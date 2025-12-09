<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use App\Models\PostReport;
use App\Models\PostBookmark;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\PostMedia;
use App\Models\CommentLike;

class PostController extends Controller
{
    /**
     * Display public posts feed (Homepage/Community)
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'likes', 'comments.user'])
            ->published();

        // Filter by post type
        if ($request->filled('type')) {
            $query->where('post_type', $request->type);
        }

        // Filter by user type
        if ($request->filled('user_type')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('user_type', $request->user_type);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%");
            });
        }

        $posts = $query->latest('published_at')->paginate(10);

        // Pinned posts
        $pinnedPosts = Post::with(['user'])
            ->published()
            ->where('is_pinned', true)
            ->latest('published_at')
            ->take(3)
            ->get();

        $pinnedCampaigns = \App\Models\DonationCampaign::where('is_pinned', true)
            ->where('status', 'Active')
            ->where('end_date', '>', now()) // Chỉ lấy chiến dịch còn hạn
            ->orderBy('created_at', 'desc')
            ->get();

        return view('posts.index', compact('posts', 'pinnedPosts', 'pinnedCampaigns'));
    }

    /**
     * Show single post
     */
    public function show($id)
    {
        $post = Post::with([
            'user',
            'likes',
            'comments.user',
            'comments.replies.user'
        ])->findOrFail($id);

        // Check if published or owned by current user
        if ($post->status !== 'published' && (!Auth::check() || $post->user_id !== Auth::id())) {
            abort(404);
        }

        // Increment views
        $post->increment('views_count');

        // Related posts
        $relatedPosts = Post::where('user_id', $post->user_id)
            ->where('post_id', '!=', $id)
            ->published()
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    /**
     * Show create post form
     */
    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to create a post');
        }

        return view('posts.create');
    }

    /**
     * Store new post
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to create a post');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:200',
            'content' => 'required|string|min:10|max:5000',
            'post_type' => 'required|in:announcement,success_story,event,impact_update,question,general',
            'status' => 'nullable|in:draft,published',
            'allow_comments' => 'nullable',
            // Validate nhiều file: ảnh hoặc video, tối đa 20MB mỗi file
            'media.*' => 'mimes:jpeg,png,jpg,gif,mp4,mov,avi,webm|max:20480'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Bắt đầu Transaction: Đảm bảo cả Post và Media cùng được tạo thành công
            DB::beginTransaction();

            $status = $request->status ?? 'published';

            // 1. Tạo bài viết (Post)
            // Lưu ý: Chúng ta không lưu 'image_url' vào bảng posts nữa vì đã có bảng riêng
            $post = Post::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'content' => $request->content,
                'post_type' => $request->post_type,
                'status' => $status,
                'allow_comments' => $request->has('allow_comments'),
                'published_at' => $status === 'published' ? now() : null
            ]);

            // 2. Xử lý upload nhiều file (Media)
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    // Lưu file vào thư mục 'storage/app/public/posts'
                    // Hàm store() sẽ trả về đường dẫn dạng: posts/filename.jpg
                    $path = $file->store('posts', 'public');

                    // Xác định loại file dựa trên mime type
                    $mimeType = $file->getMimeType();
                    $fileType = str_starts_with($mimeType, 'video') ? 'video' : 'image';

                    // Tạo bản ghi trong bảng post_media
                    \App\Models\PostMedia::create([
                        'post_id' => $post->post_id,
                        'file_path' => $path,
                        'file_type' => $fileType
                    ]);
                }
            }

            // Nếu mọi thứ ok thì lưu vào DB
            DB::commit();

            $message = $status === 'draft' ? 'Post saved as draft' : 'Post published successfully!';

            return redirect()->route('posts.my-posts')
                ->with('success', $message);
        } catch (\Exception $e) {
            // Nếu có lỗi thì hoàn tác tất cả (không tạo rác trong DB)
            DB::rollBack();

            return back()
                ->with('error', 'Failed to create post: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * My posts (all roles)
     */
    public function myPosts()
    {
        $posts = Post::where('user_id', Auth::id())
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => Post::where('user_id', Auth::id())->count(),
            'published' => Post::where('user_id', Auth::id())->where('status', 'published')->count(),
            'draft' => Post::where('user_id', Auth::id())->where('status', 'draft')->count(),
            'total_likes' => Post::where('user_id', Auth::id())->sum('likes_count'),
            'total_comments' => Post::where('user_id', Auth::id())->sum('comments_count'),
        ];

        return view('posts.my-posts', compact('posts', 'stats'));
    }

    /**
     * Edit post
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Check if user owns this post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. You can only edit your own posts.');
        }

        return view('posts.edit', compact('post'));
    }

    /**
     * Update post
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Authorization check
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized. You can only edit your own posts.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:200',
            'content' => 'required|string|min:10|max:5000',
            'post_type' => 'required|in:announcement,success_story,event,impact_update,question,general',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'remove_image' => 'nullable',
            'allow_comments' => 'nullable'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $imageUrl = $post->image_url;

        // Remove old image if requested
        if ($request->has('remove_image') && $imageUrl) {
            if (file_exists(public_path($imageUrl))) {
                unlink(public_path($imageUrl));
            }
            $imageUrl = null;
        }

        // Upload new image
        if ($request->hasFile('image')) {
            if ($imageUrl && file_exists(public_path($imageUrl))) {
                unlink(public_path($imageUrl));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/posts'), $imageName);
            $imageUrl = '/uploads/posts/' . $imageName;
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'post_type' => $request->post_type,
            'image_url' => $imageUrl,
            'allow_comments' => $request->has('allow_comments')
        ]);

        return redirect()->route('posts.my-posts')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Delete post
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Check authorization
        $isAdmin = Auth::user()->user_type === 'Admin';

        if ($post->user_id !== Auth::id() && !$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Delete image if exists
        if ($post->image_url && file_exists(public_path($post->image_url))) {
            unlink(public_path($post->image_url));
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }

    /**
     * Toggle like
     */
    public function toggleLike($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to like posts'
            ], 401);
        }

        $post = Post::findOrFail($id);

        $like = PostLike::where('post_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($like) {
            $like->delete();
            $post->decrement('likes_count');
            $liked = false;
        } else {
            PostLike::create([
                'post_id' => $id,
                'user_id' => Auth::id()
            ]);
            $post->increment('likes_count');
            $liked = true;

            // Notify post owner (if not liking own post)
            if ($post->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $post->user_id,
                    'notification_type' => 'System',
                    'title' => 'Someone liked your post',
                    'content' => Auth::user()->first_name . ' liked your post',
                    'related_id' => $post->post_id,
                    'related_type' => 'post',
                    'priority' => 'low'
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $post->fresh()->likes_count
        ]);
    }

    /**
     * Add comment
     */
    public function addComment(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to comment'
            ], 401);
        }

        $post = Post::findOrFail($id);

        if (!$post->allow_comments) {
            return response()->json([
                'success' => false,
                'message' => 'Comments are disabled for this post'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:1|max:1000',
            'parent_id' => 'nullable|exists:post_comments,comment_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $comment = PostComment::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        $post->increment('comments_count');

        // Notify post owner
        if ($post->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'notification_type' => 'System',
                'title' => 'New comment on your post',
                'content' => Auth::user()->first_name . ' commented on your post',
                'related_id' => $post->post_id,
                'related_type' => 'post',
                'priority' => 'low'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $comment->load('user')
        ]);
    }

    /**
     * Delete comment
     */
    public function deleteComment($id)
    {
        $comment = PostComment::findOrFail($id);

        $isAdmin = Auth::user()->user_type === 'Admin';

        if ($comment->user_id !== Auth::id() && !$isAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $post = $comment->post;
        $comment->delete();
        $post->decrement('comments_count');

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully'
        ]);
    }

    public function toggleCommentLike($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to like comments'
            ], 401);
        }

        $comment = PostComment::findOrFail($id);

        $like = CommentLike::where('comment_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $liked = false;

        if ($like) {
            // Nếu đã like rồi thì unlike
            $like->delete();
            // Nếu bảng post_comments có cột likes_count thì giảm
            if (\Schema::hasColumn('post_comments', 'likes_count')) {
                $comment->decrement('likes_count');
            }
            $liked = false;
        } else {
            // Nếu chưa like thì tạo mới
            CommentLike::create([
                'comment_id' => $id,
                'user_id' => Auth::id()
            ]);

            // Nếu bảng post_comments có cột likes_count thì tăng
            if (\Schema::hasColumn('post_comments', 'likes_count')) {
                $comment->increment('likes_count');
            }
            $liked = true;

            // Thông báo cho người viết comment (trừ khi tự like chính mình)
            if ($comment->user_id !== Auth::id()) {
                Notification::create([
                    'user_id' => $comment->user_id,
                    'notification_type' => 'System',
                    'title' => 'Someone liked your comment',
                    'content' => Auth::user()->first_name . ' liked your comment',
                    'related_id' => $comment->post_id, // Link về bài viết chứa comment
                    'related_type' => 'post',
                    'priority' => 'low'
                ]);
            }
        }

        // Lấy lại số lượng like mới nhất
        $likesCount = CommentLike::where('comment_id', $id)->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $likesCount
        ]);
    }

    /**
     * Report post
     */
    public function report(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to report content'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'required|in:spam,inappropriate,harassment,false_information,hate_speech,violence,other',
            'description' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $post = Post::findOrFail($id);

        // Cannot report own post
        if ($post->user_id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot report your own post'
            ], 400);
        }

        // Check if already reported
        $existingReport = PostReport::where('post_id', $id)
            ->where('reporter_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existingReport) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reported this post'
            ], 400);
        }

        PostReport::create([
            'post_id' => $id,
            'reporter_id' => Auth::id(),
            'reason' => $request->reason,
            'description' => $request->description
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post reported successfully. We will review it soon.'
        ]);
    }

    /**
     * Toggle bookmark
     */
    public function bookmark($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to bookmark posts'
            ], 401);
        }

        $post = Post::findOrFail($id);

        $bookmark = PostBookmark::where('post_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
            $message = 'Post removed from bookmarks';
        } else {
            PostBookmark::create([
                'post_id' => $id,
                'user_id' => Auth::id()
            ]);
            $bookmarked = true;
            $message = 'Post bookmarked successfully';
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked,
            'message' => $message
        ]);
    }

    /**
     * User's bookmarked posts
     */
    public function bookmarks()
    {
        $bookmarks = PostBookmark::with(['post.user'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(15);

        return view('posts.bookmarks', compact('bookmarks'));
    }

    /**
     * Update bookmark notes
     */
    public function updateBookmarkNotes(Request $request, $id)
    {
        $bookmark = PostBookmark::where('bookmark_id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $bookmark->update([
            'notes' => $request->notes
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notes updated'
        ]);
    }

    /**
     * Share post
     */
    public function share(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->increment('shares_count');

        return response()->json([
            'success' => true,
            'message' => 'Post shared successfully'
        ]);
    }
    /**
     * Store comment (alternative route)
     */
    public function storeComment(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to comment'
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'post_id' => 'required|exists:posts,post_id',
            'content' => 'required|string|min:1|max:1000',
            'parent_id' => 'nullable|exists:post_comments,comment_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $post = Post::findOrFail($request->post_id);

        if (!$post->allow_comments) {
            return response()->json([
                'success' => false,
                'message' => 'Comments are disabled for this post'
            ], 403);
        }

        $comment = PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        $post->increment('comments_count');

        // Notify post owner
        if ($post->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'notification_type' => 'System',
                'title' => 'New comment on your post',
                'content' => Auth::user()->first_name . ' commented on your post',
                'related_id' => $post->post_id,
                'related_type' => 'post',
                'priority' => 'low'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Comment added successfully',
            'comment' => $comment->load('user')
        ]);
    }
    /**
     * Add comment from form submission
     */
    public function addCommentFromForm(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Please login to comment');
        }

        $post = Post::findOrFail($id);

        if (!$post->allow_comments) {
            return back()->with('error', 'Comments are disabled for this post');
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:1|max:1000',
            'parent_id' => 'nullable|exists:post_comments,comment_id'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $comment = PostComment::create([
            'post_id' => $id,
            'user_id' => Auth::id(),
            'content' => $request->content,
            'parent_id' => $request->parent_id
        ]);

        $post->increment('comments_count');

        // Notify post owner
        if ($post->user_id !== Auth::id()) {
            Notification::create([
                'user_id' => $post->user_id,
                'notification_type' => 'System',
                'title' => 'New comment on your post',
                'content' => Auth::user()->first_name . ' commented on your post',
                'related_id' => $post->post_id,
                'related_type' => 'post',
                'priority' => 'low'
            ]);
        }

        return redirect()->route('posts.show', $id)
            ->with('success', 'Comment posted successfully!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonationCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DonationCampaignController extends Controller
{
    /**
     * Hiển thị danh sách tất cả chiến dịch.
     */
    public function index(Request $request)
    {
        $query = DonationCampaign::with('adminUser')->latest(); // 'adminUser' là tên quan hệ

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $campaigns = $query->paginate(15);
        
        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * Hiển thị form tạo chiến dịch mới.
     */
    public function create()
    {
        return view('admin.campaigns.create');
    }

    /**
     * Lưu chiến dịch mới vào CSDL.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'target_amount' => 'required|numeric|min:1000000',
            'end_date' => 'required|date|after:now',
            'is_pinned' => 'nullable|boolean',
        ]);

        // Xử lý logic ghim (pinning)
        if ($request->has('is_pinned')) {
            // Hủy ghim tất cả các chiến dịch khác
            DonationCampaign::where('is_pinned', true)->update(['is_pinned' => false]);
        }

        // Xử lý upload ảnh banner
        $bannerPath = $request->file('banner_image')->store('campaign_banners', 'public');

        DonationCampaign::create([
            'admin_user_id' => auth()->id(), // Lấy ID admin đang đăng nhập
            'title' => $request->title,
            'description' => $request->description,
            'banner_image_url' => $bannerPath,
            'target_amount' => $request->target_amount,
            'end_date' => $request->end_date,
            'status' => 'Active',
            'is_pinned' => $request->has('is_pinned'),
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Tạo chiến dịch thành công.');
    }

    /**
     * Hiển thị form chỉnh sửa chiến dịch.
     */
    public function edit($id)
    {
        $campaign = DonationCampaign::findOrFail($id);
        return view('admin.campaigns.edit', compact('campaign'));
    }

    /**
     * Cập nhật chiến dịch.
     */
    public function update(Request $request, $id)
    {
        $campaign = DonationCampaign::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Không bắt buộc
            'target_amount' => 'required|numeric|min:1000000',
            'end_date' => 'required|date',
            'status' => 'required|in:Active,Paused,Ended',
            'is_pinned' => 'nullable|boolean',
        ]);

        // Xử lý logic ghim (pinning)
        if ($request->has('is_pinned')) {
            // Hủy ghim tất cả các chiến dịch khác
            DonationCampaign::where('is_pinned', true)->where('id', '!=', $id)->update(['is_pinned' => false]);
        }

        $bannerPath = $campaign->banner_image_url;
        if ($request->hasFile('banner_image')) {
            // Xóa ảnh cũ
            if ($bannerPath) {
                Storage::disk('public')->delete($bannerPath);
            }
            // Tải ảnh mới
            $bannerPath = $request->file('banner_image')->store('campaign_banners', 'public');
        }

        $campaign->update([
            'title' => $request->title,
            'description' => $request->description,
            'banner_image_url' => $bannerPath,
            'target_amount' => $request->target_amount,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'is_pinned' => $request->has('is_pinned'),
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Cập nhật chiến dịch thành công.');
    }

    /**
     * Xóa chiến dịch.
     */
    public function destroy($id)
    {
        $campaign = DonationCampaign::findOrFail($id);

        // Xóa ảnh banner
        if ($campaign->banner_image_url) {
            Storage::disk('public')->delete($campaign->banner_image_url);
        }
        
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('success', 'Xóa chiến dịch thành công.');
    }

    /**
     * Hiển thị danh sách người quyên góp cho chiến dịch.
     */
    public function showDonations($id)
    {
        $campaign = DonationCampaign::findOrFail($id);
        $donations = $campaign->donations()
                              ->where('status', 'Success')
                              ->with('user') // 'user' là tên quan hệ trong model Donation
                              ->latest()
                              ->paginate(20);

        return view('admin.campaigns.showDonations', compact('campaign', 'donations'));
    }
}
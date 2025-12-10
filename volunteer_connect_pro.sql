-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 10, 2025 lúc 09:01 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `volunteer_connect_pro`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `applications`
--

CREATE TABLE `applications` (
  `application_id` bigint(20) UNSIGNED NOT NULL,
  `opportunity_id` bigint(20) UNSIGNED NOT NULL,
  `volunteer_id` bigint(20) UNSIGNED NOT NULL,
  `motivation_letter` text DEFAULT NULL,
  `relevant_experience` text DEFAULT NULL,
  `availability_note` text DEFAULT NULL,
  `status` enum('Pending','Under Review','Accepted','Rejected','Withdrawn') NOT NULL DEFAULT 'Pending',
  `applied_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reviewed_date` timestamp NULL DEFAULT NULL,
  `organization_notes` text DEFAULT NULL,
  `interview_scheduled` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `connections`
--

CREATE TABLE `connections` (
  `connection_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `friend_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','accepted','blocked') NOT NULL DEFAULT 'pending',
  `action_user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'User who initiated or last modified',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `accepted_at` timestamp NULL DEFAULT NULL,
  `blocked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Bẫy `connections`
--
DELIMITER $$
CREATE TRIGGER `prevent_duplicate_connection` BEFORE INSERT ON `connections` FOR EACH ROW BEGIN
                IF EXISTS (
                    SELECT 1 FROM connections 
                    WHERE user_id = NEW.friend_id AND friend_id = NEW.user_id
                ) THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Connection already exists in reverse direction";
                END IF;
            END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversations`
--

CREATE TABLE `conversations` (
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_type` enum('direct','group','opportunity_chat') NOT NULL DEFAULT 'direct',
  `title` varchar(100) DEFAULT NULL,
  `opportunity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `last_message_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `conversation_participants`
--

CREATE TABLE `conversation_participants` (
  `participant_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_read_at` timestamp NULL DEFAULT NULL,
  `unread_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donations`
--

CREATE TABLE `donations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `campaign_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` bigint(20) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  `vnp_TransactionNo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donation_campaigns`
--

CREATE TABLE `donation_campaigns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `banner_image_url` varchar(255) DEFAULT NULL,
  `target_amount` bigint(20) NOT NULL DEFAULT 0,
  `current_amount` bigint(20) NOT NULL DEFAULT 0,
  `end_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `email_logs`
--

CREATE TABLE `email_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipient_type` varchar(255) NOT NULL,
  `recipient_count` int(11) NOT NULL DEFAULT 0,
  `subject` varchar(255) NOT NULL,
  `sent_by` bigint(20) UNSIGNED DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `opportunity_id` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `message_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message_type` enum('text','image','file','video','opportunity_share') NOT NULL DEFAULT 'text',
  `content` text DEFAULT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `attachment_name` varchar(100) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `sent_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_01_01_000001_create_users_table', 1),
(4, '2024_01_01_000002_create_volunteer_profiles_table', 1),
(5, '2024_01_01_000003_create_organizations_table', 1),
(6, '2024_01_01_000004_create_categories_table', 1),
(7, '2024_01_01_000005_create_volunteer_opportunities_table', 1),
(8, '2024_01_01_000006_create_applications_table', 1),
(9, '2024_01_01_000007_create_volunteer_activities_table', 1),
(10, '2024_01_01_000008_create_reviews_table', 1),
(11, '2024_01_01_000009_create_conversations_table', 1),
(12, '2024_01_01_000010_create_conversation_participants_table', 1),
(13, '2024_01_01_000011_create_messages_table', 1),
(14, '2024_01_01_000012_create_video_calls_table', 1),
(15, '2024_01_01_000013_create_favorites_table', 1),
(16, '2024_01_01_000014_create_notifications_table', 1),
(17, '2024_01_01_000015_create_system_analytics_table', 1),
(18, '2024_01_01_999999_add_indexes_for_admin', 1),
(19, '2024_01_15_create_connections_table', 1),
(20, '2025_01_01_000000_create_vn_locations_table', 1),
(21, '2025_10_01_180040_create_personal_access_tokens_table', 1),
(22, '2025_10_02_081453_create_sessions_table', 1),
(23, '2025_10_04_033706_add_analytics_indexes', 1),
(24, '2025_10_05_163045_create_posts_table', 1),
(25, '2025_10_05_163107_create_post_likes_table', 1),
(26, '2025_10_05_163153_create_post_comments_table', 1),
(27, '2025_10_05_163206_create_post_reports_table', 1),
(28, '2025_10_05_163215_create_post_shares_table', 1),
(29, '2025_10_05_163224_create_post_tags_table', 1),
(30, '2025_10_05_163236_create_post_bookmarks_table', 1),
(31, '2025_10_09_174502_add_post_comment_to_notifications_related_type', 1),
(32, '2025_11_07_151427_add_social_id_to_users_table', 1),
(33, '2025_11_15_create_donation_campaigns_table', 1),
(34, '2025_11_15_create_donations_table', 1),
(35, '2025_11_26_221503_create_email_logs_table', 1),
(36, '2025_11_27_153504_add_last_activity_at_to_users_table', 1),
(37, '2025_11_27_174528_create_settings_table', 1),
(38, '2025_11_27_213511_create_post_media_table', 1),
(39, '2025_11_27_231223_add_password_reset_fields_to_users_table', 1),
(40, '2025_12_10_132951_create_provinces_table', 1),
(41, '2025_12_10_133216_create_wards_table', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notification_type` enum('Application','Message','Video Call','Review','System','Opportunity') NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `related_type` enum('application','opportunity','message','call','user','post','comment','conversation') DEFAULT NULL,
  `action_url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `organizations`
--

CREATE TABLE `organizations` (
  `org_id` varchar(50) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `organization_name` varchar(150) NOT NULL,
  `organization_type` enum('NGO','NPO','Charity','School','Hospital','Community Group') NOT NULL,
  `description` text DEFAULT NULL,
  `mission_statement` text DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `registration_number` varchar(50) DEFAULT NULL,
  `verification_status` enum('Pending','Verified','Rejected') NOT NULL DEFAULT 'Pending',
  `founded_year` year(4) DEFAULT NULL,
  `volunteer_count` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_opportunities` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `post_type` enum('announcement','success_story','event','impact_update','question','general') NOT NULL DEFAULT 'general',
  `status` enum('draft','pending','published','rejected') NOT NULL DEFAULT 'published',
  `admin_notes` text DEFAULT NULL,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `comments_count` int(11) NOT NULL DEFAULT 0,
  `shares_count` int(11) NOT NULL DEFAULT 0,
  `views_count` int(11) NOT NULL DEFAULT 0,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0,
  `allow_comments` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_bookmarks`
--

CREATE TABLE `post_bookmarks` (
  `bookmark_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_comments`
--

CREATE TABLE `post_comments` (
  `comment_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `likes_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_likes`
--

CREATE TABLE `post_likes` (
  `like_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_media`
--

CREATE TABLE `post_media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_reports`
--

CREATE TABLE `post_reports` (
  `report_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `reporter_id` int(10) UNSIGNED NOT NULL,
  `reason` enum('spam','inappropriate','harassment','false_information','hate_speech','violence','other') NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','under_review','resolved','dismissed') NOT NULL DEFAULT 'pending',
  `reviewed_by` int(10) UNSIGNED DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_shares`
--

CREATE TABLE `post_shares` (
  `share_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `platform` enum('facebook','twitter','linkedin','email','copy_link','internal') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_tag`
--

CREATE TABLE `post_tag` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `reviewer_id` bigint(20) UNSIGNED NOT NULL,
  `reviewee_id` bigint(20) UNSIGNED NOT NULL,
  `opportunity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `review_title` varchar(100) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `review_type` enum('Volunteer to Organization','Organization to Volunteer') NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `helpful_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `system_analytics`
--

CREATE TABLE `system_analytics` (
  `analytics_id` bigint(20) UNSIGNED NOT NULL,
  `metric_name` varchar(50) NOT NULL,
  `metric_value` int(11) NOT NULL,
  `record_date` date NOT NULL,
  `category` varchar(30) NOT NULL DEFAULT 'general',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tags`
--

CREATE TABLE `tags` (
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `posts_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `district` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_type` enum('Volunteer','Organization','Admin') NOT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_token_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `video_calls`
--

CREATE TABLE `video_calls` (
  `call_id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `initiated_by` bigint(20) UNSIGNED NOT NULL,
  `call_type` enum('audio','video') NOT NULL DEFAULT 'video',
  `call_status` enum('initiated','ringing','active','ended','missed','declined') NOT NULL DEFAULT 'initiated',
  `room_id` varchar(255) NOT NULL,
  `started_at` timestamp NULL DEFAULT NULL,
  `ended_at` timestamp NULL DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vn_locations`
--

CREATE TABLE `vn_locations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `full_path` varchar(255) DEFAULT NULL,
  `code` varchar(20) NOT NULL,
  `level` varchar(20) DEFAULT NULL,
  `parent_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vn_locations`
--

INSERT INTO `vn_locations` (`id`, `name`, `full_name`, `full_path`, `code`, `level`, `parent_code`) VALUES
(1, 'Hà Nội', 'Thành phố Hà Nội', 'Thành phố Hà Nội', '11', 'thanh-pho', NULL),
(2, 'Hồ Chí Minh', 'Thành phố Hồ Chí Minh', 'Thành phố Hồ Chí Minh', '12', 'thanh-pho', NULL),
(3, 'Đà Nẵng', 'Thành phố Đà Nẵng', 'Thành phố Đà Nẵng', '13', 'thanh-pho', NULL),
(4, 'Hải Phòng', 'Thành phố Hải Phòng', 'Thành phố Hải Phòng', '14', 'thanh-pho', NULL),
(5, 'Cần Thơ', 'Thành phố Cần Thơ', 'Thành phố Cần Thơ', '15', 'thanh-pho', NULL),
(6, 'Huế', 'Thành phố Huế', 'Thành phố Huế', '16', 'thanh-pho', NULL),
(7, 'An Giang', 'Tỉnh An Giang', 'Tỉnh An Giang', '17', 'tinh', NULL),
(8, 'Bắc Ninh', 'Tỉnh Bắc Ninh', 'Tỉnh Bắc Ninh', '18', 'tinh', NULL),
(9, 'Cà Mau', 'Tỉnh Cà Mau', 'Tỉnh Cà Mau', '19', 'tinh', NULL),
(10, 'Cao Bằng', 'Tỉnh Cao Bằng', 'Tỉnh Cao Bằng', '20', 'tinh', NULL),
(11, 'Đắk Lắk', 'Tỉnh Đắk Lắk', 'Tỉnh Đắk Lắk', '21', 'tinh', NULL),
(12, 'Điện Biên', 'Tỉnh Điện Biên', 'Tỉnh Điện Biên', '22', 'tinh', NULL),
(13, 'Đồng Nai', 'Tỉnh Đồng Nai', 'Tỉnh Đồng Nai', '23', 'tinh', NULL),
(14, 'Đồng Tháp', 'Tỉnh Đồng Tháp', 'Tỉnh Đồng Tháp', '24', 'tinh', NULL),
(15, 'Gia Lai', 'Tỉnh Gia Lai', 'Tỉnh Gia Lai', '25', 'tinh', NULL),
(16, 'Hà Tĩnh', 'Tỉnh Hà Tĩnh', 'Tỉnh Hà Tĩnh', '26', 'tinh', NULL),
(17, 'Hưng Yên', 'Tỉnh Hưng Yên', 'Tỉnh Hưng Yên', '27', 'tinh', NULL),
(18, 'Khánh Hòa', 'Tỉnh Khánh Hòa', 'Tỉnh Khánh Hòa', '28', 'tinh', NULL),
(19, 'Lai Châu', 'Tỉnh Lai Châu', 'Tỉnh Lai Châu', '29', 'tinh', NULL),
(20, 'Lâm Đồng', 'Tỉnh Lâm Đồng', 'Tỉnh Lâm Đồng', '30', 'tinh', NULL),
(21, 'Lạng Sơn', 'Tỉnh Lạng Sơn', 'Tỉnh Lạng Sơn', '31', 'tinh', NULL),
(22, 'Lào Cai', 'Tỉnh Lào Cai', 'Tỉnh Lào Cai', '32', 'tinh', NULL),
(23, 'Nghệ An', 'Tỉnh Nghệ An', 'Tỉnh Nghệ An', '33', 'tinh', NULL),
(24, 'Ninh Bình', 'Tỉnh Ninh Bình', 'Tỉnh Ninh Bình', '34', 'tinh', NULL),
(25, 'Phú Thọ', 'Tỉnh Phú Thọ', 'Tỉnh Phú Thọ', '35', 'tinh', NULL),
(26, 'Quảng Ngãi', 'Tỉnh Quảng Ngãi', 'Tỉnh Quảng Ngãi', '36', 'tinh', NULL),
(27, 'Quảng Ninh', 'Tỉnh Quảng Ninh', 'Tỉnh Quảng Ninh', '37', 'tinh', NULL),
(28, 'Quảng Trị', 'Tỉnh Quảng Trị', 'Tỉnh Quảng Trị', '38', 'tinh', NULL),
(29, 'Sơn La', 'Tỉnh Sơn La', 'Tỉnh Sơn La', '39', 'tinh', NULL),
(30, 'Tây Ninh', 'Tỉnh Tây Ninh', 'Tỉnh Tây Ninh', '40', 'tinh', NULL),
(31, 'Thái Nguyên', 'Tỉnh Thái Nguyên', 'Tỉnh Thái Nguyên', '41', 'tinh', NULL),
(32, 'Thanh Hóa', 'Tỉnh Thanh Hóa', 'Tỉnh Thanh Hóa', '42', 'tinh', NULL),
(33, 'Tuyên Quang', 'Tỉnh Tuyên Quang', 'Tỉnh Tuyên Quang', '43', 'tinh', NULL),
(34, 'Vĩnh Long', 'Tỉnh Vĩnh Long', 'Tỉnh Vĩnh Long', '44', 'tinh', NULL),
(35, 'Minh Châu', 'Xã Minh Châu', 'Xã Minh Châu, Thành phố Hà Nội', '267', 'xa', '11'),
(36, 'Ngọc Hồi', 'Xã Ngọc Hồi', 'Xã Ngọc Hồi, Thành phố Hà Nội', '523', 'xa', '11'),
(37, 'Tây Mỗ', 'Phường Tây Mỗ', 'Phường Tây Mỗ, Thành phố Hà Nội', '779', 'phuong', '11'),
(38, 'Phú Diễn', 'Phường Phú Diễn', 'Phường Phú Diễn, Thành phố Hà Nội', '1035', 'phuong', '11'),
(39, 'Tây Tựu', 'Phường Tây Tựu', 'Phường Tây Tựu, Thành phố Hà Nội', '1291', 'phuong', '11'),
(40, 'Thượng Cát', 'Phường Thượng Cát', 'Phường Thượng Cát, Thành phố Hà Nội', '1547', 'phuong', '11'),
(41, 'Xuân Đỉnh', 'Phường Xuân Đỉnh', 'Phường Xuân Đỉnh, Thành phố Hà Nội', '1803', 'phuong', '11'),
(42, 'Xuân Phương', 'Phường Xuân Phương', 'Phường Xuân Phương, Thành phố Hà Nội', '2059', 'phuong', '11'),
(43, 'Đại Xuyên', 'Xã Đại Xuyên', 'Xã Đại Xuyên, Thành phố Hà Nội', '2315', 'xa', '11'),
(44, 'Phương Liệt', 'Phường Phương Liệt', 'Phường Phương Liệt, Thành phố Hà Nội', '2571', 'phuong', '11'),
(45, 'Tùng Thiện', 'Phường Tùng Thiện', 'Phường Tùng Thiện, Thành phố Hà Nội', '2827', 'phuong', '11'),
(46, 'Đoài Phương', 'Xã Đoài Phương', 'Xã Đoài Phương, Thành phố Hà Nội', '3083', 'xa', '11'),
(47, 'Gia Lâm', 'Xã Gia Lâm', 'Xã Gia Lâm, Thành phố Hà Nội', '3339', 'xa', '11'),
(48, 'Suối Hai', 'Xã Suối Hai', 'Xã Suối Hai, Thành phố Hà Nội', '3595', 'xa', '11'),
(49, 'Ba Vì', 'Xã Ba Vì', 'Xã Ba Vì, Thành phố Hà Nội', '3851', 'xa', '11'),
(50, 'Cổ Đô', 'Xã Cổ Đô', 'Xã Cổ Đô, Thành phố Hà Nội', '4107', 'xa', '11'),
(51, 'Hoàng Liệt', 'Phường Hoàng Liệt', 'Phường Hoàng Liệt, Thành phố Hà Nội', '4363', 'phuong', '11'),
(52, 'Lĩnh Nam', 'Phường Lĩnh Nam', 'Phường Lĩnh Nam, Thành phố Hà Nội', '4619', 'phuong', '11'),
(53, 'Tương Mai', 'Phường Tương Mai', 'Phường Tương Mai, Thành phố Hà Nội', '4875', 'phuong', '11'),
(54, 'Thanh Liệt', 'Phường Thanh Liệt', 'Phường Thanh Liệt, Thành phố Hà Nội', '5131', 'phuong', '11'),
(55, 'Đại Thanh', 'Xã Đại Thanh', 'Xã Đại Thanh, Thành phố Hà Nội', '5387', 'xa', '11'),
(56, 'Thường Tín', 'Xã Thường Tín', 'Xã Thường Tín, Thành phố Hà Nội', '5643', 'xa', '11'),
(57, 'Ô Diên', 'Xã Ô Diên', 'Xã Ô Diên, Thành phố Hà Nội', '5899', 'xa', '11'),
(58, 'Quảng Bị', 'Xã Quảng Bị', 'Xã Quảng Bị, Thành phố Hà Nội', '6155', 'xa', '11'),
(59, 'Trần Phú', 'Xã Trần Phú', 'Xã Trần Phú, Thành phố Hà Nội', '6411', 'xa', '11'),
(60, 'Liên Minh', 'Xã Liên Minh', 'Xã Liên Minh, Thành phố Hà Nội', '6667', 'xa', '11'),
(61, 'Thư Lâm', 'Xã Thư Lâm', 'Xã Thư Lâm, Thành phố Hà Nội', '6923', 'xa', '11'),
(62, 'Đông Anh', 'Xã Đông Anh', 'Xã Đông Anh, Thành phố Hà Nội', '7179', 'xa', '11'),
(63, 'Phú Xuyên', 'Xã Phú Xuyên', 'Xã Phú Xuyên, Thành phố Hà Nội', '7435', 'xa', '11'),
(64, 'Quảng Oai', 'Xã Quảng Oai', 'Xã Quảng Oai, Thành phố Hà Nội', '7691', 'xa', '11'),
(65, 'Dương Hòa', 'Xã Dương Hòa', 'Xã Dương Hòa, Thành phố Hà Nội', '7947', 'xa', '11'),
(66, 'Phúc Thịnh', 'Xã Phúc Thịnh', 'Xã Phúc Thịnh, Thành phố Hà Nội', '8203', 'xa', '11'),
(67, 'Vĩnh Thanh', 'Xã Vĩnh Thanh', 'Xã Vĩnh Thanh, Thành phố Hà Nội', '8459', 'xa', '11'),
(68, 'Thiên Lộc', 'Xã Thiên Lộc', 'Xã Thiên Lộc, Thành phố Hà Nội', '8715', 'xa', '11'),
(69, 'Quang Minh', 'Xã Quang Minh', 'Xã Quang Minh, Thành phố Hà Nội', '8971', 'xa', '11'),
(70, 'Hương Sơn', 'Xã Hương Sơn', 'Xã Hương Sơn, Thành phố Hà Nội', '9227', 'xa', '11'),
(71, 'Mê Linh', 'Xã Mê Linh', 'Xã Mê Linh, Thành phố Hà Nội', '9483', 'xa', '11'),
(72, 'Tiến Thắng', 'Xã Tiến Thắng', 'Xã Tiến Thắng, Thành phố Hà Nội', '9739', 'xa', '11'),
(73, 'Yên Lãng', 'Xã Yên Lãng', 'Xã Yên Lãng, Thành phố Hà Nội', '9995', 'xa', '11'),
(74, 'Mỹ Đức', 'Xã Mỹ Đức', 'Xã Mỹ Đức, Thành phố Hà Nội', '10251', 'xa', '11'),
(75, 'Định Công', 'Phường Định Công', 'Phường Định Công, Thành phố Hà Nội', '10507', 'phuong', '11'),
(76, 'Bất Bạt', 'Xã Bất Bạt', 'Xã Bất Bạt, Thành phố Hà Nội', '10763', 'xa', '11'),
(77, 'Vật Lại', 'Xã Vật Lại', 'Xã Vật Lại, Thành phố Hà Nội', '11019', 'xa', '11'),
(78, 'Yên Bài', 'Xã Yên Bài', 'Xã Yên Bài, Thành phố Hà Nội', '11275', 'xa', '11'),
(79, 'Chương Mỹ', 'Phường Chương Mỹ', 'Phường Chương Mỹ, Thành phố Hà Nội', '11531', 'phuong', '11'),
(80, 'Xuân Mai', 'Xã Xuân Mai', 'Xã Xuân Mai, Thành phố Hà Nội', '11787', 'xa', '11'),
(81, 'Phú Nghĩa', 'Xã Phú Nghĩa', 'Xã Phú Nghĩa, Thành phố Hà Nội', '12043', 'xa', '11'),
(82, 'Yên Xuân', 'Xã Yên Xuân', 'Xã Yên Xuân, Thành phố Hà Nội', '12299', 'xa', '11'),
(83, 'Phúc Lợi', 'Phường Phúc Lợi', 'Phường Phúc Lợi, Thành phố Hà Nội', '12555', 'phuong', '11'),
(84, 'Việt Hưng', 'Phường Việt Hưng', 'Phường Việt Hưng, Thành phố Hà Nội', '12811', 'phuong', '11'),
(85, 'Hòa Lạc', 'Xã Hòa Lạc', 'Xã Hòa Lạc, Thành phố Hà Nội', '13067', 'xa', '11'),
(86, 'Thanh Oai', 'Xã Thanh Oai', 'Xã Thanh Oai, Thành phố Hà Nội', '13323', 'xa', '11'),
(87, 'Bình Minh', 'Xã Bình Minh', 'Xã Bình Minh, Thành phố Hà Nội', '13579', 'xa', '11'),
(88, 'Dân Hòa', 'Xã Dân Hòa', 'Xã Dân Hòa, Thành phố Hà Nội', '13835', 'xa', '11'),
(89, 'Ba Đình', 'Phường Ba Đình', 'Phường Ba Đình, Thành phố Hà Nội', '14091', 'phuong', '11'),
(90, 'Giảng Võ', 'Phường Giảng Võ', 'Phường Giảng Võ, Thành phố Hà Nội', '14347', 'phuong', '11'),
(91, 'Ngọc Hà', 'Phường Ngọc Hà', 'Phường Ngọc Hà, Thành phố Hà Nội', '14603', 'phuong', '11'),
(92, 'Cầu Giấy', 'Phường Cầu Giấy', 'Phường Cầu Giấy, Thành phố Hà Nội', '14859', 'phuong', '11'),
(93, 'Nghĩa Đô', 'Phường Nghĩa Đô', 'Phường Nghĩa Đô, Thành phố Hà Nội', '15115', 'phuong', '11'),
(94, 'Phù Đổng', 'Xã Phù Đổng', 'Xã Phù Đổng, Thành phố Hà Nội', '15371', 'xa', '11'),
(95, 'Hoài Đức', 'Xã Hoài Đức', 'Xã Hoài Đức, Thành phố Hà Nội', '15627', 'xa', '11'),
(96, 'An Khánh', 'Xã An Khánh', 'Xã An Khánh, Thành phố Hà Nội', '15883', 'xa', '11'),
(97, 'Phúc Sơn', 'Xã Phúc Sơn', 'Xã Phúc Sơn, Thành phố Hà Nội', '16139', 'xa', '11'),
(98, 'Sơn Đồng', 'Xã Sơn Đồng', 'Xã Sơn Đồng, Thành phố Hà Nội', '16395', 'xa', '11'),
(99, 'Chuyên Mỹ', 'Xã Chuyên Mỹ', 'Xã Chuyên Mỹ, Thành phố Hà Nội', '16651', 'xa', '11'),
(100, 'Vĩnh Tuy', 'Phường Vĩnh Tuy', 'Phường Vĩnh Tuy, Thành phố Hà Nội', '16907', 'phuong', '11'),
(101, 'Hồng Hà', 'Phường Hồng Hà', 'Phường Hồng Hà, Thành phố Hà Nội', '17163', 'phuong', '11'),
(102, 'Cửa Nam', 'Phường Cửa Nam', 'Phường Cửa Nam, Thành phố Hà Nội', '17419', 'phuong', '11'),
(103, 'Yên Nghĩa', 'Phường Yên Nghĩa', 'Phường Yên Nghĩa, Thành phố Hà Nội', '17675', 'phuong', '11'),
(104, 'Hồng Vân', 'Xã Hồng Vân', 'Xã Hồng Vân, Thành phố Hà Nội', '17931', 'xa', '11'),
(105, 'Vĩnh Hưng', 'Phường Vĩnh Hưng', 'Phường Vĩnh Hưng, Thành phố Hà Nội', '18187', 'phuong', '11'),
(106, 'Bồ Đề', 'Phường Bồ Đề', 'Phường Bồ Đề, Thành phố Hà Nội', '18443', 'phuong', '11'),
(107, 'Kiều Phú', 'Xã Kiều Phú', 'Xã Kiều Phú, Thành phố Hà Nội', '18699', 'xa', '11'),
(108, 'Phú Cát', 'Xã Phú Cát', 'Xã Phú Cát, Thành phố Hà Nội', '18955', 'xa', '11'),
(109, 'Sóc Sơn', 'Xã Sóc Sơn', 'Xã Sóc Sơn, Thành phố Hà Nội', '19211', 'xa', '11'),
(110, 'Kim Anh', 'Xã Kim Anh', 'Xã Kim Anh, Thành phố Hà Nội', '19467', 'xa', '11'),
(111, 'Nội Bài', 'Xã Nội Bài', 'Xã Nội Bài, Thành phố Hà Nội', '19723', 'xa', '11'),
(112, 'Trung Giã', 'Xã Trung Giã', 'Xã Trung Giã, Thành phố Hà Nội', '19979', 'xa', '11'),
(113, 'Quốc Oai', 'Xã Quốc Oai', 'Xã Quốc Oai, Thành phố Hà Nội', '20235', 'xa', '11'),
(114, 'Long Biên', 'Phường Long Biên', 'Phường Long Biên, Thành phố Hà Nội', '20491', 'phuong', '11'),
(115, 'Khương Đình', 'Phường Khương Đình', 'Phường Khương Đình, Thành phố Hà Nội', '20747', 'phuong', '11'),
(116, 'Phú Lương', 'Phường Phú Lương', 'Phường Phú Lương, Thành phố Hà Nội', '21003', 'phuong', '11'),
(117, 'Dương Nội', 'Phường Dương Nội', 'Phường Dương Nội, Thành phố Hà Nội', '21259', 'phuong', '11'),
(118, 'Kiến Hưng', 'Phường Kiến Hưng', 'Phường Kiến Hưng, Thành phố Hà Nội', '21515', 'phuong', '11'),
(119, 'Hà Đông', 'Phường Hà Đông', 'Phường Hà Đông, Thành phố Hà Nội', '21771', 'phuong', '11'),
(120, 'Hai Bà Trưng', 'Phường Hai Bà Trưng', 'Phường Hai Bà Trưng, Thành phố Hà Nội', '22027', 'phuong', '11'),
(121, 'Thượng Phúc', 'Xã Thượng Phúc', 'Xã Thượng Phúc, Thành phố Hà Nội', '22283', 'xa', '11'),
(122, 'Thạch Thất', 'Xã Thạch Thất', 'Xã Thạch Thất, Thành phố Hà Nội', '22539', 'xa', '11'),
(123, 'Hạ Bằng', 'Xã Hạ Bằng', 'Xã Hạ Bằng, Thành phố Hà Nội', '22795', 'xa', '11'),
(124, 'Nam Phù', 'Xã Nam Phù', 'Xã Nam Phù, Thành phố Hà Nội', '23051', 'xa', '11'),
(125, 'Thanh Trì', 'Xã Thanh Trì', 'Xã Thanh Trì, Thành phố Hà Nội', '23307', 'xa', '11'),
(126, 'Đại Mỗ', 'Phường Đại Mỗ', 'Phường Đại Mỗ, Thành phố Hà Nội', '23563', 'phuong', '11'),
(127, 'Vân Đình', 'Xã Vân Đình', 'Xã Vân Đình, Thành phố Hà Nội', '23819', 'xa', '11'),
(128, 'Yên Hòa', 'Phường Yên Hòa', 'Phường Yên Hòa, Thành phố Hà Nội', '24075', 'phuong', '11'),
(129, 'Ô Chợ Dừa', 'Phường Ô Chợ Dừa', 'Phường Ô Chợ Dừa, Thành phố Hà Nội', '24331', 'phuong', '11'),
(130, 'Kim Liên', 'Phường Kim Liên', 'Phường Kim Liên, Thành phố Hà Nội', '24587', 'phuong', '11'),
(131, 'Láng', 'Phường Láng', 'Phường Láng, Thành phố Hà Nội', '24843', 'phuong', '11'),
(132, 'Đống Đa', 'Phường Đống Đa', 'Phường Đống Đa, Thành phố Hà Nội', '25099', 'phuong', '11'),
(133, 'Văn Miếu-Quốc Tử Giám', 'Phường Văn Miếu-Quốc Tử Giám', 'Phường Văn Miếu-Quốc Tử Giám, Thành phố Hà Nội', '25355', 'phuong', '11'),
(134, 'Phú Thượng', 'Phường Phú Thượng', 'Phường Phú Thượng, Thành phố Hà Nội', '25611', 'phuong', '11'),
(135, 'Hoàng Mai', 'Phường Hoàng Mai', 'Phường Hoàng Mai, Thành phố Hà Nội', '25867', 'phuong', '11'),
(136, 'Từ Liêm', 'Phường Từ Liêm', 'Phường Từ Liêm, Thành phố Hà Nội', '26123', 'phuong', '11'),
(137, 'Đông Ngạc', 'Phường Đông Ngạc', 'Phường Đông Ngạc, Thành phố Hà Nội', '26379', 'phuong', '11'),
(138, 'Hòa Phú', 'Xã Hòa Phú', 'Xã Hòa Phú, Thành phố Hà Nội', '26635', 'xa', '11'),
(139, 'Tây Phương', 'Xã Tây Phương', 'Xã Tây Phương, Thành phố Hà Nội', '26891', 'xa', '11'),
(140, 'Hòa Xá', 'Xã Hòa Xá', 'Xã Hòa Xá, Thành phố Hà Nội', '27147', 'xa', '11'),
(141, 'Bát Tràng', 'Xã Bát Tràng', 'Xã Bát Tràng, Thành phố Hà Nội', '27403', 'xa', '11'),
(142, 'Thuận An', 'Xã Thuận An', 'Xã Thuận An, Thành phố Hà Nội', '27659', 'xa', '11'),
(143, 'Bạch Mai', 'Phường Bạch Mai', 'Phường Bạch Mai, Thành phố Hà Nội', '27915', 'phuong', '11'),
(144, 'Thanh Xuân', 'Phường Thanh Xuân', 'Phường Thanh Xuân, Thành phố Hà Nội', '28171', 'phuong', '11'),
(145, 'Sơn Tây', 'Phường Sơn Tây', 'Phường Sơn Tây, Thành phố Hà Nội', '28427', 'phuong', '11'),
(146, 'Đan Phượng', 'Xã Đan Phượng', 'Xã Đan Phượng, Thành phố Hà Nội', '28683', 'xa', '11'),
(147, 'Chương Dương', 'Xã Chương Dương', 'Xã Chương Dương, Thành phố Hà Nội', '28939', 'xa', '11'),
(148, 'Phượng Dực', 'Xã Phượng Dực', 'Xã Phượng Dực, Thành phố Hà Nội', '29195', 'xa', '11'),
(149, 'Ứng Thiên', 'Xã Ứng Thiên', 'Xã Ứng Thiên, Thành phố Hà Nội', '29451', 'xa', '11'),
(150, 'Hồng Sơn', 'Xã Hồng Sơn', 'Xã Hồng Sơn, Thành phố Hà Nội', '29707', 'xa', '11'),
(151, 'Hưng Đạo', 'Xã Hưng Đạo', 'Xã Hưng Đạo, Thành phố Hà Nội', '29963', 'xa', '11'),
(152, 'Tam Hưng', 'Xã Tam Hưng', 'Xã Tam Hưng, Thành phố Hà Nội', '30219', 'xa', '11'),
(153, 'Ứng Hòa', 'Xã Ứng Hòa', 'Xã Ứng Hòa, Thành phố Hà Nội', '30475', 'xa', '11'),
(154, 'Hát Môn', 'Xã Hát Môn', 'Xã Hát Môn, Thành phố Hà Nội', '30731', 'xa', '11'),
(155, 'Phúc Thọ', 'Xã Phúc Thọ', 'Xã Phúc Thọ, Thành phố Hà Nội', '30987', 'xa', '11'),
(156, 'Đa Phúc', 'Xã Đa Phúc', 'Xã Đa Phúc, Thành phố Hà Nội', '31243', 'xa', '11'),
(157, 'Phúc Lộc', 'Xã Phúc Lộc', 'Xã Phúc Lộc, Thành phố Hà Nội', '31499', 'xa', '11'),
(158, 'Hoàn Kiếm', 'Phường Hoàn Kiếm', 'Phường Hoàn Kiếm, Thành phố Hà Nội', '31755', 'phuong', '11'),
(159, 'Yên Sở', 'Phường Yên Sở', 'Phường Yên Sở, Thành phố Hà Nội', '32011', 'phuong', '11'),
(160, 'Tây Hồ', 'Phường Tây Hồ', 'Phường Tây Hồ, Thành phố Hà Nội', '32267', 'phuong', '11'),
(161, 'Thạnh An', 'Xã Thạnh An', 'Xã Thạnh An, Thành phố Hồ Chí Minh', '268', 'xa', '12'),
(162, 'Xóm Chiếu', 'Phường Xóm Chiếu', 'Phường Xóm Chiếu, Thành phố Hồ Chí Minh', '524', 'phuong', '12'),
(163, 'Vĩnh Hội', 'Phường Vĩnh Hội', 'Phường Vĩnh Hội, Thành phố Hồ Chí Minh', '780', 'phuong', '12'),
(164, 'Khánh Hội', 'Phường Khánh Hội', 'Phường Khánh Hội, Thành phố Hồ Chí Minh', '1036', 'phuong', '12'),
(165, 'Bình Chánh', 'Xã Bình Chánh', 'Xã Bình Chánh, Thành phố Hồ Chí Minh', '1292', 'xa', '12'),
(166, 'Vĩnh Lộc', 'Xã Vĩnh Lộc', 'Xã Vĩnh Lộc, Thành phố Hồ Chí Minh', '1548', 'xa', '12'),
(167, 'Tân Vĩnh Lộc', 'Xã Tân Vĩnh Lộc', 'Xã Tân Vĩnh Lộc, Thành phố Hồ Chí Minh', '1804', 'xa', '12'),
(168, 'An Thới Đông', 'Xã An Thới Đông', 'Xã An Thới Đông, Thành phố Hồ Chí Minh', '2060', 'xa', '12'),
(169, 'Bình Khánh', 'Xã Bình Khánh', 'Xã Bình Khánh, Thành phố Hồ Chí Minh', '2316', 'xa', '12'),
(170, 'Bàn Cờ', 'Phường Bàn Cờ', 'Phường Bàn Cờ, Thành phố Hồ Chí Minh', '2572', 'phuong', '12'),
(171, 'Xuân Hòa', 'Phường Xuân Hòa', 'Phường Xuân Hòa, Thành phố Hồ Chí Minh', '2828', 'phuong', '12'),
(172, 'Bình Đông', 'Phường Bình Đông', 'Phường Bình Đông, Thành phố Hồ Chí Minh', '3084', 'phuong', '12'),
(173, 'Phú Thuận', 'Phường Phú Thuận', 'Phường Phú Thuận, Thành phố Hồ Chí Minh', '3340', 'phuong', '12'),
(174, 'Tân Mỹ', 'Phường Tân Mỹ', 'Phường Tân Mỹ, Thành phố Hồ Chí Minh', '3596', 'phuong', '12'),
(175, 'Phú Định', 'Phường Phú Định', 'Phường Phú Định, Thành phố Hồ Chí Minh', '3852', 'phuong', '12'),
(176, 'Chánh Hưng', 'Phường Chánh Hưng', 'Phường Chánh Hưng, Thành phố Hồ Chí Minh', '4108', 'phuong', '12'),
(177, 'Long Bình', 'Phường Long Bình', 'Phường Long Bình, Thành phố Hồ Chí Minh', '4364', 'phuong', '12'),
(178, 'Tăng Nhơn Phú', 'Phường Tăng Nhơn Phú', 'Phường Tăng Nhơn Phú, Thành phố Hồ Chí Minh', '4620', 'phuong', '12'),
(179, 'Bình Tân', 'Phường Bình Tân', 'Phường Bình Tân, Thành phố Hồ Chí Minh', '4876', 'phuong', '12'),
(180, 'Bình Trị Đông', 'Phường Bình Trị Đông', 'Phường Bình Trị Đông, Thành phố Hồ Chí Minh', '5132', 'phuong', '12'),
(181, 'Phú Giáo', 'Xã Phú Giáo', 'Xã Phú Giáo, Thành phố Hồ Chí Minh', '5388', 'xa', '12'),
(182, 'Bình Hưng', 'Xã Bình Hưng', 'Xã Bình Hưng, Thành phố Hồ Chí Minh', '5644', 'xa', '12'),
(183, 'Thường Tân', 'Xã Thường Tân', 'Xã Thường Tân, Thành phố Hồ Chí Minh', '5900', 'xa', '12'),
(184, 'Phú Nhuận', 'Phường Phú Nhuận', 'Phường Phú Nhuận, Thành phố Hồ Chí Minh', '6156', 'phuong', '12'),
(185, 'Cầu Kiệu', 'Phường Cầu Kiệu', 'Phường Cầu Kiệu, Thành phố Hồ Chí Minh', '6412', 'phuong', '12'),
(186, 'Tân Bình', 'Phường Tân Bình', 'Phường Tân Bình, Thành phố Hồ Chí Minh', '6668', 'phuong', '12'),
(187, 'Phú Thạnh', 'Phường Phú Thạnh', 'Phường Phú Thạnh, Thành phố Hồ Chí Minh', '6924', 'phuong', '12'),
(188, 'Tân Định', 'Phường Tân Định', 'Phường Tân Định, Thành phố Hồ Chí Minh', '7180', 'phuong', '12'),
(189, 'Cầu Ông Lãnh', 'Phường Cầu Ông Lãnh', 'Phường Cầu Ông Lãnh, Thành phố Hồ Chí Minh', '7436', 'phuong', '12'),
(190, 'Sài Gòn', 'Phường Sài Gòn', 'Phường Sài Gòn, Thành phố Hồ Chí Minh', '7692', 'phuong', '12'),
(191, 'Bến Thành', 'Phường Bến Thành', 'Phường Bến Thành, Thành phố Hồ Chí Minh', '7948', 'phuong', '12'),
(192, 'Diên Hồng', 'Phường Diên Hồng', 'Phường Diên Hồng, Thành phố Hồ Chí Minh', '8204', 'phuong', '12'),
(193, 'Hòa Hưng', 'Phường Hòa Hưng', 'Phường Hòa Hưng, Thành phố Hồ Chí Minh', '8460', 'phuong', '12'),
(194, 'Bình Thới', 'Phường Bình Thới', 'Phường Bình Thới, Thành phố Hồ Chí Minh', '8716', 'phuong', '12'),
(195, 'Phú Thọ', 'Phường Phú Thọ', 'Phường Phú Thọ, Thành phố Hồ Chí Minh', '8972', 'phuong', '12'),
(196, 'Bình Phú', 'Phường Bình Phú', 'Phường Bình Phú, Thành phố Hồ Chí Minh', '9228', 'phuong', '12'),
(197, 'Tân Sơn Nhì', 'Phường Tân Sơn Nhì', 'Phường Tân Sơn Nhì, Thành phố Hồ Chí Minh', '9484', 'phuong', '12'),
(198, 'Tây Thạnh', 'Phường Tây Thạnh', 'Phường Tây Thạnh, Thành phố Hồ Chí Minh', '9740', 'phuong', '12'),
(199, 'Thủ Đức', 'Phường Thủ Đức', 'Phường Thủ Đức, Thành phố Hồ Chí Minh', '9996', 'phuong', '12'),
(200, 'Hiệp Bình', 'Phường Hiệp Bình', 'Phường Hiệp Bình, Thành phố Hồ Chí Minh', '10252', 'phuong', '12'),
(201, 'Linh Xuân', 'Phường Linh Xuân', 'Phường Linh Xuân, Thành phố Hồ Chí Minh', '10508', 'phuong', '12'),
(202, 'Bình Trưng', 'Phường Bình Trưng', 'Phường Bình Trưng, Thành phố Hồ Chí Minh', '10764', 'phuong', '12'),
(203, 'An Khánh', 'Phường An Khánh', 'Phường An Khánh, Thành phố Hồ Chí Minh', '11020', 'phuong', '12'),
(204, 'Phú An', 'Phường Phú An', 'Phường Phú An, Thành phố Hồ Chí Minh', '11276', 'phuong', '12'),
(205, 'Thuận Giao', 'Phường Thuận Giao', 'Phường Thuận Giao, Thành phố Hồ Chí Minh', '11532', 'phuong', '12'),
(206, 'Bình Hòa', 'Phường Bình Hòa', 'Phường Bình Hòa, Thành phố Hồ Chí Minh', '11788', 'phuong', '12'),
(207, 'Thủ Dầu Một', 'Phường Thủ Dầu Một', 'Phường Thủ Dầu Một, Thành phố Hồ Chí Minh', '12044', 'phuong', '12'),
(208, 'Lái Thiêu', 'Phường Lái Thiêu', 'Phường Lái Thiêu, Thành phố Hồ Chí Minh', '12300', 'phuong', '12'),
(209, 'An Phú', 'Phường An Phú', 'Phường An Phú, Thành phố Hồ Chí Minh', '12556', 'phuong', '12'),
(210, 'Rạch Dừa', 'Phường Rạch Dừa', 'Phường Rạch Dừa, Thành phố Hồ Chí Minh', '12812', 'phuong', '12'),
(211, 'Long Hòa', 'Xã Long Hòa', 'Xã Long Hòa, Thành phố Hồ Chí Minh', '13068', 'xa', '12'),
(212, 'Minh Thạnh', 'Xã Minh Thạnh', 'Xã Minh Thạnh, Thành phố Hồ Chí Minh', '13324', 'xa', '12'),
(213, 'Tân Tạo', 'Phường Tân Tạo', 'Phường Tân Tạo, Thành phố Hồ Chí Minh', '13580', 'phuong', '12'),
(214, 'Long Nguyên', 'Phường Long Nguyên', 'Phường Long Nguyên, Thành phố Hồ Chí Minh', '13836', 'phuong', '12'),
(215, 'Trừ Văn Thố', 'Xã Trừ Văn Thố', 'Xã Trừ Văn Thố, Thành phố Hồ Chí Minh', '14092', 'xa', '12'),
(216, 'Bến Cát', 'Phường Bến Cát', 'Phường Bến Cát, Thành phố Hồ Chí Minh', '14348', 'phuong', '12'),
(217, 'Dầu Tiếng', 'Xã Dầu Tiếng', 'Xã Dầu Tiếng, Thành phố Hồ Chí Minh', '14604', 'xa', '12'),
(218, 'Tân Khánh', 'Phường Tân Khánh', 'Phường Tân Khánh, Thành phố Hồ Chí Minh', '14860', 'phuong', '12'),
(219, 'Tân Uyên', 'Phường Tân Uyên', 'Phường Tân Uyên, Thành phố Hồ Chí Minh', '15116', 'phuong', '12'),
(220, 'Phước Hòa', 'Xã Phước Hòa', 'Xã Phước Hòa, Thành phố Hồ Chí Minh', '15372', 'xa', '12'),
(221, 'Chánh Hiệp', 'Phường Chánh Hiệp', 'Phường Chánh Hiệp, Thành phố Hồ Chí Minh', '15628', 'phuong', '12'),
(222, 'Thới Hòa', 'Phường Thới Hòa', 'Phường Thới Hòa, Thành phố Hồ Chí Minh', '15884', 'phuong', '12'),
(223, 'Tây Nam', 'Phường Tây Nam', 'Phường Tây Nam, Thành phố Hồ Chí Minh', '16140', 'phuong', '12'),
(224, 'Thanh An', 'Xã Thanh An', 'Xã Thanh An, Thành phố Hồ Chí Minh', '16396', 'xa', '12'),
(225, 'Tân Nhựt', 'Xã Tân Nhựt', 'Xã Tân Nhựt, Thành phố Hồ Chí Minh', '16652', 'xa', '12'),
(226, 'Dĩ An', 'Phường Dĩ An', 'Phường Dĩ An, Thành phố Hồ Chí Minh', '16908', 'phuong', '12'),
(227, 'Tân Đông Hiệp', 'Phường Tân Đông Hiệp', 'Phường Tân Đông Hiệp, Thành phố Hồ Chí Minh', '17164', 'phuong', '12'),
(228, 'Phú Lợi', 'Phường Phú Lợi', 'Phường Phú Lợi, Thành phố Hồ Chí Minh', '17420', 'phuong', '12'),
(229, 'Đặc Khu Côn Đảo', 'Xã Đặc Khu Côn Đảo', 'Xã Đặc Khu Côn Đảo, Thành phố Hồ Chí Minh', '17676', 'xa', '12'),
(230, 'Long Điền', 'Xã Long Điền', 'Xã Long Điền, Thành phố Hồ Chí Minh', '17932', 'xa', '12'),
(231, 'Bình Hưng Hòa', 'Phường Bình Hưng Hòa', 'Phường Bình Hưng Hòa, Thành phố Hồ Chí Minh', '18188', 'phuong', '12'),
(232, 'Nhiêu Lộc', 'Phường Nhiêu Lộc', 'Phường Nhiêu Lộc, Thành phố Hồ Chí Minh', '18444', 'phuong', '12'),
(233, 'Chợ Quán', 'Phường Chợ Quán', 'Phường Chợ Quán, Thành phố Hồ Chí Minh', '18700', 'phuong', '12'),
(234, 'An Đông', 'Phường An Đông', 'Phường An Đông, Thành phố Hồ Chí Minh', '18956', 'phuong', '12'),
(235, 'Chợ Lớn', 'Phường Chợ Lớn', 'Phường Chợ Lớn, Thành phố Hồ Chí Minh', '19212', 'phuong', '12'),
(236, 'Bình Tiên', 'Phường Bình Tiên', 'Phường Bình Tiên, Thành phố Hồ Chí Minh', '19468', 'phuong', '12'),
(237, 'Phú Lâm', 'Phường Phú Lâm', 'Phường Phú Lâm, Thành phố Hồ Chí Minh', '19724', 'phuong', '12'),
(238, 'Tân Hưng', 'Phường Tân Hưng', 'Phường Tân Hưng, Thành phố Hồ Chí Minh', '19980', 'phuong', '12'),
(239, 'Tân Thuận', 'Phường Tân Thuận', 'Phường Tân Thuận, Thành phố Hồ Chí Minh', '20236', 'phuong', '12'),
(240, 'Vườn Lài', 'Phường Vườn Lài', 'Phường Vườn Lài, Thành phố Hồ Chí Minh', '20492', 'phuong', '12'),
(241, 'Minh Phụng', 'Phường Minh Phụng', 'Phường Minh Phụng, Thành phố Hồ Chí Minh', '20748', 'phuong', '12'),
(242, 'Hòa Bình', 'Phường Hòa Bình', 'Phường Hòa Bình, Thành phố Hồ Chí Minh', '21004', 'phuong', '12'),
(243, 'Đông Hưng Thuận', 'Phường Đông Hưng Thuận', 'Phường Đông Hưng Thuận, Thành phố Hồ Chí Minh', '21260', 'phuong', '12'),
(244, 'Trung Mỹ Tây', 'Phường Trung Mỹ Tây', 'Phường Trung Mỹ Tây, Thành phố Hồ Chí Minh', '21516', 'phuong', '12'),
(245, 'Tân Thới Hiệp', 'Phường Tân Thới Hiệp', 'Phường Tân Thới Hiệp, Thành phố Hồ Chí Minh', '21772', 'phuong', '12'),
(246, 'Thới An', 'Phường Thới An', 'Phường Thới An, Thành phố Hồ Chí Minh', '22028', 'phuong', '12'),
(247, 'An Phú Đông', 'Phường An Phú Đông', 'Phường An Phú Đông, Thành phố Hồ Chí Minh', '22284', 'phuong', '12'),
(248, 'Gia Định', 'Phường Gia Định', 'Phường Gia Định, Thành phố Hồ Chí Minh', '22540', 'phuong', '12'),
(249, 'Bình Thạnh', 'Phường Bình Thạnh', 'Phường Bình Thạnh, Thành phố Hồ Chí Minh', '22796', 'phuong', '12'),
(250, 'Bình Lợi Trung', 'Phường Bình Lợi Trung', 'Phường Bình Lợi Trung, Thành phố Hồ Chí Minh', '23052', 'phuong', '12'),
(251, 'Thạnh Mỹ Tây', 'Phường Thạnh Mỹ Tây', 'Phường Thạnh Mỹ Tây, Thành phố Hồ Chí Minh', '23308', 'phuong', '12'),
(252, 'Bình Quới', 'Phường Bình Quới', 'Phường Bình Quới, Thành phố Hồ Chí Minh', '23564', 'phuong', '12'),
(253, 'An Lạc', 'Phường An Lạc', 'Phường An Lạc, Thành phố Hồ Chí Minh', '23820', 'phuong', '12'),
(254, 'Hạnh Thông', 'Phường Hạnh Thông', 'Phường Hạnh Thông, Thành phố Hồ Chí Minh', '24076', 'phuong', '12'),
(255, 'An Nhơn', 'Phường An Nhơn', 'Phường An Nhơn, Thành phố Hồ Chí Minh', '24332', 'phuong', '12'),
(256, 'Gò Vấp', 'Phường Gò Vấp', 'Phường Gò Vấp, Thành phố Hồ Chí Minh', '24588', 'phuong', '12'),
(257, 'Thông Tây Hội', 'Phường Thông Tây Hội', 'Phường Thông Tây Hội, Thành phố Hồ Chí Minh', '24844', 'phuong', '12'),
(258, 'An Hội Tây', 'Phường An Hội Tây', 'Phường An Hội Tây, Thành phố Hồ Chí Minh', '25100', 'phuong', '12'),
(259, 'An Hội Đông', 'Phường An Hội Đông', 'Phường An Hội Đông, Thành phố Hồ Chí Minh', '25356', 'phuong', '12'),
(260, 'Đức Nhuận', 'Phường Đức Nhuận', 'Phường Đức Nhuận, Thành phố Hồ Chí Minh', '25612', 'phuong', '12'),
(261, 'Tân Sơn Hòa', 'Phường Tân Sơn Hòa', 'Phường Tân Sơn Hòa, Thành phố Hồ Chí Minh', '25868', 'phuong', '12'),
(262, 'Tân Sơn Nhất', 'Phường Tân Sơn Nhất', 'Phường Tân Sơn Nhất, Thành phố Hồ Chí Minh', '26124', 'phuong', '12'),
(263, 'Tân Hòa', 'Phường Tân Hòa', 'Phường Tân Hòa, Thành phố Hồ Chí Minh', '26380', 'phuong', '12'),
(264, 'Bảy Hiền', 'Phường Bảy Hiền', 'Phường Bảy Hiền, Thành phố Hồ Chí Minh', '26636', 'phuong', '12'),
(265, 'Bình Lợi', 'Xã Bình Lợi', 'Xã Bình Lợi, Thành phố Hồ Chí Minh', '26892', 'xa', '12'),
(266, 'Hưng Long', 'Xã Hưng Long', 'Xã Hưng Long, Thành phố Hồ Chí Minh', '27148', 'xa', '12'),
(267, 'An Nhơn Tây', 'Xã An Nhơn Tây', 'Xã An Nhơn Tây, Thành phố Hồ Chí Minh', '27404', 'xa', '12'),
(268, 'Thái Mỹ', 'Xã Thái Mỹ', 'Xã Thái Mỹ, Thành phố Hồ Chí Minh', '27660', 'xa', '12'),
(269, 'Nhuận Đức', 'Xã Nhuận Đức', 'Xã Nhuận Đức, Thành phố Hồ Chí Minh', '27916', 'xa', '12'),
(270, 'Tân An Hội', 'Xã Tân An Hội', 'Xã Tân An Hội, Thành phố Hồ Chí Minh', '28172', 'xa', '12'),
(271, 'Củ Chi', 'Xã Củ Chi', 'Xã Củ Chi, Thành phố Hồ Chí Minh', '28428', 'xa', '12'),
(272, 'Phú Hòa Đông', 'Xã Phú Hòa Đông', 'Xã Phú Hòa Đông, Thành phố Hồ Chí Minh', '28684', 'xa', '12'),
(273, 'Bình Mỹ', 'Xã Bình Mỹ', 'Xã Bình Mỹ, Thành phố Hồ Chí Minh', '28940', 'xa', '12'),
(274, 'Cần Giờ', 'Xã Cần Giờ', 'Xã Cần Giờ, Thành phố Hồ Chí Minh', '29196', 'xa', '12'),
(275, 'Đông Thạnh', 'Xã Đông Thạnh', 'Xã Đông Thạnh, Thành phố Hồ Chí Minh', '29452', 'xa', '12'),
(276, 'Hóc Môn', 'Xã Hóc Môn', 'Xã Hóc Môn, Thành phố Hồ Chí Minh', '29708', 'xa', '12'),
(277, 'Xuân Thới Sơn', 'Xã Xuân Thới Sơn', 'Xã Xuân Thới Sơn, Thành phố Hồ Chí Minh', '29964', 'xa', '12'),
(278, 'Bà Điểm', 'Xã Bà Điểm', 'Xã Bà Điểm, Thành phố Hồ Chí Minh', '30220', 'xa', '12'),
(279, 'Nhà Bè', 'Xã Nhà Bè', 'Xã Nhà Bè, Thành phố Hồ Chí Minh', '30476', 'xa', '12'),
(280, 'Hiệp Phước', 'Xã Hiệp Phước', 'Xã Hiệp Phước, Thành phố Hồ Chí Minh', '30732', 'xa', '12'),
(281, 'Tam Bình', 'Phường Tam Bình', 'Phường Tam Bình, Thành phố Hồ Chí Minh', '30988', 'phuong', '12'),
(282, 'Phước Long', 'Phường Phước Long', 'Phường Phước Long, Thành phố Hồ Chí Minh', '31244', 'phuong', '12'),
(283, 'Long Phước', 'Phường Long Phước', 'Phường Long Phước, Thành phố Hồ Chí Minh', '31500', 'phuong', '12'),
(284, 'Long Trường', 'Phường Long Trường', 'Phường Long Trường, Thành phố Hồ Chí Minh', '31756', 'phuong', '12'),
(285, 'Cát Lái', 'Phường Cát Lái', 'Phường Cát Lái, Thành phố Hồ Chí Minh', '32012', 'phuong', '12'),
(286, 'Bình Tây', 'Phường Bình Tây', 'Phường Bình Tây, Thành phố Hồ Chí Minh', '32268', 'phuong', '12'),
(287, 'Tân Sơn', 'Phường Tân Sơn', 'Phường Tân Sơn, Thành phố Hồ Chí Minh', '32524', 'phuong', '12'),
(288, 'Phú Thọ Hòa', 'Phường Phú Thọ Hòa', 'Phường Phú Thọ Hòa, Thành phố Hồ Chí Minh', '32780', 'phuong', '12'),
(289, 'Tân Phú', 'Phường Tân Phú', 'Phường Tân Phú, Thành phố Hồ Chí Minh', '33036', 'phuong', '12'),
(290, 'Bàu Bàng', 'Xã Bàu Bàng', 'Xã Bàu Bàng, Thành phố Hồ Chí Minh', '33292', 'xa', '12'),
(291, 'Tam Thắng', 'Phường Tam Thắng', 'Phường Tam Thắng, Thành phố Hồ Chí Minh', '33548', 'phuong', '12'),
(292, 'Phước Thắng', 'Phường Phước Thắng', 'Phường Phước Thắng, Thành phố Hồ Chí Minh', '33804', 'phuong', '12'),
(293, 'Bà Rịa', 'Phường Bà Rịa', 'Phường Bà Rịa, Thành phố Hồ Chí Minh', '34060', 'phuong', '12'),
(294, 'Long Hương', 'Phường Long Hương', 'Phường Long Hương, Thành phố Hồ Chí Minh', '34316', 'phuong', '12'),
(295, 'Tam Long', 'Phường Tam Long', 'Phường Tam Long, Thành phố Hồ Chí Minh', '34572', 'phuong', '12'),
(296, 'Phú Mỹ', 'Phường Phú Mỹ', 'Phường Phú Mỹ, Thành phố Hồ Chí Minh', '34828', 'phuong', '12'),
(297, 'Tân Thành', 'Phường Tân Thành', 'Phường Tân Thành, Thành phố Hồ Chí Minh', '35084', 'phuong', '12'),
(298, 'Tân Phước', 'Phường Tân Phước', 'Phường Tân Phước, Thành phố Hồ Chí Minh', '35340', 'phuong', '12'),
(299, 'Tân Hải', 'Phường Tân Hải', 'Phường Tân Hải, Thành phố Hồ Chí Minh', '35596', 'phuong', '12'),
(300, 'Châu Pha', 'Xã Châu Pha', 'Xã Châu Pha, Thành phố Hồ Chí Minh', '35852', 'xa', '12'),
(301, 'Ngãi Giao', 'Xã Ngãi Giao', 'Xã Ngãi Giao, Thành phố Hồ Chí Minh', '36108', 'xa', '12'),
(302, 'Bình Giã', 'Xã Bình Giã', 'Xã Bình Giã, Thành phố Hồ Chí Minh', '36364', 'xa', '12'),
(303, 'Kim Long', 'Xã Kim Long', 'Xã Kim Long, Thành phố Hồ Chí Minh', '36620', 'xa', '12'),
(304, 'Châu Đức', 'Xã Châu Đức', 'Xã Châu Đức, Thành phố Hồ Chí Minh', '36876', 'xa', '12'),
(305, 'Xuân Sơn', 'Xã Xuân Sơn', 'Xã Xuân Sơn, Thành phố Hồ Chí Minh', '37132', 'xa', '12'),
(306, 'Nghĩa Thành', 'Xã Nghĩa Thành', 'Xã Nghĩa Thành, Thành phố Hồ Chí Minh', '37388', 'xa', '12'),
(307, 'Hồ Tràm', 'Xã Hồ Tràm', 'Xã Hồ Tràm, Thành phố Hồ Chí Minh', '37644', 'xa', '12'),
(308, 'Xuyên Mộc', 'Xã Xuyên Mộc', 'Xã Xuyên Mộc, Thành phố Hồ Chí Minh', '37900', 'xa', '12'),
(309, 'Hòa Hội', 'Xã Hòa Hội', 'Xã Hòa Hội, Thành phố Hồ Chí Minh', '38156', 'xa', '12'),
(310, 'Bàu Lâm', 'Xã Bàu Lâm', 'Xã Bàu Lâm, Thành phố Hồ Chí Minh', '38412', 'xa', '12'),
(311, 'Đất Đỏ', 'Xã Đất Đỏ', 'Xã Đất Đỏ, Thành phố Hồ Chí Minh', '38668', 'xa', '12'),
(312, 'Long Hải', 'Xã Long Hải', 'Xã Long Hải, Thành phố Hồ Chí Minh', '38924', 'xa', '12'),
(313, 'Phước Hải', 'Xã Phước Hải', 'Xã Phước Hải, Thành phố Hồ Chí Minh', '39180', 'xa', '12'),
(314, 'Long Sơn', 'Xã Long Sơn', 'Xã Long Sơn, Thành phố Hồ Chí Minh', '39436', 'xa', '12'),
(315, 'Hòa Hiệp', 'Xã Hòa Hiệp', 'Xã Hòa Hiệp, Thành phố Hồ Chí Minh', '39692', 'xa', '12'),
(316, 'Bình Châu', 'Xã Bình Châu', 'Xã Bình Châu, Thành phố Hồ Chí Minh', '39948', 'xa', '12'),
(317, 'Vũng Tàu', 'Phường Vũng Tàu', 'Phường Vũng Tàu, Thành phố Hồ Chí Minh', '40204', 'phuong', '12'),
(318, 'Bình Cơ', 'Phường Bình Cơ', 'Phường Bình Cơ, Thành phố Hồ Chí Minh', '40460', 'phuong', '12'),
(319, 'Bắc Tân Uyên', 'Xã Bắc Tân Uyên', 'Xã Bắc Tân Uyên, Thành phố Hồ Chí Minh', '40716', 'xa', '12'),
(320, 'An Long', 'Xã An Long', 'Xã An Long, Thành phố Hồ Chí Minh', '40972', 'xa', '12'),
(321, 'Phước Thành', 'Xã Phước Thành', 'Xã Phước Thành, Thành phố Hồ Chí Minh', '41228', 'xa', '12'),
(322, 'Đắc Pring', 'Xã Đắc Pring', 'Xã Đắc Pring, Thành phố Đà Nẵng', '14861', 'xa', '13'),
(323, 'Bình Dương', 'Phường Bình Dương', 'Phường Bình Dương, Thành phố Hồ Chí Minh', '41484', 'phuong', '12'),
(324, 'Tân Hiệp', 'Phường Tân Hiệp', 'Phường Tân Hiệp, Thành phố Hồ Chí Minh', '41740', 'phuong', '12'),
(325, 'Hòa Lợi', 'Phường Hòa Lợi', 'Phường Hòa Lợi, Thành phố Hồ Chí Minh', '41996', 'phuong', '12'),
(326, 'Chánh Phú Hòa', 'Phường Chánh Phú Hòa', 'Phường Chánh Phú Hòa, Thành phố Hồ Chí Minh', '42252', 'phuong', '12'),
(327, 'Vĩnh Tân', 'Phường Vĩnh Tân', 'Phường Vĩnh Tân, Thành phố Hồ Chí Minh', '42508', 'phuong', '12'),
(328, 'Đông Hòa', 'Phường Đông Hòa', 'Phường Đông Hòa, Thành phố Hồ Chí Minh', '42764', 'phuong', '12'),
(329, 'Thuận An', 'Phường Thuận An', 'Phường Thuận An, Thành phố Hồ Chí Minh', '43020', 'phuong', '12'),
(330, 'Tam Hải', 'Xã Tam Hải', 'Xã Tam Hải, Thành phố Đà Nẵng', '269', 'xa', '13'),
(331, 'Núi Thành', 'Xã Núi Thành', 'Xã Núi Thành, Thành phố Đà Nẵng', '525', 'xa', '13'),
(332, 'Hải Vân', 'Phường Hải Vân', 'Phường Hải Vân, Thành phố Đà Nẵng', '781', 'phuong', '13'),
(333, 'Thạnh Mỹ', 'Xã Thạnh Mỹ', 'Xã Thạnh Mỹ, Thành phố Đà Nẵng', '1037', 'xa', '13'),
(334, 'Tân Hiệp', 'Xã Tân Hiệp', 'Xã Tân Hiệp, Thành phố Đà Nẵng', '1293', 'xa', '13'),
(335, 'Đặc Khu Hoàng Sa', 'Xã Đặc Khu Hoàng Sa', 'Xã Đặc Khu Hoàng Sa, Thành phố Đà Nẵng', '1549', 'xa', '13'),
(336, 'Quảng Phú', 'Phường Quảng Phú', 'Phường Quảng Phú, Thành phố Đà Nẵng', '1805', 'phuong', '13'),
(337, 'Hương Trà', 'Phường Hương Trà', 'Phường Hương Trà, Thành phố Đà Nẵng', '2061', 'phuong', '13'),
(338, 'Bàn Thạch', 'Phường Bàn Thạch', 'Phường Bàn Thạch, Thành phố Đà Nẵng', '2317', 'phuong', '13'),
(339, 'Tây Hồ', 'Xã Tây Hồ', 'Xã Tây Hồ, Thành phố Đà Nẵng', '2573', 'xa', '13'),
(340, 'Chiên Đàn', 'Xã Chiên Đàn', 'Xã Chiên Đàn, Thành phố Đà Nẵng', '2829', 'xa', '13'),
(341, 'Phú Ninh', 'Xã Phú Ninh', 'Xã Phú Ninh, Thành phố Đà Nẵng', '3085', 'xa', '13'),
(342, 'Lãnh Ngọc', 'Xã Lãnh Ngọc', 'Xã Lãnh Ngọc, Thành phố Đà Nẵng', '3341', 'xa', '13'),
(343, 'Tiên Phước', 'Xã Tiên Phước', 'Xã Tiên Phước, Thành phố Đà Nẵng', '3597', 'xa', '13'),
(344, 'Thạnh Bình', 'Xã Thạnh Bình', 'Xã Thạnh Bình, Thành phố Đà Nẵng', '3853', 'xa', '13'),
(345, 'Sơn Cẩm Hà', 'Xã Sơn Cẩm Hà', 'Xã Sơn Cẩm Hà, Thành phố Đà Nẵng', '4109', 'xa', '13'),
(346, 'Trà Liên', 'Xã Trà Liên', 'Xã Trà Liên, Thành phố Đà Nẵng', '4365', 'xa', '13'),
(347, 'Trà Giáp', 'Xã Trà Giáp', 'Xã Trà Giáp, Thành phố Đà Nẵng', '4621', 'xa', '13'),
(348, 'Trà Tân', 'Xã Trà Tân', 'Xã Trà Tân, Thành phố Đà Nẵng', '4877', 'xa', '13'),
(349, 'Trà Đốc', 'Xã Trà Đốc', 'Xã Trà Đốc, Thành phố Đà Nẵng', '5133', 'xa', '13'),
(350, 'Trà My', 'Xã Trà My', 'Xã Trà My, Thành phố Đà Nẵng', '5389', 'xa', '13'),
(351, 'Trà Mai', 'Xã Trà Mai', 'Xã Trà Mai, Thành phố Đà Nẵng', '5645', 'xa', '13'),
(352, 'Trà Tập', 'Xã Trà Tập', 'Xã Trà Tập, Thành phố Đà Nẵng', '5901', 'xa', '13'),
(353, 'Trà Vân', 'Xã Trà Vân', 'Xã Trà Vân, Thành phố Đà Nẵng', '6157', 'xa', '13'),
(354, 'Trà Linh', 'Xã Trà Linh', 'Xã Trà Linh, Thành phố Đà Nẵng', '6413', 'xa', '13'),
(355, 'Trà Leng', 'Xã Trà Leng', 'Xã Trà Leng, Thành phố Đà Nẵng', '6669', 'xa', '13'),
(356, 'Thăng Bình', 'Xã Thăng Bình', 'Xã Thăng Bình, Thành phố Đà Nẵng', '6925', 'xa', '13'),
(357, 'Thăng An', 'Xã Thăng An', 'Xã Thăng An, Thành phố Đà Nẵng', '7181', 'xa', '13'),
(358, 'Thăng Trường', 'Xã Thăng Trường', 'Xã Thăng Trường, Thành phố Đà Nẵng', '7437', 'xa', '13'),
(359, 'Thăng Điền', 'Xã Thăng Điền', 'Xã Thăng Điền, Thành phố Đà Nẵng', '7693', 'xa', '13'),
(360, 'Thăng Phú', 'Xã Thăng Phú', 'Xã Thăng Phú, Thành phố Đà Nẵng', '7949', 'xa', '13'),
(361, 'Đồng Dương', 'Xã Đồng Dương', 'Xã Đồng Dương, Thành phố Đà Nẵng', '8205', 'xa', '13'),
(362, 'Quế Sơn Trung', 'Xã Quế Sơn Trung', 'Xã Quế Sơn Trung, Thành phố Đà Nẵng', '8461', 'xa', '13'),
(363, 'Quế Sơn', 'Xã Quế Sơn', 'Xã Quế Sơn, Thành phố Đà Nẵng', '8717', 'xa', '13'),
(364, 'Xuân Phú', 'Xã Xuân Phú', 'Xã Xuân Phú, Thành phố Đà Nẵng', '8973', 'xa', '13'),
(365, 'Nông Sơn', 'Xã Nông Sơn', 'Xã Nông Sơn, Thành phố Đà Nẵng', '9229', 'xa', '13'),
(366, 'Quế Phước', 'Xã Quế Phước', 'Xã Quế Phước, Thành phố Đà Nẵng', '9485', 'xa', '13'),
(367, 'Duy Nghĩa', 'Xã Duy Nghĩa', 'Xã Duy Nghĩa, Thành phố Đà Nẵng', '9741', 'xa', '13'),
(368, 'Nam Phước', 'Xã Nam Phước', 'Xã Nam Phước, Thành phố Đà Nẵng', '9997', 'xa', '13'),
(369, 'Duy Xuyên', 'Xã Duy Xuyên', 'Xã Duy Xuyên, Thành phố Đà Nẵng', '10253', 'xa', '13'),
(370, 'Thu Bồn', 'Xã Thu Bồn', 'Xã Thu Bồn, Thành phố Đà Nẵng', '10509', 'xa', '13'),
(371, 'Điện Bàn', 'Phường Điện Bàn', 'Phường Điện Bàn, Thành phố Đà Nẵng', '10765', 'phuong', '13'),
(372, 'Điện Bàn Đông', 'Phường Điện Bàn Đông', 'Phường Điện Bàn Đông, Thành phố Đà Nẵng', '11021', 'phuong', '13'),
(373, 'An Thắng', 'Phường An Thắng', 'Phường An Thắng, Thành phố Đà Nẵng', '11277', 'phuong', '13'),
(374, 'Điện Bàn Bắc', 'Phường Điện Bàn Bắc', 'Phường Điện Bàn Bắc, Thành phố Đà Nẵng', '11533', 'phuong', '13'),
(375, 'Điện Bàn Tây', 'Xã Điện Bàn Tây', 'Xã Điện Bàn Tây, Thành phố Đà Nẵng', '11789', 'xa', '13'),
(376, 'Gò Nổi', 'Xã Gò Nổi', 'Xã Gò Nổi, Thành phố Đà Nẵng', '12045', 'xa', '13'),
(377, 'Hội An', 'Phường Hội An', 'Phường Hội An, Thành phố Đà Nẵng', '12301', 'phuong', '13'),
(378, 'Hội An Đông', 'Phường Hội An Đông', 'Phường Hội An Đông, Thành phố Đà Nẵng', '12557', 'phuong', '13'),
(379, 'Hội An Tây', 'Phường Hội An Tây', 'Phường Hội An Tây, Thành phố Đà Nẵng', '12813', 'phuong', '13'),
(380, 'Đại Lộc', 'Xã Đại Lộc', 'Xã Đại Lộc, Thành phố Đà Nẵng', '13069', 'xa', '13'),
(381, 'Hà Nha', 'Xã Hà Nha', 'Xã Hà Nha, Thành phố Đà Nẵng', '13325', 'xa', '13'),
(382, 'Thượng Đức', 'Xã Thượng Đức', 'Xã Thượng Đức, Thành phố Đà Nẵng', '13581', 'xa', '13'),
(383, 'Vu Gia', 'Xã Vu Gia', 'Xã Vu Gia, Thành phố Đà Nẵng', '13837', 'xa', '13'),
(384, 'Phú Thuận', 'Xã Phú Thuận', 'Xã Phú Thuận, Thành phố Đà Nẵng', '14093', 'xa', '13'),
(385, 'Bến Giằng', 'Xã Bến Giằng', 'Xã Bến Giằng, Thành phố Đà Nẵng', '14349', 'xa', '13'),
(386, 'Nam Giang', 'Xã Nam Giang', 'Xã Nam Giang, Thành phố Đà Nẵng', '14605', 'xa', '13'),
(387, 'La Dêê', 'Xã La Dêê', 'Xã La Dêê, Thành phố Đà Nẵng', '15117', 'xa', '13'),
(388, 'Laêê', 'Xã Laêê', 'Xã Laêê, Thành phố Đà Nẵng', '15373', 'xa', '13'),
(389, 'Sông Vàng', 'Xã Sông Vàng', 'Xã Sông Vàng, Thành phố Đà Nẵng', '15629', 'xa', '13'),
(390, 'Sông Kôn', 'Xã Sông Kôn', 'Xã Sông Kôn, Thành phố Đà Nẵng', '15885', 'xa', '13'),
(391, 'Đông Giang', 'Xã Đông Giang', 'Xã Đông Giang, Thành phố Đà Nẵng', '16141', 'xa', '13'),
(392, 'Bến Hiên', 'Xã Bến Hiên', 'Xã Bến Hiên, Thành phố Đà Nẵng', '16397', 'xa', '13'),
(393, 'A Vương', 'Xã A Vương', 'Xã A Vương, Thành phố Đà Nẵng', '16653', 'xa', '13'),
(394, 'Tây Giang', 'Xã Tây Giang', 'Xã Tây Giang, Thành phố Đà Nẵng', '16909', 'xa', '13'),
(395, 'Hùng Sơn', 'Xã Hùng Sơn', 'Xã Hùng Sơn, Thành phố Đà Nẵng', '17165', 'xa', '13'),
(396, 'Hiệp Đức', 'Xã Hiệp Đức', 'Xã Hiệp Đức, Thành phố Đà Nẵng', '17421', 'xa', '13'),
(397, 'Việt An', 'Xã Việt An', 'Xã Việt An, Thành phố Đà Nẵng', '17677', 'xa', '13'),
(398, 'Phước Trà', 'Xã Phước Trà', 'Xã Phước Trà, Thành phố Đà Nẵng', '17933', 'xa', '13'),
(399, 'Khâm Đức', 'Xã Khâm Đức', 'Xã Khâm Đức, Thành phố Đà Nẵng', '18189', 'xa', '13'),
(400, 'Phước Năng', 'Xã Phước Năng', 'Xã Phước Năng, Thành phố Đà Nẵng', '18445', 'xa', '13'),
(401, 'Phước Chánh', 'Xã Phước Chánh', 'Xã Phước Chánh, Thành phố Đà Nẵng', '18701', 'xa', '13'),
(402, 'Phước Thành', 'Xã Phước Thành', 'Xã Phước Thành, Thành phố Đà Nẵng', '18957', 'xa', '13'),
(403, 'Phước Hiệp', 'Xã Phước Hiệp', 'Xã Phước Hiệp, Thành phố Đà Nẵng', '19213', 'xa', '13'),
(404, 'Hải Châu', 'Phường Hải Châu', 'Phường Hải Châu, Thành phố Đà Nẵng', '19469', 'phuong', '13'),
(405, 'Hòa Cường', 'Phường Hòa Cường', 'Phường Hòa Cường, Thành phố Đà Nẵng', '19725', 'phuong', '13'),
(406, 'Thanh Khê', 'Phường Thanh Khê', 'Phường Thanh Khê, Thành phố Đà Nẵng', '19981', 'phuong', '13'),
(407, 'An Khê', 'Phường An Khê', 'Phường An Khê, Thành phố Đà Nẵng', '20237', 'phuong', '13'),
(408, 'An Hải', 'Phường An Hải', 'Phường An Hải, Thành phố Đà Nẵng', '20493', 'phuong', '13'),
(409, 'Sơn Trà', 'Phường Sơn Trà', 'Phường Sơn Trà, Thành phố Đà Nẵng', '20749', 'phuong', '13'),
(410, 'Ngũ Hành Sơn', 'Phường Ngũ Hành Sơn', 'Phường Ngũ Hành Sơn, Thành phố Đà Nẵng', '21005', 'phuong', '13'),
(411, 'Hòa Khánh', 'Phường Hòa Khánh', 'Phường Hòa Khánh, Thành phố Đà Nẵng', '21261', 'phuong', '13'),
(412, 'Liên Chiểu', 'Phường Liên Chiểu', 'Phường Liên Chiểu, Thành phố Đà Nẵng', '21517', 'phuong', '13'),
(413, 'Cẩm Lệ', 'Phường Cẩm Lệ', 'Phường Cẩm Lệ, Thành phố Đà Nẵng', '21773', 'phuong', '13'),
(414, 'Hòa Xuân', 'Phường Hòa Xuân', 'Phường Hòa Xuân, Thành phố Đà Nẵng', '22029', 'phuong', '13'),
(415, 'Hòa Vang', 'Xã Hòa Vang', 'Xã Hòa Vang, Thành phố Đà Nẵng', '22285', 'xa', '13'),
(416, 'Hòa Tiến', 'Xã Hòa Tiến', 'Xã Hòa Tiến, Thành phố Đà Nẵng', '22541', 'xa', '13'),
(417, 'Bà Nà', 'Xã Bà Nà', 'Xã Bà Nà, Thành phố Đà Nẵng', '22797', 'xa', '13'),
(418, 'Tam Mỹ', 'Xã Tam Mỹ', 'Xã Tam Mỹ, Thành phố Đà Nẵng', '23053', 'xa', '13'),
(419, 'Tam Anh', 'Xã Tam Anh', 'Xã Tam Anh, Thành phố Đà Nẵng', '23309', 'xa', '13'),
(420, 'Đức Phú', 'Xã Đức Phú', 'Xã Đức Phú, Thành phố Đà Nẵng', '23565', 'xa', '13'),
(421, 'Tam Xuân', 'Xã Tam Xuân', 'Xã Tam Xuân, Thành phố Đà Nẵng', '23821', 'xa', '13'),
(422, 'Tam Kỳ', 'Phường Tam Kỳ', 'Phường Tam Kỳ, Thành phố Đà Nẵng', '24077', 'phuong', '13'),
(423, 'Mao Điền', 'Xã Mao Điền', 'Xã Mao Điền, Thành phố Hải Phòng', '270', 'xa', '14'),
(424, 'Việt Hòa', 'Phường Việt Hòa', 'Phường Việt Hòa, Thành phố Hải Phòng', '526', 'phuong', '14'),
(425, 'Cẩm Giàng', 'Xã Cẩm Giàng', 'Xã Cẩm Giàng, Thành phố Hải Phòng', '782', 'xa', '14'),
(426, 'Tân Hưng', 'Phường Tân Hưng', 'Phường Tân Hưng, Thành phố Hải Phòng', '1038', 'phuong', '14'),
(427, 'Ái Quốc', 'Phường Ái Quốc', 'Phường Ái Quốc, Thành phố Hải Phòng', '1294', 'phuong', '14'),
(428, 'An Khánh', 'Xã An Khánh', 'Xã An Khánh, Thành phố Hải Phòng', '1550', 'xa', '14'),
(429, 'Tân Minh', 'Xã Tân Minh', 'Xã Tân Minh, Thành phố Hải Phòng', '1806', 'xa', '14'),
(430, 'Hải An', 'Phường Hải An', 'Phường Hải An, Thành phố Hải Phòng', '2062', 'phuong', '14'),
(431, 'Nam Đồ Sơn', 'Phường Nam Đồ Sơn', 'Phường Nam Đồ Sơn, Thành phố Hải Phòng', '2318', 'phuong', '14'),
(432, 'Dương Kinh', 'Phường Dương Kinh', 'Phường Dương Kinh, Thành phố Hải Phòng', '2574', 'phuong', '14'),
(433, 'Đông Hải', 'Phường Đông Hải', 'Phường Đông Hải, Thành phố Hải Phòng', '2830', 'phuong', '14'),
(434, 'Đường An', 'Xã Đường An', 'Xã Đường An, Thành phố Hải Phòng', '3086', 'xa', '14'),
(435, 'Thượng Hồng', 'Xã Thượng Hồng', 'Xã Thượng Hồng, Thành phố Hải Phòng', '3342', 'xa', '14'),
(436, 'Bình Giang', 'Xã Bình Giang', 'Xã Bình Giang, Thành phố Hải Phòng', '3598', 'xa', '14'),
(437, 'Gia Phúc', 'Xã Gia Phúc', 'Xã Gia Phúc, Thành phố Hải Phòng', '3854', 'xa', '14'),
(438, 'An Lão', 'Xã An Lão', 'Xã An Lão, Thành phố Hải Phòng', '4110', 'xa', '14'),
(439, 'Kiến Hải', 'Xã Kiến Hải', 'Xã Kiến Hải, Thành phố Hải Phòng', '4366', 'xa', '14'),
(440, 'Kiến An', 'Phường Kiến An', 'Phường Kiến An, Thành phố Hải Phòng', '4622', 'phuong', '14'),
(441, 'Phù Liễn', 'Phường Phù Liễn', 'Phường Phù Liễn, Thành phố Hải Phòng', '4878', 'phuong', '14'),
(442, 'An Biên', 'Phường An Biên', 'Phường An Biên, Thành phố Hải Phòng', '5134', 'phuong', '14'),
(443, 'Quyết Thắng', 'Xã Quyết Thắng', 'Xã Quyết Thắng, Thành phố Hải Phòng', '5390', 'xa', '14'),
(444, 'Tiên Minh', 'Xã Tiên Minh', 'Xã Tiên Minh, Thành phố Hải Phòng', '5646', 'xa', '14'),
(445, 'Trần Liễu', 'Phường Trần Liễu', 'Phường Trần Liễu, Thành phố Hải Phòng', '5902', 'phuong', '14'),
(446, 'Lê Thanh Nghị', 'Phường Lê Thanh Nghị', 'Phường Lê Thanh Nghị, Thành phố Hải Phòng', '6158', 'phuong', '14'),
(447, 'Thạch Khôi', 'Phường Thạch Khôi', 'Phường Thạch Khôi, Thành phố Hải Phòng', '6414', 'phuong', '14'),
(448, 'Tân Kỳ', 'Xã Tân Kỳ', 'Xã Tân Kỳ, Thành phố Hải Phòng', '6670', 'xa', '14'),
(449, 'Nguyên Giáp', 'Xã Nguyên Giáp', 'Xã Nguyên Giáp, Thành phố Hải Phòng', '6926', 'xa', '14'),
(450, 'Nam An Phụ', 'Xã Nam An Phụ', 'Xã Nam An Phụ, Thành phố Hải Phòng', '7182', 'xa', '14'),
(451, 'Bắc An Phụ', 'Phường Bắc An Phụ', 'Phường Bắc An Phụ, Thành phố Hải Phòng', '7438', 'phuong', '14'),
(452, 'Hà Nam', 'Xã Hà Nam', 'Xã Hà Nam, Thành phố Hải Phòng', '7694', 'xa', '14'),
(453, 'Hà Tây', 'Xã Hà Tây', 'Xã Hà Tây, Thành phố Hải Phòng', '7950', 'xa', '14'),
(454, 'Nguyễn Lương Bằng', 'Xã Nguyễn Lương Bằng', 'Xã Nguyễn Lương Bằng, Thành phố Hải Phòng', '8206', 'xa', '14'),
(455, 'Lạc Phượng', 'Xã Lạc Phượng', 'Xã Lạc Phượng, Thành phố Hải Phòng', '8462', 'xa', '14'),
(456, 'Trần Nhân Tông', 'Phường Trần Nhân Tông', 'Phường Trần Nhân Tông, Thành phố Hải Phòng', '8718', 'phuong', '14'),
(457, 'Trần Hưng Đạo', 'Phường Trần Hưng Đạo', 'Phường Trần Hưng Đạo, Thành phố Hải Phòng', '8974', 'phuong', '14'),
(458, 'Đại Sơn', 'Xã Đại Sơn', 'Xã Đại Sơn, Thành phố Hải Phòng', '9230', 'xa', '14'),
(459, 'Đặc Khu Bạch Long Vĩ', 'Xã Đặc Khu Bạch Long Vĩ', 'Xã Đặc Khu Bạch Long Vĩ, Thành phố Hải Phòng', '9486', 'xa', '14'),
(460, 'An Hải', 'Phường An Hải', 'Phường An Hải, Thành phố Hải Phòng', '9742', 'phuong', '14'),
(461, 'Kiến Hưng', 'Xã Kiến Hưng', 'Xã Kiến Hưng, Thành phố Hải Phòng', '9998', 'xa', '14'),
(462, 'Gia Viên', 'Phường Gia Viên', 'Phường Gia Viên, Thành phố Hải Phòng', '10254', 'phuong', '14'),
(463, 'Vĩnh Am', 'Xã Vĩnh Am', 'Xã Vĩnh Am, Thành phố Hải Phòng', '10510', 'xa', '14'),
(464, 'Trường Tân', 'Xã Trường Tân', 'Xã Trường Tân, Thành phố Hải Phòng', '10766', 'xa', '14'),
(465, 'Hồng An', 'Phường Hồng An', 'Phường Hồng An, Thành phố Hải Phòng', '11022', 'phuong', '14'),
(466, 'An Phong', 'Phường An Phong', 'Phường An Phong, Thành phố Hải Phòng', '11278', 'phuong', '14'),
(467, 'Kim Thành', 'Xã Kim Thành', 'Xã Kim Thành, Thành phố Hải Phòng', '11534', 'xa', '14'),
(468, 'Thiên Hương', 'Phường Thiên Hương', 'Phường Thiên Hương, Thành phố Hải Phòng', '11790', 'phuong', '14'),
(469, 'Lưu Kiếm', 'Phường Lưu Kiếm', 'Phường Lưu Kiếm, Thành phố Hải Phòng', '12046', 'phuong', '14'),
(470, 'Hòa Bình', 'Phường Hòa Bình', 'Phường Hòa Bình, Thành phố Hải Phòng', '12302', 'phuong', '14'),
(471, 'Nam Triệu', 'Phường Nam Triệu', 'Phường Nam Triệu, Thành phố Hải Phòng', '12558', 'phuong', '14'),
(472, 'Việt Khê', 'Xã Việt Khê', 'Xã Việt Khê, Thành phố Hải Phòng', '12814', 'xa', '14'),
(473, 'Lê Ích Mộc', 'Phường Lê Ích Mộc', 'Phường Lê Ích Mộc, Thành phố Hải Phòng', '13070', 'phuong', '14'),
(474, 'An Phú', 'Xã An Phú', 'Xã An Phú, Thành phố Hải Phòng', '13326', 'xa', '14'),
(475, 'Hà Bắc', 'Xã Hà Bắc', 'Xã Hà Bắc, Thành phố Hải Phòng', '13582', 'xa', '14'),
(476, 'Lai Khê', 'Xã Lai Khê', 'Xã Lai Khê, Thành phố Hải Phòng', '13838', 'xa', '14'),
(477, 'An Hưng', 'Xã An Hưng', 'Xã An Hưng, Thành phố Hải Phòng', '14094', 'xa', '14'),
(478, 'An Quang', 'Xã An Quang', 'Xã An Quang, Thành phố Hải Phòng', '14350', 'xa', '14'),
(479, 'An Trường', 'Xã An Trường', 'Xã An Trường, Thành phố Hải Phòng', '14606', 'xa', '14'),
(480, 'Kiến Minh', 'Xã Kiến Minh', 'Xã Kiến Minh, Thành phố Hải Phòng', '14862', 'xa', '14'),
(481, 'Nghi Dương', 'Xã Nghi Dương', 'Xã Nghi Dương, Thành phố Hải Phòng', '15118', 'xa', '14'),
(482, 'Tiên Lãng', 'Xã Tiên Lãng', 'Xã Tiên Lãng, Thành phố Hải Phòng', '15374', 'xa', '14'),
(483, 'Chấn Hưng', 'Xã Chấn Hưng', 'Xã Chấn Hưng, Thành phố Hải Phòng', '15630', 'xa', '14'),
(484, 'Hùng Thắng', 'Xã Hùng Thắng', 'Xã Hùng Thắng, Thành phố Hải Phòng', '15886', 'xa', '14'),
(485, 'Vĩnh Bảo', 'Xã Vĩnh Bảo', 'Xã Vĩnh Bảo, Thành phố Hải Phòng', '16142', 'xa', '14'),
(486, 'Nguyễn Bỉnh Khiêm', 'Xã Nguyễn Bỉnh Khiêm', 'Xã Nguyễn Bỉnh Khiêm, Thành phố Hải Phòng', '16398', 'xa', '14'),
(487, 'Vĩnh Hải', 'Xã Vĩnh Hải', 'Xã Vĩnh Hải, Thành phố Hải Phòng', '16654', 'xa', '14'),
(488, 'Vĩnh Hòa', 'Xã Vĩnh Hòa', 'Xã Vĩnh Hòa, Thành phố Hải Phòng', '16910', 'xa', '14'),
(489, 'Vĩnh Thịnh', 'Xã Vĩnh Thịnh', 'Xã Vĩnh Thịnh, Thành phố Hải Phòng', '17166', 'xa', '14'),
(490, 'Vĩnh Thuận', 'Xã Vĩnh Thuận', 'Xã Vĩnh Thuận, Thành phố Hải Phòng', '17422', 'xa', '14'),
(491, 'Bạch Đằng', 'Phường Bạch Đằng', 'Phường Bạch Đằng, Thành phố Hải Phòng', '17678', 'phuong', '14'),
(492, 'Hải Dương', 'Phường Hải Dương', 'Phường Hải Dương, Thành phố Hải Phòng', '17934', 'phuong', '14'),
(493, 'Thành Đông', 'Phường Thành Đông', 'Phường Thành Đông, Thành phố Hải Phòng', '18190', 'phuong', '14'),
(494, 'Nam Đồng', 'Phường Nam Đồng', 'Phường Nam Đồng, Thành phố Hải Phòng', '18446', 'phuong', '14'),
(495, 'Chí Linh', 'Phường Chí Linh', 'Phường Chí Linh, Thành phố Hải Phòng', '18702', 'phuong', '14'),
(496, 'Nguyễn Trãi', 'Phường Nguyễn Trãi', 'Phường Nguyễn Trãi, Thành phố Hải Phòng', '18958', 'phuong', '14'),
(497, 'Lê Đại Hành', 'Phường Lê Đại Hành', 'Phường Lê Đại Hành, Thành phố Hải Phòng', '19214', 'phuong', '14'),
(498, 'Kinh Môn', 'Phường Kinh Môn', 'Phường Kinh Môn, Thành phố Hải Phòng', '19470', 'phuong', '14'),
(499, 'Nguyễn Đại Năng', 'Phường Nguyễn Đại Năng', 'Phường Nguyễn Đại Năng, Thành phố Hải Phòng', '19726', 'phuong', '14'),
(500, 'Phạm Sư Mạnh', 'Phường Phạm Sư Mạnh', 'Phường Phạm Sư Mạnh, Thành phố Hải Phòng', '19982', 'phuong', '14'),
(501, 'Nhị Chiểu', 'Phường Nhị Chiểu', 'Phường Nhị Chiểu, Thành phố Hải Phòng', '20238', 'phuong', '14'),
(502, 'Nam Sách', 'Xã Nam Sách', 'Xã Nam Sách, Thành phố Hải Phòng', '20494', 'xa', '14'),
(503, 'Thái Tân', 'Xã Thái Tân', 'Xã Thái Tân, Thành phố Hải Phòng', '20750', 'xa', '14'),
(504, 'Trần Phú', 'Xã Trần Phú', 'Xã Trần Phú, Thành phố Hải Phòng', '21006', 'xa', '14'),
(505, 'Hợp Tiến', 'Xã Hợp Tiến', 'Xã Hợp Tiến, Thành phố Hải Phòng', '21262', 'xa', '14'),
(506, 'Thanh Hà', 'Xã Thanh Hà', 'Xã Thanh Hà, Thành phố Hải Phòng', '21518', 'xa', '14'),
(507, 'Hà Đông', 'Xã Hà Đông', 'Xã Hà Đông, Thành phố Hải Phòng', '21774', 'xa', '14'),
(508, 'Cẩm Giang', 'Xã Cẩm Giang', 'Xã Cẩm Giang, Thành phố Hải Phòng', '22030', 'xa', '14'),
(509, 'Tuệ Tĩnh', 'Xã Tuệ Tĩnh', 'Xã Tuệ Tĩnh, Thành phố Hải Phòng', '22286', 'xa', '14'),
(510, 'Tứ Kỳ', 'Xã Tứ Kỳ', 'Xã Tứ Kỳ, Thành phố Hải Phòng', '22542', 'xa', '14'),
(511, 'Chí Minh', 'Xã Chí Minh', 'Xã Chí Minh, Thành phố Hải Phòng', '22798', 'xa', '14'),
(512, 'Ninh Giang', 'Xã Ninh Giang', 'Xã Ninh Giang, Thành phố Hải Phòng', '23054', 'xa', '14'),
(513, 'Vĩnh Lại', 'Xã Vĩnh Lại', 'Xã Vĩnh Lại, Thành phố Hải Phòng', '23310', 'xa', '14'),
(514, 'Khúc Thừa Dụ', 'Xã Khúc Thừa Dụ', 'Xã Khúc Thừa Dụ, Thành phố Hải Phòng', '23566', 'xa', '14'),
(515, 'Tân An', 'Xã Tân An', 'Xã Tân An, Thành phố Hải Phòng', '23822', 'xa', '14'),
(516, 'Hồng Châu', 'Xã Hồng Châu', 'Xã Hồng Châu, Thành phố Hải Phòng', '24078', 'xa', '14'),
(517, 'Thanh Miện', 'Xã Thanh Miện', 'Xã Thanh Miện, Thành phố Hải Phòng', '24334', 'xa', '14'),
(518, 'Bắc Thanh Miện', 'Xã Bắc Thanh Miện', 'Xã Bắc Thanh Miện, Thành phố Hải Phòng', '24590', 'xa', '14'),
(519, 'Hải Hưng', 'Xã Hải Hưng', 'Xã Hải Hưng, Thành phố Hải Phòng', '24846', 'xa', '14'),
(520, 'Nam Thanh Miện', 'Xã Nam Thanh Miện', 'Xã Nam Thanh Miện, Thành phố Hải Phòng', '25102', 'xa', '14'),
(521, 'An Thành', 'Xã An Thành', 'Xã An Thành, Thành phố Hải Phòng', '25358', 'xa', '14'),
(522, 'Đặc Khu Cát Hải', 'Xã Đặc Khu Cát Hải', 'Xã Đặc Khu Cát Hải, Thành phố Hải Phòng', '25614', 'xa', '14'),
(523, 'Kiến Thụy', 'Xã Kiến Thụy', 'Xã Kiến Thụy, Thành phố Hải Phòng', '25870', 'xa', '14'),
(524, 'Thủy Nguyên', 'Phường Thủy Nguyên', 'Phường Thủy Nguyên, Thành phố Hải Phòng', '26126', 'phuong', '14'),
(525, 'Hồng Bàng', 'Phường Hồng Bàng', 'Phường Hồng Bàng, Thành phố Hải Phòng', '26382', 'phuong', '14'),
(526, 'Ngô Quyền', 'Phường Ngô Quyền', 'Phường Ngô Quyền, Thành phố Hải Phòng', '26638', 'phuong', '14'),
(527, 'Lê Chân', 'Phường Lê Chân', 'Phường Lê Chân, Thành phố Hải Phòng', '26894', 'phuong', '14'),
(528, 'Đồ Sơn', 'Phường Đồ Sơn', 'Phường Đồ Sơn, Thành phố Hải Phòng', '27150', 'phuong', '14'),
(529, 'Hưng Đạo', 'Phường Hưng Đạo', 'Phường Hưng Đạo, Thành phố Hải Phòng', '27406', 'phuong', '14');
INSERT INTO `vn_locations` (`id`, `name`, `full_name`, `full_path`, `code`, `level`, `parent_code`) VALUES
(530, 'An Dương', 'Phường An Dương', 'Phường An Dương, Thành phố Hải Phòng', '27662', 'phuong', '14'),
(531, 'Tứ Minh', 'Phường Tứ Minh', 'Phường Tứ Minh, Thành phố Hải Phòng', '27918', 'phuong', '14'),
(532, 'Chu Văn An', 'Phường Chu Văn An', 'Phường Chu Văn An, Thành phố Hải Phòng', '28174', 'phuong', '14'),
(533, 'Kẻ Sặt', 'Xã Kẻ Sặt', 'Xã Kẻ Sặt, Thành phố Hải Phòng', '28430', 'xa', '14'),
(534, 'Gia Lộc', 'Xã Gia Lộc', 'Xã Gia Lộc, Thành phố Hải Phòng', '28686', 'xa', '14'),
(535, 'Yết Kiêu', 'Xã Yết Kiêu', 'Xã Yết Kiêu, Thành phố Hải Phòng', '28942', 'xa', '14'),
(536, 'Phú Thái', 'Xã Phú Thái', 'Xã Phú Thái, Thành phố Hải Phòng', '29198', 'xa', '14'),
(537, 'Phong Nẫm', 'Xã Phong Nẫm', 'Xã Phong Nẫm, Thành phố Cần Thơ', '271', 'xa', '15'),
(538, 'Lai Hòa', 'Xã Lai Hòa', 'Xã Lai Hòa, Thành phố Cần Thơ', '527', 'xa', '15'),
(539, 'Vĩnh Hải', 'Xã Vĩnh Hải', 'Xã Vĩnh Hải, Thành phố Cần Thơ', '783', 'xa', '15'),
(540, 'Mỹ Phước', 'Xã Mỹ Phước', 'Xã Mỹ Phước, Thành phố Cần Thơ', '1039', 'xa', '15'),
(541, 'Thạnh Phú', 'Xã Thạnh Phú', 'Xã Thạnh Phú, Thành phố Cần Thơ', '1295', 'xa', '15'),
(542, 'Thới Hưng', 'Xã Thới Hưng', 'Xã Thới Hưng, Thành phố Cần Thơ', '1551', 'xa', '15'),
(543, 'Trường Long', 'Xã Trường Long', 'Xã Trường Long, Thành phố Cần Thơ', '1807', 'xa', '15'),
(544, 'Long Tuyền', 'Phường Long Tuyền', 'Phường Long Tuyền, Thành phố Cần Thơ', '2063', 'phuong', '15'),
(545, 'Cái Khế', 'Phường Cái Khế', 'Phường Cái Khế, Thành phố Cần Thơ', '2319', 'phuong', '15'),
(546, 'An Bình', 'Phường An Bình', 'Phường An Bình, Thành phố Cần Thơ', '2575', 'phuong', '15'),
(547, 'Tân Lộc', 'Phường Tân Lộc', 'Phường Tân Lộc, Thành phố Cần Thơ', '2831', 'phuong', '15'),
(548, 'Ninh Kiều', 'Phường Ninh Kiều', 'Phường Ninh Kiều, Thành phố Cần Thơ', '3087', 'phuong', '15'),
(549, 'Tân An', 'Phường Tân An', 'Phường Tân An, Thành phố Cần Thơ', '3343', 'phuong', '15'),
(550, 'Thới An Đông', 'Phường Thới An Đông', 'Phường Thới An Đông, Thành phố Cần Thơ', '3599', 'phuong', '15'),
(551, 'Cái Răng', 'Phường Cái Răng', 'Phường Cái Răng, Thành phố Cần Thơ', '3855', 'phuong', '15'),
(552, 'Hưng Phú', 'Phường Hưng Phú', 'Phường Hưng Phú, Thành phố Cần Thơ', '4111', 'phuong', '15'),
(553, 'Ô Môn', 'Phường Ô Môn', 'Phường Ô Môn, Thành phố Cần Thơ', '4367', 'phuong', '15'),
(554, 'Thới Long', 'Phường Thới Long', 'Phường Thới Long, Thành phố Cần Thơ', '4623', 'phuong', '15'),
(555, 'Phước Thới', 'Phường Phước Thới', 'Phường Phước Thới, Thành phố Cần Thơ', '4879', 'phuong', '15'),
(556, 'Trung Nhứt', 'Phường Trung Nhứt', 'Phường Trung Nhứt, Thành phố Cần Thơ', '5135', 'phuong', '15'),
(557, 'Phong Điền', 'Xã Phong Điền', 'Xã Phong Điền, Thành phố Cần Thơ', '5391', 'xa', '15'),
(558, 'Nhơn Ái', 'Xã Nhơn Ái', 'Xã Nhơn Ái, Thành phố Cần Thơ', '5647', 'xa', '15'),
(559, 'Thới Lai', 'Xã Thới Lai', 'Xã Thới Lai, Thành phố Cần Thơ', '5903', 'xa', '15'),
(560, 'Đông Thuận', 'Xã Đông Thuận', 'Xã Đông Thuận, Thành phố Cần Thơ', '6159', 'xa', '15'),
(561, 'Trường Xuân', 'Xã Trường Xuân', 'Xã Trường Xuân, Thành phố Cần Thơ', '6415', 'xa', '15'),
(562, 'Trường Thành', 'Xã Trường Thành', 'Xã Trường Thành, Thành phố Cần Thơ', '6671', 'xa', '15'),
(563, 'Cờ Đỏ', 'Xã Cờ Đỏ', 'Xã Cờ Đỏ, Thành phố Cần Thơ', '6927', 'xa', '15'),
(564, 'Đông Hiệp', 'Xã Đông Hiệp', 'Xã Đông Hiệp, Thành phố Cần Thơ', '7183', 'xa', '15'),
(565, 'Trung Hưng', 'Xã Trung Hưng', 'Xã Trung Hưng, Thành phố Cần Thơ', '7439', 'xa', '15'),
(566, 'Vĩnh Thạnh', 'Xã Vĩnh Thạnh', 'Xã Vĩnh Thạnh, Thành phố Cần Thơ', '7695', 'xa', '15'),
(567, 'Vĩnh Trinh', 'Xã Vĩnh Trinh', 'Xã Vĩnh Trinh, Thành phố Cần Thơ', '7951', 'xa', '15'),
(568, 'Thạnh An', 'Xã Thạnh An', 'Xã Thạnh An, Thành phố Cần Thơ', '8207', 'xa', '15'),
(569, 'Thạnh Quới', 'Xã Thạnh Quới', 'Xã Thạnh Quới, Thành phố Cần Thơ', '8463', 'xa', '15'),
(570, 'Vị Thanh', 'Phường Vị Thanh', 'Phường Vị Thanh, Thành phố Cần Thơ', '8719', 'phuong', '15'),
(571, 'Vị Tân', 'Phường Vị Tân', 'Phường Vị Tân, Thành phố Cần Thơ', '8975', 'phuong', '15'),
(572, 'Hỏa Lựu', 'Xã Hỏa Lựu', 'Xã Hỏa Lựu, Thành phố Cần Thơ', '9231', 'xa', '15'),
(573, 'Vị Thủy', 'Xã Vị Thủy', 'Xã Vị Thủy, Thành phố Cần Thơ', '9487', 'xa', '15'),
(574, 'Vĩnh Thuận Đông', 'Xã Vĩnh Thuận Đông', 'Xã Vĩnh Thuận Đông, Thành phố Cần Thơ', '9743', 'xa', '15'),
(575, 'Vị Thanh 1', 'Xã Vị Thanh 1', 'Xã Vị Thanh 1, Thành phố Cần Thơ', '9999', 'xa', '15'),
(576, 'Vĩnh Tường', 'Xã Vĩnh Tường', 'Xã Vĩnh Tường, Thành phố Cần Thơ', '10255', 'xa', '15'),
(577, 'Vĩnh Viễn', 'Xã Vĩnh Viễn', 'Xã Vĩnh Viễn, Thành phố Cần Thơ', '10511', 'xa', '15'),
(578, 'Xà Phiên', 'Xã Xà Phiên', 'Xã Xà Phiên, Thành phố Cần Thơ', '10767', 'xa', '15'),
(579, 'Lương Tâm', 'Xã Lương Tâm', 'Xã Lương Tâm, Thành phố Cần Thơ', '11023', 'xa', '15'),
(580, 'Long Bình', 'Phường Long Bình', 'Phường Long Bình, Thành phố Cần Thơ', '11279', 'phuong', '15'),
(581, 'Long Mỹ', 'Phường Long Mỹ', 'Phường Long Mỹ, Thành phố Cần Thơ', '11535', 'phuong', '15'),
(582, 'Long Phú 1', 'Phường Long Phú 1', 'Phường Long Phú 1, Thành phố Cần Thơ', '11791', 'phuong', '15'),
(583, 'Thạnh Xuân', 'Xã Thạnh Xuân', 'Xã Thạnh Xuân, Thành phố Cần Thơ', '12047', 'xa', '15'),
(584, 'Tân Hòa', 'Xã Tân Hòa', 'Xã Tân Hòa, Thành phố Cần Thơ', '12303', 'xa', '15'),
(585, 'Trường Long Tây', 'Xã Trường Long Tây', 'Xã Trường Long Tây, Thành phố Cần Thơ', '12559', 'xa', '15'),
(586, 'Châu Thành', 'Xã Châu Thành', 'Xã Châu Thành, Thành phố Cần Thơ', '12815', 'xa', '15'),
(587, 'Đông Phước', 'Xã Đông Phước', 'Xã Đông Phước, Thành phố Cần Thơ', '13071', 'xa', '15'),
(588, 'Phú Hữu', 'Xã Phú Hữu', 'Xã Phú Hữu, Thành phố Cần Thơ', '13327', 'xa', '15'),
(589, 'Đại Thành', 'Phường Đại Thành', 'Phường Đại Thành, Thành phố Cần Thơ', '13583', 'phuong', '15'),
(590, 'Ngã Bảy', 'Phường Ngã Bảy', 'Phường Ngã Bảy, Thành phố Cần Thơ', '13839', 'phuong', '15'),
(591, 'Tân Bình', 'Xã Tân Bình', 'Xã Tân Bình, Thành phố Cần Thơ', '14095', 'xa', '15'),
(592, 'Hòa An', 'Xã Hòa An', 'Xã Hòa An, Thành phố Cần Thơ', '14351', 'xa', '15'),
(593, 'Phương Bình', 'Xã Phương Bình', 'Xã Phương Bình, Thành phố Cần Thơ', '14607', 'xa', '15'),
(594, 'Tân Phước Hưng', 'Xã Tân Phước Hưng', 'Xã Tân Phước Hưng, Thành phố Cần Thơ', '14863', 'xa', '15'),
(595, 'Hiệp Hưng', 'Xã Hiệp Hưng', 'Xã Hiệp Hưng, Thành phố Cần Thơ', '15119', 'xa', '15'),
(596, 'Phụng Hiệp', 'Xã Phụng Hiệp', 'Xã Phụng Hiệp, Thành phố Cần Thơ', '15375', 'xa', '15'),
(597, 'Thạnh Hòa', 'Xã Thạnh Hòa', 'Xã Thạnh Hòa, Thành phố Cần Thơ', '15631', 'xa', '15'),
(598, 'Bình Thủy', 'Phường Bình Thủy', 'Phường Bình Thủy, Thành phố Cần Thơ', '15887', 'phuong', '15'),
(599, 'Thốt Nốt', 'Phường Thốt Nốt', 'Phường Thốt Nốt, Thành phố Cần Thơ', '16143', 'phuong', '15'),
(600, 'Thuận Hưng', 'Phường Thuận Hưng', 'Phường Thuận Hưng, Thành phố Cần Thơ', '16399', 'phuong', '15'),
(601, 'Phú Tâm', 'Xã Phú Tâm', 'Xã Phú Tâm, Thành phố Cần Thơ', '16655', 'xa', '15'),
(602, 'An Ninh', 'Xã An Ninh', 'Xã An Ninh, Thành phố Cần Thơ', '16911', 'xa', '15'),
(603, 'Thuận Hòa', 'Xã Thuận Hòa', 'Xã Thuận Hòa, Thành phố Cần Thơ', '17167', 'xa', '15'),
(604, 'Hồ Đắc Kiện', 'Xã Hồ Đắc Kiện', 'Xã Hồ Đắc Kiện, Thành phố Cần Thơ', '17423', 'xa', '15'),
(605, 'Mỹ Tú', 'Xã Mỹ Tú', 'Xã Mỹ Tú, Thành phố Cần Thơ', '17679', 'xa', '15'),
(606, 'Long Hưng', 'Xã Long Hưng', 'Xã Long Hưng, Thành phố Cần Thơ', '17935', 'xa', '15'),
(607, 'Mỹ Hương', 'Xã Mỹ Hương', 'Xã Mỹ Hương, Thành phố Cần Thơ', '18191', 'xa', '15'),
(608, 'Vĩnh Phước', 'Phường Vĩnh Phước', 'Phường Vĩnh Phước, Thành phố Cần Thơ', '18447', 'phuong', '15'),
(609, 'Vĩnh Châu', 'Phường Vĩnh Châu', 'Phường Vĩnh Châu, Thành phố Cần Thơ', '18703', 'phuong', '15'),
(610, 'Khánh Hòa', 'Phường Khánh Hòa', 'Phường Khánh Hòa, Thành phố Cần Thơ', '18959', 'phuong', '15'),
(611, 'Ngã Năm', 'Phường Ngã Năm', 'Phường Ngã Năm, Thành phố Cần Thơ', '19215', 'phuong', '15'),
(612, 'Mỹ Quới', 'Phường Mỹ Quới', 'Phường Mỹ Quới, Thành phố Cần Thơ', '19471', 'phuong', '15'),
(613, 'Tân Long', 'Xã Tân Long', 'Xã Tân Long, Thành phố Cần Thơ', '19727', 'xa', '15'),
(614, 'Phú Lộc', 'Xã Phú Lộc', 'Xã Phú Lộc, Thành phố Cần Thơ', '19983', 'xa', '15'),
(615, 'Vĩnh Lợi', 'Xã Vĩnh Lợi', 'Xã Vĩnh Lợi, Thành phố Cần Thơ', '20239', 'xa', '15'),
(616, 'Lâm Tân', 'Xã Lâm Tân', 'Xã Lâm Tân, Thành phố Cần Thơ', '20495', 'xa', '15'),
(617, 'Thạnh Thới An', 'Xã Thạnh Thới An', 'Xã Thạnh Thới An, Thành phố Cần Thơ', '20751', 'xa', '15'),
(618, 'Tài Văn', 'Xã Tài Văn', 'Xã Tài Văn, Thành phố Cần Thơ', '21007', 'xa', '15'),
(619, 'Liêu Tú', 'Xã Liêu Tú', 'Xã Liêu Tú, Thành phố Cần Thơ', '21263', 'xa', '15'),
(620, 'Lịch Hội Thượng', 'Xã Lịch Hội Thượng', 'Xã Lịch Hội Thượng, Thành phố Cần Thơ', '21519', 'xa', '15'),
(621, 'Trần Đề', 'Xã Trần Đề', 'Xã Trần Đề, Thành phố Cần Thơ', '21775', 'xa', '15'),
(622, 'An Thạnh', 'Xã An Thạnh', 'Xã An Thạnh, Thành phố Cần Thơ', '22031', 'xa', '15'),
(623, 'Cù Lao Dung', 'Xã Cù Lao Dung', 'Xã Cù Lao Dung, Thành phố Cần Thơ', '22287', 'xa', '15'),
(624, 'Đại Ngãi', 'Xã Đại Ngãi', 'Xã Đại Ngãi, Thành phố Cần Thơ', '22543', 'xa', '15'),
(625, 'Tân Thạnh', 'Xã Tân Thạnh', 'Xã Tân Thạnh, Thành phố Cần Thơ', '22799', 'xa', '15'),
(626, 'Long Phú', 'Xã Long Phú', 'Xã Long Phú, Thành phố Cần Thơ', '23055', 'xa', '15'),
(627, 'Nhơn Mỹ', 'Xã Nhơn Mỹ', 'Xã Nhơn Mỹ, Thành phố Cần Thơ', '23311', 'xa', '15'),
(628, 'Phú Lợi', 'Phường Phú Lợi', 'Phường Phú Lợi, Thành phố Cần Thơ', '23567', 'phuong', '15'),
(629, 'Sóc Trăng', 'Phường Sóc Trăng', 'Phường Sóc Trăng, Thành phố Cần Thơ', '23823', 'phuong', '15'),
(630, 'Mỹ Xuyên', 'Phường Mỹ Xuyên', 'Phường Mỹ Xuyên, Thành phố Cần Thơ', '24079', 'phuong', '15'),
(631, 'Hòa Tú', 'Xã Hòa Tú', 'Xã Hòa Tú, Thành phố Cần Thơ', '24335', 'xa', '15'),
(632, 'Gia Hòa', 'Xã Gia Hòa', 'Xã Gia Hòa, Thành phố Cần Thơ', '24591', 'xa', '15'),
(633, 'Nhu Gia', 'Xã Nhu Gia', 'Xã Nhu Gia, Thành phố Cần Thơ', '24847', 'xa', '15'),
(634, 'Ngọc Tố', 'Xã Ngọc Tố', 'Xã Ngọc Tố, Thành phố Cần Thơ', '25103', 'xa', '15'),
(635, 'Trường Khánh', 'Xã Trường Khánh', 'Xã Trường Khánh, Thành phố Cần Thơ', '25359', 'xa', '15'),
(636, 'An Lạc Thôn', 'Xã An Lạc Thôn', 'Xã An Lạc Thôn, Thành phố Cần Thơ', '25615', 'xa', '15'),
(637, 'Kế Sách', 'Xã Kế Sách', 'Xã Kế Sách, Thành phố Cần Thơ', '25871', 'xa', '15'),
(638, 'Thới An Hội', 'Xã Thới An Hội', 'Xã Thới An Hội, Thành phố Cần Thơ', '26127', 'xa', '15'),
(639, 'Đại Hải', 'Xã Đại Hải', 'Xã Đại Hải, Thành phố Cần Thơ', '26383', 'xa', '15'),
(640, 'Dương Nỗ', 'Phường Dương Nỗ', 'Phường Dương Nỗ, Thành phố Huế', '272', 'phuong', '16'),
(641, 'Phong Điền', 'Phường Phong Điền', 'Phường Phong Điền, Thành phố Huế', '528', 'phuong', '16'),
(642, 'Phong Thái', 'Phường Phong Thái', 'Phường Phong Thái, Thành phố Huế', '784', 'phuong', '16'),
(643, 'Phong Dinh', 'Phường Phong Dinh', 'Phường Phong Dinh, Thành phố Huế', '1040', 'phuong', '16'),
(644, 'Phong Phú', 'Phường Phong Phú', 'Phường Phong Phú, Thành phố Huế', '1296', 'phuong', '16'),
(645, 'Phong Quảng', 'Phường Phong Quảng', 'Phường Phong Quảng, Thành phố Huế', '1552', 'phuong', '16'),
(646, 'Đan Điền', 'Xã Đan Điền', 'Xã Đan Điền, Thành phố Huế', '1808', 'xa', '16'),
(647, 'Quảng Điền', 'Xã Quảng Điền', 'Xã Quảng Điền, Thành phố Huế', '2064', 'xa', '16'),
(648, 'Hương Trà', 'Phường Hương Trà', 'Phường Hương Trà, Thành phố Huế', '2320', 'phuong', '16'),
(649, 'Kim Trà', 'Phường Kim Trà', 'Phường Kim Trà, Thành phố Huế', '2576', 'phuong', '16'),
(650, 'Bình Điền', 'Xã Bình Điền', 'Xã Bình Điền, Thành phố Huế', '2832', 'xa', '16'),
(651, 'Kim Long', 'Phường Kim Long', 'Phường Kim Long, Thành phố Huế', '3088', 'phuong', '16'),
(652, 'Hương An', 'Phường Hương An', 'Phường Hương An, Thành phố Huế', '3344', 'phuong', '16'),
(653, 'Phú Xuân', 'Phường Phú Xuân', 'Phường Phú Xuân, Thành phố Huế', '3600', 'phuong', '16'),
(654, 'Thuận An', 'Phường Thuận An', 'Phường Thuận An, Thành phố Huế', '3856', 'phuong', '16'),
(655, 'Hóa Châu', 'Phường Hóa Châu', 'Phường Hóa Châu, Thành phố Huế', '4112', 'phuong', '16'),
(656, 'Mỹ Thượng', 'Phường Mỹ Thượng', 'Phường Mỹ Thượng, Thành phố Huế', '4368', 'phuong', '16'),
(657, 'Vỹ Dạ', 'Phường Vỹ Dạ', 'Phường Vỹ Dạ, Thành phố Huế', '4624', 'phuong', '16'),
(658, 'Thuận Hóa', 'Phường Thuận Hóa', 'Phường Thuận Hóa, Thành phố Huế', '4880', 'phuong', '16'),
(659, 'An Cựu', 'Phường An Cựu', 'Phường An Cựu, Thành phố Huế', '5136', 'phuong', '16'),
(660, 'Thủy Xuân', 'Phường Thủy Xuân', 'Phường Thủy Xuân, Thành phố Huế', '5392', 'phuong', '16'),
(661, 'Phú Vinh', 'Xã Phú Vinh', 'Xã Phú Vinh, Thành phố Huế', '5648', 'xa', '16'),
(662, 'Phú Hồ', 'Xã Phú Hồ', 'Xã Phú Hồ, Thành phố Huế', '5904', 'xa', '16'),
(663, 'Phú Vang', 'Xã Phú Vang', 'Xã Phú Vang, Thành phố Huế', '6160', 'xa', '16'),
(664, 'Thanh Thủy', 'Phường Thanh Thủy', 'Phường Thanh Thủy, Thành phố Huế', '6416', 'phuong', '16'),
(665, 'Hương Thủy', 'Phường Hương Thủy', 'Phường Hương Thủy, Thành phố Huế', '6672', 'phuong', '16'),
(666, 'Phú Bài', 'Phường Phú Bài', 'Phường Phú Bài, Thành phố Huế', '6928', 'phuong', '16'),
(667, 'Vinh Lộc', 'Xã Vinh Lộc', 'Xã Vinh Lộc, Thành phố Huế', '7184', 'xa', '16'),
(668, 'Hưng Lộc', 'Xã Hưng Lộc', 'Xã Hưng Lộc, Thành phố Huế', '7440', 'xa', '16'),
(669, 'Lộc An', 'Xã Lộc An', 'Xã Lộc An, Thành phố Huế', '7696', 'xa', '16'),
(670, 'Phú Lộc', 'Xã Phú Lộc', 'Xã Phú Lộc, Thành phố Huế', '7952', 'xa', '16'),
(671, 'Chân Mây-Lăng Cô', 'Xã Chân Mây-Lăng Cô', 'Xã Chân Mây-Lăng Cô, Thành phố Huế', '8208', 'xa', '16'),
(672, 'Long Quảng', 'Xã Long Quảng', 'Xã Long Quảng, Thành phố Huế', '8464', 'xa', '16'),
(673, 'Nam Đông', 'Xã Nam Đông', 'Xã Nam Đông, Thành phố Huế', '8720', 'xa', '16'),
(674, 'Khe Tre', 'Xã Khe Tre', 'Xã Khe Tre, Thành phố Huế', '8976', 'xa', '16'),
(675, 'A Lưới 1', 'Xã A Lưới 1', 'Xã A Lưới 1, Thành phố Huế', '9232', 'xa', '16'),
(676, 'A Lưới 2', 'Xã A Lưới 2', 'Xã A Lưới 2, Thành phố Huế', '9488', 'xa', '16'),
(677, 'A Lưới 3', 'Xã A Lưới 3', 'Xã A Lưới 3, Thành phố Huế', '9744', 'xa', '16'),
(678, 'A Lưới 4', 'Xã A Lưới 4', 'Xã A Lưới 4, Thành phố Huế', '10000', 'xa', '16'),
(679, 'A Lưới 5', 'Xã A Lưới 5', 'Xã A Lưới 5, Thành phố Huế', '10256', 'xa', '16'),
(680, 'Hòn Nghệ', 'Xã Hòn Nghệ', 'Xã Hòn Nghệ, Tỉnh An Giang', '273', 'xa', '17'),
(681, 'Sơn Hải', 'Xã Sơn Hải', 'Xã Sơn Hải, Tỉnh An Giang', '529', 'xa', '17'),
(682, 'Hòa Điền', 'Xã Hòa Điền', 'Xã Hòa Điền, Tỉnh An Giang', '785', 'xa', '17'),
(683, 'Vĩnh Thông', 'Phường Vĩnh Thông', 'Phường Vĩnh Thông, Tỉnh An Giang', '1041', 'phuong', '17'),
(684, 'Vĩnh Tế', 'Phường Vĩnh Tế', 'Phường Vĩnh Tế, Tỉnh An Giang', '1297', 'phuong', '17'),
(685, 'Châu Đốc', 'Phường Châu Đốc', 'Phường Châu Đốc, Tỉnh An Giang', '1553', 'phuong', '17'),
(686, 'An Phú', 'Xã An Phú', 'Xã An Phú, Tỉnh An Giang', '1809', 'xa', '17'),
(687, 'Bình Giang', 'Xã Bình Giang', 'Xã Bình Giang, Tỉnh An Giang', '2065', 'xa', '17'),
(688, 'Bình Sơn', 'Xã Bình Sơn', 'Xã Bình Sơn, Tỉnh An Giang', '2321', 'xa', '17'),
(689, 'Mỹ Hòa Hưng', 'Xã Mỹ Hòa Hưng', 'Xã Mỹ Hòa Hưng, Tỉnh An Giang', '2577', 'xa', '17'),
(690, 'Nhơn Hội', 'Xã Nhơn Hội', 'Xã Nhơn Hội, Tỉnh An Giang', '2833', 'xa', '17'),
(691, 'Phú Hữu', 'Xã Phú Hữu', 'Xã Phú Hữu, Tỉnh An Giang', '3089', 'xa', '17'),
(692, 'Tiên Hải', 'Xã Tiên Hải', 'Xã Tiên Hải, Tỉnh An Giang', '3345', 'xa', '17'),
(693, 'Long Xuyên', 'Phường Long Xuyên', 'Phường Long Xuyên, Tỉnh An Giang', '3601', 'phuong', '17'),
(694, 'Bình Đức', 'Phường Bình Đức', 'Phường Bình Đức, Tỉnh An Giang', '3857', 'phuong', '17'),
(695, 'Mỹ Thới', 'Phường Mỹ Thới', 'Phường Mỹ Thới, Tỉnh An Giang', '4113', 'phuong', '17'),
(696, 'Vĩnh Hậu', 'Xã Vĩnh Hậu', 'Xã Vĩnh Hậu, Tỉnh An Giang', '4369', 'xa', '17'),
(697, 'Khánh Bình', 'Xã Khánh Bình', 'Xã Khánh Bình, Tỉnh An Giang', '4625', 'xa', '17'),
(698, 'Tân Châu', 'Phường Tân Châu', 'Phường Tân Châu, Tỉnh An Giang', '4881', 'phuong', '17'),
(699, 'Long Phú', 'Phường Long Phú', 'Phường Long Phú, Tỉnh An Giang', '5137', 'phuong', '17'),
(700, 'Tân An', 'Xã Tân An', 'Xã Tân An, Tỉnh An Giang', '5393', 'xa', '17'),
(701, 'Châu Phong', 'Xã Châu Phong', 'Xã Châu Phong, Tỉnh An Giang', '5649', 'xa', '17'),
(702, 'Vĩnh Xương', 'Xã Vĩnh Xương', 'Xã Vĩnh Xương, Tỉnh An Giang', '5905', 'xa', '17'),
(703, 'Phú Tân', 'Xã Phú Tân', 'Xã Phú Tân, Tỉnh An Giang', '6161', 'xa', '17'),
(704, 'Phú An', 'Xã Phú An', 'Xã Phú An, Tỉnh An Giang', '6417', 'xa', '17'),
(705, 'Bình Thạnh Đông', 'Xã Bình Thạnh Đông', 'Xã Bình Thạnh Đông, Tỉnh An Giang', '6673', 'xa', '17'),
(706, 'Chợ Vàm', 'Xã Chợ Vàm', 'Xã Chợ Vàm, Tỉnh An Giang', '6929', 'xa', '17'),
(707, 'Hòa Lạc', 'Xã Hòa Lạc', 'Xã Hòa Lạc, Tỉnh An Giang', '7185', 'xa', '17'),
(708, 'Phú Lâm', 'Xã Phú Lâm', 'Xã Phú Lâm, Tỉnh An Giang', '7441', 'xa', '17'),
(709, 'Mỹ Đức', 'Xã Mỹ Đức', 'Xã Mỹ Đức, Tỉnh An Giang', '7697', 'xa', '17'),
(710, 'Vĩnh Thạnh Trung', 'Xã Vĩnh Thạnh Trung', 'Xã Vĩnh Thạnh Trung, Tỉnh An Giang', '7953', 'xa', '17'),
(711, 'Châu Phú', 'Xã Châu Phú', 'Xã Châu Phú, Tỉnh An Giang', '8209', 'xa', '17'),
(712, 'Bình Mỹ', 'Xã Bình Mỹ', 'Xã Bình Mỹ, Tỉnh An Giang', '8465', 'xa', '17'),
(713, 'Thạnh Mỹ Tây', 'Xã Thạnh Mỹ Tây', 'Xã Thạnh Mỹ Tây, Tỉnh An Giang', '8721', 'xa', '17'),
(714, 'Thới Sơn', 'Phường Thới Sơn', 'Phường Thới Sơn, Tỉnh An Giang', '8977', 'phuong', '17'),
(715, 'Tịnh Biên', 'Phường Tịnh Biên', 'Phường Tịnh Biên, Tỉnh An Giang', '9233', 'phuong', '17'),
(716, 'An Cư', 'Xã An Cư', 'Xã An Cư, Tỉnh An Giang', '9489', 'xa', '17'),
(717, 'Chi Lăng', 'Phường Chi Lăng', 'Phường Chi Lăng, Tỉnh An Giang', '9745', 'phuong', '17'),
(718, 'Núi Cấm', 'Xã Núi Cấm', 'Xã Núi Cấm, Tỉnh An Giang', '10001', 'xa', '17'),
(719, 'Ba Chúc', 'Xã Ba Chúc', 'Xã Ba Chúc, Tỉnh An Giang', '10257', 'xa', '17'),
(720, 'Tri Tôn', 'Xã Tri Tôn', 'Xã Tri Tôn, Tỉnh An Giang', '10513', 'xa', '17'),
(721, 'Ô Lâm', 'Xã Ô Lâm', 'Xã Ô Lâm, Tỉnh An Giang', '10769', 'xa', '17'),
(722, 'Cô Tô', 'Xã Cô Tô', 'Xã Cô Tô, Tỉnh An Giang', '11025', 'xa', '17'),
(723, 'Vĩnh Gia', 'Xã Vĩnh Gia', 'Xã Vĩnh Gia, Tỉnh An Giang', '11281', 'xa', '17'),
(724, 'An Châu', 'Xã An Châu', 'Xã An Châu, Tỉnh An Giang', '11537', 'xa', '17'),
(725, 'Bình Hòa', 'Xã Bình Hòa', 'Xã Bình Hòa, Tỉnh An Giang', '11793', 'xa', '17'),
(726, 'Cần Đăng', 'Xã Cần Đăng', 'Xã Cần Đăng, Tỉnh An Giang', '12049', 'xa', '17'),
(727, 'Vĩnh Hanh', 'Xã Vĩnh Hanh', 'Xã Vĩnh Hanh, Tỉnh An Giang', '12305', 'xa', '17'),
(728, 'Vĩnh An', 'Xã Vĩnh An', 'Xã Vĩnh An, Tỉnh An Giang', '12561', 'xa', '17'),
(729, 'Cù Lao Giêng', 'Xã Cù Lao Giêng', 'Xã Cù Lao Giêng, Tỉnh An Giang', '12817', 'xa', '17'),
(730, 'Hội An', 'Xã Hội An', 'Xã Hội An, Tỉnh An Giang', '13073', 'xa', '17'),
(731, 'Long Điền', 'Xã Long Điền', 'Xã Long Điền, Tỉnh An Giang', '13329', 'xa', '17'),
(732, 'Chợ Mới', 'Xã Chợ Mới', 'Xã Chợ Mới, Tỉnh An Giang', '13585', 'xa', '17'),
(733, 'Nhơn Mỹ', 'Xã Nhơn Mỹ', 'Xã Nhơn Mỹ, Tỉnh An Giang', '13841', 'xa', '17'),
(734, 'Long Kiến', 'Xã Long Kiến', 'Xã Long Kiến, Tỉnh An Giang', '14097', 'xa', '17'),
(735, 'Thoại Sơn', 'Xã Thoại Sơn', 'Xã Thoại Sơn, Tỉnh An Giang', '14353', 'xa', '17'),
(736, 'Óc Eo', 'Xã Óc Eo', 'Xã Óc Eo, Tỉnh An Giang', '14609', 'xa', '17'),
(737, 'Định Mỹ', 'Xã Định Mỹ', 'Xã Định Mỹ, Tỉnh An Giang', '14865', 'xa', '17'),
(738, 'Phú Hòa', 'Xã Phú Hòa', 'Xã Phú Hòa, Tỉnh An Giang', '15121', 'xa', '17'),
(739, 'Vĩnh Trạch', 'Xã Vĩnh Trạch', 'Xã Vĩnh Trạch, Tỉnh An Giang', '15377', 'xa', '17'),
(740, 'Tây Phú', 'Xã Tây Phú', 'Xã Tây Phú, Tỉnh An Giang', '15633', 'xa', '17'),
(741, 'Đặc Khu Thổ Châu', 'Xã Đặc Khu Thổ Châu', 'Xã Đặc Khu Thổ Châu, Tỉnh An Giang', '15889', 'xa', '17'),
(742, 'Rạch Giá', 'Phường Rạch Giá', 'Phường Rạch Giá, Tỉnh An Giang', '16145', 'phuong', '17'),
(743, 'Hà Tiên', 'Phường Hà Tiên', 'Phường Hà Tiên, Tỉnh An Giang', '16401', 'phuong', '17'),
(744, 'Tô Châu', 'Phường Tô Châu', 'Phường Tô Châu, Tỉnh An Giang', '16657', 'phuong', '17'),
(745, 'Giang Thành', 'Xã Giang Thành', 'Xã Giang Thành, Tỉnh An Giang', '16913', 'xa', '17'),
(746, 'Vĩnh Điều', 'Xã Vĩnh Điều', 'Xã Vĩnh Điều, Tỉnh An Giang', '17169', 'xa', '17'),
(747, 'Hòn Đất', 'Xã Hòn Đất', 'Xã Hòn Đất, Tỉnh An Giang', '17425', 'xa', '17'),
(748, 'Sơn Kiên', 'Xã Sơn Kiên', 'Xã Sơn Kiên, Tỉnh An Giang', '17681', 'xa', '17'),
(749, 'Mỹ Thuận', 'Xã Mỹ Thuận', 'Xã Mỹ Thuận, Tỉnh An Giang', '17937', 'xa', '17'),
(750, 'Thạnh Lộc', 'Xã Thạnh Lộc', 'Xã Thạnh Lộc, Tỉnh An Giang', '18193', 'xa', '17'),
(751, 'Châu Thành', 'Xã Châu Thành', 'Xã Châu Thành, Tỉnh An Giang', '18449', 'xa', '17'),
(752, 'Bình An', 'Xã Bình An', 'Xã Bình An, Tỉnh An Giang', '18705', 'xa', '17'),
(753, 'Tân Hội', 'Xã Tân Hội', 'Xã Tân Hội, Tỉnh An Giang', '18961', 'xa', '17'),
(754, 'Tân Hiệp', 'Xã Tân Hiệp', 'Xã Tân Hiệp, Tỉnh An Giang', '19217', 'xa', '17'),
(755, 'Thạnh Đông', 'Xã Thạnh Đông', 'Xã Thạnh Đông, Tỉnh An Giang', '19473', 'xa', '17'),
(756, 'Giồng Riềng', 'Xã Giồng Riềng', 'Xã Giồng Riềng, Tỉnh An Giang', '19729', 'xa', '17'),
(757, 'Thạnh Hưng', 'Xã Thạnh Hưng', 'Xã Thạnh Hưng, Tỉnh An Giang', '19985', 'xa', '17'),
(758, 'Long Thạnh', 'Xã Long Thạnh', 'Xã Long Thạnh, Tỉnh An Giang', '20241', 'xa', '17'),
(759, 'Hòa Hưng', 'Xã Hòa Hưng', 'Xã Hòa Hưng, Tỉnh An Giang', '20497', 'xa', '17'),
(760, 'Ngọc Chúc', 'Xã Ngọc Chúc', 'Xã Ngọc Chúc, Tỉnh An Giang', '20753', 'xa', '17'),
(761, 'Hòa Thuận', 'Xã Hòa Thuận', 'Xã Hòa Thuận, Tỉnh An Giang', '21009', 'xa', '17'),
(762, 'Định Hòa', 'Xã Định Hòa', 'Xã Định Hòa, Tỉnh An Giang', '21265', 'xa', '17'),
(763, 'Gò Quao', 'Xã Gò Quao', 'Xã Gò Quao, Tỉnh An Giang', '21521', 'xa', '17'),
(764, 'Vĩnh Hòa Hưng', 'Xã Vĩnh Hòa Hưng', 'Xã Vĩnh Hòa Hưng, Tỉnh An Giang', '21777', 'xa', '17'),
(765, 'Vĩnh Tuy', 'Xã Vĩnh Tuy', 'Xã Vĩnh Tuy, Tỉnh An Giang', '22033', 'xa', '17'),
(766, 'Tây Yên', 'Xã Tây Yên', 'Xã Tây Yên, Tỉnh An Giang', '22289', 'xa', '17'),
(767, 'Đông Thái', 'Xã Đông Thái', 'Xã Đông Thái, Tỉnh An Giang', '22545', 'xa', '17'),
(768, 'An Biên', 'Xã An Biên', 'Xã An Biên, Tỉnh An Giang', '22801', 'xa', '17'),
(769, 'Đông Hòa', 'Xã Đông Hòa', 'Xã Đông Hòa, Tỉnh An Giang', '23057', 'xa', '17'),
(770, 'Tân Thạnh', 'Xã Tân Thạnh', 'Xã Tân Thạnh, Tỉnh An Giang', '23313', 'xa', '17'),
(771, 'Đông Hưng', 'Xã Đông Hưng', 'Xã Đông Hưng, Tỉnh An Giang', '23569', 'xa', '17'),
(772, 'An Minh', 'Xã An Minh', 'Xã An Minh, Tỉnh An Giang', '23825', 'xa', '17'),
(773, 'Vân Khánh', 'Xã Vân Khánh', 'Xã Vân Khánh, Tỉnh An Giang', '24081', 'xa', '17'),
(774, 'Vĩnh Hòa', 'Xã Vĩnh Hòa', 'Xã Vĩnh Hòa, Tỉnh An Giang', '24337', 'xa', '17'),
(775, 'U Minh Thượng', 'Xã U Minh Thượng', 'Xã U Minh Thượng, Tỉnh An Giang', '24593', 'xa', '17'),
(776, 'Vĩnh Bình', 'Xã Vĩnh Bình', 'Xã Vĩnh Bình, Tỉnh An Giang', '24849', 'xa', '17'),
(777, 'Vĩnh Thuận', 'Xã Vĩnh Thuận', 'Xã Vĩnh Thuận, Tỉnh An Giang', '25105', 'xa', '17'),
(778, 'Vĩnh Phong', 'Xã Vĩnh Phong', 'Xã Vĩnh Phong, Tỉnh An Giang', '25361', 'xa', '17'),
(779, 'An Lão', 'Xã An Lão', 'Xã An Lão, Tỉnh Gia Lai', '34329', 'xa', '25'),
(780, 'Đặc Khu Phú Quốc', 'Xã Đặc Khu Phú Quốc', 'Xã Đặc Khu Phú Quốc, Tỉnh An Giang', '25617', 'xa', '17'),
(781, 'Đặc Khu Kiên Hải', 'Xã Đặc Khu Kiên Hải', 'Xã Đặc Khu Kiên Hải, Tỉnh An Giang', '25873', 'xa', '17'),
(782, 'Kiên Lương', 'Xã Kiên Lương', 'Xã Kiên Lương, Tỉnh An Giang', '26129', 'xa', '17'),
(783, 'Sa Lý', 'Xã Sa Lý', 'Xã Sa Lý, Tỉnh Bắc Ninh', '274', 'xa', '18'),
(784, 'Biên Sơn', 'Xã Biên Sơn', 'Xã Biên Sơn, Tỉnh Bắc Ninh', '530', 'xa', '18'),
(785, 'Tuấn Đạo', 'Xã Tuấn Đạo', 'Xã Tuấn Đạo, Tỉnh Bắc Ninh', '786', 'xa', '18'),
(786, 'Kinh Bắc', 'Phường Kinh Bắc', 'Phường Kinh Bắc, Tỉnh Bắc Ninh', '1042', 'phuong', '18'),
(787, 'Võ Cường', 'Phường Võ Cường', 'Phường Võ Cường, Tỉnh Bắc Ninh', '1298', 'phuong', '18'),
(788, 'Vũ Ninh', 'Phường Vũ Ninh', 'Phường Vũ Ninh, Tỉnh Bắc Ninh', '1554', 'phuong', '18'),
(789, 'Hạp Lĩnh', 'Phường Hạp Lĩnh', 'Phường Hạp Lĩnh, Tỉnh Bắc Ninh', '1810', 'phuong', '18'),
(790, 'Nam Sơn', 'Phường Nam Sơn', 'Phường Nam Sơn, Tỉnh Bắc Ninh', '2066', 'phuong', '18'),
(791, 'Từ Sơn', 'Phường Từ Sơn', 'Phường Từ Sơn, Tỉnh Bắc Ninh', '2322', 'phuong', '18'),
(792, 'Tam Sơn', 'Phường Tam Sơn', 'Phường Tam Sơn, Tỉnh Bắc Ninh', '2578', 'phuong', '18'),
(793, 'Đồng Nguyên', 'Phường Đồng Nguyên', 'Phường Đồng Nguyên, Tỉnh Bắc Ninh', '2834', 'phuong', '18'),
(794, 'Phù Khê', 'Phường Phù Khê', 'Phường Phù Khê, Tỉnh Bắc Ninh', '3090', 'phuong', '18'),
(795, 'Thuận Thành', 'Phường Thuận Thành', 'Phường Thuận Thành, Tỉnh Bắc Ninh', '3346', 'phuong', '18'),
(796, 'Mão Điền', 'Phường Mão Điền', 'Phường Mão Điền, Tỉnh Bắc Ninh', '3602', 'phuong', '18'),
(797, 'Trạm Lộ', 'Phường Trạm Lộ', 'Phường Trạm Lộ, Tỉnh Bắc Ninh', '3858', 'phuong', '18'),
(798, 'Trí Quả', 'Phường Trí Quả', 'Phường Trí Quả, Tỉnh Bắc Ninh', '4114', 'phuong', '18'),
(799, 'Song Liễu', 'Phường Song Liễu', 'Phường Song Liễu, Tỉnh Bắc Ninh', '4370', 'phuong', '18'),
(800, 'Ninh Xá', 'Phường Ninh Xá', 'Phường Ninh Xá, Tỉnh Bắc Ninh', '4626', 'phuong', '18'),
(801, 'Quế Võ', 'Phường Quế Võ', 'Phường Quế Võ, Tỉnh Bắc Ninh', '4882', 'phuong', '18'),
(802, 'Phương Liễu', 'Phường Phương Liễu', 'Phường Phương Liễu, Tỉnh Bắc Ninh', '5138', 'phuong', '18'),
(803, 'Nhân Hòa', 'Phường Nhân Hòa', 'Phường Nhân Hòa, Tỉnh Bắc Ninh', '5394', 'phuong', '18'),
(804, 'Đào Viên', 'Phường Đào Viên', 'Phường Đào Viên, Tỉnh Bắc Ninh', '5650', 'phuong', '18'),
(805, 'Bồng Lai', 'Phường Bồng Lai', 'Phường Bồng Lai, Tỉnh Bắc Ninh', '5906', 'phuong', '18'),
(806, 'Chi Lăng', 'Xã Chi Lăng', 'Xã Chi Lăng, Tỉnh Bắc Ninh', '6162', 'xa', '18'),
(807, 'Phù Lãng', 'Xã Phù Lãng', 'Xã Phù Lãng, Tỉnh Bắc Ninh', '6418', 'xa', '18'),
(808, 'Yên Phong', 'Xã Yên Phong', 'Xã Yên Phong, Tỉnh Bắc Ninh', '6674', 'xa', '18'),
(809, 'Văn Môn', 'Xã Văn Môn', 'Xã Văn Môn, Tỉnh Bắc Ninh', '6930', 'xa', '18'),
(810, 'Tam Giang', 'Xã Tam Giang', 'Xã Tam Giang, Tỉnh Bắc Ninh', '7186', 'xa', '18'),
(811, 'Yên Trung', 'Xã Yên Trung', 'Xã Yên Trung, Tỉnh Bắc Ninh', '7442', 'xa', '18'),
(812, 'Tam Đa', 'Xã Tam Đa', 'Xã Tam Đa, Tỉnh Bắc Ninh', '7698', 'xa', '18'),
(813, 'Tiên Du', 'Xã Tiên Du', 'Xã Tiên Du, Tỉnh Bắc Ninh', '7954', 'xa', '18'),
(814, 'Liên Bão', 'Xã Liên Bão', 'Xã Liên Bão, Tỉnh Bắc Ninh', '8210', 'xa', '18'),
(815, 'Tân Chi', 'Xã Tân Chi', 'Xã Tân Chi, Tỉnh Bắc Ninh', '8466', 'xa', '18'),
(816, 'Đại Đồng', 'Xã Đại Đồng', 'Xã Đại Đồng, Tỉnh Bắc Ninh', '8722', 'xa', '18'),
(817, 'Phật Tích', 'Xã Phật Tích', 'Xã Phật Tích, Tỉnh Bắc Ninh', '8978', 'xa', '18'),
(818, 'Gia Bình', 'Xã Gia Bình', 'Xã Gia Bình, Tỉnh Bắc Ninh', '9234', 'xa', '18'),
(819, 'Nhân Thắng', 'Xã Nhân Thắng', 'Xã Nhân Thắng, Tỉnh Bắc Ninh', '9490', 'xa', '18'),
(820, 'Đại Lai', 'Xã Đại Lai', 'Xã Đại Lai, Tỉnh Bắc Ninh', '9746', 'xa', '18'),
(821, 'Cao Đức', 'Xã Cao Đức', 'Xã Cao Đức, Tỉnh Bắc Ninh', '10002', 'xa', '18'),
(822, 'Đông Cứu', 'Xã Đông Cứu', 'Xã Đông Cứu, Tỉnh Bắc Ninh', '10258', 'xa', '18'),
(823, 'Lương Tài', 'Xã Lương Tài', 'Xã Lương Tài, Tỉnh Bắc Ninh', '10514', 'xa', '18'),
(824, 'Lâm Thao', 'Xã Lâm Thao', 'Xã Lâm Thao, Tỉnh Bắc Ninh', '10770', 'xa', '18'),
(825, 'Trung Chính', 'Xã Trung Chính', 'Xã Trung Chính, Tỉnh Bắc Ninh', '11026', 'xa', '18'),
(826, 'Trung Kênh', 'Xã Trung Kênh', 'Xã Trung Kênh, Tỉnh Bắc Ninh', '11282', 'xa', '18'),
(827, 'Đồng Kỳ', 'Xã Đồng Kỳ', 'Xã Đồng Kỳ, Tỉnh Bắc Ninh', '11538', 'xa', '18'),
(828, 'Đại Sơn', 'Xã Đại Sơn', 'Xã Đại Sơn, Tỉnh Bắc Ninh', '11794', 'xa', '18'),
(829, 'Sơn Động', 'Xã Sơn Động', 'Xã Sơn Động, Tỉnh Bắc Ninh', '12050', 'xa', '18'),
(830, 'Tây Yên Tử', 'Xã Tây Yên Tử', 'Xã Tây Yên Tử, Tỉnh Bắc Ninh', '12306', 'xa', '18'),
(831, 'Dương Hưu', 'Xã Dương Hưu', 'Xã Dương Hưu, Tỉnh Bắc Ninh', '12562', 'xa', '18'),
(832, 'Yên Định', 'Xã Yên Định', 'Xã Yên Định, Tỉnh Bắc Ninh', '12818', 'xa', '18'),
(833, 'An Lạc', 'Xã An Lạc', 'Xã An Lạc, Tỉnh Bắc Ninh', '13074', 'xa', '18'),
(834, 'Vân Sơn', 'Xã Vân Sơn', 'Xã Vân Sơn, Tỉnh Bắc Ninh', '13330', 'xa', '18'),
(835, 'Biển Động', 'Xã Biển Động', 'Xã Biển Động, Tỉnh Bắc Ninh', '13586', 'xa', '18'),
(836, 'Lục Ngạn', 'Xã Lục Ngạn', 'Xã Lục Ngạn, Tỉnh Bắc Ninh', '13842', 'xa', '18'),
(837, 'Đèo Gia', 'Xã Đèo Gia', 'Xã Đèo Gia, Tỉnh Bắc Ninh', '14098', 'xa', '18'),
(838, 'Sơn Hải', 'Xã Sơn Hải', 'Xã Sơn Hải, Tỉnh Bắc Ninh', '14354', 'xa', '18'),
(839, 'Tân Sơn', 'Xã Tân Sơn', 'Xã Tân Sơn, Tỉnh Bắc Ninh', '14610', 'xa', '18'),
(840, 'Nam Dương', 'Xã Nam Dương', 'Xã Nam Dương, Tỉnh Bắc Ninh', '14866', 'xa', '18'),
(841, 'Kiên Lao', 'Xã Kiên Lao', 'Xã Kiên Lao, Tỉnh Bắc Ninh', '15122', 'xa', '18'),
(842, 'Chũ', 'Phường Chũ', 'Phường Chũ, Tỉnh Bắc Ninh', '15378', 'phuong', '18'),
(843, 'Phượng Sơn', 'Phường Phượng Sơn', 'Phường Phượng Sơn, Tỉnh Bắc Ninh', '15634', 'phuong', '18'),
(844, 'Lục Sơn', 'Xã Lục Sơn', 'Xã Lục Sơn, Tỉnh Bắc Ninh', '15890', 'xa', '18'),
(845, 'Trường Sơn', 'Xã Trường Sơn', 'Xã Trường Sơn, Tỉnh Bắc Ninh', '16146', 'xa', '18'),
(846, 'Cẩm Lý', 'Xã Cẩm Lý', 'Xã Cẩm Lý, Tỉnh Bắc Ninh', '16402', 'xa', '18'),
(847, 'Đông Phú', 'Xã Đông Phú', 'Xã Đông Phú, Tỉnh Bắc Ninh', '16658', 'xa', '18'),
(848, 'An Vinh', 'Xã An Vinh', 'Xã An Vinh, Tỉnh Gia Lai', '34585', 'xa', '25'),
(849, 'Nghĩa Phương', 'Xã Nghĩa Phương', 'Xã Nghĩa Phương, Tỉnh Bắc Ninh', '16914', 'xa', '18'),
(850, 'Lục Nam', 'Xã Lục Nam', 'Xã Lục Nam, Tỉnh Bắc Ninh', '17170', 'xa', '18'),
(851, 'Bắc Lũng', 'Xã Bắc Lũng', 'Xã Bắc Lũng, Tỉnh Bắc Ninh', '17426', 'xa', '18'),
(852, 'Bảo Đài', 'Xã Bảo Đài', 'Xã Bảo Đài, Tỉnh Bắc Ninh', '17682', 'xa', '18'),
(853, 'Lạng Giang', 'Xã Lạng Giang', 'Xã Lạng Giang, Tỉnh Bắc Ninh', '17938', 'xa', '18'),
(854, 'Mỹ Thái', 'Xã Mỹ Thái', 'Xã Mỹ Thái, Tỉnh Bắc Ninh', '18194', 'xa', '18'),
(855, 'Kép', 'Xã Kép', 'Xã Kép, Tỉnh Bắc Ninh', '18450', 'xa', '18'),
(856, 'Tân Dĩnh', 'Xã Tân Dĩnh', 'Xã Tân Dĩnh, Tỉnh Bắc Ninh', '18706', 'xa', '18'),
(857, 'Tiên Lục', 'Xã Tiên Lục', 'Xã Tiên Lục, Tỉnh Bắc Ninh', '18962', 'xa', '18'),
(858, 'Yên Thế', 'Xã Yên Thế', 'Xã Yên Thế, Tỉnh Bắc Ninh', '19218', 'xa', '18'),
(859, 'Bố Hạ', 'Xã Bố Hạ', 'Xã Bố Hạ, Tỉnh Bắc Ninh', '19474', 'xa', '18'),
(860, 'Xuân Lương', 'Xã Xuân Lương', 'Xã Xuân Lương, Tỉnh Bắc Ninh', '19730', 'xa', '18'),
(861, 'Tam Tiến', 'Xã Tam Tiến', 'Xã Tam Tiến, Tỉnh Bắc Ninh', '19986', 'xa', '18'),
(862, 'Tân Yên', 'Xã Tân Yên', 'Xã Tân Yên, Tỉnh Bắc Ninh', '20242', 'xa', '18'),
(863, 'Ngọc Thiện', 'Xã Ngọc Thiện', 'Xã Ngọc Thiện, Tỉnh Bắc Ninh', '20498', 'xa', '18'),
(864, 'Nhã Nam', 'Xã Nhã Nam', 'Xã Nhã Nam, Tỉnh Bắc Ninh', '20754', 'xa', '18'),
(865, 'Phúc Hòa', 'Xã Phúc Hòa', 'Xã Phúc Hòa, Tỉnh Bắc Ninh', '21010', 'xa', '18'),
(866, 'Quang Trung', 'Xã Quang Trung', 'Xã Quang Trung, Tỉnh Bắc Ninh', '21266', 'xa', '18'),
(867, 'Hợp Thịnh', 'Xã Hợp Thịnh', 'Xã Hợp Thịnh, Tỉnh Bắc Ninh', '21522', 'xa', '18'),
(868, 'Hiệp Hòa', 'Xã Hiệp Hòa', 'Xã Hiệp Hòa, Tỉnh Bắc Ninh', '21778', 'xa', '18'),
(869, 'Hoàng Vân', 'Xã Hoàng Vân', 'Xã Hoàng Vân, Tỉnh Bắc Ninh', '22034', 'xa', '18'),
(870, 'Xuân Cẩm', 'Xã Xuân Cẩm', 'Xã Xuân Cẩm, Tỉnh Bắc Ninh', '22290', 'xa', '18'),
(871, 'Tự Lạn', 'Phường Tự Lạn', 'Phường Tự Lạn, Tỉnh Bắc Ninh', '22546', 'phuong', '18'),
(872, 'Việt Yên', 'Phường Việt Yên', 'Phường Việt Yên, Tỉnh Bắc Ninh', '22802', 'phuong', '18'),
(873, 'Nếnh', 'Phường Nếnh', 'Phường Nếnh, Tỉnh Bắc Ninh', '23058', 'phuong', '18'),
(874, 'Vân Hà', 'Phường Vân Hà', 'Phường Vân Hà, Tỉnh Bắc Ninh', '23314', 'phuong', '18'),
(875, 'Đồng Việt', 'Xã Đồng Việt', 'Xã Đồng Việt, Tỉnh Bắc Ninh', '23570', 'xa', '18'),
(876, 'Bắc Giang', 'Phường Bắc Giang', 'Phường Bắc Giang, Tỉnh Bắc Ninh', '23826', 'phuong', '18'),
(877, 'Đa Mai', 'Phường Đa Mai', 'Phường Đa Mai, Tỉnh Bắc Ninh', '24082', 'phuong', '18'),
(878, 'Tiền Phong', 'Phường Tiền Phong', 'Phường Tiền Phong, Tỉnh Bắc Ninh', '24338', 'phuong', '18'),
(879, 'Tân An', 'Phường Tân An', 'Phường Tân An, Tỉnh Bắc Ninh', '24594', 'phuong', '18'),
(880, 'Yên Dũng', 'Phường Yên Dũng', 'Phường Yên Dũng, Tỉnh Bắc Ninh', '24850', 'phuong', '18'),
(881, 'Tân Tiến', 'Phường Tân Tiến', 'Phường Tân Tiến, Tỉnh Bắc Ninh', '25106', 'phuong', '18'),
(882, 'Cảnh Thụy', 'Phường Cảnh Thụy', 'Phường Cảnh Thụy, Tỉnh Bắc Ninh', '25362', 'phuong', '18'),
(883, 'U Minh', 'Xã U Minh', 'Xã U Minh, Tỉnh Cà Mau', '275', 'xa', '19'),
(884, 'Tân Hưng', 'Xã Tân Hưng', 'Xã Tân Hưng, Tỉnh Cà Mau', '531', 'xa', '19'),
(885, 'Tạ An Khương', 'Xã Tạ An Khương', 'Xã Tạ An Khương, Tỉnh Cà Mau', '787', 'xa', '19'),
(886, 'Phan Ngọc Hiển', 'Xã Phan Ngọc Hiển', 'Xã Phan Ngọc Hiển, Tỉnh Cà Mau', '1043', 'xa', '19'),
(887, 'Đất Mũi', 'Xã Đất Mũi', 'Xã Đất Mũi, Tỉnh Cà Mau', '1299', 'xa', '19'),
(888, 'Sông Đốc', 'Xã Sông Đốc', 'Xã Sông Đốc, Tỉnh Cà Mau', '1555', 'xa', '19'),
(889, 'Đất Mới', 'Xã Đất Mới', 'Xã Đất Mới, Tỉnh Cà Mau', '1811', 'xa', '19'),
(890, 'Năm Căn', 'Xã Năm Căn', 'Xã Năm Căn, Tỉnh Cà Mau', '2067', 'xa', '19'),
(891, 'Đầm Dơi', 'Xã Đầm Dơi', 'Xã Đầm Dơi, Tỉnh Cà Mau', '2323', 'xa', '19'),
(892, 'Cái Nước', 'Xã Cái Nước', 'Xã Cái Nước, Tỉnh Cà Mau', '2579', 'xa', '19'),
(893, 'Hưng Mỹ', 'Xã Hưng Mỹ', 'Xã Hưng Mỹ, Tỉnh Cà Mau', '2835', 'xa', '19'),
(894, 'Lương Thế Trân', 'Xã Lương Thế Trân', 'Xã Lương Thế Trân, Tỉnh Cà Mau', '3091', 'xa', '19'),
(895, 'Phú Mỹ', 'Xã Phú Mỹ', 'Xã Phú Mỹ, Tỉnh Cà Mau', '3347', 'xa', '19'),
(896, 'Hồ Thị Kỷ', 'Xã Hồ Thị Kỷ', 'Xã Hồ Thị Kỷ, Tỉnh Cà Mau', '3603', 'xa', '19'),
(897, 'Trần Văn Thời', 'Xã Trần Văn Thời', 'Xã Trần Văn Thời, Tỉnh Cà Mau', '3859', 'xa', '19'),
(898, 'Nguyễn Phích', 'Xã Nguyễn Phích', 'Xã Nguyễn Phích, Tỉnh Cà Mau', '4115', 'xa', '19'),
(899, 'Khánh An', 'Xã Khánh An', 'Xã Khánh An, Tỉnh Cà Mau', '4371', 'xa', '19'),
(900, 'Khánh Lâm', 'Xã Khánh Lâm', 'Xã Khánh Lâm, Tỉnh Cà Mau', '4627', 'xa', '19'),
(901, 'Lý Văn Lâm', 'Phường Lý Văn Lâm', 'Phường Lý Văn Lâm, Tỉnh Cà Mau', '4883', 'phuong', '19'),
(902, 'Hòa Thành', 'Phường Hòa Thành', 'Phường Hòa Thành, Tỉnh Cà Mau', '5139', 'phuong', '19'),
(903, 'Tân Thành', 'Phường Tân Thành', 'Phường Tân Thành, Tỉnh Cà Mau', '5395', 'phuong', '19'),
(904, 'Đá Bạc', 'Xã Đá Bạc', 'Xã Đá Bạc, Tỉnh Cà Mau', '5651', 'xa', '19'),
(905, 'Bạc Liêu', 'Phường Bạc Liêu', 'Phường Bạc Liêu, Tỉnh Cà Mau', '5907', 'phuong', '19'),
(906, 'Vĩnh Trạch', 'Phường Vĩnh Trạch', 'Phường Vĩnh Trạch, Tỉnh Cà Mau', '6163', 'phuong', '19'),
(907, 'Hiệp Thành', 'Phường Hiệp Thành', 'Phường Hiệp Thành, Tỉnh Cà Mau', '6419', 'phuong', '19'),
(908, 'Giá Rai', 'Phường Giá Rai', 'Phường Giá Rai, Tỉnh Cà Mau', '6675', 'phuong', '19'),
(909, 'Láng Tròn', 'Phường Láng Tròn', 'Phường Láng Tròn, Tỉnh Cà Mau', '6931', 'phuong', '19'),
(910, 'Phong Thạnh', 'Xã Phong Thạnh', 'Xã Phong Thạnh, Tỉnh Cà Mau', '7187', 'xa', '19'),
(911, 'Hồng Dân', 'Xã Hồng Dân', 'Xã Hồng Dân, Tỉnh Cà Mau', '7443', 'xa', '19'),
(912, 'Vĩnh Lộc', 'Xã Vĩnh Lộc', 'Xã Vĩnh Lộc, Tỉnh Cà Mau', '7699', 'xa', '19'),
(913, 'Ninh Thạnh Lợi', 'Xã Ninh Thạnh Lợi', 'Xã Ninh Thạnh Lợi, Tỉnh Cà Mau', '7955', 'xa', '19'),
(914, 'Ninh Quới', 'Xã Ninh Quới', 'Xã Ninh Quới, Tỉnh Cà Mau', '8211', 'xa', '19'),
(915, 'Gành Hào', 'Xã Gành Hào', 'Xã Gành Hào, Tỉnh Cà Mau', '8467', 'xa', '19'),
(916, 'Định Thành', 'Xã Định Thành', 'Xã Định Thành, Tỉnh Cà Mau', '8723', 'xa', '19'),
(917, 'An Trạch', 'Xã An Trạch', 'Xã An Trạch, Tỉnh Cà Mau', '8979', 'xa', '19'),
(918, 'Long Điền', 'Xã Long Điền', 'Xã Long Điền, Tỉnh Cà Mau', '9235', 'xa', '19'),
(919, 'Đông Hải', 'Xã Đông Hải', 'Xã Đông Hải, Tỉnh Cà Mau', '9491', 'xa', '19'),
(920, 'Hòa Bình', 'Xã Hòa Bình', 'Xã Hòa Bình, Tỉnh Cà Mau', '9747', 'xa', '19'),
(921, 'Vĩnh Mỹ', 'Xã Vĩnh Mỹ', 'Xã Vĩnh Mỹ, Tỉnh Cà Mau', '10003', 'xa', '19'),
(922, 'Vĩnh Hậu', 'Xã Vĩnh Hậu', 'Xã Vĩnh Hậu, Tỉnh Cà Mau', '10259', 'xa', '19'),
(923, 'Phước Long', 'Xã Phước Long', 'Xã Phước Long, Tỉnh Cà Mau', '10515', 'xa', '19'),
(924, 'Vĩnh Phước', 'Xã Vĩnh Phước', 'Xã Vĩnh Phước, Tỉnh Cà Mau', '10771', 'xa', '19'),
(925, 'Phong Hiệp', 'Xã Phong Hiệp', 'Xã Phong Hiệp, Tỉnh Cà Mau', '11027', 'xa', '19'),
(926, 'Vĩnh Thanh', 'Xã Vĩnh Thanh', 'Xã Vĩnh Thanh, Tỉnh Cà Mau', '11283', 'xa', '19'),
(927, 'Vĩnh Lợi', 'Xã Vĩnh Lợi', 'Xã Vĩnh Lợi, Tỉnh Cà Mau', '11539', 'xa', '19'),
(928, 'Hưng Hội', 'Xã Hưng Hội', 'Xã Hưng Hội, Tỉnh Cà Mau', '11795', 'xa', '19'),
(929, 'Châu Thới', 'Xã Châu Thới', 'Xã Châu Thới, Tỉnh Cà Mau', '12051', 'xa', '19'),
(930, 'An Xuyên', 'Phường An Xuyên', 'Phường An Xuyên, Tỉnh Cà Mau', '12307', 'phuong', '19'),
(931, 'Tân Thuận', 'Xã Tân Thuận', 'Xã Tân Thuận, Tỉnh Cà Mau', '12563', 'xa', '19'),
(932, 'Tân Tiến', 'Xã Tân Tiến', 'Xã Tân Tiến, Tỉnh Cà Mau', '12819', 'xa', '19'),
(933, 'Trần Phán', 'Xã Trần Phán', 'Xã Trần Phán, Tỉnh Cà Mau', '13075', 'xa', '19'),
(934, 'Thanh Tùng', 'Xã Thanh Tùng', 'Xã Thanh Tùng, Tỉnh Cà Mau', '13331', 'xa', '19'),
(935, 'Quách Phẩm', 'Xã Quách Phẩm', 'Xã Quách Phẩm, Tỉnh Cà Mau', '13587', 'xa', '19'),
(936, 'Tân Ân', 'Xã Tân Ân', 'Xã Tân Ân, Tỉnh Cà Mau', '13843', 'xa', '19'),
(937, 'Khánh Bình', 'Xã Khánh Bình', 'Xã Khánh Bình, Tỉnh Cà Mau', '14099', 'xa', '19'),
(938, 'Khánh Hưng', 'Xã Khánh Hưng', 'Xã Khánh Hưng, Tỉnh Cà Mau', '14355', 'xa', '19'),
(939, 'Thới Bình', 'Xã Thới Bình', 'Xã Thới Bình, Tỉnh Cà Mau', '14611', 'xa', '19'),
(940, 'Trí Phải', 'Xã Trí Phải', 'Xã Trí Phải, Tỉnh Cà Mau', '14867', 'xa', '19'),
(941, 'Tân Lộc', 'Xã Tân Lộc', 'Xã Tân Lộc, Tỉnh Cà Mau', '15123', 'xa', '19'),
(942, 'Biển Bạch', 'Xã Biển Bạch', 'Xã Biển Bạch, Tỉnh Cà Mau', '15379', 'xa', '19'),
(943, 'Tam Giang', 'Xã Tam Giang', 'Xã Tam Giang, Tỉnh Cà Mau', '15635', 'xa', '19'),
(944, 'Cái Đôi Vàm', 'Xã Cái Đôi Vàm', 'Xã Cái Đôi Vàm, Tỉnh Cà Mau', '15891', 'xa', '19'),
(945, 'Nguyễn Việt Khái', 'Xã Nguyễn Việt Khái', 'Xã Nguyễn Việt Khái, Tỉnh Cà Mau', '16147', 'xa', '19'),
(946, 'Phú Tân', 'Xã Phú Tân', 'Xã Phú Tân, Tỉnh Cà Mau', '16403', 'xa', '19'),
(947, 'Thục Phán', 'Phường Thục Phán', 'Phường Thục Phán, Tỉnh Cao Bằng', '276', 'phuong', '20'),
(948, 'Tân Giang', 'Phường Tân Giang', 'Phường Tân Giang, Tỉnh Cao Bằng', '532', 'phuong', '20'),
(949, 'Nùng Trí Cao', 'Phường Nùng Trí Cao', 'Phường Nùng Trí Cao, Tỉnh Cao Bằng', '788', 'phuong', '20'),
(950, 'Sơn Lộ', 'Xã Sơn Lộ', 'Xã Sơn Lộ, Tỉnh Cao Bằng', '1044', 'xa', '20'),
(951, 'Hưng Đạo', 'Xã Hưng Đạo', 'Xã Hưng Đạo, Tỉnh Cao Bằng', '1300', 'xa', '20'),
(952, 'Bảo Lạc', 'Xã Bảo Lạc', 'Xã Bảo Lạc, Tỉnh Cao Bằng', '1556', 'xa', '20'),
(953, 'Cốc Pàng', 'Xã Cốc Pàng', 'Xã Cốc Pàng, Tỉnh Cao Bằng', '1812', 'xa', '20'),
(954, 'Cô Ba', 'Xã Cô Ba', 'Xã Cô Ba, Tỉnh Cao Bằng', '2068', 'xa', '20'),
(955, 'Khánh Xuân', 'Xã Khánh Xuân', 'Xã Khánh Xuân, Tỉnh Cao Bằng', '2324', 'xa', '20'),
(956, 'Xuân Trường', 'Xã Xuân Trường', 'Xã Xuân Trường, Tỉnh Cao Bằng', '2580', 'xa', '20'),
(957, 'Huy Giáp', 'Xã Huy Giáp', 'Xã Huy Giáp, Tỉnh Cao Bằng', '2836', 'xa', '20'),
(958, 'Quảng Lâm', 'Xã Quảng Lâm', 'Xã Quảng Lâm, Tỉnh Cao Bằng', '3092', 'xa', '20'),
(959, 'Nam Quang', 'Xã Nam Quang', 'Xã Nam Quang, Tỉnh Cao Bằng', '3348', 'xa', '20'),
(960, 'Lý Bôn', 'Xã Lý Bôn', 'Xã Lý Bôn, Tỉnh Cao Bằng', '3604', 'xa', '20'),
(961, 'Bảo Lâm', 'Xã Bảo Lâm', 'Xã Bảo Lâm, Tỉnh Cao Bằng', '3860', 'xa', '20'),
(962, 'Yên Thổ', 'Xã Yên Thổ', 'Xã Yên Thổ, Tỉnh Cao Bằng', '4116', 'xa', '20'),
(963, 'Hạ Lang', 'Xã Hạ Lang', 'Xã Hạ Lang, Tỉnh Cao Bằng', '4372', 'xa', '20'),
(964, 'Lý Quốc', 'Xã Lý Quốc', 'Xã Lý Quốc, Tỉnh Cao Bằng', '4628', 'xa', '20'),
(965, 'Vinh Quý', 'Xã Vinh Quý', 'Xã Vinh Quý, Tỉnh Cao Bằng', '4884', 'xa', '20'),
(966, 'Thanh Long', 'Xã Thanh Long', 'Xã Thanh Long, Tỉnh Cao Bằng', '5140', 'xa', '20'),
(967, 'Cần Yên', 'Xã Cần Yên', 'Xã Cần Yên, Tỉnh Cao Bằng', '5396', 'xa', '20'),
(968, 'Thông Nông', 'Xã Thông Nông', 'Xã Thông Nông, Tỉnh Cao Bằng', '5652', 'xa', '20'),
(969, 'Trường Hà', 'Xã Trường Hà', 'Xã Trường Hà, Tỉnh Cao Bằng', '5908', 'xa', '20'),
(970, 'Hà Quảng', 'Xã Hà Quảng', 'Xã Hà Quảng, Tỉnh Cao Bằng', '6164', 'xa', '20'),
(971, 'Lũng Nặm', 'Xã Lũng Nặm', 'Xã Lũng Nặm, Tỉnh Cao Bằng', '6420', 'xa', '20'),
(972, 'Tổng Cọt', 'Xã Tổng Cọt', 'Xã Tổng Cọt, Tỉnh Cao Bằng', '6676', 'xa', '20'),
(973, 'Nam Tuấn', 'Xã Nam Tuấn', 'Xã Nam Tuấn, Tỉnh Cao Bằng', '6932', 'xa', '20'),
(974, 'Hòa An', 'Xã Hòa An', 'Xã Hòa An, Tỉnh Cao Bằng', '7188', 'xa', '20'),
(975, 'Bạch Đằng', 'Xã Bạch Đằng', 'Xã Bạch Đằng, Tỉnh Cao Bằng', '7444', 'xa', '20'),
(976, 'Nguyễn Huệ', 'Xã Nguyễn Huệ', 'Xã Nguyễn Huệ, Tỉnh Cao Bằng', '7700', 'xa', '20'),
(977, 'Ca Thành', 'Xã Ca Thành', 'Xã Ca Thành, Tỉnh Cao Bằng', '7956', 'xa', '20'),
(978, 'Phan Thanh', 'Xã Phan Thanh', 'Xã Phan Thanh, Tỉnh Cao Bằng', '8212', 'xa', '20'),
(979, 'Thành Công', 'Xã Thành Công', 'Xã Thành Công, Tỉnh Cao Bằng', '8468', 'xa', '20'),
(980, 'Tam Kim', 'Xã Tam Kim', 'Xã Tam Kim, Tỉnh Cao Bằng', '8724', 'xa', '20'),
(981, 'Nguyên Bình', 'Xã Nguyên Bình', 'Xã Nguyên Bình, Tỉnh Cao Bằng', '8980', 'xa', '20'),
(982, 'Tĩnh Túc', 'Xã Tĩnh Túc', 'Xã Tĩnh Túc, Tỉnh Cao Bằng', '9236', 'xa', '20'),
(983, 'Minh Tâm', 'Xã Minh Tâm', 'Xã Minh Tâm, Tỉnh Cao Bằng', '9492', 'xa', '20'),
(984, 'Phục Hòa', 'Xã Phục Hòa', 'Xã Phục Hòa, Tỉnh Cao Bằng', '9748', 'xa', '20'),
(985, 'Bế Văn Đàn', 'Xã Bế Văn Đàn', 'Xã Bế Văn Đàn, Tỉnh Cao Bằng', '10004', 'xa', '20'),
(986, 'Độc Lập', 'Xã Độc Lập', 'Xã Độc Lập, Tỉnh Cao Bằng', '10260', 'xa', '20'),
(987, 'Quảng Uyên', 'Xã Quảng Uyên', 'Xã Quảng Uyên, Tỉnh Cao Bằng', '10516', 'xa', '20'),
(988, 'Hạnh Phúc', 'Xã Hạnh Phúc', 'Xã Hạnh Phúc, Tỉnh Cao Bằng', '10772', 'xa', '20'),
(989, 'Minh Khai', 'Xã Minh Khai', 'Xã Minh Khai, Tỉnh Cao Bằng', '11028', 'xa', '20'),
(990, 'Canh Tân', 'Xã Canh Tân', 'Xã Canh Tân, Tỉnh Cao Bằng', '11284', 'xa', '20'),
(991, 'Kim Đồng', 'Xã Kim Đồng', 'Xã Kim Đồng, Tỉnh Cao Bằng', '11540', 'xa', '20'),
(992, 'Thạch An', 'Xã Thạch An', 'Xã Thạch An, Tỉnh Cao Bằng', '11796', 'xa', '20'),
(993, 'Đông Khê', 'Xã Đông Khê', 'Xã Đông Khê, Tỉnh Cao Bằng', '12052', 'xa', '20'),
(994, 'Đức Long', 'Xã Đức Long', 'Xã Đức Long, Tỉnh Cao Bằng', '12308', 'xa', '20'),
(995, 'Quang Hán', 'Xã Quang Hán', 'Xã Quang Hán, Tỉnh Cao Bằng', '12564', 'xa', '20'),
(996, 'Trà Lĩnh', 'Xã Trà Lĩnh', 'Xã Trà Lĩnh, Tỉnh Cao Bằng', '12820', 'xa', '20'),
(997, 'Quang Trung', 'Xã Quang Trung', 'Xã Quang Trung, Tỉnh Cao Bằng', '13076', 'xa', '20'),
(998, 'Đoài Dương', 'Xã Đoài Dương', 'Xã Đoài Dương, Tỉnh Cao Bằng', '13332', 'xa', '20'),
(999, 'Trùng Khánh', 'Xã Trùng Khánh', 'Xã Trùng Khánh, Tỉnh Cao Bằng', '13588', 'xa', '20'),
(1000, 'Đàm Thuỷ', 'Xã Đàm Thuỷ', 'Xã Đàm Thuỷ, Tỉnh Cao Bằng', '13844', 'xa', '20'),
(1001, 'Quang Long', 'Xã Quang Long', 'Xã Quang Long, Tỉnh Cao Bằng', '14100', 'xa', '20'),
(1002, 'Đình Phong', 'Xã Đình Phong', 'Xã Đình Phong, Tỉnh Cao Bằng', '14356', 'xa', '20'),
(1003, 'Hòa Hiệp', 'Phường Hòa Hiệp', 'Phường Hòa Hiệp, Tỉnh Đắk Lắk', '277', 'phuong', '21'),
(1004, 'Bình Kiến', 'Phường Bình Kiến', 'Phường Bình Kiến, Tỉnh Đắk Lắk', '533', 'phuong', '21'),
(1005, 'Phú Hòa 2', 'Xã Phú Hòa 2', 'Xã Phú Hòa 2, Tỉnh Đắk Lắk', '789', 'xa', '21'),
(1006, 'Đức Bình', 'Xã Đức Bình', 'Xã Đức Bình, Tỉnh Đắk Lắk', '1045', 'xa', '21'),
(1007, 'Ea Bá', 'Xã Ea Bá', 'Xã Ea Bá, Tỉnh Đắk Lắk', '1301', 'xa', '21'),
(1008, 'Ealy', 'Xã Ealy', 'Xã Ealy, Tỉnh Đắk Lắk', '1557', 'xa', '21'),
(1009, 'Phú Yên', 'Phường Phú Yên', 'Phường Phú Yên, Tỉnh Đắk Lắk', '1813', 'phuong', '21'),
(1010, 'Xuân Đài', 'Phường Xuân Đài', 'Phường Xuân Đài, Tỉnh Đắk Lắk', '2069', 'phuong', '21'),
(1011, 'Dray Bhăng', 'Xã Dray Bhăng', 'Xã Dray Bhăng, Tỉnh Đắk Lắk', '2325', 'xa', '21'),
(1012, 'Buôn Đôn', 'Xã Buôn Đôn', 'Xã Buôn Đôn, Tỉnh Đắk Lắk', '2581', 'xa', '21'),
(1013, 'Ea KTur', 'Xã Ea KTur', 'Xã Ea KTur, Tỉnh Đắk Lắk', '2837', 'xa', '21'),
(1014, 'Vụ Bổn', 'Xã Vụ Bổn', 'Xã Vụ Bổn, Tỉnh Đắk Lắk', '3093', 'xa', '21'),
(1015, 'Krông Nô', 'Xã Krông Nô', 'Xã Krông Nô, Tỉnh Đắk Lắk', '3349', 'xa', '21'),
(1016, 'Ea Trang', 'Xã Ea Trang', 'Xã Ea Trang, Tỉnh Đắk Lắk', '3605', 'xa', '21'),
(1017, 'Ea H\'Leo', 'Xã Ea H\'Leo', 'Xã Ea H\'Leo, Tỉnh Đắk Lắk', '3861', 'xa', '21'),
(1018, 'Ia Lốp', 'Xã Ia Lốp', 'Xã Ia Lốp, Tỉnh Đắk Lắk', '4117', 'xa', '21'),
(1019, 'Ia Rvê', 'Xã Ia Rvê', 'Xã Ia Rvê, Tỉnh Đắk Lắk', '4373', 'xa', '21'),
(1020, 'Buôn Ma Thuột', 'Phường Buôn Ma Thuột', 'Phường Buôn Ma Thuột, Tỉnh Đắk Lắk', '4629', 'phuong', '21'),
(1021, 'Tân An', 'Phường Tân An', 'Phường Tân An, Tỉnh Đắk Lắk', '4885', 'phuong', '21'),
(1022, 'Tân Lập', 'Phường Tân Lập', 'Phường Tân Lập, Tỉnh Đắk Lắk', '5141', 'phuong', '21'),
(1023, 'Thành Nhất', 'Phường Thành Nhất', 'Phường Thành Nhất, Tỉnh Đắk Lắk', '5397', 'phuong', '21'),
(1024, 'Ea Kao', 'Phường Ea Kao', 'Phường Ea Kao, Tỉnh Đắk Lắk', '5653', 'phuong', '21'),
(1025, 'Hòa Phú', 'Xã Hòa Phú', 'Xã Hòa Phú, Tỉnh Đắk Lắk', '5909', 'xa', '21'),
(1026, 'Buôn Hồ', 'Phường Buôn Hồ', 'Phường Buôn Hồ, Tỉnh Đắk Lắk', '6165', 'phuong', '21'),
(1027, 'Cư Bao', 'Phường Cư Bao', 'Phường Cư Bao, Tỉnh Đắk Lắk', '6421', 'phuong', '21'),
(1028, 'Ea Drông', 'Xã Ea Drông', 'Xã Ea Drông, Tỉnh Đắk Lắk', '6677', 'xa', '21'),
(1029, 'Ea Súp', 'Xã Ea Súp', 'Xã Ea Súp, Tỉnh Đắk Lắk', '6933', 'xa', '21'),
(1030, 'Ea Rốk', 'Xã Ea Rốk', 'Xã Ea Rốk, Tỉnh Đắk Lắk', '7189', 'xa', '21'),
(1031, 'Ea Bung', 'Xã Ea Bung', 'Xã Ea Bung, Tỉnh Đắk Lắk', '7445', 'xa', '21'),
(1032, 'Ea Wer', 'Xã Ea Wer', 'Xã Ea Wer, Tỉnh Đắk Lắk', '7701', 'xa', '21'),
(1033, 'Ea Nuôl', 'Xã Ea Nuôl', 'Xã Ea Nuôl, Tỉnh Đắk Lắk', '7957', 'xa', '21'),
(1034, 'Ea Kiết', 'Xã Ea Kiết', 'Xã Ea Kiết, Tỉnh Đắk Lắk', '8213', 'xa', '21'),
(1035, 'Ea M\'Droh', 'Xã Ea M\'Droh', 'Xã Ea M\'Droh, Tỉnh Đắk Lắk', '8469', 'xa', '21'),
(1036, 'Quảng Phú', 'Xã Quảng Phú', 'Xã Quảng Phú, Tỉnh Đắk Lắk', '8725', 'xa', '21'),
(1037, 'Cuôr Đăng', 'Xã Cuôr Đăng', 'Xã Cuôr Đăng, Tỉnh Đắk Lắk', '8981', 'xa', '21'),
(1038, 'Cư M\'gar', 'Xã Cư M\'gar', 'Xã Cư M\'gar, Tỉnh Đắk Lắk', '9237', 'xa', '21'),
(1039, 'Ea Tul', 'Xã Ea Tul', 'Xã Ea Tul, Tỉnh Đắk Lắk', '9493', 'xa', '21'),
(1040, 'Pơng Drang', 'Xã Pơng Drang', 'Xã Pơng Drang, Tỉnh Đắk Lắk', '9749', 'xa', '21'),
(1041, 'Krông Búk', 'Xã Krông Búk', 'Xã Krông Búk, Tỉnh Đắk Lắk', '10005', 'xa', '21'),
(1042, 'Cư Pơng', 'Xã Cư Pơng', 'Xã Cư Pơng, Tỉnh Đắk Lắk', '10261', 'xa', '21'),
(1043, 'Ea Khăl', 'Xã Ea Khăl', 'Xã Ea Khăl, Tỉnh Đắk Lắk', '10517', 'xa', '21'),
(1044, 'Ea Drăng', 'Xã Ea Drăng', 'Xã Ea Drăng, Tỉnh Đắk Lắk', '10773', 'xa', '21'),
(1045, 'Ea Wy', 'Xã Ea Wy', 'Xã Ea Wy, Tỉnh Đắk Lắk', '11029', 'xa', '21'),
(1046, 'Ea Hiao', 'Xã Ea Hiao', 'Xã Ea Hiao, Tỉnh Đắk Lắk', '11285', 'xa', '21'),
(1047, 'Krông Năng', 'Xã Krông Năng', 'Xã Krông Năng, Tỉnh Đắk Lắk', '11541', 'xa', '21'),
(1048, 'Dliê Ya', 'Xã Dliê Ya', 'Xã Dliê Ya, Tỉnh Đắk Lắk', '11797', 'xa', '21'),
(1049, 'Tam Giang', 'Xã Tam Giang', 'Xã Tam Giang, Tỉnh Đắk Lắk', '12053', 'xa', '21'),
(1050, 'Phú Xuân', 'Xã Phú Xuân', 'Xã Phú Xuân, Tỉnh Đắk Lắk', '12309', 'xa', '21'),
(1051, 'Krông Pắc', 'Xã Krông Pắc', 'Xã Krông Pắc, Tỉnh Đắk Lắk', '12565', 'xa', '21'),
(1052, 'Ea Knuếc', 'Xã Ea Knuếc', 'Xã Ea Knuếc, Tỉnh Đắk Lắk', '12821', 'xa', '21'),
(1053, 'Tân Tiến', 'Xã Tân Tiến', 'Xã Tân Tiến, Tỉnh Đắk Lắk', '13077', 'xa', '21'),
(1054, 'Ea Phê', 'Xã Ea Phê', 'Xã Ea Phê, Tỉnh Đắk Lắk', '13333', 'xa', '21'),
(1055, 'Ea Kly', 'Xã Ea Kly', 'Xã Ea Kly, Tỉnh Đắk Lắk', '13589', 'xa', '21'),
(1056, 'Ea Kar', 'Xã Ea Kar', 'Xã Ea Kar, Tỉnh Đắk Lắk', '13845', 'xa', '21'),
(1057, 'Ea Ô', 'Xã Ea Ô', 'Xã Ea Ô, Tỉnh Đắk Lắk', '14101', 'xa', '21'),
(1058, 'Ea Knốp', 'Xã Ea Knốp', 'Xã Ea Knốp, Tỉnh Đắk Lắk', '14357', 'xa', '21'),
(1059, 'Cư Yang', 'Xã Cư Yang', 'Xã Cư Yang, Tỉnh Đắk Lắk', '14613', 'xa', '21'),
(1060, 'Ea Păl', 'Xã Ea Păl', 'Xã Ea Păl, Tỉnh Đắk Lắk', '14869', 'xa', '21'),
(1061, 'M\'Drắk', 'Xã M\'Drắk', 'Xã M\'Drắk, Tỉnh Đắk Lắk', '15125', 'xa', '21'),
(1062, 'Ea Riêng', 'Xã Ea Riêng', 'Xã Ea Riêng, Tỉnh Đắk Lắk', '15381', 'xa', '21'),
(1063, 'Cư M\'ta', 'Xã Cư M\'ta', 'Xã Cư M\'ta, Tỉnh Đắk Lắk', '15637', 'xa', '21'),
(1064, 'Krông Á', 'Xã Krông Á', 'Xã Krông Á, Tỉnh Đắk Lắk', '15893', 'xa', '21'),
(1065, 'Cư Prao', 'Xã Cư Prao', 'Xã Cư Prao, Tỉnh Đắk Lắk', '16149', 'xa', '21'),
(1066, 'Hòa Sơn', 'Xã Hòa Sơn', 'Xã Hòa Sơn, Tỉnh Đắk Lắk', '16405', 'xa', '21'),
(1067, 'Dang Kang', 'Xã Dang Kang', 'Xã Dang Kang, Tỉnh Đắk Lắk', '16661', 'xa', '21'),
(1068, 'Krông Bông', 'Xã Krông Bông', 'Xã Krông Bông, Tỉnh Đắk Lắk', '16917', 'xa', '21'),
(1069, 'Yang Mao', 'Xã Yang Mao', 'Xã Yang Mao, Tỉnh Đắk Lắk', '17173', 'xa', '21'),
(1070, 'Cư Pui', 'Xã Cư Pui', 'Xã Cư Pui, Tỉnh Đắk Lắk', '17429', 'xa', '21'),
(1071, 'Liên Sơn Lắk', 'Xã Liên Sơn Lắk', 'Xã Liên Sơn Lắk, Tỉnh Đắk Lắk', '17685', 'xa', '21'),
(1072, 'Đắk Liêng', 'Xã Đắk Liêng', 'Xã Đắk Liêng, Tỉnh Đắk Lắk', '17941', 'xa', '21'),
(1073, 'Nam Ka', 'Xã Nam Ka', 'Xã Nam Ka, Tỉnh Đắk Lắk', '18197', 'xa', '21'),
(1074, 'Đắk Phơi', 'Xã Đắk Phơi', 'Xã Đắk Phơi, Tỉnh Đắk Lắk', '18453', 'xa', '21'),
(1075, 'Ea Ning', 'Xã Ea Ning', 'Xã Ea Ning, Tỉnh Đắk Lắk', '18709', 'xa', '21'),
(1076, 'Krông Ana', 'Xã Krông Ana', 'Xã Krông Ana, Tỉnh Đắk Lắk', '18965', 'xa', '21'),
(1077, 'Dur Kmăl', 'Xã Dur Kmăl', 'Xã Dur Kmăl, Tỉnh Đắk Lắk', '19221', 'xa', '21'),
(1078, 'Ea Na', 'Xã Ea Na', 'Xã Ea Na, Tỉnh Đắk Lắk', '19477', 'xa', '21'),
(1079, 'Xuân Thọ', 'Xã Xuân Thọ', 'Xã Xuân Thọ, Tỉnh Đắk Lắk', '19733', 'xa', '21'),
(1080, 'Xuân Cảnh', 'Xã Xuân Cảnh', 'Xã Xuân Cảnh, Tỉnh Đắk Lắk', '19989', 'xa', '21'),
(1081, 'Xuân Lộc', 'Xã Xuân Lộc', 'Xã Xuân Lộc, Tỉnh Đắk Lắk', '20245', 'xa', '21'),
(1082, 'Đông Hòa', 'Phường Đông Hòa', 'Phường Đông Hòa, Tỉnh Đắk Lắk', '20501', 'phuong', '21'),
(1083, 'Hòa Xuân', 'Xã Hòa Xuân', 'Xã Hòa Xuân, Tỉnh Đắk Lắk', '20757', 'xa', '21'),
(1084, 'Tuy An Bắc', 'Xã Tuy An Bắc', 'Xã Tuy An Bắc, Tỉnh Đắk Lắk', '21013', 'xa', '21'),
(1085, 'Tuy An Đông', 'Xã Tuy An Đông', 'Xã Tuy An Đông, Tỉnh Đắk Lắk', '21269', 'xa', '21'),
(1086, 'Ô Loan', 'Xã Ô Loan', 'Xã Ô Loan, Tỉnh Đắk Lắk', '21525', 'xa', '21'),
(1087, 'Tuy An Nam', 'Xã Tuy An Nam', 'Xã Tuy An Nam, Tỉnh Đắk Lắk', '21781', 'xa', '21'),
(1088, 'Tuy An Tây', 'Xã Tuy An Tây', 'Xã Tuy An Tây, Tỉnh Đắk Lắk', '22037', 'xa', '21'),
(1089, 'Hòa Thịnh', 'Xã Hòa Thịnh', 'Xã Hòa Thịnh, Tỉnh Đắk Lắk', '22293', 'xa', '21'),
(1090, 'Hòa Mỹ', 'Xã Hòa Mỹ', 'Xã Hòa Mỹ, Tỉnh Đắk Lắk', '22549', 'xa', '21'),
(1091, 'Sơn Thành', 'Xã Sơn Thành', 'Xã Sơn Thành, Tỉnh Đắk Lắk', '22805', 'xa', '21'),
(1092, 'Sơn Hòa', 'Xã Sơn Hòa', 'Xã Sơn Hòa, Tỉnh Đắk Lắk', '23061', 'xa', '21'),
(1093, 'Vân Hòa', 'Xã Vân Hòa', 'Xã Vân Hòa, Tỉnh Đắk Lắk', '23317', 'xa', '21'),
(1094, 'Tây Sơn', 'Xã Tây Sơn', 'Xã Tây Sơn, Tỉnh Đắk Lắk', '23573', 'xa', '21'),
(1095, 'Xuân Lãnh', 'Xã Xuân Lãnh', 'Xã Xuân Lãnh, Tỉnh Đắk Lắk', '23829', 'xa', '21'),
(1096, 'Phú Mỡ', 'Xã Phú Mỡ', 'Xã Phú Mỡ, Tỉnh Đắk Lắk', '24085', 'xa', '21'),
(1097, 'Xuân Phước', 'Xã Xuân Phước', 'Xã Xuân Phước, Tỉnh Đắk Lắk', '24341', 'xa', '21'),
(1098, 'Đồng Xuân', 'Xã Đồng Xuân', 'Xã Đồng Xuân, Tỉnh Đắk Lắk', '24597', 'xa', '21'),
(1099, 'Sông Cầu', 'Phường Sông Cầu', 'Phường Sông Cầu, Tỉnh Đắk Lắk', '24853', 'phuong', '21'),
(1100, 'Suối Trai', 'Xã Suối Trai', 'Xã Suối Trai, Tỉnh Đắk Lắk', '25109', 'xa', '21'),
(1101, 'Tuy Hòa', 'Phường Tuy Hòa', 'Phường Tuy Hòa, Tỉnh Đắk Lắk', '25365', 'phuong', '21'),
(1102, 'Phú Hòa 1', 'Xã Phú Hòa 1', 'Xã Phú Hòa 1, Tỉnh Đắk Lắk', '25621', 'xa', '21'),
(1103, 'Tây Hòa', 'Xã Tây Hòa', 'Xã Tây Hòa, Tỉnh Đắk Lắk', '25877', 'xa', '21');
INSERT INTO `vn_locations` (`id`, `name`, `full_name`, `full_path`, `code`, `level`, `parent_code`) VALUES
(1104, 'Sông Hinh', 'Xã Sông Hinh', 'Xã Sông Hinh, Tỉnh Đắk Lắk', '26133', 'xa', '21'),
(1105, 'Mường Nhé', 'Xã Mường Nhé', 'Xã Mường Nhé, Tỉnh Điện Biên', '278', 'xa', '22'),
(1106, 'Sín Thầu', 'Xã Sín Thầu', 'Xã Sín Thầu, Tỉnh Điện Biên', '534', 'xa', '22'),
(1107, 'Mường Toong', 'Xã Mường Toong', 'Xã Mường Toong, Tỉnh Điện Biên', '790', 'xa', '22'),
(1108, 'Nậm Kè', 'Xã Nậm Kè', 'Xã Nậm Kè, Tỉnh Điện Biên', '1046', 'xa', '22'),
(1109, 'Quảng Lâm', 'Xã Quảng Lâm', 'Xã Quảng Lâm, Tỉnh Điện Biên', '1302', 'xa', '22'),
(1110, 'Nà Hỳ', 'Xã Nà Hỳ', 'Xã Nà Hỳ, Tỉnh Điện Biên', '1558', 'xa', '22'),
(1111, 'Mường Chà', 'Xã Mường Chà', 'Xã Mường Chà, Tỉnh Điện Biên', '1814', 'xa', '22'),
(1112, 'Nà Bủng', 'Xã Nà Bủng', 'Xã Nà Bủng, Tỉnh Điện Biên', '2070', 'xa', '22'),
(1113, 'Chà Tở', 'Xã Chà Tở', 'Xã Chà Tở, Tỉnh Điện Biên', '2326', 'xa', '22'),
(1114, 'Si Pa Phìn', 'Xã Si Pa Phìn', 'Xã Si Pa Phìn, Tỉnh Điện Biên', '2582', 'xa', '22'),
(1115, 'Mường Lay', 'Phường Mường Lay', 'Phường Mường Lay, Tỉnh Điện Biên', '2838', 'phuong', '22'),
(1116, 'Na Sang', 'Xã Na Sang', 'Xã Na Sang, Tỉnh Điện Biên', '3094', 'xa', '22'),
(1117, 'Mường Tùng', 'Xã Mường Tùng', 'Xã Mường Tùng, Tỉnh Điện Biên', '3350', 'xa', '22'),
(1118, 'Pa Ham', 'Xã Pa Ham', 'Xã Pa Ham, Tỉnh Điện Biên', '3606', 'xa', '22'),
(1119, 'Nậm Nèn', 'Xã Nậm Nèn', 'Xã Nậm Nèn, Tỉnh Điện Biên', '3862', 'xa', '22'),
(1120, 'Mường Pồn', 'Xã Mường Pồn', 'Xã Mường Pồn, Tỉnh Điện Biên', '4118', 'xa', '22'),
(1121, 'Tủa Chùa', 'Xã Tủa Chùa', 'Xã Tủa Chùa, Tỉnh Điện Biên', '4374', 'xa', '22'),
(1122, 'Xín Chải', 'Xã Xín Chải', 'Xã Xín Chải, Tỉnh Điện Biên', '4630', 'xa', '22'),
(1123, 'Sính Phình', 'Xã Sính Phình', 'Xã Sính Phình, Tỉnh Điện Biên', '4886', 'xa', '22'),
(1124, 'Tủa Thàng', 'Xã Tủa Thàng', 'Xã Tủa Thàng, Tỉnh Điện Biên', '5142', 'xa', '22'),
(1125, 'Sáng Nhè', 'Xã Sáng Nhè', 'Xã Sáng Nhè, Tỉnh Điện Biên', '5398', 'xa', '22'),
(1126, 'Tuần Giáo', 'Xã Tuần Giáo', 'Xã Tuần Giáo, Tỉnh Điện Biên', '5654', 'xa', '22'),
(1127, 'Quài Tở', 'Xã Quài Tở', 'Xã Quài Tở, Tỉnh Điện Biên', '5910', 'xa', '22'),
(1128, 'Mường Mùn', 'Xã Mường Mùn', 'Xã Mường Mùn, Tỉnh Điện Biên', '6166', 'xa', '22'),
(1129, 'Pú Nhung', 'Xã Pú Nhung', 'Xã Pú Nhung, Tỉnh Điện Biên', '6422', 'xa', '22'),
(1130, 'Chiềng Sinh', 'Xã Chiềng Sinh', 'Xã Chiềng Sinh, Tỉnh Điện Biên', '6678', 'xa', '22'),
(1131, 'Nga An', 'Xã Nga An', 'Xã Nga An, Tỉnh Thanh Hóa', '16938', 'xa', '42'),
(1132, 'Mường Ảng', 'Xã Mường Ảng', 'Xã Mường Ảng, Tỉnh Điện Biên', '6934', 'xa', '22'),
(1133, 'Nà Tấu', 'Xã Nà Tấu', 'Xã Nà Tấu, Tỉnh Điện Biên', '7190', 'xa', '22'),
(1134, 'Búng Lao', 'Xã Búng Lao', 'Xã Búng Lao, Tỉnh Điện Biên', '7446', 'xa', '22'),
(1135, 'Mường Lạn', 'Xã Mường Lạn', 'Xã Mường Lạn, Tỉnh Điện Biên', '7702', 'xa', '22'),
(1136, 'Mường Phăng', 'Xã Mường Phăng', 'Xã Mường Phăng, Tỉnh Điện Biên', '7958', 'xa', '22'),
(1137, 'Điện Biên Phủ', 'Phường Điện Biên Phủ', 'Phường Điện Biên Phủ, Tỉnh Điện Biên', '8214', 'phuong', '22'),
(1138, 'Mường Thanh', 'Phường Mường Thanh', 'Phường Mường Thanh, Tỉnh Điện Biên', '8470', 'phuong', '22'),
(1139, 'Thanh Nưa', 'Xã Thanh Nưa', 'Xã Thanh Nưa, Tỉnh Điện Biên', '8726', 'xa', '22'),
(1140, 'Thanh An', 'Xã Thanh An', 'Xã Thanh An, Tỉnh Điện Biên', '8982', 'xa', '22'),
(1141, 'Thanh Yên', 'Xã Thanh Yên', 'Xã Thanh Yên, Tỉnh Điện Biên', '9238', 'xa', '22'),
(1142, 'Sam Mứn', 'Xã Sam Mứn', 'Xã Sam Mứn, Tỉnh Điện Biên', '9494', 'xa', '22'),
(1143, 'Núa Ngam', 'Xã Núa Ngam', 'Xã Núa Ngam, Tỉnh Điện Biên', '9750', 'xa', '22'),
(1144, 'Mường Nhà', 'Xã Mường Nhà', 'Xã Mường Nhà, Tỉnh Điện Biên', '10006', 'xa', '22'),
(1145, 'Na Son', 'Xã Na Son', 'Xã Na Son, Tỉnh Điện Biên', '10262', 'xa', '22'),
(1146, 'Xa Dung', 'Xã Xa Dung', 'Xã Xa Dung, Tỉnh Điện Biên', '10518', 'xa', '22'),
(1147, 'Pú Nhi', 'Xã Pú Nhi', 'Xã Pú Nhi, Tỉnh Điện Biên', '10774', 'xa', '22'),
(1148, 'Mường Luân', 'Xã Mường Luân', 'Xã Mường Luân, Tỉnh Điện Biên', '11030', 'xa', '22'),
(1149, 'Tìa Dình', 'Xã Tìa Dình', 'Xã Tìa Dình, Tỉnh Điện Biên', '11286', 'xa', '22'),
(1150, 'Phình Giàng', 'Xã Phình Giàng', 'Xã Phình Giàng, Tỉnh Điện Biên', '11542', 'xa', '22'),
(1151, 'Dak Lua', 'Xã Dak Lua', 'Xã Dak Lua, Tỉnh Đồng Nai', '279', 'xa', '23'),
(1152, 'Phú Lý', 'Xã Phú Lý', 'Xã Phú Lý, Tỉnh Đồng Nai', '535', 'xa', '23'),
(1153, 'Xuân Hòa', 'Xã Xuân Hòa', 'Xã Xuân Hòa, Tỉnh Đồng Nai', '791', 'xa', '23'),
(1154, 'Phước Tân', 'Phường Phước Tân', 'Phường Phước Tân, Tỉnh Đồng Nai', '1047', 'phuong', '23'),
(1155, 'Tam Phước', 'Phường Tam Phước', 'Phường Tam Phước, Tỉnh Đồng Nai', '1303', 'phuong', '23'),
(1156, 'Đak Ơ', 'Xã Đak Ơ', 'Xã Đak Ơ, Tỉnh Đồng Nai', '1559', 'xa', '23'),
(1157, 'Xuân Đông', 'Xã Xuân Đông', 'Xã Xuân Đông, Tỉnh Đồng Nai', '1815', 'xa', '23'),
(1158, 'Bù Gia Mập', 'Xã Bù Gia Mập', 'Xã Bù Gia Mập, Tỉnh Đồng Nai', '2071', 'xa', '23'),
(1159, 'Thanh Sơn', 'Xã Thanh Sơn', 'Xã Thanh Sơn, Tỉnh Đồng Nai', '2327', 'xa', '23'),
(1160, 'Xuân Lộc', 'Xã Xuân Lộc', 'Xã Xuân Lộc, Tỉnh Đồng Nai', '2583', 'xa', '23'),
(1161, 'Xuân Thành', 'Xã Xuân Thành', 'Xã Xuân Thành, Tỉnh Đồng Nai', '2839', 'xa', '23'),
(1162, 'Xuân Bắc', 'Xã Xuân Bắc', 'Xã Xuân Bắc, Tỉnh Đồng Nai', '3095', 'xa', '23'),
(1163, 'La Ngà', 'Xã La Ngà', 'Xã La Ngà, Tỉnh Đồng Nai', '3351', 'xa', '23'),
(1164, 'Định Quán', 'Xã Định Quán', 'Xã Định Quán, Tỉnh Đồng Nai', '3607', 'xa', '23'),
(1165, 'Phú Vinh', 'Xã Phú Vinh', 'Xã Phú Vinh, Tỉnh Đồng Nai', '3863', 'xa', '23'),
(1166, 'Phú Hòa', 'Xã Phú Hòa', 'Xã Phú Hòa, Tỉnh Đồng Nai', '4119', 'xa', '23'),
(1167, 'Tà Lài', 'Xã Tà Lài', 'Xã Tà Lài, Tỉnh Đồng Nai', '4375', 'xa', '23'),
(1168, 'Nam Cát Tiên', 'Xã Nam Cát Tiên', 'Xã Nam Cát Tiên, Tỉnh Đồng Nai', '4631', 'xa', '23'),
(1169, 'Tân Phú', 'Xã Tân Phú', 'Xã Tân Phú, Tỉnh Đồng Nai', '4887', 'xa', '23'),
(1170, 'Phú Lâm', 'Xã Phú Lâm', 'Xã Phú Lâm, Tỉnh Đồng Nai', '5143', 'xa', '23'),
(1171, 'Trị An', 'Xã Trị An', 'Xã Trị An, Tỉnh Đồng Nai', '5399', 'xa', '23'),
(1172, 'Tân An', 'Xã Tân An', 'Xã Tân An, Tỉnh Đồng Nai', '5655', 'xa', '23'),
(1173, 'Tân Triều', 'Phường Tân Triều', 'Phường Tân Triều, Tỉnh Đồng Nai', '5911', 'phuong', '23'),
(1174, 'Phú Riềng', 'Xã Phú Riềng', 'Xã Phú Riềng, Tỉnh Đồng Nai', '6167', 'xa', '23'),
(1175, 'Nhơn Trạch', 'Xã Nhơn Trạch', 'Xã Nhơn Trạch, Tỉnh Đồng Nai', '6423', 'xa', '23'),
(1176, 'Phước An', 'Xã Phước An', 'Xã Phước An, Tỉnh Đồng Nai', '6679', 'xa', '23'),
(1177, 'Phước Thái', 'Xã Phước Thái', 'Xã Phước Thái, Tỉnh Đồng Nai', '6935', 'xa', '23'),
(1178, 'Long Phước', 'Xã Long Phước', 'Xã Long Phước, Tỉnh Đồng Nai', '7191', 'xa', '23'),
(1179, 'Bình An', 'Xã Bình An', 'Xã Bình An, Tỉnh Đồng Nai', '7447', 'xa', '23'),
(1180, 'Long Thành', 'Xã Long Thành', 'Xã Long Thành, Tỉnh Đồng Nai', '7703', 'xa', '23'),
(1181, 'An Phước', 'Xã An Phước', 'Xã An Phước, Tỉnh Đồng Nai', '7959', 'xa', '23'),
(1182, 'An Viễn', 'Xã An Viễn', 'Xã An Viễn, Tỉnh Đồng Nai', '8215', 'xa', '23'),
(1183, 'Bình Minh', 'Xã Bình Minh', 'Xã Bình Minh, Tỉnh Đồng Nai', '8471', 'xa', '23'),
(1184, 'Trảng Bom', 'Xã Trảng Bom', 'Xã Trảng Bom, Tỉnh Đồng Nai', '8727', 'xa', '23'),
(1185, 'Bàu Hàm', 'Xã Bàu Hàm', 'Xã Bàu Hàm, Tỉnh Đồng Nai', '8983', 'xa', '23'),
(1186, 'Hưng Thịnh', 'Xã Hưng Thịnh', 'Xã Hưng Thịnh, Tỉnh Đồng Nai', '9239', 'xa', '23'),
(1187, 'Dầu Giây', 'Xã Dầu Giây', 'Xã Dầu Giây, Tỉnh Đồng Nai', '9495', 'xa', '23'),
(1188, 'Gia Kiệm', 'Xã Gia Kiệm', 'Xã Gia Kiệm, Tỉnh Đồng Nai', '9751', 'xa', '23'),
(1189, 'Thống Nhất', 'Xã Thống Nhất', 'Xã Thống Nhất, Tỉnh Đồng Nai', '10007', 'xa', '23'),
(1190, 'Bình Lộc', 'Phường Bình Lộc', 'Phường Bình Lộc, Tỉnh Đồng Nai', '10263', 'phuong', '23'),
(1191, 'Bảo Vinh', 'Phường Bảo Vinh', 'Phường Bảo Vinh, Tỉnh Đồng Nai', '10519', 'phuong', '23'),
(1192, 'Xuân Lập', 'Phường Xuân Lập', 'Phường Xuân Lập, Tỉnh Đồng Nai', '10775', 'phuong', '23'),
(1193, 'Long Khánh', 'Phường Long Khánh', 'Phường Long Khánh, Tỉnh Đồng Nai', '11031', 'phuong', '23'),
(1194, 'Hàng Gòn', 'Phường Hàng Gòn', 'Phường Hàng Gòn, Tỉnh Đồng Nai', '11287', 'phuong', '23'),
(1195, 'Xuân Quế', 'Xã Xuân Quế', 'Xã Xuân Quế, Tỉnh Đồng Nai', '11543', 'xa', '23'),
(1196, 'Xuân Đường', 'Xã Xuân Đường', 'Xã Xuân Đường, Tỉnh Đồng Nai', '11799', 'xa', '23'),
(1197, 'Cẩm Mỹ', 'Xã Cẩm Mỹ', 'Xã Cẩm Mỹ, Tỉnh Đồng Nai', '12055', 'xa', '23'),
(1198, 'Sông Ray', 'Xã Sông Ray', 'Xã Sông Ray, Tỉnh Đồng Nai', '12311', 'xa', '23'),
(1199, 'Xuân Định', 'Xã Xuân Định', 'Xã Xuân Định, Tỉnh Đồng Nai', '12567', 'xa', '23'),
(1200, 'Xuân Phú', 'Xã Xuân Phú', 'Xã Xuân Phú, Tỉnh Đồng Nai', '12823', 'xa', '23'),
(1201, 'Phú Trung', 'Xã Phú Trung', 'Xã Phú Trung, Tỉnh Đồng Nai', '13079', 'xa', '23'),
(1202, 'Thuận Lợi', 'Xã Thuận Lợi', 'Xã Thuận Lợi, Tỉnh Đồng Nai', '13335', 'xa', '23'),
(1203, 'Đồng Tâm', 'Xã Đồng Tâm', 'Xã Đồng Tâm, Tỉnh Đồng Nai', '13591', 'xa', '23'),
(1204, 'Tân Lợi', 'Xã Tân Lợi', 'Xã Tân Lợi, Tỉnh Đồng Nai', '13847', 'xa', '23'),
(1205, 'Đồng Phú', 'Xã Đồng Phú', 'Xã Đồng Phú, Tỉnh Đồng Nai', '14103', 'xa', '23'),
(1206, 'Phước Sơn', 'Xã Phước Sơn', 'Xã Phước Sơn, Tỉnh Đồng Nai', '14359', 'xa', '23'),
(1207, 'Nghĩa Trung', 'Xã Nghĩa Trung', 'Xã Nghĩa Trung, Tỉnh Đồng Nai', '14615', 'xa', '23'),
(1208, 'Bù Đăng', 'Xã Bù Đăng', 'Xã Bù Đăng, Tỉnh Đồng Nai', '14871', 'xa', '23'),
(1209, 'Thọ Sơn', 'Xã Thọ Sơn', 'Xã Thọ Sơn, Tỉnh Đồng Nai', '15127', 'xa', '23'),
(1210, 'Đak Nhau', 'Xã Đak Nhau', 'Xã Đak Nhau, Tỉnh Đồng Nai', '15383', 'xa', '23'),
(1211, 'Bom Bo', 'Xã Bom Bo', 'Xã Bom Bo, Tỉnh Đồng Nai', '15639', 'xa', '23'),
(1212, 'Long Bình', 'Phường Long Bình', 'Phường Long Bình, Tỉnh Đồng Nai', '15895', 'phuong', '23'),
(1213, 'Trảng Dài', 'Phường Trảng Dài', 'Phường Trảng Dài, Tỉnh Đồng Nai', '16151', 'phuong', '23'),
(1214, 'Hố Nai', 'Phường Hố Nai', 'Phường Hố Nai, Tỉnh Đồng Nai', '16407', 'phuong', '23'),
(1215, 'Long Hưng', 'Phường Long Hưng', 'Phường Long Hưng, Tỉnh Đồng Nai', '16663', 'phuong', '23'),
(1216, 'Đại Phước', 'Xã Đại Phước', 'Xã Đại Phước, Tỉnh Đồng Nai', '16919', 'xa', '23'),
(1217, 'Bình Phước', 'Phường Bình Phước', 'Phường Bình Phước, Tỉnh Đồng Nai', '17175', 'phuong', '23'),
(1218, 'Đồng Xoài', 'Phường Đồng Xoài', 'Phường Đồng Xoài, Tỉnh Đồng Nai', '17431', 'phuong', '23'),
(1219, 'Biên Hòa', 'Phường Biên Hòa', 'Phường Biên Hòa, Tỉnh Đồng Nai', '17687', 'phuong', '23'),
(1220, 'Trấn Biên', 'Phường Trấn Biên', 'Phường Trấn Biên, Tỉnh Đồng Nai', '17943', 'phuong', '23'),
(1221, 'Tam Hiệp', 'Phường Tam Hiệp', 'Phường Tam Hiệp, Tỉnh Đồng Nai', '18199', 'phuong', '23'),
(1222, 'Phước Bình', 'Phường Phước Bình', 'Phường Phước Bình, Tỉnh Đồng Nai', '18455', 'phuong', '23'),
(1223, 'Phước Long', 'Phường Phước Long', 'Phường Phước Long, Tỉnh Đồng Nai', '18711', 'phuong', '23'),
(1224, 'Bình Long', 'Phường Bình Long', 'Phường Bình Long, Tỉnh Đồng Nai', '18967', 'phuong', '23'),
(1225, 'An Lộc', 'Phường An Lộc', 'Phường An Lộc, Tỉnh Đồng Nai', '19223', 'phuong', '23'),
(1226, 'Minh Hưng', 'Phường Minh Hưng', 'Phường Minh Hưng, Tỉnh Đồng Nai', '19479', 'phuong', '23'),
(1227, 'Chơn Thành', 'Phường Chơn Thành', 'Phường Chơn Thành, Tỉnh Đồng Nai', '19735', 'phuong', '23'),
(1228, 'Nha Bích', 'Xã Nha Bích', 'Xã Nha Bích, Tỉnh Đồng Nai', '19991', 'xa', '23'),
(1229, 'Tân Quan', 'Xã Tân Quan', 'Xã Tân Quan, Tỉnh Đồng Nai', '20247', 'xa', '23'),
(1230, 'Tân Hưng', 'Xã Tân Hưng', 'Xã Tân Hưng, Tỉnh Đồng Nai', '20503', 'xa', '23'),
(1231, 'Tân Khai', 'Xã Tân Khai', 'Xã Tân Khai, Tỉnh Đồng Nai', '20759', 'xa', '23'),
(1232, 'Minh Đức', 'Xã Minh Đức', 'Xã Minh Đức, Tỉnh Đồng Nai', '21015', 'xa', '23'),
(1233, 'Lộc Thành', 'Xã Lộc Thành', 'Xã Lộc Thành, Tỉnh Đồng Nai', '21271', 'xa', '23'),
(1234, 'Lộc Ninh', 'Xã Lộc Ninh', 'Xã Lộc Ninh, Tỉnh Đồng Nai', '21527', 'xa', '23'),
(1235, 'Lộc Hưng', 'Xã Lộc Hưng', 'Xã Lộc Hưng, Tỉnh Đồng Nai', '21783', 'xa', '23'),
(1236, 'Lộc Tấn', 'Xã Lộc Tấn', 'Xã Lộc Tấn, Tỉnh Đồng Nai', '22039', 'xa', '23'),
(1237, 'Lộc Thạnh', 'Xã Lộc Thạnh', 'Xã Lộc Thạnh, Tỉnh Đồng Nai', '22295', 'xa', '23'),
(1238, 'Lộc Quang', 'Xã Lộc Quang', 'Xã Lộc Quang, Tỉnh Đồng Nai', '22551', 'xa', '23'),
(1239, 'Tân Tiến', 'Xã Tân Tiến', 'Xã Tân Tiến, Tỉnh Đồng Nai', '22807', 'xa', '23'),
(1240, 'Thiện Hưng', 'Xã Thiện Hưng', 'Xã Thiện Hưng, Tỉnh Đồng Nai', '23063', 'xa', '23'),
(1241, 'Hưng Phước', 'Xã Hưng Phước', 'Xã Hưng Phước, Tỉnh Đồng Nai', '23319', 'xa', '23'),
(1242, 'Phú Nghĩa', 'Xã Phú Nghĩa', 'Xã Phú Nghĩa, Tỉnh Đồng Nai', '23575', 'xa', '23'),
(1243, 'Đa Kia', 'Xã Đa Kia', 'Xã Đa Kia, Tỉnh Đồng Nai', '23831', 'xa', '23'),
(1244, 'Bình Tân', 'Xã Bình Tân', 'Xã Bình Tân, Tỉnh Đồng Nai', '24087', 'xa', '23'),
(1245, 'Long Hà', 'Xã Long Hà', 'Xã Long Hà, Tỉnh Đồng Nai', '24343', 'xa', '23'),
(1246, 'Phong Mỹ', 'Xã Phong Mỹ', 'Xã Phong Mỹ, Tỉnh Đồng Tháp', '280', 'xa', '24'),
(1247, 'Tân Long', 'Xã Tân Long', 'Xã Tân Long, Tỉnh Đồng Tháp', '536', 'xa', '24'),
(1248, 'Thanh Bình', 'Xã Thanh Bình', 'Xã Thanh Bình, Tỉnh Đồng Tháp', '792', 'xa', '24'),
(1249, 'Tân Thạnh', 'Xã Tân Thạnh', 'Xã Tân Thạnh, Tỉnh Đồng Tháp', '1048', 'xa', '24'),
(1250, 'Long Phú Thuận', 'Xã Long Phú Thuận', 'Xã Long Phú Thuận, Tỉnh Đồng Tháp', '1304', 'xa', '24'),
(1251, 'Phú Cường', 'Xã Phú Cường', 'Xã Phú Cường, Tỉnh Đồng Tháp', '1560', 'xa', '24'),
(1252, 'Tân Hồng', 'Xã Tân Hồng', 'Xã Tân Hồng, Tỉnh Đồng Tháp', '1816', 'xa', '24'),
(1253, 'Tân Thành', 'Xã Tân Thành', 'Xã Tân Thành, Tỉnh Đồng Tháp', '2072', 'xa', '24'),
(1254, 'Tân Hộ Cơ', 'Xã Tân Hộ Cơ', 'Xã Tân Hộ Cơ, Tỉnh Đồng Tháp', '2328', 'xa', '24'),
(1255, 'An Phước', 'Xã An Phước', 'Xã An Phước, Tỉnh Đồng Tháp', '2584', 'xa', '24'),
(1256, 'An Bình', 'Phường An Bình', 'Phường An Bình, Tỉnh Đồng Tháp', '2840', 'phuong', '24'),
(1257, 'Hồng Ngự', 'Phường Hồng Ngự', 'Phường Hồng Ngự, Tỉnh Đồng Tháp', '3096', 'phuong', '24'),
(1258, 'Thường Lạc', 'Phường Thường Lạc', 'Phường Thường Lạc, Tỉnh Đồng Tháp', '3352', 'phuong', '24'),
(1259, 'Thường Phước', 'Xã Thường Phước', 'Xã Thường Phước, Tỉnh Đồng Tháp', '3608', 'xa', '24'),
(1260, 'Long Khánh', 'Xã Long Khánh', 'Xã Long Khánh, Tỉnh Đồng Tháp', '3864', 'xa', '24'),
(1261, 'An Hòa', 'Xã An Hòa', 'Xã An Hòa, Tỉnh Đồng Tháp', '4120', 'xa', '24'),
(1262, 'Tam Nông', 'Xã Tam Nông', 'Xã Tam Nông, Tỉnh Đồng Tháp', '4376', 'xa', '24'),
(1263, 'Phú Thọ', 'Xã Phú Thọ', 'Xã Phú Thọ, Tỉnh Đồng Tháp', '4632', 'xa', '24'),
(1264, 'Tràm Chim', 'Xã Tràm Chim', 'Xã Tràm Chim, Tỉnh Đồng Tháp', '4888', 'xa', '24'),
(1265, 'An Long', 'Xã An Long', 'Xã An Long, Tỉnh Đồng Tháp', '5144', 'xa', '24'),
(1266, 'Bình Thành', 'Xã Bình Thành', 'Xã Bình Thành, Tỉnh Đồng Tháp', '5400', 'xa', '24'),
(1267, 'Tháp Mười', 'Xã Tháp Mười', 'Xã Tháp Mười, Tỉnh Đồng Tháp', '5656', 'xa', '24'),
(1268, 'Thanh Mỹ', 'Xã Thanh Mỹ', 'Xã Thanh Mỹ, Tỉnh Đồng Tháp', '5912', 'xa', '24'),
(1269, 'Mỹ Quí', 'Xã Mỹ Quí', 'Xã Mỹ Quí, Tỉnh Đồng Tháp', '6168', 'xa', '24'),
(1270, 'Đốc Binh Kiều', 'Xã Đốc Binh Kiều', 'Xã Đốc Binh Kiều, Tỉnh Đồng Tháp', '6424', 'xa', '24'),
(1271, 'Trường Xuân', 'Xã Trường Xuân', 'Xã Trường Xuân, Tỉnh Đồng Tháp', '6680', 'xa', '24'),
(1272, 'Phương Thịnh', 'Xã Phương Thịnh', 'Xã Phương Thịnh, Tỉnh Đồng Tháp', '6936', 'xa', '24'),
(1273, 'Ba Sao', 'Xã Ba Sao', 'Xã Ba Sao, Tỉnh Đồng Tháp', '7192', 'xa', '24'),
(1274, 'Mỹ Thọ', 'Xã Mỹ Thọ', 'Xã Mỹ Thọ, Tỉnh Đồng Tháp', '7448', 'xa', '24'),
(1275, 'Bình Hàng Trung', 'Xã Bình Hàng Trung', 'Xã Bình Hàng Trung, Tỉnh Đồng Tháp', '7704', 'xa', '24'),
(1276, 'Mỹ Hiệp', 'Xã Mỹ Hiệp', 'Xã Mỹ Hiệp, Tỉnh Đồng Tháp', '7960', 'xa', '24'),
(1277, 'Cao Lãnh', 'Phường Cao Lãnh', 'Phường Cao Lãnh, Tỉnh Đồng Tháp', '8216', 'phuong', '24'),
(1278, 'Mỹ Ngãi', 'Phường Mỹ Ngãi', 'Phường Mỹ Ngãi, Tỉnh Đồng Tháp', '8472', 'phuong', '24'),
(1279, 'Mỹ Trà', 'Phường Mỹ Trà', 'Phường Mỹ Trà, Tỉnh Đồng Tháp', '8728', 'phuong', '24'),
(1280, 'Mỹ An Hưng', 'Xã Mỹ An Hưng', 'Xã Mỹ An Hưng, Tỉnh Đồng Tháp', '8984', 'xa', '24'),
(1281, 'Tân Khánh Trung', 'Xã Tân Khánh Trung', 'Xã Tân Khánh Trung, Tỉnh Đồng Tháp', '9240', 'xa', '24'),
(1282, 'Lấp Vò', 'Xã Lấp Vò', 'Xã Lấp Vò, Tỉnh Đồng Tháp', '9496', 'xa', '24'),
(1283, 'Lai Vung', 'Xã Lai Vung', 'Xã Lai Vung, Tỉnh Đồng Tháp', '9752', 'xa', '24'),
(1284, 'Hòa Long', 'Xã Hòa Long', 'Xã Hòa Long, Tỉnh Đồng Tháp', '10008', 'xa', '24'),
(1285, 'Phong Hòa', 'Xã Phong Hòa', 'Xã Phong Hòa, Tỉnh Đồng Tháp', '10264', 'xa', '24'),
(1286, 'Sa Đéc', 'Phường Sa Đéc', 'Phường Sa Đéc, Tỉnh Đồng Tháp', '10520', 'phuong', '24'),
(1287, 'Tân Dương', 'Xã Tân Dương', 'Xã Tân Dương, Tỉnh Đồng Tháp', '10776', 'xa', '24'),
(1288, 'Phú Hựu', 'Xã Phú Hựu', 'Xã Phú Hựu, Tỉnh Đồng Tháp', '11032', 'xa', '24'),
(1289, 'Tân Nhuận Đông', 'Xã Tân Nhuận Đông', 'Xã Tân Nhuận Đông, Tỉnh Đồng Tháp', '11288', 'xa', '24'),
(1290, 'Tân Phú Trung', 'Xã Tân Phú Trung', 'Xã Tân Phú Trung, Tỉnh Đồng Tháp', '11544', 'xa', '24'),
(1291, 'Thanh Hưng', 'Xã Thanh Hưng', 'Xã Thanh Hưng, Tỉnh Đồng Tháp', '11800', 'xa', '24'),
(1292, 'An Hữu', 'Xã An Hữu', 'Xã An Hữu, Tỉnh Đồng Tháp', '12056', 'xa', '24'),
(1293, 'Mỹ Lợi', 'Xã Mỹ Lợi', 'Xã Mỹ Lợi, Tỉnh Đồng Tháp', '12312', 'xa', '24'),
(1294, 'Mỹ Đức Tây', 'Xã Mỹ Đức Tây', 'Xã Mỹ Đức Tây, Tỉnh Đồng Tháp', '12568', 'xa', '24'),
(1295, 'Mỹ Thiện', 'Xã Mỹ Thiện', 'Xã Mỹ Thiện, Tỉnh Đồng Tháp', '12824', 'xa', '24'),
(1296, 'Hậu Mỹ', 'Xã Hậu Mỹ', 'Xã Hậu Mỹ, Tỉnh Đồng Tháp', '13080', 'xa', '24'),
(1297, 'Hội Cư', 'Xã Hội Cư', 'Xã Hội Cư, Tỉnh Đồng Tháp', '13336', 'xa', '24'),
(1298, 'Cái Bè', 'Xã Cái Bè', 'Xã Cái Bè, Tỉnh Đồng Tháp', '13592', 'xa', '24'),
(1299, 'Hiệp Đức', 'Xã Hiệp Đức', 'Xã Hiệp Đức, Tỉnh Đồng Tháp', '13848', 'xa', '24'),
(1300, 'Bình Phú', 'Xã Bình Phú', 'Xã Bình Phú, Tỉnh Đồng Tháp', '14104', 'xa', '24'),
(1301, 'Ngũ Hiệp', 'Xã Ngũ Hiệp', 'Xã Ngũ Hiệp, Tỉnh Đồng Tháp', '14360', 'xa', '24'),
(1302, 'Long Tiên', 'Xã Long Tiên', 'Xã Long Tiên, Tỉnh Đồng Tháp', '14616', 'xa', '24'),
(1303, 'Mỹ Thành', 'Xã Mỹ Thành', 'Xã Mỹ Thành, Tỉnh Đồng Tháp', '14872', 'xa', '24'),
(1304, 'Thạnh Phú', 'Xã Thạnh Phú', 'Xã Thạnh Phú, Tỉnh Đồng Tháp', '15128', 'xa', '24'),
(1305, 'Mỹ Phước Tây', 'Phường Mỹ Phước Tây', 'Phường Mỹ Phước Tây, Tỉnh Đồng Tháp', '15384', 'phuong', '24'),
(1306, 'Thanh Hòa', 'Phường Thanh Hòa', 'Phường Thanh Hòa, Tỉnh Đồng Tháp', '15640', 'phuong', '24'),
(1307, 'Cai Lậy', 'Phường Cai Lậy', 'Phường Cai Lậy, Tỉnh Đồng Tháp', '15896', 'phuong', '24'),
(1308, 'Nhị Quý', 'Phường Nhị Quý', 'Phường Nhị Quý, Tỉnh Đồng Tháp', '16152', 'phuong', '24'),
(1309, 'Tân Phú', 'Xã Tân Phú', 'Xã Tân Phú, Tỉnh Đồng Tháp', '16408', 'xa', '24'),
(1310, 'Tân Phước 1', 'Xã Tân Phước 1', 'Xã Tân Phước 1, Tỉnh Đồng Tháp', '16664', 'xa', '24'),
(1311, 'Tân Phước 2', 'Xã Tân Phước 2', 'Xã Tân Phước 2, Tỉnh Đồng Tháp', '16920', 'xa', '24'),
(1312, 'Tân Phước 3', 'Xã Tân Phước 3', 'Xã Tân Phước 3, Tỉnh Đồng Tháp', '17176', 'xa', '24'),
(1313, 'Hưng Thạnh', 'Xã Hưng Thạnh', 'Xã Hưng Thạnh, Tỉnh Đồng Tháp', '17432', 'xa', '24'),
(1314, 'Tân Hương', 'Xã Tân Hương', 'Xã Tân Hương, Tỉnh Đồng Tháp', '17688', 'xa', '24'),
(1315, 'Châu Thành', 'Xã Châu Thành', 'Xã Châu Thành, Tỉnh Đồng Tháp', '17944', 'xa', '24'),
(1316, 'Long Hưng', 'Xã Long Hưng', 'Xã Long Hưng, Tỉnh Đồng Tháp', '18200', 'xa', '24'),
(1317, 'Long Định', 'Xã Long Định', 'Xã Long Định, Tỉnh Đồng Tháp', '18456', 'xa', '24'),
(1318, 'Vĩnh Kim', 'Xã Vĩnh Kim', 'Xã Vĩnh Kim, Tỉnh Đồng Tháp', '18712', 'xa', '24'),
(1319, 'Kim Sơn', 'Xã Kim Sơn', 'Xã Kim Sơn, Tỉnh Đồng Tháp', '18968', 'xa', '24'),
(1320, 'Bình Trưng', 'Xã Bình Trưng', 'Xã Bình Trưng, Tỉnh Đồng Tháp', '19224', 'xa', '24'),
(1321, 'Mỹ Tho', 'Phường Mỹ Tho', 'Phường Mỹ Tho, Tỉnh Đồng Tháp', '19480', 'phuong', '24'),
(1322, 'Đạo Thạnh', 'Phường Đạo Thạnh', 'Phường Đạo Thạnh, Tỉnh Đồng Tháp', '19736', 'phuong', '24'),
(1323, 'Mỹ Phong', 'Phường Mỹ Phong', 'Phường Mỹ Phong, Tỉnh Đồng Tháp', '19992', 'phuong', '24'),
(1324, 'Thới Sơn', 'Phường Thới Sơn', 'Phường Thới Sơn, Tỉnh Đồng Tháp', '20248', 'phuong', '24'),
(1325, 'Trung An', 'Phường Trung An', 'Phường Trung An, Tỉnh Đồng Tháp', '20504', 'phuong', '24'),
(1326, 'Mỹ Tịnh An', 'Xã Mỹ Tịnh An', 'Xã Mỹ Tịnh An, Tỉnh Đồng Tháp', '20760', 'xa', '24'),
(1327, 'Lương Hòa Lạc', 'Xã Lương Hòa Lạc', 'Xã Lương Hòa Lạc, Tỉnh Đồng Tháp', '21016', 'xa', '24'),
(1328, 'Tân Thuận Bình', 'Xã Tân Thuận Bình', 'Xã Tân Thuận Bình, Tỉnh Đồng Tháp', '21272', 'xa', '24'),
(1329, 'Chợ Gạo', 'Xã Chợ Gạo', 'Xã Chợ Gạo, Tỉnh Đồng Tháp', '21528', 'xa', '24'),
(1330, 'An Thạnh Thủy', 'Xã An Thạnh Thủy', 'Xã An Thạnh Thủy, Tỉnh Đồng Tháp', '21784', 'xa', '24'),
(1331, 'Bình Ninh', 'Xã Bình Ninh', 'Xã Bình Ninh, Tỉnh Đồng Tháp', '22040', 'xa', '24'),
(1332, 'Gò Công Đông', 'Xã Gò Công Đông', 'Xã Gò Công Đông, Tỉnh Đồng Tháp', '22296', 'xa', '24'),
(1333, 'Tân Điền', 'Xã Tân Điền', 'Xã Tân Điền, Tỉnh Đồng Tháp', '22552', 'xa', '24'),
(1334, 'Tân Hòa', 'Xã Tân Hòa', 'Xã Tân Hòa, Tỉnh Đồng Tháp', '22808', 'xa', '24'),
(1335, 'Tân Đông', 'Xã Tân Đông', 'Xã Tân Đông, Tỉnh Đồng Tháp', '23064', 'xa', '24'),
(1336, 'Gia Thuận', 'Xã Gia Thuận', 'Xã Gia Thuận, Tỉnh Đồng Tháp', '23320', 'xa', '24'),
(1337, 'Vĩnh Bình', 'Xã Vĩnh Bình', 'Xã Vĩnh Bình, Tỉnh Đồng Tháp', '23576', 'xa', '24'),
(1338, 'Đồng Sơn', 'Xã Đồng Sơn', 'Xã Đồng Sơn, Tỉnh Đồng Tháp', '23832', 'xa', '24'),
(1339, 'Phú Thành', 'Xã Phú Thành', 'Xã Phú Thành, Tỉnh Đồng Tháp', '24088', 'xa', '24'),
(1340, 'Long Bình', 'Xã Long Bình', 'Xã Long Bình, Tỉnh Đồng Tháp', '24344', 'xa', '24'),
(1341, 'Vĩnh Hựu', 'Xã Vĩnh Hựu', 'Xã Vĩnh Hựu, Tỉnh Đồng Tháp', '24600', 'xa', '24'),
(1342, 'Gò Công', 'Phường Gò Công', 'Phường Gò Công, Tỉnh Đồng Tháp', '24856', 'phuong', '24'),
(1343, 'Long Thuận', 'Phường Long Thuận', 'Phường Long Thuận, Tỉnh Đồng Tháp', '25112', 'phuong', '24'),
(1344, 'Bình Xuân', 'Phường Bình Xuân', 'Phường Bình Xuân, Tỉnh Đồng Tháp', '25368', 'phuong', '24'),
(1345, 'Sơn Quy', 'Phường Sơn Quy', 'Phường Sơn Quy, Tỉnh Đồng Tháp', '25624', 'phuong', '24'),
(1346, 'Tân Thới', 'Xã Tân Thới', 'Xã Tân Thới, Tỉnh Đồng Tháp', '25880', 'xa', '24'),
(1347, 'Tân Phú Đông', 'Xã Tân Phú Đông', 'Xã Tân Phú Đông, Tỉnh Đồng Tháp', '26136', 'xa', '24'),
(1348, 'Canh Liên', 'Xã Canh Liên', 'Xã Canh Liên, Tỉnh Gia Lai', '281', 'xa', '25'),
(1349, 'Nhơn Châu', 'Xã Nhơn Châu', 'Xã Nhơn Châu, Tỉnh Gia Lai', '537', 'xa', '25'),
(1350, 'An Toàn', 'Xã An Toàn', 'Xã An Toàn, Tỉnh Gia Lai', '793', 'xa', '25'),
(1351, 'Vân Canh', 'Xã Vân Canh', 'Xã Vân Canh, Tỉnh Gia Lai', '1049', 'xa', '25'),
(1352, 'Ia Púch', 'Xã Ia Púch', 'Xã Ia Púch, Tỉnh Gia Lai', '1305', 'xa', '25'),
(1353, 'Ia Mơ', 'Xã Ia Mơ', 'Xã Ia Mơ, Tỉnh Gia Lai', '1561', 'xa', '25'),
(1354, 'Ia Dom', 'Xã Ia Dom', 'Xã Ia Dom, Tỉnh Gia Lai', '1817', 'xa', '25'),
(1355, 'Ia Nan', 'Xã Ia Nan', 'Xã Ia Nan, Tỉnh Gia Lai', '2073', 'xa', '25'),
(1356, 'Ia Pnôn', 'Xã Ia Pnôn', 'Xã Ia Pnôn, Tỉnh Gia Lai', '2329', 'xa', '25'),
(1357, 'Canh Vinh', 'Xã Canh Vinh', 'Xã Canh Vinh, Tỉnh Gia Lai', '2585', 'xa', '25'),
(1358, 'An Hòa', 'Xã An Hòa', 'Xã An Hòa, Tỉnh Gia Lai', '2841', 'xa', '25'),
(1359, 'Phù Mỹ Đông', 'Xã Phù Mỹ Đông', 'Xã Phù Mỹ Đông, Tỉnh Gia Lai', '3097', 'xa', '25'),
(1360, 'Quy Nhơn Đông', 'Phường Quy Nhơn Đông', 'Phường Quy Nhơn Đông, Tỉnh Gia Lai', '3353', 'phuong', '25'),
(1361, 'Tây Sơn', 'Xã Tây Sơn', 'Xã Tây Sơn, Tỉnh Gia Lai', '3609', 'xa', '25'),
(1362, 'Ia Chia', 'Xã Ia Chia', 'Xã Ia Chia, Tỉnh Gia Lai', '3865', 'xa', '25'),
(1363, 'Ia O', 'Xã Ia O', 'Xã Ia O, Tỉnh Gia Lai', '4121', 'xa', '25'),
(1364, 'Krong', 'Xã Krong', 'Xã Krong, Tỉnh Gia Lai', '4377', 'xa', '25'),
(1365, 'Pleiku', 'Phường Pleiku', 'Phường Pleiku, Tỉnh Gia Lai', '4633', 'phuong', '25'),
(1366, 'Hội Phú', 'Phường Hội Phú', 'Phường Hội Phú, Tỉnh Gia Lai', '4889', 'phuong', '25'),
(1367, 'Thống Nhất', 'Phường Thống Nhất', 'Phường Thống Nhất, Tỉnh Gia Lai', '5145', 'phuong', '25'),
(1368, 'Diên Hồng', 'Phường Diên Hồng', 'Phường Diên Hồng, Tỉnh Gia Lai', '5401', 'phuong', '25'),
(1369, 'An Phú', 'Phường An Phú', 'Phường An Phú, Tỉnh Gia Lai', '5657', 'phuong', '25'),
(1370, 'Biển Hồ', 'Xã Biển Hồ', 'Xã Biển Hồ, Tỉnh Gia Lai', '5913', 'xa', '25'),
(1371, 'Gào', 'Xã Gào', 'Xã Gào, Tỉnh Gia Lai', '6169', 'xa', '25'),
(1372, 'Ia Ly', 'Xã Ia Ly', 'Xã Ia Ly, Tỉnh Gia Lai', '6425', 'xa', '25'),
(1373, 'Chư Păh', 'Xã Chư Păh', 'Xã Chư Păh, Tỉnh Gia Lai', '6681', 'xa', '25'),
(1374, 'Ia Khươl', 'Xã Ia Khươl', 'Xã Ia Khươl, Tỉnh Gia Lai', '6937', 'xa', '25'),
(1375, 'Ia Phí', 'Xã Ia Phí', 'Xã Ia Phí, Tỉnh Gia Lai', '7193', 'xa', '25'),
(1376, 'Chư Prông', 'Xã Chư Prông', 'Xã Chư Prông, Tỉnh Gia Lai', '7449', 'xa', '25'),
(1377, 'Bàu Cạn', 'Xã Bàu Cạn', 'Xã Bàu Cạn, Tỉnh Gia Lai', '7705', 'xa', '25'),
(1378, 'Ia Boòng', 'Xã Ia Boòng', 'Xã Ia Boòng, Tỉnh Gia Lai', '7961', 'xa', '25'),
(1379, 'Ia Lâu', 'Xã Ia Lâu', 'Xã Ia Lâu, Tỉnh Gia Lai', '8217', 'xa', '25'),
(1380, 'Ia Pia', 'Xã Ia Pia', 'Xã Ia Pia, Tỉnh Gia Lai', '8473', 'xa', '25'),
(1381, 'Ia Tôr', 'Xã Ia Tôr', 'Xã Ia Tôr, Tỉnh Gia Lai', '8729', 'xa', '25'),
(1382, 'Chư Sê', 'Xã Chư Sê', 'Xã Chư Sê, Tỉnh Gia Lai', '8985', 'xa', '25'),
(1383, 'Bờ Ngoong', 'Xã Bờ Ngoong', 'Xã Bờ Ngoong, Tỉnh Gia Lai', '9241', 'xa', '25'),
(1384, 'Ia Ko', 'Xã Ia Ko', 'Xã Ia Ko, Tỉnh Gia Lai', '9497', 'xa', '25'),
(1385, 'Al Bá', 'Xã Al Bá', 'Xã Al Bá, Tỉnh Gia Lai', '9753', 'xa', '25'),
(1386, 'Chư Pưh', 'Xã Chư Pưh', 'Xã Chư Pưh, Tỉnh Gia Lai', '10009', 'xa', '25'),
(1387, 'Ia Le', 'Xã Ia Le', 'Xã Ia Le, Tỉnh Gia Lai', '10265', 'xa', '25'),
(1388, 'Ia Hrú', 'Xã Ia Hrú', 'Xã Ia Hrú, Tỉnh Gia Lai', '10521', 'xa', '25'),
(1389, 'An Khê', 'Phường An Khê', 'Phường An Khê, Tỉnh Gia Lai', '10777', 'phuong', '25'),
(1390, 'An Bình', 'Phường An Bình', 'Phường An Bình, Tỉnh Gia Lai', '11033', 'phuong', '25'),
(1391, 'Cửu An', 'Xã Cửu An', 'Xã Cửu An, Tỉnh Gia Lai', '11289', 'xa', '25'),
(1392, 'Đak Pơ', 'Xã Đak Pơ', 'Xã Đak Pơ, Tỉnh Gia Lai', '11545', 'xa', '25'),
(1393, 'Ya Hội', 'Xã Ya Hội', 'Xã Ya Hội, Tỉnh Gia Lai', '11801', 'xa', '25'),
(1394, 'Kbang', 'Xã Kbang', 'Xã Kbang, Tỉnh Gia Lai', '12057', 'xa', '25'),
(1395, 'Kông Bơ La', 'Xã Kông Bơ La', 'Xã Kông Bơ La, Tỉnh Gia Lai', '12313', 'xa', '25'),
(1396, 'Tơ Tung', 'Xã Tơ Tung', 'Xã Tơ Tung, Tỉnh Gia Lai', '12569', 'xa', '25'),
(1397, 'Sơn Lang', 'Xã Sơn Lang', 'Xã Sơn Lang, Tỉnh Gia Lai', '12825', 'xa', '25'),
(1398, 'Đăk Roong', 'Xã Đăk Roong', 'Xã Đăk Roong, Tỉnh Gia Lai', '13081', 'xa', '25'),
(1399, 'Kông Chro', 'Xã Kông Chro', 'Xã Kông Chro, Tỉnh Gia Lai', '13337', 'xa', '25'),
(1400, 'Ya Ma', 'Xã Ya Ma', 'Xã Ya Ma, Tỉnh Gia Lai', '13593', 'xa', '25'),
(1401, 'Chư Krêy', 'Xã Chư Krêy', 'Xã Chư Krêy, Tỉnh Gia Lai', '13849', 'xa', '25'),
(1402, 'SRó', 'Xã SRó', 'Xã SRó, Tỉnh Gia Lai', '14105', 'xa', '25'),
(1403, 'Đăk Song', 'Xã Đăk Song', 'Xã Đăk Song, Tỉnh Gia Lai', '14361', 'xa', '25'),
(1404, 'Chơ Long', 'Xã Chơ Long', 'Xã Chơ Long, Tỉnh Gia Lai', '14617', 'xa', '25'),
(1405, 'Ayun Pa', 'Phường Ayun Pa', 'Phường Ayun Pa, Tỉnh Gia Lai', '14873', 'phuong', '25'),
(1406, 'Ia Rbol', 'Xã Ia Rbol', 'Xã Ia Rbol, Tỉnh Gia Lai', '15129', 'xa', '25'),
(1407, 'Ia Sao', 'Xã Ia Sao', 'Xã Ia Sao, Tỉnh Gia Lai', '15385', 'xa', '25'),
(1408, 'Phú Thiện', 'Xã Phú Thiện', 'Xã Phú Thiện, Tỉnh Gia Lai', '15641', 'xa', '25'),
(1409, 'Chư A Thai', 'Xã Chư A Thai', 'Xã Chư A Thai, Tỉnh Gia Lai', '15897', 'xa', '25'),
(1410, 'Ia Hiao', 'Xã Ia Hiao', 'Xã Ia Hiao, Tỉnh Gia Lai', '16153', 'xa', '25'),
(1411, 'Pờ Tó', 'Xã Pờ Tó', 'Xã Pờ Tó, Tỉnh Gia Lai', '16409', 'xa', '25'),
(1412, 'Ia Pa', 'Xã Ia Pa', 'Xã Ia Pa, Tỉnh Gia Lai', '16665', 'xa', '25'),
(1413, 'Ia Tul', 'Xã Ia Tul', 'Xã Ia Tul, Tỉnh Gia Lai', '16921', 'xa', '25'),
(1414, 'Phú Túc', 'Xã Phú Túc', 'Xã Phú Túc, Tỉnh Gia Lai', '17177', 'xa', '25'),
(1415, 'Ia HDreh', 'Xã Ia HDreh', 'Xã Ia HDreh, Tỉnh Gia Lai', '17433', 'xa', '25'),
(1416, 'Ia Rsai', 'Xã Ia Rsai', 'Xã Ia Rsai, Tỉnh Gia Lai', '17689', 'xa', '25'),
(1417, 'Uar', 'Xã Uar', 'Xã Uar, Tỉnh Gia Lai', '17945', 'xa', '25'),
(1418, 'Đăk Đoa', 'Xã Đăk Đoa', 'Xã Đăk Đoa, Tỉnh Gia Lai', '18201', 'xa', '25'),
(1419, 'Kon Gang', 'Xã Kon Gang', 'Xã Kon Gang, Tỉnh Gia Lai', '18457', 'xa', '25'),
(1420, 'Ia Băng', 'Xã Ia Băng', 'Xã Ia Băng, Tỉnh Gia Lai', '18713', 'xa', '25'),
(1421, 'K\'Dang', 'Xã K\'Dang', 'Xã K\'Dang, Tỉnh Gia Lai', '18969', 'xa', '25'),
(1422, 'Đăk Sơmei', 'Xã Đăk Sơmei', 'Xã Đăk Sơmei, Tỉnh Gia Lai', '19225', 'xa', '25'),
(1423, 'Mang Yang', 'Xã Mang Yang', 'Xã Mang Yang, Tỉnh Gia Lai', '19481', 'xa', '25'),
(1424, 'Lơ Pang', 'Xã Lơ Pang', 'Xã Lơ Pang, Tỉnh Gia Lai', '19737', 'xa', '25'),
(1425, 'Kon Chiêng', 'Xã Kon Chiêng', 'Xã Kon Chiêng, Tỉnh Gia Lai', '19993', 'xa', '25'),
(1426, 'Hra', 'Xã Hra', 'Xã Hra, Tỉnh Gia Lai', '20249', 'xa', '25'),
(1427, 'Ayun', 'Xã Ayun', 'Xã Ayun, Tỉnh Gia Lai', '20505', 'xa', '25'),
(1428, 'Ia Grai', 'Xã Ia Grai', 'Xã Ia Grai, Tỉnh Gia Lai', '20761', 'xa', '25'),
(1429, 'Ia KRai', 'Xã Ia KRai', 'Xã Ia KRai, Tỉnh Gia Lai', '21017', 'xa', '25'),
(1430, 'Ia Hrung', 'Xã Ia Hrung', 'Xã Ia Hrung, Tỉnh Gia Lai', '21273', 'xa', '25'),
(1431, 'Đức Cơ', 'Xã Đức Cơ', 'Xã Đức Cơ, Tỉnh Gia Lai', '21529', 'xa', '25'),
(1432, 'Ia Dơk', 'Xã Ia Dơk', 'Xã Ia Dơk, Tỉnh Gia Lai', '21785', 'xa', '25'),
(1433, 'Ia Krêl', 'Xã Ia Krêl', 'Xã Ia Krêl, Tỉnh Gia Lai', '22041', 'xa', '25'),
(1434, 'Ngô Mây', 'Xã Ngô Mây', 'Xã Ngô Mây, Tỉnh Gia Lai', '22297', 'xa', '25'),
(1435, 'Cát Tiến', 'Xã Cát Tiến', 'Xã Cát Tiến, Tỉnh Gia Lai', '22553', 'xa', '25'),
(1436, 'Đề Gi', 'Xã Đề Gi', 'Xã Đề Gi, Tỉnh Gia Lai', '22809', 'xa', '25'),
(1437, 'Hòa Hội', 'Xã Hòa Hội', 'Xã Hòa Hội, Tỉnh Gia Lai', '23065', 'xa', '25'),
(1438, 'Quy Nhơn', 'Phường Quy Nhơn', 'Phường Quy Nhơn, Tỉnh Gia Lai', '23321', 'phuong', '25'),
(1439, 'Quy Nhơn Tây', 'Phường Quy Nhơn Tây', 'Phường Quy Nhơn Tây, Tỉnh Gia Lai', '23577', 'phuong', '25'),
(1440, 'Quy Nhơn Nam', 'Phường Quy Nhơn Nam', 'Phường Quy Nhơn Nam, Tỉnh Gia Lai', '23833', 'phuong', '25'),
(1441, 'Quy Nhơn Bắc', 'Phường Quy Nhơn Bắc', 'Phường Quy Nhơn Bắc, Tỉnh Gia Lai', '24089', 'phuong', '25'),
(1442, 'Bình Định', 'Phường Bình Định', 'Phường Bình Định, Tỉnh Gia Lai', '24345', 'phuong', '25'),
(1443, 'An Nhơn', 'Phường An Nhơn', 'Phường An Nhơn, Tỉnh Gia Lai', '24601', 'phuong', '25'),
(1444, 'An Nhơn Đông', 'Phường An Nhơn Đông', 'Phường An Nhơn Đông, Tỉnh Gia Lai', '24857', 'phuong', '25'),
(1445, 'An Nhơn Tây', 'Xã An Nhơn Tây', 'Xã An Nhơn Tây, Tỉnh Gia Lai', '25113', 'xa', '25'),
(1446, 'An Nhơn Nam', 'Phường An Nhơn Nam', 'Phường An Nhơn Nam, Tỉnh Gia Lai', '25369', 'phuong', '25'),
(1447, 'An Nhơn Bắc', 'Phường An Nhơn Bắc', 'Phường An Nhơn Bắc, Tỉnh Gia Lai', '25625', 'phuong', '25'),
(1448, 'Bồng Sơn', 'Phường Bồng Sơn', 'Phường Bồng Sơn, Tỉnh Gia Lai', '25881', 'phuong', '25'),
(1449, 'Hoài Nhơn', 'Phường Hoài Nhơn', 'Phường Hoài Nhơn, Tỉnh Gia Lai', '26137', 'phuong', '25'),
(1450, 'Tam Quan', 'Phường Tam Quan', 'Phường Tam Quan, Tỉnh Gia Lai', '26393', 'phuong', '25'),
(1451, 'Hoài Nhơn Đông', 'Phường Hoài Nhơn Đông', 'Phường Hoài Nhơn Đông, Tỉnh Gia Lai', '26649', 'phuong', '25'),
(1452, 'Hoài Nhơn Tây', 'Phường Hoài Nhơn Tây', 'Phường Hoài Nhơn Tây, Tỉnh Gia Lai', '26905', 'phuong', '25'),
(1453, 'Hoài Nhơn Nam', 'Phường Hoài Nhơn Nam', 'Phường Hoài Nhơn Nam, Tỉnh Gia Lai', '27161', 'phuong', '25'),
(1454, 'Hoài Nhơn Bắc', 'Phường Hoài Nhơn Bắc', 'Phường Hoài Nhơn Bắc, Tỉnh Gia Lai', '27417', 'phuong', '25'),
(1455, 'Phù Cát', 'Xã Phù Cát', 'Xã Phù Cát, Tỉnh Gia Lai', '27673', 'xa', '25'),
(1456, 'Xuân An', 'Xã Xuân An', 'Xã Xuân An, Tỉnh Gia Lai', '27929', 'xa', '25'),
(1457, 'Hội Sơn', 'Xã Hội Sơn', 'Xã Hội Sơn, Tỉnh Gia Lai', '28185', 'xa', '25'),
(1458, 'Phù Mỹ', 'Xã Phù Mỹ', 'Xã Phù Mỹ, Tỉnh Gia Lai', '28441', 'xa', '25'),
(1459, 'An Lương', 'Xã An Lương', 'Xã An Lương, Tỉnh Gia Lai', '28697', 'xa', '25'),
(1460, 'Bình Dương', 'Xã Bình Dương', 'Xã Bình Dương, Tỉnh Gia Lai', '28953', 'xa', '25'),
(1461, 'Phù Mỹ Tây', 'Xã Phù Mỹ Tây', 'Xã Phù Mỹ Tây, Tỉnh Gia Lai', '29209', 'xa', '25'),
(1462, 'Phù Mỹ Nam', 'Xã Phù Mỹ Nam', 'Xã Phù Mỹ Nam, Tỉnh Gia Lai', '29465', 'xa', '25'),
(1463, 'Phù Mỹ Bắc', 'Xã Phù Mỹ Bắc', 'Xã Phù Mỹ Bắc, Tỉnh Gia Lai', '29721', 'xa', '25'),
(1464, 'Tuy Phước', 'Xã Tuy Phước', 'Xã Tuy Phước, Tỉnh Gia Lai', '29977', 'xa', '25'),
(1465, 'Tuy Phước Đông', 'Xã Tuy Phước Đông', 'Xã Tuy Phước Đông, Tỉnh Gia Lai', '30233', 'xa', '25'),
(1466, 'Tuy Phước Tây', 'Xã Tuy Phước Tây', 'Xã Tuy Phước Tây, Tỉnh Gia Lai', '30489', 'xa', '25'),
(1467, 'Tuy Phước Bắc', 'Xã Tuy Phước Bắc', 'Xã Tuy Phước Bắc, Tỉnh Gia Lai', '30745', 'xa', '25'),
(1468, 'Bình Khê', 'Xã Bình Khê', 'Xã Bình Khê, Tỉnh Gia Lai', '31001', 'xa', '25'),
(1469, 'Bình Phú', 'Xã Bình Phú', 'Xã Bình Phú, Tỉnh Gia Lai', '31257', 'xa', '25'),
(1470, 'Bình Hiệp', 'Xã Bình Hiệp', 'Xã Bình Hiệp, Tỉnh Gia Lai', '31513', 'xa', '25'),
(1471, 'Bình An', 'Xã Bình An', 'Xã Bình An, Tỉnh Gia Lai', '31769', 'xa', '25'),
(1472, 'Hoài Ân', 'Xã Hoài Ân', 'Xã Hoài Ân, Tỉnh Gia Lai', '32025', 'xa', '25'),
(1473, 'Ân Tường', 'Xã Ân Tường', 'Xã Ân Tường, Tỉnh Gia Lai', '32281', 'xa', '25'),
(1474, 'Kim Sơn', 'Xã Kim Sơn', 'Xã Kim Sơn, Tỉnh Gia Lai', '32537', 'xa', '25'),
(1475, 'Vạn Đức', 'Xã Vạn Đức', 'Xã Vạn Đức, Tỉnh Gia Lai', '32793', 'xa', '25'),
(1476, 'Ân Hảo', 'Xã Ân Hảo', 'Xã Ân Hảo, Tỉnh Gia Lai', '33049', 'xa', '25'),
(1477, 'Vĩnh Thạnh', 'Xã Vĩnh Thạnh', 'Xã Vĩnh Thạnh, Tỉnh Gia Lai', '33305', 'xa', '25'),
(1478, 'Vĩnh Thịnh', 'Xã Vĩnh Thịnh', 'Xã Vĩnh Thịnh, Tỉnh Gia Lai', '33561', 'xa', '25'),
(1479, 'Vĩnh Quang', 'Xã Vĩnh Quang', 'Xã Vĩnh Quang, Tỉnh Gia Lai', '33817', 'xa', '25'),
(1480, 'Vĩnh Sơn', 'Xã Vĩnh Sơn', 'Xã Vĩnh Sơn, Tỉnh Gia Lai', '34073', 'xa', '25'),
(1481, 'Thiên Cầm', 'Xã Thiên Cầm', 'Xã Thiên Cầm, Tỉnh Hà Tĩnh', '282', 'xa', '26'),
(1482, 'Kỳ Xuân', 'Xã Kỳ Xuân', 'Xã Kỳ Xuân, Tỉnh Hà Tĩnh', '538', 'xa', '26'),
(1483, 'Hoành Sơn', 'Phường Hoành Sơn', 'Phường Hoành Sơn, Tỉnh Hà Tĩnh', '794', 'phuong', '26'),
(1484, 'Sơn Kim 1', 'Xã Sơn Kim 1', 'Xã Sơn Kim 1, Tỉnh Hà Tĩnh', '1050', 'xa', '26'),
(1485, 'Sơn Kim 2', 'Xã Sơn Kim 2', 'Xã Sơn Kim 2, Tỉnh Hà Tĩnh', '1306', 'xa', '26'),
(1486, 'Đan Hải', 'Xã Đan Hải', 'Xã Đan Hải, Tỉnh Hà Tĩnh', '1562', 'xa', '26'),
(1487, 'Vũng Áng', 'Phường Vũng Áng', 'Phường Vũng Áng, Tỉnh Hà Tĩnh', '1818', 'phuong', '26'),
(1488, 'Sông Trí', 'Phường Sông Trí', 'Phường Sông Trí, Tỉnh Hà Tĩnh', '2074', 'phuong', '26'),
(1489, 'Hà Huy Tập', 'Phường Hà Huy Tập', 'Phường Hà Huy Tập, Tỉnh Hà Tĩnh', '2330', 'phuong', '26'),
(1490, 'Thành Sen', 'Phường Thành Sen', 'Phường Thành Sen, Tỉnh Hà Tĩnh', '2586', 'phuong', '26'),
(1491, 'Sơn Hồng', 'Xã Sơn Hồng', 'Xã Sơn Hồng, Tỉnh Hà Tĩnh', '2842', 'xa', '26'),
(1492, 'Sơn Tây', 'Xã Sơn Tây', 'Xã Sơn Tây, Tỉnh Hà Tĩnh', '3098', 'xa', '26'),
(1493, 'Sơn Giang', 'Xã Sơn Giang', 'Xã Sơn Giang, Tỉnh Hà Tĩnh', '3354', 'xa', '26'),
(1494, 'Sơn Tiến', 'Xã Sơn Tiến', 'Xã Sơn Tiến, Tỉnh Hà Tĩnh', '3610', 'xa', '26'),
(1495, 'Hương Sơn', 'Xã Hương Sơn', 'Xã Hương Sơn, Tỉnh Hà Tĩnh', '3866', 'xa', '26'),
(1496, 'Tứ Mỹ', 'Xã Tứ Mỹ', 'Xã Tứ Mỹ, Tỉnh Hà Tĩnh', '4122', 'xa', '26'),
(1497, 'Đức Minh', 'Xã Đức Minh', 'Xã Đức Minh, Tỉnh Hà Tĩnh', '4378', 'xa', '26'),
(1498, 'Kim Hoa', 'Xã Kim Hoa', 'Xã Kim Hoa, Tỉnh Hà Tĩnh', '4634', 'xa', '26'),
(1499, 'Vũ Quang', 'Xã Vũ Quang', 'Xã Vũ Quang, Tỉnh Hà Tĩnh', '4890', 'xa', '26'),
(1500, 'Mai Hoa', 'Xã Mai Hoa', 'Xã Mai Hoa, Tỉnh Hà Tĩnh', '5146', 'xa', '26'),
(1501, 'Thượng Đức', 'Xã Thượng Đức', 'Xã Thượng Đức, Tỉnh Hà Tĩnh', '5402', 'xa', '26'),
(1502, 'Đức Đồng', 'Xã Đức Đồng', 'Xã Đức Đồng, Tỉnh Hà Tĩnh', '5658', 'xa', '26'),
(1503, 'Hương Bình', 'Xã Hương Bình', 'Xã Hương Bình, Tỉnh Hà Tĩnh', '5914', 'xa', '26'),
(1504, 'Hương Xuân', 'Xã Hương Xuân', 'Xã Hương Xuân, Tỉnh Hà Tĩnh', '6170', 'xa', '26'),
(1505, 'Phúc Trạch', 'Xã Phúc Trạch', 'Xã Phúc Trạch, Tỉnh Hà Tĩnh', '6426', 'xa', '26'),
(1506, 'Hà Linh', 'Xã Hà Linh', 'Xã Hà Linh, Tỉnh Hà Tĩnh', '6682', 'xa', '26'),
(1507, 'Hương Đô', 'Xã Hương Đô', 'Xã Hương Đô, Tỉnh Hà Tĩnh', '6938', 'xa', '26'),
(1508, 'Hương Phố', 'Xã Hương Phố', 'Xã Hương Phố, Tỉnh Hà Tĩnh', '7194', 'xa', '26'),
(1509, 'Toàn Lưu', 'Xã Toàn Lưu', 'Xã Toàn Lưu, Tỉnh Hà Tĩnh', '7450', 'xa', '26'),
(1510, 'Hải Ninh', 'Phường Hải Ninh', 'Phường Hải Ninh, Tỉnh Hà Tĩnh', '7706', 'phuong', '26'),
(1511, 'Kỳ Anh', 'Xã Kỳ Anh', 'Xã Kỳ Anh, Tỉnh Hà Tĩnh', '7962', 'xa', '26'),
(1512, 'Kỳ Hoa', 'Xã Kỳ Hoa', 'Xã Kỳ Hoa, Tỉnh Hà Tĩnh', '8218', 'xa', '26'),
(1513, 'Kỳ Văn', 'Xã Kỳ Văn', 'Xã Kỳ Văn, Tỉnh Hà Tĩnh', '8474', 'xa', '26'),
(1514, 'Kỳ Khang', 'Xã Kỳ Khang', 'Xã Kỳ Khang, Tỉnh Hà Tĩnh', '8730', 'xa', '26'),
(1515, 'Kỳ Lạc', 'Xã Kỳ Lạc', 'Xã Kỳ Lạc, Tỉnh Hà Tĩnh', '8986', 'xa', '26'),
(1516, 'Kỳ Thượng', 'Xã Kỳ Thượng', 'Xã Kỳ Thượng, Tỉnh Hà Tĩnh', '9242', 'xa', '26'),
(1517, 'Cẩm Xuyên', 'Xã Cẩm Xuyên', 'Xã Cẩm Xuyên, Tỉnh Hà Tĩnh', '9498', 'xa', '26'),
(1518, 'Cẩm Duệ', 'Xã Cẩm Duệ', 'Xã Cẩm Duệ, Tỉnh Hà Tĩnh', '9754', 'xa', '26'),
(1519, 'Cẩm Hưng', 'Xã Cẩm Hưng', 'Xã Cẩm Hưng, Tỉnh Hà Tĩnh', '10010', 'xa', '26'),
(1520, 'Cẩm Lạc', 'Xã Cẩm Lạc', 'Xã Cẩm Lạc, Tỉnh Hà Tĩnh', '10266', 'xa', '26'),
(1521, 'Cẩm Trung', 'Xã Cẩm Trung', 'Xã Cẩm Trung, Tỉnh Hà Tĩnh', '10522', 'xa', '26'),
(1522, 'Yên Hòa', 'Xã Yên Hòa', 'Xã Yên Hòa, Tỉnh Hà Tĩnh', '10778', 'xa', '26'),
(1523, 'Trần Phú', 'Phường Trần Phú', 'Phường Trần Phú, Tỉnh Hà Tĩnh', '11034', 'phuong', '26'),
(1524, 'Thạch Lạc', 'Xã Thạch Lạc', 'Xã Thạch Lạc, Tỉnh Hà Tĩnh', '11290', 'xa', '26'),
(1525, 'Đồng Tiến', 'Xã Đồng Tiến', 'Xã Đồng Tiến, Tỉnh Hà Tĩnh', '11546', 'xa', '26'),
(1526, 'Thạch Khê', 'Xã Thạch Khê', 'Xã Thạch Khê, Tỉnh Hà Tĩnh', '11802', 'xa', '26'),
(1527, 'Cẩm Bình', 'Xã Cẩm Bình', 'Xã Cẩm Bình, Tỉnh Hà Tĩnh', '12058', 'xa', '26'),
(1528, 'Thạch Hà', 'Xã Thạch Hà', 'Xã Thạch Hà, Tỉnh Hà Tĩnh', '12314', 'xa', '26'),
(1529, 'Việt Xuyên', 'Xã Việt Xuyên', 'Xã Việt Xuyên, Tỉnh Hà Tĩnh', '12570', 'xa', '26'),
(1530, 'Đông Kinh', 'Xã Đông Kinh', 'Xã Đông Kinh, Tỉnh Hà Tĩnh', '12826', 'xa', '26'),
(1531, 'Thạch Xuân', 'Xã Thạch Xuân', 'Xã Thạch Xuân, Tỉnh Hà Tĩnh', '13082', 'xa', '26'),
(1532, 'Xuân Lộc', 'Xã Xuân Lộc', 'Xã Xuân Lộc, Tỉnh Hà Tĩnh', '13338', 'xa', '26'),
(1533, 'Can Lộc', 'Xã Can Lộc', 'Xã Can Lộc, Tỉnh Hà Tĩnh', '13594', 'xa', '26'),
(1534, 'Bắc Hồng Lĩnh', 'Phường Bắc Hồng Lĩnh', 'Phường Bắc Hồng Lĩnh, Tỉnh Hà Tĩnh', '13850', 'phuong', '26'),
(1535, 'Nam Hồng Lĩnh', 'Phường Nam Hồng Lĩnh', 'Phường Nam Hồng Lĩnh, Tỉnh Hà Tĩnh', '14106', 'phuong', '26'),
(1536, 'Đức Thịnh', 'Xã Đức Thịnh', 'Xã Đức Thịnh, Tỉnh Hà Tĩnh', '14362', 'xa', '26'),
(1537, 'Nghi Xuân', 'Xã Nghi Xuân', 'Xã Nghi Xuân, Tỉnh Hà Tĩnh', '14618', 'xa', '26'),
(1538, 'Cổ Đạm', 'Xã Cổ Đạm', 'Xã Cổ Đạm, Tỉnh Hà Tĩnh', '14874', 'xa', '26'),
(1539, 'Tiên Điền', 'Xã Tiên Điền', 'Xã Tiên Điền, Tỉnh Hà Tĩnh', '15130', 'xa', '26'),
(1540, 'Đức Thọ', 'Xã Đức Thọ', 'Xã Đức Thọ, Tỉnh Hà Tĩnh', '15386', 'xa', '26'),
(1541, 'Đức Quang', 'Xã Đức Quang', 'Xã Đức Quang, Tỉnh Hà Tĩnh', '15642', 'xa', '26'),
(1542, 'Hương Khê', 'Xã Hương Khê', 'Xã Hương Khê, Tỉnh Hà Tĩnh', '15898', 'xa', '26'),
(1543, 'Gia Hanh', 'Xã Gia Hanh', 'Xã Gia Hanh, Tỉnh Hà Tĩnh', '16154', 'xa', '26'),
(1544, 'Trường Lưu', 'Xã Trường Lưu', 'Xã Trường Lưu, Tỉnh Hà Tĩnh', '16410', 'xa', '26'),
(1545, 'Hồng Lộc', 'Xã Hồng Lộc', 'Xã Hồng Lộc, Tỉnh Hà Tĩnh', '16666', 'xa', '26'),
(1546, 'Lộc Hà', 'Xã Lộc Hà', 'Xã Lộc Hà, Tỉnh Hà Tĩnh', '16922', 'xa', '26'),
(1547, 'Mai Phụ', 'Xã Mai Phụ', 'Xã Mai Phụ, Tỉnh Hà Tĩnh', '17178', 'xa', '26'),
(1548, 'Tùng Lộc', 'Xã Tùng Lộc', 'Xã Tùng Lộc, Tỉnh Hà Tĩnh', '17434', 'xa', '26'),
(1549, 'Đồng Lộc', 'Xã Đồng Lộc', 'Xã Đồng Lộc, Tỉnh Hà Tĩnh', '17690', 'xa', '26'),
(1550, 'Hiệp Cường', 'Xã Hiệp Cường', 'Xã Hiệp Cường, Tỉnh Hưng Yên', '283', 'xa', '27'),
(1551, 'Đông Thái Ninh', 'Xã Đông Thái Ninh', 'Xã Đông Thái Ninh, Tỉnh Hưng Yên', '539', 'xa', '27'),
(1552, 'Sơn Nam', 'Phường Sơn Nam', 'Phường Sơn Nam, Tỉnh Hưng Yên', '795', 'phuong', '27'),
(1553, 'Phố Hiến', 'Phường Phố Hiến', 'Phường Phố Hiến, Tỉnh Hưng Yên', '1051', 'phuong', '27'),
(1554, 'Hồng Châu', 'Phường Hồng Châu', 'Phường Hồng Châu, Tỉnh Hưng Yên', '1307', 'phuong', '27'),
(1555, 'Tân Hưng', 'Xã Tân Hưng', 'Xã Tân Hưng, Tỉnh Hưng Yên', '1563', 'xa', '27'),
(1556, 'Hoàng Hoa Thám', 'Xã Hoàng Hoa Thám', 'Xã Hoàng Hoa Thám, Tỉnh Hưng Yên', '1819', 'xa', '27'),
(1557, 'Tiên Lữ', 'Xã Tiên Lữ', 'Xã Tiên Lữ, Tỉnh Hưng Yên', '2075', 'xa', '27'),
(1558, 'Tiên Hoa', 'Xã Tiên Hoa', 'Xã Tiên Hoa, Tỉnh Hưng Yên', '2331', 'xa', '27'),
(1559, 'Quang Hưng', 'Xã Quang Hưng', 'Xã Quang Hưng, Tỉnh Hưng Yên', '2587', 'xa', '27'),
(1560, 'Đoàn Đào', 'Xã Đoàn Đào', 'Xã Đoàn Đào, Tỉnh Hưng Yên', '2843', 'xa', '27'),
(1561, 'Tiên Tiến', 'Xã Tiên Tiến', 'Xã Tiên Tiến, Tỉnh Hưng Yên', '3099', 'xa', '27'),
(1562, 'Tống Trân', 'Xã Tống Trân', 'Xã Tống Trân, Tỉnh Hưng Yên', '3355', 'xa', '27'),
(1563, 'Lương Bằng', 'Xã Lương Bằng', 'Xã Lương Bằng, Tỉnh Hưng Yên', '3611', 'xa', '27'),
(1564, 'Nghĩa Dân', 'Xã Nghĩa Dân', 'Xã Nghĩa Dân, Tỉnh Hưng Yên', '3867', 'xa', '27'),
(1565, 'Đức Hợp', 'Xã Đức Hợp', 'Xã Đức Hợp, Tỉnh Hưng Yên', '4123', 'xa', '27'),
(1566, 'Ân Thi', 'Xã Ân Thi', 'Xã Ân Thi, Tỉnh Hưng Yên', '4379', 'xa', '27'),
(1567, 'Xuân Trúc', 'Xã Xuân Trúc', 'Xã Xuân Trúc, Tỉnh Hưng Yên', '4635', 'xa', '27'),
(1568, 'Phạm Ngũ Lão', 'Xã Phạm Ngũ Lão', 'Xã Phạm Ngũ Lão, Tỉnh Hưng Yên', '4891', 'xa', '27'),
(1569, 'Nguyễn Trãi', 'Xã Nguyễn Trãi', 'Xã Nguyễn Trãi, Tỉnh Hưng Yên', '5147', 'xa', '27'),
(1570, 'Hồng Quang', 'Xã Hồng Quang', 'Xã Hồng Quang, Tỉnh Hưng Yên', '5403', 'xa', '27'),
(1571, 'Khoái Châu', 'Xã Khoái Châu', 'Xã Khoái Châu, Tỉnh Hưng Yên', '5659', 'xa', '27'),
(1572, 'Triệu Việt Vương', 'Xã Triệu Việt Vương', 'Xã Triệu Việt Vương, Tỉnh Hưng Yên', '5915', 'xa', '27'),
(1573, 'Việt Tiến', 'Xã Việt Tiến', 'Xã Việt Tiến, Tỉnh Hưng Yên', '6171', 'xa', '27'),
(1574, 'Chí Minh', 'Xã Chí Minh', 'Xã Chí Minh, Tỉnh Hưng Yên', '6427', 'xa', '27'),
(1575, 'Châu Ninh', 'Xã Châu Ninh', 'Xã Châu Ninh, Tỉnh Hưng Yên', '6683', 'xa', '27'),
(1576, 'Yên Mỹ', 'Xã Yên Mỹ', 'Xã Yên Mỹ, Tỉnh Hưng Yên', '6939', 'xa', '27'),
(1577, 'Việt Yên', 'Xã Việt Yên', 'Xã Việt Yên, Tỉnh Hưng Yên', '7195', 'xa', '27'),
(1578, 'Hoàn Long', 'Xã Hoàn Long', 'Xã Hoàn Long, Tỉnh Hưng Yên', '7451', 'xa', '27'),
(1579, 'Nguyễn Văn Linh', 'Xã Nguyễn Văn Linh', 'Xã Nguyễn Văn Linh, Tỉnh Hưng Yên', '7707', 'xa', '27'),
(1580, 'Mỹ Hào', 'Phường Mỹ Hào', 'Phường Mỹ Hào, Tỉnh Hưng Yên', '7963', 'phuong', '27'),
(1581, 'Đường Hào', 'Phường Đường Hào', 'Phường Đường Hào, Tỉnh Hưng Yên', '8219', 'phuong', '27'),
(1582, 'Thượng Hồng', 'Phường Thượng Hồng', 'Phường Thượng Hồng, Tỉnh Hưng Yên', '8475', 'phuong', '27'),
(1583, 'Như Quỳnh', 'Xã Như Quỳnh', 'Xã Như Quỳnh, Tỉnh Hưng Yên', '8731', 'xa', '27'),
(1584, 'Lạc Đạo', 'Xã Lạc Đạo', 'Xã Lạc Đạo, Tỉnh Hưng Yên', '8987', 'xa', '27'),
(1585, 'Đại Đồng', 'Xã Đại Đồng', 'Xã Đại Đồng, Tỉnh Hưng Yên', '9243', 'xa', '27'),
(1586, 'Nghĩa Trụ', 'Xã Nghĩa Trụ', 'Xã Nghĩa Trụ, Tỉnh Hưng Yên', '9499', 'xa', '27'),
(1587, 'Phụng Công', 'Xã Phụng Công', 'Xã Phụng Công, Tỉnh Hưng Yên', '9755', 'xa', '27'),
(1588, 'Văn Giang', 'Xã Văn Giang', 'Xã Văn Giang, Tỉnh Hưng Yên', '10011', 'xa', '27'),
(1589, 'Mễ Sở', 'Xã Mễ Sở', 'Xã Mễ Sở, Tỉnh Hưng Yên', '10267', 'xa', '27'),
(1590, 'Thái Bình', 'Phường Thái Bình', 'Phường Thái Bình, Tỉnh Hưng Yên', '10523', 'phuong', '27'),
(1591, 'Trần Lãm', 'Phường Trần Lãm', 'Phường Trần Lãm, Tỉnh Hưng Yên', '10779', 'phuong', '27'),
(1592, 'Trần Hưng Đạo', 'Phường Trần Hưng Đạo', 'Phường Trần Hưng Đạo, Tỉnh Hưng Yên', '11035', 'phuong', '27'),
(1593, 'Trà Lý', 'Phường Trà Lý', 'Phường Trà Lý, Tỉnh Hưng Yên', '11291', 'phuong', '27'),
(1594, 'Vũ Phúc', 'Phường Vũ Phúc', 'Phường Vũ Phúc, Tỉnh Hưng Yên', '11547', 'phuong', '27'),
(1595, 'Thái Thụy', 'Xã Thái Thụy', 'Xã Thái Thụy, Tỉnh Hưng Yên', '11803', 'xa', '27'),
(1596, 'Đông Thụy Anh', 'Xã Đông Thụy Anh', 'Xã Đông Thụy Anh, Tỉnh Hưng Yên', '12059', 'xa', '27'),
(1597, 'Bắc Thụy Anh', 'Xã Bắc Thụy Anh', 'Xã Bắc Thụy Anh, Tỉnh Hưng Yên', '12315', 'xa', '27'),
(1598, 'Thụy Anh', 'Xã Thụy Anh', 'Xã Thụy Anh, Tỉnh Hưng Yên', '12571', 'xa', '27'),
(1599, 'Nam Thụy Anh', 'Xã Nam Thụy Anh', 'Xã Nam Thụy Anh, Tỉnh Hưng Yên', '12827', 'xa', '27'),
(1600, 'Bắc Thái Ninh', 'Xã Bắc Thái Ninh', 'Xã Bắc Thái Ninh, Tỉnh Hưng Yên', '13083', 'xa', '27'),
(1601, 'Thái Ninh', 'Xã Thái Ninh', 'Xã Thái Ninh, Tỉnh Hưng Yên', '13339', 'xa', '27'),
(1602, 'Nam Thái Ninh', 'Xã Nam Thái Ninh', 'Xã Nam Thái Ninh, Tỉnh Hưng Yên', '13595', 'xa', '27'),
(1603, 'Tây Thái Ninh', 'Xã Tây Thái Ninh', 'Xã Tây Thái Ninh, Tỉnh Hưng Yên', '13851', 'xa', '27'),
(1604, 'Tây Thụy Anh', 'Xã Tây Thụy Anh', 'Xã Tây Thụy Anh, Tỉnh Hưng Yên', '14107', 'xa', '27'),
(1605, 'Tiền Hải', 'Xã Tiền Hải', 'Xã Tiền Hải, Tỉnh Hưng Yên', '14363', 'xa', '27'),
(1606, 'Tây Tiền Hải', 'Xã Tây Tiền Hải', 'Xã Tây Tiền Hải, Tỉnh Hưng Yên', '14619', 'xa', '27'),
(1607, 'Ái Quốc', 'Xã Ái Quốc', 'Xã Ái Quốc, Tỉnh Hưng Yên', '14875', 'xa', '27'),
(1608, 'Đồng Châu', 'Xã Đồng Châu', 'Xã Đồng Châu, Tỉnh Hưng Yên', '15131', 'xa', '27'),
(1609, 'Đông Tiền Hải', 'Xã Đông Tiền Hải', 'Xã Đông Tiền Hải, Tỉnh Hưng Yên', '15387', 'xa', '27'),
(1610, 'Nam Cường', 'Xã Nam Cường', 'Xã Nam Cường, Tỉnh Hưng Yên', '15643', 'xa', '27'),
(1611, 'Hưng Phú', 'Xã Hưng Phú', 'Xã Hưng Phú, Tỉnh Hưng Yên', '15899', 'xa', '27'),
(1612, 'Đông Quan', 'Xã Đông Quan', 'Xã Đông Quan, Tỉnh Hưng Yên', '16155', 'xa', '27'),
(1613, 'Nam Tiên Hưng', 'Xã Nam Tiên Hưng', 'Xã Nam Tiên Hưng, Tỉnh Hưng Yên', '16411', 'xa', '27'),
(1614, 'Tiên Hưng', 'Xã Tiên Hưng', 'Xã Tiên Hưng, Tỉnh Hưng Yên', '16667', 'xa', '27'),
(1615, 'Hưng Hà', 'Xã Hưng Hà', 'Xã Hưng Hà, Tỉnh Hưng Yên', '16923', 'xa', '27'),
(1616, 'Tiên La', 'Xã Tiên La', 'Xã Tiên La, Tỉnh Hưng Yên', '17179', 'xa', '27'),
(1617, 'Lê Quý Đôn', 'Xã Lê Quý Đôn', 'Xã Lê Quý Đôn, Tỉnh Hưng Yên', '17435', 'xa', '27'),
(1618, 'Hồng Minh', 'Xã Hồng Minh', 'Xã Hồng Minh, Tỉnh Hưng Yên', '17691', 'xa', '27'),
(1619, 'Thần Khê', 'Xã Thần Khê', 'Xã Thần Khê, Tỉnh Hưng Yên', '17947', 'xa', '27'),
(1620, 'Diên Hà', 'Xã Diên Hà', 'Xã Diên Hà, Tỉnh Hưng Yên', '18203', 'xa', '27'),
(1621, 'Ngự Thiên', 'Xã Ngự Thiên', 'Xã Ngự Thiên, Tỉnh Hưng Yên', '18459', 'xa', '27'),
(1622, 'Long Hưng', 'Xã Long Hưng', 'Xã Long Hưng, Tỉnh Hưng Yên', '18715', 'xa', '27'),
(1623, 'Kiến Xương', 'Xã Kiến Xương', 'Xã Kiến Xương, Tỉnh Hưng Yên', '18971', 'xa', '27'),
(1624, 'Lê Lợi', 'Xã Lê Lợi', 'Xã Lê Lợi, Tỉnh Hưng Yên', '19227', 'xa', '27'),
(1625, 'Quang Lịch', 'Xã Quang Lịch', 'Xã Quang Lịch, Tỉnh Hưng Yên', '19483', 'xa', '27'),
(1626, 'Vũ Quý', 'Xã Vũ Quý', 'Xã Vũ Quý, Tỉnh Hưng Yên', '19739', 'xa', '27'),
(1627, 'Bình Thanh', 'Xã Bình Thanh', 'Xã Bình Thanh, Tỉnh Hưng Yên', '19995', 'xa', '27'),
(1628, 'Bình Định', 'Xã Bình Định', 'Xã Bình Định, Tỉnh Hưng Yên', '20251', 'xa', '27'),
(1629, 'Hồng Vũ', 'Xã Hồng Vũ', 'Xã Hồng Vũ, Tỉnh Hưng Yên', '20507', 'xa', '27'),
(1630, 'Bình Nguyên', 'Xã Bình Nguyên', 'Xã Bình Nguyên, Tỉnh Hưng Yên', '20763', 'xa', '27'),
(1631, 'Trà Giang', 'Xã Trà Giang', 'Xã Trà Giang, Tỉnh Hưng Yên', '21019', 'xa', '27'),
(1632, 'Vũ Thư', 'Xã Vũ Thư', 'Xã Vũ Thư, Tỉnh Hưng Yên', '21275', 'xa', '27'),
(1633, 'Thư Trì', 'Xã Thư Trì', 'Xã Thư Trì, Tỉnh Hưng Yên', '21531', 'xa', '27'),
(1634, 'Tân Thuận', 'Xã Tân Thuận', 'Xã Tân Thuận, Tỉnh Hưng Yên', '21787', 'xa', '27'),
(1635, 'Thư Vũ', 'Xã Thư Vũ', 'Xã Thư Vũ, Tỉnh Hưng Yên', '22043', 'xa', '27'),
(1636, 'Vũ Tiên', 'Xã Vũ Tiên', 'Xã Vũ Tiên, Tỉnh Hưng Yên', '22299', 'xa', '27'),
(1637, 'Vạn Xuân', 'Xã Vạn Xuân', 'Xã Vạn Xuân, Tỉnh Hưng Yên', '22555', 'xa', '27'),
(1638, 'Nam Tiền Hải', 'Xã Nam Tiền Hải', 'Xã Nam Tiền Hải, Tỉnh Hưng Yên', '22811', 'xa', '27'),
(1639, 'Quỳnh Phụ', 'Xã Quỳnh Phụ', 'Xã Quỳnh Phụ, Tỉnh Hưng Yên', '23067', 'xa', '27'),
(1640, 'Minh Thọ', 'Xã Minh Thọ', 'Xã Minh Thọ, Tỉnh Hưng Yên', '23323', 'xa', '27'),
(1641, 'Nguyễn Du', 'Xã Nguyễn Du', 'Xã Nguyễn Du, Tỉnh Hưng Yên', '23579', 'xa', '27'),
(1642, 'Quỳnh An', 'Xã Quỳnh An', 'Xã Quỳnh An, Tỉnh Hưng Yên', '23835', 'xa', '27'),
(1643, 'Ngọc Lâm', 'Xã Ngọc Lâm', 'Xã Ngọc Lâm, Tỉnh Hưng Yên', '24091', 'xa', '27'),
(1644, 'Đồng Bằng', 'Xã Đồng Bằng', 'Xã Đồng Bằng, Tỉnh Hưng Yên', '24347', 'xa', '27'),
(1645, 'A Sào', 'Xã A Sào', 'Xã A Sào, Tỉnh Hưng Yên', '24603', 'xa', '27'),
(1646, 'Phụ Dực', 'Xã Phụ Dực', 'Xã Phụ Dực, Tỉnh Hưng Yên', '24859', 'xa', '27'),
(1647, 'Tân Tiến', 'Xã Tân Tiến', 'Xã Tân Tiến, Tỉnh Hưng Yên', '25115', 'xa', '27'),
(1648, 'Đông Hưng', 'Xã Đông Hưng', 'Xã Đông Hưng, Tỉnh Hưng Yên', '25371', 'xa', '27'),
(1649, 'Bắc Tiên Hưng', 'Xã Bắc Tiên Hưng', 'Xã Bắc Tiên Hưng, Tỉnh Hưng Yên', '25627', 'xa', '27'),
(1650, 'Đông Tiên Hưng', 'Xã Đông Tiên Hưng', 'Xã Đông Tiên Hưng, Tỉnh Hưng Yên', '25883', 'xa', '27'),
(1651, 'Nam Đông Hưng', 'Xã Nam Đông Hưng', 'Xã Nam Đông Hưng, Tỉnh Hưng Yên', '26139', 'xa', '27'),
(1652, 'Bắc Đông Quan', 'Xã Bắc Đông Quan', 'Xã Bắc Đông Quan, Tỉnh Hưng Yên', '26395', 'xa', '27'),
(1653, 'Bắc Đông Hưng', 'Xã Bắc Đông Hưng', 'Xã Bắc Đông Hưng, Tỉnh Hưng Yên', '26651', 'xa', '27'),
(1654, 'Đô Vinh', 'Phường Đô Vinh', 'Phường Đô Vinh, Tỉnh Khánh Hòa', '284', 'phuong', '28'),
(1655, 'Phan Rang', 'Phường Phan Rang', 'Phường Phan Rang, Tỉnh Khánh Hòa', '540', 'phuong', '28'),
(1656, 'Bảo An', 'Phường Bảo An', 'Phường Bảo An, Tỉnh Khánh Hòa', '796', 'phuong', '28'),
(1657, 'Nam Ninh Hòa', 'Xã Nam Ninh Hòa', 'Xã Nam Ninh Hòa, Tỉnh Khánh Hòa', '1052', 'xa', '28'),
(1658, 'Vạn Hưng', 'Xã Vạn Hưng', 'Xã Vạn Hưng, Tỉnh Khánh Hòa', '1308', 'xa', '28'),
(1659, 'Tu Bông', 'Xã Tu Bông', 'Xã Tu Bông, Tỉnh Khánh Hòa', '1564', 'xa', '28'),
(1660, 'Vạn Thắng', 'Xã Vạn Thắng', 'Xã Vạn Thắng, Tỉnh Khánh Hòa', '1820', 'xa', '28'),
(1661, 'Đại Lãnh', 'Xã Đại Lãnh', 'Xã Đại Lãnh, Tỉnh Khánh Hòa', '2076', 'xa', '28'),
(1662, 'Bắc Cam Ranh', 'Phường Bắc Cam Ranh', 'Phường Bắc Cam Ranh, Tỉnh Khánh Hòa', '2332', 'phuong', '28'),
(1663, 'Nam Cam Ranh', 'Xã Nam Cam Ranh', 'Xã Nam Cam Ranh, Tỉnh Khánh Hòa', '2588', 'xa', '28'),
(1664, 'Phước Dinh', 'Xã Phước Dinh', 'Xã Phước Dinh, Tỉnh Khánh Hòa', '2844', 'xa', '28'),
(1665, 'Nha Trang', 'Phường Nha Trang', 'Phường Nha Trang, Tỉnh Khánh Hòa', '3100', 'phuong', '28'),
(1666, 'Bắc Nha Trang', 'Phường Bắc Nha Trang', 'Phường Bắc Nha Trang, Tỉnh Khánh Hòa', '3356', 'phuong', '28'),
(1667, 'Ninh Chử', 'Phường Ninh Chử', 'Phường Ninh Chử, Tỉnh Khánh Hòa', '3612', 'phuong', '28'),
(1668, 'Vĩnh Hải', 'Xã Vĩnh Hải', 'Xã Vĩnh Hải, Tỉnh Khánh Hòa', '3868', 'xa', '28'),
(1669, 'Cam Lâm', 'Xã Cam Lâm', 'Xã Cam Lâm, Tỉnh Khánh Hòa', '4124', 'xa', '28'),
(1670, 'Cam An', 'Xã Cam An', 'Xã Cam An, Tỉnh Khánh Hòa', '4380', 'xa', '28'),
(1671, 'Cam Hiệp', 'Xã Cam Hiệp', 'Xã Cam Hiệp, Tỉnh Khánh Hòa', '4636', 'xa', '28'),
(1672, 'Suối Dầu', 'Xã Suối Dầu', 'Xã Suối Dầu, Tỉnh Khánh Hòa', '4892', 'xa', '28'),
(1673, 'Đông Ninh Hòa', 'Phường Đông Ninh Hòa', 'Phường Đông Ninh Hòa, Tỉnh Khánh Hòa', '5148', 'phuong', '28'),
(1674, 'Đặc Khu Trường Sa', 'Xã Đặc Khu Trường Sa', 'Xã Đặc Khu Trường Sa, Tỉnh Khánh Hòa', '5404', 'xa', '28'),
(1675, 'Đông Hải', 'Phường Đông Hải', 'Phường Đông Hải, Tỉnh Khánh Hòa', '5660', 'phuong', '28');
INSERT INTO `vn_locations` (`id`, `name`, `full_name`, `full_path`, `code`, `level`, `parent_code`) VALUES
(1676, 'Nam Nha Trang', 'Phường Nam Nha Trang', 'Phường Nam Nha Trang, Tỉnh Khánh Hòa', '5916', 'phuong', '28'),
(1677, 'Cam Ranh', 'Phường Cam Ranh', 'Phường Cam Ranh, Tỉnh Khánh Hòa', '6172', 'phuong', '28'),
(1678, 'Cam Linh', 'Phường Cam Linh', 'Phường Cam Linh, Tỉnh Khánh Hòa', '6428', 'phuong', '28'),
(1679, 'Ba Ngòi', 'Phường Ba Ngòi', 'Phường Ba Ngòi, Tỉnh Khánh Hòa', '6684', 'phuong', '28'),
(1680, 'Bắc Ninh Hòa', 'Xã Bắc Ninh Hòa', 'Xã Bắc Ninh Hòa, Tỉnh Khánh Hòa', '6940', 'xa', '28'),
(1681, 'Ninh Hòa', 'Phường Ninh Hòa', 'Phường Ninh Hòa, Tỉnh Khánh Hòa', '7196', 'phuong', '28'),
(1682, 'Tân Định', 'Xã Tân Định', 'Xã Tân Định, Tỉnh Khánh Hòa', '7452', 'xa', '28'),
(1683, 'Hòa Thắng', 'Phường Hòa Thắng', 'Phường Hòa Thắng, Tỉnh Khánh Hòa', '7708', 'phuong', '28'),
(1684, 'Tây Ninh Hòa', 'Xã Tây Ninh Hòa', 'Xã Tây Ninh Hòa, Tỉnh Khánh Hòa', '7964', 'xa', '28'),
(1685, 'Hòa Trí', 'Xã Hòa Trí', 'Xã Hòa Trí, Tỉnh Khánh Hòa', '8220', 'xa', '28'),
(1686, 'Vạn Ninh', 'Xã Vạn Ninh', 'Xã Vạn Ninh, Tỉnh Khánh Hòa', '8476', 'xa', '28'),
(1687, 'Diên Khánh', 'Xã Diên Khánh', 'Xã Diên Khánh, Tỉnh Khánh Hòa', '8732', 'xa', '28'),
(1688, 'Diên Lạc', 'Xã Diên Lạc', 'Xã Diên Lạc, Tỉnh Khánh Hòa', '8988', 'xa', '28'),
(1689, 'Diên Điền', 'Xã Diên Điền', 'Xã Diên Điền, Tỉnh Khánh Hòa', '9244', 'xa', '28'),
(1690, 'Diên Lâm', 'Xã Diên Lâm', 'Xã Diên Lâm, Tỉnh Khánh Hòa', '9500', 'xa', '28'),
(1691, 'Diên Thọ', 'Xã Diên Thọ', 'Xã Diên Thọ, Tỉnh Khánh Hòa', '9756', 'xa', '28'),
(1692, 'Suối Hiệp', 'Xã Suối Hiệp', 'Xã Suối Hiệp, Tỉnh Khánh Hòa', '10012', 'xa', '28'),
(1693, 'Bắc Khánh Vĩnh', 'Xã Bắc Khánh Vĩnh', 'Xã Bắc Khánh Vĩnh, Tỉnh Khánh Hòa', '10268', 'xa', '28'),
(1694, 'Trung Khánh Vĩnh', 'Xã Trung Khánh Vĩnh', 'Xã Trung Khánh Vĩnh, Tỉnh Khánh Hòa', '10524', 'xa', '28'),
(1695, 'Tây Khánh Vĩnh', 'Xã Tây Khánh Vĩnh', 'Xã Tây Khánh Vĩnh, Tỉnh Khánh Hòa', '10780', 'xa', '28'),
(1696, 'Nam Khánh Vĩnh', 'Xã Nam Khánh Vĩnh', 'Xã Nam Khánh Vĩnh, Tỉnh Khánh Hòa', '11036', 'xa', '28'),
(1697, 'Khánh Vĩnh', 'Xã Khánh Vĩnh', 'Xã Khánh Vĩnh, Tỉnh Khánh Hòa', '11292', 'xa', '28'),
(1698, 'Khánh Sơn', 'Xã Khánh Sơn', 'Xã Khánh Sơn, Tỉnh Khánh Hòa', '11548', 'xa', '28'),
(1699, 'Tây Khánh Sơn', 'Xã Tây Khánh Sơn', 'Xã Tây Khánh Sơn, Tỉnh Khánh Hòa', '11804', 'xa', '28'),
(1700, 'Đông Khánh Sơn', 'Xã Đông Khánh Sơn', 'Xã Đông Khánh Sơn, Tỉnh Khánh Hòa', '12060', 'xa', '28'),
(1701, 'Ninh Phước', 'Xã Ninh Phước', 'Xã Ninh Phước, Tỉnh Khánh Hòa', '12316', 'xa', '28'),
(1702, 'Phước Hữu', 'Xã Phước Hữu', 'Xã Phước Hữu, Tỉnh Khánh Hòa', '12572', 'xa', '28'),
(1703, 'Phước Hậu', 'Xã Phước Hậu', 'Xã Phước Hậu, Tỉnh Khánh Hòa', '12828', 'xa', '28'),
(1704, 'Thuận Nam', 'Xã Thuận Nam', 'Xã Thuận Nam, Tỉnh Khánh Hòa', '13084', 'xa', '28'),
(1705, 'Cà Ná', 'Xã Cà Ná', 'Xã Cà Ná, Tỉnh Khánh Hòa', '13340', 'xa', '28'),
(1706, 'Phước Hà', 'Xã Phước Hà', 'Xã Phước Hà, Tỉnh Khánh Hòa', '13596', 'xa', '28'),
(1707, 'Ninh Hải', 'Xã Ninh Hải', 'Xã Ninh Hải, Tỉnh Khánh Hòa', '13852', 'xa', '28'),
(1708, 'Xuân Hải', 'Xã Xuân Hải', 'Xã Xuân Hải, Tỉnh Khánh Hòa', '14108', 'xa', '28'),
(1709, 'Thuận Bắc', 'Xã Thuận Bắc', 'Xã Thuận Bắc, Tỉnh Khánh Hòa', '14364', 'xa', '28'),
(1710, 'Công Hải', 'Xã Công Hải', 'Xã Công Hải, Tỉnh Khánh Hòa', '14620', 'xa', '28'),
(1711, 'Ninh Sơn', 'Xã Ninh Sơn', 'Xã Ninh Sơn, Tỉnh Khánh Hòa', '14876', 'xa', '28'),
(1712, 'Lâm Sơn', 'Xã Lâm Sơn', 'Xã Lâm Sơn, Tỉnh Khánh Hòa', '15132', 'xa', '28'),
(1713, 'Anh Dũng', 'Xã Anh Dũng', 'Xã Anh Dũng, Tỉnh Khánh Hòa', '15388', 'xa', '28'),
(1714, 'Mỹ Sơn', 'Xã Mỹ Sơn', 'Xã Mỹ Sơn, Tỉnh Khánh Hòa', '15644', 'xa', '28'),
(1715, 'Bác Ái Đông', 'Xã Bác Ái Đông', 'Xã Bác Ái Đông, Tỉnh Khánh Hòa', '15900', 'xa', '28'),
(1716, 'Bác Ái', 'Xã Bác Ái', 'Xã Bác Ái, Tỉnh Khánh Hòa', '16156', 'xa', '28'),
(1717, 'Bác Ái Tây', 'Xã Bác Ái Tây', 'Xã Bác Ái Tây, Tỉnh Khánh Hòa', '16412', 'xa', '28'),
(1718, 'Mỹ Bình', 'Phường Mỹ Bình', 'Phường Mỹ Bình, Tỉnh Khánh Hòa', '16668', 'phuong', '28'),
(1719, 'Tà Tổng', 'Xã Tà Tổng', 'Xã Tà Tổng, Tỉnh Lai Châu', '285', 'xa', '29'),
(1720, 'Mù Cả', 'Xã Mù Cả', 'Xã Mù Cả, Tỉnh Lai Châu', '541', 'xa', '29'),
(1721, 'Thu Lũm', 'Xã Thu Lũm', 'Xã Thu Lũm, Tỉnh Lai Châu', '797', 'xa', '29'),
(1722, 'Pa Ủ', 'Xã Pa Ủ', 'Xã Pa Ủ, Tỉnh Lai Châu', '1053', 'xa', '29'),
(1723, 'Nậm Cuổi', 'Xã Nậm Cuổi', 'Xã Nậm Cuổi, Tỉnh Lai Châu', '1309', 'xa', '29'),
(1724, 'Nậm Mạ', 'Xã Nậm Mạ', 'Xã Nậm Mạ, Tỉnh Lai Châu', '1565', 'xa', '29'),
(1725, 'Lê Lợi', 'Xã Lê Lợi', 'Xã Lê Lợi, Tỉnh Lai Châu', '1821', 'xa', '29'),
(1726, 'Nậm Hàng', 'Xã Nậm Hàng', 'Xã Nậm Hàng, Tỉnh Lai Châu', '2077', 'xa', '29'),
(1727, 'Mường Kim', 'Xã Mường Kim', 'Xã Mường Kim, Tỉnh Lai Châu', '2333', 'xa', '29'),
(1728, 'Khoen On', 'Xã Khoen On', 'Xã Khoen On, Tỉnh Lai Châu', '2589', 'xa', '29'),
(1729, 'Than Uyên', 'Xã Than Uyên', 'Xã Than Uyên, Tỉnh Lai Châu', '2845', 'xa', '29'),
(1730, 'Mường Than', 'Xã Mường Than', 'Xã Mường Than, Tỉnh Lai Châu', '3101', 'xa', '29'),
(1731, 'Pắc Ta', 'Xã Pắc Ta', 'Xã Pắc Ta, Tỉnh Lai Châu', '3357', 'xa', '29'),
(1732, 'Nậm Sỏ', 'Xã Nậm Sỏ', 'Xã Nậm Sỏ, Tỉnh Lai Châu', '3613', 'xa', '29'),
(1733, 'Tân Uyên', 'Xã Tân Uyên', 'Xã Tân Uyên, Tỉnh Lai Châu', '3869', 'xa', '29'),
(1734, 'Mường Khoa', 'Xã Mường Khoa', 'Xã Mường Khoa, Tỉnh Lai Châu', '4125', 'xa', '29'),
(1735, 'Bản Bo', 'Xã Bản Bo', 'Xã Bản Bo, Tỉnh Lai Châu', '4381', 'xa', '29'),
(1736, 'Bình Lư', 'Xã Bình Lư', 'Xã Bình Lư, Tỉnh Lai Châu', '4637', 'xa', '29'),
(1737, 'Tả Lèng', 'Xã Tả Lèng', 'Xã Tả Lèng, Tỉnh Lai Châu', '4893', 'xa', '29'),
(1738, 'Khun Há', 'Xã Khun Há', 'Xã Khun Há, Tỉnh Lai Châu', '5149', 'xa', '29'),
(1739, 'Tân Phong', 'Phường Tân Phong', 'Phường Tân Phong, Tỉnh Lai Châu', '5405', 'phuong', '29'),
(1740, 'Đoàn Kết', 'Phường Đoàn Kết', 'Phường Đoàn Kết, Tỉnh Lai Châu', '5661', 'phuong', '29'),
(1741, 'Sin Suối Hồ', 'Xã Sin Suối Hồ', 'Xã Sin Suối Hồ, Tỉnh Lai Châu', '5917', 'xa', '29'),
(1742, 'Phong Thổ', 'Xã Phong Thổ', 'Xã Phong Thổ, Tỉnh Lai Châu', '6173', 'xa', '29'),
(1743, 'Sì Lở Lầu', 'Xã Sì Lở Lầu', 'Xã Sì Lở Lầu, Tỉnh Lai Châu', '6429', 'xa', '29'),
(1744, 'Dào San', 'Xã Dào San', 'Xã Dào San, Tỉnh Lai Châu', '6685', 'xa', '29'),
(1745, 'Khổng Lào', 'Xã Khổng Lào', 'Xã Khổng Lào, Tỉnh Lai Châu', '6941', 'xa', '29'),
(1746, 'Tủa Sín Chải', 'Xã Tủa Sín Chải', 'Xã Tủa Sín Chải, Tỉnh Lai Châu', '7197', 'xa', '29'),
(1747, 'Sìn Hồ', 'Xã Sìn Hồ', 'Xã Sìn Hồ, Tỉnh Lai Châu', '7453', 'xa', '29'),
(1748, 'Hồng Thu', 'Xã Hồng Thu', 'Xã Hồng Thu, Tỉnh Lai Châu', '7709', 'xa', '29'),
(1749, 'Nậm Tăm', 'Xã Nậm Tăm', 'Xã Nậm Tăm, Tỉnh Lai Châu', '7965', 'xa', '29'),
(1750, 'Pu Sam Cáp', 'Xã Pu Sam Cáp', 'Xã Pu Sam Cáp, Tỉnh Lai Châu', '8221', 'xa', '29'),
(1751, 'Mường Mô', 'Xã Mường Mô', 'Xã Mường Mô, Tỉnh Lai Châu', '8477', 'xa', '29'),
(1752, 'Hua Bun', 'Xã Hua Bun', 'Xã Hua Bun, Tỉnh Lai Châu', '8733', 'xa', '29'),
(1753, 'Pa Tần', 'Xã Pa Tần', 'Xã Pa Tần, Tỉnh Lai Châu', '8989', 'xa', '29'),
(1754, 'Bum Nưa', 'Xã Bum Nưa', 'Xã Bum Nưa, Tỉnh Lai Châu', '9245', 'xa', '29'),
(1755, 'Bum Tở', 'Xã Bum Tở', 'Xã Bum Tở, Tỉnh Lai Châu', '9501', 'xa', '29'),
(1756, 'Mường Tè', 'Xã Mường Tè', 'Xã Mường Tè, Tỉnh Lai Châu', '9757', 'xa', '29'),
(1757, 'Quảng Hòa', 'Xã Quảng Hòa', 'Xã Quảng Hòa, Tỉnh Lâm Đồng', '286', 'xa', '30'),
(1758, 'Quảng Sơn', 'Xã Quảng Sơn', 'Xã Quảng Sơn, Tỉnh Lâm Đồng', '542', 'xa', '30'),
(1759, 'Quảng Trực', 'Xã Quảng Trực', 'Xã Quảng Trực, Tỉnh Lâm Đồng', '798', 'xa', '30'),
(1760, 'Ninh Gia', 'Xã Ninh Gia', 'Xã Ninh Gia, Tỉnh Lâm Đồng', '1054', 'xa', '30'),
(1761, 'Phan Rí Cửa', 'Xã Phan Rí Cửa', 'Xã Phan Rí Cửa, Tỉnh Lâm Đồng', '1310', 'xa', '30'),
(1762, 'Tuy Phong', 'Xã Tuy Phong', 'Xã Tuy Phong, Tỉnh Lâm Đồng', '1566', 'xa', '30'),
(1763, 'Hòa Thắng', 'Xã Hòa Thắng', 'Xã Hòa Thắng, Tỉnh Lâm Đồng', '1822', 'xa', '30'),
(1764, 'Đặc Khu Phú Quý', 'Xã Đặc Khu Phú Quý', 'Xã Đặc Khu Phú Quý, Tỉnh Lâm Đồng', '2078', 'xa', '30'),
(1765, 'Hồng Thái', 'Xã Hồng Thái', 'Xã Hồng Thái, Tỉnh Lâm Đồng', '2334', 'xa', '30'),
(1766, 'Đạ Huoai 3', 'Xã Đạ Huoai 3', 'Xã Đạ Huoai 3, Tỉnh Lâm Đồng', '2590', 'xa', '30'),
(1767, 'Xuân Hương-Đà Lạt', 'Phường Xuân Hương-Đà Lạt', 'Phường Xuân Hương-Đà Lạt, Tỉnh Lâm Đồng', '2846', 'phuong', '30'),
(1768, 'Cam Ly-Đà Lạt', 'Phường Cam Ly-Đà Lạt', 'Phường Cam Ly-Đà Lạt, Tỉnh Lâm Đồng', '3102', 'phuong', '30'),
(1769, 'Lâm Viên-Đà Lạt', 'Phường Lâm Viên-Đà Lạt', 'Phường Lâm Viên-Đà Lạt, Tỉnh Lâm Đồng', '3358', 'phuong', '30'),
(1770, 'Xuân Trường-Đà Lạt', 'Phường Xuân Trường-Đà Lạt', 'Phường Xuân Trường-Đà Lạt, Tỉnh Lâm Đồng', '3614', 'phuong', '30'),
(1771, 'Lang Biang-Đà Lạt', 'Phường Lang Biang-Đà Lạt', 'Phường Lang Biang-Đà Lạt, Tỉnh Lâm Đồng', '3870', 'phuong', '30'),
(1772, '1 Bảo Lộc', 'Phường 1 Bảo Lộc', 'Phường 1 Bảo Lộc, Tỉnh Lâm Đồng', '4126', 'phuong', '30'),
(1773, '2 Bảo Lộc', 'Phường 2 Bảo Lộc', 'Phường 2 Bảo Lộc, Tỉnh Lâm Đồng', '4382', 'phuong', '30'),
(1774, '3 Bảo Lộc', 'Phường 3 Bảo Lộc', 'Phường 3 Bảo Lộc, Tỉnh Lâm Đồng', '4638', 'phuong', '30'),
(1775, 'B\'Lao', 'Phường B\'Lao', 'Phường B\'Lao, Tỉnh Lâm Đồng', '4894', 'phuong', '30'),
(1776, 'Đơn Dương', 'Xã Đơn Dương', 'Xã Đơn Dương, Tỉnh Lâm Đồng', '5150', 'xa', '30'),
(1777, 'Ka Đô', 'Xã Ka Đô', 'Xã Ka Đô, Tỉnh Lâm Đồng', '5406', 'xa', '30'),
(1778, 'Quảng Lập', 'Xã Quảng Lập', 'Xã Quảng Lập, Tỉnh Lâm Đồng', '5662', 'xa', '30'),
(1779, 'D\'Ran', 'Xã D\'Ran', 'Xã D\'Ran, Tỉnh Lâm Đồng', '5918', 'xa', '30'),
(1780, 'Hiệp Thạnh', 'Xã Hiệp Thạnh', 'Xã Hiệp Thạnh, Tỉnh Lâm Đồng', '6174', 'xa', '30'),
(1781, 'Lạc Dương', 'Xã Lạc Dương', 'Xã Lạc Dương, Tỉnh Lâm Đồng', '6430', 'xa', '30'),
(1782, 'Đức Trọng', 'Xã Đức Trọng', 'Xã Đức Trọng, Tỉnh Lâm Đồng', '6686', 'xa', '30'),
(1783, 'Tân Hội', 'Xã Tân Hội', 'Xã Tân Hội, Tỉnh Lâm Đồng', '6942', 'xa', '30'),
(1784, 'Tà Hine', 'Xã Tà Hine', 'Xã Tà Hine, Tỉnh Lâm Đồng', '7198', 'xa', '30'),
(1785, 'Tà Năng', 'Xã Tà Năng', 'Xã Tà Năng, Tỉnh Lâm Đồng', '7454', 'xa', '30'),
(1786, 'Đinh Văn-Lâm Hà', 'Xã Đinh Văn-Lâm Hà', 'Xã Đinh Văn-Lâm Hà, Tỉnh Lâm Đồng', '7710', 'xa', '30'),
(1787, 'Phú Sơn-Lâm Hà', 'Xã Phú Sơn-Lâm Hà', 'Xã Phú Sơn-Lâm Hà, Tỉnh Lâm Đồng', '7966', 'xa', '30'),
(1788, 'Nam Hà-Lâm Hà', 'Xã Nam Hà-Lâm Hà', 'Xã Nam Hà-Lâm Hà, Tỉnh Lâm Đồng', '8222', 'xa', '30'),
(1789, 'Nam Ban-Lâm Hà', 'Xã Nam Ban-Lâm Hà', 'Xã Nam Ban-Lâm Hà, Tỉnh Lâm Đồng', '8478', 'xa', '30'),
(1790, 'Tân Hà-Lâm Hà', 'Xã Tân Hà-Lâm Hà', 'Xã Tân Hà-Lâm Hà, Tỉnh Lâm Đồng', '8734', 'xa', '30'),
(1791, 'Phúc Thọ-Lâm Hà', 'Xã Phúc Thọ-Lâm Hà', 'Xã Phúc Thọ-Lâm Hà, Tỉnh Lâm Đồng', '8990', 'xa', '30'),
(1792, 'Đam Rông 1', 'Xã Đam Rông 1', 'Xã Đam Rông 1, Tỉnh Lâm Đồng', '9246', 'xa', '30'),
(1793, 'Đam Rông 2', 'Xã Đam Rông 2', 'Xã Đam Rông 2, Tỉnh Lâm Đồng', '9502', 'xa', '30'),
(1794, 'Đam Rông 3', 'Xã Đam Rông 3', 'Xã Đam Rông 3, Tỉnh Lâm Đồng', '9758', 'xa', '30'),
(1795, 'Đam Rông 4', 'Xã Đam Rông 4', 'Xã Đam Rông 4, Tỉnh Lâm Đồng', '10014', 'xa', '30'),
(1796, 'Di Linh', 'Xã Di Linh', 'Xã Di Linh, Tỉnh Lâm Đồng', '10270', 'xa', '30'),
(1797, 'Hòa Ninh', 'Xã Hòa Ninh', 'Xã Hòa Ninh, Tỉnh Lâm Đồng', '10526', 'xa', '30'),
(1798, 'Hòa Bắc', 'Xã Hòa Bắc', 'Xã Hòa Bắc, Tỉnh Lâm Đồng', '10782', 'xa', '30'),
(1799, 'Đinh Trang Thượng', 'Xã Đinh Trang Thượng', 'Xã Đinh Trang Thượng, Tỉnh Lâm Đồng', '11038', 'xa', '30'),
(1800, 'Bảo Thuận', 'Xã Bảo Thuận', 'Xã Bảo Thuận, Tỉnh Lâm Đồng', '11294', 'xa', '30'),
(1801, 'Sơn Điền', 'Xã Sơn Điền', 'Xã Sơn Điền, Tỉnh Lâm Đồng', '11550', 'xa', '30'),
(1802, 'Gia Hiệp', 'Xã Gia Hiệp', 'Xã Gia Hiệp, Tỉnh Lâm Đồng', '11806', 'xa', '30'),
(1803, 'Bảo Lâm 1', 'Xã Bảo Lâm 1', 'Xã Bảo Lâm 1, Tỉnh Lâm Đồng', '12062', 'xa', '30'),
(1804, 'Bảo Lâm 2', 'Xã Bảo Lâm 2', 'Xã Bảo Lâm 2, Tỉnh Lâm Đồng', '12318', 'xa', '30'),
(1805, 'Bảo Lâm 3', 'Xã Bảo Lâm 3', 'Xã Bảo Lâm 3, Tỉnh Lâm Đồng', '12574', 'xa', '30'),
(1806, 'Bảo Lâm 4', 'Xã Bảo Lâm 4', 'Xã Bảo Lâm 4, Tỉnh Lâm Đồng', '12830', 'xa', '30'),
(1807, 'Bảo Lâm 5', 'Xã Bảo Lâm 5', 'Xã Bảo Lâm 5, Tỉnh Lâm Đồng', '13086', 'xa', '30'),
(1808, 'Đạ Huoai', 'Xã Đạ Huoai', 'Xã Đạ Huoai, Tỉnh Lâm Đồng', '13342', 'xa', '30'),
(1809, 'Đạ Huoai 2', 'Xã Đạ Huoai 2', 'Xã Đạ Huoai 2, Tỉnh Lâm Đồng', '13598', 'xa', '30'),
(1810, 'Đạ Tẻh', 'Xã Đạ Tẻh', 'Xã Đạ Tẻh, Tỉnh Lâm Đồng', '13854', 'xa', '30'),
(1811, 'Đạ Tẻh 2', 'Xã Đạ Tẻh 2', 'Xã Đạ Tẻh 2, Tỉnh Lâm Đồng', '14110', 'xa', '30'),
(1812, 'Đạ Tẻh 3', 'Xã Đạ Tẻh 3', 'Xã Đạ Tẻh 3, Tỉnh Lâm Đồng', '14366', 'xa', '30'),
(1813, 'Cát Tiên', 'Xã Cát Tiên', 'Xã Cát Tiên, Tỉnh Lâm Đồng', '14622', 'xa', '30'),
(1814, 'Cát Tiên 2', 'Xã Cát Tiên 2', 'Xã Cát Tiên 2, Tỉnh Lâm Đồng', '14878', 'xa', '30'),
(1815, 'Cát Tiên 3', 'Xã Cát Tiên 3', 'Xã Cát Tiên 3, Tỉnh Lâm Đồng', '15134', 'xa', '30'),
(1816, 'Đắk Wil', 'Xã Đắk Wil', 'Xã Đắk Wil, Tỉnh Lâm Đồng', '15390', 'xa', '30'),
(1817, 'Nam Dong', 'Xã Nam Dong', 'Xã Nam Dong, Tỉnh Lâm Đồng', '15646', 'xa', '30'),
(1818, 'Cư Jút', 'Xã Cư Jút', 'Xã Cư Jút, Tỉnh Lâm Đồng', '15902', 'xa', '30'),
(1819, 'Thuận An', 'Xã Thuận An', 'Xã Thuận An, Tỉnh Lâm Đồng', '16158', 'xa', '30'),
(1820, 'Đức Lập', 'Xã Đức Lập', 'Xã Đức Lập, Tỉnh Lâm Đồng', '16414', 'xa', '30'),
(1821, 'Đắk Mil', 'Xã Đắk Mil', 'Xã Đắk Mil, Tỉnh Lâm Đồng', '16670', 'xa', '30'),
(1822, 'Đắk Sắk', 'Xã Đắk Sắk', 'Xã Đắk Sắk, Tỉnh Lâm Đồng', '16926', 'xa', '30'),
(1823, 'Nam Đà', 'Xã Nam Đà', 'Xã Nam Đà, Tỉnh Lâm Đồng', '17182', 'xa', '30'),
(1824, 'Krông Nô', 'Xã Krông Nô', 'Xã Krông Nô, Tỉnh Lâm Đồng', '17438', 'xa', '30'),
(1825, 'Nâm Nung', 'Xã Nâm Nung', 'Xã Nâm Nung, Tỉnh Lâm Đồng', '17694', 'xa', '30'),
(1826, 'Quảng Phú', 'Xã Quảng Phú', 'Xã Quảng Phú, Tỉnh Lâm Đồng', '17950', 'xa', '30'),
(1827, 'Đắk Song', 'Xã Đắk Song', 'Xã Đắk Song, Tỉnh Lâm Đồng', '18206', 'xa', '30'),
(1828, 'Đức An', 'Xã Đức An', 'Xã Đức An, Tỉnh Lâm Đồng', '18462', 'xa', '30'),
(1829, 'Thuận Hạnh', 'Xã Thuận Hạnh', 'Xã Thuận Hạnh, Tỉnh Lâm Đồng', '18718', 'xa', '30'),
(1830, 'Trường Xuân', 'Xã Trường Xuân', 'Xã Trường Xuân, Tỉnh Lâm Đồng', '18974', 'xa', '30'),
(1831, 'Tà Đùng', 'Xã Tà Đùng', 'Xã Tà Đùng, Tỉnh Lâm Đồng', '19230', 'xa', '30'),
(1832, 'Quảng Khê', 'Xã Quảng Khê', 'Xã Quảng Khê, Tỉnh Lâm Đồng', '19486', 'xa', '30'),
(1833, 'Bắc Gia Nghĩa', 'Phường Bắc Gia Nghĩa', 'Phường Bắc Gia Nghĩa, Tỉnh Lâm Đồng', '19742', 'phuong', '30'),
(1834, 'Nam Gia Nghĩa', 'Phường Nam Gia Nghĩa', 'Phường Nam Gia Nghĩa, Tỉnh Lâm Đồng', '19998', 'phuong', '30'),
(1835, 'Đông Gia Nghĩa', 'Phường Đông Gia Nghĩa', 'Phường Đông Gia Nghĩa, Tỉnh Lâm Đồng', '20254', 'phuong', '30'),
(1836, 'Quảng Tân', 'Xã Quảng Tân', 'Xã Quảng Tân, Tỉnh Lâm Đồng', '20510', 'xa', '30'),
(1837, 'Tuy Đức', 'Xã Tuy Đức', 'Xã Tuy Đức, Tỉnh Lâm Đồng', '20766', 'xa', '30'),
(1838, 'Kiến Đức', 'Xã Kiến Đức', 'Xã Kiến Đức, Tỉnh Lâm Đồng', '21022', 'xa', '30'),
(1839, 'Nhân Cơ', 'Xã Nhân Cơ', 'Xã Nhân Cơ, Tỉnh Lâm Đồng', '21278', 'xa', '30'),
(1840, 'Quảng Tín', 'Xã Quảng Tín', 'Xã Quảng Tín, Tỉnh Lâm Đồng', '21534', 'xa', '30'),
(1841, 'Vĩnh Hảo', 'Xã Vĩnh Hảo', 'Xã Vĩnh Hảo, Tỉnh Lâm Đồng', '21790', 'xa', '30'),
(1842, 'Liên Hương', 'Xã Liên Hương', 'Xã Liên Hương, Tỉnh Lâm Đồng', '22046', 'xa', '30'),
(1843, 'Bắc Bình', 'Xã Bắc Bình', 'Xã Bắc Bình, Tỉnh Lâm Đồng', '22302', 'xa', '30'),
(1844, 'Hải Ninh', 'Xã Hải Ninh', 'Xã Hải Ninh, Tỉnh Lâm Đồng', '22558', 'xa', '30'),
(1845, 'Phan Sơn', 'Xã Phan Sơn', 'Xã Phan Sơn, Tỉnh Lâm Đồng', '22814', 'xa', '30'),
(1846, 'Sông Lũy', 'Xã Sông Lũy', 'Xã Sông Lũy, Tỉnh Lâm Đồng', '23070', 'xa', '30'),
(1847, 'Lương Sơn', 'Xã Lương Sơn', 'Xã Lương Sơn, Tỉnh Lâm Đồng', '23326', 'xa', '30'),
(1848, 'Đông Giang', 'Xã Đông Giang', 'Xã Đông Giang, Tỉnh Lâm Đồng', '23582', 'xa', '30'),
(1849, 'Tân Lập', 'Xã Tân Lập', 'Xã Tân Lập, Tỉnh Lâm Đồng', '23838', 'xa', '30'),
(1850, 'Tân Minh', 'Xã Tân Minh', 'Xã Tân Minh, Tỉnh Lâm Đồng', '24094', 'xa', '30'),
(1851, 'Hàm Tân', 'Xã Hàm Tân', 'Xã Hàm Tân, Tỉnh Lâm Đồng', '24350', 'xa', '30'),
(1852, 'Sơn Mỹ', 'Xã Sơn Mỹ', 'Xã Sơn Mỹ, Tỉnh Lâm Đồng', '24606', 'xa', '30'),
(1853, 'La Gi', 'Phường La Gi', 'Phường La Gi, Tỉnh Lâm Đồng', '24862', 'phuong', '30'),
(1854, 'Phước Hội', 'Phường Phước Hội', 'Phường Phước Hội, Tỉnh Lâm Đồng', '25118', 'phuong', '30'),
(1855, 'Tân Hải', 'Xã Tân Hải', 'Xã Tân Hải, Tỉnh Lâm Đồng', '25374', 'xa', '30'),
(1856, 'Nghị Đức', 'Xã Nghị Đức', 'Xã Nghị Đức, Tỉnh Lâm Đồng', '25630', 'xa', '30'),
(1857, 'Bắc Ruộng', 'Xã Bắc Ruộng', 'Xã Bắc Ruộng, Tỉnh Lâm Đồng', '25886', 'xa', '30'),
(1858, 'Đồng Kho', 'Xã Đồng Kho', 'Xã Đồng Kho, Tỉnh Lâm Đồng', '26142', 'xa', '30'),
(1859, 'Tánh Linh', 'Xã Tánh Linh', 'Xã Tánh Linh, Tỉnh Lâm Đồng', '26398', 'xa', '30'),
(1860, 'Suối Kiết', 'Xã Suối Kiết', 'Xã Suối Kiết, Tỉnh Lâm Đồng', '26654', 'xa', '30'),
(1861, 'Nam Thành', 'Xã Nam Thành', 'Xã Nam Thành, Tỉnh Lâm Đồng', '26910', 'xa', '30'),
(1862, 'Đức Linh', 'Xã Đức Linh', 'Xã Đức Linh, Tỉnh Lâm Đồng', '27166', 'xa', '30'),
(1863, 'Hoài Đức', 'Xã Hoài Đức', 'Xã Hoài Đức, Tỉnh Lâm Đồng', '27422', 'xa', '30'),
(1864, 'Trà Tân', 'Xã Trà Tân', 'Xã Trà Tân, Tỉnh Lâm Đồng', '27678', 'xa', '30'),
(1865, 'La Dạ', 'Xã La Dạ', 'Xã La Dạ, Tỉnh Lâm Đồng', '27934', 'xa', '30'),
(1866, 'Hàm Thuận Bắc', 'Xã Hàm Thuận Bắc', 'Xã Hàm Thuận Bắc, Tỉnh Lâm Đồng', '28190', 'xa', '30'),
(1867, 'Hàm Thuận', 'Xã Hàm Thuận', 'Xã Hàm Thuận, Tỉnh Lâm Đồng', '28446', 'xa', '30'),
(1868, 'Hồng Sơn', 'Xã Hồng Sơn', 'Xã Hồng Sơn, Tỉnh Lâm Đồng', '28702', 'xa', '30'),
(1869, 'Hàm Liêm', 'Xã Hàm Liêm', 'Xã Hàm Liêm, Tỉnh Lâm Đồng', '28958', 'xa', '30'),
(1870, 'Hàm Thắng', 'Phường Hàm Thắng', 'Phường Hàm Thắng, Tỉnh Lâm Đồng', '29214', 'phuong', '30'),
(1871, 'Bình Thuận', 'Phường Bình Thuận', 'Phường Bình Thuận, Tỉnh Lâm Đồng', '29470', 'phuong', '30'),
(1872, 'Mũi Né', 'Phường Mũi Né', 'Phường Mũi Né, Tỉnh Lâm Đồng', '29726', 'phuong', '30'),
(1873, 'Phú Thủy', 'Phường Phú Thủy', 'Phường Phú Thủy, Tỉnh Lâm Đồng', '29982', 'phuong', '30'),
(1874, 'Phan Thiết', 'Phường Phan Thiết', 'Phường Phan Thiết, Tỉnh Lâm Đồng', '30238', 'phuong', '30'),
(1875, 'Tiến Thành', 'Phường Tiến Thành', 'Phường Tiến Thành, Tỉnh Lâm Đồng', '30494', 'phuong', '30'),
(1876, 'Tuyên Quang', 'Xã Tuyên Quang', 'Xã Tuyên Quang, Tỉnh Lâm Đồng', '30750', 'xa', '30'),
(1877, 'Hàm Thạnh', 'Xã Hàm Thạnh', 'Xã Hàm Thạnh, Tỉnh Lâm Đồng', '31006', 'xa', '30'),
(1878, 'Hàm Kiệm', 'Xã Hàm Kiệm', 'Xã Hàm Kiệm, Tỉnh Lâm Đồng', '31262', 'xa', '30'),
(1879, 'Tân Thành', 'Xã Tân Thành', 'Xã Tân Thành, Tỉnh Lâm Đồng', '31518', 'xa', '30'),
(1880, 'Hàm Thuận Nam', 'Xã Hàm Thuận Nam', 'Xã Hàm Thuận Nam, Tỉnh Lâm Đồng', '31774', 'xa', '30'),
(1881, 'Châu Sơn', 'Xã Châu Sơn', 'Xã Châu Sơn, Tỉnh Lạng Sơn', '287', 'xa', '31'),
(1882, 'Đình Lập', 'Xã Đình Lập', 'Xã Đình Lập, Tỉnh Lạng Sơn', '543', 'xa', '31'),
(1883, 'Kiên Mộc', 'Xã Kiên Mộc', 'Xã Kiên Mộc, Tỉnh Lạng Sơn', '799', 'xa', '31'),
(1884, 'Thất Khê', 'Xã Thất Khê', 'Xã Thất Khê, Tỉnh Lạng Sơn', '1055', 'xa', '31'),
(1885, 'Đoàn Kết', 'Xã Đoàn Kết', 'Xã Đoàn Kết, Tỉnh Lạng Sơn', '1311', 'xa', '31'),
(1886, 'Tân Tiến', 'Xã Tân Tiến', 'Xã Tân Tiến, Tỉnh Lạng Sơn', '1567', 'xa', '31'),
(1887, 'Tràng Định', 'Xã Tràng Định', 'Xã Tràng Định, Tỉnh Lạng Sơn', '1823', 'xa', '31'),
(1888, 'Quốc Khánh', 'Xã Quốc Khánh', 'Xã Quốc Khánh, Tỉnh Lạng Sơn', '2079', 'xa', '31'),
(1889, 'Kháng Chiến', 'Xã Kháng Chiến', 'Xã Kháng Chiến, Tỉnh Lạng Sơn', '2335', 'xa', '31'),
(1890, 'Quốc Việt', 'Xã Quốc Việt', 'Xã Quốc Việt, Tỉnh Lạng Sơn', '2591', 'xa', '31'),
(1891, 'Bình Gia', 'Xã Bình Gia', 'Xã Bình Gia, Tỉnh Lạng Sơn', '2847', 'xa', '31'),
(1892, 'Tân Văn', 'Xã Tân Văn', 'Xã Tân Văn, Tỉnh Lạng Sơn', '3103', 'xa', '31'),
(1893, 'Hồng Phong', 'Xã Hồng Phong', 'Xã Hồng Phong, Tỉnh Lạng Sơn', '3359', 'xa', '31'),
(1894, 'Hoa Thám', 'Xã Hoa Thám', 'Xã Hoa Thám, Tỉnh Lạng Sơn', '3615', 'xa', '31'),
(1895, 'Quý Hòa', 'Xã Quý Hòa', 'Xã Quý Hòa, Tỉnh Lạng Sơn', '3871', 'xa', '31'),
(1896, 'Thiện Hòa', 'Xã Thiện Hòa', 'Xã Thiện Hòa, Tỉnh Lạng Sơn', '4127', 'xa', '31'),
(1897, 'Thiện Thuật', 'Xã Thiện Thuật', 'Xã Thiện Thuật, Tỉnh Lạng Sơn', '4383', 'xa', '31'),
(1898, 'Thiện Long', 'Xã Thiện Long', 'Xã Thiện Long, Tỉnh Lạng Sơn', '4639', 'xa', '31'),
(1899, 'Bắc Sơn', 'Xã Bắc Sơn', 'Xã Bắc Sơn, Tỉnh Lạng Sơn', '4895', 'xa', '31'),
(1900, 'Hưng Vũ', 'Xã Hưng Vũ', 'Xã Hưng Vũ, Tỉnh Lạng Sơn', '5151', 'xa', '31'),
(1901, 'Vũ Lăng', 'Xã Vũ Lăng', 'Xã Vũ Lăng, Tỉnh Lạng Sơn', '5407', 'xa', '31'),
(1902, 'Nhất Hòa', 'Xã Nhất Hòa', 'Xã Nhất Hòa, Tỉnh Lạng Sơn', '5663', 'xa', '31'),
(1903, 'Vũ Lễ', 'Xã Vũ Lễ', 'Xã Vũ Lễ, Tỉnh Lạng Sơn', '5919', 'xa', '31'),
(1904, 'Tân Tri', 'Xã Tân Tri', 'Xã Tân Tri, Tỉnh Lạng Sơn', '6175', 'xa', '31'),
(1905, 'Văn Quan', 'Xã Văn Quan', 'Xã Văn Quan, Tỉnh Lạng Sơn', '6431', 'xa', '31'),
(1906, 'Điềm He', 'Xã Điềm He', 'Xã Điềm He, Tỉnh Lạng Sơn', '6687', 'xa', '31'),
(1907, 'Yên Phúc', 'Xã Yên Phúc', 'Xã Yên Phúc, Tỉnh Lạng Sơn', '6943', 'xa', '31'),
(1908, 'Tri Lễ', 'Xã Tri Lễ', 'Xã Tri Lễ, Tỉnh Lạng Sơn', '7199', 'xa', '31'),
(1909, 'Tân Đoàn', 'Xã Tân Đoàn', 'Xã Tân Đoàn, Tỉnh Lạng Sơn', '7455', 'xa', '31'),
(1910, 'Khánh Khê', 'Xã Khánh Khê', 'Xã Khánh Khê, Tỉnh Lạng Sơn', '7711', 'xa', '31'),
(1911, 'Na Sầm', 'Xã Na Sầm', 'Xã Na Sầm, Tỉnh Lạng Sơn', '7967', 'xa', '31'),
(1912, 'Tân Thanh', 'Xã Tân Thanh', 'Xã Tân Thanh, Tỉnh Lạng Sơn', '8223', 'xa', '31'),
(1913, 'Thụy Hùng', 'Xã Thụy Hùng', 'Xã Thụy Hùng, Tỉnh Lạng Sơn', '8479', 'xa', '31'),
(1914, 'Văn Lãng', 'Xã Văn Lãng', 'Xã Văn Lãng, Tỉnh Lạng Sơn', '8735', 'xa', '31'),
(1915, 'Hội Hoan', 'Xã Hội Hoan', 'Xã Hội Hoan, Tỉnh Lạng Sơn', '8991', 'xa', '31'),
(1916, 'Lộc Bình', 'Xã Lộc Bình', 'Xã Lộc Bình, Tỉnh Lạng Sơn', '9247', 'xa', '31'),
(1917, 'Mẫu Sơn', 'Xã Mẫu Sơn', 'Xã Mẫu Sơn, Tỉnh Lạng Sơn', '9503', 'xa', '31'),
(1918, 'Na Dương', 'Xã Na Dương', 'Xã Na Dương, Tỉnh Lạng Sơn', '9759', 'xa', '31'),
(1919, 'Lợi Bác', 'Xã Lợi Bác', 'Xã Lợi Bác, Tỉnh Lạng Sơn', '10015', 'xa', '31'),
(1920, 'Thống Nhất', 'Xã Thống Nhất', 'Xã Thống Nhất, Tỉnh Lạng Sơn', '10271', 'xa', '31'),
(1921, 'Xuân Dương', 'Xã Xuân Dương', 'Xã Xuân Dương, Tỉnh Lạng Sơn', '10527', 'xa', '31'),
(1922, 'Khuất Xá', 'Xã Khuất Xá', 'Xã Khuất Xá, Tỉnh Lạng Sơn', '10783', 'xa', '31'),
(1923, 'Thái Bình', 'Xã Thái Bình', 'Xã Thái Bình, Tỉnh Lạng Sơn', '11039', 'xa', '31'),
(1924, 'Hữu Lũng', 'Xã Hữu Lũng', 'Xã Hữu Lũng, Tỉnh Lạng Sơn', '11295', 'xa', '31'),
(1925, 'Tuấn Sơn', 'Xã Tuấn Sơn', 'Xã Tuấn Sơn, Tỉnh Lạng Sơn', '11551', 'xa', '31'),
(1926, 'Tân Thành', 'Xã Tân Thành', 'Xã Tân Thành, Tỉnh Lạng Sơn', '11807', 'xa', '31'),
(1927, 'Vân Nham', 'Xã Vân Nham', 'Xã Vân Nham, Tỉnh Lạng Sơn', '12063', 'xa', '31'),
(1928, 'Thiện Tân', 'Xã Thiện Tân', 'Xã Thiện Tân, Tỉnh Lạng Sơn', '12319', 'xa', '31'),
(1929, 'Yên Bình', 'Xã Yên Bình', 'Xã Yên Bình, Tỉnh Lạng Sơn', '12575', 'xa', '31'),
(1930, 'Hữu Liên', 'Xã Hữu Liên', 'Xã Hữu Liên, Tỉnh Lạng Sơn', '12831', 'xa', '31'),
(1931, 'Cai Kinh', 'Xã Cai Kinh', 'Xã Cai Kinh, Tỉnh Lạng Sơn', '13087', 'xa', '31'),
(1932, 'Chi Lăng', 'Xã Chi Lăng', 'Xã Chi Lăng, Tỉnh Lạng Sơn', '13343', 'xa', '31'),
(1933, 'Quan Sơn', 'Xã Quan Sơn', 'Xã Quan Sơn, Tỉnh Lạng Sơn', '13599', 'xa', '31'),
(1934, 'Chiến Thắng', 'Xã Chiến Thắng', 'Xã Chiến Thắng, Tỉnh Lạng Sơn', '13855', 'xa', '31'),
(1935, 'Nhân Lý', 'Xã Nhân Lý', 'Xã Nhân Lý, Tỉnh Lạng Sơn', '14111', 'xa', '31'),
(1936, 'Bằng Mạc', 'Xã Bằng Mạc', 'Xã Bằng Mạc, Tỉnh Lạng Sơn', '14367', 'xa', '31'),
(1937, 'Vạn Linh', 'Xã Vạn Linh', 'Xã Vạn Linh, Tỉnh Lạng Sơn', '14623', 'xa', '31'),
(1938, 'Đồng Đăng', 'Xã Đồng Đăng', 'Xã Đồng Đăng, Tỉnh Lạng Sơn', '14879', 'xa', '31'),
(1939, 'Cao Lộc', 'Xã Cao Lộc', 'Xã Cao Lộc, Tỉnh Lạng Sơn', '15135', 'xa', '31'),
(1940, 'Công Sơn', 'Xã Công Sơn', 'Xã Công Sơn, Tỉnh Lạng Sơn', '15391', 'xa', '31'),
(1941, 'Ba Sơn', 'Xã Ba Sơn', 'Xã Ba Sơn, Tỉnh Lạng Sơn', '15647', 'xa', '31'),
(1942, 'Tam Thanh', 'Phường Tam Thanh', 'Phường Tam Thanh, Tỉnh Lạng Sơn', '15903', 'phuong', '31'),
(1943, 'Lương Văn Tri', 'Phường Lương Văn Tri', 'Phường Lương Văn Tri, Tỉnh Lạng Sơn', '16159', 'phuong', '31'),
(1944, 'Hoàng Văn Thụ', 'Phường Hoàng Văn Thụ', 'Phường Hoàng Văn Thụ, Tỉnh Lạng Sơn', '16415', 'phuong', '31'),
(1945, 'Đông Kinh', 'Phường Đông Kinh', 'Phường Đông Kinh, Tỉnh Lạng Sơn', '16671', 'phuong', '31'),
(1946, 'Phong Dụ Thượng', 'Xã Phong Dụ Thượng', 'Xã Phong Dụ Thượng, Tỉnh Lào Cai', '288', 'xa', '32'),
(1947, 'Nậm Có', 'Xã Nậm Có', 'Xã Nậm Có, Tỉnh Lào Cai', '544', 'xa', '32'),
(1948, 'Nậm Xé', 'Xã Nậm Xé', 'Xã Nậm Xé, Tỉnh Lào Cai', '800', 'xa', '32'),
(1949, 'Tà Si Láng', 'Xã Tà Si Láng', 'Xã Tà Si Láng, Tỉnh Lào Cai', '1056', 'xa', '32'),
(1950, 'Chế Tạo', 'Xã Chế Tạo', 'Xã Chế Tạo, Tỉnh Lào Cai', '1312', 'xa', '32'),
(1951, 'Lao Chải', 'Xã Lao Chải', 'Xã Lao Chải, Tỉnh Lào Cai', '1568', 'xa', '32'),
(1952, 'Cát Thịnh', 'Xã Cát Thịnh', 'Xã Cát Thịnh, Tỉnh Lào Cai', '1824', 'xa', '32'),
(1953, 'Ngũ Chỉ Sơn', 'Xã Ngũ Chỉ Sơn', 'Xã Ngũ Chỉ Sơn, Tỉnh Lào Cai', '2080', 'xa', '32'),
(1954, 'Khao Mang', 'Xã Khao Mang', 'Xã Khao Mang, Tỉnh Lào Cai', '2336', 'xa', '32'),
(1955, 'Mù Cang Chải', 'Xã Mù Cang Chải', 'Xã Mù Cang Chải, Tỉnh Lào Cai', '2592', 'xa', '32'),
(1956, 'Púng Luông', 'Xã Púng Luông', 'Xã Púng Luông, Tỉnh Lào Cai', '2848', 'xa', '32'),
(1957, 'Trạm Tấu', 'Xã Trạm Tấu', 'Xã Trạm Tấu, Tỉnh Lào Cai', '3104', 'xa', '32'),
(1958, 'Hạnh Phúc', 'Xã Hạnh Phúc', 'Xã Hạnh Phúc, Tỉnh Lào Cai', '3360', 'xa', '32'),
(1959, 'Phình Hồ', 'Xã Phình Hồ', 'Xã Phình Hồ, Tỉnh Lào Cai', '3616', 'xa', '32'),
(1960, 'Liên Sơn', 'Xã Liên Sơn', 'Xã Liên Sơn, Tỉnh Lào Cai', '3872', 'xa', '32'),
(1961, 'Nghĩa Lộ', 'Phường Nghĩa Lộ', 'Phường Nghĩa Lộ, Tỉnh Lào Cai', '4128', 'phuong', '32'),
(1962, 'Trung Tâm', 'Phường Trung Tâm', 'Phường Trung Tâm, Tỉnh Lào Cai', '4384', 'phuong', '32'),
(1963, 'Cầu Thia', 'Phường Cầu Thia', 'Phường Cầu Thia, Tỉnh Lào Cai', '4640', 'phuong', '32'),
(1964, 'Tú Lệ', 'Xã Tú Lệ', 'Xã Tú Lệ, Tỉnh Lào Cai', '4896', 'xa', '32'),
(1965, 'Gia Hội', 'Xã Gia Hội', 'Xã Gia Hội, Tỉnh Lào Cai', '5152', 'xa', '32'),
(1966, 'Sơn Lương', 'Xã Sơn Lương', 'Xã Sơn Lương, Tỉnh Lào Cai', '5408', 'xa', '32'),
(1967, 'Văn Chấn', 'Xã Văn Chấn', 'Xã Văn Chấn, Tỉnh Lào Cai', '5664', 'xa', '32'),
(1968, 'Thượng Bằng La', 'Xã Thượng Bằng La', 'Xã Thượng Bằng La, Tỉnh Lào Cai', '5920', 'xa', '32'),
(1969, 'Chấn Thịnh', 'Xã Chấn Thịnh', 'Xã Chấn Thịnh, Tỉnh Lào Cai', '6176', 'xa', '32'),
(1970, 'Nghĩa Tâm', 'Xã Nghĩa Tâm', 'Xã Nghĩa Tâm, Tỉnh Lào Cai', '6432', 'xa', '32'),
(1971, 'Phong Dụ Hạ', 'Xã Phong Dụ Hạ', 'Xã Phong Dụ Hạ, Tỉnh Lào Cai', '6688', 'xa', '32'),
(1972, 'Châu Quế', 'Xã Châu Quế', 'Xã Châu Quế, Tỉnh Lào Cai', '6944', 'xa', '32'),
(1973, 'Lâm Giang', 'Xã Lâm Giang', 'Xã Lâm Giang, Tỉnh Lào Cai', '7200', 'xa', '32'),
(1974, 'Đông Cuông', 'Xã Đông Cuông', 'Xã Đông Cuông, Tỉnh Lào Cai', '7456', 'xa', '32'),
(1975, 'Tân Hợp', 'Xã Tân Hợp', 'Xã Tân Hợp, Tỉnh Lào Cai', '7712', 'xa', '32'),
(1976, 'Mậu A', 'Xã Mậu A', 'Xã Mậu A, Tỉnh Lào Cai', '7968', 'xa', '32'),
(1977, 'Xuân Ái', 'Xã Xuân Ái', 'Xã Xuân Ái, Tỉnh Lào Cai', '8224', 'xa', '32'),
(1978, 'Mỏ Vàng', 'Xã Mỏ Vàng', 'Xã Mỏ Vàng, Tỉnh Lào Cai', '8480', 'xa', '32'),
(1979, 'Lâm Thượng', 'Xã Lâm Thượng', 'Xã Lâm Thượng, Tỉnh Lào Cai', '8736', 'xa', '32'),
(1980, 'Lục Yên', 'Xã Lục Yên', 'Xã Lục Yên, Tỉnh Lào Cai', '8992', 'xa', '32'),
(1981, 'Tân Lĩnh', 'Xã Tân Lĩnh', 'Xã Tân Lĩnh, Tỉnh Lào Cai', '9248', 'xa', '32'),
(1982, 'Khánh Hòa', 'Xã Khánh Hòa', 'Xã Khánh Hòa, Tỉnh Lào Cai', '9504', 'xa', '32'),
(1983, 'Phúc Lợi', 'Xã Phúc Lợi', 'Xã Phúc Lợi, Tỉnh Lào Cai', '9760', 'xa', '32'),
(1984, 'Mường Lai', 'Xã Mường Lai', 'Xã Mường Lai, Tỉnh Lào Cai', '10016', 'xa', '32'),
(1985, 'Cảm Nhân', 'Xã Cảm Nhân', 'Xã Cảm Nhân, Tỉnh Lào Cai', '10272', 'xa', '32'),
(1986, 'Yên Thành', 'Xã Yên Thành', 'Xã Yên Thành, Tỉnh Lào Cai', '10528', 'xa', '32'),
(1987, 'Thác Bà', 'Xã Thác Bà', 'Xã Thác Bà, Tỉnh Lào Cai', '10784', 'xa', '32'),
(1988, 'Yên Bình', 'Xã Yên Bình', 'Xã Yên Bình, Tỉnh Lào Cai', '11040', 'xa', '32'),
(1989, 'Bảo Ái', 'Xã Bảo Ái', 'Xã Bảo Ái, Tỉnh Lào Cai', '11296', 'xa', '32'),
(1990, 'Văn Phú', 'Phường Văn Phú', 'Phường Văn Phú, Tỉnh Lào Cai', '11552', 'phuong', '32'),
(1991, 'Yên Bái', 'Phường Yên Bái', 'Phường Yên Bái, Tỉnh Lào Cai', '11808', 'phuong', '32'),
(1992, 'Nam Cường', 'Phường Nam Cường', 'Phường Nam Cường, Tỉnh Lào Cai', '12064', 'phuong', '32'),
(1993, 'Âu Lâu', 'Phường Âu Lâu', 'Phường Âu Lâu, Tỉnh Lào Cai', '12320', 'phuong', '32'),
(1994, 'Trấn Yên', 'Xã Trấn Yên', 'Xã Trấn Yên, Tỉnh Lào Cai', '12576', 'xa', '32'),
(1995, 'Hưng Khánh', 'Xã Hưng Khánh', 'Xã Hưng Khánh, Tỉnh Lào Cai', '12832', 'xa', '32'),
(1996, 'Lương Thịnh', 'Xã Lương Thịnh', 'Xã Lương Thịnh, Tỉnh Lào Cai', '13088', 'xa', '32'),
(1997, 'Việt Hồng', 'Xã Việt Hồng', 'Xã Việt Hồng, Tỉnh Lào Cai', '13344', 'xa', '32'),
(1998, 'Quy Mông', 'Xã Quy Mông', 'Xã Quy Mông, Tỉnh Lào Cai', '13600', 'xa', '32'),
(1999, 'Phong Hải', 'Xã Phong Hải', 'Xã Phong Hải, Tỉnh Lào Cai', '13856', 'xa', '32'),
(2000, 'Xuân Quang', 'Xã Xuân Quang', 'Xã Xuân Quang, Tỉnh Lào Cai', '14112', 'xa', '32'),
(2001, 'Bảo Thắng', 'Xã Bảo Thắng', 'Xã Bảo Thắng, Tỉnh Lào Cai', '14368', 'xa', '32'),
(2002, 'Tằng Loỏng', 'Xã Tằng Loỏng', 'Xã Tằng Loỏng, Tỉnh Lào Cai', '14624', 'xa', '32'),
(2003, 'Gia Phú', 'Xã Gia Phú', 'Xã Gia Phú, Tỉnh Lào Cai', '14880', 'xa', '32'),
(2004, 'Cam Đường', 'Phường Cam Đường', 'Phường Cam Đường, Tỉnh Lào Cai', '15136', 'phuong', '32'),
(2005, 'Lào Cai', 'Phường Lào Cai', 'Phường Lào Cai, Tỉnh Lào Cai', '15392', 'phuong', '32'),
(2006, 'Cốc San', 'Xã Cốc San', 'Xã Cốc San, Tỉnh Lào Cai', '15648', 'xa', '32'),
(2007, 'Hợp Thành', 'Xã Hợp Thành', 'Xã Hợp Thành, Tỉnh Lào Cai', '15904', 'xa', '32'),
(2008, 'Mường Hum', 'Xã Mường Hum', 'Xã Mường Hum, Tỉnh Lào Cai', '16160', 'xa', '32'),
(2009, 'Dền Sáng', 'Xã Dền Sáng', 'Xã Dền Sáng, Tỉnh Lào Cai', '16416', 'xa', '32'),
(2010, 'Y Tý', 'Xã Y Tý', 'Xã Y Tý, Tỉnh Lào Cai', '16672', 'xa', '32'),
(2011, 'A Mú Sung', 'Xã A Mú Sung', 'Xã A Mú Sung, Tỉnh Lào Cai', '16928', 'xa', '32'),
(2012, 'Trịnh Tường', 'Xã Trịnh Tường', 'Xã Trịnh Tường, Tỉnh Lào Cai', '17184', 'xa', '32'),
(2013, 'Bản Xèo', 'Xã Bản Xèo', 'Xã Bản Xèo, Tỉnh Lào Cai', '17440', 'xa', '32'),
(2014, 'Bát Xát', 'Xã Bát Xát', 'Xã Bát Xát, Tỉnh Lào Cai', '17696', 'xa', '32'),
(2015, 'Bảo Yên', 'Xã Bảo Yên', 'Xã Bảo Yên, Tỉnh Lào Cai', '17952', 'xa', '32'),
(2016, 'Nghĩa Đô', 'Xã Nghĩa Đô', 'Xã Nghĩa Đô, Tỉnh Lào Cai', '18208', 'xa', '32'),
(2017, 'Thượng Hà', 'Xã Thượng Hà', 'Xã Thượng Hà, Tỉnh Lào Cai', '18464', 'xa', '32'),
(2018, 'Xuân Hòa', 'Xã Xuân Hòa', 'Xã Xuân Hòa, Tỉnh Lào Cai', '18720', 'xa', '32'),
(2019, 'Phúc Khánh', 'Xã Phúc Khánh', 'Xã Phúc Khánh, Tỉnh Lào Cai', '18976', 'xa', '32'),
(2020, 'Bảo Hà', 'Xã Bảo Hà', 'Xã Bảo Hà, Tỉnh Lào Cai', '19232', 'xa', '32'),
(2021, 'Võ Lao', 'Xã Võ Lao', 'Xã Võ Lao, Tỉnh Lào Cai', '19488', 'xa', '32'),
(2022, 'Khánh Yên', 'Xã Khánh Yên', 'Xã Khánh Yên, Tỉnh Lào Cai', '19744', 'xa', '32'),
(2023, 'Văn Bàn', 'Xã Văn Bàn', 'Xã Văn Bàn, Tỉnh Lào Cai', '20000', 'xa', '32'),
(2024, 'Dương Quỳ', 'Xã Dương Quỳ', 'Xã Dương Quỳ, Tỉnh Lào Cai', '20256', 'xa', '32'),
(2025, 'Chiềng Ken', 'Xã Chiềng Ken', 'Xã Chiềng Ken, Tỉnh Lào Cai', '20512', 'xa', '32'),
(2026, 'Minh Lương', 'Xã Minh Lương', 'Xã Minh Lương, Tỉnh Lào Cai', '20768', 'xa', '32'),
(2027, 'Nậm Chầy', 'Xã Nậm Chầy', 'Xã Nậm Chầy, Tỉnh Lào Cai', '21024', 'xa', '32'),
(2028, 'Mường Bo', 'Xã Mường Bo', 'Xã Mường Bo, Tỉnh Lào Cai', '21280', 'xa', '32'),
(2029, 'Bản Hồ', 'Xã Bản Hồ', 'Xã Bản Hồ, Tỉnh Lào Cai', '21536', 'xa', '32'),
(2030, 'Sa Pa', 'Phường Sa Pa', 'Phường Sa Pa, Tỉnh Lào Cai', '21792', 'phuong', '32'),
(2031, 'Tả Phìn', 'Xã Tả Phìn', 'Xã Tả Phìn, Tỉnh Lào Cai', '22048', 'xa', '32'),
(2032, 'Tả Van', 'Xã Tả Van', 'Xã Tả Van, Tỉnh Lào Cai', '22304', 'xa', '32'),
(2033, 'Cốc Lầu', 'Xã Cốc Lầu', 'Xã Cốc Lầu, Tỉnh Lào Cai', '22560', 'xa', '32'),
(2034, 'Bảo Nhai', 'Xã Bảo Nhai', 'Xã Bảo Nhai, Tỉnh Lào Cai', '22816', 'xa', '32'),
(2035, 'Bản Liền', 'Xã Bản Liền', 'Xã Bản Liền, Tỉnh Lào Cai', '23072', 'xa', '32'),
(2036, 'Bắc Hà', 'Xã Bắc Hà', 'Xã Bắc Hà, Tỉnh Lào Cai', '23328', 'xa', '32'),
(2037, 'Tả Củ Tỷ', 'Xã Tả Củ Tỷ', 'Xã Tả Củ Tỷ, Tỉnh Lào Cai', '23584', 'xa', '32'),
(2038, 'Lùng Phình', 'Xã Lùng Phình', 'Xã Lùng Phình, Tỉnh Lào Cai', '23840', 'xa', '32'),
(2039, 'Pha Long', 'Xã Pha Long', 'Xã Pha Long, Tỉnh Lào Cai', '24096', 'xa', '32'),
(2040, 'Mường Khương', 'Xã Mường Khương', 'Xã Mường Khương, Tỉnh Lào Cai', '24352', 'xa', '32'),
(2041, 'Bản Lầu', 'Xã Bản Lầu', 'Xã Bản Lầu, Tỉnh Lào Cai', '24608', 'xa', '32'),
(2042, 'Cao Sơn', 'Xã Cao Sơn', 'Xã Cao Sơn, Tỉnh Lào Cai', '24864', 'xa', '32'),
(2043, 'Si Ma Cai', 'Xã Si Ma Cai', 'Xã Si Ma Cai, Tỉnh Lào Cai', '25120', 'xa', '32'),
(2044, 'Sín Chéng', 'Xã Sín Chéng', 'Xã Sín Chéng, Tỉnh Lào Cai', '25376', 'xa', '32'),
(2045, 'Hữu Khuông', 'Xã Hữu Khuông', 'Xã Hữu Khuông, Tỉnh Nghệ An', '289', 'xa', '33'),
(2046, 'Huồi Tụ', 'Xã Huồi Tụ', 'Xã Huồi Tụ, Tỉnh Nghệ An', '545', 'xa', '33'),
(2047, 'Bắc Lý', 'Xã Bắc Lý', 'Xã Bắc Lý, Tỉnh Nghệ An', '801', 'xa', '33'),
(2048, 'Keng Đu', 'Xã Keng Đu', 'Xã Keng Đu, Tỉnh Nghệ An', '1057', 'xa', '33'),
(2049, 'Mường Lống', 'Xã Mường Lống', 'Xã Mường Lống, Tỉnh Nghệ An', '1313', 'xa', '33'),
(2050, 'Mỹ Lý', 'Xã Mỹ Lý', 'Xã Mỹ Lý, Tỉnh Nghệ An', '1569', 'xa', '33'),
(2051, 'Bình Chuẩn', 'Xã Bình Chuẩn', 'Xã Bình Chuẩn, Tỉnh Nghệ An', '1825', 'xa', '33'),
(2052, 'Châu Bình', 'Xã Châu Bình', 'Xã Châu Bình, Tỉnh Nghệ An', '2081', 'xa', '33'),
(2053, 'Lưỡng Minh', 'Xã Lưỡng Minh', 'Xã Lưỡng Minh, Tỉnh Nghệ An', '2337', 'xa', '33'),
(2054, 'Quỳnh Anh', 'Xã Quỳnh Anh', 'Xã Quỳnh Anh, Tỉnh Nghệ An', '2593', 'xa', '33'),
(2055, 'Anh Sơn', 'Xã Anh Sơn', 'Xã Anh Sơn, Tỉnh Nghệ An', '2849', 'xa', '33'),
(2056, 'Yên Xuân', 'Xã Yên Xuân', 'Xã Yên Xuân, Tỉnh Nghệ An', '3105', 'xa', '33'),
(2057, 'Nhân Hòa', 'Xã Nhân Hòa', 'Xã Nhân Hòa, Tỉnh Nghệ An', '3361', 'xa', '33'),
(2058, 'Anh Sơn Đông', 'Xã Anh Sơn Đông', 'Xã Anh Sơn Đông, Tỉnh Nghệ An', '3617', 'xa', '33'),
(2059, 'Vĩnh Tường', 'Xã Vĩnh Tường', 'Xã Vĩnh Tường, Tỉnh Nghệ An', '3873', 'xa', '33'),
(2060, 'Thành Bình Thọ', 'Xã Thành Bình Thọ', 'Xã Thành Bình Thọ, Tỉnh Nghệ An', '4129', 'xa', '33'),
(2061, 'Con Cuông', 'Xã Con Cuông', 'Xã Con Cuông, Tỉnh Nghệ An', '4385', 'xa', '33'),
(2062, 'Môn Sơn', 'Xã Môn Sơn', 'Xã Môn Sơn, Tỉnh Nghệ An', '4641', 'xa', '33'),
(2063, 'Mậu Thạch', 'Xã Mậu Thạch', 'Xã Mậu Thạch, Tỉnh Nghệ An', '4897', 'xa', '33'),
(2064, 'Cam Phục', 'Xã Cam Phục', 'Xã Cam Phục, Tỉnh Nghệ An', '5153', 'xa', '33'),
(2065, 'Châu Khê', 'Xã Châu Khê', 'Xã Châu Khê, Tỉnh Nghệ An', '5409', 'xa', '33'),
(2066, 'Diễn Châu', 'Xã Diễn Châu', 'Xã Diễn Châu, Tỉnh Nghệ An', '5665', 'xa', '33'),
(2067, 'Đức Châu', 'Xã Đức Châu', 'Xã Đức Châu, Tỉnh Nghệ An', '5921', 'xa', '33'),
(2068, 'Quảng Châu', 'Xã Quảng Châu', 'Xã Quảng Châu, Tỉnh Nghệ An', '6177', 'xa', '33'),
(2069, 'Hải Châu', 'Xã Hải Châu', 'Xã Hải Châu, Tỉnh Nghệ An', '6433', 'xa', '33'),
(2070, 'Tân Châu', 'Xã Tân Châu', 'Xã Tân Châu, Tỉnh Nghệ An', '6689', 'xa', '33'),
(2071, 'An Châu', 'Xã An Châu', 'Xã An Châu, Tỉnh Nghệ An', '6945', 'xa', '33'),
(2072, 'Minh Châu', 'Xã Minh Châu', 'Xã Minh Châu, Tỉnh Nghệ An', '7201', 'xa', '33'),
(2073, 'Hùng Châu', 'Xã Hùng Châu', 'Xã Hùng Châu, Tỉnh Nghệ An', '7457', 'xa', '33'),
(2074, 'Đô Lương', 'Xã Đô Lương', 'Xã Đô Lương, Tỉnh Nghệ An', '7713', 'xa', '33'),
(2075, 'Bạch Ngọc', 'Xã Bạch Ngọc', 'Xã Bạch Ngọc, Tỉnh Nghệ An', '7969', 'xa', '33'),
(2076, 'Văn Hiến', 'Xã Văn Hiến', 'Xã Văn Hiến, Tỉnh Nghệ An', '8225', 'xa', '33'),
(2077, 'Bạch Hà', 'Xã Bạch Hà', 'Xã Bạch Hà, Tỉnh Nghệ An', '8481', 'xa', '33'),
(2078, 'Thuần Trung', 'Xã Thuần Trung', 'Xã Thuần Trung, Tỉnh Nghệ An', '8737', 'xa', '33'),
(2079, 'Lương Sơn', 'Xã Lương Sơn', 'Xã Lương Sơn, Tỉnh Nghệ An', '8993', 'xa', '33'),
(2080, 'Hoàng Mai', 'Phường Hoàng Mai', 'Phường Hoàng Mai, Tỉnh Nghệ An', '9249', 'phuong', '33'),
(2081, 'Tân Mai', 'Phường Tân Mai', 'Phường Tân Mai, Tỉnh Nghệ An', '9505', 'phuong', '33'),
(2082, 'Quỳnh Mai', 'Phường Quỳnh Mai', 'Phường Quỳnh Mai, Tỉnh Nghệ An', '9761', 'phuong', '33'),
(2083, 'Hưng Nguyên', 'Xã Hưng Nguyên', 'Xã Hưng Nguyên, Tỉnh Nghệ An', '10017', 'xa', '33'),
(2084, 'Hưng Nguyên Nam', 'Xã Hưng Nguyên Nam', 'Xã Hưng Nguyên Nam, Tỉnh Nghệ An', '10273', 'xa', '33'),
(2085, 'Lam Thành', 'Xã Lam Thành', 'Xã Lam Thành, Tỉnh Nghệ An', '10529', 'xa', '33'),
(2086, 'Mường Xén', 'Xã Mường Xén', 'Xã Mường Xén, Tỉnh Nghệ An', '10785', 'xa', '33'),
(2087, 'Hữu Kiệm', 'Xã Hữu Kiệm', 'Xã Hữu Kiệm, Tỉnh Nghệ An', '11041', 'xa', '33'),
(2088, 'Nậm Cắn', 'Xã Nậm Cắn', 'Xã Nậm Cắn, Tỉnh Nghệ An', '11297', 'xa', '33'),
(2089, 'Chiêu Lưu', 'Xã Chiêu Lưu', 'Xã Chiêu Lưu, Tỉnh Nghệ An', '11553', 'xa', '33'),
(2090, 'Na Loi', 'Xã Na Loi', 'Xã Na Loi, Tỉnh Nghệ An', '11809', 'xa', '33'),
(2091, 'Mường Típ', 'Xã Mường Típ', 'Xã Mường Típ, Tỉnh Nghệ An', '12065', 'xa', '33'),
(2092, 'Na Ngoi', 'Xã Na Ngoi', 'Xã Na Ngoi, Tỉnh Nghệ An', '12321', 'xa', '33'),
(2093, 'Vạn An', 'Xã Vạn An', 'Xã Vạn An, Tỉnh Nghệ An', '12577', 'xa', '33'),
(2094, 'Nam Đàn', 'Xã Nam Đàn', 'Xã Nam Đàn, Tỉnh Nghệ An', '12833', 'xa', '33'),
(2095, 'Đại Huệ', 'Xã Đại Huệ', 'Xã Đại Huệ, Tỉnh Nghệ An', '13089', 'xa', '33'),
(2096, 'Thiên Nhẫn', 'Xã Thiên Nhẫn', 'Xã Thiên Nhẫn, Tỉnh Nghệ An', '13345', 'xa', '33'),
(2097, 'Kim Liên', 'Xã Kim Liên', 'Xã Kim Liên, Tỉnh Nghệ An', '13601', 'xa', '33'),
(2098, 'Nghĩa Đàn', 'Xã Nghĩa Đàn', 'Xã Nghĩa Đàn, Tỉnh Nghệ An', '13857', 'xa', '33'),
(2099, 'Nghĩa Thọ', 'Xã Nghĩa Thọ', 'Xã Nghĩa Thọ, Tỉnh Nghệ An', '14113', 'xa', '33'),
(2100, 'Nghĩa Lâm', 'Xã Nghĩa Lâm', 'Xã Nghĩa Lâm, Tỉnh Nghệ An', '14369', 'xa', '33'),
(2101, 'Nghĩa Mai', 'Xã Nghĩa Mai', 'Xã Nghĩa Mai, Tỉnh Nghệ An', '14625', 'xa', '33'),
(2102, 'Nghĩa Hưng', 'Xã Nghĩa Hưng', 'Xã Nghĩa Hưng, Tỉnh Nghệ An', '14881', 'xa', '33'),
(2103, 'Nghĩa Khánh', 'Xã Nghĩa Khánh', 'Xã Nghĩa Khánh, Tỉnh Nghệ An', '15137', 'xa', '33'),
(2104, 'Nghĩa Lộc', 'Xã Nghĩa Lộc', 'Xã Nghĩa Lộc, Tỉnh Nghệ An', '15393', 'xa', '33'),
(2105, 'Nghi Lộc', 'Xã Nghi Lộc', 'Xã Nghi Lộc, Tỉnh Nghệ An', '15649', 'xa', '33'),
(2106, 'Phúc Lộc', 'Xã Phúc Lộc', 'Xã Phúc Lộc, Tỉnh Nghệ An', '15905', 'xa', '33'),
(2107, 'Đông Lộc', 'Xã Đông Lộc', 'Xã Đông Lộc, Tỉnh Nghệ An', '16161', 'xa', '33'),
(2108, 'Trung Lộc', 'Xã Trung Lộc', 'Xã Trung Lộc, Tỉnh Nghệ An', '16417', 'xa', '33'),
(2109, 'Thần Lĩnh', 'Xã Thần Lĩnh', 'Xã Thần Lĩnh, Tỉnh Nghệ An', '16673', 'xa', '33'),
(2110, 'Hải Lộc', 'Xã Hải Lộc', 'Xã Hải Lộc, Tỉnh Nghệ An', '16929', 'xa', '33'),
(2111, 'Văn Kiều', 'Xã Văn Kiều', 'Xã Văn Kiều, Tỉnh Nghệ An', '17185', 'xa', '33'),
(2112, 'Tiền Phong', 'Xã Tiền Phong', 'Xã Tiền Phong, Tỉnh Nghệ An', '17441', 'xa', '33'),
(2113, 'Tri Lễ', 'Xã Tri Lễ', 'Xã Tri Lễ, Tỉnh Nghệ An', '17697', 'xa', '33'),
(2114, 'Mường Quàng', 'Xã Mường Quàng', 'Xã Mường Quàng, Tỉnh Nghệ An', '17953', 'xa', '33'),
(2115, 'Thông Thụ', 'Xã Thông Thụ', 'Xã Thông Thụ, Tỉnh Nghệ An', '18209', 'xa', '33'),
(2116, 'Quỳ Châu', 'Xã Quỳ Châu', 'Xã Quỳ Châu, Tỉnh Nghệ An', '18465', 'xa', '33'),
(2117, 'Châu Tiến', 'Xã Châu Tiến', 'Xã Châu Tiến, Tỉnh Nghệ An', '18721', 'xa', '33'),
(2118, 'Hùng Chân', 'Xã Hùng Chân', 'Xã Hùng Chân, Tỉnh Nghệ An', '18977', 'xa', '33'),
(2119, 'Quỳ Hợp', 'Xã Quỳ Hợp', 'Xã Quỳ Hợp, Tỉnh Nghệ An', '19233', 'xa', '33'),
(2120, 'Tam Hợp', 'Xã Tam Hợp', 'Xã Tam Hợp, Tỉnh Nghệ An', '19489', 'xa', '33'),
(2121, 'Châu Lộc', 'Xã Châu Lộc', 'Xã Châu Lộc, Tỉnh Nghệ An', '19745', 'xa', '33'),
(2122, 'Châu Hồng', 'Xã Châu Hồng', 'Xã Châu Hồng, Tỉnh Nghệ An', '20001', 'xa', '33'),
(2123, 'Mường Ham', 'Xã Mường Ham', 'Xã Mường Ham, Tỉnh Nghệ An', '20257', 'xa', '33'),
(2124, 'Mường Chọng', 'Xã Mường Chọng', 'Xã Mường Chọng, Tỉnh Nghệ An', '20513', 'xa', '33'),
(2125, 'Minh Hợp', 'Xã Minh Hợp', 'Xã Minh Hợp, Tỉnh Nghệ An', '20769', 'xa', '33'),
(2126, 'Quỳnh Lưu', 'Xã Quỳnh Lưu', 'Xã Quỳnh Lưu, Tỉnh Nghệ An', '21025', 'xa', '33'),
(2127, 'Quỳnh Văn', 'Xã Quỳnh Văn', 'Xã Quỳnh Văn, Tỉnh Nghệ An', '21281', 'xa', '33'),
(2128, 'Quỳnh Tam', 'Xã Quỳnh Tam', 'Xã Quỳnh Tam, Tỉnh Nghệ An', '21537', 'xa', '33'),
(2129, 'Quỳnh Phú', 'Xã Quỳnh Phú', 'Xã Quỳnh Phú, Tỉnh Nghệ An', '21793', 'xa', '33'),
(2130, 'Quỳnh Sơn', 'Xã Quỳnh Sơn', 'Xã Quỳnh Sơn, Tỉnh Nghệ An', '22049', 'xa', '33'),
(2131, 'Quỳnh Thắng', 'Xã Quỳnh Thắng', 'Xã Quỳnh Thắng, Tỉnh Nghệ An', '22305', 'xa', '33'),
(2132, 'Tân Kỳ', 'Xã Tân Kỳ', 'Xã Tân Kỳ, Tỉnh Nghệ An', '22561', 'xa', '33'),
(2133, 'Tân Phú', 'Xã Tân Phú', 'Xã Tân Phú, Tỉnh Nghệ An', '22817', 'xa', '33'),
(2134, 'Tân An', 'Xã Tân An', 'Xã Tân An, Tỉnh Nghệ An', '23073', 'xa', '33'),
(2135, 'Nghĩa Đồng', 'Xã Nghĩa Đồng', 'Xã Nghĩa Đồng, Tỉnh Nghệ An', '23329', 'xa', '33'),
(2136, 'Giai Xuân', 'Xã Giai Xuân', 'Xã Giai Xuân, Tỉnh Nghệ An', '23585', 'xa', '33'),
(2137, 'Nghĩa Hành', 'Xã Nghĩa Hành', 'Xã Nghĩa Hành, Tỉnh Nghệ An', '23841', 'xa', '33'),
(2138, 'Tiên Đồng', 'Xã Tiên Đồng', 'Xã Tiên Đồng, Tỉnh Nghệ An', '24097', 'xa', '33'),
(2139, 'Cát Ngạn', 'Xã Cát Ngạn', 'Xã Cát Ngạn, Tỉnh Nghệ An', '24353', 'xa', '33'),
(2140, 'Tam Đồng', 'Xã Tam Đồng', 'Xã Tam Đồng, Tỉnh Nghệ An', '24609', 'xa', '33'),
(2141, 'Hạnh Lâm', 'Xã Hạnh Lâm', 'Xã Hạnh Lâm, Tỉnh Nghệ An', '24865', 'xa', '33'),
(2142, 'Sơn Lâm', 'Xã Sơn Lâm', 'Xã Sơn Lâm, Tỉnh Nghệ An', '25121', 'xa', '33'),
(2143, 'Hoa Quân', 'Xã Hoa Quân', 'Xã Hoa Quân, Tỉnh Nghệ An', '25377', 'xa', '33'),
(2144, 'Kim Bảng', 'Xã Kim Bảng', 'Xã Kim Bảng, Tỉnh Nghệ An', '25633', 'xa', '33'),
(2145, 'Bích Hào', 'Xã Bích Hào', 'Xã Bích Hào, Tỉnh Nghệ An', '25889', 'xa', '33'),
(2146, 'Đại Đồng', 'Xã Đại Đồng', 'Xã Đại Đồng, Tỉnh Nghệ An', '26145', 'xa', '33'),
(2147, 'Xuân Lâm', 'Xã Xuân Lâm', 'Xã Xuân Lâm, Tỉnh Nghệ An', '26401', 'xa', '33'),
(2148, 'Thái Hòa', 'Phường Thái Hòa', 'Phường Thái Hòa, Tỉnh Nghệ An', '26657', 'phuong', '33'),
(2149, 'Tây Hiếu', 'Phường Tây Hiếu', 'Phường Tây Hiếu, Tỉnh Nghệ An', '26913', 'phuong', '33'),
(2150, 'Đông Hiếu', 'Xã Đông Hiếu', 'Xã Đông Hiếu, Tỉnh Nghệ An', '27169', 'xa', '33'),
(2151, 'Tam Quang', 'Xã Tam Quang', 'Xã Tam Quang, Tỉnh Nghệ An', '27425', 'xa', '33'),
(2152, 'Tam Thái', 'Xã Tam Thái', 'Xã Tam Thái, Tỉnh Nghệ An', '27681', 'xa', '33'),
(2153, 'Tương Dương', 'Xã Tương Dương', 'Xã Tương Dương, Tỉnh Nghệ An', '27937', 'xa', '33'),
(2154, 'Yên Na', 'Xã Yên Na', 'Xã Yên Na, Tỉnh Nghệ An', '28193', 'xa', '33'),
(2155, 'Yên Hòa', 'Xã Yên Hòa', 'Xã Yên Hòa, Tỉnh Nghệ An', '28449', 'xa', '33'),
(2156, 'Nga My', 'Xã Nga My', 'Xã Nga My, Tỉnh Nghệ An', '28705', 'xa', '33'),
(2157, 'Nhôn Mai', 'Xã Nhôn Mai', 'Xã Nhôn Mai, Tỉnh Nghệ An', '28961', 'xa', '33'),
(2158, 'Thành Vinh', 'Phường Thành Vinh', 'Phường Thành Vinh, Tỉnh Nghệ An', '29217', 'phuong', '33'),
(2159, 'Vinh Hưng', 'Phường Vinh Hưng', 'Phường Vinh Hưng, Tỉnh Nghệ An', '29473', 'phuong', '33'),
(2160, 'Vinh Phú', 'Phường Vinh Phú', 'Phường Vinh Phú, Tỉnh Nghệ An', '29729', 'phuong', '33'),
(2161, 'Vinh Lộc', 'Phường Vinh Lộc', 'Phường Vinh Lộc, Tỉnh Nghệ An', '29985', 'phuong', '33'),
(2162, 'Yên Thành', 'Xã Yên Thành', 'Xã Yên Thành, Tỉnh Nghệ An', '30241', 'xa', '33'),
(2163, 'Quan Thành', 'Xã Quan Thành', 'Xã Quan Thành, Tỉnh Nghệ An', '30497', 'xa', '33'),
(2164, 'Hợp Minh', 'Xã Hợp Minh', 'Xã Hợp Minh, Tỉnh Nghệ An', '30753', 'xa', '33'),
(2165, 'Vân Tụ', 'Xã Vân Tụ', 'Xã Vân Tụ, Tỉnh Nghệ An', '31009', 'xa', '33'),
(2166, 'Vân Du', 'Xã Vân Du', 'Xã Vân Du, Tỉnh Nghệ An', '31265', 'xa', '33'),
(2167, 'Quang Đồng', 'Xã Quang Đồng', 'Xã Quang Đồng, Tỉnh Nghệ An', '31521', 'xa', '33'),
(2168, 'Giai Lạc', 'Xã Giai Lạc', 'Xã Giai Lạc, Tỉnh Nghệ An', '31777', 'xa', '33'),
(2169, 'Bình Minh', 'Xã Bình Minh', 'Xã Bình Minh, Tỉnh Nghệ An', '32033', 'xa', '33'),
(2170, 'Đông Thành', 'Xã Đông Thành', 'Xã Đông Thành, Tỉnh Nghệ An', '32289', 'xa', '33'),
(2171, 'Yên Trung', 'Xã Yên Trung', 'Xã Yên Trung, Tỉnh Nghệ An', '32545', 'xa', '33'),
(2172, 'Cửa Lò', 'Phường Cửa Lò', 'Phường Cửa Lò, Tỉnh Nghệ An', '32801', 'phuong', '33'),
(2173, 'Quế Phong', 'Xã Quế Phong', 'Xã Quế Phong, Tỉnh Nghệ An', '33057', 'xa', '33'),
(2174, 'Trường Vinh', 'Phường Trường Vinh', 'Phường Trường Vinh, Tỉnh Nghệ An', '33313', 'phuong', '33'),
(2175, 'Duy Tân', 'Phường Duy Tân', 'Phường Duy Tân, Tỉnh Ninh Bình', '290', 'phuong', '34'),
(2176, 'Duy Hà', 'Phường Duy Hà', 'Phường Duy Hà, Tỉnh Ninh Bình', '546', 'phuong', '34'),
(2177, 'Tây Hoa Lư', 'Phường Tây Hoa Lư', 'Phường Tây Hoa Lư, Tỉnh Ninh Bình', '802', 'phuong', '34'),
(2178, 'Thanh Bình', 'Xã Thanh Bình', 'Xã Thanh Bình, Tỉnh Ninh Bình', '1058', 'xa', '34'),
(2179, 'Thanh Liêm', 'Xã Thanh Liêm', 'Xã Thanh Liêm, Tỉnh Ninh Bình', '1314', 'xa', '34'),
(2180, 'Hà Nam', 'Phường Hà Nam', 'Phường Hà Nam, Tỉnh Ninh Bình', '1570', 'phuong', '34'),
(2181, 'Tiên Sơn', 'Phường Tiên Sơn', 'Phường Tiên Sơn, Tỉnh Ninh Bình', '1826', 'phuong', '34'),
(2182, 'Mỹ Lộc', 'Phường Mỹ Lộc', 'Phường Mỹ Lộc, Tỉnh Ninh Bình', '2082', 'phuong', '34'),
(2183, 'Hoa Lư', 'Phường Hoa Lư', 'Phường Hoa Lư, Tỉnh Ninh Bình', '2338', 'phuong', '34'),
(2184, 'Nam Hoa Lư', 'Phường Nam Hoa Lư', 'Phường Nam Hoa Lư, Tỉnh Ninh Bình', '2594', 'phuong', '34'),
(2185, 'Đông Hoa Lư', 'Phường Đông Hoa Lư', 'Phường Đông Hoa Lư, Tỉnh Ninh Bình', '2850', 'phuong', '34'),
(2186, 'Tam Điệp', 'Phường Tam Điệp', 'Phường Tam Điệp, Tỉnh Ninh Bình', '3106', 'phuong', '34'),
(2187, 'Yên Sơn', 'Phường Yên Sơn', 'Phường Yên Sơn, Tỉnh Ninh Bình', '3362', 'phuong', '34'),
(2188, 'Trung Sơn', 'Phường Trung Sơn', 'Phường Trung Sơn, Tỉnh Ninh Bình', '3618', 'phuong', '34'),
(2189, 'Yên Thắng', 'Phường Yên Thắng', 'Phường Yên Thắng, Tỉnh Ninh Bình', '3874', 'phuong', '34'),
(2190, 'Gia Viễn', 'Xã Gia Viễn', 'Xã Gia Viễn, Tỉnh Ninh Bình', '4130', 'xa', '34'),
(2191, 'Đại Hoàng', 'Xã Đại Hoàng', 'Xã Đại Hoàng, Tỉnh Ninh Bình', '4386', 'xa', '34'),
(2192, 'Gia Hưng', 'Xã Gia Hưng', 'Xã Gia Hưng, Tỉnh Ninh Bình', '4642', 'xa', '34'),
(2193, 'Gia Phong', 'Xã Gia Phong', 'Xã Gia Phong, Tỉnh Ninh Bình', '4898', 'xa', '34'),
(2194, 'Gia Vân', 'Xã Gia Vân', 'Xã Gia Vân, Tỉnh Ninh Bình', '5154', 'xa', '34'),
(2195, 'Gia Trấn', 'Xã Gia Trấn', 'Xã Gia Trấn, Tỉnh Ninh Bình', '5410', 'xa', '34'),
(2196, 'Nho Quan', 'Xã Nho Quan', 'Xã Nho Quan, Tỉnh Ninh Bình', '5666', 'xa', '34'),
(2197, 'Gia Lâm', 'Xã Gia Lâm', 'Xã Gia Lâm, Tỉnh Ninh Bình', '5922', 'xa', '34'),
(2198, 'Gia Tường', 'Xã Gia Tường', 'Xã Gia Tường, Tỉnh Ninh Bình', '6178', 'xa', '34'),
(2199, 'Phú Sơn', 'Xã Phú Sơn', 'Xã Phú Sơn, Tỉnh Ninh Bình', '6434', 'xa', '34'),
(2200, 'Cúc Phương', 'Xã Cúc Phương', 'Xã Cúc Phương, Tỉnh Ninh Bình', '6690', 'xa', '34'),
(2201, 'Phú Long', 'Xã Phú Long', 'Xã Phú Long, Tỉnh Ninh Bình', '6946', 'xa', '34'),
(2202, 'Thanh Sơn', 'Xã Thanh Sơn', 'Xã Thanh Sơn, Tỉnh Ninh Bình', '7202', 'xa', '34'),
(2203, 'Quỳnh Lưu', 'Xã Quỳnh Lưu', 'Xã Quỳnh Lưu, Tỉnh Ninh Bình', '7458', 'xa', '34'),
(2204, 'Yên Khánh', 'Xã Yên Khánh', 'Xã Yên Khánh, Tỉnh Ninh Bình', '7714', 'xa', '34'),
(2205, 'Khánh Nhạc', 'Xã Khánh Nhạc', 'Xã Khánh Nhạc, Tỉnh Ninh Bình', '7970', 'xa', '34'),
(2206, 'Khánh Thiện', 'Xã Khánh Thiện', 'Xã Khánh Thiện, Tỉnh Ninh Bình', '8226', 'xa', '34'),
(2207, 'Khánh Hội', 'Xã Khánh Hội', 'Xã Khánh Hội, Tỉnh Ninh Bình', '8482', 'xa', '34'),
(2208, 'Khánh Trung', 'Xã Khánh Trung', 'Xã Khánh Trung, Tỉnh Ninh Bình', '8738', 'xa', '34'),
(2209, 'Yên Mô', 'Xã Yên Mô', 'Xã Yên Mô, Tỉnh Ninh Bình', '8994', 'xa', '34'),
(2210, 'Yên Từ', 'Xã Yên Từ', 'Xã Yên Từ, Tỉnh Ninh Bình', '9250', 'xa', '34'),
(2211, 'Yên Mạc', 'Xã Yên Mạc', 'Xã Yên Mạc, Tỉnh Ninh Bình', '9506', 'xa', '34'),
(2212, 'Đồng Thái', 'Xã Đồng Thái', 'Xã Đồng Thái, Tỉnh Ninh Bình', '9762', 'xa', '34'),
(2213, 'Chất Bình', 'Xã Chất Bình', 'Xã Chất Bình, Tỉnh Ninh Bình', '10018', 'xa', '34'),
(2214, 'Kim Sơn', 'Xã Kim Sơn', 'Xã Kim Sơn, Tỉnh Ninh Bình', '10274', 'xa', '34'),
(2215, 'Quang Thiện', 'Xã Quang Thiện', 'Xã Quang Thiện, Tỉnh Ninh Bình', '10530', 'xa', '34'),
(2216, 'Phát Diệm', 'Xã Phát Diệm', 'Xã Phát Diệm, Tỉnh Ninh Bình', '10786', 'xa', '34'),
(2217, 'Lai Thành', 'Xã Lai Thành', 'Xã Lai Thành, Tỉnh Ninh Bình', '11042', 'xa', '34'),
(2218, 'Định Hóa', 'Xã Định Hóa', 'Xã Định Hóa, Tỉnh Ninh Bình', '11298', 'xa', '34'),
(2219, 'Bình Minh', 'Xã Bình Minh', 'Xã Bình Minh, Tỉnh Ninh Bình', '11554', 'xa', '34'),
(2220, 'Kim Đông', 'Xã Kim Đông', 'Xã Kim Đông, Tỉnh Ninh Bình', '11810', 'xa', '34'),
(2221, 'Nam Định', 'Phường Nam Định', 'Phường Nam Định, Tỉnh Ninh Bình', '12066', 'phuong', '34'),
(2222, 'Thiên Trường', 'Phường Thiên Trường', 'Phường Thiên Trường, Tỉnh Ninh Bình', '12322', 'phuong', '34'),
(2223, 'Đông A', 'Phường Đông A', 'Phường Đông A, Tỉnh Ninh Bình', '12578', 'phuong', '34'),
(2224, 'Thành Nam', 'Phường Thành Nam', 'Phường Thành Nam, Tỉnh Ninh Bình', '12834', 'phuong', '34'),
(2225, 'Trường Thi', 'Phường Trường Thi', 'Phường Trường Thi, Tỉnh Ninh Bình', '13090', 'phuong', '34'),
(2226, 'Hồng Quang', 'Phường Hồng Quang', 'Phường Hồng Quang, Tỉnh Ninh Bình', '13346', 'phuong', '34'),
(2227, 'Nam Trực', 'Xã Nam Trực', 'Xã Nam Trực, Tỉnh Ninh Bình', '13602', 'xa', '34'),
(2228, 'Nam Minh', 'Xã Nam Minh', 'Xã Nam Minh, Tỉnh Ninh Bình', '13858', 'xa', '34'),
(2229, 'Nam Đồng', 'Xã Nam Đồng', 'Xã Nam Đồng, Tỉnh Ninh Bình', '14114', 'xa', '34'),
(2230, 'Nam Ninh', 'Xã Nam Ninh', 'Xã Nam Ninh, Tỉnh Ninh Bình', '14370', 'xa', '34'),
(2231, 'Nam Hồng', 'Xã Nam Hồng', 'Xã Nam Hồng, Tỉnh Ninh Bình', '14626', 'xa', '34'),
(2232, 'Minh Tân', 'Xã Minh Tân', 'Xã Minh Tân, Tỉnh Ninh Bình', '14882', 'xa', '34'),
(2233, 'Hiển Khánh', 'Xã Hiển Khánh', 'Xã Hiển Khánh, Tỉnh Ninh Bình', '15138', 'xa', '34'),
(2234, 'Vụ Bản', 'Xã Vụ Bản', 'Xã Vụ Bản, Tỉnh Ninh Bình', '15394', 'xa', '34'),
(2235, 'Liên Minh', 'Xã Liên Minh', 'Xã Liên Minh, Tỉnh Ninh Bình', '15650', 'xa', '34'),
(2236, 'Ý Yên', 'Xã Ý Yên', 'Xã Ý Yên, Tỉnh Ninh Bình', '15906', 'xa', '34'),
(2237, 'Yên Đồng', 'Xã Yên Đồng', 'Xã Yên Đồng, Tỉnh Ninh Bình', '16162', 'xa', '34'),
(2238, 'Yên Cường', 'Xã Yên Cường', 'Xã Yên Cường, Tỉnh Ninh Bình', '16418', 'xa', '34'),
(2239, 'Vạn Thắng', 'Xã Vạn Thắng', 'Xã Vạn Thắng, Tỉnh Ninh Bình', '16674', 'xa', '34'),
(2240, 'Vũ Dương', 'Xã Vũ Dương', 'Xã Vũ Dương, Tỉnh Ninh Bình', '16930', 'xa', '34'),
(2241, 'Tân Minh', 'Xã Tân Minh', 'Xã Tân Minh, Tỉnh Ninh Bình', '17186', 'xa', '34'),
(2242, 'Phong Doanh', 'Xã Phong Doanh', 'Xã Phong Doanh, Tỉnh Ninh Bình', '17442', 'xa', '34'),
(2243, 'Cổ Lễ', 'Xã Cổ Lễ', 'Xã Cổ Lễ, Tỉnh Ninh Bình', '17698', 'xa', '34'),
(2244, 'Ninh Giang', 'Xã Ninh Giang', 'Xã Ninh Giang, Tỉnh Ninh Bình', '17954', 'xa', '34'),
(2245, 'Cát Thành', 'Xã Cát Thành', 'Xã Cát Thành, Tỉnh Ninh Bình', '18210', 'xa', '34'),
(2246, 'Trực Ninh', 'Xã Trực Ninh', 'Xã Trực Ninh, Tỉnh Ninh Bình', '18466', 'xa', '34'),
(2247, 'Quang Hưng', 'Xã Quang Hưng', 'Xã Quang Hưng, Tỉnh Ninh Bình', '18722', 'xa', '34'),
(2248, 'Minh Thái', 'Xã Minh Thái', 'Xã Minh Thái, Tỉnh Ninh Bình', '18978', 'xa', '34'),
(2249, 'Ninh Cường', 'Xã Ninh Cường', 'Xã Ninh Cường, Tỉnh Ninh Bình', '19234', 'xa', '34'),
(2250, 'Xuân Trường', 'Xã Xuân Trường', 'Xã Xuân Trường, Tỉnh Ninh Bình', '19490', 'xa', '34');
INSERT INTO `vn_locations` (`id`, `name`, `full_name`, `full_path`, `code`, `level`, `parent_code`) VALUES
(2251, 'Xuân Hưng', 'Xã Xuân Hưng', 'Xã Xuân Hưng, Tỉnh Ninh Bình', '19746', 'xa', '34'),
(2252, 'Xuân Giang', 'Xã Xuân Giang', 'Xã Xuân Giang, Tỉnh Ninh Bình', '20002', 'xa', '34'),
(2253, 'Xuân Hồng', 'Xã Xuân Hồng', 'Xã Xuân Hồng, Tỉnh Ninh Bình', '20258', 'xa', '34'),
(2254, 'Hải Hậu', 'Xã Hải Hậu', 'Xã Hải Hậu, Tỉnh Ninh Bình', '20514', 'xa', '34'),
(2255, 'Hải Anh', 'Xã Hải Anh', 'Xã Hải Anh, Tỉnh Ninh Bình', '20770', 'xa', '34'),
(2256, 'Hải Tiến', 'Xã Hải Tiến', 'Xã Hải Tiến, Tỉnh Ninh Bình', '21026', 'xa', '34'),
(2257, 'Hải Hưng', 'Xã Hải Hưng', 'Xã Hải Hưng, Tỉnh Ninh Bình', '21282', 'xa', '34'),
(2258, 'Hải An', 'Xã Hải An', 'Xã Hải An, Tỉnh Ninh Bình', '21538', 'xa', '34'),
(2259, 'Hải Quang', 'Xã Hải Quang', 'Xã Hải Quang, Tỉnh Ninh Bình', '21794', 'xa', '34'),
(2260, 'Hải Xuân', 'Xã Hải Xuân', 'Xã Hải Xuân, Tỉnh Ninh Bình', '22050', 'xa', '34'),
(2261, 'Hải Thịnh', 'Xã Hải Thịnh', 'Xã Hải Thịnh, Tỉnh Ninh Bình', '22306', 'xa', '34'),
(2262, 'Đồng Thịnh', 'Xã Đồng Thịnh', 'Xã Đồng Thịnh, Tỉnh Ninh Bình', '22562', 'xa', '34'),
(2263, 'Nghĩa Hưng', 'Xã Nghĩa Hưng', 'Xã Nghĩa Hưng, Tỉnh Ninh Bình', '22818', 'xa', '34'),
(2264, 'Nghĩa Sơn', 'Xã Nghĩa Sơn', 'Xã Nghĩa Sơn, Tỉnh Ninh Bình', '23074', 'xa', '34'),
(2265, 'Hồng Phong', 'Xã Hồng Phong', 'Xã Hồng Phong, Tỉnh Ninh Bình', '23330', 'xa', '34'),
(2266, 'Quỹ Nhất', 'Xã Quỹ Nhất', 'Xã Quỹ Nhất, Tỉnh Ninh Bình', '23586', 'xa', '34'),
(2267, 'Nghĩa Lâm', 'Xã Nghĩa Lâm', 'Xã Nghĩa Lâm, Tỉnh Ninh Bình', '23842', 'xa', '34'),
(2268, 'Rạng Đông', 'Xã Rạng Đông', 'Xã Rạng Đông, Tỉnh Ninh Bình', '24098', 'xa', '34'),
(2269, 'Vị Khê', 'Phường Vị Khê', 'Phường Vị Khê, Tỉnh Ninh Bình', '24354', 'phuong', '34'),
(2270, 'Giao Minh', 'Xã Giao Minh', 'Xã Giao Minh, Tỉnh Ninh Bình', '24610', 'xa', '34'),
(2271, 'Giao Hoà', 'Xã Giao Hoà', 'Xã Giao Hoà, Tỉnh Ninh Bình', '24866', 'xa', '34'),
(2272, 'Giao Thuỷ', 'Xã Giao Thuỷ', 'Xã Giao Thuỷ, Tỉnh Ninh Bình', '25122', 'xa', '34'),
(2273, 'Giao Phúc', 'Xã Giao Phúc', 'Xã Giao Phúc, Tỉnh Ninh Bình', '25378', 'xa', '34'),
(2274, 'Giao Hưng', 'Xã Giao Hưng', 'Xã Giao Hưng, Tỉnh Ninh Bình', '25634', 'xa', '34'),
(2275, 'Giao Bình', 'Xã Giao Bình', 'Xã Giao Bình, Tỉnh Ninh Bình', '25890', 'xa', '34'),
(2276, 'Giao Ninh', 'Xã Giao Ninh', 'Xã Giao Ninh, Tỉnh Ninh Bình', '26146', 'xa', '34'),
(2277, 'Đồng Văn', 'Phường Đồng Văn', 'Phường Đồng Văn, Tỉnh Ninh Bình', '26402', 'phuong', '34'),
(2278, 'Lê Hồ', 'Phường Lê Hồ', 'Phường Lê Hồ, Tỉnh Ninh Bình', '26658', 'phuong', '34'),
(2279, 'Nguyễn Uý', 'Phường Nguyễn Uý', 'Phường Nguyễn Uý, Tỉnh Ninh Bình', '26914', 'phuong', '34'),
(2280, 'Lý Thường Kiệt', 'Phường Lý Thường Kiệt', 'Phường Lý Thường Kiệt, Tỉnh Ninh Bình', '27170', 'phuong', '34'),
(2281, 'Kim Thanh', 'Phường Kim Thanh', 'Phường Kim Thanh, Tỉnh Ninh Bình', '27426', 'phuong', '34'),
(2282, 'Tam Chúc', 'Phường Tam Chúc', 'Phường Tam Chúc, Tỉnh Ninh Bình', '27682', 'phuong', '34'),
(2283, 'Phù Vân', 'Phường Phù Vân', 'Phường Phù Vân, Tỉnh Ninh Bình', '27938', 'phuong', '34'),
(2284, 'Châu Sơn', 'Phường Châu Sơn', 'Phường Châu Sơn, Tỉnh Ninh Bình', '28194', 'phuong', '34'),
(2285, 'Liêm Tuyền', 'Phường Liêm Tuyền', 'Phường Liêm Tuyền, Tỉnh Ninh Bình', '28450', 'phuong', '34'),
(2286, 'Bình Lục', 'Xã Bình Lục', 'Xã Bình Lục, Tỉnh Ninh Bình', '28706', 'xa', '34'),
(2287, 'Bình Mỹ', 'Xã Bình Mỹ', 'Xã Bình Mỹ, Tỉnh Ninh Bình', '28962', 'xa', '34'),
(2288, 'Bình An', 'Xã Bình An', 'Xã Bình An, Tỉnh Ninh Bình', '29218', 'xa', '34'),
(2289, 'Bình Giang', 'Xã Bình Giang', 'Xã Bình Giang, Tỉnh Ninh Bình', '29474', 'xa', '34'),
(2290, 'Bình Sơn', 'Xã Bình Sơn', 'Xã Bình Sơn, Tỉnh Ninh Bình', '29730', 'xa', '34'),
(2291, 'Liêm Hà', 'Xã Liêm Hà', 'Xã Liêm Hà, Tỉnh Ninh Bình', '29986', 'xa', '34'),
(2292, 'Tân Thanh', 'Xã Tân Thanh', 'Xã Tân Thanh, Tỉnh Ninh Bình', '30242', 'xa', '34'),
(2293, 'Thanh Lâm', 'Xã Thanh Lâm', 'Xã Thanh Lâm, Tỉnh Ninh Bình', '30498', 'xa', '34'),
(2294, 'Lý Nhân', 'Xã Lý Nhân', 'Xã Lý Nhân, Tỉnh Ninh Bình', '30754', 'xa', '34'),
(2295, 'Nam Xang', 'Xã Nam Xang', 'Xã Nam Xang, Tỉnh Ninh Bình', '31010', 'xa', '34'),
(2296, 'Bắc Lý', 'Xã Bắc Lý', 'Xã Bắc Lý, Tỉnh Ninh Bình', '31266', 'xa', '34'),
(2297, 'Vĩnh Trụ', 'Xã Vĩnh Trụ', 'Xã Vĩnh Trụ, Tỉnh Ninh Bình', '31522', 'xa', '34'),
(2298, 'Trần Thương', 'Xã Trần Thương', 'Xã Trần Thương, Tỉnh Ninh Bình', '31778', 'xa', '34'),
(2299, 'Nhân Hà', 'Xã Nhân Hà', 'Xã Nhân Hà, Tỉnh Ninh Bình', '32034', 'xa', '34'),
(2300, 'Nam Lý', 'Xã Nam Lý', 'Xã Nam Lý, Tỉnh Ninh Bình', '32290', 'xa', '34'),
(2301, 'Kim Bảng', 'Phường Kim Bảng', 'Phường Kim Bảng, Tỉnh Ninh Bình', '32546', 'phuong', '34'),
(2302, 'Duy Tiên', 'Phường Duy Tiên', 'Phường Duy Tiên, Tỉnh Ninh Bình', '32802', 'phuong', '34'),
(2303, 'Phủ Lý', 'Phường Phủ Lý', 'Phường Phủ Lý, Tỉnh Ninh Bình', '33058', 'phuong', '34'),
(2304, 'Trung Sơn', 'Xã Trung Sơn', 'Xã Trung Sơn, Tỉnh Phú Thọ', '291', 'xa', '35'),
(2305, 'Thu Cúc', 'Xã Thu Cúc', 'Xã Thu Cúc, Tỉnh Phú Thọ', '547', 'xa', '35'),
(2306, 'Tiền Phong', 'Xã Tiền Phong', 'Xã Tiền Phong, Tỉnh Phú Thọ', '803', 'xa', '35'),
(2307, 'Liên Sơn', 'Xã Liên Sơn', 'Xã Liên Sơn, Tỉnh Phú Thọ', '1059', 'xa', '35'),
(2308, 'Mai Châu', 'Xã Mai Châu', 'Xã Mai Châu, Tỉnh Phú Thọ', '1315', 'xa', '35'),
(2309, 'Pà Cò', 'Xã Pà Cò', 'Xã Pà Cò, Tỉnh Phú Thọ', '1571', 'xa', '35'),
(2310, 'Thống Nhất', 'Phường Thống Nhất', 'Phường Thống Nhất, Tỉnh Phú Thọ', '1827', 'phuong', '35'),
(2311, 'Đạo Trù', 'Xã Đạo Trù', 'Xã Đạo Trù, Tỉnh Phú Thọ', '2083', 'xa', '35'),
(2312, 'Phúc Yên', 'Phường Phúc Yên', 'Phường Phúc Yên, Tỉnh Phú Thọ', '2339', 'phuong', '35'),
(2313, 'Xuân Hòa', 'Phường Xuân Hòa', 'Phường Xuân Hòa, Tỉnh Phú Thọ', '2595', 'phuong', '35'),
(2314, 'Lương Sơn', 'Xã Lương Sơn', 'Xã Lương Sơn, Tỉnh Phú Thọ', '2851', 'xa', '35'),
(2315, 'Cao Phong', 'Xã Cao Phong', 'Xã Cao Phong, Tỉnh Phú Thọ', '3107', 'xa', '35'),
(2316, 'Mường Thàng', 'Xã Mường Thàng', 'Xã Mường Thàng, Tỉnh Phú Thọ', '3363', 'xa', '35'),
(2317, 'Thung Nai', 'Xã Thung Nai', 'Xã Thung Nai, Tỉnh Phú Thọ', '3619', 'xa', '35'),
(2318, 'Đà Bắc', 'Xã Đà Bắc', 'Xã Đà Bắc, Tỉnh Phú Thọ', '3875', 'xa', '35'),
(2319, 'Cao Sơn', 'Xã Cao Sơn', 'Xã Cao Sơn, Tỉnh Phú Thọ', '4131', 'xa', '35'),
(2320, 'Đức Nhàn', 'Xã Đức Nhàn', 'Xã Đức Nhàn, Tỉnh Phú Thọ', '4387', 'xa', '35'),
(2321, 'Quy Đức', 'Xã Quy Đức', 'Xã Quy Đức, Tỉnh Phú Thọ', '4643', 'xa', '35'),
(2322, 'Tân Pheo', 'Xã Tân Pheo', 'Xã Tân Pheo, Tỉnh Phú Thọ', '4899', 'xa', '35'),
(2323, 'Kim Bôi', 'Xã Kim Bôi', 'Xã Kim Bôi, Tỉnh Phú Thọ', '5155', 'xa', '35'),
(2324, 'Mường Động', 'Xã Mường Động', 'Xã Mường Động, Tỉnh Phú Thọ', '5411', 'xa', '35'),
(2325, 'Dũng Tiến', 'Xã Dũng Tiến', 'Xã Dũng Tiến, Tỉnh Phú Thọ', '5667', 'xa', '35'),
(2326, 'Hợp Kim', 'Xã Hợp Kim', 'Xã Hợp Kim, Tỉnh Phú Thọ', '5923', 'xa', '35'),
(2327, 'Nật Sơn', 'Xã Nật Sơn', 'Xã Nật Sơn, Tỉnh Phú Thọ', '6179', 'xa', '35'),
(2328, 'Lạc Sơn', 'Xã Lạc Sơn', 'Xã Lạc Sơn, Tỉnh Phú Thọ', '6435', 'xa', '35'),
(2329, 'Mường Vang', 'Xã Mường Vang', 'Xã Mường Vang, Tỉnh Phú Thọ', '6691', 'xa', '35'),
(2330, 'Đại Đồng', 'Xã Đại Đồng', 'Xã Đại Đồng, Tỉnh Phú Thọ', '6947', 'xa', '35'),
(2331, 'Ngọc Sơn', 'Xã Ngọc Sơn', 'Xã Ngọc Sơn, Tỉnh Phú Thọ', '7203', 'xa', '35'),
(2332, 'Nhân Nghĩa', 'Xã Nhân Nghĩa', 'Xã Nhân Nghĩa, Tỉnh Phú Thọ', '7459', 'xa', '35'),
(2333, 'Quyết Thắng', 'Xã Quyết Thắng', 'Xã Quyết Thắng, Tỉnh Phú Thọ', '7715', 'xa', '35'),
(2334, 'Thượng Cốc', 'Xã Thượng Cốc', 'Xã Thượng Cốc, Tỉnh Phú Thọ', '7971', 'xa', '35'),
(2335, 'Yên Phú', 'Xã Yên Phú', 'Xã Yên Phú, Tỉnh Phú Thọ', '8227', 'xa', '35'),
(2336, 'Lạc Thủy', 'Xã Lạc Thủy', 'Xã Lạc Thủy, Tỉnh Phú Thọ', '8483', 'xa', '35'),
(2337, 'An Bình', 'Xã An Bình', 'Xã An Bình, Tỉnh Phú Thọ', '8739', 'xa', '35'),
(2338, 'An Nghĩa', 'Xã An Nghĩa', 'Xã An Nghĩa, Tỉnh Phú Thọ', '8995', 'xa', '35'),
(2339, 'Cao Dương', 'Xã Cao Dương', 'Xã Cao Dương, Tỉnh Phú Thọ', '9251', 'xa', '35'),
(2340, 'Bao La', 'Xã Bao La', 'Xã Bao La, Tỉnh Phú Thọ', '9507', 'xa', '35'),
(2341, 'Mai Hạ', 'Xã Mai Hạ', 'Xã Mai Hạ, Tỉnh Phú Thọ', '9763', 'xa', '35'),
(2342, 'Tân Mai', 'Xã Tân Mai', 'Xã Tân Mai, Tỉnh Phú Thọ', '10019', 'xa', '35'),
(2343, 'Tân Lạc', 'Xã Tân Lạc', 'Xã Tân Lạc, Tỉnh Phú Thọ', '10275', 'xa', '35'),
(2344, 'Mường Bi', 'Xã Mường Bi', 'Xã Mường Bi, Tỉnh Phú Thọ', '10531', 'xa', '35'),
(2345, 'Toàn Thắng', 'Xã Toàn Thắng', 'Xã Toàn Thắng, Tỉnh Phú Thọ', '10787', 'xa', '35'),
(2346, 'Mường Hoa', 'Xã Mường Hoa', 'Xã Mường Hoa, Tỉnh Phú Thọ', '11043', 'xa', '35'),
(2347, 'Vân Sơn', 'Xã Vân Sơn', 'Xã Vân Sơn, Tỉnh Phú Thọ', '11299', 'xa', '35'),
(2348, 'Yên Thủy', 'Xã Yên Thủy', 'Xã Yên Thủy, Tỉnh Phú Thọ', '11555', 'xa', '35'),
(2349, 'Lạc Lương', 'Xã Lạc Lương', 'Xã Lạc Lương, Tỉnh Phú Thọ', '11811', 'xa', '35'),
(2350, 'Yên Trị', 'Xã Yên Trị', 'Xã Yên Trị, Tỉnh Phú Thọ', '12067', 'xa', '35'),
(2351, 'Thịnh Minh', 'Xã Thịnh Minh', 'Xã Thịnh Minh, Tỉnh Phú Thọ', '12323', 'xa', '35'),
(2352, 'Hòa Bình', 'Phường Hòa Bình', 'Phường Hòa Bình, Tỉnh Phú Thọ', '12579', 'phuong', '35'),
(2353, 'Kỳ Sơn', 'Phường Kỳ Sơn', 'Phường Kỳ Sơn, Tỉnh Phú Thọ', '12835', 'phuong', '35'),
(2354, 'Tân Hòa', 'Phường Tân Hòa', 'Phường Tân Hòa, Tỉnh Phú Thọ', '13091', 'phuong', '35'),
(2355, 'Tam Sơn', 'Xã Tam Sơn', 'Xã Tam Sơn, Tỉnh Phú Thọ', '13347', 'xa', '35'),
(2356, 'Sông Lô', 'Xã Sông Lô', 'Xã Sông Lô, Tỉnh Phú Thọ', '13603', 'xa', '35'),
(2357, 'Hải Lựu', 'Xã Hải Lựu', 'Xã Hải Lựu, Tỉnh Phú Thọ', '13859', 'xa', '35'),
(2358, 'Yên Lãng', 'Xã Yên Lãng', 'Xã Yên Lãng, Tỉnh Phú Thọ', '14115', 'xa', '35'),
(2359, 'Lập Thạch', 'Xã Lập Thạch', 'Xã Lập Thạch, Tỉnh Phú Thọ', '14371', 'xa', '35'),
(2360, 'Tiên Lữ', 'Xã Tiên Lữ', 'Xã Tiên Lữ, Tỉnh Phú Thọ', '14627', 'xa', '35'),
(2361, 'Thái Hòa', 'Xã Thái Hòa', 'Xã Thái Hòa, Tỉnh Phú Thọ', '14883', 'xa', '35'),
(2362, 'Liên Hòa', 'Xã Liên Hòa', 'Xã Liên Hòa, Tỉnh Phú Thọ', '15139', 'xa', '35'),
(2363, 'Hợp Lý', 'Xã Hợp Lý', 'Xã Hợp Lý, Tỉnh Phú Thọ', '15395', 'xa', '35'),
(2364, 'Sơn Đông', 'Xã Sơn Đông', 'Xã Sơn Đông, Tỉnh Phú Thọ', '15651', 'xa', '35'),
(2365, 'Tam Đảo', 'Xã Tam Đảo', 'Xã Tam Đảo, Tỉnh Phú Thọ', '15907', 'xa', '35'),
(2366, 'Đại Đình', 'Xã Đại Đình', 'Xã Đại Đình, Tỉnh Phú Thọ', '16163', 'xa', '35'),
(2367, 'Tam Dương', 'Xã Tam Dương', 'Xã Tam Dương, Tỉnh Phú Thọ', '16419', 'xa', '35'),
(2368, 'Hội Thịnh', 'Xã Hội Thịnh', 'Xã Hội Thịnh, Tỉnh Phú Thọ', '16675', 'xa', '35'),
(2369, 'Hoàng An', 'Xã Hoàng An', 'Xã Hoàng An, Tỉnh Phú Thọ', '16931', 'xa', '35'),
(2370, 'Tam Dương Bắc', 'Xã Tam Dương Bắc', 'Xã Tam Dương Bắc, Tỉnh Phú Thọ', '17187', 'xa', '35'),
(2371, 'Vĩnh Tường', 'Xã Vĩnh Tường', 'Xã Vĩnh Tường, Tỉnh Phú Thọ', '17443', 'xa', '35'),
(2372, 'Thổ Tang', 'Xã Thổ Tang', 'Xã Thổ Tang, Tỉnh Phú Thọ', '17699', 'xa', '35'),
(2373, 'Vĩnh Hưng', 'Xã Vĩnh Hưng', 'Xã Vĩnh Hưng, Tỉnh Phú Thọ', '17955', 'xa', '35'),
(2374, 'Vĩnh An', 'Xã Vĩnh An', 'Xã Vĩnh An, Tỉnh Phú Thọ', '18211', 'xa', '35'),
(2375, 'Vĩnh Phú', 'Xã Vĩnh Phú', 'Xã Vĩnh Phú, Tỉnh Phú Thọ', '18467', 'xa', '35'),
(2376, 'Vĩnh Thành', 'Xã Vĩnh Thành', 'Xã Vĩnh Thành, Tỉnh Phú Thọ', '18723', 'xa', '35'),
(2377, 'Yên Lạc', 'Xã Yên Lạc', 'Xã Yên Lạc, Tỉnh Phú Thọ', '18979', 'xa', '35'),
(2378, 'Tề Lỗ', 'Xã Tề Lỗ', 'Xã Tề Lỗ, Tỉnh Phú Thọ', '19235', 'xa', '35'),
(2379, 'Liên Châu', 'Xã Liên Châu', 'Xã Liên Châu, Tỉnh Phú Thọ', '19491', 'xa', '35'),
(2380, 'Tam Hồng', 'Xã Tam Hồng', 'Xã Tam Hồng, Tỉnh Phú Thọ', '19747', 'xa', '35'),
(2381, 'Nguyệt Đức', 'Xã Nguyệt Đức', 'Xã Nguyệt Đức, Tỉnh Phú Thọ', '20003', 'xa', '35'),
(2382, 'Bình Nguyên', 'Xã Bình Nguyên', 'Xã Bình Nguyên, Tỉnh Phú Thọ', '20259', 'xa', '35'),
(2383, 'Xuân Lãng', 'Xã Xuân Lãng', 'Xã Xuân Lãng, Tỉnh Phú Thọ', '20515', 'xa', '35'),
(2384, 'Bình Xuyên', 'Xã Bình Xuyên', 'Xã Bình Xuyên, Tỉnh Phú Thọ', '20771', 'xa', '35'),
(2385, 'Bình Tuyền', 'Xã Bình Tuyền', 'Xã Bình Tuyền, Tỉnh Phú Thọ', '21027', 'xa', '35'),
(2386, 'Vĩnh Phúc', 'Phường Vĩnh Phúc', 'Phường Vĩnh Phúc, Tỉnh Phú Thọ', '21283', 'phuong', '35'),
(2387, 'Vĩnh Yên', 'Phường Vĩnh Yên', 'Phường Vĩnh Yên, Tỉnh Phú Thọ', '21539', 'phuong', '35'),
(2388, 'Vân Phú', 'Phường Vân Phú', 'Phường Vân Phú, Tỉnh Phú Thọ', '21795', 'phuong', '35'),
(2389, 'Hy Cương', 'Xã Hy Cương', 'Xã Hy Cương, Tỉnh Phú Thọ', '22051', 'xa', '35'),
(2390, 'Lâm Thao', 'Xã Lâm Thao', 'Xã Lâm Thao, Tỉnh Phú Thọ', '22307', 'xa', '35'),
(2391, 'Xuân Lũng', 'Xã Xuân Lũng', 'Xã Xuân Lũng, Tỉnh Phú Thọ', '22563', 'xa', '35'),
(2392, 'Phùng Nguyên', 'Xã Phùng Nguyên', 'Xã Phùng Nguyên, Tỉnh Phú Thọ', '22819', 'xa', '35'),
(2393, 'Bản Nguyên', 'Xã Bản Nguyên', 'Xã Bản Nguyên, Tỉnh Phú Thọ', '23075', 'xa', '35'),
(2394, 'Phong Châu', 'Phường Phong Châu', 'Phường Phong Châu, Tỉnh Phú Thọ', '23331', 'phuong', '35'),
(2395, 'Phú Thọ', 'Phường Phú Thọ', 'Phường Phú Thọ, Tỉnh Phú Thọ', '23587', 'phuong', '35'),
(2396, 'Âu Cơ', 'Phường Âu Cơ', 'Phường Âu Cơ, Tỉnh Phú Thọ', '23843', 'phuong', '35'),
(2397, 'Phù Ninh', 'Xã Phù Ninh', 'Xã Phù Ninh, Tỉnh Phú Thọ', '24099', 'xa', '35'),
(2398, 'Dân Chủ', 'Xã Dân Chủ', 'Xã Dân Chủ, Tỉnh Phú Thọ', '24355', 'xa', '35'),
(2399, 'Phú Mỹ', 'Xã Phú Mỹ', 'Xã Phú Mỹ, Tỉnh Phú Thọ', '24611', 'xa', '35'),
(2400, 'Trạm Thản', 'Xã Trạm Thản', 'Xã Trạm Thản, Tỉnh Phú Thọ', '24867', 'xa', '35'),
(2401, 'Bình Phú', 'Xã Bình Phú', 'Xã Bình Phú, Tỉnh Phú Thọ', '25123', 'xa', '35'),
(2402, 'Thanh Ba', 'Xã Thanh Ba', 'Xã Thanh Ba, Tỉnh Phú Thọ', '25379', 'xa', '35'),
(2403, 'Quảng Yên', 'Xã Quảng Yên', 'Xã Quảng Yên, Tỉnh Phú Thọ', '25635', 'xa', '35'),
(2404, 'Hoàng Cương', 'Xã Hoàng Cương', 'Xã Hoàng Cương, Tỉnh Phú Thọ', '25891', 'xa', '35'),
(2405, 'Đông Thành', 'Xã Đông Thành', 'Xã Đông Thành, Tỉnh Phú Thọ', '26147', 'xa', '35'),
(2406, 'Chí Tiên', 'Xã Chí Tiên', 'Xã Chí Tiên, Tỉnh Phú Thọ', '26403', 'xa', '35'),
(2407, 'Liên Minh', 'Xã Liên Minh', 'Xã Liên Minh, Tỉnh Phú Thọ', '26659', 'xa', '35'),
(2408, 'Đoan Hùng', 'Xã Đoan Hùng', 'Xã Đoan Hùng, Tỉnh Phú Thọ', '26915', 'xa', '35'),
(2409, 'Tây Cốc', 'Xã Tây Cốc', 'Xã Tây Cốc, Tỉnh Phú Thọ', '27171', 'xa', '35'),
(2410, 'Chân Mộng', 'Xã Chân Mộng', 'Xã Chân Mộng, Tỉnh Phú Thọ', '27427', 'xa', '35'),
(2411, 'Chí Đám', 'Xã Chí Đám', 'Xã Chí Đám, Tỉnh Phú Thọ', '27683', 'xa', '35'),
(2412, 'Bằng Luân', 'Xã Bằng Luân', 'Xã Bằng Luân, Tỉnh Phú Thọ', '27939', 'xa', '35'),
(2413, 'Hạ Hòa', 'Xã Hạ Hòa', 'Xã Hạ Hòa, Tỉnh Phú Thọ', '28195', 'xa', '35'),
(2414, 'Đan Thượng', 'Xã Đan Thượng', 'Xã Đan Thượng, Tỉnh Phú Thọ', '28451', 'xa', '35'),
(2415, 'Yên Kỳ', 'Xã Yên Kỳ', 'Xã Yên Kỳ, Tỉnh Phú Thọ', '28707', 'xa', '35'),
(2416, 'Vĩnh Chân', 'Xã Vĩnh Chân', 'Xã Vĩnh Chân, Tỉnh Phú Thọ', '28963', 'xa', '35'),
(2417, 'Văn Lang', 'Xã Văn Lang', 'Xã Văn Lang, Tỉnh Phú Thọ', '29219', 'xa', '35'),
(2418, 'Hiền Lương', 'Xã Hiền Lương', 'Xã Hiền Lương, Tỉnh Phú Thọ', '29475', 'xa', '35'),
(2419, 'Cẩm Khê', 'Xã Cẩm Khê', 'Xã Cẩm Khê, Tỉnh Phú Thọ', '29731', 'xa', '35'),
(2420, 'Phú Khê', 'Xã Phú Khê', 'Xã Phú Khê, Tỉnh Phú Thọ', '29987', 'xa', '35'),
(2421, 'Hùng Việt', 'Xã Hùng Việt', 'Xã Hùng Việt, Tỉnh Phú Thọ', '30243', 'xa', '35'),
(2422, 'Đồng Lương', 'Xã Đồng Lương', 'Xã Đồng Lương, Tỉnh Phú Thọ', '30499', 'xa', '35'),
(2423, 'Tiên Lương', 'Xã Tiên Lương', 'Xã Tiên Lương, Tỉnh Phú Thọ', '30755', 'xa', '35'),
(2424, 'Vân Bán', 'Xã Vân Bán', 'Xã Vân Bán, Tỉnh Phú Thọ', '31011', 'xa', '35'),
(2425, 'Tam Nông', 'Xã Tam Nông', 'Xã Tam Nông, Tỉnh Phú Thọ', '31267', 'xa', '35'),
(2426, 'Thọ Văn', 'Xã Thọ Văn', 'Xã Thọ Văn, Tỉnh Phú Thọ', '31523', 'xa', '35'),
(2427, 'Vạn Xuân', 'Xã Vạn Xuân', 'Xã Vạn Xuân, Tỉnh Phú Thọ', '31779', 'xa', '35'),
(2428, 'Hiền Quan', 'Xã Hiền Quan', 'Xã Hiền Quan, Tỉnh Phú Thọ', '32035', 'xa', '35'),
(2429, 'Thanh Thủy', 'Xã Thanh Thủy', 'Xã Thanh Thủy, Tỉnh Phú Thọ', '32291', 'xa', '35'),
(2430, 'Đào Xá', 'Xã Đào Xá', 'Xã Đào Xá, Tỉnh Phú Thọ', '32547', 'xa', '35'),
(2431, 'Tu Vũ', 'Xã Tu Vũ', 'Xã Tu Vũ, Tỉnh Phú Thọ', '32803', 'xa', '35'),
(2432, 'Thanh Sơn', 'Xã Thanh Sơn', 'Xã Thanh Sơn, Tỉnh Phú Thọ', '33059', 'xa', '35'),
(2433, 'Võ Miếu', 'Xã Võ Miếu', 'Xã Võ Miếu, Tỉnh Phú Thọ', '33315', 'xa', '35'),
(2434, 'Văn Miếu', 'Xã Văn Miếu', 'Xã Văn Miếu, Tỉnh Phú Thọ', '33571', 'xa', '35'),
(2435, 'Cự Đồng', 'Xã Cự Đồng', 'Xã Cự Đồng, Tỉnh Phú Thọ', '33827', 'xa', '35'),
(2436, 'Hương Cần', 'Xã Hương Cần', 'Xã Hương Cần, Tỉnh Phú Thọ', '34083', 'xa', '35'),
(2437, 'Yên Sơn', 'Xã Yên Sơn', 'Xã Yên Sơn, Tỉnh Phú Thọ', '34339', 'xa', '35'),
(2438, 'Khả Cửu', 'Xã Khả Cửu', 'Xã Khả Cửu, Tỉnh Phú Thọ', '34595', 'xa', '35'),
(2439, 'Tân Sơn', 'Xã Tân Sơn', 'Xã Tân Sơn, Tỉnh Phú Thọ', '34851', 'xa', '35'),
(2440, 'Minh Đài', 'Xã Minh Đài', 'Xã Minh Đài, Tỉnh Phú Thọ', '35107', 'xa', '35'),
(2441, 'Lai Đồng', 'Xã Lai Đồng', 'Xã Lai Đồng, Tỉnh Phú Thọ', '35363', 'xa', '35'),
(2442, 'Xuân Đài', 'Xã Xuân Đài', 'Xã Xuân Đài, Tỉnh Phú Thọ', '35619', 'xa', '35'),
(2443, 'Long Cốc', 'Xã Long Cốc', 'Xã Long Cốc, Tỉnh Phú Thọ', '35875', 'xa', '35'),
(2444, 'Yên Lập', 'Xã Yên Lập', 'Xã Yên Lập, Tỉnh Phú Thọ', '36131', 'xa', '35'),
(2445, 'Thượng Long', 'Xã Thượng Long', 'Xã Thượng Long, Tỉnh Phú Thọ', '36387', 'xa', '35'),
(2446, 'Sơn Lương', 'Xã Sơn Lương', 'Xã Sơn Lương, Tỉnh Phú Thọ', '36643', 'xa', '35'),
(2447, 'Xuân Viên', 'Xã Xuân Viên', 'Xã Xuân Viên, Tỉnh Phú Thọ', '36899', 'xa', '35'),
(2448, 'Minh Hòa', 'Xã Minh Hòa', 'Xã Minh Hòa, Tỉnh Phú Thọ', '37155', 'xa', '35'),
(2449, 'Việt Trì', 'Phường Việt Trì', 'Phường Việt Trì, Tỉnh Phú Thọ', '37411', 'phuong', '35'),
(2450, 'Nông Trang', 'Phường Nông Trang', 'Phường Nông Trang, Tỉnh Phú Thọ', '37667', 'phuong', '35'),
(2451, 'Thanh Miếu', 'Phường Thanh Miếu', 'Phường Thanh Miếu, Tỉnh Phú Thọ', '37923', 'phuong', '35'),
(2452, 'Đắk Long', 'Xã Đắk Long', 'Xã Đắk Long, Tỉnh Quảng Ngãi', '292', 'xa', '36'),
(2453, 'Ba Xa', 'Xã Ba Xa', 'Xã Ba Xa, Tỉnh Quảng Ngãi', '548', 'xa', '36'),
(2454, 'Cà Đam', 'Xã Cà Đam', 'Xã Cà Đam, Tỉnh Quảng Ngãi', '804', 'xa', '36'),
(2455, 'Vạn Tường', 'Xã Vạn Tường', 'Xã Vạn Tường, Tỉnh Quảng Ngãi', '1060', 'xa', '36'),
(2456, 'Mô Rai', 'Xã Mô Rai', 'Xã Mô Rai, Tỉnh Quảng Ngãi', '1316', 'xa', '36'),
(2457, 'Rơ Kơi', 'Xã Rơ Kơi', 'Xã Rơ Kơi, Tỉnh Quảng Ngãi', '1572', 'xa', '36'),
(2458, 'Ia Đal', 'Xã Ia Đal', 'Xã Ia Đal, Tỉnh Quảng Ngãi', '1828', 'xa', '36'),
(2459, 'Ia Tơi', 'Xã Ia Tơi', 'Xã Ia Tơi, Tỉnh Quảng Ngãi', '2084', 'xa', '36'),
(2460, 'Tây Trà Bồng', 'Xã Tây Trà Bồng', 'Xã Tây Trà Bồng, Tỉnh Quảng Ngãi', '2340', 'xa', '36'),
(2461, 'Đông Sơn', 'Xã Đông Sơn', 'Xã Đông Sơn, Tỉnh Quảng Ngãi', '2596', 'xa', '36'),
(2462, 'Đặc Khu Lý Sơn', 'Xã Đặc Khu Lý Sơn', 'Xã Đặc Khu Lý Sơn, Tỉnh Quảng Ngãi', '2852', 'xa', '36'),
(2463, 'Tịnh Khê', 'Xã Tịnh Khê', 'Xã Tịnh Khê, Tỉnh Quảng Ngãi', '3108', 'xa', '36'),
(2464, 'Trương Quang Trọng', 'Phường Trương Quang Trọng', 'Phường Trương Quang Trọng, Tỉnh Quảng Ngãi', '3364', 'phuong', '36'),
(2465, 'An Phú', 'Xã An Phú', 'Xã An Phú, Tỉnh Quảng Ngãi', '3620', 'xa', '36'),
(2466, 'Cẩm Thành', 'Phường Cẩm Thành', 'Phường Cẩm Thành, Tỉnh Quảng Ngãi', '3876', 'phuong', '36'),
(2467, 'Nghĩa Lộ', 'Phường Nghĩa Lộ', 'Phường Nghĩa Lộ, Tỉnh Quảng Ngãi', '4132', 'phuong', '36'),
(2468, 'Trà Câu', 'Phường Trà Câu', 'Phường Trà Câu, Tỉnh Quảng Ngãi', '4388', 'phuong', '36'),
(2469, 'Nguyễn Nghiêm', 'Xã Nguyễn Nghiêm', 'Xã Nguyễn Nghiêm, Tỉnh Quảng Ngãi', '4644', 'xa', '36'),
(2470, 'Đức Phổ', 'Phường Đức Phổ', 'Phường Đức Phổ, Tỉnh Quảng Ngãi', '4900', 'phuong', '36'),
(2471, 'Khánh Cường', 'Xã Khánh Cường', 'Xã Khánh Cường, Tỉnh Quảng Ngãi', '5156', 'xa', '36'),
(2472, 'Sa Huỳnh', 'Phường Sa Huỳnh', 'Phường Sa Huỳnh, Tỉnh Quảng Ngãi', '5412', 'phuong', '36'),
(2473, 'Bình Minh', 'Xã Bình Minh', 'Xã Bình Minh, Tỉnh Quảng Ngãi', '5668', 'xa', '36'),
(2474, 'Bình Chương', 'Xã Bình Chương', 'Xã Bình Chương, Tỉnh Quảng Ngãi', '5924', 'xa', '36'),
(2475, 'Trường Giang', 'Xã Trường Giang', 'Xã Trường Giang, Tỉnh Quảng Ngãi', '6180', 'xa', '36'),
(2476, 'Ba Gia', 'Xã Ba Gia', 'Xã Ba Gia, Tỉnh Quảng Ngãi', '6436', 'xa', '36'),
(2477, 'Sơn Tịnh', 'Xã Sơn Tịnh', 'Xã Sơn Tịnh, Tỉnh Quảng Ngãi', '6692', 'xa', '36'),
(2478, 'Thọ Phong', 'Xã Thọ Phong', 'Xã Thọ Phong, Tỉnh Quảng Ngãi', '6948', 'xa', '36'),
(2479, 'Tư Nghĩa', 'Xã Tư Nghĩa', 'Xã Tư Nghĩa, Tỉnh Quảng Ngãi', '7204', 'xa', '36'),
(2480, 'Vệ Giang', 'Xã Vệ Giang', 'Xã Vệ Giang, Tỉnh Quảng Ngãi', '7460', 'xa', '36'),
(2481, 'Nghĩa Giang', 'Xã Nghĩa Giang', 'Xã Nghĩa Giang, Tỉnh Quảng Ngãi', '7716', 'xa', '36'),
(2482, 'Trà Giang', 'Xã Trà Giang', 'Xã Trà Giang, Tỉnh Quảng Ngãi', '7972', 'xa', '36'),
(2483, 'Nghĩa Hành', 'Xã Nghĩa Hành', 'Xã Nghĩa Hành, Tỉnh Quảng Ngãi', '8228', 'xa', '36'),
(2484, 'Đình Cương', 'Xã Đình Cương', 'Xã Đình Cương, Tỉnh Quảng Ngãi', '8484', 'xa', '36'),
(2485, 'Thiện Tín', 'Xã Thiện Tín', 'Xã Thiện Tín, Tỉnh Quảng Ngãi', '8740', 'xa', '36'),
(2486, 'Phước Giang', 'Xã Phước Giang', 'Xã Phước Giang, Tỉnh Quảng Ngãi', '8996', 'xa', '36'),
(2487, 'Long Phụng', 'Xã Long Phụng', 'Xã Long Phụng, Tỉnh Quảng Ngãi', '9252', 'xa', '36'),
(2488, 'Mỏ Cày', 'Xã Mỏ Cày', 'Xã Mỏ Cày, Tỉnh Quảng Ngãi', '9508', 'xa', '36'),
(2489, 'Mộ Đức', 'Xã Mộ Đức', 'Xã Mộ Đức, Tỉnh Quảng Ngãi', '9764', 'xa', '36'),
(2490, 'Lân Phong', 'Xã Lân Phong', 'Xã Lân Phong, Tỉnh Quảng Ngãi', '10020', 'xa', '36'),
(2491, 'Trà Bồng', 'Xã Trà Bồng', 'Xã Trà Bồng, Tỉnh Quảng Ngãi', '10276', 'xa', '36'),
(2492, 'Đông Trà Bồng', 'Xã Đông Trà Bồng', 'Xã Đông Trà Bồng, Tỉnh Quảng Ngãi', '10532', 'xa', '36'),
(2493, 'Tây Trà', 'Xã Tây Trà', 'Xã Tây Trà, Tỉnh Quảng Ngãi', '10788', 'xa', '36'),
(2494, 'Thanh Bồng', 'Xã Thanh Bồng', 'Xã Thanh Bồng, Tỉnh Quảng Ngãi', '11044', 'xa', '36'),
(2495, 'Sơn Hạ', 'Xã Sơn Hạ', 'Xã Sơn Hạ, Tỉnh Quảng Ngãi', '11300', 'xa', '36'),
(2496, 'Sơn Linh', 'Xã Sơn Linh', 'Xã Sơn Linh, Tỉnh Quảng Ngãi', '11556', 'xa', '36'),
(2497, 'Sơn Hà', 'Xã Sơn Hà', 'Xã Sơn Hà, Tỉnh Quảng Ngãi', '11812', 'xa', '36'),
(2498, 'Sơn Thủy', 'Xã Sơn Thủy', 'Xã Sơn Thủy, Tỉnh Quảng Ngãi', '12068', 'xa', '36'),
(2499, 'Sơn Kỳ', 'Xã Sơn Kỳ', 'Xã Sơn Kỳ, Tỉnh Quảng Ngãi', '12324', 'xa', '36'),
(2500, 'Sơn Tây', 'Xã Sơn Tây', 'Xã Sơn Tây, Tỉnh Quảng Ngãi', '12580', 'xa', '36'),
(2501, 'Sơn Tây Thượng', 'Xã Sơn Tây Thượng', 'Xã Sơn Tây Thượng, Tỉnh Quảng Ngãi', '12836', 'xa', '36'),
(2502, 'Sơn Tây Hạ', 'Xã Sơn Tây Hạ', 'Xã Sơn Tây Hạ, Tỉnh Quảng Ngãi', '13092', 'xa', '36'),
(2503, 'Minh Long', 'Xã Minh Long', 'Xã Minh Long, Tỉnh Quảng Ngãi', '13348', 'xa', '36'),
(2504, 'Sơn Mai', 'Xã Sơn Mai', 'Xã Sơn Mai, Tỉnh Quảng Ngãi', '13604', 'xa', '36'),
(2505, 'Ba Vì', 'Xã Ba Vì', 'Xã Ba Vì, Tỉnh Quảng Ngãi', '13860', 'xa', '36'),
(2506, 'Ba Tô', 'Xã Ba Tô', 'Xã Ba Tô, Tỉnh Quảng Ngãi', '14116', 'xa', '36'),
(2507, 'Ba Dinh', 'Xã Ba Dinh', 'Xã Ba Dinh, Tỉnh Quảng Ngãi', '14372', 'xa', '36'),
(2508, 'Ba Tơ', 'Xã Ba Tơ', 'Xã Ba Tơ, Tỉnh Quảng Ngãi', '14628', 'xa', '36'),
(2509, 'Ba Vinh', 'Xã Ba Vinh', 'Xã Ba Vinh, Tỉnh Quảng Ngãi', '14884', 'xa', '36'),
(2510, 'Ba Động', 'Xã Ba Động', 'Xã Ba Động, Tỉnh Quảng Ngãi', '15140', 'xa', '36'),
(2511, 'Đặng Thùy Trâm', 'Xã Đặng Thùy Trâm', 'Xã Đặng Thùy Trâm, Tỉnh Quảng Ngãi', '15396', 'xa', '36'),
(2512, 'Bình Sơn', 'Xã Bình Sơn', 'Xã Bình Sơn, Tỉnh Quảng Ngãi', '15652', 'xa', '36'),
(2513, 'Kon Tum', 'Phường Kon Tum', 'Phường Kon Tum, Tỉnh Quảng Ngãi', '15908', 'phuong', '36'),
(2514, 'Đắk Cấm', 'Phường Đắk Cấm', 'Phường Đắk Cấm, Tỉnh Quảng Ngãi', '16164', 'phuong', '36'),
(2515, 'Đắk Bla', 'Phường Đắk Bla', 'Phường Đắk Bla, Tỉnh Quảng Ngãi', '16420', 'phuong', '36'),
(2516, 'Ngọk Bay', 'Xã Ngọk Bay', 'Xã Ngọk Bay, Tỉnh Quảng Ngãi', '16676', 'xa', '36'),
(2517, 'Ia Chim', 'Xã Ia Chim', 'Xã Ia Chim, Tỉnh Quảng Ngãi', '16932', 'xa', '36'),
(2518, 'Đắk Rơ Wa', 'Xã Đắk Rơ Wa', 'Xã Đắk Rơ Wa, Tỉnh Quảng Ngãi', '17188', 'xa', '36'),
(2519, 'Đắk PXi', 'Xã Đắk PXi', 'Xã Đắk PXi, Tỉnh Quảng Ngãi', '17444', 'xa', '36'),
(2520, 'Đắk Mar', 'Xã Đắk Mar', 'Xã Đắk Mar, Tỉnh Quảng Ngãi', '17700', 'xa', '36'),
(2521, 'Đắk Ui', 'Xã Đắk Ui', 'Xã Đắk Ui, Tỉnh Quảng Ngãi', '17956', 'xa', '36'),
(2522, 'Ngok Réo', 'Xã Ngok Réo', 'Xã Ngok Réo, Tỉnh Quảng Ngãi', '18212', 'xa', '36'),
(2523, 'Đắk Hà', 'Xã Đắk Hà', 'Xã Đắk Hà, Tỉnh Quảng Ngãi', '18468', 'xa', '36'),
(2524, 'Ngọk Tụ', 'Xã Ngọk Tụ', 'Xã Ngọk Tụ, Tỉnh Quảng Ngãi', '18724', 'xa', '36'),
(2525, 'Đắk Tô', 'Xã Đắk Tô', 'Xã Đắk Tô, Tỉnh Quảng Ngãi', '18980', 'xa', '36'),
(2526, 'Kon Đào', 'Xã Kon Đào', 'Xã Kon Đào, Tỉnh Quảng Ngãi', '19236', 'xa', '36'),
(2527, 'Đắk Sao', 'Xã Đắk Sao', 'Xã Đắk Sao, Tỉnh Quảng Ngãi', '19492', 'xa', '36'),
(2528, 'Đắk Tờ Kan', 'Xã Đắk Tờ Kan', 'Xã Đắk Tờ Kan, Tỉnh Quảng Ngãi', '19748', 'xa', '36'),
(2529, 'Tu Mơ Rông', 'Xã Tu Mơ Rông', 'Xã Tu Mơ Rông, Tỉnh Quảng Ngãi', '20004', 'xa', '36'),
(2530, 'Măng Ri', 'Xã Măng Ri', 'Xã Măng Ri, Tỉnh Quảng Ngãi', '20260', 'xa', '36'),
(2531, 'Bờ Y', 'Xã Bờ Y', 'Xã Bờ Y, Tỉnh Quảng Ngãi', '20516', 'xa', '36'),
(2532, 'Sa Loong', 'Xã Sa Loong', 'Xã Sa Loong, Tỉnh Quảng Ngãi', '20772', 'xa', '36'),
(2533, 'Dục Nông', 'Xã Dục Nông', 'Xã Dục Nông, Tỉnh Quảng Ngãi', '21028', 'xa', '36'),
(2534, 'Xốp', 'Xã Xốp', 'Xã Xốp, Tỉnh Quảng Ngãi', '21284', 'xa', '36'),
(2535, 'Ngọc Linh', 'Xã Ngọc Linh', 'Xã Ngọc Linh, Tỉnh Quảng Ngãi', '21540', 'xa', '36'),
(2536, 'Đắk Blô', 'Xã Đắk Blô', 'Xã Đắk Blô, Tỉnh Quảng Ngãi', '21796', 'xa', '36'),
(2537, 'Đắk Pék', 'Xã Đắk Pék', 'Xã Đắk Pék, Tỉnh Quảng Ngãi', '22052', 'xa', '36'),
(2538, 'Đắk Môn', 'Xã Đắk Môn', 'Xã Đắk Môn, Tỉnh Quảng Ngãi', '22308', 'xa', '36'),
(2539, 'Sa Thầy', 'Xã Sa Thầy', 'Xã Sa Thầy, Tỉnh Quảng Ngãi', '22564', 'xa', '36'),
(2540, 'Sa Bình', 'Xã Sa Bình', 'Xã Sa Bình, Tỉnh Quảng Ngãi', '22820', 'xa', '36'),
(2541, 'Ya Ly', 'Xã Ya Ly', 'Xã Ya Ly, Tỉnh Quảng Ngãi', '23076', 'xa', '36'),
(2542, 'Đắk Kôi', 'Xã Đắk Kôi', 'Xã Đắk Kôi, Tỉnh Quảng Ngãi', '23332', 'xa', '36'),
(2543, 'Kon Braih', 'Xã Kon Braih', 'Xã Kon Braih, Tỉnh Quảng Ngãi', '23588', 'xa', '36'),
(2544, 'Đắk Rve', 'Xã Đắk Rve', 'Xã Đắk Rve, Tỉnh Quảng Ngãi', '23844', 'xa', '36'),
(2545, 'Măng Đen', 'Xã Măng Đen', 'Xã Măng Đen, Tỉnh Quảng Ngãi', '24100', 'xa', '36'),
(2546, 'Măng Buk', 'Xã Măng Buk', 'Xã Măng Buk, Tỉnh Quảng Ngãi', '24356', 'xa', '36'),
(2547, 'Kon Plông', 'Xã Kon Plông', 'Xã Kon Plông, Tỉnh Quảng Ngãi', '24612', 'xa', '36'),
(2548, 'Vàng Danh', 'Phường Vàng Danh', 'Phường Vàng Danh, Tỉnh Quảng Ninh', '293', 'phuong', '37'),
(2549, 'Đường Hoa', 'Xã Đường Hoa', 'Xã Đường Hoa, Tỉnh Quảng Ninh', '549', 'xa', '37'),
(2550, 'Hoành Bồ', 'Phường Hoành Bồ', 'Phường Hoành Bồ, Tỉnh Quảng Ninh', '805', 'phuong', '37'),
(2551, 'Thống Nhất', 'Xã Thống Nhất', 'Xã Thống Nhất, Tỉnh Quảng Ninh', '1061', 'xa', '37'),
(2552, 'Đông Ngũ', 'Xã Đông Ngũ', 'Xã Đông Ngũ, Tỉnh Quảng Ninh', '1317', 'xa', '37'),
(2553, 'Hải Lạng', 'Xã Hải Lạng', 'Xã Hải Lạng, Tỉnh Quảng Ninh', '1573', 'xa', '37'),
(2554, 'Hải Hòa', 'Xã Hải Hòa', 'Xã Hải Hòa, Tỉnh Quảng Ninh', '1829', 'xa', '37'),
(2555, 'Hà An', 'Phường Hà An', 'Phường Hà An, Tỉnh Quảng Ninh', '2085', 'phuong', '37'),
(2556, 'Liên Hòa', 'Phường Liên Hòa', 'Phường Liên Hòa, Tỉnh Quảng Ninh', '2341', 'phuong', '37'),
(2557, 'Quang Hanh', 'Phường Quang Hanh', 'Phường Quang Hanh, Tỉnh Quảng Ninh', '2597', 'phuong', '37'),
(2558, 'Tuần Châu', 'Phường Tuần Châu', 'Phường Tuần Châu, Tỉnh Quảng Ninh', '2853', 'phuong', '37'),
(2559, 'Hà Tu', 'Phường Hà Tu', 'Phường Hà Tu, Tỉnh Quảng Ninh', '3109', 'phuong', '37'),
(2560, 'An Sinh', 'Phường An Sinh', 'Phường An Sinh, Tỉnh Quảng Ninh', '3365', 'phuong', '37'),
(2561, 'Vĩnh Thực', 'Xã Vĩnh Thực', 'Xã Vĩnh Thực, Tỉnh Quảng Ninh', '3621', 'xa', '37'),
(2562, 'Quảng Hà', 'Xã Quảng Hà', 'Xã Quảng Hà, Tỉnh Quảng Ninh', '3877', 'xa', '37'),
(2563, 'Cái Chiên', 'Xã Cái Chiên', 'Xã Cái Chiên, Tỉnh Quảng Ninh', '4133', 'xa', '37'),
(2564, 'Điền Xá', 'Xã Điền Xá', 'Xã Điền Xá, Tỉnh Quảng Ninh', '4389', 'xa', '37'),
(2565, 'Việt Hưng', 'Phường Việt Hưng', 'Phường Việt Hưng, Tỉnh Quảng Ninh', '4645', 'phuong', '37'),
(2566, 'Bình Khê', 'Phường Bình Khê', 'Phường Bình Khê, Tỉnh Quảng Ninh', '4901', 'phuong', '37'),
(2567, 'Mạo Khê', 'Phường Mạo Khê', 'Phường Mạo Khê, Tỉnh Quảng Ninh', '5157', 'phuong', '37'),
(2568, 'Hoàng Quế', 'Phường Hoàng Quế', 'Phường Hoàng Quế, Tỉnh Quảng Ninh', '5413', 'phuong', '37'),
(2569, 'Yên Tử', 'Phường Yên Tử', 'Phường Yên Tử, Tỉnh Quảng Ninh', '5669', 'phuong', '37'),
(2570, 'Đông Mai', 'Phường Đông Mai', 'Phường Đông Mai, Tỉnh Quảng Ninh', '5925', 'phuong', '37'),
(2571, 'Hiệp Hòa', 'Phường Hiệp Hòa', 'Phường Hiệp Hòa, Tỉnh Quảng Ninh', '6181', 'phuong', '37'),
(2572, 'Quảng Yên', 'Phường Quảng Yên', 'Phường Quảng Yên, Tỉnh Quảng Ninh', '6437', 'phuong', '37'),
(2573, 'Phong Cốc', 'Phường Phong Cốc', 'Phường Phong Cốc, Tỉnh Quảng Ninh', '6693', 'phuong', '37'),
(2574, 'Bãi Cháy', 'Phường Bãi Cháy', 'Phường Bãi Cháy, Tỉnh Quảng Ninh', '6949', 'phuong', '37'),
(2575, 'Hà Lầm', 'Phường Hà Lầm', 'Phường Hà Lầm, Tỉnh Quảng Ninh', '7205', 'phuong', '37'),
(2576, 'Cao Xanh', 'Phường Cao Xanh', 'Phường Cao Xanh, Tỉnh Quảng Ninh', '7461', 'phuong', '37'),
(2577, 'Hồng Gai', 'Phường Hồng Gai', 'Phường Hồng Gai, Tỉnh Quảng Ninh', '7717', 'phuong', '37'),
(2578, 'Hạ Long', 'Phường Hạ Long', 'Phường Hạ Long, Tỉnh Quảng Ninh', '7973', 'phuong', '37'),
(2579, 'Quảng La', 'Xã Quảng La', 'Xã Quảng La, Tỉnh Quảng Ninh', '8229', 'xa', '37'),
(2580, 'Mông Dương', 'Phường Mông Dương', 'Phường Mông Dương, Tỉnh Quảng Ninh', '8485', 'phuong', '37'),
(2581, 'Cẩm Phả', 'Phường Cẩm Phả', 'Phường Cẩm Phả, Tỉnh Quảng Ninh', '8741', 'phuong', '37'),
(2582, 'Cửa Ông', 'Phường Cửa Ông', 'Phường Cửa Ông, Tỉnh Quảng Ninh', '8997', 'phuong', '37'),
(2583, 'Lương Minh', 'Xã Lương Minh', 'Xã Lương Minh, Tỉnh Quảng Ninh', '9253', 'xa', '37'),
(2584, 'Kỳ Thượng', 'Xã Kỳ Thượng', 'Xã Kỳ Thượng, Tỉnh Quảng Ninh', '9509', 'xa', '37'),
(2585, 'Quảng Tân', 'Xã Quảng Tân', 'Xã Quảng Tân, Tỉnh Quảng Ninh', '9765', 'xa', '37'),
(2586, 'Quảng Đức', 'Xã Quảng Đức', 'Xã Quảng Đức, Tỉnh Quảng Ninh', '10021', 'xa', '37'),
(2587, 'Hoành Mô', 'Xã Hoành Mô', 'Xã Hoành Mô, Tỉnh Quảng Ninh', '10277', 'xa', '37'),
(2588, 'Lục Hồn', 'Xã Lục Hồn', 'Xã Lục Hồn, Tỉnh Quảng Ninh', '10533', 'xa', '37'),
(2589, 'Hải Sơn', 'Xã Hải Sơn', 'Xã Hải Sơn, Tỉnh Quảng Ninh', '10789', 'xa', '37'),
(2590, 'Hải Ninh', 'Xã Hải Ninh', 'Xã Hải Ninh, Tỉnh Quảng Ninh', '11045', 'xa', '37'),
(2591, 'Móng Cái 1', 'Phường Móng Cái 1', 'Phường Móng Cái 1, Tỉnh Quảng Ninh', '11301', 'phuong', '37'),
(2592, 'Móng Cái 2', 'Phường Móng Cái 2', 'Phường Móng Cái 2, Tỉnh Quảng Ninh', '11557', 'phuong', '37'),
(2593, 'Móng Cái 3', 'Phường Móng Cái 3', 'Phường Móng Cái 3, Tỉnh Quảng Ninh', '11813', 'phuong', '37'),
(2594, 'Đầm Hà', 'Xã Đầm Hà', 'Xã Đầm Hà, Tỉnh Quảng Ninh', '12069', 'xa', '37'),
(2595, 'Đặc Khu Vân Đồn', 'Xã Đặc Khu Vân Đồn', 'Xã Đặc Khu Vân Đồn, Tỉnh Quảng Ninh', '12325', 'xa', '37'),
(2596, 'Đặc Khu Cô Tô', 'Xã Đặc Khu Cô Tô', 'Xã Đặc Khu Cô Tô, Tỉnh Quảng Ninh', '12581', 'xa', '37'),
(2597, 'Đông Triều', 'Phường Đông Triều', 'Phường Đông Triều, Tỉnh Quảng Ninh', '12837', 'phuong', '37'),
(2598, 'Uông Bí', 'Phường Uông Bí', 'Phường Uông Bí, Tỉnh Quảng Ninh', '13093', 'phuong', '37'),
(2599, 'Tiên Yên', 'Xã Tiên Yên', 'Xã Tiên Yên, Tỉnh Quảng Ninh', '13349', 'xa', '37'),
(2600, 'Ba Chẽ', 'Xã Ba Chẽ', 'Xã Ba Chẽ, Tỉnh Quảng Ninh', '13605', 'xa', '37'),
(2601, 'Bình Liêu', 'Xã Bình Liêu', 'Xã Bình Liêu, Tỉnh Quảng Ninh', '13861', 'xa', '37'),
(2602, 'Phú Trạch', 'Xã Phú Trạch', 'Xã Phú Trạch, Tỉnh Quảng Trị', '294', 'xa', '38'),
(2603, 'Đặc Khu Cồn Cỏ', 'Xã Đặc Khu Cồn Cỏ', 'Xã Đặc Khu Cồn Cỏ, Tỉnh Quảng Trị', '550', 'xa', '38'),
(2604, 'Tân Thành', 'Xã Tân Thành', 'Xã Tân Thành, Tỉnh Quảng Trị', '806', 'xa', '38'),
(2605, 'Đồng Hới', 'Phường Đồng Hới', 'Phường Đồng Hới, Tỉnh Quảng Trị', '1062', 'phuong', '38'),
(2606, 'Đồng Thuận', 'Phường Đồng Thuận', 'Phường Đồng Thuận, Tỉnh Quảng Trị', '1318', 'phuong', '38'),
(2607, 'Đồng Sơn', 'Phường Đồng Sơn', 'Phường Đồng Sơn, Tỉnh Quảng Trị', '1574', 'phuong', '38'),
(2608, 'Ba Đồn', 'Phường Ba Đồn', 'Phường Ba Đồn, Tỉnh Quảng Trị', '1830', 'phuong', '38'),
(2609, 'Bắc Gianh', 'Phường Bắc Gianh', 'Phường Bắc Gianh, Tỉnh Quảng Trị', '2086', 'phuong', '38'),
(2610, 'Nam Gianh', 'Xã Nam Gianh', 'Xã Nam Gianh, Tỉnh Quảng Trị', '2342', 'xa', '38'),
(2611, 'Nam Ba Đồn', 'Xã Nam Ba Đồn', 'Xã Nam Ba Đồn, Tỉnh Quảng Trị', '2598', 'xa', '38'),
(2612, 'Dân Hóa', 'Xã Dân Hóa', 'Xã Dân Hóa, Tỉnh Quảng Trị', '2854', 'xa', '38'),
(2613, 'Kim Điền', 'Xã Kim Điền', 'Xã Kim Điền, Tỉnh Quảng Trị', '3110', 'xa', '38'),
(2614, 'Kim Phú', 'Xã Kim Phú', 'Xã Kim Phú, Tỉnh Quảng Trị', '3366', 'xa', '38'),
(2615, 'Minh Hóa', 'Xã Minh Hóa', 'Xã Minh Hóa, Tỉnh Quảng Trị', '3622', 'xa', '38'),
(2616, 'Tuyên Lâm', 'Xã Tuyên Lâm', 'Xã Tuyên Lâm, Tỉnh Quảng Trị', '3878', 'xa', '38'),
(2617, 'Tuyên Sơn', 'Xã Tuyên Sơn', 'Xã Tuyên Sơn, Tỉnh Quảng Trị', '4134', 'xa', '38'),
(2618, 'Đồng Lê', 'Xã Đồng Lê', 'Xã Đồng Lê, Tỉnh Quảng Trị', '4390', 'xa', '38'),
(2619, 'Tuyên Phú', 'Xã Tuyên Phú', 'Xã Tuyên Phú, Tỉnh Quảng Trị', '4646', 'xa', '38'),
(2620, 'Tuyên Bình', 'Xã Tuyên Bình', 'Xã Tuyên Bình, Tỉnh Quảng Trị', '4902', 'xa', '38'),
(2621, 'Tuyên Hóa', 'Xã Tuyên Hóa', 'Xã Tuyên Hóa, Tỉnh Quảng Trị', '5158', 'xa', '38'),
(2622, 'Tân Gianh', 'Xã Tân Gianh', 'Xã Tân Gianh, Tỉnh Quảng Trị', '5414', 'xa', '38'),
(2623, 'Trung Thuần', 'Xã Trung Thuần', 'Xã Trung Thuần, Tỉnh Quảng Trị', '5670', 'xa', '38'),
(2624, 'Quảng Trạch', 'Xã Quảng Trạch', 'Xã Quảng Trạch, Tỉnh Quảng Trị', '5926', 'xa', '38'),
(2625, 'Hòa Trạch', 'Xã Hòa Trạch', 'Xã Hòa Trạch, Tỉnh Quảng Trị', '6182', 'xa', '38'),
(2626, 'Thượng Trạch', 'Xã Thượng Trạch', 'Xã Thượng Trạch, Tỉnh Quảng Trị', '6438', 'xa', '38'),
(2627, 'Phong Nha', 'Xã Phong Nha', 'Xã Phong Nha, Tỉnh Quảng Trị', '6694', 'xa', '38'),
(2628, 'Bắc Trạch', 'Xã Bắc Trạch', 'Xã Bắc Trạch, Tỉnh Quảng Trị', '6950', 'xa', '38'),
(2629, 'Đông Trạch', 'Xã Đông Trạch', 'Xã Đông Trạch, Tỉnh Quảng Trị', '7206', 'xa', '38'),
(2630, 'Hoàn Lão', 'Xã Hoàn Lão', 'Xã Hoàn Lão, Tỉnh Quảng Trị', '7462', 'xa', '38'),
(2631, 'Bố Trạch', 'Xã Bố Trạch', 'Xã Bố Trạch, Tỉnh Quảng Trị', '7718', 'xa', '38'),
(2632, 'Nam Trạch', 'Xã Nam Trạch', 'Xã Nam Trạch, Tỉnh Quảng Trị', '7974', 'xa', '38'),
(2633, 'Quảng Ninh', 'Xã Quảng Ninh', 'Xã Quảng Ninh, Tỉnh Quảng Trị', '8230', 'xa', '38'),
(2634, 'Ninh Châu', 'Xã Ninh Châu', 'Xã Ninh Châu, Tỉnh Quảng Trị', '8486', 'xa', '38'),
(2635, 'Trường Ninh', 'Xã Trường Ninh', 'Xã Trường Ninh, Tỉnh Quảng Trị', '8742', 'xa', '38'),
(2636, 'Trường Sơn', 'Xã Trường Sơn', 'Xã Trường Sơn, Tỉnh Quảng Trị', '8998', 'xa', '38'),
(2637, 'Lệ Thủy', 'Xã Lệ Thủy', 'Xã Lệ Thủy, Tỉnh Quảng Trị', '9254', 'xa', '38'),
(2638, 'Cam Hồng', 'Xã Cam Hồng', 'Xã Cam Hồng, Tỉnh Quảng Trị', '9510', 'xa', '38'),
(2639, 'Sen Ngư', 'Xã Sen Ngư', 'Xã Sen Ngư, Tỉnh Quảng Trị', '9766', 'xa', '38'),
(2640, 'Tân Mỹ', 'Xã Tân Mỹ', 'Xã Tân Mỹ, Tỉnh Quảng Trị', '10022', 'xa', '38'),
(2641, 'Trường Phú', 'Xã Trường Phú', 'Xã Trường Phú, Tỉnh Quảng Trị', '10278', 'xa', '38'),
(2642, 'Lệ Ninh', 'Xã Lệ Ninh', 'Xã Lệ Ninh, Tỉnh Quảng Trị', '10534', 'xa', '38'),
(2643, 'Kim Ngân', 'Xã Kim Ngân', 'Xã Kim Ngân, Tỉnh Quảng Trị', '10790', 'xa', '38'),
(2644, 'Vĩnh Linh', 'Xã Vĩnh Linh', 'Xã Vĩnh Linh, Tỉnh Quảng Trị', '11046', 'xa', '38'),
(2645, 'Cửa Tùng', 'Xã Cửa Tùng', 'Xã Cửa Tùng, Tỉnh Quảng Trị', '11302', 'xa', '38'),
(2646, 'Vĩnh Hoàng', 'Xã Vĩnh Hoàng', 'Xã Vĩnh Hoàng, Tỉnh Quảng Trị', '11558', 'xa', '38'),
(2647, 'Vĩnh Thủy', 'Xã Vĩnh Thủy', 'Xã Vĩnh Thủy, Tỉnh Quảng Trị', '11814', 'xa', '38'),
(2648, 'Bến Quan', 'Xã Bến Quan', 'Xã Bến Quan, Tỉnh Quảng Trị', '12070', 'xa', '38'),
(2649, 'Cồn Tiên', 'Xã Cồn Tiên', 'Xã Cồn Tiên, Tỉnh Quảng Trị', '12326', 'xa', '38'),
(2650, 'Cửa Việt', 'Xã Cửa Việt', 'Xã Cửa Việt, Tỉnh Quảng Trị', '12582', 'xa', '38'),
(2651, 'Gio Linh', 'Xã Gio Linh', 'Xã Gio Linh, Tỉnh Quảng Trị', '12838', 'xa', '38'),
(2652, 'Bến Hải', 'Xã Bến Hải', 'Xã Bến Hải, Tỉnh Quảng Trị', '13094', 'xa', '38'),
(2653, 'Cam Lộ', 'Xã Cam Lộ', 'Xã Cam Lộ, Tỉnh Quảng Trị', '13350', 'xa', '38'),
(2654, 'Hiếu Giang', 'Xã Hiếu Giang', 'Xã Hiếu Giang, Tỉnh Quảng Trị', '13606', 'xa', '38'),
(2655, 'La Lay', 'Xã La Lay', 'Xã La Lay, Tỉnh Quảng Trị', '13862', 'xa', '38'),
(2656, 'Tà Rụt', 'Xã Tà Rụt', 'Xã Tà Rụt, Tỉnh Quảng Trị', '14118', 'xa', '38'),
(2657, 'Đakrông', 'Xã Đakrông', 'Xã Đakrông, Tỉnh Quảng Trị', '14374', 'xa', '38'),
(2658, 'Ba Lòng', 'Xã Ba Lòng', 'Xã Ba Lòng, Tỉnh Quảng Trị', '14630', 'xa', '38'),
(2659, 'Hướng Hiệp', 'Xã Hướng Hiệp', 'Xã Hướng Hiệp, Tỉnh Quảng Trị', '14886', 'xa', '38'),
(2660, 'Hướng Lập', 'Xã Hướng Lập', 'Xã Hướng Lập, Tỉnh Quảng Trị', '15142', 'xa', '38'),
(2661, 'Hướng Phùng', 'Xã Hướng Phùng', 'Xã Hướng Phùng, Tỉnh Quảng Trị', '15398', 'xa', '38'),
(2662, 'Khe Sanh', 'Xã Khe Sanh', 'Xã Khe Sanh, Tỉnh Quảng Trị', '15654', 'xa', '38'),
(2663, 'Tân Lập', 'Xã Tân Lập', 'Xã Tân Lập, Tỉnh Quảng Trị', '15910', 'xa', '38'),
(2664, 'Lao Bảo', 'Xã Lao Bảo', 'Xã Lao Bảo, Tỉnh Quảng Trị', '16166', 'xa', '38'),
(2665, 'Lìa', 'Xã Lìa', 'Xã Lìa, Tỉnh Quảng Trị', '16422', 'xa', '38'),
(2666, 'A Dơi', 'Xã A Dơi', 'Xã A Dơi, Tỉnh Quảng Trị', '16678', 'xa', '38'),
(2667, 'Đông Hà', 'Phường Đông Hà', 'Phường Đông Hà, Tỉnh Quảng Trị', '16934', 'phuong', '38'),
(2668, 'Nam Đông Hà', 'Phường Nam Đông Hà', 'Phường Nam Đông Hà, Tỉnh Quảng Trị', '17190', 'phuong', '38'),
(2669, 'Triệu Phong', 'Xã Triệu Phong', 'Xã Triệu Phong, Tỉnh Quảng Trị', '17446', 'xa', '38'),
(2670, 'Ái Tử', 'Xã Ái Tử', 'Xã Ái Tử, Tỉnh Quảng Trị', '17702', 'xa', '38'),
(2671, 'Triệu Bình', 'Xã Triệu Bình', 'Xã Triệu Bình, Tỉnh Quảng Trị', '17958', 'xa', '38'),
(2672, 'Triệu Cơ', 'Xã Triệu Cơ', 'Xã Triệu Cơ, Tỉnh Quảng Trị', '18214', 'xa', '38'),
(2673, 'Nam Cửa Việt', 'Xã Nam Cửa Việt', 'Xã Nam Cửa Việt, Tỉnh Quảng Trị', '18470', 'xa', '38'),
(2674, 'Quảng Trị', 'Phường Quảng Trị', 'Phường Quảng Trị, Tỉnh Quảng Trị', '18726', 'phuong', '38'),
(2675, 'Diên Sanh', 'Xã Diên Sanh', 'Xã Diên Sanh, Tỉnh Quảng Trị', '18982', 'xa', '38'),
(2676, 'Mỹ Thủy', 'Xã Mỹ Thủy', 'Xã Mỹ Thủy, Tỉnh Quảng Trị', '19238', 'xa', '38'),
(2677, 'Hải Lăng', 'Xã Hải Lăng', 'Xã Hải Lăng, Tỉnh Quảng Trị', '19494', 'xa', '38'),
(2678, 'Nam Hải Lăng', 'Xã Nam Hải Lăng', 'Xã Nam Hải Lăng, Tỉnh Quảng Trị', '19750', 'xa', '38'),
(2679, 'Vĩnh Định', 'Xã Vĩnh Định', 'Xã Vĩnh Định, Tỉnh Quảng Trị', '20006', 'xa', '38'),
(2680, 'Mường Bám', 'Xã Mường Bám', 'Xã Mường Bám, Tỉnh Sơn La', '295', 'xa', '39'),
(2681, 'Phiêng Khoài', 'Xã Phiêng Khoài', 'Xã Phiêng Khoài, Tỉnh Sơn La', '551', 'xa', '39'),
(2682, 'Chiềng Cơi', 'Phường Chiềng Cơi', 'Phường Chiềng Cơi, Tỉnh Sơn La', '807', 'phuong', '39'),
(2683, 'Suối Tọ', 'Xã Suối Tọ', 'Xã Suối Tọ, Tỉnh Sơn La', '1063', 'xa', '39'),
(2684, 'Mường Lạn', 'Xã Mường Lạn', 'Xã Mường Lạn, Tỉnh Sơn La', '1319', 'xa', '39'),
(2685, 'Tân Yên', 'Xã Tân Yên', 'Xã Tân Yên, Tỉnh Sơn La', '1575', 'xa', '39'),
(2686, 'Ngọc Chiến', 'Xã Ngọc Chiến', 'Xã Ngọc Chiến, Tỉnh Sơn La', '1831', 'xa', '39'),
(2687, 'Mường Lèo', 'Xã Mường Lèo', 'Xã Mường Lèo, Tỉnh Sơn La', '2087', 'xa', '39'),
(2688, 'Tô Hiệu', 'Phường Tô Hiệu', 'Phường Tô Hiệu, Tỉnh Sơn La', '2343', 'phuong', '39'),
(2689, 'Chiềng An', 'Phường Chiềng An', 'Phường Chiềng An, Tỉnh Sơn La', '2599', 'phuong', '39'),
(2690, 'Chiềng Sinh', 'Phường Chiềng Sinh', 'Phường Chiềng Sinh, Tỉnh Sơn La', '2855', 'phuong', '39'),
(2691, 'Mộc Sơn', 'Phường Mộc Sơn', 'Phường Mộc Sơn, Tỉnh Sơn La', '3111', 'phuong', '39'),
(2692, 'Vân Sơn', 'Phường Vân Sơn', 'Phường Vân Sơn, Tỉnh Sơn La', '3367', 'phuong', '39'),
(2693, 'Thảo Nguyên', 'Phường Thảo Nguyên', 'Phường Thảo Nguyên, Tỉnh Sơn La', '3623', 'phuong', '39'),
(2694, 'Đoàn Kết', 'Xã Đoàn Kết', 'Xã Đoàn Kết, Tỉnh Sơn La', '3879', 'xa', '39'),
(2695, 'Lóng Sập', 'Xã Lóng Sập', 'Xã Lóng Sập, Tỉnh Sơn La', '4135', 'xa', '39'),
(2696, 'Chiềng Sơn', 'Xã Chiềng Sơn', 'Xã Chiềng Sơn, Tỉnh Sơn La', '4391', 'xa', '39'),
(2697, 'Vân Hồ', 'Xã Vân Hồ', 'Xã Vân Hồ, Tỉnh Sơn La', '4647', 'xa', '39'),
(2698, 'Song Khủa', 'Xã Song Khủa', 'Xã Song Khủa, Tỉnh Sơn La', '4903', 'xa', '39'),
(2699, 'Tô Múa', 'Xã Tô Múa', 'Xã Tô Múa, Tỉnh Sơn La', '5159', 'xa', '39'),
(2700, 'Xuân Nha', 'Xã Xuân Nha', 'Xã Xuân Nha, Tỉnh Sơn La', '5415', 'xa', '39'),
(2701, 'Quỳnh Nhai', 'Xã Quỳnh Nhai', 'Xã Quỳnh Nhai, Tỉnh Sơn La', '5671', 'xa', '39'),
(2702, 'Mường Chiên', 'Xã Mường Chiên', 'Xã Mường Chiên, Tỉnh Sơn La', '5927', 'xa', '39'),
(2703, 'Mường Giôn', 'Xã Mường Giôn', 'Xã Mường Giôn, Tỉnh Sơn La', '6183', 'xa', '39'),
(2704, 'Mường Sại', 'Xã Mường Sại', 'Xã Mường Sại, Tỉnh Sơn La', '6439', 'xa', '39'),
(2705, 'Thuận Châu', 'Xã Thuận Châu', 'Xã Thuận Châu, Tỉnh Sơn La', '6695', 'xa', '39'),
(2706, 'Chiềng La', 'Xã Chiềng La', 'Xã Chiềng La, Tỉnh Sơn La', '6951', 'xa', '39'),
(2707, 'Nậm Lầu', 'Xã Nậm Lầu', 'Xã Nậm Lầu, Tỉnh Sơn La', '7207', 'xa', '39'),
(2708, 'Muổi Nọi', 'Xã Muổi Nọi', 'Xã Muổi Nọi, Tỉnh Sơn La', '7463', 'xa', '39'),
(2709, 'Mường Khiêng', 'Xã Mường Khiêng', 'Xã Mường Khiêng, Tỉnh Sơn La', '7719', 'xa', '39'),
(2710, 'Co Mạ', 'Xã Co Mạ', 'Xã Co Mạ, Tỉnh Sơn La', '7975', 'xa', '39'),
(2711, 'Bình Thuận', 'Xã Bình Thuận', 'Xã Bình Thuận, Tỉnh Sơn La', '8231', 'xa', '39'),
(2712, 'Mường É', 'Xã Mường É', 'Xã Mường É, Tỉnh Sơn La', '8487', 'xa', '39'),
(2713, 'Long Hẹ', 'Xã Long Hẹ', 'Xã Long Hẹ, Tỉnh Sơn La', '8743', 'xa', '39'),
(2714, 'Mường La', 'Xã Mường La', 'Xã Mường La, Tỉnh Sơn La', '8999', 'xa', '39'),
(2715, 'Chiềng Lao', 'Xã Chiềng Lao', 'Xã Chiềng Lao, Tỉnh Sơn La', '9255', 'xa', '39'),
(2716, 'Mường Bú', 'Xã Mường Bú', 'Xã Mường Bú, Tỉnh Sơn La', '9511', 'xa', '39'),
(2717, 'Chiềng Hoa', 'Xã Chiềng Hoa', 'Xã Chiềng Hoa, Tỉnh Sơn La', '9767', 'xa', '39'),
(2718, 'Bắc Yên', 'Xã Bắc Yên', 'Xã Bắc Yên, Tỉnh Sơn La', '10023', 'xa', '39'),
(2719, 'Tà Xùa', 'Xã Tà Xùa', 'Xã Tà Xùa, Tỉnh Sơn La', '10279', 'xa', '39'),
(2720, 'Tạ Khoa', 'Xã Tạ Khoa', 'Xã Tạ Khoa, Tỉnh Sơn La', '10535', 'xa', '39'),
(2721, 'Xím Vàng', 'Xã Xím Vàng', 'Xã Xím Vàng, Tỉnh Sơn La', '10791', 'xa', '39'),
(2722, 'Pắc Ngà', 'Xã Pắc Ngà', 'Xã Pắc Ngà, Tỉnh Sơn La', '11047', 'xa', '39'),
(2723, 'Chiềng Sại', 'Xã Chiềng Sại', 'Xã Chiềng Sại, Tỉnh Sơn La', '11303', 'xa', '39'),
(2724, 'Phù Yên', 'Xã Phù Yên', 'Xã Phù Yên, Tỉnh Sơn La', '11559', 'xa', '39'),
(2725, 'Gia Phù', 'Xã Gia Phù', 'Xã Gia Phù, Tỉnh Sơn La', '11815', 'xa', '39'),
(2726, 'Tường Hạ', 'Xã Tường Hạ', 'Xã Tường Hạ, Tỉnh Sơn La', '12071', 'xa', '39'),
(2727, 'Mường Cơi', 'Xã Mường Cơi', 'Xã Mường Cơi, Tỉnh Sơn La', '12327', 'xa', '39'),
(2728, 'Mường Bang', 'Xã Mường Bang', 'Xã Mường Bang, Tỉnh Sơn La', '12583', 'xa', '39'),
(2729, 'Tân Phong', 'Xã Tân Phong', 'Xã Tân Phong, Tỉnh Sơn La', '12839', 'xa', '39'),
(2730, 'Kim Bon', 'Xã Kim Bon', 'Xã Kim Bon, Tỉnh Sơn La', '13095', 'xa', '39'),
(2731, 'Yên Châu', 'Xã Yên Châu', 'Xã Yên Châu, Tỉnh Sơn La', '13351', 'xa', '39'),
(2732, 'Chiềng Hặc', 'Xã Chiềng Hặc', 'Xã Chiềng Hặc, Tỉnh Sơn La', '13607', 'xa', '39'),
(2733, 'Lóng Phiêng', 'Xã Lóng Phiêng', 'Xã Lóng Phiêng, Tỉnh Sơn La', '13863', 'xa', '39'),
(2734, 'Yên Sơn', 'Xã Yên Sơn', 'Xã Yên Sơn, Tỉnh Sơn La', '14119', 'xa', '39'),
(2735, 'Chiềng Mai', 'Xã Chiềng Mai', 'Xã Chiềng Mai, Tỉnh Sơn La', '14375', 'xa', '39'),
(2736, 'Mai Sơn', 'Xã Mai Sơn', 'Xã Mai Sơn, Tỉnh Sơn La', '14631', 'xa', '39'),
(2737, 'Phiêng Pằn', 'Xã Phiêng Pằn', 'Xã Phiêng Pằn, Tỉnh Sơn La', '14887', 'xa', '39'),
(2738, 'Chiềng Mung', 'Xã Chiềng Mung', 'Xã Chiềng Mung, Tỉnh Sơn La', '15143', 'xa', '39'),
(2739, 'Phiêng Cằm', 'Xã Phiêng Cằm', 'Xã Phiêng Cằm, Tỉnh Sơn La', '15399', 'xa', '39'),
(2740, 'Mường Chanh', 'Xã Mường Chanh', 'Xã Mường Chanh, Tỉnh Sơn La', '15655', 'xa', '39'),
(2741, 'Tà Hộc', 'Xã Tà Hộc', 'Xã Tà Hộc, Tỉnh Sơn La', '15911', 'xa', '39'),
(2742, 'Chiềng Sung', 'Xã Chiềng Sung', 'Xã Chiềng Sung, Tỉnh Sơn La', '16167', 'xa', '39'),
(2743, 'Bó Sinh', 'Xã Bó Sinh', 'Xã Bó Sinh, Tỉnh Sơn La', '16423', 'xa', '39'),
(2744, 'Chiềng Khương', 'Xã Chiềng Khương', 'Xã Chiềng Khương, Tỉnh Sơn La', '16679', 'xa', '39'),
(2745, 'Mường Hung', 'Xã Mường Hung', 'Xã Mường Hung, Tỉnh Sơn La', '16935', 'xa', '39'),
(2746, 'Chiềng Khoong', 'Xã Chiềng Khoong', 'Xã Chiềng Khoong, Tỉnh Sơn La', '17191', 'xa', '39'),
(2747, 'Mường Lầm', 'Xã Mường Lầm', 'Xã Mường Lầm, Tỉnh Sơn La', '17447', 'xa', '39'),
(2748, 'Nậm Ty', 'Xã Nậm Ty', 'Xã Nậm Ty, Tỉnh Sơn La', '17703', 'xa', '39'),
(2749, 'Sông Mã', 'Xã Sông Mã', 'Xã Sông Mã, Tỉnh Sơn La', '17959', 'xa', '39'),
(2750, 'Huổi Một', 'Xã Huổi Một', 'Xã Huổi Một, Tỉnh Sơn La', '18215', 'xa', '39'),
(2751, 'Chiềng Sơ', 'Xã Chiềng Sơ', 'Xã Chiềng Sơ, Tỉnh Sơn La', '18471', 'xa', '39'),
(2752, 'Sốp Cộp', 'Xã Sốp Cộp', 'Xã Sốp Cộp, Tỉnh Sơn La', '18727', 'xa', '39'),
(2753, 'Púng Bánh', 'Xã Púng Bánh', 'Xã Púng Bánh, Tỉnh Sơn La', '18983', 'xa', '39'),
(2754, 'Mộc Châu', 'Phường Mộc Châu', 'Phường Mộc Châu, Tỉnh Sơn La', '19239', 'phuong', '39'),
(2755, 'Dương Minh Châu', 'Xã Dương Minh Châu', 'Xã Dương Minh Châu, Tỉnh Tây Ninh', '296', 'xa', '40'),
(2756, 'Ninh Thạnh', 'Phường Ninh Thạnh', 'Phường Ninh Thạnh, Tỉnh Tây Ninh', '552', 'phuong', '40'),
(2757, 'Cầu Khởi', 'Xã Cầu Khởi', 'Xã Cầu Khởi, Tỉnh Tây Ninh', '808', 'xa', '40'),
(2758, 'Lộc Ninh', 'Xã Lộc Ninh', 'Xã Lộc Ninh, Tỉnh Tây Ninh', '1064', 'xa', '40'),
(2759, 'Thạnh Bình', 'Xã Thạnh Bình', 'Xã Thạnh Bình, Tỉnh Tây Ninh', '1320', 'xa', '40'),
(2760, 'Trà Vong', 'Xã Trà Vong', 'Xã Trà Vong, Tỉnh Tây Ninh', '1576', 'xa', '40'),
(2761, 'Tân Châu', 'Xã Tân Châu', 'Xã Tân Châu, Tỉnh Tây Ninh', '1832', 'xa', '40'),
(2762, 'Tân Thành', 'Xã Tân Thành', 'Xã Tân Thành, Tỉnh Tây Ninh', '2088', 'xa', '40'),
(2763, 'Tân Phú', 'Xã Tân Phú', 'Xã Tân Phú, Tỉnh Tây Ninh', '2344', 'xa', '40'),
(2764, 'Tân Ninh', 'Phường Tân Ninh', 'Phường Tân Ninh, Tỉnh Tây Ninh', '2600', 'phuong', '40'),
(2765, 'Bình Minh', 'Phường Bình Minh', 'Phường Bình Minh, Tỉnh Tây Ninh', '2856', 'phuong', '40'),
(2766, 'Châu Thành', 'Xã Châu Thành', 'Xã Châu Thành, Tỉnh Tây Ninh', '3112', 'xa', '40'),
(2767, 'Đức Lập', 'Xã Đức Lập', 'Xã Đức Lập, Tỉnh Tây Ninh', '3368', 'xa', '40'),
(2768, 'Mỹ Hạnh', 'Xã Mỹ Hạnh', 'Xã Mỹ Hạnh, Tỉnh Tây Ninh', '3624', 'xa', '40'),
(2769, 'Tuyên Thạnh', 'Xã Tuyên Thạnh', 'Xã Tuyên Thạnh, Tỉnh Tây Ninh', '3880', 'xa', '40'),
(2770, 'Hậu Thạnh', 'Xã Hậu Thạnh', 'Xã Hậu Thạnh, Tỉnh Tây Ninh', '4136', 'xa', '40'),
(2771, 'Long An', 'Phường Long An', 'Phường Long An, Tỉnh Tây Ninh', '4392', 'phuong', '40'),
(2772, 'Mỹ Thạnh', 'Xã Mỹ Thạnh', 'Xã Mỹ Thạnh, Tỉnh Tây Ninh', '4648', 'xa', '40'),
(2773, 'Vĩnh Hưng', 'Xã Vĩnh Hưng', 'Xã Vĩnh Hưng, Tỉnh Tây Ninh', '4904', 'xa', '40'),
(2774, 'Khánh Hưng', 'Xã Khánh Hưng', 'Xã Khánh Hưng, Tỉnh Tây Ninh', '5160', 'xa', '40'),
(2775, 'Tuyên Bình', 'Xã Tuyên Bình', 'Xã Tuyên Bình, Tỉnh Tây Ninh', '5416', 'xa', '40'),
(2776, 'Nhựt Tảo', 'Xã Nhựt Tảo', 'Xã Nhựt Tảo, Tỉnh Tây Ninh', '5672', 'xa', '40'),
(2777, 'Thủ Thừa', 'Xã Thủ Thừa', 'Xã Thủ Thừa, Tỉnh Tây Ninh', '5928', 'xa', '40'),
(2778, 'Lương Hòa', 'Xã Lương Hòa', 'Xã Lương Hòa, Tỉnh Tây Ninh', '6184', 'xa', '40'),
(2779, 'Long Hoa', 'Phường Long Hoa', 'Phường Long Hoa, Tỉnh Tây Ninh', '6440', 'phuong', '40'),
(2780, 'Hòa Thành', 'Phường Hòa Thành', 'Phường Hòa Thành, Tỉnh Tây Ninh', '6696', 'phuong', '40'),
(2781, 'Thanh Điền', 'Phường Thanh Điền', 'Phường Thanh Điền, Tỉnh Tây Ninh', '6952', 'phuong', '40'),
(2782, 'Trảng Bàng', 'Phường Trảng Bàng', 'Phường Trảng Bàng, Tỉnh Tây Ninh', '7208', 'phuong', '40'),
(2783, 'An Tịnh', 'Phường An Tịnh', 'Phường An Tịnh, Tỉnh Tây Ninh', '7464', 'phuong', '40'),
(2784, 'Gò Dầu', 'Phường Gò Dầu', 'Phường Gò Dầu, Tỉnh Tây Ninh', '7720', 'phuong', '40'),
(2785, 'Gia Lộc', 'Phường Gia Lộc', 'Phường Gia Lộc, Tỉnh Tây Ninh', '7976', 'phuong', '40'),
(2786, 'Hưng Thuận', 'Xã Hưng Thuận', 'Xã Hưng Thuận, Tỉnh Tây Ninh', '8232', 'xa', '40'),
(2787, 'Phước Chỉ', 'Xã Phước Chỉ', 'Xã Phước Chỉ, Tỉnh Tây Ninh', '8488', 'xa', '40'),
(2788, 'Thạnh Đức', 'Xã Thạnh Đức', 'Xã Thạnh Đức, Tỉnh Tây Ninh', '8744', 'xa', '40'),
(2789, 'Phước Thạnh', 'Xã Phước Thạnh', 'Xã Phước Thạnh, Tỉnh Tây Ninh', '9000', 'xa', '40'),
(2790, 'Truông Mít', 'Xã Truông Mít', 'Xã Truông Mít, Tỉnh Tây Ninh', '9256', 'xa', '40'),
(2791, 'Tân Đông', 'Xã Tân Đông', 'Xã Tân Đông, Tỉnh Tây Ninh', '9512', 'xa', '40'),
(2792, 'Tân Hội', 'Xã Tân Hội', 'Xã Tân Hội, Tỉnh Tây Ninh', '9768', 'xa', '40'),
(2793, 'Tân Hòa', 'Xã Tân Hòa', 'Xã Tân Hòa, Tỉnh Tây Ninh', '10024', 'xa', '40'),
(2794, 'Tân Lập', 'Xã Tân Lập', 'Xã Tân Lập, Tỉnh Tây Ninh', '10280', 'xa', '40'),
(2795, 'Tân Biên', 'Xã Tân Biên', 'Xã Tân Biên, Tỉnh Tây Ninh', '10536', 'xa', '40'),
(2796, 'Phước Vinh', 'Xã Phước Vinh', 'Xã Phước Vinh, Tỉnh Tây Ninh', '10792', 'xa', '40'),
(2797, 'Hòa Hội', 'Xã Hòa Hội', 'Xã Hòa Hội, Tỉnh Tây Ninh', '11048', 'xa', '40'),
(2798, 'Ninh Điền', 'Xã Ninh Điền', 'Xã Ninh Điền, Tỉnh Tây Ninh', '11304', 'xa', '40'),
(2799, 'Hảo Đước', 'Xã Hảo Đước', 'Xã Hảo Đước, Tỉnh Tây Ninh', '11560', 'xa', '40'),
(2800, 'Long Chữ', 'Xã Long Chữ', 'Xã Long Chữ, Tỉnh Tây Ninh', '11816', 'xa', '40'),
(2801, 'Long Thuận', 'Xã Long Thuận', 'Xã Long Thuận, Tỉnh Tây Ninh', '12072', 'xa', '40'),
(2802, 'Bến Cầu', 'Xã Bến Cầu', 'Xã Bến Cầu, Tỉnh Tây Ninh', '12328', 'xa', '40'),
(2803, 'Hưng Điền', 'Xã Hưng Điền', 'Xã Hưng Điền, Tỉnh Tây Ninh', '12584', 'xa', '40'),
(2804, 'Vĩnh Thạnh', 'Xã Vĩnh Thạnh', 'Xã Vĩnh Thạnh, Tỉnh Tây Ninh', '12840', 'xa', '40'),
(2805, 'Tân Hưng', 'Xã Tân Hưng', 'Xã Tân Hưng, Tỉnh Tây Ninh', '13096', 'xa', '40'),
(2806, 'Vĩnh Châu', 'Xã Vĩnh Châu', 'Xã Vĩnh Châu, Tỉnh Tây Ninh', '13352', 'xa', '40'),
(2807, 'Bình Hiệp', 'Xã Bình Hiệp', 'Xã Bình Hiệp, Tỉnh Tây Ninh', '13608', 'xa', '40'),
(2808, 'Kiến Tường', 'Phường Kiến Tường', 'Phường Kiến Tường, Tỉnh Tây Ninh', '13864', 'phuong', '40'),
(2809, 'Bình Hòa', 'Xã Bình Hòa', 'Xã Bình Hòa, Tỉnh Tây Ninh', '14120', 'xa', '40'),
(2810, 'Mộc Hóa', 'Xã Mộc Hóa', 'Xã Mộc Hóa, Tỉnh Tây Ninh', '14376', 'xa', '40'),
(2811, 'Nhơn Hòa Lập', 'Xã Nhơn Hòa Lập', 'Xã Nhơn Hòa Lập, Tỉnh Tây Ninh', '14632', 'xa', '40'),
(2812, 'Nhơn Ninh', 'Xã Nhơn Ninh', 'Xã Nhơn Ninh, Tỉnh Tây Ninh', '14888', 'xa', '40'),
(2813, 'Tân Thạnh', 'Xã Tân Thạnh', 'Xã Tân Thạnh, Tỉnh Tây Ninh', '15144', 'xa', '40'),
(2814, 'Bình Thành', 'Xã Bình Thành', 'Xã Bình Thành, Tỉnh Tây Ninh', '15400', 'xa', '40'),
(2815, 'Thạnh Phước', 'Xã Thạnh Phước', 'Xã Thạnh Phước, Tỉnh Tây Ninh', '15656', 'xa', '40'),
(2816, 'Thạnh Hóa', 'Xã Thạnh Hóa', 'Xã Thạnh Hóa, Tỉnh Tây Ninh', '15912', 'xa', '40'),
(2817, 'Tân Tây', 'Xã Tân Tây', 'Xã Tân Tây, Tỉnh Tây Ninh', '16168', 'xa', '40'),
(2818, 'Mỹ An', 'Xã Mỹ An', 'Xã Mỹ An, Tỉnh Tây Ninh', '16424', 'xa', '40'),
(2819, 'Tân Long', 'Xã Tân Long', 'Xã Tân Long, Tỉnh Tây Ninh', '16680', 'xa', '40'),
(2820, 'Mỹ Quý', 'Xã Mỹ Quý', 'Xã Mỹ Quý, Tỉnh Tây Ninh', '16936', 'xa', '40'),
(2821, 'Đông Thành', 'Xã Đông Thành', 'Xã Đông Thành, Tỉnh Tây Ninh', '17192', 'xa', '40'),
(2822, 'Đức Huệ', 'Xã Đức Huệ', 'Xã Đức Huệ, Tỉnh Tây Ninh', '17448', 'xa', '40'),
(2823, 'An Ninh', 'Xã An Ninh', 'Xã An Ninh, Tỉnh Tây Ninh', '17704', 'xa', '40'),
(2824, 'Hiệp Hòa', 'Xã Hiệp Hòa', 'Xã Hiệp Hòa, Tỉnh Tây Ninh', '17960', 'xa', '40');
INSERT INTO `vn_locations` (`id`, `name`, `full_name`, `full_path`, `code`, `level`, `parent_code`) VALUES
(2825, 'Hậu Nghĩa', 'Xã Hậu Nghĩa', 'Xã Hậu Nghĩa, Tỉnh Tây Ninh', '18216', 'xa', '40'),
(2826, 'Hòa Khánh', 'Xã Hòa Khánh', 'Xã Hòa Khánh, Tỉnh Tây Ninh', '18472', 'xa', '40'),
(2827, 'Đức Hòa', 'Xã Đức Hòa', 'Xã Đức Hòa, Tỉnh Tây Ninh', '18728', 'xa', '40'),
(2828, 'Thạnh Lợi', 'Xã Thạnh Lợi', 'Xã Thạnh Lợi, Tỉnh Tây Ninh', '18984', 'xa', '40'),
(2829, 'Bình Đức', 'Xã Bình Đức', 'Xã Bình Đức, Tỉnh Tây Ninh', '19240', 'xa', '40'),
(2830, 'Bến Lức', 'Xã Bến Lức', 'Xã Bến Lức, Tỉnh Tây Ninh', '19496', 'xa', '40'),
(2831, 'Mỹ Yên', 'Xã Mỹ Yên', 'Xã Mỹ Yên, Tỉnh Tây Ninh', '19752', 'xa', '40'),
(2832, 'Long Cang', 'Xã Long Cang', 'Xã Long Cang, Tỉnh Tây Ninh', '20008', 'xa', '40'),
(2833, 'Rạch Kiến', 'Xã Rạch Kiến', 'Xã Rạch Kiến, Tỉnh Tây Ninh', '20264', 'xa', '40'),
(2834, 'Mỹ Lệ', 'Xã Mỹ Lệ', 'Xã Mỹ Lệ, Tỉnh Tây Ninh', '20520', 'xa', '40'),
(2835, 'Tân Lân', 'Xã Tân Lân', 'Xã Tân Lân, Tỉnh Tây Ninh', '20776', 'xa', '40'),
(2836, 'Cần Đước', 'Xã Cần Đước', 'Xã Cần Đước, Tỉnh Tây Ninh', '21032', 'xa', '40'),
(2837, 'Long Hựu', 'Xã Long Hựu', 'Xã Long Hựu, Tỉnh Tây Ninh', '21288', 'xa', '40'),
(2838, 'Phước Lý', 'Xã Phước Lý', 'Xã Phước Lý, Tỉnh Tây Ninh', '21544', 'xa', '40'),
(2839, 'Mỹ Lộc', 'Xã Mỹ Lộc', 'Xã Mỹ Lộc, Tỉnh Tây Ninh', '21800', 'xa', '40'),
(2840, 'Cần Giuộc', 'Xã Cần Giuộc', 'Xã Cần Giuộc, Tỉnh Tây Ninh', '22056', 'xa', '40'),
(2841, 'Phước Vĩnh Tây', 'Xã Phước Vĩnh Tây', 'Xã Phước Vĩnh Tây, Tỉnh Tây Ninh', '22312', 'xa', '40'),
(2842, 'Tân Tập', 'Xã Tân Tập', 'Xã Tân Tập, Tỉnh Tây Ninh', '22568', 'xa', '40'),
(2843, 'Vàm Cỏ', 'Xã Vàm Cỏ', 'Xã Vàm Cỏ, Tỉnh Tây Ninh', '22824', 'xa', '40'),
(2844, 'Tân Trụ', 'Xã Tân Trụ', 'Xã Tân Trụ, Tỉnh Tây Ninh', '23080', 'xa', '40'),
(2845, 'Thuận Mỹ', 'Xã Thuận Mỹ', 'Xã Thuận Mỹ, Tỉnh Tây Ninh', '23336', 'xa', '40'),
(2846, 'An Lục Long', 'Xã An Lục Long', 'Xã An Lục Long, Tỉnh Tây Ninh', '23592', 'xa', '40'),
(2847, 'Tầm Vu', 'Xã Tầm Vu', 'Xã Tầm Vu, Tỉnh Tây Ninh', '23848', 'xa', '40'),
(2848, 'Vĩnh Công', 'Xã Vĩnh Công', 'Xã Vĩnh Công, Tỉnh Tây Ninh', '24104', 'xa', '40'),
(2849, 'Tân An', 'Phường Tân An', 'Phường Tân An, Tỉnh Tây Ninh', '24360', 'phuong', '40'),
(2850, 'Khánh Hậu', 'Phường Khánh Hậu', 'Phường Khánh Hậu, Tỉnh Tây Ninh', '24616', 'phuong', '40'),
(2851, 'Thượng Quan', 'Xã Thượng Quan', 'Xã Thượng Quan, Tỉnh Thái Nguyên', '297', 'xa', '41'),
(2852, 'Sảng Mộc', 'Xã Sảng Mộc', 'Xã Sảng Mộc, Tỉnh Thái Nguyên', '553', 'xa', '41'),
(2853, 'Phú Bình', 'Xã Phú Bình', 'Xã Phú Bình, Tỉnh Thái Nguyên', '809', 'xa', '41'),
(2854, 'Điềm Thụy', 'Xã Điềm Thụy', 'Xã Điềm Thụy, Tỉnh Thái Nguyên', '1065', 'xa', '41'),
(2855, 'Gia Sàng', 'Phường Gia Sàng', 'Phường Gia Sàng, Tỉnh Thái Nguyên', '1321', 'phuong', '41'),
(2856, 'Phan Đình Phùng', 'Phường Phan Đình Phùng', 'Phường Phan Đình Phùng, Tỉnh Thái Nguyên', '1577', 'phuong', '41'),
(2857, 'Tích Lương', 'Phường Tích Lương', 'Phường Tích Lương, Tỉnh Thái Nguyên', '1833', 'phuong', '41'),
(2858, 'Linh Sơn', 'Phường Linh Sơn', 'Phường Linh Sơn, Tỉnh Thái Nguyên', '2089', 'phuong', '41'),
(2859, 'Phúc Thuận', 'Phường Phúc Thuận', 'Phường Phúc Thuận, Tỉnh Thái Nguyên', '2345', 'phuong', '41'),
(2860, 'Thành Công', 'Xã Thành Công', 'Xã Thành Công, Tỉnh Thái Nguyên', '2601', 'xa', '41'),
(2861, 'Tân Thành', 'Xã Tân Thành', 'Xã Tân Thành, Tỉnh Thái Nguyên', '2857', 'xa', '41'),
(2862, 'Kha Sơn', 'Xã Kha Sơn', 'Xã Kha Sơn, Tỉnh Thái Nguyên', '3113', 'xa', '41'),
(2863, 'Tân Khánh', 'Xã Tân Khánh', 'Xã Tân Khánh, Tỉnh Thái Nguyên', '3369', 'xa', '41'),
(2864, 'Đồng Hỷ', 'Xã Đồng Hỷ', 'Xã Đồng Hỷ, Tỉnh Thái Nguyên', '3625', 'xa', '41'),
(2865, 'Quang Sơn', 'Xã Quang Sơn', 'Xã Quang Sơn, Tỉnh Thái Nguyên', '3881', 'xa', '41'),
(2866, 'Trại Cau', 'Xã Trại Cau', 'Xã Trại Cau, Tỉnh Thái Nguyên', '4137', 'xa', '41'),
(2867, 'Nam Hòa', 'Xã Nam Hòa', 'Xã Nam Hòa, Tỉnh Thái Nguyên', '4393', 'xa', '41'),
(2868, 'Văn Hán', 'Xã Văn Hán', 'Xã Văn Hán, Tỉnh Thái Nguyên', '4649', 'xa', '41'),
(2869, 'Văn Lăng', 'Xã Văn Lăng', 'Xã Văn Lăng, Tỉnh Thái Nguyên', '4905', 'xa', '41'),
(2870, 'Sông Công', 'Phường Sông Công', 'Phường Sông Công, Tỉnh Thái Nguyên', '5161', 'phuong', '41'),
(2871, 'Bá Xuyên', 'Phường Bá Xuyên', 'Phường Bá Xuyên, Tỉnh Thái Nguyên', '5417', 'phuong', '41'),
(2872, 'Bách Quang', 'Phường Bách Quang', 'Phường Bách Quang, Tỉnh Thái Nguyên', '5673', 'phuong', '41'),
(2873, 'Phú Lương', 'Xã Phú Lương', 'Xã Phú Lương, Tỉnh Thái Nguyên', '5929', 'xa', '41'),
(2874, 'Vô Tranh', 'Xã Vô Tranh', 'Xã Vô Tranh, Tỉnh Thái Nguyên', '6185', 'xa', '41'),
(2875, 'Yên Trạch', 'Xã Yên Trạch', 'Xã Yên Trạch, Tỉnh Thái Nguyên', '6441', 'xa', '41'),
(2876, 'Hợp Thành', 'Xã Hợp Thành', 'Xã Hợp Thành, Tỉnh Thái Nguyên', '6697', 'xa', '41'),
(2877, 'Định Hóa', 'Xã Định Hóa', 'Xã Định Hóa, Tỉnh Thái Nguyên', '6953', 'xa', '41'),
(2878, 'Bình Yên', 'Xã Bình Yên', 'Xã Bình Yên, Tỉnh Thái Nguyên', '7209', 'xa', '41'),
(2879, 'Trung Hội', 'Xã Trung Hội', 'Xã Trung Hội, Tỉnh Thái Nguyên', '7465', 'xa', '41'),
(2880, 'Phượng Tiến', 'Xã Phượng Tiến', 'Xã Phượng Tiến, Tỉnh Thái Nguyên', '7721', 'xa', '41'),
(2881, 'Phú Đình', 'Xã Phú Đình', 'Xã Phú Đình, Tỉnh Thái Nguyên', '7977', 'xa', '41'),
(2882, 'Bình Thành', 'Xã Bình Thành', 'Xã Bình Thành, Tỉnh Thái Nguyên', '8233', 'xa', '41'),
(2883, 'Kim Phượng', 'Xã Kim Phượng', 'Xã Kim Phượng, Tỉnh Thái Nguyên', '8489', 'xa', '41'),
(2884, 'Lam Vỹ', 'Xã Lam Vỹ', 'Xã Lam Vỹ, Tỉnh Thái Nguyên', '8745', 'xa', '41'),
(2885, 'Võ Nhai', 'Xã Võ Nhai', 'Xã Võ Nhai, Tỉnh Thái Nguyên', '9001', 'xa', '41'),
(2886, 'Dân Tiến', 'Xã Dân Tiến', 'Xã Dân Tiến, Tỉnh Thái Nguyên', '9257', 'xa', '41'),
(2887, 'Nghinh Tường', 'Xã Nghinh Tường', 'Xã Nghinh Tường, Tỉnh Thái Nguyên', '9513', 'xa', '41'),
(2888, 'Thần Sa', 'Xã Thần Sa', 'Xã Thần Sa, Tỉnh Thái Nguyên', '9769', 'xa', '41'),
(2889, 'La Hiên', 'Xã La Hiên', 'Xã La Hiên, Tỉnh Thái Nguyên', '10025', 'xa', '41'),
(2890, 'Tràng Xá', 'Xã Tràng Xá', 'Xã Tràng Xá, Tỉnh Thái Nguyên', '10281', 'xa', '41'),
(2891, 'Quyết Thắng', 'Phường Quyết Thắng', 'Phường Quyết Thắng, Tỉnh Thái Nguyên', '10537', 'phuong', '41'),
(2892, 'Quan Triều', 'Phường Quan Triều', 'Phường Quan Triều, Tỉnh Thái Nguyên', '10793', 'phuong', '41'),
(2893, 'Tân Cương', 'Xã Tân Cương', 'Xã Tân Cương, Tỉnh Thái Nguyên', '11049', 'xa', '41'),
(2894, 'Đại Phúc', 'Xã Đại Phúc', 'Xã Đại Phúc, Tỉnh Thái Nguyên', '11305', 'xa', '41'),
(2895, 'Đại Từ', 'Xã Đại Từ', 'Xã Đại Từ, Tỉnh Thái Nguyên', '11561', 'xa', '41'),
(2896, 'Đức Lương', 'Xã Đức Lương', 'Xã Đức Lương, Tỉnh Thái Nguyên', '11817', 'xa', '41'),
(2897, 'Phú Thịnh', 'Xã Phú Thịnh', 'Xã Phú Thịnh, Tỉnh Thái Nguyên', '12073', 'xa', '41'),
(2898, 'La Bằng', 'Xã La Bằng', 'Xã La Bằng, Tỉnh Thái Nguyên', '12329', 'xa', '41'),
(2899, 'Phú Lạc', 'Xã Phú Lạc', 'Xã Phú Lạc, Tỉnh Thái Nguyên', '12585', 'xa', '41'),
(2900, 'An Khánh', 'Xã An Khánh', 'Xã An Khánh, Tỉnh Thái Nguyên', '12841', 'xa', '41'),
(2901, 'Quân Chu', 'Xã Quân Chu', 'Xã Quân Chu, Tỉnh Thái Nguyên', '13097', 'xa', '41'),
(2902, 'Vạn Phú', 'Xã Vạn Phú', 'Xã Vạn Phú, Tỉnh Thái Nguyên', '13353', 'xa', '41'),
(2903, 'Phú Xuyên', 'Xã Phú Xuyên', 'Xã Phú Xuyên, Tỉnh Thái Nguyên', '13609', 'xa', '41'),
(2904, 'Phổ Yên', 'Phường Phổ Yên', 'Phường Phổ Yên, Tỉnh Thái Nguyên', '13865', 'phuong', '41'),
(2905, 'Vạn Xuân', 'Phường Vạn Xuân', 'Phường Vạn Xuân, Tỉnh Thái Nguyên', '14121', 'phuong', '41'),
(2906, 'Trung Thành', 'Phường Trung Thành', 'Phường Trung Thành, Tỉnh Thái Nguyên', '14377', 'phuong', '41'),
(2907, 'Phúc Lộc', 'Xã Phúc Lộc', 'Xã Phúc Lộc, Tỉnh Thái Nguyên', '14633', 'xa', '41'),
(2908, 'Thượng Minh', 'Xã Thượng Minh', 'Xã Thượng Minh, Tỉnh Thái Nguyên', '14889', 'xa', '41'),
(2909, 'Đồng Phúc', 'Xã Đồng Phúc', 'Xã Đồng Phúc, Tỉnh Thái Nguyên', '15145', 'xa', '41'),
(2910, 'Bằng Vân', 'Xã Bằng Vân', 'Xã Bằng Vân, Tỉnh Thái Nguyên', '15401', 'xa', '41'),
(2911, 'Bằng Thành', 'Xã Bằng Thành', 'Xã Bằng Thành, Tỉnh Thái Nguyên', '15657', 'xa', '41'),
(2912, 'Nghiên Loan', 'Xã Nghiên Loan', 'Xã Nghiên Loan, Tỉnh Thái Nguyên', '15913', 'xa', '41'),
(2913, 'Cao Minh', 'Xã Cao Minh', 'Xã Cao Minh, Tỉnh Thái Nguyên', '16169', 'xa', '41'),
(2914, 'Ba Bể', 'Xã Ba Bể', 'Xã Ba Bể, Tỉnh Thái Nguyên', '16425', 'xa', '41'),
(2915, 'Chợ Rã', 'Xã Chợ Rã', 'Xã Chợ Rã, Tỉnh Thái Nguyên', '16681', 'xa', '41'),
(2916, 'Ngân Sơn', 'Xã Ngân Sơn', 'Xã Ngân Sơn, Tỉnh Thái Nguyên', '16937', 'xa', '41'),
(2917, 'Nà Phặc', 'Xã Nà Phặc', 'Xã Nà Phặc, Tỉnh Thái Nguyên', '17193', 'xa', '41'),
(2918, 'Hiệp Lực', 'Xã Hiệp Lực', 'Xã Hiệp Lực, Tỉnh Thái Nguyên', '17449', 'xa', '41'),
(2919, 'Nam Cường', 'Xã Nam Cường', 'Xã Nam Cường, Tỉnh Thái Nguyên', '17705', 'xa', '41'),
(2920, 'Quảng Bạch', 'Xã Quảng Bạch', 'Xã Quảng Bạch, Tỉnh Thái Nguyên', '17961', 'xa', '41'),
(2921, 'Yên Thịnh', 'Xã Yên Thịnh', 'Xã Yên Thịnh, Tỉnh Thái Nguyên', '18217', 'xa', '41'),
(2922, 'Chợ Đồn', 'Xã Chợ Đồn', 'Xã Chợ Đồn, Tỉnh Thái Nguyên', '18473', 'xa', '41'),
(2923, 'Yên Phong', 'Xã Yên Phong', 'Xã Yên Phong, Tỉnh Thái Nguyên', '18729', 'xa', '41'),
(2924, 'Nghĩa Tá', 'Xã Nghĩa Tá', 'Xã Nghĩa Tá, Tỉnh Thái Nguyên', '18985', 'xa', '41'),
(2925, 'Phủ Thông', 'Xã Phủ Thông', 'Xã Phủ Thông, Tỉnh Thái Nguyên', '19241', 'xa', '41'),
(2926, 'Cẩm Giàng', 'Xã Cẩm Giàng', 'Xã Cẩm Giàng, Tỉnh Thái Nguyên', '19497', 'xa', '41'),
(2927, 'Vĩnh Thông', 'Xã Vĩnh Thông', 'Xã Vĩnh Thông, Tỉnh Thái Nguyên', '19753', 'xa', '41'),
(2928, 'Bạch Thông', 'Xã Bạch Thông', 'Xã Bạch Thông, Tỉnh Thái Nguyên', '20009', 'xa', '41'),
(2929, 'Phong Quang', 'Xã Phong Quang', 'Xã Phong Quang, Tỉnh Thái Nguyên', '20265', 'xa', '41'),
(2930, 'Đức Xuân', 'Phường Đức Xuân', 'Phường Đức Xuân, Tỉnh Thái Nguyên', '20521', 'phuong', '41'),
(2931, 'Bắc Kạn', 'Phường Bắc Kạn', 'Phường Bắc Kạn, Tỉnh Thái Nguyên', '20777', 'phuong', '41'),
(2932, 'Văn Lang', 'Xã Văn Lang', 'Xã Văn Lang, Tỉnh Thái Nguyên', '21033', 'xa', '41'),
(2933, 'Cường Lợi', 'Xã Cường Lợi', 'Xã Cường Lợi, Tỉnh Thái Nguyên', '21289', 'xa', '41'),
(2934, 'Na Rì', 'Xã Na Rì', 'Xã Na Rì, Tỉnh Thái Nguyên', '21545', 'xa', '41'),
(2935, 'Trần Phú', 'Xã Trần Phú', 'Xã Trần Phú, Tỉnh Thái Nguyên', '21801', 'xa', '41'),
(2936, 'Côn Minh', 'Xã Côn Minh', 'Xã Côn Minh, Tỉnh Thái Nguyên', '22057', 'xa', '41'),
(2937, 'Xuân Dương', 'Xã Xuân Dương', 'Xã Xuân Dương, Tỉnh Thái Nguyên', '22313', 'xa', '41'),
(2938, 'Tân Kỳ', 'Xã Tân Kỳ', 'Xã Tân Kỳ, Tỉnh Thái Nguyên', '22569', 'xa', '41'),
(2939, 'Thanh Mai', 'Xã Thanh Mai', 'Xã Thanh Mai, Tỉnh Thái Nguyên', '22825', 'xa', '41'),
(2940, 'Thanh Thịnh', 'Xã Thanh Thịnh', 'Xã Thanh Thịnh, Tỉnh Thái Nguyên', '23081', 'xa', '41'),
(2941, 'Chợ Mới', 'Xã Chợ Mới', 'Xã Chợ Mới, Tỉnh Thái Nguyên', '23337', 'xa', '41'),
(2942, 'Yên Bình', 'Xã Yên Bình', 'Xã Yên Bình, Tỉnh Thái Nguyên', '23593', 'xa', '41'),
(2943, 'Thiệu Quang', 'Xã Thiệu Quang', 'Xã Thiệu Quang, Tỉnh Thanh Hóa', '298', 'xa', '42'),
(2944, 'Thọ Phú', 'Xã Thọ Phú', 'Xã Thọ Phú, Tỉnh Thanh Hóa', '554', 'xa', '42'),
(2945, 'Trung Lý', 'Xã Trung Lý', 'Xã Trung Lý, Tỉnh Thanh Hóa', '810', 'xa', '42'),
(2946, 'Trung Sơn', 'Xã Trung Sơn', 'Xã Trung Sơn, Tỉnh Thanh Hóa', '1066', 'xa', '42'),
(2947, 'Mường Mìn', 'Xã Mường Mìn', 'Xã Mường Mìn, Tỉnh Thanh Hóa', '1322', 'xa', '42'),
(2948, 'Na Mèo', 'Xã Na Mèo', 'Xã Na Mèo, Tỉnh Thanh Hóa', '1578', 'xa', '42'),
(2949, 'Sơn Điện', 'Xã Sơn Điện', 'Xã Sơn Điện, Tỉnh Thanh Hóa', '1834', 'xa', '42'),
(2950, 'Sơn Thủy', 'Xã Sơn Thủy', 'Xã Sơn Thủy, Tỉnh Thanh Hóa', '2090', 'xa', '42'),
(2951, 'Tam Lư', 'Xã Tam Lư', 'Xã Tam Lư, Tỉnh Thanh Hóa', '2346', 'xa', '42'),
(2952, 'Tam Thanh', 'Xã Tam Thanh', 'Xã Tam Thanh, Tỉnh Thanh Hóa', '2602', 'xa', '42'),
(2953, 'Quang Chiểu', 'Xã Quang Chiểu', 'Xã Quang Chiểu, Tỉnh Thanh Hóa', '2858', 'xa', '42'),
(2954, 'Tam Chung', 'Xã Tam Chung', 'Xã Tam Chung, Tỉnh Thanh Hóa', '3114', 'xa', '42'),
(2955, 'Nhi Sơn', 'Xã Nhi Sơn', 'Xã Nhi Sơn, Tỉnh Thanh Hóa', '3370', 'xa', '42'),
(2956, 'Pù Nhi', 'Xã Pù Nhi', 'Xã Pù Nhi, Tỉnh Thanh Hóa', '3626', 'xa', '42'),
(2957, 'Công Chính', 'Xã Công Chính', 'Xã Công Chính, Tỉnh Thanh Hóa', '3882', 'xa', '42'),
(2958, 'Phú Xuân', 'Xã Phú Xuân', 'Xã Phú Xuân, Tỉnh Thanh Hóa', '4138', 'xa', '42'),
(2959, 'Thanh Kỳ', 'Xã Thanh Kỳ', 'Xã Thanh Kỳ, Tỉnh Thanh Hóa', '4394', 'xa', '42'),
(2960, 'Xuân Thái', 'Xã Xuân Thái', 'Xã Xuân Thái, Tỉnh Thanh Hóa', '4650', 'xa', '42'),
(2961, 'Yên Thọ', 'Xã Yên Thọ', 'Xã Yên Thọ, Tỉnh Thanh Hóa', '4906', 'xa', '42'),
(2962, 'Mường Lý', 'Xã Mường Lý', 'Xã Mường Lý, Tỉnh Thanh Hóa', '5162', 'xa', '42'),
(2963, 'Yên Khương', 'Xã Yên Khương', 'Xã Yên Khương, Tỉnh Thanh Hóa', '5418', 'xa', '42'),
(2964, 'Yên Thắng', 'Xã Yên Thắng', 'Xã Yên Thắng, Tỉnh Thanh Hóa', '5674', 'xa', '42'),
(2965, 'Mường Lát', 'Xã Mường Lát', 'Xã Mường Lát, Tỉnh Thanh Hóa', '5930', 'xa', '42'),
(2966, 'Mường Chanh', 'Xã Mường Chanh', 'Xã Mường Chanh, Tỉnh Thanh Hóa', '6186', 'xa', '42'),
(2967, 'Thiệu Trung', 'Xã Thiệu Trung', 'Xã Thiệu Trung, Tỉnh Thanh Hóa', '6442', 'xa', '42'),
(2968, 'Bát Mọt', 'Xã Bát Mọt', 'Xã Bát Mọt, Tỉnh Thanh Hóa', '6698', 'xa', '42'),
(2969, 'Luận Thành', 'Xã Luận Thành', 'Xã Luận Thành, Tỉnh Thanh Hóa', '6954', 'xa', '42'),
(2970, 'Lương Sơn', 'Xã Lương Sơn', 'Xã Lương Sơn, Tỉnh Thanh Hóa', '7210', 'xa', '42'),
(2971, 'Vạn Xuân', 'Xã Vạn Xuân', 'Xã Vạn Xuân, Tỉnh Thanh Hóa', '7466', 'xa', '42'),
(2972, 'Tân Thành', 'Xã Tân Thành', 'Xã Tân Thành, Tỉnh Thanh Hóa', '7722', 'xa', '42'),
(2973, 'Hải Bình', 'Phường Hải Bình', 'Phường Hải Bình, Tỉnh Thanh Hóa', '7978', 'phuong', '42'),
(2974, 'Yên Nhân', 'Xã Yên Nhân', 'Xã Yên Nhân, Tỉnh Thanh Hóa', '8234', 'xa', '42'),
(2975, 'Định Hòa', 'Xã Định Hòa', 'Xã Định Hòa, Tỉnh Thanh Hóa', '8490', 'xa', '42'),
(2976, 'Hàm Rồng', 'Phường Hàm Rồng', 'Phường Hàm Rồng, Tỉnh Thanh Hóa', '8746', 'phuong', '42'),
(2977, 'Hoạt Giang', 'Xã Hoạt Giang', 'Xã Hoạt Giang, Tỉnh Thanh Hóa', '9002', 'xa', '42'),
(2978, 'Vạn Lộc', 'Xã Vạn Lộc', 'Xã Vạn Lộc, Tỉnh Thanh Hóa', '9258', 'xa', '42'),
(2979, 'Đông Quang', 'Phường Đông Quang', 'Phường Đông Quang, Tỉnh Thanh Hóa', '9514', 'phuong', '42'),
(2980, 'Quảng Phú', 'Phường Quảng Phú', 'Phường Quảng Phú, Tỉnh Thanh Hóa', '9770', 'phuong', '42'),
(2981, 'Đông Sơn', 'Phường Đông Sơn', 'Phường Đông Sơn, Tỉnh Thanh Hóa', '10026', 'phuong', '42'),
(2982, 'Đông Tiến', 'Phường Đông Tiến', 'Phường Đông Tiến, Tỉnh Thanh Hóa', '10282', 'phuong', '42'),
(2983, 'Nguyệt Viên', 'Phường Nguyệt Viên', 'Phường Nguyệt Viên, Tỉnh Thanh Hóa', '10538', 'phuong', '42'),
(2984, 'Sầm Sơn', 'Phường Sầm Sơn', 'Phường Sầm Sơn, Tỉnh Thanh Hóa', '10794', 'phuong', '42'),
(2985, 'Nam Sầm Sơn', 'Phường Nam Sầm Sơn', 'Phường Nam Sầm Sơn, Tỉnh Thanh Hóa', '11050', 'phuong', '42'),
(2986, 'Bỉm Sơn', 'Phường Bỉm Sơn', 'Phường Bỉm Sơn, Tỉnh Thanh Hóa', '11306', 'phuong', '42'),
(2987, 'Quang Trung', 'Phường Quang Trung', 'Phường Quang Trung, Tỉnh Thanh Hóa', '11562', 'phuong', '42'),
(2988, 'Ngọc Sơn', 'Phường Ngọc Sơn', 'Phường Ngọc Sơn, Tỉnh Thanh Hóa', '11818', 'phuong', '42'),
(2989, 'Tân Dân', 'Phường Tân Dân', 'Phường Tân Dân, Tỉnh Thanh Hóa', '12074', 'phuong', '42'),
(2990, 'Hải Lĩnh', 'Phường Hải Lĩnh', 'Phường Hải Lĩnh, Tỉnh Thanh Hóa', '12330', 'phuong', '42'),
(2991, 'Tĩnh Gia', 'Phường Tĩnh Gia', 'Phường Tĩnh Gia, Tỉnh Thanh Hóa', '12586', 'phuong', '42'),
(2992, 'Đào Duy Tư', 'Phường Đào Duy Tư', 'Phường Đào Duy Tư, Tỉnh Thanh Hóa', '12842', 'phuong', '42'),
(2993, 'Trúc Lâm', 'Phường Trúc Lâm', 'Phường Trúc Lâm, Tỉnh Thanh Hóa', '13098', 'phuong', '42'),
(2994, 'Nghi Sơn', 'Phường Nghi Sơn', 'Phường Nghi Sơn, Tỉnh Thanh Hóa', '13354', 'phuong', '42'),
(2995, 'Các Sơn', 'Xã Các Sơn', 'Xã Các Sơn, Tỉnh Thanh Hóa', '13610', 'xa', '42'),
(2996, 'Trường Lâm', 'Xã Trường Lâm', 'Xã Trường Lâm, Tỉnh Thanh Hóa', '13866', 'xa', '42'),
(2997, 'Tống Sơn', 'Xã Tống Sơn', 'Xã Tống Sơn, Tỉnh Thanh Hóa', '14122', 'xa', '42'),
(2998, 'Hà Long', 'Xã Hà Long', 'Xã Hà Long, Tỉnh Thanh Hóa', '14378', 'xa', '42'),
(2999, 'Lĩnh Toại', 'Xã Lĩnh Toại', 'Xã Lĩnh Toại, Tỉnh Thanh Hóa', '14634', 'xa', '42'),
(3000, 'Triệu Lộc', 'Xã Triệu Lộc', 'Xã Triệu Lộc, Tỉnh Thanh Hóa', '14890', 'xa', '42'),
(3001, 'Đông Thành', 'Xã Đông Thành', 'Xã Đông Thành, Tỉnh Thanh Hóa', '15146', 'xa', '42'),
(3002, 'Hậu Lộc', 'Xã Hậu Lộc', 'Xã Hậu Lộc, Tỉnh Thanh Hóa', '15402', 'xa', '42'),
(3003, 'Hoa Lộc', 'Xã Hoa Lộc', 'Xã Hoa Lộc, Tỉnh Thanh Hóa', '15658', 'xa', '42'),
(3004, 'Nga Sơn', 'Xã Nga Sơn', 'Xã Nga Sơn, Tỉnh Thanh Hóa', '15914', 'xa', '42'),
(3005, 'Nga Thắng', 'Xã Nga Thắng', 'Xã Nga Thắng, Tỉnh Thanh Hóa', '16170', 'xa', '42'),
(3006, 'Hồ Vương', 'Xã Hồ Vương', 'Xã Hồ Vương, Tỉnh Thanh Hóa', '16426', 'xa', '42'),
(3007, 'Tân Tiến', 'Xã Tân Tiến', 'Xã Tân Tiến, Tỉnh Thanh Hóa', '16682', 'xa', '42'),
(3008, 'Ba Đình', 'Xã Ba Đình', 'Xã Ba Đình, Tỉnh Thanh Hóa', '17194', 'xa', '42'),
(3009, 'Hoằng Hóa', 'Xã Hoằng Hóa', 'Xã Hoằng Hóa, Tỉnh Thanh Hóa', '17450', 'xa', '42'),
(3010, 'Hoằng Tiến', 'Xã Hoằng Tiến', 'Xã Hoằng Tiến, Tỉnh Thanh Hóa', '17706', 'xa', '42'),
(3011, 'Hoằng Thanh', 'Xã Hoằng Thanh', 'Xã Hoằng Thanh, Tỉnh Thanh Hóa', '17962', 'xa', '42'),
(3012, 'Hoằng Lộc', 'Xã Hoằng Lộc', 'Xã Hoằng Lộc, Tỉnh Thanh Hóa', '18218', 'xa', '42'),
(3013, 'Hoằng Châu', 'Xã Hoằng Châu', 'Xã Hoằng Châu, Tỉnh Thanh Hóa', '18474', 'xa', '42'),
(3014, 'Hoằng Sơn', 'Xã Hoằng Sơn', 'Xã Hoằng Sơn, Tỉnh Thanh Hóa', '18730', 'xa', '42'),
(3015, 'Hoằng Phú', 'Xã Hoằng Phú', 'Xã Hoằng Phú, Tỉnh Thanh Hóa', '18986', 'xa', '42'),
(3016, 'Hoằng Giang', 'Xã Hoằng Giang', 'Xã Hoằng Giang, Tỉnh Thanh Hóa', '19242', 'xa', '42'),
(3017, 'Lưu Vệ', 'Xã Lưu Vệ', 'Xã Lưu Vệ, Tỉnh Thanh Hóa', '19498', 'xa', '42'),
(3018, 'Quảng Yên', 'Xã Quảng Yên', 'Xã Quảng Yên, Tỉnh Thanh Hóa', '19754', 'xa', '42'),
(3019, 'Quảng Ngọc', 'Xã Quảng Ngọc', 'Xã Quảng Ngọc, Tỉnh Thanh Hóa', '20010', 'xa', '42'),
(3020, 'Quảng Ninh', 'Xã Quảng Ninh', 'Xã Quảng Ninh, Tỉnh Thanh Hóa', '20266', 'xa', '42'),
(3021, 'Quảng Bình', 'Xã Quảng Bình', 'Xã Quảng Bình, Tỉnh Thanh Hóa', '20522', 'xa', '42'),
(3022, 'Tiên Trang', 'Xã Tiên Trang', 'Xã Tiên Trang, Tỉnh Thanh Hóa', '20778', 'xa', '42'),
(3023, 'Quảng Chính', 'Xã Quảng Chính', 'Xã Quảng Chính, Tỉnh Thanh Hóa', '21034', 'xa', '42'),
(3024, 'Nông Cống', 'Xã Nông Cống', 'Xã Nông Cống, Tỉnh Thanh Hóa', '21290', 'xa', '42'),
(3025, 'Thắng Lợi', 'Xã Thắng Lợi', 'Xã Thắng Lợi, Tỉnh Thanh Hóa', '21546', 'xa', '42'),
(3026, 'Trung Chính', 'Xã Trung Chính', 'Xã Trung Chính, Tỉnh Thanh Hóa', '21802', 'xa', '42'),
(3027, 'Trường Văn', 'Xã Trường Văn', 'Xã Trường Văn, Tỉnh Thanh Hóa', '22058', 'xa', '42'),
(3028, 'Thăng Bình', 'Xã Thăng Bình', 'Xã Thăng Bình, Tỉnh Thanh Hóa', '22314', 'xa', '42'),
(3029, 'Tượng Lĩnh', 'Xã Tượng Lĩnh', 'Xã Tượng Lĩnh, Tỉnh Thanh Hóa', '22570', 'xa', '42'),
(3030, 'Thiệu Tiến', 'Xã Thiệu Tiến', 'Xã Thiệu Tiến, Tỉnh Thanh Hóa', '22826', 'xa', '42'),
(3031, 'Thiệu Toán', 'Xã Thiệu Toán', 'Xã Thiệu Toán, Tỉnh Thanh Hóa', '23082', 'xa', '42'),
(3032, 'Yên Định', 'Xã Yên Định', 'Xã Yên Định, Tỉnh Thanh Hóa', '23338', 'xa', '42'),
(3033, 'Yên Trường', 'Xã Yên Trường', 'Xã Yên Trường, Tỉnh Thanh Hóa', '23594', 'xa', '42'),
(3034, 'Yên Phú', 'Xã Yên Phú', 'Xã Yên Phú, Tỉnh Thanh Hóa', '23850', 'xa', '42'),
(3035, 'Quý Lộc', 'Xã Quý Lộc', 'Xã Quý Lộc, Tỉnh Thanh Hóa', '24106', 'xa', '42'),
(3036, 'Yên Ninh', 'Xã Yên Ninh', 'Xã Yên Ninh, Tỉnh Thanh Hóa', '24362', 'xa', '42'),
(3037, 'Định Tân', 'Xã Định Tân', 'Xã Định Tân, Tỉnh Thanh Hóa', '24618', 'xa', '42'),
(3038, 'Thọ Xuân', 'Xã Thọ Xuân', 'Xã Thọ Xuân, Tỉnh Thanh Hóa', '24874', 'xa', '42'),
(3039, 'Thọ Long', 'Xã Thọ Long', 'Xã Thọ Long, Tỉnh Thanh Hóa', '25130', 'xa', '42'),
(3040, 'Xuân Hòa', 'Xã Xuân Hòa', 'Xã Xuân Hòa, Tỉnh Thanh Hóa', '25386', 'xa', '42'),
(3041, 'Sao Vàng', 'Xã Sao Vàng', 'Xã Sao Vàng, Tỉnh Thanh Hóa', '25642', 'xa', '42'),
(3042, 'Lam Sơn', 'Xã Lam Sơn', 'Xã Lam Sơn, Tỉnh Thanh Hóa', '25898', 'xa', '42'),
(3043, 'Thọ Lập', 'Xã Thọ Lập', 'Xã Thọ Lập, Tỉnh Thanh Hóa', '26154', 'xa', '42'),
(3044, 'Xuân Tín', 'Xã Xuân Tín', 'Xã Xuân Tín, Tỉnh Thanh Hóa', '26410', 'xa', '42'),
(3045, 'Xuân Lập', 'Xã Xuân Lập', 'Xã Xuân Lập, Tỉnh Thanh Hóa', '26666', 'xa', '42'),
(3046, 'Vĩnh Lộc', 'Xã Vĩnh Lộc', 'Xã Vĩnh Lộc, Tỉnh Thanh Hóa', '26922', 'xa', '42'),
(3047, 'Tây Đô', 'Xã Tây Đô', 'Xã Tây Đô, Tỉnh Thanh Hóa', '27178', 'xa', '42'),
(3048, 'Biện Thượng', 'Xã Biện Thượng', 'Xã Biện Thượng, Tỉnh Thanh Hóa', '27434', 'xa', '42'),
(3049, 'Triệu Sơn', 'Xã Triệu Sơn', 'Xã Triệu Sơn, Tỉnh Thanh Hóa', '27690', 'xa', '42'),
(3050, 'Thọ Bình', 'Xã Thọ Bình', 'Xã Thọ Bình, Tỉnh Thanh Hóa', '27946', 'xa', '42'),
(3051, 'Thọ Ngọc', 'Xã Thọ Ngọc', 'Xã Thọ Ngọc, Tỉnh Thanh Hóa', '28202', 'xa', '42'),
(3052, 'Hợp Tiến', 'Xã Hợp Tiến', 'Xã Hợp Tiến, Tỉnh Thanh Hóa', '28458', 'xa', '42'),
(3053, 'An Nông', 'Xã An Nông', 'Xã An Nông, Tỉnh Thanh Hóa', '28714', 'xa', '42'),
(3054, 'Tân Ninh', 'Xã Tân Ninh', 'Xã Tân Ninh, Tỉnh Thanh Hóa', '28970', 'xa', '42'),
(3055, 'Đồng Tiến', 'Xã Đồng Tiến', 'Xã Đồng Tiến, Tỉnh Thanh Hóa', '29226', 'xa', '42'),
(3056, 'Hồi Xuân', 'Xã Hồi Xuân', 'Xã Hồi Xuân, Tỉnh Thanh Hóa', '29482', 'xa', '42'),
(3057, 'Nam Xuân', 'Xã Nam Xuân', 'Xã Nam Xuân, Tỉnh Thanh Hóa', '29738', 'xa', '42'),
(3058, 'Thiên Phủ', 'Xã Thiên Phủ', 'Xã Thiên Phủ, Tỉnh Thanh Hóa', '29994', 'xa', '42'),
(3059, 'Hiền Kiệt', 'Xã Hiền Kiệt', 'Xã Hiền Kiệt, Tỉnh Thanh Hóa', '30250', 'xa', '42'),
(3060, 'Phú Lệ', 'Xã Phú Lệ', 'Xã Phú Lệ, Tỉnh Thanh Hóa', '30506', 'xa', '42'),
(3061, 'Trung Thành', 'Xã Trung Thành', 'Xã Trung Thành, Tỉnh Thanh Hóa', '30762', 'xa', '42'),
(3062, 'Trung Hạ', 'Xã Trung Hạ', 'Xã Trung Hạ, Tỉnh Thanh Hóa', '31018', 'xa', '42'),
(3063, 'Linh Sơn', 'Xã Linh Sơn', 'Xã Linh Sơn, Tỉnh Thanh Hóa', '31274', 'xa', '42'),
(3064, 'Đồng Lương', 'Xã Đồng Lương', 'Xã Đồng Lương, Tỉnh Thanh Hóa', '31530', 'xa', '42'),
(3065, 'Văn Phú', 'Xã Văn Phú', 'Xã Văn Phú, Tỉnh Thanh Hóa', '31786', 'xa', '42'),
(3066, 'Giao An', 'Xã Giao An', 'Xã Giao An, Tỉnh Thanh Hóa', '32042', 'xa', '42'),
(3067, 'Bá Thước', 'Xã Bá Thước', 'Xã Bá Thước, Tỉnh Thanh Hóa', '32298', 'xa', '42'),
(3068, 'Thiết Ống', 'Xã Thiết Ống', 'Xã Thiết Ống, Tỉnh Thanh Hóa', '32554', 'xa', '42'),
(3069, 'Văn Nho', 'Xã Văn Nho', 'Xã Văn Nho, Tỉnh Thanh Hóa', '32810', 'xa', '42'),
(3070, 'Điền Quang', 'Xã Điền Quang', 'Xã Điền Quang, Tỉnh Thanh Hóa', '33066', 'xa', '42'),
(3071, 'Điền Lư', 'Xã Điền Lư', 'Xã Điền Lư, Tỉnh Thanh Hóa', '33322', 'xa', '42'),
(3072, 'Quý Lương', 'Xã Quý Lương', 'Xã Quý Lương, Tỉnh Thanh Hóa', '33578', 'xa', '42'),
(3073, 'Cổ Lũng', 'Xã Cổ Lũng', 'Xã Cổ Lũng, Tỉnh Thanh Hóa', '33834', 'xa', '42'),
(3074, 'Pù Luông', 'Xã Pù Luông', 'Xã Pù Luông, Tỉnh Thanh Hóa', '34090', 'xa', '42'),
(3075, 'Ngọc Lặc', 'Xã Ngọc Lặc', 'Xã Ngọc Lặc, Tỉnh Thanh Hóa', '34346', 'xa', '42'),
(3076, 'Thạch Lập', 'Xã Thạch Lập', 'Xã Thạch Lập, Tỉnh Thanh Hóa', '34602', 'xa', '42'),
(3077, 'Ngọc Liên', 'Xã Ngọc Liên', 'Xã Ngọc Liên, Tỉnh Thanh Hóa', '34858', 'xa', '42'),
(3078, 'Minh Sơn', 'Xã Minh Sơn', 'Xã Minh Sơn, Tỉnh Thanh Hóa', '35114', 'xa', '42'),
(3079, 'Nguyệt Ấn', 'Xã Nguyệt Ấn', 'Xã Nguyệt Ấn, Tỉnh Thanh Hóa', '35370', 'xa', '42'),
(3080, 'Kiên Thọ', 'Xã Kiên Thọ', 'Xã Kiên Thọ, Tỉnh Thanh Hóa', '35626', 'xa', '42'),
(3081, 'Cẩm Thạch', 'Xã Cẩm Thạch', 'Xã Cẩm Thạch, Tỉnh Thanh Hóa', '35882', 'xa', '42'),
(3082, 'Cẩm Thủy', 'Xã Cẩm Thủy', 'Xã Cẩm Thủy, Tỉnh Thanh Hóa', '36138', 'xa', '42'),
(3083, 'Cẩm Tú', 'Xã Cẩm Tú', 'Xã Cẩm Tú, Tỉnh Thanh Hóa', '36394', 'xa', '42'),
(3084, 'Cẩm Vân', 'Xã Cẩm Vân', 'Xã Cẩm Vân, Tỉnh Thanh Hóa', '36650', 'xa', '42'),
(3085, 'Cẩm Tân', 'Xã Cẩm Tân', 'Xã Cẩm Tân, Tỉnh Thanh Hóa', '36906', 'xa', '42'),
(3086, 'Kim Tân', 'Xã Kim Tân', 'Xã Kim Tân, Tỉnh Thanh Hóa', '37162', 'xa', '42'),
(3087, 'Vân Du', 'Xã Vân Du', 'Xã Vân Du, Tỉnh Thanh Hóa', '37418', 'xa', '42'),
(3088, 'Ngọc Trạo', 'Xã Ngọc Trạo', 'Xã Ngọc Trạo, Tỉnh Thanh Hóa', '37674', 'xa', '42'),
(3089, 'Thạch Bình', 'Xã Thạch Bình', 'Xã Thạch Bình, Tỉnh Thanh Hóa', '37930', 'xa', '42'),
(3090, 'Thành Vinh', 'Xã Thành Vinh', 'Xã Thành Vinh, Tỉnh Thanh Hóa', '38186', 'xa', '42'),
(3091, 'Thạch Quảng', 'Xã Thạch Quảng', 'Xã Thạch Quảng, Tỉnh Thanh Hóa', '38442', 'xa', '42'),
(3092, 'Như Xuân', 'Xã Như Xuân', 'Xã Như Xuân, Tỉnh Thanh Hóa', '38698', 'xa', '42'),
(3093, 'Thượng Ninh', 'Xã Thượng Ninh', 'Xã Thượng Ninh, Tỉnh Thanh Hóa', '38954', 'xa', '42'),
(3094, 'Hóa Quỳ', 'Xã Hóa Quỳ', 'Xã Hóa Quỳ, Tỉnh Thanh Hóa', '39210', 'xa', '42'),
(3095, 'Xuân Bình', 'Xã Xuân Bình', 'Xã Xuân Bình, Tỉnh Thanh Hóa', '39466', 'xa', '42'),
(3096, 'Thanh Phong', 'Xã Thanh Phong', 'Xã Thanh Phong, Tỉnh Thanh Hóa', '39722', 'xa', '42'),
(3097, 'Thanh Quân', 'Xã Thanh Quân', 'Xã Thanh Quân, Tỉnh Thanh Hóa', '39978', 'xa', '42'),
(3098, 'Xuân Du', 'Xã Xuân Du', 'Xã Xuân Du, Tỉnh Thanh Hóa', '40234', 'xa', '42'),
(3099, 'Mậu Lâm', 'Xã Mậu Lâm', 'Xã Mậu Lâm, Tỉnh Thanh Hóa', '40490', 'xa', '42'),
(3100, 'Thường Xuân', 'Xã Thường Xuân', 'Xã Thường Xuân, Tỉnh Thanh Hóa', '40746', 'xa', '42'),
(3101, 'Thắng Lộc', 'Xã Thắng Lộc', 'Xã Thắng Lộc, Tỉnh Thanh Hóa', '41002', 'xa', '42'),
(3102, 'Xuân Chinh', 'Xã Xuân Chinh', 'Xã Xuân Chinh, Tỉnh Thanh Hóa', '41258', 'xa', '42'),
(3103, 'Hạc Thành', 'Phường Hạc Thành', 'Phường Hạc Thành, Tỉnh Thanh Hóa', '41514', 'phuong', '42'),
(3104, 'Hà Trung', 'Xã Hà Trung', 'Xã Hà Trung, Tỉnh Thanh Hóa', '41770', 'xa', '42'),
(3105, 'Thiệu Hóa', 'Xã Thiệu Hóa', 'Xã Thiệu Hóa, Tỉnh Thanh Hóa', '42026', 'xa', '42'),
(3106, 'Quan Sơn', 'Xã Quan Sơn', 'Xã Quan Sơn, Tỉnh Thanh Hóa', '42282', 'xa', '42'),
(3107, 'Như Thanh', 'Xã Như Thanh', 'Xã Như Thanh, Tỉnh Thanh Hóa', '42538', 'xa', '42'),
(3108, 'Ngọc Long', 'Xã Ngọc Long', 'Xã Ngọc Long, Tỉnh Tuyên Quang', '299', 'xa', '43'),
(3109, 'Đồng Văn', 'Xã Đồng Văn', 'Xã Đồng Văn, Tỉnh Tuyên Quang', '555', 'xa', '43'),
(3110, 'Minh Sơn', 'Xã Minh Sơn', 'Xã Minh Sơn, Tỉnh Tuyên Quang', '811', 'xa', '43'),
(3111, 'Giáp Trung', 'Xã Giáp Trung', 'Xã Giáp Trung, Tỉnh Tuyên Quang', '1067', 'xa', '43'),
(3112, 'Hà Giang 2', 'Phường Hà Giang 2', 'Phường Hà Giang 2, Tỉnh Tuyên Quang', '1323', 'phuong', '43'),
(3113, 'Ngọc Đường', 'Xã Ngọc Đường', 'Xã Ngọc Đường, Tỉnh Tuyên Quang', '1579', 'xa', '43'),
(3114, 'Tiên Nguyên', 'Xã Tiên Nguyên', 'Xã Tiên Nguyên, Tỉnh Tuyên Quang', '1835', 'xa', '43'),
(3115, 'Vị Xuyên', 'Xã Vị Xuyên', 'Xã Vị Xuyên, Tỉnh Tuyên Quang', '2091', 'xa', '43'),
(3116, 'Cao Bồ', 'Xã Cao Bồ', 'Xã Cao Bồ, Tỉnh Tuyên Quang', '2347', 'xa', '43'),
(3117, 'Mèo Vạc', 'Xã Mèo Vạc', 'Xã Mèo Vạc, Tỉnh Tuyên Quang', '2603', 'xa', '43'),
(3118, 'Thuận Hòa', 'Xã Thuận Hòa', 'Xã Thuận Hòa, Tỉnh Tuyên Quang', '2859', 'xa', '43'),
(3119, 'Thượng Sơn', 'Xã Thượng Sơn', 'Xã Thượng Sơn, Tỉnh Tuyên Quang', '3115', 'xa', '43'),
(3120, 'Tùng Bá', 'Xã Tùng Bá', 'Xã Tùng Bá, Tỉnh Tuyên Quang', '3371', 'xa', '43'),
(3121, 'Việt Lâm', 'Xã Việt Lâm', 'Xã Việt Lâm, Tỉnh Tuyên Quang', '3627', 'xa', '43'),
(3122, 'Quảng Nguyên', 'Xã Quảng Nguyên', 'Xã Quảng Nguyên, Tỉnh Tuyên Quang', '3883', 'xa', '43'),
(3123, 'Minh Ngọc', 'Xã Minh Ngọc', 'Xã Minh Ngọc, Tỉnh Tuyên Quang', '4139', 'xa', '43'),
(3124, 'Hà Giang 1', 'Phường Hà Giang 1', 'Phường Hà Giang 1, Tỉnh Tuyên Quang', '4395', 'phuong', '43'),
(3125, 'Minh Tân', 'Xã Minh Tân', 'Xã Minh Tân, Tỉnh Tuyên Quang', '4651', 'xa', '43'),
(3126, 'Nông Tiến', 'Phường Nông Tiến', 'Phường Nông Tiến, Tỉnh Tuyên Quang', '4907', 'phuong', '43'),
(3127, 'Minh Xuân', 'Phường Minh Xuân', 'Phường Minh Xuân, Tỉnh Tuyên Quang', '5163', 'phuong', '43'),
(3128, 'Trung Hà', 'Xã Trung Hà', 'Xã Trung Hà, Tỉnh Tuyên Quang', '5419', 'xa', '43'),
(3129, 'Hùng Đức', 'Xã Hùng Đức', 'Xã Hùng Đức, Tỉnh Tuyên Quang', '5675', 'xa', '43'),
(3130, 'Kiến Thiết', 'Xã Kiến Thiết', 'Xã Kiến Thiết, Tỉnh Tuyên Quang', '5931', 'xa', '43'),
(3131, 'Mỹ Lâm', 'Phường Mỹ Lâm', 'Phường Mỹ Lâm, Tỉnh Tuyên Quang', '6187', 'phuong', '43'),
(3132, 'Tân Tiến', 'Xã Tân Tiến', 'Xã Tân Tiến, Tỉnh Tuyên Quang', '6443', 'xa', '43'),
(3133, 'Hoàng Su Phì', 'Xã Hoàng Su Phì', 'Xã Hoàng Su Phì, Tỉnh Tuyên Quang', '6699', 'xa', '43'),
(3134, 'Thàng Tín', 'Xã Thàng Tín', 'Xã Thàng Tín, Tỉnh Tuyên Quang', '6955', 'xa', '43'),
(3135, 'Bản Máy', 'Xã Bản Máy', 'Xã Bản Máy, Tỉnh Tuyên Quang', '7211', 'xa', '43'),
(3136, 'Pờ Ly Ngài', 'Xã Pờ Ly Ngài', 'Xã Pờ Ly Ngài, Tỉnh Tuyên Quang', '7467', 'xa', '43'),
(3137, 'Xín Mần', 'Xã Xín Mần', 'Xã Xín Mần, Tỉnh Tuyên Quang', '7723', 'xa', '43'),
(3138, 'Pà Vầy Sủ', 'Xã Pà Vầy Sủ', 'Xã Pà Vầy Sủ, Tỉnh Tuyên Quang', '7979', 'xa', '43'),
(3139, 'Nấm Dẩn', 'Xã Nấm Dẩn', 'Xã Nấm Dẩn, Tỉnh Tuyên Quang', '8235', 'xa', '43'),
(3140, 'Trung Thịnh', 'Xã Trung Thịnh', 'Xã Trung Thịnh, Tỉnh Tuyên Quang', '8491', 'xa', '43'),
(3141, 'Khuôn Lùng', 'Xã Khuôn Lùng', 'Xã Khuôn Lùng, Tỉnh Tuyên Quang', '8747', 'xa', '43'),
(3142, 'Lũng Cú', 'Xã Lũng Cú', 'Xã Lũng Cú, Tỉnh Tuyên Quang', '9003', 'xa', '43'),
(3143, 'Sà Phìn', 'Xã Sà Phìn', 'Xã Sà Phìn, Tỉnh Tuyên Quang', '9259', 'xa', '43'),
(3144, 'Phố Bảng', 'Xã Phố Bảng', 'Xã Phố Bảng, Tỉnh Tuyên Quang', '9515', 'xa', '43'),
(3145, 'Lũng Phìn', 'Xã Lũng Phìn', 'Xã Lũng Phìn, Tỉnh Tuyên Quang', '9771', 'xa', '43'),
(3146, 'Sủng Máng', 'Xã Sủng Máng', 'Xã Sủng Máng, Tỉnh Tuyên Quang', '10027', 'xa', '43'),
(3147, 'Sơn Vĩ', 'Xã Sơn Vĩ', 'Xã Sơn Vĩ, Tỉnh Tuyên Quang', '10283', 'xa', '43'),
(3148, 'Khâu Vai', 'Xã Khâu Vai', 'Xã Khâu Vai, Tỉnh Tuyên Quang', '10539', 'xa', '43'),
(3149, 'Niêm Sơn', 'Xã Niêm Sơn', 'Xã Niêm Sơn, Tỉnh Tuyên Quang', '10795', 'xa', '43'),
(3150, 'Tát Ngà', 'Xã Tát Ngà', 'Xã Tát Ngà, Tỉnh Tuyên Quang', '11051', 'xa', '43'),
(3151, 'Thắng Mố', 'Xã Thắng Mố', 'Xã Thắng Mố, Tỉnh Tuyên Quang', '11307', 'xa', '43'),
(3152, 'Bạch Đích', 'Xã Bạch Đích', 'Xã Bạch Đích, Tỉnh Tuyên Quang', '11563', 'xa', '43'),
(3153, 'Yên Minh', 'Xã Yên Minh', 'Xã Yên Minh, Tỉnh Tuyên Quang', '11819', 'xa', '43'),
(3154, 'Mậu Duệ', 'Xã Mậu Duệ', 'Xã Mậu Duệ, Tỉnh Tuyên Quang', '12075', 'xa', '43'),
(3155, 'Du Già', 'Xã Du Già', 'Xã Du Già, Tỉnh Tuyên Quang', '12331', 'xa', '43'),
(3156, 'Đường Thượng', 'Xã Đường Thượng', 'Xã Đường Thượng, Tỉnh Tuyên Quang', '12587', 'xa', '43'),
(3157, 'Lùng Tám', 'Xã Lùng Tám', 'Xã Lùng Tám, Tỉnh Tuyên Quang', '12843', 'xa', '43'),
(3158, 'Cán Tỷ', 'Xã Cán Tỷ', 'Xã Cán Tỷ, Tỉnh Tuyên Quang', '13099', 'xa', '43'),
(3159, 'Nghĩa Thuận', 'Xã Nghĩa Thuận', 'Xã Nghĩa Thuận, Tỉnh Tuyên Quang', '13355', 'xa', '43'),
(3160, 'Quản Bạ', 'Xã Quản Bạ', 'Xã Quản Bạ, Tỉnh Tuyên Quang', '13611', 'xa', '43'),
(3161, 'Tùng Vài', 'Xã Tùng Vài', 'Xã Tùng Vài, Tỉnh Tuyên Quang', '13867', 'xa', '43'),
(3162, 'Yên Cường', 'Xã Yên Cường', 'Xã Yên Cường, Tỉnh Tuyên Quang', '14123', 'xa', '43'),
(3163, 'Đường Hồng', 'Xã Đường Hồng', 'Xã Đường Hồng, Tỉnh Tuyên Quang', '14379', 'xa', '43'),
(3164, 'Bắc Mê', 'Xã Bắc Mê', 'Xã Bắc Mê, Tỉnh Tuyên Quang', '14635', 'xa', '43'),
(3165, 'Lao Chải', 'Xã Lao Chải', 'Xã Lao Chải, Tỉnh Tuyên Quang', '14891', 'xa', '43'),
(3166, 'Thanh Thủy', 'Xã Thanh Thủy', 'Xã Thanh Thủy, Tỉnh Tuyên Quang', '15147', 'xa', '43'),
(3167, 'Phú Linh', 'Xã Phú Linh', 'Xã Phú Linh, Tỉnh Tuyên Quang', '15403', 'xa', '43'),
(3168, 'Linh Hồ', 'Xã Linh Hồ', 'Xã Linh Hồ, Tỉnh Tuyên Quang', '15659', 'xa', '43'),
(3169, 'Bạch Ngọc', 'Xã Bạch Ngọc', 'Xã Bạch Ngọc, Tỉnh Tuyên Quang', '15915', 'xa', '43'),
(3170, 'Tân Quang', 'Xã Tân Quang', 'Xã Tân Quang, Tỉnh Tuyên Quang', '16171', 'xa', '43'),
(3171, 'Đồng Tâm', 'Xã Đồng Tâm', 'Xã Đồng Tâm, Tỉnh Tuyên Quang', '16427', 'xa', '43'),
(3172, 'Liên Hiệp', 'Xã Liên Hiệp', 'Xã Liên Hiệp, Tỉnh Tuyên Quang', '16683', 'xa', '43'),
(3173, 'Bằng Hành', 'Xã Bằng Hành', 'Xã Bằng Hành, Tỉnh Tuyên Quang', '16939', 'xa', '43'),
(3174, 'Bắc Quang', 'Xã Bắc Quang', 'Xã Bắc Quang, Tỉnh Tuyên Quang', '17195', 'xa', '43'),
(3175, 'Hùng An', 'Xã Hùng An', 'Xã Hùng An, Tỉnh Tuyên Quang', '17451', 'xa', '43'),
(3176, 'Vĩnh Tuy', 'Xã Vĩnh Tuy', 'Xã Vĩnh Tuy, Tỉnh Tuyên Quang', '17707', 'xa', '43'),
(3177, 'Đồng Yên', 'Xã Đồng Yên', 'Xã Đồng Yên, Tỉnh Tuyên Quang', '17963', 'xa', '43'),
(3178, 'Tiên Yên', 'Xã Tiên Yên', 'Xã Tiên Yên, Tỉnh Tuyên Quang', '18219', 'xa', '43'),
(3179, 'Xuân Giang', 'Xã Xuân Giang', 'Xã Xuân Giang, Tỉnh Tuyên Quang', '18475', 'xa', '43'),
(3180, 'Bằng Lang', 'Xã Bằng Lang', 'Xã Bằng Lang, Tỉnh Tuyên Quang', '18731', 'xa', '43'),
(3181, 'Yên Thành', 'Xã Yên Thành', 'Xã Yên Thành, Tỉnh Tuyên Quang', '18987', 'xa', '43'),
(3182, 'Quang Bình', 'Xã Quang Bình', 'Xã Quang Bình, Tỉnh Tuyên Quang', '19243', 'xa', '43'),
(3183, 'Tân Trịnh', 'Xã Tân Trịnh', 'Xã Tân Trịnh, Tỉnh Tuyên Quang', '19499', 'xa', '43'),
(3184, 'Thông Nguyên', 'Xã Thông Nguyên', 'Xã Thông Nguyên, Tỉnh Tuyên Quang', '19755', 'xa', '43'),
(3185, 'Hồ Thầu', 'Xã Hồ Thầu', 'Xã Hồ Thầu, Tỉnh Tuyên Quang', '20011', 'xa', '43'),
(3186, 'Nậm Dịch', 'Xã Nậm Dịch', 'Xã Nậm Dịch, Tỉnh Tuyên Quang', '20267', 'xa', '43'),
(3187, 'Thái Bình', 'Xã Thái Bình', 'Xã Thái Bình, Tỉnh Tuyên Quang', '20523', 'xa', '43'),
(3188, 'Thượng Lâm', 'Xã Thượng Lâm', 'Xã Thượng Lâm, Tỉnh Tuyên Quang', '20779', 'xa', '43'),
(3189, 'Lâm Bình', 'Xã Lâm Bình', 'Xã Lâm Bình, Tỉnh Tuyên Quang', '21035', 'xa', '43'),
(3190, 'Minh Quang', 'Xã Minh Quang', 'Xã Minh Quang, Tỉnh Tuyên Quang', '21291', 'xa', '43'),
(3191, 'Bình An', 'Xã Bình An', 'Xã Bình An, Tỉnh Tuyên Quang', '21547', 'xa', '43'),
(3192, 'Côn Lôn', 'Xã Côn Lôn', 'Xã Côn Lôn, Tỉnh Tuyên Quang', '21803', 'xa', '43'),
(3193, 'Yên Hoa', 'Xã Yên Hoa', 'Xã Yên Hoa, Tỉnh Tuyên Quang', '22059', 'xa', '43'),
(3194, 'Thượng Nông', 'Xã Thượng Nông', 'Xã Thượng Nông, Tỉnh Tuyên Quang', '22315', 'xa', '43'),
(3195, 'Hồng Thái', 'Xã Hồng Thái', 'Xã Hồng Thái, Tỉnh Tuyên Quang', '22571', 'xa', '43'),
(3196, 'Nà Hang', 'Xã Nà Hang', 'Xã Nà Hang, Tỉnh Tuyên Quang', '22827', 'xa', '43'),
(3197, 'Tân Mỹ', 'Xã Tân Mỹ', 'Xã Tân Mỹ, Tỉnh Tuyên Quang', '23083', 'xa', '43'),
(3198, 'Yên Lập', 'Xã Yên Lập', 'Xã Yên Lập, Tỉnh Tuyên Quang', '23339', 'xa', '43'),
(3199, 'Tân An', 'Xã Tân An', 'Xã Tân An, Tỉnh Tuyên Quang', '23595', 'xa', '43'),
(3200, 'Chiêm Hoá', 'Xã Chiêm Hoá', 'Xã Chiêm Hoá, Tỉnh Tuyên Quang', '23851', 'xa', '43'),
(3201, 'Hoà An', 'Xã Hoà An', 'Xã Hoà An, Tỉnh Tuyên Quang', '24107', 'xa', '43'),
(3202, 'Kiên Đài', 'Xã Kiên Đài', 'Xã Kiên Đài, Tỉnh Tuyên Quang', '24363', 'xa', '43'),
(3203, 'Tri Phú', 'Xã Tri Phú', 'Xã Tri Phú, Tỉnh Tuyên Quang', '24619', 'xa', '43'),
(3204, 'Kim Bình', 'Xã Kim Bình', 'Xã Kim Bình, Tỉnh Tuyên Quang', '24875', 'xa', '43'),
(3205, 'Yên Nguyên', 'Xã Yên Nguyên', 'Xã Yên Nguyên, Tỉnh Tuyên Quang', '25131', 'xa', '43'),
(3206, 'Yên Phú', 'Xã Yên Phú', 'Xã Yên Phú, Tỉnh Tuyên Quang', '25387', 'xa', '43'),
(3207, 'Bạch Xa', 'Xã Bạch Xa', 'Xã Bạch Xa, Tỉnh Tuyên Quang', '25643', 'xa', '43'),
(3208, 'Phù Lưu', 'Xã Phù Lưu', 'Xã Phù Lưu, Tỉnh Tuyên Quang', '25899', 'xa', '43'),
(3209, 'Hàm Yên', 'Xã Hàm Yên', 'Xã Hàm Yên, Tỉnh Tuyên Quang', '26155', 'xa', '43'),
(3210, 'Bình Xa', 'Xã Bình Xa', 'Xã Bình Xa, Tỉnh Tuyên Quang', '26411', 'xa', '43'),
(3211, 'Thái Sơn', 'Xã Thái Sơn', 'Xã Thái Sơn, Tỉnh Tuyên Quang', '26667', 'xa', '43'),
(3212, 'Thái Hoà', 'Xã Thái Hoà', 'Xã Thái Hoà, Tỉnh Tuyên Quang', '26923', 'xa', '43'),
(3213, 'Hùng Lợi', 'Xã Hùng Lợi', 'Xã Hùng Lợi, Tỉnh Tuyên Quang', '27179', 'xa', '43'),
(3214, 'Trung Sơn', 'Xã Trung Sơn', 'Xã Trung Sơn, Tỉnh Tuyên Quang', '27435', 'xa', '43'),
(3215, 'Tân Long', 'Xã Tân Long', 'Xã Tân Long, Tỉnh Tuyên Quang', '27691', 'xa', '43'),
(3216, 'Xuân Vân', 'Xã Xuân Vân', 'Xã Xuân Vân, Tỉnh Tuyên Quang', '27947', 'xa', '43'),
(3217, 'Lực Hành', 'Xã Lực Hành', 'Xã Lực Hành, Tỉnh Tuyên Quang', '28203', 'xa', '43'),
(3218, 'Yên Sơn', 'Xã Yên Sơn', 'Xã Yên Sơn, Tỉnh Tuyên Quang', '28459', 'xa', '43'),
(3219, 'Nhữ Khê', 'Xã Nhữ Khê', 'Xã Nhữ Khê, Tỉnh Tuyên Quang', '28715', 'xa', '43'),
(3220, 'Tân Trào', 'Xã Tân Trào', 'Xã Tân Trào, Tỉnh Tuyên Quang', '28971', 'xa', '43'),
(3221, 'Minh Thanh', 'Xã Minh Thanh', 'Xã Minh Thanh, Tỉnh Tuyên Quang', '29227', 'xa', '43'),
(3222, 'Sơn Dương', 'Xã Sơn Dương', 'Xã Sơn Dương, Tỉnh Tuyên Quang', '29483', 'xa', '43'),
(3223, 'Bình Ca', 'Xã Bình Ca', 'Xã Bình Ca, Tỉnh Tuyên Quang', '29739', 'xa', '43'),
(3224, 'Tân Thanh', 'Xã Tân Thanh', 'Xã Tân Thanh, Tỉnh Tuyên Quang', '29995', 'xa', '43'),
(3225, 'Sơn Thuỷ', 'Xã Sơn Thuỷ', 'Xã Sơn Thuỷ, Tỉnh Tuyên Quang', '30251', 'xa', '43'),
(3226, 'Phú Lương', 'Xã Phú Lương', 'Xã Phú Lương, Tỉnh Tuyên Quang', '30507', 'xa', '43'),
(3227, 'Trường Sinh', 'Xã Trường Sinh', 'Xã Trường Sinh, Tỉnh Tuyên Quang', '30763', 'xa', '43'),
(3228, 'Hồng Sơn', 'Xã Hồng Sơn', 'Xã Hồng Sơn, Tỉnh Tuyên Quang', '31019', 'xa', '43'),
(3229, 'Đông Thọ', 'Xã Đông Thọ', 'Xã Đông Thọ, Tỉnh Tuyên Quang', '31275', 'xa', '43'),
(3230, 'An Tường', 'Phường An Tường', 'Phường An Tường, Tỉnh Tuyên Quang', '31531', 'phuong', '43'),
(3231, 'Bình Thuận', 'Phường Bình Thuận', 'Phường Bình Thuận, Tỉnh Tuyên Quang', '31787', 'phuong', '43'),
(3232, 'Hòa Minh', 'Xã Hòa Minh', 'Xã Hòa Minh, Tỉnh Vĩnh Long', '300', 'xa', '44'),
(3233, 'Long Hòa', 'Xã Long Hòa', 'Xã Long Hòa, Tỉnh Vĩnh Long', '556', 'xa', '44'),
(3234, 'Đông Hải', 'Xã Đông Hải', 'Xã Đông Hải, Tỉnh Vĩnh Long', '812', 'xa', '44'),
(3235, 'Long Hữu', 'Xã Long Hữu', 'Xã Long Hữu, Tỉnh Vĩnh Long', '1068', 'xa', '44'),
(3236, 'Long Vĩnh', 'Xã Long Vĩnh', 'Xã Long Vĩnh, Tỉnh Vĩnh Long', '1324', 'xa', '44'),
(3237, 'Cái Vồn', 'Phường Cái Vồn', 'Phường Cái Vồn, Tỉnh Vĩnh Long', '1580', 'phuong', '44'),
(3238, 'Bình Minh', 'Phường Bình Minh', 'Phường Bình Minh, Tỉnh Vĩnh Long', '1836', 'phuong', '44'),
(3239, 'Tam Bình', 'Xã Tam Bình', 'Xã Tam Bình, Tỉnh Vĩnh Long', '2092', 'xa', '44'),
(3240, 'Ngãi Tứ', 'Xã Ngãi Tứ', 'Xã Ngãi Tứ, Tỉnh Vĩnh Long', '2348', 'xa', '44'),
(3241, 'Trà Ôn', 'Xã Trà Ôn', 'Xã Trà Ôn, Tỉnh Vĩnh Long', '2604', 'xa', '44'),
(3242, 'Trà Côn', 'Xã Trà Côn', 'Xã Trà Côn, Tỉnh Vĩnh Long', '2860', 'xa', '44'),
(3243, 'Cái Nhum', 'Xã Cái Nhum', 'Xã Cái Nhum, Tỉnh Vĩnh Long', '3116', 'xa', '44'),
(3244, 'Tân Long Hội', 'Xã Tân Long Hội', 'Xã Tân Long Hội, Tỉnh Vĩnh Long', '3372', 'xa', '44'),
(3245, 'Nhơn Phú', 'Xã Nhơn Phú', 'Xã Nhơn Phú, Tỉnh Vĩnh Long', '3628', 'xa', '44'),
(3246, 'Bình Phước', 'Xã Bình Phước', 'Xã Bình Phước, Tỉnh Vĩnh Long', '3884', 'xa', '44'),
(3247, 'An Bình', 'Xã An Bình', 'Xã An Bình, Tỉnh Vĩnh Long', '4140', 'xa', '44'),
(3248, 'Long Hồ', 'Xã Long Hồ', 'Xã Long Hồ, Tỉnh Vĩnh Long', '4396', 'xa', '44'),
(3249, 'Phú Quới', 'Xã Phú Quới', 'Xã Phú Quới, Tỉnh Vĩnh Long', '4652', 'xa', '44'),
(3250, 'Thanh Đức', 'Phường Thanh Đức', 'Phường Thanh Đức, Tỉnh Vĩnh Long', '4908', 'phuong', '44'),
(3251, 'Long Châu', 'Phường Long Châu', 'Phường Long Châu, Tỉnh Vĩnh Long', '5164', 'phuong', '44'),
(3252, 'Phước Hậu', 'Phường Phước Hậu', 'Phường Phước Hậu, Tỉnh Vĩnh Long', '5420', 'phuong', '44'),
(3253, 'Tân Hạnh', 'Phường Tân Hạnh', 'Phường Tân Hạnh, Tỉnh Vĩnh Long', '5676', 'phuong', '44'),
(3254, 'Tân Ngãi', 'Phường Tân Ngãi', 'Phường Tân Ngãi, Tỉnh Vĩnh Long', '5932', 'phuong', '44'),
(3255, 'Quới Thiện', 'Xã Quới Thiện', 'Xã Quới Thiện, Tỉnh Vĩnh Long', '6188', 'xa', '44'),
(3256, 'Trung Thành', 'Xã Trung Thành', 'Xã Trung Thành, Tỉnh Vĩnh Long', '6444', 'xa', '44'),
(3257, 'Trung Ngãi', 'Xã Trung Ngãi', 'Xã Trung Ngãi, Tỉnh Vĩnh Long', '6700', 'xa', '44'),
(3258, 'Quới An', 'Xã Quới An', 'Xã Quới An, Tỉnh Vĩnh Long', '6956', 'xa', '44'),
(3259, 'Trung Hiệp', 'Xã Trung Hiệp', 'Xã Trung Hiệp, Tỉnh Vĩnh Long', '7212', 'xa', '44'),
(3260, 'Hiếu Phụng', 'Xã Hiếu Phụng', 'Xã Hiếu Phụng, Tỉnh Vĩnh Long', '7468', 'xa', '44'),
(3261, 'Hiếu Thành', 'Xã Hiếu Thành', 'Xã Hiếu Thành, Tỉnh Vĩnh Long', '7724', 'xa', '44'),
(3262, 'Lục Sỹ Thành', 'Xã Lục Sỹ Thành', 'Xã Lục Sỹ Thành, Tỉnh Vĩnh Long', '7980', 'xa', '44'),
(3263, 'Vĩnh Xuân', 'Xã Vĩnh Xuân', 'Xã Vĩnh Xuân, Tỉnh Vĩnh Long', '8236', 'xa', '44'),
(3264, 'Hòa Bình', 'Xã Hòa Bình', 'Xã Hòa Bình, Tỉnh Vĩnh Long', '8492', 'xa', '44'),
(3265, 'Hòa Hiệp', 'Xã Hòa Hiệp', 'Xã Hòa Hiệp, Tỉnh Vĩnh Long', '8748', 'xa', '44'),
(3266, 'Song Phú', 'Xã Song Phú', 'Xã Song Phú, Tỉnh Vĩnh Long', '9004', 'xa', '44'),
(3267, 'Cái Ngang', 'Xã Cái Ngang', 'Xã Cái Ngang, Tỉnh Vĩnh Long', '9260', 'xa', '44'),
(3268, 'Tân Quới', 'Xã Tân Quới', 'Xã Tân Quới, Tỉnh Vĩnh Long', '9516', 'xa', '44'),
(3269, 'Tân Lược', 'Xã Tân Lược', 'Xã Tân Lược, Tỉnh Vĩnh Long', '9772', 'xa', '44'),
(3270, 'Mỹ Thuận', 'Xã Mỹ Thuận', 'Xã Mỹ Thuận, Tỉnh Vĩnh Long', '10028', 'xa', '44'),
(3271, 'Đông Thành', 'Phường Đông Thành', 'Phường Đông Thành, Tỉnh Vĩnh Long', '10284', 'phuong', '44'),
(3272, 'Trà Vinh', 'Phường Trà Vinh', 'Phường Trà Vinh, Tỉnh Vĩnh Long', '10540', 'phuong', '44'),
(3273, 'Long Đức', 'Phường Long Đức', 'Phường Long Đức, Tỉnh Vĩnh Long', '10796', 'phuong', '44'),
(3274, 'Nguyệt Hóa', 'Phường Nguyệt Hóa', 'Phường Nguyệt Hóa, Tỉnh Vĩnh Long', '11052', 'phuong', '44'),
(3275, 'Hòa Thuận', 'Phường Hòa Thuận', 'Phường Hòa Thuận, Tỉnh Vĩnh Long', '11308', 'phuong', '44'),
(3276, 'Càng Long', 'Xã Càng Long', 'Xã Càng Long, Tỉnh Vĩnh Long', '11564', 'xa', '44'),
(3277, 'An Trường', 'Xã An Trường', 'Xã An Trường, Tỉnh Vĩnh Long', '11820', 'xa', '44'),
(3278, 'Tân An', 'Xã Tân An', 'Xã Tân An, Tỉnh Vĩnh Long', '12076', 'xa', '44'),
(3279, 'Nhị Long', 'Xã Nhị Long', 'Xã Nhị Long, Tỉnh Vĩnh Long', '12332', 'xa', '44'),
(3280, 'Bình Phú', 'Xã Bình Phú', 'Xã Bình Phú, Tỉnh Vĩnh Long', '12588', 'xa', '44'),
(3281, 'Châu Thành', 'Xã Châu Thành', 'Xã Châu Thành, Tỉnh Vĩnh Long', '12844', 'xa', '44'),
(3282, 'Song Lộc', 'Xã Song Lộc', 'Xã Song Lộc, Tỉnh Vĩnh Long', '13100', 'xa', '44'),
(3283, 'Hưng Mỹ', 'Xã Hưng Mỹ', 'Xã Hưng Mỹ, Tỉnh Vĩnh Long', '13356', 'xa', '44'),
(3284, 'Cầu Kè', 'Xã Cầu Kè', 'Xã Cầu Kè, Tỉnh Vĩnh Long', '13612', 'xa', '44'),
(3285, 'Phong Thạnh', 'Xã Phong Thạnh', 'Xã Phong Thạnh, Tỉnh Vĩnh Long', '13868', 'xa', '44'),
(3286, 'An Phú Tân', 'Xã An Phú Tân', 'Xã An Phú Tân, Tỉnh Vĩnh Long', '14124', 'xa', '44'),
(3287, 'Tam Ngãi', 'Xã Tam Ngãi', 'Xã Tam Ngãi, Tỉnh Vĩnh Long', '14380', 'xa', '44'),
(3288, 'Tiểu Cần', 'Xã Tiểu Cần', 'Xã Tiểu Cần, Tỉnh Vĩnh Long', '14636', 'xa', '44'),
(3289, 'Tân Hòa', 'Xã Tân Hòa', 'Xã Tân Hòa, Tỉnh Vĩnh Long', '14892', 'xa', '44'),
(3290, 'Hùng Hòa', 'Xã Hùng Hòa', 'Xã Hùng Hòa, Tỉnh Vĩnh Long', '15148', 'xa', '44'),
(3291, 'Tập Ngãi', 'Xã Tập Ngãi', 'Xã Tập Ngãi, Tỉnh Vĩnh Long', '15404', 'xa', '44'),
(3292, 'Cầu Ngang', 'Xã Cầu Ngang', 'Xã Cầu Ngang, Tỉnh Vĩnh Long', '15660', 'xa', '44'),
(3293, 'Mỹ Long', 'Xã Mỹ Long', 'Xã Mỹ Long, Tỉnh Vĩnh Long', '15916', 'xa', '44'),
(3294, 'Vinh Kim', 'Xã Vinh Kim', 'Xã Vinh Kim, Tỉnh Vĩnh Long', '16172', 'xa', '44'),
(3295, 'Nhị Trường', 'Xã Nhị Trường', 'Xã Nhị Trường, Tỉnh Vĩnh Long', '16428', 'xa', '44'),
(3296, 'Hiệp Mỹ', 'Xã Hiệp Mỹ', 'Xã Hiệp Mỹ, Tỉnh Vĩnh Long', '16684', 'xa', '44'),
(3297, 'Trà Cú', 'Xã Trà Cú', 'Xã Trà Cú, Tỉnh Vĩnh Long', '16940', 'xa', '44'),
(3298, 'Đại An', 'Xã Đại An', 'Xã Đại An, Tỉnh Vĩnh Long', '17196', 'xa', '44'),
(3299, 'Lưu Nghiệp Anh', 'Xã Lưu Nghiệp Anh', 'Xã Lưu Nghiệp Anh, Tỉnh Vĩnh Long', '17452', 'xa', '44'),
(3300, 'Hàm Giang', 'Xã Hàm Giang', 'Xã Hàm Giang, Tỉnh Vĩnh Long', '17708', 'xa', '44'),
(3301, 'Long Hiệp', 'Xã Long Hiệp', 'Xã Long Hiệp, Tỉnh Vĩnh Long', '17964', 'xa', '44'),
(3302, 'Tập Sơn', 'Xã Tập Sơn', 'Xã Tập Sơn, Tỉnh Vĩnh Long', '18220', 'xa', '44'),
(3303, 'Duyên Hải', 'Phường Duyên Hải', 'Phường Duyên Hải, Tỉnh Vĩnh Long', '18476', 'phuong', '44'),
(3304, 'Trường Long Hòa', 'Phường Trường Long Hòa', 'Phường Trường Long Hòa, Tỉnh Vĩnh Long', '18732', 'phuong', '44'),
(3305, 'Long Thành', 'Xã Long Thành', 'Xã Long Thành, Tỉnh Vĩnh Long', '18988', 'xa', '44'),
(3306, 'Đôn Châu', 'Xã Đôn Châu', 'Xã Đôn Châu, Tỉnh Vĩnh Long', '19244', 'xa', '44'),
(3307, 'Ngũ Lạc', 'Xã Ngũ Lạc', 'Xã Ngũ Lạc, Tỉnh Vĩnh Long', '19500', 'xa', '44'),
(3308, 'An Hội', 'Phường An Hội', 'Phường An Hội, Tỉnh Vĩnh Long', '19756', 'phuong', '44'),
(3309, 'Phú Khương', 'Phường Phú Khương', 'Phường Phú Khương, Tỉnh Vĩnh Long', '20012', 'phuong', '44'),
(3310, 'Bến Tre', 'Phường Bến Tre', 'Phường Bến Tre, Tỉnh Vĩnh Long', '20268', 'phuong', '44'),
(3311, 'Sơn Đông', 'Phường Sơn Đông', 'Phường Sơn Đông, Tỉnh Vĩnh Long', '20524', 'phuong', '44'),
(3312, 'Phú Tân', 'Phường Phú Tân', 'Phường Phú Tân, Tỉnh Vĩnh Long', '20780', 'phuong', '44'),
(3313, 'Phú Túc', 'Xã Phú Túc', 'Xã Phú Túc, Tỉnh Vĩnh Long', '21036', 'xa', '44'),
(3314, 'Giao Long', 'Xã Giao Long', 'Xã Giao Long, Tỉnh Vĩnh Long', '21292', 'xa', '44'),
(3315, 'Tiên Thủy', 'Xã Tiên Thủy', 'Xã Tiên Thủy, Tỉnh Vĩnh Long', '21548', 'xa', '44'),
(3316, 'Tân Phú', 'Xã Tân Phú', 'Xã Tân Phú, Tỉnh Vĩnh Long', '21804', 'xa', '44'),
(3317, 'Phú Phụng', 'Xã Phú Phụng', 'Xã Phú Phụng, Tỉnh Vĩnh Long', '22060', 'xa', '44'),
(3318, 'Chợ Lách', 'Xã Chợ Lách', 'Xã Chợ Lách, Tỉnh Vĩnh Long', '22316', 'xa', '44'),
(3319, 'Vĩnh Thành', 'Xã Vĩnh Thành', 'Xã Vĩnh Thành, Tỉnh Vĩnh Long', '22572', 'xa', '44'),
(3320, 'Hưng Khánh Trung', 'Xã Hưng Khánh Trung', 'Xã Hưng Khánh Trung, Tỉnh Vĩnh Long', '22828', 'xa', '44'),
(3321, 'Phước Mỹ Trung', 'Xã Phước Mỹ Trung', 'Xã Phước Mỹ Trung, Tỉnh Vĩnh Long', '23084', 'xa', '44'),
(3322, 'Tân Thành Bình', 'Xã Tân Thành Bình', 'Xã Tân Thành Bình, Tỉnh Vĩnh Long', '23340', 'xa', '44'),
(3323, 'Nhuận Phú Tân', 'Xã Nhuận Phú Tân', 'Xã Nhuận Phú Tân, Tỉnh Vĩnh Long', '23596', 'xa', '44'),
(3324, 'Đồng Khởi', 'Xã Đồng Khởi', 'Xã Đồng Khởi, Tỉnh Vĩnh Long', '23852', 'xa', '44'),
(3325, 'Mỏ Cày', 'Xã Mỏ Cày', 'Xã Mỏ Cày, Tỉnh Vĩnh Long', '24108', 'xa', '44'),
(3326, 'Thành Thới', 'Xã Thành Thới', 'Xã Thành Thới, Tỉnh Vĩnh Long', '24364', 'xa', '44'),
(3327, 'An Định', 'Xã An Định', 'Xã An Định, Tỉnh Vĩnh Long', '24620', 'xa', '44'),
(3328, 'Hương Mỹ', 'Xã Hương Mỹ', 'Xã Hương Mỹ, Tỉnh Vĩnh Long', '24876', 'xa', '44'),
(3329, 'Đại Điền', 'Xã Đại Điền', 'Xã Đại Điền, Tỉnh Vĩnh Long', '25132', 'xa', '44'),
(3330, 'Quới Điền', 'Xã Quới Điền', 'Xã Quới Điền, Tỉnh Vĩnh Long', '25388', 'xa', '44'),
(3331, 'Thạnh Phú', 'Xã Thạnh Phú', 'Xã Thạnh Phú, Tỉnh Vĩnh Long', '25644', 'xa', '44'),
(3332, 'An Qui', 'Xã An Qui', 'Xã An Qui, Tỉnh Vĩnh Long', '25900', 'xa', '44'),
(3333, 'Thạnh Hải', 'Xã Thạnh Hải', 'Xã Thạnh Hải, Tỉnh Vĩnh Long', '26156', 'xa', '44'),
(3334, 'Thạnh Phong', 'Xã Thạnh Phong', 'Xã Thạnh Phong, Tỉnh Vĩnh Long', '26412', 'xa', '44'),
(3335, 'Tân Thủy', 'Xã Tân Thủy', 'Xã Tân Thủy, Tỉnh Vĩnh Long', '26668', 'xa', '44'),
(3336, 'Bảo Thạnh', 'Xã Bảo Thạnh', 'Xã Bảo Thạnh, Tỉnh Vĩnh Long', '26924', 'xa', '44'),
(3337, 'Ba Tri', 'Xã Ba Tri', 'Xã Ba Tri, Tỉnh Vĩnh Long', '27180', 'xa', '44'),
(3338, 'Tân Xuân', 'Xã Tân Xuân', 'Xã Tân Xuân, Tỉnh Vĩnh Long', '27436', 'xa', '44'),
(3339, 'Mỹ Chánh Hòa', 'Xã Mỹ Chánh Hòa', 'Xã Mỹ Chánh Hòa, Tỉnh Vĩnh Long', '27692', 'xa', '44'),
(3340, 'An Ngãi Trung', 'Xã An Ngãi Trung', 'Xã An Ngãi Trung, Tỉnh Vĩnh Long', '27948', 'xa', '44'),
(3341, 'An Hiệp', 'Xã An Hiệp', 'Xã An Hiệp, Tỉnh Vĩnh Long', '28204', 'xa', '44'),
(3342, 'Hưng Nhượng', 'Xã Hưng Nhượng', 'Xã Hưng Nhượng, Tỉnh Vĩnh Long', '28460', 'xa', '44'),
(3343, 'Giồng Trôm', 'Xã Giồng Trôm', 'Xã Giồng Trôm, Tỉnh Vĩnh Long', '28716', 'xa', '44'),
(3344, 'Tân Hào', 'Xã Tân Hào', 'Xã Tân Hào, Tỉnh Vĩnh Long', '28972', 'xa', '44'),
(3345, 'Phước Long', 'Xã Phước Long', 'Xã Phước Long, Tỉnh Vĩnh Long', '29228', 'xa', '44'),
(3346, 'Lương Phú', 'Xã Lương Phú', 'Xã Lương Phú, Tỉnh Vĩnh Long', '29484', 'xa', '44'),
(3347, 'Châu Hòa', 'Xã Châu Hòa', 'Xã Châu Hòa, Tỉnh Vĩnh Long', '29740', 'xa', '44'),
(3348, 'Lương Hòa', 'Xã Lương Hòa', 'Xã Lương Hòa, Tỉnh Vĩnh Long', '29996', 'xa', '44'),
(3349, 'Thới Thuận', 'Xã Thới Thuận', 'Xã Thới Thuận, Tỉnh Vĩnh Long', '30252', 'xa', '44'),
(3350, 'Thạnh Phước', 'Xã Thạnh Phước', 'Xã Thạnh Phước, Tỉnh Vĩnh Long', '30508', 'xa', '44'),
(3351, 'Bình Đại', 'Xã Bình Đại', 'Xã Bình Đại, Tỉnh Vĩnh Long', '30764', 'xa', '44'),
(3352, 'Thạnh Trị', 'Xã Thạnh Trị', 'Xã Thạnh Trị, Tỉnh Vĩnh Long', '31020', 'xa', '44'),
(3353, 'Lộc Thuận', 'Xã Lộc Thuận', 'Xã Lộc Thuận, Tỉnh Vĩnh Long', '31276', 'xa', '44'),
(3354, 'Châu Hưng', 'Xã Châu Hưng', 'Xã Châu Hưng, Tỉnh Vĩnh Long', '31532', 'xa', '44'),
(3355, 'Phú Thuận', 'Xã Phú Thuận', 'Xã Phú Thuận, Tỉnh Vĩnh Long', '31788', 'xa', '44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `volunteer_activities`
--

CREATE TABLE `volunteer_activities` (
  `activity_id` bigint(20) UNSIGNED NOT NULL,
  `volunteer_id` bigint(20) UNSIGNED NOT NULL,
  `opportunity_id` bigint(20) UNSIGNED NOT NULL,
  `org_id` varchar(50) NOT NULL,
  `activity_date` date NOT NULL,
  `hours_worked` decimal(4,2) NOT NULL,
  `activity_description` text DEFAULT NULL,
  `status` enum('Pending','Verified','Disputed') NOT NULL DEFAULT 'Pending',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_date` timestamp NULL DEFAULT NULL,
  `impact_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `volunteer_opportunities`
--

CREATE TABLE `volunteer_opportunities` (
  `opportunity_id` bigint(20) UNSIGNED NOT NULL,
  `org_id` varchar(50) NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `requirements` text DEFAULT NULL,
  `benefits` text DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `time_commitment` enum('1-2 hours','3-5 hours','6-8 hours','Full day','Multiple days') DEFAULT NULL,
  `schedule_type` enum('One-time','Weekly','Monthly','Flexible') DEFAULT NULL,
  `volunteers_needed` int(11) NOT NULL DEFAULT 1,
  `volunteers_registered` int(11) NOT NULL DEFAULT 0,
  `min_age` int(11) NOT NULL DEFAULT 16,
  `required_skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`required_skills`)),
  `experience_needed` enum('No experience','Some experience','Experienced') NOT NULL DEFAULT 'No experience',
  `status` enum('Active','Paused','Completed','Cancelled') NOT NULL DEFAULT 'Active',
  `application_deadline` date DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `application_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `volunteer_profiles`
--

CREATE TABLE `volunteer_profiles` (
  `profile_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `occupation` varchar(100) DEFAULT NULL,
  `education_level` enum('High School','Diploma','Bachelor','Master','PhD') DEFAULT NULL,
  `university` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `skills` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`skills`)),
  `interests` text DEFAULT NULL,
  `availability` enum('Weekdays','Weekends','Flexible','Full-time') DEFAULT NULL,
  `volunteer_experience` text DEFAULT NULL,
  `total_volunteer_hours` int(11) NOT NULL DEFAULT 0,
  `volunteer_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `preferred_location` varchar(100) DEFAULT NULL,
  `transportation` enum('Motorbike','Car','Public Transport','Walking') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`application_id`),
  ADD UNIQUE KEY `applications_opportunity_id_volunteer_id_unique` (`opportunity_id`,`volunteer_id`),
  ADD KEY `applications_volunteer_id_status_index` (`volunteer_id`,`status`),
  ADD KEY `applications_opportunity_id_status_index` (`opportunity_id`,`status`),
  ADD KEY `applications_status_applied_date_index` (`status`,`applied_date`),
  ADD KEY `idx_status_applied_date` (`status`,`applied_date`),
  ADD KEY `idx_opportunity` (`opportunity_id`),
  ADD KEY `idx_volunteer` (`volunteer_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`);

--
-- Chỉ mục cho bảng `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`connection_id`),
  ADD UNIQUE KEY `unique_connection` (`user_id`,`friend_id`),
  ADD KEY `connections_action_user_id_foreign` (`action_user_id`),
  ADD KEY `connections_user_id_status_index` (`user_id`,`status`),
  ADD KEY `connections_friend_id_status_index` (`friend_id`,`status`);

--
-- Chỉ mục cho bảng `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`),
  ADD KEY `conversations_opportunity_id_foreign` (`opportunity_id`),
  ADD KEY `conversations_created_by_foreign` (`created_by`),
  ADD KEY `conversations_last_message_at_index` (`last_message_at`);

--
-- Chỉ mục cho bảng `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD UNIQUE KEY `conversation_participants_conversation_id_user_id_unique` (`conversation_id`,`user_id`),
  ADD KEY `conversation_participants_user_id_unread_count_index` (`user_id`,`unread_count`);

--
-- Chỉ mục cho bảng `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donations_campaign_id_foreign` (`campaign_id`),
  ADD KEY `donations_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_campaigns_admin_user_id_foreign` (`admin_user_id`);

--
-- Chỉ mục cho bảng `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_logs_sent_by_foreign` (`sent_by`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `favorites_user_id_opportunity_id_unique` (`user_id`,`opportunity_id`),
  ADD KEY `favorites_opportunity_id_foreign` (`opportunity_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_conversation_id_sent_at_index` (`conversation_id`,`sent_at`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notifications_user_id_is_read_created_at_index` (`user_id`,`is_read`,`created_at`);

--
-- Chỉ mục cho bảng `organizations`
--
ALTER TABLE `organizations`
  ADD PRIMARY KEY (`org_id`),
  ADD KEY `organizations_user_id_foreign` (`user_id`),
  ADD KEY `organizations_verification_status_index` (`verification_status`),
  ADD KEY `organizations_rating_index` (`rating`),
  ADD KEY `idx_verification_created` (`verification_status`,`created_at`),
  ADD KEY `idx_volunteer_count` (`volunteer_count`);
ALTER TABLE `organizations` ADD FULLTEXT KEY `organizations_organization_name_description_fulltext` (`organization_name`,`description`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `posts_status_published_at_index` (`status`,`published_at`),
  ADD KEY `posts_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `posts_is_pinned_index` (`is_pinned`);

--
-- Chỉ mục cho bảng `post_bookmarks`
--
ALTER TABLE `post_bookmarks`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD UNIQUE KEY `post_bookmarks_post_id_user_id_unique` (`post_id`,`user_id`),
  ADD KEY `post_bookmarks_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_comments_post_id_created_at_index` (`post_id`,`created_at`),
  ADD KEY `post_comments_user_id_index` (`user_id`),
  ADD KEY `post_comments_parent_id_index` (`parent_id`);

--
-- Chỉ mục cho bảng `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `post_likes_post_id_user_id_unique` (`post_id`,`user_id`),
  ADD KEY `post_likes_user_id_index` (`user_id`);

--
-- Chỉ mục cho bảng `post_media`
--
ALTER TABLE `post_media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_media_post_id_foreign` (`post_id`);

--
-- Chỉ mục cho bảng `post_reports`
--
ALTER TABLE `post_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `post_reports_status_created_at_index` (`status`,`created_at`),
  ADD KEY `post_reports_post_id_index` (`post_id`),
  ADD KEY `post_reports_reporter_id_index` (`reporter_id`);

--
-- Chỉ mục cho bảng `post_shares`
--
ALTER TABLE `post_shares`
  ADD PRIMARY KEY (`share_id`),
  ADD KEY `post_shares_user_id_foreign` (`user_id`),
  ADD KEY `post_shares_post_id_created_at_index` (`post_id`,`created_at`);

--
-- Chỉ mục cho bảng `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `reviews_reviewer_id_reviewee_id_opportunity_id_unique` (`reviewer_id`,`reviewee_id`,`opportunity_id`),
  ADD KEY `reviews_reviewee_id_foreign` (`reviewee_id`),
  ADD KEY `reviews_opportunity_id_foreign` (`opportunity_id`),
  ADD KEY `reviews_rating_index` (`rating`),
  ADD KEY `reviews_is_approved_created_at_index` (`is_approved`,`created_at`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `system_analytics`
--
ALTER TABLE `system_analytics`
  ADD PRIMARY KEY (`analytics_id`),
  ADD UNIQUE KEY `system_analytics_metric_name_record_date_category_unique` (`metric_name`,`record_date`,`category`),
  ADD KEY `system_analytics_record_date_category_index` (`record_date`,`category`);

--
-- Chỉ mục cho bảng `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`),
  ADD KEY `tags_slug_index` (`slug`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_user_type_index` (`user_type`),
  ADD KEY `users_city_district_index` (`city`,`district`),
  ADD KEY `users_is_active_is_verified_index` (`is_active`,`is_verified`),
  ADD KEY `users_user_type_is_verified_is_active_index` (`user_type`,`is_verified`,`is_active`),
  ADD KEY `users_created_at_index` (`created_at`),
  ADD KEY `users_last_login_at_index` (`last_login_at`),
  ADD KEY `idx_type_created` (`user_type`,`created_at`),
  ADD KEY `idx_active_type` (`is_active`,`user_type`),
  ADD KEY `users_last_activity_at_index` (`last_activity_at`),
  ADD KEY `users_reset_password_token_index` (`reset_password_token`);

--
-- Chỉ mục cho bảng `video_calls`
--
ALTER TABLE `video_calls`
  ADD PRIMARY KEY (`call_id`),
  ADD UNIQUE KEY `video_calls_room_id_unique` (`room_id`),
  ADD KEY `video_calls_conversation_id_foreign` (`conversation_id`),
  ADD KEY `video_calls_initiated_by_foreign` (`initiated_by`);

--
-- Chỉ mục cho bảng `vn_locations`
--
ALTER TABLE `vn_locations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vn_locations_code_unique` (`code`),
  ADD KEY `vn_locations_parent_code_index` (`parent_code`);

--
-- Chỉ mục cho bảng `volunteer_activities`
--
ALTER TABLE `volunteer_activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `volunteer_activities_opportunity_id_foreign` (`opportunity_id`),
  ADD KEY `volunteer_activities_verified_by_foreign` (`verified_by`),
  ADD KEY `volunteer_activities_volunteer_id_activity_date_index` (`volunteer_id`,`activity_date`),
  ADD KEY `volunteer_activities_status_index` (`status`),
  ADD KEY `volunteer_activities_status_activity_date_index` (`status`,`activity_date`),
  ADD KEY `volunteer_activities_verified_date_index` (`verified_date`),
  ADD KEY `idx_status_activity_date` (`status`,`activity_date`),
  ADD KEY `idx_org_status` (`org_id`,`status`),
  ADD KEY `idx_volunteer_status` (`volunteer_id`,`status`);

--
-- Chỉ mục cho bảng `volunteer_opportunities`
--
ALTER TABLE `volunteer_opportunities`
  ADD PRIMARY KEY (`opportunity_id`),
  ADD KEY `volunteer_opportunities_status_start_date_index` (`status`,`start_date`),
  ADD KEY `volunteer_opportunities_location_index` (`location`),
  ADD KEY `volunteer_opportunities_category_id_index` (`category_id`),
  ADD KEY `idx_status_created` (`status`,`created_at`),
  ADD KEY `idx_org_status` (`org_id`,`status`),
  ADD KEY `idx_category` (`category_id`);
ALTER TABLE `volunteer_opportunities` ADD FULLTEXT KEY `volunteer_opportunities_title_description_fulltext` (`title`,`description`);

--
-- Chỉ mục cho bảng `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `volunteer_profiles_user_id_foreign` (`user_id`),
  ADD KEY `volunteer_profiles_volunteer_rating_index` (`volunteer_rating`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `connections`
--
ALTER TABLE `connections`
  MODIFY `connection_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `participant_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `donations`
--
ALTER TABLE `donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_bookmarks`
--
ALTER TABLE `post_bookmarks`
  MODIFY `bookmark_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `like_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_media`
--
ALTER TABLE `post_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_reports`
--
ALTER TABLE `post_reports`
  MODIFY `report_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_shares`
--
ALTER TABLE `post_shares`
  MODIFY `share_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `system_analytics`
--
ALTER TABLE `system_analytics`
  MODIFY `analytics_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `video_calls`
--
ALTER TABLE `video_calls`
  MODIFY `call_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vn_locations`
--
ALTER TABLE `vn_locations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3356;

--
-- AUTO_INCREMENT cho bảng `volunteer_activities`
--
ALTER TABLE `volunteer_activities`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `volunteer_opportunities`
--
ALTER TABLE `volunteer_opportunities`
  MODIFY `opportunity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  MODIFY `profile_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `connections`
--
ALTER TABLE `connections`
  ADD CONSTRAINT `connections_action_user_id_foreign` FOREIGN KEY (`action_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `connections_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `connections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD CONSTRAINT `conversation_participants_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `donation_campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  ADD CONSTRAINT `donation_campaigns_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `email_logs`
--
ALTER TABLE `email_logs`
  ADD CONSTRAINT `email_logs_sent_by_foreign` FOREIGN KEY (`sent_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_bookmarks`
--
ALTER TABLE `post_bookmarks`
  ADD CONSTRAINT `post_bookmarks_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `post_comments` (`comment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_media`
--
ALTER TABLE `post_media`
  ADD CONSTRAINT `post_media_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_shares`
--
ALTER TABLE `post_shares`
  ADD CONSTRAINT `post_shares_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_reviewee_id_foreign` FOREIGN KEY (`reviewee_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `video_calls`
--
ALTER TABLE `video_calls`
  ADD CONSTRAINT `video_calls_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_calls_initiated_by_foreign` FOREIGN KEY (`initiated_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `volunteer_activities`
--
ALTER TABLE `volunteer_activities`
  ADD CONSTRAINT `volunteer_activities_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_activities_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`org_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_activities_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `volunteer_activities_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `volunteer_opportunities`
--
ALTER TABLE `volunteer_opportunities`
  ADD CONSTRAINT `volunteer_opportunities_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `volunteer_opportunities_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`org_id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  ADD CONSTRAINT `volunteer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

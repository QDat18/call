-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 09, 2025 lúc 03:41 PM
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

--
-- Đang đổ dữ liệu cho bảng `applications`
--

INSERT INTO `applications` (`application_id`, `opportunity_id`, `volunteer_id`, `motivation_letter`, `relevant_experience`, `availability_note`, `status`, `applied_date`, `reviewed_date`, `organization_notes`, `interview_scheduled`, `created_at`, `updated_at`) VALUES
(1, 1, 20, 'Earum expedita quae eveniet harum id est. Fugit exercitationem est quibusdam molestiae optio illum enim. Qui odio iste officia porro omnis dignissimos.', 'Eos esse illum minima. Ut expedita ut laudantium magnam atque non eos. Distinctio quaerat sint cupiditate dolor molestias reprehenderit.', NULL, 'Withdrawn', '2025-11-21 00:13:21', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(2, 1, 42, 'Recusandae qui sed assumenda quia. Laudantium sed sit deleniti beatae ex qui. Fugiat expedita maiores nobis ducimus consequatur iure nobis nostrum.', 'Ut sequi quasi nihil qui minima repudiandae a. Eum quos aliquid voluptatem consequatur maxime qui. Sit rerum nihil cupiditate amet odio sed rem.', 'Nam culpa ab excepturi voluptatem.', 'Rejected', '2025-11-10 00:02:57', '2025-11-19 22:37:05', NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(3, 3, 16, 'Magni et alias neque similique. Eveniet dolorem quibusdam et libero placeat asperiores et et. Eaque quod consectetur et iste. Ut dolorum placeat hic animi et libero harum. Et saepe et id id aut ipsam.', NULL, NULL, 'Withdrawn', '2025-11-12 19:49:28', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(4, 3, 35, 'Blanditiis molestias non consequatur aut totam sint. Eius est itaque soluta est quia. Mollitia et dolore quia nihil. Et voluptatibus odit adipisci dolorem est perferendis quae. Animi numquam velit ea non provident.', NULL, NULL, 'Accepted', '2025-11-21 18:59:08', '2025-11-30 17:48:09', 'Voluptas voluptas mollitia voluptas eum aperiam voluptatibus.', '2025-12-15 19:12:20', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(5, 3, 36, 'Harum amet vero expedita odio voluptas incidunt ipsam. Quo laudantium ut quam laudantium. Nulla illum reiciendis quisquam. Fuga eaque eos asperiores molestiae consectetur illum. Sed eligendi quibusdam voluptatem natus iure. Dolores labore eveniet repudiandae dolores animi.', 'Nesciunt delectus et nostrum doloribus ut. Aut dolorum repellat eum et est nihil delectus nisi. Omnis nihil explicabo vel tempora mollitia quod.', NULL, 'Accepted', '2025-11-29 13:46:37', '2025-12-01 04:40:15', NULL, '2025-12-18 03:43:34', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(6, 4, 12, 'Veritatis quisquam non suscipit nisi laudantium aut. Sed et vero sit molestiae sapiente velit. Ea non qui at animi. Commodi autem explicabo vitae commodi sequi quaerat eos. Voluptas velit reiciendis autem dignissimos.', 'Autem voluptatum veniam et libero architecto voluptatum. Vel ut laudantium et molestias iste voluptas quia.', NULL, 'Accepted', '2025-11-29 10:42:08', '2025-11-29 19:18:55', 'Nisi ipsam perspiciatis ex sunt dolorem et id autem.', '2025-12-08 04:36:04', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(7, 4, 18, 'In aut odit dolorem et. Tempora nam est in odit excepturi pariatur. Voluptates eos sit natus.', NULL, NULL, 'Under Review', '2025-12-02 04:30:34', NULL, NULL, '2025-12-16 01:39:23', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(8, 4, 47, 'Consequatur omnis quo omnis est. Hic similique ut maxime. Eligendi debitis recusandae illum unde quas. Aut ex impedit occaecati ut molestias. Est consectetur aut id eveniet. Cupiditate quod aut et omnis accusamus et.', NULL, 'Repellat rem labore velit qui iusto ab.', 'Rejected', '2025-12-02 17:13:19', '2025-12-03 20:10:32', NULL, '2025-12-11 03:20:41', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(9, 7, 3, 'Commodi voluptates qui in laborum. Dignissimos quod eum ipsa tempore iste. Dicta qui rerum sint. Incidunt doloremque error deserunt rerum.', 'Sit distinctio animi iure delectus nulla perspiciatis. Voluptates voluptatem aut corrupti et qui.', NULL, 'Under Review', '2025-11-21 21:05:08', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(10, 7, 24, 'Et commodi sed mollitia. Dolore blanditiis totam aut sit est. Ex in aspernatur rerum.', NULL, 'Sapiente sed minus qui aut ipsam maiores.', 'Accepted', '2025-11-28 17:32:01', '2025-11-29 09:33:12', 'Minus qui molestias facilis expedita rerum debitis voluptatum aliquam.', '2025-12-16 14:28:49', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(11, 9, 8, 'Unde mollitia nisi officia necessitatibus. Modi non excepturi aliquam saepe iusto odio. Adipisci vero quae sed vitae similique animi repudiandae. Molestiae nostrum dolor eos voluptatum ad. Ipsum sit quo et non voluptates. Quia vel distinctio tenetur inventore unde quae.', 'Autem impedit voluptatem mollitia tempore et quam eveniet. Necessitatibus incidunt dolorum aliquam vel officia et porro neque. Culpa voluptates ut eum sunt fugiat voluptas repellendus.', 'Recusandae sequi odio suscipit nobis culpa in est.', 'Withdrawn', '2025-11-24 23:00:00', NULL, NULL, '2025-12-15 19:50:21', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(12, 9, 11, 'Voluptatem sint inventore in molestiae. Quaerat rerum illum possimus nesciunt. Earum officiis voluptatem voluptatem mollitia distinctio. Ex ipsum qui iste facere nesciunt enim odit. Velit voluptatem perspiciatis omnis repellendus et.', NULL, NULL, 'Accepted', '2025-11-13 01:21:21', '2025-11-18 14:27:33', 'Qui repudiandae aut ratione.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(13, 9, 34, 'Et perspiciatis qui porro ipsa qui. Impedit ad dolorem et aut maxime qui. Ad dicta quas alias et perferendis. Pariatur quam magni est molestiae esse rerum. Eum dolor distinctio sit eius nihil.', 'Excepturi molestiae accusamus quidem consectetur voluptates officiis quia veritatis. Odit exercitationem sed voluptatem quis eos qui vel sint. Corrupti non omnis ex sed.', 'Voluptates accusantium reprehenderit autem autem maxime harum.', 'Rejected', '2025-12-02 05:18:50', '2025-12-04 08:03:58', NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(14, 9, 42, 'Quisquam dolorem debitis provident id incidunt nihil. Id atque nobis ea sunt autem exercitationem. Eligendi illo quia porro omnis. Harum assumenda officia quasi omnis aut eum. Nisi iste sapiente consequuntur autem.', NULL, 'Consequatur non voluptates error impedit.', 'Withdrawn', '2025-11-19 08:48:31', NULL, NULL, '2025-12-15 16:25:37', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(15, 9, 44, 'Eum possimus laboriosam eveniet accusamus autem ut ipsum. Autem dolor qui similique ea id aperiam temporibus. Et voluptatem in odit voluptatibus autem ad aspernatur molestiae. Rerum maiores ducimus dolores aut sapiente.', 'Amet ratione facere voluptatem eligendi aut ducimus. Esse et nesciunt voluptatum et et praesentium vero sit.', NULL, 'Withdrawn', '2025-11-19 09:39:20', NULL, NULL, '2025-12-11 03:46:28', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(16, 11, 4, 'Sit ut velit at officia aut. Quasi officia ea nulla et. Quia minima et corporis reprehenderit illum cumque. Voluptatem ea eligendi vero. Eos nisi quidem voluptatem ut.', 'Dolor nihil officia quibusdam consequatur maxime. Ut sed consectetur quos quos. Sed voluptas natus totam sit non sint.', NULL, 'Withdrawn', '2025-11-09 03:15:56', NULL, NULL, '2025-12-18 06:37:48', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(17, 11, 11, 'Sunt sit excepturi sequi cumque. Et autem quo non. Veritatis sint ipsum aut quia. Dolorem et rerum magnam qui libero. Repellendus consequatur inventore laudantium omnis ex minima hic aperiam.', 'Quia tempore distinctio deserunt quaerat sunt similique corporis. Ut dolore aut corporis accusamus esse vitae maxime.', 'Est et aut assumenda.', 'Under Review', '2025-12-03 15:49:20', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(18, 11, 45, 'Quisquam quas rerum maxime sequi sapiente sunt sed dolore. Quo non reiciendis eum et est quasi natus atque. Quidem est voluptatum eos et.', 'Qui itaque consequatur eveniet quia voluptatem. Ex sit provident dolores enim.', NULL, 'Accepted', '2025-11-12 11:52:19', '2025-11-18 07:50:09', NULL, '2025-12-18 19:10:12', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(19, 12, 5, 'Omnis nihil non doloribus eaque in. Eaque blanditiis quis quia itaque debitis quas. Omnis voluptatem quo nihil dolorum excepturi. Sequi ea non animi sed tempora.', 'Rerum quo illo hic sit sint numquam. Et soluta harum quisquam eveniet illum.', 'Natus et nemo minus tenetur officiis eos.', 'Under Review', '2025-11-17 18:22:58', NULL, NULL, '2025-12-09 04:04:27', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(20, 13, 26, 'Velit quas inventore hic consequatur non perferendis. Ea accusamus velit neque vel saepe ipsa eligendi. Et atque inventore voluptate ullam ut placeat. Numquam vero voluptates ex voluptatem.', 'Assumenda maiores corporis ut est voluptatem. Nostrum aut mollitia ratione occaecati. Autem similique id omnis voluptas aliquam aut.', 'Architecto pariatur ducimus at illo sit exercitationem molestiae.', 'Rejected', '2025-11-08 03:00:07', '2025-12-04 01:28:20', 'Sapiente atque placeat fuga iusto harum vero.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(21, 13, 42, 'Aspernatur voluptatibus enim quos facere sunt cupiditate. Possimus at modi exercitationem voluptatem. Quasi assumenda praesentium et quasi ut minima quo. Rerum est cupiditate sit nulla eligendi. Similique labore accusamus aut non quasi ipsa alias. Rerum qui eaque consequatur aut corporis.', 'Est perspiciatis beatae laboriosam tempora minus voluptas illo. Eos adipisci deleniti ea commodi aut.', 'Voluptatum reprehenderit qui voluptas dignissimos rerum.', 'Accepted', '2025-11-11 20:06:31', '2025-11-28 05:44:20', 'Quae ea maxime vitae ea.', '2025-12-05 16:32:52', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(22, 17, 28, 'Laudantium perspiciatis ex aspernatur dolorum. Ut qui atque sapiente numquam molestiae consequatur dolores. Et quo natus recusandae corporis laboriosam. Vel voluptas aliquam at qui. Suscipit hic vel aut perspiciatis iure omnis molestiae. Aut corrupti distinctio recusandae ut ipsum.', NULL, NULL, 'Withdrawn', '2025-11-11 12:11:43', NULL, NULL, '2025-12-08 23:59:01', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(23, 19, 4, 'Voluptas distinctio neque enim ex. Fugit et voluptatum occaecati eligendi. Esse est occaecati qui esse. Natus sed consequatur et culpa doloribus et.', 'Delectus nostrum quia magnam est quidem molestiae. Est qui ducimus quasi.', NULL, 'Rejected', '2025-11-11 16:45:46', '2025-11-21 00:47:04', NULL, '2025-12-05 15:38:57', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(24, 19, 19, 'Velit at unde voluptas consequuntur. Eveniet quibusdam voluptatibus debitis eum. Magnam a et ut voluptatibus officiis. Impedit qui eius qui. Non et fuga commodi qui in.', 'Sunt non enim nesciunt ut voluptatum ab. Occaecati reiciendis velit veritatis voluptatem earum animi.', 'Tempore modi voluptate et doloremque excepturi dolores.', 'Rejected', '2025-11-19 06:20:45', '2025-11-19 14:27:27', 'Est tempora aut ut dolor.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(25, 19, 39, 'Aut provident omnis veniam omnis error. Enim unde tempore ut autem explicabo quis enim. Corrupti debitis impedit vitae nemo iste incidunt cumque. Error dolore iure dolorem est beatae provident molestias. Eius commodi excepturi quibusdam est.', 'Dolor dolorum quaerat dolorum impedit aliquam facilis et quis. Itaque illo in ea hic ipsa accusamus pariatur neque. Qui aut eum eum dolorum odio dolore dolore.', 'Possimus dolorem qui veniam consequuntur saepe nihil.', 'Rejected', '2025-11-28 17:23:31', '2025-11-29 21:21:22', NULL, '2025-12-11 12:37:26', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(26, 20, 14, 'Temporibus sit non quia dicta ut. Fugiat et dolore voluptas error et ipsam dolores. Asperiores et tempora et perspiciatis est et quas. Quisquam repellendus quibusdam nemo distinctio accusantium aut quis. Aut totam quos excepturi beatae omnis voluptate voluptas dolor.', NULL, 'Voluptatem aperiam facere quod quia nulla beatae et necessitatibus.', 'Withdrawn', '2025-11-07 10:27:25', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(27, 20, 34, 'Ut aut laudantium pariatur enim dolores laudantium id ut. Quis libero et saepe non. Ullam fugiat quia totam necessitatibus sequi dolores a.', NULL, NULL, 'Accepted', '2025-11-14 01:01:04', '2025-11-15 12:23:34', NULL, '2025-12-06 17:15:55', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(28, 20, 40, 'Explicabo qui facilis quia ad nesciunt et officiis. Quo dolores sit doloremque asperiores possimus. Eos culpa dolores debitis quasi dignissimos aut. Est nobis autem natus voluptatum.', 'Earum mollitia maiores accusantium repellendus. Sed aut sed sint aut vitae modi voluptate eaque. Non aperiam illum necessitatibus id.', 'Sed facilis officia tempore excepturi.', 'Withdrawn', '2025-11-08 19:51:13', NULL, NULL, '2025-12-06 19:23:27', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(29, 23, 11, 'Aut ut voluptatem et. Ea ut corrupti dolorem. Optio quia velit aut nemo fugiat. Non ad eos ut ut. Quaerat labore vero soluta dicta odio.', NULL, 'Laboriosam qui non voluptatibus hic quia consequatur.', 'Accepted', '2025-11-12 01:28:53', '2025-11-15 15:22:18', NULL, '2025-12-07 00:01:17', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(30, 23, 24, 'Hic repudiandae consequatur dolor itaque distinctio dolor qui. Qui saepe aut ullam aliquam culpa tempora. Dolores et sed officiis a fugit in. Id aut magnam suscipit. Sit autem quod id.', NULL, 'Et facilis fugit eos quae rerum.', 'Withdrawn', '2025-11-30 16:33:53', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(31, 23, 28, 'Nobis blanditiis illum autem aut. Laudantium molestiae necessitatibus id voluptatem perspiciatis quod rerum corporis. Voluptatibus iste laborum dolores. Ea labore id beatae atque illum quia deserunt. Id mollitia et delectus quis.', 'Accusantium optio vero sed nesciunt. Dignissimos aut qui quas facilis voluptas qui ipsa.', 'Fuga iste ipsam qui.', 'Withdrawn', '2025-11-07 19:16:01', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(32, 23, 51, 'Natus est deserunt pariatur fugit et necessitatibus consequatur corporis. Et velit unde iure consequatur est. Hic voluptatum tempora commodi ipsum. Explicabo sint tenetur quia cum minima.', 'Aut impedit autem debitis quas reiciendis animi quod. Nam id sed deserunt.', 'Et saepe laudantium rerum et laudantium consectetur et sequi.', 'Under Review', '2025-12-02 23:44:27', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(33, 24, 10, 'Laudantium magnam et quas tempora possimus quibusdam asperiores. Explicabo neque ad id fugiat. Exercitationem labore non iure est harum saepe. Rerum repellat rerum sed enim.', 'Ab aperiam itaque excepturi consectetur dolor illum. Iure ex consequuntur eos adipisci harum non.', 'Debitis doloribus repellat voluptas.', 'Under Review', '2025-11-17 20:35:29', NULL, NULL, '2025-12-06 19:54:54', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(34, 24, 13, 'Rem totam est iusto enim laborum ut. Est vel eum ut velit et. Qui veniam accusamus esse quod error.', NULL, 'Vel tempora velit provident iusto.', 'Pending', '2025-11-14 02:45:59', NULL, NULL, '2025-12-06 15:19:28', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(35, 24, 20, 'Ullam ut ullam facilis quos. Perferendis incidunt est doloremque ea quo voluptates consequatur quis. In et odit quae sint. Beatae quisquam id recusandae asperiores necessitatibus.', NULL, NULL, 'Accepted', '2025-11-28 21:05:51', '2025-12-01 10:07:12', 'Nemo non quia eos aperiam molestiae dicta.', '2025-12-09 00:30:37', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(36, 24, 35, 'Nostrum ipsa sint suscipit. Libero neque voluptatem sit quidem ratione. Error hic ipsum provident non ea. Aut dolorem voluptatibus et doloremque. Et et id labore. Cum culpa consequuntur aperiam non consequuntur.', NULL, 'Iure tempora doloribus exercitationem et ullam adipisci ut laboriosam.', 'Withdrawn', '2025-11-08 03:03:50', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(37, 24, 44, 'Officiis voluptas nostrum modi maxime natus odio. Modi ut itaque et quibusdam pariatur. Rerum vel excepturi aut eveniet inventore iste dolor.', 'Placeat quod quis iusto libero necessitatibus aut possimus a. Nihil voluptatem est nam totam at distinctio optio.', NULL, 'Accepted', '2025-11-28 16:36:03', '2025-12-01 13:16:15', 'Ut est ut incidunt a.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(38, 26, 27, 'Aut molestias deserunt officiis pariatur sunt. Aspernatur quaerat facere dolores. Totam similique alias ipsa laboriosam earum.', 'Nobis minus nulla aut quia iure facilis sed alias. Veniam iste fugiat ut enim vitae rerum vero.', 'Rerum quos nihil qui voluptatem eum similique velit repudiandae.', 'Accepted', '2025-11-19 17:46:59', '2025-11-28 22:59:51', 'Omnis omnis reiciendis aspernatur temporibus iure minima.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(39, 26, 29, 'Magnam odio ut quisquam pariatur ea. Quidem ipsa non quia. Alias officiis hic et qui alias. Voluptas magni accusamus consequatur. Neque minima voluptatem architecto dolorem. Consectetur aut suscipit aliquid omnis aspernatur quaerat.', 'Eius autem explicabo voluptas molestiae est. Optio quam at officiis velit beatae.', 'Aut quia aut incidunt similique.', 'Under Review', '2025-11-05 10:13:51', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(40, 26, 39, 'Error a sint officiis aut. Blanditiis ipsam voluptas corporis excepturi. Est facilis consequatur at. Cupiditate sit a facilis iure quo. Vel possimus eaque aut consequuntur voluptate pariatur.', 'Inventore omnis dicta et sed. Amet vel omnis quam in dicta dolore sit. Molestiae mollitia itaque aut impedit.', NULL, 'Under Review', '2025-11-15 04:44:23', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(41, 26, 45, 'Est fugit et quo rerum ex. Sunt sit corporis quia debitis a. Ullam dolorum vitae tenetur qui accusantium ratione sequi recusandae.', 'Quod enim enim commodi facilis deserunt sed qui. Mollitia quibusdam earum voluptates.', 'Est cum veniam ea doloribus veniam consequatur facere quia.', 'Under Review', '2025-11-18 11:12:06', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(42, 27, 8, 'Temporibus possimus et sed quae quibusdam eveniet praesentium. Omnis ducimus eum praesentium eaque earum. Quidem nisi est occaecati.', 'Enim deserunt animi ratione magni exercitationem eos veniam. Temporibus corporis beatae qui. Atque porro et corporis omnis.', NULL, 'Withdrawn', '2025-11-07 07:16:33', NULL, NULL, '2025-12-16 15:38:17', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(43, 27, 14, 'Molestiae necessitatibus unde eius fuga distinctio dolor delectus placeat. Architecto laborum alias corporis rerum sunt autem. Asperiores qui eum ut error iure aut reiciendis. Molestias accusantium est exercitationem aliquam odio odio.', NULL, NULL, 'Under Review', '2025-11-17 05:14:24', NULL, NULL, '2025-12-13 15:07:32', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(44, 27, 23, 'Iure non soluta illo iure. Voluptatibus dolore aspernatur provident dolorem et exercitationem molestias. Voluptate rerum doloremque vero excepturi sunt soluta magnam. Molestias voluptas quam unde nobis tenetur ex officiis. Alias saepe nulla laudantium et consequuntur.', NULL, NULL, 'Under Review', '2025-11-22 07:25:36', NULL, NULL, '2025-12-17 21:50:32', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(45, 27, 29, 'Illo rem quia quis magni. Laboriosam eos iste quia eaque. Voluptatem similique velit dolorem blanditiis. Sed repudiandae temporibus asperiores sunt aliquid architecto. Maiores molestiae consectetur est quasi et facere est.', 'Vel totam deserunt animi quibusdam exercitationem iste dolorum. Eum ullam laborum odit. Consequatur id dolores doloremque aut nam.', NULL, 'Under Review', '2025-11-18 18:47:01', NULL, NULL, '2025-12-13 10:52:04', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(46, 30, 11, 'Occaecati unde expedita officiis alias quod. Consequatur officia est labore culpa. Quis eaque distinctio quos error. Est sit in quia magnam repellat est.', NULL, NULL, 'Pending', '2025-11-08 16:05:33', NULL, NULL, '2025-12-12 01:25:45', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(47, 30, 22, 'Eaque odit non numquam minus iure saepe. Modi quod excepturi voluptate quo corporis repellat. Quasi maiores similique deleniti reiciendis id repellat illo.', NULL, 'Velit similique veritatis et dignissimos quibusdam velit voluptas.', 'Under Review', '2025-11-17 17:33:25', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(48, 30, 42, 'Deserunt distinctio perspiciatis impedit et esse laborum. Aspernatur suscipit et vitae nihil reiciendis. Beatae optio quam provident dolorem velit voluptas eos.', 'Asperiores tempore alias qui quas ut. Qui reiciendis debitis velit est natus dicta. Delectus vel vero atque sed culpa tempore.', NULL, 'Accepted', '2025-11-20 16:21:16', '2025-11-27 22:45:06', NULL, '2025-12-06 04:28:13', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(49, 30, 46, 'Voluptas blanditiis eligendi assumenda autem ex eius rerum quia. Enim et ipsam delectus error. Ut quia molestias quo pariatur.', NULL, NULL, 'Under Review', '2025-11-07 11:33:00', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(50, 35, 4, 'Aut consequatur doloremque consequatur consequuntur. Qui sint neque molestiae aliquid. Est doloribus eligendi repellendus incidunt quibusdam repellat.', NULL, 'Placeat omnis ut quo est est quis.', 'Withdrawn', '2025-11-27 20:34:12', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(51, 35, 23, 'Architecto voluptates dolorem sed dolor ea quisquam. Temporibus fugit quia non fuga debitis nobis expedita. Aspernatur ab laboriosam sint vel ipsam aperiam enim. Qui molestiae quae asperiores accusantium blanditiis in. Omnis fugiat et ea commodi dolores sed qui.', 'Hic sit non quis repellat in. Laboriosam ex impedit quasi aliquam officiis qui. Doloribus laudantium vero consequatur eos earum a quis.', 'Eius soluta voluptatum deleniti adipisci.', 'Rejected', '2025-11-23 05:22:39', '2025-11-27 08:08:07', 'Perspiciatis ea molestiae quaerat sunt.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(52, 35, 30, 'Eveniet rerum neque perferendis porro quidem. Corporis at officiis accusantium et vel qui laudantium. Eligendi earum distinctio dolorum nam voluptatem. Quo tempora quaerat iusto doloribus dolores quae.', NULL, 'Libero perferendis laborum voluptatum debitis iure non perspiciatis enim.', 'Withdrawn', '2025-12-03 22:43:31', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(53, 35, 31, 'Suscipit rem commodi alias ea minus. Amet eveniet molestiae sit reprehenderit beatae. Dolorum quasi hic distinctio quas. Autem cum et dolores aut non. Ipsa occaecati libero repellendus deserunt iste nihil.', NULL, NULL, 'Rejected', '2025-11-11 00:40:51', '2025-11-26 08:50:09', 'Ducimus blanditiis minima explicabo laborum doloribus quaerat.', '2025-12-05 15:32:02', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(54, 35, 38, 'Explicabo temporibus ipsum similique. Enim possimus est laborum possimus sit consequatur aliquid accusamus. Eum suscipit quidem libero facilis voluptatem quos. Quis placeat culpa sit aliquam facere. Minus reiciendis dolore dolores aut.', NULL, NULL, 'Rejected', '2025-11-14 08:40:11', '2025-11-24 18:09:26', 'Vero et animi et ut.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(55, 36, 29, 'Accusamus distinctio ullam fugiat unde sunt aperiam. Est voluptate hic facilis enim aut fuga laborum. Voluptatem voluptatem alias laborum.', 'Corrupti labore explicabo quis exercitationem animi. Nesciunt fugiat eveniet labore iste consequatur doloremque. Qui nihil sequi est reprehenderit tempore unde quo.', 'Et tempore asperiores non sapiente.', 'Pending', '2025-12-02 10:13:27', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(56, 36, 35, 'Et doloribus assumenda cumque praesentium. Vero optio autem et ipsa voluptatem. Nobis harum dolor omnis aliquam nulla commodi. Eaque aut voluptatem eaque nesciunt. Minus sunt sed aut omnis omnis at ullam neque.', NULL, 'Consequatur quo ut doloribus vero dolores magni officiis.', 'Under Review', '2025-11-21 03:02:36', NULL, NULL, '2025-12-18 13:00:29', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(57, 36, 40, 'Et sequi sint aspernatur quo id corrupti placeat. Harum rerum accusantium voluptatibus rerum et. Et quod iusto quia dolore animi ab. Blanditiis id cumque quo eos in ea aliquid velit. Possimus qui aut voluptatum enim quaerat tenetur.', 'Natus officiis earum id. Omnis eveniet necessitatibus qui.', NULL, 'Accepted', '2025-11-22 21:07:33', '2025-11-27 07:19:17', NULL, '2025-12-09 17:09:59', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(58, 36, 44, 'Nisi ex reiciendis minus sunt est occaecati. Repudiandae nemo et perferendis amet officia dolorum. Dolorem dolorem et dolorem ut ut nam quod. Magnam autem ducimus vero nihil ut eaque.', NULL, NULL, 'Under Review', '2025-11-29 20:44:36', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(59, 36, 47, 'Repellendus rerum nulla voluptas et. Doloremque reiciendis magni saepe iure voluptatem ut numquam quis. Autem dolores sunt vero quo nostrum porro ea.', 'Rem aut enim molestiae repudiandae quia. Ipsam facere dolores facilis et corporis porro.', 'Et quo aspernatur fugit alias voluptas saepe quasi.', 'Rejected', '2025-11-25 02:26:07', '2025-11-25 18:12:22', 'Enim mollitia impedit quam culpa et aliquam.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(60, 38, 12, 'Error nam incidunt provident. Ut molestias debitis quos qui placeat. Sunt odio quas sint. Veniam laboriosam recusandae qui nisi velit excepturi. Rem culpa odio iusto blanditiis veritatis quia excepturi. Molestiae provident ex non similique temporibus et praesentium.', 'Quia fuga sed minima dolorem libero. Corporis omnis repellat consequatur et. Nam officia nihil id maxime.', 'Inventore nemo quis culpa tempore ut.', 'Under Review', '2025-11-19 12:00:28', NULL, NULL, '2025-12-09 23:53:46', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(61, 38, 41, 'Sed qui et quod voluptas sed quis quis. Quos tempore aut et accusantium praesentium earum magni. Incidunt dolores iure et quia qui ipsam vel qui. Quasi et neque quia omnis id maiores.', 'Corrupti expedita consequatur dolorem dignissimos. Velit optio aut saepe qui accusantium laudantium.', 'Voluptate fugit perferendis alias sapiente.', 'Rejected', '2025-11-17 07:24:51', '2025-11-30 12:51:59', 'Accusantium voluptatem delectus minima repudiandae quia veritatis.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(62, 40, 2, 'Est similique fuga doloremque non commodi veniam non possimus. Ratione nam in nesciunt id eligendi est ab. Reprehenderit voluptatem eos porro voluptate vero. Hic eaque nobis suscipit voluptates animi mollitia et. Laboriosam deleniti autem provident.', NULL, NULL, 'Accepted', '2025-11-10 04:45:32', '2025-11-26 17:02:52', 'Tempora rem officiis necessitatibus eveniet dolore est itaque.', '2025-12-07 08:24:41', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(63, 40, 9, 'Ea non officia omnis sint vero non in. Enim quis molestiae officiis voluptatem. Minus eos sint fugiat quia officia est quod. Dolores incidunt officiis asperiores corporis nisi voluptates.', 'Ut et porro dolorem eius dolorem ea facere. Debitis facilis saepe beatae voluptatem eligendi maxime dicta.', NULL, 'Rejected', '2025-11-14 20:01:37', '2025-12-01 06:53:58', NULL, '2025-12-09 17:45:27', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(64, 40, 10, 'Ad commodi voluptatem sint distinctio rerum id perferendis. Et facere soluta tempore velit non. At adipisci molestiae deserunt atque. Est ab aut ipsam ut est. Laborum et voluptas ipsum itaque reprehenderit.', 'Harum tempora nulla dolor consequatur eius cupiditate distinctio. Eos impedit error labore ullam quae libero.', 'Ipsam quisquam eaque provident non.', 'Pending', '2025-12-01 11:18:01', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(65, 40, 30, 'Tempore deleniti suscipit et atque nisi vel voluptas. Ullam soluta quaerat nobis amet et et saepe. Doloremque sequi tempora omnis quod. Aut quae eius et facere ullam officia praesentium excepturi. Pariatur molestias aspernatur deserunt illum.', NULL, NULL, 'Rejected', '2025-11-18 23:25:50', '2025-11-28 14:29:31', NULL, '2025-12-13 04:57:05', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(66, 40, 34, 'Vero maxime sed autem sit. Veniam adipisci voluptatem temporibus enim sint sunt ut et. Unde consequuntur sunt voluptas aut veritatis molestias inventore. Quibusdam eum corporis exercitationem nulla iusto maxime nostrum. Aliquid eos necessitatibus magnam id excepturi voluptate. Id tempora sit quia aperiam.', NULL, 'Officia et harum voluptatem sint nesciunt accusamus.', 'Withdrawn', '2025-11-16 01:55:32', NULL, NULL, '2025-12-07 20:31:47', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(67, 44, 2, 'Veniam vitae voluptatem quia non debitis. Quia quidem deleniti optio minus similique a officia. Reiciendis inventore accusantium dignissimos deleniti autem eveniet reprehenderit. Autem ea non quis aspernatur aliquam beatae cum. Reiciendis quod est repellendus quia quo maxime corrupti iste.', NULL, NULL, 'Accepted', '2025-11-15 20:47:49', '2025-11-28 06:37:23', NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(68, 44, 9, 'Eos harum consectetur fugit. Sapiente et nihil excepturi. Numquam porro enim voluptatibus velit saepe earum. Maiores aut est et repudiandae. Aspernatur molestiae non est sequi inventore exercitationem.', 'Nobis voluptatem veniam quia sint ipsam reiciendis. Fuga omnis accusantium sequi explicabo nulla.', NULL, 'Under Review', '2025-11-19 02:15:18', NULL, NULL, '2025-12-18 03:37:50', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(69, 44, 19, 'Impedit enim quis hic occaecati ea odio. Minima ipsum facere ab totam dolor commodi qui. Amet sit earum iure ipsum id optio. Nemo tenetur rerum laborum dolorum. Laudantium eum suscipit explicabo. Animi minima repudiandae laborum harum.', NULL, NULL, 'Withdrawn', '2025-11-29 05:37:41', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(70, 44, 38, 'Nihil tempore totam sit voluptatem minus qui. Et omnis aperiam sunt eos fugiat blanditiis iusto. Nulla natus minima sit numquam enim cupiditate delectus. Mollitia praesentium velit alias aliquam et officiis. Quo eos rerum expedita voluptatem similique ipsam impedit id.', 'Id mollitia ad sed dolor. Voluptates minima illum odio qui aut sunt.', 'Dolore commodi et dolore aut.', 'Withdrawn', '2025-12-02 13:03:53', NULL, NULL, '2025-12-09 15:53:17', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(71, 44, 47, 'Sint voluptas molestias fugiat possimus adipisci repudiandae qui. Provident id magni mollitia qui. Temporibus facilis non velit labore. Quia aperiam asperiores sit est soluta molestiae sunt.', NULL, 'Et possimus distinctio quidem explicabo harum et consequatur.', 'Under Review', '2025-11-17 03:50:39', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(72, 48, 13, 'Fuga ullam corrupti qui quisquam et assumenda. Eaque rerum aut fugiat sit. Unde laudantium voluptas est aliquam. Quaerat eius et eos. Itaque commodi rerum architecto maiores aspernatur atque ipsam vitae.', 'Velit sed tempore accusamus molestias quis consequatur. Repellat quia impedit voluptate.', 'Minus eveniet ut exercitationem sunt.', 'Accepted', '2025-11-16 09:51:28', '2025-11-16 20:06:05', NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(73, 48, 29, 'Quia sunt sed qui. Est aspernatur aut blanditiis exercitationem est molestias. Repellendus optio atque tempora dicta excepturi quas. Sit vel animi possimus id debitis voluptatem tenetur. Vel alias et nam hic eveniet doloremque at. Atque dignissimos vel sapiente dignissimos.', NULL, 'Quae sit placeat cumque molestiae quia cupiditate est.', 'Accepted', '2025-11-04 17:46:54', '2025-11-20 00:09:36', NULL, '2025-12-06 20:36:42', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(74, 53, 4, 'Nisi blanditiis impedit enim accusantium. Sint error similique aut quis. Minus veniam consequatur quos. Ut officia officiis labore facilis iste ut.', NULL, NULL, 'Under Review', '2025-11-18 21:07:00', NULL, NULL, '2025-12-08 05:58:02', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(75, 53, 26, 'Commodi voluptate quia eaque nobis eum quis. Odit qui laboriosam ab reiciendis ut ea. Asperiores eius explicabo quibusdam aut. Voluptatem eaque repellendus aut id beatae. Ut saepe voluptatum ullam alias. Ipsam iusto incidunt repudiandae et inventore ut hic.', NULL, 'Molestiae eum aut optio quaerat delectus nostrum.', 'Withdrawn', '2025-11-30 23:10:35', NULL, NULL, '2025-12-05 03:09:22', '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(76, 53, 29, 'Et repudiandae fuga magni. Natus consequatur aut odit sed velit ut quos eaque. Voluptatem doloribus ex adipisci maxime. Est beatae est officiis. Minima labore quia illo aspernatur nemo ab.', 'Non qui est repudiandae nostrum quasi. Provident eos cumque dolorem ab non facere. Magni repudiandae vitae commodi veritatis quibusdam.', 'Enim aut quaerat quia a laudantium eveniet et.', 'Accepted', '2025-11-30 20:16:31', '2025-11-30 23:31:34', 'Quisquam pariatur dolores in at et sint.', NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(77, 53, 35, 'Dignissimos quidem aliquid laboriosam. Optio recusandae enim ea ut. A sit est et provident nemo dolor. Consequatur eligendi error quia sed consequatur aut quam. Eius harum deleniti autem quam.', 'Ipsa quia et quo. Qui labore eveniet aperiam neque. Veniam debitis modi ut optio.', NULL, 'Accepted', '2025-11-08 04:34:00', '2025-11-21 13:10:46', NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(78, 59, 21, 'Unde aut qui magnam porro dolore possimus suscipit repellat. Dignissimos porro itaque sit. Tempore maiores optio ut eaque expedita. Necessitatibus quia qui est deleniti doloribus quos laudantium.', 'Dolores sit ea ut sit fugiat sed. Illo debitis ipsum alias cumque accusamus.', 'Magni aut consequatur impedit adipisci minus voluptas aut.', 'Under Review', '2025-11-23 06:37:34', NULL, NULL, NULL, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(79, 59, 29, 'Eum dolore sit consequatur commodi eveniet. Ut modi qui et voluptates sequi laudantium. Ea suscipit esse dolores aut non. Eos iste sed quia inventore ea nostrum ratione. Commodi ea dolores ipsa voluptatem.', 'Ut beatae dolorum facere dolorem accusamus sequi. Vitae quis quia consequatur quo omnis quos illum.', 'Commodi quis eveniet esse et ad eaque.', 'Accepted', '2025-11-08 16:03:43', '2025-11-25 21:41:03', 'Blanditiis eaque dolores similique voluptate architecto.', NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(80, 59, 30, 'Autem blanditiis a cum delectus qui facilis. Quia ratione consequuntur quibusdam in. Dolorum perferendis aliquid aliquam nemo nobis qui. Tempora tempora amet quia deleniti ut. Eveniet magni tenetur dolor quia aut nobis.', NULL, NULL, 'Pending', '2025-11-20 22:13:04', NULL, NULL, '2025-12-13 03:19:54', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(81, 59, 41, 'Harum similique dignissimos dolores impedit magnam cum. Repudiandae repellat qui dolorem eius accusantium eligendi quo dolores. Corrupti sit quas et aut facilis omnis. Sed provident voluptate amet alias non.', 'Et corporis qui est iste. Nostrum non quis aut et accusantium temporibus facilis. Ratione saepe aut quas fugit.', NULL, 'Accepted', '2025-11-27 08:48:31', '2025-11-28 14:02:56', 'Eum dolor autem facere repellat aut ipsam id.', NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(82, 61, 5, 'Libero quibusdam accusantium rem sint distinctio quo. Quidem quisquam voluptatum odit et sint temporibus unde. Nisi et voluptas qui quam. Architecto qui nemo accusamus veritatis inventore itaque repudiandae et.', NULL, NULL, 'Pending', '2025-12-01 12:38:32', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(83, 61, 7, 'Harum consequatur in aliquid nulla. Ut eius voluptatem velit asperiores eius. Expedita molestias eos unde. Non ut nobis voluptate. Odio neque neque quidem.', 'Dolorem omnis nihil doloremque dolores odio rerum sint. Iste sint deserunt eligendi cupiditate eligendi earum non.', NULL, 'Accepted', '2025-11-12 15:58:58', '2025-11-20 04:19:33', 'Minima minima deleniti similique itaque soluta distinctio corporis cum.', '2025-12-05 08:39:01', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(84, 61, 11, 'Ducimus cum numquam dolor quis vel perferendis. Dolor architecto nulla suscipit. Dolore deserunt et qui et molestiae. Voluptatibus incidunt rerum molestiae blanditiis iure.', NULL, 'Nihil ut dicta repudiandae.', 'Rejected', '2025-11-18 05:55:00', '2025-11-23 04:40:53', 'Sed ullam eius quia fugiat.', '2025-12-11 07:02:05', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(85, 61, 18, 'Voluptates quidem et excepturi nemo qui minus. Maxime alias aperiam hic nobis velit ut. Hic voluptatem aut tempora vel quis illo. Eligendi voluptas quos quidem quas repellat rerum dolor. Numquam non qui sit ratione quibusdam.', NULL, 'Asperiores id quo ullam voluptatem.', 'Rejected', '2025-11-19 05:18:04', '2025-11-20 05:57:03', NULL, '2025-12-12 23:07:58', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(86, 61, 46, 'Unde molestias earum dicta blanditiis ut. Culpa temporibus et tempora earum id. Cum saepe rerum reprehenderit pariatur architecto voluptas modi. A neque neque sunt nulla pariatur. Rerum dolorem qui quia ea.', NULL, 'Et accusantium et quidem commodi repudiandae amet.', 'Withdrawn', '2025-12-01 01:10:58', NULL, NULL, '2025-12-08 06:29:20', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(87, 63, 17, 'Ipsa doloremque veniam velit velit vero officiis reiciendis dicta. Omnis sint placeat in assumenda aut praesentium est. Dolorem quas eum et sit quo rem et. Voluptatem temporibus et enim inventore expedita itaque nostrum. Est repellendus ut atque fugit. Ratione ut aliquid illum nobis ipsa veritatis in consequatur.', NULL, NULL, 'Pending', '2025-11-24 21:28:35', NULL, NULL, '2025-12-11 05:41:31', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(88, 63, 36, 'Omnis est ducimus accusamus mollitia quo voluptate. Illo quae corporis possimus aspernatur nobis qui doloremque ex. Consectetur ea mollitia ut excepturi. Et eos cupiditate vero. Aperiam repellendus blanditiis tempora vitae accusantium. Ducimus ut quaerat corporis quia in quisquam facilis ut.', NULL, 'Maiores deleniti nemo dolorem est corporis.', 'Under Review', '2025-11-20 21:47:20', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(89, 65, 11, 'Sed quia sed inventore ullam. Vero occaecati occaecati eum eaque soluta. Velit aliquam necessitatibus dolores non aperiam debitis suscipit. Tempora excepturi qui laborum non sapiente. Facere consequatur fugiat at facilis dolor. Qui ab nihil error consequuntur corrupti.', 'Ab provident dignissimos magnam iure. Consequatur expedita fugit voluptas repudiandae aspernatur facilis et. Dolorem natus voluptas quas quam recusandae cupiditate soluta.', 'At aliquam dignissimos harum ut quam voluptatem.', 'Pending', '2025-12-04 01:42:20', NULL, NULL, '2025-12-08 15:57:45', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(90, 65, 17, 'Rerum ea recusandae beatae tenetur voluptate expedita. Delectus et minus laudantium est. Nemo consequatur sunt quidem eos et consequatur. Id quod quia blanditiis dolor ea fugiat. Maiores omnis enim enim ipsum sapiente.', 'Fugit explicabo sit ut ipsa. Minus voluptatem sunt eius inventore.', 'Minima ut consequatur enim esse qui perspiciatis.', 'Under Review', '2025-11-20 14:40:35', NULL, NULL, '2025-12-14 18:30:23', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(91, 65, 32, 'Quaerat eum vero excepturi veniam dolores vero. Non quo odio ea accusantium eligendi. Vel eligendi esse expedita.', 'Delectus inventore nesciunt inventore consequatur. Suscipit quas vel recusandae ducimus placeat odio eum. Facilis officiis suscipit omnis et voluptate.', NULL, 'Pending', '2025-11-17 20:17:11', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(92, 65, 37, 'Animi sequi iusto quia praesentium ullam. Et non sit ipsum. Officia odio consequuntur non cupiditate illo vel. Ut ex ipsam quod aut quo a id. Et eum in aperiam aperiam ipsum voluptatibus. Neque recusandae itaque blanditiis praesentium eveniet molestiae.', 'Repellat ratione tempore ea consequatur quia nobis et. Incidunt doloribus accusantium alias omnis odit dolore rem sed.', 'Ipsam pariatur consectetur ut exercitationem nisi doloremque.', 'Under Review', '2025-11-12 09:55:28', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(93, 65, 47, 'Corporis voluptatem ducimus assumenda odio autem rerum. Nulla sunt sequi aut accusantium ut odio aliquid. Eligendi et totam fugiat illum est id. Qui dolores non enim debitis suscipit ex. Amet laborum quos minus recusandae repellat.', NULL, NULL, 'Rejected', '2025-11-04 23:46:59', '2025-11-24 15:41:48', 'Occaecati nostrum optio est nam dolores perspiciatis vel eos.', '2025-12-15 10:53:30', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(94, 66, 6, 'Voluptatem sequi omnis possimus facilis. Ut porro consequatur labore. Quo laboriosam veritatis provident excepturi qui.', NULL, 'Voluptates molestiae reprehenderit dolores quia exercitationem.', 'Under Review', '2025-12-01 01:07:00', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(95, 66, 29, 'Quasi dolor doloremque est et. Culpa ut quia molestiae repellat cumque quia ab. Et minus facilis ad sit deleniti est.', NULL, NULL, 'Accepted', '2025-11-16 10:39:08', '2025-11-29 19:34:15', 'Nesciunt numquam rerum quae quas.', '2025-12-15 09:30:56', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(96, 66, 32, 'Voluptatibus placeat autem odit optio sunt tempora. Illum fugiat molestiae delectus. Deleniti voluptatem fugit cum unde similique. Repudiandae aut tenetur et.', NULL, NULL, 'Under Review', '2025-12-03 11:03:33', NULL, NULL, '2025-12-17 21:10:26', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(97, 66, 35, 'Nam numquam voluptatem numquam itaque. Sed nostrum consequatur reiciendis et veniam in. Eum hic impedit iure doloremque tenetur saepe est.', NULL, 'Deserunt excepturi soluta et unde veniam dolorem.', 'Pending', '2025-11-06 04:58:43', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(98, 70, 6, 'Dolores cupiditate ab sed quis quasi qui itaque. Deserunt autem ducimus quos numquam dignissimos. Minima assumenda minima sit officia aut eveniet laudantium. Quia eos quasi saepe dicta.', NULL, NULL, 'Rejected', '2025-11-16 19:56:33', '2025-11-29 17:42:06', 'Aut modi tempore enim nobis voluptate eligendi.', '2025-12-11 18:56:24', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(99, 70, 23, 'Aliquam iusto suscipit ratione corporis. Ipsa magnam et temporibus quod magni. Aliquid laudantium corporis qui voluptatum.', NULL, NULL, 'Pending', '2025-11-16 06:26:43', NULL, NULL, '2025-12-15 07:07:14', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(100, 70, 30, 'Odio voluptas enim dolorem. Eum qui provident excepturi et illum aspernatur. Corrupti iste assumenda necessitatibus porro iusto. Earum ipsum repellat non corporis est. Inventore nulla odit ipsa iure nemo doloribus provident. Qui nihil fugit similique sapiente placeat nemo sunt praesentium.', NULL, NULL, 'Withdrawn', '2025-11-11 23:15:37', NULL, NULL, '2025-12-17 22:58:05', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(101, 70, 32, 'Suscipit aspernatur non est vitae. Tempore adipisci rem eos et corporis dolore veritatis. Voluptatem velit ipsam totam et unde placeat eligendi. Ullam explicabo repellat nisi provident soluta quasi ut. Tempore optio nisi molestiae. Blanditiis minus ut id et atque natus.', 'In ex impedit rerum minima. Quod et dolor ea maxime eius ea doloremque incidunt.', 'Corrupti illum ipsum similique et voluptas.', 'Rejected', '2025-11-30 17:22:40', '2025-12-01 09:58:07', NULL, '2025-12-14 19:34:23', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(102, 70, 47, 'Qui nisi reprehenderit officiis temporibus modi ducimus. Blanditiis nostrum laudantium dolor quia officia praesentium. Possimus adipisci aliquid voluptatem minus aliquid. Tempore similique non quisquam deleniti.', 'Nihil omnis qui id reiciendis. Eum et velit minus quasi.', NULL, 'Pending', '2025-11-07 13:46:43', NULL, NULL, '2025-12-06 11:39:19', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(103, 73, 25, 'Vitae quasi quaerat facilis quas ad id voluptatem. Et repellendus ducimus atque officia et nihil. Officia rerum beatae inventore eos tempore placeat. Aut officia officia similique ut delectus. Magnam in iusto voluptates occaecati qui et.', 'Voluptatem aliquid et eaque. Id natus vel laboriosam sed.', 'Sit qui dignissimos temporibus itaque possimus voluptatem.', 'Rejected', '2025-11-27 08:07:51', '2025-11-30 21:57:51', NULL, '2025-12-10 17:01:29', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(104, 73, 33, 'Quia itaque qui enim dolorem enim cumque. Incidunt soluta vel dolor id sed unde corrupti. Enim molestiae vero quae.', NULL, NULL, 'Accepted', '2025-11-07 02:10:42', '2025-11-15 15:22:25', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(105, 74, 3, 'Dolores maiores eum aut et eligendi voluptas. In aliquid est qui. Illum laudantium quasi aspernatur cum. Quis quas et qui nisi exercitationem. Officiis ut expedita esse. Dolores magnam cum sed.', 'Maiores repudiandae magnam quo qui ipsam animi. Ullam repudiandae culpa veritatis eos perspiciatis.', NULL, 'Rejected', '2025-11-28 10:40:49', '2025-11-30 23:04:33', 'Ipsam eaque dolorum sunt consectetur possimus.', '2025-12-05 04:54:24', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(106, 74, 38, 'Sed qui consequatur repellat voluptatem. Voluptatum qui ut et sit esse. Est tempora aut molestiae repudiandae excepturi. Soluta molestiae id est.', NULL, NULL, 'Rejected', '2025-11-12 01:28:18', '2025-11-19 19:39:25', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(107, 74, 45, 'Id quia magnam est vitae qui. Suscipit numquam eos et repellendus sit possimus. Distinctio asperiores facilis laborum magni qui quae enim. Tenetur velit est nam facere et sequi optio. Dolore id nulla alias sunt delectus fugit vero.', NULL, NULL, 'Rejected', '2025-11-19 22:00:10', '2025-11-20 02:05:19', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(108, 75, 25, 'Eaque debitis aut aut quia minima. Porro qui ut cumque provident nesciunt. Suscipit assumenda aliquid voluptatem recusandae vel itaque. Incidunt sapiente delectus velit velit.', NULL, NULL, 'Pending', '2025-11-13 08:48:16', NULL, NULL, '2025-12-18 14:57:07', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(109, 75, 26, 'Voluptas nostrum at quisquam officiis omnis eius explicabo molestiae. Qui velit rerum cupiditate eum assumenda laboriosam. Natus odit temporibus veritatis omnis. Cum perspiciatis facilis et. Voluptatem omnis voluptatum id in. Rerum laboriosam eum voluptas optio dolores.', NULL, NULL, 'Under Review', '2025-11-30 03:50:11', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(110, 75, 33, 'Incidunt qui optio dolorem ea vel. Qui aut laudantium sed cumque animi numquam facere. Eligendi fugit fugiat illo occaecati nam sed. Similique ea asperiores dolorum voluptatibus distinctio. Id quo accusamus illum quia ipsum autem.', 'Qui ut laboriosam tenetur rerum cumque quibusdam possimus. Quisquam quas inventore dolores eius esse. Aut nostrum excepturi velit.', NULL, 'Withdrawn', '2025-11-30 08:15:44', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(111, 76, 11, 'Quibusdam exercitationem autem praesentium voluptatem cumque repudiandae aut modi. Ea quaerat eos non corrupti est voluptates ab. Eaque dolorem ullam ducimus enim error cumque molestiae.', 'Dolor est fuga molestias perspiciatis laboriosam. Deleniti quia id omnis similique nihil laboriosam eaque. Facilis rerum hic sit dolorum dolorem unde.', 'Officia eum eos commodi non vel et.', 'Under Review', '2025-11-26 01:53:48', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(112, 76, 14, 'Nihil ratione deleniti harum architecto. Aspernatur voluptatem repudiandae odio mollitia nulla doloribus. Quo doloremque dolor sint officiis aut.', NULL, 'Nihil dolorem numquam ipsam ut debitis omnis.', 'Under Review', '2025-11-14 04:13:53', NULL, NULL, '2025-12-14 19:39:29', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(113, 76, 26, 'Est aut consequatur voluptatibus repellendus. Ducimus reiciendis quis et et consequatur in et ea. Nisi ea porro quia autem incidunt illum.', 'Sequi qui aut incidunt tempora autem. Enim deserunt eos incidunt distinctio neque numquam voluptas.', 'Ducimus amet praesentium enim quam pariatur occaecati rerum.', 'Under Review', '2025-11-09 07:25:16', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(114, 76, 36, 'Alias aut optio voluptas ut ut est minima. Hic necessitatibus expedita aut in quo possimus. Earum magnam laboriosam voluptates.', NULL, 'Et ut dolor autem voluptatem maiores aperiam sit reiciendis.', 'Withdrawn', '2025-11-10 21:38:46', NULL, NULL, '2025-12-11 13:36:00', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(115, 76, 43, 'Maxime quia sapiente sequi animi. Voluptatum cupiditate quia reiciendis pariatur. Soluta quia nihil recusandae explicabo hic non quas iure. Libero nihil assumenda provident provident voluptatibus aut sapiente. Aliquid autem est quaerat consequuntur.', 'Et iste et mollitia sit. Et delectus molestiae et a numquam.', 'Et deleniti et tenetur voluptatum.', 'Accepted', '2025-12-03 20:52:22', '2025-12-04 05:55:48', NULL, '2025-12-13 20:02:32', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(116, 78, 7, 'Qui iure id aut quam pariatur enim ab officia. Quam quaerat ad dolores. Amet earum et ut sed quia vel pariatur culpa.', 'Rerum optio labore voluptatem rerum eos sapiente labore. Ipsam inventore sed unde distinctio et iste eos.', 'Soluta voluptatem dolores nam non omnis.', 'Accepted', '2025-11-25 05:56:50', '2025-12-03 23:48:44', NULL, '2025-12-18 10:56:02', '2025-12-04 16:29:01', '2025-12-04 16:29:01');
INSERT INTO `applications` (`application_id`, `opportunity_id`, `volunteer_id`, `motivation_letter`, `relevant_experience`, `availability_note`, `status`, `applied_date`, `reviewed_date`, `organization_notes`, `interview_scheduled`, `created_at`, `updated_at`) VALUES
(117, 78, 9, 'Nam facere veritatis quia voluptas placeat voluptas. Esse eum aut velit repudiandae non earum autem non. Et rerum autem et velit ut. Doloremque assumenda vero iusto.', NULL, 'Nam sint eos eaque consectetur beatae.', 'Under Review', '2025-11-25 18:25:04', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(118, 78, 19, 'Illum neque distinctio incidunt et. Ipsum laudantium cupiditate qui consectetur corporis. Et adipisci exercitationem et quia occaecati odio commodi possimus. Recusandae vitae dicta eos sed optio. Id eos cupiditate accusantium voluptates adipisci illo cum aut.', NULL, NULL, 'Withdrawn', '2025-11-30 04:59:12', NULL, NULL, '2025-12-10 11:47:35', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(119, 78, 20, 'Ut quibusdam quia voluptas. Eveniet veritatis minus voluptates. Beatae nam saepe nobis molestias qui quia quia. Velit autem eos et.', NULL, 'Quia eveniet aliquid minus consectetur consequatur.', 'Under Review', '2025-11-09 15:50:34', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(120, 78, 46, 'Odio perspiciatis quia iure dolore. Et autem cupiditate asperiores. Consequuntur quo consequatur in architecto soluta cum laborum.', 'Repudiandae enim sit eos cum optio. Quis molestiae animi est saepe dignissimos.', 'Aliquam tempora quis porro necessitatibus eos accusamus.', 'Withdrawn', '2025-11-13 16:58:01', NULL, NULL, '2025-12-10 08:49:46', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(121, 80, 2, 'Tempore vero animi voluptas. Maxime inventore dolorum velit tenetur laboriosam. Ratione harum corporis soluta et quis a. Quo est et cumque quis asperiores laborum doloremque. Sed qui voluptatem accusamus atque omnis quos voluptas. Ea natus voluptas recusandae dolor accusamus sunt quia.', 'Dolorem expedita vitae ut optio aut. Vel similique qui blanditiis quo libero voluptatem. Ratione nulla quis consequuntur.', NULL, 'Withdrawn', '2025-12-02 00:12:57', NULL, NULL, '2025-12-12 23:43:16', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(122, 80, 15, 'Ut animi alias soluta inventore doloremque iure nemo. Amet voluptas in quibusdam in cumque. Dolore sunt nulla qui aliquam perferendis aut.', 'Et dolor exercitationem et. Possimus magni illo voluptatum. Ea blanditiis eaque cumque at.', NULL, 'Accepted', '2025-11-11 06:07:42', '2025-11-15 18:43:47', NULL, '2025-12-09 10:09:11', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(123, 80, 18, 'Eos non aliquid repellat impedit consectetur unde. Enim aut error totam ad nostrum aut nostrum officia. Sint non doloremque quia velit adipisci unde quia inventore. Nesciunt provident ducimus animi architecto quis.', 'Consequatur deserunt qui vitae totam autem enim. Distinctio maxime dolore deleniti impedit ratione quis voluptate.', 'Culpa deleniti accusantium et.', 'Under Review', '2025-12-02 11:46:24', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(124, 80, 26, 'Quam dolores nulla et odit. Atque enim consequatur quo veritatis omnis. Qui neque facere quo nihil repellat et quae. Iure labore iste exercitationem illo eligendi deserunt fugiat.', 'Enim repudiandae non consequuntur voluptatum dolorem tenetur alias. Qui quibusdam eos et dolorum. Odio voluptatem error et explicabo dolor temporibus ipsum.', NULL, 'Under Review', '2025-11-11 12:33:30', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(125, 80, 47, 'Tempore incidunt rem sequi dolores. Quas magnam magnam quis omnis. Rerum maxime optio enim neque quia.', 'Iure excepturi omnis rerum delectus at facere. Magni corrupti sapiente delectus voluptas maxime. Praesentium cumque et veniam eos ipsa.', NULL, 'Accepted', '2025-12-03 11:28:50', '2025-12-04 06:07:47', NULL, '2025-12-07 10:26:25', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(126, 81, 7, 'Neque commodi sed voluptatem ea eaque. Quidem optio consequatur ab deleniti cum libero aut. Voluptatem quasi unde et laboriosam consequatur. Facilis ipsum labore ullam.', 'Et molestiae ut voluptates eaque. Quaerat molestiae est qui.', NULL, 'Rejected', '2025-11-19 16:39:06', '2025-12-03 18:22:43', 'Error sint perferendis id cum.', '2025-12-09 00:31:33', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(127, 81, 9, 'Autem repellat assumenda consequuntur id ipsa libero. Amet qui cupiditate et quis quo consequatur perspiciatis fugit. Minima minima explicabo neque voluptas quis sed qui quae. Quod quo sit hic et neque.', 'Nisi aut sint aut rerum. Non enim eos minus nihil quia tenetur. Assumenda voluptatem illo facere reiciendis doloremque.', 'Error et ut distinctio voluptatum eum aut qui odit.', 'Under Review', '2025-11-28 01:46:12', NULL, NULL, '2025-12-12 01:04:21', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(128, 81, 17, 'Nulla qui deserunt repudiandae fugit ullam praesentium. Et consequatur blanditiis cumque vel sed blanditiis. Vero et et odit minus placeat tenetur cum.', 'Sit qui non laborum consectetur eaque doloremque sit cumque. Ut odit quia distinctio est eum.', 'Sit dolore placeat sapiente tempore quam.', 'Withdrawn', '2025-11-19 23:56:11', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(129, 81, 29, 'Cupiditate nemo dolor animi neque tempore unde suscipit. Est est suscipit accusamus voluptatem facere id ex. Deserunt dolorum officia eaque aperiam in aut voluptatem.', NULL, 'Quia iure et assumenda beatae ab sit autem.', 'Rejected', '2025-11-26 14:59:03', '2025-12-03 18:39:22', 'Quae ullam quis qui tenetur culpa.', '2025-12-06 21:25:28', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(130, 81, 48, 'Voluptate sit sunt similique nam eligendi cumque et. Praesentium et quam aliquid exercitationem magni iste quia. Asperiores molestias id sed vel non ut quaerat. Quis eos consequatur quisquam dolorem omnis. Facere ipsa incidunt nulla.', NULL, 'Deserunt iste nostrum nesciunt id.', 'Accepted', '2025-12-02 21:21:06', '2025-12-03 02:07:21', 'Dicta a vel et mollitia nesciunt consequatur impedit aut.', NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(131, 82, 23, 'Atque et repellendus tempore illo eaque quos. Similique ut sit quia quae. Autem ut autem sed enim et quas voluptatem.', NULL, NULL, 'Withdrawn', '2025-11-23 08:29:18', NULL, NULL, '2025-12-10 08:39:51', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(132, 82, 38, 'Quae dolorem aut aut alias non odio. Atque molestias blanditiis est eaque tenetur magnam et excepturi. Est modi vel cum voluptatibus.', NULL, 'Earum quod a laudantium perspiciatis et.', 'Withdrawn', '2025-11-29 00:17:31', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(133, 83, 7, 'Voluptatibus tenetur eius impedit harum sunt aliquid. Laudantium accusamus maxime ea quos ipsam quae voluptatem enim. Amet nisi sit laudantium ut. Ipsam consequatur sunt cupiditate reiciendis sunt alias. Veritatis deserunt quia assumenda enim itaque soluta fugiat est. Unde repellat porro deserunt cupiditate quis molestiae.', 'Et sequi velit earum. Eveniet quas omnis cupiditate pariatur. Voluptatem et numquam ea deleniti quia dicta consequuntur.', 'Consequuntur cupiditate dignissimos error id autem accusamus.', 'Accepted', '2025-11-21 17:51:34', '2025-11-29 02:45:09', 'Consectetur deleniti et laudantium praesentium et.', NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(134, 83, 28, 'Dolor velit aliquam velit voluptates quod enim sit. Ipsum laboriosam minima ut molestias commodi. Facilis cupiditate consequuntur fuga quo et possimus saepe.', NULL, NULL, 'Rejected', '2025-11-26 22:03:31', '2025-11-26 22:17:31', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(135, 83, 29, 'Quis illum fuga officia molestiae culpa. Amet sunt ut voluptatem labore rem. Voluptatibus ut iure deserunt. Dignissimos perspiciatis id incidunt accusantium minus eveniet. Molestias repudiandae quisquam nulla earum.', NULL, NULL, 'Withdrawn', '2025-11-23 13:49:41', NULL, NULL, '2025-12-07 21:20:17', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(136, 83, 47, 'Reiciendis natus et voluptatem omnis dolores explicabo. Omnis et commodi aut ut commodi debitis velit. Fugit placeat excepturi possimus qui a cupiditate aut. Illo dicta atque nam sint aut natus aliquid. Omnis ut est delectus libero recusandae.', NULL, 'Ipsam soluta nesciunt a beatae.', 'Rejected', '2025-11-30 00:53:05', '2025-12-01 11:48:24', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(137, 85, 14, 'Delectus blanditiis facilis nemo eveniet. Corporis et qui praesentium rerum dolor sunt voluptas numquam. Provident architecto voluptatem quae est. Et ex voluptatem libero itaque. Et deserunt ratione impedit nesciunt omnis et aut.', NULL, 'Facilis officia alias possimus in ipsa tempore.', 'Rejected', '2025-11-28 22:34:22', '2025-11-29 13:20:15', 'Et saepe fuga omnis et possimus placeat in aut.', '2025-12-09 17:27:12', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(138, 85, 32, 'Rerum officiis aut et labore. Ex ut voluptas nulla. Quo iste incidunt non sunt ipsam alias et. Error quia voluptas fuga quisquam et. Laudantium itaque provident facilis dolorem.', 'Suscipit et sit sint ipsam ratione ratione. Sequi est impedit sint et delectus nemo autem. Officiis consequatur consequuntur inventore quis.', NULL, 'Rejected', '2025-11-13 10:11:20', '2025-11-26 19:37:39', 'Neque quod inventore labore repellendus est qui.', NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(139, 88, 23, 'Qui sint enim minima consequatur veniam assumenda ipsam. Cumque corporis quam eos necessitatibus perferendis provident molestiae. Quam itaque vitae quo delectus qui ut. Voluptate dolor deserunt omnis consequuntur aliquid. Ut dolorem aut et.', 'Placeat facilis architecto assumenda. Et praesentium adipisci architecto natus fugiat.', 'Quod et quae ab dolores ad magnam.', 'Under Review', '2025-12-02 15:56:07', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(140, 88, 36, 'Qui sint labore ad et quaerat consequatur rem. Earum ut iusto possimus. Provident ut molestias velit minus omnis. Qui eligendi ea adipisci perferendis. Et voluptatibus dolorum cumque saepe porro. Quos qui beatae ea animi ut nisi ratione.', 'Maxime repellat itaque soluta maxime quo ullam error. Maxime quod accusantium ducimus sint voluptatum. Porro eveniet nisi et consectetur molestias quidem vel.', 'Veritatis deleniti voluptatem dolorum molestiae velit.', 'Pending', '2025-11-26 02:40:07', NULL, NULL, '2025-12-11 00:36:54', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(141, 88, 42, 'Beatae qui a unde ex et. At eveniet placeat officiis consectetur voluptates ab autem sunt. Vitae perspiciatis voluptatem possimus labore consequuntur. Voluptas dolorum ullam hic asperiores facere omnis voluptatibus.', 'Ad iure est quia. Facere aspernatur nisi in voluptates. Fuga voluptas quia excepturi repudiandae.', NULL, 'Accepted', '2025-11-27 04:53:42', '2025-12-01 19:18:22', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(142, 89, 5, 'Maiores ea quidem et dolores animi porro. Ducimus incidunt magnam quas at. Qui nam natus dolore fugiat sit.', NULL, NULL, 'Pending', '2025-11-27 03:51:39', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(143, 89, 12, 'Nihil quis quidem eveniet sequi aut sunt. Aut voluptate veritatis culpa. Voluptates autem nisi repellendus ea aut. Deleniti tenetur quia aliquid incidunt. Odit autem sed iusto minima.', NULL, NULL, 'Rejected', '2025-11-15 10:42:36', '2025-11-16 09:00:43', 'Fugit fugiat quod tempora quod.', '2025-12-13 21:19:51', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(144, 89, 36, 'Sint ea est exercitationem a. Fugiat et saepe recusandae. Magni tempora qui distinctio reprehenderit deleniti consequatur vel.', NULL, NULL, 'Accepted', '2025-11-29 01:03:45', '2025-12-03 19:05:30', 'Enim vel rem quisquam rem minus delectus.', '2025-12-17 15:06:18', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(145, 91, 18, 'Minus doloremque sint hic et. Beatae harum veniam et eum est natus. Deleniti qui eligendi consequatur.', 'Labore in et itaque recusandae facilis. Sint laborum omnis illo cupiditate quia quis eligendi. Mollitia cum minima beatae.', 'Amet doloribus at voluptatem accusantium.', 'Under Review', '2025-11-13 14:26:25', NULL, NULL, '2025-12-09 02:48:14', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(146, 91, 22, 'Perspiciatis voluptatem consequatur vel voluptatem dolorem veniam officia. Magni amet et autem omnis. Sint perferendis totam ducimus repellendus dolorem iure. Sapiente non voluptas facere. Quam eveniet accusamus aut voluptas minus at quo.', NULL, 'Natus possimus ut perspiciatis commodi aperiam sed voluptatem.', 'Withdrawn', '2025-11-24 16:38:58', NULL, NULL, '2025-12-12 10:57:04', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(147, 91, 35, 'Quo consectetur aut officia suscipit veritatis. Enim soluta omnis modi laboriosam officiis fugit in sit. Culpa voluptates nam libero. Perferendis expedita molestiae reiciendis. Deserunt perferendis atque quisquam eos et quasi.', NULL, NULL, 'Accepted', '2025-11-20 07:51:20', '2025-11-30 21:27:32', 'Cum aut qui aut suscipit cum et odit.', '2025-12-09 15:17:08', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(148, 91, 36, 'Error sint laboriosam sunt. Aspernatur labore voluptas necessitatibus et. Sed alias pariatur a aperiam magnam accusantium officiis. Illo beatae qui eveniet fugit eius in libero. Repellat temporibus voluptate molestias doloribus velit. Porro nesciunt inventore vero alias dicta porro perspiciatis culpa.', 'Blanditiis dolor est et id nam est. Rerum illo voluptas unde aperiam porro.', 'Explicabo est et dolorem.', 'Pending', '2025-12-01 21:50:25', NULL, NULL, '2025-12-13 02:14:36', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(149, 91, 45, 'Soluta placeat culpa aut harum est quasi ut. Quos maxime beatae nobis molestiae recusandae dolorem. Et id minima voluptatem sed est maiores id tempora. Debitis blanditiis culpa reprehenderit mollitia consequuntur voluptas. Fugiat accusamus nostrum sit.', NULL, 'Numquam soluta ut reiciendis sit commodi.', 'Pending', '2025-11-07 00:10:37', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(150, 92, 6, 'Dolorum voluptate vero vel officia nulla sed. Ad saepe exercitationem aliquid voluptatum. Corrupti cupiditate sed aliquam veritatis beatae et explicabo. In laborum et et quia maiores.', NULL, NULL, 'Accepted', '2025-11-23 23:01:43', '2025-11-26 05:12:29', 'Dolores corporis error aliquid explicabo necessitatibus sint.', NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(151, 94, 47, 'Beatae totam provident qui est explicabo enim nihil. Debitis officiis ad cumque molestias ea molestias voluptatem. Natus vero assumenda qui qui explicabo enim est. Eius veritatis eum sed fugit illo qui porro autem. Dicta rerum itaque ut error sed est.', 'Pariatur animi praesentium minus quis et. Et qui consequatur quod illum.', NULL, 'Rejected', '2025-11-15 11:50:15', '2025-11-22 10:18:56', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(152, 95, 7, 'Accusamus corrupti quas non. Eos repellat iure odio consequatur libero est modi. Voluptate beatae nihil et facilis fugit. Blanditiis qui qui magnam modi vitae perferendis officia. Nihil quibusdam animi et voluptatem voluptatem nemo.', NULL, NULL, 'Under Review', '2025-11-06 10:09:25', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(153, 95, 16, 'Molestiae a eos voluptatum sunt veniam voluptas reiciendis. Totam vitae nobis ab magni unde dicta. Modi sunt doloribus accusantium. Natus voluptatem eum nam iusto nostrum qui.', 'Voluptatum ea quae dolorem. Deleniti voluptate sit aut quod nihil. Animi adipisci quisquam est numquam.', NULL, 'Accepted', '2025-11-28 06:03:31', '2025-11-29 18:58:35', 'Animi totam quis magni quas unde est.', '2025-12-09 22:44:33', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(154, 95, 41, 'Occaecati sit atque facilis ut esse eligendi. Quis unde ut corrupti quia veritatis. Id et voluptatem deleniti enim inventore omnis soluta. Recusandae sit maiores quaerat cupiditate non. Officiis vitae id porro unde officiis eum accusantium et.', NULL, NULL, 'Under Review', '2025-12-01 04:31:57', NULL, NULL, '2025-12-08 16:24:57', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(155, 98, 29, 'Vitae autem adipisci maiores suscipit possimus. Consequatur fugit ut ad aperiam et ea. Explicabo fugiat vero et cumque. Ex debitis totam quia libero minus. Quaerat accusamus dignissimos nisi sit. Sunt quia qui inventore expedita magni.', NULL, 'Voluptatem dolor est earum est excepturi est.', 'Rejected', '2025-11-08 14:37:35', '2025-11-17 09:39:33', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(156, 98, 30, 'Ut neque sequi odit aspernatur eaque id. Repudiandae qui voluptatem quo dolores illum. Rerum itaque labore sit velit ab deserunt nihil.', 'A molestias inventore non beatae. Et quod omnis sed expedita omnis ut voluptates quis.', NULL, 'Accepted', '2025-12-03 14:26:59', '2025-12-04 08:51:22', 'At modi non voluptates vel.', '2025-12-12 05:38:10', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(157, 98, 33, 'Vero blanditiis consequatur sit quasi nemo possimus. Voluptas eum ipsa illo eos iusto temporibus voluptas. Unde fugiat veniam consequatur totam.', 'Itaque voluptate qui eum repudiandae qui officiis sit. Unde sed adipisci architecto ex iure aut. Quo eum rerum ut eos ut.', 'Ratione laboriosam quod voluptatem illum eaque atque nisi.', 'Withdrawn', '2025-11-11 00:39:59', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(158, 99, 19, 'Ab ut similique nulla minima. A adipisci ut molestiae adipisci. Officiis quam eligendi minus et. Quibusdam iure quidem eum perspiciatis est.', 'Ea pariatur error fugit quo. Temporibus ipsum ullam ut voluptas itaque sed.', 'Eius quidem sed deserunt nesciunt odit.', 'Rejected', '2025-11-23 00:35:06', '2025-12-01 20:48:46', NULL, '2025-12-05 10:31:12', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(159, 99, 26, 'Voluptate animi voluptatem non a reprehenderit et laborum nesciunt. Debitis ut suscipit neque ea. Atque laborum a incidunt omnis dolores aut exercitationem dolor. Et perspiciatis voluptatem ut. Blanditiis cupiditate occaecati praesentium sunt tempore. Sed animi nemo laboriosam quia.', 'Quis sit architecto cumque pariatur eveniet id voluptatem. Repudiandae ducimus accusantium quam. Corrupti unde cum explicabo corporis.', 'Deleniti doloremque repellat nostrum vitae nihil.', 'Withdrawn', '2025-11-10 20:38:42', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(160, 99, 47, 'Saepe eveniet error eum ea aperiam voluptas odio. Et in maiores quidem voluptatem illo sed nulla. Dicta nobis est dolores ullam. Laborum quidem minus nulla.', NULL, 'Quia ut eum maxime tempora provident distinctio nesciunt.', 'Withdrawn', '2025-12-02 02:03:32', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(161, 101, 2, 'Voluptatem quidem incidunt ullam quia nam. Est nesciunt dolor impedit. Quae qui cupiditate quis necessitatibus. Ea fuga laudantium perspiciatis iure voluptates totam. Quas quo aperiam est aut voluptas non. Officia illo sit veniam temporibus numquam ut.', NULL, NULL, 'Rejected', '2025-11-11 18:30:00', '2025-12-03 13:07:19', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(162, 101, 4, 'Autem error culpa ea velit. Necessitatibus culpa culpa cupiditate placeat cumque. Aut commodi itaque soluta dicta amet.', 'Nihil exercitationem accusamus atque. Dolore deleniti minus repellendus est vel. Mollitia dolor nulla est dolores ipsam itaque.', 'Iure magni ea qui voluptatum aliquid sint nemo.', 'Under Review', '2025-11-29 01:52:51', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(163, 101, 29, 'Esse pariatur perspiciatis dolore labore eligendi eligendi. Deserunt consequuntur ab sed blanditiis repudiandae. Qui non rerum et quo animi.', NULL, 'Accusamus sapiente aut ex quia ut.', 'Under Review', '2025-12-01 16:40:04', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(164, 101, 39, 'Impedit ab voluptas voluptatibus molestias dolores alias. Dolorem reiciendis at facere ea molestias occaecati. Eaque consectetur fuga sit eligendi nihil est ratione. Est cumque dignissimos qui doloribus optio. Fuga eos voluptatem in dolores dolorem in.', 'Asperiores et odit alias quia. Quisquam saepe non repellendus quia et est voluptas. Rerum quas et et vel omnis.', NULL, 'Withdrawn', '2025-11-26 21:43:44', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(165, 101, 41, 'Optio laborum non praesentium dolores non voluptas. Deserunt laboriosam necessitatibus et ut recusandae at consequatur omnis. Voluptatem quia necessitatibus animi ratione. Occaecati enim porro quam sit quo error dolorem reiciendis. Et et suscipit deserunt sed quo iste.', NULL, 'Reprehenderit saepe quam quod molestias.', 'Under Review', '2025-12-02 19:52:43', NULL, NULL, '2025-12-15 00:31:47', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(166, 105, 8, 'Expedita quisquam ducimus totam laborum consequuntur dolorum qui. Vel earum dignissimos dolorum. Inventore magni aut nesciunt dignissimos cum. Laudantium ratione quam voluptate dolore cupiditate sapiente. Iure quisquam hic omnis reiciendis eos.', NULL, 'Debitis tempora eum voluptatem et qui fuga.', 'Rejected', '2025-11-07 22:58:12', '2025-11-30 23:41:00', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(167, 105, 15, 'Consectetur architecto eos porro hic ut. Nam recusandae voluptas sit et magnam. Qui ut repudiandae soluta eligendi aut. Dolorum similique eos placeat quia quas iste quaerat.', 'Quas velit non ipsum inventore. In voluptatibus sequi alias voluptas voluptas odio. Inventore aperiam aut sunt nam veritatis.', 'Dolor incidunt magnam quia est vero a.', 'Pending', '2025-12-03 17:31:59', NULL, NULL, '2025-12-10 21:33:06', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(168, 105, 21, 'Consectetur quisquam et corporis voluptas et ratione. Quam vel eveniet atque quo omnis et error. Iusto amet pariatur rem similique voluptate excepturi dignissimos tempore. Mollitia aut eum eaque itaque aperiam. Nesciunt quia iure accusantium minus a.', 'Qui nostrum est mollitia aut asperiores totam exercitationem. Aliquid omnis aspernatur voluptatem impedit amet natus.', NULL, 'Pending', '2025-11-19 05:36:22', NULL, NULL, '2025-12-15 20:05:07', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(169, 105, 32, 'Ut praesentium optio iusto repellendus. Id earum est similique in facilis. Totam voluptate consequatur magni voluptate aperiam officiis saepe.', 'Culpa quibusdam maxime eum saepe. Sed minus voluptatibus nihil ut quos ipsa.', 'Corporis et eum aliquid quae occaecati quia eligendi.', 'Pending', '2025-11-10 05:57:28', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(170, 105, 45, 'Praesentium non est assumenda. Vel quia nihil velit aliquid pariatur. Excepturi at impedit optio veritatis laboriosam. Modi esse sunt et ut quisquam velit est quibusdam. Dolore aut dolorum vel et delectus dolore et hic.', 'Sunt cupiditate eos eum et aliquam. Quaerat aperiam velit quia illum. Necessitatibus veritatis ea expedita.', NULL, 'Under Review', '2025-11-20 08:41:15', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(171, 106, 10, 'Molestias saepe et esse consectetur et officia suscipit. Laboriosam quia aut aut est ut culpa possimus mollitia. Iusto modi repellendus vitae et enim. Et voluptatibus ut repellendus. Quia deleniti quod provident rerum.', 'Qui culpa voluptatem itaque aliquam voluptatem. Inventore repellat ut minima ex doloribus delectus. Dignissimos veniam doloremque minus eum.', NULL, 'Pending', '2025-11-10 13:33:16', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(172, 106, 13, 'Eos voluptas repellat consequuntur. Veniam ut dignissimos aspernatur voluptatem excepturi ut. Voluptas facilis fuga facere dolore tempore eum. Aut earum asperiores dolores odio id. Dignissimos delectus et neque voluptatem iure. Distinctio nihil accusantium magnam possimus.', 'Nobis nulla voluptatum inventore exercitationem. Error architecto magni voluptatum at rem soluta dicta.', NULL, 'Under Review', '2025-11-22 11:13:38', NULL, NULL, '2025-12-04 23:46:26', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(173, 106, 27, 'Id autem dicta sed et. Praesentium sunt sint quae modi. Veritatis dolorum deleniti sapiente laudantium tempore. Est eveniet ipsa laboriosam magnam recusandae suscipit qui.', NULL, 'Est odio doloremque tempore fugit et quae quia.', 'Rejected', '2025-11-12 18:02:18', '2025-11-17 17:24:10', NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(174, 106, 33, 'Accusamus repellat pariatur itaque. Et est similique quis laudantium. Placeat itaque earum eum omnis ut voluptatem nemo. Incidunt ut nemo aut dolorem nam natus.', 'Alias recusandae minima ipsa porro ad. Et et est repudiandae commodi amet. Impedit quis nam ipsam ut facilis.', NULL, 'Pending', '2025-11-28 09:03:56', NULL, NULL, NULL, '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(175, 106, 44, 'Consequatur illum nulla quo modi qui. Debitis beatae natus qui porro cupiditate id expedita. Accusamus aspernatur placeat natus. Sapiente harum saepe dolor quae ea. Esse qui fugit unde quibusdam fugiat id.', NULL, 'Sed minus quis debitis.', 'Rejected', '2025-11-13 15:21:59', '2025-11-15 22:27:16', NULL, '2025-12-06 06:30:59', '2025-12-04 16:29:01', '2025-12-04 16:29:01'),
(176, 8, 350, 'ok', 'oko', 'ok', 'Withdrawn', '2025-12-09 03:58:18', NULL, NULL, NULL, '2025-12-09 03:58:18', '2025-12-09 05:27:20'),
(177, 109, 350, 'Chia sẻ động lực và niềm đam mê của tôi', 'Tôi đã từng rồi hihi', 'Tối rảnh', 'Accepted', '2025-12-09 05:23:23', NULL, NULL, NULL, '2025-12-09 05:23:23', '2025-12-09 05:23:23');

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

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `icon`, `color`, `is_active`, `display_order`, `created_at`) VALUES
(1, 'Education', 'Teaching and training activities', 'fas fa-graduation-cap', '#3B82F6', 1, 1, '2025-12-04 16:28:41'),
(2, 'Healthcare', 'Medical and health support', 'fas fa-heartbeat', '#EF4444', 1, 2, '2025-12-04 16:28:41'),
(3, 'Environment', 'Environmental protection', 'fas fa-leaf', '#10B981', 1, 3, '2025-12-04 16:28:41'),
(4, 'Community', 'Community development', 'fas fa-users', '#8B5CF6', 1, 4, '2025-12-04 16:28:41'),
(5, 'Children', 'Child care and support', 'fas fa-child', '#F59E0B', 1, 5, '2025-12-04 16:28:41'),
(6, 'Elderly', 'Elder care services', 'fas fa-user-friends', '#6B7280', 1, 6, '2025-12-04 16:28:41'),
(7, 'Disaster Relief', 'Emergency response', 'fas fa-hands-helping', '#DC2626', 1, 7, '2025-12-04 16:28:41'),
(8, 'Animals', 'Animal welfare', 'fas fa-paw', '#059669', 1, 8, '2025-12-04 16:28:41'),
(9, 'sint', 'Vel voluptatem sapiente nemo ea eum.', 'fas fa-ut', '#5e9165', 1, 45, '2025-12-04 16:29:41'),
(10, 'dolor', 'Itaque et magnam explicabo quia non minus.', 'fas fa-velit', '#cd53fe', 1, 29, '2025-12-04 16:29:47'),
(11, 'et', 'Vel aut suscipit deserunt quo facilis asperiores.', 'fas fa-neque', '#346271', 1, 17, '2025-12-04 16:30:02'),
(12, 'quia', 'Vitae qui voluptatem accusantium quam nemo.', 'fas fa-in', '#910892', 1, 84, '2025-12-04 16:30:10');

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
-- Đang đổ dữ liệu cho bảng `connections`
--

INSERT INTO `connections` (`connection_id`, `user_id`, `friend_id`, `status`, `action_user_id`, `requested_at`, `accepted_at`, `blocked_at`, `created_at`, `updated_at`) VALUES
(1, 350, 349, 'pending', 350, '2025-12-09 04:02:37', NULL, NULL, '2025-12-09 04:02:37', '2025-12-09 04:02:37'),
(2, 350, 347, 'accepted', 347, '2025-12-09 14:18:59', '2025-12-09 14:20:16', NULL, '2025-12-09 14:18:59', '2025-12-09 14:20:16');

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

--
-- Đang đổ dữ liệu cho bảng `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `conversation_type`, `title`, `opportunity_id`, `created_by`, `last_message_at`, `is_active`, `created_at`) VALUES
(1, 'direct', NULL, NULL, 72, '2025-11-30 11:15:03', 1, '2025-12-04 16:29:03'),
(2, 'direct', NULL, NULL, 84, '2025-11-28 02:07:15', 1, '2025-12-04 16:29:06'),
(3, 'direct', NULL, NULL, 95, '2025-11-29 05:19:10', 1, '2025-12-04 16:29:09'),
(4, 'group', 'Ea quia quod illum.', NULL, 113, '2025-12-02 11:58:05', 1, '2025-12-04 16:29:14'),
(5, 'direct', NULL, NULL, 120, '2025-12-01 01:57:20', 1, '2025-12-04 16:29:16'),
(6, 'group', 'Cumque asperiores modi.', NULL, 138, '2025-12-01 19:25:51', 1, '2025-12-04 16:29:20'),
(7, 'group', 'Sit non optio aut.', NULL, 152, '2025-11-29 06:14:12', 1, '2025-12-04 16:29:24'),
(8, 'group', 'Ut consequuntur dolor et.', NULL, 165, '2025-12-04 06:57:48', 1, '2025-12-04 16:29:28'),
(9, 'group', 'Voluptatem molestiae non.', NULL, 179, '2025-11-28 12:21:14', 1, '2025-12-04 16:29:31'),
(10, 'group', 'Voluptas quos.', NULL, 196, '2025-11-27 19:48:12', 1, '2025-12-04 16:29:36'),
(11, 'opportunity_chat', NULL, 107, 216, '2025-11-30 19:18:28', 1, '2025-12-04 16:29:41'),
(12, 'opportunity_chat', NULL, 108, 238, '2025-12-01 19:18:57', 1, '2025-12-04 16:29:47'),
(13, 'group', 'Ut qui odit aut libero.', NULL, 256, '2025-11-30 19:13:20', 1, '2025-12-04 16:29:52'),
(14, 'direct', NULL, NULL, 262, '2025-12-04 08:19:25', 1, '2025-12-04 16:29:54'),
(15, 'group', 'Eum tempore eveniet officia.', NULL, 268, '2025-11-27 18:25:46', 1, '2025-12-04 16:29:55'),
(16, 'direct', NULL, NULL, 277, '2025-11-29 19:44:07', 1, '2025-12-04 16:29:57'),
(17, 'opportunity_chat', NULL, 109, 296, '2025-12-03 06:31:46', 1, '2025-12-04 16:30:02'),
(18, 'direct', NULL, NULL, 311, '2025-11-28 22:27:34', 1, '2025-12-04 16:30:06'),
(19, 'opportunity_chat', NULL, 110, 325, '2025-12-02 17:29:35', 1, '2025-12-04 16:30:10'),
(20, 'direct', NULL, NULL, 335, '2025-11-29 10:44:56', 1, '2025-12-04 16:30:13'),
(21, 'direct', 'Chat với ab baciac', NULL, 347, '2025-12-09 14:27:50', 1, '2025-12-09 14:20:37');

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

--
-- Đang đổ dữ liệu cho bảng `conversation_participants`
--

INSERT INTO `conversation_participants` (`participant_id`, `conversation_id`, `user_id`, `joined_at`, `last_read_at`, `unread_count`, `is_active`) VALUES
(1, 21, 347, '2025-12-09 14:20:37', '2025-12-09 14:27:51', 0, 1),
(2, 21, 350, '2025-12-09 14:20:37', '2025-12-09 14:27:38', 0, 1);

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

--
-- Đang đổ dữ liệu cho bảng `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `opportunity_id`, `notes`, `created_at`) VALUES
(1, 4, 32, 'Odio quidem odit ipsum ab.', '2025-12-04 16:30:16'),
(2, 4, 45, NULL, '2025-12-04 16:30:16'),
(3, 4, 72, NULL, '2025-12-04 16:30:16'),
(4, 4, 73, 'Ut corrupti perferendis sit voluptatum omnis omnis et voluptatem.', '2025-12-04 16:30:16'),
(5, 6, 7, NULL, '2025-12-04 16:30:16'),
(6, 7, 3, NULL, '2025-12-04 16:30:16'),
(7, 9, 48, NULL, '2025-12-04 16:30:16'),
(8, 9, 77, 'Suscipit doloremque dolore porro.', '2025-12-04 16:30:16'),
(9, 11, 13, 'Et sit a unde error non et.', '2025-12-04 16:30:16'),
(10, 11, 17, NULL, '2025-12-04 16:30:16'),
(11, 11, 72, 'Natus at et eaque ea veritatis.', '2025-12-04 16:30:16'),
(12, 11, 103, NULL, '2025-12-04 16:30:16'),
(13, 12, 99, NULL, '2025-12-04 16:30:16'),
(14, 13, 22, 'Aut rerum eum tenetur ducimus molestiae consequatur laboriosam.', '2025-12-04 16:30:16'),
(15, 17, 68, NULL, '2025-12-04 16:30:16'),
(16, 20, 3, NULL, '2025-12-04 16:30:16'),
(17, 20, 33, 'Aut sed quo ducimus sit expedita cupiditate voluptatibus.', '2025-12-04 16:30:16'),
(18, 20, 34, NULL, '2025-12-04 16:30:16'),
(19, 20, 70, 'Veniam delectus quis numquam atque aut.', '2025-12-04 16:30:16'),
(20, 20, 92, NULL, '2025-12-04 16:30:16'),
(21, 21, 53, 'Non illum numquam dignissimos similique velit.', '2025-12-04 16:30:16'),
(22, 22, 5, NULL, '2025-12-04 16:30:16'),
(23, 23, 32, NULL, '2025-12-04 16:30:16'),
(24, 24, 6, 'Culpa officiis recusandae dolores aut molestiae rerum aut.', '2025-12-04 16:30:16'),
(25, 24, 77, NULL, '2025-12-04 16:30:16'),
(26, 29, 1, 'Cumque eaque maiores iste eum a.', '2025-12-04 16:30:16'),
(27, 29, 22, NULL, '2025-12-04 16:30:16'),
(28, 29, 25, NULL, '2025-12-04 16:30:16'),
(29, 30, 8, 'Distinctio qui rerum molestias magni enim.', '2025-12-04 16:30:16'),
(30, 30, 30, 'Et suscipit ut ut.', '2025-12-04 16:30:16'),
(31, 30, 87, NULL, '2025-12-04 16:30:16'),
(32, 30, 95, 'Quaerat numquam minus in veritatis est nemo.', '2025-12-04 16:30:16'),
(33, 31, 20, NULL, '2025-12-04 16:30:16'),
(34, 31, 97, NULL, '2025-12-04 16:30:16'),
(35, 32, 42, 'Corporis pariatur repudiandae sed sint id voluptas pariatur.', '2025-12-04 16:30:16'),
(36, 32, 64, 'Veniam autem animi nihil inventore.', '2025-12-04 16:30:16'),
(37, 32, 84, 'Qui corrupti modi quod tenetur magni repellat voluptate.', '2025-12-04 16:30:16'),
(38, 33, 9, 'Sit placeat quas cupiditate occaecati itaque error.', '2025-12-04 16:30:16'),
(39, 33, 36, 'Quasi quibusdam facilis explicabo voluptatum perferendis totam consequatur.', '2025-12-04 16:30:16'),
(40, 33, 42, 'Iste est error soluta non sit.', '2025-12-04 16:30:16'),
(41, 33, 60, NULL, '2025-12-04 16:30:16'),
(42, 34, 10, NULL, '2025-12-04 16:30:16'),
(43, 37, 39, 'In quia inventore dolorem id et.', '2025-12-04 16:30:16'),
(44, 37, 64, 'Quas officiis id corporis deserunt voluptates.', '2025-12-04 16:30:16'),
(45, 37, 73, 'Rerum aut vel amet aperiam.', '2025-12-04 16:30:16'),
(46, 37, 79, 'Vitae voluptas eum saepe repellat eius.', '2025-12-04 16:30:16'),
(47, 38, 17, 'Culpa perspiciatis possimus ut blanditiis veritatis non et.', '2025-12-04 16:30:16'),
(48, 38, 48, NULL, '2025-12-04 16:30:16'),
(49, 38, 95, 'Vitae delectus deleniti deserunt iste ut in dicta sed.', '2025-12-04 16:30:16'),
(50, 39, 16, NULL, '2025-12-04 16:30:16'),
(51, 40, 26, NULL, '2025-12-04 16:30:16'),
(52, 40, 29, NULL, '2025-12-04 16:30:16'),
(53, 40, 33, NULL, '2025-12-04 16:30:16'),
(54, 40, 54, 'Aut atque et commodi itaque perferendis deserunt.', '2025-12-04 16:30:16'),
(55, 40, 63, 'Beatae autem eaque quo sunt dolorum nam.', '2025-12-04 16:30:16'),
(56, 42, 23, NULL, '2025-12-04 16:30:16'),
(57, 42, 70, NULL, '2025-12-04 16:30:16'),
(58, 43, 34, NULL, '2025-12-04 16:30:16'),
(59, 43, 44, 'Cumque perferendis saepe aspernatur fugiat qui excepturi repudiandae commodi.', '2025-12-04 16:30:16'),
(60, 43, 76, 'Libero dignissimos provident tempore ut eum tempora sed.', '2025-12-04 16:30:16'),
(61, 43, 78, 'Quaerat qui recusandae nemo non est recusandae voluptatem dolores.', '2025-12-04 16:30:16'),
(62, 43, 82, 'Esse dolore animi eos laudantium rerum suscipit impedit.', '2025-12-04 16:30:16'),
(63, 44, 32, NULL, '2025-12-04 16:30:16'),
(64, 44, 96, 'Qui animi sunt iure nihil qui soluta quod excepturi.', '2025-12-04 16:30:16'),
(65, 45, 27, 'Perspiciatis qui atque eum illum numquam in voluptatibus facere.', '2025-12-04 16:30:16'),
(66, 45, 36, 'Assumenda impedit nemo quisquam aliquam iste pariatur.', '2025-12-04 16:30:16'),
(67, 45, 57, NULL, '2025-12-04 16:30:16'),
(68, 45, 94, 'Laudantium ut architecto saepe earum repellat ut.', '2025-12-04 16:30:16'),
(69, 45, 103, NULL, '2025-12-04 16:30:16'),
(70, 46, 1, NULL, '2025-12-04 16:30:16'),
(71, 46, 36, NULL, '2025-12-04 16:30:16'),
(72, 46, 53, NULL, '2025-12-04 16:30:16'),
(73, 46, 91, NULL, '2025-12-04 16:30:16'),
(74, 48, 7, 'Nulla voluptatem aut quae et.', '2025-12-04 16:30:16'),
(75, 48, 75, NULL, '2025-12-04 16:30:16'),
(76, 50, 5, 'Ea quae voluptate eius et nostrum repellendus esse.', '2025-12-04 16:30:16'),
(77, 50, 28, NULL, '2025-12-04 16:30:16'),
(78, 50, 63, 'Ea et sint commodi qui similique asperiores.', '2025-12-04 16:30:16'),
(87, 350, 82, 'oke em', '2025-12-09 05:46:39'),
(90, 350, 109, NULL, '2025-12-09 06:23:52'),
(92, 350, 104, NULL, '2025-12-09 06:26:07');

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

--
-- Đang đổ dữ liệu cho bảng `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"76b2d3b3-aa7b-4d27-bc31-1f4eb8472497\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:1;s:6:\\\"roomId\\\";s:22:\\\"agora_2yaebmcCsP4sFKHR\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:347;s:4:\\\"name\\\";s:19:\\\"Đạt Hoàng Quang\\\";s:10:\\\"receiverId\\\";i:350;}s:8:\\\"callType\\\";s:5:\\\"audio\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290147,\"delay\":null}', 0, NULL, 1765290147, 1765290147),
(2, 'default', '{\"uuid\":\"4b01e9e1-84e0-4828-a14b-549b214c7245\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:1;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:23:27.233019\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290147,\"delay\":60}', 0, NULL, 1765290207, 1765290147),
(3, 'default', '{\"uuid\":\"0daeecfd-8708-4dbe-8900-54cf6da417b8\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:2;s:6:\\\"roomId\\\";s:22:\\\"agora_G7shCrFhi40JQ4Uh\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:347;s:4:\\\"name\\\";s:19:\\\"Đạt Hoàng Quang\\\";s:10:\\\"receiverId\\\";i:350;}s:8:\\\"callType\\\";s:5:\\\"audio\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290147,\"delay\":null}', 0, NULL, 1765290147, 1765290147),
(4, 'default', '{\"uuid\":\"a89c822f-ba6e-41b3-9e21-d3b0a806b73c\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:2;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:23:27.677157\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290147,\"delay\":60}', 0, NULL, 1765290207, 1765290147),
(5, 'default', '{\"uuid\":\"67632734-2a91-46ea-b63c-5fab24ad5ccd\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:3;s:6:\\\"roomId\\\";s:22:\\\"agora_gzsPSW2FPpzLUFLv\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:350;s:4:\\\"name\\\";s:9:\\\"ab baciac\\\";s:10:\\\"receiverId\\\";i:347;}s:8:\\\"callType\\\";s:5:\\\"audio\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290214,\"delay\":null}', 0, NULL, 1765290214, 1765290214),
(6, 'default', '{\"uuid\":\"7d616828-eabc-45bd-ab3b-04680341fe52\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:3;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:24:34.944968\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290214,\"delay\":60}', 0, NULL, 1765290274, 1765290214),
(7, 'default', '{\"uuid\":\"b7aca8dd-dcc9-42dc-bf0e-134988aeae84\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:4;s:6:\\\"roomId\\\";s:22:\\\"agora_GIes9jhdEmKUNDX5\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:350;s:4:\\\"name\\\";s:9:\\\"ab baciac\\\";s:10:\\\"receiverId\\\";i:347;}s:8:\\\"callType\\\";s:5:\\\"audio\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290215,\"delay\":null}', 0, NULL, 1765290215, 1765290215),
(8, 'default', '{\"uuid\":\"f245d827-8e49-4176-a0f9-e09f8f862fef\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:4;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:24:35.361922\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290215,\"delay\":60}', 0, NULL, 1765290275, 1765290215),
(9, 'default', '{\"uuid\":\"09d66fb9-5372-4d21-991e-f3251ec318a8\",\"displayName\":\"App\\\\Events\\\\CallEnded\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:20:\\\"App\\\\Events\\\\CallEnded\\\":3:{s:6:\\\"callId\\\";i:4;s:8:\\\"duration\\\";i:0;s:7:\\\"endedBy\\\";i:350;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290222,\"delay\":null}', 0, NULL, 1765290222, 1765290222),
(10, 'default', '{\"uuid\":\"aeb2a7c4-1e9d-4ec4-b105-4d2e804b38a3\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:5;s:6:\\\"roomId\\\";s:22:\\\"agora_RKBWgBtTTiDEKgnc\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:347;s:4:\\\"name\\\";s:19:\\\"Đạt Hoàng Quang\\\";s:10:\\\"receiverId\\\";i:350;}s:8:\\\"callType\\\";s:5:\\\"video\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290235,\"delay\":null}', 0, NULL, 1765290235, 1765290235),
(11, 'default', '{\"uuid\":\"d1776f84-c470-4dd3-b74a-dc6f64056bc6\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:5;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:24:55.690665\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290235,\"delay\":60}', 0, NULL, 1765290295, 1765290235),
(12, 'default', '{\"uuid\":\"48f4c04c-92e9-4863-bdbd-49bc585da6a7\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:6;s:6:\\\"roomId\\\";s:22:\\\"agora_ezDPwjxrmnsUMDSH\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:347;s:4:\\\"name\\\";s:19:\\\"Đạt Hoàng Quang\\\";s:10:\\\"receiverId\\\";i:350;}s:8:\\\"callType\\\";s:5:\\\"video\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290236,\"delay\":null}', 0, NULL, 1765290236, 1765290236),
(13, 'default', '{\"uuid\":\"f4dcf813-4cd3-494a-acef-023c8fe8cb36\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:6;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:24:56.106031\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290236,\"delay\":60}', 0, NULL, 1765290296, 1765290236),
(14, 'default', '{\"uuid\":\"dc8914b0-6a69-49e6-b56c-1b229a45daba\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:7;s:6:\\\"roomId\\\";s:22:\\\"agora_8hhfb3UOAEa5uCbq\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:350;s:4:\\\"name\\\";s:9:\\\"ab baciac\\\";s:10:\\\"receiverId\\\";i:347;}s:8:\\\"callType\\\";s:5:\\\"video\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290281,\"delay\":null}', 0, NULL, 1765290281, 1765290281),
(15, 'default', '{\"uuid\":\"68d2211e-7af9-49c5-ae2d-35765c38e998\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:7;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:25:41.799791\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290281,\"delay\":60}', 0, NULL, 1765290341, 1765290281),
(16, 'default', '{\"uuid\":\"3866236b-e490-4383-9075-f257a4298a1c\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:8;s:6:\\\"roomId\\\";s:22:\\\"agora_nvXuIdTftBpTfCdn\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:350;s:4:\\\"name\\\";s:9:\\\"ab baciac\\\";s:10:\\\"receiverId\\\";i:347;}s:8:\\\"callType\\\";s:5:\\\"video\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290282,\"delay\":null}', 0, NULL, 1765290282, 1765290282),
(17, 'default', '{\"uuid\":\"f19529b2-9415-40bb-880f-74a500ab6d27\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:8;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:25:42.289776\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290282,\"delay\":60}', 0, NULL, 1765290342, 1765290282),
(18, 'default', '{\"uuid\":\"6e2efa6a-4f50-4a88-843c-c9492905d63d\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:9;s:6:\\\"roomId\\\";s:22:\\\"agora_LSuAJBssyiyZG74h\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:347;s:4:\\\"name\\\";s:19:\\\"Đạt Hoàng Quang\\\";s:10:\\\"receiverId\\\";i:350;}s:8:\\\"callType\\\";s:5:\\\"video\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290297,\"delay\":null}', 0, NULL, 1765290297, 1765290297),
(19, 'default', '{\"uuid\":\"fa6fc7ab-063f-4a5a-abae-759fdf3d3394\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:9;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:25:57.129779\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290297,\"delay\":60}', 0, NULL, 1765290357, 1765290297),
(20, 'default', '{\"uuid\":\"45248f0e-059c-4963-a980-909d8fc98212\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:10;s:6:\\\"roomId\\\";s:22:\\\"agora_ypdIEQtxmxLCjOsi\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:347;s:4:\\\"name\\\";s:19:\\\"Đạt Hoàng Quang\\\";s:10:\\\"receiverId\\\";i:350;}s:8:\\\"callType\\\";s:5:\\\"video\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290297,\"delay\":null}', 0, NULL, 1765290297, 1765290297),
(21, 'default', '{\"uuid\":\"8f05da59-136b-4fba-873d-5dc82cded361\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:10;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:25:57.751743\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290297,\"delay\":60}', 0, NULL, 1765290357, 1765290297),
(22, 'default', '{\"uuid\":\"cb3b056a-0b36-4563-8a52-d487f25cb6c2\",\"displayName\":\"App\\\\Events\\\\CallEnded\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:20:\\\"App\\\\Events\\\\CallEnded\\\":3:{s:6:\\\"callId\\\";i:10;s:8:\\\"duration\\\";i:0;s:7:\\\"endedBy\\\";i:347;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290422,\"delay\":null}', 0, NULL, 1765290422, 1765290422),
(23, 'default', '{\"uuid\":\"36b2dcbe-49d9-496e-9a0e-3fb9f9ba64eb\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:11;s:6:\\\"roomId\\\";s:22:\\\"agora_TcItVdOb6z9SprTj\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:350;s:4:\\\"name\\\";s:9:\\\"ab baciac\\\";s:10:\\\"receiverId\\\";i:347;}s:8:\\\"callType\\\";s:5:\\\"audio\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290473,\"delay\":null}', 0, NULL, 1765290473, 1765290473),
(24, 'default', '{\"uuid\":\"c73af15b-587e-4061-b1d5-5aea211d79e1\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:11;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:28:53.319346\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290473,\"delay\":60}', 0, NULL, 1765290533, 1765290473),
(25, 'default', '{\"uuid\":\"875efa2b-2c13-4768-ae15-9dc0b21e28b5\",\"displayName\":\"App\\\\Events\\\\CallInvitation\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\CallInvitation\\\":4:{s:6:\\\"callId\\\";i:12;s:6:\\\"roomId\\\";s:22:\\\"agora_yQyJW1ClAT09SF8I\\\";s:6:\\\"caller\\\";a:3:{s:2:\\\"id\\\";i:350;s:4:\\\"name\\\";s:9:\\\"ab baciac\\\";s:10:\\\"receiverId\\\";i:347;}s:8:\\\"callType\\\";s:5:\\\"audio\\\";}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290473,\"delay\":null}', 0, NULL, 1765290473, 1765290473),
(26, 'default', '{\"uuid\":\"8197043b-ef2d-4cc0-809d-f360328a0610\",\"displayName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\CheckMissedCall\",\"command\":\"O:24:\\\"App\\\\Jobs\\\\CheckMissedCall\\\":3:{s:9:\\\"\\u0000*\\u0000callId\\\";i:12;s:17:\\\"\\u0000*\\u0000timeoutSeconds\\\";i:60;s:5:\\\"delay\\\";O:25:\\\"Illuminate\\\\Support\\\\Carbon\\\":3:{s:4:\\\"date\\\";s:26:\\\"2025-12-09 21:28:53.712328\\\";s:13:\\\"timezone_type\\\";i:3;s:8:\\\"timezone\\\";s:16:\\\"Asia\\/Ho_Chi_Minh\\\";}}\"},\"createdAt\":1765290473,\"delay\":60}', 0, NULL, 1765290533, 1765290473),
(27, 'default', '{\"uuid\":\"8c330beb-1848-40a8-9bfd-d98fd35843d2\",\"displayName\":\"App\\\\Events\\\\CallEnded\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":16:{s:5:\\\"event\\\";O:20:\\\"App\\\\Events\\\\CallEnded\\\":3:{s:6:\\\"callId\\\";i:12;s:8:\\\"duration\\\";i:0;s:7:\\\"endedBy\\\";i:350;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:12:\\\"messageGroup\\\";N;s:12:\\\"deduplicator\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"},\"createdAt\":1765290549,\"delay\":null}', 0, NULL, 1765290549, 1765290549);

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

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`message_id`, `conversation_id`, `sender_id`, `message_type`, `content`, `attachment_url`, `attachment_name`, `is_deleted`, `sent_at`) VALUES
(1, 1, 73, 'image', NULL, 'https://via.placeholder.com/640x480.png/006655?text=animi', 'ipsa.z1', 0, '2025-11-29 21:55:15'),
(2, 1, 74, 'file', NULL, 'https://via.placeholder.com/640x480.png/003388?text=aut', 'vero.uvvi', 0, '2025-12-02 07:46:16'),
(3, 1, 75, 'file', NULL, 'https://via.placeholder.com/640x480.png/0088ff?text=repellat', 'eaque.ecma', 0, '2025-12-02 21:44:38'),
(4, 1, 76, 'file', NULL, 'https://via.placeholder.com/640x480.png/00dd00?text=repudiandae', 'cum.m3u', 0, '2025-12-03 02:26:17'),
(5, 1, 77, 'image', NULL, 'https://via.placeholder.com/640x480.png/0000dd?text=reprehenderit', 'reprehenderit.docx', 0, '2025-11-30 14:28:06'),
(6, 1, 78, 'file', NULL, 'https://via.placeholder.com/640x480.png/007744?text=nemo', 'enim.sxg', 0, '2025-11-29 19:58:57'),
(7, 1, 79, 'text', 'Odit quas corporis autem debitis voluptatibus enim et. Voluptates aut delectus dignissimos quo id quibusdam. Repellendus alias quod aut vel consequuntur maiores.', NULL, NULL, 0, '2025-11-28 07:02:09'),
(8, 1, 80, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ddee?text=aut', 'qui.unityweb', 0, '2025-12-02 04:26:39'),
(9, 1, 81, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aa33?text=quia', 'excepturi.pcx', 1, '2025-11-29 13:40:58'),
(10, 1, 82, 'image', NULL, 'https://via.placeholder.com/640x480.png/0011aa?text=voluptas', 'earum.uvvm', 0, '2025-11-29 02:16:44'),
(11, 1, 83, 'image', NULL, 'https://via.placeholder.com/640x480.png/006622?text=in', 'modi.p', 0, '2025-11-29 00:28:38'),
(12, 2, 85, 'image', NULL, 'https://via.placeholder.com/640x480.png/0011cc?text=molestiae', 'sed.uvvv', 0, '2025-12-04 08:06:23'),
(13, 2, 86, 'file', NULL, 'https://via.placeholder.com/640x480.png/0055bb?text=impedit', 'et.mseed', 0, '2025-11-30 06:01:15'),
(14, 2, 87, 'file', NULL, 'https://via.placeholder.com/640x480.png/006600?text=numquam', 'molestiae.mus', 0, '2025-11-28 22:36:50'),
(15, 2, 88, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aa22?text=quam', 'ab.png', 0, '2025-12-01 06:51:40'),
(16, 2, 89, 'file', NULL, 'https://via.placeholder.com/640x480.png/00aaff?text=molestias', 'ipsum.jad', 0, '2025-11-29 22:30:45'),
(17, 2, 90, 'image', NULL, 'https://via.placeholder.com/640x480.png/002277?text=neque', 'laudantium.tga', 0, '2025-12-04 01:41:06'),
(18, 2, 91, 'image', NULL, 'https://via.placeholder.com/640x480.png/005544?text=sit', 'laboriosam.wvx', 0, '2025-11-30 08:18:15'),
(19, 2, 92, 'text', 'Repudiandae culpa amet et iste id quo. Quas velit impedit quia adipisci qui. Soluta velit fugiat optio neque.', NULL, NULL, 0, '2025-12-01 19:41:26'),
(20, 2, 93, 'text', 'Eaque et voluptas eius eos rerum nulla. Consequatur similique maxime ducimus eligendi possimus consequuntur vel. Sit qui sit inventore ipsum aliquid enim ea. Totam quaerat in modi atque.', NULL, NULL, 0, '2025-11-29 21:00:51'),
(21, 2, 94, 'image', NULL, 'https://via.placeholder.com/640x480.png/0000dd?text=voluptatibus', 'magnam.uvva', 0, '2025-11-30 01:03:49'),
(22, 3, 96, 'image', NULL, 'https://via.placeholder.com/640x480.png/006699?text=et', 'aliquid.oxt', 0, '2025-11-28 04:16:55'),
(23, 3, 97, 'text', 'Omnis eveniet nihil aut quia libero eos debitis. Cum esse necessitatibus esse. Harum ut quia qui sint voluptate possimus dolor. Amet dolores labore officia odit ut est in.', NULL, NULL, 0, '2025-12-02 08:41:57'),
(24, 3, 98, 'image', NULL, 'https://via.placeholder.com/640x480.png/0011ff?text=minima', 'earum.wdb', 0, '2025-12-04 01:02:27'),
(25, 3, 99, 'video', NULL, 'https://via.placeholder.com/640x480.png/0055ee?text=dolore', 'et.mmf', 0, '2025-12-01 21:32:51'),
(26, 3, 100, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aaaa?text=aut', 'ut.elc', 0, '2025-11-30 21:35:04'),
(27, 3, 101, 'video', NULL, 'https://via.placeholder.com/640x480.png/008899?text=non', 'non.wbxml', 0, '2025-11-29 04:35:17'),
(28, 3, 102, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dddd?text=omnis', 'numquam.xsm', 0, '2025-12-01 12:14:59'),
(29, 3, 103, 'text', 'Est deserunt maiores ad provident libero. Deserunt veniam hic harum. Sequi est illum quis quo est dicta quas aut.', NULL, NULL, 0, '2025-11-29 06:58:53'),
(30, 3, 104, 'image', NULL, 'https://via.placeholder.com/640x480.png/0011bb?text=a', 'sed.java', 0, '2025-12-01 04:04:21'),
(31, 3, 105, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff22?text=facere', 'ducimus.7z', 0, '2025-11-30 19:03:03'),
(32, 3, 106, 'text', 'Id nesciunt et nobis voluptatum voluptatem. Voluptatem autem delectus nesciunt tenetur eos et amet. Cupiditate expedita voluptas cumque enim nemo ut.', NULL, NULL, 0, '2025-11-28 15:01:42'),
(33, 3, 107, 'image', NULL, 'https://via.placeholder.com/640x480.png/0099cc?text=non', 'ut.sxc', 0, '2025-12-04 06:33:06'),
(34, 3, 108, 'text', 'Quo voluptas temporibus modi architecto doloremque placeat quo. Ut magni delectus molestias consequatur suscipit sunt. Placeat recusandae harum voluptatem repudiandae totam corrupti esse. Quia atque et soluta voluptas qui voluptate.', NULL, NULL, 0, '2025-11-29 00:42:19'),
(35, 3, 109, 'file', NULL, 'https://via.placeholder.com/640x480.png/00bbdd?text=repellendus', 'possimus.xpm', 1, '2025-11-28 00:41:26'),
(36, 3, 110, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd66?text=cum', 'doloremque.pls', 0, '2025-12-04 09:11:30'),
(37, 3, 111, 'file', NULL, 'https://via.placeholder.com/640x480.png/000000?text=et', 'recusandae.fpx', 0, '2025-12-01 09:54:46'),
(38, 3, 112, 'image', NULL, 'https://via.placeholder.com/640x480.png/0088aa?text=illo', 'sit.123', 0, '2025-11-30 07:45:49'),
(39, 4, 114, 'video', NULL, 'https://via.placeholder.com/640x480.png/003366?text=modi', 'iste.psd', 0, '2025-12-03 16:30:27'),
(40, 4, 115, 'file', NULL, 'https://via.placeholder.com/640x480.png/00dd44?text=iste', 'illo.sitx', 0, '2025-11-28 16:07:39'),
(41, 4, 116, 'file', NULL, 'https://via.placeholder.com/640x480.png/009933?text=ut', 'labore.pps', 0, '2025-12-04 08:33:45'),
(42, 4, 117, 'image', NULL, 'https://via.placeholder.com/640x480.png/0000cc?text=provident', 'qui.ras', 0, '2025-12-02 11:55:17'),
(43, 4, 118, 'file', NULL, 'https://via.placeholder.com/640x480.png/00aacc?text=illum', 'rerum.gnumeric', 0, '2025-11-30 03:47:55'),
(44, 4, 119, 'image', NULL, 'https://via.placeholder.com/640x480.png/002222?text=rem', 'sed.appcache', 0, '2025-12-01 03:09:26'),
(45, 5, 121, 'image', NULL, 'https://via.placeholder.com/640x480.png/006666?text=quae', 'repellendus.sfd-hdstx', 0, '2025-12-03 04:39:43'),
(46, 5, 122, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee33?text=dolorum', 'modi.t3', 0, '2025-12-02 14:50:09'),
(47, 5, 123, 'video', NULL, 'https://via.placeholder.com/640x480.png/002244?text=perferendis', 'praesentium.ufd', 0, '2025-12-04 04:46:49'),
(48, 5, 124, 'video', NULL, 'https://via.placeholder.com/640x480.png/009966?text=et', 'accusamus.uvd', 0, '2025-11-29 07:11:10'),
(49, 5, 125, 'video', NULL, 'https://via.placeholder.com/640x480.png/003377?text=officiis', 'voluptatem.hdf', 0, '2025-11-28 15:36:07'),
(50, 5, 126, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ccee?text=modi', 'ullam.ogv', 0, '2025-12-03 07:11:36'),
(51, 5, 127, 'image', NULL, 'https://via.placeholder.com/640x480.png/00eeff?text=et', 'inventore.karbon', 0, '2025-11-30 04:13:06'),
(52, 5, 128, 'file', NULL, 'https://via.placeholder.com/640x480.png/004411?text=blanditiis', 'ipsam.js', 0, '2025-12-02 06:12:14'),
(53, 5, 129, 'text', 'Animi commodi sint sit mollitia enim non pariatur. Occaecati vitae consequatur enim sed possimus.', NULL, NULL, 0, '2025-12-01 17:43:14'),
(54, 5, 130, 'file', NULL, 'https://via.placeholder.com/640x480.png/004477?text=dolor', 'optio.link66', 0, '2025-12-02 01:37:02'),
(55, 5, 131, 'image', NULL, 'https://via.placeholder.com/640x480.png/005599?text=fugit', 'in.vsf', 0, '2025-11-29 06:41:48'),
(56, 5, 132, 'video', NULL, 'https://via.placeholder.com/640x480.png/007777?text=unde', 'cum.3gp', 0, '2025-11-28 19:28:45'),
(57, 5, 133, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff22?text=perferendis', 'ratione.mkv', 0, '2025-12-04 03:07:30'),
(58, 5, 134, 'file', NULL, 'https://via.placeholder.com/640x480.png/00bb00?text=debitis', 'culpa.sc', 0, '2025-11-28 07:53:27'),
(59, 5, 135, 'text', 'Voluptatem iusto dolorem nisi quis. Tenetur dignissimos quia nihil doloremque iusto suscipit ut. Aut quia et delectus aspernatur architecto ullam est et. Quia qui nihil sit quaerat ut ullam mollitia.', NULL, NULL, 0, '2025-12-02 20:38:18'),
(60, 5, 136, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff66?text=natus', 'non.ait', 0, '2025-12-01 16:24:03'),
(61, 5, 137, 'text', 'Esse repudiandae odio error blanditiis quia ut magni. Esse id perspiciatis eum possimus. Tempora aut ratione et corrupti dolores aspernatur.', NULL, NULL, 0, '2025-12-03 08:33:35'),
(62, 6, 139, 'file', NULL, 'https://via.placeholder.com/640x480.png/00bb55?text=facere', 'sapiente.uris', 0, '2025-12-03 22:10:23'),
(63, 6, 140, 'image', NULL, 'https://via.placeholder.com/640x480.png/001155?text=magni', 'omnis.xltx', 0, '2025-11-27 20:02:31'),
(64, 6, 141, 'image', NULL, 'https://via.placeholder.com/640x480.png/0011ff?text=voluptatem', 'eligendi.cfs', 0, '2025-12-04 04:24:22'),
(65, 6, 142, 'text', 'Magnam unde qui dolores est doloremque sed. Sunt nam non maxime quia nesciunt quo. Nisi at atque eius voluptates laudantium in cumque nostrum.', NULL, NULL, 0, '2025-11-27 22:24:26'),
(66, 6, 143, 'image', NULL, 'https://via.placeholder.com/640x480.png/006622?text=quisquam', 'est.mj2', 0, '2025-12-02 02:56:58'),
(67, 6, 144, 'file', NULL, 'https://via.placeholder.com/640x480.png/004499?text=culpa', 'voluptatem.m4v', 0, '2025-12-01 18:15:04'),
(68, 6, 145, 'image', NULL, 'https://via.placeholder.com/640x480.png/002266?text=aut', 'voluptatum.link66', 0, '2025-12-03 02:21:03'),
(69, 6, 146, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd55?text=et', 'cupiditate.ics', 0, '2025-11-28 03:32:23'),
(70, 6, 147, 'text', 'Temporibus est animi debitis vero aliquid nihil. Est sequi optio consequatur quo cumque illo.', NULL, NULL, 0, '2025-12-01 02:34:29'),
(71, 6, 148, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ccbb?text=commodi', 'earum.epub', 0, '2025-11-27 18:04:45'),
(72, 6, 149, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ff77?text=doloremque', 'nam.clp', 0, '2025-12-01 09:39:10'),
(73, 6, 150, 'text', 'Dolor molestiae dolorem eveniet rerum animi aliquid. Aliquam excepturi quod ut eum. Non et unde ratione exercitationem ratione ipsa nesciunt. Tempore ducimus et accusantium dolore possimus assumenda eligendi.', NULL, NULL, 0, '2025-12-03 06:07:31'),
(74, 6, 151, 'image', NULL, 'https://via.placeholder.com/640x480.png/002288?text=qui', 'nihil.sit', 0, '2025-12-03 12:56:19'),
(75, 7, 153, 'video', NULL, 'https://via.placeholder.com/640x480.png/0000dd?text=deleniti', 'laudantium.odg', 0, '2025-12-03 17:30:18'),
(76, 7, 154, 'file', NULL, 'https://via.placeholder.com/640x480.png/00dd99?text=sit', 'aut.h263', 0, '2025-12-03 11:59:21'),
(77, 7, 155, 'file', NULL, 'https://via.placeholder.com/640x480.png/000066?text=rerum', 'qui.mka', 0, '2025-12-01 21:47:12'),
(78, 7, 156, 'image', NULL, 'https://via.placeholder.com/640x480.png/0088bb?text=cupiditate', 'quis.pgn', 0, '2025-12-03 04:20:50'),
(79, 7, 157, 'text', 'Ad libero accusamus eos nobis nemo voluptatem. Necessitatibus suscipit corrupti a ab maxime ullam. Quaerat nisi doloremque rerum nostrum ipsam aut. Asperiores corporis rerum et quo amet molestiae corrupti.', NULL, NULL, 0, '2025-11-29 14:00:44'),
(80, 7, 158, 'image', NULL, 'https://via.placeholder.com/640x480.png/00cc00?text=rem', 'laboriosam.ots', 0, '2025-11-27 17:18:36'),
(81, 7, 159, 'image', NULL, 'https://via.placeholder.com/640x480.png/007766?text=provident', 'ratione.fvt', 0, '2025-12-04 15:18:17'),
(82, 7, 160, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ff55?text=vel', 'est.asm', 0, '2025-12-03 05:21:28'),
(83, 7, 161, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ee00?text=consequatur', 'rerum.curl', 0, '2025-11-28 08:53:00'),
(84, 7, 162, 'text', 'Natus ex sit dolore eveniet veritatis accusantium. Et similique molestias ut quis consequuntur eaque ea. Voluptatem eum quam sed. Repellat est cum et itaque.', NULL, NULL, 0, '2025-12-03 06:52:03'),
(85, 7, 163, 'video', NULL, 'https://via.placeholder.com/640x480.png/004422?text=sit', 'quisquam.oxt', 0, '2025-11-28 15:28:28'),
(86, 7, 164, 'text', 'Sint sed nulla aut quo id aspernatur. Velit perferendis magni doloribus cumque quibusdam. Maiores fuga quis officia eligendi vel vitae quasi. In eligendi autem provident eos.', NULL, NULL, 0, '2025-12-03 20:54:55'),
(87, 8, 166, 'image', NULL, 'https://via.placeholder.com/640x480.png/0033cc?text=id', 'illum.vcd', 0, '2025-12-01 12:45:27'),
(88, 8, 167, 'text', 'Ab facilis nisi aut consequatur. Mollitia at fuga ut cum. Et qui dolor enim eaque.', NULL, NULL, 0, '2025-11-30 05:00:27'),
(89, 8, 168, 'text', 'Et saepe occaecati voluptatem est optio ducimus. Vel et vel possimus porro. Ullam voluptatum tempora ducimus recusandae. Accusamus quod voluptatem dolorem et.', NULL, NULL, 0, '2025-11-29 03:28:42'),
(90, 8, 169, 'image', NULL, 'https://via.placeholder.com/640x480.png/004499?text=nemo', 'facilis.dtd', 0, '2025-11-28 22:12:34'),
(91, 8, 170, 'image', NULL, 'https://via.placeholder.com/640x480.png/0000ff?text=error', 'qui.3dml', 0, '2025-12-03 23:37:36'),
(92, 8, 171, 'file', NULL, 'https://via.placeholder.com/640x480.png/0055aa?text=vero', 'est.ief', 0, '2025-12-04 09:28:12'),
(93, 8, 172, 'text', 'Nesciunt veritatis voluptatem vitae quo. Ea nisi dolor asperiores. Esse ducimus omnis error sint. Minima laboriosam tenetur repudiandae voluptatem quisquam corporis fugiat.', NULL, NULL, 0, '2025-11-28 07:38:10'),
(94, 8, 173, 'video', NULL, 'https://via.placeholder.com/640x480.png/00bbaa?text=incidunt', 'earum.eml', 0, '2025-12-02 04:21:48'),
(95, 8, 174, 'file', NULL, 'https://via.placeholder.com/640x480.png/004422?text=magnam', 'pariatur.ftc', 0, '2025-12-03 00:30:38'),
(96, 8, 175, 'image', NULL, 'https://via.placeholder.com/640x480.png/008855?text=praesentium', 'velit.oxt', 0, '2025-11-30 04:05:59'),
(97, 8, 176, 'video', NULL, 'https://via.placeholder.com/640x480.png/007777?text=saepe', 'accusantium.7z', 0, '2025-11-30 15:46:54'),
(98, 8, 177, 'image', NULL, 'https://via.placeholder.com/640x480.png/0088dd?text=quam', 'quisquam.wax', 1, '2025-12-02 07:44:05'),
(99, 8, 178, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ee55?text=similique', 'corporis.odp', 0, '2025-12-02 07:54:41'),
(100, 9, 180, 'text', 'Velit dolorum odio veritatis nostrum nostrum. Omnis cumque molestiae mollitia aspernatur. Velit et rerum voluptas molestiae aspernatur quos minus.', NULL, NULL, 0, '2025-12-01 23:53:45'),
(101, 9, 181, 'video', NULL, 'https://via.placeholder.com/640x480.png/00dd66?text=est', 'similique.xltm', 0, '2025-11-28 11:33:11'),
(102, 9, 182, 'text', 'Veritatis dolor inventore quis reiciendis. Sed iusto quisquam qui dolor nam fuga quae.', NULL, NULL, 0, '2025-12-02 07:50:22'),
(103, 9, 183, 'text', 'Adipisci corporis natus et cupiditate quaerat officia. Voluptate totam sed omnis nihil sint et. Quae aut similique omnis velit. Quia iure sed aut id est voluptatum iusto.', NULL, NULL, 0, '2025-12-02 21:36:21'),
(104, 9, 184, 'file', NULL, 'https://via.placeholder.com/640x480.png/00bbdd?text=molestiae', 'quia.odc', 0, '2025-12-03 23:28:52'),
(105, 9, 185, 'video', NULL, 'https://via.placeholder.com/640x480.png/00bb00?text=ut', 'magnam.wmx', 0, '2025-12-02 19:09:39'),
(106, 9, 186, 'text', 'Voluptatum consequatur fugit ipsum. Fugit aut est cumque quia. Est labore non placeat qui. Et esse esse non vel.', NULL, NULL, 0, '2025-11-29 12:02:07'),
(107, 9, 187, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ee99?text=et', 'sit.class', 0, '2025-11-28 14:59:28'),
(108, 9, 188, 'text', 'Odit tenetur id aut est. Eveniet distinctio repudiandae rerum odit non sunt omnis. Libero voluptate commodi qui recusandae. Possimus asperiores est adipisci autem.', NULL, NULL, 0, '2025-12-02 01:45:42'),
(109, 9, 189, 'video', NULL, 'https://via.placeholder.com/640x480.png/0077bb?text=accusantium', 'veniam.vsf', 1, '2025-11-28 08:59:45'),
(110, 9, 190, 'image', NULL, 'https://via.placeholder.com/640x480.png/007733?text=vero', 'consequatur.uvm', 0, '2025-12-03 01:38:38'),
(111, 9, 191, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ddaa?text=et', 'corrupti.sxm', 0, '2025-12-02 17:53:07'),
(112, 9, 192, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aabb?text=error', 'sint.gnumeric', 0, '2025-11-29 08:24:40'),
(113, 9, 193, 'text', 'Enim provident quae ut eius earum nam voluptates. Sed et quis maxime beatae eaque fuga excepturi recusandae. Tempora qui voluptas repudiandae neque eos et delectus. Sit et blanditiis alias ut vero consequatur.', NULL, NULL, 1, '2025-11-29 02:47:06'),
(114, 9, 194, 'text', 'Et repellat eum nesciunt harum occaecati voluptatem. Veritatis asperiores voluptas necessitatibus impedit quia labore.', NULL, NULL, 0, '2025-11-28 18:57:48'),
(115, 9, 195, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ffdd?text=qui', 'asperiores.cst', 0, '2025-12-03 18:29:48'),
(116, 10, 197, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ddff?text=consequatur', 'consequatur.wbxml', 0, '2025-12-01 11:53:24'),
(117, 10, 198, 'video', NULL, 'https://via.placeholder.com/640x480.png/00bb00?text=alias', 'ut.djvu', 0, '2025-12-03 06:18:15'),
(118, 10, 199, 'image', NULL, 'https://via.placeholder.com/640x480.png/0077dd?text=est', 'quas.sql', 0, '2025-12-03 18:58:27'),
(119, 10, 200, 'image', NULL, 'https://via.placeholder.com/640x480.png/0011ee?text=ab', 'quia.cryptonote', 0, '2025-12-02 10:35:06'),
(120, 10, 201, 'image', NULL, 'https://via.placeholder.com/640x480.png/0088dd?text=tenetur', 'ex.mxu', 0, '2025-11-27 23:07:43'),
(121, 10, 202, 'video', NULL, 'https://via.placeholder.com/640x480.png/005588?text=qui', 'accusamus.eml', 0, '2025-12-04 00:15:52'),
(122, 10, 203, 'text', 'Temporibus ipsam optio est sequi minima qui consequatur. Quos eius ducimus beatae aliquid doloremque eveniet. Ipsa sunt exercitationem vel enim. Pariatur itaque dolores necessitatibus dolores consequatur voluptate molestias placeat.', NULL, NULL, 0, '2025-11-29 15:44:14'),
(123, 10, 204, 'image', NULL, 'https://via.placeholder.com/640x480.png/00cc33?text=sint', 'aut.movie', 0, '2025-11-30 15:31:56'),
(124, 10, 205, 'text', 'Ratione similique iusto ipsam libero. Iure ipsam et ea sed eius. Dolores deserunt inventore et alias.', NULL, NULL, 0, '2025-12-03 04:15:11'),
(125, 10, 206, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aa33?text=aut', 'repellendus.ogx', 0, '2025-12-02 20:15:07'),
(126, 10, 207, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033ff?text=voluptatem', 'quidem.fbs', 0, '2025-12-03 13:02:16'),
(127, 10, 208, 'image', NULL, 'https://via.placeholder.com/640x480.png/00eeff?text=ea', 'perferendis.xpm', 1, '2025-12-01 20:38:47'),
(128, 10, 209, 'file', NULL, 'https://via.placeholder.com/640x480.png/0011ff?text=sed', 'illo.csh', 0, '2025-12-01 05:26:42'),
(129, 10, 210, 'file', NULL, 'https://via.placeholder.com/640x480.png/005533?text=omnis', 'nesciunt.gtar', 0, '2025-11-28 00:22:26'),
(130, 10, 211, 'text', 'Et reiciendis nostrum veritatis mollitia suscipit. Vitae numquam occaecati nihil qui. Ab quisquam cupiditate expedita nemo qui praesentium nulla tenetur. Nihil voluptatum qui veritatis sit repellendus.', NULL, NULL, 0, '2025-11-30 08:24:50'),
(131, 10, 212, 'image', NULL, 'https://via.placeholder.com/640x480.png/00cc44?text=vel', 'harum.obj', 0, '2025-11-29 15:47:57'),
(132, 10, 213, 'image', NULL, 'https://via.placeholder.com/640x480.png/003311?text=quia', 'inventore.dae', 0, '2025-12-02 20:08:06'),
(133, 10, 214, 'text', 'Commodi neque omnis excepturi mollitia ipsa ad. Quibusdam alias vel dolor id qui mollitia. Cupiditate ipsa voluptas eos magni. Dolorum nihil sed ipsa nihil aut a.', NULL, NULL, 0, '2025-12-03 05:18:18'),
(134, 11, 217, 'video', NULL, 'https://via.placeholder.com/640x480.png/001155?text=quo', 'aperiam.pnm', 0, '2025-12-02 04:58:29'),
(135, 11, 218, 'text', 'Minima ipsum et quos recusandae occaecati. Sunt dolor ex mollitia vitae praesentium ipsam. Laborum earum consequatur est corrupti esse.', NULL, NULL, 0, '2025-12-03 13:36:40'),
(136, 11, 219, 'text', 'Error dolores facilis labore voluptates sed quasi. Nesciunt quia nobis culpa velit. Magni libero quia beatae laborum molestiae illo. Dolor et aut molestias.', NULL, NULL, 0, '2025-11-30 13:20:22'),
(137, 11, 220, 'text', 'Id iure optio quia dolorem dolorem enim consequatur. Laudantium cumque quae aut et porro corporis eligendi. Inventore ab eum beatae repudiandae corrupti atque est. Rerum aut quaerat ex adipisci est.', NULL, NULL, 0, '2025-11-30 18:58:38'),
(138, 11, 221, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033bb?text=a', 'aut.kia', 0, '2025-11-28 07:46:48'),
(139, 11, 222, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ccee?text=voluptatem', 'autem.ulx', 0, '2025-12-02 13:09:27'),
(140, 11, 223, 'file', NULL, 'https://via.placeholder.com/640x480.png/003377?text=sapiente', 'id.adp', 0, '2025-12-02 18:05:52'),
(141, 11, 224, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd66?text=at', 'magni.mathml', 0, '2025-11-28 23:15:11'),
(142, 11, 225, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033ff?text=nam', 'nihil.dae', 0, '2025-12-03 04:50:26'),
(143, 11, 226, 'text', 'Non aut id ipsa in quas animi autem omnis. Explicabo reiciendis ut ut sed qui autem ea est. Sequi sunt est est voluptatum quisquam placeat quasi. Laudantium totam quo consequatur suscipit quo odio officia.', NULL, NULL, 0, '2025-12-03 05:07:56'),
(144, 11, 227, 'text', 'Eos id sequi ut quos reprehenderit ab repudiandae hic. Aut totam cumque eaque ut quia.', NULL, NULL, 0, '2025-12-02 13:22:08'),
(145, 11, 228, 'video', NULL, 'https://via.placeholder.com/640x480.png/00cc88?text=non', 'velit.m3u', 0, '2025-12-03 08:00:13'),
(146, 11, 229, 'video', NULL, 'https://via.placeholder.com/640x480.png/006688?text=quis', 'inventore.stl', 1, '2025-12-01 17:21:11'),
(147, 11, 230, 'video', NULL, 'https://via.placeholder.com/640x480.png/0000ff?text=autem', 'consequuntur.esf', 0, '2025-11-28 02:13:50'),
(148, 11, 231, 'video', NULL, 'https://via.placeholder.com/640x480.png/0055dd?text=nemo', 'necessitatibus.mseq', 0, '2025-12-03 16:35:29'),
(149, 11, 232, 'image', NULL, 'https://via.placeholder.com/640x480.png/0066cc?text=qui', 'reiciendis.sv4cpio', 0, '2025-12-02 20:10:52'),
(150, 11, 233, 'file', NULL, 'https://via.placeholder.com/640x480.png/0099ff?text=blanditiis', 'nihil.xbm', 0, '2025-12-02 13:59:41'),
(151, 11, 234, 'video', NULL, 'https://via.placeholder.com/640x480.png/004455?text=rem', 'qui.bz', 0, '2025-12-01 15:27:53'),
(152, 11, 235, 'text', 'Qui omnis blanditiis cum quae. Et porro ratione quasi quia rerum quae omnis. Similique voluptate nihil excepturi optio magni. Quae rem sunt consequatur. Consectetur autem impedit illo sequi corrupti.', NULL, NULL, 0, '2025-11-30 22:54:28'),
(153, 11, 236, 'file', NULL, 'https://via.placeholder.com/640x480.png/007799?text=aperiam', 'dolore.eot', 0, '2025-12-03 08:39:04'),
(154, 12, 239, 'text', 'Aut delectus deleniti culpa dolores quaerat architecto non velit. Vitae doloribus quasi reprehenderit dolor eum odio. Ducimus ut qui corrupti quasi animi. Dolorem id consequuntur omnis quis.', NULL, NULL, 0, '2025-11-29 04:51:40'),
(155, 12, 240, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ccdd?text=corporis', 'rerum.ivp', 0, '2025-11-30 11:15:12'),
(156, 12, 241, 'text', 'Quis nisi et minima ut doloremque ipsa sed. Magni ut voluptas aut et. Voluptas necessitatibus odio nesciunt. Officia cum excepturi dolorem.', NULL, NULL, 0, '2025-11-28 04:01:10'),
(157, 12, 242, 'image', NULL, 'https://via.placeholder.com/640x480.png/001111?text=repellat', 'earum.rtf', 0, '2025-11-30 14:52:54'),
(158, 12, 243, 'image', NULL, 'https://via.placeholder.com/640x480.png/006600?text=alias', 'et.oxt', 0, '2025-11-28 09:14:08'),
(159, 12, 244, 'file', NULL, 'https://via.placeholder.com/640x480.png/0099aa?text=quasi', 'quis.ras', 0, '2025-12-01 06:50:26'),
(160, 12, 245, 'file', NULL, 'https://via.placeholder.com/640x480.png/000099?text=omnis', 'culpa.csv', 0, '2025-11-28 17:32:14'),
(161, 12, 246, 'text', 'Totam laboriosam voluptate necessitatibus architecto consequatur. Labore necessitatibus dignissimos soluta aperiam ullam. Consequatur blanditiis rerum in doloribus. Iusto facilis exercitationem blanditiis eum.', NULL, NULL, 0, '2025-12-01 15:58:01'),
(162, 12, 247, 'text', 'Quisquam eveniet et perferendis doloremque. Ut nihil et odio est non hic sint quo.', NULL, NULL, 1, '2025-12-02 03:05:47'),
(163, 12, 248, 'image', NULL, 'https://via.placeholder.com/640x480.png/0055bb?text=illo', 'quasi.obj', 0, '2025-11-30 06:58:03'),
(164, 12, 249, 'video', NULL, 'https://via.placeholder.com/640x480.png/001111?text=voluptatum', 'exercitationem.jar', 0, '2025-12-01 00:14:34'),
(165, 12, 250, 'video', NULL, 'https://via.placeholder.com/640x480.png/004444?text=quibusdam', 'et.clp', 0, '2025-11-29 05:22:17'),
(166, 12, 251, 'video', NULL, 'https://via.placeholder.com/640x480.png/003377?text=praesentium', 'earum.tfm', 0, '2025-12-03 01:24:24'),
(167, 12, 252, 'file', NULL, 'https://via.placeholder.com/640x480.png/001133?text=voluptatem', 'enim.htke', 0, '2025-11-28 22:30:59'),
(168, 12, 253, 'file', NULL, 'https://via.placeholder.com/640x480.png/0000cc?text=qui', 'tempore.xltm', 0, '2025-12-03 01:45:00'),
(169, 12, 254, 'file', NULL, 'https://via.placeholder.com/640x480.png/008833?text=modi', 'dolor.potx', 0, '2025-11-29 19:59:03'),
(170, 12, 255, 'image', NULL, 'https://via.placeholder.com/640x480.png/0055bb?text=rerum', 'dolorem.wpl', 0, '2025-11-27 18:23:49'),
(171, 13, 257, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd44?text=aspernatur', 'reiciendis.mseq', 0, '2025-11-28 21:31:19'),
(172, 13, 258, 'file', NULL, 'https://via.placeholder.com/640x480.png/003311?text=assumenda', 'rerum.bdm', 0, '2025-12-03 05:36:57'),
(173, 13, 259, 'image', NULL, 'https://via.placeholder.com/640x480.png/00eeaa?text=et', 'laborum.eps', 0, '2025-12-01 07:58:05'),
(174, 13, 260, 'video', NULL, 'https://via.placeholder.com/640x480.png/007733?text=veritatis', 'earum.uvz', 0, '2025-12-01 14:58:00'),
(175, 13, 261, 'text', 'Earum quia quo excepturi dignissimos. Dolores dolores animi quae dolorum et perspiciatis commodi. Officiis molestias sed enim nisi veniam ut.', NULL, NULL, 0, '2025-12-01 11:28:00'),
(176, 14, 263, 'text', 'Quo et quia dolorem nostrum numquam. Temporibus fugit in sint corrupti enim nihil repellat labore. Sequi voluptate debitis ut corporis rerum et. Odio quasi aliquid deleniti assumenda dolor. Excepturi consequatur nihil dolores sed quia molestiae.', NULL, NULL, 0, '2025-11-28 13:29:01'),
(177, 14, 264, 'image', NULL, 'https://via.placeholder.com/640x480.png/0044dd?text=nobis', 'aliquid.obj', 0, '2025-12-04 01:24:24'),
(178, 14, 265, 'file', NULL, 'https://via.placeholder.com/640x480.png/00dd99?text=est', 'voluptatem.obj', 0, '2025-12-03 07:08:24'),
(179, 14, 266, 'file', NULL, 'https://via.placeholder.com/640x480.png/006699?text=nemo', 'deleniti.qwt', 0, '2025-12-01 19:09:08'),
(180, 14, 267, 'text', 'Vel impedit rerum vero. Impedit odit dolorem rerum deleniti. Repellendus perferendis eum laboriosam quia voluptates consequatur aut. Fugit commodi minima et id perspiciatis amet facilis eveniet.', NULL, NULL, 0, '2025-12-02 03:15:34'),
(181, 15, 269, 'video', NULL, 'https://via.placeholder.com/640x480.png/009966?text=quo', 'omnis.ppm', 0, '2025-12-03 17:45:48'),
(182, 15, 270, 'text', 'Quia odio dolorem repellat eos quidem nesciunt aut accusamus. Ullam quis omnis officia aut id itaque. Quis dolorem error rerum vel temporibus aut rerum. Voluptatum ex facilis commodi ut labore error illo veritatis.', NULL, NULL, 1, '2025-11-30 02:38:59'),
(183, 15, 271, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd44?text=beatae', 'qui.odi', 0, '2025-11-27 23:58:37'),
(184, 15, 272, 'file', NULL, 'https://via.placeholder.com/640x480.png/001199?text=deleniti', 'ut.xpi', 0, '2025-12-01 00:38:32'),
(185, 15, 273, 'text', 'Voluptatibus impedit magni aspernatur placeat distinctio vel inventore. Distinctio aut enim quidem omnis commodi commodi ut. Aut laudantium dolor accusamus. Excepturi blanditiis aut voluptates autem ut beatae consequatur.', NULL, NULL, 0, '2025-11-29 23:20:56'),
(186, 15, 274, 'text', 'Deleniti est quia ut voluptate dolor repellat voluptates. Consequatur ipsa dolorem et harum reiciendis. Consequuntur suscipit velit dolores quaerat cum.', NULL, NULL, 0, '2025-11-30 14:38:14'),
(187, 15, 275, 'file', NULL, 'https://via.placeholder.com/640x480.png/002211?text=cupiditate', 'molestiae.tsv', 0, '2025-11-27 16:55:28'),
(188, 15, 276, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ff22?text=quidem', 'autem.xm', 0, '2025-12-02 21:09:46'),
(189, 16, 278, 'image', NULL, 'https://via.placeholder.com/640x480.png/00cc99?text=nulla', 'consequuntur.wml', 0, '2025-12-03 21:39:07'),
(190, 16, 279, 'video', NULL, 'https://via.placeholder.com/640x480.png/006644?text=amet', 'vero.rmp', 0, '2025-12-02 08:07:04'),
(191, 16, 280, 'video', NULL, 'https://via.placeholder.com/640x480.png/005599?text=explicabo', 'ipsa.xpl', 0, '2025-11-28 15:13:34'),
(192, 16, 281, 'image', NULL, 'https://via.placeholder.com/640x480.png/0033bb?text=id', 'qui.odm', 0, '2025-11-30 08:41:00'),
(193, 16, 282, 'image', NULL, 'https://via.placeholder.com/640x480.png/003300?text=velit', 'repellat.fdf', 0, '2025-12-01 04:49:29'),
(194, 16, 283, 'video', NULL, 'https://via.placeholder.com/640x480.png/0077bb?text=optio', 'incidunt.pgp', 0, '2025-11-30 20:14:05'),
(195, 16, 284, 'text', 'Optio vel est aut deserunt aliquid. Ut sunt sunt iusto earum quisquam. Magni et doloribus architecto est eligendi officia enim id. Ducimus ut iusto velit aperiam quasi harum aut. Rerum itaque minima dolores sit dolorum omnis.', NULL, NULL, 0, '2025-11-27 23:43:51'),
(196, 16, 285, 'image', NULL, 'https://via.placeholder.com/640x480.png/0000aa?text=quas', 'quis.odf', 0, '2025-12-01 13:07:42'),
(197, 16, 286, 'image', NULL, 'https://via.placeholder.com/640x480.png/0055aa?text=quam', 'tenetur.chrt', 0, '2025-12-01 16:06:16'),
(198, 16, 287, 'video', NULL, 'https://via.placeholder.com/640x480.png/001100?text=dolore', 'reiciendis.lasxml', 0, '2025-12-01 04:06:50'),
(199, 16, 288, 'text', 'Aut vitae qui adipisci nobis deleniti ducimus ullam. Labore impedit voluptas esse officiis quisquam beatae error esse. Ut temporibus et modi error iusto nobis ipsum.', NULL, NULL, 0, '2025-11-29 18:23:36'),
(200, 16, 289, 'text', 'Rem odio unde tempore rerum magnam optio. Cumque voluptatum rem facilis ipsam minima non. Soluta autem eaque dolore cum.', NULL, NULL, 0, '2025-11-28 12:48:24'),
(201, 16, 290, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ee55?text=expedita', 'dolorem.vtu', 0, '2025-11-29 20:54:14'),
(202, 16, 291, 'text', 'Similique qui sunt expedita ea rerum enim quia. Ab consequatur alias dolores aperiam tempora eum vel alias.', NULL, NULL, 0, '2025-11-29 08:03:30'),
(203, 16, 292, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee99?text=expedita', 'reiciendis.src', 0, '2025-11-30 04:42:53'),
(204, 16, 293, 'text', 'Nemo nulla praesentium autem quasi explicabo. Accusamus et nulla eveniet rerum ipsum unde. Sunt velit totam quos ex quas dolorum odit. Nostrum id autem accusantium tempora.', NULL, NULL, 0, '2025-12-04 15:21:02'),
(205, 16, 294, 'text', 'Asperiores sint eaque aliquid corrupti assumenda. Commodi nesciunt aut tempora aut qui. Distinctio et debitis eligendi cumque nulla numquam fuga repellendus.', NULL, NULL, 0, '2025-12-03 10:57:21'),
(206, 17, 297, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033ff?text=minus', 'provident.uvvf', 0, '2025-11-30 10:43:26'),
(207, 17, 298, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ee66?text=sed', 'fuga.asx', 0, '2025-11-29 23:34:37'),
(208, 17, 299, 'file', NULL, 'https://via.placeholder.com/640x480.png/00bb44?text=error', 'molestiae.fpx', 0, '2025-11-28 23:09:49'),
(209, 17, 300, 'file', NULL, 'https://via.placeholder.com/640x480.png/003322?text=suscipit', 'sint.gv', 0, '2025-12-04 02:40:17'),
(210, 17, 301, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aa22?text=modi', 'quae.iso', 0, '2025-12-01 01:08:43'),
(211, 17, 302, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee33?text=dolorum', 'itaque.itp', 0, '2025-11-29 08:03:28'),
(212, 17, 303, 'file', NULL, 'https://via.placeholder.com/640x480.png/0022ee?text=voluptas', 'voluptatem.sitx', 0, '2025-11-30 09:28:07'),
(213, 17, 304, 'text', 'Et dolor dicta et. Minus est possimus doloribus sunt non et. Corrupti ab explicabo laboriosam eaque et voluptas. Et sit vel ea aut impedit aliquam voluptas.', NULL, NULL, 0, '2025-11-30 21:54:15'),
(214, 17, 305, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff11?text=quasi', 'possimus.mka', 0, '2025-12-03 19:10:04'),
(215, 17, 306, 'video', NULL, 'https://via.placeholder.com/640x480.png/001155?text=facere', 'quis.prc', 1, '2025-12-03 00:11:48'),
(216, 17, 307, 'video', NULL, 'https://via.placeholder.com/640x480.png/008811?text=placeat', 'minima.3dml', 0, '2025-11-30 19:07:35'),
(217, 17, 308, 'file', NULL, 'https://via.placeholder.com/640x480.png/001100?text=quasi', 'ut.bmp', 0, '2025-11-29 11:47:57'),
(218, 17, 309, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aaff?text=nemo', 'delectus.bz', 0, '2025-11-30 03:47:56'),
(219, 17, 310, 'image', NULL, 'https://via.placeholder.com/640x480.png/008888?text=deserunt', 'iste.tfm', 0, '2025-12-02 19:00:54'),
(220, 18, 312, 'image', NULL, 'https://via.placeholder.com/640x480.png/006633?text=voluptates', 'autem.org', 0, '2025-12-02 14:03:33'),
(221, 18, 313, 'file', NULL, 'https://via.placeholder.com/640x480.png/0000dd?text=alias', 'officiis.wdb', 0, '2025-12-02 06:56:26'),
(222, 18, 314, 'file', NULL, 'https://via.placeholder.com/640x480.png/000088?text=delectus', 'velit.chm', 0, '2025-11-29 13:54:44'),
(223, 18, 315, 'image', NULL, 'https://via.placeholder.com/640x480.png/008877?text=dolore', 'nihil.fgd', 0, '2025-12-02 13:33:34'),
(224, 18, 316, 'file', NULL, 'https://via.placeholder.com/640x480.png/006655?text=unde', 'aut.dot', 0, '2025-12-04 03:32:36'),
(225, 18, 317, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ee00?text=ducimus', 'aut.odf', 0, '2025-12-03 18:08:44'),
(226, 18, 318, 'image', NULL, 'https://via.placeholder.com/640x480.png/008822?text=quam', 'eos.sus', 0, '2025-12-01 02:57:05'),
(227, 18, 319, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aacc?text=aut', 'atque.sub', 0, '2025-11-29 21:21:26'),
(228, 18, 320, 'text', 'Quam temporibus possimus culpa et maiores possimus odit. Voluptas tenetur beatae quia ad quis. Qui quas et provident. Id vero illum dignissimos sunt similique sit.', NULL, NULL, 0, '2025-11-29 07:05:02'),
(229, 18, 321, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff66?text=quis', 'qui.rmp', 0, '2025-11-29 11:51:39'),
(230, 18, 322, 'file', NULL, 'https://via.placeholder.com/640x480.png/006677?text=quod', 'aut.sse', 0, '2025-12-03 14:35:11'),
(231, 18, 323, 'image', NULL, 'https://via.placeholder.com/640x480.png/002266?text=voluptas', 'in.odt', 0, '2025-11-28 14:14:54'),
(232, 19, 326, 'image', NULL, 'https://via.placeholder.com/640x480.png/0033aa?text=deleniti', 'in.cpio', 0, '2025-11-30 15:07:17'),
(233, 19, 327, 'video', NULL, 'https://via.placeholder.com/640x480.png/008811?text=nihil', 'voluptatum.xlsm', 1, '2025-11-30 04:53:32'),
(234, 19, 328, 'video', NULL, 'https://via.placeholder.com/640x480.png/00bb00?text=itaque', 'consectetur.uu', 0, '2025-11-30 10:50:46'),
(235, 19, 329, 'image', NULL, 'https://via.placeholder.com/640x480.png/0099aa?text=dolore', 'nemo.rlc', 0, '2025-12-03 09:03:14'),
(236, 19, 330, 'video', NULL, 'https://via.placeholder.com/640x480.png/0055ff?text=molestiae', 'ducimus.sm', 0, '2025-11-30 04:00:40'),
(237, 19, 331, 'text', 'Numquam vel ut sit consequatur optio voluptas hic. Tenetur qui sint at odit magni consequuntur pariatur. Eos sapiente eos ratione quidem.', NULL, NULL, 0, '2025-11-30 11:56:05'),
(238, 19, 332, 'video', NULL, 'https://via.placeholder.com/640x480.png/001133?text=earum', 'impedit.install', 0, '2025-11-30 01:29:48'),
(239, 19, 333, 'image', NULL, 'https://via.placeholder.com/640x480.png/008833?text=architecto', 'eum.sfv', 0, '2025-11-27 17:44:44'),
(240, 19, 334, 'file', NULL, 'https://via.placeholder.com/640x480.png/0000dd?text=et', 'est.fe_launch', 0, '2025-12-02 06:25:00'),
(241, 20, 336, 'text', 'Ullam ipsum tempore omnis voluptatum nesciunt libero quidem. Illo dolores cumque non aut consequatur id deserunt aut. Autem exercitationem repudiandae nesciunt odio asperiores quaerat velit. Ipsam aut libero tempora.', NULL, NULL, 0, '2025-11-30 00:27:17'),
(242, 20, 337, 'text', 'Sint voluptatem repellendus id voluptas. Rerum cum nihil dolores et corrupti aspernatur quia. Et deleniti fugit occaecati ducimus.', NULL, NULL, 1, '2025-12-02 11:54:15'),
(243, 20, 338, 'image', NULL, 'https://via.placeholder.com/640x480.png/006699?text=sint', 'aliquid.uvvp', 0, '2025-11-29 21:15:16'),
(244, 20, 339, 'text', 'Id velit tempora harum. Et nam numquam est quibusdam autem praesentium eos. Sed eum sed dolorem reprehenderit non. Rerum et voluptas nam laborum.', NULL, NULL, 0, '2025-12-01 04:31:40'),
(245, 20, 340, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ccee?text=doloribus', 'soluta.dvb', 0, '2025-11-29 13:45:46'),
(246, 20, 341, 'file', NULL, 'https://via.placeholder.com/640x480.png/00cc88?text=necessitatibus', 'ducimus.install', 0, '2025-11-30 18:59:46'),
(247, 20, 342, 'video', NULL, 'https://via.placeholder.com/640x480.png/00cc33?text=fugit', 'quidem.pyv', 0, '2025-11-29 18:34:54'),
(248, 20, 343, 'video', NULL, 'https://via.placeholder.com/640x480.png/001122?text=voluptas', 'velit.rgb', 0, '2025-11-30 07:45:57'),
(249, 20, 344, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd11?text=praesentium', 'labore.mp4s', 0, '2025-11-27 18:41:11'),
(250, 20, 345, 'text', 'Aut adipisci ut soluta. Provident dignissimos nulla dolores sed commodi exercitationem ipsam autem. Quis iure non nam voluptate dolore nam. Necessitatibus provident modi ut laboriosam fugiat.', NULL, NULL, 0, '2025-12-03 06:19:25'),
(251, 20, 346, 'image', NULL, 'https://via.placeholder.com/640x480.png/008888?text=velit', 'aut.mmf', 0, '2025-12-02 21:24:38'),
(252, 21, 350, 'text', 'meo may be', NULL, NULL, 0, '2025-12-09 14:22:04'),
(253, 21, 347, 'text', 'e con cho', NULL, NULL, 0, '2025-12-09 14:22:10'),
(254, 21, 350, 'text', '😙', NULL, NULL, 0, '2025-12-09 14:22:20'),
(255, 21, 347, 'text', 'meo may be', NULL, NULL, 0, '2025-12-09 14:27:14'),
(256, 21, 347, 'text', 'e con cho', NULL, NULL, 0, '2025-12-09 14:27:28'),
(257, 21, 350, 'text', 'oke quduy', NULL, NULL, 0, '2025-12-09 14:27:50');

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
(20, '2025_10_01_180040_create_personal_access_tokens_table', 1),
(21, '2025_10_02_081453_create_sessions_table', 1),
(22, '2025_10_04_033706_add_analytics_indexes', 1),
(23, '2025_10_05_163045_create_posts_table', 1),
(24, '2025_10_05_163107_create_post_likes_table', 1),
(25, '2025_10_05_163153_create_post_comments_table', 1),
(26, '2025_10_05_163206_create_post_reports_table', 1),
(27, '2025_10_05_163215_create_post_shares_table', 1),
(28, '2025_10_05_163224_create_post_tags_table', 1),
(29, '2025_10_05_163236_create_post_bookmarks_table', 1),
(30, '2025_10_09_174502_add_post_comment_to_notifications_related_type', 1),
(31, '2025_11_07_151427_add_social_id_to_users_table', 1),
(32, '2025_11_15_create_donation_campaigns_table', 1),
(33, '2025_11_15_create_donations_table', 1),
(34, '2025_11_26_221503_create_email_logs_table', 1),
(35, '2025_11_27_153504_add_last_activity_at_to_users_table', 1),
(36, '2025_11_27_174528_create_settings_table', 1),
(37, '2025_11_27_213511_create_post_media_table', 1),
(38, '2025_11_27_231223_add_password_reset_fields_to_users_table', 1);

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

--
-- Đang đổ dữ liệu cho bảng `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `notification_type`, `title`, `content`, `related_id`, `related_type`, `action_url`, `is_read`, `priority`, `created_at`) VALUES
(1, 329, 'Application', 'Amet accusantium fugiat veniam et doloribus recusandae.', NULL, 83, NULL, NULL, 1, 'low', '2025-12-04 16:30:16'),
(2, 329, 'Video Call', 'Iusto quibusdam excepturi labore saepe possimus.', NULL, 12, NULL, 'http://altenwerth.com/deserunt-id-aliquam-et-sint-architecto.html', 0, 'high', '2025-12-04 16:30:16'),
(3, 329, 'Opportunity', 'Eum dolor porro dolorem sit.', 'Ullam autem voluptas fugiat id excepturi nulla itaque quidem adipisci architecto qui sit.', NULL, 'opportunity', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(4, 122, 'Message', 'Ad est et natus illo qui.', 'Quam odio culpa labore assumenda error illum dolor ipsam adipisci cumque fuga nihil accusamus.', 78, 'application', NULL, 0, 'low', '2025-12-04 16:30:16'),
(5, 122, 'Message', 'Molestiae sit omnis impedit eveniet sunt distinctio.', 'Reprehenderit cupiditate quia dolorem corrupti sed dolores nam nemo quos amet voluptate architecto.', NULL, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(6, 122, 'Message', 'Quas et dolor quos fuga enim impedit.', NULL, NULL, NULL, 'http://haag.com/sunt-voluptatem-illum-error-veritatis-deleniti-quam', 0, 'medium', '2025-12-04 16:30:16'),
(7, 122, 'Message', 'Voluptas atque alias eligendi explicabo eaque error.', NULL, 71, NULL, 'http://www.johns.org/', 0, 'medium', '2025-12-04 16:30:16'),
(8, 122, 'Application', 'Animi qui delectus minus.', NULL, 96, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(9, 122, 'Opportunity', 'Officiis ut natus natus placeat.', 'Est aut nemo libero saepe illum non esse in.', NULL, NULL, 'http://little.com/eaque-fuga-voluptas-architecto-non-qui-facere-enim-vero', 0, 'high', '2025-12-04 16:30:16'),
(10, 122, 'Opportunity', 'Eos occaecati quia consectetur.', 'Ex ea modi veritatis error qui sed tempora id velit dolorum excepturi nobis.', NULL, 'opportunity', NULL, 1, 'medium', '2025-12-04 16:30:16'),
(11, 214, 'System', 'Possimus quod voluptate deleniti eos.', 'Et autem sit aut ea voluptas officia veniam iusto dolor soluta sed.', 72, NULL, 'https://www.bartoletti.com/omnis-doloribus-ipsam-repudiandae-architecto-sed-in', 0, 'high', '2025-12-04 16:30:16'),
(12, 214, 'System', 'Esse consequatur id numquam.', 'Ut et sunt exercitationem est vero ea magnam ut eos officia.', NULL, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(13, 214, 'Opportunity', 'Sit et voluptatibus quis pariatur ex.', 'Qui unde molestias qui rerum sed eum iure tempore magni qui expedita eaque.', NULL, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(14, 214, 'Video Call', 'Perferendis eaque dicta repellat.', NULL, NULL, NULL, 'https://www.larkin.net/dolorem-sint-nihil-doloribus-numquam-quae-magni', 1, 'high', '2025-12-04 16:30:16'),
(15, 214, 'Video Call', 'Consequatur tempore culpa nam corrupti.', 'Vitae sapiente dolor voluptates totam ratione dignissimos voluptatem id consequatur eligendi illum nam.', NULL, NULL, 'http://wunsch.com/', 0, 'medium', '2025-12-04 16:30:16'),
(16, 214, 'Review', 'Cum vero laborum fugit voluptatem voluptatem dolor.', 'Nisi maiores ratione iste veritatis impedit similique et hic sit est voluptatem explicabo.', 9, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(17, 214, 'Video Call', 'At incidunt voluptatem magnam inventore commodi.', NULL, 35, NULL, NULL, 1, 'medium', '2025-12-04 16:30:16'),
(18, 220, 'System', 'Et eum sequi est quam provident.', NULL, 30, 'user', 'http://jerde.com/similique-dolore-dolor-et-nulla-omnis-tempore-magnam-omnis', 1, 'medium', '2025-12-04 16:30:16'),
(19, 220, 'System', 'Tempora amet sint est ut magnam.', 'Odit rerum voluptas cum ad molestias laboriosam consequuntur magnam eum voluptatem minus facilis facere.', NULL, NULL, 'https://langosh.biz/sunt-quis-consectetur-qui-error-sapiente.html', 1, 'high', '2025-12-04 16:30:16'),
(20, 220, 'Review', 'Aut magnam sit sunt aperiam aut nostrum.', NULL, 24, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(21, 220, 'Video Call', 'Asperiores nemo sunt impedit aut.', NULL, 48, 'message', 'http://www.stark.com/', 1, 'low', '2025-12-04 16:30:16'),
(22, 220, 'Video Call', 'Libero error nihil totam.', NULL, NULL, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(23, 220, 'Video Call', 'Non vel labore molestias est ea eligendi.', NULL, 16, NULL, 'https://mcdermott.com/voluptates-consectetur-dolorum-quia-cum-natus-qui-at.html', 1, 'high', '2025-12-04 16:30:16'),
(24, 220, 'Video Call', 'Sequi reprehenderit consectetur quibusdam assumenda reprehenderit.', 'Quas praesentium et voluptate cumque consequatur consectetur minima quibusdam ut ut et.', NULL, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(25, 260, 'Application', 'Error minus quae magnam illo aliquid.', 'Eum error maiores ad ducimus et molestiae perferendis pariatur officiis suscipit dolor inventore id.', NULL, 'opportunity', 'https://www.haley.com/quidem-adipisci-ut-voluptatem-fuga', 0, 'high', '2025-12-04 16:30:16'),
(26, 260, 'Application', 'Repudiandae commodi dolorem officia exercitationem.', NULL, 34, NULL, 'http://medhurst.com/sed-ea-ad-nisi-eos-repudiandae-qui-eius-eos', 0, 'high', '2025-12-04 16:30:16'),
(27, 260, 'System', 'Eligendi aut corrupti blanditiis aut in iusto.', 'Reprehenderit omnis asperiores nam quis accusamus adipisci nobis dolorem labore.', 9, 'user', 'http://kerluke.info/consequatur-commodi-possimus-quaerat-eaque-reprehenderit-quod-dolorem', 1, 'medium', '2025-12-04 16:30:16'),
(28, 260, 'Review', 'Tempore non et sapiente maiores aut dolores.', 'Eum non cum maxime officia veritatis quasi et enim quia saepe voluptatem rerum.', 27, 'application', 'http://www.crona.biz/repudiandae-aut-quia-sed-distinctio-ratione-molestiae-culpa', 0, 'low', '2025-12-04 16:30:16'),
(29, 260, 'Video Call', 'Omnis laboriosam ipsa aut quo.', NULL, NULL, NULL, 'http://kreiger.org/omnis-perferendis-ipsa-voluptatem-debitis-nesciunt-similique', 0, 'low', '2025-12-04 16:30:16'),
(30, 260, 'Review', 'Aspernatur aliquam omnis consequatur officia placeat.', NULL, NULL, 'message', 'http://schoen.net/et-eos-id-sit-molestiae-autem-harum', 0, 'low', '2025-12-04 16:30:16'),
(31, 260, 'Application', 'Odit minus eligendi ut eum.', NULL, 99, 'message', 'http://www.oconner.net/atque-quae-voluptas-blanditiis-molestias-non-et.html', 1, 'medium', '2025-12-04 16:30:16'),
(32, 260, 'Review', 'Possimus ut deleniti doloremque ut quia.', NULL, NULL, 'application', 'http://west.com/', 1, 'low', '2025-12-04 16:30:16'),
(33, 260, 'Message', 'Fugit dolore quos quae dolores.', NULL, 57, 'call', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(34, 260, 'Video Call', 'Voluptas eius sint laboriosam eius et.', NULL, NULL, NULL, NULL, 1, 'medium', '2025-12-04 16:30:16'),
(35, 145, 'System', 'Et aut totam nemo numquam mollitia qui.', 'Et saepe amet assumenda consequatur totam dolores et quos quia enim quas accusantium.', NULL, NULL, 'http://www.ebert.com/qui-at-velit-totam-veniam-quo', 0, 'low', '2025-12-04 16:30:16'),
(36, 145, 'System', 'Placeat beatae et animi praesentium sed est.', 'Vel qui vitae in voluptas voluptatem ut et est dolore.', 76, 'call', 'https://medhurst.com/quia-asperiores-ut-laudantium-ea.html', 0, 'high', '2025-12-04 16:30:16'),
(37, 145, 'Review', 'Vel natus velit labore suscipit eos odio.', 'Itaque libero rerum quaerat quo ducimus est nobis et et iusto.', NULL, 'user', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(38, 145, 'Opportunity', 'Est vero molestiae magni.', 'Enim corrupti debitis fuga quisquam sed cupiditate porro ipsam deleniti ut facilis.', 90, 'message', NULL, 1, 'low', '2025-12-04 16:30:16'),
(39, 145, 'Review', 'Hic tempora accusantium deserunt voluptates laudantium quas.', 'Magnam ullam ex cum blanditiis minima et sit nihil nulla officia.', NULL, 'user', 'http://mraz.info/unde-sed-sunt-iste-explicabo', 0, 'low', '2025-12-04 16:30:16'),
(40, 145, 'Video Call', 'Eaque iste ut libero et.', NULL, 55, NULL, NULL, 1, 'low', '2025-12-04 16:30:16'),
(41, 145, 'Video Call', 'Tempore iusto numquam maxime facilis.', NULL, 47, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(42, 145, 'Video Call', 'Minima laboriosam est nihil quis quis aut.', NULL, NULL, 'message', NULL, 1, 'high', '2025-12-04 16:30:16'),
(43, 145, 'Application', 'Velit est adipisci earum.', NULL, 43, 'message', 'http://www.wyman.info/', 0, 'high', '2025-12-04 16:30:16'),
(44, 145, 'Video Call', 'Nisi occaecati ut dolore quia sint.', 'Asperiores architecto ratione molestiae debitis et sed labore.', NULL, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(45, 62, 'Opportunity', 'Eos sit quod aut repudiandae dolorum aut.', NULL, 23, 'call', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(46, 62, 'Application', 'Sit itaque molestiae eos.', 'Nemo autem sequi aperiam temporibus ut quisquam laborum laudantium.', NULL, NULL, 'http://www.bechtelar.com/voluptatem-sapiente-et-suscipit-qui', 0, 'high', '2025-12-04 16:30:16'),
(47, 62, 'Application', 'Ut et unde velit architecto similique est.', 'Totam architecto sit quo voluptatum quaerat vel ipsa porro suscipit sit earum sit numquam.', 55, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(48, 62, 'Opportunity', 'Iure nemo rerum ipsa illum.', NULL, 25, 'opportunity', 'http://www.veum.com/saepe-qui-nobis-quia-officia-ut', 1, 'medium', '2025-12-04 16:30:16'),
(49, 62, 'Message', 'Dolorem vitae velit quo ducimus.', 'Iste ut reprehenderit ad in ad sed qui.', NULL, 'call', 'http://www.durgan.net/', 0, 'medium', '2025-12-04 16:30:16'),
(50, 62, 'Application', 'Veritatis ea porro modi qui.', NULL, NULL, 'message', NULL, 0, 'low', '2025-12-04 16:30:16'),
(51, 62, 'Application', 'Velit molestiae voluptatem voluptates consequuntur saepe voluptatem.', NULL, 81, NULL, NULL, 0, 'low', '2025-12-04 16:30:16'),
(52, 62, 'Review', 'Officia dignissimos sint consequatur hic culpa voluptas.', 'Voluptas modi ut dolorum et quia cum voluptas dolorem maxime id sint dolor.', NULL, 'call', 'http://eichmann.com/totam-in-qui-est-reiciendis', 0, 'high', '2025-12-04 16:30:16'),
(53, 338, 'Message', 'Ipsam dolorem illum cupiditate consequatur possimus.', NULL, NULL, 'user', 'https://wintheiser.com/dolor-dolorum-est-nam-sunt.html', 0, 'low', '2025-12-04 16:30:16'),
(54, 338, 'Application', 'Quo et quisquam assumenda.', NULL, 30, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(55, 338, 'System', 'A optio assumenda ut consequatur illo.', 'Accusamus excepturi et et molestiae corporis delectus eum dolore debitis sed.', NULL, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(56, 338, 'Application', 'Expedita ipsam commodi quasi eius illo.', 'Enim quia officia omnis consequatur odit modi.', NULL, 'message', 'http://klocko.com/velit-expedita-sed-optio-dolor-corporis-maiores-autem', 0, 'low', '2025-12-04 16:30:16'),
(57, 338, 'Application', 'Nihil totam enim nemo.', 'Accusantium nam enim labore magni enim dolorem consequatur dolor exercitationem corrupti tenetur est et.', NULL, 'message', 'https://www.lebsack.biz/quibusdam-dolorem-voluptatibus-reiciendis-atque', 0, 'low', '2025-12-04 16:30:16'),
(58, 338, 'Video Call', 'Maiores hic pariatur hic ut aut qui quaerat.', NULL, NULL, NULL, 'http://emmerich.net/eos-nobis-ullam-adipisci', 0, 'medium', '2025-12-04 16:30:16'),
(59, 338, 'Application', 'Vel unde quibusdam est unde.', 'Aliquid vitae veniam facere quidem quia temporibus exercitationem veritatis magnam similique.', 94, 'call', 'http://www.schneider.com/voluptatum-alias-laborum-quos-facilis-officiis.html', 0, 'medium', '2025-12-04 16:30:16'),
(60, 338, 'System', 'Non corrupti ab dolorum voluptatem quidem.', NULL, 23, 'user', 'http://www.bode.com/', 0, 'low', '2025-12-04 16:30:16'),
(61, 338, 'Review', 'Eligendi cupiditate labore autem vel rerum ea.', 'Ab doloribus autem quibusdam consequatur et cumque atque consequuntur porro.', NULL, NULL, NULL, 1, 'low', '2025-12-04 16:30:16'),
(62, 338, 'Opportunity', 'Sed sit accusamus qui officia maxime quo.', NULL, NULL, NULL, 'http://www.roberts.biz/', 1, 'medium', '2025-12-04 16:30:16'),
(63, 79, 'Application', 'Fuga iusto qui et.', 'Voluptates dolorem ipsum ratione aspernatur officia rerum expedita quo ex voluptatum cum a.', 75, 'opportunity', NULL, 1, 'medium', '2025-12-04 16:30:16'),
(64, 79, 'Application', 'Voluptates hic alias esse vitae qui.', NULL, 6, 'call', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(65, 79, 'Opportunity', 'Officiis quia sed suscipit perspiciatis itaque.', 'Magni molestiae minima vero sed exercitationem ut repellendus qui nam corporis.', NULL, 'opportunity', NULL, 1, 'medium', '2025-12-04 16:30:16'),
(66, 79, 'Opportunity', 'Libero deleniti et consequatur.', 'In ea quam at earum qui explicabo eius eligendi.', 6, 'message', 'http://little.info/', 0, 'high', '2025-12-04 16:30:16'),
(67, 79, 'Application', 'Omnis ut consequuntur sapiente omnis.', 'Quia omnis sed ipsum ratione non eius quaerat sit architecto non dicta.', NULL, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(68, 79, 'Review', 'Cupiditate modi tenetur ut rerum.', NULL, 34, 'call', 'http://bednar.info/minus-doloribus-facere-doloremque-saepe-praesentium-dolor', 0, 'high', '2025-12-04 16:30:16'),
(69, 213, 'Opportunity', 'Iure id voluptatum quos quae odit.', 'Sit et unde molestias corrupti commodi perferendis eum ab et ut.', NULL, 'message', 'http://www.hermiston.biz/voluptate-et-consectetur-velit-blanditiis-neque.html', 0, 'low', '2025-12-04 16:30:16'),
(70, 213, 'Message', 'Non delectus mollitia perferendis magni a.', NULL, NULL, 'message', NULL, 0, 'high', '2025-12-04 16:30:16'),
(71, 213, 'Review', 'Debitis suscipit rerum quas ipsam expedita.', 'Pariatur ut quia laborum autem nobis rem placeat.', NULL, 'opportunity', NULL, 1, 'medium', '2025-12-04 16:30:16'),
(72, 213, 'Opportunity', 'Aut vero dicta voluptates minus minus.', 'Aliquid voluptatem quia neque qui iure pariatur.', 59, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(73, 213, 'Message', 'Facere quos aut voluptas ut suscipit.', NULL, 83, 'opportunity', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(74, 213, 'System', 'A architecto dolores voluptas.', 'Suscipit sunt cumque similique earum fuga consequuntur.', NULL, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(75, 213, 'Application', 'Quam expedita dolores molestiae delectus et illum.', NULL, NULL, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(76, 213, 'Application', 'Enim ut in accusantium officia.', NULL, NULL, 'user', 'https://gerlach.com/nulla-aliquid-tempore-suscipit-molestias-consequuntur-molestiae.html', 0, 'medium', '2025-12-04 16:30:16'),
(77, 213, 'Opportunity', 'Ad molestias iste nisi saepe perspiciatis in.', 'Expedita et dignissimos dolores porro iusto harum.', NULL, NULL, NULL, 1, 'high', '2025-12-04 16:30:16'),
(78, 335, 'Application', 'Quo error voluptatem impedit alias quia.', 'Qui voluptas magni esse id voluptates nam aliquam vitae nobis ad eveniet perspiciatis.', 70, 'message', 'http://www.ziemann.com/', 0, 'low', '2025-12-04 16:30:16'),
(79, 335, 'Review', 'Accusamus possimus totam quae sed.', 'Et sit ad veritatis dolore cum magnam consequatur dolorum ipsa iure alias pariatur nobis.', NULL, 'message', 'http://okuneva.info/voluptas-facere-doloremque-consequuntur-laborum-incidunt.html', 0, 'high', '2025-12-04 16:30:16'),
(80, 335, 'Application', 'Earum corporis perferendis beatae natus est aut rem.', NULL, 33, 'user', NULL, 0, 'high', '2025-12-04 16:30:16'),
(81, 335, 'Opportunity', 'Reprehenderit veritatis sequi nesciunt.', 'Expedita temporibus provident quod reiciendis quam corporis nesciunt.', NULL, 'message', 'http://www.feil.com/quo-delectus-eius-similique-quia-qui-veritatis', 0, 'low', '2025-12-04 16:30:16'),
(82, 335, 'Video Call', 'Alias minima blanditiis necessitatibus.', NULL, 42, NULL, 'http://wunsch.info/non-omnis-cum-et-velit-laudantium-totam-et.html', 0, 'low', '2025-12-04 16:30:16'),
(83, 335, 'Message', 'Debitis rem eos quia omnis vel saepe.', NULL, NULL, 'application', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(84, 335, 'Application', 'Rerum ipsa fugit placeat voluptas.', NULL, 81, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(85, 335, 'System', 'Sint et quis commodi enim esse.', NULL, NULL, NULL, NULL, 1, 'high', '2025-12-04 16:30:16'),
(86, 335, 'Review', 'Ipsa totam voluptate voluptates eius tenetur.', 'Totam sed natus facere optio dignissimos qui numquam libero non iste.', NULL, NULL, 'http://www.cremin.info/', 0, 'high', '2025-12-04 16:30:16'),
(87, 335, 'Application', 'Sunt enim rerum asperiores occaecati.', NULL, 98, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(88, 105, 'Application', 'Consectetur et eveniet suscipit.', NULL, NULL, 'user', 'https://howell.org/sit-quasi-qui-beatae-ea.html', 0, 'medium', '2025-12-04 16:30:16'),
(89, 105, 'System', 'A enim sed fuga aliquid.', 'Voluptas perferendis sint repudiandae distinctio nihil rem odio qui soluta aut ea.', 31, 'call', 'http://schamberger.com/', 0, 'medium', '2025-12-04 16:30:16'),
(90, 105, 'Opportunity', 'Porro mollitia officia est laborum deserunt odit.', 'Nemo dicta iusto laboriosam excepturi omnis optio.', 40, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(91, 105, 'Opportunity', 'Blanditiis eum sequi itaque.', 'Tenetur perspiciatis ex qui nobis in est aperiam temporibus voluptas.', NULL, 'user', 'http://www.cummerata.com/dicta-accusantium-vero-est-tempora.html', 0, 'low', '2025-12-04 16:30:16'),
(92, 105, 'System', 'Natus delectus repudiandae iste.', 'Dolor ex doloremque dolores facilis cumque commodi.', NULL, 'application', NULL, 1, 'medium', '2025-12-04 16:30:16'),
(93, 105, 'Video Call', 'Repellat laborum minima omnis magni eaque quisquam.', 'Qui aut facilis nostrum adipisci occaecati eum ut voluptatem omnis illo velit aut.', 19, 'message', 'http://www.brakus.com/ullam-vero-officiis-ex-id-iusto-enim-unde-cum.html', 0, 'high', '2025-12-04 16:30:16'),
(94, 105, 'Opportunity', 'Voluptas amet cum quia nulla.', NULL, NULL, 'call', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(95, 105, 'Application', 'Ipsam aut quo fugit.', 'Voluptates rerum maxime velit laboriosam ullam sed magni ad quaerat.', 44, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(96, 105, 'Review', 'Officia sit cupiditate tempora aperiam.', 'Ipsam dolor doloribus esse nam numquam aut esse optio sint commodi rem ipsam.', 92, NULL, NULL, 0, 'low', '2025-12-04 16:30:16'),
(97, 105, 'System', 'Rerum rem aut voluptas.', NULL, NULL, NULL, 'https://www.emmerich.com/quo-in-dicta-ut-tempora-eius-quidem', 0, 'low', '2025-12-04 16:30:16'),
(98, 152, 'Review', 'Dolorem dolore libero similique.', 'Quia adipisci et tempore deserunt aut aut asperiores fugiat repellendus.', NULL, 'message', NULL, 1, 'low', '2025-12-04 16:30:16'),
(99, 152, 'Message', 'Non a veniam et temporibus ut.', NULL, NULL, NULL, 'http://www.braun.org/', 0, 'medium', '2025-12-04 16:30:16'),
(100, 152, 'Application', 'Ab quia laboriosam delectus neque adipisci autem.', NULL, NULL, 'call', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(101, 152, 'Video Call', 'Debitis maiores esse accusamus quisquam voluptatibus dolorum.', NULL, NULL, 'opportunity', 'http://brakus.net/et-est-est-rerum', 0, 'high', '2025-12-04 16:30:16'),
(102, 152, 'Video Call', 'Velit ipsum dolore alias repudiandae.', NULL, 10, NULL, 'http://www.monahan.net/ex-nulla-velit-consectetur-saepe-error', 0, 'medium', '2025-12-04 16:30:16'),
(103, 152, 'Video Call', 'Libero culpa nam earum.', 'Aut nulla nulla vel sunt ab est.', 3, 'opportunity', NULL, 0, 'low', '2025-12-04 16:30:16'),
(104, 152, 'Message', 'Minus enim tenetur et.', NULL, NULL, 'opportunity', NULL, 0, 'low', '2025-12-04 16:30:16'),
(105, 152, 'Opportunity', 'In voluptate facilis doloribus sunt.', 'Autem sit itaque in asperiores sit debitis possimus autem quidem repellendus voluptas et in.', NULL, 'call', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(106, 152, 'System', 'Quo nesciunt ea autem amet.', NULL, 69, 'opportunity', 'http://hilpert.com/', 0, 'high', '2025-12-04 16:30:16'),
(107, 36, 'Application', 'Voluptate ut vitae et nisi.', 'Nisi tenetur modi eos voluptatem et asperiores in nemo maiores debitis perspiciatis ut.', 46, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(108, 36, 'Application', 'Voluptatibus saepe exercitationem aliquam impedit sit eum nobis.', NULL, NULL, 'message', NULL, 0, 'low', '2025-12-04 16:30:16'),
(109, 36, 'Opportunity', 'Corporis ullam nisi quia dolores assumenda.', 'Et esse error magni voluptatum quia ab quaerat qui velit dolorem quas tenetur qui.', NULL, 'user', 'http://nitzsche.com/quae-consequatur-delectus-praesentium-aperiam-dolor-quia-ex', 0, 'medium', '2025-12-04 16:30:16'),
(110, 36, 'Video Call', 'Tempora qui assumenda impedit quas.', 'Placeat maxime autem doloremque vitae illum vel iste voluptatem cupiditate aut maiores ab corporis.', 74, NULL, 'http://hansen.com/itaque-aperiam-sed-molestias-voluptatibus-odit', 0, 'medium', '2025-12-04 16:30:16'),
(111, 36, 'Review', 'Fugit quisquam esse consequatur non.', 'Voluptas vitae sequi nostrum quidem voluptate delectus aliquam.', 19, 'message', 'http://www.abshire.com/est-est-et-id-id-consequatur-id-doloremque', 0, 'high', '2025-12-04 16:30:16'),
(112, 36, 'Opportunity', 'Quibusdam neque ut doloremque non.', 'Ipsa voluptatum vero qui neque ipsam consequatur modi.', 24, 'message', NULL, 1, 'low', '2025-12-04 16:30:16'),
(113, 36, 'Video Call', 'Repudiandae aut omnis quia repellendus.', NULL, NULL, NULL, 'https://oreilly.info/et-vel-facere-ea-consequatur-eum-soluta-reiciendis.html', 0, 'medium', '2025-12-04 16:30:16'),
(114, 36, 'Application', 'Quisquam et odio aliquam libero.', NULL, 91, NULL, 'http://www.luettgen.com/beatae-reiciendis-quam-non-modi-doloribus-consequuntur-odit', 0, 'medium', '2025-12-04 16:30:16'),
(115, 36, 'Application', 'Dolorem sequi quos autem nobis quibusdam ullam.', NULL, NULL, 'application', 'https://www.cruickshank.net/ut-facere-animi-inventore-iste-et-quia-inventore', 0, 'medium', '2025-12-04 16:30:16'),
(116, 147, 'Opportunity', 'Consectetur aut ex sed quo quaerat est.', 'Earum est molestiae tempore praesentium est sed.', NULL, NULL, 'http://www.padberg.com/omnis-ea-sed-non-magni-omnis-est-velit', 0, 'medium', '2025-12-04 16:30:16'),
(117, 147, 'Video Call', 'Ipsum aspernatur recusandae tempora qui.', NULL, 99, 'call', 'http://bauch.com/ea-velit-eveniet-sapiente-doloremque-doloremque-quos', 0, 'medium', '2025-12-04 16:30:16'),
(118, 147, 'Application', 'Provident odio quidem ab.', 'Impedit ad iure aspernatur officiis eum deserunt qui.', NULL, NULL, 'http://www.will.biz/necessitatibus-aut-non-atque-velit-tempore-ea', 0, 'high', '2025-12-04 16:30:16'),
(119, 147, 'Video Call', 'Consequatur soluta fuga perferendis magni rerum.', NULL, NULL, 'application', NULL, 0, 'low', '2025-12-04 16:30:16'),
(120, 147, 'Application', 'Deleniti voluptatum autem quo dolor suscipit.', 'Voluptas officia qui doloribus a officia dolorem doloribus nobis est dolorem sint.', NULL, 'message', 'http://greenholt.biz/et-nobis-eos-exercitationem-perferendis.html', 0, 'high', '2025-12-04 16:30:16'),
(121, 147, 'Video Call', 'Culpa aspernatur aut voluptas delectus nihil.', 'Et ea omnis rem consequuntur ea voluptatem omnis explicabo molestias.', NULL, 'call', 'http://www.fahey.com/', 1, 'low', '2025-12-04 16:30:16'),
(122, 147, 'Review', 'Voluptate ab asperiores similique porro.', NULL, NULL, NULL, 'http://bode.biz/', 0, 'low', '2025-12-04 16:30:16'),
(123, 147, 'Video Call', 'Harum sunt repudiandae eaque quis error natus.', 'Tempora quia esse dolores consequatur voluptate non.', NULL, NULL, 'http://simonis.biz/enim-quo-eligendi-architecto.html', 1, 'medium', '2025-12-04 16:30:16'),
(124, 277, 'Video Call', 'Qui beatae inventore qui eligendi quis voluptatem.', 'Perferendis fugiat provident facere dignissimos sit tenetur ratione.', NULL, 'call', 'http://hills.com/quasi-tempora-laboriosam-libero-molestiae-maxime-fuga', 1, 'medium', '2025-12-04 16:30:16'),
(125, 277, 'Message', 'Adipisci ducimus et hic deserunt totam.', 'Est consequatur natus est doloremque ut labore.', NULL, NULL, 'http://schmeler.com/aut-in-aut-voluptatem-ipsum-ex-alias-quia', 1, 'high', '2025-12-04 16:30:16'),
(126, 277, 'Message', 'Itaque architecto totam ipsum est sit architecto.', 'Placeat doloremque aliquid sed labore assumenda quasi pariatur.', NULL, 'application', 'http://www.simonis.biz/dolor-et-dolorem-a-similique-nesciunt', 0, 'medium', '2025-12-04 16:30:16'),
(127, 277, 'Review', 'Beatae molestiae praesentium voluptate sunt numquam neque.', NULL, NULL, NULL, 'http://schaden.com/', 0, 'low', '2025-12-04 16:30:16'),
(128, 277, 'System', 'Voluptatem accusamus consequatur totam earum iste non.', 'Repellat non labore sint quia quam odio molestiae similique blanditiis qui molestiae.', 46, NULL, NULL, 1, 'high', '2025-12-04 16:30:16'),
(129, 277, 'Application', 'Asperiores voluptatem repellendus dolores.', NULL, 87, NULL, NULL, 0, 'medium', '2025-12-04 16:30:16'),
(130, 277, 'Video Call', 'Sit est quas illum aliquam hic.', 'Eius eum voluptatibus qui ut commodi voluptates saepe veniam magni.', 68, 'call', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(131, 277, 'Opportunity', 'Sit dolorem magni dolores nisi.', 'Ab veritatis est qui tenetur aut velit placeat perspiciatis rem omnis rerum.', 48, NULL, 'http://jerde.com/', 1, 'low', '2025-12-04 16:30:16'),
(132, 277, 'Video Call', 'Quaerat voluptas iure beatae quae deleniti culpa.', 'Impedit ipsum exercitationem illo doloribus incidunt corporis ut magni nulla voluptate voluptatem illo.', NULL, 'opportunity', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(133, 277, 'Opportunity', 'Eos eaque voluptatum reiciendis qui aliquam.', 'Debitis cupiditate iste accusamus in distinctio aut delectus laudantium maxime et ducimus omnis.', 50, 'message', 'https://wilkinson.com/culpa-autem-ut-suscipit-molestiae.html', 1, 'high', '2025-12-04 16:30:16'),
(134, 284, 'System', 'Quibusdam et enim quasi illum suscipit.', 'Cum sit quibusdam repellat saepe alias nisi assumenda qui alias illum ut.', NULL, NULL, NULL, 1, 'low', '2025-12-04 16:30:16'),
(135, 284, 'Review', 'Pariatur voluptatem enim inventore delectus ad quae.', 'Quae quas temporibus temporibus numquam architecto ad.', 37, 'opportunity', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(136, 284, 'Review', 'Recusandae sint dolorem id aliquam aut id.', NULL, 15, 'message', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(137, 284, 'Application', 'Aut animi voluptatibus perspiciatis impedit.', 'In voluptatum provident dolore dicta ipsa quod nesciunt explicabo labore omnis pariatur iusto.', NULL, 'opportunity', NULL, 0, 'low', '2025-12-04 16:30:16'),
(138, 284, 'Review', 'Ad voluptatum unde harum.', NULL, NULL, 'call', 'http://www.goodwin.net/animi-provident-voluptatibus-veniam-eum-amet-corrupti-quo', 0, 'medium', '2025-12-04 16:30:16'),
(139, 284, 'System', 'Rerum est perferendis dolor sint rerum tempore.', 'Voluptatem labore temporibus dolorem id pariatur voluptas harum recusandae.', 65, NULL, 'http://www.torphy.com/', 0, 'medium', '2025-12-04 16:30:16'),
(140, 284, 'Review', 'Sit quas cumque adipisci est.', NULL, NULL, NULL, 'http://armstrong.com/aut-deserunt-necessitatibus-deserunt.html', 1, 'medium', '2025-12-04 16:30:16'),
(141, 219, 'Review', 'Voluptate non est pariatur a facilis hic.', 'Suscipit molestiae sint vel et fugiat repellat est repellat dignissimos temporibus officia.', NULL, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(142, 219, 'System', 'Nesciunt sit quidem ea necessitatibus.', NULL, NULL, NULL, 'http://douglas.com/', 0, 'low', '2025-12-04 16:30:16'),
(143, 219, 'Video Call', 'Ea in voluptas sunt.', 'Ea numquam modi velit officia iusto molestiae vitae officia temporibus quaerat sed quasi dolorum.', 55, NULL, NULL, 0, 'high', '2025-12-04 16:30:16'),
(144, 219, 'Message', 'Qui voluptas et doloribus suscipit consequatur.', 'Fuga qui nihil sit voluptas repellendus debitis.', NULL, NULL, NULL, 0, 'low', '2025-12-04 16:30:16'),
(145, 219, 'Opportunity', 'Inventore id et doloremque omnis commodi.', 'Labore enim provident magnam voluptates et ab error quia impedit perferendis.', 37, NULL, 'http://wolf.com/labore-assumenda-nihil-quis-quia-eaque-magnam-dolorem-mollitia.html', 0, 'high', '2025-12-04 16:30:16'),
(146, 219, 'Opportunity', 'Iure et corrupti nisi neque laboriosam dolores.', 'Pariatur sunt nihil dolores eos consequatur voluptatem.', 32, 'message', NULL, 1, 'high', '2025-12-04 16:30:16'),
(147, 219, 'Application', 'Delectus magnam corrupti et eius laudantium.', 'Ratione repellat quia pariatur aut atque nihil consequatur et.', 47, 'opportunity', NULL, 0, 'medium', '2025-12-04 16:30:16'),
(148, 219, 'Application', 'Sunt enim fugiat voluptatum eaque.', 'Maxime qui neque est nam occaecati numquam deserunt aut velit sit excepturi in animi.', 70, 'application', NULL, 1, 'medium', '2025-12-04 16:30:16'),
(149, 219, 'System', 'Aut ipsam sint quasi sapiente harum praesentium.', NULL, 5, 'user', 'http://connelly.com/optio-accusamus-ut-ut-quod-eos-sed-unde.html', 1, 'medium', '2025-12-04 16:30:16'),
(150, 219, 'System', 'Odit nihil id dolor sed nihil alias.', NULL, NULL, NULL, 'http://nader.net/dignissimos-nisi-provident-ut-facilis-voluptatibus-earum-sunt', 0, 'low', '2025-12-04 16:30:16'),
(151, 193, 'System', 'Quia dolorem voluptas in dolorem voluptatem quidem.', NULL, 24, 'user', NULL, 1, 'high', '2025-12-04 16:30:17'),
(152, 193, 'Review', 'Alias nesciunt aut in accusamus.', NULL, NULL, 'message', 'https://fahey.com/quia-dolores-et-corrupti-consectetur-qui-ut-quis.html', 0, 'high', '2025-12-04 16:30:17'),
(153, 193, 'System', 'Eos quia nihil nulla et minus.', 'Maxime beatae laboriosam et consequatur illo voluptatibus consectetur.', NULL, 'message', NULL, 0, 'low', '2025-12-04 16:30:17'),
(154, 193, 'Message', 'Voluptatem dolores aut accusamus enim ex.', NULL, NULL, NULL, NULL, 1, 'high', '2025-12-04 16:30:17'),
(155, 193, 'Opportunity', 'Dolore ea aut fuga vel eum.', 'Illum iure sint voluptatem ut possimus dolorum tempora quae.', NULL, NULL, 'http://www.frami.com/quis-omnis-aliquam-praesentium-itaque-voluptatibus-eveniet-ratione', 1, 'low', '2025-12-04 16:30:17'),
(156, 193, 'Video Call', 'Consequatur ipsa dolores provident possimus dolor error.', NULL, 1, 'call', 'http://hyatt.com/magnam-cupiditate-et-eligendi-et-quaerat-reiciendis-architecto', 0, 'high', '2025-12-04 16:30:17'),
(157, 193, 'Opportunity', 'Voluptatem veniam provident incidunt et.', 'Sit similique quibusdam eos voluptas nostrum voluptas aut facere occaecati in velit aliquam.', 4, NULL, NULL, 0, 'high', '2025-12-04 16:30:17'),
(158, 193, 'Message', 'Hic id eum et omnis.', 'Voluptas mollitia omnis aliquid reiciendis dolore ab consequuntur cupiditate necessitatibus.', 68, NULL, 'http://walker.com/', 1, 'low', '2025-12-04 16:30:17'),
(159, 193, 'Opportunity', 'Eos non vel consectetur maxime.', NULL, NULL, NULL, NULL, 0, 'high', '2025-12-04 16:30:17'),
(160, 254, 'System', 'Nesciunt ut repellendus natus.', 'Autem ullam consequatur corrupti veniam quia quasi dolorem.', NULL, NULL, 'http://legros.info/iste-eum-eos-fuga.html', 0, 'low', '2025-12-04 16:30:17'),
(161, 254, 'System', 'Et eum exercitationem provident veritatis qui ipsa.', 'Doloremque numquam eligendi accusamus culpa ut in sed.', NULL, 'user', 'http://www.block.com/nobis-dolorem-voluptatibus-nemo-debitis-reprehenderit', 0, 'low', '2025-12-04 16:30:17'),
(162, 254, 'Opportunity', 'Aut nesciunt delectus ut repellendus.', NULL, NULL, 'user', 'http://www.schneider.com/qui-quisquam-perferendis-non-et-consequatur', 0, 'high', '2025-12-04 16:30:17'),
(163, 254, 'Message', 'Quisquam enim repellendus consequuntur.', 'Quis inventore ullam unde dolorum error sed quibusdam odio nobis dignissimos aliquam itaque.', 12, 'opportunity', 'https://www.lesch.biz/delectus-quia-suscipit-voluptatem-at-sunt-eaque-blanditiis', 0, 'low', '2025-12-04 16:30:17'),
(164, 254, 'Review', 'Vel in placeat error.', NULL, NULL, 'user', 'http://ortiz.info/velit-et-sed-a-sint-veritatis-est-omnis', 0, 'low', '2025-12-04 16:30:17'),
(165, 71, 'Opportunity', 'Eum recusandae rerum sunt sint eaque.', NULL, NULL, NULL, 'https://www.mayert.info/quia-sit-recusandae-optio-ut-recusandae-ex-est', 1, 'high', '2025-12-04 16:30:17'),
(166, 71, 'Message', 'Quis debitis magni cupiditate consequatur incidunt voluptas.', NULL, NULL, 'call', NULL, 1, 'medium', '2025-12-04 16:30:17'),
(167, 71, 'Review', 'Ab dicta qui ab iusto repellendus.', 'Harum at asperiores quia nostrum tenetur quis magni maiores.', 56, 'message', 'http://hahn.com/eum-eos-et-hic.html', 0, 'low', '2025-12-04 16:30:17'),
(168, 71, 'Application', 'Similique accusamus natus accusantium recusandae laboriosam vel.', NULL, 89, NULL, 'http://www.weber.com/', 0, 'high', '2025-12-04 16:30:17'),
(169, 71, 'Application', 'In quas vel dignissimos.', NULL, NULL, 'application', NULL, 0, 'high', '2025-12-04 16:30:17'),
(170, 112, 'Message', 'Est cum quam nihil ut ex hic.', 'Perspiciatis quia sit rerum molestias explicabo voluptatem fugit mollitia rerum.', NULL, NULL, 'http://www.tromp.com/vitae-enim-architecto-et', 0, 'medium', '2025-12-04 16:30:17'),
(171, 112, 'Opportunity', 'Quis animi ut laboriosam facilis aut perferendis.', 'Iure laboriosam recusandae excepturi vel qui quis enim aspernatur sit quaerat ut rerum.', 22, NULL, 'https://www.parker.com/quisquam-quae-quidem-inventore-aut-dolorem', 0, 'high', '2025-12-04 16:30:17'),
(172, 112, 'Opportunity', 'Voluptatum numquam voluptas eos doloribus dolores minima.', NULL, 64, 'user', NULL, 1, 'low', '2025-12-04 16:30:17'),
(173, 112, 'Video Call', 'In id omnis et in.', NULL, 65, 'message', 'https://krajcik.org/harum-qui-omnis-tempora-totam-odio.html', 1, 'high', '2025-12-04 16:30:17'),
(174, 112, 'System', 'Et occaecati magnam id libero nam corporis.', 'Itaque ut est molestias et aut nobis reiciendis.', 17, 'opportunity', NULL, 1, 'low', '2025-12-04 16:30:17'),
(175, 19, 'Message', 'Nisi assumenda et veritatis totam.', NULL, 18, NULL, NULL, 0, 'high', '2025-12-04 16:30:17'),
(176, 19, 'Message', 'Voluptate quos voluptas ea laboriosam minus ullam vero.', NULL, NULL, NULL, 'http://www.raynor.com/corporis-et-sit-ullam-et', 0, 'low', '2025-12-04 16:30:17'),
(177, 19, 'System', 'Numquam officia non atque autem.', 'Numquam iure quo est ut rerum repudiandae hic fugiat voluptatem itaque impedit minima.', NULL, 'application', 'http://www.stracke.com/quis-in-dolorem-aut-omnis.html', 0, 'low', '2025-12-04 16:30:17'),
(178, 19, 'System', 'Voluptatibus quo sint voluptatibus.', NULL, 3, NULL, 'https://welch.com/officiis-ipsum-nisi-mollitia-eum-eum.html', 1, 'low', '2025-12-04 16:30:17'),
(179, 19, 'Video Call', 'Itaque quo porro ut non qui.', NULL, 86, NULL, 'http://borer.com/est-molestias-laboriosam-ea', 0, 'high', '2025-12-04 16:30:17'),
(180, 19, 'Application', 'Fugiat dolorem totam consequatur et reiciendis.', NULL, NULL, 'opportunity', NULL, 0, 'high', '2025-12-04 16:30:17'),
(181, 19, 'System', 'Sit temporibus odio maxime eius.', 'Adipisci similique eum porro accusantium veritatis expedita accusantium vitae iste ea sequi.', NULL, 'user', NULL, 1, 'low', '2025-12-04 16:30:17'),
(182, 166, 'Application', 'Facere ab itaque cupiditate et eum assumenda.', 'Itaque numquam voluptas quia alias ullam nesciunt corporis eos laboriosam ea repellendus.', 52, NULL, 'http://www.dare.com/asperiores-voluptatem-aut-voluptatem-delectus-deserunt-eligendi', 0, 'high', '2025-12-04 16:30:17'),
(183, 166, 'Opportunity', 'Ea animi dolores sed ab.', NULL, NULL, 'message', 'https://zemlak.com/et-optio-soluta-eos-sit-dolorum-odio-unde-vel.html', 0, 'low', '2025-12-04 16:30:17'),
(184, 166, 'Message', 'Et quis aut quia molestias exercitationem.', 'Minima dolorem ut soluta ullam reprehenderit aut commodi esse.', NULL, 'user', 'http://thompson.com/qui-earum-assumenda-repellat-mollitia', 0, 'high', '2025-12-04 16:30:17'),
(185, 166, 'Message', 'Amet et sunt velit quod.', 'Vel enim tempora nam ut omnis dignissimos quidem.', NULL, 'opportunity', 'http://beatty.com/nisi-eligendi-velit-cum-sint-provident-dolores', 0, 'high', '2025-12-04 16:30:17'),
(186, 166, 'System', 'Dolorem ipsum eos omnis non corrupti iste.', NULL, 26, NULL, 'https://www.price.com/illum-a-ullam-corrupti-molestiae-quae', 1, 'medium', '2025-12-04 16:30:17'),
(187, 166, 'Review', 'Consequuntur molestiae et quae et.', 'Enim repellat repellat non adipisci dolorem mollitia.', 71, 'user', NULL, 0, 'medium', '2025-12-04 16:30:17'),
(188, 166, 'System', 'Nesciunt at quo sequi expedita.', NULL, 35, NULL, 'http://hudson.com/qui-dolore-quo-sit-quia-qui-natus-vero-sit.html', 0, 'high', '2025-12-04 16:30:17'),
(189, 166, 'Application', 'Aspernatur tenetur repellendus aut non rerum unde.', 'Dolor voluptates dolore exercitationem pariatur incidunt dolorum inventore.', NULL, NULL, 'http://miller.com/sequi-at-animi-aliquam-autem-eius-sint-laborum.html', 0, 'low', '2025-12-04 16:30:17'),
(190, 166, 'Opportunity', 'Ipsa illum itaque voluptates velit.', NULL, NULL, 'message', 'http://www.beahan.com/', 1, 'medium', '2025-12-04 16:30:17'),
(191, 166, 'Review', 'Et aspernatur repellendus esse.', 'Et consequatur quia facere corporis placeat veniam.', 74, 'call', NULL, 0, 'high', '2025-12-04 16:30:17'),
(192, 229, 'Review', 'Vel eaque in illum eos.', NULL, 59, NULL, NULL, 0, 'low', '2025-12-04 16:30:17'),
(193, 229, 'Opportunity', 'Asperiores reiciendis ut rerum.', 'Nihil error omnis maxime eligendi officia error totam perferendis eum pariatur dolorem cupiditate.', 93, NULL, 'http://www.rippin.com/hic-qui-magnam-ea-itaque-distinctio-dolor-autem.html', 1, 'high', '2025-12-04 16:30:17'),
(194, 229, 'Application', 'Sequi distinctio aperiam exercitationem.', 'Voluptatibus sint molestiae qui eaque numquam voluptas voluptatum.', NULL, NULL, NULL, 0, 'low', '2025-12-04 16:30:17'),
(195, 229, 'Message', 'Accusamus cupiditate cumque sint non ut.', NULL, 42, NULL, NULL, 0, 'low', '2025-12-04 16:30:17'),
(196, 229, 'Opportunity', 'Quia enim occaecati inventore.', NULL, NULL, NULL, NULL, 0, 'medium', '2025-12-04 16:30:17'),
(197, 229, 'Opportunity', 'Id omnis tempore quia consequatur in.', 'Nobis modi vel doloribus quaerat enim ad sit minima est ad nemo et.', 71, NULL, NULL, 0, 'low', '2025-12-04 16:30:17'),
(198, 229, 'System', 'Vero tempora sit cupiditate consequatur ut fugit.', NULL, 77, NULL, NULL, 1, 'high', '2025-12-04 16:30:17'),
(199, 229, 'Application', 'Voluptatem quaerat suscipit vero ea.', 'Vel error officia libero aut at et laborum veritatis amet voluptates.', NULL, 'opportunity', 'http://www.sipes.com/ipsum-at-qui-iusto-dolorum-dolor-consequatur', 1, 'high', '2025-12-04 16:30:17'),
(200, 229, 'Video Call', 'Beatae nemo quia nulla labore.', NULL, 71, NULL, 'https://www.mayert.biz/dolor-aut-possimus-fuga-tempora-perferendis-ut-qui', 0, 'high', '2025-12-04 16:30:17'),
(201, 154, 'Opportunity', 'Veritatis voluptas aut distinctio ad ut.', NULL, 95, 'application', 'http://www.lang.info/ex-doloribus-commodi-sit-quia-est-iusto-voluptatem', 0, 'medium', '2025-12-04 16:30:17'),
(202, 154, 'Opportunity', 'Quasi fugit laudantium inventore qui amet.', NULL, 68, NULL, 'http://schamberger.biz/', 1, 'high', '2025-12-04 16:30:17'),
(203, 154, 'System', 'Quia est atque recusandae quia non.', 'Nobis consequatur fugit sapiente molestias impedit aut sint.', NULL, 'call', NULL, 1, 'medium', '2025-12-04 16:30:17'),
(204, 154, 'Opportunity', 'Ipsum molestiae dignissimos vitae.', NULL, 44, NULL, NULL, 1, 'low', '2025-12-04 16:30:17'),
(205, 205, 'Message', 'Sint doloribus eos sunt minus ullam.', NULL, NULL, NULL, NULL, 1, 'low', '2025-12-04 16:30:17'),
(206, 205, 'Video Call', 'Et odio officiis qui iure eligendi.', 'Possimus quae ratione vel est expedita beatae nam.', 95, NULL, NULL, 0, 'low', '2025-12-04 16:30:17'),
(207, 205, 'Video Call', 'Quas et magnam neque.', NULL, NULL, NULL, 'http://stiedemann.com/', 0, 'high', '2025-12-04 16:30:17'),
(208, 205, 'Application', 'Quibusdam et inventore hic odit qui adipisci.', NULL, NULL, 'user', 'http://www.schmitt.net/omnis-dolores-qui-ut-necessitatibus.html', 1, 'high', '2025-12-04 16:30:17'),
(209, 205, 'Review', 'Aut eligendi veniam saepe.', 'Sunt et animi quibusdam et enim enim esse ut earum omnis omnis.', 83, NULL, 'http://doyle.biz/qui-totam-corrupti-modi-atque', 0, 'low', '2025-12-04 16:30:17'),
(210, 205, 'Video Call', 'Omnis ipsa quisquam doloribus eum occaecati.', NULL, 96, NULL, NULL, 0, 'medium', '2025-12-04 16:30:17'),
(211, 205, 'Opportunity', 'Corporis eaque alias autem.', NULL, NULL, NULL, NULL, 0, 'low', '2025-12-04 16:30:17'),
(212, 205, 'Message', 'Repellat est iste laudantium ea occaecati.', 'Nobis autem omnis quidem culpa ad dolorem ea rerum ipsam consequuntur cupiditate aliquid laboriosam.', 18, NULL, 'http://www.crist.com/consequatur-explicabo-est-est-laboriosam-nihil-aut', 1, 'low', '2025-12-04 16:30:17'),
(213, 205, 'Review', 'Velit quasi asperiores quo.', 'Sit ea blanditiis animi nemo aut amet voluptates.', NULL, 'user', 'http://dickens.com/porro-enim-et-dolorem-quia', 0, 'low', '2025-12-04 16:30:17'),
(214, 205, 'Video Call', 'Est dolor ut debitis.', NULL, 34, 'application', 'http://mills.info/beatae-pariatur-voluptas-assumenda-earum-dignissimos-facilis-in', 0, 'medium', '2025-12-04 16:30:17'),
(215, 46, 'Message', 'Rerum ipsum beatae voluptatem tenetur quo.', NULL, NULL, NULL, 'http://mosciski.biz/quas-odio-ipsa-non-eius-dicta-quia', 1, 'medium', '2025-12-04 16:30:17'),
(216, 46, 'Video Call', 'Explicabo dolore corrupti animi saepe est.', NULL, NULL, 'user', NULL, 1, 'low', '2025-12-04 16:30:17'),
(217, 46, 'System', 'Dignissimos aut asperiores inventore aliquid.', 'Iusto praesentium veniam quia perferendis est blanditiis earum id.', NULL, 'call', 'http://hammes.info/eaque-vel-est-tempora-rerum-ex-eos-quia-nostrum', 1, 'medium', '2025-12-04 16:30:17'),
(218, 46, 'Review', 'Tenetur itaque soluta repellendus rerum.', NULL, NULL, 'call', 'https://www.keeling.net/quis-quod-corrupti-harum-magni-porro-ut', 0, 'high', '2025-12-04 16:30:17'),
(219, 46, 'Review', 'Accusamus iusto dolor accusantium illum ut quis.', NULL, NULL, NULL, 'https://keebler.com/alias-itaque-quam-et-sit-dolor.html', 0, 'medium', '2025-12-04 16:30:17'),
(220, 46, 'Opportunity', 'Maxime delectus rerum in et.', 'Doloremque molestiae omnis ipsa magnam quia mollitia nobis eius aut veritatis.', NULL, 'user', NULL, 0, 'medium', '2025-12-04 16:30:17'),
(221, 83, 'System', 'Exercitationem reprehenderit quos omnis nesciunt.', 'Incidunt eos omnis provident assumenda et voluptas tenetur sequi magnam voluptatum velit.', NULL, 'application', 'http://hauck.biz/est-minus-magni-autem-sit-sit-enim.html', 0, 'high', '2025-12-04 16:30:17'),
(222, 83, 'Message', 'Quos odit enim id.', NULL, NULL, 'message', NULL, 0, 'medium', '2025-12-04 16:30:17'),
(223, 83, 'Review', 'Ut quia praesentium repellendus sed amet corrupti.', NULL, NULL, 'user', 'http://www.friesen.com/et-ex-laboriosam-voluptatum-voluptas-totam-cupiditate.html', 1, 'low', '2025-12-04 16:30:17'),
(224, 83, 'Message', 'Porro incidunt consequatur maxime aperiam distinctio qui.', 'Doloremque aliquam consequuntur facilis ipsam iusto recusandae sed fuga laboriosam quae.', NULL, 'user', 'http://www.bernhard.com/pariatur-fuga-ut-accusamus-quo-voluptatibus.html', 0, 'medium', '2025-12-04 16:30:17'),
(225, 83, 'Review', 'Sed voluptatibus molestiae commodi molestiae at.', 'Laboriosam culpa sed porro temporibus qui illum minima molestiae itaque.', NULL, NULL, NULL, 0, 'medium', '2025-12-04 16:30:17'),
(226, 83, 'System', 'Eaque asperiores et omnis.', 'Adipisci in qui nemo doloribus distinctio sapiente qui at deserunt quos.', 7, NULL, NULL, 1, 'medium', '2025-12-04 16:30:17'),
(227, 317, 'Review', 'Numquam omnis modi sequi perspiciatis.', 'Quia dolorem recusandae illum pariatur pariatur ut eligendi ipsam officiis consequatur.', 31, 'call', 'http://olson.net/', 1, 'low', '2025-12-04 16:30:17'),
(228, 317, 'Video Call', 'Aliquam in dolore omnis omnis non ratione.', NULL, NULL, 'message', NULL, 0, 'medium', '2025-12-04 16:30:17'),
(229, 317, 'Review', 'Velit consequatur quasi esse est dolores.', NULL, NULL, 'user', 'http://www.abernathy.org/qui-commodi-laborum-dolor-modi-quia-aut', 0, 'low', '2025-12-04 16:30:17'),
(230, 317, 'Opportunity', 'Neque voluptas cumque facilis ut excepturi tempora.', NULL, 34, NULL, 'http://www.roberts.com/et-sit-totam-occaecati-sequi', 0, 'medium', '2025-12-04 16:30:17'),
(231, 317, 'System', 'Cupiditate omnis cupiditate reprehenderit est at magnam.', 'Cumque eum molestiae natus error sed cupiditate est.', 18, 'user', NULL, 0, 'medium', '2025-12-04 16:30:17'),
(232, 317, 'Video Call', 'Molestias necessitatibus voluptate aut aut.', 'Doloremque est similique officiis neque reiciendis ea aliquid.', NULL, 'call', 'http://barton.info/ipsam-et-natus-eius-aliquid-et-itaque-doloremque', 0, 'medium', '2025-12-04 16:30:17'),
(233, 317, 'Review', 'Fugit doloribus omnis quia.', 'Adipisci illum libero a esse voluptas dolor quasi.', 68, 'application', NULL, 0, 'high', '2025-12-04 16:30:17'),
(234, 317, 'System', 'Et ut est quia voluptas itaque aut.', 'Recusandae aut est et quibusdam quia numquam ut tenetur nihil minima.', 36, NULL, 'https://carroll.com/et-dolorem-ea-modi-et-est-vitae.html', 1, 'low', '2025-12-04 16:30:17'),
(235, 317, 'Video Call', 'Tempore voluptatibus dolores odit sed at.', 'Beatae quas similique assumenda dolores quia qui.', 44, NULL, NULL, 0, 'low', '2025-12-04 16:30:17'),
(236, 53, 'Application', 'Đơn ứng tuyển mới 📝', 'ab baciac đã ứng tuyển vào cơ hội: Ea sapiente quos nihil dolore illum.', 176, 'application', NULL, 0, 'medium', '2025-12-09 03:58:18'),
(237, 295, 'Application', 'Đơn ứng tuyển mới 📝', 'ab baciac đã ứng tuyển vào cơ hội: At vel doloremque sit et adipisci tenetur iusto fugit.', 177, 'application', NULL, 0, 'medium', '2025-12-09 05:23:23'),
(238, 350, 'Message', 'Bạn được thêm vào conversation mới', 'Chat với ab baciac', 21, 'conversation', 'http://127.0.0.1:8000/conversations/21', 0, 'medium', '2025-12-09 14:20:37');

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

--
-- Đang đổ dữ liệu cho bảng `organizations`
--

INSERT INTO `organizations` (`org_id`, `user_id`, `organization_name`, `organization_type`, `description`, `mission_statement`, `website`, `contact_person`, `registration_number`, `verification_status`, `founded_year`, `volunteer_count`, `rating`, `total_opportunities`, `created_at`, `updated_at`) VALUES
('org_6931b6caa86cf', 52, 'Global Heroes Center - New Lucasborough', 'NGO', 'Asperiores odio sed sunt omnis temporibus repellendus adipisci. Sunt eos ullam sunt doloribus animi et animi error. Suscipit quo et eum omnis et error facere. Necessitatibus dicta qui consequatur sed ut.', 'Voluptatibus aut repudiandae eum voluptatibus eum iusto eos quaerat aspernatur sit.', 'https://mann.info/autem-pariatur-fugit-nihil-et-et-harum-ab.html', 'Miss Crystel Kuhlman III', 'ORG-8163-ozft', 'Verified', '1996', 100, 2.49, 31, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caa95f9', 53, 'Disaster Impact Association - Port Tristinside', 'School', 'Cum tempore est nostrum. Non et voluptatem quod est nihil fugiat autem. Eum sunt vel quos esse dolorum saepe soluta. Minus magnam ab esse explicabo. Laboriosam numquam nemo qui sit.', 'Vitae non in voluptatem minima autem voluptas quis nemo vel expedita necessitatibus ea libero.', 'https://www.quitzon.com/dolor-blanditiis-saepe-non', 'Lowell Tillman', 'ORG-3102-xqmp', 'Verified', '1995', 57, 4.56, 12, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caaa704', 54, 'Green Earth Institute - Jamaalhaven', 'Community Group', 'Corrupti eligendi quis quia earum sit laboriosam. Iste et dolore delectus non. Amet assumenda amet repellendus nesciunt velit repudiandae facere. Consectetur ut exercitationem officiis velit. Ratione et delectus sequi eos.', 'Aut eos consequatur consectetur aliquam blanditiis ea magni eum sint.', 'http://prosacco.org/cumque-repellendus-aliquam-aut-itaque', 'Miss Joy Bogan', 'ORG-8162-ffon', 'Verified', '1997', 54, 3.70, 23, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caac3ae', 55, 'Youth Society Center - Brandyside', 'Community Group', 'Vel et ea est et est. Corporis commodi rerum aliquam labore. Quod quia non ut beatae consequatur.', 'Quo odio at magnam et et aliquid optio aut consequatur nihil placeat ut quae dolor blanditiis.', NULL, 'Justina Pacocha', 'ORG-9236-jjca', 'Verified', '1998', 33, 2.21, 12, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caad122', 56, 'Global Change Network - Shanahanbury', 'Community Group', 'A tenetur voluptatem dolorum aut dolores doloremque occaecati. Minus autem molestiae at nihil natus cumque. Deserunt sit facere perspiciatis voluptatem numquam totam. Aperiam libero magni magni officiis fugit.', 'Aut rerum voluptate nobis esse velit corporis officia accusantium expedita deserunt incidunt atque qui voluptates sunt architecto.', NULL, 'Lexie Padberg II', 'ORG-4194-lofe', 'Verified', '2001', 19, 4.10, 45, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caadeee', 57, 'Local Action Institute - Port Dulceborough', 'School', 'Quia quidem omnis molestiae sed aliquid molestias est. Alias ut et quis ut nostrum. Animi qui omnis magnam laboriosam explicabo.', 'Velit ab non nisi est molestiae aliquid excepturi harum quia.', NULL, 'Jessyca Bosco IV', 'ORG-4039-raee', 'Verified', '2014', 8, 2.20, 17, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caaed02', 58, 'Animal Support Organization - Wolfchester', 'Charity', 'Ut quam ea delectus doloremque laboriosam porro. Quaerat consequatur omnis a voluptatem in aut. Harum ut veritatis nemo labore nostrum. Ut quidem tempore sint aut eum. Dolorem repudiandae reprehenderit aut numquam alias. Voluptas saepe qui consequatur veritatis a.', 'Reprehenderit et ipsum ipsa voluptate perferendis cupiditate voluptatem.', NULL, 'Alfreda Hackett DDS', 'ORG-9044-sitm', 'Verified', '2021', 24, 3.75, 17, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caafd51', 59, 'Education Change Institute - Lake Evansfurt', 'Community Group', 'Voluptatem repudiandae aut est rerum. Beatae quia ducimus reprehenderit mollitia molestias. Minima alias nam quia aliquam. Non est reprehenderit qui a.', 'Est modi enim et est reprehenderit impedit eum.', NULL, 'Miss Frederique Cummings', 'ORG-0166-tbdo', 'Verified', '1991', 33, 0.06, 2, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab0b48', 60, 'Youth Impact Trust - Lake Hyman', 'Community Group', 'At iusto sit architecto repellat est reprehenderit. Rem vitae cupiditate vel neque. Modi non sit vel est.', 'Non illum amet nihil et voluptatem architecto aut eum atque possimus quia.', 'http://erdman.info/doloremque-doloribus-et-et-quia-dicta-dolorem', 'Walton Torphy II', 'ORG-7776-ujmr', 'Verified', '1991', 39, 3.32, 17, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab1b30', 61, 'Disaster Impact Organization - Larueview', 'NGO', 'Occaecati est et eos et magni. Eum eos in veritatis nesciunt. Sit incidunt vitae at tempora nulla. Est vel eveniet modi molestiae sint quia.', 'Odit beatae aut labore aperiam ut ipsam ut nostrum et accusamus.', NULL, 'Mario Stroman', 'ORG-7096-ukcr', 'Verified', '1999', 53, 3.62, 20, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab311e', 62, 'Hope Impact Association - Shannyfort', 'School', 'Sunt voluptate debitis soluta ut neque quia. Non qui dignissimos quam qui sint ut hic et. Error quis ab exercitationem reprehenderit. Culpa laudantium sed repellat est id fuga.', 'Facilis aliquid eum optio quos vitae magnam iure iste enim dolore aliquid eligendi non.', NULL, 'Oceane Goyette', 'ORG-3350-znel', 'Verified', '2002', 40, 1.49, 15, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab450a', 63, 'United Alliance Organization - Port Abe', 'Charity', 'Ut ipsa dolores placeat et quas voluptatum. Qui adipisci consequatur repellat veniam vero debitis accusamus odit. Aperiam ut ipsam reprehenderit recusandae vitae voluptatum nesciunt.', 'Libero quibusdam nobis veniam illo officia corrupti recusandae sit quod quo ipsa deserunt quo.', 'http://auer.com/est-non-aut-quasi', 'Reagan Oberbrunner', 'ORG-3156-vjjv', 'Verified', '2008', 100, 1.68, 7, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab54a9', 64, 'Senior Heroes Network - Albinamouth', 'School', 'Corrupti distinctio soluta veritatis ut. Porro corporis non quas dignissimos aperiam molestiae reprehenderit voluptatibus. Dolorum dolores sed in ad dolores. Omnis tempora quos quam.', 'Voluptas a aut et ut officiis sapiente atque qui fugiat porro vel assumenda dolor.', 'http://www.conn.com/laudantium-aut-enim-eveniet-sunt-voluptas-ab', 'Mrs. Hortense Cronin', 'ORG-1880-vcwr', 'Verified', '2016', 14, 1.19, 39, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab6522', 65, 'Youth Alliance Center - O\'Reillytown', 'Hospital', 'Quae cumque consequatur dolor quibusdam rerum maiores maxime. Quisquam similique dolorem dolor ut et. Ratione impedit blanditiis aliquam consequatur.', 'Quo voluptatem quod voluptatum nulla qui nam voluptatum sit.', NULL, 'Luna Rogahn DVM', 'ORG-3243-icps', 'Verified', '2012', 90, 2.92, 33, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab74e0', 66, 'Community Relief Trust - Eloisaside', 'Community Group', 'Ipsam repellendus quo qui ut soluta omnis magnam incidunt. Ut omnis corrupti distinctio accusantium. Dolorum et illum voluptate adipisci aperiam. Commodi nulla ad dignissimos fugit sint qui. Voluptatum accusantium est eos occaecati et maxime eligendi.', 'Et consequatur dolore excepturi aut magnam aut ipsa.', 'https://koss.org/et-placeat-voluptas-exercitationem-rerum-et-cumque.html', 'Destiney Swift', 'ORG-8162-fqrs', 'Verified', '2011', 18, 0.33, 18, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab8454', 67, 'Local Welfare Association - North Lelahland', 'School', 'Est voluptas sunt corporis minima. Non et voluptatum qui voluptas. Et est eveniet suscipit temporibus voluptatem autem. Quia dolores optio consequuntur aperiam labore quisquam. Doloremque quod ut et nihil nemo quisquam. Magni nobis et aut vel deleniti aut in.', 'Dolorem ducimus tempora sit dolores consequatur veritatis sed nemo laboriosam quia rerum magnam blanditiis dolor.', 'https://www.schumm.com/quod-a-quod-totam-expedita-soluta-dolores', 'Silas Sauer', 'ORG-3104-nmaj', 'Verified', '2008', 38, 1.65, 50, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cab92f0', 68, 'Disaster Action Institute - Port Jacey', 'Charity', 'Tempore commodi eos fuga vel et deleniti voluptas. Aut consequuntur doloribus voluptas minus. Qui assumenda minus est sunt amet ut. Libero et in aut et at qui ut. Nihil aliquid dolorem inventore consequatur.', 'Nobis est ducimus ipsa officia accusantium necessitatibus asperiores ipsa quia quae tempore impedit dignissimos.', 'http://bernhard.biz/dolorem-velit-sed-dicta-sint.html', 'Claudine Schowalter', 'ORG-8073-ymca', 'Verified', '2013', 81, 1.28, 32, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6caba232', 69, 'Future Welfare Foundation - Lake Aricstad', 'NGO', 'Illo magnam magni molestiae magnam iusto. Excepturi iste et exercitationem. Ut est ex nemo non quia consequatur. Et ab deleniti non et voluptatibus.', 'Pariatur rerum iure illo distinctio qui est officia quaerat aliquam nulla ut sint atque architecto quia est.', 'http://upton.com/', 'Mrs. Justine Moen', 'ORG-8244-lftk', 'Verified', '2007', 7, 3.10, 46, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cabb2c3', 70, 'Healthcare Earth Trust - North Shawnland', 'School', 'Similique odit perspiciatis ipsum. Ab et qui qui laudantium itaque nesciunt reiciendis. Impedit ratione saepe blanditiis quas amet. Quo dolores animi est aut et. Natus vero veritatis recusandae delectus nihil qui aut. Sed aperiam hic aut fuga odit voluptas.', 'Perferendis illo tempore omnis et magni asperiores est qui aut eos.', NULL, 'Verla Lubowitz', 'ORG-7356-kxqb', 'Verified', '1999', 64, 3.28, 33, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6cabc18d', 71, 'Global Support Society - East Amy', 'NGO', 'Dicta ut enim voluptate sunt dolorem hic. Placeat et repellat ea voluptatibus. Est animi suscipit beatae delectus. Impedit dolorem hic quia et consequuntur.', 'Consequatur minus qui dolores enim sunt provident et error sit ducimus vel et tempore eveniet.', NULL, 'Darryl Weber', 'ORG-1894-xfry', 'Verified', '2014', 74, 3.80, 4, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
('org_6931b6f583cfa', 215, 'National Action Network - West Emilieburgh', 'NPO', 'Tenetur explicabo quasi error molestiae sequi et eligendi. Sunt optio labore vel magnam. Fugit quo quia eaque a. Ipsam ad aut quia nostrum veniam.', 'Incidunt molestias voluptas voluptas vitae et vel debitis ratione.', 'http://schamberger.com/eos-dolor-deserunt-dolorum', 'Hattie Konopelski PhD', 'ORG-5829-wasq', 'Verified', '2018', 80, 4.98, 13, '2025-12-04 16:29:41', '2025-12-04 16:29:41'),
('org_6931b6fb6c5e6', 237, 'Green Support Organization - West Maci', 'Charity', 'Aut reiciendis vero quos voluptates nostrum. Perferendis ipsam qui doloremque. Est autem nihil id dolor error ut. Est eligendi voluptas et facere quo eum voluptas. Vero esse saepe reprehenderit eum sed quas molestiae. Enim accusamus qui quos accusantium.', 'Similique sunt reprehenderit aspernatur nostrum architecto enim aut quaerat et reprehenderit.', 'http://www.runte.com/ipsam-quia-inventore-sit-dicta.html', 'Samir Leffler', 'ORG-6234-andb', 'Verified', '2019', 91, 2.90, 7, '2025-12-04 16:29:47', '2025-12-04 16:29:47'),
('org_6931b70aa30d6', 295, 'United Care Organization - Montyburgh', 'Hospital', 'Dicta cumque aut aliquid nemo earum. Excepturi ratione corrupti maxime natus omnis. Et et odit velit voluptatem. Voluptatem quos saepe assumenda omnis aspernatur distinctio magni at.', 'Fugiat sequi atque fugit harum excepturi quia omnis vel ut enim culpa repellat exercitationem vitae exercitationem.', 'http://www.king.com/dolorem-possimus-dignissimos-dolorem-quis-ut.html', 'Gwen Hammes', 'ORG-0775-mtxe', 'Verified', '2000', 63, 2.28, 0, '2025-12-04 16:30:02', '2025-12-04 16:30:02'),
('org_6931b71251871', 324, 'Education Citizens Network - Robelfort', 'NPO', 'Dolores dolorem voluptas reprehenderit nisi est est sunt aperiam. Iure temporibus iste incidunt qui laboriosam laudantium est. Saepe suscipit accusantium rem accusamus tempore dicta.', 'Eveniet sunt illum aperiam veniam praesentium voluptatem dolor necessitatibus amet voluptas fugiat vel.', NULL, 'Jaron Bechtelar', 'ORG-9731-fjzr', 'Verified', '1992', 83, 2.58, 38, '2025-12-04 16:30:10', '2025-12-04 16:30:10');

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

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `content`, `image_url`, `post_type`, `status`, `admin_notes`, `likes_count`, `comments_count`, `shares_count`, `views_count`, `is_pinned`, `allow_comments`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 350, NULL, 'Hôm nay Quý buồn', NULL, 'general', 'published', NULL, 1, 5, 0, 17, 0, 1, '2025-12-09 04:47:50', '2025-12-09 04:47:50', '2025-12-09 14:34:04');

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

--
-- Đang đổ dữ liệu cho bảng `post_bookmarks`
--

INSERT INTO `post_bookmarks` (`bookmark_id`, `post_id`, `user_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 349, NULL, '2025-12-09 04:48:58', '2025-12-09 04:48:58'),
(2, 1, 350, NULL, '2025-12-09 06:58:20', '2025-12-09 06:58:20');

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

--
-- Đang đổ dữ liệu cho bảng `post_comments`
--

INSERT INTO `post_comments` (`comment_id`, `post_id`, `user_id`, `content`, `parent_id`, `is_approved`, `likes_count`, `created_at`, `updated_at`) VALUES
(1, 1, 350, 'oke bạn', NULL, 1, 0, '2025-12-09 06:46:26', '2025-12-09 06:46:26'),
(2, 1, 350, 'oke bạn', NULL, 1, 0, '2025-12-09 06:46:45', '2025-12-09 06:46:45'),
(3, 1, 350, 'abc', NULL, 1, 0, '2025-12-09 06:55:57', '2025-12-09 06:55:57'),
(4, 1, 350, 'abc', NULL, 1, 0, '2025-12-09 06:58:08', '2025-12-09 06:58:08'),
(5, 1, 350, 'hoa sơn quý', NULL, 1, 0, '2025-12-09 06:58:28', '2025-12-09 06:58:28');

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

--
-- Đang đổ dữ liệu cho bảng `post_likes`
--

INSERT INTO `post_likes` (`like_id`, `post_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 350, '2025-12-09 06:43:36', '2025-12-09 06:43:36');

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

--
-- Đang đổ dữ liệu cho bảng `post_media`
--

INSERT INTO `post_media` (`id`, `post_id`, `file_path`, `file_type`, `created_at`, `updated_at`) VALUES
(1, 1, 'posts/V3Qx8i6nvoCM9mkxDoJNrfrQOOxktZ0OTEte2MWd.jpg', 'image', '2025-12-09 04:47:50', '2025-12-09 04:47:50');

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

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `reviewer_id`, `reviewee_id`, `opportunity_id`, `rating`, `review_title`, `review_text`, `review_type`, `is_approved`, `helpful_count`, `created_at`) VALUES
(1, 61, 29, 48, 2, 'Quibusdam ex blanditiis sit architecto excepturi porro ut.', NULL, 'Organization to Volunteer', 0, 3, '2025-12-04 16:29:02'),
(2, 29, 61, 48, 2, NULL, NULL, 'Volunteer to Organization', 1, 24, '2025-12-04 16:29:02'),
(3, 65, 33, 73, 1, NULL, NULL, 'Organization to Volunteer', 1, 19, '2025-12-04 16:29:02'),
(7, 33, 65, 73, 2, NULL, 'Doloribus est labore expedita est molestiae dolorem quisquam. Sint sunt in qui similique. Eos rem sunt odit. Nihil et fuga commodi consectetur hic accusamus.', 'Volunteer to Organization', 1, 25, '2025-12-04 16:29:02'),
(9, 62, 35, 53, 4, NULL, NULL, 'Organization to Volunteer', 1, 9, '2025-12-04 16:29:02'),
(10, 35, 62, 53, 2, 'Autem veritatis ipsa nisi sint modi.', NULL, 'Volunteer to Organization', 1, 0, '2025-12-04 16:29:02'),
(11, 63, 29, 59, 4, 'Cupiditate accusamus est et.', NULL, 'Organization to Volunteer', 1, 35, '2025-12-04 16:29:02'),
(12, 29, 63, 59, 4, NULL, NULL, 'Volunteer to Organization', 1, 47, '2025-12-04 16:29:02'),
(21, 60, 2, 40, 2, 'Placeat iste eius harum.', 'Molestiae ipsam iste voluptate commodi iusto corporis. Voluptate molestiae et neque quod quis ut. Et dicta consequatur in eum cum architecto illum.', 'Organization to Volunteer', 1, 0, '2025-12-04 16:29:02'),
(22, 2, 60, 40, 1, NULL, 'Deleniti nobis adipisci natus voluptatum qui magni. Culpa omnis voluptatem neque nam odit qui nulla. Modi optio voluptas adipisci quia ut harum. Quia fugiat optio sint fuga. Debitis aliquid vero numquam accusamus consequatur ducimus.', 'Volunteer to Organization', 1, 18, '2025-12-04 16:29:02'),
(25, 67, 15, 80, 2, NULL, 'Enim dolorem non qui ullam dignissimos. A non ut non ipsa beatae nobis sapiente. Perspiciatis maxime laboriosam qui eius qui. Dolorem commodi saepe dolor error inventore.', 'Organization to Volunteer', 1, 37, '2025-12-04 16:29:02'),
(26, 15, 67, 80, 3, 'Culpa reiciendis fuga repellendus deserunt.', 'Ducimus dolor rerum vero ex aliquid consectetur recusandae error. Et iure sint distinctio recusandae et et ut. Pariatur velit cupiditate eius cupiditate.', 'Volunteer to Organization', 1, 46, '2025-12-04 16:29:02'),
(29, 54, 42, 13, 4, 'Quia minima aspernatur saepe dolorem.', NULL, 'Organization to Volunteer', 1, 3, '2025-12-04 16:29:02'),
(33, 42, 54, 13, 4, 'Voluptatem explicabo deserunt impedit rerum sit.', NULL, 'Volunteer to Organization', 0, 13, '2025-12-04 16:29:02'),
(34, 56, 11, 23, 3, 'Corrupti inventore deserunt vel.', 'Culpa odio nesciunt eum aperiam quos. Ut aspernatur error dolorem voluptatem repellat expedita eos. Magni eligendi ut non. Maiores cupiditate cupiditate explicabo doloremque vitae quia eligendi dolorum.', 'Organization to Volunteer', 1, 7, '2025-12-04 16:29:02'),
(35, 11, 56, 23, 2, NULL, 'Animi necessitatibus sit beatae quis. Expedita a ullam temporibus asperiores dolore rerum. Nihil vel nulla minima vero et.', 'Volunteer to Organization', 0, 25, '2025-12-04 16:29:02'),
(40, 53, 45, 11, 3, NULL, 'Molestias quia magnam voluptatem animi tempora quam. Cupiditate temporibus soluta qui sit ea. Architecto ut et ex. Soluta necessitatibus earum accusamus omnis assumenda sunt non. Voluptate quam et quisquam non.', 'Organization to Volunteer', 1, 0, '2025-12-04 16:29:02'),
(41, 45, 53, 11, 3, 'Voluptatem ab sit quae aut eaque et.', NULL, 'Volunteer to Organization', 0, 28, '2025-12-04 16:29:02'),
(42, 63, 7, 61, 2, 'Eos nihil officiis libero neque eos.', 'Accusantium occaecati architecto corporis et numquam quidem suscipit deserunt. A tempora ut molestias. Officia vitae nihil voluptatem cupiditate. Optio rerum nesciunt deserunt.', 'Organization to Volunteer', 1, 50, '2025-12-04 16:29:02'),
(43, 7, 63, 61, 3, NULL, 'Fuga placeat similique blanditiis laborum est. Doloremque blanditiis in cupiditate impedit. Earum quia voluptatem et maxime et officiis error.', 'Volunteer to Organization', 1, 44, '2025-12-04 16:29:02');

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
  `verification_token` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `reset_password_token` varchar(255) DEFAULT NULL,
  `reset_password_token_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `google_id`, `facebook_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `date_of_birth`, `gender`, `city`, `district`, `address`, `user_type`, `avatar_url`, `is_verified`, `is_active`, `last_login_at`, `last_activity_at`, `remember_token`, `verification_token`, `email_verified_at`, `reset_password_token`, `reset_password_token_expires_at`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'admin@volunteer.com', '$2y$12$eXT959EwxtfBf.s4Id/XH.zJGwRSymMDfPE59SjYIuuz6HOWYPh72', 'Admin', 'User', NULL, '1988-07-19', 'Female', 'Hanoi', NULL, NULL, 'Admin', 'https://via.placeholder.com/200x200.png/0044dd?text=people+doloribus', 1, 1, '2025-12-04 16:31:19', '2025-12-04 16:31:29', 'WY2HIYIoIc7vj35KCnXh3QsLaJX1FZVQWRpIwTNhdF8gqp5BnoF925QQEwb8', NULL, NULL, NULL, NULL, '2025-12-04 16:28:42', '2025-12-04 16:31:29'),
(2, NULL, NULL, 'crooks.neva@example.net', '$2y$12$z0/xPN9VfhXBPLSr/aV00urHzixAtwepLdATvBqyMZ0tIfVB5acZW', 'Garnet', 'Kozey', NULL, '1988-07-29', 'Female', 'Can Tho', 'Horaciotown', '4748 Heidenreich Mount\nPort Anastaciostad, TX 17893', 'Volunteer', NULL, 1, 1, '2025-11-17 21:23:15', NULL, 'lGsGqxHf4F', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(3, NULL, NULL, 'chad85@example.org', '$2y$12$eSWlLYwkTnE8Y3MTpgIhN.hFIy2RnX.UxqfqWx2pj4TmndMI2YIlK', 'Malika', 'Cartwright', '0940921666', '1986-12-30', 'Other', 'Can Tho', 'Batzport', '8992 Larson Ports Apt. 549\nNorth Abigailside, TN 60225-1275', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb77?text=people+similique', 1, 1, NULL, NULL, 'bGoV17DBCH', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(4, NULL, NULL, 'madaline97@example.com', '$2y$12$KArKLL8V4GxjRl/bbjziGO9iZvBxE/tQbEnMA1zwrzWFf9KYTBMny', 'Luigi', 'Greenholt', '0942025819', '1999-06-15', 'Male', 'Can Tho', 'North Clinton', '756 Shawn Burgs Suite 935\nWilliamsonborough, NM 99613-8732', 'Volunteer', NULL, 1, 1, NULL, NULL, 'Xw6sM96ouM', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(5, NULL, NULL, 'magdalena.ward@example.net', '$2y$12$BfcVL2Q8QG8sVvWSkwPJvOI.7xIBihc8kMkW6EY.eNKwxAeS5HxTK', 'Patience', 'Pagac', '0963628191', '2001-04-30', 'Male', 'Can Tho', 'Lake Kelly', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'iiXzChsmQl', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(6, NULL, NULL, 'fwatsica@example.net', '$2y$12$KZYNknxCBbzS.jVG7USG7eik0wEqetrXpx/NIzROd/T7sDRt6GVCm', 'Esteban', 'Buckridge', NULL, '1975-11-19', 'Female', 'Can Tho', 'North Andrestown', NULL, 'Volunteer', NULL, 1, 1, '2025-11-17 01:18:16', NULL, 'RKoByGAoOT', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(7, NULL, NULL, 'judy.hauck@example.org', '$2y$12$wV8ROTfE2m8EwdeHRbh75OML809cqeI2b9trO0hvcW5HZN44to/Bm', 'Roderick', 'Rempel', '0972016628', NULL, 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc44?text=people+assumenda', 1, 1, NULL, NULL, '0nZExP754e', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(8, NULL, NULL, 'ogaylord@example.com', '$2y$12$qJ9yuXisuoJ0eBLUdocjd.j/evCEGNy5ruxouNtJMun6oOjg2oiwK', 'Anjali', 'Funk', NULL, '1968-05-23', 'Male', 'Can Tho', 'Fritzfort', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/003355?text=people+magni', 1, 1, NULL, NULL, 'JGlZTcgagF', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(9, NULL, NULL, 'edwardo.schiller@example.org', '$2y$12$b2llTZjA3Nk5HOogZIsFZe0cYJM2QOWXXvHoxIC2pWVLehbOvmPtO', 'Libbie', 'Hartmann', NULL, '1989-01-27', 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'QxCsZ27cMG', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(10, NULL, NULL, 'feest.jennie@example.com', '$2y$12$heRv76GdX0vYEONQ1VGFdOpKcwM8mDQOzPLkeUA8Bg/F4z09x0ag2', 'Reagan', 'Thompson', NULL, '1969-01-08', 'Female', 'Hanoi', NULL, '45772 Hegmann Extensions Apt. 309\nGreenfelderfurt, VT 54321-6883', 'Volunteer', NULL, 1, 1, NULL, NULL, '9EeUkvmRS9', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(11, NULL, NULL, 'ksauer@example.org', '$2y$12$XXUtfUiMQnHqDIYyeA29NOb1Fxk2xZSP65D49KkB16HVBPus10wR.', 'Michale', 'Shields', NULL, '1978-01-14', 'Male', 'Ho Chi Minh', NULL, '2954 Klocko Glens Apt. 324\nNorth Quintenchester, SD 52304-5037', 'Volunteer', NULL, 1, 1, '2025-11-30 03:15:45', NULL, 'rW45BiahIj', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(12, NULL, NULL, 'antonetta58@example.net', '$2y$12$ZsPr4MHFCcchCiX53VT0k.kpRc953WqiA91og.77q6UjGeGFGZmhq', 'Everett', 'Herzog', '0968253953', NULL, 'Other', 'Can Tho', 'Jacobsmouth', '997 Shayna Common Suite 463\nNew Andreannehaven, MI 92987-2778', 'Volunteer', NULL, 1, 1, '2025-11-25 23:04:59', NULL, '01jwIgMyKg', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(13, NULL, NULL, 'cremin.carson@example.com', '$2y$12$FOBuPpqylJq12Zz1vyvjgu5DQJHQYone.ksfPwcM9tUBCpNee.GQK', 'Liliane', 'Wolf', '0934999136', NULL, 'Male', 'Can Tho', 'Lake Maryammouth', '8271 Stroman Pines Suite 938\nJakubowskiside, MA 69855', 'Volunteer', 'https://via.placeholder.com/200x200.png/0088ee?text=people+enim', 1, 1, '2025-11-30 12:20:07', NULL, 'qZNLZ2x043', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(14, NULL, NULL, 'veum.keshaun@example.com', '$2y$12$E5Iz5osYbZ3jQoktB.s/HeO9r11i3t.B4gWRvXMqSF0XuBda1u6ki', 'Cooper', 'Grady', '0935636580', '1985-08-29', 'Other', 'Da Nang', 'Moenmouth', '57088 Kristian Glens\nMcCulloughmouth, DE 89716-2235', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb33?text=people+porro', 1, 1, '2025-11-24 13:20:43', NULL, 'QhDRIyoLbd', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(15, NULL, NULL, 'otto15@example.org', '$2y$12$7zNuVsKh3WWxLmd76SN0JeszDX6YhZ8y7KvEB3qK2GltwQXB/9SCq', 'Linnea', 'Cronin', NULL, '1986-12-22', 'Other', 'Can Tho', 'Port Jaydonburgh', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0000ff?text=people+et', 1, 1, NULL, NULL, 'hG02lb2EBP', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(16, NULL, NULL, 'charlotte.kunde@example.org', '$2y$12$z.1eLODmK6VCiSm4CLN4M.ApCzSNl9YR5RUY/.iEywlvGVEHssFfC', 'Woodrow', 'Hill', NULL, '2001-10-17', 'Female', 'Da Nang', NULL, '427 Bashirian Mills Suite 881\nSchillerton, TN 36506', 'Volunteer', NULL, 1, 1, NULL, NULL, 'HwCwKzV2he', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(17, NULL, NULL, 'gerry37@example.net', '$2y$12$1jDWhq44ZJ.4Hmx9OI3TbO3O2OUPveB8yIxL4ci3G33KXrMT47FD6', 'Jerrell', 'Abbott', NULL, '1981-08-11', 'Other', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'iA3DMqkrKw', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(18, NULL, NULL, 'njakubowski@example.com', '$2y$12$NG4BOi2jVVG6atjO4dXik.nLD1qpZ1qH0LPLHky46tXpb582hXCSq', 'Brooklyn', 'Bogan', NULL, NULL, 'Male', 'Hai Phong', 'Gretamouth', '1157 Lester Ranch\nSouth Pearline, NC 75485-7430', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aaaa?text=people+autem', 1, 1, NULL, NULL, 'GZJoViR8Ev', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(19, NULL, NULL, 'daniel.jaydon@example.org', '$2y$12$5sPmELhd4j6gxpSKcbT8Nuf2M6BXESsX9ILXOBOXlLEXSKsAvPffq', 'Kara', 'Howell', NULL, '2006-09-27', 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-06 02:26:22', NULL, 'YG8fnaKbua', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(20, NULL, NULL, 'drunolfsson@example.org', '$2y$12$KWXDidyZYSGWSQmGPGy4lexmiOlinNmD9Xgj8cvACz.Ok.vyqe1WC', 'Claire', 'Beer', '0967137285', '2002-03-24', 'Male', 'Ho Chi Minh', 'Baileystad', '534 Kailey Row\nEast Jonland, HI 46805', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb88?text=people+omnis', 1, 1, '2025-11-09 12:03:57', NULL, 'EuHUpTtEfS', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(21, NULL, NULL, 'ivory14@example.com', '$2y$12$W2o.PzhHbLX3A8KWNZDUaOcUcl/1uUWq429Va8KTQ0/IIil2WKtbC', 'Layne', 'Gorczany', NULL, NULL, 'Female', 'Hanoi', 'Samfurt', NULL, 'Volunteer', NULL, 1, 1, '2025-11-23 22:13:04', NULL, 'AVuVO8hDx3', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(22, NULL, NULL, 'randall06@example.org', '$2y$12$2NaURazgliWt0FWl1JJjouUQMTEFAFd4iQJWpWnc7ZPOkHYE8NYeS', 'Gaylord', 'Veum', '0929080296', '1978-12-05', 'Female', 'Da Nang', 'North Bennyton', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008866?text=people+dolor', 1, 1, NULL, NULL, 'Q5vnUFBT4W', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(23, NULL, NULL, 'fcormier@example.com', '$2y$12$7K.qhlAkMjsgFF4WEi0UaOtIzUEt1NSN9rNIqRt/RpRDUj53ICR7a', 'Amber', 'McCullough', '0964114529', NULL, 'Female', 'Ho Chi Minh', 'North Consuelo', '4827 Cierra Stream\nCarolineshire, VT 76599', 'Volunteer', NULL, 1, 1, '2025-11-06 19:07:24', NULL, 'saPdqHDpzS', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(24, NULL, NULL, 'kade06@example.org', '$2y$12$uKEiOX/NdOoBZnjrneVHD.G6ujgX6IQ0ShTmb.52edaqbV939Rthq', 'Brendan', 'Harris', NULL, '2001-03-25', 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb55?text=people+deserunt', 1, 1, NULL, NULL, 'rx1FrS3ExW', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(25, NULL, NULL, 'vhintz@example.com', '$2y$12$37m2c6nYWjCs2hyUS/53S.8t/.fnJV.aw/otUjSdOksVm39Bywr8G', 'Jalen', 'Frami', NULL, '1984-05-30', 'Other', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/004422?text=people+officiis', 1, 1, '2025-11-26 01:12:35', NULL, 'UBkFkHylcn', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(26, NULL, NULL, 'sterling99@example.org', '$2y$12$pkwyZ.7vvfPuzEKJSbh.i.C8v9Oa34kQXZLhLARZvbaYZ71jjO1dW', 'Sid', 'Osinski', '0932424385', '1975-01-10', 'Other', 'Can Tho', NULL, '1135 Seth Village Suite 240\nPort Casey, AR 40036-5770', 'Volunteer', NULL, 1, 1, '2025-12-02 04:23:22', NULL, 'wSc2fHeksY', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(27, NULL, NULL, 'fabian.schaden@example.org', '$2y$12$dcw6woEaS6fzfeY7fzmeNesjCCSqnEAWzsIW6BHR3C5j1BJXfBcS6', 'Harold', 'Pfannerstill', NULL, NULL, 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002266?text=people+ut', 1, 1, NULL, NULL, '309HwHyEQh', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(28, NULL, NULL, 'orpha.rice@example.com', '$2y$12$txrXeVIEkunmW9K8plq.me5MbaOxgHugdJmXFZMqp.H5OtLDKlehO', 'Minerva', 'Veum', NULL, NULL, 'Male', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-14 08:17:32', NULL, 'je4HlA4frZ', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(29, NULL, NULL, 'trenton65@example.com', '$2y$12$xgZ06MBVcmS9Jcqa4fiGaOXCtBI6O59Mv4x7CThARNGSgVd.ee1iC', 'Judah', 'Deckow', NULL, '1994-05-02', 'Female', 'Da Nang', 'Lake Marielamouth', '33511 Aufderhar Square Suite 155\nNorth Davonte, TX 48456-8506', 'Volunteer', 'https://via.placeholder.com/200x200.png/0055bb?text=people+aut', 1, 1, '2025-11-07 01:10:12', NULL, '90Ql9C8RfM', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(30, NULL, NULL, 'hgislason@example.org', '$2y$12$ENLis5N/HIeke3kbAR.7/OJm9NtrlYAxK5cfgglqGFRkdE2eNasIa', 'Matt', 'Tremblay', '0995905405', NULL, 'Female', 'Ho Chi Minh', NULL, '910 Marjory Loaf\nHendersonstad, ND 53866', 'Volunteer', NULL, 1, 1, '2025-11-16 06:07:53', NULL, 'zz0MVADvu9', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(31, NULL, NULL, 'collier.jennings@example.org', '$2y$12$xvYvsmOHygiP2cMy3.Vtn.OuKSHyfoyEdpRYPfOYfDK8k9uQf.6am', 'Kylee', 'Runolfsson', '0918531761', '1972-12-04', 'Female', 'Ho Chi Minh', 'North Barrett', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aacc?text=people+totam', 1, 1, NULL, NULL, 'Wn2pxvmgiW', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(32, NULL, NULL, 'langworth.ali@example.net', '$2y$12$qqEorMr5kyz/Ue9yVpnvruhUd4naxCEP/b5zAXqfILShw4zcDd.Ge', 'Mitchell', 'Runolfsson', '0984238265', NULL, 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, '9HErZxJ763', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(33, NULL, NULL, 'laurence18@example.net', '$2y$12$ddVMiW4RiNF32hE20oXoFO.SvtLMMqYwELRgqdJnTy7EvpyrSIDfa', 'Ernestine', 'West', '0993505167', NULL, 'Other', 'Hai Phong', 'Runtemouth', '380 Collins Inlet Suite 700\nSimborough, RI 40425-8912', 'Volunteer', 'https://via.placeholder.com/200x200.png/00eeff?text=people+porro', 1, 1, NULL, NULL, 'OKSKHMw7bZ', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(34, NULL, NULL, 'maida.shanahan@example.org', '$2y$12$UREmWpg4QqjqywLweouEUOxzVRrynfY8H6JaD3APsRNIVH21E2YGm', 'Xavier', 'Mills', '0973283803', NULL, 'Other', 'Hanoi', 'South Carmella', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+repellat', 1, 1, NULL, NULL, 'j3EHJqGny6', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(35, NULL, NULL, 'marilyne50@example.com', '$2y$12$RqpRnE4N2PSmqJuLIbMTHe07eT4G8.hkoJqfT26lRaJcELnrMLg4W', 'Gracie', 'Kuhlman', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, '717 Lauren Dam\nBrekkeland, UT 75093', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000ee?text=people+iusto', 1, 1, NULL, NULL, 'VtFPW04ftU', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(36, NULL, NULL, 'dusty98@example.net', '$2y$12$7.ARi5UWVJ39ZH2itU/bneD029xJBmmkbVtTUXQ.PGiVnq5RgQ.ma', 'Zakary', 'Mayer', NULL, '1991-06-26', 'Other', 'Da Nang', 'Port Andyhaven', NULL, 'Volunteer', NULL, 1, 1, '2025-11-05 22:44:18', NULL, 'GVZUMP1iCz', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(37, NULL, NULL, 'leora04@example.com', '$2y$12$iiMIcAAemg8SuCNIGVr.8uvZtDbwt4s/cH7WE/Pvwrj251nGEpn5m', 'Austyn', 'Predovic', '0977354058', '2007-07-14', 'Male', 'Can Tho', 'Lake Janiceville', NULL, 'Volunteer', NULL, 1, 1, '2025-11-16 12:19:48', NULL, 'uFzsMVJ6nJ', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(38, NULL, NULL, 'lfay@example.net', '$2y$12$VuykUgFEqwn1MGVJ3ol7deLASozqvIZ1khSa01iqI7cBxc1Rq.KtG', 'Monty', 'Harber', '0919638426', '2000-06-18', 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-12-03 23:23:55', NULL, 'CRlJ0mZLM7', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(39, NULL, NULL, 'rossie38@example.com', '$2y$12$Cfj.fexwSRrwqkAsSDB9HuMeA7zTFZ2SAMo2z3ClW4mM9N3HaiC1O', 'Freda', 'Metz', NULL, '1992-10-02', 'Female', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/004411?text=people+ea', 1, 1, '2025-11-16 06:59:30', NULL, 'JJwesGXgP2', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(40, NULL, NULL, 'bridgette33@example.org', '$2y$12$n9mJvefLiRZZkzaX4koYKuQn4szxzS/qLbuOzt9vGuVTJVth9mAmC', 'Kolby', 'Graham', '0977614873', '1990-05-21', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd11?text=people+culpa', 1, 1, NULL, NULL, 'oDs8V3AQJk', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(41, NULL, NULL, 'ruthie.conn@example.org', '$2y$12$MgoPfTtoIfNPlG/kh/eI4.y1T6zUCQlZAwgrCny2wrqvDoUb2owsK', 'Abigale', 'Runolfsson', NULL, NULL, 'Other', 'Can Tho', 'Lake Lacyfurt', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd44?text=people+voluptatibus', 1, 1, '2025-11-06 02:23:43', NULL, 'JQbcm32WIK', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(42, NULL, NULL, 'ova85@example.net', '$2y$12$c0nD0FyRMv2vW5MLgZ7lLO8n6.ld4h54VPmqYvZ.6C4akfn64IfX.', 'Dante', 'Kovacek', '0916485729', NULL, 'Other', 'Can Tho', 'Judyhaven', '9361 Kutch Fork Apt. 267\nWunschside, KY 38014-6493', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000bb?text=people+minima', 1, 1, '2025-11-22 01:45:31', NULL, 'VKaeS19hyS', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(43, NULL, NULL, 'irwin.brekke@example.org', '$2y$12$1A/GUOHlLBDBq1y9y25IS.rkHR4uxtWuUhNoljJEEsioIJdZWTVz6', 'Timothy', 'Kassulke', NULL, '1992-11-03', 'Male', 'Can Tho', 'Gottliebmouth', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002288?text=people+laborum', 1, 1, NULL, NULL, 'D03aU9pz6Q', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(44, NULL, NULL, 'uhauck@example.org', '$2y$12$Xum/.wUgs6FEhI2w9ghNvOTDRvHSbGMWfCsM5VHFF.0uVeltuwxSm', 'Jalyn', 'Johnston', '0916234997', '2001-03-04', 'Other', 'Hanoi', 'Clarabellefurt', '44777 Cora Center Apt. 168\nNew Jonathan, AK 51366-4463', 'Volunteer', NULL, 1, 1, NULL, NULL, 'ett8v21hA3', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(45, NULL, NULL, 'teagan68@example.org', '$2y$12$nkFTz.TLbGzhtix8jJ/ycu4FTh9Y85cIrs8cA8dqUCHM0mKjljCaC', 'Delphine', 'Raynor', NULL, '2003-08-05', 'Male', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'cjOCuMBNOm', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(46, NULL, NULL, 'rboyer@example.net', '$2y$12$T/BdBW1GncHKzgxwwHH34.gYkwBdzUaGos9/HBHy.JIB12yJxFpgq', 'Annabel', 'Block', NULL, '1982-08-15', 'Other', 'Ho Chi Minh', 'South Kaitlinshire', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd11?text=people+aut', 1, 1, '2025-12-04 07:50:03', NULL, 'SMiSvGofZq', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(47, NULL, NULL, 'qhowe@example.com', '$2y$12$1W6RFJwHG0ieN0pkkNQVi.FA7waWhkmR/HwFz22fWLR9wpuVgECfW', 'Harold', 'Haag', '0939783811', NULL, 'Female', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/006600?text=people+deleniti', 1, 1, NULL, NULL, 'RTYCRp6IM4', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(48, NULL, NULL, 'enid.schuster@example.com', '$2y$12$EGpvyueitY1Os65RT5aCCe3LyEXsGGR9xLUMV1FzL7bKpgS/nx6z.', 'Bianka', 'Davis', '0960766420', NULL, 'Other', 'Hai Phong', 'West Stellaville', '910 O\'Hara Hill\nHuelport, NY 59666-5536', 'Volunteer', NULL, 1, 1, NULL, NULL, 'INAaorcwiF', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(49, NULL, NULL, 'lockman.arielle@example.com', '$2y$12$6E02iIUyzZOKvqlekEiqZOYNIaOc3fdyc.X9elYSQ7rtYLmAl6qZO', 'Brian', 'West', '0928915394', '1971-03-22', 'Female', 'Da Nang', NULL, '37706 Aliya Forge Suite 585\nKiehnton, SD 68631', 'Volunteer', NULL, 1, 1, NULL, NULL, 'z6hoY8gjLF', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(50, NULL, NULL, 'eldred.nienow@example.net', '$2y$12$siTCL6gwgvSLf5fGMBIUdeNdDxORVLt5FhER/AODZXFpA18Ou7nqi', 'Giovanni', 'Schultz', '0948153529', '2003-11-05', 'Female', 'Can Tho', 'North Litzy', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005577?text=people+et', 1, 1, '2025-11-19 18:22:09', NULL, 'qZWDsI0nfi', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(51, NULL, NULL, 'gschulist@example.org', '$2y$12$BpY548cITTU.cyHXQmjwEOPs9uf4anGFsEUB4ZK9CrhEe2BlHnaza', 'Ellis', 'Conn', NULL, '1967-02-26', 'Female', 'Hanoi', NULL, '32369 Cicero Flats\nSouth Jimmy, AK 30192-1422', 'Volunteer', NULL, 1, 1, '2025-11-17 17:01:26', NULL, 'KBj7XwdDWX', NULL, NULL, NULL, NULL, '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(52, NULL, NULL, 'kiera.bode@example.com', '$2y$12$vpzBmVBlXrVGLoP82OBk4OV9n5zrQRybytleEa1dxfu.TMxkzKN0S', 'Karli', 'Tremblay', '0901649399', '2007-03-23', 'Other', 'Hanoi', NULL, NULL, 'Organization', 'https://via.placeholder.com/200x200.png/0077bb?text=people+omnis', 1, 1, NULL, NULL, 'yQNAh5UmpA', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(53, NULL, NULL, 'wyman.noel@example.com', '$2y$12$hZA/FC3.3mnuzOT/qHXQF.RYya.wfqH7PDfl1iztUJ2Xh60NKRfnq', 'Virgie', 'Corkery', '0923268720', NULL, 'Male', 'Hai Phong', NULL, '79218 Rubie Ferry\nDaughertyton, DC 43113-0993', 'Organization', NULL, 0, 1, NULL, NULL, 'OeKG2Z3uys', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(54, NULL, NULL, 'vsipes@example.org', '$2y$12$M0mP25Yb2EwvjK3TgAnNoO/WhMSWc1Bi.xUIZFosAhpJkNK/m9TqW', 'Devon', 'Witting', NULL, NULL, 'Female', 'Can Tho', 'Klockoland', '779 Pouros Courts\nSouth Mitchelfurt, SC 26846-0493', 'Organization', 'https://via.placeholder.com/200x200.png/00ffdd?text=people+illum', 1, 1, NULL, NULL, 'GksyNlSlaV', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(55, NULL, NULL, 'shanahan.alexa@example.org', '$2y$12$qFk.A/fRdiAFpViyaWx.7ODZtC09TBFc/4JLimplGbdV/mIb1.cwy', 'Clifton', 'Luettgen', NULL, '1965-12-22', 'Other', 'Ho Chi Minh', NULL, NULL, 'Organization', NULL, 0, 1, NULL, NULL, 'sWJxhUvQZP', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(56, NULL, NULL, 'tracey67@example.net', '$2y$12$rB6QdBi3cE6YdFfVdExgrONEAYMQpl/1M.fGPsKpTmngKs.yfNjs6', 'Katlynn', 'Pouros', NULL, NULL, 'Other', 'Ho Chi Minh', NULL, '4368 Cassie Mount Apt. 353\nZariaburgh, AZ 01108', 'Organization', NULL, 1, 1, '2025-11-16 14:42:39', NULL, 'IdEW9Faang', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(57, NULL, NULL, 'alexandre.greenholt@example.com', '$2y$12$K8ArWQy0WyG1epDgINGT4OxFZ6BPhkqRzaEplz/Bk2GOKUikL2Bja', 'Demond', 'Carter', NULL, NULL, 'Male', 'Hai Phong', NULL, NULL, 'Organization', NULL, 1, 1, NULL, NULL, 'NyDHj9XYbe', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(58, NULL, NULL, 'parisian.ellie@example.org', '$2y$12$UseMt5jTDqsIXlSwohG7dOXdzUbT.bp3jE4OEku/09D0U3crT4BRa', 'Laurianne', 'Russel', '0937152436', NULL, 'Female', 'Can Tho', 'Fatimatown', NULL, 'Organization', NULL, 0, 1, NULL, NULL, 'GiYFEHlRMq', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(59, NULL, NULL, 'pink.ward@example.org', '$2y$12$HT4BtME8CuQO2f5fOyKhIOITgJtQAj88GpD9EEV0ugENJ1NXo37eC', 'Jeramie', 'Gislason', '0992841429', NULL, 'Male', 'Can Tho', NULL, '11757 Nedra Cliffs\nHesselside, NY 26148-3929', 'Organization', NULL, 0, 1, NULL, NULL, 'StHFfSGWSm', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(60, NULL, NULL, 'mfarrell@example.net', '$2y$12$.c14gnjtckSDGcbDBaxU9eCLQKA6QWZLM83Ln4UyFneHzQ3trfQhO', 'Alexandrea', 'Kemmer', NULL, NULL, 'Male', 'Hai Phong', NULL, NULL, 'Organization', 'https://via.placeholder.com/200x200.png/00eebb?text=people+neque', 1, 1, '2025-12-04 16:04:35', NULL, 'lGOTOF8HBJ', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(61, NULL, NULL, 'gnikolaus@example.net', '$2y$12$zrP8YqHl0HG/bV.FtzjmUOlwJje1eS3OcD2D8wlbAEo4HssHsOVje', 'Sonny', 'Lueilwitz', NULL, '1974-08-30', 'Male', 'Hanoi', 'Ebertberg', NULL, 'Organization', 'https://via.placeholder.com/200x200.png/00bbdd?text=people+rerum', 0, 1, NULL, NULL, 'hohT3vTrDd', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(62, NULL, NULL, 'justine47@example.net', '$2y$12$VdYWZL2D7Qm/yfKeyri4f.QRUhMZ3GYy3c7kumF.9/dUxavOHtgtC', 'Octavia', 'Mertz', NULL, NULL, 'Other', 'Can Tho', 'South Lesley', '683 Luisa Path Suite 988\nNew Scottyport, TN 34655-7723', 'Organization', NULL, 1, 1, '2025-11-28 01:33:53', NULL, '2PDxBSd24y', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(63, NULL, NULL, 'loyce.schiller@example.net', '$2y$12$UoDw5PXcQkmDclBJ5VYwnO/SvpO6lpiF.1/zlYbomZEWg0c0Lu8Om', 'Anna', 'Marks', NULL, NULL, 'Female', 'Ho Chi Minh', 'North Karinaberg', '6634 Kessler Hill Suite 832\nWest Winifredview, WI 25836-5548', 'Organization', NULL, 0, 1, '2025-11-21 05:31:20', NULL, '5fguM81cnv', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(64, NULL, NULL, 'americo90@example.net', '$2y$12$3t2aeHCphLRWim6bWyni3uhT/6nkwAC5EEhjojWnfBf021jGOChjC', 'Laverna', 'Quigley', '0972803270', NULL, 'Male', 'Da Nang', NULL, NULL, 'Organization', NULL, 0, 1, NULL, NULL, '0TitxtqsJ5', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(65, NULL, NULL, 'lgoldner@example.net', '$2y$12$GYyNDqBAtu0.cztEc8ZalelSLUM8.NCnJfiiw.y1GeOAocyUoRtXS', 'Emely', 'Walker', NULL, NULL, 'Female', 'Ho Chi Minh', NULL, NULL, 'Organization', NULL, 0, 1, NULL, NULL, '1exFrJYNIz', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(66, NULL, NULL, 'beier.quinten@example.org', '$2y$12$bh11LTa54.zUj3fYE.34euBvPxnnsMysRQR6D723peIg.YTu8nST6', 'Margarett', 'D\'Amore', NULL, '1968-05-21', 'Male', 'Hai Phong', NULL, NULL, 'Organization', 'https://via.placeholder.com/200x200.png/00cc55?text=people+dolor', 1, 1, '2025-11-09 15:44:17', NULL, 'awYOlevohL', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(67, NULL, NULL, 'qblanda@example.com', '$2y$12$Rd7dt0f.aOHRMBDUajlMYOz/mlpa3dhux7UeY8/hUvWFhlwTM9nGa', 'Lonny', 'Ruecker', '0983429303', '1994-02-22', 'Female', 'Hai Phong', 'West Kevinberg', NULL, 'Organization', NULL, 0, 1, '2025-11-08 16:54:58', NULL, 'jWPwpQudzm', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(68, NULL, NULL, 'vklein@example.org', '$2y$12$CeKcDnGaenFatvUBsAdjXOF6hItfq8DAHSljQTAey1gZ1y2dg0KEO', 'Beatrice', 'Stark', '0975766377', '1991-02-12', 'Male', 'Hanoi', NULL, '14757 Deonte Skyway\nJacquesmouth, SC 06641-2160', 'Organization', NULL, 0, 1, NULL, NULL, '8krYzZD72k', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(69, NULL, NULL, 'ocie30@example.org', '$2y$12$ZjM7SsqVhT9I0C21dKJlTO9fc/CuOpgePDCC7Y9j9xYnLo92kq2P2', 'Uriah', 'Haley', '0903852804', NULL, 'Female', 'Da Nang', NULL, '7185 Bahringer Ports Suite 886\nNovafort, AL 81315', 'Organization', 'https://via.placeholder.com/200x200.png/005500?text=people+aliquid', 0, 1, NULL, NULL, 'SImknqS2kB', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(70, NULL, NULL, 'erdman.august@example.net', '$2y$12$Y4Dkb8MCxOlpZQBaHxxjuuBmQwx.Pk4qCySKFMDCuhBk.hXx/hbP.', 'Rashawn', 'Gottlieb', NULL, '1987-01-16', 'Female', 'Hanoi', 'New Salvadorland', NULL, 'Organization', NULL, 1, 1, '2025-11-16 22:04:42', NULL, 'TDYjNmOFsU', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(71, NULL, NULL, 'osbaldo68@example.org', '$2y$12$gFMIfF.XKSnmsEb.SiHEU.u39MPJsfOOkynlpI8fUdWRJGsI.gQ7u', 'Ressie', 'Flatley', '0946147978', NULL, 'Other', 'Ho Chi Minh', NULL, NULL, 'Organization', NULL, 0, 1, NULL, NULL, '4Y4jaMzryY', NULL, NULL, NULL, NULL, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(72, NULL, NULL, 'dario.gulgowski@example.net', '$2y$12$IS3uaWOxXKr5KmeyI61ZbuJYKiDXFbSKYJzWMGKSs36cDwSbMiNxi', 'Dorothy', 'Bauch', NULL, NULL, 'Female', 'Ho Chi Minh', NULL, '697 Lula Crossing\nKundeshire, AZ 49208', 'Volunteer', NULL, 0, 1, NULL, NULL, 'AD7FDoGNB7', NULL, NULL, NULL, NULL, '2025-12-04 16:29:03', '2025-12-04 16:29:03'),
(73, NULL, NULL, 'acasper@example.org', '$2y$12$8ng3hmVP1SKAh/IaDBjNG.eNeLJvqfvzE4wqt9KJE8AUijHBNnVFy', 'Joan', 'Dickinson', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, '561 Ellie Plains Suite 995\nNew Lurline, NH 89069-7198', 'Volunteer', 'https://via.placeholder.com/200x200.png/0011ee?text=people+alias', 1, 1, NULL, NULL, 'Y17TFvSkdF', NULL, NULL, NULL, NULL, '2025-12-04 16:29:03', '2025-12-04 16:29:03'),
(74, NULL, NULL, 'isabelle49@example.net', '$2y$12$LuC3OL0wAyk3o6svGvUy5emmW19V2faHJfXyum7Fh7r5uHyteNYxy', 'Alexis', 'Mayer', NULL, '1987-12-03', 'Other', 'Hanoi', 'Port Forrest', '5090 Torphy Cove Suite 512\nSchusterberg, TX 49366', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+vel', 0, 1, NULL, NULL, '23QQE8SVwK', NULL, NULL, NULL, NULL, '2025-12-04 16:29:03', '2025-12-04 16:29:03'),
(75, NULL, NULL, 'utrantow@example.com', '$2y$12$u9rejf0ZvFhnNW2NMoUpmemTKB7DK.fAfIpvuURziROYhCfw691Qu', 'Mae', 'Mann', '0936529427', NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee66?text=people+illo', 1, 1, NULL, NULL, 'E31ZTd6RNZ', NULL, NULL, NULL, NULL, '2025-12-04 16:29:04', '2025-12-04 16:29:04'),
(76, NULL, NULL, 'ashleigh.johns@example.org', '$2y$12$KAPJOyOym7m1uiEhIioLa.pXxw9CQSyK7EonHbuaueXG1Sh.aiXrC', 'Breanna', 'Stehr', '0958583067', '1993-10-30', 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/003377?text=people+repellat', 0, 1, NULL, NULL, 'w7A4t04NyG', NULL, NULL, NULL, NULL, '2025-12-04 16:29:04', '2025-12-04 16:29:04'),
(77, NULL, NULL, 'szulauf@example.net', '$2y$12$4JUMSj8N/JpUVUv/ERI/4OVQL/v7vy9x1SJ2ayGTPOYiJ.Stm2Qri', 'Aylin', 'Ullrich', '0992096671', '1978-01-18', 'Male', 'Hai Phong', 'Luettgenside', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddff?text=people+ut', 1, 1, '2025-11-27 16:55:29', NULL, 'IeYwhC7368', NULL, NULL, NULL, NULL, '2025-12-04 16:29:04', '2025-12-04 16:29:04'),
(78, NULL, NULL, 'brandon.ernser@example.org', '$2y$12$.dMsU.c5SLBdGmVac5OTIucznFAodYFaFjU/NVgdEQDhS.6Cb7wti', 'Lonie', 'Abshire', '0962682442', NULL, 'Female', 'Ho Chi Minh', 'Wayneborough', '87813 Kautzer Brook\nRauberg, WY 12639-3482', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee44?text=people+rerum', 1, 1, NULL, NULL, 'vjkCQc5t8Z', NULL, NULL, NULL, NULL, '2025-12-04 16:29:04', '2025-12-04 16:29:04'),
(79, NULL, NULL, 'lind.tina@example.com', '$2y$12$QUNJGHhDkEy8wOI3UCW/xeJZmlWipzF6dpJCa3LRXGySYzmqduUVS', 'Jerrold', 'Kerluke', NULL, '1967-06-05', 'Male', 'Hanoi', NULL, '594 Stark Roads\nDwightton, MD 22821', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccff?text=people+veritatis', 1, 1, NULL, NULL, 'BnBLOcKbZu', NULL, NULL, NULL, NULL, '2025-12-04 16:29:05', '2025-12-04 16:29:05'),
(80, NULL, NULL, 'bartholome.quigley@example.org', '$2y$12$nQv59xS0926cM.U515jwfeItOHzgOpNJzsZEm/jQMYRW8Z6Rj1Gv.', 'Pearline', 'Predovic', '0934733167', NULL, 'Male', 'Da Nang', 'Monroestad', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb55?text=people+dolorem', 0, 1, NULL, NULL, 'L7djPQbJUX', NULL, NULL, NULL, NULL, '2025-12-04 16:29:05', '2025-12-04 16:29:05'),
(81, NULL, NULL, 'kerluke.weston@example.com', '$2y$12$deD66clVFmRbfE6MEh8KBey.Ts9ZSLj9Ydh8bQt7CyTyBlC/HajWC', 'Quincy', 'Balistreri', '0999665125', '1980-01-05', 'Male', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-25 23:15:03', NULL, 'MPCaSDieKc', NULL, NULL, NULL, NULL, '2025-12-04 16:29:05', '2025-12-04 16:29:05'),
(82, NULL, NULL, 'sincere65@example.net', '$2y$12$JuY4URm5mA6MyoYFL0vEI.8deVEd3hlbW0YbpMGH44Yvve1afTbpS', 'Daisy', 'Wunsch', NULL, NULL, 'Other', 'Can Tho', 'East Jayson', '6932 Theo Points\nNew Clotildemouth, LA 98097-9541', 'Volunteer', 'https://via.placeholder.com/200x200.png/001111?text=people+amet', 0, 1, '2025-11-24 20:24:12', NULL, '9qOKyT4OOX', NULL, NULL, NULL, NULL, '2025-12-04 16:29:05', '2025-12-04 16:29:05'),
(83, NULL, NULL, 'reinger.iliana@example.com', '$2y$12$fWqG493O2YfYHFVwqsnsZuAOT9B1jYb2Mo3dVzohkMT5NvPPQRf02', 'Camren', 'McClure', '0957848700', NULL, 'Male', 'Hanoi', 'Nicolasmouth', '282 Brook Center Suite 645\nMacejkovicview, IN 65263', 'Volunteer', 'https://via.placeholder.com/200x200.png/003366?text=people+dolorem', 1, 1, '2025-11-16 01:14:02', NULL, 'ONQYAc3JWh', NULL, NULL, NULL, NULL, '2025-12-04 16:29:06', '2025-12-04 16:29:06'),
(84, NULL, NULL, 'lafayette18@example.net', '$2y$12$13rpXZ8Y2LSh97ACtk0xhu9Rp5bqWsuR0HpH2S1IFdrmA3ZozuHp.', 'Elsie', 'Little', NULL, NULL, 'Other', 'Hanoi', NULL, '9292 Raina Forges\nNorth Kasandra, MA 11657', 'Volunteer', NULL, 1, 1, '2025-11-25 16:48:47', NULL, 'cOUYLWbWz9', NULL, NULL, NULL, NULL, '2025-12-04 16:29:06', '2025-12-04 16:29:06'),
(85, NULL, NULL, 'tkuhic@example.org', '$2y$12$Jq.bBxpsGbKKo2Rn0MaDj.BVdxZv8tYX7b8pK.VqRzN3fr8y3SdcS', 'Justen', 'Doyle', '0921508238', NULL, 'Female', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-30 05:34:52', NULL, '09wAgCd0oQ', NULL, NULL, NULL, NULL, '2025-12-04 16:29:06', '2025-12-04 16:29:06'),
(86, NULL, NULL, 'xwunsch@example.net', '$2y$12$aGGU2WVBNdzDhXIhrMGhOuCBXger0.wmU3kjIs9.ayrSaXvExYNRi', 'Jovany', 'Dickens', NULL, '1995-11-12', 'Female', 'Hanoi', 'Boyerfurt', '63222 Hilpert Prairie Apt. 120\nGerholdburgh, NV 11401', 'Volunteer', NULL, 0, 1, NULL, NULL, 'oN2F5eBBUz', NULL, NULL, NULL, NULL, '2025-12-04 16:29:07', '2025-12-04 16:29:07'),
(87, NULL, NULL, 'muller.rubie@example.net', '$2y$12$tqXO9nZIseEhh8zzCIoTiOiJu.XNywud9xQ7ETb8vhwGBIpiSQ046', 'Werner', 'Jakubowski', '0909161082', NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008855?text=people+in', 0, 1, '2025-11-24 03:42:47', NULL, 'L65Prnd5aT', NULL, NULL, NULL, NULL, '2025-12-04 16:29:07', '2025-12-04 16:29:07'),
(88, NULL, NULL, 'bleannon@example.org', '$2y$12$R0EMxGHMDw6w4ng62TkouuKVqehiBJhiMvn1Jfx3koYUUzmtYeiuy', 'Ursula', 'Kemmer', NULL, NULL, 'Male', 'Ho Chi Minh', 'Lake Jaylen', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0044aa?text=people+neque', 0, 1, '2025-11-11 09:25:05', NULL, '678Gtkfreq', NULL, NULL, NULL, NULL, '2025-12-04 16:29:07', '2025-12-04 16:29:07'),
(89, NULL, NULL, 'schuppe.eldred@example.org', '$2y$12$n6Sn5GWJrkxy/wpv06R2NubV8oJ/70/em0jCGGrXCTQLu8XH7jzS2', 'Dayne', 'Robel', '0906086676', NULL, 'Female', 'Da Nang', 'New Janemouth', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd55?text=people+ipsa', 0, 1, NULL, NULL, 'UbQpuBD7ww', NULL, NULL, NULL, NULL, '2025-12-04 16:29:07', '2025-12-04 16:29:07'),
(90, NULL, NULL, 'kdibbert@example.com', '$2y$12$brmnWLP5Jh5BWl1Z1bxivOV5L3/.4q9PtAYW.i40zCcqtEUO6tdUK', 'Vergie', 'Okuneva', '0941657377', NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-25 03:28:29', NULL, '4aBCMmo8y9', NULL, NULL, NULL, NULL, '2025-12-04 16:29:08', '2025-12-04 16:29:08'),
(91, NULL, NULL, 'jules.kirlin@example.org', '$2y$12$K/R8vw5t6lz8G/.z7kplk.9nGq9bwlKGIeFB6UEf2BOYwjSPdYfXK', 'Erling', 'Kris', NULL, '1978-12-04', 'Female', 'Can Tho', 'Wisozkstad', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/009955?text=people+autem', 1, 1, '2025-11-24 06:56:32', NULL, 'aJxY1pIiwB', NULL, NULL, NULL, NULL, '2025-12-04 16:29:08', '2025-12-04 16:29:08'),
(92, NULL, NULL, 'christelle.reichert@example.org', '$2y$12$1ZhR2pTzJv8mUn21j4M70.43mOfgpBIOrga6iuzsOlwpEtCmOCY4W', 'Ebba', 'Rogahn', NULL, '1982-09-05', 'Female', 'Da Nang', 'Muhammadport', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/003333?text=people+sit', 1, 1, NULL, NULL, '9dFtCHHYek', NULL, NULL, NULL, NULL, '2025-12-04 16:29:08', '2025-12-04 16:29:08'),
(93, NULL, NULL, 'jimmie.lindgren@example.org', '$2y$12$VpfzbIUxkMoEPq9c9AXLE.8KWywioxmPa6lhSCs0Xfri9RRzdFPua', 'Judd', 'Stroman', '0943067835', '1977-10-03', 'Other', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-16 02:37:29', NULL, 'FFFjnPOOSC', NULL, NULL, NULL, NULL, '2025-12-04 16:29:08', '2025-12-04 16:29:08'),
(94, NULL, NULL, 'hugh78@example.com', '$2y$12$yMvSsyDHuaMyXICtTtKgPOhQHsGb6d1NlRa4259L34SVmFNrQuNAW', 'Armand', 'Nitzsche', NULL, NULL, 'Other', 'Ho Chi Minh', 'Howellland', '16575 Kris Trace Apt. 835\nNew Laury, CT 17785', 'Volunteer', NULL, 0, 1, '2025-11-08 17:04:08', NULL, '2uZuy1CymY', NULL, NULL, NULL, NULL, '2025-12-04 16:29:09', '2025-12-04 16:29:09'),
(95, NULL, NULL, 'elwyn67@example.org', '$2y$12$qj/uke.mbnkXTvYbEhUa6.So7QR0jOmUv0Cl6UhUKsgCZIGK2YBaa', 'Roberto', 'Heathcote', '0948229904', NULL, 'Other', 'Can Tho', NULL, '9867 Gennaro Crescent\nPort Freddy, ND 66922', 'Volunteer', NULL, 0, 1, NULL, NULL, 'NGrQCiNBcV', NULL, NULL, NULL, NULL, '2025-12-04 16:29:09', '2025-12-04 16:29:09'),
(96, NULL, NULL, 'agustina.jakubowski@example.net', '$2y$12$wFmLwEwDy15FGZ/Dw5N2ZuR0reIIiQpi9zsBfrrxu7h7qmmEUji.G', 'Zola', 'Miller', '0903209767', NULL, 'Other', 'Hanoi', 'East Georgefort', NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'YcvSCxUNdn', NULL, NULL, NULL, NULL, '2025-12-04 16:29:09', '2025-12-04 16:29:09'),
(97, NULL, NULL, 'tyson.breitenberg@example.org', '$2y$12$1RanuewH97ijtnHrO8GG5.NwEqB9wcGc3/zLkMs31xR2tPmSa8kHu', 'Henriette', 'Turner', '0972607773', '1991-06-20', 'Female', 'Hanoi', 'Mallietown', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005500?text=people+eos', 1, 1, '2025-11-18 16:35:37', NULL, 'v9HqRbpPSz', NULL, NULL, NULL, NULL, '2025-12-04 16:29:09', '2025-12-04 16:29:09'),
(98, NULL, NULL, 'luz90@example.org', '$2y$12$/BwW3AUdN2drULdBQ1vW/.OKuGfLOqPYvc74pMehd7w43tofuGhEW', 'Ola', 'Doyle', NULL, NULL, 'Female', 'Da Nang', NULL, '112 Heathcote Ports Suite 100\nPort Alejandra, FL 45646-6295', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffdd?text=people+in', 1, 1, '2025-11-21 14:23:26', NULL, 'CstT2icT7W', NULL, NULL, NULL, NULL, '2025-12-04 16:29:10', '2025-12-04 16:29:10'),
(99, NULL, NULL, 'wilfred.mclaughlin@example.com', '$2y$12$aIOwR9YmzmVp4M3n0zvKBuS4XpXnFVBs7sUzcYBVaWZnLv3h49FES', 'Brayan', 'Deckow', NULL, '1996-04-16', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd22?text=people+quia', 1, 1, NULL, NULL, 'O0NbxI8qhk', NULL, NULL, NULL, NULL, '2025-12-04 16:29:10', '2025-12-04 16:29:10'),
(100, NULL, NULL, 'yhansen@example.net', '$2y$12$9t6H8EqA2MoMSI8U5nlGgO0OtmwFZbVZzJjYrdZxUIUJumz0v8uT.', 'Cesar', 'Lesch', '0985932752', NULL, 'Female', 'Hanoi', 'Blockchester', '2098 Smitham Plaza Suite 788\nEleanorefurt, WI 89928-2160', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bbcc?text=people+hic', 1, 1, NULL, NULL, 'hYkOEM1P5O', NULL, NULL, NULL, NULL, '2025-12-04 16:29:10', '2025-12-04 16:29:10'),
(101, NULL, NULL, 'umcglynn@example.org', '$2y$12$qAtrtGHoSmSqHMdpUAA1.OekDkjCbMd0NbdMgLPn8zbKEDcaFXJVq', 'Briana', 'Hintz', NULL, NULL, 'Male', 'Da Nang', 'Jevonland', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'DA5JYx1gfv', NULL, NULL, NULL, NULL, '2025-12-04 16:29:10', '2025-12-04 16:29:10'),
(102, NULL, NULL, 'jlarkin@example.com', '$2y$12$uP2Ws4oRDUF.P9Ilyxw8.O86zA222Ql82hhEcHgtFcXK1tVnMLlT2', 'Kaia', 'Ward', '0934096039', '1981-11-26', 'Other', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-20 14:24:57', NULL, '5CS5YJoD4z', NULL, NULL, NULL, NULL, '2025-12-04 16:29:11', '2025-12-04 16:29:11'),
(103, NULL, NULL, 'zakary.wunsch@example.org', '$2y$12$WMKhX750LIDNELJzO/ZqiefBMYiNTROidBY6VvTlvVJF4ybJBqVgm', 'Damon', 'Nikolaus', '0921740481', NULL, 'Other', 'Ho Chi Minh', 'North Kaela', NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'cvTh3qxK8J', NULL, NULL, NULL, NULL, '2025-12-04 16:29:11', '2025-12-04 16:29:11'),
(104, NULL, NULL, 'leola.durgan@example.com', '$2y$12$qoorgwy6cx5pFE5Aw6sfbuXLYP2ZOzF1dXV8.wjKu0uAi./HTjUAC', 'Lukas', 'Cassin', NULL, '1979-07-30', 'Other', 'Hai Phong', 'Douglaston', '715 Gleichner Estates Suite 128\nKassulkeberg, AL 32174', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffaa?text=people+eum', 1, 1, '2025-11-23 12:26:18', NULL, 'Wr7mQgM353', NULL, NULL, NULL, NULL, '2025-12-04 16:29:11', '2025-12-04 16:29:11'),
(105, NULL, NULL, 'percival99@example.org', '$2y$12$KNpQL9P8Z8gjRuhJodhySeG98x6NmrkQx9RbOqjX0hKu92dK4bRfi', 'Emmanuelle', 'Klocko', NULL, '1968-01-15', 'Male', 'Can Tho', NULL, '13007 Hills Rapids Apt. 398\nKeiratown, IL 88063-1637', 'Volunteer', NULL, 1, 1, '2025-11-06 02:06:57', NULL, '3xJqnTHflE', NULL, NULL, NULL, NULL, '2025-12-04 16:29:11', '2025-12-04 16:29:11'),
(106, NULL, NULL, 'dayna64@example.org', '$2y$12$dAnaB59c4vN0JScDmJLp6erEyFp0Ivt1cJtvE.XzQwrKUNSOgejAG', 'Thora', 'Klocko', '0920921475', NULL, 'Other', 'Ho Chi Minh', 'East Eveline', '356 O\'Kon Hollow Suite 873\nSchaefertown, SC 00752-4012', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa88?text=people+laboriosam', 1, 1, NULL, NULL, '2SzEbPljA9', NULL, NULL, NULL, NULL, '2025-12-04 16:29:12', '2025-12-04 16:29:12'),
(107, NULL, NULL, 'shanna.bailey@example.com', '$2y$12$0bcKlj2UF.Fm0HtmWg5TmOB4/8ScPNOHtIFi0SxZktF77J3poG37K', 'Hester', 'Lang', NULL, '1981-11-10', 'Other', 'Can Tho', 'Hamillchester', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'Hhm88WOFao', NULL, NULL, NULL, NULL, '2025-12-04 16:29:12', '2025-12-04 16:29:12'),
(108, NULL, NULL, 'keebler.aubree@example.net', '$2y$12$PeODahYzvNwzqfeCauRXGuTwAq6MJcCxuR1FRZsTxRBUH/e1cDZOW', 'Adella', 'Trantow', '0952669498', '1977-02-06', 'Male', 'Hanoi', 'Vandervortborough', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0099ee?text=people+quo', 0, 1, NULL, NULL, 'JxcwFk6zwS', NULL, NULL, NULL, NULL, '2025-12-04 16:29:12', '2025-12-04 16:29:12'),
(109, NULL, NULL, 'dullrich@example.com', '$2y$12$Yv81D4DPIlC37JA48jByJuXpNjBHrBAJKiilxn8XEzFnHbs21slse', 'Cathrine', 'Roob', NULL, '1973-05-06', 'Other', 'Hanoi', 'Lake Geraldineshire', NULL, 'Volunteer', NULL, 0, 1, '2025-11-29 19:25:37', NULL, 'Ym5bVdB83I', NULL, NULL, NULL, NULL, '2025-12-04 16:29:12', '2025-12-04 16:29:12'),
(110, NULL, NULL, 'borer.chase@example.net', '$2y$12$w1WIAcnMzH1cWt4FdAq8n.kF27L2kGtrVjWJnYQiGp9HWGL8/88oW', 'Margaretta', 'Stokes', NULL, '2000-03-09', 'Male', 'Can Tho', 'Travischester', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/006666?text=people+incidunt', 1, 1, NULL, NULL, 'yfVaV8ahNl', NULL, NULL, NULL, NULL, '2025-12-04 16:29:13', '2025-12-04 16:29:13'),
(111, NULL, NULL, 'kilback.selina@example.org', '$2y$12$iOWOkn6mmIHV4RH.EU7QJeLDgNyT19Evs/Gu8XWNB.W51B/58tT7G', 'Dane', 'Kassulke', '0949828908', '1991-08-23', 'Other', 'Hai Phong', 'Maeveburgh', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb22?text=people+voluptas', 1, 1, NULL, NULL, 'gubzs6Cz74', NULL, NULL, NULL, NULL, '2025-12-04 16:29:13', '2025-12-04 16:29:13'),
(112, NULL, NULL, 'ottis.schultz@example.org', '$2y$12$zV/H1a6Mvi9zJOlAeKjR6.Q78S1MYFP.owse8jHbIVMxEN9MB5n9m', 'Dee', 'Murray', NULL, NULL, 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, '85b2PcjG9o', NULL, NULL, NULL, NULL, '2025-12-04 16:29:13', '2025-12-04 16:29:13'),
(113, NULL, NULL, 'trace.bashirian@example.org', '$2y$12$Ing5QB5tnQixVH0lsUG8NeKfZLeV5ggLBZwyCbmlWCMD.J4LkTD/.', 'Elmira', 'Grant', '0987740401', '1986-09-26', 'Female', 'Can Tho', NULL, '92860 Odell Lakes Suite 265\nKozeyland, TX 87571', 'Volunteer', 'https://via.placeholder.com/200x200.png/0099bb?text=people+consectetur', 1, 1, '2025-11-28 07:03:45', NULL, 'itrqD2fNj7', NULL, NULL, NULL, NULL, '2025-12-04 16:29:14', '2025-12-04 16:29:14'),
(114, NULL, NULL, 'gutmann.rogers@example.com', '$2y$12$fXDM7CqAx8rnHIOcnH7aNuWZ1QBy/xvnm0Xf9pQwNovapZw.3eaRy', 'Lonzo', 'Block', NULL, NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008800?text=people+et', 1, 1, NULL, NULL, '6F6fD7lFwU', NULL, NULL, NULL, NULL, '2025-12-04 16:29:14', '2025-12-04 16:29:14'),
(115, NULL, NULL, 'ymccullough@example.net', '$2y$12$zHafVUFDX/oRPvoODuNfmujVAe4fODdsx356uLtKB6dnj.7IbW3lG', 'Sarah', 'Kilback', NULL, NULL, 'Female', 'Can Tho', 'Nitzschechester', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005599?text=people+ipsam', 1, 1, '2025-11-20 07:58:25', NULL, '4rtYUq9Tc4', NULL, NULL, NULL, NULL, '2025-12-04 16:29:14', '2025-12-04 16:29:14'),
(116, NULL, NULL, 'rreynolds@example.net', '$2y$12$r8firYwcgPI3JPf5FukSB.BjbugwiVKLJvGLoo1Iqx.HKyyOFPIX2', 'Anahi', 'Nitzsche', NULL, NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, '9QseIixjSx', NULL, NULL, NULL, NULL, '2025-12-04 16:29:14', '2025-12-04 16:29:14'),
(117, NULL, NULL, 'greenholt.dovie@example.net', '$2y$12$K485TXYApIadh3UWjHBTYuLa/s/Kd1Au2BXQaCCT5dltt/wH2G7gS', 'Judy', 'Nolan', NULL, NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0066ee?text=people+nobis', 1, 1, NULL, NULL, '8X4n1NUZdo', NULL, NULL, NULL, NULL, '2025-12-04 16:29:15', '2025-12-04 16:29:15'),
(118, NULL, NULL, 'tjerde@example.org', '$2y$12$W9n5Y.Wuwai/nFm.I8/Jgu3XfM54IYdEfV8oY8vUhWMgwYf1zoxyK', 'Gideon', 'Pacocha', '0922438570', NULL, 'Female', 'Hai Phong', NULL, '550 Toy Landing Apt. 219\nNew Bridgetborough, NV 93003-7946', 'Volunteer', NULL, 0, 1, NULL, NULL, 'hmjTtB2t6M', NULL, NULL, NULL, NULL, '2025-12-04 16:29:15', '2025-12-04 16:29:15'),
(119, NULL, NULL, 'kelvin.klein@example.org', '$2y$12$rHYljMEivrvJ.XQaeuLZAu.pg93cOzd8puuKQeP/djvm3S3xECMAW', 'Allison', 'Borer', NULL, '2000-02-19', 'Male', 'Ho Chi Minh', NULL, '6191 Emmitt Square Suite 718\nMurphychester, FL 88898-0609', 'Volunteer', NULL, 1, 1, '2025-12-02 01:59:15', NULL, 'rT6ofJ5GEU', NULL, NULL, NULL, NULL, '2025-12-04 16:29:15', '2025-12-04 16:29:15'),
(120, NULL, NULL, 'lenore23@example.com', '$2y$12$9PebGApzVzm2lyChNaU3zeIAzPJEdA3Txm9QtnWWTM8zfKkUD/xz6', 'Annette', 'Zulauf', '0930060850', '1972-09-22', 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'yPbGO6MoAt', NULL, NULL, NULL, NULL, '2025-12-04 16:29:16', '2025-12-04 16:29:16'),
(121, NULL, NULL, 'hammes.kailyn@example.net', '$2y$12$0jjCPBs4/sekaxynwwY1Ye8kfZSfxqds1KauxYcMzZb8vsbry6Eju', 'Elisha', 'Farrell', NULL, '1968-07-21', 'Female', 'Ho Chi Minh', NULL, '607 Schoen Valleys\nSipesfurt, NJ 30466-5619', 'Volunteer', NULL, 0, 1, '2025-11-28 12:03:22', NULL, 'f1EBgzMesY', NULL, NULL, NULL, NULL, '2025-12-04 16:29:16', '2025-12-04 16:29:16'),
(122, NULL, NULL, 'xlangosh@example.net', '$2y$12$AaBBXi1NrhVH2u3VLEFUPuE6F7qWs4abW98BQvQ1G5B.lzWqLfvKq', 'Ezra', 'Wiza', '0986844483', NULL, 'Female', 'Hanoi', NULL, '37275 Jacobson Hill\nBeierview, UT 91497', 'Volunteer', NULL, 0, 1, NULL, NULL, 'lsvwcqY4Tv', NULL, NULL, NULL, NULL, '2025-12-04 16:29:16', '2025-12-04 16:29:16'),
(123, NULL, NULL, 'boyer.kaycee@example.org', '$2y$12$PcoIuYDm3eZ.hd7k.VYIjuFUvrqPeFpDOWC4BwGGXhVWRNrG7iAA2', 'Ida', 'Wisozk', '0987320163', '1981-01-11', 'Other', 'Ho Chi Minh', NULL, '226 Herzog Estate Apt. 563\nSouth Estelmouth, PA 74075', 'Volunteer', 'https://via.placeholder.com/200x200.png/0088bb?text=people+eos', 0, 1, NULL, NULL, 'nxL33JGFn1', NULL, NULL, NULL, NULL, '2025-12-04 16:29:16', '2025-12-04 16:29:16'),
(124, NULL, NULL, 'leilani.lemke@example.net', '$2y$12$5SsYJrhOWHE7BAgJIOKdpuNjIGPsBV2HGWMOO.GBsGeTO8GuZB2xS', 'Willie', 'Torp', '0950042493', '1966-04-19', 'Other', 'Can Tho', 'Legrosfurt', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0033cc?text=people+modi', 1, 1, NULL, NULL, 'hXI9oNMxiW', NULL, NULL, NULL, NULL, '2025-12-04 16:29:17', '2025-12-04 16:29:17'),
(125, NULL, NULL, 'gladyce.ritchie@example.org', '$2y$12$XNQLaXPN3vsfpR7bNz9vwe/N2HI2RuLIaU.iyZHl8Ewbe33C51dAi', 'Charley', 'Mayer', NULL, NULL, 'Female', 'Can Tho', 'Hillsville', '5943 Pfannerstill Flats Apt. 639\nJerdetown, NY 91318', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aadd?text=people+autem', 1, 1, NULL, NULL, '5AM9J5iuT2', NULL, NULL, NULL, NULL, '2025-12-04 16:29:17', '2025-12-04 16:29:17'),
(126, NULL, NULL, 'kmoore@example.com', '$2y$12$0uMCcQ7xzpYUCzPE4pIGT.AWjgPedf3tfMZFuTM5QaEm0RQKlGxEC', 'Layla', 'Connelly', '0946304672', '1993-02-06', 'Female', 'Hanoi', 'Rodriguezmouth', '92702 Kade Pike Apt. 106\nSouth Rachellestad, MN 58793', 'Volunteer', 'https://via.placeholder.com/200x200.png/0055cc?text=people+consequatur', 1, 1, '2025-11-18 18:55:35', NULL, 'KiWepedjmp', NULL, NULL, NULL, NULL, '2025-12-04 16:29:17', '2025-12-04 16:29:17'),
(127, NULL, NULL, 'uhill@example.org', '$2y$12$caRAmXl8zQbQ56BklUqWUeGD5H3dX8EfhwStXPM7pG2f14BWnrMpe', 'Maurice', 'Runolfsson', NULL, '1987-08-28', 'Male', 'Ho Chi Minh', NULL, '473 Devon Trafficway Apt. 388\nPort Chelsie, FL 30182', 'Volunteer', 'https://via.placeholder.com/200x200.png/007733?text=people+itaque', 1, 1, '2025-11-24 05:18:50', NULL, 'MC9C8Se9YH', NULL, NULL, NULL, NULL, '2025-12-04 16:29:17', '2025-12-04 16:29:17'),
(128, NULL, NULL, 'hayes.astrid@example.org', '$2y$12$BiprqrNfJyty2aRj5XLcvuj1VoMJ41O0Vsy7sd/bOsBOa8v5NKLdK', 'Howard', 'Crist', NULL, '2000-09-13', 'Male', 'Hanoi', 'New Orion', '50246 Kris Crescent\nKarlieview, NM 13095-6587', 'Volunteer', 'https://via.placeholder.com/200x200.png/003344?text=people+quis', 0, 1, '2025-11-16 00:13:15', NULL, 'IiF1eHIEKK', NULL, NULL, NULL, NULL, '2025-12-04 16:29:18', '2025-12-04 16:29:18'),
(129, NULL, NULL, 'rbednar@example.org', '$2y$12$oKxqfB1yVsYMPGoa/HStB.lKSUPM24.M01R6YEYcTHWyxCVSv3yc.', 'Charlene', 'Walker', '0971614081', '2000-07-14', 'Other', 'Can Tho', 'North Modesta', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008844?text=people+non', 1, 1, '2025-12-02 16:04:15', NULL, 'O1ozligg0W', NULL, NULL, NULL, NULL, '2025-12-04 16:29:18', '2025-12-04 16:29:18'),
(130, NULL, NULL, 'kellie.nitzsche@example.org', '$2y$12$ozvNG.ARo9eVajqiZqPR4.EvXM9gJeP0Cr/ITqP7O/W.bDf5NxRa6', 'Arne', 'Murray', '0990002870', NULL, 'Other', 'Da Nang', 'Port Lacyshire', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff77?text=people+et', 1, 1, '2025-11-28 01:05:20', NULL, '34v6MDksiL', NULL, NULL, NULL, NULL, '2025-12-04 16:29:18', '2025-12-04 16:29:18'),
(131, NULL, NULL, 'oconner.arvilla@example.net', '$2y$12$m9tjRz2UGOfsXj4pvpw9quh8whsh4lyCp3iEM1zEdSXPjXqh2O8xa', 'Adah', 'Shields', NULL, NULL, 'Other', 'Hanoi', NULL, '5420 Hansen Key\nSvenstad, WY 39225', 'Volunteer', 'https://via.placeholder.com/200x200.png/0044dd?text=people+doloremque', 0, 1, '2025-11-13 09:02:32', NULL, 'k9zXjRgVVz', NULL, NULL, NULL, NULL, '2025-12-04 16:29:18', '2025-12-04 16:29:18'),
(132, NULL, NULL, 'mccullough.minnie@example.com', '$2y$12$VbidT5d03ugorpIObkpKA.8HYw3aw3pLlghM36Bl/8LxN9n369.C6', 'Imogene', 'Kerluke', '0940948170', '2007-03-06', 'Male', 'Can Tho', 'Lake Deliastad', NULL, 'Volunteer', NULL, 0, 1, '2025-11-25 06:23:07', NULL, '4uNq1F787p', NULL, NULL, NULL, NULL, '2025-12-04 16:29:19', '2025-12-04 16:29:19'),
(133, NULL, NULL, 'mertie.corwin@example.org', '$2y$12$HFfK7sbdDhr8TrOH.b6UMO88rwQvt71psDx/mwShcMkpUsSKcYoKe', 'Selina', 'Homenick', NULL, NULL, 'Female', 'Can Tho', NULL, '55012 Kohler Gardens Suite 282\nNorth Matteo, WV 42686-2396', 'Volunteer', 'https://via.placeholder.com/200x200.png/007744?text=people+quis', 0, 1, NULL, NULL, 'kZCCpKc9bw', NULL, NULL, NULL, NULL, '2025-12-04 16:29:19', '2025-12-04 16:29:19'),
(134, NULL, NULL, 'helga.bogan@example.net', '$2y$12$.XjoYgvwn.Cnn44YqBBNFOLiE4nhLmj/pf/Q.mhk83fVaToqA/oUq', 'Tomas', 'Hoppe', '0976965447', '2002-05-22', 'Other', 'Hai Phong', 'North Angelica', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0077dd?text=people+dolorum', 1, 1, NULL, NULL, 'h5nL7ZEuaP', NULL, NULL, NULL, NULL, '2025-12-04 16:29:19', '2025-12-04 16:29:19');
INSERT INTO `users` (`user_id`, `google_id`, `facebook_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `date_of_birth`, `gender`, `city`, `district`, `address`, `user_type`, `avatar_url`, `is_verified`, `is_active`, `last_login_at`, `last_activity_at`, `remember_token`, `verification_token`, `email_verified_at`, `reset_password_token`, `reset_password_token_expires_at`, `created_at`, `updated_at`) VALUES
(135, NULL, NULL, 'pkulas@example.org', '$2y$12$NODVVj8MTjIB4IiPzKlFBOMwIFU/P2u2YKTOLVx3qG0VZDnLeb16q', 'Tyrique', 'Shields', NULL, '1993-07-25', 'Male', 'Ho Chi Minh', 'West Fletatown', '134 Waelchi Manors\nEast Octavia, IL 66836-3891', 'Volunteer', 'https://via.placeholder.com/200x200.png/0011ee?text=people+commodi', 1, 1, '2025-11-29 19:52:27', NULL, 'FknkguXFML', NULL, NULL, NULL, NULL, '2025-12-04 16:29:19', '2025-12-04 16:29:19'),
(136, NULL, NULL, 'makayla64@example.org', '$2y$12$gQrjHvigWMlYYhfEDZoR6OMIu8laVK6jDn5zWBrsbLKE1ERbmuDny', 'Jordan', 'Upton', '0989985487', NULL, 'Female', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'jROHIpTgzb', NULL, NULL, NULL, NULL, '2025-12-04 16:29:20', '2025-12-04 16:29:20'),
(137, NULL, NULL, 'emmett.larkin@example.net', '$2y$12$7d82pjp5Yy0qAe9uf2uL/OcMXvaZTlQ1bP7HscAk4M5z7X7RF.luO', 'Lester', 'McDermott', '0922053405', NULL, 'Male', 'Hanoi', NULL, '4308 Laurel Haven\nNorth Sophie, ND 01777-7704', 'Volunteer', NULL, 1, 1, NULL, NULL, 'qHByzBBxt8', NULL, NULL, NULL, NULL, '2025-12-04 16:29:20', '2025-12-04 16:29:20'),
(138, NULL, NULL, 'xfay@example.org', '$2y$12$PAB.yiT7Jr5mNn/IN1PhceqNQNC8pVTADWMahHvRVLDIgL7rkNHaW', 'Dudley', 'Lemke', '0925766983', NULL, 'Female', 'Da Nang', NULL, '10478 Schuppe Radial\nEast Lylafort, OR 23715', 'Volunteer', 'https://via.placeholder.com/200x200.png/0055ee?text=people+sint', 0, 1, '2025-11-27 11:50:41', NULL, 'WgGtkxsmAM', NULL, NULL, NULL, NULL, '2025-12-04 16:29:20', '2025-12-04 16:29:20'),
(139, NULL, NULL, 'vmacejkovic@example.net', '$2y$12$eZM8/pqJV0sggq8F3BS7auvBE0b6qvxK6mhpRr6utr.Hx7FWr40dm', 'Aiyana', 'Swaniawski', NULL, NULL, 'Male', 'Hai Phong', 'North Elwynton', '40511 Lesly Ports Apt. 913\nSwaniawskitown, VA 13476', 'Volunteer', NULL, 1, 1, NULL, NULL, 'U7f9oHRARp', NULL, NULL, NULL, NULL, '2025-12-04 16:29:21', '2025-12-04 16:29:21'),
(140, NULL, NULL, 'sonya.stanton@example.com', '$2y$12$FYNcpVESySHysPcCM8FUh.h4MJjw.ILoGnF6UrOyCRSYNd4S1F0bK', 'Elise', 'Hoeger', NULL, NULL, 'Male', 'Can Tho', NULL, '6337 Mills Land\nKemmerborough, NH 26819-2313', 'Volunteer', NULL, 1, 1, '2025-11-05 21:32:08', NULL, 'q0acAxDIBQ', NULL, NULL, NULL, NULL, '2025-12-04 16:29:21', '2025-12-04 16:29:21'),
(141, NULL, NULL, 'srice@example.com', '$2y$12$Ievz3UOtqQ5ademYYjeCwutGT3eVqu4e2EOuC8icXxcFr/cloxyym', 'Brandon', 'Kshlerin', '0979056352', NULL, 'Male', 'Can Tho', 'West Samantaview', '237 Jude Glens Suite 217\nEast Quintonchester, SD 74250-7430', 'Volunteer', NULL, 1, 1, '2025-11-26 18:55:15', NULL, 'VKwTZfiLOv', NULL, NULL, NULL, NULL, '2025-12-04 16:29:21', '2025-12-04 16:29:21'),
(142, NULL, NULL, 'brippin@example.net', '$2y$12$dupu9ajczK/0FAz2oqjNy.NdFUS2RuI/Nbvox84lpFATIoACMSEYG', 'Palma', 'Herman', '0949718275', NULL, 'Female', 'Hai Phong', 'West Tracyview', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0000dd?text=people+iure', 1, 1, '2025-11-23 23:53:49', NULL, 'tS0RplGncq', NULL, NULL, NULL, NULL, '2025-12-04 16:29:21', '2025-12-04 16:29:21'),
(143, NULL, NULL, 'joyce11@example.com', '$2y$12$rR6p4VHphAVY16wJL1xbZeOb6Wx1Tg/GGS/HX2Pqp.0gViBtJyhze', 'Christelle', 'Harber', NULL, '2007-02-04', 'Female', 'Ho Chi Minh', NULL, '7667 Jesse Harbors\nLueilwitzberg, CA 93090-1910', 'Volunteer', 'https://via.placeholder.com/200x200.png/00eebb?text=people+sint', 0, 1, NULL, NULL, 'UBLchHKOKs', NULL, NULL, NULL, NULL, '2025-12-04 16:29:22', '2025-12-04 16:29:22'),
(144, NULL, NULL, 'tjaskolski@example.com', '$2y$12$GUf8gSxEaeDMNBVFIjtMmuUDBcRLmvhphM4teP0I/6.DMfNqKgYfC', 'Tatum', 'Bashirian', NULL, NULL, 'Other', 'Da Nang', NULL, '44983 Rupert Valleys Suite 429\nJazminburgh, AK 76719-0045', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddee?text=people+iure', 1, 1, '2025-11-24 01:42:31', NULL, 'PJopIS68GW', NULL, NULL, NULL, NULL, '2025-12-04 16:29:22', '2025-12-04 16:29:22'),
(145, NULL, NULL, 'alexie57@example.com', '$2y$12$SBVmjSXfPy5cU9Z2WfVuyOo/yMZkirHiIBMzYnLBfZnnbkw0LAjGS', 'Ludie', 'Dooley', '0944905282', NULL, 'Male', 'Hanoi', NULL, '2358 Mueller Run Suite 751\nHirammouth, IL 08818-3869', 'Volunteer', NULL, 0, 1, '2025-11-20 17:16:08', NULL, '7A1TxLKwmn', NULL, NULL, NULL, NULL, '2025-12-04 16:29:22', '2025-12-04 16:29:22'),
(146, NULL, NULL, 'roob.breanna@example.net', '$2y$12$kQ6zrjwLo8u9I043P6CEm.T89EmFJAL1h9RLn94G/gu5X4SyPqfB2', 'Reilly', 'Runte', NULL, '2007-11-26', 'Male', 'Ho Chi Minh', 'Terryland', '9819 Luettgen Shore Suite 090\nPort Amina, NC 73375', 'Volunteer', 'https://via.placeholder.com/200x200.png/006611?text=people+dolorum', 0, 1, NULL, NULL, 'W4ZESPD95X', NULL, NULL, NULL, NULL, '2025-12-04 16:29:22', '2025-12-04 16:29:22'),
(147, NULL, NULL, 'cierra75@example.org', '$2y$12$io6AlYCUuz3Z8iK/yS/.DORrGjyzGU4QD9wYqYSgRvvSsMwO7jL0i', 'Georgianna', 'Abshire', '0917678573', '1970-06-25', 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'IxA7k2AGdu', NULL, NULL, NULL, NULL, '2025-12-04 16:29:23', '2025-12-04 16:29:23'),
(148, NULL, NULL, 'etha84@example.com', '$2y$12$GfqOjhRI3C1w/kyibjDkNu.MQlC2WGZHYKoQD.ZtQSHqGfAYhbbT2', 'Lula', 'Beahan', '0968478249', NULL, 'Male', 'Hai Phong', 'Godfreyfurt', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'GiCvze1eul', NULL, NULL, NULL, NULL, '2025-12-04 16:29:23', '2025-12-04 16:29:23'),
(149, NULL, NULL, 'ledner.gisselle@example.net', '$2y$12$6HT9hunc5bM4ZST/jHKfeuyEensj5eOJWiquNNPqhNxIoBAbXOCxm', 'Odell', 'Littel', NULL, NULL, 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee00?text=people+sit', 1, 1, '2025-11-18 12:51:07', NULL, 'iOpwZq8iWh', NULL, NULL, NULL, NULL, '2025-12-04 16:29:23', '2025-12-04 16:29:23'),
(150, NULL, NULL, 'lucius54@example.com', '$2y$12$ig7TJbq4evvYAvZrBmAoYuO.lxuF4xDxvIbjxe3KOKWCt/UNXRy8G', 'Kailee', 'Balistreri', '0968030282', NULL, 'Female', 'Can Tho', NULL, '916 Earnest Junctions\nLake Giovannyfurt, WI 59370', 'Volunteer', NULL, 0, 1, '2025-11-23 09:02:50', NULL, 'mES5cKwydE', NULL, NULL, NULL, NULL, '2025-12-04 16:29:24', '2025-12-04 16:29:24'),
(151, NULL, NULL, 'lupton@example.org', '$2y$12$52bd3FcrXSvDhP6.ckCXV.m2LVUiTQc3B4MAbolEbF2LaPVfyg8hu', 'Layla', 'Dickinson', NULL, '2006-05-17', 'Female', 'Da Nang', 'East Ana', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0099aa?text=people+a', 1, 1, '2025-11-17 02:19:04', NULL, 'zQ8amtbWSM', NULL, NULL, NULL, NULL, '2025-12-04 16:29:24', '2025-12-04 16:29:24'),
(152, NULL, NULL, 'rowan.cronin@example.net', '$2y$12$ZqslGqLkw4Hv8QCZzZjnfe97HZG7IbunY00fxl76Z4ngkIlcubTFG', 'Janiya', 'Feeney', '0909422385', '1983-03-09', 'Male', 'Ho Chi Minh', 'West Austenfurt', '5424 Sally Vista\nStephonchester, IA 51834-8118', 'Volunteer', 'https://via.placeholder.com/200x200.png/0033bb?text=people+accusantium', 0, 1, '2025-11-10 06:32:16', NULL, 'fhYSV4g1Vd', NULL, NULL, NULL, NULL, '2025-12-04 16:29:24', '2025-12-04 16:29:24'),
(153, NULL, NULL, 'uhills@example.com', '$2y$12$Y2Gdngo6d5ukD.reGzqPc.BS.X.H1Ac42QisWS7i2vK7x6TvAGoxW', 'Gennaro', 'Deckow', NULL, '2002-10-08', 'Other', 'Can Tho', NULL, '96944 Schumm Loop Apt. 336\nJuanaside, VT 90330-3750', 'Volunteer', NULL, 0, 1, '2025-11-27 08:34:17', NULL, '9hN9q2r1jT', NULL, NULL, NULL, NULL, '2025-12-04 16:29:24', '2025-12-04 16:29:24'),
(154, NULL, NULL, 'jesus.maggio@example.org', '$2y$12$ecTglCvNxocr3baWjgQiKuuHe3XbjGs45Bjd7duFJxx8cmt5W6A6K', 'Percy', 'Auer', '0914239400', NULL, 'Other', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa99?text=people+fugit', 1, 1, NULL, NULL, 'PZA81aIbX1', NULL, NULL, NULL, NULL, '2025-12-04 16:29:25', '2025-12-04 16:29:25'),
(155, NULL, NULL, 'nader.ramona@example.org', '$2y$12$25FI1I4mv9P4wTuTnqwXteyAdWQLTW7YXk1dxmMT/h4JOHwXGYkd2', 'Bernardo', 'Olson', NULL, NULL, 'Male', 'Ho Chi Minh', 'Halvorsonport', NULL, 'Volunteer', NULL, 1, 1, '2025-11-23 20:35:01', NULL, 'knp1Sq3UXx', NULL, NULL, NULL, NULL, '2025-12-04 16:29:25', '2025-12-04 16:29:25'),
(156, NULL, NULL, 'timmy03@example.org', '$2y$12$Dm0sfZaOWJbaADFycJ2ncekQa8YblNRH5JMvIujW9B735rjjpl55S', 'Erica', 'Rutherford', NULL, NULL, 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd00?text=people+commodi', 0, 1, '2025-11-21 21:07:12', NULL, 'FDidNYCZjd', NULL, NULL, NULL, NULL, '2025-12-04 16:29:25', '2025-12-04 16:29:25'),
(157, NULL, NULL, 'jnitzsche@example.net', '$2y$12$oeJV9uAHom7V28HiC7vf2.4.65.wmKWbAn4Y56NWbDwfUGQTYX5Wq', 'Jadon', 'Oberbrunner', NULL, NULL, 'Female', 'Can Tho', 'Ollieberg', '7262 Zackery Corner Suite 939\nMontanafurt, AZ 10360', 'Volunteer', NULL, 0, 1, NULL, NULL, 'trNcSFGG7r', NULL, NULL, NULL, NULL, '2025-12-04 16:29:25', '2025-12-04 16:29:25'),
(158, NULL, NULL, 'runte.pat@example.org', '$2y$12$BYS602BgRrWJ.TtaOIwnSeAwo.TbrqxEtQTG/PhxNoGT8iP5MZZnK', 'Mabelle', 'Runolfsdottir', '0906869822', '1988-06-21', 'Other', 'Ho Chi Minh', 'East Grady', NULL, 'Volunteer', NULL, 1, 1, '2025-11-18 00:29:05', NULL, 'BLwDNw3SPC', NULL, NULL, NULL, NULL, '2025-12-04 16:29:26', '2025-12-04 16:29:26'),
(159, NULL, NULL, 'koelpin.sterling@example.net', '$2y$12$yANDMv3lfxGft/zBZRLDJOdwZVC6t2HRGEmfZa3y4UzuIxwEoFKla', 'Monica', 'Quitzon', '0996504222', '1975-01-19', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'fECSJs34yl', NULL, NULL, NULL, NULL, '2025-12-04 16:29:26', '2025-12-04 16:29:26'),
(160, NULL, NULL, 'wiza.sven@example.com', '$2y$12$2J5VsMUb6jRqdhrTDgowu.j0ow/ep1bhxVZIiM2brtainDYAYJGIK', 'Madelynn', 'Hessel', '0945149570', NULL, 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-14 04:30:22', NULL, 'Vd8LnTasMW', NULL, NULL, NULL, NULL, '2025-12-04 16:29:26', '2025-12-04 16:29:26'),
(161, NULL, NULL, 'cebert@example.com', '$2y$12$GQLQtv1LuE8CbcqjwkrJiuBXme3ZEnuW52UNtcwM48NTpmAuq/Vra', 'Maximillia', 'Rippin', NULL, '1986-05-22', 'Female', 'Da Nang', NULL, '695 Gleason Court Apt. 760\nFeeneybury, LA 07236-6739', 'Volunteer', NULL, 1, 1, NULL, NULL, 'SLR00Fk2wX', NULL, NULL, NULL, NULL, '2025-12-04 16:29:27', '2025-12-04 16:29:27'),
(162, NULL, NULL, 'wisozk.gust@example.net', '$2y$12$4eCvTKFlTPb5F0/Y827GJOHW2qffyFzeSKuZ3VAhKekL1Kp1k8VNy', 'Lolita', 'Littel', NULL, '2005-12-07', 'Female', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, '4Nkzvkl9et', NULL, NULL, NULL, NULL, '2025-12-04 16:29:27', '2025-12-04 16:29:27'),
(163, NULL, NULL, 'jules.wuckert@example.com', '$2y$12$RCTgyTTLbfCc/nLnzVbJj.QGmBYvVreFoTZtXelS1bHeFhkXGZWUa', 'Gilbert', 'Mante', NULL, NULL, 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff99?text=people+suscipit', 0, 1, '2025-12-01 10:48:48', NULL, 'zdv3wdSmye', NULL, NULL, NULL, NULL, '2025-12-04 16:29:27', '2025-12-04 16:29:27'),
(164, NULL, NULL, 'sierra05@example.net', '$2y$12$ACXea3ATpm3a7g56s0rKFO9BJ.lm4ogRavm5fQ6jmKWEI1zEKI/di', 'Wendell', 'Langosh', NULL, '1981-09-29', 'Female', 'Can Tho', 'Lake Alyson', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'gyEbz0RSlv', NULL, NULL, NULL, NULL, '2025-12-04 16:29:27', '2025-12-04 16:29:27'),
(165, NULL, NULL, 'johns.roxanne@example.net', '$2y$12$MDvy4vri9CJwdJCLpL4z.O4/Pq63q0iLEWvFJT5NAh0SnwnSWInxS', 'Alvina', 'Boyer', NULL, '1970-01-13', 'Other', 'Da Nang', NULL, '4088 Millie Dale\nTimothyside, AR 90922', 'Volunteer', NULL, 1, 1, '2025-11-30 15:41:25', NULL, 'ulIVFpDtIH', NULL, NULL, NULL, NULL, '2025-12-04 16:29:28', '2025-12-04 16:29:28'),
(166, NULL, NULL, 'amiya.heathcote@example.com', '$2y$12$tvpcPly4fqORULgNcM9Dd.Y7MoH/1m.ZzSYjCwjhyHg2h4vZPLUO2', 'Jovani', 'O\'Kon', NULL, '1999-04-13', 'Female', 'Da Nang', 'Wisozkberg', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa99?text=people+tenetur', 1, 1, '2025-11-12 22:16:09', NULL, 'MNDsYe4JVF', NULL, NULL, NULL, NULL, '2025-12-04 16:29:28', '2025-12-04 16:29:28'),
(167, NULL, NULL, 'margarita.cremin@example.com', '$2y$12$85DgD053X0g9TDzrXXaIn.wmp.msHiwloMsZDEOIMJbrvJE2v31iC', 'Roslyn', 'Osinski', NULL, NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'UGptdRSjC5', NULL, NULL, NULL, NULL, '2025-12-04 16:29:28', '2025-12-04 16:29:28'),
(168, NULL, NULL, 'deron98@example.net', '$2y$12$tATOJwTTQ9/mrQ7OcOyfTOvtd1EGdTnJ4sIDMxHcYXocspKxvwx0K', 'Kayleigh', 'Renner', NULL, '1991-10-28', 'Male', 'Ho Chi Minh', 'Runolfssontown', '832 Marquis Summit\nLake Alvinachester, ME 87798-7555', 'Volunteer', 'https://via.placeholder.com/200x200.png/002233?text=people+et', 1, 1, '2025-11-30 17:07:07', NULL, 'WTTNsfWZJr', NULL, NULL, NULL, NULL, '2025-12-04 16:29:28', '2025-12-04 16:29:28'),
(169, NULL, NULL, 'angie95@example.com', '$2y$12$x9AiVBWOgD3gw6FnPh.Zf.FZsXWDSuOcjMxOGA5yoVO5hAJasaBNq', 'Glenda', 'Huels', '0989969059', NULL, 'Male', 'Can Tho', 'Erinfort', '810 Rodolfo Isle\nRileybury, VT 87626-7450', 'Volunteer', 'https://via.placeholder.com/200x200.png/006688?text=people+distinctio', 1, 1, NULL, NULL, 'IFumtFtTUg', NULL, NULL, NULL, NULL, '2025-12-04 16:29:29', '2025-12-04 16:29:29'),
(170, NULL, NULL, 'winston.pfannerstill@example.com', '$2y$12$I47/jYKk.VNDDWN3yLDDrOmjH8GbuXOHguIorY9lrMNRVEewamyPW', 'Napoleon', 'Russel', '0959605868', '1966-02-27', 'Male', 'Hai Phong', NULL, '895 Sigurd Mews Apt. 762\nEast Yessenia, MS 47498', 'Volunteer', NULL, 1, 1, NULL, NULL, '58dvow2aOf', NULL, NULL, NULL, NULL, '2025-12-04 16:29:29', '2025-12-04 16:29:29'),
(171, NULL, NULL, 'kilback.hallie@example.org', '$2y$12$e1mM0wFQk6EjAKMSav8QdebhAO60ek5mcbTkKqt/wAE.fipvmQTC.', 'Garrett', 'Gleason', '0953782798', NULL, 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0033dd?text=people+officia', 1, 1, NULL, NULL, 'WW6jgcwCq6', NULL, NULL, NULL, NULL, '2025-12-04 16:29:29', '2025-12-04 16:29:29'),
(172, NULL, NULL, 'janelle.kilback@example.org', '$2y$12$2TDZMCsLwJrz6y03e5q5Veaw4X2MTz.Ydwa4UVUAtXvjn4Te2CNoW', 'Cara', 'Sanford', NULL, '1972-03-27', 'Female', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-04 20:14:34', NULL, 'rDMVBmMh0v', NULL, NULL, NULL, NULL, '2025-12-04 16:29:30', '2025-12-04 16:29:30'),
(173, NULL, NULL, 'makenzie06@example.net', '$2y$12$xY6u6lwChu8qygXlXeH/FuQxTvA56qhIqMbBG.CnoG/0E50Bat5Jq', 'Eusebio', 'Donnelly', NULL, '1971-09-18', 'Other', 'Hai Phong', 'Jarrellland', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/009900?text=people+quod', 0, 1, '2025-11-21 15:10:32', NULL, 'hvqy3RRDgW', NULL, NULL, NULL, NULL, '2025-12-04 16:29:30', '2025-12-04 16:29:30'),
(174, NULL, NULL, 'zleannon@example.org', '$2y$12$CCt9hVY2eOdhLZ2G8xlsV.1djotI5xjKjvrkfiUrZp3wFkyi4Ie0a', 'Corbin', 'Hahn', NULL, NULL, 'Other', 'Hai Phong', NULL, '34465 Schimmel Mission\nBartonhaven, KS 19390-6199', 'Volunteer', 'https://via.placeholder.com/200x200.png/0066ff?text=people+consequatur', 1, 1, '2025-11-09 14:29:50', NULL, 'V0mnyYRQbf', NULL, NULL, NULL, NULL, '2025-12-04 16:29:30', '2025-12-04 16:29:30'),
(175, NULL, NULL, 'runte.pat@example.net', '$2y$12$PDuky4nbUWZykdSSz6Hl9eSvfuW6cE9JWLe5/j.hRYsTgyRndVrXm', 'Shemar', 'Balistreri', NULL, '1984-03-17', 'Male', 'Can Tho', 'Rutherfordmouth', '756 Regan Inlet Suite 726\nMargarettaview, NH 73128', 'Volunteer', NULL, 1, 1, NULL, NULL, 'QOChbtt18F', NULL, NULL, NULL, NULL, '2025-12-04 16:29:30', '2025-12-04 16:29:30'),
(176, NULL, NULL, 'cormier.carolyne@example.net', '$2y$12$Uad3DPLtqJs54QLDEEb71.GMi1vdeuKMtVqZ1pci9kGTdbKs8GjoC', 'Cynthia', 'Walter', '0934049780', '1984-07-01', 'Male', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bbaa?text=people+repellendus', 0, 1, NULL, NULL, 'XXC6EQ3diM', NULL, NULL, NULL, NULL, '2025-12-04 16:29:31', '2025-12-04 16:29:31'),
(177, NULL, NULL, 'russ.sporer@example.com', '$2y$12$l/Dhy62jAfffG24kqsvy9uD.0x3.w6IXVeW9ew/sDieyFec9.Nm7.', 'Jeramy', 'Conn', NULL, '1989-01-07', 'Female', 'Da Nang', NULL, '623 Raul Overpass Apt. 119\nKailynmouth, ID 35106-0107', 'Volunteer', NULL, 1, 1, '2025-11-10 22:51:50', NULL, 'VyfE2syyjy', NULL, NULL, NULL, NULL, '2025-12-04 16:29:31', '2025-12-04 16:29:31'),
(178, NULL, NULL, 'greenholt.rebecca@example.org', '$2y$12$JWcsx2yDjaTiTFwVG6LohO1D0ZzJVOHetkCAASJrHf3mCI/WWzHM.', 'Jairo', 'Cole', NULL, '1972-10-02', 'Other', 'Can Tho', 'Russland', NULL, 'Volunteer', NULL, 1, 1, '2025-11-16 18:14:36', NULL, '6Epq2EOGaW', NULL, NULL, NULL, NULL, '2025-12-04 16:29:31', '2025-12-04 16:29:31'),
(179, NULL, NULL, 'alfredo98@example.net', '$2y$12$633FsPjQcI4tR07BpZM3SeYy25UEAKloCJEXUeftbrEPGc3DVC3ue', 'Buck', 'Kreiger', NULL, '1993-05-18', 'Male', 'Da Nang', 'Tillmanland', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0055ee?text=people+illum', 1, 1, NULL, NULL, 'F7nZPlCXlb', NULL, NULL, NULL, NULL, '2025-12-04 16:29:31', '2025-12-04 16:29:31'),
(180, NULL, NULL, 'miller.berneice@example.org', '$2y$12$AbjeptK1N.ZUqauLN224hunusLjGgx1sF1OphXRYT9uv2vs0oAmkO', 'Leif', 'Doyle', '0975887419', '2002-01-26', 'Other', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-15 02:58:04', NULL, 'B968LfG9Fg', NULL, NULL, NULL, NULL, '2025-12-04 16:29:32', '2025-12-04 16:29:32'),
(181, NULL, NULL, 'ebony79@example.com', '$2y$12$xt2ekkw37loSw9CCnEM2kuwE0/qzb2crZ5nbN6U1itX03ixuscNcO', 'Dedric', 'Price', '0970585977', '1993-04-19', 'Male', 'Ho Chi Minh', 'Towneport', NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'yBBR7J2LdZ', NULL, NULL, NULL, NULL, '2025-12-04 16:29:32', '2025-12-04 16:29:32'),
(182, NULL, NULL, 'ftromp@example.com', '$2y$12$OhbvrZ5/mdNwsYqfvEnvCOY3g0LF6jr938VzsHP1nX5o8Ex0hL80e', 'Reta', 'Herman', '0996504315', NULL, 'Female', 'Da Nang', NULL, '70472 Quincy Station\nNorth Lyricville, DC 87419-8299', 'Volunteer', NULL, 1, 1, '2025-11-13 23:07:05', NULL, '6D29KAnpGm', NULL, NULL, NULL, NULL, '2025-12-04 16:29:32', '2025-12-04 16:29:32'),
(183, NULL, NULL, 'beier.cheyanne@example.org', '$2y$12$kwfg9GmDeaqapCeozpX/1uPdukJ1XPbxElCQjOb1satl1wQEdQJPG', 'Lowell', 'Dach', NULL, NULL, 'Female', 'Can Tho', 'Riceport', NULL, 'Volunteer', NULL, 1, 1, '2025-11-10 01:59:54', NULL, 'Unju3CC4FA', NULL, NULL, NULL, NULL, '2025-12-04 16:29:33', '2025-12-04 16:29:33'),
(184, NULL, NULL, 'solon33@example.com', '$2y$12$V4cAC1K96in0SkmqYbyn8utu5uamXPzc9H6WKI5SE3UuQVK23zE.i', 'Myrtie', 'Lang', '0903083763', NULL, 'Other', 'Hanoi', 'Halvorsonmouth', '575 Marilie Path\nWest Wilhelmville, ID 53552', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb44?text=people+magni', 0, 1, NULL, NULL, 'H1hdtZZpJe', NULL, NULL, NULL, NULL, '2025-12-04 16:29:33', '2025-12-04 16:29:33'),
(185, NULL, NULL, 'isom.muller@example.net', '$2y$12$MgDc7HqOOm9sXUreZXDiBu382sch5efSCxl20RuCN3Kz6w1oGamQe', 'Monty', 'Crooks', '0987100973', NULL, 'Male', 'Hai Phong', 'Port Ferne', NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'glzMc63OPj', NULL, NULL, NULL, NULL, '2025-12-04 16:29:33', '2025-12-04 16:29:33'),
(186, NULL, NULL, 'kshlerin.frederic@example.net', '$2y$12$DDLcVj5rZyzLsxPczbxCrOG0qg/TDBOi1Ipju8DERiZHhwTN4nCiS', 'Pinkie', 'Labadie', '0959971545', '2002-07-07', 'Female', 'Hanoi', 'Daphneemouth', '159 Bessie Unions Apt. 729\nWest Bria, SC 80876', 'Volunteer', NULL, 1, 1, NULL, NULL, 'eDhD0cIklO', NULL, NULL, NULL, NULL, '2025-12-04 16:29:33', '2025-12-04 16:29:33'),
(187, NULL, NULL, 'toby01@example.com', '$2y$12$HrIrUcn.NKHaA528JOyej.m8qVQ/VCgVie/sxMNgzYYS95LaEh9ka', 'Karelle', 'Bruen', NULL, NULL, 'Other', 'Hanoi', 'South Baronton', '14559 Larson Land\nAylinshire, WI 64554-0126', 'Volunteer', NULL, 1, 1, '2025-11-15 23:21:23', NULL, 'XSEZMG8wXH', NULL, NULL, NULL, NULL, '2025-12-04 16:29:34', '2025-12-04 16:29:34'),
(188, NULL, NULL, 'xdickens@example.com', '$2y$12$ILyxwI31CUGnn5XYUft24ON6/l2yQduLmM6QWJO6w0zeG3AssH1Ii', 'Mac', 'Kerluke', '0932142572', NULL, 'Female', 'Da Nang', 'Aufderharfort', '98848 Grady Fords\nGradyview, IN 38730', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee33?text=people+consequuntur', 1, 1, '2025-11-16 11:21:54', NULL, 'tTPlhU1pdq', NULL, NULL, NULL, NULL, '2025-12-04 16:29:34', '2025-12-04 16:29:34'),
(189, NULL, NULL, 'heaney.luther@example.org', '$2y$12$cx7nznuOwtL1jAhLa1B7VuiGiRvNqP8WlpzXAsbB2.Zh2gwEB2PIi', 'Maxie', 'Barrows', NULL, '1991-05-06', 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008844?text=people+maxime', 1, 1, '2025-11-14 18:48:11', NULL, 'HQzIfjlV1B', NULL, NULL, NULL, NULL, '2025-12-04 16:29:34', '2025-12-04 16:29:34'),
(190, NULL, NULL, 'elvis39@example.net', '$2y$12$V/BZjH/eTiCXNXRHCTOBCOg8s.digwfB2rrw9GpQYbEayCbAgS.5q', 'Tremaine', 'Murray', NULL, '1981-08-20', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002255?text=people+esse', 1, 1, NULL, NULL, 'hmtwItCXsG', NULL, NULL, NULL, NULL, '2025-12-04 16:29:34', '2025-12-04 16:29:34'),
(191, NULL, NULL, 'ledner.karlee@example.net', '$2y$12$vc/9jjxaRi.jnhlwoJesW.vHNn55VjQGt/AMtRW81CaycPjac5xpO', 'Talia', 'Ruecker', '0995963328', '1982-10-08', 'Male', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-12-03 23:45:10', NULL, 'MneVCrikM9', NULL, NULL, NULL, NULL, '2025-12-04 16:29:35', '2025-12-04 16:29:35'),
(192, NULL, NULL, 'rutherford.monte@example.org', '$2y$12$EW4xWF/ATbnSFd5byYPG4.78JsJfgYLgubifXVFcQeGwSjBf6OTeC', 'Rebeca', 'Heaney', '0930817126', '1976-02-01', 'Male', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-26 16:24:07', NULL, 'xf6K3TS3bg', NULL, NULL, NULL, NULL, '2025-12-04 16:29:35', '2025-12-04 16:29:35'),
(193, NULL, NULL, 'unique.cole@example.com', '$2y$12$oSNR9EkEqNqY13EhsNjjA.tKABHvcDQu2HCh1uN0MlxZk2ttwLkIO', 'Cornell', 'Kohler', '0958885100', NULL, 'Male', 'Hanoi', 'Jaymemouth', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'AKJcQLjVsa', NULL, NULL, NULL, NULL, '2025-12-04 16:29:35', '2025-12-04 16:29:35'),
(194, NULL, NULL, 'wjerde@example.org', '$2y$12$LQ9uuqzsNcyKqmqeSNqg0eGJfk78yxv1VnPF2Ux8niuAJDzQZ2OU6', 'Stuart', 'Legros', '0952826290', '2007-10-11', 'Other', 'Hanoi', 'South Chaddchester', '3915 Joany Forks Apt. 787\nMariaburgh, CO 23192-1736', 'Volunteer', 'https://via.placeholder.com/200x200.png/0088ee?text=people+sunt', 1, 1, '2025-11-15 08:58:40', NULL, 'vC8zwx2ebZ', NULL, NULL, NULL, NULL, '2025-12-04 16:29:35', '2025-12-04 16:29:35'),
(195, NULL, NULL, 'corwin.olin@example.com', '$2y$12$YTXY26hxct9Ro10nAiGu2.Fsp36lw4VtIjvkyrNjZ4niQt7r2R4fW', 'Syble', 'Hamill', '0949143526', NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/004411?text=people+voluptatibus', 1, 1, NULL, NULL, 'VuggByJItc', NULL, NULL, NULL, NULL, '2025-12-04 16:29:36', '2025-12-04 16:29:36'),
(196, NULL, NULL, 'myles.parker@example.net', '$2y$12$/gD/2t96SwSWAnxlSAY54OWjvLfix5VLNU0uRfvA782VDyNVAdTFK', 'Eulalia', 'Treutel', NULL, NULL, 'Other', 'Da Nang', 'South Prudence', '4248 Okuneva Crossroad\nLake Orlandburgh, AR 52957-8753', 'Volunteer', 'https://via.placeholder.com/200x200.png/0066cc?text=people+molestias', 1, 1, NULL, NULL, 'YQ9FHgBZAu', NULL, NULL, NULL, NULL, '2025-12-04 16:29:36', '2025-12-04 16:29:36'),
(197, NULL, NULL, 'joel.torp@example.net', '$2y$12$eWdXD4hvBRBEveZdrKiGVe8KgzXoZa2BjHRg/dCOhF5BjT0gwxViy', 'Ottilie', 'Schaden', NULL, NULL, 'Other', 'Ho Chi Minh', 'Lefflerton', '8160 Mills Burg Apt. 927\nJoelstad, ME 75238-4606', 'Volunteer', 'https://via.placeholder.com/200x200.png/001155?text=people+deserunt', 1, 1, NULL, NULL, 'MJojsSeOLp', NULL, NULL, NULL, NULL, '2025-12-04 16:29:36', '2025-12-04 16:29:36'),
(198, NULL, NULL, 'rosalind.gleason@example.net', '$2y$12$yz1bzW0HelQ75E/8m.aOGehVv4PrujdXUVJqzjMNVAXCKmfJ2Sel6', 'Demarco', 'Tillman', NULL, NULL, 'Female', 'Da Nang', 'Loweborough', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc11?text=people+adipisci', 1, 1, '2025-11-15 12:21:52', NULL, 'HdG8N2Ge8j', NULL, NULL, NULL, NULL, '2025-12-04 16:29:37', '2025-12-04 16:29:37'),
(199, NULL, NULL, 'effie.wunsch@example.net', '$2y$12$qQt3Ha.eiJgo.ZyWTJ15Lem9SGURmz57DitYi61AosSR2RaGFMSZy', 'Alejandra', 'Emard', NULL, '1978-06-29', 'Male', 'Ho Chi Minh', NULL, '62629 Emma Turnpike Apt. 020\nRyderstad, IN 03688', 'Volunteer', NULL, 0, 1, '2025-12-01 16:34:37', NULL, 'bnfKg8fn7y', NULL, NULL, NULL, NULL, '2025-12-04 16:29:37', '2025-12-04 16:29:37'),
(200, NULL, NULL, 'dietrich.garland@example.org', '$2y$12$zJoHwwExgHl092CE9L.rHewhAIeDrxtxOoi7T5N19GTtoJajeaVji', 'Davonte', 'Howe', NULL, NULL, 'Female', 'Hai Phong', 'Devynport', '3044 Jast Curve\nEvansland, NE 21161', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee99?text=people+dolor', 1, 1, NULL, NULL, 'v09lJLXt6b', NULL, NULL, NULL, NULL, '2025-12-04 16:29:37', '2025-12-04 16:29:37'),
(201, NULL, NULL, 'durgan.hettie@example.org', '$2y$12$8rcUPFyN7/C4lXwn2t0e2ubCRuNYDtZO8iEuovolHey2.ZPmak7fi', 'Will', 'Kohler', '0993998605', '1987-07-25', 'Male', 'Ho Chi Minh', 'East Cortney', NULL, 'Volunteer', NULL, 1, 1, '2025-11-10 13:29:08', NULL, 'hXjqd8WTAL', NULL, NULL, NULL, NULL, '2025-12-04 16:29:37', '2025-12-04 16:29:37'),
(202, NULL, NULL, 'clemmie.schneider@example.net', '$2y$12$xO0IOEHerC6DHekGuczGvuS3F/zaZzOFzpnNIphr3cJQm96vpMgNy', 'Karson', 'Wolf', '0923516929', NULL, 'Female', 'Da Nang', 'West Nestor', NULL, 'Volunteer', NULL, 1, 1, '2025-11-06 12:59:58', NULL, 'fAFagsuPCO', NULL, NULL, NULL, NULL, '2025-12-04 16:29:38', '2025-12-04 16:29:38'),
(203, NULL, NULL, 'gaetano.crona@example.net', '$2y$12$7gYgDo4jXVA2MUqGJtMKJe31uwT29cPXa5Y4yvxw.pL/MDEtYsbJm', 'Sylvester', 'Waelchi', NULL, NULL, 'Other', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'tdOwAXqpWQ', NULL, NULL, NULL, NULL, '2025-12-04 16:29:38', '2025-12-04 16:29:38'),
(204, NULL, NULL, 'cgoyette@example.org', '$2y$12$9tVoYnzP5t.5ruDOP4Bd..ewg4s37inshSxS3VGBE2A60opYGXkzi', 'Bertrand', 'Reynolds', '0966910113', '1984-11-02', 'Male', 'Ho Chi Minh', 'Lake Karlieland', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'h6LTW4lnrz', NULL, NULL, NULL, NULL, '2025-12-04 16:29:38', '2025-12-04 16:29:38'),
(205, NULL, NULL, 'bettie52@example.org', '$2y$12$2ZjOrxuQf1pGbaNBAOMTA.oeNC.962a.XAr/aNvxiVYSnVXl367ki', 'Reyes', 'Heidenreich', '0982834327', NULL, 'Other', 'Da Nang', 'Mattmouth', '69671 Nya Hollow Suite 717\nSchuppeshire, KY 02229-2119', 'Volunteer', NULL, 1, 1, '2025-11-05 07:05:53', NULL, 'k4MkCiyq4D', NULL, NULL, NULL, NULL, '2025-12-04 16:29:38', '2025-12-04 16:29:38'),
(206, NULL, NULL, 'schultz.constance@example.org', '$2y$12$JyuGdgt8sRV3l5Q4JvLrF.uMmRIfiT/U1sPXNxwovfY/.k0FyyNvq', 'Jessyca', 'Mertz', '0989180906', '1990-01-11', 'Female', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0077ff?text=people+et', 1, 1, NULL, NULL, 'A6mPk695LC', NULL, NULL, NULL, NULL, '2025-12-04 16:29:39', '2025-12-04 16:29:39'),
(207, NULL, NULL, 'cristal91@example.net', '$2y$12$wN88XCU6ow22wcMgaptOw.M/ScphNQd9R0GyztR0DEVYcoBE2OEx6', 'Jimmy', 'Muller', NULL, NULL, 'Male', 'Can Tho', 'Port Giovannyborough', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'ppFfdu8Gl0', NULL, NULL, NULL, NULL, '2025-12-04 16:29:39', '2025-12-04 16:29:39'),
(208, NULL, NULL, 'baby.heaney@example.net', '$2y$12$d6U/DP4hcxAoAIfrOTWFhO0efVE93NZ52dteWq/TbBgoL2zlkjGRu', 'Nannie', 'Beer', NULL, NULL, 'Other', 'Da Nang', 'Lake Dexter', '408 Conn Creek Suite 243\nWest Chloe, OR 74848', 'Volunteer', 'https://via.placeholder.com/200x200.png/007744?text=people+soluta', 1, 1, NULL, NULL, 'zXiVpmxuN6', NULL, NULL, NULL, NULL, '2025-12-04 16:29:39', '2025-12-04 16:29:39'),
(209, NULL, NULL, 'ehudson@example.org', '$2y$12$LqK/NImGteI/QbLNj5WUCeaT4oX/DBHISyj2LoMXOfM8/XfHAQkmm', 'Gennaro', 'Nolan', NULL, NULL, 'Other', 'Hanoi', 'East Bernard', '60202 Antonetta Estate\nNew Sonny, PA 52615-4117', 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc77?text=people+non', 0, 1, '2025-11-08 05:29:53', NULL, 'hxUqpUZWO0', NULL, NULL, NULL, NULL, '2025-12-04 16:29:39', '2025-12-04 16:29:39'),
(210, NULL, NULL, 'charlie18@example.org', '$2y$12$7giKwFw7/fstA5kFdSY70uCtAMGXSYKJkz/esKGRE1g8zO9HLzB16', 'Lola', 'Mitchell', NULL, NULL, 'Female', 'Can Tho', 'Auertown', '97451 Janice Isle\nBrakuschester, MN 99702', 'Volunteer', NULL, 1, 1, '2025-11-16 14:21:36', NULL, 'VygcMrzheG', NULL, NULL, NULL, NULL, '2025-12-04 16:29:40', '2025-12-04 16:29:40'),
(211, NULL, NULL, 'noemy.mcglynn@example.com', '$2y$12$1pcr3ujzW3PIbgHXBO/sbO2BRYJAeKxABkTUAA0TGnJS0AcCOW2bq', 'Destiny', 'Jacobi', NULL, '1998-12-09', 'Female', 'Ho Chi Minh', 'Lake Pierreberg', '223 Predovic Village Apt. 992\nWeldonborough, SD 38957-2430', 'Volunteer', NULL, 1, 1, NULL, NULL, 'f9DHPmucq0', NULL, NULL, NULL, NULL, '2025-12-04 16:29:40', '2025-12-04 16:29:40'),
(212, NULL, NULL, 'dooley.johnathon@example.org', '$2y$12$GMa9cMZAapqEREiNlvSqd.SaoaTkq0k0XkQ9zTAMdBaN37rN0.vp.', 'Gisselle', 'Keebler', '0927653713', '1989-08-01', 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb55?text=people+ipsum', 1, 1, '2025-11-05 01:20:04', NULL, 'anAM5xNxr4', NULL, NULL, NULL, NULL, '2025-12-04 16:29:40', '2025-12-04 16:29:40'),
(213, NULL, NULL, 'egoldner@example.net', '$2y$12$nUdPrfJ/YVz5Df5YH.b3nuaerOaF7hX5qOCQG9Lajhvas4txDsTaS', 'Titus', 'Miller', NULL, NULL, 'Other', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'VX0SusW6Jg', NULL, NULL, NULL, NULL, '2025-12-04 16:29:40', '2025-12-04 16:29:40'),
(214, NULL, NULL, 'hayes.sam@example.org', '$2y$12$yxVHmA3RholaWvLbDMyIRO5MBD/gHBatLs9F91ptXRSE27Iujj.7S', 'Savanna', 'Bechtelar', NULL, NULL, 'Male', 'Hanoi', 'Cooperberg', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008844?text=people+modi', 1, 1, '2025-11-20 10:11:57', NULL, 'PQZEA8vpL5', NULL, NULL, NULL, NULL, '2025-12-04 16:29:41', '2025-12-04 16:29:41'),
(215, NULL, NULL, 'treichel@example.com', '$2y$12$Jb4PaivWAN181JA9tZ9iX.cbhGKH3URoNgxDtv3XBtB00uxzdongm', 'Daija', 'Berge', '0931506221', '1966-12-01', 'Other', 'Can Tho', 'New Amira', NULL, 'Organization', 'https://via.placeholder.com/200x200.png/005588?text=people+adipisci', 0, 1, NULL, NULL, '2zvkR9YVPy', NULL, NULL, NULL, NULL, '2025-12-04 16:29:41', '2025-12-04 16:29:41'),
(216, NULL, NULL, 'aaufderhar@example.com', '$2y$12$8zKNQyxC0s/Fi1xjFkU2rOYUPS03nbYyct43AT9RWwfPuwGlHiTwS', 'Chelsie', 'Rath', '0952879922', '1969-02-28', 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aacc?text=people+sunt', 1, 1, NULL, NULL, 'hZAWDeNdfP', NULL, NULL, NULL, NULL, '2025-12-04 16:29:41', '2025-12-04 16:29:41'),
(217, NULL, NULL, 'virginia.bernhard@example.com', '$2y$12$YcnDr5Hx12evssQa5NXo/Ol5/oaR5RtQ9riddtyUSkhWh9F/JI/Ji', 'Ford', 'Bogisich', NULL, NULL, 'Male', 'Can Tho', 'Port Kellieshire', NULL, 'Volunteer', NULL, 0, 1, '2025-11-05 16:19:18', NULL, '1A8GbPXv8h', NULL, NULL, NULL, NULL, '2025-12-04 16:29:42', '2025-12-04 16:29:42'),
(218, NULL, NULL, 'sipes.bennie@example.org', '$2y$12$ZMwgfz0NjMdyS/YuIVMWM.esj3PZeXE/.TRxR9cm8XZ98ul4SoIVm', 'Jose', 'Eichmann', '0964511894', '1988-02-05', 'Female', 'Can Tho', NULL, '4261 Wilhelmine Village\nHilpertbury, OR 40741-6015', 'Volunteer', NULL, 1, 1, NULL, NULL, 'i3kggBAohT', NULL, NULL, NULL, NULL, '2025-12-04 16:29:42', '2025-12-04 16:29:42'),
(219, NULL, NULL, 'lessie.kutch@example.net', '$2y$12$opy5zK7s/4c4QQe8dzXBCe3FrDKOd7i/tZVJHqBDm.JyxbNZWSsd.', 'Jalon', 'Bogan', NULL, '1985-09-14', 'Male', 'Can Tho', 'Lake Jayceebury', '6920 Bechtelar Turnpike\nFaheyville, DE 57329', 'Volunteer', NULL, 1, 1, NULL, NULL, 'ZLYOuWBcEh', NULL, NULL, NULL, NULL, '2025-12-04 16:29:42', '2025-12-04 16:29:42'),
(220, NULL, NULL, 'jfritsch@example.net', '$2y$12$GDL92Q1f8PXrCllWatX0S.ksumKzRMx41FRO3G9fuN0vhpEq2tbb.', 'Merle', 'Rice', NULL, '1986-06-27', 'Female', 'Hai Phong', 'Lake Sylvestertown', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'ZHttKstgGW', NULL, NULL, NULL, NULL, '2025-12-04 16:29:42', '2025-12-04 16:29:42'),
(221, NULL, NULL, 'lind.ignatius@example.org', '$2y$12$gJM/FSwunghiD/yFrw1yv.MakC8RGqQuC/1sIEvKVR1YzYjuvPPba', 'Lora', 'Keebler', '0919836042', NULL, 'Male', 'Da Nang', 'Binsside', '285 Farrell Village Suite 576\nNorth Jovanymouth, SD 90768', 'Volunteer', NULL, 1, 1, '2025-11-26 03:36:30', NULL, 'gzdFZMIbAP', NULL, NULL, NULL, NULL, '2025-12-04 16:29:43', '2025-12-04 16:29:43'),
(222, NULL, NULL, 'qhalvorson@example.net', '$2y$12$Eu9bpEXchMTalEObGDqth.4/KvPRqMbJoznCy9ELRihMy1TlxMEZ2', 'Ima', 'Okuneva', '0908703268', NULL, 'Other', 'Da Nang', 'South Douglaschester', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0033cc?text=people+tempora', 0, 1, '2025-11-22 00:54:44', NULL, 'pp9cxDtTVv', NULL, NULL, NULL, NULL, '2025-12-04 16:29:43', '2025-12-04 16:29:43'),
(223, NULL, NULL, 'sibyl97@example.com', '$2y$12$XRfcvbvGl1zpkhkXDJGfu.pL3UKn1/iQlnpKs9B0b2PthHB8DPNy6', 'Bella', 'Heller', NULL, '2005-02-04', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'zoRfxzkarn', NULL, NULL, NULL, NULL, '2025-12-04 16:29:43', '2025-12-04 16:29:43'),
(224, NULL, NULL, 'sunny.bogisich@example.net', '$2y$12$Sf1xl5YuYjX9Pzu6I35fTeelnn5U6f8OvgbkFCrgtPPmYf7X5ClGK', 'Lucile', 'Walker', '0930012204', '2000-04-10', 'Male', 'Ho Chi Minh', 'Strosintown', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0066bb?text=people+numquam', 1, 1, '2025-11-05 15:04:27', NULL, 'U6aQbLh1vJ', NULL, NULL, NULL, NULL, '2025-12-04 16:29:43', '2025-12-04 16:29:43'),
(225, NULL, NULL, 'amely.daugherty@example.org', '$2y$12$jAW5IOrxBi3st5Dc5aUJNeiCpldcF9iZrYD.fLh92gK8L5llON6r2', 'Sid', 'Labadie', NULL, '1980-08-30', 'Female', 'Hanoi', NULL, '3717 Adeline Route Apt. 425\nWest Colemanburgh, MD 15412-5186', 'Volunteer', 'https://via.placeholder.com/200x200.png/007733?text=people+veritatis', 1, 1, '2025-11-15 05:13:58', NULL, 'lr09EFOura', NULL, NULL, NULL, NULL, '2025-12-04 16:29:44', '2025-12-04 16:29:44'),
(226, NULL, NULL, 'parker.ilene@example.org', '$2y$12$haRGDV7jKvW3ozpQ8eGFkuTr3xdiBaiP4LqlJgwRpXWq9G7o4xF26', 'Pablo', 'Kiehn', NULL, '1977-01-12', 'Male', 'Hanoi', 'New Zackberg', '99214 Kuvalis Mill Apt. 582\nAurelieland, OK 46416-4325', 'Volunteer', NULL, 1, 1, NULL, NULL, '4lm5n9E5hT', NULL, NULL, NULL, NULL, '2025-12-04 16:29:44', '2025-12-04 16:29:44'),
(227, NULL, NULL, 'norma26@example.net', '$2y$12$rjx0KGy9gS3VSsSSzM5lGue/moN7.dfu4BlNCgfm5hUAWQyF4y.kO', 'Jaeden', 'Cassin', '0925766907', '1999-04-24', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002222?text=people+exercitationem', 1, 1, NULL, NULL, 'OB9kXi7080', NULL, NULL, NULL, NULL, '2025-12-04 16:29:44', '2025-12-04 16:29:44'),
(228, NULL, NULL, 'wkuvalis@example.org', '$2y$12$um8BKS.U3HFWBtihacFFgOZrWy1kf5AljgWILExgtckKvhWp1cJZi', 'Doyle', 'Reichel', '0958083540', '1967-04-17', 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-27 04:38:09', NULL, '4UlnDnNYNp', NULL, NULL, NULL, NULL, '2025-12-04 16:29:44', '2025-12-04 16:29:44'),
(229, NULL, NULL, 'tdaugherty@example.org', '$2y$12$4kjARGv/zbX6M2H8xmxT6.lqzNzQFoV.YQ2Blip.WiOmGtzi3N4Du', 'Craig', 'Blick', NULL, '1996-12-13', 'Other', 'Ho Chi Minh', 'Madisonport', NULL, 'Volunteer', NULL, 1, 1, '2025-11-22 22:10:03', NULL, 'Px1XSYfZqR', NULL, NULL, NULL, NULL, '2025-12-04 16:29:45', '2025-12-04 16:29:45'),
(230, NULL, NULL, 'fernando35@example.org', '$2y$12$JbRLebxAVYUasKworTJOUuK.g5R1idnwjl2gPyYijUvg.3tZzH/I6', 'Dominique', 'Gleason', '0957362282', NULL, 'Male', 'Can Tho', NULL, '551 Dante Squares Suite 237\nLarkinton, RI 83766-3167', 'Volunteer', 'https://via.placeholder.com/200x200.png/004455?text=people+est', 1, 1, '2025-11-12 03:59:34', NULL, 'R0z30E4gN8', NULL, NULL, NULL, NULL, '2025-12-04 16:29:45', '2025-12-04 16:29:45'),
(231, NULL, NULL, 'raina.schaden@example.org', '$2y$12$v32BjKLOAMJwVkub8e4X1e0iV2kE6Gt/CmbKuXQgSvH33x7JPzFWu', 'Joanny', 'Skiles', '0908580557', '1983-01-09', 'Male', 'Da Nang', 'South Janaeville', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00eeaa?text=people+et', 1, 1, '2025-11-06 19:21:55', NULL, 'tQgvRlDXCT', NULL, NULL, NULL, NULL, '2025-12-04 16:29:45', '2025-12-04 16:29:45'),
(232, NULL, NULL, 'thompson.dorian@example.net', '$2y$12$W34dYk6gwWFmcpPpR3lcwehIv9UXDXABqnNpUN52rJsf0anmHzcFm', 'Burdette', 'Reynolds', '0933551945', '1975-01-12', 'Male', 'Hai Phong', 'Hershelport', '25478 Champlin Unions\nVerdashire, DE 39285-4367', 'Volunteer', NULL, 1, 1, NULL, NULL, 'ftMrJsKh5H', NULL, NULL, NULL, NULL, '2025-12-04 16:29:46', '2025-12-04 16:29:46'),
(233, NULL, NULL, 'jefferey16@example.com', '$2y$12$7SSAz.pU2OE8vEiflHq98evWkZ9vTH.nZZT968JANE03ztvu2VbiW', 'Liliana', 'Zboncak', NULL, '2001-11-09', 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005500?text=people+blanditiis', 1, 1, NULL, NULL, 'hHt2PUtt1v', NULL, NULL, NULL, NULL, '2025-12-04 16:29:46', '2025-12-04 16:29:46'),
(234, NULL, NULL, 'itzel.beer@example.net', '$2y$12$2KDcZ9ZNHDK9vnL6amD68uwvNfgQxDIdGhyanE8sY4AVT0n7rbccu', 'Tristin', 'Gaylord', NULL, '1992-04-08', 'Female', 'Ho Chi Minh', 'Frederiqueland', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, '1EniLbs5ku', NULL, NULL, NULL, NULL, '2025-12-04 16:29:46', '2025-12-04 16:29:46'),
(235, NULL, NULL, 'lizzie.borer@example.com', '$2y$12$SibRDXv79zyIzjFHXmg5CegQGqdEaAhLhcvrqXxleK5gGOrfmr47a', 'Jammie', 'Gislason', '0956706709', NULL, 'Male', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'QlDXDCXsQH', NULL, NULL, NULL, NULL, '2025-12-04 16:29:46', '2025-12-04 16:29:46'),
(236, NULL, NULL, 'troy.wolff@example.net', '$2y$12$RXf90vPJ6aw55q7pVWu5U.MdrfdzA6tiHsUGpegXiJunno7hUoR0C', 'Major', 'Lebsack', '0920019888', '1999-03-15', 'Other', 'Ho Chi Minh', NULL, '252 Volkman Motorway Suite 714\nSouth Karleeland, HI 76869-0758', 'Volunteer', 'https://via.placeholder.com/200x200.png/0088ee?text=people+ut', 1, 1, NULL, NULL, 'ntRdKB5i0V', NULL, NULL, NULL, NULL, '2025-12-04 16:29:47', '2025-12-04 16:29:47'),
(237, NULL, NULL, 'antoinette65@example.org', '$2y$12$ssorNwiSclQWO4zIzTsrhuPJpMV0IzaeLFc/E5LVlXmWNbSkDBDcy', 'Eloy', 'Kiehn', NULL, '1997-10-28', 'Other', 'Can Tho', 'Hayesstad', NULL, 'Organization', NULL, 1, 1, '2025-11-20 16:37:01', NULL, 'Mr5raIWUji', NULL, NULL, NULL, NULL, '2025-12-04 16:29:47', '2025-12-04 16:29:47'),
(238, NULL, NULL, 'brandt48@example.org', '$2y$12$JPPCHGRNyl2G6WkQW12u3e423IIRaMAuDNFQGlph1ufzG/QT3Lrjy', 'Levi', 'Grimes', '0984499836', '1987-11-15', 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd88?text=people+nihil', 0, 1, NULL, NULL, 'V3cmWPHuLi', NULL, NULL, NULL, NULL, '2025-12-04 16:29:47', '2025-12-04 16:29:47'),
(239, NULL, NULL, 'francesca69@example.com', '$2y$12$WLSJbUpEnpaTaxqCyeteNeEInX9Av6PpDElO6tNpvD4TiRxc/flDq', 'Ezequiel', 'Casper', NULL, NULL, 'Male', 'Hai Phong', 'Shaniyastad', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0044ff?text=people+ipsa', 1, 1, NULL, NULL, 'Q6iRbRSaIw', NULL, NULL, NULL, NULL, '2025-12-04 16:29:47', '2025-12-04 16:29:47'),
(240, NULL, NULL, 'simone.shields@example.net', '$2y$12$SeDDSEhHvrEOkaaYMKaWoutzG.ogsBL6gNCBKF7HA4LTjOqg.dVgO', 'Elyse', 'Kassulke', NULL, '1998-07-01', 'Other', 'Hanoi', 'North Jamesonside', '20352 Ryan Plains\nSipesbury, WA 64083', 'Volunteer', NULL, 1, 1, '2025-11-24 04:36:38', NULL, '93EfRWWUCM', NULL, NULL, NULL, NULL, '2025-12-04 16:29:48', '2025-12-04 16:29:48'),
(241, NULL, NULL, 'josiah44@example.org', '$2y$12$DAET3y17FChH2i6SjWQuz.IZBzJzPqDBZbKRUsgjLZSoGUjXaUgiy', 'Erick', 'Schamberger', NULL, '1991-06-07', 'Male', 'Hanoi', 'Justusmouth', '255 Corwin Square\nNorth Orlo, DE 66462', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff00?text=people+a', 1, 1, '2025-11-11 02:29:19', NULL, 'oVWifmR8dq', NULL, NULL, NULL, NULL, '2025-12-04 16:29:48', '2025-12-04 16:29:48'),
(242, NULL, NULL, 'tianna62@example.com', '$2y$12$NUp3aWVhRPuLGzFP/u3oJu69TP6I0WzeNB0b.1Q.KzRfwWicUuuEC', 'Camille', 'Osinski', NULL, '1978-11-18', 'Other', 'Hai Phong', 'Hamillhaven', '4976 Kuhn Forges\nSmithamville, IL 99714-9476', 'Volunteer', NULL, 1, 1, '2025-11-12 16:36:10', NULL, 'wGLM2cFvWK', NULL, NULL, NULL, NULL, '2025-12-04 16:29:48', '2025-12-04 16:29:48'),
(243, NULL, NULL, 'yshanahan@example.net', '$2y$12$uWrXNsxsmuJMRxPuO2Zx/OLaJf/WdLjajaRuYFmTrYFWCIAH4M.be', 'Danika', 'Bosco', NULL, '1994-06-20', 'Female', 'Da Nang', 'Kathryneburgh', '765 Schulist Pike Suite 850\nChamplinfurt, ME 04293-6303', 'Volunteer', 'https://via.placeholder.com/200x200.png/001144?text=people+enim', 0, 1, '2025-11-17 19:10:52', NULL, 'MbzJ4WLuvK', NULL, NULL, NULL, NULL, '2025-12-04 16:29:49', '2025-12-04 16:29:49'),
(244, NULL, NULL, 'reed.murphy@example.net', '$2y$12$QzAQMiQL/g5L.kB1pzYYJumLnSBkfhbZ77i8x/FZ8y0FdtWCA8Xf.', 'Hardy', 'Koelpin', NULL, '1983-05-08', 'Female', 'Hanoi', 'South Ralphbury', '616 Greenholt Locks Suite 599\nEast Audiemouth, WA 29560', 'Volunteer', NULL, 1, 1, NULL, NULL, 'bVPtwXMi7E', NULL, NULL, NULL, NULL, '2025-12-04 16:29:49', '2025-12-04 16:29:49'),
(245, NULL, NULL, 'erdman.madison@example.net', '$2y$12$j1OsHZBEvbuFmT4J9plrUOe7sX499wgdo.1R1NgTIBpE4mVhMNIfy', 'Zula', 'Effertz', '0907345881', '1978-04-24', 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002233?text=people+qui', 1, 1, NULL, NULL, 'MEmYFvSlnL', NULL, NULL, NULL, NULL, '2025-12-04 16:29:49', '2025-12-04 16:29:49'),
(246, NULL, NULL, 'kconnelly@example.com', '$2y$12$pxn.NJFMmoHtY4qV2NQtKOQwcu6lLL80kL4CS385/yk/nY/uJF8Ui', 'Trevor', 'McGlynn', '0995424275', NULL, 'Other', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00eedd?text=people+quos', 1, 1, '2025-11-09 22:52:53', NULL, 'brywB0ruCM', NULL, NULL, NULL, NULL, '2025-12-04 16:29:49', '2025-12-04 16:29:49'),
(247, NULL, NULL, 'mhermann@example.net', '$2y$12$g7XRtQ1SdyseHe0tndHI9OZbQEtN.ppZvMcbrNr0Vn2hVfqkYFYRy', 'Andre', 'Spencer', '0975658040', NULL, 'Other', 'Hanoi', 'Port Shanelmouth', NULL, 'Volunteer', NULL, 1, 1, '2025-11-17 09:06:33', NULL, '2lifNjHBCb', NULL, NULL, NULL, NULL, '2025-12-04 16:29:50', '2025-12-04 16:29:50'),
(248, NULL, NULL, 'stark.alysha@example.org', '$2y$12$GiCGYvXI59GumknfLNqrHezuWehiVURVcVTpPt.REamLiLgOQdijy', 'Marques', 'Hegmann', NULL, NULL, 'Other', 'Hai Phong', 'Dionburgh', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'uXc7Y9FM0K', NULL, NULL, NULL, NULL, '2025-12-04 16:29:50', '2025-12-04 16:29:50'),
(249, NULL, NULL, 'ccarter@example.org', '$2y$12$0c2Uvkn4glBnRmloh4vTMeq3CXJYRZskcUhd2WhJpzASus8/sIFmK', 'Martin', 'Heller', '0967205081', NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/007711?text=people+aut', 1, 1, '2025-11-16 07:35:18', NULL, 'oi1HZ3MKKt', NULL, NULL, NULL, NULL, '2025-12-04 16:29:50', '2025-12-04 16:29:50'),
(250, NULL, NULL, 'lebsack.dale@example.net', '$2y$12$NUagaNreaSKhvIc1lZiFEeHr8yL2uBxwtDsd6.l8rdRqThiYBBU4S', 'Jeffry', 'Cremin', NULL, '1974-03-09', 'Other', 'Can Tho', 'New Mariane', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'hipvOykvHg', NULL, NULL, NULL, NULL, '2025-12-04 16:29:50', '2025-12-04 16:29:50'),
(251, NULL, NULL, 'rebecca.hill@example.org', '$2y$12$Ok/t1WEjuF73/oJb2nYJrOBW0qUljZJtysI2p3BbxzV1/095K2vv.', 'Diana', 'Prohaska', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, '569 Runolfsdottir Turnpike\nEsperanzafurt, WY 99398', 'Volunteer', 'https://via.placeholder.com/200x200.png/008855?text=people+modi', 1, 1, '2025-12-02 01:35:10', NULL, 'tUcgryb29U', NULL, NULL, NULL, NULL, '2025-12-04 16:29:51', '2025-12-04 16:29:51'),
(252, NULL, NULL, 'jazmyn.schuppe@example.com', '$2y$12$cz.S0fN1SXiD24EyfSz5pegZI1c7rn8Bss5QxQJxMuYNnOmIKyVrS', 'Terry', 'Lockman', '0906664359', NULL, 'Male', 'Ho Chi Minh', 'Lake Sandrineshire', '6083 Mark Harbors\nNew Lewisstad, WA 14210-6848', 'Volunteer', NULL, 1, 1, '2025-11-12 18:43:26', NULL, 'MaIC9gYwmc', NULL, NULL, NULL, NULL, '2025-12-04 16:29:51', '2025-12-04 16:29:51'),
(253, NULL, NULL, 'mreynolds@example.com', '$2y$12$2NWRt1mXOxwlrrQJkXAyien8xlhEoADxtjge6QQ8ns.qCLFZLX3Tu', 'Willie', 'Brekke', '0958068980', NULL, 'Male', 'Hai Phong', 'South Garrett', '77020 Moen Tunnel\nLake Unique, RI 09739', 'Volunteer', NULL, 1, 1, NULL, NULL, 'PZYgbaukcH', NULL, NULL, NULL, NULL, '2025-12-04 16:29:51', '2025-12-04 16:29:51'),
(254, NULL, NULL, 'qwilliamson@example.org', '$2y$12$fxm3PTYY15CyeRPuLpfvSe1HO1FYshZ3ZyO7FvRDlLc9EU98zKHzW', 'Maribel', 'Bahringer', NULL, '2001-04-17', 'Other', 'Ho Chi Minh', 'Willshire', '61484 Pagac Walks Apt. 137\nLake Earlinefurt, SD 28638', 'Volunteer', NULL, 1, 1, '2025-11-05 04:19:40', NULL, 'Jpy1DfwfvN', NULL, NULL, NULL, NULL, '2025-12-04 16:29:51', '2025-12-04 16:29:51'),
(255, NULL, NULL, 'lily66@example.org', '$2y$12$gVvOnKm2NeU0iEB1uT3TP.lUvnMWuzy5WnaIQvVJy79RpVQ8aaTAu', 'Opal', 'Cole', '0980825015', NULL, 'Male', 'Da Nang', 'Dasiatown', '910 Lilyan Mills Apt. 309\nPort Sophiefurt, DC 77659', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffbb?text=people+est', 1, 1, NULL, NULL, '0HbTvBtUao', NULL, NULL, NULL, NULL, '2025-12-04 16:29:52', '2025-12-04 16:29:52'),
(256, NULL, NULL, 'cluettgen@example.net', '$2y$12$JECrzjnk62z7SHqrXhE/LeKiWrRCkGw8/BKbrJez4fMZFj.zbhKLa', 'Mario', 'Lubowitz', '0981919176', '2003-05-09', 'Female', 'Hai Phong', 'South Angus', '1109 Dayana Spur Apt. 263\nCummerataburgh, OK 83587', 'Volunteer', NULL, 1, 1, '2025-11-21 08:48:40', NULL, 'vY85spnzNx', NULL, NULL, NULL, NULL, '2025-12-04 16:29:52', '2025-12-04 16:29:52'),
(257, NULL, NULL, 'dakota.cremin@example.com', '$2y$12$REWiZwl7n/rrrjjGwc9CaeY7GI1prDiQZBIITIZ.t7mbe5qKEldMe', 'Toby', 'Cummings', '0989565396', NULL, 'Male', 'Hanoi', NULL, '187 Cecile Motorway Apt. 077\nPort Granvilleshire, VT 20590', 'Volunteer', NULL, 0, 1, NULL, NULL, 'MbEQgKSlZc', NULL, NULL, NULL, NULL, '2025-12-04 16:29:52', '2025-12-04 16:29:52'),
(258, NULL, NULL, 'arnaldo59@example.org', '$2y$12$m2xGDbM1QdOfi/yK/aeOHumEF.i8UPR/gPQjegQjhnIHZYBdqf2lq', 'Betty', 'Parker', NULL, '1977-05-07', 'Male', 'Ho Chi Minh', 'Lake Adrienneville', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffee?text=people+dignissimos', 0, 1, NULL, NULL, '45gwbm28Kk', NULL, NULL, NULL, NULL, '2025-12-04 16:29:52', '2025-12-04 16:29:52'),
(259, NULL, NULL, 'terrell.schaden@example.com', '$2y$12$uVAEMJAnA9flGvlYFNq2N.wQIpoqJC9Z81UCVZvzavcXVKoicwzia', 'Collin', 'McKenzie', NULL, '2007-09-27', 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff11?text=people+architecto', 1, 1, '2025-11-09 01:49:07', NULL, 'Ww3l9oR1eg', NULL, NULL, NULL, NULL, '2025-12-04 16:29:53', '2025-12-04 16:29:53'),
(260, NULL, NULL, 'may66@example.com', '$2y$12$KSJnd2QL.GkTZE3DRgu5y.3v3mM61.xzpTac4TIDMSbozKY1CS.I2', 'Juana', 'Conn', '0929193623', NULL, 'Other', 'Hanoi', 'Juanitaton', NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'gxP7mJkkG7', NULL, NULL, NULL, NULL, '2025-12-04 16:29:53', '2025-12-04 16:29:53'),
(261, NULL, NULL, 'brice25@example.com', '$2y$12$KLAMe2ch8cPPc/gMf6BROuT63CpBe4AHR1tCksPYRBQxbVjEq2YmK', 'Misty', 'Lueilwitz', '0917397370', '1971-08-19', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000066?text=people+quia', 1, 1, '2025-11-29 10:38:29', NULL, 'xkMgJLDqGF', NULL, NULL, NULL, NULL, '2025-12-04 16:29:53', '2025-12-04 16:29:53'),
(262, NULL, NULL, 'cassin.jannie@example.net', '$2y$12$IQ3N0c1Y9BESbVdWdErf2O6KnwKyTPnXsbBciXf.Qa5OdEKFIzdi2', 'Lilly', 'Dach', NULL, NULL, 'Male', 'Hanoi', 'Crystelport', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccaa?text=people+quo', 1, 1, NULL, NULL, '5iDUUzh4s1', NULL, NULL, NULL, NULL, '2025-12-04 16:29:53', '2025-12-04 16:29:53'),
(263, NULL, NULL, 'harvey24@example.com', '$2y$12$B/IrrzcbSLnGnavGphSeQegkf4/R2Qkn55v5jkZ6WyBRzkWvw8gf.', 'Arden', 'Ullrich', '0912806481', '1973-09-21', 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/003333?text=people+nesciunt', 1, 1, NULL, NULL, 'PuzZU4w8ml', NULL, NULL, NULL, NULL, '2025-12-04 16:29:54', '2025-12-04 16:29:54'),
(264, NULL, NULL, 'gleichner.issac@example.org', '$2y$12$Y3cKy98iJGFkVdLfOVEBQe4Kd8AFXMysUdygD9yvHjqgHhJXEYw92', 'Arnoldo', 'McGlynn', '0908138863', NULL, 'Other', 'Da Nang', 'Tracebury', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bbee?text=people+ducimus', 1, 1, NULL, NULL, 'NP79sCRDLi', NULL, NULL, NULL, NULL, '2025-12-04 16:29:54', '2025-12-04 16:29:54'),
(265, NULL, NULL, 'bins.van@example.org', '$2y$12$5JCg8asB.8u8ZUQIZ88Vh.zF.tyzLCFJY1Y5R4EJzN5hu3tF.bab6', 'Elwin', 'Miller', '0904255873', NULL, 'Female', 'Hai Phong', 'Terrybury', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/009911?text=people+praesentium', 1, 1, '2025-11-18 09:59:52', NULL, 'efqGKLRqqF', NULL, NULL, NULL, NULL, '2025-12-04 16:29:54', '2025-12-04 16:29:54'),
(266, NULL, NULL, 'sarai.mohr@example.com', '$2y$12$h/u.WJ7nvrKoD0bQjtbgoOESseZL81it016zILwxbFmKR12dunLyC', 'Stuart', 'Kulas', '0995548455', NULL, 'Female', 'Hanoi', NULL, '773 O\'Keefe Burg Suite 997\nEast Berniecemouth, AK 17054', 'Volunteer', 'https://via.placeholder.com/200x200.png/006655?text=people+voluptatem', 1, 1, '2025-11-27 18:02:57', NULL, 'HsgFpDkg6d', NULL, NULL, NULL, NULL, '2025-12-04 16:29:55', '2025-12-04 16:29:55'),
(267, NULL, NULL, 'erik89@example.net', '$2y$12$15pk5O8pX.dOYrCmiYQV1eXWby.aPBPaSkFXRWmuUiGC4gW1ikeEi', 'Jacquelyn', 'Keeling', NULL, '2001-05-20', 'Male', 'Ho Chi Minh', NULL, '41952 Spinka Skyway Apt. 306\nWandafort, IA 01806-4137', 'Volunteer', 'https://via.placeholder.com/200x200.png/0055cc?text=people+sed', 1, 1, NULL, NULL, 'cgnHKe4L72', NULL, NULL, NULL, NULL, '2025-12-04 16:29:55', '2025-12-04 16:29:55'),
(268, NULL, NULL, 'emmett.mraz@example.org', '$2y$12$WsLDsnIlF7VEKnBEyu8kOO8oO2Yt1PVYe7A3L6R/X.2YQFlG9VDy6', 'Helen', 'Wyman', '0937033914', NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008800?text=people+fuga', 1, 1, NULL, NULL, 'fgG6wuRfsi', NULL, NULL, NULL, NULL, '2025-12-04 16:29:55', '2025-12-04 16:29:55'),
(269, NULL, NULL, 'vkling@example.net', '$2y$12$Oy7otnacQ9uhcdIaegJbbOdHHi51deMH1qnKF/goXV68bYY7X1G.S', 'Caroline', 'D\'Amore', NULL, NULL, 'Male', 'Hanoi', 'West Freeman', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'XYePO7cBvW', NULL, NULL, NULL, NULL, '2025-12-04 16:29:55', '2025-12-04 16:29:55');
INSERT INTO `users` (`user_id`, `google_id`, `facebook_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `date_of_birth`, `gender`, `city`, `district`, `address`, `user_type`, `avatar_url`, `is_verified`, `is_active`, `last_login_at`, `last_activity_at`, `remember_token`, `verification_token`, `email_verified_at`, `reset_password_token`, `reset_password_token_expires_at`, `created_at`, `updated_at`) VALUES
(270, NULL, NULL, 'forrest.wunsch@example.com', '$2y$12$/p0krP50dCsHFR04Uh7TTuPf7rgfdITPRsKUfl6NP4VfUnFQsIcn.', 'Vicky', 'Bergnaum', '0996643354', '2006-03-13', 'Female', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-30 12:23:25', NULL, 'f7CBwXo8oK', NULL, NULL, NULL, NULL, '2025-12-04 16:29:56', '2025-12-04 16:29:56'),
(271, NULL, NULL, 'creola.brakus@example.net', '$2y$12$NgyAOxSLtSalyUEMmz9zT.c.IhFmkjtJJwuxRFT3R7gcrepq9pVUi', 'Constance', 'Prohaska', NULL, '1989-05-08', 'Female', 'Can Tho', 'West Leann', NULL, 'Volunteer', NULL, 1, 1, '2025-11-06 22:10:56', NULL, 'ql1sVZtlse', NULL, NULL, NULL, NULL, '2025-12-04 16:29:56', '2025-12-04 16:29:56'),
(272, NULL, NULL, 'grolfson@example.net', '$2y$12$jPrL47bXPzTrWk/DO9LZx.37.CO2XpvluD1TJ0SsEm3krzCLdkAjy', 'Emelia', 'Windler', NULL, '1983-07-13', 'Female', 'Hai Phong', NULL, '993 Casper Canyon Apt. 817\nNew Helmer, RI 93548-4516', 'Volunteer', NULL, 0, 1, '2025-11-20 16:42:04', NULL, '5XEKStsMhu', NULL, NULL, NULL, NULL, '2025-12-04 16:29:56', '2025-12-04 16:29:56'),
(273, NULL, NULL, 'will.moen@example.org', '$2y$12$QVWlylR0XS0henFRkSlH9OPHv/xXb9NFBnrTSMzA1ZIfNHCicnxc6', 'Justyn', 'Ernser', '0967504605', NULL, 'Male', 'Can Tho', 'Dickensshire', '10776 Okey Unions Suite 291\nNicolasside, UT 30557', 'Volunteer', NULL, 0, 1, NULL, NULL, 'gDGrKzhD28', NULL, NULL, NULL, NULL, '2025-12-04 16:29:56', '2025-12-04 16:29:56'),
(274, NULL, NULL, 'elsie.spencer@example.org', '$2y$12$B28LoCY26fvd.7mwThEcn.8yrQB4zM3f83x29KymyR/VQTjbif4.2', 'Nico', 'Carroll', NULL, NULL, 'Male', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-30 17:48:29', NULL, 'sCPim7D8Re', NULL, NULL, NULL, NULL, '2025-12-04 16:29:57', '2025-12-04 16:29:57'),
(275, NULL, NULL, 'grant.hayes@example.com', '$2y$12$Up.t17i6G8u8nOjCK7.rqOnt.bBkNH.sxshwjJ8nuADCb7o0VB1W6', 'Haskell', 'Brekke', '0954553085', NULL, 'Other', 'Hanoi', NULL, '1965 Walter Island\nNew Tiffanyton, DC 49850-0529', 'Volunteer', 'https://via.placeholder.com/200x200.png/005555?text=people+tempore', 1, 1, '2025-12-03 18:00:12', NULL, 'fk3jpWtif1', NULL, NULL, NULL, NULL, '2025-12-04 16:29:57', '2025-12-04 16:29:57'),
(276, NULL, NULL, 'kaitlin24@example.net', '$2y$12$Xd3DhXSaxlrH7Ue3QKr29eCw/sLV79KCh9rLd0e2w7C7pToMSlbfy', 'Max', 'Gislason', '0979741368', NULL, 'Female', 'Ho Chi Minh', NULL, '3658 Ocie Forges Apt. 000\nAdamstown, AL 99885', 'Volunteer', 'https://via.placeholder.com/200x200.png/0066dd?text=people+sunt', 1, 1, '2025-11-11 10:23:43', NULL, 'A64OCYhhpq', NULL, NULL, NULL, NULL, '2025-12-04 16:29:57', '2025-12-04 16:29:57'),
(277, NULL, NULL, 'hermann.ricky@example.com', '$2y$12$U5TFWiLw9mReNPtgUp4Z8eZXO.53HVRQT.tqeEYnCMGyQosqN282e', 'Mackenzie', 'Gulgowski', NULL, NULL, 'Other', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0011dd?text=people+est', 1, 1, '2025-12-02 05:23:52', NULL, 'IboAY4e474', NULL, NULL, NULL, NULL, '2025-12-04 16:29:57', '2025-12-04 16:29:57'),
(278, NULL, NULL, 'chris54@example.net', '$2y$12$dQSKaP1emakQNsUveaGz3eYvFGVE/mFCJNpqX.iFSNbI0DIY75.6m', 'Kacey', 'Weimann', NULL, '1981-09-16', 'Male', 'Hanoi', 'South Kara', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, '6n2FQWnAm4', NULL, NULL, NULL, NULL, '2025-12-04 16:29:58', '2025-12-04 16:29:58'),
(279, NULL, NULL, 'considine.amira@example.org', '$2y$12$pRxBsxZlFBO0ArSV95UKu.9AkizCh9AKY4gcEPhWRQIL0w6HVykJ.', 'Barry', 'Emmerich', '0937254666', NULL, 'Female', 'Da Nang', 'East Annabelleview', '639 Roderick Burg Apt. 668\nJazmynmouth, DE 63099', 'Volunteer', NULL, 1, 1, '2025-11-16 20:43:43', NULL, 'HQydFyPcA4', NULL, NULL, NULL, NULL, '2025-12-04 16:29:58', '2025-12-04 16:29:58'),
(280, NULL, NULL, 'ttillman@example.org', '$2y$12$/hPmNHUkVW7Yge7SkHkSUeFJOK4Ab0lHDUsdzzrx4cg5B2w/YJbSu', 'Beulah', 'Boehm', '0903674293', NULL, 'Female', 'Hanoi', 'North Madisyn', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/009955?text=people+voluptatem', 1, 1, '2025-12-02 05:37:39', NULL, '3ZGeLirzaT', NULL, NULL, NULL, NULL, '2025-12-04 16:29:58', '2025-12-04 16:29:58'),
(281, NULL, NULL, 'xsawayn@example.net', '$2y$12$DaCJ5jxsIjsK4ryxbuxL3e3vS6lqLFx9e0pXS4sdyGJD1I/CR2.XC', 'Alisha', 'Glover', '0976355940', NULL, 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000044?text=people+voluptas', 1, 1, '2025-11-25 07:32:45', NULL, 'wJPrCmK3D8', NULL, NULL, NULL, NULL, '2025-12-04 16:29:58', '2025-12-04 16:29:58'),
(282, NULL, NULL, 'vpadberg@example.org', '$2y$12$yHh4laOsU6Yuwvtnko2xwu9nnmm0ayDIq4xv3Hw.M/fkVoMdR7r.2', 'Jamir', 'Gusikowski', '0950536506', NULL, 'Female', 'Can Tho', 'Johannstad', '34310 Dexter Lodge Apt. 783\nTorpland, PA 90477', 'Volunteer', NULL, 1, 1, NULL, NULL, 'EumF4yXZ9V', NULL, NULL, NULL, NULL, '2025-12-04 16:29:59', '2025-12-04 16:29:59'),
(283, NULL, NULL, 'isabel74@example.org', '$2y$12$kjn8pzB7FQY2taK.7LFiFuL4Mdk0SRnHq98wFCLtmW.GbJna72UIS', 'Fred', 'Hermiston', NULL, '2001-05-25', 'Male', 'Hanoi', 'South Norbertburgh', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff77?text=people+magnam', 0, 1, NULL, NULL, 'g41iVR1JQg', NULL, NULL, NULL, NULL, '2025-12-04 16:29:59', '2025-12-04 16:29:59'),
(284, NULL, NULL, 'anderson.susanna@example.com', '$2y$12$vgZn5T9.Hyn3KSyLHxRTxOppSwAcYmHqCZRJnhBS7.NvoKU7WTjNC', 'Luisa', 'Anderson', NULL, '1972-01-28', 'Other', 'Da Nang', 'Jaycemouth', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'yaNIBpqjg9', NULL, NULL, NULL, NULL, '2025-12-04 16:29:59', '2025-12-04 16:29:59'),
(285, NULL, NULL, 'orn.dahlia@example.com', '$2y$12$ZI.CkiQQLuYUo.3g3fX41OOMsW4CrhiZsy29xc0xDLrxxSN7spHbq', 'Vito', 'Hilpert', '0991371509', '1973-09-29', 'Female', 'Da Nang', 'Lake Precious', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0077ee?text=people+fuga', 1, 1, '2025-11-25 11:56:27', NULL, 'EJGDHH5ybE', NULL, NULL, NULL, NULL, '2025-12-04 16:30:00', '2025-12-04 16:30:00'),
(286, NULL, NULL, 'qkris@example.com', '$2y$12$A5y.pSu5Gf9yA7iuz5MakOODqQD/k5.MrQ3o8IkddxLnjAOuNw652', 'Caitlyn', 'Donnelly', NULL, NULL, 'Male', 'Ho Chi Minh', 'New Vern', '8043 Feeney Corners Suite 651\nWest Rachaelmouth, DE 58643-6789', 'Volunteer', NULL, 1, 1, NULL, NULL, '9Eqz4hCGXb', NULL, NULL, NULL, NULL, '2025-12-04 16:30:00', '2025-12-04 16:30:00'),
(287, NULL, NULL, 'qborer@example.net', '$2y$12$/a8i5VsUeyAJ344.gz1wseeu3IsAHIVs2mOcDlH9.QBUOZb5u9UdC', 'Savanah', 'Metz', '0941159674', NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'aT7Kd4Vys3', NULL, NULL, NULL, NULL, '2025-12-04 16:30:00', '2025-12-04 16:30:00'),
(288, NULL, NULL, 'schuyler.greenholt@example.net', '$2y$12$sI3n2UDrvwSMg.xJ9cDI9.mkbpFBgV5F6brx6JFaItK0GDwYJbQ9W', 'Maximo', 'Konopelski', NULL, '2004-09-11', 'Other', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc33?text=people+voluptatibus', 0, 1, '2025-12-02 11:24:11', NULL, '2J6rp9kZbh', NULL, NULL, NULL, NULL, '2025-12-04 16:30:00', '2025-12-04 16:30:00'),
(289, NULL, NULL, 'nettie.simonis@example.org', '$2y$12$TJY3neBsif1oawnkpa1TL.TOllbgzPML9Z1..ldcwaZanDFjkhAhO', 'Rosalind', 'Koss', NULL, '1967-07-08', 'Female', 'Hanoi', 'Denesikbury', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'XqVnmWDQlt', NULL, NULL, NULL, NULL, '2025-12-04 16:30:01', '2025-12-04 16:30:01'),
(290, NULL, NULL, 'runolfsson.amelia@example.org', '$2y$12$masVLwn8vP43TlkmQHRce.EdwYjBpMSCZR0GyKdDep.65cU1zfi3y', 'Elmer', 'Johns', '0906638215', NULL, 'Other', 'Hanoi', NULL, '56364 Frank Trafficway\nJaymeshire, CA 77258', 'Volunteer', 'https://via.placeholder.com/200x200.png/00eeee?text=people+minus', 0, 1, '2025-11-21 07:46:38', NULL, 'ieVVsaSSMG', NULL, NULL, NULL, NULL, '2025-12-04 16:30:01', '2025-12-04 16:30:01'),
(291, NULL, NULL, 'fletcher.predovic@example.org', '$2y$12$9ue3nxxMyRv3o1EcKQOL1OzjFjnHh.7ERU9kh35K20K5LJq/li/dy', 'Greyson', 'Fisher', '0988150887', NULL, 'Female', 'Da Nang', NULL, '97982 Cole Isle Suite 185\nNew Wellingtonburgh, IL 19402', 'Volunteer', NULL, 0, 1, '2025-11-28 11:03:40', NULL, 'rjh8qXKcwp', NULL, NULL, NULL, NULL, '2025-12-04 16:30:01', '2025-12-04 16:30:01'),
(292, NULL, NULL, 'barney.upton@example.org', '$2y$12$rdTAPbej/ltG3vtwu9g4GOFd30ZmGH9nl2mH3HaDimfx5TOm3JeFq', 'Valentin', 'Keebler', '0982318693', NULL, 'Female', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff66?text=people+odio', 1, 1, NULL, NULL, 'nhRo7gp0tg', NULL, NULL, NULL, NULL, '2025-12-04 16:30:01', '2025-12-04 16:30:01'),
(293, NULL, NULL, 'brodriguez@example.com', '$2y$12$5v8TdhOPfMcSpeF7PPXOiuwYp1EH1E1MqCm4jCHEbwNWuRz4sU3pu', 'Judah', 'McGlynn', '0958813951', '1967-06-19', 'Other', 'Can Tho', 'Davinfort', '26175 Price Drives\nWolfchester, TN 20021', 'Volunteer', NULL, 1, 1, NULL, NULL, 'ZK7tWC68iS', NULL, NULL, NULL, NULL, '2025-12-04 16:30:02', '2025-12-04 16:30:02'),
(294, NULL, NULL, 'lwalker@example.com', '$2y$12$UdFwLnHjoSCX6uobhE6hLuqTnXmkK8gpVEcsx9zj4y8kU/l0JuOjm', 'Carolina', 'Hauck', '0930865818', NULL, 'Male', 'Ho Chi Minh', 'Jonestown', '9287 Buck Squares Suite 803\nNorth Vincent, NC 49560-4048', 'Volunteer', 'https://via.placeholder.com/200x200.png/007711?text=people+non', 1, 1, NULL, NULL, 'roKnZPk3As', NULL, NULL, NULL, NULL, '2025-12-04 16:30:02', '2025-12-04 16:30:02'),
(295, NULL, NULL, 'mgrady@example.net', '$2y$12$luSawmWtQASbo4KTb3EFG.U5T4pWWpAYwVSb.8m/cyV2O11rYi0sa', 'Annabelle', 'Stokes', '0930858182', '2005-04-02', 'Male', 'Ho Chi Minh', NULL, '613 Alexie Views Suite 911\nPort Estellaport, KS 22026-1904', 'Organization', NULL, 1, 1, NULL, NULL, 'gEmwI4eLkH', NULL, NULL, NULL, NULL, '2025-12-04 16:30:02', '2025-12-04 16:30:02'),
(296, NULL, NULL, 'gwest@example.net', '$2y$12$0k6/OCBe2yCgR.oFrWDJDOnSHWE8qeYCM8cGgDaLCGVj432v9KS5.', 'Newton', 'Legros', '0984908317', '1970-05-07', 'Male', 'Hai Phong', 'Port Bill', NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'baAFmS3yUH', NULL, NULL, NULL, NULL, '2025-12-04 16:30:02', '2025-12-04 16:30:02'),
(297, NULL, NULL, 'mohara@example.com', '$2y$12$3Hl.tPnqFRfhqBHrlOpNguINn9VqHKNrNL6LYicKIK.TPan7Xix1G', 'Julian', 'O\'Conner', '0989321890', '1975-07-07', 'Female', 'Da Nang', 'New Tiara', '580 Brad Squares Apt. 720\nLeslymouth, AR 90884', 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc33?text=people+molestiae', 1, 1, NULL, NULL, 'OqYwAKg9l9', NULL, NULL, NULL, NULL, '2025-12-04 16:30:03', '2025-12-04 16:30:03'),
(298, NULL, NULL, 'price.zaria@example.com', '$2y$12$0cw.x8Smvh2M9K.D6n4GqeOzJKM72hzcffCQHBO/UtqXQNShUuXfi', 'Jarrett', 'Predovic', NULL, NULL, 'Female', 'Hanoi', NULL, '548 Kendrick Neck\nBeauborough, IA 09092-3442', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa99?text=people+deserunt', 1, 1, '2025-11-11 07:57:29', NULL, 'XjufACxaSF', NULL, NULL, NULL, NULL, '2025-12-04 16:30:03', '2025-12-04 16:30:03'),
(299, NULL, NULL, 'sgrady@example.com', '$2y$12$JaV7VrZ833zZcQzbRBgn5OnEIAV6Yb3Omw54Py1eqzVmdpKhyghFa', 'Nona', 'Heidenreich', '0961072019', '1982-08-21', 'Other', 'Hanoi', 'North Eldredfurt', '672 Cummerata Estates Apt. 554\nPort Litzymouth, IN 41716-0853', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff55?text=people+temporibus', 1, 1, NULL, NULL, 'pVVQnBo9WC', NULL, NULL, NULL, NULL, '2025-12-04 16:30:03', '2025-12-04 16:30:03'),
(300, NULL, NULL, 'mpouros@example.org', '$2y$12$Q8nODN96NxQF7Oxrsg48EuzNQ72GNBOV4Z9YyOwd/pp6NfI2o64tS', 'Winnifred', 'Baumbach', NULL, NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-08 20:02:50', NULL, 'brp55uHDiX', NULL, NULL, NULL, NULL, '2025-12-04 16:30:03', '2025-12-04 16:30:03'),
(301, NULL, NULL, 'wiza.keenan@example.net', '$2y$12$VJYJfG843v8rT9IlygzJiewtg16JSmrQN/n5JB369kRep3v92kcOe', 'Brooke', 'Swift', NULL, '1999-10-07', 'Female', 'Da Nang', 'Kaleside', NULL, 'Volunteer', NULL, 1, 1, '2025-11-20 03:21:23', NULL, '9DFNxBK2pw', NULL, NULL, NULL, NULL, '2025-12-04 16:30:04', '2025-12-04 16:30:04'),
(302, NULL, NULL, 'may84@example.org', '$2y$12$018WciFu0uAAbTKHFy2G8OuS3ihJX9.3ybR9IzfDtkQaCqO9jj5OG', 'Luciano', 'Russel', NULL, NULL, 'Female', 'Ho Chi Minh', 'Toyberg', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffaa?text=people+odit', 1, 1, '2025-11-05 04:31:16', NULL, 'uqwoG3c86r', NULL, NULL, NULL, NULL, '2025-12-04 16:30:04', '2025-12-04 16:30:04'),
(303, NULL, NULL, 'bernie06@example.org', '$2y$12$rpoLwTE7cjx5nZWRyZq6xeRrEmVCzWcPs0qoGmykXsOt9rgfnACje', 'Lura', 'Durgan', '0903506111', NULL, 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0033ff?text=people+laborum', 1, 1, '2025-11-20 11:14:46', NULL, 'Ao0T3NknlG', NULL, NULL, NULL, NULL, '2025-12-04 16:30:04', '2025-12-04 16:30:04'),
(304, NULL, NULL, 'hallie.bauch@example.net', '$2y$12$/VdlAg1ZUUs5O3VOwm1U5.8H.9D7KqgjEXfjIDuHYC.iDvaiK9Z6q', 'Ardella', 'Treutel', NULL, '1989-04-27', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffaa?text=people+magni', 0, 1, NULL, NULL, 'LdW8CwFJ0s', NULL, NULL, NULL, NULL, '2025-12-04 16:30:05', '2025-12-04 16:30:05'),
(305, NULL, NULL, 'terence.wintheiser@example.net', '$2y$12$SDhAtmYbfGHaQRBNEvN91O/n3eJCdITMpmd4Cgdz31PtqCUfDxzEu', 'Arlo', 'Gaylord', '0992843533', NULL, 'Female', 'Da Nang', NULL, '33005 Joana Island Suite 005\nTerrychester, OR 67973-5544', 'Volunteer', NULL, 0, 1, NULL, NULL, 'lJDZF5e6Te', NULL, NULL, NULL, NULL, '2025-12-04 16:30:05', '2025-12-04 16:30:05'),
(306, NULL, NULL, 'shyanne.lesch@example.net', '$2y$12$aSXKzt8tgH5gWP42U2PALOS70bFP3kI/N.0MGyi3KScbAwQp15lpu', 'Alexanne', 'Abbott', '0902719539', NULL, 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00eeee?text=people+dicta', 1, 1, '2025-11-22 07:51:59', NULL, 'qcVoUZnO4O', NULL, NULL, NULL, NULL, '2025-12-04 16:30:05', '2025-12-04 16:30:05'),
(307, NULL, NULL, 'iparisian@example.com', '$2y$12$RYwCQBTt8f8N3ArTCeTEuebZZyuB15isHHGQ93W48YfXK7Cacxj7u', 'Madison', 'Hoppe', '0972710596', NULL, 'Male', 'Hanoi', 'Loyceland', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/007711?text=people+reprehenderit', 1, 1, '2025-11-20 05:03:11', NULL, 'pIVRdrVZGc', NULL, NULL, NULL, NULL, '2025-12-04 16:30:05', '2025-12-04 16:30:05'),
(308, NULL, NULL, 'francesco.bayer@example.net', '$2y$12$2W9FUlH.pi5OKe7sgfOheevnT6ujTJrxE0Iw4ZdGuYLCPwFhTqbtK', 'Jacquelyn', 'Emard', '0927683706', '1974-07-26', 'Other', 'Ho Chi Minh', 'Gloverbury', '63901 Lexie Ville Apt. 599\nOletahaven, CT 44473', 'Volunteer', 'https://via.placeholder.com/200x200.png/0055bb?text=people+possimus', 1, 1, NULL, NULL, 'aExFpS2Rwq', NULL, NULL, NULL, NULL, '2025-12-04 16:30:06', '2025-12-04 16:30:06'),
(309, NULL, NULL, 'dwatsica@example.com', '$2y$12$M9r/HuffagMHH92DnfoohuWGpxxySHmI/9dmJJ/UWY7xaUOzRiztq', 'Bernadette', 'Mohr', NULL, NULL, 'Male', 'Can Tho', NULL, '8716 Champlin Hill\nJaskolskifort, KY 80471', 'Volunteer', NULL, 1, 1, NULL, NULL, 's91w7ql93c', NULL, NULL, NULL, NULL, '2025-12-04 16:30:06', '2025-12-04 16:30:06'),
(310, NULL, NULL, 'batz.nasir@example.net', '$2y$12$9Zh45sy/731zJMXEd93rFOgP5OFaBRZi7rrH//m1znpvEVrobo1Gi', 'Sabrina', 'Rice', '0955056684', '1973-11-10', 'Other', 'Hai Phong', 'North Marilou', NULL, 'Volunteer', NULL, 0, 1, '2025-11-26 11:00:06', NULL, 'OTDJL4pHai', NULL, NULL, NULL, NULL, '2025-12-04 16:30:06', '2025-12-04 16:30:06'),
(311, NULL, NULL, 'alicia.bartell@example.com', '$2y$12$u1/fD9XJX2qRKZusykJcQeYjyXg3z9aE5oQ5IPYSpvE8zOtSb/3jW', 'Cynthia', 'Schaden', '0907889281', NULL, 'Female', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/001166?text=people+ad', 1, 1, NULL, NULL, 'vVq617VE9U', NULL, NULL, NULL, NULL, '2025-12-04 16:30:06', '2025-12-04 16:30:06'),
(312, NULL, NULL, 'roberts.alessia@example.org', '$2y$12$vo1xfrDYFB0y4OwA6O07MuYM3ImoYMynNvW0eXi3PSUWesNiKn4ZG', 'Chaya', 'Robel', '0953629622', '1969-10-01', 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'wzc9hj14s3', NULL, NULL, NULL, NULL, '2025-12-04 16:30:07', '2025-12-04 16:30:07'),
(313, NULL, NULL, 'mcglynn.kieran@example.net', '$2y$12$/MHZx4A2ZhirHw6T7suyoOGLhBOsQjfXSAz5/5Lk5rJz7YqBd4Y2O', 'Otis', 'Kertzmann', '0990324585', '1991-12-06', 'Male', 'Da Nang', 'Cassandraville', '729 Windler Expressway\nLake Jamie, IL 33786-8757', 'Volunteer', 'https://via.placeholder.com/200x200.png/0033ff?text=people+repellat', 1, 1, '2025-11-05 13:29:17', NULL, 'fBEUXE5r7A', NULL, NULL, NULL, NULL, '2025-12-04 16:30:07', '2025-12-04 16:30:07'),
(314, NULL, NULL, 'dewayne99@example.org', '$2y$12$J6Wn9LOb7ucfEBspDMQq2.jddUJbwEofMzp8DSqcB9jpM8nQV0auy', 'Abagail', 'Olson', '0984419642', NULL, 'Female', 'Hanoi', 'Lake Omer', '830 Feest Port\nChristopheland, WY 21722-3761', 'Volunteer', NULL, 0, 1, '2025-11-23 02:08:10', NULL, 'dvnh2FIRtE', NULL, NULL, NULL, NULL, '2025-12-04 16:30:07', '2025-12-04 16:30:07'),
(315, NULL, NULL, 'willow.mitchell@example.com', '$2y$12$11Dg2vv/3QkFfXkX6TYyXuyN0DIDu.Q1ssGxxS.93sUwzNUEWMFty', 'Kendrick', 'Gutmann', '0935643684', NULL, 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-20 00:04:53', NULL, 'PAPAL8OcLI', NULL, NULL, NULL, NULL, '2025-12-04 16:30:07', '2025-12-04 16:30:07'),
(316, NULL, NULL, 'antonio83@example.net', '$2y$12$WFkHXZurG4IqvXOZHaILQuPbwZZSMojnfgWBAbay2f.FdUSxpJm9q', 'Moriah', 'Hilpert', NULL, '1970-06-29', 'Female', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'HDNehL9FiY', NULL, NULL, NULL, NULL, '2025-12-04 16:30:08', '2025-12-04 16:30:08'),
(317, NULL, NULL, 'kaden.dicki@example.com', '$2y$12$AkS9Gy5bNcXUkrqPF2hq8.azjKBZIWd0CQWHYj.ebDTvYWEhkHp8K', 'Guy', 'Frami', '0903068291', NULL, 'Male', 'Hanoi', NULL, '736 Shane Springs Suite 132\nMohrshire, MD 98636-3760', 'Volunteer', 'https://via.placeholder.com/200x200.png/004444?text=people+quos', 1, 1, NULL, NULL, 'ntyynJiBJr', NULL, NULL, NULL, NULL, '2025-12-04 16:30:08', '2025-12-04 16:30:08'),
(318, NULL, NULL, 'sonny62@example.net', '$2y$12$vszJLhTvAlDTUT/A4ziAsOR3v.HX.bMBPAHHUYcybwCjHBOaBZqCO', 'Arvel', 'Torp', NULL, '1987-06-28', 'Other', 'Hanoi', NULL, '39880 Bridgette Fork\nSouth Corineview, MT 26664-9285', 'Volunteer', NULL, 0, 1, NULL, NULL, '4e4xX0234z', NULL, NULL, NULL, NULL, '2025-12-04 16:30:08', '2025-12-04 16:30:08'),
(319, NULL, NULL, 'dhamill@example.com', '$2y$12$0N2UEsG4QJ8corfDVqVTVuCm4A1ZIrY5W6kbznkHw.PRa8AVn9aXm', 'Quinton', 'Hansen', '0965456854', '1990-03-24', 'Female', 'Can Tho', 'Feilbury', '29497 Bernier Estates\nPort Shannonside, WV 48405-8666', 'Volunteer', NULL, 1, 1, NULL, NULL, 'B2EwII6KPR', NULL, NULL, NULL, NULL, '2025-12-04 16:30:08', '2025-12-04 16:30:08'),
(320, NULL, NULL, 'kristian86@example.net', '$2y$12$mg1s1GOtfRPfHdUOtGWzw.qDGnQZNuRDwA592np4/tMrOojHQ7sQ.', 'Makenna', 'Ullrich', NULL, '1986-12-23', 'Female', 'Can Tho', 'Trantowshire', '54292 Mitchell Centers\nJordonside, RI 85891', 'Volunteer', NULL, 1, 1, NULL, NULL, 'AtrUZNi2Ff', NULL, NULL, NULL, NULL, '2025-12-04 16:30:09', '2025-12-04 16:30:09'),
(321, NULL, NULL, 'bridget49@example.com', '$2y$12$mmqrnuK6JKUWE0c.Dde.WuEssAD0CiDDlO5nvzK4U0Oi2VCD/65Sq', 'Amie', 'Murray', '0937248045', NULL, 'Male', 'Da Nang', 'Strosinmouth', '6105 O\'Hara Rue Suite 166\nEast Turnermouth, NH 71363-0771', 'Volunteer', 'https://via.placeholder.com/200x200.png/002200?text=people+adipisci', 1, 1, '2025-12-03 18:20:41', NULL, 'Fhltv3NEt2', NULL, NULL, NULL, NULL, '2025-12-04 16:30:09', '2025-12-04 16:30:09'),
(322, NULL, NULL, 'edd.lueilwitz@example.com', '$2y$12$5/hHR7Fztoik.UPvzxEdHeBnlmFpXSboRwxfyxhqHAzDyTku/Nh8u', 'Weston', 'Becker', NULL, NULL, 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, '6H6DyMG6WW', NULL, NULL, NULL, NULL, '2025-12-04 16:30:09', '2025-12-04 16:30:09'),
(323, NULL, NULL, 'coby80@example.com', '$2y$12$NAICVhav.0llKjwz2BWTl.HgDJBAoahzTQEVSLww86cqiAFBmzQJ.', 'Jaron', 'Carroll', '0932358924', '2005-05-16', 'Female', 'Hanoi', NULL, '379 Daugherty Shoal Apt. 328\nNorth Sophieshire, MI 65565-3028', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff33?text=people+enim', 1, 1, NULL, NULL, 'ZlXW4uLQgq', NULL, NULL, NULL, NULL, '2025-12-04 16:30:10', '2025-12-04 16:30:10'),
(324, NULL, NULL, 'jerrold.roob@example.com', '$2y$12$4yizZt2EUihEzVo/.TN36.QpaG4suUdAdwcczNQGC55/1YHwGgs6W', 'Cleora', 'Rempel', NULL, NULL, 'Male', 'Can Tho', 'Jonathonbury', NULL, 'Organization', 'https://via.placeholder.com/200x200.png/00ff66?text=people+cupiditate', 0, 1, '2025-11-07 17:12:54', NULL, 'S2HLSzLAPi', NULL, NULL, NULL, NULL, '2025-12-04 16:30:10', '2025-12-04 16:30:10'),
(325, NULL, NULL, 'iglover@example.net', '$2y$12$jjwwVoKEPuqvFC0/1Q3CB.OTiwbBjNaeBs4q3.K8IqZ1Z9U9Q4Zz.', 'Halie', 'Brown', '0954653993', NULL, 'Female', 'Hanoi', 'Hettingerport', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0022aa?text=people+soluta', 1, 1, NULL, NULL, 'yyZD2N2h9U', NULL, NULL, NULL, NULL, '2025-12-04 16:30:10', '2025-12-04 16:30:10'),
(326, NULL, NULL, 'kkozey@example.org', '$2y$12$jZbPFAG27QgCO3lFu6YwC.QREHzTlRsgWcA0VhpJc5WGzEPnLkxuG', 'Jennie', 'Cole', '0908853851', NULL, 'Male', 'Da Nang', 'Lake Sidney', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000000?text=people+officia', 0, 1, NULL, NULL, 'QyZqT66Ihw', NULL, NULL, NULL, NULL, '2025-12-04 16:30:10', '2025-12-04 16:30:10'),
(327, NULL, NULL, 'coy.kutch@example.net', '$2y$12$5FUUidcKfNjaEaXj53//X.RrV59b1kU.bAcyMmwHYghZSxFv/4WBC', 'Teresa', 'McCullough', NULL, '1978-06-23', 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa88?text=people+fugiat', 1, 1, NULL, NULL, 'eiVjQ8tEXc', NULL, NULL, NULL, NULL, '2025-12-04 16:30:11', '2025-12-04 16:30:11'),
(328, NULL, NULL, 'odell.yost@example.net', '$2y$12$z13G577k8QirEonXyaWPC.AfVnsq5wwRTbzcAsPhgJ0LV8mnOZ9gq', 'Bart', 'Bode', NULL, NULL, 'Other', 'Hanoi', 'Baileyfort', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0099aa?text=people+nostrum', 1, 1, '2025-12-01 13:29:01', NULL, 'cSFEKiZOVf', NULL, NULL, NULL, NULL, '2025-12-04 16:30:11', '2025-12-04 16:30:11'),
(329, NULL, NULL, 'mhyatt@example.org', '$2y$12$VJ2seqT2FCzQaMbXvidI6e/Oe/FlKKe9skjegERPbALaeFGhYqxfe', 'Aurore', 'Huels', '0957973905', NULL, 'Male', 'Da Nang', 'New Jasenview', '311 Rocky Stream\nNorth Kristofferview, NC 13925', 'Volunteer', 'https://via.placeholder.com/200x200.png/003333?text=people+optio', 1, 1, NULL, NULL, 'f9WFpPsZmT', NULL, NULL, NULL, NULL, '2025-12-04 16:30:11', '2025-12-04 16:30:11'),
(330, NULL, NULL, 'brandi.stiedemann@example.com', '$2y$12$3eKyECoOC2JbSXMwgWpnWO/nAq0QEJQdt9s3h4hkVpJqHI9k0ShRu', 'Vesta', 'Mann', NULL, '2005-02-05', 'Other', 'Can Tho', NULL, '22363 Watsica Ways\nGilbertoville, AZ 15386', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aaee?text=people+nam', 1, 1, '2025-11-21 05:16:09', NULL, 'eSpCfbsLAr', NULL, NULL, NULL, NULL, '2025-12-04 16:30:11', '2025-12-04 16:30:11'),
(331, NULL, NULL, 'ydooley@example.org', '$2y$12$dBWDGn8s1Al5tH54exDGc.5gCH3Fe1B9O9/2roUJr7QYqq/mRFRqC', 'Evans', 'Rempel', '0947516521', '1999-06-04', 'Female', 'Hanoi', NULL, '610 O\'Connell Neck Suite 577\nMohrbury, TX 47493', 'Volunteer', NULL, 0, 1, '2025-12-03 20:31:28', NULL, 'w79TKc38OD', NULL, NULL, NULL, NULL, '2025-12-04 16:30:12', '2025-12-04 16:30:12'),
(332, NULL, NULL, 'vtowne@example.net', '$2y$12$jCV53b1tp51K6dotT/jxLuA8iLNiAzaCYDvYtvBOWsJ5Gd1yEqgc.', 'Tabitha', 'Heller', '0928009445', NULL, 'Female', 'Hai Phong', 'Abshireside', '195 Rolfson Garden\nJessyport, FL 10141-0836', 'Volunteer', NULL, 1, 1, '2025-11-12 21:20:28', NULL, 'DaeXJu0w7a', NULL, NULL, NULL, NULL, '2025-12-04 16:30:12', '2025-12-04 16:30:12'),
(333, NULL, NULL, 'gleason.shannon@example.net', '$2y$12$HwIMayA99ohXjPN4OSnWpuz3YYOFa2QGr2a7/BMnQ7zcpCdj.aKWa', 'Dejon', 'Abbott', NULL, '1968-03-25', 'Female', 'Hai Phong', NULL, '572 Robel Prairie Suite 507\nSouth Aglae, OR 94485-2875', 'Volunteer', 'https://via.placeholder.com/200x200.png/000088?text=people+rerum', 1, 1, '2025-11-18 10:54:03', NULL, '1UlSeR85Ca', NULL, NULL, NULL, NULL, '2025-12-04 16:30:12', '2025-12-04 16:30:12'),
(334, NULL, NULL, 'brandon49@example.net', '$2y$12$mLLu8ndyM8K4DDJ3EpuZ6.C6sjE6EOjpJeQ4yzq1V8hWopXjss182', 'Jannie', 'Fahey', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0033dd?text=people+similique', 1, 1, '2025-11-26 04:39:35', NULL, 'domPWQ3y1M', NULL, NULL, NULL, NULL, '2025-12-04 16:30:12', '2025-12-04 16:30:12'),
(335, NULL, NULL, 'laila.kohler@example.net', '$2y$12$foxijEUvyR7E58DVvkXes.WB8/czSvSEPXRfr30X/ssnotv.Gt5pu', 'Felicia', 'Schinner', '0951476664', '2006-05-26', 'Female', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, NULL, 'r9K6kvJ6JQ', NULL, NULL, NULL, NULL, '2025-12-04 16:30:13', '2025-12-04 16:30:13'),
(336, NULL, NULL, 'cdubuque@example.com', '$2y$12$Fm8e/NtCPKfDktlN7O/YeeiPdJVV8OQNEJoDU/XuHScT.Fyo3/xdq', 'Jaqueline', 'Sipes', '0938940088', '1980-09-08', 'Female', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-22 04:48:07', NULL, 'RL2JsGaWJL', NULL, NULL, NULL, NULL, '2025-12-04 16:30:13', '2025-12-04 16:30:13'),
(337, NULL, NULL, 'xdavis@example.org', '$2y$12$AfiFGppXJwxK6Q5RhRgAu.z5mHGgjX4UvN6AeWDstFFJNyIaQhGWe', 'Darron', 'Wolf', NULL, '1990-02-01', 'Male', 'Ho Chi Minh', 'O\'Connellmouth', '811 Dejah Knolls\nEast Maybelle, VA 65176', 'Volunteer', 'https://via.placeholder.com/200x200.png/002244?text=people+est', 1, 1, NULL, NULL, 'I70oqLoQtN', NULL, NULL, NULL, NULL, '2025-12-04 16:30:13', '2025-12-04 16:30:13'),
(338, NULL, NULL, 'elza.mante@example.net', '$2y$12$Fgv9nEVR/0cW.MGMri3SOuMFOdz09sZDGey75GpfzQihEBJhgc5BK', 'Sierra', 'Yundt', NULL, '1982-04-03', 'Female', 'Can Tho', 'Estellhaven', '3437 Camilla Point Suite 726\nDaughertybury, PA 55761', 'Volunteer', NULL, 0, 1, '2025-11-25 22:18:27', NULL, '2gWzBtLsNN', NULL, NULL, NULL, NULL, '2025-12-04 16:30:13', '2025-12-04 16:30:13'),
(339, NULL, NULL, 'ihettinger@example.com', '$2y$12$c5gbQspVmmxKN4yinSRlkO9BiDUR2XU2zbaxRYCIar6/Y06LHtoui', 'Scot', 'Howe', '0969453779', NULL, 'Male', 'Hanoi', 'Kuhicfurt', '263 Rogahn Roads\nWiltonton, VT 67562-3097', 'Volunteer', NULL, 0, 1, '2025-11-19 14:30:08', NULL, '3lDSaMw1bz', NULL, NULL, NULL, NULL, '2025-12-04 16:30:14', '2025-12-04 16:30:14'),
(340, NULL, NULL, 'elnora64@example.com', '$2y$12$tvgKnJMwLRiAHeni1B9gq.kp/B.d6TmjdBBc6rfl0cPWSSrKTdrou', 'Addison', 'Nicolas', '0912781162', '2001-09-24', 'Male', 'Ho Chi Minh', 'Port Reannastad', '2326 Novella Extension Apt. 404\nNew Amietown, VA 23473-3006', 'Volunteer', NULL, 1, 1, '2025-11-25 06:16:12', NULL, 'IDVVMir9CS', NULL, NULL, NULL, NULL, '2025-12-04 16:30:14', '2025-12-04 16:30:14'),
(341, NULL, NULL, 'karelle67@example.com', '$2y$12$ID38u.b8YhFBKU2e.Ispf.d0hW4yZIy5eSbxENZvp0R6m0BfTq9bi', 'Willie', 'Larkin', '0967932053', NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffee?text=people+eum', 0, 1, NULL, NULL, 'vLrwp0pNaJ', NULL, NULL, NULL, NULL, '2025-12-04 16:30:14', '2025-12-04 16:30:14'),
(342, NULL, NULL, 'hlittle@example.com', '$2y$12$.AZTxg8J7w/LcTMLBKZ5KeX.MOCiVbSH7XgtwOtAtieX3DvRdE3ZC', 'Carolina', 'Kihn', NULL, NULL, 'Other', 'Hai Phong', NULL, '982 Collier Estate\nFrederiqueville, SD 95706', 'Volunteer', NULL, 0, 1, NULL, NULL, 'rXrOQdT0ia', NULL, NULL, NULL, NULL, '2025-12-04 16:30:15', '2025-12-04 16:30:15'),
(343, NULL, NULL, 'tatum56@example.org', '$2y$12$cT1XEcJDpPXyp6acm08Kd.LI07IRHbEt8e8uhfsrSfJ050drKGCMy', 'Kraig', 'Runte', '0915149774', '1993-07-18', 'Female', 'Da Nang', 'South Tryciamouth', NULL, 'Volunteer', NULL, 1, 1, NULL, NULL, 'PxoEF7TUeF', NULL, NULL, NULL, NULL, '2025-12-04 16:30:15', '2025-12-04 16:30:15'),
(344, NULL, NULL, 'medhurst.tara@example.com', '$2y$12$FPiuoBHmMhdB3mprS6cDa.eBXmB5BAg/17tXymSOAHfcUxLMejDRW', 'Delta', 'Hand', '0970238740', NULL, 'Other', 'Hanoi', 'North Erlingmouth', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bbdd?text=people+qui', 1, 1, NULL, NULL, 'VlXtAWaj1l', NULL, NULL, NULL, NULL, '2025-12-04 16:30:15', '2025-12-04 16:30:15'),
(345, NULL, NULL, 'oberbrunner.hattie@example.org', '$2y$12$L.KerJgvnHxdeNzatpIiueni0shmfDkz3FGAZK2cqIFJs7.A/H1d2', 'Greyson', 'Adams', '0974786507', '1975-07-22', 'Female', 'Can Tho', NULL, '3103 Twila Run Apt. 938\nMacejkovicmouth, HI 53444-2988', 'Volunteer', NULL, 0, 1, '2025-11-06 08:04:20', NULL, 'JzSIzGaRaI', NULL, NULL, NULL, NULL, '2025-12-04 16:30:15', '2025-12-04 16:30:15'),
(346, NULL, NULL, 'ozella.torp@example.net', '$2y$12$Lc4mvlnN4yGIKpsCRUq0tuM4CY7LB3jh0yNqisFXPzIQz2erl0UmG', 'Manley', 'Kertzmann', '0980770605', '2002-09-10', 'Other', 'Ho Chi Minh', 'Maxwellton', '96480 Sven Hill Apt. 095\nLehnerborough, MD 35448-5461', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff99?text=people+doloremque', 0, 1, NULL, NULL, '0wLZb6TPNX', NULL, NULL, NULL, NULL, '2025-12-04 16:30:16', '2025-12-04 16:30:16'),
(347, NULL, NULL, 'dathoami2k5@gmail.com', '$2y$12$CFLUDsEuNVPgx9N4IHzw6u26h8sKN0h3ECFm.wDCfkTrLqLD1ETZm', 'Đạt', 'Hoàng Quang', NULL, NULL, NULL, NULL, NULL, NULL, 'Volunteer', 'https://lh3.googleusercontent.com/a/ACg8ocKEwMxwLDUag3LXXhKK6awhnEz6ctqtyIvEVdY5vnSnZJUExfI=s96-c', 1, 1, '2025-12-09 14:18:32', '2025-12-09 14:18:32', NULL, NULL, NULL, NULL, NULL, '2025-12-04 16:31:34', '2025-12-09 14:18:32'),
(349, NULL, NULL, 'duy442212@gmail.com', '$2y$12$Wf00oFC0zUbgXuxnCdg4l.EgccZK3pAWhnE0Bt8gpcHTDhzbyGzqi', 'HOa SON QUy', 'QBu', '0987123412', '2005-01-02', 'Female', 'Ho Chi Minh', 'Ha oi', 'akdhka', 'Volunteer', NULL, 0, 1, '2025-12-09 03:35:46', '2025-12-09 03:35:46', NULL, NULL, NULL, NULL, NULL, '2025-12-09 03:35:46', '2025-12-09 03:35:46'),
(350, NULL, NULL, '26a4040725@hvnh.edu.vn', '$2y$12$2F04sHxEtHRj1wNCD.6JVOgXRyxTHZmwe/Vx4VP2dB.b2UKQ5dxI2', 'ab', 'baciac', '0123456788', '2005-08-10', 'Female', 'Hai Phong', 'Đống Đa', 'acb', 'Volunteer', 'avatars/ZBZGa9MU4l30kBJe3E49Xa5k2Z8CwHiEpxNTpYv9.jpg', 1, 1, '2025-12-09 14:15:38', '2025-12-09 14:15:38', 'rJbenZCq1042SsmY3gA0WHlHhEXBbMdu7AyySLvqe2SwjOqTYGMt46HSFGXK', NULL, '2025-12-09 03:49:37', NULL, NULL, '2025-12-09 03:38:10', '2025-12-09 14:15:38');

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

--
-- Đang đổ dữ liệu cho bảng `video_calls`
--

INSERT INTO `video_calls` (`call_id`, `conversation_id`, `initiated_by`, `call_type`, `call_status`, `room_id`, `started_at`, `ended_at`, `duration`, `created_at`, `updated_at`) VALUES
(1, 21, 347, 'audio', 'ended', 'agora_2yaebmcCsP4sFKHR', NULL, '2025-12-09 14:22:27', 0, '2025-12-09 14:22:25', '2025-12-09 14:22:27'),
(2, 21, 347, 'audio', 'ended', 'agora_G7shCrFhi40JQ4Uh', NULL, '2025-12-09 14:23:34', 0, '2025-12-09 14:22:27', '2025-12-09 14:23:34'),
(3, 21, 350, 'audio', 'ended', 'agora_gzsPSW2FPpzLUFLv', NULL, '2025-12-09 14:23:35', 0, '2025-12-09 14:23:34', '2025-12-09 14:23:35'),
(4, 21, 350, 'audio', 'ended', 'agora_GIes9jhdEmKUNDX5', NULL, '2025-12-09 14:23:42', 0, '2025-12-09 14:23:35', '2025-12-09 14:23:42'),
(5, 21, 347, 'video', 'ended', 'agora_RKBWgBtTTiDEKgnc', NULL, '2025-12-09 14:23:56', 0, '2025-12-09 14:23:55', '2025-12-09 14:23:56'),
(6, 21, 347, 'video', 'ended', 'agora_ezDPwjxrmnsUMDSH', NULL, '2025-12-09 14:24:41', 0, '2025-12-09 14:23:56', '2025-12-09 14:24:41'),
(7, 21, 350, 'video', 'ended', 'agora_8hhfb3UOAEa5uCbq', NULL, '2025-12-09 14:24:42', 0, '2025-12-09 14:24:41', '2025-12-09 14:24:42'),
(8, 21, 350, 'video', 'ended', 'agora_nvXuIdTftBpTfCdn', NULL, '2025-12-09 14:24:57', 0, '2025-12-09 14:24:42', '2025-12-09 14:24:57'),
(9, 21, 347, 'video', 'ended', 'agora_LSuAJBssyiyZG74h', NULL, '2025-12-09 14:24:57', 0, '2025-12-09 14:24:57', '2025-12-09 14:24:57'),
(10, 21, 347, 'video', 'ended', 'agora_ypdIEQtxmxLCjOsi', NULL, '2025-12-09 14:27:02', 0, '2025-12-09 14:24:57', '2025-12-09 14:27:02'),
(11, 21, 350, 'audio', 'ended', 'agora_TcItVdOb6z9SprTj', NULL, '2025-12-09 14:27:53', 0, '2025-12-09 14:27:53', '2025-12-09 14:27:53'),
(12, 21, 350, 'audio', 'ended', 'agora_yQyJW1ClAT09SF8I', NULL, '2025-12-09 14:29:09', 0, '2025-12-09 14:27:53', '2025-12-09 14:29:09');

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

--
-- Đang đổ dữ liệu cho bảng `volunteer_activities`
--

INSERT INTO `volunteer_activities` (`activity_id`, `volunteer_id`, `opportunity_id`, `org_id`, `activity_date`, `hours_worked`, `activity_description`, `status`, `verified_by`, `verified_date`, `impact_notes`, `created_at`) VALUES
(1, 29, 48, 'org_6931b6cab1b30', '2025-11-18', 1.34, 'Est quo earum laboriosam perspiciatis qui officiis. Similique aut sed culpa non quo. Iure dolorem est ad quod. Recusandae esse officiis non odio rerum vel ut at.', 'Verified', 61, '2025-11-06 08:35:06', NULL, '2025-12-04 16:29:01'),
(2, 33, 73, 'org_6931b6cab6522', '2025-11-11', 7.55, 'Nostrum officiis dolores autem. Dolor velit non sunt asperiores. Cumque dignissimos placeat ut et quia.', 'Verified', 65, '2025-11-28 07:44:48', 'Similique totam aut adipisci quia ipsam eos sit.', '2025-12-04 16:29:01'),
(3, 33, 73, 'org_6931b6cab6522', '2025-11-16', 11.01, NULL, 'Verified', 65, '2025-11-17 03:58:52', NULL, '2025-12-04 16:29:01'),
(4, 33, 73, 'org_6931b6cab6522', '2025-11-15', 5.21, 'Tempore facilis consequatur rerum alias accusamus est. Sed debitis sequi itaque exercitationem rerum. Sit fugit pariatur sint et vel ipsam. Recusandae optio sed ea quisquam ea.', 'Verified', 65, '2025-11-09 03:55:10', NULL, '2025-12-04 16:29:01'),
(5, 33, 73, 'org_6931b6cab6522', '2025-10-18', 4.47, 'Consectetur qui quo voluptatibus magni mollitia. Laboriosam occaecati quaerat incidunt. Consequatur illum porro qui voluptatem pariatur et. Alias doloribus aut cumque ea aliquam non veritatis ipsa.', 'Verified', 65, '2025-12-01 09:30:58', NULL, '2025-12-04 16:29:01'),
(6, 33, 73, 'org_6931b6cab6522', '2025-11-16', 8.77, 'Quam asperiores beatae molestias molestias fuga magni porro. Omnis facere nesciunt quibusdam nisi at recusandae.', 'Verified', 65, '2025-12-04 06:02:03', NULL, '2025-12-04 16:29:01'),
(7, 35, 53, 'org_6931b6cab311e', '2025-10-28', 11.62, NULL, 'Verified', 62, '2025-12-04 11:27:47', 'Dicta cum rerum non eum consequatur dolor quo.', '2025-12-04 16:29:01'),
(8, 29, 59, 'org_6931b6cab450a', '2025-11-27', 5.29, 'Illo et corporis eos et. Dolor natus magnam debitis veritatis temporibus voluptas voluptatem eos. Itaque quia beatae suscipit ipsa voluptatem.', 'Verified', 63, '2025-11-16 05:03:40', NULL, '2025-12-04 16:29:01'),
(9, 29, 59, 'org_6931b6cab450a', '2025-10-17', 9.56, 'Nostrum magnam ea id dicta. Id unde dignissimos delectus. Fugit et sunt mollitia qui. Dicta provident minus reprehenderit nostrum.', 'Verified', 63, '2025-11-07 15:35:49', 'Quia assumenda consequatur accusamus nisi deleniti.', '2025-12-04 16:29:01'),
(10, 29, 59, 'org_6931b6cab450a', '2025-11-26', 7.86, NULL, 'Verified', 63, '2025-11-24 22:23:25', 'Voluptatem amet accusantium saepe illo tempora consequatur ut.', '2025-12-04 16:29:01'),
(11, 29, 59, 'org_6931b6cab450a', '2025-11-07', 6.59, NULL, 'Verified', 63, '2025-11-20 00:44:49', NULL, '2025-12-04 16:29:01'),
(12, 29, 59, 'org_6931b6cab450a', '2025-10-08', 7.18, NULL, 'Verified', 63, '2025-11-23 00:27:12', 'Reprehenderit quo doloremque maiores dignissimos autem iste.', '2025-12-04 16:29:01'),
(13, 2, 40, 'org_6931b6cab0b48', '2025-11-07', 10.43, 'Consequatur consequatur ipsum reprehenderit. Dignissimos aspernatur et qui qui laborum. Veritatis est non corrupti dolore dolorum dignissimos ea. Est omnis aperiam eveniet et et explicabo dolores. Officia ut qui veniam ut sequi voluptatibus nisi exercitationem.', 'Verified', 60, '2025-11-24 12:37:38', NULL, '2025-12-04 16:29:01'),
(14, 2, 40, 'org_6931b6cab0b48', '2025-11-08', 1.48, NULL, 'Verified', 60, '2025-12-01 09:52:58', 'Nisi consequuntur asperiores eos laboriosam.', '2025-12-04 16:29:01'),
(15, 15, 80, 'org_6931b6cab8454', '2025-10-16', 7.46, NULL, 'Verified', 67, '2025-11-09 15:32:54', 'Et quisquam recusandae eligendi numquam.', '2025-12-04 16:29:01'),
(16, 15, 80, 'org_6931b6cab8454', '2025-10-17', 7.85, 'Molestias perspiciatis et et earum numquam. Porro consequuntur et magni asperiores blanditiis earum ut.', 'Verified', 67, '2025-11-23 20:28:05', 'Ducimus non nihil consequatur non est.', '2025-12-04 16:29:01'),
(17, 42, 13, 'org_6931b6caaa704', '2025-10-31', 4.96, NULL, 'Verified', 54, '2025-11-19 22:54:55', 'Deleniti quo est temporibus magni.', '2025-12-04 16:29:01'),
(18, 42, 13, 'org_6931b6caaa704', '2025-11-29', 3.19, 'Id et incidunt esse. Repellendus rerum quasi quia voluptatem voluptas. Ullam aut id quod at hic tempore reiciendis. Delectus blanditiis quidem et aut omnis sint delectus.', 'Verified', 54, '2025-11-17 03:49:51', 'Libero velit eum voluptas porro.', '2025-12-04 16:29:01'),
(19, 42, 13, 'org_6931b6caaa704', '2025-11-01', 6.80, NULL, 'Verified', 54, '2025-11-18 11:31:14', 'Porro blanditiis id molestiae laborum.', '2025-12-04 16:29:01'),
(20, 42, 13, 'org_6931b6caaa704', '2025-11-28', 6.47, 'Expedita consectetur voluptates minima assumenda. Et fugit et voluptatum doloribus. Eum beatae voluptatem cupiditate distinctio voluptates cum magnam sint.', 'Verified', 54, '2025-12-03 09:04:43', NULL, '2025-12-04 16:29:01'),
(21, 11, 23, 'org_6931b6caad122', '2025-10-27', 4.56, 'Occaecati et et cum quia vero ratione. Et ut recusandae autem hic incidunt magni. Aut praesentium consequuntur nostrum. Error a recusandae eum nihil.', 'Verified', 56, '2025-11-30 12:30:35', NULL, '2025-12-04 16:29:01'),
(22, 11, 23, 'org_6931b6caad122', '2025-10-13', 6.39, NULL, 'Verified', 56, '2025-11-21 18:51:34', NULL, '2025-12-04 16:29:01'),
(23, 11, 23, 'org_6931b6caad122', '2025-10-15', 7.59, 'Eum facilis modi qui exercitationem voluptatem. Ut laudantium praesentium nam nam est debitis et quam. Accusantium eaque neque nesciunt sapiente commodi eligendi.', 'Verified', 56, '2025-11-05 14:19:36', 'Eligendi qui illo earum.', '2025-12-04 16:29:01'),
(24, 11, 23, 'org_6931b6caad122', '2025-10-18', 4.87, NULL, 'Verified', 56, '2025-11-14 02:48:53', NULL, '2025-12-04 16:29:01'),
(25, 45, 11, 'org_6931b6caa95f9', '2025-10-13', 3.04, NULL, 'Verified', 53, '2025-11-27 20:59:28', 'Ut reiciendis atque consequuntur placeat atque dolor est.', '2025-12-04 16:29:01'),
(26, 7, 61, 'org_6931b6cab450a', '2025-11-06', 10.57, NULL, 'Verified', 63, '2025-11-07 22:18:32', NULL, '2025-12-04 16:29:01'),
(27, 7, 61, 'org_6931b6cab450a', '2025-10-21', 6.29, 'Aut animi maxime odit similique rem soluta. Nihil officia libero minima pariatur consequuntur ullam. Omnis soluta sit laboriosam et aliquam. Ea voluptates earum id impedit harum nihil. Quaerat quis quod nam tenetur quasi.', 'Verified', 63, '2025-12-03 10:08:31', NULL, '2025-12-04 16:29:01'),
(28, 7, 61, 'org_6931b6cab450a', '2025-11-15', 11.42, 'Sequi quia itaque sit sunt praesentium autem. Dolorem perspiciatis provident quas. Dolorem officia iste voluptatum facere. Dignissimos consequuntur fuga est mollitia consectetur.', 'Verified', 63, '2025-11-27 01:01:04', 'Iure earum qui atque voluptatibus facere.', '2025-12-04 16:29:01'),
(29, 7, 61, 'org_6931b6cab450a', '2025-11-07', 2.01, 'Saepe reiciendis esse nesciunt est ratione. Aliquam laudantium voluptatem deleniti qui doloribus laudantium cumque. Tenetur modi et nihil iusto enim consequatur. Numquam assumenda ut beatae aut aut sit optio.', 'Verified', 63, '2025-11-13 19:47:25', 'Ipsam et unde labore.', '2025-12-04 16:29:01'),
(30, 7, 61, 'org_6931b6cab450a', '2025-11-25', 1.30, 'Optio impedit ab accusantium quo. Possimus velit ipsam iusto non libero. Repellendus esse nihil atque tenetur repellendus. Voluptatem a eligendi enim iusto illum exercitationem.', 'Verified', 63, '2025-11-29 18:51:32', NULL, '2025-12-04 16:29:01'),
(31, 11, 9, 'org_6931b6caa95f9', '2025-11-22', 8.87, NULL, 'Verified', 53, '2025-11-28 17:48:53', NULL, '2025-12-04 16:29:01'),
(32, 11, 9, 'org_6931b6caa95f9', '2025-11-25', 5.14, NULL, 'Verified', 53, '2025-11-20 22:13:38', NULL, '2025-12-04 16:29:01'),
(33, 34, 20, 'org_6931b6caad122', '2025-10-14', 3.82, 'Est et adipisci aliquid doloremque beatae quibusdam nesciunt doloremque. Sapiente quaerat consectetur molestiae corrupti praesentium. Quod aut dolorem itaque totam.', 'Verified', 56, '2025-11-11 21:40:40', NULL, '2025-12-04 16:29:01'),
(34, 34, 20, 'org_6931b6caad122', '2025-10-06', 4.78, NULL, 'Verified', 56, '2025-11-22 11:50:44', 'Delectus aspernatur vel est et.', '2025-12-04 16:29:01'),
(35, 34, 20, 'org_6931b6caad122', '2025-11-07', 10.29, NULL, 'Verified', 56, '2025-11-06 07:16:14', 'Ut et ipsam sed fugit voluptates ab dicta.', '2025-12-04 16:29:01'),
(36, 2, 44, 'org_6931b6cab1b30', '2025-11-23', 2.30, NULL, 'Verified', 61, '2025-12-02 08:01:34', 'Aliquam magnam impedit quis aliquid et maiores.', '2025-12-04 16:29:01'),
(37, 2, 44, 'org_6931b6cab1b30', '2025-10-24', 7.51, 'Vero rerum assumenda aut atque excepturi necessitatibus itaque. Corrupti sed voluptatem et deleniti. Et consequuntur et voluptas quis sit. Impedit iusto pariatur id quia nam aut non.', 'Verified', 61, '2025-11-16 15:53:08', 'Impedit asperiores numquam eos molestias rerum pariatur.', '2025-12-04 16:29:01'),
(38, 2, 44, 'org_6931b6cab1b30', '2025-10-23', 5.62, NULL, 'Verified', 61, '2025-11-11 01:58:42', NULL, '2025-12-04 16:29:01'),
(39, 2, 44, 'org_6931b6cab1b30', '2025-10-15', 2.80, NULL, 'Verified', 61, '2025-11-26 10:31:54', NULL, '2025-12-04 16:29:01'),
(40, 13, 48, 'org_6931b6cab1b30', '2025-10-06', 6.32, 'Perferendis aut quos asperiores esse. Quod nesciunt aliquid corrupti et doloribus. Molestiae velit qui maiores praesentium rerum delectus. Facilis nisi quo omnis sunt placeat officiis quam officia.', 'Verified', 61, '2025-11-13 13:47:30', 'Qui et aspernatur molestiae nisi.', '2025-12-04 16:29:01'),
(41, 13, 48, 'org_6931b6cab1b30', '2025-10-25', 5.64, NULL, 'Verified', 61, '2025-11-27 16:45:51', NULL, '2025-12-04 16:29:02'),
(42, 13, 48, 'org_6931b6cab1b30', '2025-10-12', 5.28, 'Distinctio numquam ea dolore rerum dolore. Sapiente voluptatem distinctio qui nulla inventore eum neque id. Sapiente consequatur dolorum ullam ut qui.', 'Verified', 61, '2025-11-12 13:51:12', 'Distinctio debitis quam sed deleniti ut sit mollitia.', '2025-12-04 16:29:02'),
(43, 29, 66, 'org_6931b6cab54a9', '2025-11-20', 11.55, NULL, 'Verified', 64, '2025-11-27 03:31:22', 'Perspiciatis quasi in ab doloribus eaque sit illo.', '2025-12-04 16:29:02'),
(44, 29, 66, 'org_6931b6cab54a9', '2025-11-21', 4.40, 'Quis omnis ab nam et et. Magnam tempora beatae voluptatem quibusdam in accusamus consequatur minima. Molestiae reprehenderit saepe sint et est. Pariatur occaecati vitae et consequatur dicta quibusdam aspernatur officiis.', 'Verified', 64, '2025-11-11 12:27:09', 'Aut dolorem maiores soluta aut doloremque dolor accusamus.', '2025-12-04 16:29:02'),
(45, 29, 66, 'org_6931b6cab54a9', '2025-11-26', 3.62, NULL, 'Verified', 64, '2025-11-12 19:14:32', 'Placeat et porro aperiam asperiores quibusdam ut est.', '2025-12-04 16:29:02'),
(46, 27, 26, 'org_6931b6caadeee', '2025-11-07', 8.07, 'Atque omnis voluptas doloremque ipsa. Aperiam dolor molestiae sed soluta iusto necessitatibus cum. Rerum blanditiis aut enim dolore. Possimus modi quis ut et.', 'Verified', 57, '2025-11-24 17:12:05', NULL, '2025-12-04 16:29:02'),
(47, 27, 26, 'org_6931b6caadeee', '2025-10-25', 1.86, 'Voluptas reprehenderit ex dolore maiores. Molestias est fuga facere dolores reiciendis suscipit. Qui consequatur ut et.', 'Verified', 57, '2025-11-07 16:32:59', 'Voluptas pariatur ex quia vero et molestias dolore.', '2025-12-04 16:29:02'),
(48, 27, 26, 'org_6931b6caadeee', '2025-11-16', 3.98, 'Occaecati harum rerum voluptatem ea quae aut. Sint voluptatum quod consequatur perferendis tenetur et. Quia reprehenderit quia facere quidem. Tempore facere atque et at officia reiciendis esse.', 'Verified', 57, '2025-11-14 06:38:30', 'Quia quis enim voluptatem dolor quis omnis.', '2025-12-04 16:29:02'),
(49, 27, 26, 'org_6931b6caadeee', '2025-10-14', 2.39, 'Cupiditate rerum sed magnam quis. Cum nam cupiditate aliquid sit non architecto quia. Expedita explicabo delectus aut ex.', 'Verified', 57, '2025-11-22 14:47:00', NULL, '2025-12-04 16:29:02'),
(50, 35, 91, 'org_6931b6caba232', '2025-10-15', 11.45, 'Nobis vel quidem ullam ut porro odio. Eos quaerat officiis non. Voluptas veritatis explicabo dolores natus.', 'Verified', 69, '2025-11-21 04:11:25', 'Eum omnis sunt nobis ut quia minus fugiat.', '2025-12-04 16:29:02'),
(51, 35, 91, 'org_6931b6caba232', '2025-10-14', 10.97, NULL, 'Verified', 69, '2025-11-24 10:35:52', 'Quod dolor et optio voluptate sint et.', '2025-12-04 16:29:02'),
(52, 35, 91, 'org_6931b6caba232', '2025-11-07', 5.35, NULL, 'Verified', 69, '2025-11-07 00:45:30', 'Vel repellat et sed architecto sint tenetur.', '2025-12-04 16:29:02'),
(53, 35, 91, 'org_6931b6caba232', '2025-10-10', 3.30, NULL, 'Verified', 69, '2025-11-29 03:52:23', NULL, '2025-12-04 16:29:02'),
(54, 42, 30, 'org_6931b6caaed02', '2025-11-03', 3.39, 'Voluptatem itaque molestias et nisi aut. In et dolore laborum quo sunt dignissimos. In quibusdam nihil est nesciunt dolores modi.', 'Verified', 58, '2025-11-07 17:11:35', NULL, '2025-12-04 16:29:02'),
(55, 42, 30, 'org_6931b6caaed02', '2025-10-13', 7.72, 'Occaecati quo suscipit vel molestiae accusamus maiores hic. Ipsam dolorem et ratione quo. Soluta et omnis qui ea. Sint et vitae ut et est quas beatae.', 'Verified', 58, '2025-11-06 06:24:50', 'Reiciendis repudiandae aliquam numquam dolores rem.', '2025-12-04 16:29:02'),
(56, 42, 30, 'org_6931b6caaed02', '2025-11-23', 11.41, NULL, 'Verified', 58, '2025-11-10 18:15:02', 'Eum qui vitae quae omnis non officia rerum.', '2025-12-04 16:29:02'),
(57, 42, 30, 'org_6931b6caaed02', '2025-10-06', 3.54, NULL, 'Verified', 58, '2025-11-18 21:41:59', NULL, '2025-12-04 16:29:02'),
(58, 7, 83, 'org_6931b6cab8454', '2025-10-25', 1.83, NULL, 'Verified', 67, '2025-11-17 21:17:39', 'Modi quae libero qui.', '2025-12-04 16:29:02'),
(59, 35, 3, 'org_6931b6caa86cf', '2025-10-14', 10.68, NULL, 'Verified', 52, '2025-11-12 13:47:14', NULL, '2025-12-04 16:29:02'),
(60, 35, 3, 'org_6931b6caa86cf', '2025-10-28', 2.66, NULL, 'Verified', 52, '2025-11-26 08:22:21', 'Voluptas quis a eum ut ab voluptates cumque.', '2025-12-04 16:29:02'),
(61, 35, 3, 'org_6931b6caa86cf', '2025-11-09', 10.61, NULL, 'Verified', 52, '2025-11-20 03:58:51', NULL, '2025-12-04 16:29:02'),
(62, 40, 36, 'org_6931b6caafd51', '2025-11-16', 10.43, 'Et qui provident quibusdam est quia. Sed reprehenderit unde consequuntur aperiam quaerat. In consequatur aperiam animi est animi. Amet culpa neque ut aut et reprehenderit eligendi est.', 'Verified', 59, '2025-11-26 02:05:17', 'Quisquam in eos nulla voluptatum enim quis.', '2025-12-04 16:29:02'),
(63, 6, 92, 'org_6931b6caba232', '2025-10-06', 5.98, 'Quis consequatur impedit ut. Tempora rerum incidunt quam voluptates culpa dolorem repudiandae rerum. Facere in similique quas voluptas nemo libero. Fugiat modi rem minus et quos omnis fuga.', 'Verified', 69, '2025-11-12 06:19:06', 'Odit et est consequatur exercitationem.', '2025-12-04 16:29:02'),
(64, 7, 78, 'org_6931b6cab74e0', '2025-11-30', 6.35, 'Fugit minima officia beatae corrupti. Consectetur dolorum molestiae sint ex. Deserunt repudiandae odio recusandae sed accusamus. Sit autem autem ullam voluptas quod esse natus.', 'Verified', 66, '2025-11-23 16:22:47', 'Atque et voluptatem a velit.', '2025-12-04 16:29:02'),
(65, 7, 78, 'org_6931b6cab74e0', '2025-10-12', 3.07, 'Voluptatem cupiditate suscipit illum cupiditate aut. Et culpa voluptas distinctio aperiam commodi non laudantium. Excepturi tenetur sint rerum reprehenderit architecto aut.', 'Verified', 66, '2025-11-12 22:11:44', 'Neque rerum facilis quo harum est sed id.', '2025-12-04 16:29:02'),
(66, 7, 78, 'org_6931b6cab74e0', '2025-11-30', 11.59, 'Odit praesentium minima rerum molestiae blanditiis. Consequatur rerum quo eligendi est hic nesciunt. Alias nihil modi sit aut aliquid eveniet quos. Mollitia unde ut consequatur magnam aut vitae et.', 'Verified', 66, '2025-11-30 01:44:24', 'Placeat quam eligendi repellendus ut consequatur.', '2025-12-04 16:29:02'),
(67, 7, 78, 'org_6931b6cab74e0', '2025-11-22', 9.60, 'Sit atque animi aliquid voluptatibus dicta aut. Voluptatem optio non enim neque non illo. Dolores quae maiores dolorum mollitia porro.', 'Verified', 66, '2025-11-18 01:59:14', 'Cumque et assumenda quia quisquam saepe iusto.', '2025-12-04 16:29:02'),
(68, 7, 78, 'org_6931b6cab74e0', '2025-10-07', 7.40, 'Dolores veritatis consectetur quia est voluptates. Explicabo labore animi laboriosam fuga accusamus excepturi ad officiis. Laboriosam suscipit voluptas occaecati ipsam inventore. Doloribus occaecati eum et ullam est.', 'Verified', 66, '2025-11-17 00:31:23', NULL, '2025-12-04 16:29:02'),
(69, 42, 88, 'org_6931b6cab92f0', '2025-11-09', 6.92, NULL, 'Verified', 68, '2025-11-28 20:47:22', NULL, '2025-12-04 16:29:02'),
(70, 42, 88, 'org_6931b6cab92f0', '2025-11-29', 1.97, NULL, 'Verified', 68, '2025-11-25 20:02:17', 'Nesciunt atque eius est eligendi consequatur fugit.', '2025-12-04 16:29:02'),
(71, 42, 88, 'org_6931b6cab92f0', '2025-11-05', 6.48, 'Optio possimus doloribus nisi nobis omnis accusantium. Et doloribus nesciunt eveniet ut. Consequatur aspernatur quia vero explicabo. Illo sit quae aliquid rem voluptates.', 'Verified', 68, '2025-11-23 10:28:38', NULL, '2025-12-04 16:29:02'),
(72, 42, 88, 'org_6931b6cab92f0', '2025-10-16', 9.20, NULL, 'Verified', 68, '2025-11-18 15:24:51', 'Consequatur et quas ratione voluptatem et.', '2025-12-04 16:29:02'),
(73, 42, 88, 'org_6931b6cab92f0', '2025-10-11', 7.98, NULL, 'Verified', 68, '2025-11-17 02:39:44', NULL, '2025-12-04 16:29:02'),
(74, 41, 59, 'org_6931b6cab450a', '2025-10-10', 9.69, NULL, 'Verified', 63, '2025-11-19 22:26:20', 'Qui in ut tempora omnis qui architecto cum laborum.', '2025-12-04 16:29:02'),
(75, 41, 59, 'org_6931b6cab450a', '2025-11-10', 8.72, 'Deserunt atque laborum beatae nostrum. Repellendus qui soluta aut quod nostrum vitae maiores. Est impedit ad dolore possimus minima est.', 'Verified', 63, '2025-11-17 01:55:44', NULL, '2025-12-04 16:29:02'),
(76, 41, 59, 'org_6931b6cab450a', '2025-10-29', 11.18, NULL, 'Verified', 63, '2025-12-03 08:00:37', 'Nemo sed placeat sunt voluptatem iure.', '2025-12-04 16:29:02'),
(77, 16, 95, 'org_6931b6caba232', '2025-10-15', 11.45, 'Dolore dicta perferendis sequi iusto dolorem dolores. Aliquid enim explicabo sint voluptate iste. In voluptas autem et omnis animi. Minus quos molestiae totam tenetur rerum.', 'Verified', 69, '2025-11-20 12:57:15', NULL, '2025-12-04 16:29:02'),
(78, 16, 95, 'org_6931b6caba232', '2025-10-12', 4.84, 'Adipisci vitae odio excepturi voluptate accusantium sed. Eos quibusdam ut aspernatur sapiente qui error.', 'Verified', 69, '2025-11-24 14:56:41', NULL, '2025-12-04 16:29:02'),
(79, 16, 95, 'org_6931b6caba232', '2025-11-27', 10.62, 'Quia rerum qui officia quibusdam sed. Quo assumenda sit aspernatur architecto nesciunt. Eligendi pariatur minus facilis cupiditate architecto impedit accusantium rem.', 'Verified', 69, '2025-11-18 15:00:26', NULL, '2025-12-04 16:29:02'),
(80, 16, 95, 'org_6931b6caba232', '2025-11-29', 9.23, NULL, 'Verified', 69, '2025-11-29 21:36:21', NULL, '2025-12-04 16:29:02'),
(81, 44, 24, 'org_6931b6caadeee', '2025-10-06', 5.56, NULL, 'Verified', 57, '2025-11-20 07:47:51', 'Sed dolorum inventore cum quia et.', '2025-12-04 16:29:02'),
(82, 44, 24, 'org_6931b6caadeee', '2025-10-29', 7.66, NULL, 'Verified', 57, '2025-11-10 23:25:12', NULL, '2025-12-04 16:29:02'),
(83, 44, 24, 'org_6931b6caadeee', '2025-11-16', 8.66, NULL, 'Verified', 57, '2025-11-23 16:14:10', NULL, '2025-12-04 16:29:02'),
(84, 44, 24, 'org_6931b6caadeee', '2025-11-30', 3.95, 'Sunt impedit mollitia reiciendis et libero impedit sequi. Pariatur quia necessitatibus ipsam veniam harum aperiam. Occaecati voluptatem similique sunt labore non dolorem unde ea. Eius quis fugit fuga deserunt nisi sed.', 'Verified', 57, '2025-11-29 19:29:26', 'Unde et eveniet quasi qui quas necessitatibus quasi.', '2025-12-04 16:29:02'),
(85, 24, 7, 'org_6931b6caa86cf', '2025-11-09', 6.17, NULL, 'Verified', 52, '2025-11-20 16:16:50', NULL, '2025-12-04 16:29:02'),
(86, 24, 7, 'org_6931b6caa86cf', '2025-10-28', 9.26, NULL, 'Verified', 52, '2025-11-24 21:23:28', NULL, '2025-12-04 16:29:02'),
(87, 20, 24, 'org_6931b6caadeee', '2025-10-15', 10.11, 'Accusamus aspernatur cupiditate sint aliquid nobis possimus sit. Et vel vero in.', 'Verified', 57, '2025-12-01 06:16:07', 'Sequi blanditiis nobis et qui accusamus.', '2025-12-04 16:29:02'),
(88, 20, 24, 'org_6931b6caadeee', '2025-11-27', 8.31, NULL, 'Verified', 57, '2025-11-25 13:55:19', 'Neque non quia eius rerum eos.', '2025-12-04 16:29:02'),
(89, 20, 24, 'org_6931b6caadeee', '2025-11-01', 11.00, NULL, 'Verified', 57, '2025-11-12 20:51:15', 'Libero dolorem harum consequatur commodi aut numquam voluptas.', '2025-12-04 16:29:02'),
(90, 36, 89, 'org_6931b6cab92f0', '2025-11-11', 5.68, 'Et ducimus pariatur aut similique. Vel quod velit autem nulla. Facere modi eveniet esse eius hic alias. Veniam officiis harum optio consectetur voluptate.', 'Verified', 68, '2025-11-14 14:25:17', 'Possimus et est qui nostrum aut recusandae.', '2025-12-04 16:29:02'),
(91, 36, 89, 'org_6931b6cab92f0', '2025-11-13', 4.09, NULL, 'Verified', 68, '2025-11-29 08:48:52', 'Quia rem velit et soluta.', '2025-12-04 16:29:02'),
(92, 36, 89, 'org_6931b6cab92f0', '2025-11-05', 4.24, NULL, 'Verified', 68, '2025-11-12 07:01:54', NULL, '2025-12-04 16:29:02'),
(93, 36, 89, 'org_6931b6cab92f0', '2025-10-10', 10.52, NULL, 'Verified', 68, '2025-11-22 02:04:17', 'Ut enim nemo sed.', '2025-12-04 16:29:02'),
(94, 12, 4, 'org_6931b6caa86cf', '2025-11-03', 8.65, 'Et ut veritatis incidunt praesentium non porro dolores minus. Officiis repellat debitis dolor. Illo quas eos enim quo vel officia qui itaque. Aut iste ullam aut autem nihil fuga.', 'Verified', 52, '2025-11-06 18:49:01', NULL, '2025-12-04 16:29:02'),
(95, 36, 3, 'org_6931b6caa86cf', '2025-11-19', 10.22, NULL, 'Verified', 52, '2025-11-16 08:52:24', NULL, '2025-12-04 16:29:02'),
(96, 29, 53, 'org_6931b6cab311e', '2025-10-17', 8.38, NULL, 'Verified', 62, '2025-11-19 14:39:06', NULL, '2025-12-04 16:29:02'),
(97, 29, 53, 'org_6931b6cab311e', '2025-11-05', 9.32, NULL, 'Verified', 62, '2025-11-20 20:04:35', NULL, '2025-12-04 16:29:02'),
(98, 29, 53, 'org_6931b6cab311e', '2025-11-14', 11.36, 'Et ipsum itaque amet dolorum est. Sit dolores ipsum temporibus quia odio qui velit facilis. Excepturi nemo voluptas velit nam ratione est.', 'Verified', 62, '2025-11-26 17:14:21', 'Consequatur quia maxime deserunt est.', '2025-12-04 16:29:02'),
(99, 48, 81, 'org_6931b6cab8454', '2025-10-26', 3.12, 'Error ipsa qui ea. Et at distinctio dolorem optio. Consequatur sit quas totam quos. Sequi et doloremque est deleniti. Deleniti dolorem eos dicta.', 'Verified', 67, '2025-11-22 20:05:13', NULL, '2025-12-04 16:29:02'),
(100, 48, 81, 'org_6931b6cab8454', '2025-11-02', 1.05, NULL, 'Verified', 67, '2025-11-07 02:36:59', 'Accusantium id nihil quibusdam aliquid velit.', '2025-12-04 16:29:02'),
(101, 48, 81, 'org_6931b6cab8454', '2025-11-16', 8.84, NULL, 'Verified', 67, '2025-11-05 10:57:02', NULL, '2025-12-04 16:29:02'),
(102, 48, 81, 'org_6931b6cab8454', '2025-10-30', 9.78, 'Quia modi qui sit consequuntur velit. Perspiciatis ullam voluptatibus et velit officia odio distinctio excepturi. Eius nulla autem exercitationem delectus. Magni consequatur sed excepturi totam aliquid enim. Voluptas ea aspernatur quis.', 'Verified', 67, '2025-11-08 04:37:25', NULL, '2025-12-04 16:29:02'),
(103, 48, 81, 'org_6931b6cab8454', '2025-11-11', 8.12, 'Nostrum sit illum omnis at iusto minima sunt sed. Magnam incidunt laborum velit. Aliquid eos ut ut qui vero. Exercitationem iusto sunt voluptatem. Est est enim repellendus aut voluptas unde sequi.', 'Verified', 67, '2025-11-05 06:41:52', 'Molestias tenetur aliquam sint minima.', '2025-12-04 16:29:02'),
(104, 47, 80, 'org_6931b6cab8454', '2025-11-13', 3.53, NULL, 'Verified', 67, '2025-11-26 11:21:02', 'Soluta dolores possimus asperiores dicta voluptatibus molestiae.', '2025-12-04 16:29:02'),
(105, 30, 98, 'org_6931b6cabb2c3', '2025-10-06', 10.52, NULL, 'Verified', 70, '2025-11-07 15:00:45', 'Ut autem officia minus iusto possimus.', '2025-12-04 16:29:02'),
(106, 30, 98, 'org_6931b6cabb2c3', '2025-11-18', 11.57, 'Placeat neque vero enim iure. Iusto nesciunt qui impedit odio laboriosam libero praesentium. Facere unde vel aut dolorem consectetur fugit quos dolores. Omnis cupiditate dolorem rerum placeat voluptates sunt architecto eaque.', 'Verified', 70, '2025-11-08 23:20:36', NULL, '2025-12-04 16:29:02'),
(107, 30, 98, 'org_6931b6cabb2c3', '2025-12-01', 9.81, NULL, 'Verified', 70, '2025-11-15 11:18:28', NULL, '2025-12-04 16:29:02'),
(108, 30, 98, 'org_6931b6cabb2c3', '2025-11-16', 7.83, NULL, 'Verified', 70, '2025-11-16 21:56:51', NULL, '2025-12-04 16:29:02'),
(109, 30, 98, 'org_6931b6cabb2c3', '2025-10-16', 7.26, 'Impedit et sint quis blanditiis qui aliquid soluta. Ut est suscipit distinctio ut ut quibusdam. Quia eligendi incidunt ut sapiente perferendis. Dolores repellendus eligendi est facere et ducimus.', 'Verified', 70, '2025-11-04 22:13:46', 'Numquam amet at ea in corrupti possimus.', '2025-12-04 16:29:02'),
(110, 43, 76, 'org_6931b6cab74e0', '2025-10-06', 10.28, 'Et vel perferendis sapiente dolorem minima deleniti quia cum. Officia maiores vero fuga omnis eveniet molestias incidunt sed. Commodi corrupti et veritatis commodi asperiores sint id. Voluptatum possimus aut et quis dolorem veniam consequatur.', 'Verified', 66, '2025-11-06 06:44:08', NULL, '2025-12-04 16:29:02'),
(111, 43, 76, 'org_6931b6cab74e0', '2025-10-20', 5.88, 'Consequatur ullam esse a exercitationem quasi delectus nobis. Natus dignissimos voluptate cumque quos molestiae. Quo quis reprehenderit iure quos. Pariatur necessitatibus earum ipsum blanditiis consequuntur sit ab.', 'Verified', 66, '2025-12-03 12:06:34', 'Quia laboriosam officiis quaerat velit qui.', '2025-12-04 16:29:02'),
(112, 43, 76, 'org_6931b6cab74e0', '2025-11-15', 5.39, 'Quia nemo voluptate aspernatur necessitatibus soluta quod quo. Deserunt ut repellat dolor aut consequatur ut rem. Et nisi magnam voluptatibus minima occaecati aut. Ipsum dolores aliquid iure sed quo rerum.', 'Verified', 66, '2025-11-09 16:47:48', NULL, '2025-12-04 16:29:02'),
(113, 350, 109, 'org_6931b70aa30d6', '2025-12-05', 4.50, 'Tôi chăm sóc Hoa Sơn Quý', 'Pending', NULL, NULL, NULL, '2025-12-09 07:32:14');

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

--
-- Đang đổ dữ liệu cho bảng `volunteer_opportunities`
--

INSERT INTO `volunteer_opportunities` (`opportunity_id`, `org_id`, `category_id`, `title`, `description`, `requirements`, `benefits`, `location`, `latitude`, `longitude`, `start_date`, `end_date`, `time_commitment`, `schedule_type`, `volunteers_needed`, `volunteers_registered`, `min_age`, `required_skills`, `experience_needed`, `status`, `application_deadline`, `view_count`, `application_count`, `created_at`, `updated_at`) VALUES
(1, 'org_6931b6caa86cf', 5, 'Recusandae rerum aut quas possimus officiis.', 'Commodi officiis animi velit quia. Laboriosam est porro aut est. Sunt quia reiciendis molestiae recusandae. Similique et voluptatem ut omnis commodi optio quis. Eius dignissimos doloribus quia rem quis numquam. Et ut veritatis non et. Ipsum quis quam quos sed.', 'Dolores nihil est et. Qui molestiae alias architecto repellendus veniam aliquam.', NULL, 'Da Nang, 511 Schiller Ridges Suite 682', 16.27840000, 106.67135100, '2025-12-08', NULL, 'Full day', 'Flexible', 7, 2, 18, '[\"Programming\"]', 'Experienced', 'Cancelled', '2025-12-06', 254, 32, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(2, 'org_6931b6caa86cf', 5, 'Totam harum totam perspiciatis omnis in.', 'Placeat mollitia omnis perspiciatis sunt quo consequatur. Accusantium culpa eaque ut delectus provident. Sit id molestiae maiores error. Quasi iusto sunt maxime nulla ex. Maiores distinctio omnis non recusandae voluptatem corporis magnam.', 'Soluta fugit debitis aut et. Quia unde odio non ex corporis illo.', NULL, 'Can Tho, 57193 Elmira Brook Apt. 884', 9.95751300, 105.87720400, '2026-01-23', NULL, '3-5 hours', 'Monthly', 1, 4, 16, '[\"Programming\",\"First Aid\"]', 'Some experience', 'Paused', NULL, 498, 48, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(3, 'org_6931b6caa86cf', 6, 'Sed est aperiam quasi explicabo velit asperiores.', 'Veniam dolor assumenda voluptatibus qui. Rerum deserunt assumenda explicabo perferendis. Natus id et laboriosam. Sed voluptatibus laboriosam aut harum. Illo qui dolor non quaerat quas. Quasi tenetur necessitatibus saepe minima fuga earum. Dolorum voluptatum nobis porro vel.', NULL, NULL, 'Hanoi, 308 Amari Road Apt. 558', 17.38565400, 108.92973900, '2026-01-12', '2026-03-04', '6-8 hours', 'One-time', 18, 5, 18, '[\"First Aid\"]', 'No experience', 'Paused', '2025-12-10', 84, 36, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(4, 'org_6931b6caa86cf', 3, 'Consequatur distinctio illo voluptates.', 'Sunt autem vel deserunt totam. Omnis quia tenetur exercitationem iste cupiditate eum qui omnis. Labore aliquid quae soluta quisquam officia nam excepturi. Esse recusandae aut enim velit eius beatae enim. Quos omnis libero ut quidem quas. Enim illum voluptas adipisci fuga a maiores qui.', 'Et saepe sed deserunt sit dolor sit. Deserunt provident omnis quo explicabo doloribus autem. Ad possimus et libero deserunt consequuntur.', NULL, 'Da Nang, 50079 Scot Ridges', 11.31028300, 102.68541700, '2026-01-27', NULL, 'Full day', 'Monthly', 15, 3, 21, '[\"Cooking\",\"Marketing\"]', 'Some experience', 'Paused', NULL, 263, 49, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(5, 'org_6931b6caa86cf', 3, 'Eum amet et quibusdam inventore a et eos ducimus.', 'Qui adipisci sit corporis molestiae. Error molestias at perferendis velit. Necessitatibus tenetur culpa tenetur sed. Sed libero similique dolores quis quod placeat. Iusto dolorem odio vel a.', 'Quo impedit illo ex officiis. Cum omnis eum enim assumenda. Aliquam autem pariatur dolores dicta perspiciatis.', 'Voluptatum consequatur ipsam hic ut ducimus eum. Aut tempora dolor ratione et.', 'Can Tho, 3913 Roman Cliff', 20.03648800, 102.89587900, '2025-12-18', '2026-01-11', 'Full day', 'Flexible', 7, 5, 16, '[\"First Aid\"]', 'No experience', 'Cancelled', NULL, 157, 32, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(6, 'org_6931b6caa86cf', 5, 'Hic exercitationem nisi et.', 'Tempora dolor autem praesentium atque. Similique placeat rerum ad sed voluptatum. Incidunt doloremque aperiam aut praesentium eum in cupiditate. Rerum et itaque et nesciunt enim omnis. Blanditiis ratione dicta aut quis odio. Asperiores eaque fugiat quo illum ab incidunt. Odit molestias eos aut ut itaque quam odio.', 'Dicta veniam fugiat iste. Eveniet velit est corporis beatae. Autem sint quia ut aliquam velit illum saepe.', 'Quia natus et ipsum occaecati molestiae debitis. Et omnis voluptatem rerum repudiandae dolorum eligendi. Et voluptatem illo dolor enim.', 'Can Tho, 58082 Collin Park Apt. 324', 19.87484600, 105.59270800, '2025-12-26', NULL, '3-5 hours', 'Monthly', 6, 5, 16, '[\"Programming\",\"Translation\",\"Marketing\",\"Teaching\"]', 'No experience', 'Active', NULL, 178, 7, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(7, 'org_6931b6caa86cf', 7, 'Qui odio sit fugit voluptatem nisi laudantium soluta perferendis.', 'Cumque reiciendis ipsum corporis est. Quia doloremque sunt at. Et et laboriosam non et. Et cupiditate veritatis debitis aut est maiores sit. Est occaecati nemo qui aperiam dicta voluptas.', 'Eligendi libero odit asperiores. Natus neque qui alias repellendus cumque.', NULL, 'Can Tho, 99496 Dickens Dam Apt. 170', 15.90856700, 109.21543000, '2026-01-16', '2026-01-23', '6-8 hours', 'Monthly', 14, 3, 16, '[\"Programming\",\"Writing\",\"Photography\",\"First Aid\"]', 'Some experience', 'Cancelled', NULL, 169, 13, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(8, 'org_6931b6caa95f9', 4, 'Ea sapiente quos nihil dolore illum.', 'Saepe beatae ipsam aut consequatur aspernatur. Accusantium perspiciatis doloremque placeat fuga ut alias incidunt. Et aspernatur eligendi sunt qui. Praesentium sit minima sed et aspernatur ipsam. Ea nihil minima eum fugit molestias dicta.', NULL, 'Quisquam quia cum reiciendis saepe dolore ut unde. Veniam id suscipit repellendus ipsa blanditiis est iusto.', 'Hai Phong, 21543 Abraham Springs Apt. 208', 16.51070400, 106.12121200, '2025-12-30', '2026-02-12', '1-2 hours', 'Monthly', 20, 2, 16, '[\"First Aid\"]', 'Some experience', 'Active', '2025-12-21', 81, 11, '2025-12-04 16:28:58', '2025-12-09 06:43:18'),
(9, 'org_6931b6caa95f9', 4, 'Non eos vel tempore perferendis.', 'Eligendi saepe ducimus omnis magnam earum dolore. Id et recusandae voluptatem occaecati. Officia et natus sed ut. Dolor a ut commodi et illum numquam.', NULL, 'Temporibus quae incidunt et totam non. Qui repudiandae consequuntur animi ex eos. Iste alias magni illo quibusdam vero.', 'Hanoi, 990 Akeem Trace Apt. 412', 10.82446600, 107.42598100, '2025-12-21', NULL, '6-8 hours', 'Flexible', 9, 2, 21, '[\"Cooking\"]', 'Some experience', 'Cancelled', NULL, 392, 40, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(10, 'org_6931b6caa95f9', 5, 'Atque non sit ducimus pariatur.', 'Minima voluptate excepturi eum eum. Quo in recusandae ut corrupti in odio non nisi. Quibusdam perferendis assumenda dolor ad quam. Sed quia ut quaerat ad totam deserunt nam. Et numquam explicabo et necessitatibus.', NULL, 'Eveniet ea consequatur et impedit quo. Dolorem voluptatum dolore ut recusandae id harum magnam nobis. Vitae et velit minima veritatis a nisi.', 'Ho Chi Minh City, 297 Bettie Heights Apt. 490', 18.36751400, 103.84767200, '2025-12-27', '2026-02-07', '3-5 hours', 'Monthly', 1, 0, 21, '[\"Cooking\",\"Teaching\"]', 'Experienced', 'Active', '2025-12-09', 96, 34, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(11, 'org_6931b6caa95f9', 4, 'Ipsa laborum aliquam ratione itaque.', 'Provident rerum asperiores reiciendis ut qui incidunt sunt. Veniam veniam mollitia impedit. Et sed blanditiis et. Perferendis sed nihil iste occaecati dolor laudantium. Ipsa omnis numquam ea pariatur rem doloribus et unde. Cumque inventore dolorum ut alias autem. Et ea optio molestiae in.', 'Sed et nam commodi repellat earum ut. Voluptatum aut laborum totam sit eius voluptas. Illo eos esse qui qui.', NULL, 'Hanoi, 2993 Carlo Key Apt. 335', 13.96979700, 108.31640300, '2026-01-15', NULL, 'Full day', 'One-time', 5, 5, 16, '[\"Photography\",\"Design\"]', 'No experience', 'Paused', NULL, 57, 38, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(12, 'org_6931b6caaa704', 4, 'Est qui molestias architecto facere quae provident consequuntur placeat.', 'Veritatis qui ad impedit atque sit. Aut non atque et ipsa sed libero. Perspiciatis est vel deleniti. Voluptatem aspernatur dolorem ad libero architecto.', 'Occaecati et qui occaecati error. Qui illum id facere sint.', NULL, 'Can Tho, 239 Macejkovic Coves Suite 606', 14.99426200, 108.58865300, '2026-01-23', '2026-03-02', 'Multiple days', 'Weekly', 6, 1, 16, '[\"Photography\",\"Writing\",\"First Aid\"]', 'Experienced', 'Paused', NULL, 319, 7, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(13, 'org_6931b6caaa704', 7, 'Optio excepturi sit doloremque dignissimos cumque illo impedit.', 'Non repellat autem amet et et. Nihil dolores praesentium magni perspiciatis perspiciatis qui. Harum enim incidunt debitis itaque beatae voluptatem. Rerum dolorem dolorum rerum quidem est quasi blanditiis. Sit unde harum repellendus libero sed vero.', 'Accusamus assumenda omnis rerum saepe incidunt quisquam doloribus eius. Ex rerum architecto sit quo repellat fugit. Rerum quis voluptatum est quam quae.', 'Totam dolores iusto harum soluta eius id ipsam. Earum velit consequatur id aliquam autem. Et qui quisquam natus asperiores quo vel.', 'Ho Chi Minh City, 5342 Jannie Knolls', 17.69176800, 108.23874400, '2025-12-13', NULL, '3-5 hours', 'Monthly', 10, 1, 18, '[\"Cooking\"]', 'Experienced', 'Active', NULL, 253, 27, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(14, 'org_6931b6caaa704', 4, 'Dignissimos numquam id porro aut.', 'Ipsa provident perferendis quia cupiditate asperiores sint. Est officia quia quia illo error. Aut aut expedita voluptatibus eligendi. Placeat aut omnis dolorem quidem dolorem. Qui sunt temporibus ex saepe voluptas. Dolore quis impedit suscipit est. Dolor nisi quibusdam quia tenetur.', NULL, NULL, 'Hai Phong, 2380 Octavia Hills', 9.79427200, 108.40248000, '2026-01-25', NULL, '6-8 hours', 'Flexible', 20, 5, 21, '[\"Marketing\",\"Translation\",\"Cooking\"]', 'Some experience', 'Cancelled', '2026-01-14', 65, 42, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(15, 'org_6931b6caaa704', 2, 'Debitis doloribus eligendi qui quidem nostrum qui enim dolores.', 'Quibusdam quia rerum voluptatum explicabo. Quaerat veniam et magni pariatur dolorum. Est officia aut mollitia ad. Consequatur cupiditate rerum occaecati. Cumque libero quia itaque temporibus.', NULL, NULL, 'Hai Phong, 123 Lubowitz Springs', 14.91585800, 107.64297300, '2026-01-31', '2026-02-08', '1-2 hours', 'Weekly', 20, 3, 18, '[\"Programming\",\"First Aid\",\"Photography\"]', 'No experience', 'Paused', '2026-01-20', 445, 4, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(16, 'org_6931b6caac3ae', 8, 'Nobis ut qui minima nobis eveniet.', 'Dicta consequatur eum quae blanditiis dolorem natus. Doloremque inventore temporibus a a. Laudantium aut ab consectetur occaecati impedit eaque. Autem eius dolor et ut ipsum totam et.', NULL, 'Et magnam in molestiae nesciunt molestias est omnis. Possimus ut alias saepe molestiae earum aut cupiditate quasi.', 'Da Nang, 25219 Swift Plains Apt. 220', 22.81566600, 103.59957600, '2026-01-27', '2026-02-20', '1-2 hours', 'Monthly', 19, 1, 16, '[\"Writing\",\"Programming\",\"Design\",\"Photography\"]', 'Experienced', 'Paused', NULL, 325, 46, '2025-12-04 16:28:58', '2025-12-04 16:28:58'),
(17, 'org_6931b6caac3ae', 6, 'Dolore nisi quaerat ullam aliquid ducimus impedit explicabo ut.', 'Animi quia eos quisquam rem sed voluptatibus ut. Doloribus dolores in possimus excepturi. Tempore saepe repellat numquam et qui nostrum quod repellendus. Sit fugit laudantium rem et deleniti.', NULL, 'Non provident qui ut iusto iste natus placeat et. Laboriosam expedita voluptas ut eius aut est. Voluptate reprehenderit ut quam expedita asperiores cum sint.', 'Hanoi, 449 Kacie Drives', 17.71800400, 109.23396600, '2026-01-27', NULL, 'Full day', 'One-time', 13, 1, 21, '[\"Photography\",\"Marketing\",\"Programming\"]', 'Some experience', 'Cancelled', NULL, 402, 7, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(18, 'org_6931b6caac3ae', 3, 'Quisquam nihil alias veniam est.', 'Nesciunt maiores velit accusamus autem tempora. Quia nulla sit perspiciatis et vel. Molestiae vitae ut labore. Fugit velit aut officiis illum aliquid. Perspiciatis accusamus non sequi omnis unde in.', 'Aut eius asperiores aliquam dignissimos. Quidem non et consequatur ut sequi aut labore in. Error ut architecto et reiciendis consequatur officia.', 'Veniam laborum commodi deleniti reiciendis rerum. Deleniti minus aut nesciunt ullam vel.', 'Da Nang, 961 Weissnat Terrace', 10.57148900, 102.33535400, '2026-01-01', NULL, '3-5 hours', 'One-time', 9, 3, 18, '[\"Photography\",\"Teaching\"]', 'Some experience', 'Paused', '2025-12-13', 494, 37, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(19, 'org_6931b6caad122', 2, 'Deleniti explicabo sit veritatis blanditiis aspernatur.', 'Delectus velit enim qui voluptas fuga. Dolores nihil quas et aut. Repellat rerum sapiente veritatis error illo omnis. Voluptatum aperiam vel sequi. Provident qui et consectetur cupiditate. Ut molestiae reprehenderit saepe et ratione enim iste.', NULL, 'Harum rerum suscipit quibusdam. Officiis tenetur eum voluptatem omnis id voluptatem vitae. Nihil harum laborum delectus a.', 'Ho Chi Minh City, 382 Sabina Motorway Apt. 960', 17.90538300, 108.77214200, '2026-01-15', '2026-02-16', '3-5 hours', 'Flexible', 7, 0, 18, '[\"Writing\",\"Cooking\",\"First Aid\"]', 'Experienced', 'Paused', '2025-12-14', 427, 15, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(20, 'org_6931b6caad122', 6, 'Pariatur eos aut sint illum.', 'Voluptatem qui officiis et molestias. Id vel quia sunt ipsum et velit. Voluptas maiores rerum voluptas atque repellat molestias. Dolores earum dolor alias sint ipsa dignissimos.', 'Itaque sunt ratione consequatur fuga accusantium quae. Et dolor sapiente optio aspernatur. Vitae architecto officiis quia deserunt totam.', 'Blanditiis molestiae assumenda dolor consectetur dicta dignissimos voluptatem. Repellendus sint ratione rerum distinctio eos. Nihil itaque a est.', 'Da Nang, 412 Howe Shoals', 17.24256800, 103.21820000, '2025-12-29', '2026-02-02', '3-5 hours', 'Weekly', 11, 3, 16, '[\"Programming\",\"Writing\",\"Cooking\",\"Marketing\"]', 'No experience', 'Completed', NULL, 360, 32, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(21, 'org_6931b6caad122', 4, 'Consectetur et blanditiis deleniti ratione est illo similique.', 'Fugit aperiam dicta sit perspiciatis modi. Qui qui nostrum dignissimos et aut dolores. Sit iusto dolorem deserunt minima. Necessitatibus adipisci iure et quod laudantium. Velit maxime et optio delectus veritatis placeat minima. Iste est beatae ducimus similique. Commodi voluptatem odio omnis veritatis.', NULL, NULL, 'Hanoi, 44984 Cassin Pass Suite 146', 19.62662200, 109.77580100, '2025-12-19', '2026-01-10', '1-2 hours', 'Monthly', 3, 5, 18, '[\"First Aid\",\"Programming\",\"Photography\",\"Writing\"]', 'Experienced', 'Paused', NULL, 297, 0, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(22, 'org_6931b6caad122', 8, 'Et suscipit magnam non provident.', 'Nostrum inventore vitae eos quidem nostrum. Sequi ipsum voluptatibus asperiores tempora placeat nesciunt sed. Perspiciatis neque perferendis et consequatur magnam omnis rerum quo. Quam molestias et quo. Nam cupiditate hic aut est nemo voluptatum. Maiores nihil quidem qui non.', NULL, 'Hic debitis dignissimos dolorem sit. Eligendi enim quos reiciendis soluta veniam omnis exercitationem. Libero vel quam debitis.', 'Ho Chi Minh City, 6860 Thalia Gardens', 20.96708700, 105.65121300, '2026-01-24', '2026-03-03', '1-2 hours', 'Flexible', 12, 1, 21, '[\"Cooking\",\"First Aid\",\"Marketing\"]', 'Experienced', 'Completed', NULL, 7, 40, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(23, 'org_6931b6caad122', 3, 'Iure et sed veniam optio error esse.', 'Facilis facilis nam aut placeat est. Aut reprehenderit sed reiciendis consectetur sed. Saepe quae aliquam voluptatem ut ducimus libero. Sunt ea hic aspernatur voluptas voluptas numquam ullam. Quae enim est sint adipisci eos saepe ducimus odit.', NULL, NULL, 'Da Nang, 3602 Walker Neck Suite 667', 17.63690100, 102.09155700, '2025-12-13', NULL, 'Multiple days', 'Weekly', 16, 5, 21, '[\"Marketing\",\"Writing\",\"First Aid\",\"Cooking\"]', 'Experienced', 'Paused', '2025-12-06', 451, 24, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(24, 'org_6931b6caadeee', 2, 'Totam pariatur dignissimos sed.', 'Molestiae aut repudiandae accusantium amet. Dolor autem similique molestiae soluta. Quae sed animi dignissimos sit ut ea eos rerum. Ab quibusdam officia quia eum non quo.', 'Hic aliquid corrupti enim praesentium saepe est voluptas non. Qui officia ducimus sed quas perspiciatis sint quo.', NULL, 'Hai Phong, 6480 Paige Path Suite 565', 17.16869200, 104.62161500, '2025-12-13', NULL, 'Full day', 'Flexible', 14, 2, 21, '[\"Teaching\",\"Cooking\"]', 'Some experience', 'Active', '2025-12-08', 39, 1, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(25, 'org_6931b6caadeee', 8, 'Ipsam molestias voluptas fugiat.', 'Itaque aperiam et omnis non beatae eaque similique nihil. Voluptatum unde accusamus numquam rem eveniet eum vitae. Velit officiis et voluptatum dolore voluptas impedit sit quo. Suscipit cumque illum possimus qui. Reiciendis dolor impedit qui sed minus quia. Dolores provident incidunt quibusdam id. Voluptatem laudantium doloremque maiores ipsum.', NULL, 'Quia deserunt dolores inventore. Porro ut hic explicabo fugit magni aut recusandae.', 'Ho Chi Minh City, 6772 Brad Burg', 10.27866600, 106.72094400, '2025-12-11', NULL, '6-8 hours', 'One-time', 13, 5, 16, '[\"Photography\",\"Marketing\"]', 'Experienced', 'Paused', '2025-12-08', 387, 16, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(26, 'org_6931b6caadeee', 1, 'Laudantium ut assumenda quia ut laboriosam similique.', 'Dolor aut neque animi eum itaque ipsam accusantium. Molestiae laboriosam numquam qui a vel ut. Aliquam explicabo et impedit similique maxime delectus voluptatem. Provident necessitatibus quis illum. Nobis ut praesentium consequatur. Provident dolores est consequuntur a architecto itaque.', NULL, NULL, 'Can Tho, 9342 Marshall Club Suite 772', 15.77929100, 106.65621500, '2026-01-14', NULL, 'Multiple days', 'One-time', 12, 2, 18, '[\"Design\"]', 'No experience', 'Cancelled', '2026-01-06', 193, 46, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(27, 'org_6931b6caaed02', 3, 'Enim labore et doloribus nihil.', 'Mollitia enim nemo enim animi ut ut delectus. Numquam sint nulla repellendus quis voluptate. Eaque eum ad tempora corrupti debitis praesentium nam dolor. Voluptas placeat minus eum sequi. Quae sit quia consequatur alias dicta libero aut.', 'Ipsum incidunt qui aliquid in ullam aliquam. Voluptatibus at facere inventore quo saepe provident sed. Debitis maiores magnam nobis voluptatem atque.', 'Quos autem provident id totam voluptas iste eum excepturi. Quis error sed tempora consectetur nihil. Vero alias neque provident ipsum sit et quibusdam.', 'Da Nang, 845 Maiya Course', 18.74340400, 109.64671000, '2025-12-13', '2026-02-12', '1-2 hours', 'One-time', 14, 4, 18, '[\"Translation\"]', 'Some experience', 'Active', NULL, 287, 1, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(28, 'org_6931b6caaed02', 3, 'Laboriosam ab rerum est necessitatibus.', 'Cumque consequatur iure id et. Quisquam rerum molestias consequatur est. Non ullam enim voluptatum quis qui occaecati et et. In culpa sed numquam architecto et natus id. Eum quas libero error fugiat est qui. Porro amet necessitatibus sunt natus.', NULL, 'Sunt nihil et sit officia perspiciatis fuga. Et in quod architecto molestias incidunt quos fugit. Eius molestiae est officia quis voluptas vel.', 'Da Nang, 847 Lucy Park', 21.57272400, 104.49639000, '2026-01-01', NULL, 'Multiple days', 'One-time', 18, 0, 21, '[\"Teaching\",\"Marketing\"]', 'No experience', 'Completed', '2025-12-16', 179, 4, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(29, 'org_6931b6caaed02', 2, 'Voluptatibus eos id sed eum et.', 'Perferendis est quis quisquam odit ipsam qui repudiandae. Ipsa quis consectetur voluptatibus minima. Laboriosam autem et at optio. Quia corporis at est enim alias ea.', NULL, 'Tenetur ipsa et eius quos veniam magni corporis. Necessitatibus minus quod impedit nihil.', 'Can Tho, 188 Willie Expressway Suite 909', 16.48669800, 105.37066400, '2026-01-09', '2026-02-03', 'Full day', 'One-time', 20, 2, 21, '[\"Cooking\",\"Design\",\"Photography\",\"First Aid\"]', 'No experience', 'Active', '2025-12-05', 448, 28, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(30, 'org_6931b6caaed02', 8, 'Delectus voluptatem aut ea nisi similique qui velit.', 'Eveniet sed occaecati non ab id. Maiores ut sunt beatae dignissimos quas. Velit corporis expedita quo sed dolore ut. Vero voluptas sequi laudantium voluptas. Culpa ut quia atque est natus. Unde neque qui ex sed. Accusamus impedit at itaque odio.', 'Recusandae provident quaerat quos et voluptatum quisquam. Quaerat maxime ut consequatur quidem sed nostrum asperiores.', 'Velit minima vel sapiente iste. Aut corrupti aut culpa magnam adipisci et debitis. Animi aut accusantium sed.', 'Ho Chi Minh City, 22877 Lisette Spur', 12.83204100, 107.41051400, '2026-01-07', NULL, '1-2 hours', 'Weekly', 9, 5, 16, '[\"Writing\",\"Design\",\"Translation\"]', 'Experienced', 'Paused', NULL, 5, 40, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(31, 'org_6931b6caaed02', 8, 'Voluptatem ut et dolor culpa pariatur tempore voluptatem.', 'Dolorem dolorum perferendis sit praesentium repudiandae. Sint mollitia quia dolorem aut quidem inventore omnis quo. Consequatur doloremque delectus ea quos eaque hic beatae. Necessitatibus aut et incidunt aut. Ipsam explicabo voluptatem deleniti velit rerum temporibus adipisci tenetur. Dolores voluptatibus consequatur inventore est molestiae. Eum asperiores voluptatem natus sit modi temporibus deserunt.', 'Reiciendis necessitatibus repudiandae voluptatem aspernatur. Fugiat esse necessitatibus totam ullam hic nam.', NULL, 'Hai Phong, 6722 Lura Stravenue Suite 798', 16.71398500, 108.69173300, '2025-12-23', '2026-02-18', '3-5 hours', 'Monthly', 11, 2, 21, '[\"Design\",\"Writing\"]', 'No experience', 'Paused', NULL, 232, 20, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(32, 'org_6931b6caaed02', 3, 'Incidunt et neque debitis doloremque sed sunt.', 'Tempore enim laborum quaerat non fuga. Maxime impedit delectus et expedita fuga. Earum aliquid mollitia quas et vero dolor rerum natus. Nobis voluptas ab delectus accusantium aspernatur reprehenderit repellat. Nostrum nostrum neque iste culpa tenetur nesciunt. Accusamus dolores sunt voluptas ad nostrum id.', NULL, NULL, 'Can Tho, 454 Maynard Ranch Suite 047', 14.54798300, 106.43754700, '2026-01-15', '2026-02-04', '1-2 hours', 'Monthly', 8, 0, 21, '[\"Cooking\",\"Teaching\",\"First Aid\",\"Translation\"]', 'No experience', 'Completed', NULL, 83, 3, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(33, 'org_6931b6caaed02', 2, 'Dolor sequi culpa atque sit animi est.', 'Culpa accusamus neque nihil. Sed est repellendus itaque ut. Quis molestias quia odio vitae quod ea. Sit suscipit quos est corrupti blanditiis. Ducimus nisi nemo omnis numquam totam et atque.', NULL, 'Similique distinctio possimus recusandae et in ut. Quia sit quod voluptatem numquam maiores officia.', 'Can Tho, 8918 Rodriguez Point Suite 845', 8.91017100, 107.21402200, '2025-12-31', NULL, '1-2 hours', 'Weekly', 11, 4, 16, '[\"First Aid\",\"Design\"]', 'Some experience', 'Cancelled', '2025-12-07', 229, 44, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(34, 'org_6931b6caaed02', 3, 'Dolorem ullam ducimus quos aut sit debitis non.', 'Dolore placeat non eaque. Quos id aspernatur eligendi aliquam sapiente magni odio eius. Molestiae similique dignissimos repudiandae tempore repudiandae provident. Optio in nobis impedit commodi eveniet aliquam est accusamus. Quia labore laboriosam molestias quasi velit perspiciatis voluptatum. Optio provident sapiente sint occaecati. Voluptate voluptas non et laudantium facilis.', NULL, NULL, 'Hanoi, 868 Deckow Pass Apt. 951', 9.50282500, 109.55439700, '2025-12-28', '2026-02-16', '6-8 hours', 'One-time', 13, 0, 16, '[\"Programming\",\"Marketing\",\"Photography\"]', 'Some experience', 'Active', '2025-12-10', 37, 38, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(35, 'org_6931b6caafd51', 1, 'Ea minus enim ipsa libero eligendi perferendis.', 'Soluta porro molestias eum consequatur incidunt id culpa. Modi et dolor ut veritatis perspiciatis animi voluptas reprehenderit. Ut necessitatibus et sit nulla non. Ratione temporibus mollitia qui similique. Voluptas id quia rerum quidem dolor. Harum delectus magnam ipsa culpa sint deserunt. Quod neque aut et libero impedit eos cupiditate sit.', NULL, NULL, 'Ho Chi Minh City, 3449 Ivah Lakes Suite 648', 18.77558800, 105.66681200, '2026-01-11', NULL, 'Full day', 'Weekly', 1, 5, 18, '[\"Design\",\"Photography\"]', 'No experience', 'Active', '2025-12-29', 156, 7, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(36, 'org_6931b6caafd51', 1, 'Id sed ullam maxime impedit.', 'Autem maxime et quidem earum tenetur voluptas vero. Maxime rerum assumenda ab qui. Numquam sit placeat provident quasi provident omnis odit earum. Et perspiciatis et qui deserunt voluptatem in expedita nobis.', NULL, NULL, 'Hai Phong, 64350 Naomie Mission Apt. 414', 19.54902800, 103.62031000, '2026-01-12', '2026-01-19', 'Full day', 'Flexible', 18, 3, 16, '[\"Cooking\",\"Writing\",\"Marketing\",\"First Aid\"]', 'Experienced', 'Completed', '2025-12-24', 231, 8, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(37, 'org_6931b6caafd51', 2, 'Voluptatem est magni et aspernatur.', 'Dolores in dignissimos et mollitia. Qui voluptates dolores molestiae expedita velit magnam. Rerum temporibus et qui eos iste. Et et qui explicabo aperiam saepe. Quia officiis quia doloribus qui id praesentium voluptatem. Aut iste nobis sit sint omnis cupiditate.', NULL, 'Perferendis nesciunt eos voluptatum animi similique veniam sint. Possimus impedit qui rerum et.', 'Hanoi, 38524 Carmella Bypass Suite 560', 11.70964300, 109.02637700, '2026-01-23', NULL, '6-8 hours', 'Weekly', 14, 3, 21, '[\"Marketing\",\"Teaching\",\"Cooking\",\"Design\"]', 'No experience', 'Active', NULL, 381, 37, '2025-12-04 16:28:59', '2025-12-09 06:07:07'),
(38, 'org_6931b6caafd51', 7, 'Eos magnam ducimus dolorum aut aut expedita.', 'Quam sequi quia non quia possimus nihil libero. Et ut vel quidem unde quia nam quis. Dolor aliquam fugit aut error ut veritatis. Corporis asperiores repellat tempora et distinctio. Quidem facere deserunt asperiores placeat quia optio odio dicta. Ipsam provident earum est et porro.', NULL, 'Repudiandae nesciunt ut consequatur voluptas. Neque molestiae corporis odit et repellat voluptatem dolores. Consequuntur unde inventore distinctio non animi.', 'Hanoi, 61330 Reymundo Loaf Suite 594', 12.31676000, 104.47990400, '2025-12-28', '2026-01-24', '3-5 hours', 'One-time', 20, 4, 18, '[\"Photography\"]', 'Experienced', 'Completed', '2025-12-18', 0, 11, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(39, 'org_6931b6caafd51', 6, 'Illo voluptate commodi dolore animi et itaque.', 'Corrupti non ipsa qui deserunt sit occaecati. Consequatur accusantium est commodi cumque voluptatem expedita. Tenetur doloremque dolorem quisquam odio possimus ea. Voluptatem quos est nesciunt autem rerum at. Molestiae quia aperiam fuga quia explicabo voluptatem sint. Voluptatem perferendis aut voluptatum quisquam ut cupiditate.', NULL, 'Nihil iusto et velit qui maiores totam. Eveniet eligendi praesentium quia qui. Quo officia enim nemo minus suscipit possimus.', 'Hanoi, 9514 Veum Mews Apt. 583', 11.87391100, 107.36693800, '2025-12-31', '2026-01-03', '3-5 hours', 'Monthly', 5, 4, 18, '[\"Cooking\",\"Design\",\"Teaching\"]', 'Experienced', 'Cancelled', '2025-12-15', 375, 50, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(40, 'org_6931b6cab0b48', 7, 'Qui et omnis id aut reiciendis ut exercitationem fugit.', 'Reprehenderit aliquid quasi dolorem explicabo cumque sed deleniti in. Culpa voluptatum dignissimos et praesentium maiores. Autem quos culpa et. Rem repellendus sed architecto beatae. Eius et aut magni sunt in. Rem et sed nulla similique quibusdam. Doloribus facere consequatur est et.', NULL, 'Provident maiores blanditiis nostrum voluptatibus dignissimos. Recusandae culpa enim in dolores omnis est.', 'Ho Chi Minh City, 1056 Daniella Coves Suite 910', 20.09644500, 107.62786600, '2026-01-16', '2026-02-12', 'Multiple days', 'One-time', 18, 1, 21, '[\"Programming\",\"Teaching\",\"Translation\",\"First Aid\"]', 'Experienced', 'Completed', NULL, 282, 17, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(41, 'org_6931b6cab0b48', 4, 'Quo repellendus ut voluptas dolor placeat.', 'Quisquam quam blanditiis porro. Nostrum vitae qui expedita quaerat. Ut consequatur enim ut. Repellendus expedita accusantium ducimus deleniti. Vero veritatis autem iste inventore provident harum eaque explicabo.', NULL, NULL, 'Hai Phong, 16869 Koepp Greens Apt. 270', 17.85833200, 103.37382000, '2026-01-05', NULL, 'Full day', 'Flexible', 8, 1, 21, '[\"Cooking\"]', 'Experienced', 'Cancelled', '2025-12-17', 39, 46, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(42, 'org_6931b6cab0b48', 6, 'Aut omnis in non neque quod ut velit.', 'Fugit qui doloribus illo placeat aspernatur nam et. Aut dignissimos earum velit consectetur odit ullam tenetur saepe. Eaque corporis est eos sed debitis fugiat illo esse. Quasi aut ea iure explicabo.', NULL, NULL, 'Hai Phong, 99142 Hayes Row', 13.97088200, 106.86585400, '2026-01-22', '2026-02-07', '6-8 hours', 'Monthly', 11, 1, 18, '[\"Programming\",\"Photography\",\"Teaching\",\"Translation\"]', 'Experienced', 'Paused', NULL, 463, 28, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(43, 'org_6931b6cab0b48', 6, 'Molestiae voluptatum illum praesentium non accusamus at debitis dolorem.', 'Aut laborum velit fuga. Sint pariatur impedit reprehenderit at dolorem. Voluptates qui eveniet adipisci error voluptatem. Ipsa ut sed temporibus et nihil explicabo officiis. Qui laudantium dolores dolor et facilis et esse voluptas. Occaecati illo consequuntur enim et quia.', NULL, 'Non maxime veniam veritatis minus laborum. Doloribus et soluta dicta ut voluptas. Labore quia inventore eius blanditiis non sapiente eius non.', 'Da Nang, 36161 Ian Ferry Apt. 823', 15.34154200, 106.94741200, '2025-12-14', '2025-12-21', '1-2 hours', 'Monthly', 1, 1, 18, '[\"Programming\"]', 'No experience', 'Cancelled', '2025-12-11', 173, 0, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(44, 'org_6931b6cab1b30', 5, 'Voluptatum illo occaecati id tempore.', 'At quo quia eos quaerat. Harum eum aspernatur et illo magnam laudantium. Sint repellendus doloribus voluptatibus voluptates sed quidem sint eveniet. Eius similique molestias et veritatis inventore odit. Magni iusto culpa in cum rem est.', NULL, 'Sint necessitatibus dolorum rerum qui. Totam odit quis et voluptates voluptas.', 'Hanoi, 471 Xander Causeway', 10.94401500, 107.44702500, '2025-12-27', NULL, 'Full day', 'Monthly', 20, 0, 18, '[\"Marketing\"]', 'No experience', 'Active', NULL, 391, 37, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(45, 'org_6931b6cab1b30', 5, 'Itaque laudantium veritatis sit nihil.', 'Qui aliquam nihil perspiciatis et. Et repellendus dolor pariatur enim corporis nam quas. Illo non ducimus neque sunt molestiae qui sunt. Est qui molestias dolores non assumenda ab. Dolorem velit laborum dolorem et.', NULL, NULL, 'Hanoi, 931 Rickie Course', 13.11319900, 105.08331100, '2026-01-27', NULL, '3-5 hours', 'One-time', 5, 1, 21, '[\"Cooking\",\"First Aid\",\"Design\"]', 'No experience', 'Cancelled', NULL, 299, 1, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(46, 'org_6931b6cab1b30', 8, 'Sint quia tempora maiores aperiam atque.', 'Nulla totam recusandae aut voluptatum. Esse totam sint cumque. Est et tempora dolor quam. Veniam provident repellendus magnam ea.', NULL, 'Autem tempora minus aut modi officiis. Id adipisci adipisci quia blanditiis.', 'Da Nang, 618 Landen Springs', 9.77820900, 105.29805900, '2026-01-19', NULL, '1-2 hours', 'Flexible', 16, 5, 18, '[\"First Aid\",\"Marketing\"]', 'No experience', 'Completed', NULL, 410, 12, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(47, 'org_6931b6cab1b30', 7, 'Dolor fugit harum totam veniam eum vero architecto.', 'Mollitia et perspiciatis autem alias temporibus. Et perspiciatis quibusdam ab consequatur quo voluptates eos libero. Perferendis qui quod nulla aut atque maiores non. Eum fuga voluptas eaque sit. Sit et nulla ut pariatur velit. Eaque qui qui cumque at.', NULL, 'Aut corporis amet repellat molestiae architecto sapiente fugiat. Praesentium ut quia aut et. Reiciendis id voluptatem consequatur voluptas nam dolores sed.', 'Hai Phong, 8714 Dare Causeway Suite 541', 11.27488200, 106.06910000, '2026-01-25', NULL, '1-2 hours', 'One-time', 16, 2, 21, '[\"Teaching\",\"First Aid\",\"Marketing\"]', 'No experience', 'Active', NULL, 396, 29, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(48, 'org_6931b6cab1b30', 5, 'Aut repellendus doloremque omnis quia.', 'Veritatis reiciendis qui quia similique labore corrupti cupiditate. Omnis vel ea at. Quo ut qui mollitia earum. Dolorem vel suscipit nobis rerum unde vero. Repellat facere consequatur iste non ullam vel quibusdam.', NULL, 'Repellat et optio illum id amet. Laboriosam placeat assumenda illo. Non et illum quam nam est.', 'Ho Chi Minh City, 5609 Feest Ports Suite 770', 14.97878200, 107.79869200, '2026-01-03', '2026-02-20', 'Full day', 'One-time', 12, 2, 21, '[\"First Aid\"]', 'Some experience', 'Cancelled', NULL, 412, 17, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(49, 'org_6931b6cab1b30', 6, 'Ipsa officia atque minima quisquam voluptatibus.', 'Vel autem qui ut corporis sit. Et et et deserunt tempora nemo sed commodi. Nobis eius numquam id atque error tenetur. Quisquam quia illum nihil dolores perferendis blanditiis.', 'Atque accusantium saepe minus qui ut est et. Et et consequatur quis.', NULL, 'Can Tho, 15873 Mitchell Drive Apt. 550', 19.74020800, 109.14670000, '2026-01-10', NULL, '1-2 hours', 'Flexible', 17, 2, 21, '[\"Teaching\"]', 'Experienced', 'Paused', NULL, 384, 24, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(50, 'org_6931b6cab311e', 1, 'Aut ipsam voluptatem in eveniet rerum culpa eveniet.', 'Architecto officiis est sapiente dolores rerum voluptate ipsa. Maiores atque quo aut suscipit id saepe libero molestias. Quis illo nulla sit. Sunt porro non officia nihil eos.', 'Ea eveniet blanditiis qui. Mollitia rerum quo suscipit omnis omnis. Minus quo et alias eius est nostrum ea velit.', NULL, 'Ho Chi Minh City, 964 Mabel Tunnel Apt. 640', 15.17877200, 102.32627500, '2026-01-15', NULL, 'Multiple days', 'Flexible', 15, 2, 21, '[\"Design\"]', 'Experienced', 'Cancelled', NULL, 291, 2, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(51, 'org_6931b6cab311e', 5, 'Velit voluptatibus veritatis aut neque quibusdam fugiat.', 'Fugit quasi ipsa sint aliquam beatae nihil omnis. A sapiente animi dolorem. Fugit tempora soluta veniam at animi ipsa. Sed omnis atque aspernatur possimus. Fugiat explicabo iure nobis sed quidem pariatur assumenda.', 'Quibusdam rerum ullam quia corrupti maiores aut. Modi asperiores debitis voluptates doloremque nostrum deserunt.', 'Quia vel et sit rerum non alias. Tenetur rem nulla enim nam rerum. Alias corrupti suscipit ut.', 'Can Tho, 4634 Wisoky Cliffs Suite 681', 8.60522100, 102.94142400, '2026-01-12', NULL, '6-8 hours', 'Monthly', 19, 0, 16, '[\"Cooking\",\"Translation\",\"Marketing\",\"Writing\"]', 'Some experience', 'Completed', '2025-12-12', 422, 46, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(52, 'org_6931b6cab311e', 3, 'Porro ea repellendus sunt quaerat sequi impedit dolorum facilis.', 'Dolor dicta eos perferendis. Suscipit quis nemo repudiandae. Debitis sed autem recusandae. Suscipit dolorem possimus quod nostrum consectetur quas. Molestiae expedita magni velit sed. Voluptatem hic ut molestiae dolore sapiente eaque eveniet ducimus. Quaerat et officia repellat veniam molestias.', 'Vel rerum ipsa quo. Id et necessitatibus harum velit.', 'Magnam et ullam vel et. Est ab nihil repellat dolorem. Et ipsum porro minus nisi dolorem aliquam.', 'Hanoi, 7700 Nathen Villages Apt. 906', 17.65043100, 102.29231600, '2026-01-05', NULL, 'Full day', 'Monthly', 5, 1, 16, '[\"Programming\",\"Design\",\"First Aid\"]', 'No experience', 'Cancelled', NULL, 11, 40, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(53, 'org_6931b6cab311e', 6, 'Voluptate amet nam occaecati accusantium vel.', 'Natus corrupti eius itaque ut voluptatibus sunt ipsum consectetur. Nulla amet enim et mollitia inventore dolores. Dolorum eos placeat ut est asperiores est dolorum. Aut voluptas voluptatem reiciendis vel. Expedita repellendus inventore dolorem beatae animi aut incidunt. Ut consequatur neque voluptas facere exercitationem incidunt distinctio velit.', 'Magnam omnis et expedita et omnis nisi doloremque. Voluptate quasi molestiae incidunt vel.', NULL, 'Da Nang, 6915 Kautzer Loop Suite 020', 8.51392400, 106.69827800, '2026-01-04', NULL, 'Full day', 'Flexible', 8, 2, 18, '[\"Design\",\"Writing\"]', 'Some experience', 'Cancelled', '2025-12-07', 213, 31, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(54, 'org_6931b6cab311e', 4, 'Sed sunt sequi quo quo.', 'Sunt omnis eligendi quibusdam voluptate ut deserunt. Dolorem a nihil nobis aspernatur nemo vero. Praesentium ipsam eligendi sit enim fugit. Optio aperiam in recusandae officiis unde. Maiores enim voluptatem possimus harum repellendus.', NULL, NULL, 'Hanoi, 408 Annabelle Valleys Suite 083', 14.46319500, 109.53277000, '2026-02-02', '2026-02-08', '1-2 hours', 'Flexible', 18, 1, 21, '[\"First Aid\",\"Writing\",\"Teaching\"]', 'Some experience', 'Completed', '2025-12-07', 15, 45, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(55, 'org_6931b6cab311e', 1, 'Dolorem possimus nisi voluptates veritatis ullam.', 'Ullam ipsum ut esse iure. Sed earum sint sapiente voluptatum ab. Quasi eligendi ipsam qui deserunt totam. Neque et eaque dolor facilis iste. In facilis et corporis non culpa ipsum veniam.', 'Et quia neque voluptatem quam. Ipsam debitis qui qui id et omnis.', 'Rem ipsam corrupti quod veniam sequi. Error odit hic officiis officia.', 'Hanoi, 33965 Lebsack Land', 11.85622900, 106.27580400, '2026-01-26', NULL, '1-2 hours', 'Flexible', 2, 2, 16, '[\"Writing\",\"First Aid\",\"Programming\",\"Cooking\"]', 'Experienced', 'Completed', NULL, 10, 19, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(56, 'org_6931b6cab311e', 8, 'Facere quidem et necessitatibus facilis aut tenetur.', 'Iste molestiae alias repellendus quis voluptas. Dolores ea veritatis est delectus at molestiae quas. Sequi laborum officia qui optio voluptatem et. Dignissimos repellendus et molestias et quo eos odio. Quia dolorem occaecati sunt qui illum.', NULL, 'Qui quisquam est non sunt culpa quidem. Recusandae earum harum molestias iste eum qui.', 'Ho Chi Minh City, 276 Cristopher Stream Suite 997', 15.63953500, 105.64026700, '2026-01-23', '2026-03-02', '6-8 hours', 'Weekly', 6, 2, 21, '[\"First Aid\",\"Marketing\",\"Translation\"]', 'Some experience', 'Completed', NULL, 195, 6, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(57, 'org_6931b6cab450a', 3, 'Vel velit vel similique modi quos amet laudantium neque.', 'Est et a quasi ipsam perferendis architecto dolorem. Dolor a autem ab expedita itaque velit iure aut. Qui officiis nam qui autem dolor ipsum consectetur. Doloremque consequatur et voluptate voluptate. Autem dolores voluptatem aliquid et.', NULL, NULL, 'Can Tho, 30542 Sipes Heights', 19.21672800, 107.41760000, '2026-01-15', '2026-01-20', '6-8 hours', 'One-time', 20, 3, 18, '[\"Photography\"]', 'No experience', 'Cancelled', NULL, 486, 7, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(58, 'org_6931b6cab450a', 5, 'Dolores sint earum doloremque tempora voluptas consequatur eveniet animi.', 'Doloribus reiciendis omnis minus tenetur accusantium ut. Maxime autem aut quia doloribus tempore. Ex sunt atque animi temporibus ut magnam est. Vel distinctio velit consequuntur qui.', NULL, NULL, 'Da Nang, 9359 Kihn Meadows', 12.74749800, 107.21376400, '2025-12-18', '2026-01-29', '1-2 hours', 'Weekly', 6, 4, 16, '[\"First Aid\",\"Teaching\",\"Programming\"]', 'Experienced', 'Completed', NULL, 484, 9, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(59, 'org_6931b6cab450a', 6, 'Deleniti molestiae inventore corrupti dolores est.', 'Quas laudantium minus totam tenetur. Cum fuga qui dicta et vero in. At quia facere aut dignissimos reiciendis. Non nesciunt id enim fuga qui labore sunt.', 'Nihil perferendis ipsum eum molestiae maiores quis. Eos nihil voluptatum voluptatem ut. Reprehenderit perferendis in sunt et dolor nihil aut.', NULL, 'Ho Chi Minh City, 48921 Ada Stravenue Apt. 994', 20.56129300, 104.78275100, '2026-01-29', '2026-02-18', '3-5 hours', 'Monthly', 7, 1, 18, '[\"Programming\"]', 'Experienced', 'Cancelled', '2026-01-03', 367, 36, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(60, 'org_6931b6cab450a', 2, 'Aut unde eum vel esse ut aspernatur.', 'Numquam praesentium vel et. Voluptatem et perspiciatis harum eligendi quod excepturi dolorem quia. Numquam quibusdam eum sint voluptatem eveniet ut voluptatem. Nemo facere provident cumque consectetur. Dolores facere incidunt aut inventore vel repudiandae. Quos dolorum saepe minus sequi minus aut ut ad. Neque ipsa voluptatibus dolorem occaecati.', 'Ea numquam eligendi nam quia quaerat est consequatur. Et aut minus et expedita voluptas quod ipsum et. Distinctio tempore libero possimus in harum alias similique.', NULL, 'Hai Phong, 47718 Kertzmann Divide', 12.03004700, 107.16846100, '2026-01-12', NULL, 'Full day', 'Weekly', 7, 3, 16, '[\"Photography\",\"Writing\"]', 'Experienced', 'Active', NULL, 390, 7, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(61, 'org_6931b6cab450a', 5, 'Libero voluptatem sapiente voluptate aut est deserunt.', 'Ipsa hic quia nisi. Rerum ipsam delectus et voluptate tempora. Impedit in debitis aut facere occaecati. Incidunt aut eum minima. Vel eum qui sunt et laborum consectetur aspernatur tempore. Nisi eaque est quidem tempore inventore quas.', 'Aut nobis dolorem et natus sequi. Veniam fugiat deleniti repellendus et beatae sunt.', NULL, 'Can Tho, 319 Konopelski Centers Apt. 440', 12.45784100, 105.29152900, '2025-12-08', '2026-01-09', 'Multiple days', 'Weekly', 7, 5, 18, '[\"Marketing\",\"Photography\",\"Translation\",\"Teaching\"]', 'Experienced', 'Paused', NULL, 310, 11, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(62, 'org_6931b6cab450a', 3, 'Doloremque animi laudantium ad odio.', 'Est aut id maiores voluptas rerum labore. Possimus in nostrum ab et sapiente. Cum ad eius est maiores ut qui. In quam tempore dolor autem in nulla qui blanditiis.', NULL, 'Unde voluptatem qui perferendis natus tempora. Vero neque ullam voluptatibus itaque.', 'Hai Phong, 87441 Beryl Freeway', 21.08745300, 109.27214100, '2026-01-12', '2026-02-06', '6-8 hours', 'One-time', 8, 1, 18, '[\"First Aid\",\"Programming\",\"Teaching\"]', 'No experience', 'Completed', NULL, 322, 26, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(63, 'org_6931b6cab450a', 7, 'Non iste veniam non qui magnam totam necessitatibus.', 'Velit praesentium voluptatem molestias dolorem exercitationem. Possimus eos exercitationem optio dolorem odit asperiores. Et commodi autem repellat qui adipisci. Doloremque expedita labore veritatis nostrum. Ullam non impedit et facere distinctio. Quasi error vel odit.', NULL, NULL, 'Ho Chi Minh City, 80599 Heaney Island Apt. 650', 13.27010500, 103.70446000, '2026-01-15', '2026-02-17', '3-5 hours', 'Monthly', 7, 4, 16, '[\"Design\",\"Writing\"]', 'No experience', 'Active', '2026-01-04', 279, 21, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(64, 'org_6931b6cab54a9', 2, 'Recusandae aut sint maxime eligendi nulla ratione illum.', 'Hic eum est incidunt praesentium qui placeat. Aut nisi quibusdam unde illo eaque tempore qui. Sint veniam sint dolorem sed est. Aut maxime voluptatibus atque earum. Vitae laborum et est deserunt omnis sint itaque.', NULL, NULL, 'Hai Phong, 580 Erwin Crossing', 22.98506400, 107.93368600, '2025-12-29', NULL, 'Multiple days', 'One-time', 8, 3, 21, '[\"Writing\",\"Translation\",\"Teaching\"]', 'Experienced', 'Cancelled', NULL, 463, 20, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(65, 'org_6931b6cab54a9', 2, 'Et eveniet inventore sint quia rerum earum.', 'Harum aut nobis et voluptatem aut ea facere cumque. In ipsam est dolore et. Placeat expedita necessitatibus dolores cum animi et illum. Ullam et quod saepe aut repudiandae vitae. Porro eum earum beatae.', 'Iure tenetur maxime velit perferendis optio tempora aut. Pariatur modi ut quasi ab dolor nulla et. Et tenetur nemo exercitationem.', NULL, 'Ho Chi Minh City, 796 Alexandro Courts Suite 383', 18.08393100, 109.48341200, '2025-12-22', '2026-01-17', 'Full day', 'Weekly', 17, 0, 16, '[\"First Aid\",\"Design\"]', 'Experienced', 'Cancelled', '2025-12-07', 310, 9, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(66, 'org_6931b6cab54a9', 7, 'Enim sed quisquam eos alias.', 'Porro enim excepturi rerum consectetur praesentium. Corporis consequatur ad quo doloribus. Inventore tempora est ratione officia. Ut eligendi consequatur tempora ut nihil cum nihil. Sunt voluptate iure aut eum. Ipsa et esse veritatis laborum.', 'Tempora unde aliquid ut voluptates totam aliquid. Voluptatum numquam quasi necessitatibus sunt doloremque accusantium et.', NULL, 'Da Nang, 476 Dickinson Pine', 14.63810800, 103.58433400, '2025-12-13', NULL, '6-8 hours', 'Weekly', 13, 0, 18, '[\"Teaching\",\"Cooking\",\"Writing\"]', 'Experienced', 'Completed', '2025-12-07', 68, 37, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(67, 'org_6931b6cab54a9', 4, 'Sed asperiores autem laborum veritatis quo ratione.', 'Distinctio expedita dolor odio aut id vero. Eos in dolores quam dolorum unde error possimus. Non necessitatibus omnis dolorem aliquid veritatis necessitatibus. Nihil mollitia illo nihil ut.', NULL, NULL, 'Hanoi, 3401 Morar Rapids', 20.90173900, 103.56024400, '2026-01-08', '2026-02-08', 'Multiple days', 'Monthly', 17, 1, 21, '[\"Teaching\",\"First Aid\",\"Marketing\",\"Programming\"]', 'Experienced', 'Cancelled', '2025-12-17', 223, 18, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(68, 'org_6931b6cab54a9', 5, 'Non animi quis quae quasi mollitia.', 'Earum quibusdam in maxime dignissimos. Odit quod deserunt ad assumenda omnis facilis. Deleniti adipisci ut aut doloremque dicta. Est officia est delectus non. Reiciendis dolore dolor distinctio qui sit. Enim itaque sint aut harum cumque officia ea. Labore sit unde ut est aut.', NULL, 'Est consequuntur nesciunt porro eum non reiciendis. Et rerum harum velit corporis sit.', 'Hanoi, 135 Kody Way', 17.20815100, 106.88531300, '2026-01-08', '2026-02-24', '3-5 hours', 'One-time', 14, 4, 16, '[\"Cooking\",\"Teaching\"]', 'No experience', 'Active', NULL, 134, 42, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(69, 'org_6931b6cab54a9', 3, 'Nostrum repellat adipisci repellendus aliquid.', 'Expedita perspiciatis alias dolorem. Dolores sunt sed voluptate. Iste temporibus est ab odit quibusdam optio. Et commodi nihil sunt quia saepe quis. Facilis est sint earum omnis quod amet aut. Iusto consectetur libero ratione non suscipit dignissimos.', 'In et eveniet ex quia voluptate esse dolores. Fuga eum ut impedit ab.', 'Est quaerat corporis in ea alias praesentium velit aut. Nemo illo odit ullam temporibus doloremque autem temporibus. Dolor non eos reiciendis esse quaerat eum non maiores.', 'Hai Phong, 16603 Green Orchard Apt. 847', 10.97162500, 104.48127700, '2026-01-02', NULL, '6-8 hours', 'Flexible', 8, 5, 21, '[\"First Aid\",\"Teaching\",\"Translation\",\"Writing\"]', 'Some experience', 'Paused', '2025-12-18', 63, 10, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(70, 'org_6931b6cab6522', 7, 'Dolor sed beatae quos qui.', 'Et qui libero ipsa iusto. Ut sint quibusdam aliquam cumque. Quis cum autem accusantium vero et minima quis. Sint placeat omnis laborum at qui ut. Molestiae fugiat vitae laudantium et. Deleniti consequuntur est libero voluptates.', 'Ipsam amet labore quos nobis illum. Quia aut molestiae omnis.', 'Officiis consequuntur ut repellendus qui. Est voluptatem natus deserunt reiciendis sit consequuntur. Ea vitae est culpa facere eum facilis.', 'Da Nang, 11260 Jada Port Suite 834', 17.50036500, 104.68728000, '2026-01-13', '2026-02-18', '6-8 hours', 'Monthly', 5, 0, 21, '[\"Teaching\",\"Photography\"]', 'No experience', 'Paused', NULL, 234, 42, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(71, 'org_6931b6cab6522', 4, 'Quis omnis deleniti voluptatem illo eligendi voluptatem voluptatem adipisci.', 'Dolorum et ut harum blanditiis. Enim officiis omnis at ut quo laudantium accusantium. Et voluptatibus molestiae enim voluptates ut sunt fugiat. Eaque cum laboriosam odio consequatur rerum soluta.', 'Et doloribus iste sit eius eos. Labore magnam omnis labore tempore ipsa vitae rerum consequatur. Ut et sapiente nostrum sit omnis enim.', NULL, 'Hanoi, 120 Kane Union', 19.51479900, 107.35563400, '2025-12-23', '2026-03-03', '6-8 hours', 'Weekly', 16, 4, 18, '[\"Marketing\",\"First Aid\",\"Programming\",\"Writing\"]', 'Some experience', 'Active', NULL, 234, 34, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(72, 'org_6931b6cab6522', 8, 'Asperiores consequatur illo veritatis id facere saepe.', 'Et est ex nihil reprehenderit. Fugiat labore et aut rerum sint aperiam. Numquam et incidunt adipisci et. Veniam ducimus est unde aperiam nulla animi.', NULL, NULL, 'Da Nang, 434 Nitzsche Flat Suite 566', 8.66858100, 102.88532900, '2026-01-21', NULL, '3-5 hours', 'One-time', 6, 3, 18, '[\"First Aid\",\"Design\"]', 'Experienced', 'Paused', NULL, 8, 29, '2025-12-04 16:28:59', '2025-12-04 16:28:59');
INSERT INTO `volunteer_opportunities` (`opportunity_id`, `org_id`, `category_id`, `title`, `description`, `requirements`, `benefits`, `location`, `latitude`, `longitude`, `start_date`, `end_date`, `time_commitment`, `schedule_type`, `volunteers_needed`, `volunteers_registered`, `min_age`, `required_skills`, `experience_needed`, `status`, `application_deadline`, `view_count`, `application_count`, `created_at`, `updated_at`) VALUES
(73, 'org_6931b6cab6522', 1, 'Voluptatem voluptatem ad rerum iusto maiores fuga quisquam.', 'Quam optio labore debitis et qui. Soluta eaque suscipit possimus enim consequuntur voluptatem. Nisi quaerat odit nobis fugiat quis qui cumque. Beatae sit voluptatem et voluptatem commodi quia. Qui hic est consequuntur. Aperiam sit ipsam consequuntur at ut ea.', NULL, 'Saepe error et rerum nemo amet magni. Facilis magni maxime quae.', 'Ho Chi Minh City, 7682 Mertz Mountains Apt. 607', 17.84701100, 102.07856500, '2026-01-14', '2026-01-25', 'Full day', 'One-time', 4, 5, 21, '[\"Writing\"]', 'No experience', 'Paused', '2025-12-10', 404, 24, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(74, 'org_6931b6cab6522', 7, 'Dolorem amet sunt enim.', 'Maxime amet dolor fugit eum temporibus. Eos debitis aut et asperiores molestiae voluptate. Minus aspernatur natus tempore dolor perferendis dolorem. Recusandae perspiciatis impedit voluptas reiciendis aut ea delectus aliquam. Repellat facere omnis et recusandae consectetur. Ut autem perspiciatis ducimus laboriosam.', NULL, 'Incidunt libero dolores non occaecati. Tempora dolores sint fugit veniam sunt reprehenderit accusamus.', 'Can Tho, 5560 Kevon Crescent', 16.56170700, 104.82183500, '2026-01-28', '2026-01-28', '3-5 hours', 'Flexible', 9, 2, 16, '[\"Marketing\",\"Writing\",\"Teaching\",\"Design\"]', 'Some experience', 'Active', '2026-01-19', 38, 1, '2025-12-04 16:28:59', '2025-12-09 06:08:35'),
(75, 'org_6931b6cab6522', 3, 'Corporis sit sit itaque dolor.', 'Alias non sit accusantium ut. Quas alias officiis necessitatibus unde omnis minus. Praesentium placeat quo doloribus corrupti voluptas molestiae. Et repellendus unde harum. Libero reprehenderit ut esse quos autem. Autem officiis perferendis officia dignissimos.', 'Corporis unde ullam vitae nam. Dicta fugiat dignissimos nemo at fugiat sint et. Ut aperiam maxime eos.', NULL, 'Can Tho, 1838 Dakota Union', 16.53469600, 103.32506100, '2026-01-12', NULL, '3-5 hours', 'Flexible', 15, 2, 18, '[\"Design\",\"Photography\",\"Translation\",\"Programming\"]', 'Experienced', 'Cancelled', NULL, 492, 24, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(76, 'org_6931b6cab74e0', 1, 'Neque et et iste omnis consequatur quae eos.', 'Impedit quia fuga a et dignissimos. Soluta laborum tempore delectus aut. Ex consequatur harum et quae dolorum aut. Ea enim ut sapiente repellat odio sint minus.', NULL, 'Molestiae consectetur id voluptatibus dolorem quia id perferendis quis. Tempore itaque maiores laboriosam beatae.', 'Hai Phong, 496 Lauriane Court', 11.34845900, 102.94026200, '2026-01-22', '2026-01-22', '3-5 hours', 'One-time', 2, 4, 18, '[\"Programming\"]', 'Some experience', 'Paused', NULL, 368, 30, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(77, 'org_6931b6cab74e0', 5, 'Adipisci omnis quam magnam qui est non incidunt ut.', 'Omnis aut quas nostrum et impedit dolorem. Nobis et odio sed et voluptatem perspiciatis repellat. Accusamus deserunt consequatur in vitae corporis. Excepturi eligendi perferendis exercitationem molestiae. Et qui amet perferendis illo asperiores commodi non suscipit.', 'Provident consequatur nihil non. Magni vel tempora voluptas libero. Deserunt deleniti aut et non necessitatibus.', NULL, 'Hai Phong, 9141 Doug Point', 10.61535800, 107.07247700, '2026-01-24', NULL, '6-8 hours', 'Weekly', 16, 5, 21, '[\"Translation\"]', 'Some experience', 'Completed', NULL, 8, 35, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(78, 'org_6931b6cab74e0', 7, 'Quos quisquam ea aut.', 'Nulla natus sit rerum quaerat ipsum officia aut. Magnam dicta sit deserunt possimus recusandae. Modi assumenda quaerat beatae sit dolor consequatur. Enim vel itaque laboriosam quasi quos aliquid inventore. Est dolores quia ut laboriosam. In ut non voluptatum iusto. Quibusdam voluptatem atque adipisci.', NULL, NULL, 'Can Tho, 7163 Langworth Ville', 16.34927100, 103.31378700, '2026-01-07', '2026-01-07', '3-5 hours', 'Weekly', 7, 3, 16, '[\"Cooking\",\"Translation\",\"First Aid\",\"Writing\"]', 'Experienced', 'Paused', '2025-12-27', 67, 1, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(79, 'org_6931b6cab74e0', 2, 'Aperiam non voluptatem enim soluta.', 'Ut cum tempora consequatur ut accusamus. Autem molestiae nam unde in ut nostrum soluta. Pariatur omnis itaque maiores nemo distinctio blanditiis reiciendis. Eveniet mollitia voluptatem id at aspernatur non cum. Porro cumque cumque aut voluptas dolor ullam.', NULL, 'Incidunt temporibus laudantium facilis aspernatur quod pariatur saepe esse. Ab enim voluptates et provident ipsam inventore dignissimos ut. Sequi odit porro et iste explicabo est alias.', 'Hai Phong, 9297 Isidro Cliff Apt. 939', 11.05037300, 102.31342600, '2025-12-16', NULL, '1-2 hours', 'One-time', 19, 2, 18, '[\"Writing\",\"Cooking\",\"Marketing\"]', 'No experience', 'Paused', NULL, 142, 37, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(80, 'org_6931b6cab8454', 5, 'Totam qui eos in.', 'Molestiae quia quisquam vitae nam beatae consequatur. Voluptatem eius error dignissimos quo minima et. Quis doloribus pariatur ipsum. Libero veniam sapiente consequatur adipisci sint error ipsam quia. Aperiam quod voluptate ut quia. Magni est dolorem sint et voluptas qui a. Asperiores eum qui id eum sed quis sit.', 'Perferendis fugit nam illo et ad. Qui velit dolorem magni. Nesciunt qui sit rerum quis necessitatibus facilis.', 'Quidem corrupti veniam beatae. Porro aut consequatur laborum quidem officiis.', 'Ho Chi Minh City, 2831 Santiago Highway', 11.96187300, 108.28053900, '2025-12-12', '2026-03-02', 'Multiple days', 'Monthly', 6, 3, 18, '[\"Writing\",\"First Aid\"]', 'Experienced', 'Cancelled', NULL, 177, 24, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(81, 'org_6931b6cab8454', 7, 'Consequatur doloremque mollitia ipsam est velit sint perspiciatis.', 'Qui ex earum molestiae sed omnis voluptatibus. Id molestias et nulla qui fugit quos. Harum eligendi enim velit dolores. Magnam aut numquam quod provident eos qui accusantium. Illo consequatur eos tempora corporis assumenda.', 'Mollitia reiciendis ad labore non harum velit vel. Alias atque quo occaecati nam cum.', 'Reprehenderit ipsam eligendi quod. Voluptatem vel quos aut non quos consectetur.', 'Da Nang, 2112 Abernathy Station', 14.05307000, 105.77261800, '2026-01-04', '2026-02-12', 'Multiple days', 'Weekly', 2, 3, 18, '[\"Writing\",\"Cooking\",\"Teaching\",\"Programming\"]', 'Some experience', 'Active', '2025-12-16', 181, 18, '2025-12-04 16:28:59', '2025-12-09 06:08:22'),
(82, 'org_6931b6cab8454', 3, 'Sapiente ratione fugit consequatur pariatur aut perspiciatis.', 'Qui ad esse fugiat provident repellendus ratione suscipit non. Exercitationem vitae vitae quos et corporis eaque. Aspernatur placeat sit non. Dolore qui modi dolor aliquam. Magni aut quisquam eos et.', 'Voluptatem dolorem tempora laudantium non ad. Magni molestiae amet aut qui nihil.', 'Et a error dolorem porro doloribus. Ut rem architecto fugiat voluptates quos sequi error. Quo id sed et aut ut eos veniam.', 'Can Tho, 38052 Nola Terrace Suite 592', 11.65193200, 106.01065400, '2026-01-05', NULL, '1-2 hours', 'Monthly', 6, 1, 21, '[\"Programming\",\"Teaching\"]', 'Experienced', 'Active', NULL, 441, 10, '2025-12-04 16:28:59', '2025-12-09 06:08:30'),
(83, 'org_6931b6cab8454', 8, 'Amet enim neque sint aut debitis.', 'Ducimus esse ad iure labore. Ut officiis impedit qui nostrum molestias. Ipsa similique quia dolores delectus eius eum magni. Et sit molestias tenetur ut amet et. Eos fugiat saepe perferendis suscipit ad impedit sunt.', NULL, NULL, 'Hai Phong, 78387 Runte Walks Apt. 831', 11.15063600, 108.23307900, '2026-01-07', '2026-02-03', '1-2 hours', 'Flexible', 19, 4, 16, '[\"Photography\"]', 'Some experience', 'Completed', NULL, 211, 39, '2025-12-04 16:28:59', '2025-12-04 16:28:59'),
(84, 'org_6931b6cab8454', 7, 'Rerum asperiores dolorum iure non quam commodi.', 'Aut vero est qui dolorem voluptatem. Aspernatur iste omnis odit deserunt. Qui et autem vel ut ad omnis fuga. Fugit ullam aut delectus qui. Eius beatae et ab dolorem temporibus itaque tempora ut.', 'Laudantium dolores voluptas nihil alias quo. Reprehenderit quod suscipit harum.', 'Cum eveniet rem numquam eum. Labore libero eos eligendi. Aut aliquid quis vel qui.', 'Ho Chi Minh City, 55413 Ike Knolls', 17.62299400, 109.93509000, '2025-12-28', '2026-02-04', '3-5 hours', 'Weekly', 10, 0, 16, '[\"First Aid\"]', 'No experience', 'Completed', NULL, 153, 20, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(85, 'org_6931b6cab92f0', 5, 'Ipsum sed et repellendus et.', 'Et explicabo atque illum ducimus magni porro numquam. Ab occaecati eligendi deleniti et nostrum quia voluptate aut. Unde sed quia aut quis praesentium quas. Molestias similique dolorem vitae. Ut rerum eum explicabo et. Quisquam sint necessitatibus voluptatem architecto sunt quisquam aut.', NULL, 'Earum architecto earum impedit culpa aut enim. Non unde eum facilis nihil quasi laborum. Ut nulla et corrupti magnam omnis maxime.', 'Ho Chi Minh City, 759 Pollich Bridge', 13.66452200, 104.26933700, '2025-12-25', '2026-02-12', '6-8 hours', 'Flexible', 6, 1, 16, '[\"Programming\",\"Cooking\",\"Teaching\",\"Translation\"]', 'Some experience', 'Paused', '2025-12-19', 232, 31, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(86, 'org_6931b6cab92f0', 5, 'Sit et omnis dolorum totam atque quam.', 'Et voluptates ut laborum sed in sed porro. Facilis earum ut voluptatem est. Vero dolores ratione in nesciunt est deserunt. Doloribus vitae est facilis et maiores possimus omnis. Natus maiores perspiciatis ut et saepe sit. Consectetur ut molestias quia consequuntur eum.', 'Ea dolorem dolor nihil est voluptas autem veritatis. Sequi ut error in quis deserunt. Impedit ab aut maiores ipsa non aliquid.', 'Consequuntur ut ab enim ut. Sed dolore illo animi impedit dignissimos.', 'Hanoi, 992 Emmet Flats Apt. 143', 13.91376300, 108.76789200, '2026-01-27', NULL, '1-2 hours', 'Weekly', 9, 4, 21, '[\"Marketing\",\"First Aid\",\"Photography\"]', 'No experience', 'Paused', NULL, 163, 50, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(87, 'org_6931b6cab92f0', 2, 'Autem nulla ipsa nam et.', 'Qui provident rem corporis libero non velit quam. Asperiores et id omnis molestiae temporibus quos omnis. Magni voluptas debitis sed quo ullam fugiat odio. Maiores aut eos similique aspernatur quas sed.', NULL, NULL, 'Hanoi, 31754 Ivah Parkways Apt. 041', 21.68473800, 106.17126400, '2025-12-13', '2025-12-21', '6-8 hours', 'Flexible', 8, 2, 21, '[\"Teaching\",\"Translation\"]', 'Some experience', 'Completed', NULL, 440, 42, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(88, 'org_6931b6cab92f0', 2, 'Repellat et consequatur at incidunt.', 'Sed illo vel porro voluptas. Magni fuga eos ut dolore. Laborum distinctio incidunt ea. Debitis ea laudantium laboriosam atque. Numquam cumque nihil voluptas occaecati tenetur earum iusto quibusdam. Qui quo eos et sint. Sit consequatur architecto dolor voluptate.', 'Expedita beatae voluptas architecto ab. Natus laudantium aperiam excepturi voluptatibus id est autem.', NULL, 'Hanoi, 830 Norma Mountains', 15.26250100, 102.06306100, '2025-12-31', '2025-12-31', '3-5 hours', 'One-time', 17, 2, 16, '[\"Teaching\",\"Translation\"]', 'Experienced', 'Cancelled', NULL, 89, 49, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(89, 'org_6931b6cab92f0', 5, 'Velit assumenda aut eos dolores sed.', 'Aut eaque omnis debitis odio. Cumque quisquam sunt minus illo veritatis id ipsum. Voluptatem debitis eveniet nihil vel nam. Possimus voluptatum repellendus non. Qui et omnis veritatis magni. Ipsam nemo et maiores.', NULL, NULL, 'Ho Chi Minh City, 476 Kshlerin Canyon Suite 591', 15.79452600, 103.67276100, '2026-01-17', '2026-02-11', 'Multiple days', 'Flexible', 4, 0, 21, '[\"First Aid\",\"Teaching\",\"Translation\"]', 'No experience', 'Paused', NULL, 493, 50, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(90, 'org_6931b6cab92f0', 3, 'Omnis magnam consectetur autem molestiae libero accusamus.', 'Temporibus itaque harum est facere. A ut nam atque. Sed expedita temporibus voluptatum et debitis et voluptatem. Distinctio illum dolorem soluta quae quo. Est porro quas aut corporis eveniet. Quasi laudantium reprehenderit voluptatem fuga aliquam. Et at ad est error.', 'Corrupti voluptas dolor optio velit ut ea. Explicabo inventore quae maiores perferendis rem quaerat. Beatae repellat iste dolor mollitia libero laborum.', NULL, 'Da Nang, 37195 Balistreri Villages Suite 232', 12.39542600, 105.03831800, '2026-01-31', '2026-02-16', '1-2 hours', 'Monthly', 10, 2, 18, '[\"Photography\",\"Design\",\"Programming\",\"Cooking\"]', 'Experienced', 'Completed', NULL, 142, 43, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(91, 'org_6931b6caba232', 7, 'Quasi quae at iusto.', 'Impedit molestias amet occaecati quod non earum vitae. Sunt suscipit dolore quos nulla aliquid. Ab veritatis nostrum omnis ab aspernatur. Quia placeat sequi magnam ullam velit quo mollitia. Ut ut nobis aut quisquam et porro. Debitis sit rem sit eaque quis distinctio aut. Quam dolor corrupti qui adipisci quis.', 'Natus dolor expedita explicabo sunt quia et et. Labore eaque facilis laudantium sapiente dolorem dicta temporibus. Cumque voluptas adipisci sed et sit.', NULL, 'Hai Phong, 89431 Lorna Mountains Suite 437', 12.16335400, 107.77573600, '2026-01-15', NULL, 'Full day', 'Monthly', 8, 5, 21, '[\"Marketing\",\"Cooking\",\"Teaching\"]', 'Some experience', 'Active', '2025-12-11', 263, 16, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(92, 'org_6931b6caba232', 5, 'Explicabo id aut iste voluptate.', 'Ea magnam et nihil et. Cumque amet dolorum aut sequi. Neque et consequatur porro ipsa. Officia ad quae quaerat assumenda cupiditate. Et aut a aut magni harum. Dolore dolore ratione fuga quas cupiditate.', 'Nemo beatae recusandae sint rerum et enim. Rerum sit dolorem optio ad quia harum ratione reiciendis. Voluptatem placeat aspernatur error quidem omnis distinctio.', 'Eos sed non molestiae ipsam. Aliquam esse soluta reprehenderit facilis eligendi sunt quis. Reprehenderit officiis eum occaecati dolores et.', 'Ho Chi Minh City, 54315 Boyer Highway', 12.79984500, 102.14362500, '2025-12-24', NULL, '3-5 hours', 'Monthly', 12, 0, 21, '[\"First Aid\"]', 'Experienced', 'Completed', NULL, 70, 33, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(93, 'org_6931b6caba232', 3, 'Sed nobis quos eaque repudiandae illum id.', 'Et ut non quia eos adipisci. Officia dolores non rerum aliquid. Sunt explicabo autem suscipit non earum ut iste. Similique repellendus quis nostrum quis possimus nulla.', 'Voluptatem voluptatem voluptas esse consequatur. Voluptas quo et voluptatem ut est.', 'Quia excepturi eveniet assumenda sunt odit sequi. Asperiores voluptatem deserunt vero vero aut odit.', 'Da Nang, 39410 Vance Lodge', 12.67951300, 105.35863400, '2026-01-12', '2026-01-19', '1-2 hours', 'Weekly', 13, 4, 21, '[\"Cooking\"]', 'No experience', 'Paused', '2026-01-11', 11, 4, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(94, 'org_6931b6caba232', 2, 'Sequi est corporis est.', 'Qui dignissimos ad magni aperiam. Beatae minima cumque ipsa eum. Voluptas occaecati adipisci id. Maiores consequatur quas molestiae harum amet et eos.', 'Voluptatibus inventore tenetur sit vel minus. Veritatis ipsa a inventore consequatur sunt modi.', 'Ad et commodi officia quia nihil. Debitis illum eaque et mollitia corporis fugit.', 'Can Tho, 750 White Dam', 16.54511200, 107.76222200, '2025-12-16', NULL, '3-5 hours', 'One-time', 2, 4, 21, '[\"Cooking\",\"Translation\",\"Programming\",\"Design\"]', 'Experienced', 'Paused', NULL, 200, 1, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(95, 'org_6931b6caba232', 1, 'Voluptates voluptatibus et et commodi.', 'Molestiae blanditiis commodi magnam quibusdam omnis eaque consequatur. Neque omnis et rerum et voluptas. Ut tenetur neque recusandae omnis id. Non id inventore non sit quae tempora. Ex ut impedit deserunt fugiat. Ratione eaque natus maiores molestiae qui aut voluptatum. Consequatur soluta a quaerat omnis.', 'Porro cum rerum eum accusantium dolorem quia explicabo. Est aut est dolores earum ut occaecati ex.', NULL, 'Hai Phong, 10477 Boyle Mill Apt. 666', 12.84011400, 106.73807700, '2026-01-10', NULL, '1-2 hours', 'One-time', 17, 2, 16, '[\"Teaching\",\"Marketing\"]', 'Some experience', 'Paused', NULL, 10, 45, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(96, 'org_6931b6caba232', 5, 'Enim dolorum sint culpa ducimus inventore eligendi in.', 'Tenetur et minus amet non nulla qui. Quasi et eos minus et. Iure molestias ut et sint illo et harum exercitationem. Qui porro recusandae consequatur aliquid quo vitae.', NULL, NULL, 'Ho Chi Minh City, 181 Nikolaus Avenue Suite 036', 16.13636900, 105.40144000, '2026-01-14', '2026-02-14', '1-2 hours', 'Monthly', 12, 3, 16, '[\"Writing\"]', 'Some experience', 'Paused', '2025-12-13', 491, 41, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(97, 'org_6931b6cabb2c3', 4, 'Provident harum odit cupiditate qui nostrum non corporis.', 'Voluptatem voluptas velit at ea sed ut. Possimus omnis qui sed et voluptatem qui veniam perspiciatis. Corrupti odit repudiandae beatae dignissimos minus id vero. Omnis quia animi earum expedita quidem eligendi et. Delectus consequatur qui quo similique itaque assumenda nostrum. Cumque nostrum ut fuga fugit natus culpa. Voluptate quia assumenda et iusto iusto.', NULL, 'Optio consequatur quos qui eaque illo ducimus. Eos beatae illo porro culpa asperiores magnam voluptatem et.', 'Hanoi, 9887 Altenwerth Shore', 10.23717200, 104.77359800, '2025-12-27', NULL, 'Full day', 'Monthly', 9, 3, 18, '[\"Teaching\"]', 'No experience', 'Paused', '2025-12-27', 1, 15, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(98, 'org_6931b6cabb2c3', 4, 'Perferendis porro velit occaecati doloribus.', 'Dolor dolorem molestiae facere iusto cupiditate quia. Ut nulla quas id quo. Autem necessitatibus ut blanditiis et eius error et. Autem repudiandae accusantium culpa ut. Voluptas nisi ut in libero facere officia dolor. Numquam fuga ut dicta quos nesciunt non vitae corporis.', 'Omnis omnis repellat et et. Rerum nihil ut autem aut molestias iste dolorem.', NULL, 'Da Nang, 267 McLaughlin Islands Apt. 481', 13.05400600, 103.70153100, '2025-12-12', '2026-01-06', 'Multiple days', 'One-time', 8, 4, 21, '[\"Cooking\"]', 'Some experience', 'Paused', NULL, 33, 27, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(99, 'org_6931b6cabb2c3', 4, 'Eligendi quidem eum eaque ea voluptas.', 'Rerum eveniet necessitatibus aliquam numquam ex. Commodi omnis aliquid impedit qui omnis eum ex. Omnis earum aliquam est ullam quos modi unde. Nisi placeat perspiciatis at debitis accusantium. Sint harum magnam non hic ut et eveniet.', 'Non animi nulla vel ut mollitia hic. Qui sint rerum odit enim minima excepturi.', NULL, 'Can Tho, 2586 Abby Turnpike Apt. 588', 17.31518800, 102.93659700, '2026-01-01', '2026-01-09', '3-5 hours', 'Monthly', 6, 5, 21, '[\"Design\",\"Writing\",\"Cooking\",\"Programming\"]', 'Some experience', 'Paused', NULL, 306, 48, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(100, 'org_6931b6cabc18d', 1, 'Aut non accusantium hic cupiditate.', 'Magnam ab aut doloremque animi eos sunt ab. Est et repellat qui molestias deleniti nostrum similique. Corporis voluptatem voluptatem beatae unde voluptatum. Beatae cupiditate totam et odit ut. Hic laboriosam quia et est.', 'Suscipit distinctio eius et enim eum et numquam eligendi. Ut veniam laboriosam similique architecto quas vel error. Excepturi enim itaque adipisci accusamus sed aperiam cumque.', 'Vitae eos voluptatem cupiditate non fugiat. Aperiam aut velit enim aut perspiciatis pariatur. Et accusantium sunt quae asperiores.', 'Da Nang, 98713 Isabelle Trail Suite 825', 18.91318000, 105.19479200, '2026-01-21', NULL, '6-8 hours', 'Flexible', 6, 0, 21, '[\"Photography\",\"Writing\",\"Programming\",\"Design\"]', 'No experience', 'Paused', '2025-12-15', 154, 32, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(101, 'org_6931b6cabc18d', 7, 'Aut accusantium adipisci autem cumque repellendus.', 'Cumque totam qui eligendi est voluptatem. Sint consequatur omnis deleniti officia quos delectus et. Rem rerum ad earum recusandae delectus cupiditate. Eos cupiditate beatae eius voluptates. Ut molestiae aut repellendus recusandae porro et accusantium.', 'Harum officia consequatur delectus perferendis. Inventore id corrupti ullam sapiente nam. Corporis est tenetur molestiae quo rem quis et maxime.', NULL, 'Da Nang, 7747 Morton Gateway Apt. 680', 12.21696400, 104.87159700, '2025-12-23', '2026-02-16', 'Full day', 'Weekly', 19, 2, 21, '[\"Teaching\",\"Translation\",\"Programming\",\"Writing\"]', 'Experienced', 'Paused', NULL, 450, 10, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(102, 'org_6931b6cabc18d', 1, 'Veritatis sunt dolorem similique harum commodi beatae.', 'Mollitia harum dolorum molestias nobis quo. Voluptates et similique minima esse illum. Et optio eaque dolorum maiores blanditiis cum. Laboriosam quia ea dolores. Id perferendis non maxime provident cum. Voluptas corrupti ex aut tempore. Est adipisci voluptatem et sunt voluptatem qui dolores.', NULL, 'Explicabo quos eum qui voluptates possimus. Dolor voluptatem et eligendi eveniet reiciendis. Dolorum eius rerum sint qui repellat.', 'Can Tho, 907 Turner Islands', 12.69210900, 103.49612200, '2026-01-29', NULL, '6-8 hours', 'One-time', 1, 2, 21, '[\"Photography\",\"Programming\",\"Design\"]', 'Some experience', 'Completed', '2025-12-17', 36, 24, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(103, 'org_6931b6cabc18d', 8, 'Et repellat aut voluptas aliquam.', 'Dolorum id odio mollitia quasi in. Odio mollitia culpa voluptatibus quidem ducimus. Et eum temporibus quod consequatur maiores. Dolor laborum beatae ipsam ut.', NULL, NULL, 'Hai Phong, 49081 Herbert Wells Suite 601', 13.63088700, 108.08611600, '2026-01-12', NULL, '3-5 hours', 'One-time', 4, 1, 21, '[\"Translation\",\"First Aid\",\"Writing\",\"Programming\"]', 'No experience', 'Completed', '2025-12-20', 428, 30, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(104, 'org_6931b6cabc18d', 1, 'Non vitae qui voluptatum et.', 'Iste maiores est doloremque et saepe iste. Qui numquam natus accusamus minima iste quibusdam sunt. Quae dignissimos cumque vel eum debitis natus. Maiores et minima ducimus nulla qui aut debitis quidem. Alias fugit est deleniti et rerum. Tempore eius accusantium aliquid alias voluptatem.', 'Eveniet saepe quia non odit optio et ipsam. Fugiat nemo alias atque voluptas modi. Ut voluptas architecto laboriosam porro ipsum.', 'Iste possimus et velit provident id et. Quidem quae qui deleniti dolore et nostrum delectus.', 'Can Tho, 2073 Ebert Coves', 20.36650200, 107.72516800, '2025-12-18', '2026-02-14', '6-8 hours', 'One-time', 19, 2, 21, '[\"Translation\",\"Marketing\"]', 'Some experience', 'Active', '2025-12-07', 53, 33, '2025-12-04 16:29:00', '2025-12-09 06:26:03'),
(105, 'org_6931b6cabc18d', 8, 'Eos non voluptas dolore vero nobis eos nobis provident.', 'Numquam provident tempore nobis libero libero sit dolorem. Quo modi aliquid adipisci. Perspiciatis quis minus sequi. Nihil commodi voluptas inventore ad sit omnis.', 'Ipsam dignissimos quo hic ad. Quasi reprehenderit sed inventore atque cum architecto qui. Doloribus sit tempore eligendi quis ut tenetur.', 'Nulla facilis ut alias. Nam nemo debitis in numquam qui laborum. Officia placeat ea cumque dolorem omnis veniam facere.', 'Ho Chi Minh City, 7054 Reichel Shoal', 18.47537600, 109.41513300, '2026-01-25', NULL, 'Full day', 'One-time', 14, 0, 16, '[\"Photography\"]', 'No experience', 'Paused', NULL, 318, 19, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(106, 'org_6931b6cabc18d', 3, 'Non sunt culpa blanditiis vitae id est sequi.', 'Et eius debitis nam eum natus. Atque commodi culpa laudantium. Error doloremque et voluptatem iure rerum. Consequatur quis aspernatur explicabo qui rerum cumque est. Maiores nulla veniam cupiditate itaque laborum. Quia ullam id aut perferendis labore. Voluptas aut rerum placeat ullam ipsam.', 'Magnam magnam sequi dolorem. Omnis illo quaerat exercitationem quo quos dignissimos ab.', 'Temporibus eveniet in delectus accusantium vitae ullam dolorum. Et eius atque quia et et.', 'Can Tho, 11870 Helen Greens', 14.56865700, 106.64943400, '2026-01-21', NULL, '3-5 hours', 'Weekly', 2, 0, 16, '[\"First Aid\",\"Cooking\"]', 'Some experience', 'Cancelled', NULL, 138, 20, '2025-12-04 16:29:00', '2025-12-04 16:29:00'),
(107, 'org_6931b6f583cfa', 9, 'Ut laborum dolorum eum corporis quasi iure.', 'Veniam vel sunt est porro. Vitae et mollitia rerum nostrum ea ullam molestiae. Ratione quibusdam id non. Eligendi est ullam culpa et labore.', NULL, 'Vel sit voluptatem dolor non autem molestiae consequatur. Consequatur autem ratione temporibus dolorem nobis deleniti ducimus.', 'Can Tho, 5745 Roxane Lane Apt. 781', 22.76855000, 107.17535000, '2026-01-21', NULL, '3-5 hours', 'One-time', 10, 5, 21, '[\"Design\"]', 'Some experience', 'Completed', '2026-01-02', 353, 48, '2025-12-04 16:29:41', '2025-12-04 16:29:41'),
(108, 'org_6931b6fb6c5e6', 10, 'Minima odio mollitia dolorum a impedit ut aperiam.', 'Non iusto illo quis dicta ipsum. Iure autem dolores necessitatibus quia et. Aut voluptatem sed quia. Commodi incidunt quibusdam eum voluptates sapiente.', NULL, 'Veritatis facilis magnam et ad excepturi laboriosam et. Similique facere sit delectus ut dolor omnis vero. Ex doloremque similique consectetur minus.', 'Ho Chi Minh City, 3710 Schinner Lakes Apt. 092', 16.92103400, 102.38092500, '2025-12-09', '2025-12-20', 'Multiple days', 'Monthly', 4, 1, 16, '[\"Design\",\"First Aid\",\"Translation\"]', 'Experienced', 'Cancelled', NULL, 476, 25, '2025-12-04 16:29:47', '2025-12-04 16:29:47'),
(109, 'org_6931b70aa30d6', 11, 'At vel doloremque sit et adipisci tenetur iusto fugit.', 'Aut corrupti quibusdam eaque nostrum sed quibusdam. Dignissimos at aperiam qui et. Illo sit qui quasi ratione nesciunt non. Iure qui consectetur nulla accusantium illo. Repellat nesciunt rerum quo sed doloremque doloribus.', NULL, NULL, 'Hai Phong, 3136 Lexie Ramp Suite 473', 9.19074400, 109.66706100, '2026-01-18', '2026-02-27', 'Full day', 'Weekly', 9, 4, 16, '[\"Cooking\",\"Writing\",\"Marketing\",\"Photography\"]', 'No experience', 'Active', '2025-12-19', 166, 41, '2025-12-04 16:30:02', '2025-12-09 06:23:55'),
(110, 'org_6931b71251871', 12, 'Distinctio laboriosam harum consequatur laudantium.', 'Quidem perferendis molestiae nobis sit dolor aut ea. Et veniam quisquam amet rerum incidunt. Magnam maiores qui et deleniti. Ut veritatis et delectus animi ullam harum ipsam nisi.', NULL, NULL, 'Da Nang, 3176 Heaney Skyway Apt. 888', 11.98969200, 102.38220700, '2026-01-17', '2026-02-21', '3-5 hours', 'Monthly', 4, 4, 16, '[\"Programming\",\"First Aid\"]', 'Experienced', 'Active', '2026-01-14', 256, 45, '2025-12-04 16:30:10', '2025-12-09 14:19:12');

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
-- Đang đổ dữ liệu cho bảng `volunteer_profiles`
--

INSERT INTO `volunteer_profiles` (`profile_id`, `user_id`, `occupation`, `education_level`, `university`, `bio`, `skills`, `interests`, `availability`, `volunteer_experience`, `total_volunteer_hours`, `volunteer_rating`, `preferred_location`, `transportation`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 'PhD', ' University', 'Ea ea ut dolore possimus. Et quisquam doloribus mollitia quis id quia quas. Est in vitae iste id asperiores aliquam eos. Quos sapiente sed eos alias doloribus commodi.', '[\"Programming\",\"Teaching\",\"Music\"]', NULL, 'Flexible', NULL, 373, 3.56, 'Ho Chi Minh', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(2, 3, 'Home Appliance Repairer', 'Bachelor', 'Bashirian-Gislason University', 'Facilis esse quo facere sed occaecati quis dolor. Corporis enim commodi id itaque incidunt ab animi.', '[\"Design\",\"Teaching\",\"Music\",\"Marketing\"]', 'Harum voluptas ipsum officiis autem rerum expedita debitis.', 'Weekdays', 'Tenetur vero consequuntur exercitationem eos odit. Temporibus et libero vitae a consequuntur quasi.', 491, 1.33, 'Ho Chi Minh', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(3, 4, NULL, 'High School', 'Beahan, Turner and Bechtelar University', 'Consequatur nesciunt beatae dignissimos eveniet. Quis nemo et dolor dignissimos sapiente similique quos. Qui molestiae autem animi nihil quos.', '[\"Cooking\",\"Photography\",\"Writing\",\"Marketing\"]', 'Consequatur eveniet voluptatem consequatur molestiae et quia eaque.', 'Flexible', 'Qui corporis suscipit reiciendis sit dolor dolor ea. Consequatur facere excepturi soluta quod in odit molestiae. Voluptatem praesentium enim quia sit error.', 23, 3.31, 'Da Nang', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(4, 5, 'Nuclear Power Reactor Operator', 'Master', ' University', 'Autem numquam facilis suscipit aspernatur vel dicta eum nulla. Dolor et ipsam illo quidem praesentium. Praesentium neque ipsa repellendus vitae hic blanditiis.', '[\"Music\",\"Data Entry\"]', 'Non non autem itaque tempora.', 'Weekends', NULL, 335, 3.29, 'Ho Chi Minh', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(5, 6, 'Engineering Teacher', 'Master', 'Runte-Swift University', NULL, '[\"Data Entry\",\"Gardening\",\"Programming\",\"Photography\",\"Sports\",\"Music\"]', NULL, 'Flexible', 'Est facilis ipsum voluptatem consectetur animi eum. Laudantium veritatis ex esse atque voluptas pariatur consequatur. Sunt ut unde est itaque maiores ipsum ut.', 485, 4.30, 'Any', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(6, 7, NULL, 'High School', ' University', 'Accusamus deleniti et excepturi cupiditate veniam sit vitae. Non saepe dolore voluptas natus inventore.', '[\"Data Entry\",\"First Aid\",\"Photography\",\"Sports\",\"Gardening\"]', 'Consectetur sequi aut consequatur magni delectus dolor delectus.', 'Full-time', NULL, 124, 3.86, 'Ho Chi Minh', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(7, 8, NULL, 'PhD', 'Hettinger and Sons University', NULL, '[\"Sports\",\"Counseling\",\"Gardening\"]', NULL, 'Full-time', 'Quos sint voluptas quia recusandae accusamus labore natus. Sit ut illo eligendi deserunt qui.', 488, 2.58, 'Any', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(8, 9, 'Mixing and Blending Machine Operator', 'High School', 'Halvorson-Conroy University', NULL, '[\"First Aid\",\"Gardening\",\"Photography\",\"Programming\",\"Data Entry\"]', NULL, 'Flexible', 'Quia aut qui est nulla qui omnis nemo. Sint voluptatem quasi repudiandae aliquam. Nemo deserunt quae molestiae aperiam expedita aspernatur.', 441, 0.26, 'Any', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(9, 10, 'Warehouse', 'PhD', ' University', NULL, '[\"Photography\",\"Cooking\"]', 'Non qui exercitationem quidem maiores perferendis.', 'Full-time', 'Est eveniet eius impedit consequatur. Voluptate in vel dolores et.', 487, 0.22, 'Any', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(10, 11, NULL, 'PhD', ' University', NULL, '[\"Gardening\",\"Design\",\"Cooking\"]', 'Est alias delectus fugiat dolores architecto quod dolor.', 'Weekends', NULL, 198, 1.40, 'Ho Chi Minh', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(11, 12, NULL, 'Master', ' University', NULL, '[\"Sports\",\"Counseling\",\"First Aid\",\"Music\",\"Gardening\"]', 'Occaecati architecto consectetur quis reprehenderit unde rerum suscipit.', 'Weekdays', 'Sed illum fuga dolorum beatae. Nemo voluptatem cum tenetur et.', 414, 1.42, 'Ho Chi Minh', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(12, 13, 'Insurance Investigator', 'PhD', ' University', 'Blanditiis adipisci perspiciatis at et consequatur. Expedita repudiandae magnam quo sunt voluptas. Non dolores consequuntur reprehenderit voluptatem quis esse. Dolor rerum quo molestiae.', '[\"Data Entry\",\"Counseling\",\"First Aid\",\"Music\",\"Writing\",\"Design\"]', NULL, 'Flexible', NULL, 361, 4.56, 'Hanoi', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(13, 14, NULL, 'PhD', 'Rempel and Sons University', NULL, '[\"Sports\",\"Gardening\"]', NULL, 'Full-time', 'Quia nihil aliquid neque laudantium ratione. Optio optio quibusdam vel pariatur expedita.', 278, 4.30, 'Ho Chi Minh', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(14, 15, NULL, 'PhD', 'Mayert, Oberbrunner and Bergstrom University', 'Et id voluptates quo corporis laudantium maiores praesentium. Nihil fugiat autem voluptas omnis sapiente minima quia. Suscipit amet eaque ratione ipsa non.', '[\"First Aid\",\"Writing\",\"Cooking\",\"Marketing\"]', 'Quae dolor qui sed quasi eos voluptatem.', 'Flexible', 'Fuga quam voluptatibus fugiat vitae. Sequi dolor ad deserunt consequatur ut iste omnis voluptatum.', 77, 3.98, 'Hanoi', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(15, 16, NULL, 'PhD', 'Doyle Ltd University', 'Vero iure nobis cum illo eaque at. Et dolores maiores laboriosam expedita et molestiae ut. Sunt provident at quas omnis repudiandae rerum et. Aspernatur omnis ipsum minima id.', '[\"Music\",\"Programming\"]', 'Doloremque nihil nisi consectetur.', 'Full-time', 'Magni quae voluptates perspiciatis incidunt voluptatum amet sunt. Tempore qui et iure dicta quisquam. Et harum quidem ut optio quaerat ipsum tenetur.', 407, 0.38, 'Hanoi', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(16, 17, 'Conveyor Operator', 'PhD', ' University', 'Et culpa porro quia facilis voluptas similique animi. Rerum voluptate molestias tempora quas corrupti sunt. Nostrum animi quia et officia aperiam dicta.', '[\"Translation\",\"Gardening\",\"Writing\"]', NULL, 'Flexible', NULL, 17, 2.39, 'Hanoi', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(17, 18, 'Precision Instrument Repairer', 'Bachelor', ' University', 'Tenetur doloremque ea ea praesentium velit voluptates ipsa. Et doloremque vel nihil est sed et. Aperiam architecto quia cupiditate. Voluptatibus minima est earum qui.', '[\"Data Entry\",\"Translation\",\"First Aid\",\"Cooking\",\"Programming\"]', NULL, 'Full-time', NULL, 134, 4.16, 'Any', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(18, 19, NULL, 'Master', ' University', NULL, '[\"Data Entry\",\"First Aid\",\"Design\"]', 'Dolorem sequi occaecati eum repellendus id.', 'Flexible', NULL, 74, 4.64, 'Ho Chi Minh', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(19, 20, NULL, 'PhD', 'Wolff, Connelly and Wolff University', 'Sit nihil voluptatum soluta commodi magnam. Aut explicabo eum ex quia porro. Quidem non ipsa aliquam expedita ab sint aliquam. Exercitationem qui distinctio voluptates quis occaecati sed repellat.', '[\"Counseling\",\"Cooking\"]', NULL, 'Weekends', NULL, 107, 4.35, 'Ho Chi Minh', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(20, 21, 'Art Director', 'Master', 'Graham, Block and Considine University', NULL, '[\"Music\",\"Teaching\",\"Data Entry\",\"Design\"]', 'Qui dignissimos dolorem optio ut est.', 'Weekends', 'Minus qui laudantium nobis aspernatur qui delectus. Placeat vel est repudiandae asperiores. Delectus sit sint velit quia qui maxime earum.', 444, 5.00, 'Da Nang', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(21, 22, 'Administrative Support Supervisors', 'Diploma', 'Mohr, Keebler and Dicki University', 'Mollitia officiis velit labore accusantium voluptatem animi. Autem possimus expedita temporibus omnis sunt ut. Id temporibus vitae alias alias sed.', '[\"Marketing\",\"Gardening\",\"Music\",\"Teaching\"]', 'Debitis consequuntur eligendi aliquid maiores consequuntur ut nesciunt.', 'Weekdays', 'Ea ratione sapiente dolore ratione. Veniam quas perspiciatis in et eos aliquam vitae.', 431, 1.67, 'Hanoi', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(22, 23, NULL, 'Diploma', 'Cremin-Casper University', 'Consequatur qui debitis adipisci quasi harum. Est quidem consequatur iste sapiente commodi ea consequatur sapiente. Autem deserunt corrupti voluptatum optio quia quis. Ut ad illum autem totam ut inventore.', '[\"Marketing\",\"Design\",\"Gardening\",\"Sports\",\"Teaching\"]', NULL, 'Weekdays', NULL, 211, 3.97, 'Ho Chi Minh', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(23, 24, NULL, 'PhD', ' University', 'Voluptate occaecati hic et omnis voluptatem blanditiis quis ipsum. Quo aspernatur adipisci saepe quas repudiandae autem aut molestiae. Est deleniti eos voluptate iusto fugiat velit nesciunt. Explicabo est animi et laborum hic.', '[\"Data Entry\",\"Cooking\",\"Photography\",\"Sports\"]', NULL, 'Flexible', NULL, 350, 3.64, 'Da Nang', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(24, 25, NULL, 'Bachelor', 'Schmeler, Beatty and Gottlieb University', NULL, '[\"Programming\",\"Gardening\",\"Cooking\",\"Design\",\"Photography\"]', 'Provident aut doloribus exercitationem voluptatibus.', 'Flexible', NULL, 105, 1.17, 'Hanoi', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(25, 26, 'Hunter and Trapper', 'Bachelor', 'Pfannerstill, Mitchell and Kiehn University', NULL, '[\"Music\",\"Data Entry\",\"Writing\",\"Teaching\",\"Translation\"]', NULL, 'Full-time', NULL, 192, 1.37, 'Any', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(26, 27, NULL, 'High School', 'Wunsch-Grimes University', NULL, '[\"Sports\",\"Design\",\"Translation\",\"Music\",\"Programming\"]', NULL, 'Weekends', 'Laudantium quisquam voluptates molestiae necessitatibus. Rerum ex nostrum dolor repellat numquam nobis.', 120, 2.49, 'Da Nang', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(27, 28, NULL, 'Bachelor', 'Carroll-Kunze University', NULL, '[\"Gardening\",\"First Aid\"]', 'Ea ab nam quo quod exercitationem aspernatur rerum.', 'Weekends', NULL, 247, 4.20, 'Ho Chi Minh', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(28, 29, NULL, 'Master', 'Reynolds-Corkery University', 'Minima est facilis id consequatur magnam tempora. Veritatis id expedita vitae quo eos. Iure sint ipsum nam commodi exercitationem.', '[\"Writing\",\"First Aid\"]', 'Porro impedit consequatur et laudantium veniam voluptatem.', 'Full-time', NULL, 396, 0.89, 'Da Nang', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(29, 30, 'Archeologist', 'Bachelor', 'O\'Conner-Jenkins University', NULL, '[\"Gardening\",\"First Aid\"]', NULL, 'Full-time', NULL, 350, 4.56, 'Hanoi', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(30, 31, NULL, 'PhD', ' University', 'Nobis voluptas a consectetur. Suscipit consequuntur animi laboriosam debitis odit non aliquid nesciunt. Eaque et repellendus enim quibusdam cum error.', '[\"Counseling\",\"Translation\"]', 'Et velit a ut hic blanditiis.', 'Weekdays', NULL, 169, 1.40, 'Any', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(31, 32, 'Housekeeper', 'PhD', ' University', NULL, '[\"Teaching\",\"Data Entry\",\"Design\",\"Marketing\",\"Translation\"]', 'Aliquam consequatur aut in rerum sunt ut.', 'Full-time', 'Ipsam eos odio perspiciatis ut. In excepturi quod labore.', 65, 0.20, 'Ho Chi Minh', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(32, 33, 'Ophthalmic Laboratory Technician', 'High School', 'Littel Ltd University', 'Veritatis consequatur qui magni est illum et. Eum reprehenderit iure eligendi est quia inventore. Omnis rerum non iusto et hic necessitatibus et. Voluptas possimus velit dignissimos occaecati exercitationem qui optio.', '[\"Counseling\",\"Writing\"]', 'Possimus dolorum facere inventore sit eveniet.', 'Weekdays', 'Provident impedit quod rerum aliquam necessitatibus quia veniam. Molestiae impedit error voluptates. Qui quisquam adipisci repudiandae soluta quia voluptates.', 212, 4.28, 'Ho Chi Minh', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(33, 34, NULL, 'Bachelor', ' University', 'Earum debitis tempora dignissimos est aut praesentium veritatis. Ad quo illum qui id veritatis ut. Soluta voluptatem nobis qui est possimus maiores. Corporis nihil odio expedita soluta ut.', '[\"Sports\",\"Cooking\",\"Marketing\",\"Music\",\"Writing\"]', 'Nemo laudantium omnis laborum qui soluta unde doloribus.', 'Flexible', NULL, 275, 3.83, 'Any', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(34, 35, NULL, 'Master', ' University', NULL, '[\"Sports\",\"Photography\",\"Cooking\",\"Marketing\"]', 'Voluptatum at eum corporis iure voluptate nam odio.', 'Weekends', 'Et asperiores veritatis et voluptas. Non non expedita amet temporibus quod nesciunt sint. Aut magni qui occaecati facilis expedita voluptatem nisi.', 109, 4.82, 'Hanoi', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(35, 36, 'Welder-Fitter', 'Bachelor', ' University', NULL, '[\"Data Entry\",\"Counseling\",\"Cooking\"]', NULL, 'Full-time', 'Amet autem nobis excepturi saepe dolorem blanditiis cumque veritatis. Autem dolorem porro molestias non ab et delectus.', 313, 3.25, 'Ho Chi Minh', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(36, 37, 'Legislator', 'PhD', ' University', 'Autem eaque assumenda voluptatem. Itaque quasi vel consequuntur corporis qui. Quae laudantium et rerum consequatur. Inventore dolore repudiandae cumque eos reprehenderit.', '[\"Programming\",\"Gardening\",\"Translation\"]', 'Asperiores sit magnam explicabo sunt optio cum neque cupiditate.', 'Weekdays', 'Est fugit rem suscipit ipsam repellendus voluptates. Libero eveniet nemo quas non soluta. Iste eveniet sunt molestiae dolor vero officiis excepturi dolorem.', 153, 0.77, 'Ho Chi Minh', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(37, 38, 'Executive Secretary', 'Bachelor', ' University', 'Officiis saepe repellat accusantium repudiandae. Totam magnam qui mollitia rerum aliquam culpa repudiandae suscipit. Consequatur voluptate animi earum quibusdam perspiciatis aut. Dolore consequuntur distinctio molestias omnis accusantium.', '[\"Cooking\",\"Programming\",\"Counseling\"]', 'Ducimus sunt magni quod voluptatem in consequuntur.', 'Weekdays', NULL, 383, 4.31, 'Any', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(38, 39, 'Shoe and Leather Repairer', 'Bachelor', ' University', 'Accusamus quidem doloremque sed in ea aut beatae. Ipsa qui ipsa perferendis facilis eaque sunt molestiae.', '[\"Photography\",\"Writing\",\"Cooking\",\"Design\",\"Teaching\"]', 'Nostrum nobis qui ullam placeat.', 'Weekdays', NULL, 128, 1.02, 'Ho Chi Minh', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(39, 40, NULL, 'Master', ' University', 'Alias numquam ut pariatur quia cum quo. Dolorem explicabo necessitatibus iste dolor id sed ut. Totam rem et consequuntur.', '[\"Data Entry\",\"Programming\",\"Teaching\",\"Music\",\"Sports\"]', 'Non quia possimus qui reiciendis.', 'Flexible', NULL, 99, 1.92, 'Hanoi', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(40, 41, 'Aircraft Engine Specialist', 'PhD', 'Howell and Sons University', 'Natus repellat aut deserunt vel. Veritatis ab adipisci distinctio consequuntur sequi consequatur. Reiciendis quos sit laborum velit expedita blanditiis. Dolor aut quam consequatur quam voluptas cumque. Quaerat doloribus nisi non quidem facilis esse maxime.', '[\"Gardening\",\"Data Entry\",\"Teaching\",\"Sports\",\"Writing\",\"Cooking\"]', 'Fugit placeat dolores eaque assumenda corporis sapiente sit.', 'Weekends', 'Dignissimos et enim ipsam numquam porro sit. Voluptatem ipsa excepturi molestiae quibusdam. Nulla commodi excepturi soluta quibusdam natus quis unde.', 329, 1.18, 'Hanoi', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(41, 42, 'Manager Tactical Operations', 'Master', ' University', 'Asperiores neque sapiente et sapiente. Perferendis incidunt molestiae blanditiis eligendi sint nemo laboriosam. Eos nesciunt similique iusto provident.', '[\"Photography\",\"Music\"]', NULL, 'Weekends', 'Eaque nemo qui est quos error voluptatem. Qui sed nihil nostrum sapiente magni nihil iste. Rerum et fugit nesciunt numquam molestias dolore.', 381, 3.25, 'Hanoi', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(42, 43, NULL, 'Master', ' University', NULL, '[\"Translation\",\"Marketing\"]', NULL, 'Weekends', 'Est pariatur quia esse et molestiae porro ut. Et maiores et tempora quisquam quo. Corporis omnis unde excepturi illum cupiditate.', 488, 4.38, 'Any', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(43, 44, 'Locksmith', 'Master', ' University', NULL, '[\"Data Entry\",\"Music\",\"Translation\",\"Design\",\"Photography\",\"Gardening\"]', 'Minima omnis quia quia eum similique.', 'Flexible', 'Eveniet atque reprehenderit sequi reprehenderit eum ratione explicabo. Optio harum nisi nobis qui sapiente sunt.', 104, 3.99, 'Hanoi', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(44, 45, NULL, 'Bachelor', ' University', 'Porro non quis rem quia fugiat. Enim vero quia ut tenetur repellendus. Numquam doloremque omnis eum ut. Error similique placeat illum ut delectus.', '[\"Gardening\",\"Music\",\"Design\",\"Marketing\",\"First Aid\"]', 'Eveniet numquam qui cumque veritatis id.', 'Full-time', NULL, 356, 2.01, 'Ho Chi Minh', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(45, 46, NULL, 'High School', ' University', 'Pariatur et delectus quibusdam sed sequi. Natus consequatur in quod dicta perspiciatis. Molestiae vitae quidem eligendi nulla magnam et.', '[\"Data Entry\",\"Photography\",\"Music\",\"Gardening\",\"Counseling\"]', NULL, 'Full-time', 'Impedit adipisci a et cupiditate veniam dolor. Quis impedit amet sit recusandae. Ut asperiores sit repellat quaerat sit quisquam et.', 318, 4.68, 'Hanoi', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(46, 47, NULL, 'PhD', ' University', 'Et eum aperiam accusantium porro est. Repudiandae earum facilis consequatur architecto quia expedita nulla.', '[\"Sports\",\"Design\",\"Programming\",\"Teaching\"]', NULL, 'Flexible', NULL, 112, 2.41, 'Da Nang', 'Motorbike', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(47, 48, NULL, 'Master', 'Koss-Auer University', 'Neque magni dicta dolorem culpa atque dolorem sit. Eligendi nulla numquam voluptas magni. Doloremque molestiae quia necessitatibus earum numquam vel aut nemo.', '[\"Teaching\",\"First Aid\",\"Counseling\",\"Data Entry\",\"Design\",\"Translation\"]', NULL, 'Full-time', 'Sed est nam architecto soluta nesciunt. Quia aut earum dolores explicabo non atque.', 204, 1.67, 'Any', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(48, 49, 'Automotive Technician', 'High School', ' University', NULL, '[\"Sports\",\"Design\",\"Translation\",\"Programming\",\"Marketing\"]', 'Delectus molestiae placeat at quis.', 'Flexible', NULL, 82, 4.83, 'Ho Chi Minh', 'Public Transport', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(49, 50, NULL, 'Bachelor', 'Hyatt-Conroy University', NULL, '[\"Design\",\"Photography\",\"Programming\",\"Translation\"]', 'Illo blanditiis nobis facilis aspernatur harum facilis.', 'Weekdays', NULL, 491, 1.63, 'Hanoi', 'Car', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(50, 51, 'Pastry Chef', 'Bachelor', 'Bayer-Smitham University', 'Earum sunt facere eveniet reprehenderit omnis odio minus. Quo nisi tempora sunt rem. Nemo rem in culpa delectus et.', '[\"Counseling\",\"First Aid\",\"Design\",\"Music\",\"Translation\"]', 'Tempora omnis atque dolore voluptatem molestiae est.', 'Flexible', NULL, 271, 1.44, 'Any', 'Walking', '2025-12-04 16:28:53', '2025-12-04 16:28:53'),
(51, 347, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL, NULL, '2025-12-04 16:31:34', '2025-12-04 16:31:34'),
(53, 349, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL, NULL, '2025-12-09 03:35:46', '2025-12-09 03:35:46'),
(54, 350, 'Sinh viên', 'Bachelor', 'Học viện Ngân hàng', 'Tôi là Hoa Sơn Quý ok', '[\"abc\",\"hoa sơn quý\"]', '[\"acb\",\"Education\",\"Environment\"]', 'Full-time', 'Giáo dục', 0, 0.00, 'Hà Nội', 'Motorbike', '2025-12-09 03:38:10', '2025-12-09 14:06:32');

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
  MODIFY `application_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `connections`
--
ALTER TABLE `connections`
  MODIFY `connection_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `participant_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `favorite_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=258;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `post_bookmarks`
--
ALTER TABLE `post_bookmarks`
  MODIFY `bookmark_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `like_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `post_media`
--
ALTER TABLE `post_media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `review_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

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
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;

--
-- AUTO_INCREMENT cho bảng `video_calls`
--
ALTER TABLE `video_calls`
  MODIFY `call_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `volunteer_activities`
--
ALTER TABLE `volunteer_activities`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT cho bảng `volunteer_opportunities`
--
ALTER TABLE `volunteer_opportunities`
  MODIFY `opportunity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT cho bảng `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  MODIFY `profile_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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

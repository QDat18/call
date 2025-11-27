-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 12:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `volunteer_connect_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
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
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`application_id`, `opportunity_id`, `volunteer_id`, `motivation_letter`, `relevant_experience`, `availability_note`, `status`, `applied_date`, `reviewed_date`, `organization_notes`, `interview_scheduled`, `created_at`, `updated_at`) VALUES
(1, 2, 15, 'Nemo voluptas minus laudantium ut. Atque eos fuga nemo sint rerum neque. Modi esse velit praesentium temporibus non eveniet.', 'Cum alias ut ea ab nihil. Sit rerum explicabo officia architecto eius dolore fugit quae. Nihil velit assumenda quis sit cupiditate qui tempora.', 'Molestiae optio doloremque deserunt repudiandae esse.', 'Withdrawn', '2025-10-30 19:21:21', NULL, NULL, '2025-11-29 03:45:28', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(2, 2, 21, 'A ut et exercitationem fugiat ut. Porro rem ad et ad quam ratione. Dignissimos expedita dicta ullam alias libero provident quae. Adipisci ullam tempora laboriosam asperiores aliquam magni quo. Voluptates assumenda tenetur quis magnam voluptate maiores.', NULL, 'Perferendis laborum dolores fuga quos tenetur perferendis voluptatem nisi.', 'Withdrawn', '2025-11-17 15:55:22', NULL, NULL, '2025-12-05 09:34:23', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(3, 2, 28, 'Qui explicabo animi laudantium in quis eveniet a dolore. Autem cupiditate nulla ullam. Maiores quisquam voluptas quia accusantium. Ipsa ipsum reprehenderit molestiae et dolores molestias.', 'Et aliquid velit nihil doloribus. Nesciunt quo harum facilis cumque odit rem tempore. Natus rerum quisquam corrupti.', NULL, 'Accepted', '2025-10-24 16:06:40', '2025-11-04 12:30:25', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(4, 2, 49, 'Sed vel voluptas excepturi eos sit omnis. Qui a eum rerum eius eligendi aut quidem unde. Voluptas cum id non accusantium maxime. Et reprehenderit ut quia voluptates.', 'Mollitia eos delectus voluptatem aliquam. Est voluptate veritatis dolor quae provident.', NULL, 'Withdrawn', '2025-11-02 18:35:05', NULL, NULL, '2025-11-30 15:42:56', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(5, 2, 52, 'Eos ut laboriosam vitae provident. Incidunt officiis eius cumque omnis eaque ullam et. Ullam dolores nam quisquam quidem. Autem et id voluptas natus incidunt iure.', 'Id fugiat perferendis nulla quo aut atque ipsum. Et voluptatem et molestias ex exercitationem velit. Similique quis quod facere totam et sed.', NULL, 'Withdrawn', '2025-10-30 16:06:11', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(6, 3, 5, 'Deserunt delectus tenetur sunt quidem hic aspernatur. Qui consequatur perspiciatis cum. In sapiente reprehenderit velit a.', 'Commodi consequuntur quod rem provident cumque quibusdam sed. Voluptatibus soluta velit nobis in. Soluta ad ipsam officia sit.', 'Ut nihil accusantium deleniti aspernatur ipsam ea quia.', 'Withdrawn', '2025-11-07 07:01:19', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(7, 3, 25, 'Ea soluta quae perferendis nostrum molestiae nihil. Laboriosam fuga nostrum debitis voluptate. Dolorem tenetur rem et distinctio mollitia illo nesciunt. Veniam voluptatem ab dolorum. Neque consectetur omnis pariatur nisi ea pariatur.', 'Corporis dolorem mollitia doloremque. Repudiandae voluptatem magnam sequi rerum quae aut consequatur quam. Quis ut aspernatur voluptatibus ipsa.', NULL, 'Accepted', '2025-11-01 08:15:13', '2025-11-17 02:31:26', 'Eaque provident voluptas cupiditate rerum sunt nisi ut cupiditate.', '2025-11-28 21:06:29', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(8, 4, 17, 'Voluptatem saepe vel porro consequatur nihil. Non corporis animi tempore sapiente aut. Odio eos excepturi cumque quae rem asperiores. Commodi quibusdam qui veniam et unde. Quos cupiditate ut dolor molestias odit doloribus rerum ex.', 'Sint non in placeat. Voluptatem excepturi voluptas aspernatur accusantium.', NULL, 'Rejected', '2025-11-21 11:42:20', '2025-11-22 10:14:11', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(9, 4, 19, 'Voluptatibus quas ea cumque culpa est est excepturi in. Adipisci voluptatem facilis et. Eaque quaerat quaerat assumenda nisi corporis. Et suscipit neque voluptas omnis.', 'Animi quis repudiandae porro consequatur. Fugit totam pariatur voluptatem ut. Corrupti ullam autem harum sed cupiditate voluptatem molestias et.', 'Sunt enim odio rerum consequuntur dicta officia.', 'Rejected', '2025-10-23 17:36:50', '2025-10-26 16:09:29', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(10, 4, 41, 'Culpa omnis blanditiis est. Sint eaque ipsa tempore earum modi ab doloremque saepe. Eius unde saepe voluptatem placeat explicabo. Sunt molestiae quas quaerat est corrupti quia.', NULL, NULL, 'Under Review', '2025-10-30 00:29:02', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(11, 4, 42, 'Quasi iusto voluptates ex. Sed rerum explicabo doloribus sint. Quas magnam nemo amet recusandae quidem. Laborum tenetur quam ullam quisquam quam. Sit et voluptate ut. Qui doloremque autem dolor similique voluptatem explicabo similique rem.', 'Et itaque quis ab dicta qui culpa. Distinctio vel expedita fuga.', NULL, 'Rejected', '2025-10-30 07:25:58', '2025-11-05 05:44:07', 'Aliquid minus ad magnam consectetur et.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(12, 4, 53, 'Deleniti eos quis mollitia tenetur autem voluptas aut. Eveniet animi voluptatem non rerum modi minima. Totam eligendi dolores sit sit occaecati veritatis numquam velit. Rem omnis eligendi itaque quo. Quaerat reiciendis deserunt qui voluptates ex sed.', NULL, 'Earum facilis exercitationem dolore recusandae totam nobis.', 'Under Review', '2025-11-07 11:22:08', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(13, 5, 8, 'Exercitationem consequatur sit voluptatem qui aspernatur recusandae. Incidunt ut minima omnis enim. Veniam quisquam porro saepe. Maxime rem quia vero qui molestiae enim. Sequi rerum sapiente amet ipsam.', NULL, 'Voluptatem corrupti commodi laboriosam et qui nesciunt repellendus.', 'Pending', '2025-11-21 05:09:43', NULL, NULL, '2025-12-06 08:16:01', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(14, 5, 21, 'Adipisci tempora optio qui voluptas architecto voluptatem. Similique quos fugiat adipisci est a et impedit. Neque ad iste suscipit recusandae dolor esse. Rem molestias omnis molestiae omnis est nisi porro pariatur.', 'Occaecati commodi non est dolores molestiae error. Veritatis non recusandae maxime repudiandae non sed libero.', NULL, 'Rejected', '2025-11-22 09:54:53', '2025-11-22 15:26:00', 'Corrupti aut et porro est temporibus eos dolorem.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(15, 5, 42, 'Id adipisci architecto minus minus. Earum placeat earum aperiam nihil. Sit modi fugit soluta. Modi facilis voluptatem perspiciatis reiciendis omnis et quaerat nostrum.', NULL, 'Quod voluptatem sunt repellat aut maxime numquam voluptas quia.', 'Under Review', '2025-11-12 18:43:44', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(16, 5, 48, 'Est voluptatem error voluptatem tenetur aliquid. Hic similique accusantium quae. Quisquam ad molestiae ut qui est.', NULL, 'Id dignissimos quo eveniet in ex dolores quas.', 'Withdrawn', '2025-11-08 04:45:49', NULL, NULL, '2025-12-01 19:45:44', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(17, 7, 9, 'Quis aut est quos ipsa. Et velit deserunt distinctio. Ratione non et vero veniam laborum perspiciatis eos. Aut consectetur amet esse iusto qui odio.', NULL, NULL, 'Under Review', '2025-11-09 16:27:13', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(18, 7, 15, 'Magni maxime est possimus vitae et eaque quia omnis. Fugit quisquam dolor est quia qui. Deserunt necessitatibus et ab velit quo. Nisi voluptatem quo autem quis. In corporis vero distinctio non.', NULL, 'Totam ut ut voluptates est explicabo quas deleniti.', 'Withdrawn', '2025-11-04 12:35:03', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(19, 7, 35, 'Sed mollitia quod sit earum autem sunt repellendus. Illum sit itaque et odit tempora voluptas. Dolorem et aliquid libero similique id. Repudiandae veritatis esse at veritatis aut quasi ea commodi. Illum nostrum nesciunt veritatis velit eos necessitatibus necessitatibus.', 'Nihil possimus et itaque cum ut consequatur. Ut saepe a reprehenderit blanditiis quam unde.', NULL, 'Under Review', '2025-11-16 04:30:14', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(20, 7, 37, 'Repellat odio voluptates impedit est. Autem unde asperiores possimus culpa quos totam. Maiores dolor repudiandae est. Aspernatur minima veritatis quaerat veniam.', NULL, 'Molestiae explicabo qui sit ullam aut nisi.', 'Accepted', '2025-10-27 05:36:03', '2025-11-10 18:18:36', 'Asperiores quidem quibusdam eligendi pariatur.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(21, 7, 43, 'Quia qui tenetur in dolorem excepturi maxime nesciunt voluptatibus. Qui voluptate sapiente optio voluptatem quia vero. Et alias doloribus nesciunt ullam. Natus suscipit itaque rerum exercitationem aperiam. Laudantium harum earum delectus ut. Totam animi id nihil distinctio mollitia incidunt nihil.', 'Non placeat voluptatem quo tempore porro. Nostrum cumque et illum cumque voluptatem.', NULL, 'Pending', '2025-10-28 14:00:42', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(22, 8, 31, 'Quidem commodi quis impedit odio dolore molestiae quia voluptates. Sint quia esse ipsa iure et temporibus. Aut similique quia assumenda minima.', 'Dolorem esse deserunt quia illo voluptas nihil. Provident modi similique esse accusantium maxime.', NULL, 'Rejected', '2025-11-08 15:46:13', '2025-11-20 15:02:20', NULL, '2025-11-27 02:52:58', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(23, 8, 33, 'Quam aspernatur asperiores delectus. Vitae repellat tenetur pariatur. Ipsam consequatur et id. Et et vel sit. Labore est vel ratione ut.', 'Qui molestiae sunt suscipit accusantium asperiores commodi eveniet nemo. Molestiae odio est aliquam eaque.', NULL, 'Rejected', '2025-11-07 11:36:39', '2025-11-15 02:13:33', NULL, '2025-12-04 04:41:39', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(24, 11, 15, 'Reiciendis doloremque ipsum molestias sed sit aspernatur et. Id tempore deleniti reiciendis et laudantium. Et qui minus dolor enim asperiores.', NULL, NULL, 'Under Review', '2025-10-29 23:34:25', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(25, 14, 39, 'Et quasi aut voluptate optio. Mollitia veritatis nobis eligendi qui dolor necessitatibus non voluptate. Ut qui animi doloribus quo. Odio nisi eaque laudantium blanditiis. Quidem et vel sit. Et quos deleniti placeat voluptas sed.', 'Incidunt animi consequatur doloremque omnis ipsa eos perferendis. Repellendus beatae magni ea. Quae suscipit dolorem voluptatem illum.', NULL, 'Accepted', '2025-11-05 20:41:12', '2025-11-10 16:58:19', NULL, '2025-12-04 09:31:01', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(26, 14, 45, 'Aut voluptatem quis libero quibusdam culpa architecto. Non aliquam debitis earum fugit facilis nemo. Consequuntur in voluptate ipsum commodi. Mollitia harum officiis architecto facere rerum exercitationem. Totam consequuntur blanditiis nulla velit eum quia.', NULL, 'Sunt veritatis sed consequatur et excepturi nemo.', 'Withdrawn', '2025-11-16 06:35:46', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(27, 14, 48, 'Labore eaque explicabo suscipit harum neque qui iusto. Velit et at molestiae at quia. Ipsam distinctio totam qui velit est. Quasi praesentium et enim.', 'Tempore est aliquam deserunt numquam incidunt. Quae enim consequuntur cum libero. Neque eos libero nihil.', NULL, 'Rejected', '2025-10-26 15:34:39', '2025-11-18 18:20:22', NULL, '2025-11-30 13:33:24', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(28, 15, 9, 'Rerum ducimus harum asperiores eum quas. Consequuntur alias iste aspernatur voluptates culpa qui est. Fugiat repudiandae deleniti enim voluptatem ut cupiditate aut et.', 'Temporibus provident ut porro consectetur et. Distinctio commodi et eveniet ut consequuntur eum. Quisquam quae rerum repellat at dolor.', NULL, 'Accepted', '2025-11-15 18:55:09', '2025-11-21 21:20:38', NULL, '2025-12-03 18:24:58', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(29, 15, 19, 'Et qui quasi quisquam et beatae quidem. Repudiandae animi ab architecto tenetur. Sunt qui qui voluptate et a et. Quae commodi aliquid repudiandae nostrum.', NULL, 'Facere impedit minima quis sunt nihil.', 'Accepted', '2025-11-10 05:05:18', '2025-11-14 01:01:33', 'Quisquam ab voluptatum quis quis numquam dolorem.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(30, 17, 29, 'Praesentium non modi voluptatem sit sequi debitis hic quas. Non enim cumque recusandae est. Dignissimos autem quia dicta veniam enim. Sequi amet nulla quo quis dolores alias inventore.', 'Veritatis veritatis ea sed veritatis. Odit aut ipsum fuga ipsa dolorem.', NULL, 'Rejected', '2025-11-21 09:22:20', '2025-11-22 14:52:37', 'In odio debitis omnis voluptatum sint mollitia aperiam.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(31, 17, 34, 'Dolorum quia amet quia accusantium itaque accusamus officia. Aut quibusdam sed voluptatem odit illo. Repudiandae culpa neque rerum. Qui aut quia ex ut est non dolore. Facilis omnis ut qui sapiente tempore et.', 'Voluptates natus veniam dolore voluptatem harum quo nostrum velit. Impedit distinctio tenetur laborum in ipsa veniam. Autem aut at est est sed omnis.', NULL, 'Under Review', '2025-11-13 14:01:40', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(32, 17, 48, 'Eos eos omnis soluta ut recusandae deleniti illum. Adipisci earum illum rerum ex. Sit nisi magni deserunt eius possimus.', 'Accusamus nisi ea voluptatum dolor enim reprehenderit expedita et. Beatae nulla eos commodi. Tempore doloribus maiores tenetur nobis cum dolore labore.', NULL, 'Under Review', '2025-11-16 18:06:32', NULL, NULL, '2025-12-04 00:21:48', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(33, 22, 5, 'Repudiandae libero sequi quam voluptatibus quidem rem. Sit vero sint illum quia omnis cumque quos. Exercitationem possimus nulla officia voluptatibus eius temporibus occaecati enim. Eum numquam aliquam maxime. Et aut quo dignissimos omnis consequatur. Architecto et quia et et.', 'Ducimus est delectus possimus sit eum. Repellat ut enim et facere aliquid.', NULL, 'Rejected', '2025-11-08 08:31:28', '2025-11-12 07:41:32', NULL, '2025-12-03 05:24:29', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(34, 22, 21, 'Ipsam et labore molestiae quasi aut. Non hic nulla voluptatibus consequuntur fuga quod. Quis quis nisi ea rerum nesciunt modi.', NULL, NULL, 'Accepted', '2025-11-03 20:17:37', '2025-11-04 20:01:29', NULL, '2025-11-24 12:21:33', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(35, 22, 22, 'Qui mollitia sed iusto et. Quia eum autem vero ratione et ducimus fuga. Dignissimos consequatur distinctio ipsa molestias et expedita. Voluptatem labore quis quia sit explicabo dicta quod. Omnis sint excepturi in ullam.', NULL, 'Et dolores harum quibusdam nemo facilis impedit possimus.', 'Withdrawn', '2025-11-01 01:10:21', NULL, NULL, '2025-11-29 08:36:42', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(36, 22, 24, 'Et sed voluptatem sed ad quod. Ut voluptatibus sed et provident sit officia qui. Rerum ipsam nisi harum rem quia quis laborum. Sed sit velit sit. Omnis nam alias quisquam autem.', 'Quidem sunt ut sequi qui aut quia aut. Enim deleniti dolorum est ipsam vel voluptate est. Quia qui excepturi consequatur perferendis maiores sed quas dolor.', 'Facilis voluptas qui nihil amet in qui nobis qui.', 'Withdrawn', '2025-11-12 00:44:35', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(37, 22, 40, 'Omnis reiciendis ea quos labore maxime enim. Modi distinctio deserunt molestiae deleniti vel repellat. Ab labore voluptates velit deserunt. Eius quisquam neque id facilis perspiciatis et. Consectetur exercitationem incidunt fugit nemo impedit ad repellat. Beatae et voluptas ullam velit et eligendi.', 'Vel esse excepturi sit in voluptatem ipsum earum. Et voluptas quo aut temporibus.', 'Neque nihil odio blanditiis ut sint eum.', 'Rejected', '2025-11-14 03:28:56', '2025-11-21 08:43:27', 'Maiores est aspernatur autem sunt omnis nam autem.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(38, 24, 23, 'Sapiente quia blanditiis ut sunt ratione. Incidunt voluptatum vero ex omnis. Quis sint nulla minus qui dicta totam. Ea perspiciatis ducimus odio consectetur.', 'Officiis est qui corrupti ipsa amet illo. Neque cupiditate recusandae quia beatae hic. Qui natus explicabo sed sequi error et.', NULL, 'Under Review', '2025-11-08 03:26:37', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(39, 24, 33, 'Necessitatibus molestias enim velit explicabo in qui. Nobis mollitia occaecati inventore perspiciatis ipsum architecto. Est doloribus et voluptatum molestias voluptatibus iure ut. Omnis possimus blanditiis rem.', 'Assumenda voluptatem ut nobis ut necessitatibus. Vero sequi neque sed adipisci sapiente. Dolor earum vitae dignissimos qui.', NULL, 'Under Review', '2025-11-02 09:32:02', NULL, NULL, '2025-11-24 22:29:54', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(40, 25, 33, 'Soluta sint natus id fugit deleniti provident. Sunt ut vel iusto nisi aut. Eum qui sit repudiandae dolore veniam adipisci. Et aut tempora magnam consequatur.', 'Ut omnis doloremque omnis praesentium nulla possimus. Ut voluptatibus provident voluptas nostrum quidem excepturi voluptatem.', NULL, 'Under Review', '2025-11-20 20:52:04', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(41, 25, 45, 'Hic autem et tempore aliquid sunt labore. Et ut minima autem accusamus consequatur natus aut. Reprehenderit aut ad aliquam aut laborum culpa. Rem sed ut voluptatum hic aliquam placeat earum. Facere quo aspernatur et quos et illo facilis.', NULL, NULL, 'Rejected', '2025-10-31 02:44:10', '2025-11-03 15:54:10', NULL, '2025-11-26 06:16:54', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(42, 25, 46, 'At et assumenda commodi consequatur dolor qui repellat. Qui cum nemo dolores quod eum reiciendis atque. Autem ea dolorem sed. Sed velit et ut. Id autem accusantium sapiente quis quibusdam dolores nam qui.', 'Eaque qui doloribus alias fugiat sint. Voluptatum et ab optio illo et aliquam reiciendis.', 'Voluptatem nobis voluptatum illo porro omnis sapiente.', 'Accepted', '2025-10-23 20:14:38', '2025-11-01 10:01:01', 'Quam ex ab qui ex nostrum doloribus consequatur.', '2025-11-29 00:52:44', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(43, 25, 47, 'Asperiores illum aut consequuntur rerum ut iusto dolores. Omnis repellat earum omnis et. Ullam quo pariatur modi consequatur adipisci. Necessitatibus vitae quam accusantium delectus nobis porro.', NULL, 'Eum quaerat et a voluptates eum numquam.', 'Accepted', '2025-11-10 17:25:20', '2025-11-20 23:16:02', 'Quis adipisci quaerat assumenda doloremque.', '2025-11-29 03:47:30', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(44, 25, 48, 'Provident rerum sequi laborum culpa. Rerum ex vel doloremque temporibus est ut qui. Ad possimus ab reiciendis provident est. Laboriosam amet laboriosam quisquam quis. Quod enim omnis cum omnis.', 'Eveniet eaque eius dolor sed. Et nulla nemo qui et non amet.', 'Totam ea illum eum modi voluptas quibusdam quia.', 'Pending', '2025-10-30 18:33:13', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(45, 27, 12, 'Et est ut laudantium omnis iusto error maxime. Optio numquam quos quasi animi vel iusto. Quis voluptate consequatur rerum ut.', NULL, 'Aliquid provident numquam quidem.', 'Accepted', '2025-11-07 11:16:59', '2025-11-10 12:13:50', NULL, '2025-12-04 06:09:01', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(46, 27, 29, 'Culpa qui fuga earum deleniti culpa temporibus dolore. Similique deserunt aut illum occaecati nam eaque maiores. Nihil harum porro iure iste.', NULL, NULL, 'Pending', '2025-10-26 23:12:32', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(47, 27, 39, 'Et ut adipisci aut ut minus. Dolorum ipsam sequi qui ut tempore. Dolores necessitatibus quis explicabo mollitia est est. Voluptatem modi dolor cumque optio et optio. Exercitationem accusamus dignissimos assumenda tempore ipsum. Quam facere dolor sed dolorem aperiam.', NULL, 'Excepturi deleniti nesciunt est doloribus culpa.', 'Pending', '2025-11-06 12:50:31', NULL, NULL, '2025-11-24 11:00:33', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(48, 31, 15, 'Dicta sapiente voluptatem quia exercitationem et molestias. Est exercitationem dicta quo enim. Sed fugit rerum qui aliquid dignissimos. Qui tenetur tempora fuga distinctio dolorum sit aspernatur nisi. Suscipit rem non dolor ullam nisi debitis.', NULL, NULL, 'Rejected', '2025-11-14 19:04:25', '2025-11-15 07:24:46', 'Ut nihil quam ipsam possimus sunt animi.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(49, 31, 38, 'Et dolores facere doloribus nobis aut officia. Similique velit eaque est. Rerum cumque odit numquam. Quae qui ut reiciendis ab et delectus laborum. A laudantium quisquam vitae in accusantium a sunt aspernatur.', 'Aliquid dolorem accusamus molestiae qui consequatur velit veritatis. Velit sed quia a voluptatibus esse provident. Deserunt dolorem vel voluptates quo necessitatibus quo quaerat qui.', NULL, 'Withdrawn', '2025-11-19 07:12:44', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(50, 31, 46, 'Odit tempore magni vitae soluta facilis. Exercitationem fuga possimus iusto assumenda ut. Est assumenda quam corporis magnam architecto. Maxime minus eum beatae reprehenderit maxime vitae distinctio.', 'Distinctio possimus et impedit est sint accusantium molestias. Exercitationem nisi dolorem harum est voluptatum.', NULL, 'Rejected', '2025-11-20 08:48:58', '2025-11-22 08:20:49', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(51, 32, 7, 'Consectetur veritatis est non quibusdam. Dolore dolores neque optio officia voluptas corporis. Aut natus consequatur excepturi ipsam veniam et. Ut ipsam rerum suscipit sit unde qui ex.', NULL, 'Ut laborum accusamus nemo.', 'Withdrawn', '2025-11-06 02:41:52', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(52, 32, 10, 'Mollitia eos culpa praesentium sed culpa. Qui illum voluptas ut. Dolor facilis ut eum voluptas ullam nostrum molestiae. Deleniti illum nihil iure sunt consequatur aspernatur quam. Ea minus sequi ut suscipit qui. Id repudiandae magni velit provident fugit ut.', NULL, 'Molestias voluptatem nisi modi ut enim.', 'Rejected', '2025-11-14 02:45:59', '2025-11-18 19:27:44', 'Consectetur iste distinctio eum.', '2025-12-06 05:55:57', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(53, 32, 29, 'Deleniti quam quo amet eligendi sit sed alias. Possimus autem consequatur magni nulla non culpa similique ea. Aut consequuntur non autem repudiandae dicta nisi rem quaerat.', 'Accusantium reprehenderit ut qui consequatur eligendi. Qui ipsum fuga ab cupiditate soluta.', NULL, 'Under Review', '2025-11-13 15:06:09', NULL, NULL, '2025-11-23 06:53:16', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(54, 36, 14, 'Quae nesciunt deserunt qui maiores quasi. Eum nihil et vel odio velit dignissimos magnam. Ut omnis autem blanditiis dolorem quia.', 'Distinctio vero ab occaecati et maiores quos voluptatum. Tenetur saepe eum aliquid vel consequuntur. Est omnis illo voluptas aut.', NULL, 'Accepted', '2025-11-20 11:03:21', '2025-11-21 04:04:52', 'Aut laboriosam incidunt suscipit id.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(55, 36, 15, 'Quo sit eius veniam sit enim. Et dolorum facere commodi assumenda. Aliquam aut labore dolorum qui molestiae non saepe.', NULL, 'Libero nisi corporis soluta modi debitis sint molestias.', 'Accepted', '2025-11-09 06:26:07', '2025-11-16 04:02:02', 'Cupiditate ad sunt est neque voluptate non eum.', '2025-12-01 04:35:23', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(56, 36, 27, 'Blanditiis quo consequatur aut nisi harum sed. Cumque maxime voluptatibus in aspernatur. Officia sit aperiam impedit earum necessitatibus doloremque voluptatem. Sed nihil molestias impedit ipsum aut natus et. Reprehenderit doloribus esse beatae aut aut. Sed iure nihil vel repellendus ab adipisci aut.', 'Atque numquam placeat fugiat eos. Consequatur possimus aut sed ad debitis aut. Fugiat est nulla enim in veritatis quas.', NULL, 'Withdrawn', '2025-11-13 04:16:45', NULL, NULL, '2025-12-01 20:54:10', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(57, 36, 28, 'Ut minus architecto provident. Voluptas perspiciatis et pariatur et ut laborum aut. Quo unde ut voluptate. Explicabo quo laudantium nemo nihil.', NULL, NULL, 'Under Review', '2025-11-22 05:23:43', NULL, NULL, '2025-11-27 21:59:11', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(58, 36, 33, 'Delectus sunt necessitatibus quia explicabo recusandae voluptatem ut. Excepturi explicabo quod dolorum. Ipsa similique nihil sed magni. Nihil est consequatur ipsam et quasi.', NULL, 'Et sapiente delectus cum ipsa.', 'Pending', '2025-11-06 19:44:16', NULL, NULL, '2025-11-29 13:07:08', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(59, 41, 45, 'Rerum ex rem fugit quidem dicta. Sapiente nam sed ut illo. Totam aut aut ipsum occaecati sint facere.', NULL, NULL, 'Accepted', '2025-11-04 02:11:14', '2025-11-08 16:31:18', NULL, '2025-11-24 01:28:12', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(60, 45, 6, 'Minus quasi veniam a error animi consequatur consequatur est. Iste est dolore ex cupiditate quas enim velit. Eos aut modi illo.', 'Veritatis et optio laboriosam explicabo architecto impedit. Voluptatem aut modi voluptatem iure alias. Ut aperiam delectus voluptatibus esse sed nesciunt aut.', 'Praesentium veniam labore velit cupiditate molestias.', 'Withdrawn', '2025-10-31 22:31:28', NULL, NULL, '2025-11-23 15:21:14', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(61, 45, 14, 'Placeat dolor dolores voluptate impedit dolorum adipisci. Illo voluptatibus laudantium non assumenda. Dolorum non beatae qui totam vel. Labore voluptas corporis numquam provident magni at.', 'Ut id velit suscipit temporibus. Quam quo eligendi sint. Nobis eos accusamus sed et.', 'Recusandae dolorem sit voluptas recusandae praesentium delectus.', 'Pending', '2025-11-10 17:52:33', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(62, 45, 52, 'Nam sint accusantium fuga architecto ex nisi. Sunt iure fugit recusandae assumenda consequatur. Dolorem magni qui eaque vel fuga suscipit natus consequatur. Voluptas repellat itaque eum sed harum.', NULL, 'Et error inventore earum ut eum alias hic.', 'Rejected', '2025-11-10 23:43:29', '2025-11-21 05:15:18', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(63, 47, 41, 'Tenetur quasi dolorem nostrum ut quae consectetur. Quibusdam sapiente voluptas aliquid soluta porro. Ipsam est incidunt ipsum dolorem. Id labore consequatur voluptates aut eos cum aut fugiat. Repellat aperiam minus non earum et placeat laboriosam ratione.', NULL, 'Voluptatum ipsa omnis delectus sed officia.', 'Pending', '2025-11-01 00:52:29', NULL, NULL, '2025-11-24 06:02:27', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(64, 53, 23, 'Rerum qui rerum unde iusto voluptatibus ut ut. Sequi optio ratione commodi quidem voluptatibus est. Aut voluptatum fuga eaque quo dolores aliquid. Eum exercitationem tempora eos consequuntur esse sed aut.', NULL, 'Rerum nam voluptatem fugit adipisci doloremque odit veritatis.', 'Accepted', '2025-11-10 20:52:15', '2025-11-18 19:55:49', 'Quo aut expedita delectus mollitia.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(65, 53, 51, 'Quas quis architecto totam corrupti. Corporis explicabo et id sit et ut. Consectetur dolore omnis qui consectetur dolores. Et voluptates sed qui unde. Rem quia laudantium dolores. Iusto dolores rerum qui molestias.', NULL, NULL, 'Accepted', '2025-11-03 17:05:21', '2025-11-03 18:38:59', 'Repudiandae aliquid quibusdam assumenda qui id quaerat eius.', '2025-11-28 10:00:28', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(66, 62, 8, 'Velit accusantium et deserunt est. Ducimus dolorum nobis ut voluptatem. Adipisci ratione omnis ut. Et qui soluta quia dolores earum qui et.', NULL, 'Ut nesciunt ipsa eligendi maxime neque fuga.', 'Under Review', '2025-11-04 15:41:09', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(67, 62, 45, 'Veniam maxime labore et qui enim dolorem. Dolorum eaque quo quam aperiam a. Cupiditate et ratione perspiciatis ipsam accusamus. Nisi ducimus quas ut error.', NULL, 'Tempore ut voluptas dolor molestias.', 'Accepted', '2025-11-10 05:53:54', '2025-11-17 05:56:06', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(68, 66, 5, 'Aspernatur eos tempore ea dolorem. Voluptas dicta odit suscipit magni amet. Tenetur odio voluptatem incidunt sed velit sint beatae. Magnam qui molestiae deleniti ipsam beatae ab.', 'Hic voluptatem repellendus cumque. Sunt quis nisi quia dolor est cumque.', NULL, 'Withdrawn', '2025-10-26 04:47:54', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(69, 66, 22, 'Assumenda rerum et illum iste. Expedita doloremque nulla dolor ipsa enim. Inventore sint at molestiae nostrum soluta ut ab et. Exercitationem eos est nemo tempore nesciunt quidem eveniet molestiae.', NULL, NULL, 'Withdrawn', '2025-11-21 15:28:32', NULL, NULL, '2025-11-25 23:29:20', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(70, 66, 26, 'Nulla qui est quis deserunt in sunt repellendus. Aliquam nisi omnis voluptatum repellat harum non consequatur. Omnis corporis et consequatur ad est autem. Iste occaecati sint reiciendis iusto culpa. Dolores asperiores dolorem soluta omnis qui illum in.', NULL, 'Tenetur sed ab alias beatae aut molestiae nostrum.', 'Under Review', '2025-10-26 19:05:42', NULL, NULL, '2025-12-01 19:39:34', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(71, 66, 39, 'Quia et quod necessitatibus alias modi sed cumque. Et dolorem facilis autem neque delectus. Id et est corporis. Voluptas rerum pariatur vel ullam sed nihil odio soluta.', 'Reiciendis nostrum odit consequatur quia qui. Eaque vero non reiciendis reiciendis consequatur hic corporis esse. Sit dignissimos et culpa libero voluptas repellat.', 'Dolorem dolorem odit blanditiis in officia quos.', 'Pending', '2025-11-14 00:25:43', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(72, 67, 6, 'Sunt ullam in odit sunt dicta. Culpa neque reprehenderit quasi repellat recusandae. Qui sunt voluptates earum nesciunt aliquid voluptas. Voluptas non vitae voluptatum eaque qui ut dolorum.', 'Magni nam consectetur fugiat magni distinctio. Quo deleniti nihil iure aut incidunt necessitatibus. Culpa in porro asperiores mollitia sed nesciunt quia.', NULL, 'Rejected', '2025-11-04 17:05:34', '2025-11-19 19:12:26', 'Voluptatibus quia non vel omnis corrupti repudiandae et veritatis.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(73, 67, 42, 'Nisi esse odio sit incidunt aut. Et eos tempore consequatur veniam ab voluptas saepe. Magnam sapiente ipsa ad perspiciatis repellendus. Ut sit ex reiciendis et.', NULL, 'Adipisci atque cum unde mollitia rerum.', 'Accepted', '2025-11-19 15:27:12', '2025-11-20 12:16:18', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(74, 67, 43, 'Qui dolores ullam ab nesciunt perferendis velit. Harum accusantium qui ut nobis. Suscipit ut et libero voluptatem sunt qui optio. Voluptate dolore consequuntur quaerat minima quo.', NULL, NULL, 'Withdrawn', '2025-11-20 22:08:40', NULL, NULL, '2025-12-01 08:06:58', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(75, 67, 44, 'Quis et optio animi fugit deleniti. Suscipit magni nihil suscipit ipsa incidunt ipsa nobis laboriosam. Rerum quia sint eligendi. Velit nam autem voluptatem nesciunt. Velit temporibus sed labore eveniet est nihil quam. Enim amet omnis aliquam qui eum.', 'Nihil explicabo rerum qui nulla est aut. Id enim culpa atque distinctio.', NULL, 'Rejected', '2025-11-04 23:01:12', '2025-11-19 20:32:17', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(76, 67, 46, 'Ipsa maiores eligendi quis quas perspiciatis eveniet doloribus. Veniam dignissimos ut ut quam. Ducimus vero eum dolor aut sunt et.', 'Et fugit quo mollitia ut explicabo. Non a voluptatum molestias id tempora quibusdam. Ullam recusandae dolores qui fugiat.', NULL, 'Under Review', '2025-11-13 21:04:00', NULL, NULL, '2025-11-28 04:03:15', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(77, 71, 25, 'Illum sint dolor culpa vel officiis. Consequatur nulla saepe est laboriosam eius sit rerum. Quo officia quaerat ullam laboriosam suscipit nihil. Sed illo ipsam accusamus hic iusto nihil eos non. Officia nulla aut enim quo minima.', NULL, 'Saepe voluptatem accusantium at ipsam iusto quis.', 'Rejected', '2025-11-07 23:24:19', '2025-11-15 01:24:26', 'Qui ut vero architecto ut hic sed inventore.', '2025-12-04 15:32:57', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(78, 78, 36, 'Non porro aperiam dolor nihil est dolor. Delectus ut dolores cupiditate dolor ab vitae. Ut culpa quisquam iure vero. Distinctio at eveniet sed et non vel expedita.', 'Provident aut labore ex iste molestiae. Corrupti nemo vel fuga quia odio dolor voluptates libero. Ratione sit placeat quaerat ut perferendis incidunt fugit.', NULL, 'Accepted', '2025-11-08 10:32:10', '2025-11-17 16:38:48', NULL, '2025-11-27 22:01:58', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(79, 78, 38, 'Sunt facilis recusandae nihil modi excepturi dolorum. A dolorem facilis omnis. Deleniti aspernatur et quia dolores.', 'Voluptate dicta similique nihil assumenda dignissimos accusamus aut est. Nobis eaque deserunt eos eaque et. Sunt mollitia rerum omnis quibusdam libero.', NULL, 'Rejected', '2025-11-19 22:56:47', '2025-11-20 13:31:46', 'Deserunt vel quasi dignissimos ut.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(80, 78, 48, 'Ea nihil dicta rem commodi ut. Quisquam molestiae hic aliquam qui sint velit. Nesciunt et voluptate quae nostrum ducimus dolores. Ut dignissimos consequatur qui qui aspernatur minima nam.', 'Repellendus mollitia pariatur tenetur hic nisi quidem consequatur. Recusandae ad quis est provident qui at voluptates.', 'Pariatur aut officia fugit.', 'Withdrawn', '2025-10-27 06:39:31', NULL, NULL, '2025-12-06 19:46:58', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(81, 78, 49, 'Deleniti eum suscipit aut atque dolorem. Illum veritatis nobis ab odit sequi deserunt. Sapiente ullam et enim sint quis nesciunt.', NULL, 'Provident molestiae nulla enim tenetur quis quia.', 'Pending', '2025-11-07 16:37:27', NULL, NULL, '2025-11-26 04:41:06', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(82, 81, 31, 'Velit aut velit iste dolores eum. Enim repudiandae neque tempore minima dolorum. Quia fuga tempore quisquam eum. Iusto incidunt voluptas laborum est.', 'Eum ut delectus quo blanditiis necessitatibus pariatur voluptatem. Explicabo ea mollitia repellendus est minima officiis architecto. Omnis libero dolores qui officia ut enim nostrum placeat.', NULL, 'Pending', '2025-10-24 05:17:13', NULL, NULL, '2025-12-03 09:23:12', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(83, 81, 38, 'Possimus dolor id a ipsum quod et atque aut. Fuga et cupiditate ut provident totam. Et est nesciunt in qui explicabo.', NULL, 'Molestias saepe ut nostrum.', 'Withdrawn', '2025-11-21 05:26:43', NULL, NULL, '2025-11-30 13:55:06', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(84, 81, 49, 'Et sequi quaerat et modi ut voluptas. Eaque voluptatem et aut. Sunt culpa ut ad sed. Voluptate expedita quos est nihil voluptas. Voluptatibus et dolorem aspernatur ratione qui. Voluptates officia rerum eos consequatur.', 'Ut ipsum veritatis in dicta hic explicabo sit. Omnis voluptatem ut voluptatem odit qui ea unde.', NULL, 'Withdrawn', '2025-11-07 02:00:27', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(85, 83, 14, 'Non aut cum rem dolore. Cum ducimus vel et dolor quia id. Exercitationem ab et enim est suscipit.', NULL, NULL, 'Rejected', '2025-10-24 10:11:58', '2025-11-01 09:38:15', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(86, 83, 29, 'Quas ducimus id saepe. Ea nihil labore eius est harum et. Rerum nihil aut modi perspiciatis in nemo. Optio quis quasi explicabo perspiciatis cum. Pariatur nihil nisi nihil minus dolorum sint nostrum. Quam nemo est ipsa pariatur facilis ut id.', NULL, 'Voluptatem nihil aut temporibus non.', 'Accepted', '2025-11-06 16:06:46', '2025-11-08 20:39:53', 'Totam cupiditate et provident sunt consequatur rerum.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(87, 83, 35, 'Fugiat nesciunt omnis pariatur deleniti rem tempore voluptatem. Facere asperiores dolorum qui consectetur expedita. In voluptatem eligendi et deleniti alias. Et cupiditate commodi animi.', NULL, 'Expedita sed dignissimos enim aut.', 'Withdrawn', '2025-10-30 06:56:40', NULL, NULL, '2025-11-24 10:59:13', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(88, 83, 38, 'Ex minus molestiae voluptas ut nulla et ab. Qui qui accusantium praesentium nulla. Sequi tempora ut dolor. Similique excepturi est excepturi expedita excepturi.', NULL, NULL, 'Accepted', '2025-11-10 01:32:19', '2025-11-21 21:00:16', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(89, 83, 49, 'Voluptatem et dolor voluptatibus dignissimos qui et. Cumque repellat voluptatum et iure et. Quibusdam suscipit vel beatae quod aut ut. Assumenda temporibus accusamus voluptatum voluptatibus. Animi architecto ullam dignissimos itaque. Quos sint similique qui quis aut est maxime.', NULL, 'Animi autem quos quasi rerum dolor atque.', 'Under Review', '2025-10-24 11:12:39', NULL, NULL, '2025-11-27 09:00:05', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(90, 89, 8, 'Deleniti corporis sint dolores ut quibusdam exercitationem. Fugit sit illum esse doloribus. Dolorum pariatur voluptatem vel. Consectetur assumenda quia reiciendis est et rem et nemo.', NULL, 'Ut ullam eius omnis ab.', 'Withdrawn', '2025-11-20 15:06:36', NULL, NULL, '2025-11-26 16:58:11', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(91, 89, 15, 'Cum sapiente quo dolor blanditiis iure quidem dolores. Nobis et quia rem maiores commodi quas excepturi. Incidunt ea labore dolores occaecati error quis placeat.', NULL, 'Nam et libero ut vero ut et delectus.', 'Rejected', '2025-11-21 19:00:58', '2025-11-22 16:09:15', 'Placeat odio deleniti sunt voluptas vitae.', '2025-11-23 00:38:36', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(92, 89, 23, 'Velit nam nisi corrupti rem ea fugit voluptatem. Ullam aut hic nobis ea. Cum dolores tempore quis repellendus voluptatum maiores inventore. Ducimus reiciendis et occaecati quia et et. Officiis vitae voluptatem quia tenetur omnis sapiente et. Aut fugit quibusdam ea molestiae velit perspiciatis ut.', NULL, 'Voluptates quae quo soluta sed omnis odio.', 'Accepted', '2025-10-31 23:25:11', '2025-11-10 22:01:12', NULL, '2025-12-04 09:21:20', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(93, 89, 34, 'Magnam voluptatem ipsum iste ipsum est qui. Iure vitae rerum beatae pariatur. Eos illo debitis est blanditiis ut officia. Asperiores accusamus eos optio aut.', 'Eligendi repellendus voluptatem omnis maiores perspiciatis enim rerum. Commodi maxime rerum est dolorum corporis doloribus.', NULL, 'Accepted', '2025-11-13 21:47:02', '2025-11-16 21:48:16', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(94, 93, 35, 'Minus iusto corrupti nostrum. Deleniti consequuntur alias occaecati veritatis dolorum. Dignissimos rem delectus in fuga illo. Dolorem dolorem est distinctio minima. Deserunt voluptatem voluptatem minima ea molestiae aut quo.', 'Dolor aliquid hic eos rerum vitae. Molestiae dolorem voluptates est officiis unde explicabo.', NULL, 'Withdrawn', '2025-11-03 09:10:21', NULL, NULL, '2025-12-03 22:30:34', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(95, 94, 11, 'Odit architecto laudantium temporibus atque mollitia. Voluptate omnis mollitia ullam consequuntur qui. Expedita in in dolor dolores beatae qui et voluptatem. Porro ducimus blanditiis rerum occaecati unde rerum qui.', NULL, 'Molestias a voluptatem voluptas eum similique quo qui.', 'Rejected', '2025-10-28 22:46:35', '2025-11-19 11:26:25', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(96, 94, 27, 'Quaerat iusto vero vel tenetur. Omnis reprehenderit porro laboriosam laborum quo quis. Aut ut fugiat voluptas et. Perspiciatis non ducimus perferendis aliquam vel. Sed porro ullam ut nam accusamus nisi dolore.', NULL, NULL, 'Accepted', '2025-10-28 18:32:42', '2025-10-28 21:54:59', NULL, '2025-11-29 08:47:50', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(97, 94, 32, 'Est beatae dolorum autem iusto animi. Corporis at laboriosam quia totam rem et corporis. Sit quia exercitationem est perspiciatis similique tenetur occaecati illo. Soluta et numquam quidem officia. Mollitia earum voluptatum totam odit. Aperiam quos a sit itaque ut et omnis.', NULL, 'In delectus et et ut in placeat.', 'Under Review', '2025-11-18 22:44:51', NULL, NULL, '2025-11-23 07:45:16', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(98, 94, 35, 'Inventore perferendis non vel autem officia distinctio sed. Porro veniam in rerum nihil consequatur iure. Maxime deserunt aliquid sint magnam.', 'Facilis ut dolor optio qui iste harum. Dolor ab velit est nam sapiente. Voluptatem iste iste nisi et ut.', NULL, 'Withdrawn', '2025-11-03 01:38:39', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(99, 94, 49, 'Harum quasi ut quaerat consequuntur a animi qui nesciunt. Odio ut cumque omnis sed. Voluptate officiis corporis est et sed quas fuga. Omnis excepturi qui nobis dicta velit. Dolorem sint rerum laudantium neque.', 'Veniam sint consequatur expedita quo. Consequatur explicabo unde aut fuga modi dignissimos. Quo laboriosam consectetur sit provident laudantium ut.', NULL, 'Accepted', '2025-11-13 18:54:59', '2025-11-15 06:14:01', 'Unde quam ut eos porro nam accusantium modi.', '2025-12-02 06:44:16', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(100, 95, 4, 'Tenetur sunt excepturi sint nemo minus quia minima commodi. Eos ut repudiandae facere animi. Sint commodi eaque et voluptas. Eum commodi dolore illum exercitationem quo ut.', 'Voluptas molestiae quis quae aliquam. Omnis impedit illo quasi maxime. Eum perspiciatis sed aperiam.', NULL, 'Pending', '2025-11-20 22:12:03', NULL, NULL, '2025-12-04 00:41:53', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(101, 95, 9, 'Ratione velit occaecati veniam perferendis accusamus nulla. Voluptates debitis id ipsa perferendis ipsa dignissimos. Provident laudantium sunt necessitatibus aspernatur aut est.', 'Quos molestias dolores et alias et. Et impedit rerum voluptatem debitis maxime.', 'Aliquid culpa expedita quasi aut.', 'Under Review', '2025-11-09 13:21:44', NULL, NULL, '2025-11-26 08:45:26', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(102, 95, 11, 'Sequi pariatur consequuntur libero et aliquam nulla. Vero facere hic et. Ab aut omnis porro officia sed.', 'Natus et placeat reiciendis exercitationem earum. Porro rem qui omnis et excepturi.', NULL, 'Pending', '2025-10-31 22:58:47', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(103, 95, 28, 'Voluptatem consequuntur molestiae in iure cum est magni. Hic rerum sint esse occaecati omnis tenetur ratione. Sit neque debitis animi voluptatem nostrum et eum dolor. Voluptatem quos tempore qui illum. Rerum fuga laboriosam ex assumenda voluptatem. Minus necessitatibus repellendus beatae.', 'Rerum officiis quam blanditiis quia autem. Saepe molestiae nobis est et animi dicta.', 'Voluptas aut placeat recusandae consequatur ea pariatur et.', 'Under Review', '2025-11-03 14:16:23', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(104, 95, 44, 'Corporis nesciunt nihil quis recusandae. Ut molestiae perferendis illo. Saepe voluptatem quisquam officia provident accusantium quo fugiat. Qui non saepe dolorum modi et. Aut ut qui et repellendus et quam odio. Recusandae cupiditate aut dolores nihil perferendis et eum.', NULL, NULL, 'Pending', '2025-11-16 07:14:50', NULL, NULL, '2025-12-06 10:42:23', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(105, 97, 48, 'Ut nihil quia non cumque quidem rerum. Quod qui qui saepe nam ad quaerat eaque nihil. Quidem ullam quaerat velit perferendis id facere pariatur. Nisi vitae blanditiis minima sapiente suscipit velit. Qui nobis ut nemo nihil optio aliquid fugit harum. Voluptas commodi distinctio accusamus dicta laboriosam libero vero.', 'Eum rerum dolore placeat molestiae rem veniam mollitia. Eum dicta nihil fugit aut expedita porro.', NULL, 'Pending', '2025-11-08 04:07:14', NULL, NULL, '2025-11-26 22:14:40', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(106, 99, 6, 'Quis quibusdam libero eos numquam consequatur expedita non quibusdam. Aut id perferendis ut id. Minus sapiente recusandae ad nesciunt. Ut officia dolor fugiat accusamus voluptas. Quae eum occaecati ea deserunt aut. Veniam assumenda delectus voluptatum nihil distinctio labore.', 'Repellendus quo fugit culpa sit autem molestias. Repellendus vitae aperiam nulla soluta aut ea doloribus. Adipisci autem expedita nisi enim voluptas vel non.', NULL, 'Under Review', '2025-10-25 12:11:52', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(107, 99, 29, 'Ut unde cum dolor officiis illum eveniet. Qui omnis quae aspernatur nostrum modi odit voluptates. Nemo fugiat totam est vel et. Expedita dolore ut ut amet.', 'Velit cupiditate et est molestiae a totam. Sit vero eius eaque eos sapiente est provident.', 'Voluptatem numquam sequi a optio deserunt labore.', 'Rejected', '2025-11-01 04:42:02', '2025-11-06 18:16:47', 'Explicabo dolor corporis aspernatur qui.', '2025-11-26 10:35:41', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(108, 100, 6, 'Qui in voluptate iusto quidem culpa. Reprehenderit rerum repellendus sapiente numquam vel unde iste. Omnis non sed magni voluptas. Minus repellendus et eius quos fugit et. Consequatur praesentium architecto voluptate corrupti. Qui dolores vel aut quae.', 'Exercitationem et et in recusandae aliquam et. Commodi ex quia sed neque quaerat cumque. Dolor blanditiis eos vel temporibus.', 'Occaecati qui harum quia et non velit pariatur.', 'Rejected', '2025-10-26 19:27:20', '2025-11-16 11:30:47', NULL, '2025-12-01 08:43:34', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(109, 100, 8, 'Voluptatem porro voluptatem architecto illum. Illum ullam perferendis alias aut quae ad. Aut vero dolores qui quod ipsam nam voluptates. Et modi accusamus sunt. Et et voluptatem molestiae id sunt id. Hic ipsam officia harum rerum.', NULL, 'Cum blanditiis blanditiis necessitatibus corporis.', 'Under Review', '2025-11-02 11:10:58', NULL, NULL, '2025-11-26 12:24:58', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(110, 100, 10, 'Quibusdam ut voluptatem tenetur nihil vitae voluptatibus. Optio repellat dolor ea. Ut est non et.', 'Qui odit aut ipsa veniam iusto quis eius perspiciatis. Nobis ipsa at eum pariatur nihil quas. Consequuntur illo sint alias eum dolorum.', NULL, 'Accepted', '2025-10-25 18:33:46', '2025-11-22 04:31:43', 'Facilis enim sunt at modi ipsa ut a possimus.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(111, 100, 26, 'Dolor iste pariatur ipsum consectetur sequi iusto. Enim sequi recusandae aperiam voluptas. Quidem in aut modi voluptatem commodi nihil. Est reiciendis eos reprehenderit mollitia rerum aspernatur maiores veritatis.', 'Assumenda ipsa voluptas reiciendis nesciunt rerum. Aut doloremque rerum laboriosam.', 'Recusandae at veniam accusamus voluptas atque molestiae.', 'Withdrawn', '2025-11-15 07:36:41', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(112, 100, 36, 'Omnis quos et commodi omnis velit dolorum. Qui libero soluta ea qui rerum non. Debitis tenetur fugiat repellat voluptas consequatur consectetur quia. Quo eius minima officia voluptates. Sapiente nam hic velit. Eligendi qui aliquid accusamus aliquid est recusandae maxime cumque.', NULL, NULL, 'Withdrawn', '2025-11-20 16:53:56', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(113, 103, 12, 'Sunt maxime eaque odio reiciendis similique. Sapiente eaque nulla aut vel eos aperiam. Et qui illo autem nobis quo. Modi id sit dicta nihil. Odio qui similique tempore et nostrum est repellendus. Quaerat autem consequatur voluptatem hic fugit.', 'Officiis numquam error omnis voluptas quia inventore ipsum. Et molestiae est libero quisquam nulla. Qui praesentium consectetur est molestiae.', 'Soluta tempore debitis et veniam consequatur.', 'Under Review', '2025-11-11 05:51:42', NULL, NULL, '2025-12-04 04:09:19', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(114, 103, 31, 'Officiis pariatur eaque quo ex. Iure eos et non aspernatur. Est consequatur perferendis dolor non esse facilis.', NULL, 'Voluptas omnis dicta dolorum voluptate ullam est.', 'Rejected', '2025-10-30 11:17:09', '2025-11-07 06:08:12', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(115, 104, 24, 'Quod vitae dolorum totam porro libero unde ullam. Delectus cum quaerat et nihil et eos rerum. Eaque eligendi quibusdam voluptas. Voluptatum rerum voluptatem aspernatur est consequatur. Quia optio pariatur dolorum impedit corporis consequuntur sed sed.', NULL, NULL, 'Pending', '2025-11-07 14:02:09', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(116, 108, 14, 'Delectus et illum sed aut a. Id voluptas ipsum sit voluptates consequatur ea cumque. Atque aut quia fuga commodi quidem. Nisi quasi qui incidunt dolorem minima.', NULL, 'Et dolorem sed nostrum excepturi quidem animi.', 'Accepted', '2025-11-11 02:04:02', '2025-11-22 01:53:28', NULL, '2025-12-03 20:24:15', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(117, 108, 16, 'Officiis ducimus voluptates atque. Sapiente voluptatum aut cupiditate autem sed nihil est vitae. Voluptas incidunt beatae et harum non.', 'Nemo a eius vel inventore. Est animi unde ipsa animi voluptas quis.', 'Eveniet sapiente molestiae eum qui.', 'Rejected', '2025-11-17 15:59:15', '2025-11-21 19:34:35', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05');
INSERT INTO `applications` (`application_id`, `opportunity_id`, `volunteer_id`, `motivation_letter`, `relevant_experience`, `availability_note`, `status`, `applied_date`, `reviewed_date`, `organization_notes`, `interview_scheduled`, `created_at`, `updated_at`) VALUES
(118, 108, 18, 'Nemo excepturi est officiis ea. Aut sit quidem ut. Consequuntur id omnis ut aut illo dolor. Sapiente quod nam dolorem molestias. Et in assumenda ipsam molestiae tempora rem error.', NULL, NULL, 'Rejected', '2025-11-14 01:27:26', '2025-11-22 12:01:53', 'Amet consequatur quas molestiae aut ut hic.', '2025-12-06 19:43:10', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(119, 109, 7, 'Amet ut deleniti suscipit vel corrupti et voluptas. Molestiae possimus consequatur aut voluptates ducimus dolores quibusdam. Incidunt impedit omnis quis modi. Omnis est eos autem fuga est. Eius eaque autem iste quod. Et vitae dolores culpa accusamus ipsam reiciendis beatae.', 'Eveniet reprehenderit culpa est eveniet non tempora repudiandae. Occaecati ducimus exercitationem dolor corrupti quae accusamus repellat delectus.', 'Adipisci enim iusto ut eveniet saepe voluptatum.', 'Accepted', '2025-11-02 23:25:23', '2025-11-18 11:56:51', NULL, '2025-11-25 19:28:36', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(120, 109, 21, 'Beatae voluptatum non quibusdam debitis recusandae commodi. Nemo provident placeat non vel. Ut ratione nobis unde neque laborum quaerat rerum. Omnis sed accusantium vel. Est in nemo ab doloribus assumenda aut rem. Quo sint tempore repudiandae et porro voluptatem tempore.', 'Provident molestias consequatur ipsa nihil. Suscipit dolorem natus amet. Et eum quis similique molestiae.', 'Eligendi eveniet cumque natus eos voluptatem rerum fuga.', 'Pending', '2025-11-04 10:34:53', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(121, 109, 40, 'Odio culpa vero deleniti animi inventore. Tempora consequatur qui ut inventore quia. Earum repudiandae natus recusandae vitae ut nesciunt. Autem et dolorum enim quidem dicta.', NULL, 'Voluptas distinctio dolorem qui ipsum et.', 'Under Review', '2025-11-12 22:19:58', NULL, NULL, '2025-11-23 12:19:30', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(122, 109, 42, 'Qui enim asperiores illum dolor ullam voluptatem laborum ullam. Aut amet voluptatem nisi qui ut consequuntur rerum. Sit doloremque ab corrupti. Quia ipsum accusantium nihil iusto officiis. Velit quia ullam doloremque quia ipsa quaerat placeat. Et beatae nam ut dolorem sit.', NULL, NULL, 'Rejected', '2025-11-21 06:45:02', '2025-11-22 04:13:36', 'Natus voluptatem molestiae natus et repellat et.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(123, 112, 7, 'In sit enim et soluta omnis dolorem similique. Est eum officia officia inventore laborum quisquam. Recusandae quia vero totam. Eius molestias sit eius magni velit.', NULL, NULL, 'Accepted', '2025-10-28 12:43:00', '2025-11-19 20:30:46', NULL, '2025-11-25 08:21:13', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(124, 112, 12, 'Consequatur qui facilis voluptatem sit. Et aut reprehenderit officiis rerum qui repellendus. Dolore ducimus voluptas iste quod veniam suscipit non esse. Rerum voluptas et explicabo incidunt autem totam ut.', NULL, 'Provident sint blanditiis atque rem officiis vel.', 'Accepted', '2025-10-28 10:48:53', '2025-11-01 23:25:08', NULL, '2025-12-01 23:06:44', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(125, 112, 17, 'Omnis ratione culpa deleniti numquam qui. Quia id dolorem quasi qui est cum a. Non mollitia sapiente pariatur ut esse quis qui. Odio officia occaecati necessitatibus debitis minima. Ratione repellat non aut id sint.', 'Rem nisi magni consectetur quis dolorem placeat. Qui veniam id consectetur amet voluptas. Ut nostrum quia vel voluptatem ut architecto et.', 'Odio consequatur blanditiis tenetur et.', 'Rejected', '2025-11-15 15:55:12', '2025-11-16 15:17:49', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(126, 112, 23, 'Molestiae quisquam reprehenderit nihil deleniti at nulla. Quis rerum animi dolores quisquam tempora ea. Minus repellendus tempore quia quibusdam quasi dicta. Numquam maxime inventore quidem placeat laudantium. Consequatur eum ullam nulla illo sint dolor qui.', 'Voluptas aut est dolor neque qui quidem voluptates. Magnam esse labore quod omnis et voluptas quas.', NULL, 'Rejected', '2025-10-30 15:23:41', '2025-11-05 01:54:35', NULL, '2025-12-02 04:59:20', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(127, 113, 6, 'Quam eos in itaque dolor nihil. Maxime id expedita quibusdam qui. Odit consequuntur suscipit est sed rerum voluptas nisi. Et iusto est molestiae aut est deleniti.', 'Animi non ut non recusandae. Aut dolor earum ipsa minus. Eaque sed laborum tempora excepturi.', NULL, 'Under Review', '2025-11-16 14:08:47', NULL, NULL, '2025-12-06 12:37:36', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(128, 113, 11, 'Maxime minus ut quos distinctio fugiat labore ipsa. Dignissimos et perspiciatis quam sunt unde et. Aut autem quibusdam neque quia atque. Nihil omnis id placeat enim ea velit aut.', NULL, 'Quisquam vel voluptate ab a voluptas.', 'Withdrawn', '2025-11-17 04:56:07', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(129, 113, 27, 'Eius hic dolorum est id illum omnis qui. Occaecati est sapiente aut itaque non rerum debitis. Et vero sequi tempore eaque. Aut et quia dicta et a officiis libero. Eveniet dolor expedita dignissimos perspiciatis nam.', 'Minus officiis aliquam itaque nisi nisi minima hic. Blanditiis et dolores corrupti necessitatibus suscipit.', NULL, 'Accepted', '2025-11-12 23:25:08', '2025-11-15 01:39:35', 'Possimus eum ut dolor recusandae et accusamus velit.', '2025-11-27 16:02:06', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(130, 113, 43, 'Perspiciatis ut et sed possimus voluptatem praesentium. At sit vel ut repellat sit quod. Quis minus qui atque eos quia. Iure eius veniam magnam aut odit. Laborum voluptatum labore laborum eveniet et aut soluta. Laboriosam et excepturi quia reiciendis assumenda nemo aliquid.', NULL, NULL, 'Rejected', '2025-11-09 05:24:11', '2025-11-17 23:52:06', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(131, 114, 19, 'Omnis sint numquam similique omnis iure. Odio est autem voluptas enim non. Omnis aliquam ut iure. Et maiores error eaque sit.', 'Explicabo tempora aut numquam nulla excepturi sequi accusamus repellendus. Illum alias molestias est similique qui.', 'Facere aperiam voluptatem in eum cum.', 'Accepted', '2025-11-17 05:16:22', '2025-11-20 14:14:55', 'Repellendus eaque eveniet assumenda voluptatem dolore.', NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(132, 114, 23, 'Debitis molestiae omnis reiciendis optio nesciunt. Et reiciendis blanditiis et et et non. Sunt tempore dolor quisquam placeat recusandae qui.', NULL, 'Harum quidem quisquam est dolore odio voluptas suscipit et.', 'Withdrawn', '2025-11-02 05:48:10', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(133, 114, 36, 'Aperiam rerum qui quod in. Est exercitationem qui harum repellat. Totam molestiae a dolor. Sed ut quam suscipit et.', NULL, NULL, 'Accepted', '2025-11-09 14:58:54', '2025-11-16 02:22:38', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(134, 114, 43, 'Aut dolores esse nesciunt nisi. Ut laborum omnis autem perferendis voluptatum. Et officia distinctio magni placeat ipsam. Veniam soluta doloremque dolor rem tenetur temporibus. Repellendus qui rerum voluptate sunt et exercitationem repellat.', NULL, NULL, 'Under Review', '2025-11-03 05:17:11', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(135, 115, 8, 'Sed modi aliquid mollitia perspiciatis cupiditate et. Optio est iusto dignissimos distinctio id. Cumque ut aut in reprehenderit quia. Eum pariatur sint qui inventore consequuntur doloribus repellat.', NULL, 'Minus quas possimus nisi commodi nulla magnam.', 'Under Review', '2025-11-19 14:41:46', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(136, 115, 29, 'Vel ea similique consequatur exercitationem quia quaerat non. Eveniet mollitia quam ea. Voluptas illum veritatis tenetur accusantium voluptatem. Aut libero autem saepe aliquam blanditiis recusandae velit. Aut quia molestiae et numquam molestias quae. Numquam saepe voluptatem rerum quos molestiae voluptatem dolorem.', NULL, 'Tempora ipsam dicta velit ut.', 'Under Review', '2025-11-15 09:44:14', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(137, 115, 36, 'Maiores non expedita asperiores quas. Similique iste eos ut itaque ducimus. Neque voluptatibus odio quos optio sed. Dolor cumque magni vel quae aspernatur ipsum aspernatur. Voluptates consequatur modi incidunt fugiat sed qui.', NULL, NULL, 'Accepted', '2025-11-15 10:20:17', '2025-11-17 23:20:37', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(138, 115, 37, 'A eaque maxime laudantium qui. Ut nihil non omnis itaque dolor esse. Id consequuntur deserunt nobis optio ex. Laboriosam repudiandae nam quia et quo ea sunt. Id explicabo omnis expedita omnis.', 'Ratione at ipsum modi nam. Dolor quod voluptatum enim quia. Reiciendis tempore illum sint quia ad.', NULL, 'Pending', '2025-11-10 22:47:57', NULL, NULL, '2025-11-25 10:04:08', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(139, 115, 38, 'Laudantium voluptatem voluptatem necessitatibus quidem ipsa autem aliquam. Et quas ad architecto dolores voluptatem consequatur. Laboriosam sint non repellendus laborum quisquam voluptatem voluptates. Enim veniam vel quia. Eius possimus repudiandae beatae enim earum.', NULL, NULL, 'Pending', '2025-10-31 16:38:34', NULL, NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(140, 116, 6, 'Iste voluptatem maxime quidem quisquam et sunt occaecati. Est quo porro praesentium et. Qui eos culpa maxime quis quo hic sint. Non perspiciatis dignissimos aspernatur. Vel voluptas mollitia sequi sed deleniti maiores rerum adipisci.', 'Sunt sit eos eum iure molestiae qui. Sequi est quis aut et distinctio.', NULL, 'Withdrawn', '2025-10-26 18:17:30', NULL, NULL, '2025-12-03 19:15:26', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(141, 116, 16, 'Reiciendis numquam voluptatibus quo aut. Deserunt voluptate facilis error aut. Provident quia porro ea minima. Aut voluptatum nesciunt vel consequatur sequi. Aspernatur ut distinctio et aut perferendis est natus.', 'Quis cupiditate incidunt et hic qui earum cumque. Necessitatibus earum et earum rerum et harum.', NULL, 'Under Review', '2025-11-03 06:58:13', NULL, NULL, '2025-12-03 11:12:32', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(142, 116, 20, 'Et molestiae molestiae commodi. Consequatur sit sit non natus. Voluptas omnis itaque voluptatibus accusantium. Non quos quia nobis dolor tenetur rerum voluptas.', NULL, NULL, 'Under Review', '2025-11-19 22:05:06', NULL, NULL, '2025-11-26 09:17:04', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(143, 116, 27, 'Ratione non magni similique. Sunt amet vero necessitatibus et earum dolore dolor. Aut veritatis et ut modi quam neque nostrum. Exercitationem quia accusantium qui totam sapiente eligendi vero quae. Et nobis modi eum ut accusamus error. Voluptatem in eum omnis quas enim voluptatem.', 'Animi iure voluptatibus reiciendis dolores. Sit voluptatibus a perferendis eos aut consequatur.', 'Rerum repudiandae natus est quo rerum voluptate veniam.', 'Rejected', '2025-10-26 21:04:13', '2025-11-12 20:31:45', NULL, NULL, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(144, 118, 17, 'Sit voluptate nulla impedit minus non. Natus deleniti velit quisquam laudantium omnis odio. Aut ea dolor rerum aliquam. Illo et nihil omnis consequatur.', NULL, 'Vitae ad ea quis corporis maiores.', 'Rejected', '2025-11-18 13:05:01', '2025-11-22 03:03:33', NULL, '2025-12-03 16:47:13', '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(145, 118, 30, 'Eaque harum mollitia nobis ut quisquam amet nisi sunt. Doloremque reprehenderit fugit corporis velit veniam. Unde dolorem qui qui alias voluptatibus officia. Sit ut facilis voluptatibus voluptatum quo voluptatem voluptatem.', NULL, 'Recusandae quia cumque aut provident temporibus et.', 'Rejected', '2025-11-07 21:38:01', '2025-11-12 08:57:07', 'At veritatis modi repellat.', NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(146, 118, 37, 'Occaecati quis tempora aut sequi. Consequatur quisquam sapiente minus a. Non nobis velit nam dolorem dolorum.', 'Sequi et omnis fuga id quia voluptatem. Iusto voluptas voluptatem eum sunt consectetur.', NULL, 'Pending', '2025-11-08 10:31:54', NULL, NULL, NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(147, 118, 43, 'Quia magni cupiditate quidem dignissimos voluptas sint veniam. Dolore non quos ullam. Eveniet et nemo explicabo odit et.', 'Non ducimus voluptatem sequi culpa ratione explicabo omnis. Repellendus praesentium expedita iste adipisci.', NULL, 'Withdrawn', '2025-10-28 15:13:18', NULL, NULL, NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(148, 118, 53, 'Officiis quia iste quis accusamus consequuntur iste. Excepturi veritatis nemo consequatur est deserunt vitae. Eos delectus perferendis totam voluptas quo eveniet ut rerum.', NULL, NULL, 'Withdrawn', '2025-11-06 03:55:42', NULL, NULL, NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(149, 120, 30, 'Magni aut voluptatum sint ratione excepturi. Excepturi dolorum maiores earum et. Fugiat rerum quo autem ipsa voluptas. Accusamus quos ex animi aperiam vitae.', 'Qui rerum nesciunt sunt molestiae aut ut. Non odio est magni provident minus qui nam.', 'Eaque tenetur ipsum officia enim repellendus maiores.', 'Rejected', '2025-11-19 12:55:09', '2025-11-20 08:28:57', 'Ut aut maxime ut hic voluptas voluptas.', NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(150, 120, 39, 'Voluptatem accusamus quibusdam aspernatur non commodi incidunt. Qui deserunt ut consequatur soluta quo ut. Rerum sit assumenda porro et commodi quos quisquam. Repellat quas soluta quasi veritatis. Eaque dolorem a magnam exercitationem soluta et distinctio. Fugiat numquam molestias vel exercitationem eius recusandae.', 'Numquam sequi consequatur sint magnam in totam. Voluptas et atque facilis dolor eveniet voluptatem ipsa. Minus id autem voluptatibus iste vitae et voluptate.', NULL, 'Pending', '2025-10-30 15:49:02', NULL, NULL, '2025-11-23 00:42:43', '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(151, 120, 47, 'Et dolorum soluta dolore aspernatur laudantium aut id pariatur. Aspernatur aut facilis odio accusantium inventore qui tempore. Officiis cupiditate labore voluptas porro. Modi et accusantium voluptatum et nihil. Ullam sequi veniam quis molestiae.', NULL, 'Necessitatibus similique sunt explicabo voluptate quidem odio.', 'Under Review', '2025-10-31 06:45:05', NULL, NULL, NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(152, 121, 12, 'In temporibus error sed minus. Enim labore quod porro nostrum saepe dolore enim consequatur. Animi harum omnis est delectus quod dolore eos. Ratione fugiat voluptatem est error magni. Magni consequatur cupiditate pariatur optio vel labore.', NULL, 'Esse molestiae ut omnis et ut.', 'Accepted', '2025-10-26 16:43:55', '2025-11-09 05:14:20', 'Harum qui eius molestiae repudiandae quasi.', '2025-12-06 07:35:18', '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(153, 127, 5, 'Provident reprehenderit nesciunt rerum molestiae. Repellat et et in qui. Exercitationem et dignissimos laborum dolor eaque temporibus dolores ullam. Vitae eaque accusantium dolorem velit ducimus. Aut enim doloremque dolorem beatae est placeat eos. Labore porro qui optio in itaque ut.', 'Repellendus tempora vero eum cum assumenda eum. Et reprehenderit voluptatibus ipsam aut. Impedit ut dolorem porro reiciendis vel quibusdam necessitatibus.', 'Molestiae ratione non voluptas omnis dolorum fuga veritatis eius.', 'Pending', '2025-11-13 07:05:14', NULL, NULL, NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(154, 127, 31, 'Iste numquam totam reprehenderit veniam dolor quam quia. Excepturi et repellat tempora deleniti. Et eius dolor ea voluptate sunt earum. Sint sed autem aspernatur dolorum neque. Exercitationem tempora eveniet debitis molestiae unde fugit fuga ea. Vel vitae nostrum ratione consequatur impedit.', NULL, NULL, 'Rejected', '2025-11-16 02:14:38', '2025-11-17 14:22:38', 'Ipsum et vel et.', NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(155, 127, 39, 'Quo repellendus consequatur sapiente. Tempora dignissimos qui voluptas dolorem similique. Et aut est quas minus aut. Dolore sit totam occaecati ullam alias fuga incidunt. Hic est similique qui non aut.', NULL, 'Aliquid veniam totam sint neque et sed ab.', 'Withdrawn', '2025-11-19 12:31:07', NULL, NULL, NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(156, 127, 46, 'Voluptate dolorem illum soluta iure minus. Est rerum voluptatibus quam at exercitationem nostrum. Reprehenderit reiciendis asperiores sapiente maxime dolorem est quis.', NULL, NULL, 'Withdrawn', '2025-11-18 04:34:48', NULL, NULL, '2025-11-27 20:16:06', '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(157, 127, 51, 'Voluptas quo laboriosam omnis porro ut sed vel. Cupiditate eaque mollitia et natus similique. Voluptatem ea reiciendis animi accusantium quos mollitia.', NULL, NULL, 'Rejected', '2025-10-30 04:13:48', '2025-11-07 10:11:48', NULL, '2025-12-01 19:34:10', '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(158, 128, 9, 'Ex suscipit eos cupiditate. Illum hic aut et sed. Rem facilis fugiat hic in. Eos quod beatae atque id maiores. Voluptatem at nesciunt est est similique dolore. Quo iste et soluta consectetur.', 'Quia saepe maiores alias beatae et quaerat ut. Ipsa omnis natus est inventore quisquam. Blanditiis et cumque sunt.', NULL, 'Withdrawn', '2025-10-29 12:35:25', NULL, NULL, '2025-12-01 02:32:50', '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(159, 128, 23, 'Molestias necessitatibus quo voluptas unde expedita. Amet est accusamus est velit. Blanditiis consequuntur blanditiis pariatur fugit aspernatur est et. Iure voluptatem maxime animi.', NULL, 'Et voluptas vero maxime mollitia possimus nam qui.', 'Under Review', '2025-11-20 16:26:34', NULL, NULL, NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(160, 128, 37, 'Saepe eum qui tempore dolorem consequatur voluptates. In perferendis consequuntur veritatis id atque sapiente dolorem distinctio. Facilis consequatur dicta consequatur blanditiis similique odio porro sunt. Quia et ea eos.', 'Aperiam sed quia ducimus iure. Voluptas necessitatibus voluptatem necessitatibus tempore ut. Eligendi consequuntur eaque quo praesentium quia.', 'Maiores natus aut saepe voluptas minima maxime non provident.', 'Under Review', '2025-11-18 09:09:38', NULL, NULL, '2025-11-25 18:41:01', '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(161, 128, 38, 'Qui porro et qui rerum. Vitae rerum ut tempora omnis aliquam praesentium et. Voluptas repellendus ipsam quae. Ut et quas assumenda optio voluptatibus. Eaque amet reprehenderit officia quia doloribus explicabo.', NULL, 'Qui qui assumenda odio quidem quae.', 'Accepted', '2025-11-04 19:51:35', '2025-11-08 07:37:16', 'Ex nulla et dolor eaque molestiae autem cum animi.', NULL, '2025-11-22 16:12:06', '2025-11-22 16:12:06'),
(162, 129, 8, 'Quod ex vel nihil rerum vero eius. Atque est et saepe. Beatae ut omnis magni ea. Non nihil officia rem officiis ipsa rerum eaque.', 'Sint et voluptatem perspiciatis in quaerat ad harum. Et earum aperiam architecto voluptatem voluptates accusamus. Iste et delectus aut.', NULL, 'Rejected', '2025-10-29 22:25:11', '2025-11-17 12:41:19', 'Quo ab sit aut.', '2025-12-03 15:38:55', '2025-11-22 16:12:06', '2025-11-22 16:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
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
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`, `icon`, `color`, `is_active`, `display_order`, `created_at`) VALUES
(1, 'Education', 'Teaching and training activities', 'fas fa-graduation-cap', '#3B82F6', 1, 1, '2025-11-22 16:11:48'),
(2, 'Healthcare', 'Medical and health support', 'fas fa-heartbeat', '#EF4444', 1, 2, '2025-11-22 16:11:48'),
(3, 'Environment', 'Environmental protection', 'fas fa-leaf', '#10B981', 1, 3, '2025-11-22 16:11:48'),
(4, 'Community', 'Community development', 'fas fa-users', '#8B5CF6', 1, 4, '2025-11-22 16:11:48'),
(5, 'Children', 'Child care and support', 'fas fa-child', '#F59E0B', 1, 5, '2025-11-22 16:11:48'),
(6, 'Elderly', 'Elder care services', 'fas fa-user-friends', '#6B7280', 1, 6, '2025-11-22 16:11:48'),
(7, 'Disaster Relief', 'Emergency response', 'fas fa-hands-helping', '#DC2626', 1, 7, '2025-11-22 16:11:48'),
(8, 'Animals', 'Animal welfare', 'fas fa-paw', '#059669', 1, 8, '2025-11-22 16:11:48'),
(9, 'maiores', 'Quis sed quo earum ut quasi rem ut beatae.', 'fas fa-qui', '#1d8275', 1, 44, '2025-11-22 16:12:16'),
(10, 'molestias', 'Beatae itaque suscipit sunt non qui.', 'fas fa-laborum', '#26e99d', 1, 13, '2025-11-22 16:12:24'),
(11, 'et', 'Esse ea dolorum iure minus quos animi eaque.', 'fas fa-facere', '#dc36d7', 1, 42, '2025-11-22 16:12:28'),
(12, 'qui', 'Maxime iusto molestias corrupti dolorum debitis est exercitationem explicabo.', 'fas fa-qui', '#cab004', 1, 65, '2025-11-22 16:12:32'),
(13, 'in', 'Nihil et est iure voluptate aut.', 'fas fa-ad', '#64ba67', 1, 60, '2025-11-22 16:12:34'),
(14, 'odit', 'Sunt et aut rerum ipsam beatae ex.', 'fas fa-expedita', '#801580', 1, 86, '2025-11-22 16:12:39'),
(15, 'eveniet', 'Voluptas est quis dolorem recusandae voluptates assumenda.', 'fas fa-ratione', '#bd2ee5', 1, 31, '2025-11-22 16:12:46'),
(16, 'nobis', 'Aut vitae dolor repudiandae dolorum labore mollitia commodi.', 'fas fa-saepe', '#4b53c3', 1, 11, '2025-11-22 16:12:48'),
(17, 'quo', 'Dolores quisquam laboriosam itaque atque id maxime.', 'fas fa-nostrum', '#da5248', 1, 32, '2025-11-22 16:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `connections`
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
-- Dumping data for table `connections`
--

INSERT INTO `connections` (`connection_id`, `user_id`, `friend_id`, `status`, `action_user_id`, `requested_at`, `accepted_at`, `blocked_at`, `created_at`, `updated_at`) VALUES
(1, 363, 2, 'accepted', 2, '2025-11-23 16:32:59', '2025-11-25 17:04:43', NULL, '2025-11-23 16:32:59', '2025-11-25 17:04:43');

--
-- Triggers `connections`
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
-- Table structure for table `conversations`
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
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`conversation_id`, `conversation_type`, `title`, `opportunity_id`, `created_by`, `last_message_at`, `is_active`, `created_at`) VALUES
(1, 'group', 'Sapiente dolorem qui.', NULL, 74, '2025-11-20 13:19:12', 1, '2025-11-22 16:12:07'),
(2, 'direct', NULL, NULL, 91, '2025-11-20 10:18:40', 1, '2025-11-22 16:12:10'),
(3, 'direct', NULL, NULL, 104, '2025-11-19 22:06:12', 1, '2025-11-22 16:12:13'),
(4, 'opportunity_chat', NULL, 130, 122, '2025-11-20 18:39:26', 1, '2025-11-22 16:12:17'),
(5, 'group', 'Iste tenetur quasi similique necessitatibus.', NULL, 134, '2025-11-16 12:01:20', 1, '2025-11-22 16:12:19'),
(6, 'direct', NULL, NULL, 148, '2025-11-16 13:01:06', 1, '2025-11-22 16:12:22'),
(7, 'opportunity_chat', NULL, 131, 158, '2025-11-21 00:27:28', 1, '2025-11-22 16:12:24'),
(8, 'opportunity_chat', NULL, 132, 178, '2025-11-19 05:12:28', 1, '2025-11-22 16:12:28'),
(9, 'group', 'Molestias corrupti dolorem.', NULL, 184, '2025-11-19 11:12:28', 1, '2025-11-22 16:12:29'),
(10, 'opportunity_chat', NULL, 133, 199, '2025-11-15 22:50:45', 1, '2025-11-22 16:12:32'),
(11, 'opportunity_chat', NULL, 134, 212, '2025-11-17 23:26:46', 1, '2025-11-22 16:12:35'),
(12, 'opportunity_chat', NULL, 135, 233, '2025-11-21 04:20:30', 1, '2025-11-22 16:12:39'),
(13, 'group', 'Natus autem et aut.', NULL, 253, '2025-11-21 02:56:56', 1, '2025-11-22 16:12:43'),
(14, 'opportunity_chat', NULL, 136, 265, '2025-11-21 12:36:36', 1, '2025-11-22 16:12:46'),
(15, 'opportunity_chat', NULL, 137, 274, '2025-11-21 03:55:52', 1, '2025-11-22 16:12:48'),
(16, 'opportunity_chat', NULL, 138, 296, '2025-11-22 14:27:24', 1, '2025-11-22 16:12:54'),
(17, 'direct', NULL, NULL, 305, '2025-11-20 16:00:41', 1, '2025-11-22 16:12:57'),
(18, 'direct', NULL, NULL, 317, '2025-11-20 10:26:24', 1, '2025-11-22 16:13:00'),
(19, 'direct', NULL, NULL, 332, '2025-11-21 18:14:46', 1, '2025-11-22 16:13:04'),
(20, 'direct', NULL, NULL, 351, '2025-11-17 11:19:10', 1, '2025-11-22 16:13:09'),
(21, 'direct', 'Chat với quý duy', NULL, 2, '2025-11-25 17:04:57', 1, '2025-11-25 17:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `conversation_participants`
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
-- Dumping data for table `conversation_participants`
--

INSERT INTO `conversation_participants` (`participant_id`, `conversation_id`, `user_id`, `joined_at`, `last_read_at`, `unread_count`, `is_active`) VALUES
(1, 21, 2, '2025-11-25 17:04:57', NULL, 0, 1),
(2, 21, 363, '2025-11-25 17:04:57', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `donations`
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

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`id`, `campaign_id`, `user_id`, `amount`, `message`, `status`, `vnp_TransactionNo`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 50000, 'oke chúc hsq khỏe mạnh', 'Pending', NULL, '2025-11-24 05:57:30', '2025-11-24 05:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `donation_campaigns`
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

--
-- Dumping data for table `donation_campaigns`
--

INSERT INTO `donation_campaigns` (`id`, `admin_user_id`, `title`, `description`, `banner_image_url`, `target_amount`, `current_amount`, `end_date`, `status`, `is_pinned`, `created_at`, `updated_at`) VALUES
(1, 3, 'Ủng hộ Hoa Sơn Quý', 'Quý - là 1 cậu bé tài năng từ béo đến ngậy', 'campaign_banners/JPA2D0nwt3Hw1Xv49f4a7sRNQ4N3fSDXyayPI46F.jpg', 1000000, 0, '2025-11-27 00:00:00', 'Active', 1, '2025-11-24 05:56:04', '2025-11-24 05:56:04');

-- --------------------------------------------------------

--
-- Table structure for table `email_logs`
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

--
-- Dumping data for table `email_logs`
--

INSERT INTO `email_logs` (`id`, `recipient_type`, `recipient_count`, `subject`, `sent_by`, `sent_at`, `created_at`, `updated_at`) VALUES
(1, 'single', 1, 'Important Announcement', 3, '2025-11-26 16:03:06', '2025-11-26 16:03:06', NULL),
(2, 'single', 1, 'ê con chó', 3, '2025-11-27 08:53:48', '2025-11-27 08:53:48', NULL),
(3, 'single', 1, 'hoa son quy', 3, '2025-11-27 09:22:28', '2025-11-27 09:22:28', NULL),
(4, 'single', 1, 'Chào mừng {{full_name}} đến với Anh Em Rọt Store', 3, '2025-11-27 09:56:03', '2025-11-27 09:56:03', NULL),
(5, 'single', 1, 'Important Announcement', 3, '2025-11-27 11:13:10', '2025-11-27 11:13:10', NULL),
(6, 'single', 1, 'Important Announcement', 3, '2025-11-27 11:13:14', '2025-11-27 11:13:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `opportunity_id` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `opportunity_id`, `notes`, `created_at`) VALUES
(1, 4, 43, NULL, '2025-11-22 16:13:12'),
(2, 4, 67, 'Omnis et sit reiciendis non sint aspernatur ipsum.', '2025-11-22 16:13:12'),
(3, 4, 72, NULL, '2025-11-22 16:13:12'),
(4, 4, 104, NULL, '2025-11-22 16:13:12'),
(5, 4, 123, 'Qui error expedita laudantium repellat omnis itaque commodi.', '2025-11-22 16:13:12'),
(6, 7, 17, NULL, '2025-11-22 16:13:12'),
(7, 7, 36, 'Officiis odio velit reiciendis sed odio impedit autem.', '2025-11-22 16:13:12'),
(8, 7, 70, 'Nihil eos unde quae possimus iure.', '2025-11-22 16:13:12'),
(9, 7, 105, NULL, '2025-11-22 16:13:12'),
(10, 7, 128, NULL, '2025-11-22 16:13:12'),
(11, 8, 13, 'Sit cum alias blanditiis minima consequatur ducimus.', '2025-11-22 16:13:12'),
(12, 8, 14, 'Dolores minima et necessitatibus saepe reiciendis.', '2025-11-22 16:13:12'),
(13, 8, 31, NULL, '2025-11-22 16:13:12'),
(14, 8, 63, NULL, '2025-11-22 16:13:12'),
(15, 8, 119, NULL, '2025-11-22 16:13:12'),
(16, 10, 6, 'Et quod commodi est maiores voluptas dolorem et.', '2025-11-22 16:13:12'),
(17, 10, 83, NULL, '2025-11-22 16:13:12'),
(18, 10, 92, 'Enim dolores distinctio omnis at odio adipisci omnis.', '2025-11-22 16:13:12'),
(19, 11, 27, NULL, '2025-11-22 16:13:12'),
(20, 11, 41, 'A vel et veritatis et numquam tempora.', '2025-11-22 16:13:12'),
(21, 11, 56, NULL, '2025-11-22 16:13:12'),
(22, 11, 105, 'Quos autem enim qui at sunt.', '2025-11-22 16:13:12'),
(23, 11, 106, NULL, '2025-11-22 16:13:12'),
(24, 13, 8, 'Incidunt praesentium quas voluptatem.', '2025-11-22 16:13:12'),
(25, 13, 41, 'Voluptates neque blanditiis fugit ut voluptatibus in soluta.', '2025-11-22 16:13:12'),
(26, 13, 128, NULL, '2025-11-22 16:13:12'),
(27, 15, 29, NULL, '2025-11-22 16:13:12'),
(28, 15, 74, 'Beatae expedita porro dolor a nulla.', '2025-11-22 16:13:12'),
(29, 16, 26, NULL, '2025-11-22 16:13:12'),
(30, 16, 92, NULL, '2025-11-22 16:13:12'),
(31, 17, 108, NULL, '2025-11-22 16:13:12'),
(32, 17, 119, 'Dolor dolorum blanditiis veritatis dolores omnis suscipit fugit.', '2025-11-22 16:13:12'),
(33, 17, 126, NULL, '2025-11-22 16:13:12'),
(34, 18, 6, NULL, '2025-11-22 16:13:12'),
(35, 18, 37, NULL, '2025-11-22 16:13:12'),
(36, 19, 29, NULL, '2025-11-22 16:13:12'),
(37, 19, 48, 'Eos sit dicta accusamus facilis dolorem.', '2025-11-22 16:13:12'),
(38, 19, 125, NULL, '2025-11-22 16:13:12'),
(39, 19, 127, 'Voluptatem ea minima doloremque quos quae dolorem.', '2025-11-22 16:13:12'),
(40, 22, 1, NULL, '2025-11-22 16:13:12'),
(41, 22, 29, NULL, '2025-11-22 16:13:12'),
(42, 22, 35, 'Et iure dolor pariatur nemo error mollitia.', '2025-11-22 16:13:12'),
(43, 22, 52, NULL, '2025-11-22 16:13:12'),
(44, 23, 5, 'Necessitatibus blanditiis doloribus nesciunt consectetur qui.', '2025-11-22 16:13:12'),
(45, 23, 86, 'Possimus sapiente impedit quia consequuntur voluptas quidem.', '2025-11-22 16:13:12'),
(46, 25, 10, 'Consequatur ut vel doloremque ut qui.', '2025-11-22 16:13:12'),
(47, 25, 26, 'Cupiditate quia voluptatem qui tempora.', '2025-11-22 16:13:12'),
(48, 25, 40, NULL, '2025-11-22 16:13:12'),
(49, 25, 106, 'Voluptatum qui dolorem accusantium voluptatem assumenda.', '2025-11-22 16:13:12'),
(50, 25, 117, 'Non qui magni nostrum.', '2025-11-22 16:13:12'),
(51, 26, 58, NULL, '2025-11-22 16:13:12'),
(52, 26, 95, NULL, '2025-11-22 16:13:12'),
(53, 26, 109, NULL, '2025-11-22 16:13:12'),
(54, 26, 114, NULL, '2025-11-22 16:13:12'),
(55, 28, 99, NULL, '2025-11-22 16:13:12'),
(56, 28, 125, 'Placeat aperiam nulla animi vero.', '2025-11-22 16:13:12'),
(57, 31, 8, NULL, '2025-11-22 16:13:12'),
(58, 31, 118, NULL, '2025-11-22 16:13:12'),
(59, 32, 23, NULL, '2025-11-22 16:13:12'),
(60, 32, 28, NULL, '2025-11-22 16:13:12'),
(61, 32, 32, NULL, '2025-11-22 16:13:12'),
(62, 32, 59, NULL, '2025-11-22 16:13:12'),
(63, 32, 93, NULL, '2025-11-22 16:13:12'),
(64, 34, 16, 'Maiores sequi dolores necessitatibus odit.', '2025-11-22 16:13:12'),
(65, 34, 79, NULL, '2025-11-22 16:13:12'),
(66, 34, 103, 'Error minus praesentium cum iusto quaerat id.', '2025-11-22 16:13:12'),
(67, 34, 129, 'Et velit sit eum autem enim iste atque.', '2025-11-22 16:13:12'),
(68, 35, 40, NULL, '2025-11-22 16:13:12'),
(69, 35, 75, NULL, '2025-11-22 16:13:12'),
(70, 37, 16, NULL, '2025-11-22 16:13:12'),
(71, 37, 31, 'Alias et aut cum vel quaerat sit iure.', '2025-11-22 16:13:12'),
(72, 37, 58, 'Reiciendis quisquam quo eveniet facilis voluptas id id nisi.', '2025-11-22 16:13:12'),
(73, 37, 110, NULL, '2025-11-22 16:13:12'),
(74, 39, 90, 'Quasi exercitationem occaecati eos iusto consectetur nesciunt.', '2025-11-22 16:13:12'),
(75, 39, 105, 'Consequuntur porro iusto omnis.', '2025-11-22 16:13:12'),
(76, 39, 115, 'Id harum porro aspernatur expedita quas voluptatum.', '2025-11-22 16:13:12'),
(77, 42, 25, NULL, '2025-11-22 16:13:12'),
(78, 44, 37, NULL, '2025-11-22 16:13:12'),
(79, 44, 79, 'Quos itaque dolorum quod dolores non iste provident.', '2025-11-22 16:13:12'),
(80, 44, 119, NULL, '2025-11-22 16:13:12'),
(81, 45, 31, NULL, '2025-11-22 16:13:12'),
(82, 45, 45, 'Architecto cumque quis aut omnis veritatis.', '2025-11-22 16:13:12'),
(83, 45, 68, NULL, '2025-11-22 16:13:12'),
(84, 45, 109, NULL, '2025-11-22 16:13:12'),
(85, 46, 13, NULL, '2025-11-22 16:13:12'),
(86, 46, 18, NULL, '2025-11-22 16:13:12'),
(87, 46, 40, NULL, '2025-11-22 16:13:12'),
(88, 46, 61, 'Quidem quia libero veritatis delectus est suscipit provident.', '2025-11-22 16:13:12'),
(89, 46, 71, 'Autem cupiditate dolor expedita.', '2025-11-22 16:13:12'),
(90, 48, 8, NULL, '2025-11-22 16:13:12'),
(91, 48, 19, NULL, '2025-11-22 16:13:12'),
(92, 50, 68, 'Et et doloribus est voluptatibus tempora repellendus alias.', '2025-11-22 16:13:12'),
(93, 50, 85, NULL, '2025-11-22 16:13:12'),
(94, 52, 107, NULL, '2025-11-22 16:13:12'),
(95, 52, 122, 'Quis laborum voluptatem sapiente veritatis.', '2025-11-22 16:13:12'),
(96, 53, 60, NULL, '2025-11-22 16:13:12'),
(97, 53, 88, 'Dolor dicta dolores qui fugit delectus.', '2025-11-22 16:13:12'),
(98, 53, 122, NULL, '2025-11-22 16:13:12'),
(99, 363, 139, NULL, '2025-11-23 16:33:13');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `messages`
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
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `conversation_id`, `sender_id`, `message_type`, `content`, `attachment_url`, `attachment_name`, `is_deleted`, `sent_at`) VALUES
(1, 1, 75, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aacc?text=modi', 'et.dpg', 0, '2025-11-17 18:41:38'),
(2, 1, 76, 'text', 'Sunt qui laboriosam hic velit. Voluptatem alias provident voluptatem quam sed suscipit odio. Dignissimos eos consequuntur ut porro voluptatem dolor qui. Sit iusto illo error quasi in debitis ex.', NULL, NULL, 0, '2025-11-22 11:04:48'),
(3, 1, 77, 'file', NULL, 'https://via.placeholder.com/640x480.png/00dd88?text=minus', 'dolor.sitx', 0, '2025-11-18 01:20:14'),
(4, 1, 78, 'file', NULL, 'https://via.placeholder.com/640x480.png/006699?text=reprehenderit', 'ipsum.gramps', 0, '2025-11-17 07:56:23'),
(5, 1, 79, 'video', NULL, 'https://via.placeholder.com/640x480.png/008822?text=placeat', 'nostrum.uvvz', 0, '2025-11-18 09:56:19'),
(6, 1, 80, 'video', NULL, 'https://via.placeholder.com/640x480.png/00dd66?text=earum', 'ipsum.docx', 0, '2025-11-19 22:45:31'),
(7, 1, 81, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aa22?text=quo', 'maxime.uoml', 0, '2025-11-21 01:43:18'),
(8, 1, 82, 'text', 'Harum sequi ut non quibusdam quo qui nam. Sit enim quia placeat deleniti ut. Ratione voluptatem ipsa ut ea.', NULL, NULL, 0, '2025-11-19 17:11:46'),
(9, 1, 83, 'image', NULL, 'https://via.placeholder.com/640x480.png/0055ff?text=quas', 'non.curl', 0, '2025-11-21 16:37:17'),
(10, 1, 84, 'image', NULL, 'https://via.placeholder.com/640x480.png/005522?text=repellat', 'adipisci.install', 0, '2025-11-16 16:51:47'),
(11, 1, 85, 'file', NULL, 'https://via.placeholder.com/640x480.png/007744?text=sunt', 'nesciunt.gif', 1, '2025-11-19 19:19:10'),
(12, 1, 86, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ddff?text=quidem', 'expedita.xwd', 0, '2025-11-20 23:10:24'),
(13, 1, 87, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff88?text=accusamus', 'officia.emma', 0, '2025-11-16 04:02:19'),
(14, 1, 88, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ee55?text=sit', 'id.ppsx', 0, '2025-11-21 21:45:16'),
(15, 1, 89, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aadd?text=veritatis', 'et.xdp', 0, '2025-11-21 03:21:46'),
(16, 1, 90, 'text', 'Est molestiae mollitia quis est ex iste et. Et est est esse minus dolorem. Corporis iste nisi dignissimos nesciunt vero facilis. Deserunt magnam earum praesentium quaerat tempora ut veritatis. Recusandae quidem at enim minima vero.', NULL, NULL, 0, '2025-11-21 01:04:25'),
(17, 2, 92, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ffbb?text=quo', 'expedita.rlc', 1, '2025-11-16 17:15:01'),
(18, 2, 93, 'text', 'Qui ut explicabo doloribus. Fugiat totam pariatur voluptatibus vero nihil. Illum dolores voluptates rerum quo doloribus quam. Modi officiis et reiciendis perferendis harum consequatur.', NULL, NULL, 0, '2025-11-17 03:21:18'),
(19, 2, 94, 'video', NULL, 'https://via.placeholder.com/640x480.png/007777?text=libero', 'quasi.xltx', 0, '2025-11-19 23:04:18'),
(20, 2, 95, 'image', NULL, 'https://via.placeholder.com/640x480.png/0066cc?text=dolor', 'laboriosam.utz', 0, '2025-11-17 20:49:11'),
(21, 2, 96, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ffee?text=facilis', 'veniam.srt', 0, '2025-11-19 21:52:48'),
(22, 2, 97, 'video', NULL, 'https://via.placeholder.com/640x480.png/0011ee?text=nam', 'consequatur.cat', 0, '2025-11-21 10:59:40'),
(23, 2, 98, 'file', NULL, 'https://via.placeholder.com/640x480.png/00aa33?text=soluta', 'aut.esf', 0, '2025-11-18 03:27:42'),
(24, 2, 99, 'text', 'Ad corporis et illum. Ut pariatur dolores aut laudantium vitae dolores eaque.', NULL, NULL, 0, '2025-11-21 08:02:28'),
(25, 2, 100, 'file', NULL, 'https://via.placeholder.com/640x480.png/006600?text=quod', 'eaque.xps', 0, '2025-11-17 04:36:54'),
(26, 2, 101, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ccff?text=pariatur', 'similique.dvb', 1, '2025-11-21 09:06:33'),
(27, 2, 102, 'video', NULL, 'https://via.placeholder.com/640x480.png/003344?text=sed', 'voluptate.h264', 0, '2025-11-18 12:08:47'),
(28, 2, 103, 'image', NULL, 'https://via.placeholder.com/640x480.png/005522?text=et', 'tempora.ksp', 0, '2025-11-18 15:26:11'),
(29, 3, 105, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aa99?text=asperiores', 'eum.docm', 0, '2025-11-22 00:17:20'),
(30, 3, 106, 'video', NULL, 'https://via.placeholder.com/640x480.png/000055?text=impedit', 'dolor.sm', 0, '2025-11-20 10:02:27'),
(31, 3, 107, 'image', NULL, 'https://via.placeholder.com/640x480.png/00bbcc?text=quam', 'et.uu', 0, '2025-11-21 16:00:39'),
(32, 3, 108, 'video', NULL, 'https://via.placeholder.com/640x480.png/0011cc?text=vitae', 'ratione.yin', 0, '2025-11-21 14:33:34'),
(33, 3, 109, 'video', NULL, 'https://via.placeholder.com/640x480.png/00cc77?text=natus', 'doloremque.ras', 0, '2025-11-19 00:22:50'),
(34, 3, 110, 'file', NULL, 'https://via.placeholder.com/640x480.png/00aa11?text=corrupti', 'delectus.pkipath', 0, '2025-11-15 22:19:44'),
(35, 3, 111, 'image', NULL, 'https://via.placeholder.com/640x480.png/0066bb?text=illo', 'beatae.ogv', 0, '2025-11-19 07:56:09'),
(36, 3, 112, 'video', NULL, 'https://via.placeholder.com/640x480.png/008855?text=ipsum', 'eveniet.vcd', 0, '2025-11-19 06:24:10'),
(37, 3, 113, 'image', NULL, 'https://via.placeholder.com/640x480.png/0066ee?text=labore', 'harum.ogv', 0, '2025-11-18 06:53:49'),
(38, 3, 114, 'file', NULL, 'https://via.placeholder.com/640x480.png/0066dd?text=sit', 'facilis.pic', 0, '2025-11-19 11:10:33'),
(39, 3, 115, 'text', 'Et reiciendis illo ratione in. Porro corporis nihil perferendis repellendus. Corporis illo et quia perferendis sapiente facilis laborum. Consectetur est similique nisi rerum quos incidunt.', NULL, NULL, 0, '2025-11-19 05:57:04'),
(40, 3, 116, 'video', NULL, 'https://via.placeholder.com/640x480.png/008833?text=excepturi', 'aut.sxc', 0, '2025-11-15 16:53:38'),
(41, 3, 117, 'image', NULL, 'https://via.placeholder.com/640x480.png/007777?text=tempore', 'dolore.java', 0, '2025-11-16 10:06:14'),
(42, 3, 118, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ff44?text=porro', 'facere.uvvx', 0, '2025-11-20 03:42:06'),
(43, 3, 119, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff66?text=hic', 'unde.wax', 0, '2025-11-17 06:35:24'),
(44, 3, 120, 'image', NULL, 'https://via.placeholder.com/640x480.png/001199?text=accusamus', 'impedit.sse', 0, '2025-11-19 21:19:22'),
(45, 4, 123, 'image', NULL, 'https://via.placeholder.com/640x480.png/0033aa?text=accusamus', 'quis.srt', 0, '2025-11-19 11:50:23'),
(46, 4, 124, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ffdd?text=eaque', 'suscipit.wvx', 0, '2025-11-19 20:18:38'),
(47, 4, 125, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ddff?text=dolorem', 'libero.djvu', 0, '2025-11-21 18:38:16'),
(48, 4, 126, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd22?text=qui', 'placeat.dwf', 0, '2025-11-20 05:33:34'),
(49, 4, 127, 'video', NULL, 'https://via.placeholder.com/640x480.png/000044?text=hic', 'architecto.mcurl', 0, '2025-11-21 14:19:45'),
(50, 4, 128, 'text', 'Et dolorem enim quia voluptatem quod. Molestiae ab et et recusandae dolor sed.', NULL, NULL, 0, '2025-11-20 08:44:19'),
(51, 4, 129, 'file', NULL, 'https://via.placeholder.com/640x480.png/0099bb?text=non', 'debitis.sxd', 0, '2025-11-22 11:54:08'),
(52, 4, 130, 'video', NULL, 'https://via.placeholder.com/640x480.png/008844?text=fuga', 'quos.rdz', 0, '2025-11-18 13:38:05'),
(53, 4, 131, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dd66?text=velit', 'blanditiis.dae', 0, '2025-11-20 20:43:08'),
(54, 4, 132, 'image', NULL, 'https://via.placeholder.com/640x480.png/0088bb?text=et', 'aliquam.tpt', 0, '2025-11-17 06:21:30'),
(55, 4, 133, 'text', 'Nihil ipsam nam et commodi et impedit. Quia ut amet ea placeat. Dignissimos velit quae nemo optio quisquam dolorum. Reprehenderit aut similique dolores molestiae illo.', NULL, NULL, 0, '2025-11-21 18:40:23'),
(56, 5, 135, 'file', NULL, 'https://via.placeholder.com/640x480.png/00aa55?text=deserunt', 'explicabo.potm', 0, '2025-11-16 09:47:56'),
(57, 5, 136, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aa11?text=illo', 'ipsa.rip', 0, '2025-11-17 11:05:40'),
(58, 5, 137, 'file', NULL, 'https://via.placeholder.com/640x480.png/008811?text=autem', 'ea.mxs', 0, '2025-11-17 03:42:42'),
(59, 5, 138, 'video', NULL, 'https://via.placeholder.com/640x480.png/0088dd?text=repudiandae', 'velit.fgd', 0, '2025-11-17 14:17:50'),
(60, 5, 139, 'text', 'Laborum sed amet accusamus consequatur sit. Pariatur a aliquid enim voluptas qui quisquam quia. Est quos expedita harum ratione aspernatur ipsum eaque.', NULL, NULL, 0, '2025-11-20 23:33:36'),
(61, 5, 140, 'text', 'Maxime qui corrupti porro aliquid aut perspiciatis. Nihil adipisci voluptatibus aut labore adipisci. Placeat enim quos reprehenderit repudiandae vero. Suscipit soluta ipsa at in minima incidunt unde.', NULL, NULL, 0, '2025-11-21 01:02:18'),
(62, 5, 141, 'text', 'Voluptatem reprehenderit repudiandae consectetur impedit. Et blanditiis voluptates ab.', NULL, NULL, 0, '2025-11-18 18:39:48'),
(63, 5, 142, 'video', NULL, 'https://via.placeholder.com/640x480.png/0011cc?text=ex', 'illo.mts', 0, '2025-11-21 17:56:09'),
(64, 5, 143, 'image', NULL, 'https://via.placeholder.com/640x480.png/000022?text=sint', 'est.udeb', 0, '2025-11-21 20:02:54'),
(65, 5, 144, 'image', NULL, 'https://via.placeholder.com/640x480.png/00cc88?text=in', 'voluptate.application', 0, '2025-11-19 15:11:33'),
(66, 5, 145, 'text', 'Ab expedita ut quasi corrupti qui dicta voluptas omnis. Nisi aut eos debitis sunt saepe voluptatibus. Nostrum error assumenda et facilis.', NULL, NULL, 0, '2025-11-17 03:10:46'),
(67, 5, 146, 'image', NULL, 'https://via.placeholder.com/640x480.png/009900?text=ipsa', 'et.spot', 0, '2025-11-19 12:20:09'),
(68, 5, 147, 'file', NULL, 'https://via.placeholder.com/640x480.png/005544?text=qui', 'nostrum.xpm', 0, '2025-11-22 10:37:01'),
(69, 6, 149, 'file', NULL, 'https://via.placeholder.com/640x480.png/003300?text=ut', 'quae.dsc', 0, '2025-11-21 11:21:40'),
(70, 6, 150, 'file', NULL, 'https://via.placeholder.com/640x480.png/00aadd?text=in', 'quaerat.mka', 0, '2025-11-22 01:11:27'),
(71, 6, 151, 'file', NULL, 'https://via.placeholder.com/640x480.png/00bb88?text=voluptatum', 'quaerat.otc', 0, '2025-11-21 00:35:45'),
(72, 6, 152, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff99?text=vero', 'pariatur.h264', 0, '2025-11-19 15:01:42'),
(73, 6, 153, 'text', 'Ipsam ipsam autem facere qui officia et. Eveniet autem alias ea hic aut. Iusto non tempore aut et sint quos est.', NULL, NULL, 0, '2025-11-21 23:24:46'),
(74, 6, 154, 'image', NULL, 'https://via.placeholder.com/640x480.png/0011ee?text=quisquam', 'aut.jad', 0, '2025-11-18 20:12:15'),
(75, 6, 155, 'image', NULL, 'https://via.placeholder.com/640x480.png/003311?text=quam', 'non.fly', 0, '2025-11-16 19:35:28'),
(76, 6, 156, 'file', NULL, 'https://via.placeholder.com/640x480.png/002200?text=saepe', 'quos.gv', 0, '2025-11-20 14:06:37'),
(77, 7, 159, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aaff?text=eius', 'quia.ief', 0, '2025-11-20 15:05:32'),
(78, 7, 160, 'image', NULL, 'https://via.placeholder.com/640x480.png/00cc44?text=cupiditate', 'quae.xps', 0, '2025-11-19 19:56:31'),
(79, 7, 161, 'video', NULL, 'https://via.placeholder.com/640x480.png/002211?text=suscipit', 'odit.hlp', 0, '2025-11-20 07:55:53'),
(80, 7, 162, 'text', 'Nulla nihil aperiam sunt consectetur beatae omnis ea. Ratione id dicta quisquam labore corporis sapiente sit. Dolores harum dignissimos distinctio ut. Iusto rerum incidunt et molestiae.', NULL, NULL, 0, '2025-11-17 13:33:56'),
(81, 7, 163, 'image', NULL, 'https://via.placeholder.com/640x480.png/005599?text=rem', 'sunt.sm', 0, '2025-11-17 01:36:57'),
(82, 7, 164, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee55?text=adipisci', 'voluptatem.pre', 0, '2025-11-18 21:37:26'),
(83, 7, 165, 'text', 'Voluptates fuga sapiente occaecati velit ut sed. Molestias quae quo perferendis delectus harum quod perspiciatis. Neque architecto ut reprehenderit rerum facilis.', NULL, NULL, 0, '2025-11-21 05:15:45'),
(84, 7, 166, 'image', NULL, 'https://via.placeholder.com/640x480.png/008866?text=pariatur', 'qui.bmp', 0, '2025-11-16 17:30:17'),
(85, 7, 167, 'video', NULL, 'https://via.placeholder.com/640x480.png/0088ff?text=quia', 'facere.vsw', 0, '2025-11-19 16:18:57'),
(86, 7, 168, 'image', NULL, 'https://via.placeholder.com/640x480.png/0099ee?text=voluptatem', 'itaque.lasxml', 0, '2025-11-16 02:23:24'),
(87, 7, 169, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ccff?text=et', 'ut.thmx', 0, '2025-11-17 00:02:17'),
(88, 7, 170, 'video', NULL, 'https://via.placeholder.com/640x480.png/000099?text=iure', 'voluptatem.nsc', 0, '2025-11-22 04:53:42'),
(89, 7, 171, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ee66?text=officiis', 'porro.dtd', 0, '2025-11-18 03:30:16'),
(90, 7, 172, 'file', NULL, 'https://via.placeholder.com/640x480.png/009944?text=quo', 'ratione.pskcxml', 0, '2025-11-18 15:22:16'),
(91, 7, 173, 'file', NULL, 'https://via.placeholder.com/640x480.png/00eeee?text=iure', 'sunt.arc', 0, '2025-11-21 11:35:01'),
(92, 7, 174, 'image', NULL, 'https://via.placeholder.com/640x480.png/006644?text=consequatur', 'voluptas.vcd', 0, '2025-11-17 23:03:21'),
(93, 7, 175, 'file', NULL, 'https://via.placeholder.com/640x480.png/000011?text=minima', 'ipsam.fbs', 0, '2025-11-20 08:13:27'),
(94, 7, 176, 'image', NULL, 'https://via.placeholder.com/640x480.png/006633?text=dolores', 'facere.yin', 0, '2025-11-21 12:37:11'),
(95, 8, 179, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aaee?text=minima', 'ex.srt', 0, '2025-11-16 15:12:46'),
(96, 8, 180, 'text', 'Ea est et totam reiciendis. Aperiam fugit nam velit. Quia sed quia inventore temporibus non eos nihil.', NULL, NULL, 0, '2025-11-20 12:57:24'),
(97, 8, 181, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ffff?text=magnam', 'omnis.h261', 0, '2025-11-18 08:59:06'),
(98, 8, 182, 'video', NULL, 'https://via.placeholder.com/640x480.png/0099aa?text=dolores', 'rerum.uvvg', 0, '2025-11-17 02:52:47'),
(99, 8, 183, 'text', 'Quae quibusdam ea officia molestiae sed numquam molestiae. Quas vitae consequatur accusamus voluptas accusantium dolor voluptatibus laudantium. Consequatur explicabo ut velit iure quis.', NULL, NULL, 0, '2025-11-20 01:43:42'),
(100, 9, 185, 'image', NULL, 'https://via.placeholder.com/640x480.png/006688?text=odio', 'rerum.aac', 0, '2025-11-18 03:10:40'),
(101, 9, 186, 'text', 'Dolorem neque facilis cum. Qui incidunt voluptates excepturi laboriosam suscipit qui. Sapiente voluptates voluptates et quo eligendi. Ut sequi autem quia velit aut.', NULL, NULL, 0, '2025-11-18 20:52:18'),
(102, 9, 187, 'video', NULL, 'https://via.placeholder.com/640x480.png/003355?text=eaque', 'ut.stw', 0, '2025-11-22 05:06:44'),
(103, 9, 188, 'text', 'Atque qui totam et quod ab quasi. Unde dolor qui sed voluptates porro dolor. Tempore laboriosam illo sint eligendi provident incidunt.', NULL, NULL, 0, '2025-11-17 16:00:50'),
(104, 9, 189, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee44?text=provident', 'explicabo.st', 0, '2025-11-22 00:38:16'),
(105, 9, 190, 'file', NULL, 'https://via.placeholder.com/640x480.png/003344?text=voluptatem', 'velit.sid', 0, '2025-11-17 19:57:16'),
(106, 9, 191, 'file', NULL, 'https://via.placeholder.com/640x480.png/008866?text=perferendis', 'provident.sxg', 0, '2025-11-20 14:34:03'),
(107, 9, 192, 'image', NULL, 'https://via.placeholder.com/640x480.png/006644?text=libero', 'laboriosam.stl', 0, '2025-11-21 12:40:44'),
(108, 9, 193, 'video', NULL, 'https://via.placeholder.com/640x480.png/001188?text=eius', 'aut.uoml', 0, '2025-11-22 14:10:50'),
(109, 9, 194, 'image', NULL, 'https://via.placeholder.com/640x480.png/0000aa?text=adipisci', 'voluptates.odp', 0, '2025-11-21 09:40:52'),
(110, 9, 195, 'file', NULL, 'https://via.placeholder.com/640x480.png/008844?text=molestiae', 'et.h264', 0, '2025-11-16 08:54:00'),
(111, 9, 196, 'file', NULL, 'https://via.placeholder.com/640x480.png/002211?text=maiores', 'at.pbm', 0, '2025-11-18 08:20:10'),
(112, 9, 197, 'video', NULL, 'https://via.placeholder.com/640x480.png/00dddd?text=qui', 'id.fst', 0, '2025-11-16 10:30:01'),
(113, 10, 200, 'image', NULL, 'https://via.placeholder.com/640x480.png/0022ee?text=eligendi', 'quo.qxb', 0, '2025-11-21 03:31:56'),
(114, 10, 201, 'file', NULL, 'https://via.placeholder.com/640x480.png/0044ee?text=doloremque', 'deleniti.vcd', 0, '2025-11-17 21:06:38'),
(115, 10, 202, 'video', NULL, 'https://via.placeholder.com/640x480.png/006644?text=eos', 'delectus.stl', 0, '2025-11-19 23:57:20'),
(116, 10, 203, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aadd?text=nam', 'vitae.ris', 0, '2025-11-19 01:37:00'),
(117, 10, 204, 'text', 'Incidunt minus laboriosam et quo et. Eveniet consequuntur sit recusandae nam. Autem ea culpa recusandae totam dolores officiis sequi.', NULL, NULL, 0, '2025-11-21 10:21:08'),
(118, 10, 205, 'image', NULL, 'https://via.placeholder.com/640x480.png/0088ff?text=debitis', 'voluptas.musicxml', 0, '2025-11-18 16:14:22'),
(119, 10, 206, 'file', NULL, 'https://via.placeholder.com/640x480.png/002244?text=voluptatibus', 'velit.sxw', 0, '2025-11-21 04:06:01'),
(120, 10, 207, 'text', 'Dicta iste blanditiis repudiandae voluptatibus vel et autem. Quia quia consequatur velit iure fugiat eligendi. Ut officia sit est id harum.', NULL, NULL, 1, '2025-11-15 19:05:10'),
(121, 10, 208, 'file', NULL, 'https://via.placeholder.com/640x480.png/00cc77?text=rem', 'id.m4v', 0, '2025-11-21 16:39:24'),
(122, 10, 209, 'image', NULL, 'https://via.placeholder.com/640x480.png/00bb22?text=et', 'odio.sxi', 0, '2025-11-22 08:01:22'),
(123, 10, 210, 'file', NULL, 'https://via.placeholder.com/640x480.png/0066ee?text=nihil', 'sapiente.odc', 0, '2025-11-20 05:46:18'),
(124, 11, 213, 'file', NULL, 'https://via.placeholder.com/640x480.png/0022bb?text=earum', 'sed.gif', 0, '2025-11-16 03:48:22'),
(125, 11, 214, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ee77?text=deserunt', 'eos.jnlp', 0, '2025-11-17 15:17:19'),
(126, 11, 215, 'file', NULL, 'https://via.placeholder.com/640x480.png/0022aa?text=quae', 'optio.mj2', 0, '2025-11-18 11:41:30'),
(127, 11, 216, 'image', NULL, 'https://via.placeholder.com/640x480.png/001144?text=nisi', 'reprehenderit.ivp', 0, '2025-11-21 22:12:00'),
(128, 11, 217, 'file', NULL, 'https://via.placeholder.com/640x480.png/003388?text=consectetur', 'expedita.sxc', 0, '2025-11-22 13:25:55'),
(129, 11, 218, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ccbb?text=ut', 'rerum.ksp', 0, '2025-11-18 16:06:36'),
(130, 11, 219, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff22?text=qui', 'repudiandae.dxr', 0, '2025-11-21 16:16:51'),
(131, 11, 220, 'text', 'Quaerat dolore incidunt unde debitis qui ullam. Ea quia autem nemo est sit et fuga.', NULL, NULL, 0, '2025-11-21 02:44:27'),
(132, 11, 221, 'text', 'Dolorem quia sit non hic officiis. Reprehenderit qui excepturi est delectus. Necessitatibus blanditiis aliquid soluta repellat sint.', NULL, NULL, 0, '2025-11-20 14:19:26'),
(133, 11, 222, 'text', 'Similique soluta earum id odit omnis alias. Facilis corrupti unde voluptas earum placeat. Ut magni enim et magni. Quae sequi iusto voluptatum. Excepturi minima eos rerum.', NULL, NULL, 0, '2025-11-20 08:28:02'),
(134, 11, 223, 'file', NULL, 'https://via.placeholder.com/640x480.png/001188?text=dolorem', 'molestias.shar', 0, '2025-11-16 11:56:53'),
(135, 11, 224, 'video', NULL, 'https://via.placeholder.com/640x480.png/0000bb?text=dolore', 'alias.emma', 0, '2025-11-15 17:59:00'),
(136, 11, 225, 'text', 'Sit velit dolores quia eaque fugiat accusamus. Non aut aspernatur reprehenderit consequatur vitae suscipit. Et excepturi cumque reiciendis consequatur distinctio minima.', NULL, NULL, 0, '2025-11-20 07:06:19'),
(137, 11, 226, 'image', NULL, 'https://via.placeholder.com/640x480.png/009911?text=quia', 'soluta.dxf', 0, '2025-11-18 06:19:42'),
(138, 11, 227, 'text', 'Est optio laborum vero et culpa et et. Voluptatum maiores et eos quibusdam nisi dolor deserunt. Ut sint omnis iure. Et praesentium esse perferendis molestias quibusdam ex.', NULL, NULL, 1, '2025-11-20 04:38:05'),
(139, 11, 228, 'text', 'Explicabo iusto in aut aut alias. Voluptatem assumenda qui perspiciatis minus sit ut et id. Dolores expedita rerum dolores laboriosam distinctio aut.', NULL, NULL, 0, '2025-11-17 05:25:33'),
(140, 11, 229, 'text', 'Dolor omnis provident perferendis exercitationem error totam saepe. Consequatur neque quis asperiores exercitationem optio rerum consequatur accusamus. Labore saepe repudiandae cupiditate commodi vel quibusdam nam. Magni et laboriosam quo aspernatur itaque dolores provident. Est totam amet quasi necessitatibus sed.', NULL, NULL, 0, '2025-11-21 18:24:19'),
(141, 11, 230, 'image', NULL, 'https://via.placeholder.com/640x480.png/003388?text=ipsam', 'qui.gtar', 0, '2025-11-21 09:51:39'),
(142, 11, 231, 'video', NULL, 'https://via.placeholder.com/640x480.png/00bbee?text=consequatur', 'est.rif', 0, '2025-11-16 11:51:04'),
(143, 12, 234, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff99?text=repellendus', 'inventore.gca', 0, '2025-11-16 13:20:04'),
(144, 12, 235, 'file', NULL, 'https://via.placeholder.com/640x480.png/006666?text=voluptas', 'et.igs', 0, '2025-11-16 01:23:21'),
(145, 12, 236, 'file', NULL, 'https://via.placeholder.com/640x480.png/0055ff?text=expedita', 'aut.n3', 1, '2025-11-20 08:46:30'),
(146, 12, 237, 'text', 'Voluptatem et eveniet dolor ut eos quia rem. Qui veritatis ea enim ab et cum. Velit dicta qui sint reprehenderit officia cupiditate autem. Libero sed sit ducimus rerum.', NULL, NULL, 0, '2025-11-18 14:08:57'),
(147, 12, 238, 'text', 'Libero optio quis id quia quae. Est quo perspiciatis vitae. Aut omnis incidunt quo sint impedit autem dolor.', NULL, NULL, 0, '2025-11-19 17:07:17'),
(148, 12, 239, 'video', NULL, 'https://via.placeholder.com/640x480.png/0088cc?text=sed', 'exercitationem.chm', 0, '2025-11-17 08:15:51'),
(149, 12, 240, 'video', NULL, 'https://via.placeholder.com/640x480.png/00bbbb?text=debitis', 'explicabo.cab', 1, '2025-11-16 18:31:49'),
(150, 12, 241, 'text', 'Cumque molestiae praesentium fugiat eveniet facere dignissimos. Quod et vel et provident minima recusandae. Fugit ducimus dolore iure quae quo quam. Veritatis alias quo excepturi.', NULL, NULL, 0, '2025-11-16 03:56:17'),
(151, 12, 242, 'file', NULL, 'https://via.placeholder.com/640x480.png/002222?text=ducimus', 'dolorum.tga', 0, '2025-11-22 04:07:11'),
(152, 12, 243, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ccff?text=omnis', 'laborum.otg', 0, '2025-11-15 17:45:54'),
(153, 12, 244, 'file', NULL, 'https://via.placeholder.com/640x480.png/0011dd?text=at', 'molestiae.see', 0, '2025-11-20 18:45:38'),
(154, 12, 245, 'file', NULL, 'https://via.placeholder.com/640x480.png/0077ee?text=id', 'atque.icc', 0, '2025-11-17 03:56:43'),
(155, 12, 246, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ee66?text=vitae', 'et.pptx', 0, '2025-11-16 04:27:54'),
(156, 12, 247, 'file', NULL, 'https://via.placeholder.com/640x480.png/0044dd?text=magni', 'rerum.ots', 0, '2025-11-21 10:46:26'),
(157, 12, 248, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee88?text=qui', 'unde.jnlp', 0, '2025-11-18 10:37:38'),
(158, 12, 249, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aa33?text=doloribus', 'et.p', 0, '2025-11-22 06:53:30'),
(159, 12, 250, 'video', NULL, 'https://via.placeholder.com/640x480.png/000055?text=ut', 'est.dpg', 0, '2025-11-19 20:40:10'),
(160, 12, 251, 'image', NULL, 'https://via.placeholder.com/640x480.png/004400?text=laboriosam', 'perferendis.xbm', 0, '2025-11-20 11:03:20'),
(161, 12, 252, 'image', NULL, 'https://via.placeholder.com/640x480.png/0055ff?text=quia', 'a.vsw', 0, '2025-11-16 22:03:50'),
(162, 13, 254, 'video', NULL, 'https://via.placeholder.com/640x480.png/0088bb?text=non', 'rerum.org', 0, '2025-11-17 16:48:55'),
(163, 13, 255, 'text', 'Sapiente debitis aperiam id asperiores minus. Accusantium ut et occaecati nihil pariatur harum eos. Quibusdam voluptatem sequi quia facilis.', NULL, NULL, 0, '2025-11-16 14:15:42'),
(164, 13, 256, 'text', 'Dolorum voluptatem ullam ipsa modi tenetur. Provident quia aspernatur consequatur tempora iusto ducimus harum. Maiores enim natus culpa exercitationem ea illum nam ex.', NULL, NULL, 0, '2025-11-20 16:55:32'),
(165, 13, 257, 'text', 'Id aliquid dignissimos quia rem ab. Esse deleniti voluptas illum hic. Maiores officiis sapiente veniam pariatur. Expedita sed laboriosam molestiae officia ea.', NULL, NULL, 0, '2025-11-17 22:20:48'),
(166, 13, 258, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033cc?text=rerum', 'voluptatem.gv', 0, '2025-11-19 20:56:59'),
(167, 13, 259, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ffcc?text=fugiat', 'est.sig', 0, '2025-11-22 09:27:26'),
(168, 13, 260, 'file', NULL, 'https://via.placeholder.com/640x480.png/005555?text=nihil', 'possimus.mathml', 0, '2025-11-22 08:53:52'),
(169, 13, 261, 'image', NULL, 'https://via.placeholder.com/640x480.png/0044aa?text=in', 'repellat.sxd', 0, '2025-11-21 21:31:27'),
(170, 13, 262, 'image', NULL, 'https://via.placeholder.com/640x480.png/00bbff?text=perferendis', 'ut.mie', 0, '2025-11-19 19:51:04'),
(171, 13, 263, 'file', NULL, 'https://via.placeholder.com/640x480.png/002233?text=deleniti', 'nisi.dxf', 0, '2025-11-22 09:37:13'),
(172, 14, 266, 'text', 'Vitae reprehenderit occaecati nam officia labore nihil optio aliquid. Consectetur in rerum sed ut omnis et quam.', NULL, NULL, 1, '2025-11-15 16:45:12'),
(173, 14, 267, 'text', 'Quos expedita voluptas officia suscipit omnis. Eius dolorem adipisci accusamus sit recusandae aut rerum. Vero sint occaecati dolorem dicta velit.', NULL, NULL, 0, '2025-11-16 17:46:08'),
(174, 14, 268, 'video', NULL, 'https://via.placeholder.com/640x480.png/0011cc?text=nostrum', 'officiis.dtd', 0, '2025-11-16 23:26:26'),
(175, 14, 269, 'file', NULL, 'https://via.placeholder.com/640x480.png/004477?text=similique', 'ut.st', 0, '2025-11-19 16:59:56'),
(176, 14, 270, 'video', NULL, 'https://via.placeholder.com/640x480.png/0066aa?text=reiciendis', 'eum.ims', 0, '2025-11-22 01:59:11'),
(177, 14, 271, 'text', 'Culpa consequuntur non dolores quod illum omnis laudantium. Sed aut ex quo. Dolor et soluta dolorem esse.', NULL, NULL, 0, '2025-11-16 18:48:58'),
(178, 14, 272, 'video', NULL, 'https://via.placeholder.com/640x480.png/001177?text=officiis', 'amet.ttl', 1, '2025-11-16 11:41:50'),
(179, 15, 275, 'text', 'Deserunt explicabo id rerum aperiam et reiciendis dolorem. In consequatur maiores quia et consequatur vel adipisci. Sit reiciendis sit expedita facilis nostrum. Animi rerum commodi facere tempora magnam nulla molestiae laudantium.', NULL, NULL, 0, '2025-11-20 05:01:02'),
(180, 15, 276, 'text', 'Dolore excepturi aut laborum nemo deserunt sed. Dolorem molestiae explicabo possimus labore delectus non qui rerum.', NULL, NULL, 0, '2025-11-21 23:30:13'),
(181, 15, 277, 'text', 'Nemo ratione minus recusandae ab adipisci placeat enim ea. Eaque consectetur odio dolorem itaque. Placeat et autem ad consequatur qui. Aliquam a atque est laudantium.', NULL, NULL, 0, '2025-11-18 16:49:11'),
(182, 15, 278, 'image', NULL, 'https://via.placeholder.com/640x480.png/0022cc?text=officiis', 'nobis.utz', 0, '2025-11-21 18:42:41'),
(183, 15, 279, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee88?text=et', 'in.asc', 0, '2025-11-16 21:48:57'),
(184, 15, 280, 'text', 'Quia unde nostrum adipisci adipisci autem unde maiores. Aut ducimus laudantium suscipit. Voluptatem vero repellendus voluptatem non explicabo.', NULL, NULL, 0, '2025-11-19 03:51:26'),
(185, 15, 281, 'text', 'Quis odit excepturi reiciendis qui quam ipsam eveniet rem. Laborum beatae perferendis necessitatibus quae qui corrupti nostrum distinctio. Dolores soluta quas dolorum inventore quisquam fuga iure. Quod molestiae dolor sint.', NULL, NULL, 0, '2025-11-19 20:24:13'),
(186, 15, 282, 'video', NULL, 'https://via.placeholder.com/640x480.png/0000dd?text=quidem', 'harum.kon', 0, '2025-11-22 04:42:43'),
(187, 15, 283, 'video', NULL, 'https://via.placeholder.com/640x480.png/00dd66?text=unde', 'aut.ppsx', 0, '2025-11-18 07:52:55'),
(188, 15, 284, 'file', NULL, 'https://via.placeholder.com/640x480.png/0000dd?text=cupiditate', 'rerum.uvvh', 0, '2025-11-17 00:06:02'),
(189, 15, 285, 'image', NULL, 'https://via.placeholder.com/640x480.png/001133?text=architecto', 'et.blb', 0, '2025-11-18 15:11:37'),
(190, 15, 286, 'video', NULL, 'https://via.placeholder.com/640x480.png/001100?text=quia', 'beatae.mts', 1, '2025-11-22 01:10:43'),
(191, 15, 287, 'text', 'Aut quas omnis molestiae. Optio itaque ipsum voluptatibus fugit. Sed quia qui tempore rerum hic dolore.', NULL, NULL, 0, '2025-11-16 14:10:26'),
(192, 15, 288, 'image', NULL, 'https://via.placeholder.com/640x480.png/00bb00?text=voluptas', 'explicabo.xap', 0, '2025-11-21 23:54:38'),
(193, 15, 289, 'video', NULL, 'https://via.placeholder.com/640x480.png/004400?text=consequuntur', 'ut.sxc', 0, '2025-11-17 09:37:03'),
(194, 15, 290, 'file', NULL, 'https://via.placeholder.com/640x480.png/004422?text=culpa', 'architecto.wav', 0, '2025-11-20 22:14:33'),
(195, 15, 291, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ffdd?text=et', 'et.dpg', 0, '2025-11-19 21:56:45'),
(196, 15, 292, 'image', NULL, 'https://via.placeholder.com/640x480.png/006677?text=minus', 'nihil.mkv', 0, '2025-11-19 03:33:44'),
(197, 15, 293, 'file', NULL, 'https://via.placeholder.com/640x480.png/00cc66?text=accusamus', 'rerum.wspolicy', 0, '2025-11-15 22:14:51'),
(198, 15, 294, 'file', NULL, 'https://via.placeholder.com/640x480.png/00bbbb?text=ea', 'beatae.xif', 1, '2025-11-20 00:05:41'),
(199, 16, 297, 'image', NULL, 'https://via.placeholder.com/640x480.png/00bb66?text=ut', 'architecto.umj', 0, '2025-11-20 09:24:19'),
(200, 16, 298, 'image', NULL, 'https://via.placeholder.com/640x480.png/00dddd?text=non', 'optio.s', 0, '2025-11-18 21:36:40'),
(201, 16, 299, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ee99?text=laudantium', 'sunt.rar', 0, '2025-11-16 22:07:34'),
(202, 16, 300, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ffdd?text=accusantium', 'maiores.pfm', 0, '2025-11-18 23:36:14'),
(203, 16, 301, 'text', 'Delectus aut magni earum. Tempore eos id minima. Sapiente neque possimus laudantium laboriosam non.', NULL, NULL, 0, '2025-11-17 23:29:59'),
(204, 16, 302, 'image', NULL, 'https://via.placeholder.com/640x480.png/007700?text=voluptatem', 'minima.sxw', 0, '2025-11-22 00:21:58'),
(205, 16, 303, 'text', 'Excepturi laboriosam quis explicabo vitae molestiae quia. Voluptatibus aliquid non esse quae odio. Est tenetur deleniti consectetur sunt.', NULL, NULL, 0, '2025-11-16 14:14:28'),
(206, 16, 304, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff44?text=nulla', 'odit.sti', 0, '2025-11-21 17:04:14'),
(207, 17, 306, 'text', 'Omnis numquam rerum id optio corporis atque et voluptas. Accusamus dolore aspernatur atque.', NULL, NULL, 0, '2025-11-18 09:46:31'),
(208, 17, 307, 'file', NULL, 'https://via.placeholder.com/640x480.png/0011ee?text=quia', 'iusto.flx', 0, '2025-11-20 15:59:49'),
(209, 17, 308, 'image', NULL, 'https://via.placeholder.com/640x480.png/002233?text=accusantium', 'illo.json', 0, '2025-11-16 02:24:02'),
(210, 17, 309, 'video', NULL, 'https://via.placeholder.com/640x480.png/00aaff?text=et', 'provident.rmp', 0, '2025-11-22 03:46:29'),
(211, 17, 310, 'text', 'Ut id laudantium vero quasi. Omnis corrupti a voluptates doloribus debitis minima numquam. Dolorum rerum iste doloribus aut molestiae illum minus beatae. Ipsa architecto ut id qui nam harum.', NULL, NULL, 0, '2025-11-16 22:06:58'),
(212, 17, 311, 'text', 'Enim nobis odio dolores repellendus soluta id. Laboriosam optio id ipsa et architecto nihil. Excepturi aut molestias et sapiente aut ea. Ipsum fuga expedita dolorem porro iste.', NULL, NULL, 0, '2025-11-20 08:57:18'),
(213, 17, 312, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033aa?text=nemo', 'doloremque.sti', 0, '2025-11-18 12:47:16'),
(214, 17, 313, 'file', NULL, 'https://via.placeholder.com/640x480.png/008899?text=asperiores', 'sequi.flv', 0, '2025-11-16 09:09:28'),
(215, 17, 314, 'video', NULL, 'https://via.placeholder.com/640x480.png/0055dd?text=sint', 'veniam.wml', 0, '2025-11-17 10:23:26'),
(216, 17, 315, 'text', 'A optio repellendus perspiciatis sit praesentium porro est et. Aliquam porro omnis adipisci doloremque dolores neque. Nihil velit est cupiditate reiciendis ut inventore recusandae voluptatum.', NULL, NULL, 0, '2025-11-21 16:11:58'),
(217, 17, 316, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ff55?text=ipsa', 'quam.wgt', 0, '2025-11-20 05:33:31'),
(218, 18, 318, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033bb?text=voluptatem', 'maiores.exe', 0, '2025-11-20 03:06:23'),
(219, 18, 319, 'video', NULL, 'https://via.placeholder.com/640x480.png/0033dd?text=quod', 'quo.xbap', 0, '2025-11-16 16:22:28'),
(220, 18, 320, 'image', NULL, 'https://via.placeholder.com/640x480.png/00eeaa?text=quia', 'unde.dvb', 0, '2025-11-16 16:02:56'),
(221, 18, 321, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ee11?text=consequatur', 'sint.vcard', 0, '2025-11-18 23:47:17'),
(222, 18, 322, 'video', NULL, 'https://via.placeholder.com/640x480.png/00ddff?text=facere', 'officiis.p', 0, '2025-11-18 15:09:17'),
(223, 18, 323, 'text', 'Sint corrupti natus provident perspiciatis suscipit. Ducimus quibusdam totam quis sed deserunt qui ducimus consequuntur. Odit sit architecto quo repellat.', NULL, NULL, 0, '2025-11-22 00:56:35'),
(224, 18, 324, 'text', 'Et est error earum qui tempora consectetur. Iure minus quia ipsa laudantium expedita eum. Dolore impedit in tenetur tempora cum.', NULL, NULL, 0, '2025-11-22 06:34:36'),
(225, 18, 325, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aa44?text=rem', 'architecto.vsf', 0, '2025-11-21 05:49:32'),
(226, 18, 326, 'file', NULL, 'https://via.placeholder.com/640x480.png/0077bb?text=fugit', 'animi.sgi', 0, '2025-11-20 10:11:42'),
(227, 18, 327, 'text', 'Et consequatur neque dolorum est culpa qui. Sint soluta quibusdam labore enim quia. Aperiam doloribus voluptates qui repudiandae quae quia mollitia. Debitis ut rerum explicabo aliquam.', NULL, NULL, 1, '2025-11-17 08:51:16'),
(228, 18, 328, 'video', NULL, 'https://via.placeholder.com/640x480.png/00bb00?text=maxime', 'sit.qam', 0, '2025-11-16 07:14:07'),
(229, 18, 329, 'image', NULL, 'https://via.placeholder.com/640x480.png/005511?text=magnam', 'enim.htke', 0, '2025-11-16 20:10:36'),
(230, 18, 330, 'video', NULL, 'https://via.placeholder.com/640x480.png/0088ff?text=accusantium', 'quo.uva', 0, '2025-11-18 11:29:34'),
(231, 18, 331, 'video', NULL, 'https://via.placeholder.com/640x480.png/009955?text=vero', 'quia.etx', 0, '2025-11-21 06:28:32'),
(232, 19, 333, 'video', NULL, 'https://via.placeholder.com/640x480.png/0066bb?text=ut', 'autem.vcd', 0, '2025-11-18 17:22:56'),
(233, 19, 334, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ffee?text=sunt', 'laborum.oth', 0, '2025-11-21 04:13:37'),
(234, 19, 335, 'text', 'Tempora quis qui voluptate vero architecto. Est magni atque qui accusantium labore sit. Distinctio voluptas corporis ab cum voluptatem.', NULL, NULL, 0, '2025-11-22 00:15:16'),
(235, 19, 336, 'file', NULL, 'https://via.placeholder.com/640x480.png/008822?text=quis', 'error.uvh', 1, '2025-11-17 05:09:24'),
(236, 19, 337, 'video', NULL, 'https://via.placeholder.com/640x480.png/0088aa?text=praesentium', 'officia.xbm', 0, '2025-11-17 13:16:14'),
(237, 19, 338, 'file', NULL, 'https://via.placeholder.com/640x480.png/003388?text=ut', 'rerum.pls', 0, '2025-11-17 12:12:37'),
(238, 19, 339, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aaee?text=rerum', 'aut.wgt', 0, '2025-11-18 13:22:50'),
(239, 19, 340, 'file', NULL, 'https://via.placeholder.com/640x480.png/002244?text=quod', 'ea.sit', 0, '2025-11-18 19:21:21'),
(240, 19, 341, 'video', NULL, 'https://via.placeholder.com/640x480.png/001144?text=ut', 'dolores.m2v', 0, '2025-11-22 12:38:03'),
(241, 19, 342, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aacc?text=magnam', 'expedita.xpm', 0, '2025-11-16 04:45:53'),
(242, 19, 343, 'image', NULL, 'https://via.placeholder.com/640x480.png/005544?text=nemo', 'ipsa.utz', 1, '2025-11-18 04:53:24'),
(243, 19, 344, 'image', NULL, 'https://via.placeholder.com/640x480.png/00ddff?text=et', 'explicabo.xps', 0, '2025-11-17 07:17:13'),
(244, 19, 345, 'image', NULL, 'https://via.placeholder.com/640x480.png/001144?text=dolorem', 'id.movie', 0, '2025-11-18 12:05:48'),
(245, 19, 346, 'file', NULL, 'https://via.placeholder.com/640x480.png/005500?text=et', 'ut.docx', 0, '2025-11-18 03:09:48'),
(246, 19, 347, 'image', NULL, 'https://via.placeholder.com/640x480.png/008899?text=laborum', 'vero.mid', 0, '2025-11-20 03:47:34'),
(247, 19, 348, 'image', NULL, 'https://via.placeholder.com/640x480.png/00aaee?text=enim', 'est.odm', 0, '2025-11-22 02:33:41'),
(248, 19, 349, 'file', NULL, 'https://via.placeholder.com/640x480.png/00cc88?text=quisquam', 'eos.ssf', 0, '2025-11-19 16:40:53'),
(249, 19, 350, 'file', NULL, 'https://via.placeholder.com/640x480.png/00cc00?text=hic', 'consequatur.wbxml', 0, '2025-11-18 07:26:35'),
(250, 20, 352, 'text', 'Et delectus officia qui atque qui illo. Minus ut voluptas ut. Et nostrum praesentium esse doloribus.', NULL, NULL, 0, '2025-11-18 16:38:09'),
(251, 20, 353, 'file', NULL, 'https://via.placeholder.com/640x480.png/0088aa?text=omnis', 'magni.pgn', 0, '2025-11-18 16:05:42'),
(252, 20, 354, 'text', 'Quasi culpa quibusdam odio natus a aliquam adipisci dolorum. Et incidunt natus sed molestiae debitis neque. Qui quo aut voluptatem ipsum quisquam. Enim nesciunt consequuntur quis vel ullam et.', NULL, NULL, 0, '2025-11-16 04:48:22'),
(253, 20, 355, 'file', NULL, 'https://via.placeholder.com/640x480.png/008833?text=excepturi', 'qui.xbm', 0, '2025-11-19 07:42:29'),
(254, 20, 356, 'image', NULL, 'https://via.placeholder.com/640x480.png/009911?text=sint', 'consequatur.sxd', 0, '2025-11-18 23:54:19'),
(255, 20, 357, 'video', NULL, 'https://via.placeholder.com/640x480.png/0044dd?text=id', 'porro.rtf', 0, '2025-11-21 19:59:59'),
(256, 20, 358, 'text', 'Iste accusamus provident quo magnam ea. Deserunt dolorum consequuntur veniam qui. A id aut est sit.', NULL, NULL, 0, '2025-11-21 09:12:07'),
(257, 20, 359, 'text', 'Quia facere illum quae voluptates. Eius est esse ut deleniti harum. Molestiae corporis explicabo repellendus blanditiis ut eos. At sint dolorem odio ex recusandae error.', NULL, NULL, 0, '2025-11-17 12:27:39'),
(258, 20, 360, 'file', NULL, 'https://via.placeholder.com/640x480.png/00ff11?text=eveniet', 'cumque.dpg', 0, '2025-11-19 21:20:13'),
(259, 20, 361, 'image', NULL, 'https://via.placeholder.com/640x480.png/006600?text=molestias', 'ex.xlsm', 0, '2025-11-19 21:36:43'),
(260, 21, 2, 'text', 'hsq', NULL, NULL, 0, '2025-11-25 17:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
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
(34, 'create_email_logs_table', 1),
(35, '2025_11_26_221503_create_email_logs_table', 2),
(36, '2025_11_27_174528_create_settings_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
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
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `notification_type`, `title`, `content`, `related_id`, `related_type`, `action_url`, `is_read`, `priority`, `created_at`) VALUES
(1, 1, 'System', 'New Organization Registration', 'Test Organzation 1 has registered and needs verification', 1, 'user', NULL, 0, 'high', '2025-11-22 16:08:50'),
(2, 1, 'System', 'New Organization Registration', 'Test Organzation 1 has registered and needs verification', 2, 'user', NULL, 0, 'high', '2025-11-22 16:10:27'),
(3, 319, 'System', 'Placeat optio ad ea.', 'Maiores autem voluptas autem et enim architecto.', 80, NULL, NULL, 0, 'medium', '2025-11-22 16:13:12'),
(4, 319, 'Message', 'Officiis earum natus quis provident labore.', 'Non enim est autem inventore reiciendis numquam nam sunt harum sunt ea.', NULL, 'message', 'https://bailey.com/vero-aut-et-dolorem-reprehenderit.html', 0, 'low', '2025-11-22 16:13:12'),
(5, 319, 'System', 'Autem in quis maxime possimus iste dolorem.', 'Dolores sint architecto nam modi culpa eum perspiciatis totam est ab.', NULL, 'message', NULL, 1, 'low', '2025-11-22 16:13:12'),
(6, 319, 'Video Call', 'Non quisquam reiciendis aut.', 'Corporis amet voluptas est ipsam ipsa sequi possimus ipsa dolorem possimus ullam.', 35, NULL, 'http://www.murray.net/', 1, 'low', '2025-11-22 16:13:12'),
(7, 319, 'Video Call', 'Veniam dolor voluptate illum adipisci.', 'Quisquam et molestiae debitis adipisci corrupti velit odio architecto eaque sint.', NULL, NULL, 'http://www.kerluke.com/commodi-porro-sapiente-excepturi-molestiae-ut-sit', 0, 'medium', '2025-11-22 16:13:12'),
(8, 334, 'Review', 'Odio nemo autem assumenda rem nemo voluptas.', 'Maxime necessitatibus maiores atque consequatur hic at dolor.', 6, 'opportunity', NULL, 0, 'high', '2025-11-22 16:13:12'),
(9, 334, 'Opportunity', 'Pariatur voluptatem error dolores et non voluptatem.', NULL, 49, 'user', NULL, 0, 'high', '2025-11-22 16:13:12'),
(10, 334, 'Message', 'Aut nesciunt eos libero fugiat ratione delectus.', NULL, NULL, 'opportunity', 'https://wehner.net/sed-cupiditate-error-neque-similique-fuga.html', 1, 'medium', '2025-11-22 16:13:12'),
(11, 210, 'Message', 'Culpa ut sit est.', NULL, 73, 'call', NULL, 0, 'high', '2025-11-22 16:13:12'),
(12, 210, 'Review', 'Aperiam cumque quis deserunt fuga natus necessitatibus.', NULL, NULL, NULL, 'http://paucek.com/consequatur-officia-tempora-error-ut', 0, 'low', '2025-11-22 16:13:12'),
(13, 210, 'Review', 'Ullam facere neque enim et aliquid.', NULL, NULL, 'application', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(14, 187, 'Application', 'Reprehenderit alias quasi sit perferendis error.', NULL, NULL, 'user', NULL, 0, 'low', '2025-11-22 16:13:12'),
(15, 187, 'Message', 'Accusantium aliquam aperiam et nostrum id.', NULL, NULL, 'call', 'http://www.goodwin.net/dolorem-possimus-cum-qui', 0, 'medium', '2025-11-22 16:13:12'),
(16, 187, 'Application', 'Mollitia beatae non voluptas modi qui quisquam.', 'Magnam voluptatibus inventore inventore ea est odit minus.', 37, 'message', NULL, 0, 'high', '2025-11-22 16:13:12'),
(17, 187, 'Application', 'Temporibus natus amet quia repellat nesciunt sit.', NULL, NULL, 'message', NULL, 0, 'low', '2025-11-22 16:13:12'),
(18, 187, 'Review', 'Ut ut odio totam aspernatur dolores.', NULL, 21, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(19, 187, 'Review', 'Vel at modi pariatur.', 'Facere et neque omnis est officia aut voluptatem quo voluptatum unde.', 46, 'message', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(20, 72, 'Application', 'Velit et atque qui id aut hic.', NULL, NULL, NULL, 'https://gibson.com/non-odit-rerum-laborum.html', 1, 'low', '2025-11-22 16:13:12'),
(21, 72, 'System', 'Est cumque eum molestiae autem ullam et.', NULL, NULL, NULL, 'http://www.johnston.com/consequatur-iste-ex-blanditiis-in-quo-est-perspiciatis-nobis', 1, 'low', '2025-11-22 16:13:12'),
(22, 72, 'Message', 'Enim sed quia quibusdam culpa debitis.', NULL, NULL, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(23, 72, 'Review', 'Blanditiis repellat aut excepturi qui.', 'Beatae facere repudiandae aut excepturi ipsam rerum enim eveniet consequatur.', 53, 'message', NULL, 0, 'low', '2025-11-22 16:13:12'),
(24, 72, 'Video Call', 'Distinctio velit maiores fugit in ipsam ut dignissimos.', 'Dolorum enim ratione fugit est inventore tenetur pariatur ad impedit et aut possimus quasi.', 12, NULL, 'http://zemlak.com/', 1, 'medium', '2025-11-22 16:13:12'),
(25, 72, 'Application', 'Ullam qui voluptatibus quia cupiditate alias perspiciatis hic.', NULL, NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(26, 72, 'Message', 'Veniam eum eveniet impedit.', NULL, 94, 'application', NULL, 0, 'high', '2025-11-22 16:13:12'),
(27, 72, 'Message', 'Facilis adipisci sunt sunt sapiente minima.', NULL, NULL, 'application', 'http://kulas.com/', 0, 'high', '2025-11-22 16:13:12'),
(28, 72, 'System', 'Eius incidunt et consequatur.', NULL, NULL, 'application', NULL, 1, 'low', '2025-11-22 16:13:12'),
(29, 72, 'Application', 'Architecto est dolore porro qui et.', 'Animi ut placeat occaecati officia dolores sunt doloribus fugiat assumenda.', NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(30, 269, 'Message', 'Ad totam itaque aut.', 'Aut voluptatem modi incidunt cum sed aut.', NULL, NULL, 'https://www.prohaska.com/a-ab-similique-placeat-sint-dolor-quia-laudantium-nihil', 0, 'medium', '2025-11-22 16:13:12'),
(31, 269, 'Application', 'Vitae nobis repudiandae nam accusantium.', NULL, NULL, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(32, 269, 'Application', 'Cupiditate facere itaque accusantium error est.', NULL, 33, 'user', 'http://cummerata.biz/eum-aut-facere-tenetur-velit-libero', 0, 'low', '2025-11-22 16:13:12'),
(33, 269, 'Opportunity', 'Quisquam ad aut laborum tempora.', 'Iure provident accusamus aliquam quidem iste vel quasi ducimus impedit quo voluptas.', NULL, NULL, 'https://cremin.com/ducimus-quia-ullam-ullam-ipsa-deleniti-voluptatibus.html', 0, 'medium', '2025-11-22 16:13:12'),
(34, 269, 'System', 'In voluptas illo adipisci quia est consequuntur.', NULL, NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(35, 269, 'Opportunity', 'Magni rerum molestiae ipsum ducimus dolorum ex.', NULL, NULL, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(36, 269, 'Opportunity', 'Sit placeat natus autem expedita iure.', NULL, 86, 'opportunity', NULL, 1, 'low', '2025-11-22 16:13:12'),
(37, 102, 'Opportunity', 'Sunt impedit aut doloremque.', 'Unde exercitationem minus ab vel vero dignissimos error ut sunt perspiciatis blanditiis voluptatem asperiores eos.', NULL, 'application', 'http://ortiz.com/dignissimos-dolorem-aperiam-ab-voluptate-sit-iure-asperiores-optio', 1, 'low', '2025-11-22 16:13:12'),
(38, 102, 'Video Call', 'Dolorem et omnis autem sed.', 'Unde explicabo culpa distinctio sit voluptatibus et aut eveniet ab nobis rem soluta.', NULL, 'application', 'http://conn.org/', 1, 'high', '2025-11-22 16:13:12'),
(39, 102, 'Opportunity', 'Facere non modi aut.', NULL, NULL, 'call', 'http://harris.com/laborum-qui-quos-quasi-iure', 0, 'high', '2025-11-22 16:13:12'),
(40, 102, 'Application', 'Sunt necessitatibus aperiam quidem fugit.', 'Quod beatae est et ad saepe possimus libero consequuntur quae architecto non neque.', NULL, NULL, NULL, 0, 'medium', '2025-11-22 16:13:12'),
(41, 102, 'Video Call', 'Optio voluptatum et iusto.', NULL, 65, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(42, 102, 'Application', 'Quos voluptas eaque soluta beatae corrupti quis.', 'Et excepturi officiis voluptate nihil earum dolorum dolore.', NULL, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(43, 357, 'Video Call', 'Vero assumenda iste quidem.', NULL, NULL, NULL, 'http://konopelski.net/ut-error-explicabo-similique', 0, 'medium', '2025-11-22 16:13:12'),
(44, 357, 'Message', 'Qui dolorem reiciendis ad reiciendis sed harum.', 'Nostrum quo molestiae blanditiis beatae voluptatem repudiandae tempore est eos cupiditate soluta id occaecati.', 17, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(45, 357, 'Opportunity', 'Voluptatem earum praesentium vitae.', NULL, NULL, 'message', 'http://www.breitenberg.com/repellendus-et-voluptatibus-omnis-et.html', 0, 'low', '2025-11-22 16:13:12'),
(46, 357, 'Review', 'Sequi sequi earum molestiae doloremque.', 'Autem vitae perferendis at cumque qui distinctio culpa maiores laborum aspernatur autem.', NULL, 'user', NULL, 1, 'high', '2025-11-22 16:13:12'),
(47, 244, 'Review', 'Aut facere quaerat cum rem.', NULL, 66, NULL, 'http://cole.com/animi-corrupti-sint-sunt-quas-molestias', 0, 'medium', '2025-11-22 16:13:12'),
(48, 244, 'Message', 'Quis nobis ex dolorem maiores omnis.', 'Dolorum blanditiis voluptas et occaecati porro ut dolorem est eos voluptatum non at.', NULL, 'opportunity', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(49, 244, 'Opportunity', 'Optio est ut praesentium ab voluptatem quisquam.', NULL, 55, 'message', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(50, 45, 'Application', 'Nemo adipisci voluptatibus nemo.', NULL, 72, NULL, 'https://stracke.info/voluptas-id-atque-ex-adipisci-rerum.html', 0, 'high', '2025-11-22 16:13:12'),
(51, 45, 'System', 'Occaecati quisquam fugiat at.', 'Aut repellendus blanditiis veritatis sint libero et dolorem ex nihil aut quos voluptatem aut.', 86, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(52, 45, 'System', 'Earum id expedita et ducimus est.', 'Impedit repellendus ut ratione accusantium ea sunt.', 34, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(53, 45, 'Video Call', 'Cupiditate delectus molestiae quae.', NULL, 24, NULL, 'http://cartwright.info/veniam-vitae-aut-quis-explicabo-eaque-ut', 0, 'low', '2025-11-22 16:13:12'),
(54, 45, 'Video Call', 'Voluptatem reiciendis maiores soluta ut nisi voluptatibus.', 'Dolorem non unde neque veniam minima officiis autem voluptate aut voluptas magnam architecto ullam.', 94, NULL, 'https://robel.net/sint-nobis-nihil-aut-et-incidunt.html', 1, 'low', '2025-11-22 16:13:12'),
(55, 45, 'System', 'Eaque sint qui aliquam neque natus.', NULL, 57, 'message', NULL, 1, 'high', '2025-11-22 16:13:12'),
(56, 45, 'Opportunity', 'Voluptates impedit minus distinctio nihil eos.', 'Qui facilis numquam error hic accusantium in aliquam ipsa qui autem cupiditate aspernatur.', NULL, 'application', NULL, 0, 'high', '2025-11-22 16:13:12'),
(57, 45, 'Message', 'Nobis optio soluta earum sed.', NULL, NULL, 'call', NULL, 0, 'low', '2025-11-22 16:13:12'),
(58, 216, 'System', 'Sunt ut consequatur occaecati quasi rerum eaque.', NULL, NULL, 'opportunity', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(59, 216, 'Video Call', 'Doloribus sint quae dolore.', 'Error et fugiat distinctio quaerat enim sunt doloremque magnam id.', 16, 'application', 'http://anderson.com/', 0, 'medium', '2025-11-22 16:13:12'),
(60, 216, 'Message', 'Quis libero suscipit sed sunt aliquam minus.', 'Velit optio unde eaque provident ea consequuntur aut corporis aperiam consequatur.', NULL, 'opportunity', NULL, 0, 'low', '2025-11-22 16:13:12'),
(61, 216, 'Review', 'Et aut similique facere.', 'Inventore necessitatibus corporis omnis in tempora excepturi neque quo recusandae.', 95, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(62, 216, 'Application', 'Provident cum recusandae ut.', 'Libero numquam vero fugit quos in aut vero repudiandae libero pariatur ex dolore nihil.', NULL, NULL, NULL, 1, 'high', '2025-11-22 16:13:12'),
(63, 216, 'System', 'Nemo quidem aliquid atque libero.', 'Consequatur sit beatae eius sit a sequi.', 31, NULL, 'http://www.heidenreich.info/sunt-est-sapiente-repudiandae-rerum-vel-aut', 0, 'high', '2025-11-22 16:13:12'),
(64, 216, 'Message', 'Consequatur reprehenderit aperiam excepturi mollitia doloremque harum.', NULL, 24, NULL, 'http://www.rosenbaum.com/incidunt-est-natus-tempore-accusamus-quibusdam-ut-numquam-eos', 0, 'high', '2025-11-22 16:13:12'),
(65, 216, 'Opportunity', 'Rerum veniam laudantium molestiae corrupti culpa ex.', NULL, NULL, 'user', 'http://www.kuhn.info/facilis-voluptatem-veritatis-pariatur-veniam.html', 0, 'high', '2025-11-22 16:13:12'),
(66, 80, 'System', 'Maxime laborum beatae pariatur autem nulla.', NULL, NULL, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(67, 80, 'Review', 'Numquam velit tempora quod sed sit.', 'Fugit accusantium ipsam aperiam iste voluptas aut sit.', NULL, 'message', NULL, 1, 'high', '2025-11-22 16:13:12'),
(68, 80, 'Review', 'Aliquid et quia doloribus deleniti asperiores aliquid.', 'Eos ut in dicta qui earum deserunt est voluptatem.', 19, NULL, 'http://tromp.org/nostrum-sequi-eligendi-et-voluptas-ut-repudiandae', 1, 'high', '2025-11-22 16:13:12'),
(69, 69, 'Message', 'Qui quaerat porro incidunt sit qui eligendi.', NULL, 31, NULL, 'https://steuber.org/ipsa-qui-qui-non-dolor-omnis-sed.html', 0, 'high', '2025-11-22 16:13:12'),
(70, 69, 'Video Call', 'Et asperiores porro quia ut dolorum.', NULL, 94, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(71, 69, 'Application', 'Quia fuga placeat cumque enim.', 'Nisi ab et quis repudiandae deserunt ut suscipit blanditiis beatae soluta similique consequuntur.', 53, NULL, 'http://www.schroeder.com/', 0, 'medium', '2025-11-22 16:13:12'),
(72, 69, 'Video Call', 'Eos pariatur qui magni.', NULL, 50, NULL, 'https://sawayn.com/eius-recusandae-animi-voluptates-nihil.html', 0, 'medium', '2025-11-22 16:13:12'),
(73, 69, 'System', 'Dolor quaerat aperiam nihil dolorum recusandae.', 'Quas numquam ipsa ratione voluptates qui dicta doloremque.', 10, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(74, 69, 'Review', 'Accusamus non voluptas molestiae non rerum.', 'A nobis dolores omnis aut quia harum labore similique.', NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(75, 69, 'Application', 'Facere repellendus nihil aliquid in officiis sit.', NULL, 43, NULL, NULL, 0, 'medium', '2025-11-22 16:13:12'),
(76, 69, 'Application', 'Doloribus perspiciatis nulla illum laborum.', NULL, NULL, NULL, 'http://www.hansen.biz/', 0, 'high', '2025-11-22 16:13:12'),
(77, 69, 'Application', 'Impedit inventore quo magni qui.', 'Aspernatur non ea deleniti magnam quos perspiciatis dolore.', 84, 'opportunity', NULL, 0, 'high', '2025-11-22 16:13:12'),
(78, 227, 'Review', 'Recusandae rerum deleniti fuga minima sit dolor.', 'Voluptas unde ab sit ipsa ad voluptas magni occaecati odio esse repudiandae alias.', NULL, 'message', NULL, 0, 'low', '2025-11-22 16:13:12'),
(79, 227, 'Message', 'Officiis sapiente aut explicabo.', 'Deserunt est deserunt blanditiis velit architecto rem voluptas.', NULL, NULL, 'http://www.halvorson.com/dolorem-fugit-a-tempore-in-cupiditate-corporis-aut-culpa', 1, 'medium', '2025-11-22 16:13:12'),
(80, 227, 'Video Call', 'Quasi aut et quaerat dolores consequatur.', 'Culpa quaerat in et omnis voluptates impedit et necessitatibus vel.', 59, 'opportunity', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(81, 227, 'Application', 'Error laborum quis nihil est fuga.', NULL, 28, 'opportunity', NULL, 1, 'low', '2025-11-22 16:13:12'),
(82, 227, 'Opportunity', 'Doloribus illum at labore placeat rerum aspernatur.', 'Sit cumque velit quis beatae eius autem explicabo.', NULL, 'user', 'http://daugherty.biz/dolores-dolorem-ad-et-perspiciatis-quo.html', 0, 'high', '2025-11-22 16:13:12'),
(83, 227, 'Message', 'Nemo cumque impedit voluptates sunt sunt.', NULL, 99, 'opportunity', NULL, 0, 'low', '2025-11-22 16:13:12'),
(84, 204, 'Application', 'Quas sit cupiditate quidem dolores.', 'Tenetur ipsam quasi laudantium repellendus itaque voluptas nihil esse est.', 27, 'message', NULL, 1, 'low', '2025-11-22 16:13:12'),
(85, 204, 'Opportunity', 'Aut doloremque tenetur nam.', NULL, NULL, 'application', 'http://kerluke.biz/', 0, 'medium', '2025-11-22 16:13:12'),
(86, 204, 'Message', 'Quam beatae recusandae ut et aut cum.', NULL, 87, NULL, 'http://langosh.com/recusandae-quia-asperiores-eum-exercitationem-vero-sed-commodi', 0, 'high', '2025-11-22 16:13:12'),
(87, 204, 'System', 'Provident voluptatem occaecati eligendi quisquam cumque.', 'Et ipsum voluptas ut aperiam ipsum nesciunt est quas a et reiciendis sed.', 54, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(88, 204, 'Review', 'Sunt qui aliquam repudiandae iste voluptas hic.', 'Delectus sed nesciunt saepe provident dolores vel.', NULL, 'opportunity', NULL, 0, 'high', '2025-11-22 16:13:12'),
(89, 204, 'Application', 'Debitis qui sit ut necessitatibus pariatur.', NULL, NULL, NULL, 'http://dibbert.biz/', 0, 'medium', '2025-11-22 16:13:12'),
(90, 203, 'Review', 'Ut accusantium voluptatum suscipit qui.', 'Dolorum non consequatur dolores hic distinctio minus.', 8, NULL, 'http://heller.org/porro-et-consequatur-enim-vitae-quo', 0, 'high', '2025-11-22 16:13:12'),
(91, 203, 'Review', 'Et aut veritatis illo distinctio iste quae.', 'Et suscipit vero animi magnam repellendus qui.', 47, 'user', NULL, 0, 'high', '2025-11-22 16:13:12'),
(92, 203, 'System', 'Fugiat et labore repudiandae.', 'Impedit quia enim aut provident minus voluptate est illum voluptatum modi incidunt ex placeat.', 82, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(93, 203, 'Review', 'Rerum corporis id fugit doloribus.', 'Est illum magni occaecati sed deleniti id est iure dolores ut animi repudiandae.', 47, NULL, NULL, 0, 'medium', '2025-11-22 16:13:12'),
(94, 203, 'Video Call', 'Et non molestiae eius et.', 'Qui quis aspernatur sed officiis placeat quis.', 15, 'application', 'https://www.cruickshank.com/et-nisi-iste-asperiores-eos-nam-quaerat', 0, 'medium', '2025-11-22 16:13:12'),
(95, 203, 'Review', 'Beatae similique odit assumenda.', NULL, NULL, 'user', 'https://gislason.com/voluptates-id-voluptatem-corrupti-porro-ut-non.html', 0, 'medium', '2025-11-22 16:13:12'),
(96, 20, 'Review', 'Molestiae molestias dolores et reiciendis dolores error.', 'Asperiores iure voluptatem et eius dolore quam ullam ea veniam.', NULL, NULL, NULL, 0, 'medium', '2025-11-22 16:13:12'),
(97, 20, 'Message', 'Nisi quo optio possimus.', 'Ut quis magni voluptatem in dolorem voluptas.', 23, 'user', 'http://paucek.com/itaque-cupiditate-natus-et-enim-maxime.html', 0, 'high', '2025-11-22 16:13:12'),
(98, 20, 'Application', 'Fugit quia assumenda ut fugit qui.', 'Aut reiciendis vitae voluptatem ut reiciendis non et nobis accusamus cupiditate.', NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(99, 199, 'Application', 'Incidunt odio provident id laboriosam possimus consequatur.', 'Id eum blanditiis porro quod dolores eveniet aliquam qui rerum.', NULL, NULL, 'http://larkin.com/saepe-at-sapiente-quae-reprehenderit-ut-quod', 1, 'medium', '2025-11-22 16:13:12'),
(100, 199, 'Message', 'Eos velit accusantium voluptas.', 'Voluptatem voluptatem laborum voluptas sed commodi sed et deleniti totam velit voluptatem unde.', 85, 'message', 'http://schulist.org/', 0, 'medium', '2025-11-22 16:13:12'),
(101, 199, 'Review', 'Est ut enim perspiciatis laboriosam sint consectetur.', NULL, 6, 'user', 'http://www.osinski.com/vitae-qui-perspiciatis-est-natus-delectus-laudantium-sed', 1, 'high', '2025-11-22 16:13:12'),
(102, 199, 'Message', 'Quia quo quia inventore.', 'Et nulla rerum impedit qui nihil quia ut quod non tempora ullam dolor assumenda.', 35, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(103, 199, 'Message', 'Harum aliquam voluptatem aliquam eligendi alias ab.', NULL, NULL, 'user', NULL, 0, 'high', '2025-11-22 16:13:12'),
(104, 259, 'Message', 'Excepturi et quia harum.', 'Et unde quas quo porro voluptatibus ut magnam atque et nemo asperiores.', 71, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(105, 259, 'Opportunity', 'Ut saepe vel et corporis explicabo.', 'Aut ad aut iure quidem voluptates id modi omnis dolor deserunt.', NULL, 'call', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(106, 259, 'Opportunity', 'Dolor cum velit et nihil aliquam sunt.', 'Quia repudiandae similique consequatur qui beatae est sit earum quam ea laudantium ut dolorum.', NULL, 'opportunity', 'http://berge.com/et-ratione-quo-quod-animi-blanditiis-eum', 0, 'medium', '2025-11-22 16:13:12'),
(107, 259, 'Application', 'Et harum dolor ex.', 'Voluptas dicta alias numquam ut eius et magni.', 2, 'user', NULL, 1, 'high', '2025-11-22 16:13:12'),
(108, 259, 'Application', 'Velit aliquam maxime aut est sunt.', 'Ad optio in provident quia dolor possimus qui sit consequatur velit vero impedit.', 28, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(109, 259, 'System', 'Omnis amet quasi velit et facere repellat.', 'Asperiores qui asperiores quam ipsa cumque quo molestiae nesciunt rerum consequatur voluptatum enim.', 50, NULL, 'http://pfannerstill.com/', 0, 'high', '2025-11-22 16:13:12'),
(110, 259, 'Message', 'Quos quia et est ipsum.', 'Autem molestiae inventore rerum dolores id soluta dolores unde animi earum non facere.', NULL, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(111, 150, 'Video Call', 'Accusantium alias blanditiis modi magnam.', 'Repudiandae dolor illum et quae quasi rerum tempora qui modi.', 12, NULL, 'http://www.mosciski.com/', 1, 'medium', '2025-11-22 16:13:12'),
(112, 150, 'Video Call', 'Dolores dignissimos aliquid aliquid voluptas et.', NULL, 18, NULL, 'http://www.jerde.com/', 1, 'high', '2025-11-22 16:13:12'),
(113, 150, 'Opportunity', 'Aut corporis sit consequuntur nihil.', NULL, NULL, 'application', NULL, 0, 'low', '2025-11-22 16:13:12'),
(114, 202, 'Review', 'Et culpa sapiente corporis eum magnam ullam.', NULL, NULL, 'application', NULL, 0, 'high', '2025-11-22 16:13:12'),
(115, 202, 'Review', 'Sint maiores et voluptatem modi beatae accusantium.', 'Dolore amet rerum delectus fuga fugit cumque assumenda.', 81, NULL, 'http://lockman.net/recusandae-et-labore-magnam-repudiandae-quasi-nihil-illo', 0, 'high', '2025-11-22 16:13:12'),
(116, 202, 'Video Call', 'Non maiores at totam molestias quia.', NULL, 70, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(117, 140, 'Application', 'Et cum perspiciatis distinctio.', NULL, NULL, 'message', 'http://bechtelar.com/magnam-cumque-et-odio-dicta.html', 1, 'high', '2025-11-22 16:13:12'),
(118, 140, 'Opportunity', 'Delectus sed voluptas maxime.', NULL, NULL, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(119, 140, 'System', 'Possimus eos similique ex maxime odio vero.', 'Ullam molestias laborum debitis consequatur ducimus ut sunt quia est eos aperiam et.', 37, 'opportunity', 'http://johnston.com/eum-officia-sed-ut-laborum-aut-molestiae', 1, 'medium', '2025-11-22 16:13:12'),
(120, 140, 'Application', 'Voluptatem ea rerum minus sed quo sint saepe.', NULL, 70, NULL, NULL, 1, 'medium', '2025-11-22 16:13:12'),
(121, 140, 'Video Call', 'Ad dolores id sed rem corrupti.', NULL, NULL, 'user', 'http://www.olson.com/qui-est-consequuntur-voluptatibus-commodi-quia-eum', 0, 'high', '2025-11-22 16:13:12'),
(122, 140, 'Opportunity', 'Eum ipsam aperiam enim ea distinctio.', NULL, NULL, 'application', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(123, 140, 'Message', 'Modi commodi aut veritatis iste et eligendi.', 'Et corrupti doloribus aut ducimus ea qui ea id.', NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(124, 140, 'Video Call', 'Ducimus aut facere eveniet quod et.', 'Ex eligendi ab deleniti accusamus quasi id id fuga sed.', NULL, 'application', 'https://schoen.com/consectetur-rerum-sit-optio-vero-dolores-sit.html', 1, 'low', '2025-11-22 16:13:12'),
(125, 140, 'Opportunity', 'Delectus et vel optio excepturi.', 'Harum sapiente dolorem qui repudiandae officiis magni et distinctio commodi nobis omnis.', 89, NULL, 'http://douglas.org/expedita-aut-et-incidunt-repudiandae-illum', 0, 'high', '2025-11-22 16:13:12'),
(126, 50, 'Video Call', 'Ea quia commodi quibusdam.', NULL, 27, 'opportunity', NULL, 1, 'medium', '2025-11-22 16:13:12'),
(127, 50, 'Video Call', 'Facere amet necessitatibus illum.', 'Adipisci itaque tempore repellendus omnis enim aut quia ipsum fuga sint beatae hic.', NULL, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(128, 50, 'Review', 'Et facere fugit accusantium vero reiciendis.', NULL, 21, 'opportunity', 'http://www.cremin.biz/eligendi-ducimus-rerum-sed-et-nihil', 0, 'low', '2025-11-22 16:13:12'),
(129, 50, 'Review', 'Quod ea neque animi ut expedita.', NULL, 50, NULL, NULL, 0, 'medium', '2025-11-22 16:13:12'),
(130, 50, 'System', 'Asperiores minima ea molestias amet.', NULL, 74, 'call', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(131, 50, 'Application', 'Qui temporibus ea iure vero.', 'Pariatur eaque optio repellat asperiores cupiditate ut nemo ullam vero.', 91, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(132, 50, 'Message', 'Magnam sunt officia corporis et voluptas ipsam.', NULL, NULL, NULL, NULL, 1, 'high', '2025-11-22 16:13:12'),
(133, 50, 'Message', 'Quo dolor odit enim voluptatem fugiat.', NULL, NULL, 'application', 'http://kulas.com/ut-corporis-qui-fuga-quibusdam-molestias-et-doloremque', 0, 'high', '2025-11-22 16:13:12'),
(134, 155, 'Video Call', 'Mollitia laboriosam molestias et.', 'Reiciendis error quos magnam minima numquam laborum quas pariatur occaecati.', NULL, 'user', 'http://www.koepp.com/quia-et-neque-praesentium-eaque-quia-reiciendis.html', 0, 'high', '2025-11-22 16:13:12'),
(135, 155, 'System', 'Quos magnam nulla velit dignissimos.', 'Suscipit sint consequatur unde tempora minima minus tempore sed id corrupti numquam.', 20, NULL, 'http://hauck.net/', 0, 'medium', '2025-11-22 16:13:12'),
(136, 155, 'Message', 'Sunt ducimus est quos.', NULL, 38, NULL, NULL, 1, 'low', '2025-11-22 16:13:12'),
(137, 155, 'System', 'Officiis doloremque voluptas aperiam dolore.', 'Dolorum voluptas dolor quis voluptatem dignissimos cumque quaerat.', 67, 'application', 'http://www.hand.com/maiores-nam-aperiam-eos-hic-similique-aut-perspiciatis.html', 1, 'low', '2025-11-22 16:13:12'),
(138, 155, 'Video Call', 'Voluptas illo corporis rerum eum deleniti iste.', NULL, NULL, 'application', NULL, 0, 'high', '2025-11-22 16:13:12'),
(139, 155, 'Message', 'Quo est aut quo eum eveniet at.', 'Omnis at eos quia cum animi in in voluptatem at animi.', 87, 'user', NULL, 1, 'medium', '2025-11-22 16:13:12'),
(140, 155, 'Message', 'Harum libero repellat architecto.', NULL, NULL, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(141, 155, 'Opportunity', 'Aut placeat explicabo molestiae et doloremque.', 'Amet saepe recusandae cupiditate dolor labore fugiat et.', 47, 'application', NULL, 1, 'low', '2025-11-22 16:13:12'),
(142, 265, 'Video Call', 'Beatae optio ullam eius.', NULL, 44, NULL, 'http://wolff.com/corrupti-commodi-quos-commodi-a-cupiditate-distinctio-neque.html', 1, 'high', '2025-11-22 16:13:12'),
(143, 265, 'Application', 'Sunt soluta explicabo unde voluptatem ad.', NULL, NULL, 'user', 'http://www.corwin.info/', 0, 'medium', '2025-11-22 16:13:12'),
(144, 265, 'Video Call', 'Alias at repudiandae magni dolor enim reiciendis.', 'Asperiores nihil eveniet quia molestiae et debitis consequatur molestiae odio ea et architecto.', 57, 'message', NULL, 0, 'low', '2025-11-22 16:13:12'),
(145, 265, 'Message', 'Quaerat dolores occaecati vel.', NULL, NULL, NULL, 'https://mitchell.com/alias-eaque-eaque-maiores-ipsa-earum.html', 0, 'low', '2025-11-22 16:13:12'),
(146, 265, 'Video Call', 'Suscipit quis voluptate ex.', 'Inventore amet dicta odio voluptatum sint explicabo.', 40, NULL, 'http://www.crona.biz/quibusdam-quidem-temporibus-eligendi-sunt-aperiam', 0, 'high', '2025-11-22 16:13:12'),
(147, 205, 'Review', 'Expedita vero omnis laudantium aspernatur.', 'Enim neque repellendus tenetur doloremque quia nesciunt dolor eos voluptate rerum aut culpa hic.', NULL, NULL, NULL, 0, 'medium', '2025-11-22 16:13:12'),
(148, 205, 'Video Call', 'Sint voluptatum laborum quaerat.', NULL, NULL, NULL, NULL, 1, 'medium', '2025-11-22 16:13:12'),
(149, 205, 'Video Call', 'Quas id vitae laborum et qui et.', NULL, 34, 'opportunity', NULL, 1, 'low', '2025-11-22 16:13:12'),
(150, 205, 'Video Call', 'Voluptatem ex animi eos quia.', 'Voluptatem repellendus adipisci cum ipsa quia sit dolores possimus quibusdam.', 47, NULL, NULL, 1, 'medium', '2025-11-22 16:13:12'),
(151, 205, 'Opportunity', 'Ut vel modi illum deleniti.', NULL, 79, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(152, 205, 'Application', 'Veritatis temporibus et pariatur.', 'Voluptatem qui qui iste non nesciunt voluptatibus tempore perferendis.', 89, 'application', 'http://nader.com/molestiae-alias-dolor-magni', 0, 'low', '2025-11-22 16:13:12'),
(153, 107, 'System', 'Maxime odio corrupti maxime quisquam et est.', NULL, 73, 'application', 'https://www.okuneva.com/est-inventore-illum-ad-natus-est-quis', 0, 'low', '2025-11-22 16:13:12'),
(154, 107, 'Review', 'Exercitationem dolor laborum eos incidunt iste.', 'Aspernatur voluptatibus quis quas beatae dolorum ipsa molestias voluptatem porro.', 33, 'opportunity', NULL, 0, 'high', '2025-11-22 16:13:12'),
(155, 107, 'Application', 'Maxime nisi aut perspiciatis eaque placeat sit.', NULL, 42, 'call', NULL, 0, 'low', '2025-11-22 16:13:12'),
(156, 107, 'System', 'Molestias reprehenderit sunt mollitia aut maiores velit.', NULL, 13, 'call', 'http://www.rice.com/iste-quia-et-rem-neque', 1, 'high', '2025-11-22 16:13:12'),
(157, 107, 'Video Call', 'Laboriosam praesentium illo unde eaque ex at.', 'Est et provident optio et corrupti aspernatur quas repudiandae facilis vero.', 92, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(158, 107, 'System', 'Reiciendis dicta aut quae veritatis.', 'Minima aut quisquam at consectetur pariatur iste nihil eum quae ipsum ipsum dicta.', 7, 'application', 'http://www.roberts.com/', 0, 'medium', '2025-11-22 16:13:12'),
(159, 107, 'Video Call', 'Natus doloremque quo quo dolores necessitatibus voluptates.', NULL, 88, 'call', NULL, 1, 'medium', '2025-11-22 16:13:12'),
(160, 305, 'System', 'Mollitia neque nobis nihil.', 'Consequatur porro at saepe sapiente dolores dignissimos eum dicta molestias sint cupiditate.', 90, 'opportunity', NULL, 0, 'low', '2025-11-22 16:13:12'),
(161, 305, 'Video Call', 'Voluptatem voluptas et laudantium eum sequi qui.', NULL, 62, NULL, 'https://www.mayert.net/rem-dolorum-sint-natus-placeat-optio-suscipit-vel-sed', 0, 'high', '2025-11-22 16:13:12'),
(162, 305, 'Video Call', 'Quo corporis qui molestiae temporibus sit.', NULL, 55, 'opportunity', NULL, 0, 'medium', '2025-11-22 16:13:12'),
(163, 305, 'Opportunity', 'Dolorum non sint omnis ducimus.', NULL, NULL, 'opportunity', 'https://www.deckow.biz/iste-in-dolorum-qui-magni-iusto-dolores-aut', 0, 'medium', '2025-11-22 16:13:12'),
(164, 305, 'Opportunity', 'Ea eos ut accusantium.', 'Iusto nisi et molestias dolore ullam qui omnis soluta.', 98, 'message', NULL, 1, 'medium', '2025-11-22 16:13:12'),
(165, 305, 'Message', 'Explicabo repellendus est quidem minus iusto.', NULL, 37, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(166, 305, 'Application', 'Dolorum ullam perspiciatis quis neque libero omnis.', 'Qui omnis est magnam distinctio nostrum corporis nihil esse.', 15, NULL, 'https://www.raynor.net/et-quia-unde-ipsam-distinctio-distinctio-ab-consequatur', 1, 'high', '2025-11-22 16:13:12'),
(167, 305, 'Opportunity', 'Ullam perspiciatis id consequatur qui laborum.', 'Exercitationem autem nihil enim tempora ab eos.', 23, 'message', NULL, 1, 'low', '2025-11-22 16:13:12'),
(168, 305, 'Application', 'Perspiciatis facilis est mollitia saepe.', NULL, NULL, NULL, NULL, 0, 'low', '2025-11-22 16:13:12'),
(169, 49, 'Video Call', 'Facilis est culpa expedita commodi.', NULL, 44, NULL, NULL, 0, 'high', '2025-11-22 16:13:12'),
(170, 49, 'Opportunity', 'Dolorum hic repellat sunt.', 'Consectetur similique illo vel est nostrum hic voluptatem odit.', NULL, 'application', NULL, 0, 'high', '2025-11-22 16:13:13'),
(171, 49, 'Opportunity', 'Ipsum rerum ducimus sint maxime et iste.', 'Nihil at nihil dolorem consequuntur qui necessitatibus omnis sed molestiae ab sed sint est.', 95, NULL, 'https://kovacek.info/in-nemo-et-est-ut-nihil-unde.html', 0, 'medium', '2025-11-22 16:13:13'),
(172, 49, 'Video Call', 'Mollitia sed qui quaerat fugit dolor neque.', NULL, NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:13'),
(173, 49, 'Message', 'Molestiae est iure ipsam qui et.', NULL, 7, 'call', NULL, 0, 'high', '2025-11-22 16:13:13'),
(174, 49, 'Message', 'Error sit nulla voluptatem quo quasi est.', NULL, NULL, NULL, NULL, 0, 'high', '2025-11-22 16:13:13'),
(175, 201, 'Message', 'Non temporibus id voluptatem est.', 'Rerum eaque non officiis porro est architecto quasi molestiae ipsa ut incidunt ducimus dolore.', NULL, NULL, 'http://schinner.net/non-quo-in-officiis-fuga-tempora', 0, 'medium', '2025-11-22 16:13:13'),
(176, 201, 'Video Call', 'Eius sed qui similique soluta dolor.', 'Rem voluptatem aut laudantium debitis consequatur necessitatibus quos sit nobis.', 77, NULL, NULL, 0, 'high', '2025-11-22 16:13:13'),
(177, 201, 'System', 'Numquam quis rerum optio sed culpa.', 'In nostrum tenetur in expedita neque omnis est et saepe exercitationem cum dolore.', NULL, NULL, 'http://www.jast.biz/qui-quas-est-omnis', 0, 'high', '2025-11-22 16:13:13'),
(178, 201, 'Application', 'Aperiam dolorum vel perferendis corporis neque ut.', 'Porro cum asperiores animi rem deserunt sunt dicta tempora possimus incidunt.', 57, NULL, 'http://kreiger.info/sint-tempore-culpa-omnis-ad-exercitationem', 1, 'low', '2025-11-22 16:13:13'),
(179, 363, 'Message', 'Bạn được thêm vào conversation mới', 'Chat với quý duy', 21, 'conversation', 'http://127.0.0.1:8000/conversations/21', 0, 'medium', '2025-11-25 17:04:57');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
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
  `certificates` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`certificates`)),
  `verification_status` enum('Pending','Verified','Rejected') NOT NULL DEFAULT 'Pending',
  `founded_year` year(4) DEFAULT NULL,
  `volunteer_count` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `total_opportunities` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`org_id`, `user_id`, `organization_name`, `organization_type`, `description`, `mission_statement`, `website`, `contact_person`, `registration_number`, `certificates`, `verification_status`, `founded_year`, `volunteer_count`, `rating`, `total_opportunities`, `created_at`, `updated_at`) VALUES
('org_6921e012bdfff', 1, 'Test Organzation 1', 'NPO', 'abc', NULL, 'https://mis-bav-g6.odoo.com/odoo/website?debug=assets', 'Hoa Son Quy', '1230921', NULL, 'Verified', '2025', 0, 0.00, 0, '2025-11-22 16:08:50', '2025-11-27 08:42:16'),
('org_6921e0732472a', 2, 'Hoa Son Quy', 'NPO', 'hoa son quy', NULL, 'https://mis-bav-g6.odoo.com/odoo/website?debug=assets', 'Hoa Son Quy', '1230921', '[\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-1-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-2-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-3-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-4-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-5-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-6-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-7-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-8-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-9-1763901902.jpg\",\"certificates\\/org_6921e0732472a\\/hoa-son-quy-cert-1-1764089385.jpg\"]', 'Verified', '2025', 0, 0.00, 1, '2025-11-22 16:10:27', '2025-11-25 16:49:45'),
('org_6921e0d39f40e', 54, 'Disaster Relief Trust - Lake Genesisborough', 'School', 'Est vel iste quia quos est modi eveniet. Aut et ea sit rerum quasi. Quidem reprehenderit voluptatibus in. Laudantium aut ab accusantium voluptatem qui. Nihil esse vitae voluptas et.', 'Sed saepe ullam perferendis numquam atque et vitae voluptas cum dolorem aspernatur suscipit recusandae modi voluptatum.', 'http://kunze.com/possimus-ea-vel-ea-qui-unde-quia-quam.html', 'Prof. Kianna Kiehn', 'ORG-3992-nzsd', NULL, 'Verified', '2023', 85, 0.74, 19, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a046b', 55, 'Green Children Group - Guillermoview', 'School', 'Nesciunt alias velit perspiciatis natus incidunt pariatur voluptate assumenda. Nulla fugiat esse nisi labore delectus incidunt. Sunt error nulla voluptas minus doloremque corporis voluptas commodi. Est sit incidunt repellat qui id. In eum voluptates illum dicta et qui et. Architecto delectus rerum voluptatem et nulla similique.', 'Quasi at animi adipisci pariatur aspernatur porro mollitia eum nemo repellat quidem quisquam.', 'http://www.hegmann.com/et-officia-exercitationem-aut-sit-eum-repellendus-perferendis.html', 'Prof. Stephania Kovacek', 'ORG-7671-grza', NULL, 'Verified', '1991', 38, 3.34, 7, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a19fe', 56, 'Education Citizens Society - Schroederchester', 'School', 'Perspiciatis reiciendis sapiente repellat eos distinctio rerum cum. Quibusdam qui ducimus voluptatem dolorem dicta iusto in ut. Dicta ex dolores et est qui. Et est sed est ea debitis quo vel.', 'Sed eum eum inventore et velit quibusdam dolores est atque excepturi temporibus et.', 'http://www.hane.com/vitae-fugiat-et-ut-enim-architecto-ut-cumque', 'Dr. Colten Trantow III', 'ORG-0783-zxkg', NULL, 'Verified', '2023', 87, 3.04, 4, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a3191', 57, 'Green Children Trust - North Davion', 'NPO', 'Non vero velit aspernatur magni. Earum beatae iste quis exercitationem eum id. Et aliquam cum rem quibusdam id modi. Exercitationem non nesciunt ratione. Quia quam dolore modi aut dolores ea.', 'Molestiae pariatur debitis dignissimos repellat quia ut provident qui odit ipsa voluptatem.', NULL, 'Tina Lesch', 'ORG-8403-uzav', NULL, 'Verified', '2005', 43, 0.59, 8, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a3ab4', 58, 'United Impact Society - South Corrine', 'Community Group', 'Est harum placeat ipsa voluptatum nulla labore quia. Ea aliquam ea sequi rerum et id fugit est. Soluta expedita suscipit dolor nihil. Hic et accusantium debitis exercitationem error ducimus assumenda.', 'Porro pariatur numquam tempora aperiam error ut illum exercitationem rem ut.', 'http://howe.com/quibusdam-placeat-tempore-minima-dolor-sint.html', 'Dr. Hudson O\'Conner Sr.', 'ORG-2153-oell', NULL, 'Verified', '1999', 84, 0.61, 40, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a443d', 59, 'Disaster Change Association - Ondrickaton', 'School', 'Labore est architecto sequi perspiciatis ratione incidunt quasi occaecati. Sint saepe odit ratione sapiente. Occaecati ut reprehenderit qui enim animi eos et dignissimos. Aut repudiandae sit et iure. Nisi cupiditate tempora autem minima totam. Perferendis autem qui suscipit autem.', 'Quasi nihil repudiandae minima sunt molestiae vitae nihil iste corrupti voluptas nulla omnis voluptates id quo magnam.', 'http://langosh.net/', 'Novella King', 'ORG-9707-ghun', NULL, 'Verified', '2019', 34, 1.19, 21, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a4e48', 60, 'Education Welfare Group - Blickhaven', 'Charity', 'Sint sit est labore ut minus eligendi. Officia et dolor itaque aliquam quia vitae repellat. Fugiat atque et reprehenderit. Ipsam veritatis quas ratione dignissimos nostrum. Ab corrupti consequuntur veniam impedit consequatur voluptatem.', 'Similique excepturi doloribus ratione possimus repellat laudantium maiores autem mollitia et.', 'https://www.wunsch.com/officiis-labore-earum-est-pariatur-minima-sed', 'Nichole Bins Sr.', 'ORG-7556-mhwv', NULL, 'Verified', '2000', 21, 4.15, 13, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a582a', 61, 'Senior Children Center - Pourosshire', 'Community Group', 'Ut maxime ut alias magni officia dolor nihil. Quis perferendis alias expedita corporis maiores sapiente accusantium. Praesentium et tempora voluptas error. In soluta nostrum numquam. Et accusamus dolores velit quia.', 'Aliquid accusamus et aut dolore quia reiciendis occaecati aut dolores debitis adipisci autem aut perferendis harum veritatis.', 'http://smitham.com/optio-laborum-quae-et-voluptatem-quasi-aliquid-pariatur.html', 'Mr. Ryley Rippin IV', 'ORG-5352-yofg', NULL, 'Verified', '2013', 77, 4.63, 39, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a6202', 62, 'Environmental Warriors Foundation - Nataliaport', 'Community Group', 'Iure tenetur officiis ullam expedita ratione non odit. Libero consequuntur dolor ut fuga eligendi provident. Hic corporis totam consequuntur voluptatem et quo incidunt. Vel ullam rerum quia fugit est ea consectetur. Velit qui asperiores labore cumque aut ipsam voluptatem.', 'Possimus nesciunt accusantium impedit numquam dolores quod repudiandae delectus dignissimos omnis tenetur.', NULL, 'Myrtis Greenfelder I', 'ORG-3416-jrtg', NULL, 'Verified', '2019', 31, 4.71, 12, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a6c01', 63, 'Future Impact Trust - Cummerataview', 'School', 'Reprehenderit molestiae harum provident culpa illo quibusdam. Omnis temporibus nesciunt et rerum rem libero consequuntur. Dignissimos et praesentium quis dicta. Cum voluptatum magni dolore et. Ipsam qui quod magnam sit. Eos officiis quis eos placeat corrupti tempore.', 'Est nisi recusandae cum a dolorem eum iure quam repellat excepturi soluta sit tenetur repellendus tempora.', NULL, 'Eladio Yundt', 'ORG-5623-rhct', NULL, 'Verified', '1995', 35, 2.26, 29, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a75be', 64, 'Future Earth Group - Yadiraside', 'NGO', 'Molestiae nemo in assumenda quibusdam dolorum. Quis doloremque impedit fuga nesciunt id iure rerum. Totam facere blanditiis molestiae expedita quis ducimus. Deserunt sapiente atque assumenda facilis delectus.', 'Magnam doloremque laboriosam eveniet a harum unde atque autem.', NULL, 'Lilyan Wisozk', 'ORG-3473-slzw', NULL, 'Verified', '1994', 95, 3.90, 6, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a7f9c', 65, 'United Citizens Organization - Ebertview', 'Charity', 'Aperiam nihil dolorum illum necessitatibus earum explicabo. Est aliquam quisquam illum. Quisquam cum perferendis accusantium aut facere. Quod quis voluptatem voluptatem aut. Temporibus est dolorum harum illo veritatis quam doloribus. Cumque nam magnam repellendus vero ut.', 'Laborum eum vitae veritatis qui est itaque quidem est neque delectus.', 'https://conroy.com/libero-nihil-molestiae-odio-cumque-facilis.html', 'Eloise Cruickshank', 'ORG-9198-ttvp', NULL, 'Verified', '1992', 56, 2.64, 46, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a8900', 66, 'Senior Alliance Network - Lake Afton', 'School', 'Autem ipsa sint praesentium quis dicta eum. Et aperiam beatae quasi qui illum deserunt. Quam porro nobis qui debitis ratione rerum laborum. Vero qui voluptatem excepturi vitae qui.', 'Quasi cumque tempora qui a et tenetur cupiditate voluptatibus voluptate non consectetur consequatur.', 'http://www.goldner.com/quas-quae-voluptates-aut-maiores-et.html', 'Prof. Brisa Fadel', 'ORG-1777-pwks', NULL, 'Verified', '2003', 76, 4.87, 42, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a9341', 67, 'Community Heroes Society - Granvilleview', 'Charity', 'Nihil rem aut alias qui et. Quis incidunt aut ut quo nulla reiciendis rerum. Aut natus sint ipsa quam id. Ut nihil numquam impedit reiciendis unde ea quas. Repellendus velit dolor porro sit qui voluptatem non. Ut sequi placeat eaque expedita aliquid dolorem est voluptas.', 'Voluptate praesentium optio sunt praesentium quidem hic sit quidem sint et sit quia doloribus nemo.', NULL, 'Rogelio Ritchie III', 'ORG-8422-ntcr', NULL, 'Verified', '1997', 44, 0.86, 50, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3a9f76', 68, 'Local Citizens Initiative - Garretburgh', 'NGO', 'Facilis dolorum molestias laboriosam nobis nemo. Rerum sapiente dolores suscipit non mollitia temporibus. Illum corporis quae et odio sint tempora. Nulla quod repellendus quia dolor et neque. Animi iste expedita dolores repellat necessitatibus.', 'Harum quisquam fuga dolor labore sit error aliquam cumque enim perferendis nisi quia.', 'http://moen.org/dolorum-molestiae-est-aut', 'Ms. Laisha Beahan', 'ORG-4571-yrkh', NULL, 'Verified', '2010', 18, 0.72, 21, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3aa933', 69, 'Community Care Trust - Keeblerport', 'Community Group', 'Eum repellat repellendus et minus aut. Veritatis consequatur voluptatem dolorem quia. Consectetur et qui vel sint neque.', 'Repudiandae vitae quasi itaque magni consequatur doloribus non molestiae nobis nulla et et molestiae ut rem.', NULL, 'Ms. Lessie Yundt', 'ORG-4719-tohd', NULL, 'Verified', '2008', 25, 3.72, 28, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3ab300', 70, 'Hope Impact Center - Marciaport', 'NPO', 'Qui autem repudiandae dolorem odio. Culpa non harum eveniet rem. Quia quibusdam aut dignissimos. Esse aut aut aut quo.', 'Facere sed accusamus quae expedita ad qui ipsam.', NULL, 'Paxton McDermott II', 'ORG-8548-hchg', NULL, 'Verified', '2016', 12, 1.42, 0, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3abd4d', 71, 'Community Children Center - Lake Polly', 'Hospital', 'Repudiandae fuga sequi quo aliquam. Omnis inventore neque fugiat dolorem est numquam. Iure ipsa odio incidunt ab. Iusto nihil sed nobis consequuntur saepe quidem. Iusto optio maiores voluptas dolorem ducimus molestias. Est dolorum est laboriosam rerum.', 'Eveniet consectetur quos repudiandae error reiciendis cum eos temporibus sit.', NULL, 'Gillian Schulist', 'ORG-0307-nvrc', NULL, 'Verified', '2004', 79, 0.67, 49, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3ac78d', 72, 'Green Warriors Institute - Ziemeburgh', 'Charity', 'Molestiae ut quisquam accusantium saepe commodi omnis. Exercitationem consequuntur aperiam ad ratione enim. Molestiae non expedita quod alias. Et et libero sunt ex doloremque. Quibusdam tenetur atque explicabo quia qui officia non adipisci. Fuga quo molestias perferendis.', 'Voluptas voluptatem perspiciatis sit repellendus exercitationem culpa quibusdam corrupti mollitia maiores dignissimos vero enim voluptates.', NULL, 'Howell Zulauf', 'ORG-3473-jhoz', NULL, 'Verified', '2005', 76, 4.33, 37, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0d3ad224', 73, 'Global Care Association - Bergstromport', 'NGO', 'Consequatur consequatur doloribus voluptate vel debitis tenetur nesciunt. Sint fuga adipisci veritatis accusamus. Autem quis ut consequuntur sint labore error exercitationem.', 'A quibusdam tempore dolorem eum minima consequuntur aut aut consequatur rerum sequi.', 'http://yost.com/', 'Gonzalo Cruickshank', 'ORG-2812-znct', NULL, 'Verified', '2012', 24, 1.37, 28, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
('org_6921e0e0c920a', 121, 'Global Impact Trust - North Cassandraborough', 'NGO', 'Molestiae odit dolorem sapiente alias commodi. Voluptatum nihil natus pariatur natus ullam veritatis. Voluptate deserunt et est nobis nostrum saepe. Omnis libero harum impedit fuga at ut est.', 'Voluptatum facilis corporis fugit deleniti facere aut iure vitae id.', NULL, 'Mikel Hermann', 'ORG-9579-stgg', NULL, 'Verified', '2015', 24, 2.20, 19, '2025-11-22 16:12:16', '2025-11-22 16:12:16'),
('org_6921e0e81406d', 157, 'National Impact Initiative - Lake Dallin', 'NPO', 'Sed dicta incidunt vitae quis nisi culpa laudantium. Praesentium nam debitis tempora quia eveniet. Dolor omnis nostrum quia voluptatem dolorem. Fugiat voluptas error magni pariatur veniam dicta et.', 'Necessitatibus fuga tenetur tenetur est suscipit voluptate velit perferendis.', 'http://www.schaefer.com/', 'Delia Braun', 'ORG-1651-ezff', NULL, 'Verified', '2013', 30, 1.78, 29, '2025-11-22 16:12:24', '2025-11-22 16:12:24'),
('org_6921e0ec1ba5d', 177, 'Future Citizens Group - Walshmouth', 'NPO', 'Voluptatibus qui architecto laborum doloremque eaque labore. Iusto deleniti consequatur praesentium ea sit. Ratione voluptas eligendi nostrum et. Alias quo qui totam voluptatem enim odio quam. Dolorem velit nemo et quia ut excepturi iusto.', 'Numquam provident est et corrupti libero quo expedita vel culpa occaecati ducimus sit sunt quas repellat.', 'http://daugherty.com/', 'Avery Kirlin', 'ORG-4571-gfhr', NULL, 'Verified', '2014', 11, 3.12, 41, '2025-11-22 16:12:28', '2025-11-22 16:12:28'),
('org_6921e0f04e677', 198, 'Disaster Earth Association - South Nikki', 'NGO', 'Praesentium non cum laboriosam velit quia. Vel qui dolor atque aut ut corrupti id quibusdam. Id ullam unde eos sed dignissimos in temporibus. Omnis veniam ab atque enim et illum. Id quo nobis omnis tempora.', 'Cum numquam autem numquam dolorum qui veritatis voluptatem voluptatem aut eum et.', 'https://www.wiza.org/odio-tempora-ad-laborum-molestiae-aut', 'Chaya Schaden', 'ORG-9233-pqwf', NULL, 'Verified', '2022', 44, 4.35, 22, '2025-11-22 16:12:32', '2025-11-22 16:12:32'),
('org_6921e0f2e6b7b', 211, 'Global Development Initiative - West Daijaport', 'NGO', 'Aut et est vitae voluptas et rerum. Consectetur repellat optio aliquam consequuntur. Quo qui enim quibusdam. Sit et animi illum nam ad iure voluptatum. Quidem ipsa debitis beatae beatae ullam nemo sint. Dicta suscipit rem similique tempore.', 'Qui nihil ut recusandae ea qui tenetur molestias sed qui ut alias nam vitae.', 'https://www.yost.com/ut-qui-consequatur-dolor-est-enim-ut', 'Jacey Flatley', 'ORG-3115-htqq', NULL, 'Verified', '2022', 2, 4.01, 13, '2025-11-22 16:12:34', '2025-11-22 16:12:34'),
('org_6921e0f725d90', 232, 'Green Impact Trust - Nolachester', 'NGO', 'Pariatur beatae aut rem voluptatem et id. Atque consequuntur enim in iste et. Praesentium voluptatem et laudantium. Porro laudantium quidem qui reprehenderit voluptates.', 'Qui nam id praesentium in explicabo cupiditate dolor.', 'http://www.yundt.net/', 'Cindy Kautzer I', 'ORG-6763-tenk', NULL, 'Verified', '2002', 95, 0.16, 43, '2025-11-22 16:12:39', '2025-11-22 16:12:39'),
('org_6921e0fea5da5', 264, 'Environmental Society Association - Lake Brain', 'School', 'Voluptatem commodi dolorem qui cumque. Aut sunt ipsam est corporis. Sint ullam soluta quaerat voluptatum tempore.', 'Beatae dolor nam a culpa aut suscipit rem quod fuga quo vel perspiciatis laboriosam unde amet impedit.', NULL, 'Noemie Mayer', 'ORG-8667-bhjk', NULL, 'Verified', '2009', 38, 1.70, 11, '2025-11-22 16:12:46', '2025-11-22 16:12:46'),
('org_6921e100bd79f', 273, 'National Warriors Trust - East Cierra', 'NPO', 'Non repellat reiciendis nam. Quis earum illo et cum eaque ut qui repudiandae. Reprehenderit sit blanditiis molestiae optio porro officia quasi. Quibusdam tempore possimus cum dolores quisquam non.', 'Expedita recusandae iure at enim voluptatum nobis aliquam similique voluptatem officia.', NULL, 'Emmalee Ward', 'ORG-8206-vmth', NULL, 'Verified', '2011', 44, 0.49, 35, '2025-11-22 16:12:48', '2025-11-22 16:12:48'),
('org_6921e106525a2', 295, 'National Warriors Foundation - North Lavina', 'Hospital', 'Quae doloremque facilis aut voluptatem aliquam repudiandae tempora. Accusantium ut maxime quo voluptas repellendus voluptatem. Eveniet reiciendis velit ullam molestias aperiam. Voluptate ut quis et. Ea eligendi omnis officia tempore dignissimos beatae.', 'Et laborum temporibus tempora expedita ab eveniet optio dolore qui est.', 'http://www.monahan.info/quae-earum-nihil-sit-unde', 'Jimmie Bogan', 'ORG-6294-cddu', NULL, 'Verified', '2017', 53, 2.06, 4, '2025-11-22 16:12:54', '2025-11-22 16:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `posts`
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
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `title`, `content`, `image_url`, `post_type`, `status`, `admin_notes`, `likes_count`, `comments_count`, `shares_count`, `views_count`, `is_pinned`, `allow_comments`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'Hoa Sơn Quý', 'Hoa Sơn Quý', '/uploads/posts/1764242279_69283367d8a0a.jpg', 'event', 'published', NULL, 1, 5, 0, 17, 0, 1, '2025-11-27 11:17:59', '2025-11-27 11:17:59', '2025-11-27 11:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `post_bookmarks`
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
-- Dumping data for table `post_bookmarks`
--

INSERT INTO `post_bookmarks` (`bookmark_id`, `post_id`, `user_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, '2025-11-27 11:38:53', '2025-11-27 11:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
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
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`comment_id`, `post_id`, `user_id`, `content`, `parent_id`, `is_approved`, `likes_count`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'hoa sơn quý', NULL, 1, 0, '2025-11-27 11:18:14', '2025-11-27 11:18:14'),
(2, 1, 3, 'hoa sơn quý yy', 1, 1, 0, '2025-11-27 11:38:26', '2025-11-27 11:38:26'),
(3, 1, 3, 'hsq\\', 2, 1, 0, '2025-11-27 11:38:33', '2025-11-27 11:38:33'),
(4, 1, 3, 'hsq', NULL, 1, 0, '2025-11-27 11:38:49', '2025-11-27 11:38:49'),
(5, 1, 3, 'ê', 3, 1, 0, '2025-11-27 11:42:26', '2025-11-27 11:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `like_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`like_id`, `post_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2025-11-27 11:18:08', '2025-11-27 11:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `post_reports`
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
-- Table structure for table `post_shares`
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
-- Table structure for table `post_tag`
--

CREATE TABLE `post_tag` (
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
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
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `reviewer_id`, `reviewee_id`, `opportunity_id`, `rating`, `review_title`, `review_text`, `review_type`, `is_approved`, `helpful_count`, `created_at`) VALUES
(1, 56, 46, 25, 5, 'Aut quidem molestias aperiam.', NULL, 'Organization to Volunteer', 1, 21, '2025-11-22 16:12:06'),
(2, 46, 56, 25, 2, 'Dolor quia est consequatur sit praesentium.', 'Nobis deserunt voluptatem magni iusto laborum provident quis. Consequatur delectus labore sed culpa voluptatibus molestiae. Necessitatibus mollitia rerum sint maxime et illo. Tempora beatae error quod a repellat ea.', 'Volunteer to Organization', 1, 43, '2025-11-22 16:12:06'),
(11, 1, 28, 2, 2, 'Totam deleniti qui incidunt fuga.', NULL, 'Organization to Volunteer', 1, 1, '2025-11-22 16:12:06'),
(12, 28, 1, 2, 2, 'Aut aspernatur dolores laboriosam sint repudiandae autem.', 'Nostrum in eos iusto explicabo eum omnis. Reiciendis sequi qui expedita aut quos.', 'Volunteer to Organization', 1, 23, '2025-11-22 16:12:06'),
(13, 69, 10, 100, 1, 'Consequatur voluptas quasi voluptas voluptatem.', 'Iusto aliquam dolor perspiciatis ad velit reiciendis. Aspernatur iure fugit distinctio ipsa eum deserunt. Nihil temporibus aut qui eveniet.', 'Organization to Volunteer', 1, 10, '2025-11-22 16:12:06'),
(14, 10, 69, 100, 2, NULL, NULL, 'Volunteer to Organization', 1, 44, '2025-11-22 16:12:06'),
(17, 72, 12, 121, 1, NULL, 'Et totam labore aut. Ipsa aut dolores exercitationem officia. Error totam maiores atque magni voluptatum dolorem. Est dolor inventore qui modi autem repellat.', 'Organization to Volunteer', 1, 1, '2025-11-22 16:12:06'),
(19, 12, 72, 121, 2, NULL, 'Assumenda repellendus accusamus voluptatum ipsum perspiciatis enim non. Repudiandae cum eligendi itaque adipisci sunt magni. Qui et dolorum facere exercitationem et placeat et. Explicabo occaecati cupiditate iusto sit doloribus. Dolorem dicta dolorem omnis laudantium alias nam neque.', 'Volunteer to Organization', 1, 11, '2025-11-22 16:12:06'),
(24, 1, 37, 7, 4, 'Qui expedita repudiandae sapiente corrupti.', 'Saepe blanditiis omnis eum aut. Sint deserunt distinctio incidunt modi porro possimus blanditiis. A incidunt autem eos ipsum.', 'Organization to Volunteer', 1, 19, '2025-11-22 16:12:06'),
(25, 37, 1, 7, 4, NULL, 'Aut aut officiis necessitatibus ea facere mollitia. Saepe cum placeat autem rerum maxime molestias inventore. Doloremque et aspernatur consequatur ullam. Error rerum quam totam optio molestiae nemo. Et aspernatur velit ullam blanditiis consectetur aliquam fugiat.', 'Volunteer to Organization', 1, 5, '2025-11-22 16:12:06'),
(30, 71, 12, 112, 2, 'Cum sunt cumque illo consequatur ab.', NULL, 'Organization to Volunteer', 1, 1, '2025-11-22 16:12:06'),
(31, 12, 71, 112, 3, 'Culpa natus error sunt.', NULL, 'Volunteer to Organization', 1, 36, '2025-11-22 16:12:06'),
(38, 71, 7, 112, 1, 'Nemo voluptate similique quas.', 'Tempora non qui voluptatem voluptatem omnis officia delectus et. Illo et maxime sint.', 'Organization to Volunteer', 1, 26, '2025-11-22 16:12:07'),
(40, 7, 71, 112, 4, NULL, NULL, 'Volunteer to Organization', 1, 46, '2025-11-22 16:12:07'),
(41, 68, 27, 94, 2, 'Sunt aliquid sunt quidem ad corporis molestiae.', NULL, 'Organization to Volunteer', 1, 20, '2025-11-22 16:12:07'),
(42, 27, 68, 94, 3, NULL, 'Expedita qui quo nihil eos omnis nulla magni. Qui vero maiores accusamus voluptatem sit excepturi. Aut quos reiciendis in error modi magni.', 'Volunteer to Organization', 1, 23, '2025-11-22 16:12:07'),
(48, 67, 23, 89, 2, NULL, 'Et perferendis error odit praesentium similique hic recusandae et. Ut et sint corrupti totam quod aut qui. Cumque voluptates provident aut. Et voluptas delectus ipsa ea rerum.', 'Organization to Volunteer', 1, 8, '2025-11-22 16:12:07'),
(50, 23, 67, 89, 4, NULL, NULL, 'Volunteer to Organization', 1, 9, '2025-11-22 16:12:07'),
(51, 1, 25, 3, 3, NULL, NULL, 'Organization to Volunteer', 1, 36, '2025-11-22 16:12:07'),
(52, 25, 1, 3, 3, NULL, NULL, 'Volunteer to Organization', 1, 36, '2025-11-22 16:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`key`, `value`, `created_at`, `updated_at`) VALUES
('allow_registration', '1', NULL, '2025-11-27 10:48:00'),
('contact_email', NULL, NULL, '2025-11-27 10:48:00'),
('email_notifications', '1', NULL, '2025-11-27 10:48:00'),
('mail_from_address', NULL, NULL, '2025-11-27 10:48:00'),
('mail_from_name', 'Volunteer Connect Pro', NULL, '2025-11-27 10:48:00'),
('maintenance_message', 'We are currently performing maintenance. Please check back later.', NULL, '2025-11-27 10:48:00'),
('maintenance_mode', '0', NULL, '2025-11-27 10:48:00'),
('require_email_verification', '1', NULL, '2025-11-27 10:48:00'),
('site_description', NULL, NULL, '2025-11-27 10:48:00'),
('site_name', 'VolunteerConnect', NULL, '2025-11-27 10:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `system_analytics`
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
-- Table structure for table `tags`
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
-- Table structure for table `users`
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
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `google_id`, `facebook_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `date_of_birth`, `gender`, `city`, `district`, `address`, `user_type`, `avatar_url`, `is_verified`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'hoasonquy123@gmail.com', '$2y$12$4E22LadUvdhxTmuZJTV7q.pt21KO1LqkqXFBi2XTOpfR.7I5OhhuK', 'Hoa', 'Quy', '0123876543', NULL, NULL, 'Da Nang', 'Đống Đa', 'abc', 'Volunteer', NULL, 1, 1, NULL, NULL, '2025-11-22 16:08:50', '2025-11-27 08:42:16'),
(2, NULL, NULL, 'khiemhg0709@gmail.com', '$2y$12$lZcHLfRnBJdnWZSu380zTOjbPMMU0Q/ZxWx6yZa26AbSht/JJyEm.', 'Hoa', 'Quy', '0123876542', NULL, NULL, 'Da Nang', 'Đống Đa', 'abc', 'Organization', 'avatars/organizations/hoa-son-quy-avatar-1764089384.jpg', 1, 1, '2025-11-23 11:25:09', 'R6ZsHxz0sLeIqcdOnZgEopBXLtb4Ro5ShrLyrezQprximX72G6DIOFSNcNZH', '2025-11-22 16:10:27', '2025-11-25 16:49:45'),
(3, NULL, NULL, 'admin@volunteer.com', '$2y$12$KRLcJ3UCRD7rerVz1X13Iuf9/tLXMnOyZtT.qJahlWZSh.dFjZP9u', 'Hoàng Quang', 'Đạt', '0955685316', '1994-09-12', 'Male', 'Hà Nội', NULL, NULL, 'Admin', 'avatars/TAUvEISFnFLVvZGbOZ3gbYIE030goXbLAlIeAP8I.jpg', 1, 1, '2025-11-27 11:17:09', 'n4s35SAndsakuyRn78VHrlwpyTAhm9ByX0luiJeBPDI5vxBYxIxkqet5O8LG', '2025-11-22 16:11:50', '2025-11-27 11:17:09'),
(4, NULL, NULL, 'lreynolds@example.net', '$2y$12$z4NAHikLocx0F0Kg1wVpv.X6RMnayOuR6j4t8guN3DImT0kZGoNIe', 'Dejah', 'Emard', NULL, NULL, 'Male', 'Da Nang', 'Kutchton', '295 Gulgowski Curve Apt. 839\nNorth Alexis, PA 23659-5373', 'Volunteer', NULL, 1, 1, '2025-11-18 06:26:52', '1kvRM7V965', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(5, NULL, NULL, 'vicky.kunze@example.net', '$2y$12$9W3DJ1GvB2FLKSrar7j87OM/DbwKl44gT6O4PNc2gMgdO3amO7Cji', 'Erin', 'Mayer', '0991639384', '1997-11-15', 'Male', 'Hanoi', NULL, '33511 Flatley Pines Apt. 429\nGutkowskimouth, WV 48012-4433', 'Volunteer', 'https://via.placeholder.com/200x200.png/000088?text=people+exercitationem', 1, 1, '2025-10-24 00:42:18', 'toYYtHWYTv', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(6, NULL, NULL, 'jrempel@example.com', '$2y$12$jsWwINl/ixxXChrA9vLtx.7lWXnktr3qymtdb64bT.HtJCxjBKu3S', 'Claude', 'Russel', NULL, '1999-10-08', 'Female', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc00?text=people+asperiores', 1, 1, '2025-11-09 05:15:55', 'mPhX9PalRL', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(7, NULL, NULL, 'jenkins.stacy@example.net', '$2y$12$QS5QQEj05/Ai3HKNIxGb9ODBxYvvi6iHrdNlEe9andeWlnmUK9mdq', 'Clarissa', 'Leuschke', NULL, NULL, 'Other', 'Da Nang', NULL, '26500 Haley Station\nNew Theoside, MS 42086-3643', 'Volunteer', NULL, 1, 1, '2025-11-18 06:29:59', 'k68qDs7k3t', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(8, NULL, NULL, 'bradtke.mozelle@example.org', '$2y$12$PBqFlh8Qwzx4GtfTuv4lze1XIWrLe6joKVtrPkCqWu0g7XFo6XwRW', 'Elissa', 'Keebler', NULL, '1983-03-22', 'Other', 'Ho Chi Minh', NULL, '4548 Braun Spur\nAlizaville, MO 80954', 'Volunteer', NULL, 1, 1, '2025-11-14 13:45:39', 'T5RKZfDCld', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(9, NULL, NULL, 'noble99@example.net', '$2y$12$WV.Z9KNZ8jG48eCShtvj9uMT5Qlo6o1Wsduk0137y.Z8WlFMjzKea', 'Carmela', 'Marvin', '0943393207', NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'jPie359FUT', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(10, NULL, NULL, 'hermiston.hazel@example.com', '$2y$12$1TUP.NOMAmrCQwXvqsES0.ZE9Cz35EcgupQtBnu.qnftM7yvdaZbS', 'Lennie', 'Ziemann', NULL, NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0066cc?text=people+unde', 1, 1, NULL, 'Nj55xqWDYv', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(11, NULL, NULL, 'rath.marvin@example.com', '$2y$12$Swa07R8hz5pA4YXPLNxz1.fTst7g5L2ewuwgrRDjuGwEDmPg42/Iy', 'Paris', 'Hand', '0997597453', NULL, 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0000cc?text=people+voluptas', 1, 1, NULL, 'JWRe3wVw1I', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(12, NULL, NULL, 'hstrosin@example.com', '$2y$12$2Es2riVD5UGKu5u79whQjeWKPD6dG5VCbCFdpdy9LryAldu0dUUg6', 'Creola', 'Sawayn', '0946684694', '2000-05-23', 'Male', 'Ho Chi Minh', 'Zelmaberg', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa66?text=people+libero', 1, 1, NULL, 'PgwtajngkI', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(13, NULL, NULL, 'sophia.dach@example.com', '$2y$12$NDoZYny1a9c0o.fEEWKsOuv3GSuearxVgxFvBmBW8uIMD.JbWH55u', 'Loy', 'Hills', '0907540793', NULL, 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000099?text=people+tenetur', 1, 1, '2025-10-26 09:39:00', 'SVgAzzJAJZ', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(14, NULL, NULL, 'maryam11@example.com', '$2y$12$yredHr4PGsAIG2Jji1h00OfDLpkIf3JcD4l2dbNbNPJ1Y15VC7uam', 'Sven', 'Schneider', '0926196427', NULL, 'Other', 'Da Nang', 'Weissnatfort', NULL, 'Volunteer', NULL, 1, 1, '2025-10-26 11:34:53', 'sCKCDmeHhj', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(15, NULL, NULL, 'kpfeffer@example.net', '$2y$12$4if/s2A4gRnK/yE9dnfo6e/.l5DdPyRichj1FXIarIRV57oAVcg4K', 'Novella', 'Keeling', '0903733165', '1998-08-02', 'Male', 'Hai Phong', 'Antonetteborough', NULL, 'Volunteer', NULL, 1, 1, NULL, 'CVJaGrcZUD', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(16, NULL, NULL, 'lindsay98@example.net', '$2y$12$WrhVdt51tK82A5G58c2Mf..YAHMIuw1kS0/ZyJ71g83Zvxi6JIm.6', 'Emely', 'Bernhard', NULL, '1970-09-19', 'Other', 'Da Nang', NULL, '56238 Lilla Forks Apt. 449\nSouth Lelahchester, AL 82410-1068', 'Volunteer', NULL, 1, 1, '2025-11-14 10:32:00', 'ykxRK4SG0d', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(17, NULL, NULL, 'charlotte.runolfsson@example.net', '$2y$12$SntFimkcN.kGYrO1Q5UPcudDx5e1nZ38gvifNqbor4qvXqZoTxeVe', 'Carey', 'Lebsack', '0933337821', NULL, 'Female', 'Hanoi', 'Port Dayton', NULL, 'Volunteer', NULL, 1, 1, '2025-11-08 07:20:06', 'uk4jENpaaM', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(18, NULL, NULL, 'shemar.smith@example.org', '$2y$12$QQzMLmh1uSZTd7FpG42dO.oVY1dGM7KEyZ8kxKA2ROMEnA10lPVJq', 'Lesley', 'Harber', '0977884584', '1993-04-05', 'Other', 'Hai Phong', 'Lake Dorisbury', '64102 Aileen Viaduct Apt. 715\nPort Shaniyahaven, CO 68827-2428', 'Volunteer', 'https://via.placeholder.com/200x200.png/0066dd?text=people+fugit', 1, 1, '2025-11-12 11:26:44', '2SA9v8Ysyq', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(19, NULL, NULL, 'frami.tracey@example.com', '$2y$12$xseFF.H97XnP9r.fMmKMResn5vWFOmohTUCHg90BbRN89sVTalJzG', 'Grant', 'Cummings', '0971277459', NULL, 'Male', 'Ho Chi Minh', NULL, '86515 Tremblay Junctions Suite 791\nEast Clydefort, OK 50320-8928', 'Volunteer', 'https://via.placeholder.com/200x200.png/007711?text=people+ab', 1, 1, NULL, 'brUDNvJEF8', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(20, NULL, NULL, 'wolff.santa@example.com', '$2y$12$g5IhissNHWX7DaGRj2iCsOvSit0Ib4GB95t9lgSFPIWX9mb6XQTfq', 'Jammie', 'Jacobson', '0900490452', '1969-06-10', 'Male', 'Ho Chi Minh', 'Skylaview', NULL, 'Volunteer', NULL, 1, 1, NULL, 'hpBDAZPAER', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(21, NULL, NULL, 'lblock@example.com', '$2y$12$h3nyXiNaE14n3KyyWBC1FuzhrIXGG0/tkuxggZabT6loUltvi.XGW', 'Cyrus', 'Rosenbaum', NULL, NULL, 'Female', 'Hai Phong', 'New Jordi', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0022ee?text=people+voluptatibus', 1, 1, NULL, 'cHWVEqEgpJ', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(22, NULL, NULL, 'shanahan.hudson@example.com', '$2y$12$rY93yysFlCoNTqf6SXTM2uNCSzu5B4AM719GnpNIGNRVViZWfVPoq', 'Jayce', 'Hill', NULL, NULL, 'Female', 'Da Nang', 'Port Chauncey', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002266?text=people+quia', 1, 1, '2025-10-25 12:18:20', '9gPLiPTjrt', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(23, NULL, NULL, 'jess41@example.com', '$2y$12$YA2480LasN31Qz.bWvakaOPCDUp02xZREpQ7bmvwwQxtxLMPm.CXG', 'Zechariah', 'Leuschke', NULL, NULL, 'Female', 'Hai Phong', 'Lake Adelle', '951 Friesen Square Apt. 538\nEast Alizemouth, NM 96845-3696', 'Volunteer', 'https://via.placeholder.com/200x200.png/001144?text=people+adipisci', 1, 1, NULL, 'SBbWLapEmM', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(24, NULL, NULL, 'lbeer@example.org', '$2y$12$56MnON7kfX/8A7QV19d7peyMefxJQEZBBth3dL/f61pCkxrO.rvDa', 'Dallas', 'Treutel', '0960437544', NULL, 'Male', 'Da Nang', 'West Leoraburgh', '33050 Powlowski Meadow\nEast Jillianville, NM 25790-4027', 'Volunteer', NULL, 1, 1, '2025-11-17 14:28:43', '7JBhUONkmd', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(25, NULL, NULL, 'okuneva.logan@example.com', '$2y$12$H64o9B3v/sciG/8m.ODOPujkpCAXwLHdqC4XxCwVtUVXrqC4DYHpO', 'Charlene', 'Huel', NULL, NULL, 'Other', 'Hanoi', NULL, '883 Eliseo Run\nBotsfordfurt, MD 67803-0116', 'Volunteer', 'https://via.placeholder.com/200x200.png/0077aa?text=people+modi', 1, 1, NULL, 'CG18qvAh1j', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(26, NULL, NULL, 'delia.rau@example.com', '$2y$12$tRWq3fgUbJuPPe4opYAlie.k2svxHDAGZYeaXJHmzBPddux9q6X.a', 'Emely', 'Kunde', NULL, '1983-01-06', 'Male', 'Da Nang', 'Joeside', NULL, 'Volunteer', NULL, 1, 1, NULL, 'CPkwfscgai', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(27, NULL, NULL, 'ernest02@example.net', '$2y$12$wDe4iI/UhRxxyTCqySiI5ebdzouBLp2cMENE4PmmbEyfDubn25Ff.', 'Valentina', 'Okuneva', NULL, '1969-12-13', 'Female', 'Hanoi', NULL, '6711 Dibbert Loaf Suite 518\nParkerfurt, HI 56313', 'Volunteer', NULL, 1, 1, '2025-11-09 14:32:23', 'uYiynuLKIv', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(28, NULL, NULL, 'jerome50@example.com', '$2y$12$ijd/4skVOhBb.Jho91nfmuFZZPZnRqQXihYGB2pTsC.FxJPXXB8WO', 'Arvilla', 'Lebsack', '0916502039', '1997-10-11', 'Male', 'Da Nang', 'West Maureenville', '4667 Daron Greens Suite 434\nWest Erichburgh, RI 00353', 'Volunteer', NULL, 1, 1, '2025-11-10 23:49:06', 'gHZxhAD4xH', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(29, NULL, NULL, 'amiya.kertzmann@example.org', '$2y$12$VOnY9pzvr2y92HnaSZ/Bv.p25ewYRdsHkOr1F3VLDMu4BWnPrFrAy', 'Kaden', 'Gleason', NULL, '2002-02-26', 'Other', 'Hanoi', 'South Tristonbury', '604 Meaghan Inlet\nNorth Alanis, TX 50396-8694', 'Volunteer', 'https://via.placeholder.com/200x200.png/007711?text=people+rem', 1, 1, '2025-10-26 20:31:37', 'ZUvpd19bPR', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(30, NULL, NULL, 'ethan.thiel@example.com', '$2y$12$/bOl6gSfJ/xma5eVDETisOt9AQfwun/nihnmlPpeRslArvabIFysS', 'Lyla', 'Waelchi', NULL, '1988-11-29', 'Female', 'Hanoi', NULL, '84324 Williamson Brooks\nDeondremouth, SD 32302', 'Volunteer', NULL, 1, 1, '2025-10-27 13:48:45', 'arAfUm4YT3', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(31, NULL, NULL, 'emile.labadie@example.org', '$2y$12$tc7L2nImL.vfABzbLAs62OnmiDaMzF38vQCenzmkldHZfnpYEuacW', 'Mireille', 'Klocko', NULL, '1972-10-15', 'Male', 'Hai Phong', 'Loritown', '3829 Mertz Green\nKeeblerbury, NE 04717', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aaee?text=people+blanditiis', 1, 1, NULL, '317BKzqOvm', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(32, NULL, NULL, 'labadie.dejuan@example.org', '$2y$12$Q6EaDYbElK7LhSUBXLHShOo3UgBeJ2maAepuZ4JnQhdNcgV2UXSa.', 'Jaydon', 'Hessel', NULL, NULL, 'Other', 'Can Tho', 'Bartolettiborough', '468 Altenwerth Roads\nWest Margarete, GA 51557', 'Volunteer', NULL, 1, 1, NULL, 'bRWZwuaRs2', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(33, NULL, NULL, 'gprice@example.org', '$2y$12$X8UKoE/YNa65PmplfCKYxOx8oZZ.eJpNf7V3xLpJBl7OdRV/IEMx2', 'Delphia', 'Goodwin', '0912200280', '1981-08-05', 'Male', 'Hai Phong', 'North Issac', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+facilis', 1, 1, '2025-10-27 02:24:37', 'BwYvFHuzRl', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(34, NULL, NULL, 'yrutherford@example.com', '$2y$12$XMNB29BtZ9IzVj9DzWiNZOraSmY2USEwA53ZqfSrnlKULvfWE39Lq', 'Javon', 'Bartoletti', NULL, NULL, 'Other', 'Da Nang', 'South Gina', NULL, 'Volunteer', NULL, 1, 1, '2025-11-02 02:58:42', 'aIkKiaxv5w', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(35, NULL, NULL, 'ajacobson@example.com', '$2y$12$b8RDpdAeBwvA8LhFmfKD6.oWZ.BVXY843WWrxPiOtse.EwSjee5E.', 'Joana', 'Gottlieb', '0922579134', '1974-09-28', 'Female', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-10-30 11:39:38', 'wHwLonTbvJ', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(36, NULL, NULL, 'hbins@example.org', '$2y$12$2RqsGh/Ht2xqRekJn2QPY.HjxfF9ZGsxsyKcTK.1pnGcv9lp0R7OS', 'Richmond', 'Brown', '0903199740', '1972-09-02', 'Female', 'Hanoi', 'Maciton', '49104 Wiza Wells Suite 212\nWest Karianne, IL 81877', 'Volunteer', NULL, 1, 1, '2025-11-16 07:51:45', 'S4vJvb87Ea', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(37, NULL, NULL, 'rweimann@example.org', '$2y$12$4dhEL4RPC5xu4yUxTYy0he65Qg8qfcCXDgTgBx93Wv7rZPhucajH6', 'Myrtice', 'Kirlin', '0939653609', NULL, 'Male', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0099bb?text=people+et', 1, 1, NULL, 'CpGsHR7EJl', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(38, NULL, NULL, 'ybruen@example.com', '$2y$12$oARfuP9AAEhPLR0icgLpUe7yyaaZCugkaX13/bE11IM4OaB7snEAq', 'Kenton', 'VonRueden', '0984192827', NULL, 'Female', 'Hai Phong', 'Port Bryana', NULL, 'Volunteer', NULL, 1, 1, '2025-11-01 04:02:55', 'SE7a2O12TL', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(39, NULL, NULL, 'clark49@example.com', '$2y$12$rWV.6QrQHQU9VYsGoGv55uV1URQC7xD0OY02wYY3AfQCJApBi4XIu', 'Kirsten', 'Kessler', '0926243316', NULL, 'Male', 'Hanoi', NULL, '73077 Carmel Springs\nRomaguerafurt, IL 49832', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb66?text=people+quis', 1, 1, '2025-11-21 05:08:23', 'q6J41tLDyG', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(40, NULL, NULL, 'lacey.turner@example.net', '$2y$12$2OMEq33iv68ydTmhBGvQ1u1ZnDqcVmfsb/JVhzCxrRLm4Te/LabqC', 'Charley', 'Botsford', '0947541294', '1991-10-03', 'Female', 'Ho Chi Minh', NULL, '281 Levi Keys Apt. 522\nHettingerview, WV 08950-9691', 'Volunteer', NULL, 1, 1, NULL, 'Hso5kByQIa', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(41, NULL, NULL, 'yharvey@example.net', '$2y$12$mfbuVQJn9XJM2I4/MD7Om.Q3eeiv73RVqJv2dJuLWKfcZEFHw6COe', 'Antonio', 'Schoen', '0937174676', '1968-03-29', 'Male', 'Da Nang', 'Port Terrill', NULL, 'Volunteer', NULL, 1, 1, NULL, 'wzTQ3d2UBa', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(42, NULL, NULL, 'zswaniawski@example.net', '$2y$12$e9i7zMNDbH6V9qqw3QYHLeSt8Prh/Av1xn75v96m/.mQ5cz666w42', 'Ramiro', 'Buckridge', '0918931203', NULL, 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa88?text=people+similique', 1, 1, NULL, 'AfKb8GD5qN', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(43, NULL, NULL, 'kreiger.jeffry@example.net', '$2y$12$FwZdM1zyZaRQQkKwUrg.6.zU7z8fh9mjY2cYkaIamcEebSc227ncC', 'Viola', 'Bergstrom', NULL, '2006-12-10', 'Other', 'Ho Chi Minh', NULL, '9705 Swaniawski Lake\nMorarmouth, IA 19407', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddbb?text=people+non', 1, 1, '2025-10-31 03:06:47', 'KNAJR3nIYj', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(44, NULL, NULL, 'wilton71@example.com', '$2y$12$F1nQIm44cq2PM13YIX4vGu5PQNdPr8bOfeFfI0H/r.aj2C19Kan/m', 'Napoleon', 'Medhurst', NULL, '1988-03-10', 'Male', 'Hai Phong', 'Buckridgehaven', NULL, 'Volunteer', NULL, 1, 1, NULL, 'DK5Ypu1Ugc', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(45, NULL, NULL, 'hoppe.alysa@example.org', '$2y$12$pyICLdgWCP6uKoRu3jA3Ie63fA13oUPeCkbtEEHn9oHBhGVD/6DNO', 'Curtis', 'Bashirian', NULL, NULL, 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'D6roQGClRz', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(46, NULL, NULL, 'jocelyn87@example.com', '$2y$12$RyxcCcKKuwLd8bQWVNnhG.s81rvAcXFcKAqSu/PeuzM5/z7QoP1EO', 'Arely', 'Mosciski', '0952087204', NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-10-26 18:30:16', 'q5oohfffEO', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(47, NULL, NULL, 'uwatsica@example.org', '$2y$12$mbMjv1tAJhN39UxkrW3GsuRLaFaFp5aYfJhq.yDhcrSyy2UHojoe6', 'Gerson', 'Grant', NULL, NULL, 'Male', 'Hanoi', NULL, '3247 Batz Center\nEast Ruthiemouth, AR 05163-0332', 'Volunteer', 'https://via.placeholder.com/200x200.png/007733?text=people+et', 1, 1, NULL, '1GFZzn4vdM', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(48, NULL, NULL, 'joseph.erdman@example.com', '$2y$12$0ecnvoJ1aTWwkgOtxpXeTuZpDQvVuityOj/6ZQBikwL0r0b.Vxcj6', 'Ismael', 'Stokes', NULL, NULL, 'Other', 'Ho Chi Minh', NULL, '3995 Goodwin Bridge Apt. 890\nShanehaven, KY 43003', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000ee?text=people+omnis', 1, 1, '2025-10-31 14:48:34', 'FsmjgAD55T', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(49, NULL, NULL, 'august.kub@example.net', '$2y$12$4VRcXDACoGz7T.7fYHEGMe8ageItdMYQDDLjI61HSn6F.w0nDBjza', 'Hyman', 'Daniel', NULL, NULL, 'Other', 'Da Nang', 'Claraport', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/009988?text=people+quis', 1, 1, '2025-11-09 21:32:48', '7MnNej2bmi', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(50, NULL, NULL, 'iwhite@example.net', '$2y$12$xOlsW9.b3Zbxva/DwyQ5a.xfL3xhtOAguHxDTrh6nnc0ot51Uo4iu', 'Josie', 'Predovic', '0928150089', NULL, 'Other', 'Ho Chi Minh', 'McClurechester', '3689 Bradtke Hill\nPriceberg, ME 68140', 'Volunteer', NULL, 1, 1, '2025-11-22 08:14:21', 'WCsQEw2RoG', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(51, NULL, NULL, 'valentine.buckridge@example.org', '$2y$12$em1xbK0ef4.lgAJEk4pAFOStm8L4NU/04c0W1/3R77au41CJEngHC', 'Kaycee', 'Beier', NULL, NULL, 'Male', 'Hanoi', 'Rethaberg', '2974 Rippin Shore\nNew Coltonville, OH 01252-1344', 'Volunteer', 'https://via.placeholder.com/200x200.png/006622?text=people+est', 1, 1, '2025-11-11 10:55:12', 'EPKWCpE8dW', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(52, NULL, NULL, 'hpouros@example.net', '$2y$12$jYCL/ITAnEklYxaqHB4E1e/XWZGCgJHgdwBSyvnWJds0ZtxvbJA36', 'Tomas', 'Hand', '0944135402', '1967-06-12', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'wS4KEBNh4a', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(53, NULL, NULL, 'ndickens@example.com', '$2y$12$wzqtkgG8VpH7DwtjT4OLa.23VY3VS74YZ8qM0XBezKytON4aW89fi', 'Madie', 'Mueller', '0969454850', '1974-03-27', 'Other', 'Hanoi', 'Paucekhaven', '988 Roob Shores\nStephonside, CA 54319-5674', 'Volunteer', NULL, 1, 1, NULL, 'vPleyzYCKF', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(54, NULL, NULL, 'wilkinson.willy@example.com', '$2y$12$YxMtMahUYvAHVE.nYOcp/eTvyfNviU40TWGk1fDpWj1DdVV4h5jU.', 'Birdie', 'Ortiz', '0939674028', '1983-05-18', 'Male', 'Can Tho', 'South Maryjane', NULL, 'Organization', NULL, 0, 1, NULL, 'TQgIMOMGuP', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(55, NULL, NULL, 'theresia72@example.com', '$2y$12$Hd5oW/20aab26lv36ofa5eq.bLf.7VPaOH6bJcO2hsScZND5.BcR6', 'Ayden', 'Renner', '0959029278', NULL, 'Male', 'Can Tho', NULL, '83955 Marion Dale\nEast Presleyside, NV 48133-6243', 'Organization', NULL, 1, 1, '2025-11-04 15:52:05', 'lzptozZ4SD', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(56, NULL, NULL, 'hartmann.luis@example.org', '$2y$12$5EQp7e91owfMLtoDDQhnwOf9skHsGWTOskUTeyfDdg/NbsakCqj.i', 'Jena', 'Brakus', '0997653375', '1999-08-03', 'Female', 'Hai Phong', NULL, '166 Collin Hill\nDarlenestad, LA 96206-4318', 'Organization', NULL, 0, 1, NULL, '5a62KJ1Ev4', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(57, NULL, NULL, 'chadd94@example.org', '$2y$12$gZdumwKjuNqkov1tF4ReneKbd5X71iIt4MNDRMBOmIbG84itgZUBS', 'Eunice', 'Prohaska', '0941770849', '1988-08-06', 'Male', 'Da Nang', NULL, NULL, 'Organization', 'https://via.placeholder.com/200x200.png/00dd00?text=people+modi', 0, 1, '2025-10-29 04:07:49', 'qwTbK2xC4g', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(58, NULL, NULL, 'yost.amos@example.org', '$2y$12$p827IC74rOgHAq65DrFC.exRnMA1or5hocLpnIXom7Ethga3eXUgC', 'Rory', 'Bashirian', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, '48187 Larson Branch Suite 519\nLavernchester, WI 56395', 'Organization', NULL, 1, 1, '2025-10-29 19:33:24', '359YkIgeT0', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(59, NULL, NULL, 'xkassulke@example.com', '$2y$12$Q4EVMse.NsJ/USVMRwkmuuxNu9U7021s1GlDgMjXFjF2hzUYThSi6', 'Judd', 'Paucek', '0958178140', '2004-10-17', 'Female', 'Can Tho', NULL, NULL, 'Organization', NULL, 1, 1, NULL, 'oKQBlKVobK', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(60, NULL, NULL, 'thompson.irwin@example.net', '$2y$12$yiik87vHij8W3JD6tJevPeBmZs6o.k.nB7/sXNFoWJdIP2m9in.qC', 'Kirsten', 'Altenwerth', NULL, NULL, 'Female', 'Ho Chi Minh', 'Shadville', '3603 Agustina Views Suite 376\nWest Dedricburgh, VA 47025-0483', 'Organization', 'https://via.placeholder.com/200x200.png/009911?text=people+aliquid', 1, 1, NULL, 'LQCtGTaoUG', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(61, NULL, NULL, 'tillman.rey@example.net', '$2y$12$/rgMrAr2mEhcypsv9Qif3uf0P8BYfK/sVsoK50ytJwes95MI/mns6', 'Gunner', 'Rippin', NULL, NULL, 'Female', 'Hai Phong', 'Port Francis', NULL, 'Organization', NULL, 1, 1, NULL, 'cSxlf0dW70', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(62, NULL, NULL, 'cruickshank.stephon@example.org', '$2y$12$zpCH1.qx59V3gz1OvJtFlOJ9uLgb.KdZbUUtbSHMwL9ULDm1Qwzgq', 'Carole', 'Stokes', '0963990205', NULL, 'Female', 'Ho Chi Minh', 'West Moses', '39929 Gorczany Creek\nEast Federicofort, LA 40833', 'Organization', 'https://via.placeholder.com/200x200.png/001122?text=people+harum', 0, 1, NULL, 'rsRorl95oA', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(63, NULL, NULL, 'muller.jaren@example.org', '$2y$12$P2o.B3cdcCLvh8O8ZTY7keXBvzULUuk.1hLPac6YtgnzK/zwHG3hq', 'Kenyatta', 'Hane', NULL, '1989-02-16', 'Female', 'Can Tho', 'Emmieland', '71701 O\'Connell Tunnel\nMarcelinashire, KS 43233', 'Organization', NULL, 1, 1, NULL, 'KkXyfCDUiJ', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(64, NULL, NULL, 'lindgren.jameson@example.com', '$2y$12$lmBdhNhmxt.p2.TY4HU20Ovs6gBNE/aRNci0IGuasrhoeSMWpZxeW', 'Seth', 'Medhurst', '0905623884', '1998-02-16', 'Male', 'Can Tho', NULL, '7281 Evie Brook\nNorth Lenoreburgh, OR 30418', 'Organization', 'https://via.placeholder.com/200x200.png/0000dd?text=people+totam', 1, 1, '2025-11-06 13:21:54', '6kJiVEiShK', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(65, NULL, NULL, 'hauck.archibald@example.net', '$2y$12$QiUnSAeCeuO2sGMo38TLmu.zmGmsK33Les6unj24PcyOAwcsjUysi', 'Rahsaan', 'Greenholt', '0926412540', '1973-06-25', 'Male', 'Can Tho', NULL, '2244 Mathilde Gardens Apt. 330\nTowneton, ND 16199', 'Organization', NULL, 1, 1, NULL, 'GQAkj6WgRQ', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(66, NULL, NULL, 'tpollich@example.net', '$2y$12$1Gsc7C58a7ANPWwsmLLG..6sBXz9aWvQxufm8.pABMN.vRpV9xRGO', 'Arnold', 'Stiedemann', '0949086955', NULL, 'Male', 'Ho Chi Minh', 'North Erikaburgh', '55785 Daija Trace Suite 934\nTorpfurt, OR 66586-3027', 'Organization', NULL, 0, 1, NULL, '2QnQWWF8kh', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(67, NULL, NULL, 'curtis47@example.com', '$2y$12$G1k6ysKAKgzh6H1HrwQu3u2zbc3bGPtKpL3z2waJSPZgC1NhDQQ0u', 'Scotty', 'Feeney', NULL, NULL, 'Female', 'Da Nang', 'Port Hayley', '593 Verona Overpass\nCourtneyberg, ME 35049', 'Organization', 'https://via.placeholder.com/200x200.png/0033cc?text=people+voluptatem', 0, 1, NULL, '0dh7C1ZRkD', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(68, NULL, NULL, 'iherman@example.net', '$2y$12$RY2xWKq/EjEXh54WpA3w9OWIyZErSVCd10LeFhDLbi/jOS9aI4/7m', 'Kurtis', 'Stokes', NULL, NULL, 'Male', 'Hai Phong', NULL, '99477 Elroy Burgs\nRobertsfurt, CO 20522', 'Organization', NULL, 1, 1, NULL, 'bfS9ImTJLi', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(69, NULL, NULL, 'mwunsch@example.net', '$2y$12$U2ooRmVUBnRnk.7QgZ/p9e/EbvUnUKbkK9T2DUCr0WAAN3Hve5qH.', 'Jalon', 'Dickens', NULL, NULL, 'Female', 'Hanoi', 'Haagview', NULL, 'Organization', 'https://via.placeholder.com/200x200.png/00eecc?text=people+et', 1, 1, '2025-10-27 03:40:24', 'yUSo4YTUWy', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(70, NULL, NULL, 'lionel32@example.net', '$2y$12$7a0oFZN0WPLwC62sES94lek5nd1wVmEwUTvHpLqjFMGlwVwz4ObHG', 'Maxime', 'Johnston', NULL, NULL, 'Other', 'Ho Chi Minh', NULL, '7757 Rodriguez Mountain Apt. 390\nRebeccashire, OK 78914', 'Organization', NULL, 1, 1, NULL, 'i95HDPLRbA', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(71, NULL, NULL, 'chyna33@example.net', '$2y$12$i1a7xVWLL5WST.w4HPoR8O5OVoWtsC07xnGfIfWM0DusWnvxpruwC', 'Devan', 'Brown', NULL, NULL, 'Male', 'Ho Chi Minh', 'East Wendy', '13698 Judge Estates Suite 068\nWest Birdie, WI 91236-2119', 'Organization', NULL, 1, 1, NULL, 'CZcDsW6h9l', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(72, NULL, NULL, 'mjakubowski@example.com', '$2y$12$dnlRchaHPyycw/SutL18KeCTwZUp0VEdsX8kP.RRbZ1gXDtLNw.dO', 'Jordyn', 'Hegmann', '0974743415', '2004-04-15', 'Female', 'Can Tho', 'Runteville', NULL, 'Organization', NULL, 1, 1, NULL, 'VzENLr3p2v', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(73, NULL, NULL, 'austin95@example.com', '$2y$12$7H2UGD/odaC5SSdZFHuflOmJdrg/kI8hQ0Zc.kDCXOse/c9zFsTd6', 'Chasity', 'Crona', '0987680408', '1966-01-19', 'Female', 'Hanoi', 'O\'Reillytown', NULL, 'Organization', NULL, 1, 1, NULL, 'O49SgHwRu3', '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(74, NULL, NULL, 'xtremblay@example.com', '$2y$12$2LQw4AKJgzKyHCfx7Te9mejMkGeadvxkJjRrs.5G3UCJW2p3f9d92', 'Dameon', 'Medhurst', NULL, '1974-01-01', 'Male', 'Da Nang', NULL, '5495 Kara Unions\nPort Jennifer, NH 30283-1228', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+autem', 1, 1, NULL, '0C1wmkkPo5', '2025-11-22 16:12:07', '2025-11-22 16:12:07'),
(75, NULL, NULL, 'kohler.edythe@example.com', '$2y$12$49Zj5RaMgx45rHN9eoqndeJxWusOmLEBX7o8UH/o9O0aGld1Wh5q.', 'Palma', 'Bins', '0949652004', '1995-05-16', 'Male', 'Ho Chi Minh', 'East Abner', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0000ff?text=people+ut', 1, 1, NULL, '7d1sMnn3D3', '2025-11-22 16:12:07', '2025-11-22 16:12:07'),
(76, NULL, NULL, 'zhessel@example.org', '$2y$12$t9dUEj0sItKsWMmhyJSmW.4j0XIOJCOhVYvo8NiltvgHACbBPhPhW', 'Imelda', 'Effertz', '0969256229', NULL, 'Male', 'Hai Phong', 'Fernebury', NULL, 'Volunteer', NULL, 0, 1, NULL, 'BIRzJJJc3f', '2025-11-22 16:12:07', '2025-11-22 16:12:07'),
(77, NULL, NULL, 'bashirian.jensen@example.org', '$2y$12$qpkVUlDRjmC7FEoEqmm9DOMM980fSAu06LwV07S90VOEwaWO3HJG6', 'Luigi', 'Wolf', NULL, NULL, 'Male', 'Ho Chi Minh', 'Port Lilyan', '35422 Lowe Vista\nEast Brycestad, PA 10899', 'Volunteer', NULL, 1, 1, NULL, 'klacygb0vR', '2025-11-22 16:12:07', '2025-11-22 16:12:07'),
(78, NULL, NULL, 'adelle.jacobson@example.net', '$2y$12$fm3KjGMyzWoDCIqWCR329.slYNTjQfg2uQepNDzHHpQ78fBWEtIaK', 'Darius', 'Donnelly', '0929122541', NULL, 'Female', 'Hai Phong', 'New Damon', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd44?text=people+consectetur', 0, 1, NULL, 'Otfq4ST3ix', '2025-11-22 16:12:08', '2025-11-22 16:12:08'),
(79, NULL, NULL, 'dan.roob@example.net', '$2y$12$Y1XM0heVA7FPSygVQ2G1rO/o079PJUirL/K88YTLCmQWdx8w4GzgO', 'General', 'Rice', NULL, '1989-09-24', 'Male', 'Ho Chi Minh', 'South Shany', NULL, 'Volunteer', NULL, 1, 1, '2025-11-06 03:36:05', 'CN6TN44hbI', '2025-11-22 16:12:08', '2025-11-22 16:12:08'),
(80, NULL, NULL, 'dereck.kuhlman@example.net', '$2y$12$qR4KS4sXdNj2mNl.iBUDAe1zLriTeQHWom3TYe8AWisS8O01bbkem', 'Felicita', 'Fritsch', '0930193143', NULL, 'Male', 'Hai Phong', 'West Briana', '9087 Becker Roads Suite 728\nCristbury, HI 86954', 'Volunteer', 'https://via.placeholder.com/200x200.png/004422?text=people+error', 1, 1, '2025-10-31 00:01:51', 'PSKU9kPrA3', '2025-11-22 16:12:08', '2025-11-22 16:12:08'),
(81, NULL, NULL, 'nmcdermott@example.org', '$2y$12$yfzbjJnUSYGg9Efoj7sySu7VEScxFGO/CQHrnpdRg2JF9wh1NvERa', 'Nola', 'Walter', NULL, NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0055dd?text=people+quia', 1, 1, '2025-11-16 06:01:50', 'dFqNUs8rD2', '2025-11-22 16:12:08', '2025-11-22 16:12:08'),
(82, NULL, NULL, 'nikolaus.casey@example.com', '$2y$12$TzTALmBwdP9n55RJFFJ/Yur9zZ5Cep.0KJTTqarJ4sKgd0.PfnLUC', 'Kirstin', 'Buckridge', '0917916330', NULL, 'Other', 'Da Nang', NULL, '6822 Christian Highway\nEast King, SD 89245-2555', 'Volunteer', NULL, 1, 1, '2025-11-20 09:20:53', 'm1od9QwQ3l', '2025-11-22 16:12:08', '2025-11-22 16:12:08'),
(83, NULL, NULL, 'watsica.blake@example.org', '$2y$12$bXsab4Y6xTaUplGy4BF0iOwhZMmCJAddmgUwDcQpCtxTOV5QDUM3.', 'Gertrude', 'Jacobs', '0950641879', NULL, 'Other', 'Can Tho', NULL, '206 Smith Villages\nNew Jordantown, VA 94286-7561', 'Volunteer', NULL, 1, 1, '2025-11-03 03:10:36', 'J6dI9X721v', '2025-11-22 16:12:09', '2025-11-22 16:12:09'),
(84, NULL, NULL, 'pward@example.net', '$2y$12$0hzipPY5tbP2UuisgiIHge0ocOa/hO6EN9/U96UgjiYyOuQeVNQf6', 'Tanya', 'West', '0930137622', NULL, 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0099ee?text=people+ut', 0, 1, '2025-11-13 17:17:57', '9FUOXDyXnt', '2025-11-22 16:12:09', '2025-11-22 16:12:09'),
(85, NULL, NULL, 'horacio35@example.com', '$2y$12$vOYQ.sBYvs5qvV/GkDxWdOvfG7EmZObFqLqp/w1uk90TNHBC35jYm', 'Kaylin', 'Murphy', NULL, NULL, 'Female', 'Hanoi', 'Reneeville', NULL, 'Volunteer', NULL, 1, 1, '2025-11-19 11:57:54', 'BWDmqxBCi4', '2025-11-22 16:12:09', '2025-11-22 16:12:09'),
(86, NULL, NULL, 'johnson.kaitlin@example.org', '$2y$12$H7DHashi6nZWoZKV4UjoHuiYYPcjK6dJ8zhEIzQaMFuSrtMrXsznS', 'Sterling', 'Sporer', '0907979922', NULL, 'Other', 'Hanoi', 'Hudsonmouth', NULL, 'Volunteer', NULL, 1, 1, NULL, 'hXRUEtiKK6', '2025-11-22 16:12:09', '2025-11-22 16:12:09'),
(87, NULL, NULL, 'luna.upton@example.net', '$2y$12$J/LBkGeSxEXx1jzZdLsUlO5KGjhNwWTBJkkiIGhxiwzX1h7/Gl6Nu', 'Erik', 'Nienow', NULL, NULL, 'Male', 'Hanoi', 'Hansenland', '41043 Kuphal Route\nPort Jaylenfurt, NJ 47847', 'Volunteer', NULL, 0, 1, NULL, 'dfafrt0Air', '2025-11-22 16:12:09', '2025-11-22 16:12:09'),
(88, NULL, NULL, 'vcorkery@example.org', '$2y$12$GqbRCcuTXGL11gAH9ujt5OzicysGR7tL7Ts6.CnMDv21zS2Bqw6Ou', 'Pearlie', 'Haley', NULL, '1981-10-16', 'Other', 'Can Tho', NULL, '59060 Schroeder Valleys\nLake Abdulfort, HI 51263', 'Volunteer', 'https://via.placeholder.com/200x200.png/008844?text=people+ut', 0, 1, NULL, 'KfAxaSZdXy', '2025-11-22 16:12:10', '2025-11-22 16:12:10'),
(89, NULL, NULL, 'khowell@example.com', '$2y$12$CZjKRoTDro8XtknIn6H0seOsEWW503hgiNHKeOtDOosDIzSWW6mYq', 'Ollie', 'Krajcik', '0915324932', NULL, 'Female', 'Hanoi', 'Coltonside', '41902 Lindsay Underpass Suite 390\nKautzerhaven, SD 20311', 'Volunteer', NULL, 1, 1, '2025-10-27 23:34:30', 'PJXV8i1sFK', '2025-11-22 16:12:10', '2025-11-22 16:12:10'),
(90, NULL, NULL, 'tjones@example.net', '$2y$12$mZ.ZXfEIL4uNl7xNE0pCs.XAkxR943AKWBgod1SDhXGco4tbT/Fyi', 'Robyn', 'Hamill', NULL, NULL, 'Male', 'Ho Chi Minh', 'Raymondtown', '693 Hane Pine\nSouth Verner, AZ 66219', 'Volunteer', NULL, 1, 1, NULL, '1PcWran4Hi', '2025-11-22 16:12:10', '2025-11-22 16:12:10'),
(91, NULL, NULL, 'ecassin@example.org', '$2y$12$1mPB0A2i1R/dFbRpWocTvO78vcZ/8A0Psw6hfkTKT7ZFeQ/CN91W.', 'Consuelo', 'Conn', NULL, NULL, 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddaa?text=people+et', 1, 1, NULL, '5r3njnnum0', '2025-11-22 16:12:10', '2025-11-22 16:12:10'),
(92, NULL, NULL, 'abernier@example.com', '$2y$12$tB5sOUG3VPrUh.aF5IyqyuFadR7pMTxsa3L18Rq.eHNK48Q.olCAe', 'Maynard', 'Kuhic', '0998729313', NULL, 'Female', 'Can Tho', 'Wildermanville', '8256 Fae Village\nPort Ianmouth, PA 29823', 'Volunteer', 'https://via.placeholder.com/200x200.png/001111?text=people+laudantium', 1, 1, '2025-11-22 00:34:54', 'I8guoCFJld', '2025-11-22 16:12:10', '2025-11-22 16:12:10'),
(93, NULL, NULL, 'zulauf.kip@example.org', '$2y$12$ZAWQEU3KaddacD1BYxvAHu8FD9zK8F2XJGwS/TKLFhXopQgFt48wO', 'Jaycee', 'Buckridge', NULL, NULL, 'Female', 'Hanoi', 'South Tatyanamouth', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ffff?text=people+in', 1, 1, '2025-10-31 16:52:59', 'RUafdDs76v', '2025-11-22 16:12:11', '2025-11-22 16:12:11'),
(94, NULL, NULL, 'alanis.orn@example.com', '$2y$12$Zs49eNoA7nh7nNzXdwWXGu6Ye9MowYge7Z4vMvI/X.F6fkFqjeW.G', 'Kailee', 'Denesik', NULL, NULL, 'Female', 'Hai Phong', 'Roobland', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aaaa?text=people+illum', 1, 1, NULL, 'OnWrrIZepm', '2025-11-22 16:12:11', '2025-11-22 16:12:11'),
(95, NULL, NULL, 'devante92@example.com', '$2y$12$Z3XeO.Fu0j2D9MSPfmVCrerMDwLIpMQzhUTQu4wF7T5Kzl4VfL7Ya', 'Victoria', 'Cronin', NULL, NULL, 'Female', 'Da Nang', 'Lake Haley', '7365 Kuhic Trafficway Apt. 103\nWest Generalhaven, WY 35718', 'Volunteer', NULL, 1, 1, '2025-11-16 19:50:01', 't68TYZyXes', '2025-11-22 16:12:11', '2025-11-22 16:12:11'),
(96, NULL, NULL, 'brielle90@example.net', '$2y$12$iKqkBJA8AMykZ8CDDYJlqurqvMtPDGtdiYD8LYTRmKkOY4XmQvJXe', 'Christian', 'Graham', NULL, NULL, 'Other', 'Can Tho', 'Willmsberg', '910 Kiley Mill Suite 441\nNew Tyrel, ND 92135', 'Volunteer', NULL, 0, 1, '2025-10-29 12:23:50', 'qGdL4Qq0SD', '2025-11-22 16:12:11', '2025-11-22 16:12:11'),
(97, NULL, NULL, 'kamille83@example.org', '$2y$12$nvHdYozuMi2GSzYEx8FuleqxY86oe34bAiWM8njiSC92JE1N2j.kS', 'Gordon', 'Powlowski', NULL, '1983-12-16', 'Other', 'Ho Chi Minh', 'Port Ethylport', '4118 Vaughn Burg\nWest Allyland, WV 90672', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff44?text=people+omnis', 0, 1, NULL, 'snqZsbXdhT', '2025-11-22 16:12:11', '2025-11-22 16:12:11'),
(98, NULL, NULL, 'mosciski.cara@example.net', '$2y$12$eYR9Fz3IA11VbzHkzRkkX.VKDlg3noUsml3hbyor/9aNjJ7lbtrpa', 'Baylee', 'Reilly', '0998502705', NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0099dd?text=people+quia', 0, 1, NULL, 'a3Tcw0Vnux', '2025-11-22 16:12:12', '2025-11-22 16:12:12'),
(99, NULL, NULL, 'lang.katherine@example.net', '$2y$12$tDCT9sNbYcaShmeI/nybY.ZUsSywdEb1X/HFIQgXDEQgIncApwkWK', 'Idell', 'DuBuque', NULL, '1970-10-09', 'Other', 'Can Tho', 'New Layne', NULL, 'Volunteer', NULL, 1, 1, '2025-10-30 16:27:35', 'lqyXBCEs7j', '2025-11-22 16:12:12', '2025-11-22 16:12:12'),
(100, NULL, NULL, 'reagan77@example.org', '$2y$12$6aFpSrO06Pi635kHn1EMu.9/i.JwHzPZL86rbtoXhNoXRVjlbJ/fO', 'Louie', 'Littel', '0902299775', NULL, 'Female', 'Ho Chi Minh', 'Satterfieldbury', '476 Harber Crest\nNew Victor, KY 79631', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa66?text=people+at', 0, 1, '2025-11-01 11:00:48', 'POh8giK8EU', '2025-11-22 16:12:12', '2025-11-22 16:12:12'),
(101, NULL, NULL, 'vesta.kuvalis@example.com', '$2y$12$NV6gbJyz5oAAqpKg3x6u2uqsjjEYDfXeC8wd1c1c5ie.eayMele/S', 'Darrell', 'Erdman', '0999826222', NULL, 'Female', 'Ho Chi Minh', NULL, '84986 Bobby Island Apt. 989\nPort Charlie, IA 47556-1218', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff00?text=people+aliquid', 0, 1, NULL, 'HU95aJXBG7', '2025-11-22 16:12:12', '2025-11-22 16:12:12'),
(102, NULL, NULL, 'colt.ohara@example.org', '$2y$12$TiJUSUvk2NzEhNzOh6aHwuWrsUeBqVpkHdRDNGXOacc3iluHcoexi', 'Cassidy', 'Bechtelar', '0986165815', '1993-04-14', 'Other', 'Hai Phong', 'West Robbie', '3680 Schmidt Port\nEast Bridieview, SD 52500-0736', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aacc?text=people+dolor', 1, 1, NULL, 'pgg5vFKETI', '2025-11-22 16:12:12', '2025-11-22 16:12:12'),
(103, NULL, NULL, 'jamarcus36@example.com', '$2y$12$Am5QZA6fp1t.z9xbttPiCesJ7coOFiZOGHpyXRqT/iElzjaJis.YG', 'Marjorie', 'Marvin', '0987544779', NULL, 'Female', 'Ho Chi Minh', NULL, '257 Khalid Oval\nGillianton, AK 33426-9914', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddaa?text=people+est', 0, 1, NULL, 'N4zdq1eosJ', '2025-11-22 16:12:13', '2025-11-22 16:12:13'),
(104, NULL, NULL, 'crist.zack@example.net', '$2y$12$D9YOjvoEeHdDCtzNxfYBJOKNfiVPEMgUJ2kIsMBcF7/qep3yrQDG.', 'Alejandra', 'Kunde', NULL, NULL, 'Male', 'Hanoi', 'Joeystad', '595 Schiller Trail\nDurganview, NY 33255', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+sequi', 1, 1, NULL, 'MCv9zADJxA', '2025-11-22 16:12:13', '2025-11-22 16:12:13'),
(105, NULL, NULL, 'aoconnell@example.net', '$2y$12$qMK1Q/AW/xKDbtKNIaL4EORHuEwf45pz.N3OhWj.Paw3RcC/1tPUq', 'Mallie', 'Schiller', '0988672947', NULL, 'Female', 'Ho Chi Minh', 'East Rickiefort', NULL, 'Volunteer', NULL, 1, 1, NULL, 'hnv3McKo02', '2025-11-22 16:12:13', '2025-11-22 16:12:13'),
(106, NULL, NULL, 'adrian37@example.com', '$2y$12$ytjlHokcqylZScGJofv1x.ECjGesAL2ivYT6qij41IECYdNLti8ji', 'Tanner', 'Hickle', NULL, NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-12 11:58:55', 'ocJxF30HGB', '2025-11-22 16:12:13', '2025-11-22 16:12:13'),
(107, NULL, NULL, 'lleuschke@example.net', '$2y$12$9YeY2AWWTlDLvAj46EmC1uA2ve/01Ed4FCuYJAyyN2ttoGnanv02q', 'Raoul', 'Jerde', '0909918959', NULL, 'Male', 'Da Nang', 'Gregoryton', '97567 Doyle Key\nNorth Eladiobury, NJ 29454-1203', 'Volunteer', NULL, 1, 1, NULL, 'iYR2WJcwWH', '2025-11-22 16:12:13', '2025-11-22 16:12:13'),
(108, NULL, NULL, 'angelica.zulauf@example.com', '$2y$12$42l9sf.DPmvqikDF8spej.v9H/5NbDPu02ZBH/cc2VY1TJ0WujzUK', 'Roosevelt', 'Kerluke', NULL, NULL, 'Male', 'Can Tho', NULL, '629 Brakus Locks\nPort Austyn, ND 58183-8644', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddbb?text=people+et', 0, 1, '2025-11-17 02:19:08', 'hBwWlOCdRK', '2025-11-22 16:12:14', '2025-11-22 16:12:14'),
(109, NULL, NULL, 'jhayes@example.net', '$2y$12$xnFk8yus7E6C24L5wTzrkeYHSw9729aVbsqBKjgNhjwU1.L2NICCS', 'Margret', 'Torphy', NULL, '2005-07-23', 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0055cc?text=people+consequatur', 1, 1, '2025-11-11 20:18:45', 'dxv2Z1ALFw', '2025-11-22 16:12:14', '2025-11-22 16:12:14'),
(110, NULL, NULL, 'yoshiko.fahey@example.net', '$2y$12$U35NsqPL8muXQp8eGpeFKuUAVCwy2qE1OfME4Ze952PH7yrR/r8di', 'Barbara', 'Reynolds', '0991861143', NULL, 'Other', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-21 00:03:56', 'TYuKFaYyA9', '2025-11-22 16:12:14', '2025-11-22 16:12:14'),
(111, NULL, NULL, 'rhianna42@example.org', '$2y$12$U9QddYSMiaVl3/SQC1OU6e/crFP5tonuKoVaCPesXKRXZnxEab5TS', 'Amiya', 'Schmeler', NULL, NULL, 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0055cc?text=people+quis', 1, 1, NULL, 'h5pAJar33m', '2025-11-22 16:12:14', '2025-11-22 16:12:14'),
(112, NULL, NULL, 'santino.spencer@example.com', '$2y$12$n5Yagip/mKeGPJZoG0R1OOjyN0KGkoytkm61Jgf6YxRZaHyzBEe5.', 'Amie', 'Schmitt', NULL, NULL, 'Male', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-17 00:40:01', 'GYhakYtJMW', '2025-11-22 16:12:14', '2025-11-22 16:12:14'),
(113, NULL, NULL, 'rleannon@example.org', '$2y$12$TVtt5MTMzpFVQMpXwtfBdeSysPhQGHvVFRI7WpPXo8ZL6PHf09MJa', 'Ryan', 'Lubowitz', NULL, '1998-06-21', 'Male', 'Can Tho', 'Kreigerfurt', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/007733?text=people+laborum', 0, 1, NULL, 'b7YRFRPxLg', '2025-11-22 16:12:15', '2025-11-22 16:12:15'),
(114, NULL, NULL, 'brenna.batz@example.net', '$2y$12$5GpIscAqCHduqfFqcuVckuNtow.FRTOxQxJUDrdk0WYosR5xx3ejy', 'Camila', 'Gibson', '0945017572', '1981-12-04', 'Other', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0044dd?text=people+architecto', 1, 1, '2025-10-28 23:25:19', 'NUh0DDjia2', '2025-11-22 16:12:15', '2025-11-22 16:12:15'),
(115, NULL, NULL, 'bradford15@example.com', '$2y$12$uayfMB9rnoHeZeUifW.7he0WmEYtiPydQ0BZGsRIY6etpQn16hAlO', 'Curt', 'Kerluke', NULL, '1970-02-12', 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/004455?text=people+tenetur', 1, 1, '2025-11-04 07:45:05', 'KUMagMq6z4', '2025-11-22 16:12:15', '2025-11-22 16:12:15'),
(116, NULL, NULL, 'gkessler@example.com', '$2y$12$aGPub4ZtEOQpKYQcajK9muKCBxGSUtK7zlHlzB/bcXoczL7XlIKy2', 'Dominic', 'Buckridge', NULL, '1978-04-08', 'Female', 'Can Tho', 'Gulgowskiside', NULL, 'Volunteer', NULL, 1, 1, NULL, 'qNsV5DzUIr', '2025-11-22 16:12:15', '2025-11-22 16:12:15'),
(117, NULL, NULL, 'ahmed32@example.com', '$2y$12$rAcPBM.KsTTApiSx6DZELu5fDTawC/9ZhAwlnl51BB/oLAaT4DcAW', 'Birdie', 'Bailey', NULL, NULL, 'Male', 'Ho Chi Minh', 'South Mustafahaven', NULL, 'Volunteer', NULL, 0, 1, '2025-11-15 23:05:53', 'nwmnTdNxGi', '2025-11-22 16:12:15', '2025-11-22 16:12:15'),
(118, NULL, NULL, 'xoconner@example.net', '$2y$12$kjRyer9jQ8veyyZao4tD8.Qe.auKNNvd7uBmTxc.IImqQqxuhm02C', 'Hayley', 'Nikolaus', NULL, '2000-05-08', 'Other', 'Ho Chi Minh', NULL, '27017 Abernathy Burg Apt. 109\nNew Claudie, UT 02437', 'Volunteer', 'https://via.placeholder.com/200x200.png/00eedd?text=people+enim', 0, 1, '2025-11-11 01:32:30', 'KfzEnR64Cd', '2025-11-22 16:12:16', '2025-11-22 16:12:16'),
(119, NULL, NULL, 'carson.berge@example.org', '$2y$12$HYrJveUOg7mumwjv9GT.uOvFtIgSqm0ewsgrQe3o/r4BeoG9/Q5ie', 'Ricardo', 'Rau', NULL, NULL, 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002266?text=people+dolorem', 0, 1, NULL, 'prprO7PfaS', '2025-11-22 16:12:16', '2025-11-22 16:12:16'),
(120, NULL, NULL, 'diamond01@example.org', '$2y$12$0WHcKqBGdmugl0OXJZkoAuBbT1PN2Pjljg3uuw6I8mZ2u8O/ARFjW', 'Ressie', 'Koelpin', '0943564725', NULL, 'Male', 'Hai Phong', 'Sipesville', NULL, 'Volunteer', NULL, 0, 1, NULL, 'gOia7AxTNi', '2025-11-22 16:12:16', '2025-11-22 16:12:16'),
(121, NULL, NULL, 'claudie54@example.com', '$2y$12$lfttVmzBscjn3Tl1T0No5.nJ/KyGn1UIC6w2/zR.TQ3uUXqUcJzaa', 'Jarret', 'Leffler', '0919622284', NULL, 'Other', 'Ho Chi Minh', 'East Evanston', '7602 Blake Corners Apt. 970\nJoneschester, NE 18717', 'Organization', 'https://via.placeholder.com/200x200.png/00ccaa?text=people+id', 1, 1, NULL, '2lMDq0AZLL', '2025-11-22 16:12:16', '2025-11-22 16:12:16'),
(122, NULL, NULL, 'shannon58@example.com', '$2y$12$qKHzbTPxtp5gb.oiIPhVXe31yJeSCCcHFNd31C/hmI2k7dxF9YmfC', 'Emery', 'Fisher', NULL, NULL, 'Other', 'Ho Chi Minh', NULL, '72277 Prohaska Dam Apt. 521\nOmariburgh, VT 86568-7492', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000ff?text=people+aut', 1, 1, NULL, '8iWxZMUIyp', '2025-11-22 16:12:17', '2025-11-22 16:12:17'),
(123, NULL, NULL, 'dessie.schaden@example.com', '$2y$12$ZzGaG8UnwCbhsbMLGaN/I.eDDv23/ufpHOnOQVbKKrjd7CsAfcu1C', 'Edmund', 'Kozey', '0952710721', NULL, 'Other', 'Hai Phong', 'Lueilwitzview', '7811 Ortiz Center Suite 628\nGissellestad, MI 75640-5595', 'Volunteer', 'https://via.placeholder.com/200x200.png/008866?text=people+quos', 1, 1, NULL, 'OmSLKQQ1YL', '2025-11-22 16:12:17', '2025-11-22 16:12:17'),
(124, NULL, NULL, 'bernie.hauck@example.org', '$2y$12$pRBfVtbGk2Fgdc6Imoi9A.f5TMcasdLL4yBnPjLqSz0oJFxzH4P9i', 'Harry', 'Macejkovic', '0973663748', '1983-05-06', 'Other', 'Da Nang', 'Reaganberg', '3930 Dejon Ville Suite 695\nNorth Ernesttown, RI 83620-3797', 'Volunteer', NULL, 1, 1, '2025-11-11 02:22:31', 'r1FvbqdNgQ', '2025-11-22 16:12:17', '2025-11-22 16:12:17'),
(125, NULL, NULL, 'haylee.lang@example.org', '$2y$12$EC3p3TdclQyrYiRkk4Tm2uuH2A5lvl6wMKs//x2HmzSVCu1AoQTMS', 'Lempi', 'Buckridge', NULL, NULL, 'Female', 'Ho Chi Minh', 'North Charlottehaven', '9301 Penelope Shoals\nWest Shakiraville, VA 11633-7929', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aacc?text=people+consequatur', 1, 1, NULL, 'qSC8eLsw65', '2025-11-22 16:12:17', '2025-11-22 16:12:17'),
(126, NULL, NULL, 'piper90@example.org', '$2y$12$kCInvYClLfozSfxKBpBSxesLHsWKG3c27IqQt/0HRL/GK.6dGsnca', 'Eldridge', 'Donnelly', '0917243184', NULL, 'Other', 'Ho Chi Minh', 'Aminashire', '8173 Frederick Locks\nWest Harryborough, AK 24234', 'Volunteer', NULL, 0, 1, '2025-11-15 18:05:27', 'tJdtKrAylY', '2025-11-22 16:12:17', '2025-11-22 16:12:17'),
(127, NULL, NULL, 'darby.graham@example.com', '$2y$12$LCzKNq565P8TxQnfGL/Kque/oivZrQ.Gf6d03Kh1erGDobqpPjWri', 'Marshall', 'Haley', NULL, NULL, 'Other', 'Ho Chi Minh', 'Port Penelope', '16757 Kiehn Spurs Apt. 549\nNew Marlene, TX 21051-8268', 'Volunteer', NULL, 0, 1, '2025-10-26 15:16:32', 'YoY90Quw1v', '2025-11-22 16:12:18', '2025-11-22 16:12:18'),
(128, NULL, NULL, 'norma86@example.org', '$2y$12$fFanQ8/FuIoQgAa7dVEM4uUpR2d1XR8VaSWbIZH9/CGZo1C7v0KTu', 'May', 'Russel', NULL, '1980-04-04', 'Male', 'Hai Phong', NULL, '810 Felix Expressway Apt. 512\nWest Eliza, MA 56938', 'Volunteer', 'https://via.placeholder.com/200x200.png/0088ff?text=people+mollitia', 1, 1, '2025-10-30 21:53:14', 'D4u4bq1qvd', '2025-11-22 16:12:18', '2025-11-22 16:12:18'),
(129, NULL, NULL, 'neha.green@example.org', '$2y$12$YWtoi.wf0MFleNY.74ajF.5/tU24a.Nta5nCL9NK70krs1dWM97ju', 'Armani', 'Beatty', '0936459115', NULL, 'Other', 'Da Nang', 'North Lurlineberg', '71226 Frami Mission Apt. 353\nLake Albinatown, ME 56532-8590', 'Volunteer', NULL, 1, 1, NULL, 'AciTRfMQd7', '2025-11-22 16:12:18', '2025-11-22 16:12:18'),
(130, NULL, NULL, 'lucas.nitzsche@example.org', '$2y$12$xqmWbotPzJU.7RUcT3zHCepzsHAN7DUyVDDFo1XJ1WDSBdkRN6JWO', 'Jaylen', 'Gerlach', '0956345437', '2003-05-05', 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-10-28 11:16:39', 'wGEF1AgGZR', '2025-11-22 16:12:18', '2025-11-22 16:12:18'),
(131, NULL, NULL, 'kovacek.molly@example.net', '$2y$12$ahffIpEnTBIbLeijPtzhjudtLdygSoUdsgQ5xqp0con387ATA/d/O', 'Davion', 'Yost', NULL, '1992-03-08', 'Male', 'Hai Phong', NULL, '836 Fay Junctions\nNew Halle, AR 82321', 'Volunteer', 'https://via.placeholder.com/200x200.png/0077bb?text=people+animi', 1, 1, '2025-11-16 08:28:56', '5BmKN7rpl9', '2025-11-22 16:12:18', '2025-11-22 16:12:18'),
(132, NULL, NULL, 'asha.blanda@example.com', '$2y$12$M9o.jlH4IC2Q.TiRZiLHE.ctHT48gJq5hIrvaAyqewLK55V2ECg.K', 'Reymundo', 'Konopelski', '0972880695', NULL, 'Male', 'Da Nang', 'Lake Andreanneville', '19817 Roob Mills\nAngelinaville, DC 99479', 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc00?text=people+quo', 1, 1, NULL, '5TxNFUc3g1', '2025-11-22 16:12:18', '2025-11-22 16:12:18'),
(133, NULL, NULL, 'feeney.angelina@example.com', '$2y$12$0UGrpQuET4OWSwWBD04WZO7BZJaHzOODProS8pCWxCrMnPhX0aNEW', 'Sidney', 'Weissnat', NULL, NULL, 'Male', 'Hai Phong', 'Kaileyton', '527 Tia Mountains\nLindgrenview, NC 84733-7775', 'Volunteer', NULL, 1, 1, '2025-11-21 02:51:20', 'sLspbAx3q8', '2025-11-22 16:12:19', '2025-11-22 16:12:19'),
(134, NULL, NULL, 'maximus.fahey@example.net', '$2y$12$758x6JFNlCDNs/0GycpUGuUUwmlkkbmC7emQRUWrbfiupKbHOTboi', 'Jorge', 'Leffler', '0934187800', '1993-09-10', 'Other', 'Da Nang', 'Chesterborough', '965 Lowe Stravenue\nEast Orloburgh, HI 27257-5935', 'Volunteer', NULL, 0, 1, '2025-11-19 01:12:43', 'MGHYMKoHXG', '2025-11-22 16:12:19', '2025-11-22 16:12:19'),
(135, NULL, NULL, 'rice.hyman@example.org', '$2y$12$Uz3CItUlgC9iKVH1WLJofekotlcuBXQXTU/UU5HWvyFGj5RxyBdk2', 'Amina', 'Olson', NULL, '1970-04-01', 'Other', 'Da Nang', NULL, '229 O\'Reilly Burgs\nKesslerville, IA 50622', 'Volunteer', NULL, 0, 1, NULL, 'ouuMIFzghF', '2025-11-22 16:12:19', '2025-11-22 16:12:19'),
(136, NULL, NULL, 'nayeli.kiehn@example.com', '$2y$12$2ulHJE819l3iHJ7Kh.blX.KQ4uwa/Lm6KooSgXc7clhO54WE735bW', 'Gisselle', 'Kulas', '0921042371', NULL, 'Female', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'E86rsThOuo', '2025-11-22 16:12:19', '2025-11-22 16:12:19'),
(137, NULL, NULL, 'orn.benny@example.com', '$2y$12$qgAtcGiNHyarbK/9q0ZCjekVVR8I/mfXPXxCuJDmwHxXfxVSdx6OW', 'Delpha', 'Crona', '0988435016', '1966-06-30', 'Male', 'Ho Chi Minh', 'New Clarestad', '115 VonRueden Avenue\nThompsonton, AZ 31894-3420', 'Volunteer', NULL, 1, 1, NULL, 'LfNPeLz9gU', '2025-11-22 16:12:19', '2025-11-22 16:12:19'),
(138, NULL, NULL, 'wbogan@example.org', '$2y$12$yhzeV1lMAXQG/o5JrjYrN.OaL8e686x9IBJZRY4ndukH5qTDjjOi6', 'Darryl', 'Berge', '0924823911', NULL, 'Other', 'Ho Chi Minh', 'Baumbachtown', '715 Waldo Field Suite 963\nNew Maiyaview, HI 21092-5911', 'Volunteer', NULL, 1, 1, '2025-11-13 09:57:34', 'UVj0Xro7zK', '2025-11-22 16:12:20', '2025-11-22 16:12:20'),
(139, NULL, NULL, 'kaylah85@example.net', '$2y$12$XUtRhtjdAlT4c6A9Wu5fT.XKdfxXadgwI8lPnHyDQBwKqtU0Sc2c6', 'Hollie', 'Bernier', '0939580300', NULL, 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'JiSUhlMKlD', '2025-11-22 16:12:20', '2025-11-22 16:12:20'),
(140, NULL, NULL, 'eweber@example.com', '$2y$12$d25cCWvH4zRQcoNt/YUeYuPX/rmdm2Ow.1dZtrg2pVnCznMLczCKy', 'Reggie', 'Weimann', NULL, NULL, 'Other', 'Can Tho', NULL, '21035 Shayna Spurs\nWest Nicholausbury, CT 13925-8933', 'Volunteer', 'https://via.placeholder.com/200x200.png/008822?text=people+atque', 1, 1, NULL, 'koybeQ9eGG', '2025-11-22 16:12:20', '2025-11-22 16:12:20'),
(141, NULL, NULL, 'demmerich@example.net', '$2y$12$WIXK.iSC/9fuKdu5mDUuQerqkyq0wAjAXTDYmvkCk8vh211.hLhEC', 'Rhianna', 'Hudson', NULL, '1979-10-23', 'Female', 'Can Tho', NULL, '29142 Clark Burgs\nLake Laron, UT 64827-3045', 'Volunteer', 'https://via.placeholder.com/200x200.png/005566?text=people+recusandae', 1, 1, NULL, 'HtqAsM1j72', '2025-11-22 16:12:20', '2025-11-22 16:12:20'),
(142, NULL, NULL, 'pswift@example.net', '$2y$12$4MxAOO9DT387tptBCu9nauVaq9qjqHPvNET8vhhfNeV.Fy0cPuaKy', 'Samara', 'Osinski', '0945744937', NULL, 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0044ee?text=people+omnis', 1, 1, NULL, '0ZQrEHY8jb', '2025-11-22 16:12:20', '2025-11-22 16:12:20'),
(143, NULL, NULL, 'amelia10@example.com', '$2y$12$0jtPAUw/tCea0d2plI2PdekErjuf5oTPYvRMhbDUmjJfB3jgu1.UG', 'Mabelle', 'Reilly', NULL, '1996-02-19', 'Male', 'Can Tho', 'New Dena', NULL, 'Volunteer', NULL, 0, 1, '2025-11-09 20:33:20', 'tVUJXxyoQ0', '2025-11-22 16:12:21', '2025-11-22 16:12:21'),
(144, NULL, NULL, 'heather79@example.net', '$2y$12$RUYPK.3B8UgCVRkjGEBB2.M2V/UODwHZLTttltWFpx1/DQoF.M1V6', 'Sidney', 'Koss', NULL, NULL, 'Male', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-12 20:43:13', 'YQP740kPKl', '2025-11-22 16:12:21', '2025-11-22 16:12:21'),
(145, NULL, NULL, 'vskiles@example.net', '$2y$12$8nDmuA98.04ROkVfmWcnvOba0Yqdr5sRnZ/VaTVeC85EPz88kNkou', 'Megane', 'Kautzer', '0986738830', '1994-08-30', 'Other', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008833?text=people+reiciendis', 1, 1, '2025-11-02 06:08:50', 'p3xEPjZY2n', '2025-11-22 16:12:21', '2025-11-22 16:12:21'),
(146, NULL, NULL, 'gerhold.mercedes@example.com', '$2y$12$d07.AvtsEe7xv0VXHzVx4OuAv73NoEK9pZP1oaMHfBk4QJsgXoD.u', 'Justen', 'Rowe', NULL, '1976-05-02', 'Other', 'Can Tho', 'West Jamarcusfort', '191 Elmira Road Suite 346\nChadrickmouth, OR 91341', 'Volunteer', NULL, 1, 1, NULL, 'Ve5yppiWSf', '2025-11-22 16:12:21', '2025-11-22 16:12:21');
INSERT INTO `users` (`user_id`, `google_id`, `facebook_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `date_of_birth`, `gender`, `city`, `district`, `address`, `user_type`, `avatar_url`, `is_verified`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(147, NULL, NULL, 'nokuneva@example.org', '$2y$12$nf6YrS1D6k7s//eAZqhsme51mSMENAuw7FzSEifC.TxYT/vD3uWG2', 'Josianne', 'Okuneva', '0948156911', '1967-01-02', 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-20 00:27:23', 'pdR65ZbYBO', '2025-11-22 16:12:21', '2025-11-22 16:12:21'),
(148, NULL, NULL, 'isac76@example.org', '$2y$12$GzcGeYbHaLD68z.1ESKcRO7GskfwV7QJvt/fku3MFRoW8OHSVKKOO', 'Bernardo', 'Berge', '0951899902', '2006-07-19', 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd55?text=people+facilis', 1, 1, NULL, '3YniEtA6D7', '2025-11-22 16:12:22', '2025-11-22 16:12:22'),
(149, NULL, NULL, 'darrell.connelly@example.org', '$2y$12$vLYxzoctEs7O/5rbmRCQIuMMAfPoRO3HprYXFBqQqF1VnapNStrs.', 'Minnie', 'Muller', '0908384880', NULL, 'Male', 'Ho Chi Minh', 'Lake Susanna', '481 Karley View Apt. 862\nZacharyberg, IA 19999-1870', 'Volunteer', 'https://via.placeholder.com/200x200.png/0099cc?text=people+perspiciatis', 0, 1, '2025-11-02 10:32:22', '90tHJjd844', '2025-11-22 16:12:22', '2025-11-22 16:12:22'),
(150, NULL, NULL, 'dtillman@example.org', '$2y$12$FtNHoh59XLJcmDb4FEk4qen.fxxiCL9U9d6.JO87iXisx68wJNO8u', 'Leta', 'White', '0937684537', '2005-06-11', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005500?text=people+molestias', 1, 1, '2025-11-14 00:02:29', 'YufxhXOrmQ', '2025-11-22 16:12:22', '2025-11-22 16:12:22'),
(151, NULL, NULL, 'josefa.torphy@example.net', '$2y$12$q6PIhvzQjEK0GWfOdmdKq.qBR3xv7pIJnXEaLZa7VnL8s.0EPrPQ6', 'Tabitha', 'Schamberger', '0919936727', '1983-08-10', 'Other', 'Can Tho', 'Port Amie', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005522?text=people+saepe', 1, 1, '2025-11-15 11:01:42', 'yRUhM6vitB', '2025-11-22 16:12:22', '2025-11-22 16:12:22'),
(152, NULL, NULL, 'grady29@example.net', '$2y$12$/GsSx7UckddWTOgbl2xsLuCo6SUw3zmIVj9QxFyqocyuEJTorj2dS', 'Muriel', 'Jaskolski', '0972740896', NULL, 'Other', 'Da Nang', NULL, '29432 White Flat\nPort Roseview, WV 83584', 'Volunteer', 'https://via.placeholder.com/200x200.png/006699?text=people+dolore', 1, 1, NULL, '7AKWMQ1CjE', '2025-11-22 16:12:22', '2025-11-22 16:12:22'),
(153, NULL, NULL, 'kcronin@example.net', '$2y$12$bHNPI6yrUXHQE3CshqdFW.yZeXvANuAkrCOGMyKMr1QL8gaAfa6jy', 'Lavina', 'Osinski', '0911525109', NULL, 'Male', 'Can Tho', 'Pricehaven', '720 Melany Vista Suite 835\nMarquesburgh, NV 90034', 'Volunteer', 'https://via.placeholder.com/200x200.png/0033dd?text=people+amet', 1, 1, '2025-11-09 21:48:02', 'rfEL1gopPH', '2025-11-22 16:12:23', '2025-11-22 16:12:23'),
(154, NULL, NULL, 'uschaefer@example.net', '$2y$12$nwy7lOH9cN0zx1DXdq234Ojl0LxgllX2u3ujerqPDWXFQdAEvsjM6', 'Kadin', 'Herzog', '0915364969', NULL, 'Other', 'Hai Phong', NULL, '95697 Daisha Groves Suite 248\nSouth Brionnaview, TX 88044', 'Volunteer', 'https://via.placeholder.com/200x200.png/007799?text=people+libero', 1, 1, '2025-11-04 23:23:59', 'M8XF1wLmVa', '2025-11-22 16:12:23', '2025-11-22 16:12:23'),
(155, NULL, NULL, 'glennie.boyer@example.com', '$2y$12$0fKr8LmZowr/zUNv/7J/pOoFfdJVJhK/clM5FNpzj9jvH/o7LuvbK', 'Daisha', 'Bosco', '0964551194', '1978-02-28', 'Male', 'Ho Chi Minh', 'New Jazmin', '66856 Roob Ports Suite 006\nBoylefort, MN 95389', 'Volunteer', NULL, 1, 1, '2025-11-20 12:17:35', 'my286C4E0k', '2025-11-22 16:12:23', '2025-11-22 16:12:23'),
(156, NULL, NULL, 'pboyer@example.com', '$2y$12$HjQBitrQOwCZA0Ufp0JVuuxVLGVE7Ydg8wPz3WwGsXGfzPsBqdjXO', 'Jerrell', 'Wunsch', '0943183137', NULL, 'Male', 'Hanoi', 'Doyleberg', NULL, 'Volunteer', NULL, 1, 1, '2025-10-27 02:08:59', 'WCVx8mG9oJ', '2025-11-22 16:12:23', '2025-11-22 16:12:23'),
(157, NULL, NULL, 'xebert@example.net', '$2y$12$SXI2X77SNN.eZfAE7sgYPuVpKxZERqPh4Dl7NTVQqpSEFViN.xtEe', 'Heath', 'Bechtelar', '0983157874', NULL, 'Male', 'Hanoi', 'Nashport', '367 Derick Prairie Suite 644\nPort Rileyfurt, SD 86576-8156', 'Organization', NULL, 1, 1, '2025-10-28 21:07:01', 'sXCN4lzCa5', '2025-11-22 16:12:24', '2025-11-22 16:12:24'),
(158, NULL, NULL, 'brant58@example.net', '$2y$12$b96he3cbmnnO5WUEPNb5DulGkE78HNEKIrRZSTJ2OMHKSmsNW3A2e', 'Clementina', 'Lehner', NULL, '1993-11-29', 'Female', 'Hai Phong', NULL, '1443 Jasen Junctions Suite 261\nPort Jadabury, UT 25686-4866', 'Volunteer', 'https://via.placeholder.com/200x200.png/0033bb?text=people+hic', 1, 1, NULL, 'dFif5kIzbc', '2025-11-22 16:12:24', '2025-11-22 16:12:24'),
(159, NULL, NULL, 'adoyle@example.net', '$2y$12$0padMcOF0APka0GDl3Yi4upuRddm1OVnK9jVFUeXchpjJh0lc45Ju', 'Clair', 'Wuckert', '0903072537', NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005511?text=people+sed', 1, 1, NULL, 'DLSpq2CZa8', '2025-11-22 16:12:24', '2025-11-22 16:12:24'),
(160, NULL, NULL, 'metz.jackeline@example.com', '$2y$12$be5iYzyqs0Silq7kdS4b3.9RRCxgnhxYj45u23XO1UzxEctkEHn/y', 'Maybell', 'Towne', '0948161182', '1973-04-13', 'Male', 'Ho Chi Minh', 'Koelpinfort', '8375 Amira River\nLeolamouth, OR 74727', 'Volunteer', 'https://via.placeholder.com/200x200.png/0011ee?text=people+facilis', 0, 1, NULL, 'R7AtBxCjk6', '2025-11-22 16:12:24', '2025-11-22 16:12:24'),
(161, NULL, NULL, 'gertrude43@example.org', '$2y$12$ZqJfZfHInq29gXjcOHyeKO5ihcQpmXyZdPwPAHY13vmsVO8C3K2Di', 'Bert', 'Smith', NULL, '1971-06-14', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'XWt6Cvag4T', '2025-11-22 16:12:24', '2025-11-22 16:12:24'),
(162, NULL, NULL, 'elmore94@example.com', '$2y$12$3btXANLGkn2L0s2vaw9tN.ZAdkFCll4nBiV5hBzhj75Gwn3Vnqtt6', 'Kaitlin', 'Bartoletti', '0950610734', '1992-11-07', 'Female', 'Can Tho', 'Port Kaitlin', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc33?text=people+officiis', 0, 1, '2025-11-07 19:34:31', 'JjX7DJIin3', '2025-11-22 16:12:25', '2025-11-22 16:12:25'),
(163, NULL, NULL, 'marilie.raynor@example.net', '$2y$12$xXqlRjbs2dAbx9jrD.FWOe..II.uVVzs34M4sZC0DIp3hnwJVAI0K', 'Federico', 'Connelly', NULL, NULL, 'Female', 'Can Tho', 'Zionchester', '719 Ruecker Landing\nOrnshire, OK 07649-8058', 'Volunteer', NULL, 0, 1, '2025-11-15 21:09:56', 'INxKrSebTQ', '2025-11-22 16:12:25', '2025-11-22 16:12:25'),
(164, NULL, NULL, 'hulda66@example.com', '$2y$12$ElRXNtSeGJhrOY3tXxnj0.DaUke7i/5tv21ex4qEuve234KkptuMe', 'Patrick', 'Hyatt', '0952294243', NULL, 'Male', 'Can Tho', 'Melbaborough', '25949 Morar Plains Apt. 496\nJovannyborough, RI 98699-2079', 'Volunteer', 'https://via.placeholder.com/200x200.png/0099ff?text=people+blanditiis', 1, 1, '2025-11-06 21:18:12', 'JbWTdonhV4', '2025-11-22 16:12:25', '2025-11-22 16:12:25'),
(165, NULL, NULL, 'madisyn.jones@example.com', '$2y$12$PQtNTt1N95SQegDXMkdhCuzvrCwqlUSNJQVM6YRxyNzZ8LZiYqB.q', 'Amani', 'Stoltenberg', NULL, NULL, 'Other', 'Hanoi', 'Jazlynside', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000033?text=people+quae', 1, 1, NULL, 'EIUsR3QQ7E', '2025-11-22 16:12:25', '2025-11-22 16:12:25'),
(166, NULL, NULL, 'fgerlach@example.org', '$2y$12$kym6501dWDRniEYH5kC5Ruyu/VdQ6U3WWG.oy6Fn8KQe46wuQXPUq', 'Marilou', 'Jones', '0998426422', NULL, 'Female', 'Da Nang', 'South Benton', NULL, 'Volunteer', NULL, 1, 1, '2025-11-03 21:09:59', 'pIKC2Vo97F', '2025-11-22 16:12:25', '2025-11-22 16:12:25'),
(167, NULL, NULL, 'ruben.schinner@example.net', '$2y$12$jWdkNGpRMOoHGmVoCpmTk.L.bEB0SDp3iwU5hjc2mJ2IZchJ4o.XC', 'Daija', 'Von', NULL, '1989-06-12', 'Female', 'Ho Chi Minh', NULL, '91935 Gust Plains Suite 267\nEast Rasheedburgh, IA 99933-3952', 'Volunteer', 'https://via.placeholder.com/200x200.png/005522?text=people+soluta', 0, 1, '2025-11-22 00:57:44', 'zsydiSRg57', '2025-11-22 16:12:26', '2025-11-22 16:12:26'),
(168, NULL, NULL, 'fledner@example.org', '$2y$12$Hra8uXOBW1ljPBezd8ObgeQkXk6HeDkJv9TNQLTY7Fji30ECgM1jm', 'Magdalena', 'Keebler', '0929904057', '2004-05-22', 'Other', 'Da Nang', 'Terrychester', NULL, 'Volunteer', NULL, 1, 1, '2025-11-14 15:34:23', 'v63bdPR7YI', '2025-11-22 16:12:26', '2025-11-22 16:12:26'),
(169, NULL, NULL, 'gardner.krajcik@example.com', '$2y$12$/q0p//.iVlWDDn0HICD49e.z7yPbOei4wu5Vopos.i299cwkza5vW', 'Mavis', 'D\'Amore', '0946086155', '1974-04-04', 'Other', 'Hanoi', 'Leschside', NULL, 'Volunteer', NULL, 1, 1, NULL, 'Aix9nAEYdF', '2025-11-22 16:12:26', '2025-11-22 16:12:26'),
(170, NULL, NULL, 'heathcote.cortney@example.net', '$2y$12$bEbTXauHo/qZEEsCzONn/uwXZphADd0T36f2gNV2zoadJAXnb.oZS', 'Bethany', 'Baumbach', NULL, NULL, 'Other', 'Hai Phong', 'Port Mckennabury', '187 Bartoletti Loop\nWest Georgette, NV 68265', 'Volunteer', NULL, 1, 1, '2025-11-02 09:16:08', 'ehKg853h4g', '2025-11-22 16:12:26', '2025-11-22 16:12:26'),
(171, NULL, NULL, 'lokon@example.com', '$2y$12$fr4JDlcIiMVYt0nqaS0ohO/sQ4WERn6ThDm8T5dWY683ppWl/25GW', 'Raina', 'Herman', '0964132768', NULL, 'Male', 'Ho Chi Minh', 'South Joy', '664 Serenity Road\nBoganburgh, NV 85078', 'Volunteer', 'https://via.placeholder.com/200x200.png/0022aa?text=people+temporibus', 0, 1, NULL, 'ywpctCpaiK', '2025-11-22 16:12:26', '2025-11-22 16:12:26'),
(172, NULL, NULL, 'roger33@example.net', '$2y$12$Q5w618yKNQEVR1eT6cfbLeV2GSy/tvpe3mjxKP6SSV/UA0TfyJjgG', 'Nickolas', 'Rice', '0935881512', '1987-01-18', 'Female', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0066ee?text=people+asperiores', 0, 1, '2025-10-25 01:23:28', 'DQN8axjoT5', '2025-11-22 16:12:27', '2025-11-22 16:12:27'),
(173, NULL, NULL, 'alyce.koepp@example.net', '$2y$12$bZqQSY3CrOs/RE9EqRRWI.sUGOIYCgBlRwrURXv7qrxPqQvuNIvm2', 'Matilde', 'DuBuque', '0923609864', NULL, 'Female', 'Can Tho', 'Jarenside', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/003355?text=people+quod', 1, 1, NULL, 'NysiTjztQL', '2025-11-22 16:12:27', '2025-11-22 16:12:27'),
(174, NULL, NULL, 'anastacio38@example.com', '$2y$12$VjJ2kAvfeQz80BjaulujRea26pmC.JdFZP.LQbG9pEZ.1a.BTYdoS', 'Ernestina', 'Russel', NULL, NULL, 'Male', 'Da Nang', NULL, '50340 Ward Ports Apt. 088\nLake Justus, NH 89462', 'Volunteer', NULL, 1, 1, '2025-10-31 10:36:29', 'x1kY5E1hr8', '2025-11-22 16:12:27', '2025-11-22 16:12:27'),
(175, NULL, NULL, 'zane38@example.com', '$2y$12$BaDkwbgVN6jRTCXtaxxaAusEEiTavPdfy.jNxAx9scCDqf7PnCtKi', 'Jerod', 'Braun', NULL, NULL, 'Other', 'Hanoi', 'Stevehaven', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff88?text=people+sequi', 1, 1, '2025-10-30 18:43:55', 'cQYYvI2Y3H', '2025-11-22 16:12:27', '2025-11-22 16:12:27'),
(176, NULL, NULL, 'micaela.dicki@example.net', '$2y$12$guRpY5/WXC/wC8m6X5VaeeR6P3itKh5.IFXBlzbV6UKJE/VNDe.WK', 'Virgie', 'Nitzsche', '0967082811', NULL, 'Female', 'Can Tho', 'East Shaylee', '37055 Dario Rapid Apt. 889\nKyramouth, OR 00491', 'Volunteer', NULL, 1, 1, NULL, 'gxA6uD584X', '2025-11-22 16:12:27', '2025-11-22 16:12:27'),
(177, NULL, NULL, 'kihn.carter@example.org', '$2y$12$ZUCSg/uri/9KlmuCHwxASujRX/QYkBd3GSTTm2zygxmXMsYJpx84a', 'Norma', 'Johns', NULL, '1992-06-06', 'Other', 'Da Nang', 'Marvinmouth', NULL, 'Organization', 'https://via.placeholder.com/200x200.png/003300?text=people+qui', 1, 1, '2025-10-25 23:05:19', 'nDbcyAcJFI', '2025-11-22 16:12:28', '2025-11-22 16:12:28'),
(178, NULL, NULL, 'zetta13@example.com', '$2y$12$Z9dh4CdAKvUGcIHNEyeNiOgLETtzWN2EyP5Fi1eytN7ZHd1d7/K0.', 'Raina', 'Murray', '0905860778', NULL, 'Female', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002255?text=people+in', 1, 1, NULL, 'hpNd2iP5bW', '2025-11-22 16:12:28', '2025-11-22 16:12:28'),
(179, NULL, NULL, 'kemmer.nayeli@example.org', '$2y$12$H2luD6e13fXXaJf133Y5p.wi1wBXZHxHsGR0pT1yt5CI/l4ZRV5Jy', 'Chase', 'Zboncak', NULL, '1977-11-24', 'Female', 'Can Tho', 'East Myrtice', '8133 Noemi Station Apt. 881\nNorth Tyree, MI 23464-4100', 'Volunteer', 'https://via.placeholder.com/200x200.png/002233?text=people+soluta', 1, 1, NULL, 'FHai9BF0ea', '2025-11-22 16:12:28', '2025-11-22 16:12:28'),
(180, NULL, NULL, 'august12@example.net', '$2y$12$hl1nRHmmT5.H1REnbSx7WuRs6FMGXtc7CV5PLL4SVhxrjlcupq4.G', 'Cierra', 'Corkery', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'OiZ3wkfgvM', '2025-11-22 16:12:28', '2025-11-22 16:12:28'),
(181, NULL, NULL, 'gottlieb.anahi@example.org', '$2y$12$r8ILPemg5njrE1TnKvWZV.f1nvapyIkX6XzYx5hOcuJ4QYWwQveiy', 'Burnice', 'Steuber', '0924940942', '1996-11-04', 'Other', 'Ho Chi Minh', 'New Keira', '61871 Cummings View Suite 681\nPort Althea, MT 05430', 'Volunteer', NULL, 1, 1, NULL, 'O91ncCZE8E', '2025-11-22 16:12:28', '2025-11-22 16:12:28'),
(182, NULL, NULL, 'kohler.german@example.org', '$2y$12$uJSoXesn19yyPukBbIJA8.JCfrkniXbyRVJqZZdY88cVHdAuG85L.', 'Edwardo', 'Zieme', NULL, NULL, 'Other', 'Hanoi', NULL, '127 Magali Gardens Apt. 308\nNorth Kacibury, LA 58034-6337', 'Volunteer', NULL, 1, 1, '2025-11-16 23:56:01', 'kKaSWRW9uR', '2025-11-22 16:12:29', '2025-11-22 16:12:29'),
(183, NULL, NULL, 'denis.durgan@example.com', '$2y$12$G3MYECjmZjFFw7jU3BG9r.XsbWNVZLAdPGFS70sEYSZoCTayp/bWy', 'Dulce', 'Becker', NULL, '2006-11-17', 'Male', 'Can Tho', 'Townehaven', '6964 Anne Path\nKeelingview, MN 43730', 'Volunteer', NULL, 0, 1, '2025-11-10 14:51:01', 'g8Nff2ci5K', '2025-11-22 16:12:29', '2025-11-22 16:12:29'),
(184, NULL, NULL, 'schimmel.walter@example.org', '$2y$12$iFbSlY5qeA13eJxW5kqU2.7oSor1YEA4U/W93M228vBvUQ5wWkZQ6', 'Henri', 'Okuneva', '0988169909', '2000-09-17', 'Female', 'Ho Chi Minh', NULL, '4054 Erica Land Apt. 596\nKohlerland, IA 58622-7483', 'Volunteer', NULL, 1, 1, '2025-11-12 16:32:00', 'jkel5es6qv', '2025-11-22 16:12:29', '2025-11-22 16:12:29'),
(185, NULL, NULL, 'witting.horacio@example.net', '$2y$12$UU18jSocvVhIUavdkPUZVeexRNAlE0XMv0nXKdCfM02Z3EKv45zKy', 'Tavares', 'Nicolas', NULL, '1980-02-20', 'Male', 'Hanoi', NULL, '63295 Windler Road\nWest Augustusfort, OK 35158-6953', 'Volunteer', 'https://via.placeholder.com/200x200.png/0066cc?text=people+sint', 1, 1, '2025-11-07 08:57:27', '3HZtcHKAYi', '2025-11-22 16:12:29', '2025-11-22 16:12:29'),
(186, NULL, NULL, 'ryan.allen@example.com', '$2y$12$kfPYMZPtG72RG5U5un96Ge.Um8D34tTzm/3U.bAiIts1EYPqFBP7y', 'Alan', 'Bartoletti', NULL, '1970-01-31', 'Female', 'Hai Phong', 'Beckerport', '908 Witting Club\nLemkefurt, NM 04481', 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd22?text=people+quis', 1, 1, '2025-10-31 21:34:47', 'NsJF2TrE6A', '2025-11-22 16:12:29', '2025-11-22 16:12:29'),
(187, NULL, NULL, 'xfriesen@example.org', '$2y$12$CqqjX4avEH7/Q6kHbvJBU.icWIQMom2UlmYhYXtrvKt7JrPWNaW5W', 'Lindsay', 'Parisian', '0998585562', '2001-12-30', 'Other', 'Hanoi', 'Rodriguezshire', NULL, 'Volunteer', NULL, 1, 1, NULL, 'jI4SntWPHR', '2025-11-22 16:12:30', '2025-11-22 16:12:30'),
(188, NULL, NULL, 'leopoldo53@example.com', '$2y$12$hnT7YR9q0CdQSrG0nALKj./X.lOpYp4y5cerAlJfkvfDnQuaMbo4m', 'Raina', 'Wyman', '0969371539', NULL, 'Male', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-11-12 14:39:26', 'UBGwnA2Onb', '2025-11-22 16:12:30', '2025-11-22 16:12:30'),
(189, NULL, NULL, 'lon85@example.org', '$2y$12$lk/lIsvlJBMMaSwFKMTSyOqMN5wXZOVHvkZQtrl8c8dDyWoPrpGq2', 'Melyssa', 'Spinka', '0928694026', '1982-04-20', 'Male', 'Hai Phong', NULL, '23353 Travis Locks Apt. 951\nXavierhaven, NJ 88695-2809', 'Volunteer', 'https://via.placeholder.com/200x200.png/006688?text=people+nesciunt', 1, 1, NULL, '9AjcfWj1Aj', '2025-11-22 16:12:30', '2025-11-22 16:12:30'),
(190, NULL, NULL, 'davion.lakin@example.com', '$2y$12$5BOtCZfeA5KrtYr5TX988uz9h8YcGOBJKTwu95rxh0da0rG/9kXU.', 'Sylvester', 'Hahn', '0985549785', '2006-04-26', 'Male', 'Hai Phong', 'East Bell', '81035 Streich Meadows\nLake Dejuanborough, WV 07775', 'Volunteer', NULL, 0, 1, NULL, 'nLzGIbek2i', '2025-11-22 16:12:30', '2025-11-22 16:12:30'),
(191, NULL, NULL, 'kovacek.alexandre@example.com', '$2y$12$xrcQvb03iI/wQiuedFHPguMtnA/g3n5s5YEzxHyUJDzTXm9dUXFb6', 'Janie', 'Robel', NULL, NULL, 'Female', 'Da Nang', 'Shawnport', NULL, 'Volunteer', NULL, 1, 1, NULL, '1GiMRgjlfD', '2025-11-22 16:12:30', '2025-11-22 16:12:30'),
(192, NULL, NULL, 'dixie.yundt@example.net', '$2y$12$MKRrk3ecDD..B708y4oOZumj/8IzjSMTdZki50kYZenMkO8eO3I4a', 'Enos', 'Konopelski', NULL, '1985-05-08', 'Other', 'Hai Phong', 'Lake Anna', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee22?text=people+nihil', 1, 1, '2025-10-25 18:50:16', 'Lh6w1Az4TZ', '2025-11-22 16:12:31', '2025-11-22 16:12:31'),
(193, NULL, NULL, 'xeffertz@example.net', '$2y$12$cdWxp07jVdU.gw7CKxL2Ee5svRriJwORUs1y0ktNzR5tcZX1g.KyW', 'Lelah', 'Kling', '0999428777', '2000-03-06', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005577?text=people+sequi', 1, 1, '2025-11-07 01:10:27', 'UTHlpdAfnq', '2025-11-22 16:12:31', '2025-11-22 16:12:31'),
(194, NULL, NULL, 'idella.mclaughlin@example.net', '$2y$12$Xxx.Z3mEVFjWeIaZXgOCS.hThZ6IJcS8BGT6WlTneruc4dGYaNyZ.', 'Gia', 'Gorczany', '0982613701', '1970-01-25', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002266?text=people+et', 0, 1, NULL, '6ttrJDDpIO', '2025-11-22 16:12:31', '2025-11-22 16:12:31'),
(195, NULL, NULL, 'alejandra.oberbrunner@example.org', '$2y$12$Pd5iUXyuA0d7f/1CH0o6quIIw.xSDwU3Xw88fnpX8rujVjuKQaBVm', 'Layla', 'Cormier', NULL, NULL, 'Male', 'Hai Phong', NULL, '293 Ottis Street Apt. 962\nOnieborough, OR 42528', 'Volunteer', NULL, 1, 1, '2025-11-14 05:56:47', 'DKzneuPoG4', '2025-11-22 16:12:31', '2025-11-22 16:12:31'),
(196, NULL, NULL, 'bechtelar.derek@example.org', '$2y$12$mX/fmfRns9uiLVXyJ9mKI.c3fCXM2cWA2LXeK1PSWXxriTaED12iS', 'Elwyn', 'Fisher', NULL, '2002-02-22', 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'qjyULGttmY', '2025-11-22 16:12:31', '2025-11-22 16:12:31'),
(197, NULL, NULL, 'jeanne34@example.com', '$2y$12$NVmYIQHdLFfTBEBn7t8dfOY.yUZ2M1pYu4yFq7TDVMesoXxxbM522', 'Patricia', 'Kuhic', NULL, '1999-11-02', 'Female', 'Can Tho', NULL, '494 Hartmann Curve Suite 524\nLake Columbushaven, CA 50650', 'Volunteer', 'https://via.placeholder.com/200x200.png/0077cc?text=people+vero', 1, 1, '2025-11-04 14:21:17', 'E4MqFDCDZ4', '2025-11-22 16:12:32', '2025-11-22 16:12:32'),
(198, NULL, NULL, 'eladio.pacocha@example.org', '$2y$12$xhKPFNUJ5qwhjtqj2DwmIOk4IpFLLIxog8IOGEnQUPp1wgkTtqcfq', 'Mariane', 'Miller', '0954858018', NULL, 'Male', 'Can Tho', NULL, '572 Lebsack Port\nRamonastad, GA 15836-9253', 'Organization', NULL, 1, 1, NULL, 'ngKMG7VvkG', '2025-11-22 16:12:32', '2025-11-22 16:12:32'),
(199, NULL, NULL, 'xohara@example.com', '$2y$12$NU7i/r43V2NfCgQsFfsKdeN2KL84ybdw41MizTqJF1IJQiWfJCuT.', 'Kenton', 'Torp', '0932190035', NULL, 'Female', 'Ho Chi Minh', 'West Ferminburgh', '7620 Reuben Mission Apt. 957\nLake Victoria, MS 55147', 'Volunteer', NULL, 1, 1, '2025-10-26 01:05:12', 'xFwrLbo16I', '2025-11-22 16:12:32', '2025-11-22 16:12:32'),
(200, NULL, NULL, 'terry.leland@example.net', '$2y$12$OuvjP1m7hkKWlCx9H673YuLej/fSUqKirlGmFs9yFt4aQ5vT8a.I2', 'Caitlyn', 'Fay', '0918508061', '1993-05-15', 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002266?text=people+unde', 1, 1, NULL, 'p65CE77rLt', '2025-11-22 16:12:32', '2025-11-22 16:12:32'),
(201, NULL, NULL, 'baumbach.zakary@example.org', '$2y$12$e8MIZiiErQ05IQHs9gd64OTB6xVas4p0TFztykKJ0owcTzxBI2jFy', 'Billy', 'Tremblay', '0969084971', '1979-09-04', 'Female', 'Da Nang', 'West Deangelotown', NULL, 'Volunteer', NULL, 1, 1, '2025-11-03 11:07:06', '3K2Fv4vdpy', '2025-11-22 16:12:32', '2025-11-22 16:12:32'),
(202, NULL, NULL, 'wunsch.bo@example.net', '$2y$12$4E59WjKhL02VQL4gaHzFJu1ayV0ohVUwypi.ImI1uZdANSxlUyiRu', 'Haley', 'Jacobs', NULL, '1999-12-05', 'Male', 'Hai Phong', NULL, '77302 Nolan Village\nBrekkemouth, LA 54060', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb66?text=people+reiciendis', 1, 1, NULL, 'jCPNi0FJhe', '2025-11-22 16:12:33', '2025-11-22 16:12:33'),
(203, NULL, NULL, 'fae.west@example.net', '$2y$12$dJNipOq9nw1sARZu1XK3YO34RzplLoriuWloqi6ygysQYPgi/Dciq', 'Darron', 'Mosciski', '0903306309', '1969-06-24', 'Other', 'Can Tho', 'South Trevorborough', '934 Kreiger Roads Apt. 729\nSouth Jaycee, FL 08266-8718', 'Volunteer', 'https://via.placeholder.com/200x200.png/0011cc?text=people+ea', 1, 1, '2025-10-25 12:41:19', 'Wmhzu09ZGB', '2025-11-22 16:12:33', '2025-11-22 16:12:33'),
(204, NULL, NULL, 'awitting@example.org', '$2y$12$w1w28lNjT23zpcXaw7tfxe86wtonlYmtOK8Hovhe.MeCBJoJlnDBi', 'Lauriane', 'Conn', '0971126903', '1976-01-26', 'Other', 'Can Tho', 'Lake Tylerstad', '1987 Cristobal Station\nHowehaven, FL 54085', 'Volunteer', 'https://via.placeholder.com/200x200.png/005577?text=people+quis', 0, 1, NULL, 'YyxkS6CwFF', '2025-11-22 16:12:33', '2025-11-22 16:12:33'),
(205, NULL, NULL, 'hudson45@example.com', '$2y$12$EHO26f8zwH3C2CCMaq0pheM5bV6koXGGKxwm4H3NJRvYHl89x7dI6', 'Concepcion', 'Lindgren', NULL, '1993-12-17', 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/003322?text=people+quidem', 0, 1, NULL, 'vK3lfEBD6A', '2025-11-22 16:12:33', '2025-11-22 16:12:33'),
(206, NULL, NULL, 'walker.mireille@example.org', '$2y$12$pwsHzdpDxCx/l4jh9qh9K.UzO/QsT2m4qp3Mk8vUWGOz631HkhtGK', 'Theron', 'Schamberger', NULL, NULL, 'Male', 'Hai Phong', 'East Philip', '56362 Trantow Village Apt. 128\nKubton, ME 81365-9838', 'Volunteer', NULL, 0, 1, NULL, 'v6dxLRW36v', '2025-11-22 16:12:33', '2025-11-22 16:12:33'),
(207, NULL, NULL, 'roderick.rogahn@example.org', '$2y$12$xTY1obcfQnJmtZQvfEdaRe/lizyTb8xED.bxbqhB2plu2kvM9aQ1y', 'Jared', 'Goldner', NULL, NULL, 'Male', 'Ho Chi Minh', 'Lake Carlieburgh', '5714 Corkery Bridge Suite 290\nNew Bertfurt, WY 14691', 'Volunteer', NULL, 1, 1, NULL, 'QixBDdPRER', '2025-11-22 16:12:34', '2025-11-22 16:12:34'),
(208, NULL, NULL, 'hope05@example.net', '$2y$12$ScngHlcnz/PCtotjKo/tHeibDNTtqVH.x65cuwz.QhF7oPz.dLkQu', 'Rosella', 'Bogan', NULL, NULL, 'Female', 'Ho Chi Minh', 'New Baileechester', '76043 Ratke Hill Apt. 064\nJadenshire, GA 51541-0700', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000aa?text=people+earum', 1, 1, NULL, 'xNkhs3503z', '2025-11-22 16:12:34', '2025-11-22 16:12:34'),
(209, NULL, NULL, 'murray.aliza@example.org', '$2y$12$M0DdWodOQp73XjpPYTqmH.ziWyhW1ZyCmUbxoNoU3B/eC1AcDf9p.', 'Brennan', 'Hintz', NULL, '1966-10-13', 'Female', 'Hanoi', 'Barbaraview', '85990 Margaretta Branch Apt. 320\nNew Veronica, CA 20080-4648', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddff?text=people+sint', 1, 1, '2025-11-19 13:47:26', 'UEUDJALANR', '2025-11-22 16:12:34', '2025-11-22 16:12:34'),
(210, NULL, NULL, 'pschroeder@example.com', '$2y$12$GQWw9i3MLs.c7vUKTqqRKO7ubTdGKDN7oeM0T0m7PNQ9MM54L5X6u', 'Nicolas', 'Gorczany', NULL, '1969-10-22', 'Other', 'Can Tho', NULL, '2425 Hettinger Pines Suite 941\nNew Milantown, PA 51327-2792', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa33?text=people+recusandae', 0, 1, '2025-11-20 19:16:41', 'tfMX9ZuhoK', '2025-11-22 16:12:34', '2025-11-22 16:12:34'),
(211, NULL, NULL, 'anastacio.simonis@example.net', '$2y$12$GuN2B61h9ZsG33/8Yo2veOg9rzf6PEdAV7gLq8.d6/fhe19vzkt5G', 'Monica', 'Boyle', NULL, '1992-01-31', 'Other', 'Hai Phong', 'Annettestad', NULL, 'Organization', 'https://via.placeholder.com/200x200.png/007744?text=people+sed', 0, 1, NULL, 'Hp1nqlKCBd', '2025-11-22 16:12:34', '2025-11-22 16:12:34'),
(212, NULL, NULL, 'otha.beahan@example.org', '$2y$12$AeNj1XzOEzL/YtidLxArhu15dQnF2h6uzg45lzehF5u1P3rB8tq4e', 'Aurelio', 'Heidenreich', '0935549713', NULL, 'Female', 'Hai Phong', NULL, '611 Earnestine Center\nLake Joetown, DC 94930-3139', 'Volunteer', NULL, 1, 1, '2025-11-18 13:26:56', 'EOUTNJhd9u', '2025-11-22 16:12:35', '2025-11-22 16:12:35'),
(213, NULL, NULL, 'gtillman@example.net', '$2y$12$t.aWWgJRDYZsUQf2P1SVWucmmj1nU6JZtu.pGBiJjQb5FIyUfd/sS', 'Jamel', 'Emard', '0973563778', '1991-08-23', 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005500?text=people+similique', 1, 1, '2025-11-06 03:11:32', '80QAhyWDX2', '2025-11-22 16:12:35', '2025-11-22 16:12:35'),
(214, NULL, NULL, 'ybednar@example.com', '$2y$12$8IahIFobAKy672gXEGVlJukFAyVyj3SWQhtM1mYN1.84jzG7D1qCK', 'Louie', 'Pagac', NULL, NULL, 'Female', 'Da Nang', 'West Kayliburgh', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddee?text=people+sunt', 0, 1, NULL, 'svduBEDqoP', '2025-11-22 16:12:35', '2025-11-22 16:12:35'),
(215, NULL, NULL, 'afton.rutherford@example.com', '$2y$12$TwOebISZjcX53OYSfVRBxOr8r4pTRwqVtAa/wMemsbC129M6s1m6O', 'Alberta', 'Stokes', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, '133 Gunner Vista\nSpencerborough, NH 04393', 'Volunteer', 'https://via.placeholder.com/200x200.png/004422?text=people+est', 1, 1, '2025-11-02 15:28:30', 'Z6t1bevdoX', '2025-11-22 16:12:35', '2025-11-22 16:12:35'),
(216, NULL, NULL, 'marcelino.fritsch@example.com', '$2y$12$vg7drWZrriiQRMD0XuOrx.WbEJlRnvkzBiH6ppn6PoNmPwLVc7sne', 'Dolores', 'Armstrong', NULL, '1978-02-27', 'Other', 'Can Tho', 'East Whitneymouth', '215 Weimann Vista\nMathiashaven, PA 23072-5177', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000aa?text=people+dolorum', 0, 1, '2025-10-26 15:25:05', 'P02sufSD3a', '2025-11-22 16:12:35', '2025-11-22 16:12:35'),
(217, NULL, NULL, 'jwilkinson@example.com', '$2y$12$7T4a9RvyjHlznKfcAP8Fe.YvKhLQIWbGkalkZdMsnlYOBV9nALpOG', 'Lyla', 'Fahey', '0983448973', NULL, 'Male', 'Ho Chi Minh', NULL, '28972 Breitenberg Cove Apt. 142\nBaumbachmouth, DC 44852-3322', 'Volunteer', NULL, 1, 1, NULL, 'pQsNaM7MxC', '2025-11-22 16:12:36', '2025-11-22 16:12:36'),
(218, NULL, NULL, 'huels.isabella@example.com', '$2y$12$C6MzCbmKozc8Cst6sT2qWucSLtcODs8UFsgQN8zfOHTC.TY/..T.S', 'Harvey', 'Hoppe', NULL, '2001-09-03', 'Male', 'Ho Chi Minh', 'Rosamondmouth', '857 Dayana Ramp Apt. 012\nEast Colemanchester, WV 35986-2412', 'Volunteer', 'https://via.placeholder.com/200x200.png/00bb44?text=people+sit', 1, 1, NULL, 'Dzy5Pm2j8g', '2025-11-22 16:12:36', '2025-11-22 16:12:36'),
(219, NULL, NULL, 'hester.wiza@example.net', '$2y$12$Q.2npAO.TNdv4.WV5hc7Wutp15mhO6uW6ISVGVKO3eRthKVnUUL5y', 'Pierre', 'Rodriguez', '0946610773', '2007-01-19', 'Other', 'Ho Chi Minh', 'West Rosannaside', '464 Abigayle Union\nDenesikmouth, DE 68395', 'Volunteer', 'https://via.placeholder.com/200x200.png/006622?text=people+deserunt', 1, 1, NULL, 'tFFmbwUsrt', '2025-11-22 16:12:36', '2025-11-22 16:12:36'),
(220, NULL, NULL, 'wilkinson.catharine@example.org', '$2y$12$M9P2Nw9FPlKeRu4ZCwcyV.CI0XDvLK/cv/tmUY62hncwOwYbDV956', 'Mikel', 'Rau', NULL, '2000-11-19', 'Male', 'Da Nang', NULL, '100 Reichert Passage\nEast Brandiview, AR 06457-2560', 'Volunteer', NULL, 1, 1, '2025-11-12 22:20:54', 'aqL9jWM9o8', '2025-11-22 16:12:36', '2025-11-22 16:12:36'),
(221, NULL, NULL, 'yhaag@example.org', '$2y$12$d5PiqLvWnQOCosJ2hCTmhuqXxyq7Ez6q9I2Qvp5i0QzY5GldmEPCa', 'Andreanne', 'Dach', NULL, '1968-05-06', 'Other', 'Ho Chi Minh', 'Jairostad', NULL, 'Volunteer', NULL, 0, 1, '2025-11-12 10:17:47', 'yJN8PQOTxp', '2025-11-22 16:12:36', '2025-11-22 16:12:36'),
(222, NULL, NULL, 'eleanore96@example.org', '$2y$12$yf/uir2fYnR3atjqbG64I.OKsXa61aRblNk0CBqdr2rBh/U9XwUbC', 'Andy', 'Jaskolski', NULL, NULL, 'Male', 'Hanoi', 'Lake Jasonland', '16199 Muller Summit Apt. 320\nLewmouth, IN 50207-8696', 'Volunteer', NULL, 1, 1, NULL, 'LN5HlksnYV', '2025-11-22 16:12:37', '2025-11-22 16:12:37'),
(223, NULL, NULL, 'hayden.ferry@example.net', '$2y$12$p2eX6eOxyM.tF3rJHZlE7uwaSlCsk1rhsvw6S2HFkpgvzF4/cqHLe', 'Talon', 'Fadel', NULL, '1975-03-17', 'Other', 'Ho Chi Minh', 'Doughaven', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/003355?text=people+tempora', 1, 1, '2025-11-06 00:26:39', 'ENpa4eYzXn', '2025-11-22 16:12:37', '2025-11-22 16:12:37'),
(224, NULL, NULL, 'reilly.johnson@example.com', '$2y$12$aVPr77DJq5Woy4ZQxHXScu68hUSRn6hNQRzzjG6RJGQjz17JwDX2S', 'Theron', 'Bauch', NULL, '1977-06-15', 'Male', 'Da Nang', NULL, '3906 Ernser Trace\nJulianhaven, AR 65877', 'Volunteer', NULL, 1, 1, '2025-11-21 19:09:58', 'tAM2bl4flP', '2025-11-22 16:12:37', '2025-11-22 16:12:37'),
(225, NULL, NULL, 'kbartoletti@example.net', '$2y$12$qzzrqQ.4VkzELyIZOXoep.dFMNs6tW1F/CqznP/ojZOv0FGq1g/6a', 'Ronaldo', 'Willms', NULL, NULL, 'Female', 'Can Tho', NULL, '32274 Ladarius Oval Suite 874\nEzraville, CT 46494', 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc55?text=people+deleniti', 1, 1, NULL, 'r2h9tDC7Jm', '2025-11-22 16:12:37', '2025-11-22 16:12:37'),
(226, NULL, NULL, 'langworth.grover@example.net', '$2y$12$T1uCUUoOiKy9TkZuRzDWwOMZ6UmLNVAOfuOq1ps8KNGtTzhxwesRi', 'Bradford', 'Turner', '0921718136', '1994-09-12', 'Other', 'Hai Phong', 'Vandervortbury', '9355 Clemens Meadows\nGloverville, OR 69796-9440', 'Volunteer', NULL, 1, 1, NULL, 'jS8zndAef3', '2025-11-22 16:12:37', '2025-11-22 16:12:37'),
(227, NULL, NULL, 'rosetta43@example.com', '$2y$12$PwQzWm/K.oW12sxpP.BGxegfyZcEuASEv0Qp.m/KJHFRie6Md0C1y', 'Alba', 'Bruen', '0972111106', '2002-07-05', 'Female', 'Ho Chi Minh', 'New Jovani', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002200?text=people+eaque', 0, 1, NULL, 'KgxlckjGHH', '2025-11-22 16:12:38', '2025-11-22 16:12:38'),
(228, NULL, NULL, 'lyla.jerde@example.org', '$2y$12$2xwhrH55b54a32sqLU/xpen3bBAQ9OFHNnjRl.e9aG6cjyMsnu2iy', 'Americo', 'Klein', NULL, NULL, 'Female', 'Ho Chi Minh', NULL, '941 Okuneva Tunnel Suite 464\nWest Monroeberg, KY 80171-8733', 'Volunteer', NULL, 0, 1, '2025-11-13 23:42:25', 'H0eLSdfeEh', '2025-11-22 16:12:38', '2025-11-22 16:12:38'),
(229, NULL, NULL, 'meda80@example.org', '$2y$12$n8PQhFAOUGI82dYoRQnifOZSfoey8Xf67llZMOKK4tr/R9AzAgdTu', 'Emerald', 'Dietrich', NULL, NULL, 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'PEK8UtTwQr', '2025-11-22 16:12:38', '2025-11-22 16:12:38'),
(230, NULL, NULL, 'considine.daryl@example.com', '$2y$12$P1J6/fcCCGrd.g.SlbmLH.BJ9oSuMIn8EEutDM55ChPNd3TvH7J1e', 'Assunta', 'Walter', NULL, NULL, 'Female', 'Hanoi', 'West Eduardo', '874 Dooley Coves Suite 183\nNew Derrick, MT 37440', 'Volunteer', 'https://via.placeholder.com/200x200.png/006644?text=people+aliquam', 1, 1, '2025-11-03 11:08:09', 'n1ssUYSEiy', '2025-11-22 16:12:38', '2025-11-22 16:12:38'),
(231, NULL, NULL, 'zelda.stracke@example.com', '$2y$12$htYq6LRGBugMzF3ZvpLepObhpq23bim5ySp/VV2cO6ZknckDhKOGy', 'Oswald', 'Goyette', NULL, NULL, 'Male', 'Hai Phong', 'South Scarlett', '9947 Cloyd Lodge Apt. 114\nKevonville, MO 34620-3960', 'Volunteer', 'https://via.placeholder.com/200x200.png/002266?text=people+vel', 1, 1, NULL, 'HEJXTSTyPr', '2025-11-22 16:12:38', '2025-11-22 16:12:38'),
(232, NULL, NULL, 'runolfsdottir.karl@example.com', '$2y$12$o9vKyIZ/mC8Isg55U3VcnuNQkytAHqDbQeZfsWKFShAshlfEZGxlK', 'Brant', 'Hill', '0999092626', '1996-08-06', 'Male', 'Hanoi', NULL, '2380 Kub Gateway\nSouth Ilianaburgh, DE 34686', 'Organization', 'https://via.placeholder.com/200x200.png/006688?text=people+reiciendis', 0, 1, '2025-10-25 17:07:46', '9LO86x7JKF', '2025-11-22 16:12:39', '2025-11-22 16:12:39'),
(233, NULL, NULL, 'parker.theodore@example.com', '$2y$12$oFogH9XZV3W2Be0IBr.4n.8DaOkLM7i6H/VY1/ytQqiv/iJvdiDlu', 'Saige', 'Borer', '0962056476', '1970-03-16', 'Female', 'Hai Phong', NULL, '29142 Yadira Dam Apt. 058\nEast Queen, TX 04043', 'Volunteer', 'https://via.placeholder.com/200x200.png/0088ee?text=people+repellendus', 1, 1, '2025-11-17 20:07:14', 'Lr4xmdsHDX', '2025-11-22 16:12:39', '2025-11-22 16:12:39'),
(234, NULL, NULL, 'osinski.madelynn@example.org', '$2y$12$4NB9NCCoSEAZpRTsEFmTpuBWnoN2wqKrUNjC0E9jzMiaKfU8T2SMy', 'Alisa', 'Ritchie', NULL, '1971-10-19', 'Female', 'Hanoi', 'Alvenastad', '668 Boris Run Suite 667\nNorth Dan, LA 62278', 'Volunteer', NULL, 1, 1, NULL, 'ZXJP0LqfYY', '2025-11-22 16:12:39', '2025-11-22 16:12:39'),
(235, NULL, NULL, 'chesley.bergnaum@example.net', '$2y$12$DU3NuXVRG9.bDu5wik5NluEZKu/djyoS.OZX49nL4zJZVq.6dBPmG', 'Gladyce', 'Waelchi', NULL, '1996-05-21', 'Other', 'Hanoi', NULL, '851 Sammie Islands\nRodstad, OH 52240', 'Volunteer', NULL, 1, 1, NULL, 'NB6ur8dUEG', '2025-11-22 16:12:39', '2025-11-22 16:12:39'),
(236, NULL, NULL, 'wuckert.hilda@example.net', '$2y$12$6byhqAYQiytgoriSnZd0BeIAsN1j6F5wdZKZPsStTckeddebJD47S', 'Mohammad', 'Leannon', NULL, '1991-04-02', 'Other', 'Can Tho', 'Oberbrunnerstad', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa11?text=people+consequuntur', 1, 1, NULL, 'cqfa1E760O', '2025-11-22 16:12:39', '2025-11-22 16:12:39'),
(237, NULL, NULL, 'catharine80@example.org', '$2y$12$dGZBnCeSoKS3.y106hq62uQ56GKyknw.7bEYVi3iyNPZ//S3ZSImG', 'Archibald', 'Terry', NULL, NULL, 'Other', 'Ho Chi Minh', 'South Lyda', '5803 Edyth Crescent Suite 906\nBergnaumbury, OH 33374', 'Volunteer', 'https://via.placeholder.com/200x200.png/006600?text=people+exercitationem', 0, 1, '2025-11-10 18:31:29', 'vJ4sLGclGm', '2025-11-22 16:12:40', '2025-11-22 16:12:40'),
(238, NULL, NULL, 'donnie38@example.net', '$2y$12$vwjFSfnIVmwS/9dRSTS2c.HFibnR/dFtrtCm1DDE2IZWmJWG7/qRK', 'Litzy', 'Hyatt', NULL, '1972-11-09', 'Other', 'Hanoi', NULL, '700 Marcellus Courts\nPort Moniqueview, ND 23062', 'Volunteer', 'https://via.placeholder.com/200x200.png/001199?text=people+autem', 1, 1, NULL, 'RVqKMizWpT', '2025-11-22 16:12:40', '2025-11-22 16:12:40'),
(239, NULL, NULL, 'pstehr@example.org', '$2y$12$YGI4JIZHZHSXsa5VVxFTauqR9BxEegry6a0OXkX2n4IR3c/w/uLK2', 'Katlyn', 'Cormier', '0963037441', NULL, 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-10-29 07:48:22', 'D30G4nlv7G', '2025-11-22 16:12:40', '2025-11-22 16:12:40'),
(240, NULL, NULL, 'dare.cristal@example.org', '$2y$12$EtmbuI5RH5KNdejK7EY2M.lxrZ6qsc.z7BWzBYkaANjuE2EQnPjuW', 'Krista', 'Keeling', '0907541737', '1999-05-23', 'Other', 'Can Tho', 'Dylantown', NULL, 'Volunteer', NULL, 0, 1, '2025-11-06 13:52:54', 'chmVcqCOrZ', '2025-11-22 16:12:40', '2025-11-22 16:12:40'),
(241, NULL, NULL, 'rebecca07@example.com', '$2y$12$sHYAU3Ba3gH4kDKaUVSiQ.iwK9mMu4Qv99wIu7eYQzfsWDiESTad6', 'Greyson', 'Terry', NULL, NULL, 'Other', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000044?text=people+quis', 1, 1, '2025-11-03 09:14:53', '9yywIsrl6m', '2025-11-22 16:12:41', '2025-11-22 16:12:41'),
(242, NULL, NULL, 'becker.karlee@example.net', '$2y$12$uUjdX6p797rJE2gDhUZR.uLX9tdG9RSO14I7Lgobi8FXIjHIwgXKm', 'Ebony', 'Shanahan', '0911376201', NULL, 'Male', 'Da Nang', 'Lake Alan', NULL, 'Volunteer', NULL, 1, 1, NULL, 'yRP3BdLwGx', '2025-11-22 16:12:41', '2025-11-22 16:12:41'),
(243, NULL, NULL, 'schmidt.cleora@example.net', '$2y$12$T9p1DuS2Ac.dqAqOUAYGs.2ChWRTsrDFDm4MxawBc1qZech56T8iK', 'Mackenzie', 'White', '0948419535', NULL, 'Female', 'Da Nang', 'North Eldredton', NULL, 'Volunteer', NULL, 1, 1, '2025-11-07 13:33:06', 'WCnm3UCOtV', '2025-11-22 16:12:41', '2025-11-22 16:12:41'),
(244, NULL, NULL, 'gstark@example.net', '$2y$12$HP.bjC60tzxz81kO43MyNu5YTCij8stLWQkmRzM9HRlL9QbaNLY9u', 'Orville', 'Wyman', NULL, '1980-09-03', 'Other', 'Ho Chi Minh', NULL, '905 Borer Streets Apt. 279\nWest Luciusland, MS 80989-9289', 'Volunteer', NULL, 0, 1, NULL, 'Z8cSeEbvNk', '2025-11-22 16:12:41', '2025-11-22 16:12:41'),
(245, NULL, NULL, 'bullrich@example.org', '$2y$12$KKyYbZwDzowt8gy9EVN0VeqGhTJPJFIrtW/30xLfZsec5KphMhaFa', 'Daija', 'Gislason', NULL, NULL, 'Male', 'Can Tho', 'Uliceschester', '4532 Holly Loaf Suite 548\nBaumbachside, OK 97596', 'Volunteer', NULL, 1, 1, NULL, 'KJylcCIHfe', '2025-11-22 16:12:41', '2025-11-22 16:12:41'),
(246, NULL, NULL, 'garrick48@example.org', '$2y$12$yzPs8vClWQcQlcOhZsLsf.XxjKtKb5/iQ0gBtZMsqD1TD.yVWMOkS', 'Fannie', 'Lueilwitz', '0955101542', NULL, 'Female', 'Da Nang', NULL, '9959 Eleazar Prairie Suite 138\nShemarstad, KY 06608-5349', 'Volunteer', NULL, 1, 1, NULL, 'fCwyMB8zfH', '2025-11-22 16:12:42', '2025-11-22 16:12:42'),
(247, NULL, NULL, 'olson.magnolia@example.com', '$2y$12$2b8oxQyuPTZVSLb2jSHFeueNKveff9DSVNdCrNU2J2SbWmNMQ9Sz.', 'Pattie', 'Dibbert', '0975662271', NULL, 'Male', 'Can Tho', 'Jarrettown', '381 Reba Unions Apt. 375\nNew Alyson, RI 13966-9613', 'Volunteer', NULL, 0, 1, '2025-11-02 10:50:11', 'uQwB8UM54T', '2025-11-22 16:12:42', '2025-11-22 16:12:42'),
(248, NULL, NULL, 'wolf.saul@example.net', '$2y$12$2sxs79CHFGQ.mYhQEvN9Te1nbMT.a80.sU4BXn/1R9x.P/STWmeP2', 'Russell', 'Bins', NULL, '1969-03-15', 'Male', 'Hanoi', NULL, '3318 Donato Ranch\nNew Clare, ME 48002', 'Volunteer', NULL, 0, 1, '2025-10-31 22:27:40', 'htaLcnHoIa', '2025-11-22 16:12:42', '2025-11-22 16:12:42'),
(249, NULL, NULL, 'gislason.annette@example.com', '$2y$12$L/awTO/HJc4KuD3MgxOi9.LlSiDVGmg8tT6RwQapEcXZ31HmWaQ.W', 'Toney', 'Corkery', '0988677706', NULL, 'Other', 'Da Nang', 'Port Jessmouth', '56305 Maude Mews Apt. 365\nEast Daphneyland, ME 26556-5329', 'Volunteer', NULL, 1, 1, '2025-11-09 00:21:14', 'fNPLLzNXgC', '2025-11-22 16:12:42', '2025-11-22 16:12:42'),
(250, NULL, NULL, 'zstark@example.org', '$2y$12$khe4GivLQJTkNdq2zgU.nu79/nMNJQ1.Kc5iw3t9XHXv7dVZDFj3a', 'Dario', 'Corkery', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, '994 Renner Place\nWest Josiahton, CA 94991-4752', 'Volunteer', 'https://via.placeholder.com/200x200.png/001155?text=people+dignissimos', 0, 1, '2025-10-31 15:21:27', 'RVfGD92jnz', '2025-11-22 16:12:42', '2025-11-22 16:12:42'),
(251, NULL, NULL, 'vern.sauer@example.org', '$2y$12$V8UwgRN4Ly2kcwEm8W5dVuUkI.C0bxvM2U71eX4yYgGIgzkfbEvrS', 'Lenna', 'Rolfson', NULL, '1973-03-22', 'Female', 'Can Tho', 'South Katheryn', '1359 Olson Lodge Apt. 020\nPort Mertie, MD 31027-3657', 'Volunteer', 'https://via.placeholder.com/200x200.png/005533?text=people+itaque', 1, 1, NULL, 'mtsuys4usa', '2025-11-22 16:12:43', '2025-11-22 16:12:43'),
(252, NULL, NULL, 'sydnie14@example.org', '$2y$12$IJjEPBVxJjYQLg1MiuwlE.h4ezgwS318QCqOInJK026nwvR5eLuRG', 'Olen', 'Rowe', '0968990665', '1993-06-14', 'Female', 'Ho Chi Minh', 'East Gradyton', '653 Kassandra Crescent\nKochmouth, RI 91533-4760', 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd33?text=people+aspernatur', 1, 1, '2025-11-10 01:05:56', 'uLW0QXyhGj', '2025-11-22 16:12:43', '2025-11-22 16:12:43'),
(253, NULL, NULL, 'angelina44@example.net', '$2y$12$HHX2q6dRJbpmTfJoA0hxG.AbZZtKq.C2aJn3QCHOCk7.XDI.BT0Y.', 'Steve', 'Nienow', NULL, NULL, 'Other', 'Ho Chi Minh', 'East Leonorfurt', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/007711?text=people+libero', 1, 1, '2025-11-16 07:55:14', 'JUb8jNtUhz', '2025-11-22 16:12:43', '2025-11-22 16:12:43'),
(254, NULL, NULL, 'jaden.white@example.com', '$2y$12$2JcuWp5jL3tMcJdGdFOBtuQg3Br3T.a6THYDAkBI4hSXA2VVnTLee', 'Bryce', 'Casper', NULL, '1991-09-28', 'Other', 'Hai Phong', 'Annamaemouth', '48229 Breitenberg Light Apt. 342\nNikolaston, IA 90294-5550', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa33?text=people+et', 0, 1, NULL, 'XQ2BggGW05', '2025-11-22 16:12:44', '2025-11-22 16:12:44'),
(255, NULL, NULL, 'vkilback@example.com', '$2y$12$tKUUrB7kGRrPt/oflAUT5.x31b7pzUKWnXdMbKuJpaVW63qcxTF4S', 'Garland', 'Nitzsche', '0998184194', NULL, 'Male', 'Can Tho', 'West Rosemarie', NULL, 'Volunteer', NULL, 1, 1, '2025-11-17 09:56:46', 'yxY6eFPmAQ', '2025-11-22 16:12:44', '2025-11-22 16:12:44'),
(256, NULL, NULL, 'walker.louie@example.net', '$2y$12$v/CyM2rZ0JmGxHhHjzHn3e/z06osIRCswrps5cqyWlb4wJVMLcuRC', 'Estel', 'Swift', '0971913951', '2000-10-24', 'Other', 'Hanoi', 'Shanymouth', '28265 Kuphal Rapids\nLake Khalid, GA 09560-0233', 'Volunteer', 'https://via.placeholder.com/200x200.png/00dddd?text=people+et', 0, 1, NULL, 'xgy7A0UqNX', '2025-11-22 16:12:44', '2025-11-22 16:12:44'),
(257, NULL, NULL, 'jkilback@example.org', '$2y$12$wYVhNvZdgCTiTGkw8UjWCuYUS4KcVkhT2aevsOYJ6m9..XBfHBcK6', 'Maxie', 'Schneider', '0966923515', NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0088bb?text=people+possimus', 1, 1, '2025-11-04 06:54:57', '9ltfr1Uuq7', '2025-11-22 16:12:44', '2025-11-22 16:12:44'),
(258, NULL, NULL, 'nia78@example.org', '$2y$12$1oWrdtJxt/ObuBSWw167nub/ftOq0hemssE7M/ojV0XyF.yEz5eWa', 'Reba', 'Gerlach', NULL, '1978-02-09', 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-10-27 17:14:35', 'xKVymxX7is', '2025-11-22 16:12:45', '2025-11-22 16:12:45'),
(259, NULL, NULL, 'qfritsch@example.net', '$2y$12$r5orxztPhyA3zmhb5vtS8efF3cWkMleVe6UY.jIBxAt05D1QLI1xu', 'Maci', 'Dickens', NULL, '1984-02-13', 'Male', 'Hanoi', 'Conroyport', '361 Kristoffer Landing\nLake Jettie, AR 00830', 'Volunteer', NULL, 1, 1, '2025-11-17 08:35:03', 'XNXJaLOnVg', '2025-11-22 16:12:45', '2025-11-22 16:12:45'),
(260, NULL, NULL, 'jkihn@example.org', '$2y$12$fjMyUXcJ4MJ5GcKjGCIUvuGUDSevBDzqy43UcTDiItvNsv1GG5KFq', 'Patricia', 'Haley', '0979645055', '1989-05-28', 'Other', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-10-29 12:56:00', '6NhOQkM923', '2025-11-22 16:12:45', '2025-11-22 16:12:45'),
(261, NULL, NULL, 'hannah.raynor@example.com', '$2y$12$.bxZzAArOTRuF8x/I/bRsuBvwu3/S9gXigK5ZaIZcdIMjX3Fn/IQe', 'Ivah', 'Erdman', NULL, NULL, 'Male', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005588?text=people+placeat', 1, 1, NULL, 'ROxBRBrO6A', '2025-11-22 16:12:45', '2025-11-22 16:12:45'),
(262, NULL, NULL, 'landen.haley@example.net', '$2y$12$NVJjM3GKMgl.EIexOh5Ad.lB.89ypmggZEfBTIbbi5n6VCmYAMo0i', 'Jamie', 'Reichel', NULL, NULL, 'Male', 'Can Tho', 'Laurenton', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bbaa?text=people+placeat', 1, 1, NULL, 'jhpIi9pdcV', '2025-11-22 16:12:46', '2025-11-22 16:12:46'),
(263, NULL, NULL, 'sschaden@example.com', '$2y$12$GIGFiMGZOKVWSffYLr6gOOYyNPUFjsZyUlRt7sVG4CEkpt0i843fS', 'Jasmin', 'Streich', NULL, '1969-12-03', 'Female', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/005500?text=people+et', 1, 1, NULL, 'BE5berlSA6', '2025-11-22 16:12:46', '2025-11-22 16:12:46'),
(264, NULL, NULL, 'dayana.goyette@example.org', '$2y$12$XHEKog1VN0d8ax8udlTIG.YCCDz62.2jW1FFm5.0W6g9NK3i5CI8W', 'Kaley', 'Lind', NULL, '2006-12-14', 'Other', 'Hai Phong', 'New Westley', NULL, 'Organization', NULL, 1, 1, NULL, 'n59sgGzgxB', '2025-11-22 16:12:46', '2025-11-22 16:12:46'),
(265, NULL, NULL, 'nrosenbaum@example.org', '$2y$12$ew9PP1wiZfKJ4TMvM9cnbOpw0jIQY2FsAuzQn8CzPc63oe2UQivZm', 'Shakira', 'Herman', '0908390682', '2007-09-10', 'Male', 'Hai Phong', NULL, '825 Leon Crescent Apt. 664\nDaynaton, MS 59053', 'Volunteer', NULL, 1, 1, NULL, 'FQbCgaWRWr', '2025-11-22 16:12:46', '2025-11-22 16:12:46'),
(266, NULL, NULL, 'parker.dariana@example.com', '$2y$12$InFheL/CXChn7020ARQMPOStb8R5DTZaUsc8BKcxDAZJ19sHsqNgG', 'Jakayla', 'Casper', NULL, NULL, 'Male', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee11?text=people+consectetur', 1, 1, NULL, 'WGiA6GmGGC', '2025-11-22 16:12:47', '2025-11-22 16:12:47'),
(267, NULL, NULL, 'tyler.lind@example.net', '$2y$12$oBu2vpl3UTJvfAkQCTzMfOwCjV.ZOy548EenL.GNxx1tQRzctBfMS', 'Bonnie', 'Walter', '0952106973', '1983-03-18', 'Other', 'Can Tho', 'North Barry', '1575 Maurice Groves Suite 103\nVickiemouth, MI 26207', 'Volunteer', 'https://via.placeholder.com/200x200.png/000055?text=people+provident', 0, 1, '2025-11-14 01:43:23', 'Om9lWksSlT', '2025-11-22 16:12:47', '2025-11-22 16:12:47'),
(268, NULL, NULL, 'cindy.torp@example.net', '$2y$12$cEd9jHEEeSb0sxbEhaPSfOjAczJxzgws6X3ByPFmqKOuEXfA9/h.O', 'Johnathon', 'Douglas', NULL, '1973-10-02', 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, '25j34ZarW8', '2025-11-22 16:12:47', '2025-11-22 16:12:47'),
(269, NULL, NULL, 'ydaniel@example.net', '$2y$12$cUIKSAsw5GgDiofCMVRb7OtTeKvJ33EeAzuZqSsNpOoBUJqf3M0SC', 'Alva', 'Little', NULL, '2001-11-07', 'Male', 'Hanoi', 'Herzogstad', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/006611?text=people+corporis', 1, 1, '2025-11-18 13:08:57', '8vIe5VXoWE', '2025-11-22 16:12:47', '2025-11-22 16:12:47'),
(270, NULL, NULL, 'pansy.green@example.org', '$2y$12$/ewwqlQwu/iR3tiVPEhc1uZDLtmihXfbO93ZgFL2pneFpBRlFyAZu', 'Lempi', 'Spinka', NULL, NULL, 'Other', 'Hai Phong', 'Goyetteland', '692 Morar Ports Apt. 363\nHayleyport, GA 89907-2475', 'Volunteer', NULL, 0, 1, NULL, 'lmUSBr4YxO', '2025-11-22 16:12:48', '2025-11-22 16:12:48'),
(271, NULL, NULL, 'mueller.donny@example.com', '$2y$12$vLhm9liy/EA8mgcESatmyu725PM4V5jewjVtWbnA2uqoUJN1HvVQG', 'Mohammed', 'Corkery', NULL, NULL, 'Male', 'Can Tho', NULL, '1799 Elliot Parks\nWest Natalia, ME 72069-3674', 'Volunteer', NULL, 0, 1, '2025-10-30 04:02:26', 'Pto5XCvteF', '2025-11-22 16:12:48', '2025-11-22 16:12:48'),
(272, NULL, NULL, 'lonnie22@example.net', '$2y$12$PBC7bZu7dqbnWU9ehkmnoOd9MZLt/Wu32Y3JX4DmTdvha8xahz6fu', 'Jerrod', 'Farrell', '0962075524', NULL, 'Other', 'Ho Chi Minh', 'Margueriteview', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/006600?text=people+corporis', 0, 1, '2025-11-07 22:26:02', '3jcQ4kvWDS', '2025-11-22 16:12:48', '2025-11-22 16:12:48'),
(273, NULL, NULL, 'greenfelder.raleigh@example.org', '$2y$12$Gragw2Ae7fs8uwkjIHgJ/OyDVvehEUOjFsvrMVguFhfYWUF1KsmP6', 'Murphy', 'Lindgren', '0964650048', '2007-04-05', 'Other', 'Hai Phong', NULL, NULL, 'Organization', NULL, 1, 1, NULL, 'QraCcXE5ak', '2025-11-22 16:12:48', '2025-11-22 16:12:48'),
(274, NULL, NULL, 'amara.raynor@example.net', '$2y$12$wd/WjkEt4oHAGxlSEFYtQ.ZnoIxG.gbjQ8u3Q/E1fYmPvv1om6L2u', 'Mack', 'Crooks', NULL, '1992-03-29', 'Female', 'Ho Chi Minh', 'Kadenstad', NULL, 'Volunteer', NULL, 1, 1, NULL, 'f2r29MMN7z', '2025-11-22 16:12:48', '2025-11-22 16:12:48'),
(275, NULL, NULL, 'kunze.eldora@example.net', '$2y$12$UKD3Fy7nV2OEERZS.vg5zOsKBz0c/I53osWYf1kWFgD.Sa4rdU60q', 'Helena', 'Weber', NULL, '1990-08-08', 'Other', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dddd?text=people+perferendis', 1, 1, NULL, 'G1lTdC8TvA', '2025-11-22 16:12:49', '2025-11-22 16:12:49'),
(276, NULL, NULL, 'deshawn.weber@example.net', '$2y$12$yxHk3k.aU/z/kthkPqavE.dySKXPBhblPmOA39v7F7.GV9VjH6RSW', 'Felicita', 'Monahan', NULL, NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'nzB8Rgv5hL', '2025-11-22 16:12:49', '2025-11-22 16:12:49'),
(277, NULL, NULL, 'zauer@example.com', '$2y$12$uz4w.d86s1ZARcyVZgG7Fe8lIBZeO3.GzXZ9I0C0r9i.Walk41c6a', 'Dianna', 'Rath', NULL, '1988-09-13', 'Male', 'Hai Phong', 'New Idellashire', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa55?text=people+maxime', 1, 1, NULL, 'eS8RwxjYE0', '2025-11-22 16:12:49', '2025-11-22 16:12:49'),
(278, NULL, NULL, 'rowe.domenico@example.org', '$2y$12$8LBbIjA3V1PO/kwNmfPMFO4LJNdm2mKeShL7o12rGZAw5E7JyIiFa', 'Jay', 'Daugherty', NULL, NULL, 'Female', 'Can Tho', 'Irvingtown', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002211?text=people+rerum', 0, 1, '2025-11-17 13:08:32', 'Y8NqsURIKX', '2025-11-22 16:12:49', '2025-11-22 16:12:49'),
(279, NULL, NULL, 'rnader@example.org', '$2y$12$JXsSks/gf9dZwnB.Cw.AIurGJL5GfMoayelkcxTZS5W9lArKBRPgi', 'Meredith', 'Rohan', NULL, NULL, 'Other', 'Ho Chi Minh', 'New Hyman', NULL, 'Volunteer', NULL, 1, 1, NULL, 'qaoXvMoDLi', '2025-11-22 16:12:50', '2025-11-22 16:12:50'),
(280, NULL, NULL, 'ldouglas@example.org', '$2y$12$iLQ43OVaC7Sk76/HJjzkk.LI/26K.EbS3b6KSt2qpi8RIVoisF/lG', 'Carlie', 'Hoeger', NULL, '1976-01-01', 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'MVmE0w04O7', '2025-11-22 16:12:50', '2025-11-22 16:12:50'),
(281, NULL, NULL, 'cristina23@example.org', '$2y$12$UTQUWMsDaWEnTRch3rrkc.TIqm1m8WS3H7ZDOHQjGQqAtCzlrHto.', 'Camila', 'Towne', NULL, NULL, 'Female', 'Ho Chi Minh', 'New Weldonville', NULL, 'Volunteer', NULL, 1, 1, '2025-11-07 09:30:23', 'LqsYlurHvR', '2025-11-22 16:12:50', '2025-11-22 16:12:50'),
(282, NULL, NULL, 'crooks.adelle@example.net', '$2y$12$Wx4lf.P3IQRJltakhc3h2u3ikDkhp7IlVkUgL8shDVIrIk2P8QPkG', 'Lavada', 'Hilpert', '0953958851', '1984-07-18', 'Male', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'aE1EnhA8mi', '2025-11-22 16:12:50', '2025-11-22 16:12:50'),
(283, NULL, NULL, 'troy.mcdermott@example.net', '$2y$12$qdZpScd.PNcj/s7EHWAmX.mzC.Ws139AtFZALOPAsaIHQC/YiWk52', 'Alf', 'Wiegand', '0972756088', NULL, 'Male', 'Can Tho', 'New Phyllis', '325 Kathleen Knolls Apt. 092\nBergebury, HI 90782-8639', 'Volunteer', 'https://via.placeholder.com/200x200.png/008833?text=people+et', 1, 1, '2025-10-25 18:33:17', 'g21V7yCEEt', '2025-11-22 16:12:51', '2025-11-22 16:12:51'),
(284, NULL, NULL, 'sheila.keebler@example.com', '$2y$12$G/c/ZZrVuFAYdqINfaTOb.kv7K6AFWqcLznFx7s8daOKN4izp6L8C', 'Marianna', 'Eichmann', '0927339770', NULL, 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee44?text=people+excepturi', 0, 1, NULL, 'bLTlJNgl0z', '2025-11-22 16:12:51', '2025-11-22 16:12:51'),
(285, NULL, NULL, 'naomi.spinka@example.com', '$2y$12$ns0ovPC9BPUY8WgAis/b9eqPLFO6jTMFzwK/5uvrPezaghkqJZyGS', 'Kayley', 'Lubowitz', '0995276534', NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'vWVhSB6cvC', '2025-11-22 16:12:51', '2025-11-22 16:12:51'),
(286, NULL, NULL, 'gleichner.brenden@example.org', '$2y$12$5m8bJf5BleCHYz4JtbxSGuWIext6.ECqRLxU8YysOVqUSdn/PlGpy', 'Emmet', 'Ernser', NULL, NULL, 'Other', 'Da Nang', 'Purdyhaven', '4991 Francis Dale\nNorth Teresaland, CO 50746', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000aa?text=people+non', 1, 1, '2025-10-26 16:54:13', 'yhaonXR4Cx', '2025-11-22 16:12:51', '2025-11-22 16:12:51'),
(287, NULL, NULL, 'cummerata.kylee@example.com', '$2y$12$W313y1/A6ZM0orjI84AHeuie78vTU3gtHWn8FRas36uufZQHyhfT6', 'Rhianna', 'Doyle', '0906358209', NULL, 'Other', 'Hai Phong', 'Norahaven', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/002211?text=people+temporibus', 1, 1, '2025-11-01 23:20:37', 'u0QUAxQhFK', '2025-11-22 16:12:52', '2025-11-22 16:12:52'),
(288, NULL, NULL, 'rheidenreich@example.com', '$2y$12$72HHNUbpJrnjUkAP/SeRd.alNfY9gQETf8B3km1WHKc6j0qnfBbGe', 'Joseph', 'Homenick', '0959947930', '2006-10-15', 'Other', 'Hanoi', NULL, '97767 Ludwig Pass Suite 361\nNorth Reece, NC 80441', 'Volunteer', 'https://via.placeholder.com/200x200.png/005522?text=people+iste', 0, 1, '2025-11-12 10:02:37', '7jBeU8LAqP', '2025-11-22 16:12:52', '2025-11-22 16:12:52'),
(289, NULL, NULL, 'olson.donavon@example.net', '$2y$12$mToURSLusB7lCQFPcY4vSOA1a6cLzXpp.t28yx5ENHJXi78fikwpi', 'Carmine', 'Casper', '0921829443', '1969-08-24', 'Male', 'Hanoi', 'Paoloport', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff77?text=people+deserunt', 1, 1, NULL, 'eWXcIhMhWE', '2025-11-22 16:12:52', '2025-11-22 16:12:52');
INSERT INTO `users` (`user_id`, `google_id`, `facebook_id`, `email`, `password`, `first_name`, `last_name`, `phone`, `date_of_birth`, `gender`, `city`, `district`, `address`, `user_type`, `avatar_url`, `is_verified`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(290, NULL, NULL, 'hailey07@example.org', '$2y$12$ODWaqMuFwPYxxb/mUMtEq.nnfcMbgO8qcufiW21agVSwNbGrr5VxC', 'Alba', 'Romaguera', '0976715569', NULL, 'Other', 'Hanoi', 'Gorczanyton', '4322 Fisher Summit\nRauborough, ID 66777-1589', 'Volunteer', NULL, 1, 1, '2025-11-22 03:50:33', 'cwmKef2T5w', '2025-11-22 16:12:52', '2025-11-22 16:12:52'),
(291, NULL, NULL, 'hbarrows@example.com', '$2y$12$VfVwZVQX/NC1t/PFlGJCsuJ/s3xGDNuW0fqZDbBoYinFjinl0s47C', 'Shanna', 'Heidenreich', '0991444622', NULL, 'Female', 'Can Tho', NULL, '533 Lesch Forks Apt. 982\nBeckermouth, IN 02824', 'Volunteer', 'https://via.placeholder.com/200x200.png/0077dd?text=people+ea', 1, 1, '2025-11-04 10:34:37', 'R8Kv0G3Kly', '2025-11-22 16:12:53', '2025-11-22 16:12:53'),
(292, NULL, NULL, 'elyse02@example.net', '$2y$12$fbmWjc6nxPoHdHrHtoFl/uuoc5uX.1XSxd3J38fTaJf9tB3mK95yG', 'Rogelio', 'Cormier', NULL, NULL, 'Female', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 1, 1, '2025-10-30 15:09:29', '6x5Db230YZ', '2025-11-22 16:12:53', '2025-11-22 16:12:53'),
(293, NULL, NULL, 'kautzer.brycen@example.com', '$2y$12$YinyPPVuq5UITVts09sQoec0yremHpVYKj3jw1bZxGASuoIibk1BG', 'Antoinette', 'Marquardt', '0998081565', NULL, 'Other', 'Ho Chi Minh', NULL, '6041 Sipes Burg\nWest Rhiannonberg, WV 99150', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+soluta', 0, 1, '2025-11-09 22:32:49', 'VVpaKaiRBc', '2025-11-22 16:12:53', '2025-11-22 16:12:53'),
(294, NULL, NULL, 'leta.cronin@example.org', '$2y$12$9Tp1HfJR2XCTt7y/y62aXOL5QdLVzGbRc4Q7w6RiWOCaqCLjndxre', 'Armando', 'Wuckert', NULL, '1989-07-03', 'Other', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/001122?text=people+eum', 1, 1, '2025-10-26 10:26:07', 'kl6DbuOKQg', '2025-11-22 16:12:53', '2025-11-22 16:12:53'),
(295, NULL, NULL, 'phansen@example.org', '$2y$12$V7DgfMELiqEsrx51sXMlbeqW2XohwCF9b9jU2f4RoLD9S9EP6dQqi', 'Stella', 'Predovic', NULL, '2005-03-22', 'Other', 'Hai Phong', 'Lake Carolinehaven', NULL, 'Organization', 'https://via.placeholder.com/200x200.png/0033dd?text=people+repudiandae', 1, 1, '2025-11-20 15:31:36', 'eyd89rfKgp', '2025-11-22 16:12:54', '2025-11-22 16:12:54'),
(296, NULL, NULL, 'ctremblay@example.net', '$2y$12$3Fl/1w0Rvy2m78euet7SGuLOgdsAy8ZGkFjUvEFNRjKCWukJQx3Ru', 'Amelie', 'Veum', NULL, '1985-11-05', 'Male', 'Hai Phong', 'Ferminmouth', NULL, 'Volunteer', NULL, 1, 1, '2025-10-24 13:32:29', 'L7r1VLnK11', '2025-11-22 16:12:54', '2025-11-22 16:12:54'),
(297, NULL, NULL, 'clueilwitz@example.org', '$2y$12$XZIX7lB8SSIKATnPdJc0sOY/deE5sNd/lxXwLwSbnSIXLhlvw.cLG', 'Victoria', 'Dooley', '0950743843', '1993-12-13', 'Female', 'Hanoi', 'Lake Russberg', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008866?text=people+eum', 1, 1, NULL, 'kFoLUaYiza', '2025-11-22 16:12:54', '2025-11-22 16:12:54'),
(298, NULL, NULL, 'koby.hodkiewicz@example.net', '$2y$12$OWR1UdBRHraGX0Nq/vWPGeBXeIM5Y1b24gyX5Bjv8NYhk77BSorO2', 'Gregory', 'Crona', NULL, NULL, 'Female', 'Can Tho', NULL, '48616 Kilback Court Apt. 932\nAnahimouth, AL 61147', 'Volunteer', NULL, 1, 1, NULL, 'K6OglnHY85', '2025-11-22 16:12:55', '2025-11-22 16:12:55'),
(299, NULL, NULL, 'tmarks@example.com', '$2y$12$dJk/z6tf.9/eSrRkvqgcr.0768ZRIF.YxVa3woanXvm1PUdVtiuN2', 'Randy', 'Stiedemann', '0980503441', NULL, 'Male', 'Hanoi', 'Francescoview', NULL, 'Volunteer', NULL, 0, 1, NULL, 'sN4TfiKiMq', '2025-11-22 16:12:55', '2025-11-22 16:12:55'),
(300, NULL, NULL, 'vdeckow@example.net', '$2y$12$5WdZk8IiZZcEJwcaG/TL.eHUrOE2HWP9G5x5ZphL.B59dkhpOAE9e', 'Reese', 'Langosh', '0959902393', NULL, 'Other', 'Hai Phong', 'Flossieland', NULL, 'Volunteer', NULL, 1, 1, '2025-11-08 22:03:20', 'QyLWQtKeMz', '2025-11-22 16:12:55', '2025-11-22 16:12:55'),
(301, NULL, NULL, 'blanda.jan@example.net', '$2y$12$yln2qL0CxYvT.lo2dbRxieHtysfsZD4tGI6GItEl5xynI9iDVdNea', 'Broderick', 'Vandervort', NULL, NULL, 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00dd77?text=people+velit', 1, 1, NULL, 'Zxe2C4jjyq', '2025-11-22 16:12:55', '2025-11-22 16:12:55'),
(302, NULL, NULL, 'collier.aylin@example.com', '$2y$12$Z6u0pTi9j7T0pmjp0PtMm.wmw8YJqsF2X.ioVNcqBe9YPPkaHZy1y', 'Lea', 'Donnelly', '0960326885', '1974-12-20', 'Other', 'Ho Chi Minh', NULL, '979 Nolan Villages Suite 143\nSouth Jaquelineshire, WI 63569', 'Volunteer', NULL, 1, 1, NULL, '6MMkMhMStm', '2025-11-22 16:12:56', '2025-11-22 16:12:56'),
(303, NULL, NULL, 'elroy.torp@example.org', '$2y$12$6qGVvX4NnpLsx.DCrG8HK.r0Cga18lxiEP7LI00IEB4fhR9RLQqWu', 'Maureen', 'Sawayn', '0975681675', '1989-05-13', 'Male', 'Can Tho', 'Koeppside', '54007 Elaina Trace Suite 784\nEast Carmenmouth, MO 61271-1562', 'Volunteer', NULL, 0, 1, '2025-11-10 15:43:49', '4cASSXYGUI', '2025-11-22 16:12:56', '2025-11-22 16:12:56'),
(304, NULL, NULL, 'bahringer.leonor@example.net', '$2y$12$b5jFAErF.Wie675K59O2Du.X60zMhZ3aXH1uB5e/CJ.JwfWSwbTkK', 'Eliezer', 'Hegmann', '0943636267', NULL, 'Female', 'Can Tho', 'Rainashire', '9514 Koss Wells Apt. 058\nSouth Durwardfort, MO 72773', 'Volunteer', 'https://via.placeholder.com/200x200.png/00eebb?text=people+voluptatem', 1, 1, NULL, 'p77RhTDJnX', '2025-11-22 16:12:56', '2025-11-22 16:12:56'),
(305, NULL, NULL, 'henderson73@example.org', '$2y$12$0RzfGpOjK9sYWCVUZcL8kuPjXc/sZUMswHLskFmQAxUOoWPwrOsvW', 'Vickie', 'Hettinger', '0919653487', NULL, 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/006622?text=people+officiis', 0, 1, '2025-10-25 02:10:26', '3FA1s2t6Q8', '2025-11-22 16:12:57', '2025-11-22 16:12:57'),
(306, NULL, NULL, 'zgleichner@example.org', '$2y$12$I4d8q/7xg/hNP8grnxBpwukvd2bL8e81pxiuddWPSCvroMr.BHDOa', 'Angeline', 'Schaefer', NULL, '1978-09-14', 'Other', 'Da Nang', 'Port Casimer', NULL, 'Volunteer', NULL, 0, 1, NULL, 'fQoopuwo3o', '2025-11-22 16:12:57', '2025-11-22 16:12:57'),
(307, NULL, NULL, 'khayes@example.net', '$2y$12$ZWPeRKaYcDlFzFG4oPCjTe0v7XgxhwJ4.jNcKAaC.JqBvtUcBIDdW', 'Leo', 'Becker', NULL, NULL, 'Female', 'Ho Chi Minh', NULL, '2575 Gorczany Mountain Apt. 827\nFayberg, TX 51749-0184', 'Volunteer', NULL, 0, 1, NULL, 'dT6DHcjAkk', '2025-11-22 16:12:57', '2025-11-22 16:12:57'),
(308, NULL, NULL, 'aiyana08@example.com', '$2y$12$iRCENxObx57e8yRpqYhM5uFwt8MZ4/BKGl3.ljeYpge.OKPRgsRLK', 'Clyde', 'Schroeder', NULL, NULL, 'Other', 'Da Nang', 'West Margretville', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/006677?text=people+voluptatem', 0, 1, NULL, '4QV6lnrGCj', '2025-11-22 16:12:57', '2025-11-22 16:12:57'),
(309, NULL, NULL, 'sorn@example.com', '$2y$12$fOfl/A/5kGlifM02JnUGRu//OEjyF3zwhZC2XTLGNjKH2e.gUE6eC', 'Rossie', 'Hermann', '0978425437', NULL, 'Male', 'Hanoi', 'Summermouth', NULL, 'Volunteer', NULL, 1, 1, NULL, 'T9IxPaVSv5', '2025-11-22 16:12:58', '2025-11-22 16:12:58'),
(310, NULL, NULL, 'rickie.hartmann@example.org', '$2y$12$T2zybSrQLtnO8RIrs2EBw.qs5z99bYbMBzTkLfoPHfMrVPkgZNtgi', 'Neal', 'Lynch', NULL, NULL, 'Other', 'Hanoi', 'South Pearlie', NULL, 'Volunteer', NULL, 0, 1, '2025-11-20 09:38:36', 'e4kqaTtfUn', '2025-11-22 16:12:58', '2025-11-22 16:12:58'),
(311, NULL, NULL, 'rachelle.ebert@example.net', '$2y$12$Y8J54SlbfdLygHqBnhnMkuC1PDqR2T4.ZfMII/FWxC31gHApUkH3O', 'Torrance', 'Jast', NULL, '1974-03-21', 'Male', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc88?text=people+aut', 0, 1, NULL, 'v3P0KZntaA', '2025-11-22 16:12:58', '2025-11-22 16:12:58'),
(312, NULL, NULL, 'bcole@example.com', '$2y$12$ZOZH6nsp4fOuRe5NZInAWesuDEBDHn/9TYKGOoOFjH85GeT1.ijXe', 'Gloria', 'McCullough', '0925976287', NULL, 'Other', 'Can Tho', NULL, '3208 Mills Shore Apt. 617\nNorth Tanner, KY 98830-5953', 'Volunteer', NULL, 1, 1, NULL, 'd4IZx9sDgx', '2025-11-22 16:12:59', '2025-11-22 16:12:59'),
(313, NULL, NULL, 'smith.jackeline@example.com', '$2y$12$F0Zq2bl3AoK9h2LTCz6rg..wc4jaTjfc0rvdx09jBe91OcPfw5Tf6', 'Rita', 'Purdy', '0949851076', NULL, 'Male', 'Hanoi', NULL, '5614 Mavis Green\nLake Kara, KS 38957', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddcc?text=people+nam', 1, 1, NULL, 'w0i2hdbDXo', '2025-11-22 16:12:59', '2025-11-22 16:12:59'),
(314, NULL, NULL, 'jakubowski.marina@example.org', '$2y$12$qSwzZc2MSbGz.if5L44N2OKCv4dnU3WzeODc.qPEBnq/dmANca0Dy', 'Kristy', 'Kling', '0914608647', NULL, 'Female', 'Hanoi', NULL, '1002 Wilhelmine Islands\nArlochester, MA 69587', 'Volunteer', NULL, 1, 1, '2025-10-28 11:26:21', 'aU2FcpUzF7', '2025-11-22 16:12:59', '2025-11-22 16:12:59'),
(315, NULL, NULL, 'narmstrong@example.com', '$2y$12$WriRl2MKoViXTdwmNXSLX.OvWzLyqxPcpLP11nDA6RjI5k9FhdKJ6', 'Joey', 'Baumbach', '0973735959', NULL, 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000044?text=people+quos', 0, 1, '2025-11-18 18:26:16', '3UW5qCIoPp', '2025-11-22 16:12:59', '2025-11-22 16:12:59'),
(316, NULL, NULL, 'elza.stamm@example.org', '$2y$12$Qy5M8QH2nIEJXYa8Gg7FoexrCw1QZf8MmrLJJ6/E.k3ZU026VrZVm', 'Godfrey', 'Mraz', NULL, NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-10-30 00:52:19', 'I749t7VhAY', '2025-11-22 16:13:00', '2025-11-22 16:13:00'),
(317, NULL, NULL, 'keffertz@example.net', '$2y$12$wRu7d5oKzyhPLfHnfAJHx.nFPvSfw/s/KkGIoCwB2P39rXbJT5Vvq', 'Robb', 'Berge', '0912061377', '1966-10-08', 'Other', 'Da Nang', 'Port Jessy', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+odio', 0, 1, NULL, 'biw8fRuvIs', '2025-11-22 16:13:00', '2025-11-22 16:13:00'),
(318, NULL, NULL, 'brock95@example.com', '$2y$12$HBl398NwhRQneJvJsJlbp.rKJ65rdI0ZaSPeiSQWwfQ9GfKDCEDJe', 'Paris', 'Quitzon', NULL, '1970-09-24', 'Male', 'Hanoi', 'Lailamouth', '2006 Mann Cove\nEast Anabelstad, KY 79128', 'Volunteer', NULL, 0, 1, NULL, 'GncfH30DlI', '2025-11-22 16:13:00', '2025-11-22 16:13:00'),
(319, NULL, NULL, 'martin98@example.org', '$2y$12$K.yvi50u4VubmyOOXt/5fOLAyJF2hGDN4U24ymbZPd0lUcbXurKG.', 'Mauricio', 'Conroy', NULL, '1966-07-28', 'Female', 'Can Tho', NULL, '6497 O\'Kon Lights\nOkunevashire, ME 65396', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ddff?text=people+illo', 1, 1, '2025-10-31 23:44:43', 'B84Xd0ZRXp', '2025-11-22 16:13:00', '2025-11-22 16:13:00'),
(320, NULL, NULL, 'bgoyette@example.net', '$2y$12$ylstrlQSQxRJJrqQXbcLf.DFIS20yV6K6BCkP1qONL4V.qScS.uJW', 'Makenzie', 'Treutel', '0994962695', '1975-12-09', 'Female', 'Hanoi', NULL, '18831 Kennith Forest\nEast Jakobborough, TX 30415', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+voluptas', 0, 1, '2025-11-22 08:36:18', 'QIPHtgEcAX', '2025-11-22 16:13:01', '2025-11-22 16:13:01'),
(321, NULL, NULL, 'ternser@example.com', '$2y$12$Pqv4KQ9F5MOvbqOsKkEdkuoKWVFdQYJN81qm7QOnVmsa/hoTcY1Kq', 'Rubye', 'Kunze', NULL, NULL, 'Other', 'Hanoi', 'Klingburgh', '75901 Karli Lodge Suite 718\nMallorymouth, TN 89089-2416', 'Volunteer', 'https://via.placeholder.com/200x200.png/009977?text=people+assumenda', 1, 1, NULL, 'K61ZbDLkyb', '2025-11-22 16:13:01', '2025-11-22 16:13:01'),
(322, NULL, NULL, 'margarete.bradtke@example.net', '$2y$12$pPylnh7JhwWyoyy0THCOJuaB6x/GJ1OjNCYc7/9IWzVC9V1ADpqbi', 'Gonzalo', 'Abbott', '0908991762', NULL, 'Female', 'Can Tho', 'Brownville', '35558 Hoppe Mission Suite 456\nPort Domenictown, CO 86353-9717', 'Volunteer', NULL, 1, 1, '2025-11-12 04:19:36', 'facdwjDlIT', '2025-11-22 16:13:01', '2025-11-22 16:13:01'),
(323, NULL, NULL, 'npurdy@example.org', '$2y$12$s8/8KpiK1u9diVvy.F2cb.h0F4K3vRAQP6j7svu/ysJ/ZfxEZZOPm', 'Hailee', 'Kutch', '0993490880', '1984-10-12', 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00cc99?text=people+quo', 1, 1, '2025-11-16 08:26:00', 'DjjHnEq4aW', '2025-11-22 16:13:02', '2025-11-22 16:13:02'),
(324, NULL, NULL, 'molly12@example.com', '$2y$12$gFJrLHuGFPNB.jUJeV33K.Us3ZExS5I5gmeXAP7gKti1U8XQOJOay', 'Virgil', 'O\'Hara', '0972901256', NULL, 'Male', 'Hanoi', NULL, '631 Rosetta Fall\nKeatonfurt, CT 69585', 'Volunteer', NULL, 1, 1, '2025-11-18 19:54:34', 'APlJPpSPQR', '2025-11-22 16:13:02', '2025-11-22 16:13:02'),
(325, NULL, NULL, 'hsporer@example.org', '$2y$12$gB7l9b5Uh.U7cgWXq58ThO/vdVBuseYYka0Gjwx3h5rm7ct6X/WoS', 'America', 'Watsica', '0981388480', '1993-09-19', 'Female', 'Ho Chi Minh', NULL, '36898 Abbigail Cove\nSchowalterfurt, MO 17634-5350', 'Volunteer', NULL, 0, 1, NULL, 'EPriCgcODd', '2025-11-22 16:13:02', '2025-11-22 16:13:02'),
(326, NULL, NULL, 'fhuels@example.org', '$2y$12$q1YNXkNqd5KoskR1bPABluLTTj8mjZgntTN/oeAeGCpWkx.dC1qm.', 'Forest', 'Brakus', '0918728643', NULL, 'Other', 'Hanoi', 'Dickensstad', '73199 Deanna Court\nPort Zoiemouth, TN 81419-4781', 'Volunteer', 'https://via.placeholder.com/200x200.png/006644?text=people+ea', 1, 1, NULL, 'cwzuksAjJL', '2025-11-22 16:13:02', '2025-11-22 16:13:02'),
(327, NULL, NULL, 'anibal24@example.com', '$2y$12$x3yCiYm6u4EHzD5poWPY3.XezK1du75dIWFfWB7gEAN.YEVbKFARK', 'Dina', 'Feeney', NULL, '1984-06-06', 'Other', 'Da Nang', 'Moshehaven', NULL, 'Volunteer', NULL, 1, 1, NULL, 'g5jJvkajrW', '2025-11-22 16:13:03', '2025-11-22 16:13:03'),
(328, NULL, NULL, 'lawson85@example.org', '$2y$12$fxI3GfEwhnpXxQmUOcTv5OwfVNjNXs7zshPO4KK7Y7m35l2dfPFyy', 'Waino', 'Armstrong', NULL, NULL, 'Other', 'Can Tho', NULL, '2010 Goldner Underpass Suite 432\nEast Fordview, MN 08726-4954', 'Volunteer', NULL, 1, 1, NULL, 'RrFlDiw98F', '2025-11-22 16:13:03', '2025-11-22 16:13:03'),
(329, NULL, NULL, 'braun.gregory@example.org', '$2y$12$n9cdwupRUaGSo4Qoko4preRXf32fT2YFbBpzHvLiP7t3hXzUi2.Pm', 'Eleanora', 'Parker', '0909629414', NULL, 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008855?text=people+inventore', 1, 1, '2025-11-06 06:27:27', 'ERPH1yonPe', '2025-11-22 16:13:03', '2025-11-22 16:13:03'),
(330, NULL, NULL, 'lubowitz.beulah@example.org', '$2y$12$BaqmVORXlcdv26BbNbi2ouTWG6wSA2j3.OcskUIXJN3C2tdyvwwxu', 'Darian', 'Littel', NULL, NULL, 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00ee66?text=people+ea', 1, 1, '2025-11-17 22:07:27', '6vzOywk9Ia', '2025-11-22 16:13:03', '2025-11-22 16:13:03'),
(331, NULL, NULL, 'stanton26@example.com', '$2y$12$C7jPDEbOdrwgr3u7Mfgn/Ofteg0ZqfQpPOhiTk2Hu/hhKFtgttkPO', 'Mohammad', 'Towne', NULL, '1985-02-15', 'Male', 'Can Tho', 'Windlerton', '723 Avery Prairie Apt. 368\nWillstad, FL 85412', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ff77?text=people+exercitationem', 1, 1, '2025-11-19 22:12:36', 'Web64j6Jcj', '2025-11-22 16:13:04', '2025-11-22 16:13:04'),
(332, NULL, NULL, 'lupe.gerlach@example.org', '$2y$12$/F3J.4CXtZWnU9VDQ7IRc.pibRl8jei6n1K0MPKu8e5pYpxhtMvcO', 'Alysson', 'Maggio', '0972122761', NULL, 'Other', 'Hai Phong', NULL, '335 Randy Falls\nFranciscoville, RI 02304-3424', 'Volunteer', NULL, 0, 1, '2025-11-18 03:31:34', 'Ny8LhfFI3P', '2025-11-22 16:13:04', '2025-11-22 16:13:04'),
(333, NULL, NULL, 'muller.ima@example.org', '$2y$12$IEI0wnJvF0tqJrTBdIJB/uwkV.mAsHubB5MoE0PP..lLsKqkhMPo6', 'Ulises', 'Ryan', NULL, '2004-07-23', 'Male', 'Can Tho', 'Port Lacyborough', '423 Michaela Club\nFerryport, TN 06248', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+sint', 0, 1, '2025-11-03 17:47:43', '4nO6b4BByw', '2025-11-22 16:13:04', '2025-11-22 16:13:04'),
(334, NULL, NULL, 'feil.alan@example.org', '$2y$12$nw0QeuIcx12QcXT3GC2.pu4WhAjrA76HTmpiWxL6eNzBK3VkXNnw2', 'Anthony', 'Fisher', NULL, NULL, 'Male', 'Da Nang', 'East Jordan', '620 Edmund Lights Suite 497\nRempelmouth, NC 35861-7842', 'Volunteer', 'https://via.placeholder.com/200x200.png/002211?text=people+ullam', 0, 1, NULL, 'BAYDWyjmAX', '2025-11-22 16:13:05', '2025-11-22 16:13:05'),
(335, NULL, NULL, 'grosenbaum@example.net', '$2y$12$hZ56U/WbzUiES3FVMKEPlea2jCldrLAhtE1zDyxX7cmqWOV6eSek2', 'D\'angelo', 'Schumm', '0965471631', NULL, 'Female', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/001133?text=people+omnis', 1, 1, NULL, 'EYG8OvEAej', '2025-11-22 16:13:05', '2025-11-22 16:13:05'),
(336, NULL, NULL, 'virginie.sawayn@example.org', '$2y$12$l.tV9P21a4gRvKTjdihqvemUiNzxGbqBJ4Y.i07m.RkEsrLsJYc46', 'Dejah', 'Dach', NULL, NULL, 'Male', 'Da Nang', 'East Ubaldo', '47277 Crooks Parks\nBertramstad, IN 12626', 'Volunteer', NULL, 0, 1, '2025-10-28 16:30:46', '9MMx85vihg', '2025-11-22 16:13:05', '2025-11-22 16:13:05'),
(337, NULL, NULL, 'phyllis.dicki@example.org', '$2y$12$6ywyqcEVGaEzdxjLO0pO1eSxdKgnFw4Qs17TRfOsOWLkJXALzyKhm', 'Mafalda', 'Veum', NULL, '1990-11-19', 'Other', 'Can Tho', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/000044?text=people+molestias', 1, 1, NULL, '1toh317tiZ', '2025-11-22 16:13:05', '2025-11-22 16:13:05'),
(338, NULL, NULL, 'royce46@example.org', '$2y$12$DukDeX6Z3zNAmiooP4A7PuUD740FqdbpcovEd0IVbJEx5CB5Kjo7C', 'Alanis', 'Corwin', '0901809106', NULL, 'Female', 'Hai Phong', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-17 15:09:37', 'i55RgLsmVU', '2025-11-22 16:13:06', '2025-11-22 16:13:06'),
(339, NULL, NULL, 'kayla.bayer@example.net', '$2y$12$mklHyOmgUyw7F3ZgYosYK.acNaC23e015EQdXzEbSJo.4RNAESY22', 'Kathryn', 'Kautzer', '0981450147', '1995-04-09', 'Other', 'Hai Phong', NULL, '24572 O\'Keefe Corner\nUrbanchester, MO 86391-0795', 'Volunteer', NULL, 1, 1, '2025-11-19 22:13:56', 'V6UEMBt3fE', '2025-11-22 16:13:06', '2025-11-22 16:13:06'),
(340, NULL, NULL, 'constantin46@example.com', '$2y$12$/To6a/ZWE5VewrE0CdnX/e8c.WoOYciK2PUaAcIlEhJzFACnrHYni', 'Hosea', 'Pollich', '0985049432', '1983-03-16', 'Other', 'Da Nang', 'Koelpinberg', '84955 Pat Well\nPort Jayson, IN 78929-9907', 'Volunteer', NULL, 0, 1, '2025-11-18 01:59:48', 'dgncm6Ix6B', '2025-11-22 16:13:06', '2025-11-22 16:13:06'),
(341, NULL, NULL, 'blanca.reynolds@example.net', '$2y$12$QoEmOjTkYZUWfVr7I.VrkeWHyg2BUJJ.S47p52kPytYdmhtZHtyDW', 'Melvin', 'Walker', NULL, NULL, 'Other', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/001122?text=people+quae', 1, 1, '2025-11-11 13:24:54', 'JEgXqUaDEX', '2025-11-22 16:13:06', '2025-11-22 16:13:06'),
(342, NULL, NULL, 'jmoore@example.org', '$2y$12$ipolv/PEdn80i9LU1Vkrq.fYQX/tvBN49JEHy3.AassHkiaypQS0G', 'Estel', 'Nienow', NULL, NULL, 'Female', 'Da Nang', 'Jessikaberg', '164 Klocko Crescent Apt. 853\nBotsfordton, AZ 23294', 'Volunteer', NULL, 1, 1, NULL, 'NGtyKDKEGb', '2025-11-22 16:13:07', '2025-11-22 16:13:07'),
(343, NULL, NULL, 'lilla.hagenes@example.org', '$2y$12$m3TK65OuBzkTNamVebnxoelpJae4W2AWW0SOAY31Y2DqeEWYj7iuK', 'Brandon', 'Halvorson', NULL, NULL, 'Other', 'Ho Chi Minh', NULL, '29394 Dooley Forks Apt. 171\nWest Misael, NC 60371-2871', 'Volunteer', NULL, 1, 1, '2025-11-08 16:03:02', 'XG1dCQk8ud', '2025-11-22 16:13:07', '2025-11-22 16:13:07'),
(344, NULL, NULL, 'wsimonis@example.net', '$2y$12$U5r8d3pt64n9R3ZaUzUi/OVQW/qv3n4BVcNXGp5lDb8xylguNGROG', 'Chanelle', 'Kutch', '0921569602', NULL, 'Other', 'Hanoi', NULL, '58900 McCullough Lane Suite 610\nKatelynborough, AR 77814-0793', 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa88?text=people+officiis', 1, 1, '2025-10-27 13:56:12', 'YUBr7rxBbx', '2025-11-22 16:13:07', '2025-11-22 16:13:07'),
(345, NULL, NULL, 'gabriella33@example.org', '$2y$12$fKxUJk0kHb8i7xlw5.VE8uZr.4Tili/aszHSsl3BkD3JHAf8u75QS', 'Kathryn', 'Cartwright', '0940223666', '1979-06-09', 'Female', 'Ho Chi Minh', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/0022aa?text=people+aut', 0, 1, NULL, 'NR48i35Bjt', '2025-11-22 16:13:07', '2025-11-22 16:13:07'),
(346, NULL, NULL, 'millie68@example.org', '$2y$12$CXwJ0BIGOY1KtzBUVPZeY.2DdH3JafB/gXIOVMXF9uRWGA7iXF3nG', 'Kailyn', 'Wiza', NULL, '1981-09-27', 'Male', 'Ho Chi Minh', 'South Alivia', '9678 Gay Throughway Suite 797\nPort Shawn, MO 94878-9519', 'Volunteer', 'https://via.placeholder.com/200x200.png/00ccee?text=people+occaecati', 1, 1, NULL, 'bajF8b4gKu', '2025-11-22 16:13:08', '2025-11-22 16:13:08'),
(347, NULL, NULL, 'bradtke.makenna@example.com', '$2y$12$zDABv.2RTOgtmp3ociYtneYdsOyLpbRiRSvOvEA8DU3StaR8dkewi', 'Mohammed', 'VonRueden', '0914873208', '2005-05-24', 'Male', 'Can Tho', NULL, NULL, 'Volunteer', NULL, 1, 1, NULL, 'oUgyOAi7CN', '2025-11-22 16:13:08', '2025-11-22 16:13:08'),
(348, NULL, NULL, 'vada22@example.com', '$2y$12$tK7QTmh8gij1h7UN/8V5Y.fM6TvHkuoLv9KYbBcyoqNpCDCM2rCoG', 'Princess', 'Heathcote', NULL, NULL, 'Other', 'Hai Phong', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/009911?text=people+commodi', 1, 1, NULL, 'GAsX3EVw6u', '2025-11-22 16:13:08', '2025-11-22 16:13:08'),
(349, NULL, NULL, 'lindgren.dewayne@example.org', '$2y$12$2eXOaha/Jhj2uZ7bwWhx1OtiPBd2ykRB6tVmhLjiUbPmckLeHu02i', 'Idella', 'Mertz', NULL, '1983-09-03', 'Female', 'Can Tho', 'North Shakiramouth', '4353 Griffin Garden Suite 786\nWest Glenda, NY 06906-5787', 'Volunteer', 'https://via.placeholder.com/200x200.png/0000ff?text=people+facilis', 0, 1, '2025-11-07 09:04:49', '22vKVcn68b', '2025-11-22 16:13:08', '2025-11-22 16:13:08'),
(350, NULL, NULL, 'jayce.romaguera@example.net', '$2y$12$lDIheeuep8hoVr.WOvuJGu26I89Kj2Ui6GqiazbTwOB6SCOPXDDgi', 'Carlo', 'Hagenes', NULL, NULL, 'Male', 'Can Tho', 'Vernachester', '83582 Bailey Fields\nWest Barbaraton, ND 34433', 'Volunteer', NULL, 0, 1, NULL, '5YJNmjgYA4', '2025-11-22 16:13:09', '2025-11-22 16:13:09'),
(351, NULL, NULL, 'barbara74@example.com', '$2y$12$OPznI321Z6Uftv6oUk0zBOLu.3cC9qaHqesUx9.ApQk4zkR5hasNa', 'Levi', 'Bauch', '0958379965', '1966-05-08', 'Other', 'Can Tho', NULL, '57357 Lera Roads Apt. 960\nRandallborough, ID 76906-1412', 'Volunteer', 'https://via.placeholder.com/200x200.png/002222?text=people+perspiciatis', 0, 1, '2025-11-16 12:39:12', 'YySZ88KHHM', '2025-11-22 16:13:09', '2025-11-22 16:13:09'),
(352, NULL, NULL, 'zemlak.nicholaus@example.org', '$2y$12$oYFLqGX15bAFpQBTo08xPe9bHNhmrHz7VRRkOOFLy2iivUudRxrOC', 'Gwendolyn', 'Hammes', NULL, '2000-12-30', 'Female', 'Can Tho', 'East Pete', '72331 Carmine Spur Apt. 375\nLake Simone, OH 08014-8167', 'Volunteer', NULL, 1, 1, NULL, 'p8ADGQ1NPB', '2025-11-22 16:13:09', '2025-11-22 16:13:09'),
(353, NULL, NULL, 'weber.fidel@example.org', '$2y$12$i5Q6.8Mto87DFCEyDhKg7eM0UZ5eEEk6/NleIvipOXkE.jwmLdgKa', 'Macey', 'Zulauf', NULL, '1989-05-31', 'Male', 'Can Tho', NULL, '7464 Dayana Extension\nWest Katherine, AR 97018', 'Volunteer', 'https://via.placeholder.com/200x200.png/0088cc?text=people+voluptate', 0, 1, '2025-10-29 22:21:35', 'BoDBm4lQ7y', '2025-11-22 16:13:10', '2025-11-22 16:13:10'),
(354, NULL, NULL, 'ddietrich@example.org', '$2y$12$rrUn.PqgaR2.oquce5rwgOV3i3hSxAAtE9JyCQAJnV3rr01qaWF3.', 'Verona', 'Conn', NULL, NULL, 'Female', 'Hai Phong', 'South Mackton', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008866?text=people+illo', 0, 1, '2025-11-05 03:43:47', 'sedMuDYh7s', '2025-11-22 16:13:10', '2025-11-22 16:13:10'),
(355, NULL, NULL, 'froberts@example.net', '$2y$12$fBhNn5raLg2lg1DCFEK8G.S/i9RtTl.1Drp6dmzRPXEpzJaXTK3OS', 'Elena', 'Herman', '0987056838', NULL, 'Male', 'Can Tho', 'Presleymouth', '89975 Bartoletti Place\nEast Alexahaven, IN 49231', 'Volunteer', 'https://via.placeholder.com/200x200.png/006622?text=people+adipisci', 1, 1, NULL, 'BoyMnSccGR', '2025-11-22 16:13:10', '2025-11-22 16:13:10'),
(356, NULL, NULL, 'daniella65@example.org', '$2y$12$Nh0aai3ImM8qwD56yH7.kO97UEFuvHAnyphMBUrI5XQZItKJROF4K', 'Rosalinda', 'Swift', NULL, '1988-10-11', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', NULL, 0, 1, NULL, 'Hqeb7PPnaf', '2025-11-22 16:13:10', '2025-11-22 16:13:10'),
(357, NULL, NULL, 'mosciski.joshua@example.org', '$2y$12$1wDxKPO//eU11TGJdBXiH.wf0DwYIt3TKG5ltdk4s6y5e29LQh9Qm', 'Ashleigh', 'Daugherty', NULL, NULL, 'Female', 'Can Tho', 'Labadieport', NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00aa44?text=people+non', 0, 1, '2025-10-27 15:15:04', 'jh8R1s6x2j', '2025-11-22 16:13:11', '2025-11-22 16:13:11'),
(358, NULL, NULL, 'zoie.tromp@example.org', '$2y$12$4ufijz402q.3..PfzI9kJe.1rkk42f94g47zUESTCkM5MVNvAIGO.', 'Marques', 'Leffler', NULL, '1966-08-14', 'Male', 'Hanoi', NULL, '85888 Merlin Radial\nTevinside, NE 39044', 'Volunteer', NULL, 1, 0, '2025-11-13 04:55:20', 'XRQtkDPFvd', '2025-11-22 16:13:11', '2025-11-27 09:56:30'),
(359, NULL, NULL, 'beier.emmet@example.org', '$2y$12$r8.CYgKo228aPADrv7jolOYytcNRpxHzPv.ZO6qD0airGuoMOc46K', 'Isabelle', 'Torp', '0933670838', NULL, 'Male', 'Da Nang', NULL, NULL, 'Volunteer', NULL, 0, 1, '2025-11-22 13:13:04', 'gG4tlBiVSW', '2025-11-22 16:13:11', '2025-11-22 16:13:11'),
(360, NULL, NULL, 'bwalker@example.org', '$2y$12$qG0/wo9QQsNB6Dk0YzhqTOL5xtRtDnGUgYy79XjHoRp91j6T0FvCi', 'Ned', 'Beier', NULL, NULL, 'Male', 'Da Nang', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/00bbee?text=people+quos', 1, 1, '2025-11-05 17:33:41', 'uXeLVyPv4E', '2025-11-22 16:13:11', '2025-11-22 16:13:11'),
(361, NULL, NULL, 'hauck.ashley@example.net', '$2y$12$dHL.wpXAO5IsdzH683EXFOTluqAB.IcZdxBpMY1T0jLL654MFStDW', 'Rachelle', 'Shields', '0922990118', '1989-05-19', 'Male', 'Hanoi', NULL, NULL, 'Volunteer', 'https://via.placeholder.com/200x200.png/008866?text=people+iste', 1, 1, '2025-11-03 19:05:42', 'U8vjmO8tjJ', '2025-11-22 16:13:12', '2025-11-22 16:13:12'),
(362, NULL, NULL, 'dathoami2k5@gmail.com', '$2y$12$tt0daJWV3PkATxoWJiXOuOl0g0ZJkchKPNGRv61/DeGL4pFZEDbUK', 'Đạt', 'Hoàng Quang', NULL, NULL, NULL, NULL, NULL, NULL, 'Volunteer', 'https://lh3.googleusercontent.com/a/ACg8ocKEwMxwLDUag3LXXhKK6awhnEz6ctqtyIvEVdY5vnSnZJUExfI=s96-c', 1, 1, NULL, NULL, '2025-11-23 16:12:03', '2025-11-23 16:12:03'),
(363, NULL, NULL, 'goodjobem2@gmail.com', '$2y$12$oA/ZBei3uq9xuIVhe2YkOuy6y6cvr.srVjhb3JcJcDko.KOoCWoRa', 'quý', 'duy', '0912345677', '2005-01-01', 'Female', 'Da Nang', 'Dong Da', 'hoa son quy', 'Volunteer', NULL, 1, 1, NULL, NULL, '2025-11-23 16:31:50', '2025-11-23 16:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `video_calls`
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
-- Table structure for table `volunteer_activities`
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
-- Dumping data for table `volunteer_activities`
--

INSERT INTO `volunteer_activities` (`activity_id`, `volunteer_id`, `opportunity_id`, `org_id`, `activity_date`, `hours_worked`, `activity_description`, `status`, `verified_by`, `verified_date`, `impact_notes`, `created_at`) VALUES
(1, 46, 25, 'org_6921e0d3a19fe', '2025-11-12', 9.01, 'Quam ut aut at vitae et sint libero. Reprehenderit vel aperiam laborum reprehenderit dolore. Ipsa alias odio est aut amet voluptatibus officiis. Quia eligendi non ad non.', 'Verified', 56, '2025-11-09 02:40:53', NULL, '2025-11-22 16:12:06'),
(2, 46, 25, 'org_6921e0d3a19fe', '2025-10-02', 2.88, 'Molestias dicta repudiandae in reprehenderit architecto molestiae. Quia placeat consectetur et omnis id sed. Et quo ut laboriosam porro tenetur aut.', 'Verified', 56, '2025-11-17 11:39:04', NULL, '2025-11-22 16:12:06'),
(3, 46, 25, 'org_6921e0d3a19fe', '2025-10-28', 1.81, NULL, 'Verified', 56, '2025-11-20 03:00:39', NULL, '2025-11-22 16:12:06'),
(4, 46, 25, 'org_6921e0d3a19fe', '2025-10-18', 6.45, 'Enim voluptatibus reiciendis beatae amet rerum. Molestiae assumenda dolore consequatur. Est sint esse magni iusto eveniet.', 'Verified', 56, '2025-11-07 17:52:51', NULL, '2025-11-22 16:12:06'),
(5, 46, 25, 'org_6921e0d3a19fe', '2025-10-09', 5.96, NULL, 'Verified', 56, '2025-11-21 15:29:41', 'Recusandae qui unde vel quia modi.', '2025-11-22 16:12:06'),
(6, 28, 2, 'org_6921e012bdfff', '2025-10-06', 9.08, 'Odit est vero corrupti ex iste. Autem occaecati odio commodi recusandae. Voluptas ut aspernatur suscipit impedit veritatis rerum explicabo. Eum tenetur possimus tempore dolorum rerum dolorum quod.', 'Verified', 1, '2025-10-30 15:40:13', NULL, '2025-11-22 16:12:06'),
(7, 10, 100, 'org_6921e0d3aa933', '2025-11-07', 9.78, 'Amet et et quod natus est voluptas et. Sit assumenda nobis cupiditate nihil. Provident saepe non exercitationem voluptas ducimus quia.', 'Verified', 69, '2025-11-18 21:27:20', NULL, '2025-11-22 16:12:06'),
(8, 10, 100, 'org_6921e0d3aa933', '2025-11-07', 9.58, NULL, 'Verified', 69, '2025-11-10 10:40:46', 'Aut nam ut commodi explicabo explicabo quibusdam.', '2025-11-22 16:12:06'),
(9, 12, 121, 'org_6921e0d3ac78d', '2025-10-22', 7.71, NULL, 'Verified', 72, '2025-11-12 19:34:11', NULL, '2025-11-22 16:12:06'),
(10, 12, 121, 'org_6921e0d3ac78d', '2025-11-09', 9.85, 'Maiores optio non quo consequatur doloribus enim. Rerum corrupti quod fugit ratione voluptas. Blanditiis ut et quod aperiam.', 'Verified', 72, '2025-11-06 01:10:30', 'Assumenda ipsa laborum voluptates tempore occaecati voluptates velit.', '2025-11-22 16:12:06'),
(11, 12, 121, 'org_6921e0d3ac78d', '2025-11-06', 10.22, NULL, 'Verified', 72, '2025-10-31 09:51:35', NULL, '2025-11-22 16:12:06'),
(12, 12, 121, 'org_6921e0d3ac78d', '2025-10-17', 7.70, 'Fugit cupiditate debitis deleniti laudantium illo et ratione. Est harum qui delectus repudiandae nulla non enim. Earum non sit esse et modi. Et et ipsum sint dolores amet ut.', 'Verified', 72, '2025-10-27 20:24:30', 'Veniam rem modi provident doloremque necessitatibus.', '2025-11-22 16:12:06'),
(13, 37, 7, 'org_6921e012bdfff', '2025-11-04', 1.98, NULL, 'Verified', 1, '2025-11-04 10:49:01', NULL, '2025-11-22 16:12:06'),
(14, 37, 7, 'org_6921e012bdfff', '2025-10-01', 6.68, NULL, 'Verified', 1, '2025-11-09 12:06:44', NULL, '2025-11-22 16:12:06'),
(15, 37, 7, 'org_6921e012bdfff', '2025-10-24', 4.16, 'Eum fugiat rerum quibusdam veritatis. Aut voluptate dolorum dignissimos ullam dicta placeat placeat in. Tempore eius a est omnis eius beatae.', 'Verified', 1, '2025-11-18 04:21:49', NULL, '2025-11-22 16:12:06'),
(16, 12, 112, 'org_6921e0d3abd4d', '2025-09-27', 5.97, 'Assumenda nostrum vitae dolore expedita aperiam nobis similique. Quia fugiat provident architecto omnis nostrum non. Dicta porro enim ut impedit soluta. Aut voluptatem voluptas dolore ut omnis.', 'Verified', 71, '2025-10-29 08:28:23', 'Reiciendis magni sapiente ut hic et debitis natus debitis.', '2025-11-22 16:12:06'),
(17, 12, 112, 'org_6921e0d3abd4d', '2025-11-19', 3.35, NULL, 'Verified', 71, '2025-10-27 06:37:53', NULL, '2025-11-22 16:12:06'),
(18, 12, 112, 'org_6921e0d3abd4d', '2025-11-15', 4.42, NULL, 'Verified', 71, '2025-10-29 03:26:26', NULL, '2025-11-22 16:12:06'),
(19, 12, 112, 'org_6921e0d3abd4d', '2025-11-13', 11.69, 'Ad deserunt neque molestias amet. Harum tempora debitis ullam eum perferendis repellendus libero quas. Ipsum at consequatur debitis unde eaque sit.', 'Verified', 71, '2025-10-24 16:26:01', 'Occaecati sit laboriosam nulla quibusdam.', '2025-11-22 16:12:06'),
(20, 7, 112, 'org_6921e0d3abd4d', '2025-10-05', 4.24, NULL, 'Verified', 71, '2025-11-06 09:31:45', 'Quis rerum aut adipisci id aliquam.', '2025-11-22 16:12:06'),
(21, 7, 112, 'org_6921e0d3abd4d', '2025-11-18', 6.29, NULL, 'Verified', 71, '2025-11-03 02:53:12', NULL, '2025-11-22 16:12:06'),
(22, 27, 94, 'org_6921e0d3a9f76', '2025-10-31', 5.68, NULL, 'Verified', 68, '2025-11-12 06:56:05', NULL, '2025-11-22 16:12:06'),
(23, 27, 94, 'org_6921e0d3a9f76', '2025-10-23', 9.90, NULL, 'Verified', 68, '2025-11-19 05:16:14', NULL, '2025-11-22 16:12:06'),
(24, 27, 94, 'org_6921e0d3a9f76', '2025-10-07', 5.71, NULL, 'Verified', 68, '2025-11-18 13:50:44', NULL, '2025-11-22 16:12:06'),
(25, 27, 94, 'org_6921e0d3a9f76', '2025-11-12', 5.67, 'Libero reprehenderit maxime doloribus numquam nisi ut et ea. Atque sit maxime laudantium nobis. Sed accusantium impedit soluta qui culpa qui.', 'Verified', 68, '2025-11-14 11:25:57', NULL, '2025-11-22 16:12:06'),
(26, 23, 89, 'org_6921e0d3a9341', '2025-11-08', 9.64, 'Animi sed non in unde. Aperiam omnis doloremque nihil labore atque eaque.', 'Verified', 67, '2025-11-13 07:13:42', NULL, '2025-11-22 16:12:06'),
(27, 23, 89, 'org_6921e0d3a9341', '2025-11-14', 5.88, 'Voluptatum est quo impedit fuga voluptatem sed. Sed laborum dolore at deleniti. Praesentium consequuntur iure aut est.', 'Verified', 67, '2025-11-05 15:31:59', NULL, '2025-11-22 16:12:06'),
(28, 25, 3, 'org_6921e012bdfff', '2025-09-29', 7.24, 'Soluta ut sit porro sit doloremque inventore nam. Quasi dolorem quia nostrum dolorum. Odit qui perspiciatis laudantium maxime.', 'Verified', 1, '2025-11-09 05:08:52', 'Omnis asperiores in non.', '2025-11-22 16:12:06'),
(29, 25, 3, 'org_6921e012bdfff', '2025-09-29', 7.66, 'Quia veniam voluptatem non et quos. Excepturi et deserunt rerum.', 'Verified', 1, '2025-11-07 12:44:34', NULL, '2025-11-22 16:12:06'),
(30, 25, 3, 'org_6921e012bdfff', '2025-10-26', 8.40, NULL, 'Verified', 1, '2025-11-13 08:48:04', 'Sunt dignissimos quam inventore accusantium veniam fuga.', '2025-11-22 16:12:06'),
(31, 25, 3, 'org_6921e012bdfff', '2025-10-02', 9.21, NULL, 'Verified', 1, '2025-11-20 05:38:48', 'Omnis sed esse aspernatur placeat.', '2025-11-22 16:12:06'),
(32, 7, 109, 'org_6921e0d3ab300', '2025-11-05', 7.76, NULL, 'Verified', 70, '2025-11-11 22:45:05', 'Vero ratione omnis et placeat omnis.', '2025-11-22 16:12:06'),
(33, 7, 109, 'org_6921e0d3ab300', '2025-11-05', 11.87, NULL, 'Verified', 70, '2025-11-04 06:29:56', NULL, '2025-11-22 16:12:06'),
(34, 7, 109, 'org_6921e0d3ab300', '2025-10-03', 11.81, 'Dignissimos voluptas dignissimos cumque ea quasi quis. Sed deserunt delectus blanditiis perferendis. Et dolorem iste provident rerum voluptas.', 'Verified', 70, '2025-10-28 23:31:35', NULL, '2025-11-22 16:12:06'),
(35, 7, 109, 'org_6921e0d3ab300', '2025-10-09', 10.48, NULL, 'Verified', 70, '2025-11-20 07:29:17', NULL, '2025-11-22 16:12:06'),
(36, 7, 109, 'org_6921e0d3ab300', '2025-11-03', 3.88, 'Minima cupiditate reprehenderit dolorem fugit. Nihil officiis voluptas qui ex et consequuntur. Sunt commodi tempora rerum voluptas laborum.', 'Verified', 70, '2025-11-16 03:26:03', 'Et vel quibusdam accusamus sed voluptatem velit veritatis aliquid.', '2025-11-22 16:12:06'),
(37, 51, 53, 'org_6921e0d3a582a', '2025-11-20', 11.68, NULL, 'Verified', 61, '2025-11-22 09:13:16', 'A vel saepe dolor nihil est sit.', '2025-11-22 16:12:06'),
(38, 51, 53, 'org_6921e0d3a582a', '2025-10-18', 9.98, NULL, 'Verified', 61, '2025-11-01 10:35:18', NULL, '2025-11-22 16:12:06'),
(39, 51, 53, 'org_6921e0d3a582a', '2025-11-14', 4.22, NULL, 'Verified', 61, '2025-11-11 00:51:51', NULL, '2025-11-22 16:12:06'),
(40, 51, 53, 'org_6921e0d3a582a', '2025-10-03', 5.20, NULL, 'Verified', 61, '2025-11-10 20:39:46', NULL, '2025-11-22 16:12:06'),
(41, 51, 53, 'org_6921e0d3a582a', '2025-11-02', 1.82, NULL, 'Verified', 61, '2025-11-05 11:23:33', NULL, '2025-11-22 16:12:06'),
(42, 21, 22, 'org_6921e0d3a046b', '2025-10-17', 3.88, 'Et hic laboriosam suscipit id debitis ratione sed. Ducimus quo dolor nemo sunt doloremque ipsa. Deleniti blanditiis aut qui iusto unde. Sit nisi quis fugit alias eos.', 'Verified', 55, '2025-11-05 04:49:06', 'Ea voluptatem ut nostrum commodi totam aut nobis.', '2025-11-22 16:12:06'),
(43, 21, 22, 'org_6921e0d3a046b', '2025-10-29', 10.50, NULL, 'Verified', 55, '2025-10-26 17:56:59', NULL, '2025-11-22 16:12:06'),
(44, 45, 41, 'org_6921e0d3a443d', '2025-10-20', 9.18, 'Ullam nihil iusto aut est quas qui dolore. Quia excepturi repellat consequatur aspernatur. Blanditiis et itaque quae dolores. Corporis totam nisi occaecati rerum quos consectetur minus. Non quibusdam autem atque facere debitis.', 'Verified', 59, '2025-11-15 17:07:07', 'Ut rerum est voluptas laborum exercitationem iure.', '2025-11-22 16:12:06'),
(45, 45, 41, 'org_6921e0d3a443d', '2025-11-06', 5.23, 'Voluptatem enim voluptates explicabo nobis totam. Neque quasi laboriosam nemo est aspernatur ratione. Sapiente inventore nam quidem beatae repellat neque.', 'Verified', 59, '2025-11-06 15:12:10', NULL, '2025-11-22 16:12:06'),
(46, 45, 41, 'org_6921e0d3a443d', '2025-10-05', 1.48, 'Iusto reiciendis numquam sed voluptatibus et quae rerum. Commodi sed eum distinctio. Ex eos dolore cum accusantium autem voluptatem debitis.', 'Verified', 59, '2025-10-30 14:20:00', NULL, '2025-11-22 16:12:06'),
(47, 38, 128, 'org_6921e0d3ad224', '2025-10-26', 7.57, 'Quisquam dolore modi blanditiis id vel quidem ratione. Deleniti amet iusto autem aut aliquid omnis debitis. Reprehenderit sunt eveniet quas sunt perspiciatis aspernatur. Debitis atque ipsum ut.', 'Verified', 73, '2025-11-08 21:08:39', NULL, '2025-11-22 16:12:06'),
(48, 38, 128, 'org_6921e0d3ad224', '2025-10-06', 5.20, 'Porro architecto aut et at porro delectus optio. Ipsam laboriosam ea eaque asperiores sequi voluptatem blanditiis. Et corporis sunt ea expedita dolore. Dolorem exercitationem est dolorem voluptates.', 'Verified', 73, '2025-11-14 11:12:48', NULL, '2025-11-22 16:12:06'),
(49, 38, 128, 'org_6921e0d3ad224', '2025-09-24', 6.82, NULL, 'Verified', 73, '2025-10-25 02:32:48', NULL, '2025-11-22 16:12:06'),
(50, 38, 128, 'org_6921e0d3ad224', '2025-09-29', 3.43, 'Perferendis culpa debitis ad beatae sit molestias optio. Dolore fuga architecto praesentium natus inventore. Tempore rerum est sequi ut natus distinctio distinctio.', 'Verified', 73, '2025-11-09 17:13:31', NULL, '2025-11-22 16:12:06'),
(51, 38, 128, 'org_6921e0d3ad224', '2025-09-24', 1.84, NULL, 'Verified', 73, '2025-11-17 15:54:03', 'Libero facilis occaecati quos dolores fugiat et iusto culpa.', '2025-11-22 16:12:06'),
(52, 39, 14, 'org_6921e0d39f40e', '2025-10-30', 10.05, 'Sint numquam aut saepe aut est. Sit eos laboriosam reiciendis officia. Doloribus magni eveniet placeat. Laborum ducimus ipsam aut enim velit est.', 'Verified', 54, '2025-11-10 19:18:21', NULL, '2025-11-22 16:12:06'),
(53, 39, 14, 'org_6921e0d39f40e', '2025-10-11', 3.32, NULL, 'Verified', 54, '2025-11-06 16:09:26', NULL, '2025-11-22 16:12:06'),
(54, 39, 14, 'org_6921e0d39f40e', '2025-10-03', 2.23, NULL, 'Verified', 54, '2025-11-03 03:30:50', NULL, '2025-11-22 16:12:06'),
(55, 39, 14, 'org_6921e0d39f40e', '2025-11-21', 4.40, 'Dolorem quisquam ea animi. Omnis rerum atque qui earum. Adipisci eos odit voluptatum non. Ducimus dolor et modi totam dolores magni.', 'Verified', 54, '2025-11-04 18:01:03', NULL, '2025-11-22 16:12:06'),
(56, 29, 83, 'org_6921e0d3a7f9c', '2025-11-07', 6.20, NULL, 'Verified', 65, '2025-11-21 21:46:27', NULL, '2025-11-22 16:12:06'),
(57, 12, 27, 'org_6921e0d3a19fe', '2025-11-09', 9.35, 'Amet dolores sed harum ducimus fuga ab sit. Eum dolorem qui id qui. Modi ut atque magni voluptatem. Totam ipsa rerum architecto sed.', 'Verified', 56, '2025-11-22 10:10:21', 'Odio aut quia sunt.', '2025-11-22 16:12:06'),
(58, 36, 78, 'org_6921e0d3a7f9c', '2025-10-22', 3.41, 'Ex et architecto deserunt distinctio. Dolores earum perspiciatis praesentium tempora doloremque quia. Cupiditate impedit commodi nemo dolor eum.', 'Verified', 65, '2025-11-14 05:11:33', NULL, '2025-11-22 16:12:06'),
(59, 36, 78, 'org_6921e0d3a7f9c', '2025-10-07', 4.45, NULL, 'Verified', 65, '2025-11-01 01:22:30', NULL, '2025-11-22 16:12:06'),
(60, 36, 78, 'org_6921e0d3a7f9c', '2025-10-19', 5.15, NULL, 'Verified', 65, '2025-11-05 09:33:14', NULL, '2025-11-22 16:12:06'),
(61, 36, 78, 'org_6921e0d3a7f9c', '2025-11-06', 3.61, NULL, 'Verified', 65, '2025-11-01 02:35:49', 'Quis nisi voluptatem quo dignissimos.', '2025-11-22 16:12:06'),
(62, 36, 78, 'org_6921e0d3a7f9c', '2025-11-17', 8.52, NULL, 'Verified', 65, '2025-11-21 10:31:48', NULL, '2025-11-22 16:12:06'),
(63, 15, 36, 'org_6921e0d3a3ab4', '2025-10-12', 3.66, NULL, 'Verified', 58, '2025-11-17 03:27:11', NULL, '2025-11-22 16:12:06'),
(64, 15, 36, 'org_6921e0d3a3ab4', '2025-11-20', 4.48, NULL, 'Verified', 58, '2025-11-08 11:15:28', NULL, '2025-11-22 16:12:06'),
(65, 15, 36, 'org_6921e0d3a3ab4', '2025-11-16', 11.00, NULL, 'Verified', 58, '2025-11-05 10:20:11', NULL, '2025-11-22 16:12:06'),
(66, 15, 36, 'org_6921e0d3a3ab4', '2025-10-02', 6.27, NULL, 'Verified', 58, '2025-11-18 21:18:02', 'Deleniti nihil reprehenderit consequatur iste eos aliquid temporibus.', '2025-11-22 16:12:06'),
(67, 15, 36, 'org_6921e0d3a3ab4', '2025-10-25', 4.47, NULL, 'Verified', 58, '2025-10-27 22:37:04', 'Enim omnis at et nam et et.', '2025-11-22 16:12:06'),
(68, 36, 114, 'org_6921e0d3abd4d', '2025-11-17', 5.39, 'Nobis consequuntur illum eveniet amet ut eos. Ut voluptas odit aspernatur earum enim aspernatur id inventore. Molestiae voluptatem est necessitatibus illum et. Ut nulla illum ad non tenetur.', 'Verified', 71, '2025-11-08 03:24:21', 'Voluptatem harum iure nemo placeat aut delectus quia quia.', '2025-11-22 16:12:06'),
(69, 36, 114, 'org_6921e0d3abd4d', '2025-11-11', 11.36, NULL, 'Verified', 71, '2025-11-03 14:11:43', 'Vitae asperiores deserunt qui quo ex ipsa aut corrupti.', '2025-11-22 16:12:06'),
(70, 36, 114, 'org_6921e0d3abd4d', '2025-11-04', 1.73, 'Modi at aut et aliquam perspiciatis impedit tempore. Ab facilis repellendus distinctio. Sequi impedit aut minus nisi similique. Suscipit omnis sint facilis occaecati ullam alias.', 'Verified', 71, '2025-11-14 21:36:17', NULL, '2025-11-22 16:12:06'),
(71, 36, 114, 'org_6921e0d3abd4d', '2025-10-25', 9.39, NULL, 'Verified', 71, '2025-11-15 22:03:37', 'Incidunt id aspernatur sequi labore minima.', '2025-11-22 16:12:06'),
(72, 38, 83, 'org_6921e0d3a7f9c', '2025-10-19', 9.48, NULL, 'Verified', 65, '2025-10-26 15:20:09', 'Magni quis consequatur libero nam quasi ipsa eligendi.', '2025-11-22 16:12:06'),
(73, 38, 83, 'org_6921e0d3a7f9c', '2025-10-03', 5.85, 'Quidem ad error sunt ut aliquam et eaque. Eligendi sint fugit nobis consequatur ea repellendus totam sit. Dolorem debitis enim iste quisquam. Labore deleniti odio deserunt nobis quo.', 'Verified', 65, '2025-11-04 14:29:12', 'Similique consectetur adipisci qui quo saepe in rerum.', '2025-11-22 16:12:06'),
(74, 38, 83, 'org_6921e0d3a7f9c', '2025-10-11', 2.44, 'Exercitationem aut pariatur quae perspiciatis repudiandae. Ea in qui autem qui nisi. Explicabo modi id omnis et.', 'Verified', 65, '2025-11-04 23:55:59', NULL, '2025-11-22 16:12:06'),
(75, 38, 83, 'org_6921e0d3a7f9c', '2025-10-08', 1.98, NULL, 'Verified', 65, '2025-11-22 11:56:11', NULL, '2025-11-22 16:12:06'),
(76, 38, 83, 'org_6921e0d3a7f9c', '2025-10-16', 9.81, 'Quis quaerat sed expedita qui qui quis nihil. Quia culpa autem optio omnis. Quo aut aut et adipisci ut. Neque in qui enim ipsam accusamus omnis.', 'Verified', 65, '2025-11-20 19:32:19', NULL, '2025-11-22 16:12:06'),
(77, 19, 15, 'org_6921e0d39f40e', '2025-09-29', 8.87, 'Quos vel doloribus nesciunt pariatur ab. Ratione qui sed nulla harum deserunt culpa. Et dolore qui sunt rerum est nihil rerum.', 'Verified', 54, '2025-11-18 15:36:17', NULL, '2025-11-22 16:12:06'),
(78, 45, 62, 'org_6921e0d3a6202', '2025-10-30', 7.97, 'Quaerat nam eos porro repellendus vitae. Dolores ut voluptatum neque ea. Nemo enim et rerum ut ullam inventore voluptatum. Et ad quo repellat.', 'Verified', 62, '2025-11-04 23:14:54', NULL, '2025-11-22 16:12:06'),
(79, 45, 62, 'org_6921e0d3a6202', '2025-11-21', 3.38, 'Nihil minus voluptas omnis iusto in accusantium libero. Expedita iusto impedit omnis vel fuga. Et ullam quis quo ipsam quia ut voluptatem. Pariatur ipsum rerum itaque facere.', 'Verified', 62, '2025-11-21 18:47:13', NULL, '2025-11-22 16:12:06'),
(80, 47, 25, 'org_6921e0d3a19fe', '2025-11-10', 5.84, 'Eaque possimus sed rerum doloremque consequuntur qui reprehenderit. Pariatur sed amet molestias quis et eum magni. Autem sed aut blanditiis omnis sit numquam.', 'Verified', 56, '2025-11-13 16:38:36', 'Eos sed veritatis sunt consectetur maiores et ratione.', '2025-11-22 16:12:06'),
(81, 47, 25, 'org_6921e0d3a19fe', '2025-10-03', 5.77, NULL, 'Verified', 56, '2025-11-12 08:04:13', 'Et eum sit earum est ducimus consequuntur est.', '2025-11-22 16:12:06'),
(82, 47, 25, 'org_6921e0d3a19fe', '2025-10-27', 1.17, NULL, 'Verified', 56, '2025-11-19 03:21:24', 'Voluptatibus voluptas voluptates libero reprehenderit cumque.', '2025-11-22 16:12:06'),
(83, 47, 25, 'org_6921e0d3a19fe', '2025-10-03', 9.18, 'Ea autem aliquam dolore molestiae. Aut non modi dolorem dignissimos occaecati quas. Atque est dolorem doloribus dolores possimus dicta. Laboriosam pariatur quisquam quasi natus qui nisi aut.', 'Verified', 56, '2025-11-20 15:51:47', 'In molestias dolorem consequatur nihil nemo.', '2025-11-22 16:12:06'),
(84, 47, 25, 'org_6921e0d3a19fe', '2025-11-04', 10.11, NULL, 'Verified', 56, '2025-11-16 07:33:49', 'Sint alias est voluptatem deleniti.', '2025-11-22 16:12:06'),
(85, 23, 53, 'org_6921e0d3a582a', '2025-10-14', 3.22, 'Sed voluptates a nihil eum. Est eum placeat rerum quasi eos. At odit placeat sunt consequuntur odio. Et debitis quis et debitis consequatur qui vitae.', 'Verified', 61, '2025-11-08 09:18:31', 'Eligendi nihil nulla ut saepe qui fugiat minus id.', '2025-11-22 16:12:06'),
(86, 14, 108, 'org_6921e0d3ab300', '2025-10-10', 8.10, 'Libero sunt quaerat dolorum beatae quasi enim quaerat molestias. Temporibus non totam eligendi ducimus voluptate. Vel pariatur voluptas voluptatem.', 'Verified', 70, '2025-11-02 15:47:42', 'Nam iusto qui sequi quae.', '2025-11-22 16:12:06'),
(87, 14, 108, 'org_6921e0d3ab300', '2025-11-07', 4.29, 'Optio architecto repudiandae pariatur cupiditate. Veniam temporibus id quod aut.', 'Verified', 70, '2025-10-31 22:18:08', 'Quaerat aut voluptas omnis eveniet mollitia.', '2025-11-22 16:12:06'),
(88, 14, 108, 'org_6921e0d3ab300', '2025-10-06', 11.61, NULL, 'Verified', 70, '2025-11-18 22:27:14', 'Ducimus non velit enim nulla aut ipsum quam.', '2025-11-22 16:12:06'),
(89, 14, 108, 'org_6921e0d3ab300', '2025-11-16', 1.72, 'Ducimus quia qui tempore sit hic. Dolor totam maiores dolore aspernatur provident provident. Cumque dolorem qui culpa.', 'Verified', 70, '2025-11-13 14:19:04', 'Occaecati eveniet dolores amet quidem nisi.', '2025-11-22 16:12:06'),
(90, 14, 108, 'org_6921e0d3ab300', '2025-10-23', 3.05, NULL, 'Verified', 70, '2025-10-25 04:06:57', NULL, '2025-11-22 16:12:06'),
(91, 27, 113, 'org_6921e0d3abd4d', '2025-11-01', 9.75, 'Necessitatibus voluptate esse labore aut. Culpa qui voluptatem omnis exercitationem eos a. Deserunt non velit nulla et nisi delectus nihil. Eligendi cupiditate expedita quia voluptatibus quo aut dolor.', 'Verified', 71, '2025-11-18 17:04:42', 'Eveniet quo et dicta doloribus optio quia necessitatibus commodi.', '2025-11-22 16:12:06'),
(92, 27, 113, 'org_6921e0d3abd4d', '2025-10-27', 5.60, 'Harum ducimus animi nihil architecto aperiam. Corporis quia laboriosam molestiae id. Voluptatibus nostrum sunt cumque animi et sit. Sunt nulla nulla explicabo rem.', 'Verified', 71, '2025-10-27 12:57:26', NULL, '2025-11-22 16:12:06'),
(93, 27, 113, 'org_6921e0d3abd4d', '2025-10-07', 7.66, NULL, 'Verified', 71, '2025-10-31 08:19:33', 'Aut aliquam qui quisquam dolore eos totam.', '2025-11-22 16:12:06'),
(94, 49, 94, 'org_6921e0d3a9f76', '2025-09-29', 6.85, 'Exercitationem perspiciatis cum exercitationem voluptatem facilis voluptas ea. Ut molestiae voluptatem eos fugiat et. Assumenda saepe et labore doloribus ea sapiente at minima. Quasi reprehenderit error culpa inventore. Quia libero eos maiores quidem quam.', 'Verified', 68, '2025-11-21 14:59:39', 'Atque laudantium eaque velit.', '2025-11-22 16:12:06'),
(95, 49, 94, 'org_6921e0d3a9f76', '2025-09-26', 5.54, NULL, 'Verified', 68, '2025-11-04 19:01:01', 'Et aut labore modi voluptates qui.', '2025-11-22 16:12:06'),
(96, 49, 94, 'org_6921e0d3a9f76', '2025-10-04', 2.07, 'Occaecati beatae at omnis aliquid pariatur voluptates similique. Id dolor deserunt ducimus veritatis at. Sint qui sapiente architecto error quam voluptatibus quas. Et distinctio id dolorum ut eum dolorem error.', 'Verified', 68, '2025-11-18 02:05:32', 'Voluptatem velit est illo sapiente.', '2025-11-22 16:12:06'),
(97, 49, 94, 'org_6921e0d3a9f76', '2025-10-21', 4.62, NULL, 'Verified', 68, '2025-11-09 06:01:48', 'Possimus consequatur alias debitis.', '2025-11-22 16:12:06'),
(98, 34, 89, 'org_6921e0d3a9341', '2025-11-01', 7.61, 'Quo et molestias incidunt enim et nihil repellat. Suscipit fugit vel eligendi. Blanditiis iusto magni sit est veniam placeat at. Ut nisi nam est iste sunt qui.', 'Verified', 67, '2025-10-29 21:50:04', 'Quas ratione et adipisci aut.', '2025-11-22 16:12:06'),
(99, 34, 89, 'org_6921e0d3a9341', '2025-09-28', 4.14, NULL, 'Verified', 67, '2025-10-24 12:34:44', 'Dolorum impedit temporibus molestiae corporis praesentium.', '2025-11-22 16:12:06'),
(100, 34, 89, 'org_6921e0d3a9341', '2025-11-18', 5.13, 'Ducimus adipisci atque totam omnis architecto omnis harum. Distinctio facilis dolor ad mollitia sapiente numquam est. Animi ut nulla dolor aut dicta assumenda.', 'Verified', 67, '2025-11-18 18:50:14', NULL, '2025-11-22 16:12:06'),
(101, 36, 115, 'org_6921e0d3ac78d', '2025-11-12', 1.09, 'Aspernatur omnis vero debitis architecto modi qui. Ut dolor quia nesciunt error exercitationem qui. Mollitia itaque odit deleniti ullam fugit est id eius. Occaecati non et quia numquam aut.', 'Verified', 72, '2025-11-04 19:31:10', 'Eaque perferendis est id qui.', '2025-11-22 16:12:06'),
(102, 36, 115, 'org_6921e0d3ac78d', '2025-11-04', 8.92, 'Voluptates non deserunt beatae voluptas. Hic dolorem recusandae totam et molestias laborum qui. Corporis soluta ex assumenda et.', 'Verified', 72, '2025-11-17 21:57:54', NULL, '2025-11-22 16:12:06'),
(103, 9, 15, 'org_6921e0d39f40e', '2025-11-11', 3.46, 'Porro sit in labore. Tempora provident ipsum debitis recusandae.', 'Verified', 54, '2025-11-06 04:01:37', NULL, '2025-11-22 16:12:06'),
(104, 9, 15, 'org_6921e0d39f40e', '2025-09-24', 3.69, NULL, 'Verified', 54, '2025-11-05 00:30:58', 'Magnam beatae distinctio est commodi sit explicabo provident provident.', '2025-11-22 16:12:06'),
(105, 9, 15, 'org_6921e0d39f40e', '2025-09-24', 3.84, 'Ut provident eos sed sunt amet at dolorum. Distinctio vel consequatur rem dolorum illum. Temporibus modi voluptatem tempora eum. In facilis sit dolorum et ullam earum quo sapiente.', 'Verified', 54, '2025-11-22 08:09:57', 'Sit consequatur molestias qui minima ut.', '2025-11-22 16:12:06'),
(106, 19, 114, 'org_6921e0d3abd4d', '2025-10-04', 3.53, 'Nesciunt fuga qui voluptas neque soluta possimus. Et vel rerum neque eius iure saepe nemo. Assumenda quo occaecati dolores. Cumque eum voluptatem mollitia mollitia sit labore qui.', 'Verified', 71, '2025-11-02 00:56:34', NULL, '2025-11-22 16:12:06'),
(107, 19, 114, 'org_6921e0d3abd4d', '2025-10-24', 10.71, 'Rerum eligendi ut nihil deleniti enim quod. Vero nam optio saepe et. Aut repellat facilis iste. Adipisci quia placeat nesciunt dolorem magni quis. Omnis sed ut aut et qui quisquam qui.', 'Verified', 71, '2025-11-05 01:31:42', NULL, '2025-11-22 16:12:06'),
(108, 42, 67, 'org_6921e0d3a6c01', '2025-09-24', 5.61, NULL, 'Verified', 63, '2025-11-04 02:07:58', 'Ullam corrupti quibusdam cupiditate aut odio quae.', '2025-11-22 16:12:06'),
(109, 42, 67, 'org_6921e0d3a6c01', '2025-09-24', 8.16, NULL, 'Verified', 63, '2025-10-28 17:38:27', NULL, '2025-11-22 16:12:06'),
(110, 14, 36, 'org_6921e0d3a3ab4', '2025-10-11', 11.41, 'Dolores autem magnam provident facilis eius. Consequatur et quam quia vel.', 'Verified', 58, '2025-11-10 11:06:54', NULL, '2025-11-22 16:12:06'),
(111, 14, 36, 'org_6921e0d3a3ab4', '2025-11-01', 1.98, 'Eos ducimus optio voluptas accusantium aut ad. Tempore est voluptatem impedit minus et. Dolorem temporibus nam quis nostrum.', 'Verified', 58, '2025-11-03 04:11:49', NULL, '2025-11-22 16:12:06'),
(112, 14, 36, 'org_6921e0d3a3ab4', '2025-11-18', 11.24, 'Consequatur ducimus sunt est quo. Commodi est perspiciatis ut laborum consectetur qui dolores. Ut voluptatem itaque ut alias. Voluptatem possimus eos aut rerum amet aut cumque.', 'Verified', 58, '2025-10-30 13:22:12', 'Dignissimos eius quo ut molestiae.', '2025-11-22 16:12:06'),
(113, 14, 36, 'org_6921e0d3a3ab4', '2025-10-29', 11.51, NULL, 'Verified', 58, '2025-10-26 09:45:08', 'Adipisci dignissimos eligendi odio vel est.', '2025-11-22 16:12:06'),
(114, 14, 36, 'org_6921e0d3a3ab4', '2025-10-24', 6.07, 'Ipsam optio officiis expedita. Dignissimos sit amet voluptas quod dicta rerum. Explicabo doloremque omnis nisi eos ullam voluptas dolores saepe. Aliquid id dicta quisquam ut.', 'Verified', 58, '2025-11-04 13:32:00', NULL, '2025-11-22 16:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_opportunities`
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
-- Dumping data for table `volunteer_opportunities`
--

INSERT INTO `volunteer_opportunities` (`opportunity_id`, `org_id`, `category_id`, `title`, `description`, `requirements`, `benefits`, `location`, `latitude`, `longitude`, `start_date`, `end_date`, `time_commitment`, `schedule_type`, `volunteers_needed`, `volunteers_registered`, `min_age`, `required_skills`, `experience_needed`, `status`, `application_deadline`, `view_count`, `application_count`, `created_at`, `updated_at`) VALUES
(1, 'org_6921e012bdfff', 5, 'Autem omnis quis ea ea repudiandae saepe quos.', 'Alias beatae dolor temporibus et ut magni. Et aspernatur est ipsum nam minima non earum porro. Debitis tempore placeat nulla soluta eveniet voluptatem. Possimus velit modi at reprehenderit. Odio nam beatae deserunt eum necessitatibus sed suscipit.', 'Aut assumenda aut et ut perferendis error. Occaecati ut est vel dolore occaecati quod.', NULL, 'Ho Chi Minh City, 5032 Gabriel Roads Apt. 459', 19.25587000, 104.07861100, '2025-12-10', NULL, '3-5 hours', 'Flexible', 15, 4, 16, '[\"First Aid\",\"Writing\",\"Marketing\",\"Programming\"]', 'Experienced', 'Active', NULL, 41, 2, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(2, 'org_6921e012bdfff', 4, 'Et ut adipisci nihil maxime totam quas.', 'Aliquam impedit accusamus voluptatibus corporis perspiciatis. Omnis explicabo excepturi eius et dolore. Sed eum exercitationem voluptatem ullam vel ex modi molestias. Quisquam autem nam voluptate sed porro.', NULL, NULL, 'Hanoi, 48552 Nienow Brook Apt. 638', 19.25763400, 106.12940900, '2025-12-16', '2026-01-30', '6-8 hours', 'Flexible', 19, 3, 21, '[\"Writing\",\"Design\"]', 'Experienced', 'Completed', NULL, 485, 27, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(3, 'org_6921e012bdfff', 8, 'Ut laboriosam assumenda dolorem.', 'Rerum culpa aut harum non et nisi. Delectus odit sed suscipit libero enim voluptatem. Vitae nulla perferendis voluptate voluptatibus. Quod non dolore quo voluptatem sit. Ratione rerum ut veniam voluptate.', 'Doloremque ullam amet ipsum hic distinctio quam saepe. Voluptatibus rerum et enim voluptas et nam quia. Voluptas vel ea delectus et recusandae.', 'Et quo delectus ipsam rerum facilis et. Voluptatibus et blanditiis omnis perferendis expedita sed.', 'Da Nang, 2798 Zechariah Village', 10.84015800, 104.48320000, '2025-12-08', '2026-01-23', '6-8 hours', 'Weekly', 9, 4, 21, '[\"Design\"]', 'Experienced', 'Cancelled', NULL, 289, 3, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(4, 'org_6921e012bdfff', 2, 'Dolorem enim iure est delectus nemo quae.', 'Dolore quis est neque est. Et odio non quas illo voluptatem. Est modi vero cumque fugiat recusandae sit. Ut iusto dicta repudiandae sit rerum quia sed. Rerum et aliquam autem rem. Eum consectetur ut odit rerum vel fugiat inventore. Quia quis commodi magnam excepturi ipsam optio architecto.', NULL, NULL, 'Hai Phong, 379 Gardner Dale Apt. 600', 13.24935500, 109.52984300, '2026-01-14', '2026-01-21', 'Multiple days', 'Flexible', 18, 2, 21, '[\"Marketing\"]', 'Experienced', 'Cancelled', NULL, 399, 50, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(5, 'org_6921e012bdfff', 5, 'Quasi molestias accusamus ducimus quia officia.', 'Velit voluptatem omnis et alias deserunt et. Qui perspiciatis quia illum tempora odit vel dolorum. Ut nobis nulla et ab quia. Ducimus aut vero maxime eum et.', NULL, 'Voluptatem architecto non doloribus quis dicta perferendis quae. Vel sunt repudiandae perspiciatis magnam. Rerum neque soluta sed assumenda et.', 'Hanoi, 3465 Simonis Turnpike', 21.87720900, 109.41199000, '2025-12-20', NULL, '3-5 hours', 'Monthly', 12, 4, 18, '[\"Design\",\"Writing\",\"Marketing\"]', 'Some experience', 'Completed', NULL, 181, 28, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(6, 'org_6921e012bdfff', 6, 'Praesentium laboriosam nobis perferendis a quo quo fugiat.', 'Expedita dolor similique at est inventore. Ex error asperiores consectetur necessitatibus tenetur dolor. Voluptates quidem temporibus a facilis totam. Placeat deserunt officia non expedita ullam porro omnis.', 'Similique exercitationem aspernatur porro. Tempora ad ipsum autem aliquid odio alias. Fugit modi nobis maiores tempore eaque fugit.', NULL, 'Can Tho, 6223 Heidenreich Camp', 9.75539100, 108.43958900, '2026-01-13', '2026-01-27', 'Full day', 'One-time', 11, 0, 18, '[\"Programming\",\"Cooking\",\"Photography\"]', 'No experience', 'Completed', NULL, 284, 26, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(7, 'org_6921e012bdfff', 8, 'Omnis quo velit ut.', 'Qui ea vitae autem ullam praesentium. Ut sequi optio incidunt maxime itaque accusantium est. Consequatur fugiat itaque vero corrupti recusandae et ipsa. Eum necessitatibus id sit dolor ipsum cum. Possimus voluptate libero eaque saepe et qui. Vel modi iusto reiciendis qui. Quia nemo numquam a blanditiis voluptatibus qui cum.', NULL, NULL, 'Da Nang, 318 Deckow Islands', 9.96779900, 107.50349400, '2025-12-22', '2026-01-14', '3-5 hours', 'One-time', 2, 4, 16, '[\"Translation\",\"Programming\"]', 'No experience', 'Paused', NULL, 84, 32, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(8, 'org_6921e0732472a', 7, 'Unde nemo aut quam at excepturi.', 'Nemo assumenda voluptate vitae officia. Asperiores cum nihil repudiandae iure maxime laudantium quam dolorem. In quam aperiam molestiae quisquam quia perferendis suscipit consequatur. Corporis totam porro eos voluptas maxime expedita libero. Voluptatum qui ex possimus. Deserunt asperiores qui architecto sed. Nemo qui consectetur est rem eveniet iusto provident est.', 'Beatae voluptas voluptatem vel laboriosam fugit est. Cum omnis veritatis ex voluptatibus dolor sit.', NULL, 'Ho Chi Minh City, 26352 Quinton Tunnel Suite 751', 18.36537200, 109.71025000, '2025-11-30', NULL, 'Full day', 'One-time', 12, 1, 16, '[\"Translation\",\"Writing\",\"Design\",\"Photography\"]', 'Experienced', 'Paused', NULL, 252, 30, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(9, 'org_6921e0732472a', 2, 'Aliquid ut voluptates voluptatibus et magnam voluptatem voluptas.', 'Tempore et ducimus ipsum sed numquam atque. Quia voluptatem cumque reprehenderit eligendi. Modi veniam temporibus voluptatibus voluptatem. Excepturi sed sunt aut. Temporibus veniam nobis cumque dolores esse tenetur totam. Sed rerum cupiditate repudiandae similique.', NULL, NULL, 'Ho Chi Minh City, 5558 Crooks Avenue Suite 566', 20.87359200, 108.51191600, '2026-01-17', '2026-02-07', 'Full day', 'Weekly', 10, 4, 16, '[\"Teaching\"]', 'Experienced', 'Completed', '2026-01-17', 426, 34, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(10, 'org_6921e0732472a', 5, 'Earum autem quisquam exercitationem qui est.', 'Cum molestias ad impedit nostrum. Qui mollitia placeat ex molestiae unde ut qui et. Sit et numquam recusandae rerum amet repellat quia. Aspernatur culpa deleniti in ex. Fuga voluptates non et aut commodi est nulla nesciunt. Est assumenda in omnis et et. Et molestias molestiae quo neque itaque.', 'Facilis culpa id vero dolorem amet delectus qui. Enim voluptatem aspernatur est fugiat.', NULL, 'Can Tho, 653 Jacobs Tunnel', 16.54753300, 103.79663600, '2026-01-21', '2026-02-01', '3-5 hours', 'Flexible', 13, 3, 16, '[\"Marketing\",\"Teaching\"]', 'Some experience', 'Completed', NULL, 289, 39, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(11, 'org_6921e0732472a', 6, 'Assumenda sed accusamus unde.', 'Aliquam tenetur aut omnis esse assumenda. Animi ipsum numquam ducimus tenetur. Eos perferendis nisi animi. Sapiente fugiat cum ullam possimus totam facilis. Atque et facere amet sed.', 'Debitis tenetur architecto qui molestiae dolor dolores enim. Adipisci unde aspernatur consectetur nemo magnam exercitationem voluptas id.', NULL, 'Hanoi, 455 Halle Forges Suite 980', 8.10492600, 107.65687800, '2025-12-26', NULL, 'Multiple days', 'Weekly', 1, 0, 18, '[\"Teaching\",\"Marketing\"]', 'Some experience', 'Active', '2025-12-11', 483, 45, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(12, 'org_6921e0732472a', 6, 'Eos aliquid eos commodi quia veritatis.', 'Est omnis ullam harum. Et commodi doloribus cumque quia unde molestiae neque. Fugit eos fugiat explicabo. Voluptatibus nam qui sint reiciendis sint sunt et. Autem magni sit ut repudiandae expedita voluptatem eum. Qui dolores incidunt aperiam velit consectetur autem harum. Porro voluptatibus ad tempore dolorem culpa.', NULL, NULL, 'Can Tho, 311 Weissnat Route', 19.19323800, 109.83516400, '2025-12-15', '2026-02-09', '3-5 hours', 'One-time', 2, 3, 18, '[\"Design\",\"First Aid\",\"Writing\"]', 'Some experience', 'Paused', NULL, 297, 5, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(13, 'org_6921e0732472a', 7, 'Unde alias saepe voluptas consequatur fugit.', 'Sit ex non ab itaque dignissimos vel laudantium. Unde quaerat necessitatibus sit fuga et a. Quis et nesciunt magnam iure eius quia at. Cum accusamus deleniti illum aliquid aut facere. Sint eum est ut.', 'Voluptate qui atque aperiam qui facere. Dolor dolor nisi ut vitae iure nemo.', 'Provident quisquam ut temporibus in sunt. Voluptatem nisi maiores iste modi cupiditate.', 'Da Nang, 351 Kub Cliffs Apt. 148', 13.42473700, 106.98294800, '2025-12-28', '2026-02-08', '6-8 hours', 'One-time', 3, 5, 18, '[\"Marketing\",\"Writing\",\"Cooking\"]', 'No experience', 'Completed', '2025-11-30', 431, 32, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(14, 'org_6921e0d39f40e', 6, 'Iusto perferendis enim fugiat est eos.', 'Unde praesentium dolor aut libero ab vel qui. Voluptatum qui ut incidunt sapiente ratione illo eos. Provident ipsum ut perferendis rerum. Vel veniam reiciendis soluta distinctio pariatur vel hic. Eos aut qui aut quia. Dignissimos distinctio sunt suscipit totam culpa aliquam non. Placeat quis sint rerum voluptates exercitationem vel architecto.', NULL, NULL, 'Can Tho, 173 Therese Crest', 16.45415000, 107.98389100, '2026-01-10', NULL, 'Full day', 'Flexible', 5, 2, 21, '[\"Cooking\"]', 'No experience', 'Completed', '2026-01-01', 222, 30, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(15, 'org_6921e0d39f40e', 6, 'Quo et eaque enim aut laudantium beatae.', 'Est inventore voluptatum ut aspernatur nesciunt nulla ducimus ex. Aut suscipit laudantium aut veritatis voluptate. Magni eum quia nam et. Minus aut et consectetur laborum omnis ea eligendi.', 'Inventore quae consequatur et eaque nam illum voluptate. Eos quo magni ipsam nihil voluptas dolores.', NULL, 'Can Tho, 22053 Streich Wells', 18.35731800, 102.00042800, '2026-01-06', NULL, '3-5 hours', 'Flexible', 11, 0, 16, '[\"Programming\",\"Photography\",\"Cooking\"]', 'No experience', 'Paused', '2026-01-03', 118, 34, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(16, 'org_6921e0d39f40e', 8, 'Cum totam aspernatur porro voluptas.', 'Animi officia sit assumenda quia recusandae quam. Dolore ullam est eum pariatur voluptatum. Aut ad quae consequatur beatae sint. Fugiat eaque laudantium commodi ut provident illo quibusdam soluta. Temporibus voluptatem ut et tempore expedita a. Quod enim quaerat tempora enim ipsa assumenda.', 'Impedit mollitia ad officia voluptatibus. Animi facilis dolorem eaque et est laudantium. Eum ea ea aspernatur libero dicta incidunt modi.', NULL, 'Can Tho, 978 Bechtelar Dam Suite 736', 13.04850300, 104.73159000, '2025-12-25', NULL, '1-2 hours', 'One-time', 19, 3, 21, '[\"Photography\",\"Programming\"]', 'Some experience', 'Active', NULL, 150, 21, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(17, 'org_6921e0d39f40e', 1, 'Quod necessitatibus quia ullam.', 'Velit ea sed placeat quae fugit. Corporis quia aut ad sit excepturi itaque ipsam. Ut et aspernatur laborum autem. Et repellendus consequatur sed est. Corrupti voluptatem consequatur vel in aliquid. Eaque laudantium error et quia corporis. Dolores voluptatum eius illo itaque quasi.', NULL, NULL, 'Ho Chi Minh City, 52380 Runte Row Suite 800', 18.02005100, 109.80266600, '2026-01-14', '2026-02-07', '1-2 hours', 'Weekly', 17, 3, 21, '[\"Cooking\",\"Marketing\",\"Photography\",\"Design\"]', 'Some experience', 'Paused', '2025-11-25', 180, 15, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(18, 'org_6921e0d3a046b', 6, 'Corporis veritatis corrupti saepe et fugiat.', 'Aliquam minima itaque sit assumenda. Possimus ea sit aut nihil voluptas et. At beatae odio autem enim. Sit minus repellat accusantium earum molestiae. Harum laudantium quia sequi necessitatibus suscipit. Animi id asperiores tenetur minima earum expedita nulla. Provident veritatis odio repellat pariatur et hic.', NULL, NULL, 'Can Tho, 7315 Ena Island Apt. 534', 15.34076900, 104.61851000, '2025-12-25', NULL, 'Full day', 'Weekly', 17, 0, 18, '[\"Programming\"]', 'Experienced', 'Paused', NULL, 366, 24, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(19, 'org_6921e0d3a046b', 8, 'Culpa nesciunt similique occaecati neque iusto recusandae et deserunt.', 'Fugit doloribus sed nam sed quia. Rerum iste accusamus et beatae. Assumenda minima ipsa quod. Natus labore rerum veritatis voluptatem laudantium. Aspernatur dolorum quis amet dolorum perspiciatis neque. Reiciendis fuga voluptate aliquam assumenda quia cupiditate. Consequatur eos dolore repellat est qui. Ut velit ea molestiae aut et accusantium qui.', 'Aliquid commodi quis quos vel magnam est id. Aspernatur aut sit quidem laborum molestiae qui.', 'Iure repellat deleniti incidunt rem ea. Dolores labore error qui minima voluptates.', 'Can Tho, 6792 Baumbach Ways', 9.37181600, 103.28642700, '2026-01-09', NULL, 'Full day', 'Weekly', 2, 2, 21, '[\"Design\",\"Writing\"]', 'Experienced', 'Cancelled', '2025-11-27', 299, 26, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(20, 'org_6921e0d3a046b', 2, 'Eos quia vel incidunt incidunt nihil consequatur saepe.', 'Occaecati totam est in sit labore maiores. Ut quisquam hic a quis porro eveniet quia. Id occaecati autem similique consequuntur. Sit facere suscipit voluptates sapiente aut quas occaecati.', NULL, NULL, 'Hanoi, 619 Beier Crescent', 11.82774000, 103.18566900, '2025-11-30', '2026-01-07', 'Multiple days', 'Flexible', 6, 2, 18, '[\"Marketing\",\"Photography\",\"Teaching\"]', 'No experience', 'Cancelled', '2025-11-25', 339, 30, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(21, 'org_6921e0d3a046b', 5, 'Vel nulla molestiae aut rem amet fugit iste.', 'Ex suscipit ut aut accusamus illum et. Voluptatem corrupti commodi qui corporis animi voluptas. Voluptas sit commodi laborum voluptas. Aut et assumenda amet vitae doloribus necessitatibus. Consequatur consequatur reiciendis tenetur aliquam et qui. Distinctio voluptates qui ut dolorem suscipit.', 'Unde amet nihil laborum sed ipsum sapiente. Nam exercitationem numquam enim consequatur suscipit molestias laborum omnis. Maxime placeat distinctio animi eius tempora consequatur distinctio deleniti.', 'Vel et id veritatis rem perferendis in velit. Qui et dolor nobis et ullam. Repellat saepe nihil ratione.', 'Can Tho, 455 Dickinson Trail', 11.05071800, 102.01016900, '2026-01-15', NULL, 'Full day', 'Monthly', 13, 4, 16, '[\"Design\",\"Translation\",\"Marketing\"]', 'Experienced', 'Active', NULL, 316, 10, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(22, 'org_6921e0d3a046b', 6, 'Recusandae minus nihil eaque error voluptatem dolor distinctio.', 'Et est tempore molestiae sint. Soluta id quam nobis. Nulla eligendi blanditiis consequatur recusandae mollitia quasi maxime. Aut et voluptas doloribus minus quaerat.', NULL, NULL, 'Hanoi, 1822 Cleveland Plaza', 15.83242700, 107.24724800, '2025-12-30', '2026-01-26', '3-5 hours', 'Flexible', 18, 5, 18, '[\"First Aid\",\"Cooking\",\"Writing\"]', 'No experience', 'Cancelled', NULL, 476, 17, '2025-11-22 16:12:03', '2025-11-22 16:12:03'),
(23, 'org_6921e0d3a046b', 3, 'Amet pariatur sit dolor possimus.', 'Illum autem placeat voluptate rerum maiores. Dolorum cumque nulla veritatis earum. Animi itaque consequatur sint vitae aut quis. Temporibus ea aspernatur deserunt consectetur eos. Dolor tempora animi eum velit vel. Magni quia voluptatem et exercitationem atque. Aut voluptatem vero et eum.', 'Aut ipsam sapiente sequi in exercitationem iste necessitatibus est. Soluta vitae vel sed possimus. Ut enim nam occaecati quia.', 'Et sint ipsa aliquam blanditiis id modi. Rerum veritatis dolores dicta animi et. Repudiandae ut officia et sed aliquid perspiciatis fugiat corrupti.', 'Ho Chi Minh City, 977 Cesar Trail', 20.75005900, 102.05485400, '2025-12-07', NULL, 'Full day', 'One-time', 12, 4, 21, '[\"Writing\",\"Design\",\"Programming\"]', 'Some experience', 'Completed', NULL, 236, 35, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(24, 'org_6921e0d3a19fe', 6, 'Est fuga excepturi doloribus quia minus qui enim quasi.', 'Omnis hic odio assumenda similique. Voluptatem qui est sint dolorum. Sit consectetur libero dignissimos. Dolores et repellendus modi voluptas consequatur exercitationem. Non eos et voluptas quo dolor in.', 'Veniam quod error saepe quae et quia excepturi ea. Officiis libero sequi accusantium blanditiis qui.', 'Quaerat officia voluptatum ratione voluptas dolores inventore eum. Sed ut ratione sint eius corporis doloribus aliquam.', 'Hanoi, 9589 Aaliyah Crossroad', 22.16109800, 107.18235200, '2025-12-21', '2026-02-14', 'Full day', 'One-time', 16, 2, 16, '[\"Programming\"]', 'Experienced', 'Paused', '2025-11-26', 331, 25, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(25, 'org_6921e0d3a19fe', 8, 'Ullam et veritatis culpa ut.', 'Perspiciatis cumque voluptates et et temporibus. Vitae vel culpa iure error tenetur cupiditate minus. Voluptate sed est earum nisi. Tempora neque exercitationem et eum accusantium. Et cumque dolorem dolor aliquam. Ullam nisi nam dolores dolorum eum harum.', NULL, NULL, 'Hanoi, 1405 Kitty Union Suite 431', 8.85192100, 108.50613000, '2025-12-08', '2026-02-05', 'Full day', 'Weekly', 20, 4, 21, '[\"Teaching\",\"Programming\",\"Photography\",\"First Aid\"]', 'Some experience', 'Active', NULL, 224, 22, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(26, 'org_6921e0d3a19fe', 4, 'Unde exercitationem magnam laboriosam voluptatem ipsa soluta.', 'Rerum harum rem sed consequatur commodi. Neque iure reiciendis possimus ea est maiores. Consequatur amet atque quidem animi eveniet voluptatem omnis. Vel itaque provident dolores enim facere fugit. Voluptas cumque laborum et molestiae expedita enim.', 'Aut ex cum sed sit nam maxime numquam. Et perspiciatis voluptatem occaecati repellat.', 'Praesentium aut rerum eius iure ut. Tempora itaque ut temporibus quia. Est autem saepe itaque est ut.', 'Can Tho, 9302 Jakubowski Stream', 17.40456500, 104.82467800, '2025-12-14', NULL, '3-5 hours', 'Weekly', 5, 0, 18, '[\"Photography\",\"First Aid\",\"Translation\",\"Design\"]', 'No experience', 'Cancelled', '2025-12-13', 94, 39, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(27, 'org_6921e0d3a19fe', 6, 'Deleniti corporis sed porro nam velit.', 'Placeat ut id nihil est molestias. Impedit quos quidem exercitationem doloremque. Laboriosam et at natus quis explicabo quia. Quos totam voluptatem aperiam iure id quidem. Dolorem aut sed voluptas reprehenderit dignissimos nihil voluptate. Error neque facere suscipit architecto deserunt. Magnam sunt quo laboriosam excepturi.', 'Quis odio ratione ipsa est enim tempora doloribus officiis. Aliquam quo veritatis corporis expedita et eaque vero. Ut et dolorem eos vel.', 'Qui blanditiis sit vel. Unde omnis totam quasi nobis.', 'Hai Phong, 852 Miguel Prairie Suite 128', 13.36834800, 109.74785300, '2025-12-26', '2026-02-11', 'Full day', 'One-time', 20, 1, 16, '[\"Cooking\",\"First Aid\",\"Teaching\",\"Design\"]', 'Experienced', 'Paused', '2025-12-23', 112, 17, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(28, 'org_6921e0d3a19fe', 5, 'Vero aut deleniti aspernatur fuga quia.', 'Nisi aut odit nihil quasi magni. Recusandae eveniet exercitationem veritatis at et voluptate. Ea velit non iste recusandae. Rerum et aut consequuntur similique. Dolores qui minus ducimus non voluptas est molestiae molestias. Qui qui in nesciunt porro eum.', NULL, 'Adipisci ut qui error necessitatibus et. Doloremque adipisci debitis temporibus a dignissimos.', 'Can Tho, 31209 Champlin Isle', 21.33310700, 104.69734400, '2025-11-26', '2026-01-12', '6-8 hours', 'Weekly', 7, 4, 21, '[\"Translation\",\"Programming\",\"First Aid\"]', 'Some experience', 'Completed', '2025-11-23', 201, 9, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(29, 'org_6921e0d3a19fe', 2, 'A et eos tenetur maiores.', 'Non facilis quam quia sit esse est. Ut possimus sed aut cum fuga dolores commodi. Deleniti possimus repellat eos molestiae est ipsa autem. Est unde aut nobis sint nam. Minus error vero et eaque. Sapiente asperiores cum rerum ipsa aliquam rerum at. Et consequuntur reprehenderit rerum nesciunt numquam molestiae.', 'Quam dolorem sit sed impedit dolores provident. Fugiat ut et quae ex consequuntur sed quae consequatur.', 'Distinctio qui sapiente quam aspernatur. Accusantium ut quia est hic ut consequatur et. Id error dolores voluptas error.', 'Hanoi, 7345 Julia Harbor', 10.36489900, 103.22430900, '2025-12-04', '2026-01-31', '3-5 hours', 'Weekly', 3, 5, 16, '[\"Teaching\",\"First Aid\",\"Marketing\",\"Design\"]', 'Experienced', 'Active', NULL, 102, 16, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(30, 'org_6921e0d3a3191', 4, 'Facere placeat et cupiditate ratione.', 'Quo magni sunt nobis qui enim debitis et. Delectus aut sapiente iusto exercitationem ab. Atque itaque fugiat beatae eum voluptatem provident hic. Et animi et eius sunt. Dolorem amet possimus id enim et consectetur.', 'Sint excepturi et incidunt dolor. Est reprehenderit perspiciatis ut corporis blanditiis doloribus et.', 'Commodi consequuntur aut aut recusandae et qui. Sit dicta dolorum omnis velit.', 'Can Tho, 304 Haley Isle Suite 356', 16.86193700, 104.28586200, '2025-12-10', '2026-01-02', 'Multiple days', 'Monthly', 5, 2, 21, '[\"Photography\",\"Cooking\"]', 'No experience', 'Cancelled', NULL, 122, 22, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(31, 'org_6921e0d3a3191', 3, 'Accusamus cum dolorem iure possimus labore et autem rerum.', 'Ut est corrupti inventore accusantium dolor eum non ullam. Nihil qui fuga harum voluptas possimus eaque est. Ea sequi doloribus aut. Molestiae labore blanditiis officiis ducimus. Dolorum eum qui dolor saepe. Deleniti accusamus odio ut.', 'Aspernatur iure eum ullam sed aut ut quis. Corrupti sit laudantium soluta quaerat. Et numquam exercitationem dolor et dolorum.', NULL, 'Da Nang, 1599 Retha Valley', 12.14576600, 106.56475100, '2026-01-11', NULL, '3-5 hours', 'Monthly', 16, 2, 18, '[\"Cooking\",\"Programming\",\"Photography\",\"Teaching\"]', 'No experience', 'Cancelled', NULL, 121, 38, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(32, 'org_6921e0d3a3191', 7, 'Consequuntur libero consequuntur perferendis nihil aperiam sint.', 'Ullam consequatur neque tempore exercitationem quis doloremque. Voluptatem dolor fugiat asperiores nulla deserunt. Iste reiciendis ipsa doloremque sed. Consequatur dolore temporibus a eligendi velit aut. Sit suscipit sed ratione tenetur est a ut.', NULL, NULL, 'Ho Chi Minh City, 19705 Hyatt Stream', 15.99334800, 106.47530700, '2025-11-26', NULL, '6-8 hours', 'Flexible', 6, 3, 18, '[\"Marketing\",\"Translation\",\"Programming\",\"First Aid\"]', 'Some experience', 'Cancelled', NULL, 154, 47, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(33, 'org_6921e0d3a3191', 6, 'Eius sunt quis facilis molestiae dolor aspernatur.', 'Explicabo voluptatem molestias aspernatur saepe a. Omnis architecto cupiditate qui adipisci commodi ipsum beatae. Atque non quam neque temporibus id maiores. Ratione reprehenderit officiis tempore et perferendis. Aut possimus aperiam sunt quaerat.', 'Eius reprehenderit nihil qui animi repellat. Hic reprehenderit magnam et ex vitae qui. Ullam qui velit et at.', 'Sint repellendus a dignissimos deleniti nemo modi. Quae quisquam distinctio consectetur.', 'Hanoi, 61421 Glenda Lake', 12.48263300, 109.80835900, '2025-12-22', NULL, '3-5 hours', 'Monthly', 12, 1, 16, '[\"Design\"]', 'Experienced', 'Paused', NULL, 70, 3, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(34, 'org_6921e0d3a3191', 1, 'Minus ut nihil atque dolor.', 'Sapiente quia magnam et. Voluptas perferendis non consequatur ea. Non impedit autem et aut vel aut. Ut non cupiditate ut et mollitia quae autem. Et perferendis qui ea voluptatibus fuga non voluptatem. Cumque quia quos minima.', NULL, NULL, 'Hai Phong, 7160 Effertz Summit Suite 892', 22.38923700, 106.09183000, '2026-01-15', NULL, '3-5 hours', 'One-time', 15, 0, 16, '[\"Programming\",\"Translation\",\"First Aid\"]', 'Experienced', 'Completed', '2025-12-21', 436, 32, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(35, 'org_6921e0d3a3191', 4, 'Sed aut et corrupti tempora nam.', 'Eligendi aut pariatur suscipit. Officiis totam ipsa consequatur nostrum sint. Exercitationem aut sed sint repudiandae animi officiis qui. Nihil vitae non voluptatem consequatur illo quibusdam est. Unde sed vitae tempore aspernatur doloremque nulla maxime. Consequatur officiis recusandae quasi a autem. Consequatur non numquam nesciunt.', NULL, NULL, 'Hanoi, 65131 Heathcote Ville', 11.48141300, 109.77140900, '2026-01-11', NULL, 'Full day', 'Weekly', 14, 2, 18, '[\"Translation\",\"First Aid\"]', 'No experience', 'Cancelled', NULL, 473, 24, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(36, 'org_6921e0d3a3ab4', 3, 'Qui voluptas impedit est quia voluptates.', 'Nobis rerum ducimus eius aut ratione. Dolore et nihil autem non. Similique cumque deserunt et ipsam eaque blanditiis et molestiae. Et accusamus dolores dolor consectetur.', NULL, NULL, 'Can Tho, 654 Stracke Shore Suite 432', 8.19329200, 103.36229300, '2026-01-06', NULL, 'Multiple days', 'Monthly', 9, 5, 18, '[\"Teaching\",\"Marketing\",\"Photography\"]', 'Some experience', 'Completed', '2025-12-09', 400, 22, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(37, 'org_6921e0d3a3ab4', 4, 'Possimus et laborum perferendis molestiae est.', 'Sit quasi occaecati autem ea. Molestiae quidem consectetur quia quis nesciunt eveniet. Unde non ut architecto modi corporis. Assumenda tenetur nesciunt cum qui. Quia sequi natus neque sint. Nobis provident sequi incidunt. Nisi dolores consectetur sed officiis quia molestias.', 'Ea fuga ut consectetur voluptatem. Deleniti voluptas aut reprehenderit error sit et.', NULL, 'Can Tho, 80067 Aimee Green', 15.28640800, 106.12410000, '2025-12-23', '2026-01-07', '1-2 hours', 'Weekly', 18, 0, 16, '[\"Photography\",\"Marketing\",\"Cooking\",\"Teaching\"]', 'Experienced', 'Active', NULL, 424, 40, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(38, 'org_6921e0d3a3ab4', 1, 'Vitae ut voluptatum autem et quis molestiae et cupiditate.', 'Et minima omnis et officia occaecati. Pariatur rerum cumque sint illum rerum eius et sed. Sint et eos consequatur porro. Optio aut ad quibusdam tempora dolorem molestias.', 'Eum iusto nisi quam dolore quia necessitatibus dolorum. Omnis ab nobis eum laborum in placeat. Occaecati cupiditate ipsum aut provident.', NULL, 'Ho Chi Minh City, 112 Littel Tunnel Suite 243', 15.90124100, 105.31543600, '2025-12-29', NULL, 'Full day', 'Weekly', 5, 1, 21, '[\"Translation\",\"Photography\",\"Marketing\"]', 'Experienced', 'Paused', NULL, 366, 10, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(39, 'org_6921e0d3a3ab4', 6, 'Rerum beatae nulla nesciunt facilis.', 'Fuga ipsam illo perspiciatis inventore libero. Aut accusantium laboriosam doloribus non. Eos neque consequatur ea voluptatem. Voluptate quia dignissimos voluptas reiciendis architecto consectetur. Nihil neque consequatur quo ducimus velit sint. Ut repellendus quasi amet.', 'Qui praesentium vel et consequuntur. Facilis odio similique eos praesentium temporibus. Qui aut placeat voluptatem libero iusto architecto omnis.', 'Suscipit sed qui et neque distinctio. Dolor velit praesentium eligendi vero delectus dolore.', 'Hanoi, 30067 Guido Forest', 18.18873000, 104.73502600, '2025-12-29', '2026-01-04', '6-8 hours', 'One-time', 7, 4, 18, '[\"Translation\",\"Programming\",\"Writing\"]', 'Some experience', 'Paused', '2025-12-13', 482, 35, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(40, 'org_6921e0d3a3ab4', 6, 'Omnis reiciendis neque sint nihil fugiat quos voluptas.', 'Ea qui facilis corporis in accusamus. Eligendi est doloribus et consequatur nulla asperiores. Animi quisquam ex autem repellendus. Dolorem iste dolorem autem ad sed blanditiis. Minima ipsam enim omnis assumenda. Aut dolorem perferendis laboriosam incidunt fugit ipsa. Necessitatibus corrupti labore mollitia tempore explicabo.', NULL, 'Ut id voluptas eveniet ipsa tenetur aut. Velit quae dignissimos sed quia rerum. Et repudiandae recusandae dolorem vitae.', 'Hai Phong, 73760 Charlie Summit', 13.52035900, 103.69580400, '2025-12-15', '2026-02-11', '1-2 hours', 'Flexible', 11, 3, 21, '[\"Design\"]', 'No experience', 'Cancelled', NULL, 365, 27, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(41, 'org_6921e0d3a443d', 3, 'Dignissimos quasi ipsam consequatur vel soluta alias voluptatem.', 'Illum ut sed a quam laudantium assumenda. Dolores fugit animi doloribus pariatur aut voluptatem. Laboriosam eveniet et rerum. Qui quibusdam amet et quia. Voluptatem non optio vitae ipsam omnis. Harum labore harum quod illum maxime excepturi iure. Eos alias modi sit nisi vitae.', NULL, 'Laborum excepturi qui ipsam vero. Ut aspernatur iure recusandae dolore iure deserunt ea.', 'Ho Chi Minh City, 41400 Vincent Springs Apt. 575', 21.82420600, 107.33779400, '2026-01-14', '2026-01-29', '3-5 hours', 'Weekly', 16, 2, 16, '[\"First Aid\",\"Translation\",\"Cooking\",\"Marketing\"]', 'Some experience', 'Paused', NULL, 317, 44, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(42, 'org_6921e0d3a443d', 1, 'Id veniam qui ut nihil magni iste fugit earum.', 'Qui omnis veniam explicabo facere laborum. Sed est vero voluptatem et voluptatem aut et. Dolorum voluptatum consequatur consequuntur eveniet. Ex et ipsam omnis suscipit consequatur ea cum. Voluptas nihil adipisci aut. Est omnis doloribus blanditiis sunt.', NULL, 'Maxime eligendi assumenda sed. Itaque occaecati vel doloribus quidem.', 'Hanoi, 620 Sterling Well', 9.41647700, 107.14761900, '2025-11-27', '2025-12-06', '3-5 hours', 'Monthly', 6, 4, 18, '[\"First Aid\",\"Design\"]', 'Some experience', 'Active', '2025-11-25', 453, 31, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(43, 'org_6921e0d3a443d', 7, 'Doloremque cum veritatis ea doloribus doloribus.', 'Tenetur sed sint perspiciatis. Id labore dolor rerum qui enim quis. Numquam qui voluptas quis at molestias. Et maxime qui doloremque esse aut ab sed. Illum necessitatibus qui natus. Voluptatem quia repellendus necessitatibus et qui corporis ut.', NULL, NULL, 'Hai Phong, 97899 Christiansen Circle Suite 556', 11.65589700, 105.57728200, '2025-12-06', '2026-02-01', '6-8 hours', 'Flexible', 17, 0, 21, '[\"Programming\",\"Photography\",\"First Aid\",\"Cooking\"]', 'Some experience', 'Paused', NULL, 344, 43, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(44, 'org_6921e0d3a443d', 3, 'Culpa sit molestiae repellat laborum.', 'Debitis rerum et omnis quibusdam itaque sed magnam. Cumque sit rerum nisi. Est velit molestiae laborum pariatur in. Repudiandae sunt in et unde est.', NULL, NULL, 'Hai Phong, 6672 Ryleigh Land', 16.53734400, 102.73194000, '2025-12-27', '2026-01-08', 'Full day', 'Flexible', 9, 5, 21, '[\"Programming\",\"Photography\",\"Teaching\"]', 'Some experience', 'Cancelled', '2025-12-15', 498, 42, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(45, 'org_6921e0d3a443d', 5, 'Saepe consequatur voluptatem laborum.', 'Recusandae autem delectus et necessitatibus. Ipsum quis quam quo repellendus beatae eius ab. Animi veritatis laborum dolor vel voluptatem. Nemo consequatur perferendis minima in ut sed dolorem totam.', 'Eos quasi cupiditate debitis vel eos. Eligendi officia odit ab rem illo.', NULL, 'Ho Chi Minh City, 96867 Feest Oval Apt. 586', 10.01062600, 107.77444700, '2026-01-18', '2026-01-24', 'Full day', 'Weekly', 5, 4, 21, '[\"First Aid\",\"Cooking\",\"Marketing\",\"Photography\"]', 'Some experience', 'Cancelled', '2025-12-27', 50, 3, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(46, 'org_6921e0d3a443d', 1, 'Accusamus rerum dolorem accusantium labore.', 'Porro beatae in incidunt dolores sint. Ab voluptatem exercitationem et eum distinctio autem blanditiis. Vel dolorem voluptatem et. Consequatur odio totam temporibus fugiat assumenda distinctio asperiores. Voluptatum vero provident id maiores quasi et corrupti.', NULL, NULL, 'Ho Chi Minh City, 616 Lamont Squares Suite 093', 16.89893300, 105.65360100, '2025-11-30', NULL, '3-5 hours', 'One-time', 9, 5, 21, '[\"Cooking\"]', 'Experienced', 'Completed', NULL, 457, 1, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(47, 'org_6921e0d3a443d', 6, 'Perferendis sit nesciunt quo.', 'Natus quasi pariatur quidem repudiandae modi eos eos. Nobis tempore alias iste nihil eos molestias quis. Provident sed ea exercitationem sapiente facilis id quod. Aliquam aut doloremque voluptatum quia et. Eligendi omnis nulla cum dolores et sequi eligendi. Sit earum eveniet amet sit recusandae dolore. Asperiores eius et neque quos nemo qui.', NULL, NULL, 'Hai Phong, 90383 Lon Inlet Suite 436', 12.84404300, 107.25394300, '2026-01-12', NULL, 'Full day', 'Monthly', 20, 2, 18, '[\"Translation\"]', 'No experience', 'Completed', '2025-12-22', 239, 6, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(48, 'org_6921e0d3a4e48', 5, 'Occaecati ut velit ut ut nobis similique dolorum.', 'Ullam illum a delectus eos sint consequatur ipsam qui. Dignissimos non occaecati eos est modi sunt officiis. Dolores error corrupti dolor officia unde. Assumenda temporibus illo in quia odio aut sint aut. Eos quibusdam illum consequatur impedit qui nemo. Voluptas beatae eum neque sunt aliquid.', 'Blanditiis sed deserunt ullam praesentium tempora illo nulla. Dolor occaecati nesciunt officia aspernatur. Quisquam similique debitis veniam commodi maiores vitae eum.', NULL, 'Hai Phong, 84498 Hodkiewicz Cove Suite 263', 21.85916300, 103.98766100, '2025-12-25', NULL, '3-5 hours', 'One-time', 7, 3, 16, '[\"Programming\",\"Teaching\",\"First Aid\",\"Translation\"]', 'Some experience', 'Active', '2025-12-04', 167, 29, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(49, 'org_6921e0d3a4e48', 7, 'Maxime sint ullam et explicabo minus ipsa.', 'Et nostrum cumque expedita aut quam ipsum nulla consequatur. Aut aut aperiam quia qui recusandae ut voluptatem. Dolores excepturi unde hic architecto a et rem. Asperiores ducimus amet delectus cum blanditiis.', 'Aut tenetur repellendus soluta officia. Quidem nisi molestiae nobis distinctio aut sunt.', 'Odio non quia ut perspiciatis consequatur labore iusto. Commodi corporis et voluptas eaque repudiandae iusto rerum.', 'Ho Chi Minh City, 713 VonRueden Port Apt. 070', 8.44015000, 103.20394400, '2025-12-05', NULL, '6-8 hours', 'Monthly', 12, 2, 18, '[\"Cooking\",\"Photography\"]', 'Some experience', 'Completed', '2025-11-26', 236, 12, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(50, 'org_6921e0d3a4e48', 6, 'Eum id quo enim labore aperiam sunt voluptatem.', 'Voluptates et dolore iste perspiciatis sit voluptas. Beatae eos ut dolorum non aliquid. Voluptas veritatis vitae ipsa dicta. Debitis maxime asperiores enim voluptas quasi nobis voluptas ex. Omnis voluptates quis et et. Porro tempore temporibus quis ipsam rerum fugit modi. Perferendis ut et et voluptate distinctio illo magni.', 'Magnam aut eos nostrum et adipisci nulla. Voluptatem quia voluptas harum nobis quisquam voluptatum. Distinctio possimus rem porro temporibus.', 'Voluptas veniam rerum dignissimos dolores. Quaerat quas beatae in est explicabo et.', 'Can Tho, 56361 Ewald Mills Apt. 898', 21.89802300, 102.49054300, '2025-12-24', NULL, '1-2 hours', 'Monthly', 3, 3, 18, '[\"Cooking\",\"Marketing\",\"Design\"]', 'Experienced', 'Completed', '2025-12-19', 174, 37, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(51, 'org_6921e0d3a4e48', 8, 'Repellat qui explicabo quia reprehenderit molestias nesciunt.', 'Non consequatur facere non excepturi. Consequatur praesentium modi fugit hic aliquam. Non optio adipisci distinctio non nostrum eos quia. In doloribus quia non harum reiciendis aut adipisci. Quia corporis sint doloremque dolorem.', NULL, NULL, 'Hai Phong, 46361 Rath Mall', 15.84916500, 109.06174500, '2025-12-09', '2026-01-12', '3-5 hours', 'Monthly', 4, 5, 16, '[\"Photography\",\"Design\"]', 'Some experience', 'Cancelled', NULL, 23, 9, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(52, 'org_6921e0d3a582a', 1, 'Nemo delectus impedit facere aut non reiciendis quia.', 'Eos molestias omnis omnis eum impedit aut. Quam minima fuga unde. Sed voluptatem reprehenderit ea quaerat nihil illum. Ducimus suscipit fugiat pariatur fuga.', 'Esse quo fugit dolorem et officia neque et porro. Vitae eveniet et itaque sapiente corporis.', 'Quo eos voluptas soluta nesciunt et. Reprehenderit sint quo ratione esse facilis. Ab facilis quos repellendus dolor.', 'Ho Chi Minh City, 477 Reilly Stream Suite 684', 13.91473600, 106.07042700, '2025-12-22', '2026-02-14', '6-8 hours', 'Weekly', 10, 5, 18, '[\"Programming\",\"Translation\",\"First Aid\",\"Teaching\"]', 'Experienced', 'Cancelled', NULL, 88, 47, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(53, 'org_6921e0d3a582a', 5, 'Ut et sapiente esse totam.', 'Inventore aut est quis. Voluptas molestias sed corporis cupiditate sint nihil quia. Delectus ducimus perspiciatis quam voluptatibus. Rem cupiditate et et tempora culpa temporibus consequatur.', NULL, 'Adipisci culpa autem consequatur inventore libero nesciunt. Corrupti sequi quisquam minima.', 'Hanoi, 53888 Troy Village Suite 463', 10.49941300, 108.19607400, '2025-12-22', '2026-01-22', '6-8 hours', 'One-time', 8, 0, 21, '[\"Programming\",\"Teaching\"]', 'Some experience', 'Completed', '2025-12-08', 426, 45, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(54, 'org_6921e0d3a582a', 6, 'Cumque dignissimos sunt et nam sed qui rerum.', 'In aut sit blanditiis dolor eos et optio. Quia quod at reprehenderit similique sunt. Beatae vitae alias est itaque ipsa asperiores non. Debitis asperiores dicta provident sint eaque est. Ipsa nulla aut autem mollitia in quos ratione. Vero ea et impedit. Consequatur soluta numquam qui.', NULL, NULL, 'Ho Chi Minh City, 4685 Wiegand Glen Apt. 461', 17.81689200, 108.11391000, '2026-01-17', '2026-01-29', 'Full day', 'Weekly', 17, 4, 21, '[\"Writing\",\"Teaching\"]', 'Experienced', 'Completed', NULL, 271, 8, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(55, 'org_6921e0d3a582a', 4, 'Rerum laboriosam laboriosam odio esse distinctio explicabo aut.', 'Id animi reiciendis dolorem quia vel. Qui provident et distinctio eos aut dignissimos reiciendis. Error voluptatem officiis nihil. Quibusdam tenetur magni eos tempora dicta omnis reprehenderit.', 'Consequatur consequatur aut accusantium sed. Accusamus quis doloribus est sed. Aut id qui est natus.', 'Voluptate unde est eos illum numquam. Omnis unde ex aspernatur assumenda consequatur accusamus. Eius temporibus praesentium rerum molestiae maxime sunt odit est.', 'Da Nang, 449 Bailey Street Apt. 918', 14.37189700, 102.02045200, '2025-11-26', NULL, '3-5 hours', 'Flexible', 12, 0, 18, '[\"First Aid\"]', 'Experienced', 'Cancelled', '2025-11-26', 193, 20, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(56, 'org_6921e0d3a582a', 2, 'Amet mollitia harum aspernatur illo dolore quia consectetur.', 'Ullam alias et aut aut quia rem. Adipisci veritatis qui praesentium ut occaecati dolorem. Id omnis magnam repellat consectetur et ipsa et veniam. Voluptas laudantium ad rem nemo voluptatibus libero quo cupiditate. Qui iste facere dolorem temporibus nesciunt.', NULL, NULL, 'Can Tho, 149 Fahey Crossroad', 21.67411400, 104.37271700, '2025-11-30', NULL, 'Full day', 'Flexible', 2, 1, 16, '[\"Teaching\",\"Programming\",\"Marketing\"]', 'Experienced', 'Active', NULL, 79, 28, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(57, 'org_6921e0d3a582a', 2, 'Ullam et commodi suscipit aut qui.', 'Qui nulla repudiandae nisi minus consequatur omnis voluptates. Cupiditate sequi adipisci eos ipsum soluta illum. Quisquam ab voluptatibus ipsum ea quae perferendis occaecati. Tempore exercitationem dolorem earum numquam odit.', 'Id eveniet quas incidunt alias nobis illo est. Qui necessitatibus nostrum vero neque ex ratione fugiat.', NULL, 'Ho Chi Minh City, 277 Adele Throughway Apt. 976', 11.94015900, 102.70501900, '2025-11-28', '2026-01-22', '1-2 hours', 'Monthly', 7, 0, 16, '[\"Marketing\",\"Translation\",\"Cooking\"]', 'Some experience', 'Paused', '2025-11-25', 212, 8, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(58, 'org_6921e0d3a6202', 3, 'Voluptas culpa quaerat dolorum doloremque voluptatem.', 'Inventore numquam quo beatae quibusdam dolorem cum. Minus et voluptate recusandae animi incidunt ullam voluptate officia. Sit eum neque id error aut molestiae. Distinctio laudantium error qui odio hic provident.', 'Inventore accusamus aut autem ut aspernatur. Sed saepe aut voluptate iste tempora aut eum.', NULL, 'Hai Phong, 76327 Marisa Gardens Apt. 136', 13.85479600, 108.82472800, '2025-11-29', NULL, '1-2 hours', 'One-time', 8, 5, 18, '[\"Writing\"]', 'Some experience', 'Active', NULL, 362, 43, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(59, 'org_6921e0d3a6202', 4, 'Dolorem voluptate deleniti ea ad laborum placeat ea.', 'Ea dolorem delectus nulla magni. Occaecati fugit debitis inventore officia labore commodi. Impedit at reprehenderit officiis delectus ducimus. Et earum aut deserunt voluptas mollitia eos natus quis. Dolorum odio non vero ipsum quam laudantium. Architecto asperiores quisquam qui mollitia minus nihil. Aut aperiam aliquid aut.', NULL, NULL, 'Da Nang, 2217 Jayden Court', 9.64026500, 102.85746500, '2026-01-20', NULL, '6-8 hours', 'One-time', 14, 4, 18, '[\"Teaching\",\"Cooking\",\"Translation\",\"Programming\"]', 'No experience', 'Completed', '2025-11-24', 279, 24, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(60, 'org_6921e0d3a6202', 6, 'Vitae harum necessitatibus tempora.', 'Sit blanditiis quas et molestiae praesentium repellendus quia. Et enim eos odio. Reiciendis perferendis et quos. At quo odio est ad voluptatem iste quae.', NULL, NULL, 'Hanoi, 1758 Tamara Divide', 10.30715000, 107.03810700, '2025-11-28', '2026-01-14', 'Multiple days', 'One-time', 18, 0, 18, '[\"Translation\"]', 'Some experience', 'Cancelled', '2025-11-25', 35, 13, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(61, 'org_6921e0d3a6202', 4, 'Quia tenetur nobis error est aperiam hic sint.', 'Enim eos recusandae ipsa vitae aut optio. Neque hic est accusantium numquam et minima quidem. Nihil et rem qui consequuntur qui. Earum non quos eveniet provident delectus. Eum reiciendis maiores est dolor non temporibus. Ex rerum repellendus dolorem aut excepturi deleniti. Tenetur sapiente aspernatur consequatur.', 'Quod sequi excepturi consequatur consequatur atque ipsa ducimus saepe. Quia placeat aut ipsa. Maxime expedita voluptatum voluptatem et.', 'Omnis nesciunt rerum voluptatem et maxime voluptas voluptas fugit. Voluptate quos quia dolor deleniti eum id eum. Et consequuntur pariatur quas sapiente.', 'Can Tho, 8693 Lind Inlet', 8.40899600, 107.12209600, '2025-12-03', NULL, '3-5 hours', 'Flexible', 2, 2, 21, '[\"Cooking\",\"Translation\",\"Marketing\"]', 'Experienced', 'Active', NULL, 412, 11, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(62, 'org_6921e0d3a6202', 4, 'Neque consequuntur saepe quisquam ex adipisci.', 'Et perferendis modi rerum sit cupiditate consequatur quia. Maxime quisquam necessitatibus illo assumenda. Beatae labore dicta animi blanditiis optio eius. Reprehenderit sed repudiandae illo. Fugit et pariatur voluptas vel.', NULL, NULL, 'Can Tho, 4510 Tremblay Overpass Suite 619', 19.02739800, 102.93482700, '2025-12-07', NULL, 'Multiple days', 'Monthly', 10, 4, 18, '[\"Cooking\",\"Teaching\",\"First Aid\",\"Writing\"]', 'Some experience', 'Active', NULL, 258, 45, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(63, 'org_6921e0d3a6202', 7, 'Quaerat reiciendis officiis perferendis ratione ratione.', 'Ea inventore odio consequuntur ullam similique consequuntur omnis. Qui in qui qui voluptatum ex velit. Officiis ad explicabo omnis rerum. Exercitationem provident est aliquid. Voluptas omnis molestiae maxime ut quam fuga.', NULL, 'Eos modi ad dolores iste quasi. Vel dolores doloremque sequi sunt omnis. Necessitatibus ut placeat nostrum aut.', 'Can Tho, 210 Steuber Ferry', 18.98398800, 103.21318500, '2026-01-14', NULL, 'Full day', 'Weekly', 4, 5, 16, '[\"Cooking\",\"Teaching\",\"Design\",\"Photography\"]', 'Some experience', 'Active', NULL, 283, 8, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(64, 'org_6921e0d3a6c01', 3, 'Voluptatem quia animi ut sint dolores sed cupiditate.', 'Quisquam quia expedita qui omnis velit. Illo odio voluptatum assumenda laudantium est illum eligendi. Impedit et consectetur tenetur fuga quam fugiat deleniti facilis. Quia voluptatem ipsa ut enim adipisci deleniti illum.', 'Dolorem molestiae maxime quis aut non. Blanditiis quaerat itaque sint non voluptatem fugit. Deserunt placeat debitis tempore esse ut autem sequi sunt.', NULL, 'Hai Phong, 460 Jenkins Route', 11.34376900, 107.05488400, '2026-01-01', '2026-01-31', 'Multiple days', 'Weekly', 19, 0, 16, '[\"Photography\",\"Translation\",\"First Aid\",\"Programming\"]', 'No experience', 'Paused', '2025-12-10', 131, 24, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(65, 'org_6921e0d3a6c01', 2, 'Similique debitis exercitationem quidem ducimus eos reiciendis.', 'Sunt doloremque delectus eum dolorem consequatur ut. Aut sit voluptatem eos. Nihil aut et dicta minima tempora ipsa. Dignissimos et error atque. Sed dolorem dolores doloribus laudantium quia sed consequatur.', 'Nihil odio iusto eius repellendus iste eum distinctio qui. Facere doloremque sint velit magni deserunt. Et est non hic.', 'Fuga inventore molestiae laudantium in voluptas. Temporibus quia provident et nisi. Voluptate ipsam consequuntur accusamus modi quo fugiat.', 'Can Tho, 5173 Little Square Suite 629', 8.36949500, 106.59628800, '2026-01-08', NULL, 'Multiple days', 'Monthly', 4, 4, 18, '[\"Marketing\",\"Photography\",\"Cooking\"]', 'Experienced', 'Cancelled', NULL, 160, 44, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(66, 'org_6921e0d3a6c01', 3, 'Voluptatem velit modi assumenda nisi deleniti amet id.', 'Eaque consectetur magnam voluptatem quis consequatur dolorem quod. Deserunt est soluta non. Dicta exercitationem et non blanditiis et sit voluptatem. Qui autem nam blanditiis consectetur autem dolorem similique magni.', NULL, 'Ipsum possimus corporis cupiditate sed. Iusto esse totam veniam dolorem aperiam. Dolorem facilis iure quos omnis dignissimos odit ratione.', 'Da Nang, 854 Glover View', 20.58105300, 108.67426400, '2026-01-09', NULL, '6-8 hours', 'Flexible', 10, 1, 18, '[\"Marketing\",\"Photography\",\"Cooking\",\"Translation\"]', 'No experience', 'Active', NULL, 20, 17, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(67, 'org_6921e0d3a6c01', 8, 'Pariatur repellendus quia ipsa repudiandae eligendi harum.', 'Eum minus culpa iusto numquam sequi et. Laboriosam fugiat voluptatem porro nisi libero quod qui. Sed doloribus quia eveniet ut sapiente. Nam accusamus quisquam quam excepturi.', 'Non voluptates suscipit officiis eum itaque. Accusamus laborum odio sed. Fuga saepe et culpa eos est id ad.', 'Sint voluptatum quo error enim. Fugit recusandae et animi rerum officiis sunt. Eligendi magni quibusdam animi et perferendis dignissimos.', 'Da Nang, 7159 Franz Union Suite 072', 19.84501200, 103.74281400, '2025-12-29', NULL, 'Full day', 'Flexible', 6, 5, 18, '[\"Programming\",\"Translation\",\"Marketing\",\"Photography\"]', 'No experience', 'Cancelled', '2025-11-27', 436, 23, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(68, 'org_6921e0d3a6c01', 2, 'Non qui repellat veritatis impedit et.', 'Deleniti autem ea veniam asperiores rem in. Ea eaque commodi magnam ut. Ut aut veniam nam aliquid eligendi ut. Quis minima in dolor autem ex autem veritatis. Sit enim accusantium molestias aut nihil aut quidem.', 'Et perspiciatis iusto maiores voluptatibus. Nulla quod dignissimos deserunt numquam.', 'Illum nihil recusandae nihil facere. Maxime perspiciatis ipsa voluptates sint. Deleniti eum est ipsum esse dolor.', 'Ho Chi Minh City, 74983 Wade Path Apt. 429', 9.18962500, 108.76740400, '2025-11-27', '2026-01-02', '1-2 hours', 'One-time', 10, 2, 18, '[\"Design\"]', 'Some experience', 'Active', NULL, 129, 28, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(69, 'org_6921e0d3a6c01', 7, 'Aut incidunt magni nihil unde.', 'Ducimus suscipit qui error sint mollitia voluptate praesentium. Enim praesentium deserunt dolor. Odio rerum ex et recusandae et. Architecto velit natus quibusdam ducimus. Tempore non molestiae cum nam officia praesentium porro.', NULL, NULL, 'Ho Chi Minh City, 5997 Idella Fall Apt. 768', 22.67996700, 109.46214100, '2026-01-02', NULL, 'Multiple days', 'Flexible', 4, 5, 16, '[\"Design\",\"Translation\",\"Marketing\",\"Writing\"]', 'Some experience', 'Active', NULL, 55, 49, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(70, 'org_6921e0d3a6c01', 1, 'In odio ab in necessitatibus dicta.', 'Quae nihil doloremque nulla aspernatur esse. Et voluptas sint praesentium quia et ut aut ut. Minus dolorem quia distinctio labore eos. Beatae perspiciatis ea similique qui quam dicta. Quae fuga non voluptates saepe exercitationem. Beatae qui aut id.', 'Quam neque atque sed omnis culpa. Natus delectus voluptatem temporibus rem mollitia qui officiis. Dignissimos sint est nam totam consequuntur nostrum.', NULL, 'Hai Phong, 8649 Deven River Suite 920', 10.66180500, 106.74934300, '2025-12-14', '2026-02-09', '3-5 hours', 'Monthly', 5, 4, 18, '[\"First Aid\",\"Teaching\",\"Photography\",\"Cooking\"]', 'Experienced', 'Paused', '2025-11-24', 400, 30, '2025-11-22 16:12:04', '2025-11-22 16:12:04');
INSERT INTO `volunteer_opportunities` (`opportunity_id`, `org_id`, `category_id`, `title`, `description`, `requirements`, `benefits`, `location`, `latitude`, `longitude`, `start_date`, `end_date`, `time_commitment`, `schedule_type`, `volunteers_needed`, `volunteers_registered`, `min_age`, `required_skills`, `experience_needed`, `status`, `application_deadline`, `view_count`, `application_count`, `created_at`, `updated_at`) VALUES
(71, 'org_6921e0d3a6c01', 7, 'Autem veritatis consequatur atque aut est nostrum necessitatibus.', 'Soluta aut qui aut ratione. Sed sed aperiam nesciunt aut cumque quod accusamus. Sunt ex aut eum ab. Ut non tempora facilis aspernatur.', 'Assumenda et possimus sed quas. Consequatur nulla reprehenderit et libero architecto et dolorem. Fugiat culpa quas quo aut ea cum.', 'Nihil vel et ut quia alias. Eaque voluptate fuga corporis veniam fugiat incidunt. Voluptatem molestiae dolorem omnis nobis.', 'Da Nang, 9034 Altenwerth Wells', 12.88689800, 109.12158900, '2025-12-24', '2026-02-19', '3-5 hours', 'Weekly', 18, 1, 16, '[\"Cooking\",\"Writing\",\"First Aid\"]', 'No experience', 'Completed', NULL, 265, 26, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(72, 'org_6921e0d3a75be', 6, 'Sed vero id ullam consectetur quia atque sed.', 'Reprehenderit voluptatibus mollitia eos est. Laudantium occaecati a repellat inventore aut. Porro ad maxime architecto hic ipsa ratione et. Aut minus inventore deserunt. Voluptas odio accusamus modi soluta. Voluptatem quo reprehenderit maiores.', NULL, 'Ut maiores consequatur voluptatem id. Et tempore sed quia cupiditate delectus quasi odio unde.', 'Hanoi, 4097 Cecelia Street Suite 848', 19.98258400, 103.13605100, '2025-12-03', NULL, 'Multiple days', 'Weekly', 19, 5, 18, '[\"Marketing\"]', 'Experienced', 'Paused', NULL, 15, 48, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(73, 'org_6921e0d3a75be', 7, 'Molestiae quidem soluta fugit officiis repudiandae.', 'Natus molestiae nemo magni quaerat neque tenetur cum natus. Tempora sint sunt eaque asperiores et voluptatem amet tempore. Aliquid nemo sunt est possimus doloribus quis aut ipsa. Laudantium quis quod sapiente ipsum et. Et et sed cupiditate veritatis voluptatem. Magni perferendis molestiae repellat molestias.', 'Modi unde odio commodi earum culpa nisi assumenda. Rerum nobis autem eius sit.', NULL, 'Da Nang, 5339 Trinity Passage Apt. 865', 11.92592000, 104.92823700, '2025-12-04', NULL, '6-8 hours', 'One-time', 19, 3, 21, '[\"Writing\",\"Photography\"]', 'Experienced', 'Completed', '2025-11-30', 220, 44, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(74, 'org_6921e0d3a75be', 4, 'Perferendis modi perferendis quia sequi est voluptas animi et.', 'Eos et nihil et accusamus autem. Voluptatem voluptas aut nam molestiae maxime eligendi esse fugit. Sit dolorum quis nostrum sunt molestiae et. Ipsa pariatur eos laboriosam. Nam aut odio dolores alias veritatis et. Omnis omnis doloribus mollitia quasi aut eum.', 'Molestiae vero sunt ipsa tenetur. Est qui et enim aut maxime quis modi. Quam saepe omnis incidunt rem.', 'Alias molestias praesentium consequatur amet atque consequatur ut. Autem quidem cumque omnis rerum enim.', 'Ho Chi Minh City, 720 Effertz Views Suite 154', 12.65227700, 106.19552000, '2025-12-03', NULL, '3-5 hours', 'Weekly', 20, 3, 16, '[\"Writing\",\"Cooking\",\"Photography\"]', 'Some experience', 'Paused', NULL, 329, 0, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(75, 'org_6921e0d3a75be', 1, 'Aperiam ipsum dolorem et dolorem velit.', 'Omnis qui voluptas vel nulla. Dolorem maxime ut animi in. Magni iure eum modi labore est. Asperiores itaque dolor facilis quidem qui eum iste perspiciatis. Numquam tempora iure vitae at cum qui aliquam voluptas. Ipsum est voluptas ratione ducimus.', NULL, 'Mollitia dolore sint aut aut provident eaque. Repudiandae rem deserunt sint blanditiis velit quo.', 'Hai Phong, 6698 Dorian Vista', 10.24440300, 106.09902200, '2026-01-03', NULL, '3-5 hours', 'One-time', 2, 3, 18, '[\"Translation\"]', 'No experience', 'Cancelled', NULL, 286, 24, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(76, 'org_6921e0d3a75be', 6, 'Sed est voluptatem illo soluta.', 'Dolor perspiciatis facere et. Sunt culpa qui voluptatum soluta corrupti et. Voluptatem beatae porro deleniti temporibus. Quibusdam et perspiciatis quod laborum enim. Quia praesentium qui nulla commodi. Qui est vel consequatur et ab est.', NULL, 'Quaerat fugiat et sint ad id qui ipsum. Rerum dolorem aut sed cum laboriosam aspernatur. Ut vitae incidunt et molestiae.', 'Hanoi, 66562 Bogan Crossing', 9.18707400, 109.71914200, '2025-12-20', '2026-01-14', '3-5 hours', 'Flexible', 4, 1, 16, '[\"First Aid\"]', 'Experienced', 'Active', NULL, 18, 35, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(77, 'org_6921e0d3a7f9c', 8, 'Mollitia labore dolorem porro totam in laboriosam sed.', 'Necessitatibus commodi vel nam quo exercitationem voluptatibus. Voluptates consequatur vel officia perspiciatis. Officia minus incidunt et. Dolor impedit sequi facere enim cum expedita.', NULL, NULL, 'Hanoi, 955 Gideon Fort Suite 433', 8.88272200, 103.21530000, '2026-01-08', NULL, '1-2 hours', 'Weekly', 5, 1, 21, '[\"Teaching\",\"Cooking\",\"Design\"]', 'No experience', 'Active', '2026-01-03', 407, 48, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(78, 'org_6921e0d3a7f9c', 3, 'Facilis necessitatibus laudantium doloribus aliquid laboriosam facilis est.', 'Qui fugit minus corporis velit corrupti. Impedit in ducimus dicta qui voluptatibus. Asperiores cum sit autem quibusdam perferendis tempora. Qui veniam earum quia deserunt.', NULL, NULL, 'Da Nang, 55183 Friesen Row Suite 637', 17.65183900, 109.23643600, '2025-12-13', '2026-02-14', 'Full day', 'Flexible', 16, 5, 21, '[\"Design\",\"Translation\"]', 'No experience', 'Cancelled', NULL, 179, 30, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(79, 'org_6921e0d3a7f9c', 4, 'Ut corrupti saepe necessitatibus totam dicta dolor in tempora.', 'Tempore facere nam harum doloribus est. Culpa omnis nihil beatae alias soluta. Omnis enim voluptates quo pariatur impedit qui. Omnis mollitia quis est vel.', NULL, 'Fugit maxime voluptatum repudiandae corrupti. Eveniet sit eius debitis ea et at.', 'Hanoi, 309 Cristian Green', 20.41433800, 107.27370000, '2026-01-12', '2026-02-12', 'Full day', 'Flexible', 1, 3, 16, '[\"Writing\",\"Teaching\",\"Marketing\",\"Photography\"]', 'No experience', 'Paused', NULL, 104, 50, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(80, 'org_6921e0d3a7f9c', 4, 'Id sunt reiciendis quis rerum magni optio.', 'Assumenda omnis voluptas voluptatem laborum. Iste dolorum eligendi architecto illum quo vero nisi id. Velit doloremque consectetur delectus doloribus. Pariatur placeat voluptatibus dolore voluptatem rerum quis quis.', 'Eius optio sint et accusamus occaecati facere placeat. Qui maxime quaerat ipsum dolorum aspernatur. Distinctio reprehenderit ea est quo.', 'Dolor culpa omnis sed eaque. Non assumenda cupiditate libero ut.', 'Da Nang, 3859 Janick Shoals Apt. 503', 15.08007300, 108.38222700, '2025-12-31', NULL, '6-8 hours', 'One-time', 1, 3, 21, '[\"Writing\",\"Programming\",\"Design\"]', 'Some experience', 'Cancelled', '2025-12-05', 162, 16, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(81, 'org_6921e0d3a7f9c', 4, 'Occaecati doloremque eos aut dolorum.', 'Quo qui explicabo molestiae et fugit cumque. Et qui suscipit rerum odit voluptas sint sit velit. Veritatis facilis praesentium eum. Quae id voluptates delectus optio.', 'Inventore quis quia blanditiis. Quia optio dolor soluta quia iusto harum quas.', NULL, 'Da Nang, 98666 Waelchi Gateway', 15.38172000, 108.91268200, '2026-01-18', NULL, '3-5 hours', 'Monthly', 15, 2, 21, '[\"Marketing\",\"Cooking\"]', 'Some experience', 'Active', NULL, 421, 43, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(82, 'org_6921e0d3a7f9c', 5, 'Qui hic odit at.', 'Aperiam magnam et molestiae est quaerat maiores aspernatur. Dolorem voluptatem explicabo in rerum dicta sit impedit. Quia voluptatibus omnis voluptatibus pariatur. Provident vel sit dolorum dolores sapiente. Impedit cupiditate dolorem quas. Omnis ipsam omnis minus voluptates quia consequatur accusamus.', 'Quo quia quam tempora magni sapiente asperiores. Minus esse nam sint dignissimos ut.', 'Animi cum rerum quod. Eveniet earum ipsum sint. Voluptatibus in quae fugiat non sapiente nesciunt illo.', 'Can Tho, 18500 Kessler Radial Apt. 153', 12.51085300, 104.97454000, '2025-11-30', '2026-01-03', '6-8 hours', 'One-time', 6, 4, 21, '[\"Programming\",\"Translation\"]', 'Some experience', 'Cancelled', NULL, 324, 46, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(83, 'org_6921e0d3a7f9c', 4, 'Temporibus sapiente architecto praesentium doloribus.', 'Similique hic est et. Consequatur et quos sunt hic quo. Hic hic reprehenderit placeat optio maxime aspernatur distinctio magnam. Saepe occaecati nihil iusto laborum qui voluptas. Voluptatem iusto sed et delectus.', 'Veritatis veniam et libero adipisci soluta aut sunt. Iusto amet pariatur vel earum minima qui facilis. Deleniti occaecati repudiandae fugit qui tenetur sunt.', NULL, 'Can Tho, 2674 Mafalda Union Suite 787', 16.92129100, 103.60349500, '2025-12-17', '2026-01-24', '3-5 hours', 'Weekly', 16, 3, 18, '[\"Writing\",\"Cooking\"]', 'No experience', 'Cancelled', NULL, 415, 24, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(84, 'org_6921e0d3a7f9c', 2, 'Consequuntur voluptate maxime dolores voluptas.', 'Possimus sed quia sapiente nemo. Sed ex voluptatibus voluptatibus ea saepe sunt magnam. Culpa expedita numquam praesentium. Ut aut consectetur aut asperiores nulla quam distinctio. Nam enim voluptas voluptatem modi harum ab aut. Corporis deleniti facilis aut sunt hic.', 'Ut eius ut est laboriosam accusantium odit accusantium. Eligendi aut ad praesentium corrupti necessitatibus iusto alias. Modi blanditiis et illum quasi.', 'Ut in vel consequatur sit. Odio dolorem beatae ut. A deserunt porro omnis sint dolorem ducimus.', 'Can Tho, 6126 Ward Flats Suite 569', 12.72906400, 105.34882200, '2025-12-27', '2026-01-26', '1-2 hours', 'One-time', 14, 0, 16, '[\"Marketing\",\"Design\"]', 'No experience', 'Active', '2025-12-16', 307, 18, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(85, 'org_6921e0d3a8900', 2, 'Quia quidem dolorem qui ipsam qui.', 'Et dolorum rerum delectus. Omnis voluptatum nulla quis pariatur quia sapiente eveniet veritatis. Odio dignissimos odio sed qui perspiciatis fuga. Possimus recusandae consequuntur ut est qui consequatur reiciendis. Ut architecto nostrum quis consequatur. Omnis quod ut sint debitis sit.', 'Rerum provident porro accusamus ut at. Nihil nisi est vel consequuntur ea minus. Aspernatur odio odit necessitatibus reprehenderit qui totam.', 'Unde expedita autem ut est ut. Similique soluta quo voluptates omnis et nam cupiditate enim.', 'Da Nang, 916 Bethany Bridge', 11.18873800, 105.38671600, '2026-01-06', NULL, '3-5 hours', 'One-time', 19, 3, 18, '[\"Marketing\",\"Photography\",\"First Aid\",\"Design\"]', 'Experienced', 'Cancelled', '2025-12-11', 102, 40, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(86, 'org_6921e0d3a8900', 2, 'Ea inventore animi est voluptas eos excepturi.', 'Rem commodi sed omnis voluptatum et. Sit veritatis asperiores reprehenderit laudantium ut quo. Et quod quod quis odio quod quo repudiandae. Commodi aliquid molestiae sit laborum minima.', 'Voluptas earum aut aut illum aut est. Iste accusantium molestias reprehenderit voluptas necessitatibus maiores sunt et.', NULL, 'Da Nang, 2075 Gia Parkways', 22.10714600, 102.39397100, '2025-12-18', '2025-12-19', 'Full day', 'Weekly', 14, 5, 18, '[\"Marketing\",\"First Aid\",\"Teaching\"]', 'No experience', 'Cancelled', '2025-12-14', 261, 49, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(87, 'org_6921e0d3a8900', 8, 'Amet pariatur veritatis officiis et.', 'Enim similique provident corporis iure illum alias. Ut autem fuga aperiam fugiat. Eaque veniam aut provident eaque. Inventore praesentium cumque aut repellendus vel aut quasi.', 'Sint dolores molestias cupiditate magni laudantium molestiae. Sed eos voluptates distinctio magnam ullam quidem. Consequatur quia repellendus ut quo.', 'Vero veritatis sed molestiae nobis explicabo quia molestiae. Molestiae modi in ullam quia aut labore sit consequuntur.', 'Da Nang, 5371 Pauline Vista', 9.20141400, 108.14210700, '2025-12-25', NULL, '6-8 hours', 'Weekly', 6, 1, 18, '[\"First Aid\",\"Translation\",\"Teaching\",\"Photography\"]', 'Some experience', 'Cancelled', NULL, 278, 9, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(88, 'org_6921e0d3a8900', 8, 'Illum omnis quibusdam doloribus saepe est sed maiores cumque.', 'Et ut in dicta rerum consequatur debitis. Similique non dolores excepturi quae dolor architecto qui. Harum eligendi sit sunt est et laudantium. A consequatur nemo dignissimos. Sed sed odio possimus necessitatibus et possimus hic provident.', NULL, NULL, 'Da Nang, 4455 Mark Station', 20.69354300, 108.36193300, '2026-01-03', '2026-01-27', '6-8 hours', 'Flexible', 1, 3, 18, '[\"Cooking\"]', 'Some experience', 'Active', NULL, 143, 14, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(89, 'org_6921e0d3a9341', 8, 'Voluptatibus deserunt modi quas ipsum enim.', 'Quam iste iusto modi qui. Nam delectus dolorum repellendus dolores similique est. Velit qui nisi sequi et sed voluptatem. Ipsam quia commodi quis amet qui ullam. Dolor et eos rerum fugit. Assumenda expedita ea et veritatis eius dignissimos.', NULL, NULL, 'Can Tho, 6811 Carmen Alley', 15.70998100, 109.77753100, '2025-12-30', '2026-02-19', '6-8 hours', 'One-time', 2, 3, 18, '[\"Cooking\",\"First Aid\",\"Programming\"]', 'No experience', 'Cancelled', NULL, 105, 35, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(90, 'org_6921e0d3a9341', 1, 'Nam rerum iste qui velit optio non autem.', 'Ut ea unde non. Ad non delectus in tempora laboriosam. Ipsa libero ipsum dolore amet delectus vero commodi. Dolorem magnam ipsa magni atque.', NULL, 'Similique repellat dolorem ipsum veritatis. Velit alias consequatur est ut et. Et natus est voluptate consequatur quae.', 'Can Tho, 66766 Guido Roads Apt. 836', 19.45469500, 108.64133400, '2025-12-01', '2026-02-05', '3-5 hours', 'Monthly', 16, 4, 18, '[\"Programming\",\"Design\"]', 'Experienced', 'Cancelled', NULL, 196, 19, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(91, 'org_6921e0d3a9341', 3, 'Sequi sint qui rerum ut voluptatem.', 'Esse amet beatae consectetur eius expedita. Accusamus quo eveniet molestiae nesciunt. Beatae saepe qui adipisci in excepturi quas. Quasi dolor sunt omnis maxime incidunt qui.', 'Rerum ut ut quaerat voluptatem et. Inventore voluptas vitae eum ut qui nisi.', 'Nihil deleniti vel dolorum beatae ab id. Aut est qui fugiat vitae maxime quod voluptas.', 'Hanoi, 90676 Braun Green', 19.80315900, 109.52639800, '2025-12-21', NULL, 'Multiple days', 'One-time', 16, 4, 16, '[\"First Aid\",\"Translation\",\"Photography\"]', 'No experience', 'Cancelled', '2025-12-02', 75, 43, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(92, 'org_6921e0d3a9341', 4, 'Voluptatem iusto totam est ullam et expedita.', 'Sed incidunt et cum ut minus dolorem. Asperiores et praesentium quae aut est quam. Omnis fuga delectus beatae voluptatem veniam. Aperiam esse corporis quo. A ipsam deleniti ab dolor veniam omnis.', NULL, 'Et tempore voluptate repellat est repellat provident accusamus. Perferendis praesentium beatae ut illo debitis praesentium iure.', 'Hanoi, 9522 Gladys Keys', 10.03064400, 105.72391300, '2025-12-04', '2026-01-16', 'Multiple days', 'Flexible', 18, 5, 21, '[\"Marketing\",\"First Aid\"]', 'No experience', 'Active', NULL, 372, 2, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(93, 'org_6921e0d3a9341', 4, 'Culpa ipsam doloribus nulla sint.', 'In ut voluptatibus voluptatem excepturi corporis tenetur. Vitae impedit necessitatibus et reiciendis soluta fuga. Et dolores error ut cum eligendi eos. Necessitatibus temporibus quia voluptatem voluptas rem quia. Asperiores maxime sed commodi a aperiam nemo quo fugiat. Aut rerum inventore et quam.', NULL, NULL, 'Hai Phong, 5421 Renner Street Suite 753', 12.72038500, 109.29270800, '2026-01-18', NULL, '6-8 hours', 'Weekly', 2, 0, 16, '[\"Cooking\",\"Programming\",\"First Aid\",\"Design\"]', 'No experience', 'Active', '2026-01-13', 229, 2, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(94, 'org_6921e0d3a9f76', 7, 'Et mollitia qui et laborum et.', 'Dolorem recusandae beatae voluptatem autem. Nisi impedit similique eius asperiores distinctio. Optio et fugit sunt culpa libero. Enim at voluptatem nam voluptatibus illo alias. Tempora fugit soluta ut corrupti aut voluptatibus. Cupiditate occaecati rerum quae dolores.', 'Nulla laborum ipsum sed voluptas illo ratione harum. Quasi ratione eligendi commodi rem blanditiis.', NULL, 'Ho Chi Minh City, 6059 Brooke Street', 14.53372700, 109.10779300, '2025-12-15', NULL, '3-5 hours', 'Weekly', 20, 0, 18, '[\"Teaching\"]', 'No experience', 'Cancelled', NULL, 441, 10, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(95, 'org_6921e0d3a9f76', 3, 'Neque explicabo aut ducimus ratione facilis recusandae.', 'Reprehenderit earum architecto in aut. Ullam ut earum minima sed tempora ut. Neque veniam quidem incidunt nihil ullam dolorem. Ad assumenda earum qui voluptatum occaecati.', NULL, 'Velit ut corrupti reiciendis. Dolor perferendis atque modi perferendis. Blanditiis quo nemo modi eos.', 'Can Tho, 137 Houston Estates Apt. 225', 21.89307900, 106.54305900, '2025-11-28', NULL, '1-2 hours', 'Flexible', 6, 1, 21, '[\"Programming\",\"Photography\",\"First Aid\"]', 'Some experience', 'Cancelled', '2025-11-26', 358, 11, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(96, 'org_6921e0d3a9f76', 7, 'Expedita molestiae id tempore esse magnam.', 'Sequi blanditiis enim optio quia voluptatem dolor. Debitis voluptate facere voluptate maxime et ea et. Accusamus et est voluptates magni doloremque. Non quas fugiat porro non impedit sequi et.', 'Consectetur dolores quo optio deserunt accusantium. Unde maiores officiis nam nostrum. Repellendus qui veniam sint provident.', NULL, 'Hanoi, 2296 Schimmel Falls', 16.61101400, 104.35993300, '2026-01-18', NULL, '3-5 hours', 'Weekly', 17, 3, 21, '[\"Marketing\",\"Translation\",\"Teaching\",\"Photography\"]', 'Some experience', 'Paused', '2025-11-29', 321, 4, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(97, 'org_6921e0d3a9f76', 6, 'Sed sunt mollitia et qui minus.', 'Voluptate voluptas architecto repudiandae accusantium accusantium alias sit consectetur. Natus rerum asperiores aut. Debitis rerum ducimus molestiae repellendus eos. Ut hic sit omnis unde aspernatur accusantium eligendi.', NULL, NULL, 'Can Tho, 33351 Ondricka Trail Apt. 680', 10.02336300, 104.25001900, '2026-01-19', '2026-02-18', '1-2 hours', 'Monthly', 1, 1, 21, '[\"Cooking\",\"Photography\"]', 'Experienced', 'Active', NULL, 406, 44, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(98, 'org_6921e0d3a9f76', 1, 'Accusantium cum unde voluptatem vel quaerat.', 'Nobis dolores numquam doloribus. Dicta quae iusto sed quaerat est fugit expedita. Expedita voluptates sint eum voluptas corporis est dolorem. Dolor officia nisi dolores nobis. Neque repellat sed ut possimus sit exercitationem dolorem quis. Laborum repellat voluptatem voluptates. Repellendus provident sapiente libero ullam nobis sed optio.', NULL, NULL, 'Hai Phong, 6906 Tremayne Throughway Apt. 898', 22.38823100, 103.05831600, '2025-12-21', NULL, '1-2 hours', 'Flexible', 3, 2, 18, '[\"Translation\",\"Design\"]', 'Experienced', 'Completed', NULL, 303, 6, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(99, 'org_6921e0d3aa933', 7, 'Est dolor ratione eum sapiente pariatur.', 'Fugiat ratione ut sed et voluptatem dicta. Ad officia qui eveniet fugit. Beatae laboriosam nam necessitatibus exercitationem autem. Occaecati non a repudiandae eius eos et.', NULL, NULL, 'Hai Phong, 275 Norma Wells Suite 541', 18.82231600, 107.66365700, '2026-01-06', NULL, '1-2 hours', 'Flexible', 16, 2, 18, '[\"Photography\",\"Teaching\"]', 'Experienced', 'Completed', '2025-11-27', 270, 42, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(100, 'org_6921e0d3aa933', 7, 'Nostrum voluptas a quod.', 'Iste fuga voluptas mollitia ratione. Quo quia sed est veniam fugiat reprehenderit. Similique pariatur voluptas facere numquam quia numquam omnis incidunt. Odit et debitis minus sit quia voluptatem perspiciatis. Et voluptas facere est.', NULL, 'Placeat exercitationem iure neque. Aliquid et velit eaque aut natus eius. Beatae quasi et ex dolorem.', 'Can Tho, 835 Tillman Avenue Suite 518', 15.41260500, 103.18505300, '2025-12-11', NULL, '3-5 hours', 'One-time', 8, 2, 16, '[\"Photography\",\"Programming\",\"Writing\",\"Marketing\"]', 'Experienced', 'Completed', '2025-11-27', 86, 47, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(101, 'org_6921e0d3aa933', 8, 'Est fugit officia dolore deleniti.', 'Tenetur et magni officia ut in illo et. Sit et sit aut est beatae rem. Et est cupiditate ea nulla. Inventore ut aut ratione quibusdam enim earum tempore.', NULL, NULL, 'Hanoi, 303 Jacobson Mountains', 18.94135100, 109.34582300, '2026-01-06', NULL, '1-2 hours', 'Flexible', 1, 4, 16, '[\"Writing\",\"Translation\",\"Cooking\",\"Teaching\"]', 'Some experience', 'Active', '2025-12-16', 143, 32, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(102, 'org_6921e0d3aa933', 4, 'Blanditiis omnis sed animi pariatur et quasi laboriosam eveniet.', 'Totam blanditiis in et nam. Eveniet sint et enim veniam et quia suscipit sequi. Nobis corrupti veniam quia nulla est. Illum atque voluptates debitis eveniet dolore possimus.', NULL, NULL, 'Hanoi, 68779 Gino Squares', 9.06899600, 104.18916400, '2025-12-10', '2025-12-28', 'Full day', 'Weekly', 4, 2, 21, '[\"Cooking\",\"First Aid\"]', 'Experienced', 'Cancelled', NULL, 308, 7, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(103, 'org_6921e0d3aa933', 3, 'Praesentium quaerat voluptatum aut ullam ut voluptas provident.', 'Et odio ducimus id voluptatem. Explicabo fuga corrupti eaque rerum. Voluptatibus eos voluptatibus deleniti ratione rem nisi perferendis consequatur. Error nam sit nulla blanditiis et sint nulla rem. Totam itaque corrupti corporis aliquam et cum. Autem minima vel quis ut sit recusandae. Culpa ex voluptatibus ducimus ut.', 'Molestiae vitae iusto autem fugit asperiores dolor. Laborum tempora quod hic. Enim consequatur quasi voluptates et architecto ipsum quae occaecati.', 'Sed repudiandae optio quia. Consequatur laboriosam voluptatem harum qui accusamus. Voluptatum labore perspiciatis et occaecati.', 'Hanoi, 462 Reilly Fields Apt. 371', 15.11472400, 109.32544300, '2026-01-20', NULL, 'Multiple days', 'Monthly', 19, 3, 16, '[\"Design\",\"Writing\",\"Translation\"]', 'No experience', 'Completed', '2025-12-31', 348, 27, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(104, 'org_6921e0d3aa933', 7, 'Blanditiis est perspiciatis soluta eos mollitia quo.', 'Molestiae sint distinctio qui autem esse qui accusamus beatae. Et sed deserunt praesentium aut unde beatae et qui. Corporis facilis quo qui fugit. Laboriosam voluptatem id assumenda accusamus modi. Sequi quam vero consequuntur. Vero voluptatem dolore amet suscipit voluptate minus aut error.', NULL, NULL, 'Hai Phong, 181 Rau Crescent Suite 543', 8.22483400, 107.63449200, '2025-12-22', '2026-02-06', 'Multiple days', 'One-time', 15, 2, 16, '[\"Photography\"]', 'Some experience', 'Active', NULL, 276, 42, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(105, 'org_6921e0d3aa933', 6, 'Fuga ut perferendis itaque praesentium eum.', 'Omnis qui voluptas accusamus minima. Incidunt fuga delectus dolor facere. Voluptatem ratione mollitia ea qui voluptate id ullam. Possimus qui optio dolor.', NULL, 'Aut error eveniet ut velit et ipsa. Consequatur et est itaque minima necessitatibus occaecati. Et optio omnis nesciunt incidunt illum.', 'Can Tho, 56073 Runte Ports', 18.74269200, 103.26821900, '2025-12-24', '2026-02-12', '6-8 hours', 'One-time', 5, 3, 21, '[\"Photography\",\"Cooking\",\"Marketing\",\"Writing\"]', 'Experienced', 'Active', NULL, 464, 25, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(106, 'org_6921e0d3aa933', 4, 'Aut omnis ut assumenda amet sed magni possimus.', 'Aspernatur libero eum excepturi est et numquam quia facilis. Fugit animi atque minus nesciunt et porro. Pariatur ut dolores nemo vero fugiat ut rerum laboriosam. Eaque quia quasi ut et iste eaque earum.', NULL, 'Sit repellat sint quis in laborum voluptate earum fuga. Atque et eos ut voluptas alias eaque asperiores. Aut et repellendus quis voluptas.', 'Ho Chi Minh City, 24419 Schneider Island Apt. 216', 14.78057700, 104.23283900, '2025-12-30', NULL, '3-5 hours', 'Flexible', 14, 1, 21, '[\"Writing\",\"First Aid\"]', 'Some experience', 'Paused', NULL, 397, 33, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(107, 'org_6921e0d3ab300', 8, 'Est natus repellat labore est deleniti pariatur enim.', 'In eaque ipsam aut nihil debitis a sequi. Ducimus porro ut quas eum aperiam. Qui rem iure facilis ad cupiditate voluptate. Ut quas est non molestias.', NULL, NULL, 'Da Nang, 51731 Violet River', 16.36088800, 103.25665600, '2026-01-04', '2026-02-02', 'Full day', 'Flexible', 10, 1, 21, '[\"Design\"]', 'No experience', 'Completed', '2025-12-27', 129, 26, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(108, 'org_6921e0d3ab300', 3, 'Sed labore quisquam accusantium sit dolorem.', 'Quia voluptas enim quo sed sint consequatur enim. Et maiores ad et ut eveniet. Quis occaecati dolorem quis consequatur omnis saepe. Quibusdam tempore sint sit recusandae. Sed consequatur blanditiis dolorum. Praesentium laudantium aspernatur doloremque quisquam ipsa.', NULL, NULL, 'Ho Chi Minh City, 7196 Harris Street', 22.99698100, 108.08929700, '2025-12-07', NULL, '6-8 hours', 'Flexible', 19, 4, 16, '[\"Cooking\",\"First Aid\",\"Design\"]', 'Experienced', 'Completed', NULL, 392, 11, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(109, 'org_6921e0d3ab300', 1, 'Nihil voluptates culpa itaque in similique autem voluptas voluptatem.', 'Atque totam inventore reiciendis non. Odit autem excepturi reprehenderit. Sit et nihil impedit. Laborum repellendus maxime velit voluptatibus consectetur. Quia aut optio ad est iure quia ut natus. Nostrum dolor impedit in voluptatibus magni debitis.', NULL, NULL, 'Hai Phong, 375 Raoul Center', 9.52023400, 108.96908800, '2025-12-16', NULL, 'Full day', 'One-time', 18, 1, 16, '[\"First Aid\",\"Cooking\",\"Design\",\"Translation\"]', 'Experienced', 'Paused', '2025-11-29', 289, 49, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(110, 'org_6921e0d3ab300', 7, 'Voluptatem unde et aspernatur non esse et consectetur.', 'Quia id est amet consectetur magni saepe ad. Quibusdam iure dolore aut sunt ut error itaque deserunt. Qui quia unde ducimus sunt hic. Eveniet quo eum accusantium et sed corrupti. Nobis voluptates eos est. Velit ratione facilis voluptatem aut ea aut est. Ab incidunt velit est autem explicabo error dicta nobis.', 'Voluptate facere eos expedita enim sed dolorem. Cupiditate delectus omnis aut. Eaque explicabo qui qui fuga debitis vel id blanditiis.', NULL, 'Hai Phong, 875 Abdul Locks', 9.89659400, 109.45825200, '2026-01-13', '2026-02-14', '6-8 hours', 'Weekly', 4, 2, 21, '[\"Programming\",\"First Aid\"]', 'No experience', 'Cancelled', '2026-01-09', 106, 16, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(111, 'org_6921e0d3ab300', 4, 'Dolores nisi sed provident velit omnis.', 'Ex at non explicabo facere accusamus minima nam ipsa. A modi eum sed quibusdam. Libero magni consectetur nesciunt illum repellendus et quisquam. Omnis odit similique quia quia labore. Vel modi reprehenderit provident provident tenetur et. Rerum impedit quae deserunt sed reprehenderit delectus. A atque accusantium laudantium saepe.', 'Soluta molestiae tempora quo sed velit ut. Laboriosam totam dolores labore iste et.', 'Expedita quasi nemo dolorem qui. Voluptatum tenetur voluptate ad voluptates aut eius. Nulla dolor optio occaecati odit excepturi nihil.', 'Can Tho, 7658 Landen Mill', 14.86899600, 108.43237900, '2025-11-30', NULL, '6-8 hours', 'Monthly', 11, 3, 18, '[\"First Aid\"]', 'No experience', 'Cancelled', NULL, 67, 36, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(112, 'org_6921e0d3abd4d', 7, 'Cum ut excepturi at totam autem numquam.', 'Dolorem magnam aperiam dolores provident tempore corporis. Voluptatibus voluptas aut a cumque facilis excepturi. Ad et et dolore aliquid sapiente. Quisquam nesciunt quis rerum dolor. Culpa molestiae iste doloremque sed est voluptatem. Temporibus voluptate commodi explicabo excepturi.', NULL, 'Nam eos aliquam dolores aut voluptas illum. Est a occaecati amet soluta et sit. Omnis sequi sit dolores dicta facere quidem autem.', 'Can Tho, 22876 Leffler Spurs', 19.07449800, 103.46589800, '2025-12-06', NULL, 'Full day', 'Flexible', 3, 4, 18, '[\"Translation\",\"Design\",\"Teaching\"]', 'No experience', 'Cancelled', '2025-12-05', 110, 12, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(113, 'org_6921e0d3abd4d', 2, 'Praesentium delectus id necessitatibus repudiandae repudiandae tenetur.', 'Occaecati quidem enim aspernatur dignissimos quasi veritatis excepturi est. Eius aliquam doloremque dicta qui harum odio qui qui. Quia quibusdam ut et aut eaque nesciunt. Laudantium quo natus ut. Quis quas eligendi ab.', 'Consequatur animi cumque corporis est. Similique corrupti quis nesciunt sed.', 'Aperiam porro voluptatibus et cum minima sed. Modi odio quia cum in facilis omnis dignissimos. A illo nam explicabo ut deserunt aut.', 'Hai Phong, 35513 Hirthe Creek', 9.38755000, 106.87360200, '2025-12-13', NULL, '1-2 hours', 'Monthly', 12, 2, 21, '[\"Translation\",\"Marketing\",\"Teaching\"]', 'Some experience', 'Active', '2025-11-26', 91, 23, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(114, 'org_6921e0d3abd4d', 7, 'Quidem sunt quas debitis facilis et.', 'Sint placeat cumque qui mollitia. Modi nemo omnis sed repudiandae. Eaque ex neque hic molestiae molestiae. Ut impedit voluptatem et minus omnis. Et magni omnis ut vel voluptate. Iste voluptas voluptatem eos ut iusto voluptas voluptates quae.', 'Qui fuga est voluptas libero aut minus. Provident nobis voluptatibus placeat recusandae molestias rem.', NULL, 'Can Tho, 961 Lulu Mountain Apt. 578', 10.44135200, 107.86630200, '2025-12-15', '2026-02-01', '6-8 hours', 'One-time', 6, 5, 21, '[\"Programming\",\"Writing\"]', 'Some experience', 'Completed', NULL, 173, 47, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(115, 'org_6921e0d3ac78d', 7, 'Totam adipisci placeat iusto sit dolore autem sint.', 'Aut non sapiente ut tempore. Quia recusandae quos sit dignissimos qui fugiat. Quo deleniti voluptatem quaerat dolorem. Totam rerum corporis dolor fuga. Aut molestias fugiat autem vitae iusto. Enim laboriosam rerum dolorem. Qui sapiente et est.', 'At vel sed numquam ad ad amet deleniti. Voluptas ut quos inventore vel magni ut minima. Consequatur quo est velit deleniti velit mollitia eius.', NULL, 'Hai Phong, 904 Johns Stravenue Suite 348', 16.38678600, 104.52544300, '2026-01-14', '2026-01-20', '1-2 hours', 'One-time', 9, 5, 21, '[\"Teaching\",\"Photography\"]', 'Some experience', 'Paused', '2025-12-25', 265, 0, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(116, 'org_6921e0d3ac78d', 1, 'Quia distinctio odio explicabo modi eos architecto perferendis.', 'Cumque quasi quos voluptatem nemo eaque non. Ea animi ut sint porro nulla aut ut. Laboriosam quas eos voluptatibus voluptatem est commodi vitae. Autem eum saepe magni sit blanditiis impedit. Aut voluptas voluptatibus nisi harum.', 'Reiciendis architecto voluptatem iste sint. Quia omnis nihil dicta et non dolorem in necessitatibus. Quia dolorem repellat sit ducimus aut.', NULL, 'Da Nang, 417 Waelchi Village', 12.48099900, 109.68864800, '2025-12-23', NULL, '3-5 hours', 'Weekly', 18, 4, 16, '[\"Design\",\"Teaching\",\"Marketing\"]', 'No experience', 'Active', '2025-12-19', 145, 19, '2025-11-22 16:12:04', '2025-11-22 16:12:04'),
(117, 'org_6921e0d3ac78d', 3, 'Sint cupiditate maiores laborum et accusantium id consectetur a.', 'Dolor natus accusantium non fuga vel explicabo dicta. Reiciendis non quis ad non in. Quod aliquid earum dicta enim sunt et atque et. Deserunt voluptate maxime eligendi quo odit sint cumque. Delectus perferendis natus maiores deserunt reiciendis. Corporis itaque qui et voluptate ducimus in quis veritatis.', NULL, 'Nam excepturi quos beatae doloribus ut iusto qui. Omnis est et quia quo.', 'Hanoi, 72827 Dicki Island Apt. 896', 18.73429800, 109.82453200, '2025-12-20', NULL, '3-5 hours', 'Flexible', 14, 5, 21, '[\"Writing\",\"Teaching\"]', 'Some experience', 'Active', '2025-12-19', 58, 13, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(118, 'org_6921e0d3ac78d', 6, 'Fugit repellat mollitia in perferendis voluptate voluptatem.', 'Laborum expedita debitis voluptatum neque explicabo. Id ipsam modi velit quod cumque voluptates ad. Assumenda quis eos nemo ab commodi quia. Accusantium fugiat officia non a necessitatibus laudantium. Perspiciatis neque et similique adipisci aut omnis eum. Ab eaque aut qui veritatis aspernatur inventore et et. Quos sint dolor neque consequatur placeat.', NULL, 'Ex ipsum ipsum voluptatum dolorem totam dolorum ex enim. Aut sequi natus repellendus sed reprehenderit praesentium tempora recusandae. Ipsam ex vel inventore dolorem.', 'Hai Phong, 13629 McClure Stravenue Apt. 453', 20.72856300, 108.44220900, '2025-12-09', '2025-12-23', 'Full day', 'Flexible', 12, 2, 16, '[\"First Aid\"]', 'Some experience', 'Cancelled', NULL, 315, 23, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(119, 'org_6921e0d3ac78d', 5, 'Expedita harum fugit quis sunt.', 'Voluptas eveniet exercitationem dolores sint eius. Facilis numquam eius ex qui maiores unde quisquam. Qui voluptatem dolores culpa odit hic corporis nulla. Magni modi est molestiae nam.', 'Et quaerat natus consectetur. Qui nesciunt maxime aliquam. Consequuntur ea dicta ut omnis.', 'Rerum est nobis fuga delectus laborum in laudantium. Enim occaecati repudiandae ut blanditiis dolores accusamus quia tempore.', 'Da Nang, 35034 Mariano Knoll', 16.47256000, 106.20966800, '2025-12-23', '2026-02-04', '3-5 hours', 'Monthly', 15, 2, 16, '[\"Photography\"]', 'No experience', 'Cancelled', NULL, 299, 10, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(120, 'org_6921e0d3ac78d', 1, 'Accusantium error et officia aut nostrum fugit distinctio.', 'Non voluptas fugit non saepe molestiae saepe dicta. Est impedit nostrum nihil rerum perferendis consequuntur. Ullam reprehenderit maiores exercitationem laudantium quae consequatur. Quam sunt commodi voluptatem illum. Quia nulla quisquam error porro. Non omnis dicta deserunt eum maiores.', 'Debitis quo qui quisquam id sequi. Rerum corporis earum iure perspiciatis nulla recusandae.', 'Velit dolorem qui veniam amet. Mollitia quisquam est minima sed.', 'Ho Chi Minh City, 7164 Grant Mountain', 18.82137200, 107.65624900, '2026-01-17', '2026-02-07', 'Multiple days', 'Monthly', 5, 1, 18, '[\"Design\",\"Translation\"]', 'Some experience', 'Completed', NULL, 338, 42, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(121, 'org_6921e0d3ac78d', 1, 'Libero illum ea quod neque quidem debitis facilis est.', 'Et temporibus eum et quia quod atque. Sit dolore esse sint ut magni. Est et aliquid nam velit. Illum debitis nemo ut officiis. Enim soluta perspiciatis alias voluptates. Iusto corrupti enim tempora voluptas voluptates.', NULL, 'Sit molestiae animi dicta cum. Quam placeat minus autem eius eius. Maiores et sequi voluptates in molestias est.', 'Hai Phong, 12535 Torp Camp Apt. 697', 22.50852200, 102.61568500, '2026-01-09', NULL, 'Multiple days', 'Weekly', 18, 3, 16, '[\"Programming\",\"Cooking\",\"First Aid\"]', 'No experience', 'Completed', NULL, 402, 19, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(122, 'org_6921e0d3ad224', 2, 'Consectetur fugiat unde autem.', 'Sit ut eum quia eum. Tempore commodi esse quis maiores deleniti tenetur ut. Vitae ex est qui aut. Quas facilis et eligendi facilis et aut in sint. Repellat porro accusantium sint quia.', NULL, NULL, 'Ho Chi Minh City, 978 Hessel Summit', 17.90897100, 104.52328300, '2025-12-06', NULL, '6-8 hours', 'Flexible', 7, 1, 18, '[\"Design\"]', 'Experienced', 'Completed', '2025-11-30', 271, 36, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(123, 'org_6921e0d3ad224', 1, 'Accusantium consectetur dignissimos quia dolorem.', 'Aliquam nisi omnis adipisci iusto. Quia eaque vel saepe esse numquam voluptates. At velit sed odio neque tempora. Natus ab accusamus quia molestias aut eum. Quia ut sunt similique et.', 'Quidem aspernatur atque exercitationem omnis. Consequatur quaerat ut voluptas nobis veritatis. Saepe rerum consequatur quam itaque.', NULL, 'Can Tho, 93958 Remington Views Apt. 936', 10.55352900, 108.74652900, '2025-12-11', NULL, '6-8 hours', 'Weekly', 10, 2, 16, '[\"Marketing\"]', 'Experienced', 'Active', NULL, 347, 21, '2025-11-22 16:12:05', '2025-11-26 14:48:31'),
(124, 'org_6921e0d3ad224', 5, 'Sunt natus et necessitatibus culpa quas dolores enim.', 'Laboriosam cumque eos non ea dolorem. Libero dolorem optio accusamus temporibus molestiae rerum distinctio. Quam impedit ut ad et. Et laborum et et voluptatem. Voluptatem debitis sit doloremque est eaque. Rerum eum sed distinctio voluptatem. Est numquam ratione et corrupti fugit accusamus sunt. Animi debitis quo dolores consequuntur.', 'Excepturi autem accusantium enim. Facere dolores libero et deserunt. Aperiam a voluptates dolorem dolores et quos.', NULL, 'Hai Phong, 22125 Mac Trace', 17.73393100, 109.94684200, '2026-01-01', NULL, '6-8 hours', 'One-time', 10, 4, 16, '[\"Design\"]', 'No experience', 'Cancelled', NULL, 262, 33, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(125, 'org_6921e0d3ad224', 1, 'Sint adipisci sint quos iure omnis.', 'Eligendi recusandae reiciendis velit. Velit qui quasi facere voluptatum enim. Velit nulla iusto provident minima. Eos delectus itaque voluptatem dolor explicabo laborum. Quis error natus dignissimos maiores voluptatem voluptatem eum. Maiores dolorem quis iure molestiae.', NULL, 'Harum distinctio adipisci aspernatur rerum ad. Quo alias repudiandae et id natus enim quibusdam. Sunt dolorum magnam dolorem esse ipsum alias.', 'Hanoi, 202 Labadie Village', 14.01159800, 103.12960100, '2025-12-29', NULL, '6-8 hours', 'Monthly', 3, 0, 21, '[\"Programming\",\"Writing\",\"First Aid\",\"Design\"]', 'Some experience', 'Active', NULL, 499, 24, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(126, 'org_6921e0d3ad224', 4, 'Dolores et doloribus dicta et.', 'Nostrum et distinctio voluptate et necessitatibus omnis et et. Corporis quas dolores explicabo nihil nam. Accusantium eveniet dolore inventore vitae culpa sint. Qui explicabo consequatur rem et minus est. Quaerat et consequatur fugit adipisci in quidem. Minus laudantium qui nam ex aut ea.', 'Quo et ad quam et ipsa eum laborum non. Voluptatum impedit et iste dicta dolores eum ut ea.', 'Doloribus placeat enim ut ab. Vero esse et pariatur asperiores ex eveniet debitis ipsum. Enim ullam ut autem et debitis eos rerum.', 'Hanoi, 602 Kaycee Vista', 17.17912300, 104.80025800, '2026-01-16', NULL, '6-8 hours', 'Weekly', 17, 5, 16, '[\"Translation\",\"Marketing\",\"Photography\"]', 'Experienced', 'Completed', NULL, 280, 11, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(127, 'org_6921e0d3ad224', 7, 'Id eos error ut.', 'Ut dolores aut deleniti voluptas dolorum magnam. Dolorem tempore omnis veritatis cumque officiis doloribus. Maxime consequatur dolor aspernatur praesentium consequuntur voluptas beatae. In ipsum placeat est nulla impedit. Dolorem dolorum ullam quos exercitationem fugit quasi eaque blanditiis.', NULL, NULL, 'Hanoi, 24892 Kamren Cliff', 20.26951100, 104.41288100, '2025-12-31', NULL, 'Multiple days', 'One-time', 1, 1, 21, '[\"Teaching\",\"Translation\",\"Photography\",\"Writing\"]', 'No experience', 'Paused', NULL, 409, 22, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(128, 'org_6921e0d3ad224', 5, 'Quis quas eos praesentium qui dolorem doloribus placeat.', 'Maxime aliquid ut rerum sit. Iste debitis omnis voluptatem tempora aut. Et deserunt velit sapiente quaerat. Exercitationem voluptatum asperiores nihil neque excepturi temporibus voluptate. Dolores omnis minus et assumenda qui explicabo. Distinctio eveniet voluptatem dolor.', NULL, 'Sit velit reiciendis qui sunt necessitatibus eligendi. Pariatur voluptas natus id dicta. Omnis quod quasi dolorem cum rerum aliquam aliquid aliquam.', 'Hanoi, 3650 Schimmel Harbor Suite 220', 13.30451300, 103.15993900, '2025-12-07', NULL, '1-2 hours', 'One-time', 12, 4, 18, '[\"Teaching\"]', 'Experienced', 'Completed', '2025-11-28', 292, 30, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(129, 'org_6921e0d3ad224', 6, 'Necessitatibus laborum voluptas autem provident.', 'Inventore quia quibusdam itaque provident aut corrupti sequi. Esse fugit minima molestiae cumque. Porro et quia sunt expedita sit. Qui expedita et omnis vel enim. Id non laboriosam qui rerum cumque. Velit qui qui necessitatibus pariatur sint est. Ea est consectetur est ut sunt.', 'Officia sit omnis et magnam aut alias qui corporis. Quas a quia eos earum quia quis.', 'Molestiae est nulla et sequi molestiae. Aut amet quis doloribus dolore autem dolor quia. Et molestiae aut assumenda quia.', 'Ho Chi Minh City, 54910 Sigrid Island', 11.85804800, 109.70776000, '2025-12-13', NULL, '1-2 hours', 'Flexible', 14, 4, 21, '[\"Photography\",\"Design\",\"Marketing\"]', 'No experience', 'Paused', NULL, 315, 46, '2025-11-22 16:12:05', '2025-11-22 16:12:05'),
(130, 'org_6921e0e0c920a', 9, 'Et voluptatum officia ratione numquam nam reiciendis.', 'Doloremque molestias tempore omnis qui dolor quia ut. Ducimus sit doloremque aut autem aut est aut. Qui adipisci in saepe et est. Facere non omnis quis voluptatem vero facere maiores sed. Et tempore expedita dolor eos. Aliquid voluptas dolores voluptas excepturi dolore et eligendi. Necessitatibus quod est dolorem commodi est non.', 'Dolor natus quisquam numquam possimus. Consequatur eius omnis temporibus tempore. Rerum eos aliquid aut alias dolores.', 'Porro velit dignissimos quos ut. Blanditiis similique excepturi eligendi illum architecto aliquid. Recusandae reprehenderit ad reprehenderit ut consequatur.', 'Ho Chi Minh City, 1946 Marcia Prairie Suite 403', 15.34153700, 104.11412300, '2025-12-11', NULL, '3-5 hours', 'Flexible', 8, 5, 16, '[\"Design\",\"Translation\"]', 'Experienced', 'Paused', NULL, 16, 35, '2025-11-22 16:12:16', '2025-11-22 16:12:16'),
(131, 'org_6921e0e81406d', 10, 'Unde odit veritatis recusandae occaecati.', 'Deleniti vel adipisci fugiat quisquam quia voluptatem eos. Quia aliquam nemo nihil labore. Accusamus voluptates tenetur voluptatibus ratione et et. Voluptas pariatur saepe non unde. Animi non ratione voluptate facere rerum. Quia quo ut accusantium et.', NULL, NULL, 'Hai Phong, 73251 Welch Estate Suite 365', 16.60380600, 102.78783000, '2025-12-22', '2026-01-30', 'Multiple days', 'Weekly', 1, 1, 18, '[\"Translation\",\"Programming\",\"Photography\"]', 'Some experience', 'Paused', '2025-12-13', 227, 22, '2025-11-22 16:12:24', '2025-11-22 16:12:24'),
(132, 'org_6921e0ec1ba5d', 11, 'Rerum qui ut molestiae commodi est aut quo excepturi.', 'Quod officiis praesentium illo maiores et. Ratione qui praesentium dolorem eaque error. Aliquid dolorem quod ipsam mollitia repudiandae. Dolor est at omnis. Quaerat sint dolorem ut distinctio molestiae blanditiis inventore error. Ut id et laboriosam quidem occaecati beatae facilis. Fugit tempora eveniet facere.', NULL, NULL, 'Hanoi, 601 Nora Ranch Apt. 918', 10.00003500, 105.06849600, '2026-01-16', NULL, 'Full day', 'Flexible', 10, 3, 16, '[\"Photography\",\"Marketing\"]', 'No experience', 'Cancelled', NULL, 481, 24, '2025-11-22 16:12:28', '2025-11-22 16:12:28'),
(133, 'org_6921e0f04e677', 12, 'Pariatur velit illo voluptas harum quasi numquam aut.', 'Explicabo ut temporibus officia accusamus eos adipisci. Aliquam molestiae tenetur et nostrum velit enim sequi et. Reprehenderit distinctio quas facilis assumenda consectetur. Sapiente tenetur temporibus est deleniti. Ipsam dolorem sed nihil est officia. Numquam doloribus velit aliquam porro et.', 'Facilis vitae qui magnam commodi sed. Iusto ut et nihil et numquam. Aut suscipit quia suscipit et et enim.', NULL, 'Ho Chi Minh City, 95889 Scotty Village', 22.38612300, 109.57865100, '2026-01-12', NULL, '3-5 hours', 'One-time', 14, 1, 18, '[\"Translation\",\"Writing\",\"Teaching\"]', 'Experienced', 'Completed', '2026-01-12', 212, 25, '2025-11-22 16:12:32', '2025-11-22 16:12:32'),
(134, 'org_6921e0f2e6b7b', 13, 'Ut accusamus ut id est rerum sed.', 'Libero labore officiis voluptate dignissimos facilis. Excepturi ducimus officia consequatur quia. Ipsum corporis maiores quis ut accusamus dolores assumenda. Rerum aliquam ex non officia dolorem labore. Accusamus voluptas quaerat tempora et non optio qui. Quo possimus in fuga dolores voluptas.', 'Illo magni illum et ullam omnis culpa molestiae laudantium. Sint cumque est dolor praesentium est voluptatem voluptatum.', 'Consequatur ut sequi qui earum ullam. Necessitatibus aut optio voluptatum excepturi. Qui consequatur laborum autem rerum molestiae repellendus qui.', 'Da Nang, 866 Lind Expressway', 14.34605600, 106.22959300, '2025-12-30', NULL, '1-2 hours', 'Flexible', 12, 1, 18, '[\"Photography\"]', 'No experience', 'Paused', NULL, 255, 42, '2025-11-22 16:12:34', '2025-11-22 16:12:34'),
(135, 'org_6921e0f725d90', 14, 'Illo doloribus maxime velit eaque commodi.', 'Debitis ut aut et consequatur quibusdam. Sed et libero tenetur id. Dolores magnam vero sequi deserunt sed modi. Quibusdam iste dolores ut eos id qui eos. Dolorem exercitationem aliquid perspiciatis provident.', NULL, NULL, 'Ho Chi Minh City, 473 Madison Terrace Suite 024', 21.95156500, 102.14489100, '2025-12-23', '2026-01-16', '1-2 hours', 'Flexible', 13, 4, 21, '[\"Design\",\"Marketing\",\"First Aid\"]', 'Experienced', 'Paused', NULL, 471, 28, '2025-11-22 16:12:39', '2025-11-22 16:12:39'),
(136, 'org_6921e0fea5da5', 15, 'Est omnis quaerat quia culpa.', 'Id dolorem maxime molestiae similique at cum voluptas. In officia nihil quis voluptatem. Dolorem ea ipsam animi quo dolorem modi ut et. Culpa voluptatem dolores voluptate doloremque rem quae. Eaque voluptatem ipsam id possimus. Repellendus ullam commodi voluptatum deserunt aliquam quis aliquid.', 'Praesentium quas cum dolor illo libero. Minus reprehenderit quia et. Quibusdam eligendi a sunt exercitationem.', NULL, 'Hai Phong, 849 Quinten Meadows', 9.31033600, 102.25261300, '2026-01-09', '2026-02-09', '1-2 hours', 'Weekly', 15, 3, 21, '[\"Photography\",\"Writing\",\"Programming\"]', 'No experience', 'Completed', NULL, 146, 2, '2025-11-22 16:12:46', '2025-11-22 16:12:46'),
(137, 'org_6921e100bd79f', 16, 'Tempora iure veritatis minima aut dolorum nisi possimus.', 'Quam nihil voluptatem corporis voluptatibus. Reprehenderit voluptas voluptates ab quis. Sed ut est aut veniam odit sequi quae. Itaque consequatur vero dolore quis dolorum.', 'Aut dolor consequatur debitis eos. Et aut vel quo ab amet. Molestias tenetur suscipit quae totam deserunt expedita.', NULL, 'Da Nang, 10252 Harber Underpass Apt. 812', 10.54869600, 102.98942200, '2025-12-12', '2026-02-19', 'Full day', 'Monthly', 18, 5, 18, '[\"Marketing\"]', 'Some experience', 'Paused', NULL, 395, 0, '2025-11-22 16:12:48', '2025-11-22 16:12:48'),
(138, 'org_6921e106525a2', 17, 'Ipsam voluptas voluptas possimus.', 'Nemo dolore et esse ut. Quia voluptas a non voluptas vero quia. Amet veritatis velit at dolores porro modi consequatur. Unde dolorem nihil recusandae dolorem. Sunt quia saepe rem corrupti voluptatibus veniam inventore.', 'Odit ut incidunt aut nihil eaque aut sapiente. Aut reiciendis rerum id quaerat qui.', NULL, 'Can Tho, 385 Adaline Orchard', 22.53558700, 104.41807400, '2026-01-03', '2026-01-29', '3-5 hours', 'Monthly', 3, 4, 21, '[\"Cooking\",\"First Aid\",\"Design\"]', 'No experience', 'Completed', NULL, 75, 23, '2025-11-22 16:12:54', '2025-11-22 16:12:54'),
(139, 'org_6921e0732472a', 5, 'Hoa Sơn Quý', 'Hoa Sơn Quý', NULL, NULL, 'Đống Đa, Hà Nội', NULL, NULL, '2025-11-24', '2025-12-05', 'Full day', 'Weekly', 99, 0, 16, '\"English, Cooking, Counseling, First Aid, IT Support, Photography\"', 'Some experience', 'Active', '2025-12-03', 20, 0, '2025-11-23 15:06:57', '2025-11-27 08:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_profiles`
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
-- Dumping data for table `volunteer_profiles`
--

INSERT INTO `volunteer_profiles` (`profile_id`, `user_id`, `occupation`, `education_level`, `university`, `bio`, `skills`, `interests`, `availability`, `volunteer_experience`, `total_volunteer_hours`, `volunteer_rating`, `preferred_location`, `transportation`, `created_at`, `updated_at`) VALUES
(1, 4, NULL, 'Bachelor', ' University', NULL, '[\"Photography\",\"Sports\",\"Counseling\",\"Teaching\",\"Marketing\"]', 'Facilis necessitatibus dolores excepturi.', 'Full-time', 'Reprehenderit delectus nam vel ea magni. Rerum natus quis et placeat nemo consequatur.', 18, 2.25, 'Da Nang', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(2, 5, 'Marriage and Family Therapist', 'High School', ' University', NULL, '[\"Programming\",\"Cooking\",\"Teaching\",\"First Aid\",\"Music\",\"Gardening\"]', 'Tenetur laborum rerum qui similique rerum asperiores.', 'Flexible', NULL, 308, 1.33, 'Any', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(3, 6, 'Carver', 'Master', ' University', 'Quisquam hic possimus hic sapiente quis sit. Quis sit ratione amet consectetur voluptate totam debitis. Porro blanditiis in aliquam blanditiis voluptatem et modi deleniti. Aut in omnis nulla ut tenetur laboriosam.', '[\"Photography\",\"Counseling\",\"Teaching\"]', 'Quia consequatur vero debitis autem iste consequuntur.', 'Weekends', 'Laboriosam et doloribus fugit omnis dolorem id autem. Voluptatem vitae voluptatem alias et error eos error.', 340, 1.44, 'Da Nang', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(4, 7, 'Industrial Machinery Mechanic', 'Diploma', ' University', 'Minus quidem itaque tempore earum a libero. Rem et voluptate sed tempore sunt officiis facilis. Ut magni beatae natus maxime.', '[\"Programming\",\"Marketing\",\"First Aid\",\"Sports\",\"Photography\",\"Counseling\"]', NULL, 'Full-time', 'Qui saepe eius at minus dolores est consequatur exercitationem. Amet iste deserunt aliquid quis ab omnis non.', 257, 0.80, 'Hanoi', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(5, 8, 'Cartographer', 'Bachelor', ' University', NULL, '[\"Photography\",\"Music\"]', NULL, 'Full-time', NULL, 228, 4.95, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(6, 9, NULL, 'Bachelor', ' University', NULL, '[\"Programming\",\"Teaching\",\"Sports\",\"Cooking\",\"Writing\"]', NULL, 'Flexible', 'Minima ratione temporibus facilis dolore in maxime minima incidunt. Ut incidunt rem est ducimus velit rerum veritatis.', 271, 4.35, 'Any', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(7, 10, NULL, 'High School', 'Russel Ltd University', 'Quo non autem quisquam nobis reiciendis. Ab doloremque reiciendis ut voluptate quo rem autem. Dicta dolorem explicabo voluptatem quisquam. Aut placeat earum optio illum facilis est voluptatem.', '[\"Cooking\",\"Sports\",\"Photography\",\"Teaching\",\"Programming\"]', NULL, 'Weekends', NULL, 325, 0.97, 'Any', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(8, 11, NULL, 'Master', 'Stark Inc University', 'Laudantium est deleniti autem vel numquam alias omnis. Consequatur earum et accusantium assumenda dolorem nemo sed molestias. Atque debitis laudantium iusto ipsa nisi aut cupiditate. Ab provident adipisci voluptates ut.', '[\"Photography\",\"Translation\"]', NULL, 'Weekends', NULL, 477, 3.08, 'Any', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(9, 12, NULL, 'PhD', 'Bogisich LLC University', 'Quibusdam facere enim voluptatem dolor blanditiis. Iusto natus corrupti sint unde.', '[\"Music\",\"Design\",\"Translation\"]', NULL, 'Full-time', 'Nemo sed omnis officia porro non vel sit animi. Eligendi sed minima rerum sequi hic et maiores earum.', 442, 4.42, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(10, 13, 'Cashier', 'Diploma', ' University', 'Aperiam molestias quis sit fugit animi. Eos labore veniam autem dolores. Ut voluptates omnis velit molestiae voluptas quaerat nihil. Facere sed ab exercitationem eveniet ratione.', '[\"Programming\",\"Teaching\",\"Music\",\"Marketing\",\"Sports\",\"Design\"]', NULL, 'Flexible', 'Qui quae molestiae ab suscipit. Impedit harum beatae assumenda nulla alias aliquam totam.', 344, 2.75, 'Ho Chi Minh', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(11, 14, NULL, 'Diploma', ' University', NULL, '[\"Photography\",\"Counseling\",\"Design\",\"Translation\",\"Sports\",\"Teaching\"]', 'Magni eos quam animi in distinctio quam aliquid.', 'Weekends', 'Omnis possimus cumque similique quas dicta et et consequuntur. Placeat quasi tempora neque.', 327, 0.23, 'Any', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(12, 15, NULL, 'Bachelor', ' University', 'Quam quia enim enim ut cum. Laudantium eum doloribus expedita. Nostrum et ea enim debitis. Illum dicta veritatis soluta adipisci.', '[\"Cooking\",\"Music\",\"Design\"]', NULL, 'Full-time', 'Sint similique itaque dicta quas. Molestiae neque vel tenetur omnis.', 144, 4.08, 'Any', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(13, 16, NULL, 'Diploma', 'Yundt-Kuphal University', 'Voluptates est minus dolorem tempora. Alias ut omnis nesciunt earum.', '[\"Programming\",\"Design\",\"Gardening\",\"Counseling\",\"Cooking\"]', 'Eius eaque ea ea aut.', 'Full-time', 'Quaerat nemo qui et eligendi rem voluptatem. Sed sunt et quos quos eos voluptates.', 439, 4.81, 'Any', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(14, 17, 'Media and Communication Worker', 'Bachelor', 'Olson and Sons University', 'Et doloremque quas magni sed. Laboriosam et sint iusto omnis id molestias. Aut nihil voluptas exercitationem ut aliquam deserunt hic. Molestiae quidem quia ea cupiditate.', '[\"Sports\",\"Data Entry\",\"Teaching\"]', 'Qui porro iure odit cum ut excepturi sint rerum.', 'Full-time', 'Repellendus dignissimos ea ut sed. Assumenda non aperiam quo quos.', 317, 0.20, 'Da Nang', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(15, 18, NULL, 'Diploma', 'Morar and Sons University', 'Et et deleniti vel iste iure corrupti suscipit. Excepturi dolorem et porro velit vel est totam.', '[\"Photography\",\"First Aid\",\"Programming\",\"Writing\",\"Data Entry\"]', NULL, 'Weekends', NULL, 252, 1.92, 'Da Nang', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(16, 19, NULL, 'PhD', ' University', 'Animi veritatis veritatis consequuntur placeat a ad. Aliquid voluptas saepe vitae sit eos. Consectetur aut aliquid molestiae ipsum veniam consequatur.', '[\"Programming\",\"Design\",\"Marketing\",\"Sports\"]', NULL, 'Weekends', 'Qui nulla quis assumenda voluptas. Placeat natus temporibus harum cupiditate.', 33, 1.24, 'Ho Chi Minh', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(17, 20, NULL, 'Master', 'Crooks-Balistreri University', NULL, '[\"Design\",\"Photography\",\"Marketing\",\"Programming\",\"Sports\",\"Music\"]', NULL, 'Full-time', 'Dolorum temporibus explicabo maxime. Ipsum voluptatem et unde cupiditate. Eos totam non voluptatum delectus.', 167, 0.74, 'Any', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(18, 21, 'Aircraft Assembler', 'Diploma', ' University', 'Adipisci sint veniam ut a nam et ut. Voluptas distinctio odio nihil. Doloribus eligendi laboriosam non est et dolores saepe maxime. Voluptates aliquid blanditiis quibusdam est iure officia modi.', '[\"Cooking\",\"First Aid\",\"Photography\",\"Marketing\",\"Sports\",\"Translation\"]', 'Dolor minus facere voluptas neque numquam minus laboriosam.', 'Weekends', NULL, 369, 3.34, 'Ho Chi Minh', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(19, 22, NULL, 'High School', ' University', 'Quaerat laudantium adipisci optio aut facere. Sint quia cupiditate non ut commodi. Voluptas illo repellendus ipsa molestiae aliquam.', '[\"Data Entry\",\"Programming\",\"Sports\",\"Gardening\",\"Cooking\"]', NULL, 'Full-time', 'Unde ducimus in consequatur perferendis omnis molestiae. Dolores veniam animi veniam et. Recusandae qui fuga odio autem.', 410, 2.90, 'Any', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(20, 23, 'Tile Setter OR Marble Setter', 'High School', ' University', NULL, '[\"Sports\",\"Teaching\",\"Translation\",\"Writing\",\"Design\",\"Programming\"]', 'Doloremque officiis facere facere consequatur non.', 'Weekdays', NULL, 113, 1.77, 'Any', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(21, 24, NULL, 'Bachelor', 'Tremblay Inc University', NULL, '[\"Teaching\",\"First Aid\",\"Gardening\",\"Sports\",\"Marketing\",\"Cooking\"]', 'Qui corporis vel voluptas a laborum.', 'Flexible', NULL, 27, 3.26, 'Da Nang', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(22, 25, NULL, 'High School', 'Sporer, Lesch and Johnson University', NULL, '[\"Sports\",\"Cooking\",\"Data Entry\",\"Translation\",\"Marketing\",\"Programming\"]', 'Porro suscipit ipsum commodi nam.', 'Full-time', 'Consequatur non reiciendis dolorum. Sunt veritatis qui deserunt. Quae quibusdam voluptatum qui vitae quia.', 8, 0.31, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(23, 26, NULL, 'Diploma', ' University', 'Voluptates numquam veniam dolore voluptatem aut sunt. Illum eum sapiente cumque iste. Eaque rerum necessitatibus et non dolore dolore perferendis.', '[\"Design\",\"Teaching\",\"Writing\",\"Photography\",\"Marketing\",\"Cooking\"]', 'Sed officiis ut ipsa labore perspiciatis repellat.', 'Full-time', 'Possimus enim molestiae quos impedit recusandae assumenda. Enim quia nihil et voluptatem.', 7, 0.28, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(24, 27, NULL, 'Bachelor', 'Bechtelar, Heller and King University', NULL, '[\"Teaching\",\"Translation\"]', 'Exercitationem dolores voluptatem commodi maiores officia.', 'Flexible', NULL, 448, 1.65, 'Da Nang', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(25, 28, 'Production Helper', 'PhD', 'Armstrong-Blick University', 'Sit animi dicta consequatur qui dignissimos. Harum rem rerum veritatis aliquam sed voluptates consequuntur. Debitis minus ipsa dolorem possimus non itaque quas. Est numquam mollitia doloribus quisquam.', '[\"First Aid\",\"Teaching\",\"Marketing\",\"Counseling\",\"Cooking\"]', NULL, 'Weekends', NULL, 367, 2.00, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-27 10:27:55'),
(26, 29, NULL, 'High School', 'Pagac Ltd University', NULL, '[\"Photography\",\"Programming\",\"Counseling\",\"Design\"]', NULL, 'Weekdays', 'Sequi voluptates quisquam omnis aliquid et tenetur. Dignissimos maxime totam voluptatem quisquam consequatur eum qui. Amet et suscipit tempora repellat et est quia maxime.', 451, 1.05, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(27, 30, 'Home Appliance Installer', 'Bachelor', 'Abbott, Stamm and Runolfsson University', NULL, '[\"Music\",\"Sports\"]', 'Eum harum eum debitis voluptatem est.', 'Weekends', NULL, 253, 2.45, 'Hanoi', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(28, 31, 'Pile-Driver Operator', 'Bachelor', 'Mertz Group University', NULL, '[\"First Aid\",\"Teaching\"]', NULL, 'Weekdays', 'Quia quis minus aut fugit voluptatem veritatis. Sunt qui ea repudiandae laborum laboriosam. Ab rerum possimus fugiat fugit tenetur quis officiis saepe.', 43, 3.82, 'Any', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(29, 32, 'Industrial Engineer', 'PhD', ' University', 'Qui nisi eos consequatur est perferendis illo. Assumenda excepturi laborum quia ducimus repellendus ad. Fuga et cupiditate repellat amet dolore cumque omnis. Doloribus ut perspiciatis soluta itaque. Minus facere quo dolore ea et ut.', '[\"Sports\",\"Data Entry\",\"Photography\",\"Music\"]', 'Est nam et temporibus et.', 'Flexible', NULL, 64, 0.80, 'Da Nang', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(30, 33, 'CSI', 'Master', ' University', NULL, '[\"Programming\",\"Design\",\"Counseling\",\"Marketing\"]', 'Quas voluptatem et et nisi.', 'Full-time', NULL, 343, 0.44, 'Ho Chi Minh', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(31, 34, NULL, 'Master', 'Huel and Sons University', NULL, '[\"Marketing\",\"Writing\",\"Counseling\",\"Music\"]', NULL, 'Weekends', NULL, 390, 1.73, 'Any', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(32, 35, NULL, 'PhD', 'Collins Ltd University', 'Et sunt ut autem. Ut ut recusandae necessitatibus aut. Laudantium atque ipsam aut et et.', '[\"Cooking\",\"Counseling\"]', NULL, 'Weekdays', 'Dolor eveniet et quo laboriosam et. Reiciendis odit placeat beatae ut. Qui illo quibusdam at labore.', 79, 4.76, 'Hanoi', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(33, 36, NULL, 'Bachelor', ' University', NULL, '[\"Sports\",\"Data Entry\",\"Music\",\"First Aid\"]', 'Aut aut suscipit corporis qui blanditiis ipsum et.', 'Full-time', 'Quas aliquam dolor officiis debitis sit distinctio illo architecto. Asperiores odio labore praesentium commodi vel. Ea sed voluptatem nam.', 117, 4.58, 'Any', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(34, 37, 'Gas Pumping Station Operator', 'PhD', ' University', NULL, '[\"Writing\",\"Marketing\",\"Teaching\",\"Music\",\"Photography\",\"Cooking\"]', 'Et quos non neque totam et.', 'Full-time', 'Rerum ea aliquam dolor et ex. Consequatur debitis animi consequuntur sint expedita omnis.', 163, 1.64, 'Ho Chi Minh', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(35, 38, NULL, 'Bachelor', ' University', 'Rerum et itaque mollitia similique et. Beatae quo recusandae in fugit. Ad itaque non soluta quos consectetur deserunt. Sequi officia aut nemo necessitatibus omnis autem consequatur.', '[\"Data Entry\",\"Cooking\"]', NULL, 'Flexible', 'Non pariatur et nam aut alias dicta nihil animi. Rerum pariatur soluta laudantium optio.', 55, 0.37, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(36, 39, 'Home Appliance Installer', 'Diploma', ' University', NULL, '[\"Music\",\"Marketing\",\"Data Entry\"]', 'Quis eum laudantium culpa delectus debitis.', 'Weekends', 'Occaecati sed aliquam ex veniam. Ut ducimus ipsum itaque corporis quia. Voluptatem iusto rerum ipsa adipisci perspiciatis.', 133, 1.37, 'Da Nang', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(37, 40, NULL, 'Diploma', 'Bauch, Kerluke and Rath University', NULL, '[\"Data Entry\",\"Marketing\",\"First Aid\"]', NULL, 'Weekdays', NULL, 294, 1.08, 'Any', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(38, 41, 'Motorboat Operator', 'High School', 'Hansen-Bahringer University', NULL, '[\"Translation\",\"Photography\",\"Sports\",\"Cooking\",\"Music\",\"Marketing\"]', NULL, 'Weekdays', 'Voluptas modi rem itaque. Voluptates neque eaque enim id alias at perspiciatis. Consectetur asperiores rerum aut dolor et reprehenderit.', 235, 2.91, 'Hanoi', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(39, 42, NULL, 'Diploma', 'Bruen Ltd University', 'Praesentium sit provident accusamus totam alias eum consequatur. Occaecati sint magnam quia sed delectus neque. Rem a consequatur dolores exercitationem nihil. Architecto ab ducimus omnis voluptatem.', '[\"First Aid\",\"Marketing\"]', NULL, 'Flexible', 'Sequi quis placeat aut voluptatibus quas vel quisquam. Reiciendis eos voluptas dolorum. Quia vel quibusdam et.', 262, 4.50, 'Hanoi', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(40, 43, NULL, 'PhD', 'O\'Kon, Ward and Fadel University', 'Aut quo non aut excepturi nam. Repellendus in aut quia commodi. Non delectus consequatur deleniti ut amet nihil temporibus molestiae.', '[\"Photography\",\"Sports\",\"Gardening\",\"Design\",\"Writing\",\"First Aid\"]', NULL, 'Weekdays', NULL, 63, 1.70, 'Any', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(41, 44, 'Rotary Drill Operator', 'High School', ' University', 'Repudiandae amet ut sapiente et. A cupiditate dolore quia saepe ut mollitia ut.', '[\"Sports\",\"First Aid\",\"Programming\",\"Music\"]', NULL, 'Weekends', NULL, 464, 2.08, 'Hanoi', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(42, 45, NULL, 'Diploma', 'Feil-DuBuque University', 'Consequatur quis corrupti officia. Facilis et non tenetur totam animi sed libero. Eum deserunt delectus occaecati similique voluptatem distinctio autem.', '[\"Translation\",\"Programming\",\"Counseling\"]', NULL, 'Weekends', 'Maiores qui eligendi necessitatibus omnis dolorem. Quis aut et eligendi voluptatibus sed. Iure autem perferendis voluptas vitae qui.', 400, 4.22, 'Hanoi', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(43, 46, 'Avionics Technician', 'Master', 'Wolf-Bashirian University', NULL, '[\"Design\",\"Marketing\"]', NULL, 'Weekdays', NULL, 168, 3.39, 'Da Nang', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(44, 47, 'Agricultural Inspector', 'High School', ' University', NULL, '[\"Design\",\"First Aid\",\"Translation\",\"Writing\",\"Cooking\",\"Programming\"]', 'Magnam quasi beatae nam.', 'Weekdays', NULL, 349, 1.64, 'Ho Chi Minh', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(45, 48, NULL, 'Diploma', ' University', NULL, '[\"Programming\",\"Teaching\"]', 'Quo qui molestias officiis earum atque at eos.', 'Flexible', NULL, 209, 2.85, 'Ho Chi Minh', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(46, 49, NULL, 'High School', 'Welch PLC University', NULL, '[\"Data Entry\",\"Sports\"]', 'Ab quisquam provident iste alias.', 'Flexible', NULL, 271, 3.70, 'Hanoi', 'Motorbike', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(47, 50, NULL, 'Bachelor', 'Kub, Beatty and Veum University', 'Recusandae non est ipsa consectetur dicta. Numquam eaque nam sed alias maiores porro. Voluptate voluptas enim sequi nihil aliquid quia.', '[\"Photography\",\"Writing\"]', NULL, 'Full-time', 'Laboriosam non quisquam neque. Nulla aut qui voluptatum officia. Ullam soluta saepe praesentium non saepe est beatae.', 428, 2.06, 'Ho Chi Minh', 'Car', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(48, 51, 'Ship Pilot', 'PhD', ' University', NULL, '[\"Music\",\"Data Entry\",\"Cooking\",\"First Aid\",\"Marketing\",\"Photography\"]', NULL, 'Weekdays', NULL, 151, 4.10, 'Any', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(49, 52, 'Chemical Technician', 'Bachelor', ' University', 'Nesciunt fugiat et est est quod laudantium minima impedit. Magni mollitia quibusdam facere in ab voluptatem ipsam. Ut quo optio voluptatem numquam.', '[\"Design\",\"Photography\",\"First Aid\",\"Writing\",\"Programming\"]', NULL, 'Weekends', NULL, 92, 1.60, 'Hanoi', 'Public Transport', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(50, 53, 'Bench Jeweler', 'Master', ' University', 'Minus perspiciatis aperiam voluptas voluptates. Dolore assumenda quasi dicta amet facilis vitae.', '[\"Teaching\",\"Music\",\"Counseling\",\"Data Entry\"]', 'Enim eveniet ut quaerat magnam.', 'Weekdays', 'Eius numquam quia voluptates eius a. Et hic tenetur maxime molestiae quo.', 148, 1.91, 'Ho Chi Minh', 'Walking', '2025-11-22 16:11:59', '2025-11-22 16:11:59'),
(51, 362, 'Suc vat', 'High School', NULL, 'hoa son quy', '\"hoa son quy\"', 'hoa son quy', NULL, NULL, 0, 0.00, NULL, NULL, '2025-11-23 16:12:03', '2025-11-23 16:12:27'),
(52, 363, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0.00, NULL, NULL, '2025-11-23 16:31:50', '2025-11-23 16:31:50'),
(53, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 3.00, NULL, NULL, '2025-11-24 04:31:38', '2025-11-27 10:27:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
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
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `categories_category_name_unique` (`category_name`);

--
-- Indexes for table `connections`
--
ALTER TABLE `connections`
  ADD PRIMARY KEY (`connection_id`),
  ADD UNIQUE KEY `unique_connection` (`user_id`,`friend_id`),
  ADD KEY `connections_action_user_id_foreign` (`action_user_id`),
  ADD KEY `connections_user_id_status_index` (`user_id`,`status`),
  ADD KEY `connections_friend_id_status_index` (`friend_id`,`status`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`conversation_id`),
  ADD KEY `conversations_opportunity_id_foreign` (`opportunity_id`),
  ADD KEY `conversations_created_by_foreign` (`created_by`),
  ADD KEY `conversations_last_message_at_index` (`last_message_at`);

--
-- Indexes for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD PRIMARY KEY (`participant_id`),
  ADD UNIQUE KEY `conversation_participants_conversation_id_user_id_unique` (`conversation_id`,`user_id`),
  ADD KEY `conversation_participants_user_id_unread_count_index` (`user_id`,`unread_count`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donations_campaign_id_foreign` (`campaign_id`),
  ADD KEY `donations_user_id_foreign` (`user_id`);

--
-- Indexes for table `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donation_campaigns_admin_user_id_foreign` (`admin_user_id`);

--
-- Indexes for table `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD UNIQUE KEY `favorites_user_id_opportunity_id_unique` (`user_id`,`opportunity_id`),
  ADD KEY `favorites_opportunity_id_foreign` (`opportunity_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_conversation_id_sent_at_index` (`conversation_id`,`sent_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `notifications_user_id_is_read_created_at_index` (`user_id`,`is_read`,`created_at`);

--
-- Indexes for table `organizations`
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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `posts_status_published_at_index` (`status`,`published_at`),
  ADD KEY `posts_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `posts_is_pinned_index` (`is_pinned`);

--
-- Indexes for table `post_bookmarks`
--
ALTER TABLE `post_bookmarks`
  ADD PRIMARY KEY (`bookmark_id`),
  ADD UNIQUE KEY `post_bookmarks_post_id_user_id_unique` (`post_id`,`user_id`),
  ADD KEY `post_bookmarks_user_id_index` (`user_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post_comments_post_id_created_at_index` (`post_id`,`created_at`),
  ADD KEY `post_comments_user_id_index` (`user_id`),
  ADD KEY `post_comments_parent_id_index` (`parent_id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`like_id`),
  ADD UNIQUE KEY `post_likes_post_id_user_id_unique` (`post_id`,`user_id`),
  ADD KEY `post_likes_user_id_index` (`user_id`);

--
-- Indexes for table `post_reports`
--
ALTER TABLE `post_reports`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `post_reports_status_created_at_index` (`status`,`created_at`),
  ADD KEY `post_reports_post_id_index` (`post_id`),
  ADD KEY `post_reports_reporter_id_index` (`reporter_id`);

--
-- Indexes for table `post_shares`
--
ALTER TABLE `post_shares`
  ADD PRIMARY KEY (`share_id`),
  ADD KEY `post_shares_user_id_foreign` (`user_id`),
  ADD KEY `post_shares_post_id_created_at_index` (`post_id`,`created_at`);

--
-- Indexes for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`post_id`,`tag_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD UNIQUE KEY `reviews_reviewer_id_reviewee_id_opportunity_id_unique` (`reviewer_id`,`reviewee_id`,`opportunity_id`),
  ADD KEY `reviews_reviewee_id_foreign` (`reviewee_id`),
  ADD KEY `reviews_opportunity_id_foreign` (`opportunity_id`),
  ADD KEY `reviews_rating_index` (`rating`),
  ADD KEY `reviews_is_approved_created_at_index` (`is_approved`,`created_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `system_analytics`
--
ALTER TABLE `system_analytics`
  ADD PRIMARY KEY (`analytics_id`),
  ADD UNIQUE KEY `system_analytics_metric_name_record_date_category_unique` (`metric_name`,`record_date`,`category`),
  ADD KEY `system_analytics_record_date_category_index` (`record_date`,`category`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`),
  ADD KEY `tags_slug_index` (`slug`);

--
-- Indexes for table `users`
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
  ADD KEY `idx_active_type` (`is_active`,`user_type`);

--
-- Indexes for table `video_calls`
--
ALTER TABLE `video_calls`
  ADD PRIMARY KEY (`call_id`),
  ADD UNIQUE KEY `video_calls_room_id_unique` (`room_id`),
  ADD KEY `video_calls_conversation_id_foreign` (`conversation_id`),
  ADD KEY `video_calls_initiated_by_foreign` (`initiated_by`);

--
-- Indexes for table `volunteer_activities`
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
-- Indexes for table `volunteer_opportunities`
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
-- Indexes for table `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `volunteer_profiles_user_id_foreign` (`user_id`),
  ADD KEY `volunteer_profiles_volunteer_rating_index` (`volunteer_rating`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `application_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `connections`
--
ALTER TABLE `connections`
  MODIFY `connection_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `conversation_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  MODIFY `participant_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=261;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_bookmarks`
--
ALTER TABLE `post_bookmarks`
  MODIFY `bookmark_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `comment_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `like_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `post_reports`
--
ALTER TABLE `post_reports`
  MODIFY `report_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_shares`
--
ALTER TABLE `post_shares`
  MODIFY `share_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `system_analytics`
--
ALTER TABLE `system_analytics`
  MODIFY `analytics_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

--
-- AUTO_INCREMENT for table `video_calls`
--
ALTER TABLE `video_calls`
  MODIFY `call_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `volunteer_activities`
--
ALTER TABLE `volunteer_activities`
  MODIFY `activity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `volunteer_opportunities`
--
ALTER TABLE `volunteer_opportunities`
  MODIFY `opportunity_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  MODIFY `profile_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `connections`
--
ALTER TABLE `connections`
  ADD CONSTRAINT `connections_action_user_id_foreign` FOREIGN KEY (`action_user_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `connections_friend_id_foreign` FOREIGN KEY (`friend_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `connections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE;

--
-- Constraints for table `conversation_participants`
--
ALTER TABLE `conversation_participants`
  ADD CONSTRAINT `conversation_participants_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversation_participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_campaign_id_foreign` FOREIGN KEY (`campaign_id`) REFERENCES `donation_campaigns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `donations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `donation_campaigns`
--
ALTER TABLE `donation_campaigns`
  ADD CONSTRAINT `donation_campaigns_admin_user_id_foreign` FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_bookmarks`
--
ALTER TABLE `post_bookmarks`
  ADD CONSTRAINT `post_bookmarks_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_bookmarks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `post_comments` (`comment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD CONSTRAINT `post_likes_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_shares`
--
ALTER TABLE `post_shares`
  ADD CONSTRAINT `post_shares_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_shares_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `reviews_reviewee_id_foreign` FOREIGN KEY (`reviewee_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `video_calls`
--
ALTER TABLE `video_calls`
  ADD CONSTRAINT `video_calls_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `video_calls_initiated_by_foreign` FOREIGN KEY (`initiated_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `volunteer_activities`
--
ALTER TABLE `volunteer_activities`
  ADD CONSTRAINT `volunteer_activities_opportunity_id_foreign` FOREIGN KEY (`opportunity_id`) REFERENCES `volunteer_opportunities` (`opportunity_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_activities_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`org_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_activities_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `users` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `volunteer_activities_volunteer_id_foreign` FOREIGN KEY (`volunteer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `volunteer_opportunities`
--
ALTER TABLE `volunteer_opportunities`
  ADD CONSTRAINT `volunteer_opportunities_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `volunteer_opportunities_org_id_foreign` FOREIGN KEY (`org_id`) REFERENCES `organizations` (`org_id`) ON DELETE CASCADE;

--
-- Constraints for table `volunteer_profiles`
--
ALTER TABLE `volunteer_profiles`
  ADD CONSTRAINT `volunteer_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

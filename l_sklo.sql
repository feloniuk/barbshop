-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 06 2025 г., 21:17
-- Версия сервера: 10.4.24-MariaDB
-- Версия PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `l_sklo`
--

-- --------------------------------------------------------

--
-- Структура таблицы `actions_logs`
--

CREATE TABLE `actions_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `entity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `time` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `actions_logs`
--

INSERT INTO `actions_logs` (`id`, `user_id`, `action`, `entity`, `time`) VALUES
(1, 5, 'add', 'services#1', 1741047933),
(2, 5, 'add', 'shops#1', 1741048247),
(3, 5, 'edit', 'shops#1', 1741048457),
(4, 5, 'add', 'shops#2', 1741048667),
(5, 5, 'edit', 'shops#2', 1741048939),
(6, 5, 'edit', 'shops#1', 1741048957),
(7, 5, 'edit', 'user#3', 1741049222),
(8, 5, 'edit', 'services#1', 1741049301),
(9, 5, 'edit', 'user#3', 1741049309),
(10, 5, 'add', 'services#2', 1741049329),
(11, 5, 'edit', 'services#2', 1741049351),
(12, 5, 'add', 'services#3', 1741049368),
(13, 5, 'edit', 'services#3', 1741049400),
(14, 5, 'add', 'services#4', 1741049417),
(15, 5, 'edit', 'services#4', 1741049433),
(16, 5, 'add', 'services#5', 1741049477),
(17, 5, 'edit', 'services#5', 1741049492),
(18, 5, 'add', 'services#6', 1741049504),
(19, 5, 'edit', 'services#6', 1741049518),
(20, 5, 'add', 'services#7', 1741049526),
(21, 5, 'edit', 'services#7', 1741049541),
(22, 5, 'edit', 'services#7', 1741049556),
(23, 5, 'edit', 'services#6', 1741049564),
(24, 5, 'edit', 'services#5', 1741049570),
(25, 5, 'add', 'services#8', 1741049612),
(26, 5, 'edit', 'services#8', 1741049731),
(27, 5, 'edit', 'user#3', 1741049748),
(28, 5, 'edit', 'user#3', 1741049759),
(29, 5, 'edit', 'services#8', 1741049895);

-- --------------------------------------------------------

--
-- Структура таблицы `alt_attributes`
--

CREATE TABLE `alt_attributes` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `field_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `alt_attributes`
--

INSERT INTO `alt_attributes` (`id`, `entity`, `entity_id`, `field_name`, `alt`) VALUES
(2, 'shops', 2, 'image', ''),
(3, 'shops', 1, 'image', ''),
(4, 'services', 1, 'image', ''),
(5, 'services', 2, 'image', ''),
(6, 'services', 3, 'image', ''),
(7, 'services', 4, 'image', ''),
(11, 'services', 7, 'image', ''),
(12, 'services', 6, 'image', ''),
(13, 'services', 5, 'image', ''),
(15, 'services', 8, 'image', '');

-- --------------------------------------------------------

--
-- Структура таблицы `content_pages_tree`
--

CREATE TABLE `content_pages_tree` (
  `id` int(10) UNSIGNED NOT NULL,
  `module` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('input','textarea','image','video','picture','meta','file','page_name') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'textarea',
  `image_width` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_height` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_type` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `position` int(10) UNSIGNED DEFAULT 0,
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cv_library`
--

CREATE TABLE `cv_library` (
  `id` int(10) UNSIGNED NOT NULL,
  `vacancy_id` int(10) UNSIGNED DEFAULT 0,
  `candidate_id` int(10) UNSIGNED DEFAULT 0,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_spec` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `application_id` int(10) UNSIGNED DEFAULT 0 COMMENT 'Bullhorn field',
  `bh_notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Integration access revoked' COMMENT 'Bullhorn field',
  `bh_candidate_id` int(10) UNSIGNED DEFAULT 0 COMMENT 'Bullhorn field',
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `dashboard_settings`
--

CREATE TABLE `dashboard_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `where` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `sort_list` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `dashboard_settings`
--

INSERT INTO `dashboard_settings` (`id`, `title`, `table`, `where`, `link`, `status`, `sort_list`, `deleted`) VALUES
(1, 'Jobs Listed', 'vacancies', '', 'panel/vacancies', 'active', '', 'no'),
(2, 'Blog Posts', 'blog', '', 'panel/blog', 'active', '', 'no'),
(3, 'Uploaded Vacancies', 'cv_library', '`deleted` = &#039;no&#039; AND `vacancy_id` = &#039;0&#039;', 'panel/vacancy_applications', 'active', '', 'no'),
(4, 'Email subscribers', 'subscribers', '', 'panel/analytics/subscribers', 'active', '', 'no'),
(5, 'Team', 'users', '', 'panel/team', 'active', '', 'no'),
(6, 'Job Applications', 'cv_library', '`deleted` = &#039;no&#039; AND `vacancy_id` != &#039;0&#039;', 'panel/vacancy_applications', 'active', '', 'no');

-- --------------------------------------------------------

--
-- Структура таблицы `data_versions`
--

CREATE TABLE `data_versions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `entity_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `table` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `entity_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'default',
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `data_versions`
--

INSERT INTO `data_versions` (`id`, `user_id`, `entity_id`, `data`, `table`, `type`, `entity_type`, `deleted`, `time`) VALUES
(1, 5, '1', '{\"rows\":{\"id\":\"1\",\"title\":\"1\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"1\",\"time\":\"1741047933\"}}', 'services', 'add', 'default', 'no', 1741047933),
(2, 5, '1', '{\"rows\":{\"id\":\"1\",\"title\":\"\\u041f\\u0430\\u043f\\u0430+\\u0421\\u0438\\u043d Segedska\",\"image\":null,\"file\":null,\"work_time\":null,\"time_to\":null,\"time_from\":null,\"address\":null,\"address_link\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"no\",\"slug\":\"papa-sin-segedska\",\"time\":\"1741048247\"}}', 'shops', 'add', 'default', 'no', 1741048247),
(3, 5, '1', '{\"rows\":{\"id\":\"1\",\"title\":\"\\u041f\\u0430\\u043f\\u0430+\\u0421\\u0438\\u043d Segedska\",\"image\":\"71ae1ef10e90925aaa70b54bb778c9a5.webp\",\"file\":null,\"work_time\":\"\",\"time_to\":\"22:00\",\"time_from\":\"10:00\",\"address\":\"\\u041c\\u0435\\u0441\\u044f\\u0447\\u043d\\u044b\\u0439, 2\",\"address_link\":\"https:\\/\\/g.co\\/kgs\\/x8me6Hz\",\"content\":\"&lt;p&gt;\\u041d\\u0430\\u0448 \\u0431\\u0430\\u0440\\u0431\\u0435\\u0440\\u0448\\u043e\\u043f &mdash; \\u044d\\u0442\\u043e \\u043c\\u0435\\u0441\\u0442\\u043e, \\u0433\\u0434\\u0435 \\u0441\\u0442\\u0438\\u043b\\u044c \\u0438 \\u0442\\u0440\\u0430\\u0434\\u0438\\u0446\\u0438\\u0438 \\u0432\\u0441\\u0442\\u0440\\u0435\\u0447\\u0430\\u044e\\u0442\\u0441\\u044f \\u0441 \\u0441\\u043e\\u0432\\u0440\\u0435\\u043c\\u0435\\u043d\\u043d\\u044b\\u043c\\u0438 \\u0442\\u0440\\u0435\\u043d\\u0434\\u0430\\u043c\\u0438. \\u041c\\u044b \\u0441\\u043e\\u0437\\u0434\\u0430\\u0435\\u043c \\u043d\\u0435 \\u043f\\u0440\\u043e\\u0441\\u0442\\u043e \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0438, \\u0430 \\u043f\\u043e\\u0434\\u0447\\u0435\\u0440\\u043a\\u0438\\u0432\\u0430\\u0435\\u043c \\u0438\\u043d\\u0434\\u0438\\u0432\\u0438\\u0434\\u0443\\u0430\\u043b\\u044c\\u043d\\u043e\\u0441\\u0442\\u044c \\u043a\\u0430\\u0436\\u0434\\u043e\\u0433\\u043e \\u043a\\u043b\\u0438\\u0435\\u043d\\u0442\\u0430. \\u0410\\u0442\\u043c\\u043e\\u0441\\u0444\\u0435\\u0440\\u0430 \\u0443\\u044e\\u0442\\u0430 \\u0438 \\u0431\\u0440\\u0443\\u0442\\u0430\\u043b\\u044c\\u043d\\u043e\\u0441\\u0442\\u0438, \\u043f\\u0440\\u043e\\u0444\\u0435\\u0441\\u0441\\u0438\\u043e\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0435 \\u0431\\u0430\\u0440\\u0431\\u0435\\u0440\\u044b, \\u043a\\u0430\\u0447\\u0435\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u044b\\u0435 \\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432\\u0430 \\u0434\\u043b\\u044f \\u0443\\u0445\\u043e\\u0434\\u0430 &mdash; \\u0432\\u0441\\u0451 \\u0434\\u043b\\u044f \\u0442\\u043e\\u0433\\u043e, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0442\\u044b \\u0447\\u0443\\u0432\\u0441\\u0442\\u0432\\u043e\\u0432\\u0430\\u043b \\u0441\\u0435\\u0431\\u044f \\u0443\\u0432\\u0435\\u0440\\u0435\\u043d\\u043d\\u043e. \\u0414\\u043e\\u0431\\u0440\\u043e \\u043f\\u043e\\u0436\\u0430\\u043b\\u043e\\u0432\\u0430\\u0442\\u044c \\u0432 \\u043f\\u0440\\u043e\\u0441\\u0442\\u0440\\u0430\\u043d\\u0441\\u0442\\u0432\\u043e \\u043d\\u0430\\u0441\\u0442\\u043e\\u044f\\u0449\\u0435\\u0433\\u043e \\u043c\\u0443\\u0436\\u0441\\u043a\\u043e\\u0433\\u043e \\u0443\\u0445\\u043e\\u0434\\u0430!&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"papa-sin-segedska\",\"time\":\"1741048457\"}}', 'shops', 'edit', 'default', 'no', 1741048457),
(4, 5, '2', '{\"rows\":{\"id\":\"2\",\"title\":\"\\u041f\\u0430\\u043f\\u0430+\\u0441\\u044b\\u043d \\u0413\\u0435\\u043d.\\u041f\\u0435\\u0442\\u0440\\u043e\\u0432\\u0430\",\"image\":null,\"file\":null,\"work_time\":null,\"time_to\":null,\"time_from\":null,\"address\":null,\"address_link\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"no\",\"slug\":\"papa-syn-gen-petrova\",\"time\":\"1741048667\"}}', 'shops', 'add', 'default', 'no', 1741048667),
(5, 5, '2', '{\"rows\":{\"id\":\"2\",\"title\":\"\\u041f\\u0430\\u043f\\u0430+\\u0441\\u044b\\u043d \\u0413\\u0435\\u043d.\\u041f\\u0435\\u0442\\u0440\\u043e\\u0432\\u0430\",\"image\":\"crop_66c8fcd68b98925cb81139f028b184e0.jpg\",\"file\":null,\"work_time\":\"\",\"time_to\":\"22:00\",\"time_from\":\"10:00\",\"address\":\"\\u0413\\u0435\\u043d\\u0435\\u0440\\u0430\\u043b\\u0430 \\u041f\\u0435\\u0442\\u0440\\u043e\\u0432\\u0430, 61\",\"address_link\":\"https:\\/\\/g.co\\/kgs\\/gjLTExK\",\"content\":\"&lt;p&gt;\\u041d\\u0430\\u0448 \\u0431\\u0430\\u0440\\u0431\\u0435\\u0440\\u0448\\u043e\\u043f &mdash; \\u044d\\u0442\\u043e \\u043c\\u0435\\u0441\\u0442\\u043e, \\u0433\\u0434\\u0435 \\u0441\\u0442\\u0438\\u043b\\u044c \\u0438 \\u0442\\u0440\\u0430\\u0434\\u0438\\u0446\\u0438\\u0438 \\u0432\\u0441\\u0442\\u0440\\u0435\\u0447\\u0430\\u044e\\u0442\\u0441\\u044f \\u0441 \\u0441\\u043e\\u0432\\u0440\\u0435\\u043c\\u0435\\u043d\\u043d\\u044b\\u043c\\u0438 \\u0442\\u0440\\u0435\\u043d\\u0434\\u0430\\u043c\\u0438. \\u041c\\u044b \\u0441\\u043e\\u0437\\u0434\\u0430\\u0435\\u043c \\u043d\\u0435 \\u043f\\u0440\\u043e\\u0441\\u0442\\u043e \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0438, \\u0430 \\u043f\\u043e\\u0434\\u0447\\u0435\\u0440\\u043a\\u0438\\u0432\\u0430\\u0435\\u043c \\u0438\\u043d\\u0434\\u0438\\u0432\\u0438\\u0434\\u0443\\u0430\\u043b\\u044c\\u043d\\u043e\\u0441\\u0442\\u044c \\u043a\\u0430\\u0436\\u0434\\u043e\\u0433\\u043e \\u043a\\u043b\\u0438\\u0435\\u043d\\u0442\\u0430. \\u0410\\u0442\\u043c\\u043e\\u0441\\u0444\\u0435\\u0440\\u0430 \\u0443\\u044e\\u0442\\u0430 \\u0438 \\u0431\\u0440\\u0443\\u0442\\u0430\\u043b\\u044c\\u043d\\u043e\\u0441\\u0442\\u0438, \\u043f\\u0440\\u043e\\u0444\\u0435\\u0441\\u0441\\u0438\\u043e\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0435 \\u0431\\u0430\\u0440\\u0431\\u0435\\u0440\\u044b, \\u043a\\u0430\\u0447\\u0435\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u044b\\u0435 \\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432\\u0430 \\u0434\\u043b\\u044f \\u0443\\u0445\\u043e\\u0434\\u0430 &mdash; \\u0432\\u0441\\u0451 \\u0434\\u043b\\u044f \\u0442\\u043e\\u0433\\u043e, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0442\\u044b \\u0447\\u0443\\u0432\\u0441\\u0442\\u0432\\u043e\\u0432\\u0430\\u043b \\u0441\\u0435\\u0431\\u044f \\u0443\\u0432\\u0435\\u0440\\u0435\\u043d\\u043d\\u043e. \\u0414\\u043e\\u0431\\u0440\\u043e \\u043f\\u043e\\u0436\\u0430\\u043b\\u043e\\u0432\\u0430\\u0442\\u044c \\u0432 \\u043f\\u0440\\u043e\\u0441\\u0442\\u0440\\u0430\\u043d\\u0441\\u0442\\u0432\\u043e \\u043d\\u0430\\u0441\\u0442\\u043e\\u044f\\u0449\\u0435\\u0433\\u043e \\u043c\\u0443\\u0436\\u0441\\u043a\\u043e\\u0433\\u043e \\u0443\\u0445\\u043e\\u0434\\u0430!&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"papa-syn-gen-petrova\",\"time\":\"1741048939\"}}', 'shops', 'edit', 'default', 'no', 1741048939),
(6, 5, '1', '{\"rows\":{\"id\":\"1\",\"title\":\"\\u041f\\u0430\\u043f\\u0430+\\u0421\\u0438\\u043d Segedska\",\"image\":\"crop_24e53ee9b3a213e6f835ef824e8ba00f.jpg\",\"file\":null,\"work_time\":\"\",\"time_to\":\"22:00\",\"time_from\":\"10:00\",\"address\":\"\\u041c\\u0435\\u0441\\u044f\\u0447\\u043d\\u044b\\u0439, 2\",\"address_link\":\"https:\\/\\/g.co\\/kgs\\/x8me6Hz\",\"content\":\"&lt;p&gt;\\u041d\\u0430\\u0448 \\u0431\\u0430\\u0440\\u0431\\u0435\\u0440\\u0448\\u043e\\u043f &mdash; \\u044d\\u0442\\u043e \\u043c\\u0435\\u0441\\u0442\\u043e, \\u0433\\u0434\\u0435 \\u0441\\u0442\\u0438\\u043b\\u044c \\u0438 \\u0442\\u0440\\u0430\\u0434\\u0438\\u0446\\u0438\\u0438 \\u0432\\u0441\\u0442\\u0440\\u0435\\u0447\\u0430\\u044e\\u0442\\u0441\\u044f \\u0441 \\u0441\\u043e\\u0432\\u0440\\u0435\\u043c\\u0435\\u043d\\u043d\\u044b\\u043c\\u0438 \\u0442\\u0440\\u0435\\u043d\\u0434\\u0430\\u043c\\u0438. \\u041c\\u044b \\u0441\\u043e\\u0437\\u0434\\u0430\\u0435\\u043c \\u043d\\u0435 \\u043f\\u0440\\u043e\\u0441\\u0442\\u043e \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0438, \\u0430 \\u043f\\u043e\\u0434\\u0447\\u0435\\u0440\\u043a\\u0438\\u0432\\u0430\\u0435\\u043c \\u0438\\u043d\\u0434\\u0438\\u0432\\u0438\\u0434\\u0443\\u0430\\u043b\\u044c\\u043d\\u043e\\u0441\\u0442\\u044c \\u043a\\u0430\\u0436\\u0434\\u043e\\u0433\\u043e \\u043a\\u043b\\u0438\\u0435\\u043d\\u0442\\u0430. \\u0410\\u0442\\u043c\\u043e\\u0441\\u0444\\u0435\\u0440\\u0430 \\u0443\\u044e\\u0442\\u0430 \\u0438 \\u0431\\u0440\\u0443\\u0442\\u0430\\u043b\\u044c\\u043d\\u043e\\u0441\\u0442\\u0438, \\u043f\\u0440\\u043e\\u0444\\u0435\\u0441\\u0441\\u0438\\u043e\\u043d\\u0430\\u043b\\u044c\\u043d\\u044b\\u0435 \\u0431\\u0430\\u0440\\u0431\\u0435\\u0440\\u044b, \\u043a\\u0430\\u0447\\u0435\\u0441\\u0442\\u0432\\u0435\\u043d\\u043d\\u044b\\u0435 \\u0441\\u0440\\u0435\\u0434\\u0441\\u0442\\u0432\\u0430 \\u0434\\u043b\\u044f \\u0443\\u0445\\u043e\\u0434\\u0430 &mdash; \\u0432\\u0441\\u0451 \\u0434\\u043b\\u044f \\u0442\\u043e\\u0433\\u043e, \\u0447\\u0442\\u043e\\u0431\\u044b \\u0442\\u044b \\u0447\\u0443\\u0432\\u0441\\u0442\\u0432\\u043e\\u0432\\u0430\\u043b \\u0441\\u0435\\u0431\\u044f \\u0443\\u0432\\u0435\\u0440\\u0435\\u043d\\u043d\\u043e. \\u0414\\u043e\\u0431\\u0440\\u043e \\u043f\\u043e\\u0436\\u0430\\u043b\\u043e\\u0432\\u0430\\u0442\\u044c \\u0432 \\u043f\\u0440\\u043e\\u0441\\u0442\\u0440\\u0430\\u043d\\u0441\\u0442\\u0432\\u043e \\u043d\\u0430\\u0441\\u0442\\u043e\\u044f\\u0449\\u0435\\u0433\\u043e \\u043c\\u0443\\u0436\\u0441\\u043a\\u043e\\u0433\\u043e \\u0443\\u0445\\u043e\\u0434\\u0430!&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"papa-sin-segedska\",\"time\":\"1741048956\"}}', 'shops', 'edit', 'default', 'no', 1741048957),
(7, 5, '3', '{\"rows\":{\"id\":\"3\",\"email\":\"master@gmail.com\",\"password\":\"613ba0a0b709a943a6d5b7fcd83ecf32\",\"token\":null,\"restore_token\":null,\"role\":\"master\",\"firstname\":\"Master\",\"lastname\":\"Master\",\"description\":\"\",\"tel\":\"\",\"skype\":\"\",\"twitter\":\"\",\"linkedin\":\"\",\"image\":\"crop_355cee0f27a08075f131113a5c005ff3.png\",\"job_title\":\"Tester\",\"sectors\":\"\",\"locations\":\"\",\"location\":\"\",\"cv\":null,\"display_team\":\"no\",\"sort\":\"0\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_desc\":\"\",\"slug\":\"tester-tester\",\"deleted\":\"no\",\"reg_time\":\"1581189342\",\"last_time\":\"1585141182\"}}', 'users', 'edit', 'default', 'no', 1741049222),
(8, 5, '1', '{\"rows\":{\"id\":\"1\",\"title\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430(\\u0444\\u0435\\u0439\\u0434)\",\"image\":\"f11535683da7f028cd5129a20aaa204b.png\",\"file\":null,\"price\":\"450\",\"service_time\":\"1\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u043d\\u043e\\u0436\\u0438\\u0446\\u044f\\u043c\\u0438, \\u0437 \\u0435\\u043b\\u0435\\u043c\\u0435\\u043d\\u0442\\u043e\\u043c &laquo;fade&raquo; (\\u043f\\u043b\\u0430\\u0432\\u043d\\u0438\\u0439 \\u043f\\u0435\\u0440\\u0435\\u0445\\u0456\\u0434 \\u0437 &laquo;0&raquo;), \\u0430 \\u0442\\u0430\\u043a\\u043e\\u0436 \\u043c\\u0438\\u0442\\u0442\\u044f \\u0433\\u043e\\u043b\\u043e\\u0432\\u0438 \\u0442\\u0430 \\u0443\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f \\u0437\\u0430 \\u0412\\u0430\\u0448\\u0438\\u043c \\u0431\\u0430\\u0436\\u0430\\u043d\\u043d\\u044f\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430(\\u0444\\u0435\\u0439\\u0434)\",\"time\":\"1741049301\"}}', 'services', 'edit', 'default', 'no', 1741049301),
(9, 5, '3', '{\"rows\":{\"id\":\"3\",\"email\":\"master@gmail.com\",\"password\":\"613ba0a0b709a943a6d5b7fcd83ecf32\",\"token\":null,\"restore_token\":null,\"role\":\"master\",\"firstname\":\"Master\",\"lastname\":\"Master\",\"description\":\"\",\"tel\":\"\",\"skype\":\"\",\"twitter\":\"\",\"linkedin\":\"\",\"image\":\"crop_355cee0f27a08075f131113a5c005ff3.png\",\"job_title\":\"Tester\",\"sectors\":\"\",\"locations\":\"\",\"location\":\"\",\"cv\":null,\"display_team\":\"no\",\"sort\":\"0\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_desc\":\"\",\"slug\":\"tester-tester\",\"deleted\":\"no\",\"reg_time\":\"1581189342\",\"last_time\":\"1585141182\"}}', 'users', 'edit', 'default', 'no', 1741049309),
(10, 5, '2', '{\"rows\":{\"id\":\"2\",\"title\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 (\\u043a\\u043b\\u0430\\u0441\\u0438\\u043a\\u0430)\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"strizhka-klasika-\",\"time\":\"1741049329\"}}', 'services', 'add', 'default', 'no', 1741049329),
(11, 5, '2', '{\"rows\":{\"id\":\"2\",\"title\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 (\\u043a\\u043b\\u0430\\u0441\\u0438\\u043a\\u0430)\",\"image\":\"f732a124878fb0a940242bbad149836e.png\",\"file\":null,\"price\":\"400\",\"service_time\":\"1\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u043d\\u043e\\u0436\\u0438\\u0446\\u044f\\u043c\\u0438, \\u0437\\u0431\\u043e\\u043a\\u0443 \\u0432\\u0438\\u043a\\u043e\\u0440\\u0438\\u0441\\u0442\\u043e\\u0432\\u0443\\u044e\\u0442\\u044c\\u0441\\u044f \\u043d\\u0430\\u0441\\u0430\\u0434\\u043a\\u0438 \\u0432\\u0456\\u0434 1.5 \\u0434\\u043e 13\\u043c\\u043c, \\u0430 \\u0442\\u0430\\u043a\\u043e\\u0436 \\u043c\\u0438\\u0442\\u0442\\u044f \\u0433\\u043e\\u043b\\u043e\\u0432\\u0438 \\u0442\\u0430 \\u0443\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f \\u0437\\u0430 \\u0412\\u0430\\u0448\\u0438\\u043c \\u0431\\u0430\\u0436\\u0430\\u043d\\u043d\\u044f\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 (\\u043a\\u043b\\u0430\\u0441\\u0438\\u043a\\u0430)\",\"time\":\"1741049351\"}}', 'services', 'edit', 'default', 'no', 1741049351),
(12, 5, '3', '{\"rows\":{\"id\":\"3\",\"title\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 \\u043c\\u0430\\u0448\\u0438\\u043d\\u043a\\u043e\\u044e (\\u0444\\u0435\\u0439\\u0434)\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"strizhka-mashinkoyu-feyd-\",\"time\":\"1741049368\"}}', 'services', 'add', 'default', 'no', 1741049368),
(13, 5, '3', '{\"rows\":{\"id\":\"3\",\"title\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 \\u043c\\u0430\\u0448\\u0438\\u043d\\u043a\\u043e\\u044e (\\u0444\\u0435\\u0439\\u0434)\",\"image\":\"27bbcd9ac712485074b12e25b6a70183.png\",\"file\":null,\"price\":\"350\",\"service_time\":\"1\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u043d\\u0430\\u0441\\u0430\\u0434\\u043a\\u043e\\u044e \\u0432\\u0456\\u0434 4,5 \\u0434\\u043e 13\\u043c\\u043c, \\u0437 \\u0435\\u043b\\u0435\\u043c\\u0435\\u043d\\u0442\\u043e\\u043c &laquo;fade&raquo; (\\u043f\\u043b\\u0430\\u0432\\u043d\\u0438\\u0439 \\u043f\\u0435\\u0440\\u0435\\u0445\\u0456\\u0434 \\u0437 &laquo;0&raquo;), \\u0430 \\u0442\\u0430\\u043a\\u043e\\u0436 \\u043c\\u0438\\u0442\\u0442\\u044f \\u0433\\u043e\\u043b\\u043e\\u0432\\u0438 \\u0437\\u0430 \\u0412\\u0430\\u0448\\u0438\\u043c \\u0431\\u0430\\u0436\\u0430\\u043d\\u043d\\u044f\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 \\u043c\\u0430\\u0448\\u0438\\u043d\\u043a\\u043e\\u044e (\\u0444\\u0435\\u0439\\u0434)\",\"time\":\"1741049399\"}}', 'services', 'edit', 'default', 'no', 1741049399),
(14, 5, '4', '{\"rows\":{\"id\":\"4\",\"title\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 \\u043c\\u0430\\u0448\\u0438\\u043d\\u043a\\u043e\\u044e (\\u043a\\u043b\\u0430\\u0441\\u0438\\u043a\\u0430)\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"strizhka-mashinkoyu-klasika-\",\"time\":\"1741049417\"}}', 'services', 'add', 'default', 'no', 1741049417),
(15, 5, '4', '{\"rows\":{\"id\":\"4\",\"title\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 \\u043c\\u0430\\u0448\\u0438\\u043d\\u043a\\u043e\\u044e (\\u043a\\u043b\\u0430\\u0441\\u0438\\u043a\\u0430)\",\"image\":\"c80dcabcfe3f847803dd3ce217ec697e.png\",\"file\":null,\"price\":\"350\",\"service_time\":\"0.5\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u043d\\u0430\\u0441\\u0430\\u0434\\u043a\\u043e\\u044e \\u0434\\u043e 13\\u043c\\u043c, \\u0437\\u0431\\u043e\\u043a\\u0443 \\u0434\\u043b\\u044f \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0438 \\u0432\\u0438\\u043a\\u043e\\u0440\\u0438\\u0441\\u0442\\u043e\\u0432\\u0443\\u044e\\u0442\\u044c\\u0441\\u044f \\u043d\\u0430\\u0441\\u0430\\u0434\\u043a\\u0430 \\u0432\\u0456\\u0434 1,5 \\u0434\\u043e 13\\u043c\\u043c, \\u0430 \\u0442\\u0430\\u043a\\u043e\\u0436 \\u043c\\u0438\\u0442\\u0442\\u044f \\u0433\\u043e\\u043b\\u043e\\u0432\\u0438 \\u0437\\u0430 \\u0412\\u0430\\u0448\\u0438\\u043c \\u0431\\u0430\\u0436\\u0430\\u043d\\u043d\\u044f\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0421\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430 \\u043c\\u0430\\u0448\\u0438\\u043d\\u043a\\u043e\\u044e (\\u043a\\u043b\\u0430\\u0441\\u0438\\u043a\\u0430)\",\"time\":\"1741049433\"}}', 'services', 'edit', 'default', 'no', 1741049433),
(16, 5, '5', '{\"rows\":{\"id\":\"5\",\"title\":\"\\u0414\\u0438\\u0442\\u044f\\u0447\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"dityacha-strizhka\",\"time\":\"1741049477\"}}', 'services', 'add', 'default', 'no', 1741049477),
(17, 5, '5', '{\"rows\":{\"id\":\"5\",\"title\":\"\\u0414\\u0438\\u0442\\u044f\\u0447\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430\",\"image\":\"48e5abb0d331fdb58319180e0556ced7.png\",\"file\":null,\"price\":\"0\",\"service_time\":\"1\",\"content\":\"&lt;p&gt;\\u0411\\u0443\\u0434\\u044c-\\u044f\\u043a\\u0430 \\u0434\\u0438\\u0442\\u044f\\u0447\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430, \\u0437\\u0430 \\u0432\\u0438\\u043d\\u044f\\u0442\\u043a\\u043e\\u043c \\u043f\\u043e\\u0434\\u043e\\u0432\\u0436\\u0435\\u043d\\u043e\\u0457 (\\u0434\\u043e\\u0432\\u0436\\u0438\\u043d\\u0430 \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f \\u0437\\u0431\\u043e\\u043a\\u0443 \\u043f\\u0435\\u0440\\u0435\\u0432\\u0438\\u0449\\u0443\\u0454 2\\u0441\\u043c), \\u0434\\u043b\\u044f \\u0432\\u0438\\u0431\\u043e\\u0440\\u0443 \\u043f\\u043e\\u0434\\u043e\\u0432\\u0436\\u0435\\u043d\\u043e\\u0457 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0438, \\u043e\\u0431\\u0435\\u0440\\u0456\\u0442\\u044c &laquo;\\u0410\\u0432\\u0442\\u043e\\u0440\\u0441\\u044c\\u043a\\u0430 \\u043f\\u043e\\u0434\\u043e\\u0432\\u0436\\u0435\\u043d\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430&raquo;&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0414\\u0438\\u0442\\u044f\\u0447\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430\",\"time\":\"1741049492\"}}', 'services', 'edit', 'default', 'no', 1741049492),
(18, 5, '6', '{\"rows\":{\"id\":\"6\",\"title\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\\u043c\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"oformlennya-borodi-z-gol-nnyam\",\"time\":\"1741049504\"}}', 'services', 'add', 'default', 'no', 1741049504),
(19, 5, '6', '{\"rows\":{\"id\":\"6\",\"title\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\\u043c\",\"image\":\"d9905f39803c5926d9023bc8668afda6.png\",\"file\":null,\"price\":\"0\",\"service_time\":\"0.5\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0443\\u0434\\u044c-\\u044f\\u043a\\u043e\\u0457 \\u0434\\u043e\\u0432\\u0436\\u0438\\u043d\\u0438,\\u043d\\u0430\\u0434\\u0430\\u043d\\u043d\\u044f \\u0444\\u043e\\u0440\\u043c\\u0438, \\u0443\\u0441\\u0443\\u043d\\u0435\\u043d\\u043d\\u044f \\u0437\\u0430\\u0439\\u0432\\u043e\\u0433\\u043e \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f, \\u0449\\u043e \\u0441\\u0442\\u0438\\u0440\\u0447\\u0438\\u0442\\u044c, \\u043f\\u0435\\u0440\\u0435\\u0445\\u0456\\u0434 \\u043d\\u0430 \\u0441\\u043a\\u0440\\u043e\\u043d\\u044f\\u0445 \\u0442\\u0430 \\u043a\\u043e\\u043d\\u0442\\u0443\\u0440\\u0438, \\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\\u043c \\u043d\\u0435\\u0431\\u0435\\u0437\\u043f\\u0435\\u0447\\u043d\\u0438\\u043c \\u043b\\u0435\\u0437\\u043e\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\\u043c\",\"time\":\"1741049518\"}}', 'services', 'edit', 'default', 'no', 1741049518),
(20, 5, '7', '{\"rows\":{\"id\":\"7\",\"title\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0435\\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"oformlennya-borodi-bez-gol-nnya\",\"time\":\"1741049526\"}}', 'services', 'add', 'default', 'no', 1741049526),
(21, 5, '7', '{\"rows\":{\"id\":\"7\",\"title\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0435\\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\",\"image\":\"2e74bf874284b623789a4a2aae3f3dc4.png\",\"file\":null,\"price\":\"0\",\"service_time\":\"0.5\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0443\\u0434\\u044c-\\u044f\\u043a\\u043e\\u0457 \\u0434\\u043e\\u0432\\u0436\\u0438\\u043d\\u0438,\\u043d\\u0430\\u0434\\u0430\\u043d\\u043d\\u044f \\u0444\\u043e\\u0440\\u043c\\u0438, \\u0443\\u0441\\u0443\\u043d\\u0435\\u043d\\u043d\\u044f \\u0437\\u0430\\u0439\\u0432\\u043e\\u0433\\u043e \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f, \\u0449\\u043e \\u0441\\u0442\\u0438\\u0440\\u0447\\u0438\\u0442\\u044c, \\u043f\\u0435\\u0440\\u0435\\u0445\\u0456\\u0434 \\u043d\\u0430 \\u0441\\u043a\\u0440\\u043e\\u043d\\u044f\\u0445 \\u0442\\u0430 \\u043a\\u043e\\u043d\\u0442\\u0443\\u0440\\u0438, \\u0431\\u0435\\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f \\u043d\\u0435\\u0431\\u0435\\u0437\\u043f\\u0435\\u0447\\u043d\\u0438\\u043c \\u043b\\u0435\\u0437\\u043e\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0435\\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\",\"time\":\"1741049541\"}}', 'services', 'edit', 'default', 'no', 1741049541),
(22, 5, '7', '{\"rows\":{\"id\":\"7\",\"title\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0435\\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\",\"image\":\"2e74bf874284b623789a4a2aae3f3dc4.png\",\"file\":null,\"price\":\"300\",\"service_time\":\"0.5\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0443\\u0434\\u044c-\\u044f\\u043a\\u043e\\u0457 \\u0434\\u043e\\u0432\\u0436\\u0438\\u043d\\u0438,\\u043d\\u0430\\u0434\\u0430\\u043d\\u043d\\u044f \\u0444\\u043e\\u0440\\u043c\\u0438, \\u0443\\u0441\\u0443\\u043d\\u0435\\u043d\\u043d\\u044f \\u0437\\u0430\\u0439\\u0432\\u043e\\u0433\\u043e \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f, \\u0449\\u043e \\u0441\\u0442\\u0438\\u0440\\u0447\\u0438\\u0442\\u044c, \\u043f\\u0435\\u0440\\u0435\\u0445\\u0456\\u0434 \\u043d\\u0430 \\u0441\\u043a\\u0440\\u043e\\u043d\\u044f\\u0445 \\u0442\\u0430 \\u043a\\u043e\\u043d\\u0442\\u0443\\u0440\\u0438, \\u0431\\u0435\\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f \\u043d\\u0435\\u0431\\u0435\\u0437\\u043f\\u0435\\u0447\\u043d\\u0438\\u043c \\u043b\\u0435\\u0437\\u043e\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0435\\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\",\"time\":\"1741049556\"}}', 'services', 'edit', 'default', 'no', 1741049556),
(23, 5, '6', '{\"rows\":{\"id\":\"6\",\"title\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\\u043c\",\"image\":\"d9905f39803c5926d9023bc8668afda6.png\",\"file\":null,\"price\":\"300\",\"service_time\":\"0.5\",\"content\":\"&lt;p&gt;\\u0426\\u044f \\u043f\\u043e\\u0441\\u043b\\u0443\\u0433\\u0430 \\u0432\\u043a\\u043b\\u044e\\u0447\\u0430\\u0454 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0443 \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0431\\u0443\\u0434\\u044c-\\u044f\\u043a\\u043e\\u0457 \\u0434\\u043e\\u0432\\u0436\\u0438\\u043d\\u0438,\\u043d\\u0430\\u0434\\u0430\\u043d\\u043d\\u044f \\u0444\\u043e\\u0440\\u043c\\u0438, \\u0443\\u0441\\u0443\\u043d\\u0435\\u043d\\u043d\\u044f \\u0437\\u0430\\u0439\\u0432\\u043e\\u0433\\u043e \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f, \\u0449\\u043e \\u0441\\u0442\\u0438\\u0440\\u0447\\u0438\\u0442\\u044c, \\u043f\\u0435\\u0440\\u0435\\u0445\\u0456\\u0434 \\u043d\\u0430 \\u0441\\u043a\\u0440\\u043e\\u043d\\u044f\\u0445 \\u0442\\u0430 \\u043a\\u043e\\u043d\\u0442\\u0443\\u0440\\u0438, \\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\\u043c \\u043d\\u0435\\u0431\\u0435\\u0437\\u043f\\u0435\\u0447\\u043d\\u0438\\u043c \\u043b\\u0435\\u0437\\u043e\\u043c&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u041e\\u0444\\u043e\\u0440\\u043c\\u043b\\u0435\\u043d\\u043d\\u044f \\u0431\\u043e\\u0440\\u043e\\u0434\\u0438 \\u0437 \\u0433\\u043e\\u043b\\u0456\\u043d\\u043d\\u044f\\u043c\",\"time\":\"1741049564\"}}', 'services', 'edit', 'default', 'no', 1741049564),
(24, 5, '5', '{\"rows\":{\"id\":\"5\",\"title\":\"\\u0414\\u0438\\u0442\\u044f\\u0447\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430\",\"image\":\"48e5abb0d331fdb58319180e0556ced7.png\",\"file\":null,\"price\":\"350\",\"service_time\":\"1\",\"content\":\"&lt;p&gt;\\u0411\\u0443\\u0434\\u044c-\\u044f\\u043a\\u0430 \\u0434\\u0438\\u0442\\u044f\\u0447\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430, \\u0437\\u0430 \\u0432\\u0438\\u043d\\u044f\\u0442\\u043a\\u043e\\u043c \\u043f\\u043e\\u0434\\u043e\\u0432\\u0436\\u0435\\u043d\\u043e\\u0457 (\\u0434\\u043e\\u0432\\u0436\\u0438\\u043d\\u0430 \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f \\u0437\\u0431\\u043e\\u043a\\u0443 \\u043f\\u0435\\u0440\\u0435\\u0432\\u0438\\u0449\\u0443\\u0454 2\\u0441\\u043c), \\u0434\\u043b\\u044f \\u0432\\u0438\\u0431\\u043e\\u0440\\u0443 \\u043f\\u043e\\u0434\\u043e\\u0432\\u0436\\u0435\\u043d\\u043e\\u0457 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0438, \\u043e\\u0431\\u0435\\u0440\\u0456\\u0442\\u044c &laquo;\\u0410\\u0432\\u0442\\u043e\\u0440\\u0441\\u044c\\u043a\\u0430 \\u043f\\u043e\\u0434\\u043e\\u0432\\u0436\\u0435\\u043d\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430&raquo;&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0414\\u0438\\u0442\\u044f\\u0447\\u0430 \\u0441\\u0442\\u0440\\u0438\\u0436\\u043a\\u0430\",\"time\":\"1741049570\"}}', 'services', 'edit', 'default', 'no', 1741049570),
(25, 5, '8', '{\"rows\":{\"id\":\"8\",\"title\":\"\\u0423\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0438\",\"image\":null,\"file\":null,\"price\":null,\"service_time\":null,\"content\":null,\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"ukladka-zach-ski\",\"time\":\"1741049612\"}}', 'services', 'add', 'default', 'no', 1741049612),
(26, 5, '8', '{\"rows\":{\"id\":\"8\",\"title\":\"\\u0423\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0438\",\"image\":\"crop_fcaa59896843fab7a214d22b3b8ba8c3.png\",\"file\":null,\"price\":\"150\",\"service_time\":\"0.5\",\"content\":\"&lt;p&gt;&quot;\\u0423\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0438&quot; \\u043f\\u0440\\u043e\\u043f\\u043e\\u043d\\u0443\\u0454 \\u043f\\u0440\\u043e\\u0444\\u0435\\u0441\\u0456\\u0439\\u043d\\u0435 \\u0441\\u0442\\u0432\\u043e\\u0440\\u0435\\u043d\\u043d\\u044f \\u0441\\u0442\\u0438\\u043b\\u044c\\u043d\\u0438\\u0445 \\u0442\\u0430 \\u0435\\u043b\\u0435\\u0433\\u0430\\u043d\\u0442\\u043d\\u0438\\u0445 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043e\\u043a \\u0434\\u043b\\u044f \\u0431\\u0443\\u0434\\u044c-\\u044f\\u043a\\u043e\\u0457 \\u043f\\u043e\\u0434\\u0456\\u0457. \\u041d\\u0430\\u0448\\u0456 \\u0434\\u043e\\u0441\\u0432\\u0456\\u0434\\u0447\\u0435\\u043d\\u0456 \\u0441\\u0442\\u0438\\u043b\\u0456\\u0441\\u0442\\u0438 \\u0434\\u043e\\u043f\\u043e\\u043c\\u043e\\u0436\\u0443\\u0442\\u044c \\u043f\\u0456\\u0434\\u0456\\u0431\\u0440\\u0430\\u0442\\u0438 \\u0456\\u0434\\u0435\\u0430\\u043b\\u044c\\u043d\\u0438\\u0439 \\u043e\\u0431\\u0440\\u0430\\u0437, \\u0432\\u0440\\u0430\\u0445\\u043e\\u0432\\u0443\\u044e\\u0447\\u0438 \\u0442\\u0438\\u043f \\u0432\\u0430\\u0448\\u043e\\u0433\\u043e \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f, \\u0444\\u043e\\u0440\\u043c\\u0443 \\u043e\\u0431\\u043b\\u0438\\u0447\\u0447\\u044f \\u0442\\u0430 \\u0432\\u0430\\u0448\\u0456 \\u043f\\u043e\\u0431\\u0430\\u0436\\u0430\\u043d\\u043d\\u044f. \\u041c\\u0438 \\u0432\\u0438\\u043a\\u043e\\u0440\\u0438\\u0441\\u0442\\u043e\\u0432\\u0443\\u0454\\u043c\\u043e \\u043b\\u0438\\u0448\\u0435 \\u0432\\u0438\\u0441\\u043e\\u043a\\u043e\\u044f\\u043a\\u0456\\u0441\\u043d\\u0456 \\u0437\\u0430\\u0441\\u043e\\u0431\\u0438 \\u0434\\u043b\\u044f \\u0443\\u043a\\u043b\\u0430\\u0434\\u0430\\u043d\\u043d\\u044f, \\u0449\\u043e \\u0437\\u0430\\u0431\\u0435\\u0437\\u043f\\u0435\\u0447\\u0443\\u044e\\u0442\\u044c \\u0434\\u043e\\u0432\\u0433\\u043e\\u0442\\u0440\\u0438\\u0432\\u0430\\u043b\\u0438\\u0439 \\u0435\\u0444\\u0435\\u043a\\u0442 \\u0456 \\u0437\\u0434\\u043e\\u0440\\u043e\\u0432\\u0438\\u0439 \\u0432\\u0438\\u0433\\u043b\\u044f\\u0434 \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f. \\u0427\\u0438 \\u0442\\u043e \\u043a\\u043b\\u0430\\u0441\\u0438\\u0447\\u043d\\u0438\\u0439 \\u0441\\u0442\\u0438\\u043b\\u044c, \\u0435\\u043b\\u0435\\u0433\\u0430\\u043d\\u0442\\u043d\\u0456 \\u043b\\u043e\\u043a\\u043e\\u043d\\u0438, \\u0447\\u0438 \\u043c\\u043e\\u0434\\u043d\\u0456 \\u0442\\u0440\\u0435\\u043d\\u0434\\u0438 &mdash; \\u043c\\u0438 \\u0433\\u043e\\u0442\\u043e\\u0432\\u0456 \\u0441\\u0442\\u0432\\u043e\\u0440\\u0438\\u0442\\u0438 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0443, \\u044f\\u043a\\u0430 \\u043f\\u0456\\u0434\\u043a\\u0440\\u0435\\u0441\\u043b\\u0438\\u0442\\u044c \\u0432\\u0430\\u0448\\u0443 \\u0456\\u043d\\u0434\\u0438\\u0432\\u0456\\u0434\\u0443\\u0430\\u043b\\u044c\\u043d\\u0456\\u0441&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0423\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0438\",\"time\":\"1741049731\"}}', 'services', 'edit', 'default', 'no', 1741049731),
(27, 5, '3', '{\"rows\":{\"id\":\"3\",\"email\":\"master@gmail.com\",\"password\":\"613ba0a0b709a943a6d5b7fcd83ecf32\",\"token\":null,\"restore_token\":null,\"role\":\"master\",\"firstname\":\"\\u041e\\u043b\\u0435\\u0433\",\"lastname\":\"Master\",\"description\":\"\",\"tel\":\"\",\"skype\":\"\",\"twitter\":\"\",\"linkedin\":\"\",\"image\":\"crop_355cee0f27a08075f131113a5c005ff3.png\",\"job_title\":\"Tester\",\"sectors\":\"\",\"locations\":\"\",\"location\":\"\",\"cv\":null,\"display_team\":\"no\",\"sort\":\"0\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_desc\":\"\",\"slug\":\"--master\",\"deleted\":\"no\",\"reg_time\":\"1581189342\",\"last_time\":\"1585141182\"}}', 'users', 'edit', 'default', 'no', 1741049748),
(28, 5, '3', '{\"rows\":{\"id\":\"3\",\"email\":\"master@gmail.com\",\"password\":\"613ba0a0b709a943a6d5b7fcd83ecf32\",\"token\":null,\"restore_token\":null,\"role\":\"master\",\"firstname\":\"\\u041e\\u043b\\u0435\\u0433\",\"lastname\":\"Master\",\"description\":\"\",\"tel\":\"\",\"skype\":\"\",\"twitter\":\"\",\"linkedin\":\"\",\"image\":\"crop_355cee0f27a08075f131113a5c005ff3.png\",\"job_title\":\"\\u0422\\u043e\\u043f \\u041c\\u0430\\u0441\\u0442\\u0435\\u0440\",\"sectors\":\"\",\"locations\":\"\",\"location\":\"\",\"cv\":null,\"display_team\":\"no\",\"sort\":\"0\",\"meta_title\":\"\",\"meta_keywords\":\"\",\"meta_desc\":\"\",\"slug\":\"--master\",\"deleted\":\"no\",\"reg_time\":\"1581189342\",\"last_time\":\"1585141182\"}}', 'users', 'edit', 'default', 'no', 1741049759),
(29, 5, '8', '{\"rows\":{\"id\":\"8\",\"title\":\"\\u0423\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0438\",\"image\":\"crop_b31dc55e10a9e67a0b3b9944a878ef2b.png\",\"file\":null,\"price\":\"150\",\"service_time\":\"0.5\",\"content\":\"&lt;p&gt;&quot;\\u0423\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0438&quot; \\u043f\\u0440\\u043e\\u043f\\u043e\\u043d\\u0443\\u0454 \\u043f\\u0440\\u043e\\u0444\\u0435\\u0441\\u0456\\u0439\\u043d\\u0435 \\u0441\\u0442\\u0432\\u043e\\u0440\\u0435\\u043d\\u043d\\u044f \\u0441\\u0442\\u0438\\u043b\\u044c\\u043d\\u0438\\u0445 \\u0442\\u0430 \\u0435\\u043b\\u0435\\u0433\\u0430\\u043d\\u0442\\u043d\\u0438\\u0445 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043e\\u043a \\u0434\\u043b\\u044f \\u0431\\u0443\\u0434\\u044c-\\u044f\\u043a\\u043e\\u0457 \\u043f\\u043e\\u0434\\u0456\\u0457. \\u041d\\u0430\\u0448\\u0456 \\u0434\\u043e\\u0441\\u0432\\u0456\\u0434\\u0447\\u0435\\u043d\\u0456 \\u0441\\u0442\\u0438\\u043b\\u0456\\u0441\\u0442\\u0438 \\u0434\\u043e\\u043f\\u043e\\u043c\\u043e\\u0436\\u0443\\u0442\\u044c \\u043f\\u0456\\u0434\\u0456\\u0431\\u0440\\u0430\\u0442\\u0438 \\u0456\\u0434\\u0435\\u0430\\u043b\\u044c\\u043d\\u0438\\u0439 \\u043e\\u0431\\u0440\\u0430\\u0437, \\u0432\\u0440\\u0430\\u0445\\u043e\\u0432\\u0443\\u044e\\u0447\\u0438 \\u0442\\u0438\\u043f \\u0432\\u0430\\u0448\\u043e\\u0433\\u043e \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f, \\u0444\\u043e\\u0440\\u043c\\u0443 \\u043e\\u0431\\u043b\\u0438\\u0447\\u0447\\u044f \\u0442\\u0430 \\u0432\\u0430\\u0448\\u0456 \\u043f\\u043e\\u0431\\u0430\\u0436\\u0430\\u043d\\u043d\\u044f. \\u041c\\u0438 \\u0432\\u0438\\u043a\\u043e\\u0440\\u0438\\u0441\\u0442\\u043e\\u0432\\u0443\\u0454\\u043c\\u043e \\u043b\\u0438\\u0448\\u0435 \\u0432\\u0438\\u0441\\u043e\\u043a\\u043e\\u044f\\u043a\\u0456\\u0441\\u043d\\u0456 \\u0437\\u0430\\u0441\\u043e\\u0431\\u0438 \\u0434\\u043b\\u044f \\u0443\\u043a\\u043b\\u0430\\u0434\\u0430\\u043d\\u043d\\u044f, \\u0449\\u043e \\u0437\\u0430\\u0431\\u0435\\u0437\\u043f\\u0435\\u0447\\u0443\\u044e\\u0442\\u044c \\u0434\\u043e\\u0432\\u0433\\u043e\\u0442\\u0440\\u0438\\u0432\\u0430\\u043b\\u0438\\u0439 \\u0435\\u0444\\u0435\\u043a\\u0442 \\u0456 \\u0437\\u0434\\u043e\\u0440\\u043e\\u0432\\u0438\\u0439 \\u0432\\u0438\\u0433\\u043b\\u044f\\u0434 \\u0432\\u043e\\u043b\\u043e\\u0441\\u0441\\u044f. \\u0427\\u0438 \\u0442\\u043e \\u043a\\u043b\\u0430\\u0441\\u0438\\u0447\\u043d\\u0438\\u0439 \\u0441\\u0442\\u0438\\u043b\\u044c, \\u0435\\u043b\\u0435\\u0433\\u0430\\u043d\\u0442\\u043d\\u0456 \\u043b\\u043e\\u043a\\u043e\\u043d\\u0438, \\u0447\\u0438 \\u043c\\u043e\\u0434\\u043d\\u0456 \\u0442\\u0440\\u0435\\u043d\\u0434\\u0438 &mdash; \\u043c\\u0438 \\u0433\\u043e\\u0442\\u043e\\u0432\\u0456 \\u0441\\u0442\\u0432\\u043e\\u0440\\u0438\\u0442\\u0438 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0443, \\u044f\\u043a\\u0430 \\u043f\\u0456\\u0434\\u043a\\u0440\\u0435\\u0441\\u043b\\u0438\\u0442\\u044c \\u0432\\u0430\\u0448\\u0443 \\u0456\\u043d\\u0434\\u0438\\u0432\\u0456\\u0434\\u0443\\u0430\\u043b\\u044c\\u043d\\u0456\\u0441&lt;\\/p&gt;\\r\\n\",\"deleted\":\"no\",\"posted\":\"yes\",\"slug\":\"\\u0423\\u043a\\u043b\\u0430\\u0434\\u043a\\u0430 \\u0437\\u0430\\u0447\\u0456\\u0441\\u043a\\u0438\",\"time\":\"1741049895\"}}', 'services', 'edit', 'default', 'no', 1741049895);

-- --------------------------------------------------------

--
-- Структура таблицы `email_logs`
--

CREATE TABLE `email_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `entity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'send',
  `token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `time` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `guests`
--

CREATE TABLE `guests` (
  `id` int(10) UNSIGNED NOT NULL,
  `ip` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `time` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `guests`
--

INSERT INTO `guests` (`id`, `ip`, `browser`, `referer`, `count`, `time`) VALUES
(1, '2130706433', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', '', 146, 1741096728);

-- --------------------------------------------------------

--
-- Структура таблицы `last_uploaded_images`
--

CREATE TABLE `last_uploaded_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `last_uploaded_images`
--

INSERT INTO `last_uploaded_images` (`id`, `image`) VALUES
(1, '71ae1ef10e90925aaa70b54bb778c9a5.webp'),
(2, '9446b47c0e93c9402c19e81cde823a61.webp'),
(3, 'f0a4e7936d2434457a24bde0402a3f18.png'),
(4, 'f11535683da7f028cd5129a20aaa204b.png'),
(5, 'f732a124878fb0a940242bbad149836e.png'),
(6, '27bbcd9ac712485074b12e25b6a70183.png'),
(7, 'c80dcabcfe3f847803dd3ce217ec697e.png'),
(8, '48e5abb0d331fdb58319180e0556ced7.png'),
(9, 'd9905f39803c5926d9023bc8668afda6.png'),
(10, '2e74bf874284b623789a4a2aae3f3dc4.png'),
(11, '128d978553d1041c21d5b1814fe7d6fc.png'),
(12, '41ab243d4b7337f42c435b94cad46041.webp');

-- --------------------------------------------------------

--
-- Структура таблицы `logs`
--

CREATE TABLE `logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `where` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `error` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('mysql','php') COLLATE utf8mb4_unicode_ci DEFAULT 'mysql',
  `time` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `where`, `error`, `status`, `time`) VALUES
(8, 5, 'page/zapis_service', 'Table &#039;l_sklo.orders&#039; doesn&#039;t exist\n &lt;br&gt;&lt;b&gt;Query:&lt;/b&gt; INSERT INTO `orders` (`selectedTime`, `selectedDate`, `shop_id`, `user_id`, `service_id`, `time`) VALUES (&#039;15:00&#039;, &#039;08.03.2025&#039;, &#039;2&#039;, &#039;3&#039;, &#039;2&#039;, &#039;1741209975&#039;);', 'mysql', '21:26:15, 05.03.2025');

-- --------------------------------------------------------

--
-- Структура таблицы `modules`
--

CREATE TABLE `modules` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `version` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `visible` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `modules`
--

INSERT INTO `modules` (`id`, `name`, `version`, `visible`, `time`) VALUES
(1, 'page', '4', 'no', 1741044333),
(2, 'panel/settings', '1', 'no', 1741044333),
(3, 'panel/content_pages', '0', 'no', 1741044334),
(4, 'panel/shops', '1', 'no', 1741044334),
(5, 'panel', '0', 'no', 1741044342),
(6, 'panel/settings/dashboard', '1', 'no', 1741047898),
(7, 'panel/vacancies', '0', 'no', 1741047898),
(8, 'panel/analytics', '0', 'no', 1741047899),
(9, 'panel/services', '1', 'no', 1741047902),
(10, 'panel/team', '1', 'no', 1741047904),
(11, 'panel/vacancies/sectors', '0', 'no', 1741047933),
(12, 'panel/orders', '0', 'no', 1741210323);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `selectedTime` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selectedDate` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shop_id` int(10) NOT NULL,
  `service_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `client_id` int(10) DEFAULT NULL,
  `status` enum('new','done','conflict') COLLATE utf8mb4_unicode_ci DEFAULT 'new',
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `name`, `tel`, `email`, `selectedTime`, `selectedDate`, `shop_id`, `service_id`, `user_id`, `client_id`, `status`, `deleted`, `time`) VALUES
(1, '', '', NULL, '13:00', '06.03.2025', 1, 2, 3, NULL, 'new', 'no', 1741213830),
(2, 'test', '38 0(66) 341-75-95', '', '11:30', '06.03.2025', 2, 2, 3, NULL, 'new', 'no', 1741214367);

-- --------------------------------------------------------

--
-- Структура таблицы `redirects`
--

CREATE TABLE `redirects` (
  `id` int(10) UNSIGNED NOT NULL,
  `uri_from` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri_to` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `time` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `refer_friend`
--

CREATE TABLE `refer_friend` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `friend_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `friend_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `tel` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `friend_tel` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sectors`
--

CREATE TABLE `sectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `service_time` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `posted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'yes',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services`
--

INSERT INTO `services` (`id`, `title`, `image`, `file`, `price`, `service_time`, `content`, `deleted`, `posted`, `slug`, `time`) VALUES
(1, 'Стрижка(фейд)', 'f11535683da7f028cd5129a20aaa204b.png', NULL, 450, '1', '&lt;p&gt;Ця послуга включає стрижку ножицями, з елементом &laquo;fade&raquo; (плавний перехід з &laquo;0&raquo;), а також миття голови та укладка волосся за Вашим бажанням&lt;/p&gt;\r\n', 'no', 'yes', 'Стрижка(фейд)', 1741049301),
(2, 'Стрижка (класика)', 'f732a124878fb0a940242bbad149836e.png', NULL, 400, '1', '&lt;p&gt;Ця послуга включає стрижку ножицями, збоку використовуються насадки від 1.5 до 13мм, а також миття голови та укладка волосся за Вашим бажанням&lt;/p&gt;\r\n', 'no', 'yes', 'Стрижка (класика)', 1741049351),
(3, 'Стрижка машинкою (фейд)', '27bbcd9ac712485074b12e25b6a70183.png', NULL, 350, '1', '&lt;p&gt;Ця послуга включає стрижку насадкою від 4,5 до 13мм, з елементом &laquo;fade&raquo; (плавний перехід з &laquo;0&raquo;), а також миття голови за Вашим бажанням&lt;/p&gt;\r\n', 'no', 'yes', 'Стрижка машинкою (фейд)', 1741049399),
(4, 'Стрижка машинкою (класика)', 'c80dcabcfe3f847803dd3ce217ec697e.png', NULL, 350, '0.5', '&lt;p&gt;Ця послуга включає стрижку насадкою до 13мм, збоку для стрижки використовуються насадка від 1,5 до 13мм, а також миття голови за Вашим бажанням&lt;/p&gt;\r\n', 'no', 'yes', 'Стрижка машинкою (класика)', 1741049433),
(5, 'Дитяча стрижка', '48e5abb0d331fdb58319180e0556ced7.png', NULL, 350, '1', '&lt;p&gt;Будь-яка дитяча стрижка, за винятком подовженої (довжина волосся збоку перевищує 2см), для вибору подовженої стрижки, оберіть &laquo;Авторська подовжена стрижка&raquo;&lt;/p&gt;\r\n', 'no', 'yes', 'Дитяча стрижка', 1741049570),
(6, 'Оформлення бороди з голінням', 'd9905f39803c5926d9023bc8668afda6.png', NULL, 300, '0.5', '&lt;p&gt;Ця послуга включає стрижку бороди будь-якої довжини,надання форми, усунення зайвого волосся, що стирчить, перехід на скронях та контури, з голінням небезпечним лезом&lt;/p&gt;\r\n', 'no', 'yes', 'Оформлення бороди з голінням', 1741049564),
(7, 'Оформлення бороди без гоління', '2e74bf874284b623789a4a2aae3f3dc4.png', NULL, 300, '0.5', '&lt;p&gt;Ця послуга включає стрижку бороди будь-якої довжини,надання форми, усунення зайвого волосся, що стирчить, перехід на скронях та контури, без гоління небезпечним лезом&lt;/p&gt;\r\n', 'no', 'yes', 'Оформлення бороди без гоління', 1741049556),
(8, 'Укладка зачіски', 'crop_b31dc55e10a9e67a0b3b9944a878ef2b.png', NULL, 150, '0.5', '&lt;p&gt;&quot;Укладка зачіски&quot; пропонує професійне створення стильних та елегантних зачісок для будь-якої події. Наші досвідчені стилісти допоможуть підібрати ідеальний образ, враховуючи тип вашого волосся, форму обличчя та ваші побажання. Ми використовуємо лише високоякісні засоби для укладання, що забезпечують довготривалий ефект і здоровий вигляд волосся. Чи то класичний стиль, елегантні локони, чи модні тренди &mdash; ми готові створити зачіску, яка підкреслить вашу індивідуальніс&lt;/p&gt;\r\n', 'no', 'yes', 'Укладка зачіски', 1741049895);

-- --------------------------------------------------------

--
-- Структура таблицы `services_sectors`
--

CREATE TABLE `services_sectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `services_users`
--

CREATE TABLE `services_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `services_users`
--

INSERT INTO `services_users` (`id`, `service_id`, `user_id`) VALUES
(10, 1, 3),
(11, 2, 3),
(12, 3, 3),
(13, 4, 3),
(14, 5, 3),
(15, 6, 3),
(16, 7, 3),
(17, 8, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`name`, `title`, `value`) VALUES
('admin_mail', 'admin_mail', 'dev7emailsender@gmail.com'),
('cms_image', 'cms_image', ''),
('cms_logo', 'cms_logo', '41ab243d4b7337f42c435b94cad46041.webp'),
('favicon', 'favicon', ''),
('noreply_mail', 'noreply_mail', 'sklo@cms.loc'),
('noreply_name', 'noreply_name', 'CMS'),
('statistics_time', 'statistics_time', '1741106004'),
('test_mode', 'test_mode', 'yes'),
('test_mode_email', 'test_mode_email', ''),
('title_prefix', 'title_prefix', '');

-- --------------------------------------------------------

--
-- Структура таблицы `shops`
--

CREATE TABLE `shops` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_time` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_to` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_from` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_link` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `posted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'yes',
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `shops`
--

INSERT INTO `shops` (`id`, `title`, `image`, `file`, `work_time`, `time_to`, `time_from`, `address`, `address_link`, `content`, `deleted`, `posted`, `slug`, `time`) VALUES
(1, 'Папа+Син Segedska', 'crop_24e53ee9b3a213e6f835ef824e8ba00f.jpg', NULL, '', '22:00', '10:00', 'Месячный, 2', 'https://g.co/kgs/x8me6Hz', '&lt;p&gt;Наш барбершоп &mdash; это место, где стиль и традиции встречаются с современными трендами. Мы создаем не просто стрижки, а подчеркиваем индивидуальность каждого клиента. Атмосфера уюта и брутальности, профессиональные барберы, качественные средства для ухода &mdash; всё для того, чтобы ты чувствовал себя уверенно. Добро пожаловать в пространство настоящего мужского ухода!&lt;/p&gt;\r\n', 'no', 'yes', 'papa-sin-segedska', 1741048956),
(2, 'Папа+сын Ген.Петрова', 'crop_66c8fcd68b98925cb81139f028b184e0.jpg', NULL, '', '22:00', '10:00', 'Генерала Петрова, 61', 'https://g.co/kgs/gjLTExK', '&lt;p&gt;Наш барбершоп &mdash; это место, где стиль и традиции встречаются с современными трендами. Мы создаем не просто стрижки, а подчеркиваем индивидуальность каждого клиента. Атмосфера уюта и брутальности, профессиональные барберы, качественные средства для ухода &mdash; всё для того, чтобы ты чувствовал себя уверенно. Добро пожаловать в пространство настоящего мужского ухода!&lt;/p&gt;\r\n', 'no', 'yes', 'papa-syn-gen-petrova', 1741048939);

-- --------------------------------------------------------

--
-- Структура таблицы `shops_sectors`
--

CREATE TABLE `shops_sectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sitemap`
--

CREATE TABLE `sitemap` (
  `id` int(10) UNSIGNED NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `sitemap`
--

INSERT INTO `sitemap` (`id`, `link`) VALUES
(1, 'shops/{slug}'),
(2, 'barber/{slug}'),
(3, 'zapis');

-- --------------------------------------------------------

--
-- Структура таблицы `subscribers`
--

CREATE TABLE `subscribers` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `sectors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `restore_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('unconfirmed','user','moder','master','admin','superadmin') COLLATE utf8mb4_unicode_ci DEFAULT 'unconfirmed',
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tel` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `skype` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `twitter` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `linkedin` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `job_title` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sectors` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `locations` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `cv` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_team` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `sort` int(10) DEFAULT 0,
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `meta_keywords` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `reg_time` int(10) UNSIGNED NOT NULL,
  `last_time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `token`, `restore_token`, `role`, `firstname`, `lastname`, `description`, `tel`, `skype`, `twitter`, `linkedin`, `image`, `job_title`, `sectors`, `locations`, `location`, `cv`, `display_team`, `sort`, `meta_title`, `meta_keywords`, `meta_desc`, `slug`, `deleted`, `reg_time`, `last_time`) VALUES
(1, 'user@gmail.com', '0cef1fb10f60529028a71f58e54ed07b', NULL, NULL, 'user', 'Alex', 'Userov', NULL, '', '', '', '', '', 'Developers', '', '', '', NULL, 'no', 0, '', '', '', 'tom-wild', 'no', 1581189342, 1585141182),
(2, 'admin@gmail.com', 'fb6dfc7542d4cf878dc958024bd14ef3', NULL, NULL, 'admin', 'Admin', 'Admin', NULL, '', '', '', '', '', 'Manager', '', '', '', NULL, 'no', 0, '', '', '', 'manager-manager', 'no', 1581189342, 1585141182),
(3, 'master@gmail.com', '613ba0a0b709a943a6d5b7fcd83ecf32', NULL, NULL, 'master', 'Олег', 'Master', '', '', '', '', '', 'crop_355cee0f27a08075f131113a5c005ff3.png', 'Топ Мастер', '', '', '', NULL, 'no', 0, '', '', '', '--master', 'no', 1581189342, 1585141182),
(4, 'manager@gmail.com', '24af45f1feb24889340909b0aa890f38', NULL, NULL, 'moder', 'Manager', 'Manager', NULL, '', '', '', '', '', 'Front', '', '', '', NULL, 'no', 0, '', '', '', 'front-front', 'no', 1581189342, 1585141182),
(5, 'back@gmail.com', 'dd786b6e50cdf8c5773e2125f3423d2d', NULL, NULL, 'superadmin', 'Back', 'Back', NULL, '', '', '', '', '', 'Back', '', '', '', NULL, 'no', 0, '', '', '', 'back-back', 'no', 1581189342, 1741290590);

-- --------------------------------------------------------

--
-- Структура таблицы `users_session`
--

CREATE TABLE `users_session` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `scope` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `session` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `created` int(10) UNSIGNED NOT NULL,
  `updated` int(10) UNSIGNED NOT NULL,
  `ip` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_session`
--

INSERT INTO `users_session` (`id`, `user_id`, `scope`, `session`, `status`, `created`, `updated`, `ip`) VALUES
(1, 5, 'user', '0abdd2bf33f254fe76011c1c9f5b692d', 1, 1741044510, 1741044510, '127.0.0.1'),
(2, 5, 'user', '6a281bb863505acb186f867e8f5665ce', 1, 1741044520, 1741044520, '127.0.0.1'),
(3, 5, 'user', '81068a88c2e9a24871b28d1c17d191ea', 1, 1741044807, 1741044807, '127.0.0.1'),
(4, 5, 'user', 'f4249d89bc66f77adadf7a7064502aaf', 1, 1741045967, 1741045967, '127.0.0.1'),
(5, 5, 'user', '09d5a8d1db3d5acb28ca8384e7f68bac', 1, 1741046024, 1741046024, '127.0.0.1'),
(6, 5, 'user', '85f944fa7f043031583782c40c8dee88', 1, 1741046123, 1741046123, '127.0.0.1'),
(7, 5, 'user', '5555ca7539220c9f5cf329937b9e3951', 1, 1741046357, 1741046357, '127.0.0.1'),
(8, 5, 'user', '786472c299964b1516a3a0969cc481e8', 1, 1741046359, 1741046359, '127.0.0.1'),
(9, 5, 'user', '1edbb545473c6d5cf38f27e5045a77c8', 1, 1741046360, 1741046360, '127.0.0.1'),
(10, 5, 'user', 'fe3304221c2374d825bd92b4c9cae4bd', 1, 1741046366, 1741046366, '127.0.0.1'),
(11, 5, 'user', '61067620d2152e1ea038ef9ce6b3a9dc', 1, 1741046372, 1741046372, '127.0.0.1'),
(12, 5, 'user', 'c0043c15adcba59369ac3803ba98ff16', 1, 1741046467, 1741046467, '127.0.0.1'),
(13, 5, 'user', 'e8f885a3caa896a782d939af0c406433', 1, 1741046471, 1741046471, '127.0.0.1'),
(14, 5, 'user', '679cf163d4aa172f9532db51affacbb7', 1, 1741046578, 1741046578, '127.0.0.1'),
(15, 5, 'user', 'efba676f0233a90719b347f7682b6d1d', 1, 1741046715, 1741046715, '127.0.0.1'),
(16, 5, 'user', '92e0f642cfeab71756040f5fbf86b829', 1, 1741046902, 1741046902, '127.0.0.1'),
(17, 5, 'user', '537a4fc8d3be825df038d12fee4ed27e', 1, 1741047053, 1741047053, '127.0.0.1'),
(18, 5, 'user', 'fe56fec3510c8971e8987217174886a9', 1, 1741047257, 1741047257, '127.0.0.1'),
(19, 5, 'user', '9980722a32153a8d5534ecb38488e279', 1, 1741047536, 1741047536, '127.0.0.1'),
(20, 5, 'user', 'c598af1a018bbab11a4d0f954898a81d', 1, 1741047610, 1741047610, '127.0.0.1'),
(21, 5, 'user', '48ab4597e4cb1d57dcc9fe066ce26574', 0, 1741047898, 1741047898, '127.0.0.1'),
(22, 5, 'user', '30fa95ee2ae31dfb8a6683fd3dae3d60', 0, 1741047982, 1741047982, '127.0.0.1'),
(23, 5, 'user', '5505d9a8180adf1ab1a0a464abbf2f74', 1, 1741096728, 1741096728, '127.0.0.1');

-- --------------------------------------------------------

--
-- Структура таблицы `users_shops`
--

CREATE TABLE `users_shops` (
  `id` int(10) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users_shops`
--

INSERT INTO `users_shops` (`id`, `shop_id`, `user_id`) VALUES
(2, 2, 3),
(3, 1, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `user_images`
--

CREATE TABLE `user_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancies`
--

CREATE TABLE `vacancies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ref` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contract_type` enum('permanent','temporary','contract') COLLATE utf8mb4_unicode_ci DEFAULT 'permanent',
  `salary_value` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `meta_keywords` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `meta_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `consultant_id` int(10) UNSIGNED DEFAULT 0,
  `content_short` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `internal` tinyint(2) UNSIGNED NOT NULL DEFAULT 0,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expire_alert` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `expire_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `posted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'yes',
  `deleted` enum('no','yes') COLLATE utf8mb4_unicode_ci DEFAULT 'no',
  `views` int(10) UNSIGNED DEFAULT 0,
  `slug` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `time_expire` int(10) UNSIGNED NOT NULL,
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancies_analytics`
--

CREATE TABLE `vacancies_analytics` (
  `id` int(10) UNSIGNED NOT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT 0,
  `user_id` int(10) UNSIGNED DEFAULT 0,
  `ref` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `referrer` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancies_locations`
--

CREATE TABLE `vacancies_locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `vacancy_id` int(10) UNSIGNED NOT NULL,
  `location_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancies_referrers`
--

CREATE TABLE `vacancies_referrers` (
  `id` int(10) UNSIGNED NOT NULL,
  `vacancy_id` int(10) UNSIGNED DEFAULT 0,
  `title` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `count` int(10) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `vacancies_sectors`
--

CREATE TABLE `vacancies_sectors` (
  `id` int(10) UNSIGNED NOT NULL,
  `vacancy_id` int(10) UNSIGNED NOT NULL,
  `sector_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `actions_logs`
--
ALTER TABLE `actions_logs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `alt_attributes`
--
ALTER TABLE `alt_attributes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `content_pages_tree`
--
ALTER TABLE `content_pages_tree`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cv_library`
--
ALTER TABLE `cv_library`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `dashboard_settings`
--
ALTER TABLE `dashboard_settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `data_versions`
--
ALTER TABLE `data_versions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `email_logs`
--
ALTER TABLE `email_logs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip` (`ip`);

--
-- Индексы таблицы `last_uploaded_images`
--
ALTER TABLE `last_uploaded_images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `redirects`
--
ALTER TABLE `redirects`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `refer_friend`
--
ALTER TABLE `refer_friend`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Индексы таблицы `services_sectors`
--
ALTER TABLE `services_sectors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `services_users`
--
ALTER TABLE `services_users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `shops`
--
ALTER TABLE `shops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Индексы таблицы `shops_sectors`
--
ALTER TABLE `shops_sectors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sitemap`
--
ALTER TABLE `sitemap`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users_session`
--
ALTER TABLE `users_session`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session` (`session`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users_shops`
--
ALTER TABLE `users_shops`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_images`
--
ALTER TABLE `user_images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vacancies`
--
ALTER TABLE `vacancies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slug` (`slug`);

--
-- Индексы таблицы `vacancies_analytics`
--
ALTER TABLE `vacancies_analytics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `entity_id` (`entity_id`);

--
-- Индексы таблицы `vacancies_locations`
--
ALTER TABLE `vacancies_locations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vacancies_referrers`
--
ALTER TABLE `vacancies_referrers`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `vacancies_sectors`
--
ALTER TABLE `vacancies_sectors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `actions_logs`
--
ALTER TABLE `actions_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `alt_attributes`
--
ALTER TABLE `alt_attributes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `content_pages_tree`
--
ALTER TABLE `content_pages_tree`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `cv_library`
--
ALTER TABLE `cv_library`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `dashboard_settings`
--
ALTER TABLE `dashboard_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `data_versions`
--
ALTER TABLE `data_versions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT для таблицы `email_logs`
--
ALTER TABLE `email_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `guests`
--
ALTER TABLE `guests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `last_uploaded_images`
--
ALTER TABLE `last_uploaded_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `redirects`
--
ALTER TABLE `redirects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `refer_friend`
--
ALTER TABLE `refer_friend`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `services_sectors`
--
ALTER TABLE `services_sectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `services_users`
--
ALTER TABLE `services_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `shops`
--
ALTER TABLE `shops`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `shops_sectors`
--
ALTER TABLE `shops_sectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `sitemap`
--
ALTER TABLE `sitemap`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users_session`
--
ALTER TABLE `users_session`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT для таблицы `users_shops`
--
ALTER TABLE `users_shops`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `user_images`
--
ALTER TABLE `user_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vacancies`
--
ALTER TABLE `vacancies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vacancies_analytics`
--
ALTER TABLE `vacancies_analytics`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vacancies_locations`
--
ALTER TABLE `vacancies_locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vacancies_referrers`
--
ALTER TABLE `vacancies_referrers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `vacancies_sectors`
--
ALTER TABLE `vacancies_sectors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;
-- Створення таблиці для обліку відвідувань працівників
CREATE TABLE IF NOT EXISTS `attendance` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `shop_id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `hours_worked` decimal(4,2) DEFAULT NULL,
  `status` enum('present','absent','late','holiday','sick') COLLATE utf8mb4_unicode_ci DEFAULT 'present',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_attendance` (`user_id`, `date`),
  KEY `user_id` (`user_id`),
  KEY `shop_id` (`shop_id`),
  KEY `date` (`date`),
  KEY `status` (`status`),
  CONSTRAINT `fk_attendance_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_attendance_shop` FOREIGN KEY (`shop_id`) REFERENCES `shops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Додаємо індекс для швидкого пошуку
CREATE INDEX `idx_attendance_lookup` ON `attendance` (`user_id`, `date`, `status`);

-- Тригер для автоматичного розрахунку відпрацьованих годин
DELIMITER $$
CREATE TRIGGER `calculate_hours_worked` 
BEFORE UPDATE ON `attendance`
FOR EACH ROW
BEGIN
    IF NEW.check_in IS NOT NULL AND NEW.check_out IS NOT NULL THEN
        SET NEW.hours_worked = TIMESTAMPDIFF(MINUTE, NEW.check_in, NEW.check_out) / 60;
    END IF;
END$$
DELIMITER ;

-- Приклад даних для тестування
INSERT INTO `attendance` (`user_id`, `shop_id`, `date`, `check_in`, `check_out`, `hours_worked`, `status`) VALUES
(3, 1, '2025-03-07', '2025-03-07 09:05:00', '2025-03-07 18:30:00', 9.42, 'present'),
(1, 1, '2025-03-07', '2025-03-07 10:00:00', '2025-03-07 19:00:00', 9.00, 'present'),
(2, 2, '2025-03-07', '2025-03-07 09:55:00', '2025-03-07 18:45:00', 8.83, 'present'),
(3, 1, '2025-03-06', '2025-03-06 10:15:00', '2025-03-06 19:00:00', 8.75, 'late'),
(1, 1, '2025-03-06', '2025-03-06 10:00:00', '2025-03-06 18:30:00', 8.50, 'present'),
(2, 2, '2025-03-06', NULL, NULL, NULL, 'absent');

-- Представлення для звітності
CREATE VIEW `v_attendance_report` AS
SELECT 
    a.id,
    a.date,
    u.firstname,
    u.lastname,
    CONCAT(u.firstname, ' ', u.lastname) as full_name,
    u.job_title,
    s.title as shop_name,
    a.check_in,
    a.check_out,
    a.hours_worked,
    a.status,
    CASE 
        WHEN a.check_in > CONCAT(a.date, ' 10:00:00') THEN 'late'
        ELSE 'on_time'
    END as punctuality,
    a.notes
FROM attendance a
JOIN users u ON a.user_id = u.id
JOIN shops s ON a.shop_id = s.id
WHERE u.deleted = 'no'
ORDER BY a.date DESC, a.check_in DESC;

-- Функція для отримання статистики за період
DELIMITER $$
CREATE FUNCTION `get_attendance_stats`(
    p_user_id INT,
    p_date_from DATE,
    p_date_to DATE
) RETURNS JSON
READS SQL DATA
BEGIN
    DECLARE v_stats JSON;
    
    SELECT JSON_OBJECT(
        'total_days', COUNT(DISTINCT date),
        'present_days', SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END),
        'absent_days', SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END),
        'late_days', SUM(CASE WHEN status = 'late' OR (check_in > CONCAT(date, ' 10:00:00')) THEN 1 ELSE 0 END),
        'total_hours', COALESCE(SUM(hours_worked), 0),
        'avg_hours_per_day', COALESCE(AVG(hours_worked), 0)
    ) INTO v_stats
    FROM attendance
    WHERE user_id = p_user_id
    AND date BETWEEN p_date_from AND p_date_to;
    
    RETURN v_stats;
END$$
DELIMITER ;
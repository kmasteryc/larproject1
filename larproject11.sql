-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2016 at 02:13 PM
-- Server version: 5.7.12
-- PHP Version: 7.0.5-2+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `larproject11`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(10) UNSIGNED NOT NULL,
  `artist_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `artist_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `artist_info` text COLLATE utf8_unicode_ci NOT NULL,
  `artist_birthday` date NOT NULL,
  `artist_gender` int(11) NOT NULL,
  `artist_nation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `artist_title`, `artist_name`, `artist_info`, `artist_birthday`, `artist_gender`, `artist_nation`) VALUES
(1, 'AAAAAAAAAAAAAAAAAAAAA', 'AAAAAAAAAAAAAAAAAAAAA', 'AAAAAAAAAAAAAAAAAAAAA', '1111-11-11', 1, 84);

-- --------------------------------------------------------

--
-- Table structure for table `artist_song`
--

CREATE TABLE `artist_song` (
  `id` int(10) UNSIGNED NOT NULL,
  `artist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `artist_song`
--

INSERT INTO `artist_song` (`id`, `artist_id`, `song_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cates`
--

CREATE TABLE `cates` (
  `id` int(10) UNSIGNED NOT NULL,
  `cate_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cate_parent` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cates`
--

INSERT INTO `cates` (`id`, `cate_title`, `cate_parent`, `created_at`, `updated_at`) VALUES
(3, 'Nhac khong loi', 3, NULL, NULL),
(4, 'VIỆT NAM', 0, NULL, NULL),
(5, 'ÂU MỸ', 0, NULL, NULL),
(6, 'CHÂU Á', 0, NULL, NULL),
(7, 'HÒA TẤU', 0, NULL, NULL),
(8, 'Nhạc trẻ', 4, NULL, NULL),
(9, 'Nhạc trữ tình', 4, NULL, NULL),
(10, 'Dance Việt', 4, NULL, NULL),
(11, 'Rock Việt', 4, NULL, NULL),
(12, 'Rap/Hip hop Việt', 4, NULL, NULL),
(13, 'Nhạc trịnh', 4, NULL, NULL),
(14, 'Nhạc thiếu nhi', 4, NULL, NULL),
(15, 'Pop', 5, NULL, NULL),
(16, 'Rock', 5, NULL, NULL),
(17, 'Rap / Hip Hop', 5, NULL, NULL),
(18, 'Country', 5, NULL, NULL),
(19, 'Electronic', 5, NULL, NULL),
(20, 'R & B', 5, NULL, NULL),
(21, 'Hàn Quốc', 6, NULL, NULL),
(22, 'Nhật Bản', 6, NULL, NULL),
(23, 'Hoa ngữ', 6, NULL, NULL),
(24, 'Thải Lan', 6, NULL, NULL),
(25, 'Classical', 7, NULL, NULL),
(26, 'Piano', 7, NULL, NULL),
(27, 'Guitar', 7, NULL, NULL),
(28, 'Violin', 7, NULL, NULL),
(29, 'Cello', 7, NULL, NULL),
(30, 'Nhạc cụ dân tộc', 7, NULL, NULL),
(31, 'TỔNG HỢP', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(10) UNSIGNED NOT NULL,
  `image_path` text COLLATE utf8_unicode_ci NOT NULL,
  `imageable_id` int(10) UNSIGNED NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_path`, `imageable_id`, `imageable_type`, `created_at`, `updated_at`) VALUES
(9, 'http://larproject1.app/uploads/imgs/45d58b312c97531c18e0f7725317ef2a_1459137761.jpg', 13, 'App\\Playlist', '2016-05-28 11:13:26', '2016-05-28 11:13:26');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2016_05_27_143826_create_users', 1),
('2016_05_27_151707_create_artist', 1),
('2016_05_27_151726_create_cates', 1),
('2016_05_27_151745_create_songs', 1),
('2016_05_27_151828_create_playlists', 1),
('2016_05_27_152914_create_artists_songs', 1),
('2016_05_27_152930_create_playlists_songs', 1),
('2016_05_28_040815_create_images', 2);

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE `playlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `playlist_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `playlist_view` int(11) NOT NULL DEFAULT '0',
  `cate_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlist_song`
--

CREATE TABLE `playlist_song` (
  `id` int(10) UNSIGNED NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `song_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `playlist_song`
--

INSERT INTO `playlist_song` (`id`, `playlist_id`, `song_id`, `created_at`, `updated_at`) VALUES
(2, 7, 3, NULL, NULL),
(3, 7, 4, NULL, NULL),
(9, 8, 4, NULL, NULL),
(10, 8, 3, NULL, NULL),
(11, 6, 3, NULL, NULL),
(12, 6, 4, NULL, NULL),
(13, 9, 3, NULL, NULL),
(14, 10, 4, NULL, NULL),
(15, 12, 4, NULL, NULL),
(23, 13, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(10) UNSIGNED NOT NULL,
  `song_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `song_mp3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `song_view` int(11) NOT NULL DEFAULT '0',
  `cate_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `level`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 2, 'admin@admin.com', '$2y$10$v/u/jJnAwkDtJwsL5HCxVuajAKr7LRQucY2n2mbswpmUDIh6FIQxa', 'JjsR0wc4Nm4DGPVMrpre66J5gGU6lh15vdchSIHCLXq3qAcvwXtUikjQlewO', '2016-05-27 17:01:16', '2016-05-28 03:50:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `artist_song`
--
ALTER TABLE `artist_song`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cates`
--
ALTER TABLE `cates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playlists_cate_id_foreign` (`cate_id`),
  ADD KEY `playlists_user_id_foreign` (`user_id`);

--
-- Indexes for table `playlist_song`
--
ALTER TABLE `playlist_song`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `songs_cate_id_foreign` (`cate_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `artist_song`
--
ALTER TABLE `artist_song`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cates`
--
ALTER TABLE `cates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `playlists`
--
ALTER TABLE `playlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `playlist_song`
--
ALTER TABLE `playlist_song`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_cate_id_foreign` FOREIGN KEY (`cate_id`) REFERENCES `cates` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `playlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `songs`
--
ALTER TABLE `songs`
  ADD CONSTRAINT `songs_cate_id_foreign` FOREIGN KEY (`cate_id`) REFERENCES `cates` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

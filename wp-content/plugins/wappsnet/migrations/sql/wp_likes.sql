SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE `wp_likes` (
  `id` int(11) NOT NULL,
  `like_key` varchar(255) NOT NULL,
  `items` text NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `wp_likes`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `wp_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
CREATE TABLE `wp_cart` (
  `id` int(11) NOT NULL,
  `cart_key` varchar(255) NOT NULL,
  `items` text NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `wp_cart` ADD PRIMARY KEY (`id`);
ALTER TABLE `wp_cart` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

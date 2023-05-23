-- Adminer 4.8.0 MySQL 5.5.5-10.5.17-MariaDB-1:10.5.17+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `added_on`) VALUES
(1,	'Foo Fang Woei',	'foofangwoei@gmail.com',	'$2y$10$0hLsdtQcpMY.xw.fKc7yFeqCZaxdZj3mMnDm/BNQyopfTtYPCwJHu',	'2023-05-23 04:46:29'),
(2,	'rabbit',	'rabbit@gmail.com',	'$2y$10$ccZkjW3amba6e1m.kiIWw.DIN7TAxUrLdw8W2IemhHV4ozkxNzjLG',	'2023-05-23 04:57:34'),
(3,	'John',	'john@gmail.com',	'$2y$10$eB.GO4KGa/SMjAu8Ovkn3uTALkQmQnwhtjWSSslruA1bj7rFMVnue',	'2023-05-23 05:02:01'),
(4,	'Foo',	'fangwoei22f@forwardschool.edu.my',	'$2y$10$WWxAYMXaclbMpRjy7N0nPOwklXyYtSnj9q8n5L0jSohavFB9i151C',	'2023-05-23 05:11:12'),
(5,	'Jack',	'jack@gmail.com',	'$2y$10$H4r32aNuwvEHsWzRhWHe2u3ZbeZtbe.9MuSyrm5BgEY.xL4NnzSwy',	'2023-05-23 05:12:25'),
(6,	'Jane',	'jane@gmail.com',	'$2y$10$0tvU9pPX9zFMhqsVCXohX.wx7/r8sIEgxPQQUsMErLRw0dJeCSYpC',	'2023-05-23 05:43:21'),
(7,	'S',	's@s.com',	'$2y$10$ZUj4uMFBpfqgHTfZnE6PbOm9G8zUAvWKqUsxZx5T8ScitwAU466we',	'2023-05-23 06:08:35'),
(8,	'Rex Yap Wei Chung',	'rexyapweichuang@hotmail.com',	'$2y$10$mwk66MyK/aP0JVa.7ipeJ.7UuzK1TI/TkZEuGMfGDSk3BPF.a9IAG',	'2023-05-23 07:07:27');

-- 2023-05-23 07:45:32

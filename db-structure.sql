
 SET NAMES utf8mb4 ;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;

 SET character_set_client = utf8mb4 ;
CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(180) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `text` varchar(255) NOT NULL,
  `updated` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'new',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;

SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `login` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_UN` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


 INSERT INTO users (username,login,pass) VALUES
 ('Администратор','admin','$2y$10$Hmi8lsowWGXe0vyaifs5bOI8W0Wfac7A9ivnCpVW/ytc/4LsVmYKu') -- pass: 123
 ;

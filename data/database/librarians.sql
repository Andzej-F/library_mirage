CREATE TABLE `librarians` (
  `libr_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `libr_email` varchar(64) NOT NULL,
  `libr_password` varchar(64) NOT NULL,
  PRIMARY KEY (`libr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
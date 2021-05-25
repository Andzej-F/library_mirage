--
-- 'library_mirage' database creation script
--

CREATE DATABASE IF NOT EXISTS `library_mirage`;


--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_name` varchar(64) DEFAULT '',
  `author_surname` varchar(64) DEFAULT '',
  PRIMARY KEY (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `book_title` varchar(255) NOT NULL,
  `book_author_id` int(11) unsigned NOT NULL,
  `book_genre` varchar(64) NOT NULL,
  `book_year` int(4) NOT NULL,
  `book_pages` int(4) NOT NULL,
  `book_stock` int(3) DEFAULT 0,
  `book_about` text DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  KEY `FK_BookAuthor` (`book_author_id`),
  CONSTRAINT `FK_BookAuthor` FOREIGN KEY (`book_author_id`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `acct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acct_email` varchar(64) NOT NULL,
  `acct_role` varchar(64) NOT NULL,
  `acct_passwd` varchar(64) NOT NULL,
  PRIMARY KEY (`acct_id`),
  UNIQUE KEY `acct_email` (`acct_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
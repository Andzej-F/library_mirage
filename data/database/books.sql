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
  `book_isbn` int(4) NOT NULL,
  `book_stock` int(3) DEFAULT 0,
  `book_about` text DEFAULT NULL,
  PRIMARY KEY (`book_id`),
  KEY `FK_BookAuthor` (`book_author_id`),
  CONSTRAINT `FK_BookAuthor` FOREIGN KEY (`book_author_id`) REFERENCES `authors` (`author_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
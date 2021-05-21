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
  `account_id` int(10) UNSIGNED NOT NULL,
  `account_name` varchar(255) NOT NULL,
  `account_passwd` varchar(255) NOT NULL,
  `account_reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `account_enabled` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`),
  ADD UNIQUE KEY `account_name` (`account_name`);

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Table structure for table `account_sessions`
--

CREATE TABLE `account_sessions` (
  `session_id` varchar(255) NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `account_sessions`
--
ALTER TABLE `account_sessions`
  ADD PRIMARY KEY (`session_id`);


  --
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `account_id` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`),
  ADD CONSTRAINT `FK_RoleAccount` FOREIGN KEY (`account_id`)
  REFERENCES `accounts` (`account_id`) ON DELETE CASCADE ON UPDATE CASCADE;


--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


--
-- Table structure for table `librarians`
--

CREATE TABLE `librarians` (
  `libr_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `libr_email` varchar(64) NOT NULL,
  `libr_password` varchar(64) NOT NULL,
  PRIMARY KEY (`libr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
<?php
session_start();

/* include_once the file with additional functions */
require_once '../../common.php';

/* include_once the database connection file */
require_once '../../config.php';

/* include_once the Author class file */
require_once '../classes/Book.php';

/* Create a new Book object */
$book = new Book();

/* Get book data */
try {
    $result = $book->readBook();
} catch (Exception $e) {
    $error = $e->getMessage();
}

include_once '../templates/header.php';

include_once '../templates/books_table.php';

include_once '../templates/footer.php';

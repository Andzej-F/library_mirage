<?php
session_start();

/* Include the file with additional functions */
require '../../common.php';

/* Include the database connection file */
require '../../config.php';

/* Include the Author class file */
require '../classes/Book.php';

/* Create a new Book object */
$book = new Book();

/* Create a new author */
try {
    $result = $book->readBook();
} catch (Exception $e) {
    $error = $e->getMessage();
}

include '../templates/header.php';

include '../templates/books_table.php';

include '../templates/footer.php';

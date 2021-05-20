<?php
session_start();

/* Include the file with additional functions */
require '../../common.php';

/* Include the database connection file */
require '../../config.php';

/* Include the Author class file */
require '../classes/Author.php';

/* Create a new Author object */
$author = new Author();

/* Create a new author */
try {
    $result = $author->readAuthor();
} catch (Exception $e) {
    $error = $e->getMessage();
}

include '../templates/header.php';

include '../templates/authors_table.php';

include '../templates/footer.php';

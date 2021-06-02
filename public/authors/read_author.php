<?php
session_start();

/* include_once the file with additional functions */
require_once '../../common.php';

/* include_once the database connection file */
require_once '../../config.php';

/* include_once the Author class file */
require_once '../classes/Author.php';

/* Create a new Author object */
$author = new Author();

/* Create a new author */
try {
    $result = $author->readAuthor();
} catch (Exception $e) {
    $error = $e->getMessage();
}

include_once '../templates/header.php';

include_once '../templates/authors_table.php';

include_once '../templates/footer.php';

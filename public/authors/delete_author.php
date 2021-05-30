<?php

session_start();

/* Include the file with additional functions */
require '../../common.php';

/* Include the database connection file */
require '../../config.php';

/* Include the Author class file */
require '../classes/Author.php';

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    if (isset($_GET['author_id'])) {
        /* Set initial value for $delete */
        $success = TRUE;

        /* Author id from the database  */
        $id = $_GET['author_id'];

        /* Create a new Author object */
        $author = new Author();

        /* Get deleted author's name and surname */
        $author_db = $author->getAuthorById($id);
        $name = $author_db['author_name'];
        $surname = $author_db['author_surname'];

        /* Delete the author */
        try {
            $author->deleteAuthor($id);
        } catch (Exception $e) {
            $success = FALSE;
            $error = $e->getMessage();
        }

        if ($success) {
            successAuthor($name, $surname, 'deleted');
        } else {
            showError($error);
        }
    }
}
include '../templates/header.php';

include '../templates/authors_table.php';

include '../templates/footer.php';

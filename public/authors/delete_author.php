<?php

session_start();

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    /* Include the file with additional functions */
    require '../../common.php';

    /* Include the database connection file */
    require '../../config.php';

    /* Include the Author class file */
    require '../classes/Author.php';

    if (isset($_GET['author_id'])) {
        /* Set initial value for $delete */
        $delete = TRUE;

        /* Author id from the database  */
        $id = $_GET['author_id'];

        /* Create a new Author object */
        $author = new Author();

        /* Get author's name and surname */
        $author_db = $author->getAuthorById($id);

        /* Delete the author */
        try {
            $author->deleteAuthor($id);
        } catch (Exception $e) {
            $delete = FALSE;
            $error = $e->getMessage();
        }
        if ($delete) {
            successAuthor($author_db['author_name'], $author_db['author_surname'], 'deleted');
        } else {
            showError($error);
        }
    }
}
include '../templates/header.php';

include '../templates/authors_table.php';

include '../templates/footer.php';

<?php

session_start();

/* include_once the file with additional functions */
require_once '../../common.php';

/* include_once the database connection file */
require_once '../../config.php';

/* include_once the Author class file */
require_once '../classes/Author.php';

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
include_once '../templates/header.php';

include_once '../templates/authors_table.php';

include_once '../templates/footer.php';

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

    /* Create a new Author object */
    $author = new Author();
    /* Initial value for error string  */
    $error = '';

    if (isset($_GET['author_id'])) {
        /* Author id from the database  */
        $id = $_GET['author_id'];

        /* Get author's name and surname */
        $author_db = $author->getAuthorById($_GET['author_id']);

        /* Delete a new author */
        try {
            $author->deleteAuthor($id);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        echo '<div class="success">' . escape($author_db['author_name']) . ' '
            . escape($author_db['author_surname']) . ' successfully deleted!</div>';
    }

    try {
        $result = $author->readAuthor();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    include '../templates/header.php';
    include '../templates/authors_table.php';
}
?>
<?php include '../templates/footer.php'; ?>
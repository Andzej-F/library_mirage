<?php

session_start();

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    /* Include the file with additional functions */
    require '../../common.php';

    /* Include the database connection file */
    require '../../config.php';

    /* Include the Book class file */
    require '../classes/Book.php';

    /* Create a new Book object */
    $book = new Book();
    /* Initial value for error string  */
    $error = '';

    if (isset($_GET['book_id'])) {
        /* Author id from the database  */
        $id = $_GET['book_id'];

        /* Get book's title */
        $book_db = $book->getBookById($id);

        /* Delete the book */
        try {
            $book->deleteBook($id);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        echo '<div class="success">' . escape($book_db['book_title']) . ' successfully deleted!</div>';
    }


    try {
        $result = $book->readBook();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }

    include '../templates/header.php';

    include '../templates/books_table.php';
}
?>
<?php include '../templates/footer.php'; ?>
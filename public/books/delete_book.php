<?php

session_start();

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    /* include_once the file with additional functions */
    require_once '../../common.php';

    /* include_once the database connection file */
    require_once '../../config.php';

    /* include_once the Book class file */
    require_once '../classes/Book.php';

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

    include_once '../templates/header.php';

    include_once '../templates/books_table.php';
}
?>
<?php include_once '../templates/footer.php'; ?>
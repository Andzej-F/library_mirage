<?php

require '../../config.php';

if (isset($_GET['book_id'])) {
    try {

        $book_id = ['book_id' => $_GET['book_id']];

        $sql = 'DELETE FROM books WHERE book_id= :book_id';

        $statement = $pdo->prepare($sql);
        $statement->execute($book_id);

        echo 'Book successfully deleted';
        header("Location: http://localhost/PHP/Bandymai/library_mirage/public/books/read_book.php");
        exit();
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }
}

<?php

require '../../config.php';
require '../../common.php';

if (isset($_GET['author_id'])) {
    try {

        $author_id = ['author_id' => $_GET['author_id']];

        $sql = 'DELETE FROM authors WHERE author_id= :author_id';

        $statement = $pdo->prepare($sql);
        $statement->execute($author_id);

        echo 'Author successfully deleted';
        header("Location: http://localhost/PHP/Bandymai/library_mirage/public/authors/read_author.php");
        exit();
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }
}

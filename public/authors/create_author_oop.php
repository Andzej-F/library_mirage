<?php

session_start();

/* Check if the librarian has logged in */
//$logged_in = isset($_SESSION['librarian_login']);

/* Include the database connection file */
require '../../config.php';

/* Include the additional functions file */
require '../../common.php';

/* Include the Account class file */
require './author_class.php';

/* Create a new Account object */
$author = new Author();

/* Check if the librarian has logged in */
//if ($logged_in) {

if (isset($_POST['submit'])) {

    /* Add a new author */
    try {
        $newId = $author->createAuthor($_POST['author_name'], $_POST['author_surname']);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

    echo 'The new author\'s ID is ' . $newId;

    echo escape($_POST['author_name']) . ' ' .
        escape($_POST['author_surname']) . ' successfully added';

    // $valid_author = valAuthorName($_POST['author_name']) &&
    //     valAuthorSurname($_POST['author_surname']);
    // if ($valid_author) {
    //     try {
    //         $author_data = [
    //             'author_name' => $_POST['author_name'],
    //             'author_surname' => $_POST['author_surname']
    //         ];

    //         $sql = "INSERT INTO `authors` (`author_name`, `author_surname`)
    //              VALUES (:author_name, :author_surname)";

    //         $statement = $pdo->prepare($sql);
    //         $statement->execute($author_data);
    //     } catch (PDOException $error) {
    //         echo $sql . "<br>" . $error->getMessage();
    //     }
    // }
}
// } else {
//     header('Location: http://localhost/PHP/Bandymai/library_mirage/public/index.php');
//     exit();
// }
?>

<?php require '../templates/header.php'; ?>

<?php
/*
 if (isset($_POST['submit'])) {
    if ($valid_author) {
        echo escape($_POST['author_name']) . ' ' .
            escape($_POST['author_surname']) . ' successfully added';
    }
}
*/
?>

<h2>Add a New Author</h2>
<?php include '../templates/navigation.php'; ?>

<form class="form" method="POST">
    <div class="form-input">
        <label>Name</label>
        <input type="text" name="author_name" value="<?= isset($_POST['author_name']) ? escape($_POST['author_name']) : ''; ?>">
    </div>
    <div class="form-input">
        <label>Surname</label>
        <input type="text" name="author_surname" value="<?= isset($_POST['author_surname']) ? escape($_POST['author_surname']) : ''; ?>">
    </div>
    <div class="form-input">
        <input type="submit" name="submit" value="ADD">
</form>

<?php require '../templates/footer.php'; ?>
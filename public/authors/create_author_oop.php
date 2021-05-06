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

    //TODO: create success message
    echo escape($_POST['author_name']) . ' ' .
        escape($_POST['author_surname']) . ' successfully added';
}
?>

<?php require '../templates/header.php'; ?>

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
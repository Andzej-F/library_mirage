<?php

session_start();

/* Check if the librarian has logged in */
$logged_in = isset($_SESSION['librarian_login']);

/* Check if the librarian has logged in */
if ($logged_in) {

    if (isset($_POST['submit'])) {

        /* Include the database connection file */
        require '../../config.php';

        /* Include the file with additional functions */
        require '../../common.php';

        /* Include the Author class file */
        require './author_class.php';

        /* Create a new Author object */
        $author = new Author();

        /* Create a new author */
        try {
            $author->createAuthor($_POST['author_name'], $_POST['author_surname']);
        } catch (Exception $e) {
            echo '<p class="error">' . $e->getMessage() . '</p>';
        }
    }
}
?>

<?php require '../templates/header.php'; ?>

<h2>Add a New Author</h2>
<?php include '../templates/navigation.php'; ?>

<form method="POST">
    <?php include('author_errors.php'); ?>
    <div class="input-group">
        <label>Name</label>
        <input type="text" name="author_name" value="<?= isset($_POST['author_name']) ? escape($_POST['author_name']) : ''; ?>">
    </div>
    <div class="input-group">
        <label>Surname</label>
        <input type="text" name="author_surname" value="<?= isset($_POST['author_surname']) ? escape($_POST['author_surname']) : ''; ?>">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="submit">ADD</button>
</form>

<?php require '../templates/footer.php'; ?>
<?php

session_start();

/* Include the file with additional functions */
require '../../common.php';

/* Initial value for error string  */
$error = '';

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    if (isset($_POST['submit'])) {
        /* Include the database connection file */
        require '../../config.php';

        /* Include the Author class file */
        require '../classes/Author.php';

        /* Create a new Author object */
        $author = new Author();
        /* Create a new author */
        try {
            $author->createAuthor($_POST['author_name'], $_POST['author_surname']);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}
?>

<?php require '../templates/header.php'; ?>

<h2>Add a New Author</h2>
<?php include '../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['submit'])) {
        if ($error) {
            /* Display errors */
            echo '<div class="error">' . $error . '</div>';
        } else {
            /* Display success message */
            echo '<div class="success">' . escape($author->getName()) . ' '
                . escape($author->getSurname()) . ' successfully added!</div>';

            /* Clear form input after success message */
            $_POST = [];
        }
    }
    ?>
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
    </div>
</form>

<?php require '../templates/footer.php'; ?>
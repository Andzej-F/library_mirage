<?php

session_start();

/* Include the file with additional functions */
require '../../common.php';

/* Include the database connection file */
require '../../config.php';

/* Include the Author class file */
require '../classes/Author.php';

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    if (isset($_POST['submit'])) {

        /* Set initial value */
        $create = TRUE;

        /* Create a new Author object */
        $author = new Author();

        try {
            $name = $_POST['author_name'];
            $surname = $_POST['author_surname'];

            $author->createAuthor($name, $surname);
        } catch (Exception $e) {
            $create = FALSE;
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
        if ($create) {
            /* Display success message */
            successAuthor($author->getName(), $author->getSurname(), 'added');

            /* Clear form input after success message */
            $_POST = [];
        } else {
            /* Display errors */
            showError($error);
        }
    }
    ?>
    <div class="input-group">
        <label>Name</label>
        <input type="text" name="author_name" value="<?= isset($_POST['author_name']) ? escape($name) : ''; ?>">
    </div>
    <div class="input-group">
        <label>Surname</label>
        <input type="text" name="author_surname" value="<?= isset($_POST['author_surname']) ? escape($surname) : ''; ?>">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="submit">ADD</button>
    </div>
</form>

<?php require '../templates/footer.php'; ?>
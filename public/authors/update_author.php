<?php

session_start();

/* include_once the file with additional functions */
require_once '../../common.php';

/* include_once the database connection file */
require_once '../../config.php';

/* include_once the Author class file */
require_once '../classes/Author.php';

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    $author = new Author();

    if (isset($_POST['submit'])) {
        $success = TRUE;

        $id = $_POST['author_id'];
        $name = $_POST['author_name'];
        $surname = $_POST['author_surname'];

        try {
            $author->updateAuthor($id, $name, $surname);
        } catch (Exception $e) {
            $success = FALSE;
            $error = $e->getMessage();
        }
    }
}

/* Author array from the database  */
$author_db = $author->getAuthorById($_GET['author_id']);
?>

<?php require_once '../templates/header.php'; ?>

<h2>Update the Author</h2>
<?php include_once '../templates/navigation.php'; ?>
<form method="POST">
    <?php
    if (isset($_POST['submit'])) {
        if ($success) {
            successAuthor($author->getName(), $author->getSurname(), 'updated');

            /* Clear form input after success message */
            $_POST = [];
        } else {
            showError($error);
        }
    }
    ?>
    <div class="input-group">
        <input type="hidden" name="author_id" value=" <?= $author_db['author_id']; ?>">
    </div>
    <div class="input-group">
        <label>Name</label>
        <input type="text" name="author_name" value="<?= isset($_POST['author_name']) ? escape($name) : ($author_db['author_name']); ?>">
    </div>
    <div class="input-group">
        <label>Surname</label>
    </div>
    <div class="input-group">
        <input type="text" name="author_surname" value="<?= isset($_POST['author_surname']) ? escape($surname) : ($author_db['author_surname']); ?>">
    </div>

    <div class="input-group">
        <button type="submit" class="btn" name="submit">UPDATE</button>
    </div>
</form>

<?php require_once '../templates/footer.php'; ?>
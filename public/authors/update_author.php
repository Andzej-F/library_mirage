<?php

session_start();

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    /* Include the file with additional functions */
    require '../../common.php';

    /* Include the database connection file */
    require '../../config.php';

    /* Include the Author class file */
    require '../classes/Author.php';

    /* Create a new Author object */
    $author = new Author();

    /* Initial value for error string  */
    $error = '';

    if (isset($_POST['submit'])) {

        try {
            $author->updateAuthor($_POST['author_id'], $_POST['author_name'], $_POST['author_surname']);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

/* Author array from the database  */
$author_db = $author->getAuthorById($_GET['author_id']);
?>

<?php require '../templates/header.php'; ?>

<h2>Update the Author</h2>
<?php include '../templates/navigation.php'; ?>
<form method="POST">
    <?php
    if (isset($_POST['submit'])) {
        if ($error) {
            /* Display error */
            echo '<div class="error">' . $error . '</div>';
        } else {
            /* Display success message */
            echo '<div class="success">' . escape($author->getName()) . ' '
                . escape($author->getSurname()) . ' successfully updated!</div>';
        }
    }
    ?>
    <div class="input-group">
        <input type="hidden" name="author_id" value=" <?= $author_db['author_id']; ?>">
    </div>
    <div class="input-group">
        <label>Name</label>
        <input type="text" name="author_name" value="<?= isset($_POST['author_name']) ? escape($_POST['author_name']) : ($author_db['author_name']); ?>">
    </div>
    <div class="input-group">
        <label>Surname</label>
    </div>
    <div class="input-group">
        <input type="text" name="author_surname" value="<?= isset($_POST['author_surname']) ? escape($_POST['author_surname']) : ($author_db['author_surname']); ?>">
    </div>

    <div class="input-group">
        <button type="submit" class="btn" name="submit">Update</button>
    </div>
</form>

<?php require '../templates/footer.php'; ?>
<?php

session_start();

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

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
        // try {
        //     $author->createAuthor($_POST['author_name'], $_POST['author_surname']);
        // } catch (Exception $e) {
        //     echo '<p class="error">' . $e->getMessage() . '</p>';
        // }

        /* Create a new author */
        $author->createAuthor($_POST['author_name'], $_POST['author_surname']);

        if (count($author->errors) > 0) { ?>
            <div class="error">
                <?php foreach ($author->errors as $error) : ?>
                    <p><?php echo $error ?></p>
                <?php endforeach; ?>
            </div>
<?php } else {
            echo '<div class="success">' . $name . ' ' . $surname . ' successfully added!</div>';

            /* Clear form input after success message */
            $_POST = [];
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
    </div>
</form>

<?php require '../templates/footer.php'; ?>
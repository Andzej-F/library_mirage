<?php

session_start();

/* Include the file with additional functions */
require '../../common.php';

/* Initial value for error string  */
$error = '';

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    /* Include the database connection file */
    require '../../config.php';

    /* Include the Author class file */
    require '../classes/Author.php';

    /* Include the Book class file */
    require '../classes/Book.php';
    if (isset($_POST['submit'])) {

        /* Create a new Book object */
        $book = new Book();
        /* Create a new book */
        try {
            $book->createBook(
                $_POST['book_title'],
                $_POST['book_author_id'],
                $_POST['book_genre'],
                $_POST['book_year'],
                $_POST['book_pages'],
                $_POST['book_stock'],
                $_POST['book_about']
            );
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
    /* Authors array from the database  */
    $author = new Author();
    $authors = $author->readAuthor();
}
?>

<?php require '../templates/header.php'; ?>

<h2>Add a New Book</h2>
<?php include '../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['submit'])) {
        if ($error) {
            /* Display errors */
            echo '<div class="error">' . $error . '</div>';
        } else {
            /* Display success message */
            echo '<div class="success">' . escape($book->getTitle()) . ' successfully added!</div>';

            /* Clear form input after success message */
            $_POST = [];
        }
    }
    ?>
    <div class="input-group">
        <label>Title</label>
        <input type="text" name="book_title" value="<?= isset($_POST['book_title']) ? escape($_POST['book_title']) : ''; ?>">
    </div>
    <div class="input-group">
        <label>Genre</label>
        <input type="text" name="book_genre" value="<?= isset($_POST['book_genre']) ? escape($_POST['book_genre']) : ''; ?>">
    </div>
    <div class="input-group">
        <label>Year</label>
        <input type="text" name="book_year" value="<?= isset($_POST['book_year']) ? escape($_POST['book_year']) : ''; ?>">
    </div>
    <div class="input-group">
        <label>Pages</label>
        <input type="text" name="book_pages" value="<?= isset($_POST['book_pages']) ? escape($_POST['book_pages']) : ''; ?>">
    </div>
    <div class="input-group">
        <label>Stock</label>
        <input type="text" name="book_stock" value="<?= isset($_POST['book_stock']) ? escape($_POST['book_stock']) : ''; ?>">
    </div>
    <div class="input-group">
        <label>About</label>
        <textarea name="book_about" value="<?= isset($_POST['book_about']) ? escape($_POST['book_about']) : ''; ?>"></textarea>
    </div>
    <div class="input-group">
        <label>Choose the author</label>
        <select name="book_author_id">
            <?php
            if (is_array($authors)) {
                foreach ($authors as $author) { ?>
                    <option value="<?php echo escape($author['author_id']); ?>">
                        <?php echo escape($author['author_name']) . ' ' . escape($author['author_surname']); ?></option>
            <?php }
            } ?>
        </select>
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="submit">ADD</button>
    </div>
</form>

<?php include '../templates/footer.php'; ?>
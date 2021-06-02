<?php

session_start();

/* Check if the librarian has logged in */
if (isset($_SESSION['libr_login'])) {

    /* include_once the file with additional functions */
    require_once '../../common.php';

    /* include_once the database connection file */
    require_once '../../config.php';

    /* include_once the Book class file */
    require_once '../classes/Book.php';

    /* include_once the Author class file */
    require_once '../classes/Author.php';

    /* Create a new Book object */
    $book = new Book();

    /* Initial value for error string  */
    $error = '';

    if (isset($_POST['submit'])) {

        try {
            $book->updateBook(
                $_POST['book_id'],
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
}

/* Authors array from the database  */
$author = new Author();
$authors = $author->readAuthor();

/* Author array from the database  */
$book_db = $book->getBookById($_GET['book_id']);
?>

<?php require_once '../templates/header.php'; ?>

<h2>Update the Book</h2>

<?php include_once '../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['submit'])) {
        if ($error) {
            /* Display error */
            echo '<div class="error">' . $error . '</div>';
        } else {
            /* Display success message */
            echo '<div class="success">' . escape($book->getTitle()) . ' successfully updated!</div>';
        }
    }
    ?>
    <form method="POST">
        <input type="hidden" name="book_id" value="<?= $book_db['book_id']; ?>">
        <div class="input-group">
            <label>Title</label>
            <input type="text" name="book_title" value="<?= escape($book_db['book_title']); ?>"><br>
        </div>
        <div class="input-group">
            <label>Genre</label>
            <input type="text" name="book_genre" value="<?= escape($book_db['book_genre']); ?>"><br>
        </div>
        <div class="input-group">
            <label>Year</label>
            <input type="text" name="book_year" value="<?= escape($book_db['book_year']); ?>"><br>
        </div>
        <div class="input-group">
            <label>Pages</label>
            <input type="text" name="book_pages" value="<?= escape($book_db['book_pages']); ?>"><br>
        </div>
        <div class="input-group">
            <label>Stock</label>
            <input type="text" name="book_stock" value="<?= escape($book_db['book_stock']); ?>"><br>
        </div>
        <div class="input-group">
            <label>About</label>
            <textarea name="book_about"><?= escape($book_db['book_about']); ?></textarea><br>
        </div>
        <div class="input-group">
            <label>Choose the author</label>
            <select name="book_author_id">
                <?php if (is_array($authors)) { ?>
                    <?php foreach ($authors as $author) { ?>
                        <option value="<?= $author['author_id']; ?>">
                            <?= $author['author_name'] . ' ' . $author['author_surname']; ?></option>
                <?php }
                } ?>
            </select>
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="submit">UPDATE</button>
        </div>
    </form>

    <?php include_once '../templates/footer.php';

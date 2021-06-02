<?php

session_start();

/* include_once the file with additional functions */
require_once '../../common.php';

/* include_once the database connection file */
require_once '../../config.php';

/* include_once the Author class file */
require_once '../classes/Author.php';

/* include_once the Book class file */
require_once '../classes/Book.php';

/* Check if the librarian has logged in */
if ($librLogged || $readerLogged) {


    if (isset($_GET['search_btn'])) {

        /* Set default values */
        $results = NULL;
        $error = NULL;

        /* Create a new Book object */
        $book = new Book();

        $search = $_GET['search_input'];

        try {
            $results = $book->searchBook($search);
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

require_once '../templates/header.php'; ?>

<h2>Books</h2>

<?php include_once '../templates/navigation.php'; ?>

<?php
if (isset($_GET['search_btn'])) {
    if ($results) { ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <?php if ($librLogged) : ?>
                        <th>Update</th>
                        <th>Delete</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($results as $result) : ?>
                        <td>
                            <?= escape($result['book_title']); ?>
                        </td>
                        <td>
                            <?= escape($result['author_name']); ?>
                            <?= escape($result['author_surname']); ?>
                        </td>
                        <?php if ($librLogged) : ?>
                            <td><a href="../books/update_book.php?book_id=<?= escape($result['book_id']); ?>">UPDATE</a></td>
                            <td><a href="../books/delete_book.php?book_id=<?= escape($result['book_id']); ?>">DELETE</a></td>
                        <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
<?php
    } elseif ($error) {
        showError($error);
        header("Refresh:1; url=$address/index.php");
    } else {
        echo '<div class="error">No results found</div>';
        header("Refresh:1; url=$address/index.php");
    }
}
?>
<?php include_once '../templates/footer.php'; ?>
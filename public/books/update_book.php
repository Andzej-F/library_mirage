<?php
session_start();

require "../../config.php";
require "../../common.php";
require "./validate_book.php";

if (isset($_POST['submit'])) {
    $valid_book = valTitle($_POST['book_title']) &&
        valGenre($_POST['book_genre']) &&
        valYear($_POST['book_year']) &&
        valPages($_POST['book_pages']) &&
        valISBN($_POST['book_isbn']) &&
        valStock($_POST['book_stock']) &&
        valAbout($_POST['book_about']);

    if ($valid_book) {
        try {
            $update_book = [
                'book_id' => $_POST['book_id'],
                'book_title' => $_POST['book_title'],
                'book_author_id' => $_POST['book_author_id'],
                'book_genre' => $_POST['book_genre'],
                'book_year' => $_POST['book_year'],
                'book_pages' => $_POST['book_pages'],
                'book_isbn' => $_POST['book_isbn'],
                'book_stock' => $_POST['book_stock'],
                'book_about' => $_POST['book_about']
            ];

            $sql = "UPDATE `books`
                SET `book_id` = :book_id,
                    `book_title` = :book_title,
                    `book_author_id` = :book_author_id,                  
                    `book_genre` = :book_genre,
                    `book_year` = :book_year,
                    `book_pages` = :book_pages,
                    `book_isbn` = :book_isbn,
                    `book_stock` = :book_stock,
                    `book_about` = :book_about
                WHERE `book_id` = :book_id";

            $statement = $pdo->prepare($sql);
            $statement->execute($update_book);
        } catch (PDOException $error) {
            echo 'Query error: ' . $error->getMessage();
            exit();
        }
        echo escape($_POST['book_title']) . ' successfully updated';
    }
}

if (isset($_GET['book_id'])) {
    try {

        $book_id = $_GET['book_id'];

        $sql = "SELECT * FROM `books` 
	            INNER JOIN `authors`
                ON `books`.`book_author_id`=`authors`.`author_id`
                WHERE `book_id`=:book_id";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':book_id', $book_id);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }

    /* Create authors dropdown list */
    try {
        $sql = "SELECT * FROM authors WHERE 1";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $authors = $statement->fetchAll();
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }
} else {
    echo 'Something went wrong!';
    exit();
}
require "../templates/header.php";

?>

<h2>Update the Book</h2>
<?php include '../templates/navigation.php'; ?>
<form class="form" action="" method="POST">
    <input type="hidden" name="book_id" value="<?php echo $result['book_id']; ?>">
    <div class="form-input">
        <label>Title</label>
        <input type="text" name="book_title" value="<?php echo escape($result['book_title']); ?>"><br>
    </div>
    <div class="form-input">
        <label>Genre</label>
        <input type="text" name="book_genre" value="<?php echo escape($result['book_genre']); ?>"><br>
    </div>
    <div class="form-input">
        <label>Year</label>
        <input type="text" name="book_year" value="<?php echo escape($result['book_year']); ?>"><br>
    </div>
    <div class="form-input">
        <label>Pages</label>
        <input type="text" name="book_pages" value="<?php echo escape($result['book_pages']); ?>"><br>
    </div>
    <div class="form-input">
        <label>ISBN</label>
        <input type="text" name="book_isbn" value="<?php echo escape($result['book_isbn']); ?>"><br>
    </div>
    <div class="form-input">
        <label>Stock</label>
        <input type="text" name="book_stock" value="<?php echo escape($result['book_stock']); ?>"><br>
    </div>
    <div class="form-input">
        <label>About</label>
        <textarea name="book_about"><?php echo escape($result['book_about']); ?></textarea><br>
    </div>
    <div class="form-input">
        <label>Choose an author</label>
        <select name="book_author_id">
            <?php if ($statement->rowCount() > 0) { ?>
                <?php foreach ($authors as $author) { ?>
                    <option value="<?php echo $author['author_id']; ?>">
                        <?php echo $author['author_name'] . ' ' . $author['author_surname']; ?></option>
            <?php }
            } ?>
        </select>
    </div>
    <input type="submit" name="submit" value="Update">
</form>

<?php include '../templates/footer.php';

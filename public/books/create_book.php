 <?php
    session_start();
    $logged_in = isset($_SESSION['librarian_login']);

    require "../../config.php";
    require "../../common.php";
    require "validate_book.php";

    if ($logged_in) {

        if (isset($_POST['submit'])) {
            if (validBook()) {
                try {
                    $new_book = [
                        'book_title' => $_POST['book_title'],
                        'book_author_id' => $_POST['book_author_id'],
                        'book_genre' => $_POST['book_genre'],
                        'book_year' => $_POST['book_year'],
                        'book_pages' => $_POST['book_pages'],
                        'book_isbn' => $_POST['book_isbn'],
                        'book_stock' => $_POST['book_stock'],
                        'book_about' => escape($_POST['book_about'])
                    ];

                    $sql = "INSERT INTO `books`(
                    `book_title`,
                    `book_author_id`,
                    `book_genre`,
                    `book_year`,
                    `book_pages`,
                    `book_isbn`,
                    `book_stock`,
                    `book_about`)
                    VALUES (:book_title,
                    :book_author_id,
                    :book_genre,
                    :book_year,
                    :book_pages,
                    :book_isbn,
                    :book_stock,
                    :book_about)";
                    $statement = $pdo->prepare($sql);
                    $statement->execute($new_book);
                } catch (PDOException $error) {
                    echo 'Query error: ' . $error->getMessage();
                    exit();
                }
            }
        }
    } else {
        header('refresh:1, url=http://localhost/PHP/Bandymai/library_mirage/public/index.php');
        exit();
    }

    try {
        $sql = "SELECT * FROM `authors` WHERE 1";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $authors = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }
    ?>

 <?php require "../templates/header.php";

    if (isset($_POST['submit'])) {
        if (validBook()) {
            echo escape($_POST['book_title']) . ' successfully added';
        }
    }
    ?>

 <h2>Add a New Book</h2>

 <form class="form" action="http://localhost/PHP/Bandymai/library_mirage/public/books/create_book.php" method="POST">
     <div class="form-input">
         <label>Title</label>
         <input type="text" name="book_title" value="<?= isset($_POST['book_title']) ? escape($_POST['book_title']) : ''; ?>">
     </div>
     <div class="form-input">
         <label>Genre</label>
         <input type="text" name="book_genre" value="<?= isset($_POST['book_genre']) ? escape($_POST['book_genre']) : ''; ?>">
     </div>
     <div class="form-input">
         <label>Year</label>
         <input type="text" name="book_year" value="<?= isset($_POST['book_year']) ? escape($_POST['book_year']) : ''; ?>">
     </div>
     <div class="form-input">
         <label>Pages</label>
         <input type="text" name="book_pages" value="<?= isset($_POST['book_pages']) ? escape($_POST['book_pages']) : ''; ?>">
     </div>
     <div class="form-input">
         <label>ISBN</label>
         <input type="text" name="book_isbn" value="<?= isset($_POST['book_isbn']) ? escape($_POST['book_isbn']) : ''; ?>">
     </div>
     <div class="form-input">
         <label>Stock</label>
         <input type="text" name="book_stock" value="<?= isset($_POST['book_stock']) ? escape($_POST['book_stock']) : ''; ?>">
     </div>
     <div class="form-input">
         <label>About</label>
         <textarea name="book_about" value="<?= isset($_POST['book_about']) ? escape($_POST['book_about']) : ''; ?>"></textarea>
     </div>
     <div class="form-input">
         <label>Choose the author</label>
         <select name="book_author_id">
             <?php
                if ($statement->rowCount() > 0) {
                    foreach ($authors as $author) { ?>
                     <option value="<?php echo escape($author['author_id']); ?>">
                         <?php echo escape($author['author_name']) . ' ' . escape($author['author_surname']); ?></option>
             <?php }
                } ?>
         </select>
     </div>
     <div class="form-input">
         <input class="form-input-submit" type="submit" name="submit" value="ADD">
     </div>
 </form>

 <a href="../index.php">Back to home</a>

 <?php include '../templates/footer.php'; ?>
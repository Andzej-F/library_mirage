    <?php

    session_start();
    $logged_in = isset($_SESSION['librarian_login']);

    require '../../config.php';
    require '../../common.php';

    if ($logged_in) {
        if (isset($_GET['submit_search'])) {
            try {
                $search = escape($_GET['search']);
                $sql = "SELECT `book_id`,`book_title`, `author_name`, `author_surname`
                    FROM `books`
                    INNER JOIN `authors` ON `books`.`book_author_id`=`authors`.`author_id`
                    WHERE `book_title`LIKE :search
                    OR `author_name` LIKE :search
                    OR `author_surname` LIKE :search";

                $statement = $pdo->prepare($sql);
                $statement->bindValue(':search', '%' . $search . '%');
                $statement->execute();
                $results = $statement->fetchAll();
            } catch (PDOException $error) {
                echo 'Query error: ' . $error->getMessage();
                exit();
            }
        } else {
            echo "No results found";
            exit();
        }
    }
    require '../templates/header.php';
    if ($results && ($statement->rowCount() > 0)) { ?>
        <h2>Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <?php if ($logged_in) : ?>
                        <th>Update</th>
                        <th>Delete</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php foreach ($results as $result) : ?>
                        <td>
                            <?php echo escape($result['book_title']); ?>
                        </td>
                        <td>
                            <?php echo escape($result['author_name']); ?>
                            <?php echo escape($result['author_surname']); ?>
                        </td>
                        <?php if ($logged_in) : ?>
                            <td><a href="../books/update.php?book_id=<?php echo escape($result['book_id']); ?>">UPDATE</a></td>
                            <td><a href="../books/delete.php?book_id=<?php echo escape($result['book_id']); ?>">DELETE</a></td>
                        <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "No results found";
    }
    ?>

    <a href="../index.php">Back to home</a>

    <?php include '../templates/footer.php'; ?>
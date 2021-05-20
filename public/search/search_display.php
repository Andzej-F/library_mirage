    <?php

    session_start();

    require '../../config.php';
    require '../../common.php';

    if (isset($_SESSION['libr_login'])) {
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
        <?php include '../templates/navigation.php'; ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <?php if (isset($_SESSION['libr_login'])) : ?>
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
                        <?php if (isset($_SESSION['libr_login'])) : ?>
                            <td><a href="../books/update_book.php?book_id=<?= escape($result['book_id']); ?>">UPDATE</a></td>
                            <td><a href="../books/delete_book.php?book_id=<?= escape($result['book_id']); ?>">DELETE</a></td>
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
    <?php include '../templates/footer.php'; ?>
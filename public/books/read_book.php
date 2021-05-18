    <?php
    session_start();

    require '../../config.php';
    require '../../common.php';

    try {

        $sql = "SELECT `book_id`, `book_title`, `author_name`, `author_surname` 
                FROM `books` 
	            INNER JOIN `authors`
                ON `books`.`book_author_id`=`authors`.`author_id`";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }

    require '../templates/header.php';

    if ($results && $statement->rowCount() > 0) { ?>
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
                            <td><a href="./update_book.php?book_id=<?php echo $result['book_id']; ?>">UPDATE</a></td>
                            <td><a href="./delete_book.php?book_id=<?php echo $result['book_id']; ?>">DELETE</a></td>
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
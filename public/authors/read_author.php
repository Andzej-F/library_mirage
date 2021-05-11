    <?php
    session_start();
    $logged_in = isset($_SESSION['librarian_login']);

    require '../../common.php';
    require '../../config.php';

    try {
        $sql = "SELECT * FROM `authors` WHERE 1";
        $statement = $pdo->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }

    include '../templates/header.php';

    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Authors</h2>
        <?php include '../templates/navigation.php'; ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <?php if ($logged_in) : ?>
                        <th>Update</th>
                        <th>Delete</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?= escape($row['author_name']); ?></td>
                        <td><?= escape($row['author_surname']); ?></td>
                        <?php
                        if ($logged_in) : ?>
                            <td><a href="./update_author.php?author_id=<?php echo $row['author_id']; ?>">UPDATE</a></td>
                            <td><a href="./delete_author.php?author_id=<?php echo $row['author_id']; ?>">DELETE</a></td>
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
    <?php
    /* Display authors array */
    $result = $author->readAuthor();

    if (is_array($result)) { ?>
        <h2>Authors</h2>
        <?php include '../templates/navigation.php'; ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <?php if (isset($_SESSION['libr_login'])) : ?>
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
                        if (isset($_SESSION['libr_login'])) : ?>
                            <td><a href="./update_author.php?author_id=<?= $row['author_id']; ?>">UPDATE</a></td>
                            <td><a href="./delete_author.php?author_id=<?= $row['author_id']; ?>">DELETE</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php
    }

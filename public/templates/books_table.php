<?php
if (is_array($result)) { ?>
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
                <?php foreach ($result as $row) : ?>
                    <td>
                        <?= escape($row['book_title']); ?>
                    </td>
                    <td>
                        <?= escape($row['author_name']); ?>
                        <?= escape($row['author_surname']); ?>
                    </td>
                    <?php if (isset($_SESSION['libr_login'])) : ?>
                        <td><a href="./update_book.php?book_id=<?= $row['book_id']; ?>">UPDATE</a></td>
                        <td><a href="./delete_book.php?book_id=<?= $row['book_id']; ?>">DELETE</a></td>
                    <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php
}

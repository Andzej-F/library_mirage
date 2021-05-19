<?php
session_start();

require '../../config.php';
require '../../common.php';
require 'validate_author.php';

if (isset($_POST['submit'])) {
    $valid_author = valAuthorName($_POST['author_name']) &&
        valAuthorSurname($_POST['author_surname']);
    if ($valid_author) {
        try {
            $author = [
                'author_id' => $_POST['author_id'],
                'author_name' => $_POST['author_name'],
                'author_surname' => $_POST['author_surname']
            ];

            $sql = "UPDATE `authors` 
                SET author_id=:author_id,
                author_name=:author_name,
                author_surname=:author_surname
                WHERE author_id=:author_id";

            $statement = $pdo->prepare($sql);
            $statement->execute($author);
        } catch (PDOException $error) {
            echo 'Query error: ' . $error->getMessage();
            exit();
        }
    }
}

if (isset($_GET['author_id'])) {
    try {
        $author_id = $_GET['author_id'];

        $sql = "SELECT * FROM authors WHERE author_id=:author_id";

        $statement = $pdo->prepare($sql);
        $statement->bindValue(':author_id', $author_id);
        $statement->execute();

        $author = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $error) {
        echo 'Query error: ' . $error->getMessage();
        exit();
    }
} else {
    echo 'Something went wrong!';
    exit;
}
?>

<?php require '../templates/header.php'; ?>

<?php if (isset($_POST['submit']) && $statement) {
    if ($valid_author) {
        echo escape($_POST['author_name']) . ' ' .
            escape($_POST['author_surname']) . ' successfully updated';
        header('Refresh:1, url= http://localhost/PHP/Bandymai/library_mirage/public/authors/read_author.php');
        exit();
    }
} ?>

<h2>Update the Author</h2>
<?php include '../templates/navigation.php'; ?>

<form method="POST">
    <div class="input-group">
        <input type="hidden" name="author_id" value="<?php echo escape($author['author_id']); ?>">
    </div>
    <div class="input-group">
        <label>Name</label>
        <input type="text" name="author_name" value="<?php echo escape($author['author_name']); ?>">
    </div>
    <div class="input-group">
        <label>Surname</label>
    </div>
    <div class="input-group">
        <input type="text" name="author_surname" value="<?php echo escape($author['author_surname']); ?>">
    </div>

    <div class="input-group">
        <button type="submit" class="btn" name="submit">Update</button>
    </div>
</form>

<?php require '../templates/footer.php'; ?>
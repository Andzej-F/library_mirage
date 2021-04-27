<?php
session_start();

require '../../config.php';
require './librarian_validation.php';

if (isset($_SESSION['librarian_login'])) {
    header('Location: http://localhost/PHP/Bandymai/book_shop/public/index.php');
    exit();
}

if (isset($_POST['btn_login'])) {
    $input_email = $_POST["input_email"];
    $input_password = $_POST["input_password"];

    if (valLibrLogin($input_email, $input_password)) {
        try {
            $sql = 'SELECT * FROM `librarians`
                    WHERE `libr_email`=:input_email';

            $select_stmt = $pdo->prepare($sql);
            $select_stmt->bindParam(':input_email', $input_email);

            $select_stmt->execute();
            $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

            if ($select_stmt->rowCount() > 0) {

                $dbemail = $row['libr_email'];
                $dbpassword = $row['libr_password'];

                if (($input_email == $dbemail) &&
                    (password_verify($input_password, $dbpassword))
                ) {
                    $_SESSION['librarian_login'] = $input_email;
                    $loginMsg = 'Librarian... Successfully Login...';
                    header('refresh:1; url=http://localhost/PHP/Bandymai/library_mirage/public/index.php');
                } else {
                    $errorMsg[] = 'Wrong email or password<br>';
                }
            } else {
                $errorMsg[] = 'Wrong email or password<br>';
            }
        } catch (PDOException $error) {
            echo 'Database connection error<br>';
        }
    } else {
        $errorMsg[] = 'Wrong email or password';
    }
}

if (isset($errorMsg)) {
    foreach ($errorMsg as $error) {
        echo $error;
    }
}

if (isset($loginMsg)) {
    echo $loginMsg;
}

?>

<?php include '../templates/header.php'; ?>

<form class="form-login" method="post">
    <label class="form-login-label">Email</label>
    <input class="form-login-input-text" type="text" name="input_email" placeholder="Enter email"><br>
    <label class="form-login-label">Password</label>
    <input class="form-login-input-password" type="password" name="input_password" placeholder="Enter password">
    <input class="form-login-input-submit" type="submit" name="btn_login" value="Login"><br><br>
</form>

<a class=".form-login" href="../index.php">Back to home</a>

<?php include '../templates/footer.php'; ?>
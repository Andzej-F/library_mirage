<?php
session_start();

require '../../config.php';
require './librarian_validation.php';

if (isset($_SESSION['libr_login'])) {
    header("Location: $address/index.php");
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
                    $_SESSION['libr_login'] = $input_email;
                    $loginMsg = 'Librarian... Successfully Login...';
                    header("refresh:1; url=$address/index.php");
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

<h2>Login</h2>

<?php include '../templates/navigation.php'; ?>

<form class="form-login" method="post">
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="input_email" placeholder="Enter email"><br>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="input_password" placeholder="Enter password">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="btn_login">Log In</button>
    </div>
</form>

<?php include '../templates/footer.php'; ?>
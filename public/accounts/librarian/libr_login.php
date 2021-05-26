<?php

session_start();

/* Include the file with additional functions */
require '../../../common.php';

/* Initial value for error string  */
$error = '';

/* Include the database connection file */
require '../../../config.php';

/* Include the account class file */
require '../../classes/Account.php';

/* Create a new account object */
$account = new Account();

if (isset($_POST['login'])) {
    try {
        $account->login($_POST['email'], $_POST['passwd']);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<?php require '../../templates/header.php'; ?>

<h2>Librarian Login</h2>

<?php include '../../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['login'])) {
        if ($error) {

            /* Display error */
            echo '<div class="error">' . $error . '</div>';
        } else {

            /* Display success message */
            echo '<div class="success">' . escape($account->getEmail()) .
                ' successfully logged in!</div>';

            /* Clear form input after success message */
            $_POST = [];
        }
    }
    ?>
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="email" value="<?= isset($_POST['email']) ? escape($_POST['email']) : ''; ?>" placeholder="Enter email"><br>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="passwd" placeholder="Enter password">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="login">Log In</button>
    </div>
</form>


<?php require '../../templates/footer.php';

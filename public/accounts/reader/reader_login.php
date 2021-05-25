<?php

session_start();

/* Include the file with additional functions */
require '../../../common.php';

/* Initial value for error string  */
$error = '';


if (isset($_POST['login_btn'])) {

    /* Include the database connection file */
    require '../../../config.php';

    /* Include the account class file */
    require '../../classes/Account.php';

    /* Create a new account object */
    $account = new Account();

    try {
        $account->login($_POST['log_email'], $_POST['log_passwd']);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

?>

<?php require '../../templates/header.php'; ?>

<h2>Reader Login</h2>

<?php include '../../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['login_btn'])) {
        if ($error) {
            /* Display error */
            echo '<div class="error">' . $error . '</div>';
        } else {
            /* Display success message */
            echo '<div class="success">' . escape($account->getEmail()) . ' successfully logged in!</div>';
            /* Clear form input after success message */
            $_POST = [];
        }
    }
    ?>
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="log_email" value="<?= isset($_POST['log_email']) ? escape($_POST['log_email']) : ''; ?>" placeholder="Enter email"><br>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="log_passwd" placeholder="Enter password">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="login_btn">Log In</button>
    </div>
</form>


<?php require '../../templates/footer.php';

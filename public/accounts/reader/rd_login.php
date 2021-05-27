<?php

session_start();

/* Include the file with additional functions */
require '../../../common.php';

/* Include the database connection file */
require '../../../config.php';

/* Include the account class file */
require '../../classes/Account.php';

/* Create a new account object */
$account = new Account();

if (isset($_POST['login'])) {
    try {
        /* $login will be assigned TRUE on success */
        $login = $account->login($_POST['log_email'], $_POST['log_passwd']);
    } catch (Exception $e) {
        /* If there is an error, assign FALSE to $login */
        $login = FALSE;
        $error = $e->getMessage();
    }
}
?>

<?php require '../../templates/header.php'; ?>

<h2>Reader Login</h2>

<?php require '../../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['login'])) {
        if ($login) {
            /* Display success message */
            showSuccess($account->getEmail(), 'logged in');

            /* Redirect to the main page */
            header("Refresh:2; url= $address/index.php");
        } else {
            /* Display error message */
            showError($error);
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
        <button type="submit" class="btn" name="login">Log In</button>
    </div>
</form>

<?php require '../../templates/footer.php'; ?>
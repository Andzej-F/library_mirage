<?php

session_start();

/* Include the file with additional functions */
require '../../../common.php';

/* Include the database connection file */
require '../../../config.php';

/* Include the account class file */
require '../../classes/Account.php';

$account = new Account();

if (isset($_POST['login'])) {

    $login = TRUE;

    try {
        $account->login($_POST['email'], $_POST['passwd']);
    } catch (Exception $e) {
        $login = FALSE;
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

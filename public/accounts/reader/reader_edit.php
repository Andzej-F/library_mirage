<?php
session_start();

require '../../../common.php';

/* Include the Account class file */
require '../../classes/Account.php';

/* Include the database connection file */
require '../../../config.php';

/* Create a new Account object */
$account = new Account();

// 2. Edit an account. Try passing invalid parameters to test error messages.
if (isset($_GET['edit'])) {
    if (isset($_POST['edit_btn'])) {

        $id = $_SESSION['account_id'];
        $newEmail = $_POST['new_email'];
        $newPasswd = $_POST['new_pass'];

        try {
            $account->editAccount($id, $newEmail, $newPasswd);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
        // $_SESSION['success'] = 'Account edit successful.';
        // unset($_GET['edit']);
        // header("Location: $address/login/reader_home.php");
        // exit();
    }
}
include '../../templates/header.php'; ?>

<h2>Edit Account</h2>

<?php include '../../templates/navigation.php'; ?>

<form method="post">
    <?php
    if (isset($_POST['reg_btn'])) {
        if ($error) {
            /* Display error */
            echo '<div class="error">' . $error . '</div>';
        } else {
            /* Display success message */
            echo '<div class="success">' . escape($account->getEmail()) . ' successfully changed in!</div>';
            /* Clear form input after success message */
            $_POST = [];
        }
    }
    ?>
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="new_email"><br>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="new_pass">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="edit_btn">EDIT</button>
    </div>
</form>

<?php include '../../templates/footer.php';

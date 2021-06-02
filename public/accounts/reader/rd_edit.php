<?php
session_start();

/* include_once a file with common functions */
require_once '../../../common.php';

/* include_once the Account class file */
require_once '../../classes/Account.php';

/* include_once the database connection file */
require_once '../../../config.php';

/* Create a new Account object */
$account = new Account();

if (isset($_POST['edit'])) {

    $edit = TRUE;

    $id = $_SESSION['acct_id'];
    $newEmail = $_POST['new_email'];
    $newPasswd = $_POST['new_pass'];

    try {
        $account->editAccount($id, $newEmail, $newPasswd);
    } catch (Exception $e) {
        $edit = FALSE;
        $error = $e->getMessage();
    }
}

include_once '../../templates/header.php'; ?>

<h2>Edit Account</h2>

<?php include_once '../../templates/navigation.php'; ?>

<form method="post">
    <?php
    if (isset($_POST['edit'])) {
        if ($edit) {
            showSuccess($account->getEmail(), 'edited');
        } else {
            showError($error);
        }
    }
    ?>
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="new_email" value="<?= isset($_POST['new_email']) ? escape($_POST['new_email']) : escape($_SESSION['reader_login']); ?>" placeholder="Enter new email"><br>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="new_pass" placeholder="Enter new password">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="edit">EDIT</button>
    </div>
</form>

<?php include_once '../../templates/footer.php';

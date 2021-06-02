<?php
session_start();

/* include_once the file with additional functions */
require_once '../../../common.php';

/* include_once the Account class file */
require_once '../../classes/Account.php';

/* include_once the database connection file */
require_once '../../../config.php';

$account = new Account();

if (isset($_POST['register'])) {

    $register = TRUE;

    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    try {
        /* Save account id in Session array */
        $_SESSION['acct_id'] = $account->addAccount($email, $passwd, 'reader');
    } catch (Exception $e) {
        $register = FALSE;
        $error = $e->getMessage();
    }
}
include_once '../../templates/header.php'; ?>

<h2>Reader Registration</h2>

<?php include_once '../../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['register'])) {
        if ($register) {
            showSuccess($account->getEmail(), 'registered');
            header("Refresh:2; url= $address/index.php");
        } else {
            showError($error);
        }
    }
    ?>
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="email" value="<?= isset($_POST['email']) ? escape($_POST['email']) : ''; ?>" placeholder="Enter email" placeholder="Enter Email"><br>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="passwd" placeholder="Enter password">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="register">Register</button>
    </div>
</form>

<?php include_once '../../templates/footer.php'; ?>
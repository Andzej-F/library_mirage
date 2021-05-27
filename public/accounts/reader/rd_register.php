<?php
session_start();

/* Include the file with additional functions */
require '../../../common.php';

/* Include the Account class file */
require '../../classes/Account.php';

/* Include the database connection file */
require '../../../config.php';

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
include '../../templates/header.php'; ?>

<h2>Reader Registration</h2>

<?php include '../../templates/navigation.php'; ?>

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

<?php include '../../templates/footer.php'; ?>
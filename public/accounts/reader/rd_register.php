<?php
session_start();

require '../../../common.php';

/* Initial value for error string  */
$error = '';

if (isset($_POST['register'])) {

    /* Include the Account class file */
    require '../../classes/Account.php';

    /* Include the database connection file */
    require '../../../config.php';

    /* Create a new Account object */
    $account = new Account();

    $email = $_POST['email'];
    $passwd = $_POST['passwd'];

    try {
        /* Save account id in Session array */
        $_SESSION['acct_id'] = $account->addAccount($email, $passwd, 'reader');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
include '../../templates/header.php'; ?>

<h2>Reader Registration</h2>

<?php include '../../templates/navigation.php'; ?>

<form method="POST">
    <?php
    if (isset($_POST['register'])) {
        if ($error) {
            showError($error);
        } else {
            /* Display success message and redirect to the main page */
            showSuccess($account->getEmail(), 'registered');
            header("Refresh:2; url= $address/index.php");
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
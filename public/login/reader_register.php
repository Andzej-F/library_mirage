<?php
session_start();

require '../../common.php';

/* Include the Account class file */
require '../classes/Account.php';

/* Include the database connection file */
require '../../config.php';

/* Create a new Account object */
$account = new Account();

if (isset($_POST['rd_reg'])) {
    try {
        $_SESSION['account_id'] = $account->addAccount($_POST['rd_uname'], $_POST['rd_pswd']);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
    // $_SESSION['account_id'] = $newId;
    // $_SESSION['success_reg'] = 'The new account ID is ' . $newId . '<br>';

    /* After successful registration redirect reader to the home page */
    header('Location: http://localhost/PHP/Bandymai/library_mirage/public/login/reader_home.php');
    exit();
}

?>

<?php include '../templates/header.php'; ?>

<h2>Register</h2>

<?php include '../templates/navigation.php'; ?>

<form method="post">
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="rd_uname" placeholder="Enter username"><br>
    </div>
    <!-- <div class="input-group">
        <label>Email</label>
        <input type="text" name="rd_eml" placeholder="Enter email"><br>
    </div> -->
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="rd_pswd" placeholder="Enter password">
    </div>
    <!-- <div class="input-group">
        <label>Repeat password</label>
        <input type="password" name="rp_rd_pass" placeholder="Repeat password">
    </div> -->
    <div class="input-group">
        <button type="submit" class="btn" name="rd_reg">Register</button>
    </div>
</form>

<?php include '../templates/footer.php'; ?>
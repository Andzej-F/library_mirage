<?php
session_start();

require '../../common.php';

/* Include the Account class file */
require '../classes/Account.php';

/* Include the database connection file */
require '../../config.php';

/* Create a new Account object */
$account = new Account();

// 2. Edit an account. Try passing invalid parameters to test error messages.
if (isset($_GET['rd_edit'])) {

    $accountId = $_SESSION['account_id'];
    $newName = $_POST['new_name'];
    $newPass = $_POST['new_pass'];

    try {
        $account->editAccount($accountId, $newName, $newPass, TRUE);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
    // $_SESSION['success'] = 'Account edit successful.';
    unset($_GET['edit']);
    // header("Location: $address/login/reader_home.php");
    exit();
}

include '../templates/header.php'; ?>

<h3>Reader Edit Account Page</h3>

<?php include '../templates/navigation.php'; ?>

<?php if (isset($_GET['edit'])) : ?>
    <form method="post">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="edit_name" placeholder="Enter username"><br>
        </div>
        <!-- <div class="input-group">
        <label>Email</label>
        <input type="text" name="rd_eml" placeholder="Enter email"><br>
    </div> -->
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="edit_pass" placeholder="Enter password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="rd_login">LOGIN</button>
        </div>
    </form>
<?php endif;

include '../templates/footer.php';

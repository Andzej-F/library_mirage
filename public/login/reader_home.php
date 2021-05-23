<?php
session_start();


/* Include the Account class file */
require '../classes/Account.php';

/* Include the database connection file */
require '../../config.php';

/* Create a new Account object */
$account = new Account();


// 2. Edit an account. Try passing invalid parameters to test error messages.
if (isset($_POST['rd_edit'])) {

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
    // header('Location: http://localhost/PHP/Bandymai/library_mirage/public/login/reader_home.php');
    exit();
}

// 3. Delete an account.

if (isset($_GET['delete'])) {

    $accountId = $_SESSION['account_id'];

    try {
        $account->deleteAccount($accountId);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
    // $_SESSION['success'] = 'Account deleted successfully.';
    header('Location: http://localhost/PHP/Bandymai/library_mirage/public/login/reader_home.php');
    exit();
}

// 4. Login with username and password.
if (isset($_POST['login'])) {
    $login = FALSE;

    $logName = $_POST['log_name'];
    $logPass = $_POST['log_pass'];

    try {
        $login = $account->login($logName, $logPass);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

    if ($login) {
        echo 'Authentication successful.';
        echo 'Account ID: ' . $account->getId() . '<br>';
        echo 'Account name: ' . $account->getName() . '<br>';
    } else {
        echo 'Authentication failed.';
    }
}

?>

<?php include '../templates/header.php'; ?>

<h2>Reader Home Page</h2>

<?php include '../templates/navigation.php'; ?>

<ul>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_home.php?edit">Edit Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_home.php?delete">Delete Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_home.php?login">Login</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_logout.php">Logout</a></h3>
    </li>
</ul>

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
        <!-- <div class="input-group">
        <label>Repeat password</label>
        <input type="password" name="rp_rd_pass" placeholder="Repeat password">
    </div> -->
        <div class="input-group">
            <button type="submit" class="btn" name="rd_login">LOGIN</button>
        </div>
    </form>
<?php endif ?>

<?php if (isset($_GET['login'])) : ?>
    <form method="post">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="log_name" placeholder="Enter username"><br>
        </div>
        <!-- <div class="input-group">
        <label>Email</label>
        <input type="text" name="rd_eml" placeholder="Enter email"><br>
    </div> -->
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="log_pass" placeholder="Enter password">
        </div>
        <!-- <div class="input-group">
        <label>Repeat password</label>
        <input type="password" name="rp_rd_pass" placeholder="Repeat password">
    </div> -->
        <div class="input-group">
            <button type="submit" class="btn" name="login">LOGIN</button>
        </div>
    </form>
<?php endif ?>

<?php include '../templates/footer.php';

// echo '<pre>';
// // echo $account->getId();
// print_r(get_defined_vars());
// echo '</pre>';
?>
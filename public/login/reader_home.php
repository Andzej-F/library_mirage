<?php
session_start();

require '../../common.php';

/* Include the Account class file */
require '../classes/Account.php';

/* Include the database connection file */
require '../../config.php';

/* Create a new Account object */
$account = new Account();

// 3. Delete an account.

if (isset($_GET['delete'])) {

    $accountId = $_SESSION['account_id'];

    try {
        $account->deleteAccount($accountId);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }
    //TODO header to the same page? + success message
    header("Location: $address/login/reader_home.php");
    exit();
}

// ------------------ 6. Logout.
if (isset($_GET['logout'])) {
    try {
        $login = $account->login($_SESSION['log_name'], $_SESSION['log_pass']);

        if ($login) {
            echo 'Authentication successful.';
            echo 'Account ID: ' . $account->getId() . '<br>';
            echo 'Account name: ' . $account->getName() . '<br>';
        } else {
            echo 'Authentication failed.<br>';
        }


        $account->logout();

        $login = $account->sessionLogin();

        if ($login) {
            echo 'Authentication successful.';
            echo 'Account ID: ' . $account->getId() . '<br>';
            echo 'Account name: ' . $account->getName() . '<br>';
        } else {
            echo 'Authentication failed.<br>';
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

    echo 'Logout successful.';
}

include '../templates/header.php'; ?>

<h2>Reader Home Page</h2>

<?php include '../templates/navigation.php'; ?>

<ul>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_edit.php?edit">Edit Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_home.php?delete">Delete Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_login.php?login">Login</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/login/reader_home.php?logout">Logout</a></h3>
    </li>
</ul>

<?php include '../templates/footer.php';

echo session_status();
echo '<br>';
echo session_id();
//jdm29rdj6g3iqv01q56kief5qe    
<?php
session_start();

/* Include common functions file */
require '../../../common.php';

/* Include the Account class file */
require '../../classes/Account.php';

/* Include the database connection file */
require '../../../config.php';

$account = new Account();

$accountId = $_SESSION['acct_id'];

try {
    $success = TRUE;
    $account->deleteAccount($accountId);
} catch (Exception $e) {
    $error = $e->getMessage();
    $success = FALSE;
}

/* Include header file */
include '../../templates/header.php'; ?>

<h2>Account Settings</h2>

<?php
/* Include navigation bar file */
include '../../templates/navigation.php';

if ($success) {
    /* Display success message */
    showSuccess($account->getEmail(), 'deleted');

    /* Destroy current session */
    session_destroy();

    /* Redirect to the main page */
    header("Refresh:2.5; url= $address/index.php");
    exit();
} else {
    showError($error);
}

include '../../templates/footer.php';

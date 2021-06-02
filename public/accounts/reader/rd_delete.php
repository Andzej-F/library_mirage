<?php
session_start();

/* include_once common functions file */
require_once '../../../common.php';

/* include_once the Account class file */
require_once '../../classes/Account.php';

/* include_once the database connection file */
require_once '../../../config.php';

$account = new Account();

$accountId = $_SESSION['acct_id'];

try {
    $success = TRUE;
    $account->deleteAccount($accountId);
} catch (Exception $e) {
    $error = $e->getMessage();
    $success = FALSE;
}

/* include_once header file */
include_once '../../templates/header.php'; ?>

<h2>Account Settings</h2>

<?php
/* include_once navigation bar file */
include_once '../../templates/navigation.php';

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

include_once '../../templates/footer.php';

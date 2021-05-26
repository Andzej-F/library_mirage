<?php

session_start();

/* Include the file with additional functions */
require '../../../common.php';

/* Initial value for error string  */
$error = '';

/* Include the database connection file */
require '../../../config.php';

/* Include the account class file */
require '../../classes/Account.php';

/* Create a new account object */
$account = new Account();

if (isset($_GET['logout'])) {

    $logout = TRUE;

    try {
        $account->logout();
    } catch (Exception $e) {
        $error = $e->getMessage();
        $logout = FALSE;
    }

    if ($logout) {
        session_destroy();
        header("Location: $address/index.php");
        exit();
    } else {
        showError($error);
    }
}

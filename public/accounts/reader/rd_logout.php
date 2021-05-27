<?php

session_start();

/* Include the file with additional functions */
require '../../../common.php';

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
        $logout = FALSE;
        $error = $e->getMessage();
    }

    if ($logout) {
        unset($_SESSION["reader_login"]);
        unset($_SESSION["acct_id"]);
        header("Location: $address/index.php");
        exit();
    } else {
        showError($error);
    }
}

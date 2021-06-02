<?php

session_start();

/* include_once the file with additional functions */
require_once '../../../common.php';

/* include_once the database connection file */
require_once '../../../config.php';

/* include_once the account class file */
require_once '../../classes/Account.php';

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

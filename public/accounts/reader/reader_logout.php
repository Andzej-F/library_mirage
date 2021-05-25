<?php

session_start();

/* Include the file with additional functions */
require '../../../common.php';

/* Initial value for error string  */
$error = '';

if (isset($_GET['reader_logout'])) {

    /* Include the database connection file */
    require '../../../config.php';

    /* Include the account class file */
    require '../../classes/Account.php';

    /* Create a new account object */
    $account = new Account();

    try {
        $account->logout();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
    unset($_SESSION["reader_login"]);
    header("Location: $address/index.php");
    exit();
}

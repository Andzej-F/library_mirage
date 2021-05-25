<?php
session_start();

require '../../../common.php';

/* Include the Account class file */
require '../../classes/Account.php';

/* Include the database connection file */
require '../../../config.php';

/* Create a new Account object */
// $account = new Account();

include '../../templates/header.php'; ?>

<h2>Account Settings</h2>

<?php include '../../templates/navigation.php'; ?>

<ul>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/reader_edit.php?edit">Edit Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/reader_home.php?delete">Delete Account</a></h3>
    </li>
</ul>

<?php include '../../templates/footer.php';

<?php
session_start();

/* Include common functions file */
require '../../../common.php';

// /* Include the Account class file */
require '../../classes/Account.php';

/* Include the database connection file */
require '../../../config.php';

include '../../templates/header.php'; ?>

<h2>Account Settings</h2>

<?php include '../../templates/navigation.php'; ?>
<ul>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/rd_edit.php">Edit Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/rd_delete.php">Delete Account</a></h3>
    </li>
</ul>
<?php include '../../templates/footer.php';

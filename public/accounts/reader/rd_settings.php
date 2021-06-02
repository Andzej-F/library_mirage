<?php
session_start();

/* include_once common functions file */
require_once '../../../common.php';

// /* include_once the Account class file */
require_once '../../classes/Account.php';

/* include_once the database connection file */
require_once '../../../config.php';

include_once '../../templates/header.php'; ?>

<h2>Account Settings</h2>

<?php include_once '../../templates/navigation.php'; ?>
<ul>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/rd_edit.php">Edit Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/rd_delete.php">Delete Account</a></h3>
    </li>
</ul>
<?php include_once '../../templates/footer.php';

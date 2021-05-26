<?php
session_start();

/* Include common functions file */
require '../../../common.php';

// /* Include the Account class file */
require '../../classes/Account.php';

/* Include the database connection file */
require '../../../config.php';

/* Create a new Account object */
$account = new Account();

if (isset($_GET['delete'])) {

    // /* Delete an account. */
    $accountId = $_SESSION['acct_id'];

    try {
        $account->deleteAccount($accountId);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

    echo '<div class="success">' . escape($account->getEmail()) . ' successfully deleted!</div>';
    session_destroy();
    header("Location: $address/index.php");
    exit();
}

include '../../templates/header.php'; ?>

<h2>Account Settings</h2>

<?php include '../../templates/navigation.php';
?>
<ul>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/reader_edit.php?edit">Edit Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/reader_settings.php?delete">Delete Account</a></h3>
    </li>
</ul>
<?php include '../../templates/footer.php';

<?php
session_start();

/* Include common functions file */
require '../../../common.php';

// /* Include the Account class file */
require '../../classes/Account.php';

/* Include the database connection file */
require '../../../config.php';

$account = new Account();

/* Initial value for error string  */
$error = '';

if (isset($_GET['delete'])) {

    $success = TRUE;

    $accountId = $_SESSION['acct_id'];

    try {
        $account->deleteAccount($accountId);
    } catch (Exception $e) {
        $error = $e->getMessage();
        $success = FALSE;
    }
}

include '../../templates/header.php'; ?>

<h2>Account Settings</h2>

<?php include '../../templates/navigation.php';

if (isset($_GET['delete'])) {
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
}
?>
<ul>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/rd_edit.php">Edit Account</a></h3>
    </li>
    <li>
        <h3><a href="<?= $address; ?>/accounts/reader/rd_settings.php?delete">Delete Account</a></h3>
    </li>
</ul>
<?php include '../../templates/footer.php';

/* Debug */
echo '<pre>';
echo $account->getId();
echo '<br>';
echo $account->getEmail();

<?php
session_start();

require '../../config.php';

//$address = 'http://localhost/PHP/Bandymai/library_mirage/public';

/* Include the Account class file */
require '../classes/Account.php';

/* Include the database connection file */
require '../../config.php';

/* Create a new Account object */
$account = new Account();

if (isset($_POST['rd_reg'])) {
    try {
        $newId = $account->addAccount($_POST['rd_uname'], $_POST['rd_pswd']);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

    //echo 'The new account ID is ' . $newId . '<br>';

    /* After successful registration redirect reader to the home page */
    header('Location: http://localhost/PHP/Bandymai/library_mirage/public/login/reader_home.php');
    exit();
}
?>

<?php include '../templates/header.php'; ?>

<h2>Reader Home Page</h2>

<?php include '../templates/navigation.php'; ?>

<ul>
    <h2>
        <a href="<?= $address; ?>/readers/edit_reader.php">Edit Account</a>
    </h2>
    <h2><a href="<?= $address; ?>/readers/delete_reader.php">Delete Account</a><br>
        <!-- TODO chek if it is possible to delete account from reader home page
        w/o creating a separate file ;) -->
        <a href="<?= $address; ?>/delete_account.php?account_id=<?= $row['del_acct']; ?>">Delete Account</a>
    </h2>
    <h2><a href="<?= $address; ?>/readers/logout_reader.php">Logout</a>
    </h2>
</ul>

<?php include '../templates/footer.php'; ?>
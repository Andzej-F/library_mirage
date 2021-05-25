<?php
session_start();

/* If the reader has logged in, redirect to the main page */
// if (isset($_SESSION['reader_login'])) {
//     header("Location: $address/index.php");
//     exit();
// }

require '../../../common.php';

/* Initial value for error string  */
$error = '';

if (isset($_POST['reg_btn'])) {

    /* Include the Account class file */
    require '../../classes/Account.php';

    /* Include the database connection file */
    require '../../../config.php';

    /* Create a new Account object */
    $account = new Account();

    $email = $_POST['rd_email'];
    $passwd = $_POST['rd_passwd'];
    try {
        $_SESSION['account_id'] = $account->addAccount($email, $passwd, 'reader');
    } catch (Exception $e) {
        $error = $e->getMessage();
    }


    /* Register reader sessions  */
    // $_SESSION['reader_login'] = $account->getEmail();

    /* After successful registration redirect reader to a reader home page */
    // header("Location: $address/accounts/reader/reader_home.php");
    // exit();
}

?>

<?php include '../../templates/header.php'; ?>

<h2>Reader Registration</h2>

<?php include '../../templates/navigation.php'; ?>

<form method="post">
    <?php
    if (isset($_POST['reg_btn'])) {
        if ($error) {
            /* Display error */
            echo '<div class="error">' . $error . '</div>';
        } else {
            /* Display success message */
            echo '<div class="success">' . escape($account->getEmail()) . ' successfully logged in!</div>';

            /* Clear form input after success message */
            $_POST = [];
        }
    }
    ?>
    <div class="input-group">
        <label>Email</label>
        <input type="text" name="rd_email" value="<?= isset($_POST['rd_email']) ? escape($_POST['rd_email']) : ''; ?>" placeholder="Enter email" placeholder="Enter Email"><br>
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="rd_passwd" placeholder="Enter password">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="reg_btn">Register</button>
    </div>
</form>

<?php include '../../templates/footer.php'; ?>
<?php
session_start();

require '../../common.php';

/* Include the Account class file */
require '../classes/Account.php';

/* Include the database connection file */
require '../../config.php';

/* Create a new Account object */
$account = new Account();

// 4. Login with username and password.
if (isset($_POST['login'])) {
    $login = FALSE;

    $_SESSION['log_name'] = $_POST['log_name'];
    $_SESSION['log_pass'] = $_POST['log_pass'];

    try {
        $login = $account->login($_POST['log_name'], $_POST['log_pass']);
    } catch (Exception $e) {
        echo $e->getMessage();
        die();
    }

    if ($login) {
        echo 'Authentication successful.';
        echo 'Account ID: ' . $account->getId() . '<br>';
        echo 'Account name: ' . $account->getName() . '<br>';
    } else {
        echo 'Authentication failed.';
    }
    header("Location: $address/login/reader_home.php");
}

include '../templates/header.php'; ?>

<h2>Reader Login Page</h2>

<?php include '../templates/navigation.php'; ?>
<?php if (isset($_GET['login'])) : ?>
    <form method="post">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="log_name" placeholder="Enter username"><br>
        </div>
        <!-- <div class="input-group">
        <label>Email</label>
        <input type="text" name="rd_eml" placeholder="Enter email"><br>
    </div> -->
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="log_pass" placeholder="Enter password">
        </div>

        <div class="input-group">
            <button type="submit" class="btn" name="login">LOGIN</button>
        </div>
    </form>
<?php endif;

include '../templates/footer.php';

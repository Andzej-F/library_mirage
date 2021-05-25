    <?php
    $address = 'http://localhost/PHP/Bandymai/library_mirage/public';
    ?>
    <div class="row header">
        <nav>
            <ul>
                <li><a class="dropdown dropbtn" href="<?= $address; ?>/index.php">Home</a></li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Authors</button>
                        <div class="dropdown-content">
                            <a href="<?= $address; ?>/authors/read_author.php">Authors</a>
                            <?php if (isset($_SESSION['libr_login'])) : ?>
                                <a href="<?= $address; ?>/authors/create_author.php">Add a New Author</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Books</button>
                        <div class="dropdown-content">
                            <a href="<?= $address; ?>/books/read_book.php">Books</a>
                            <?php if (isset($_SESSION['libr_login'])) : ?>
                                <a href="<?= $address; ?>/books/create_book.php">Add a New Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Librarian</button>
                        <div class="dropdown-content">
                            <?php if (isset($_SESSION['libr_login']) === FALSE) : ?>
                                <a href="<?= $address; ?>/accounts/librarian/libr_login_oop.php">Login</a>
                            <?php endif; ?>
                            <a href="<?= $address; ?>/accounts/librarian/libr_logout_oop.php">Logout</a>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Reader</button>
                        <div class="dropdown-content">
                            <a href="<?= $address; ?>/login/reader_login.php">Login</a>
                            <a href="<?= $address; ?>/login/reader_register.php">Register</a>
                            <a href="<?= $address; ?>/login/reader_logout.php">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
    <?php
    /* Local computer address string */
    $address = 'http://localhost/PHP/Bandymai/library_mirage/public';

    /* Check if the reader is logged in */
    $readerLogged = isset($_SESSION['reader_login']);

    /* Check if the librarian is logged in */
    $librLogged = isset($_SESSION['libr_login']);

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
                            <?php if ($librLogged) : ?>
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
                            <?php if ($librLogged) : ?>
                                <a href="<?= $address; ?>/books/create_book.php">Add a New Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <li>
                    <?php
                    /* Do not display "Librarian" tab when reader is logged*/
                    if (!$readerLogged) : ?>
                        <div class="dropdown">
                            <button class="dropbtn">Librarian</button>
                            <div class="dropdown-content">
                                <?php if (!$librLogged) : ?>
                                    <a href="<?= $address; ?>/accounts/librarian/libr_login.php">Login</a>
                                <?php endif; ?>
                                <?php if ($librLogged) : ?>
                                    <a href="<?= $address; ?>/accounts/librarian/libr_logout.php?libr_logout">Logout</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
                <li>
                    <?php
                    /* Do not display "Reader" tab when librarian is logged*/
                    if (!$librLogged) : ?>
                        <div class="dropdown">
                            <button class="dropbtn">Reader</button>
                            <div class="dropdown-content">
                                <?php if (!$readerLogged) : ?>
                                    <a href="<?= $address; ?>/accounts/reader/rd_login.php">Login</a>
                                    <a href="<?= $address; ?>/accounts/reader/rd_register.php?">Register</a>
                                <?php endif; ?>
                                <?php if ($readerLogged) : ?>
                                    <a href="<?= $address; ?>/accounts/reader/rd_settings.php">Account Settings</a>
                                    <a href="<?= $address; ?>/accounts/reader/rd_logout.php?logout">Logout</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
    <div class="row header">
        <nav>
            <ul>
                <li><a class="dropdown dropbtn" href="http://localhost/PHP/Bandymai/library_mirage/public/index.php">Home</a></li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Authors</button>
                        <div class="dropdown-content">
                            <a href="http://localhost/PHP/Bandymai/library_mirage/public/authors/read_author.php">Authors</a>
                            <?php if (isset($_SESSION['libr_login'])) : ?>
                                <a href="http://localhost/PHP/Bandymai/library_mirage/public/authors/create_author_oop.php">Add a New Author</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Books</button>
                        <div class="dropdown-content">
                            <a href="http://localhost/PHP/Bandymai/library_mirage/public/books/read_book.php">Books</a>
                            <?php if (isset($_SESSION['libr_login'])) : ?>
                                <a href="http://localhost/PHP/Bandymai/library_mirage/public/books/create_book.php">Add a New Book</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Login</button>
                        <div class="dropdown-content">
                            <?php if (isset($_SESSION['libr_login']) === FALSE) : ?>
                                <a href="http://localhost/PHP/Bandymai/library_mirage/public/login/librarian_login.php">Librarian Login</a>
                            <?php endif; ?>
                            <a href="http://localhost/PHP/Bandymai/library_mirage/public/login/librarian_logout.php">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
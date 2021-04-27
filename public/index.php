<?php session_start();
$logged_in = isset($_SESSION['librarian_login']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Mirage</title>

    <link rel="stylesheet" href="/PHP/Bandymai/library_mirage/public/css/style.css" type="text/css">
    <style>
        body {
            background-image: url('http://localhost/PHP/Bandymai/library_mirage/data/images/library_photo.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>
</head>

<body>
    <div class="box">
        <div class="row header">
            <h1>Library "Mirage"</h1>
            <nav>
                <ul>
                    <li><a class="dropdown dropbtn" href="">Home</a></li>
                    <li>
                        <div class="dropdown">
                            <button class="dropbtn">Authors</button>
                            <div class="dropdown-content">
                                <a href="./authors/read_author.php">Authors</a>
                                <?php if ($logged_in) : ?>
                                    <a href="./authors/create_author.php">Add a New Author</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown">
                            <button class="dropbtn">Books</button>
                            <div class="dropdown-content">
                                <a href="./books/read_book.php">Books</a>
                                <?php if ($logged_in) : ?>
                                    <a href="./books/create_book.php">Add a New Book</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown">
                            <button class="dropbtn">Login</button>
                            <div class="dropdown-content">
                                <?php if ($logged_in === FALSE) : ?>
                                    <a href="./login/librarian_login.php">Librarian Login</a>
                                <?php endif; ?>
                                <a href="./login/librarian_logout.php">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="row search_field">
            <?php
            if ($logged_in) {
                include './search/search_field.php';
            } ?>
        </div>
        <div class="row content">
            <div class="new_books">
                <h3><span>Newest Books</span></h3>
                <div class="new_book"><img src="../data/images/the_three_musketers.jpg" alt="The Three Musketers"></div>
                <div class="new_book"><img src="../data/images/treasure_island.jpg" alt="Treasure Island"></div>
                <div class="new_book"><img src="../data/images/journey_to_the_center.jpg" alt="Journey to the Center of the Earth"></div>
            </div>
        </div>

        <div class="row footer">
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Resources</a></li>
            </ul>
        </div>
    </div>
    <?php require './templates/footer.php'; ?>
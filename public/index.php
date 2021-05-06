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
    <h1 class="header">Library "Mirage"</h1>
    <div class="box">
        <?php include './templates/navigation.php'; ?>
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
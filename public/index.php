<?php session_start();
$logged_in = isset($_SESSION['librarian_login']);
include './templates/header.php';
?>

<body class="main_page_background">
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
<?php

session_start();

include_once './templates/header.php';
include_once '../common.php';
?>


<body class="main_page_background">
    <h1 class="header">Library "Mirage"</h1>
    <div class="box">

        <?php include_once './templates/navigation.php'; ?>

        <div class="row">
            <?php
            if (isset($_SESSION['libr_login']) || isset($_SESSION['reader_login'])) {
                include_once './search/search_field.php';
            } ?>
        </div>

        <div class="row main-content">
            <div class="new_books">
                <h3><span>New Books</span></h3>
                <div class="new_book"><img src="./data/images/the_three_musketers.jpg" alt="The Three Musketers"></div>
                <div class="new_book"><img src="./data/images/treasure_island.jpg" alt="Treasure Island"></div>
                <div class="new_book"><img src="./data/images/journey_to_the_center.jpg" alt="Journey to the Center of the Earth"></div>
            </div>
        </div>

        <?php require_once './templates/footer.php'; ?>
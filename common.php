<?php
/* This file contains common custom functions used in application */

/* Escapes HTML for output */
function escape($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

/* Local computer address string */
$address = 'http://localhost/PHP/Bandymai/library_mirage/public';

/* Check if the reader has logged in */
$readerLogged = isset($_SESSION['reader_login']);

/* Check if the librarian has logged in */
$librLogged = isset($_SESSION['libr_login']);

/* Function displays error messages */
function showError($error)
{
    echo '<div class="error">' . $error . '</div>';
}

/* Function displays success messages. It takes two arguments, one is account email,
   second is action message('edited', 'logged in', 'registered' or 'deleted') */
function showSuccess($email, $actionMsg)
{
    if ($actionMsg === 'deleted') {
        echo '<div class="success">Account successfully deleted!</div>';
    } else {
        echo '<div class="success">' . escape($email) . ' account successfully ' . $actionMsg . ' !</div>';
    }
}

/* Function displays success messages for "author" object operations */
function successAuthor($name, $surname, $actionMsg)
{
    echo '<div class="success">' . escape($name) .
        ' ' . escape($surname) . ' successfully ' . $actionMsg . ' !</div>';
}

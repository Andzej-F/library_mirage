<?php
/* This file contains some coomon custom functions used accross the files */

/* Escapes HTML for output */
function escape($html)
{
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}


/* Local computer address string */
$address = 'http://localhost/PHP/Bandymai/library_mirage/public';

/* Check if the reader is logged in */
$readerLogged = isset($_SESSION['reader_login']);

/* Check if the librarian is logged in */
$librLogged = isset($_SESSION['libr_login']);


/* Function displays success or error message */
// function dispErrSuccess($error, $value, $button, $change)
// {
//     if (isset($button) {
//         if ($error) {
//             /* Display error */
//             echo '<div class="error">' . $error . '</div>';
//         } else {
//             /* Display success message */
//             echo '<div class="success">' . $value . ' account successfully '.$change.'!</div>';
//             /* Clear form input after success message */
//             $_POST = [];
//         }
//     }
// }

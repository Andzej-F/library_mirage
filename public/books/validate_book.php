<?PHP

/**
 *  Book validation functions
 */

/* Function that displays error messages */
function dispErr($errors)
{
    if (isset($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    }
}

/* Function checks if provided input is integer greater than 0 */
function valInt($input): bool
{
    /* Initialise the return variable */
    $valid = TRUE;

    if (filter_var($input, FILTER_VALIDATE_INT) === FALSE) {
        $errorMsg[] = 'Please enter a valid number line.<br>';
        $valid = FALSE;
    } else {
        if ($input < 0) {
            $errorMsg[] = 'Input value cannot be negative.<br>';
            $valid = FALSE;
        }
    }

    dispErr($errorMsg);
    return $valid;
}

function validBook(): bool
{
    if (
        valTitle($_POST['book_title']) &&
        valGenre($_POST['book_genre']) &&
        valYear($_POST['book_year']) &&
        valPages($_POST['book_pages']) &&
        valISBN($_POST['book_isbn']) &&
        valStock($_POST['book_stock']) &&
        valAbout($_POST['book_about'])
    ) {
        $valid = TRUE;
    } else {
        $valid = FALSE;
    }
    return $valid;
}

function valTitle(string $title): bool
{
    /* Initialize the return variable */
    $valid = TRUE;

    if (isset($title)) {
        /* Title length check */
        $len = mb_strlen($title);

        if (($len > 255)) {
            $errorMsg[] = 'Name cannot be longer than 255 characters<br>';
            $valid = FALSE;
        }

        /* Check if the title consists of alpha-numeric characters */
        if (!preg_match("/^[A-Za-z0-9]+((\s)?((\'|\-)?([A-Za-z])+))*$/", $title)) {
            $errorMsg[] = 'Name must contain only alpha-numeric characters<br>';
            $valid = FALSE;
        }
    } else {
        $errorMsg[] = 'Please enter book\'s title<br>';
        $valid = FALSE;
    }

    dispErr($errorMsg);
    return $valid;
}

function valGenre(string $genre): bool
{
    /* Initialize the return variable */
    $valid = TRUE;

    if (isset($genre)) {
        $len = mb_strlen($genre);
        if (($len > 64)) {
            $errorMsg[] = 'Name of the genre cannot be longer than 64 characters<br>';
            $valid = FALSE;
        }

        /* Check if the genre consists of alpha characters */
        if (!preg_match("/^[A-Za-z]+((\s)?((\'|\-)?([A-Za-z])+))*$/", $genre)) {
            $errorMsg[] = 'Genre must contain only alpha characters<br>';
            $valid = FALSE;
        }
    } else {
        $errorMsg[] = 'Please enter book\'s genre<br>';
        $valid = FALSE;
    }

    dispErr($errorMsg);
    return $valid;
}

function valYear(string $year): bool
{
    /* Initialise the return variable */
    $valid = TRUE;

    /* Check that the book issue year element exists. */
    if (isset($year)) {

        if (valInt($year)) {
            /* Check if the issue year is not greater than current year */
            if ($year > intval(date('Y'))) {
                $errorMsg[] = 'The books issue year cannot be greater than current year <br>';
                $valid = FALSE;
            }
        }
    } else {
        $errorMsg[] = 'Please enter the book\'s issue year<br>';
        $valid = FALSE;
    }

    dispErr($errorMsg);

    return $valid;
}


function valPages(string $pages): bool
{
    $valid = TRUE;

    if (isset($pages)) {
        /* Check if the value is integer */
        if (valInt($pages)) {
            if (($pages > 2000)) {
                $errorMsg[] = 'Please enter the correct number of pages.<br>';
                $valid = FALSE;
            }
        }
    } else {
        $errorMsg[] = 'Please enter the number of pages<br>';
        $valid = FALSE;
    }

    dispErr($errorMsg);

    return $valid;
}

function valISBN(string $isbn): bool
{
    $valid = TRUE;

    if (isset($isbn)) {
        /* Check if the value is integer */
        if (valInt($isbn)) {
            if (($isbn < 1000)) {
                $errorMsg[] = 'ISBN value cannot be lower than 1000.<br>';
                $valid = FALSE;
            }
            if (($isbn >= 10000)) {
                $errorMsg[] = 'ISBN value cannot be greater than 10000.<br>';
                $valid = FALSE;
            }
        }
    } else {
        $errorMsg[] = 'Please enter the number of ISBN<br>';
        $valid = FALSE;
    }

    dispErr($errorMsg);

    return $valid;
}


function valStock(string $stock): bool
{
    $valid = TRUE;
    if (isset($stock)) {
        if (valInt($stock)) {
            if (($stock > 100)) {
                $errorMsg[] = 'Stock value cannot be greater than 100.<br>';
                $valid = FALSE;
            }
        } else {
            $errorMsg[] = 'Please enter the number of stock<br>';
            $valid = FALSE;
        }
    }

    dispErr($errorMsg);
    return $valid;
}
function valAbout(string $about): bool
{
    /* Initialize the return variable */
    $valid = TRUE;

    $len = mb_strlen($about);
    if (($len > 10000)) {
        $errorMsg[] = 'Book\'s description cannot be longer than 10000 characters<br>';
        $valid = FALSE;
    }

    dispErr($errorMsg);

    return $valid;
}

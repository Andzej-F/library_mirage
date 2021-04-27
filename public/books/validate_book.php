<?PHP

/**
 *  Book validation functions
 */


function valTitle(string $title): bool
{
    /* Initialize the return variable */
    $valid = TRUE;

    if (empty($title)) {
        $errorMsg[] = 'Please enter book\'s title<br>';
        $valid = FALSE;
    } else {
        /* Title length check */
        $len = mb_strlen($title);

        if (($len > 255)) {
            $errorMsg[] = 'Title cannot be longer than 255 characters<br>';
            $valid = FALSE;
        }

        /* Check if the title consists of alpha-numeric characters */
        if (!preg_match("/^[A-Za-z0-9]+((\s)?((\'|\-)?([A-Za-z])+))*$/", $title)) {
            $errorMsg[] = 'Name must contain only alpha-numeric characters<br>';
            $valid = FALSE;
        }
    }

    /* Display errors */
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }
    return $valid;
}

function valGenre(string $genre): bool
{
    /* Initialize the return variable */
    $valid = TRUE;

    if (empty($genre)) {
        $errorMsg[] = 'Please enter book\'s genre<br>';
        $valid = FALSE;
    } else {
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
    }

    /* Display errors */
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }

    return $valid;
}

function valYear(string $year): bool
{
    /* Initialize the return variable */
    $valid = TRUE;

    if (isset($year)) {
        /* Check if the value is integer */
        if (filter_var($year, FILTER_VALIDATE_INT) == TRUE) {
            if ($year < 0) {
                $errorMsg[] = 'Year value cannot be negative.<br>';
                $valid = FALSE;
            }
            $current_year = intval(date('Y'));
            if ($year > $current_year) {
                $errorMsg[] = 'The books issue date cannot be greater than ' . $current_year . '<br>';
                $valid = FALSE;
            }
        } else {
            $errorMsg[] = 'Please enter an integer value for the issue year.<br>';
            $valid = FALSE;
        }
    } else {
        $errorMsg[] = 'Please enter the book\'s issue year<br>';
        $valid = FALSE;
    }

    /* Display errors */
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }

    return $valid;
}


function valPages(string $pages): bool
{
    $valid = TRUE;

    if (!empty($pages)) {
        /* Check if the value is integer */
        if (filter_var($pages, FILTER_VALIDATE_INT) == TRUE) {
            if (($pages < 0)) {
                $errorMsg[] = 'Pages value cannot be negative.<br>';
                $valid = FALSE;
            }
            if (($pages > 2000)) {
                $errorMsg[] = 'Pages value cannot be greater than 2000.<br>';
                $valid = FALSE;
            }
        } else {
            $errorMsg[] = 'Please enter an integer value for the number of pages.<br>';
            $valid = FALSE;
        }
    } else {
        $errorMsg[] = 'Please enter the number of pages<br>';
        $valid = FALSE;
    }

    /* Display errors */
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }

    return $valid;
}

function valISBN(string $isbn): bool
{
    $valid = TRUE;

    if (!empty($isbn)) {
        /* Check if the value is integer */
        if (filter_var($isbn, FILTER_VALIDATE_INT) == TRUE) {
            if (($isbn < 1000)) {
                $errorMsg[] = 'ISBN value cannot be lower than 1000.<br>';
                $valid = FALSE;
            }
            if (($isbn >= 10000)) {
                $errorMsg[] = 'ISBN value cannot be greater than 10000.<br>';
                $valid = FALSE;
            }
        } else {
            $errorMsg[] = 'Please enter an integer value for the number of isbn.<br>';
            $valid = FALSE;
        }
    } else {
        $errorMsg[] = 'Please enter the number of ISBN<br>';
        $valid = FALSE;
    }

    /* Display errors */
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }

    return $valid;
}


function valStock(string $stock): bool
{
    $valid = TRUE;

    if (!empty($stock)) {
        if (is_numeric($stock)) {
            if ($stock == intval($stock)) {
                if (($stock < 0)) {
                    $errorMsg[] = 'Stock value cannot be lower than 0.<br>';
                    $valid = FALSE;
                }
                if (($stock > 1000)) {
                    $errorMsg[] = 'Stock value cannot be greater than 1000.<br>';
                    $valid = FALSE;
                }
            } else {
                $errorMsg[] = 'Please provide the integer number<br>';
                $valid = FALSE;
            }
        } else {
            $errorMsg[] = 'Please enter the number of stock<br>';
            $valid = FALSE;
        }
    }

    /* Display errors */
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }

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

    /* Display errors */
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }

    return $valid;
}

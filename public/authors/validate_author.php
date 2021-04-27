<?php

/**
 *Author validation functions
 */

function valAuthorName(string $name): bool
{
    /* Initialise the return variable */
    $valid = TRUE;

    if (empty($name)) {
        $errorMsg[] = 'Name cannot be an empty line<br>';
        $valid = FALSE;
    }
    if (!empty($name)) {
        /* Check if the name consists of alpha characters optional additional names,
        with spaces and special characters (apostrophe, hyphen) */
        if (!preg_match("/^[A-Za-z]+((\s)?((\'|\-)?([A-Za-z])+))*$/", $name)) {
            $errorMsg[] = 'Name must contain only alpha characters<br>';
            $valid = FALSE;
        }

        /* Check if the name starts with capital letter */
        if ($name != ucwords($name, " \t\r\n\f\v'")) {
            $errorMsg[] = 'Name must start with a capital letter<br>';
            $valid = FALSE;
        }

        /* Name length check */
        $len = mb_strlen($name);

        if (($len > 64)) {
            $errorMsg[] = 'Name cannot be longer than 64 characters<br>';
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

function valAuthorSurname(string $surname): bool
{
    /* Initialize the return variable */
    $valid = TRUE;

    /* Check if the surname is not empty */
    if (!empty($surname)) {
        /* Check if the surname consists of alpha characters optional additional names,
with spaces and special characters (apostrophe, hyphen) */
        if (!preg_match("/^[A-Za-z]+((\s)?((\'|\-)?([A-Za-z])+))*$/", $surname)) {
            $errorMsg[] = 'Name must contain only alpha characters<br>';
            $valid = FALSE;
        }

        /* Check if the surname starts with capital letter */
        if ($surname != ucwords($surname, " \t\r\n\f\v'")) {
            $errorMsg[] = 'Surname must start with a capital letter<br>';
            $valid = FALSE;
        }

        /* Surname length check */
        $len = mb_strlen($surname);

        if (($len > 64)) {
            $errorMsg[] = 'Surname cannot be longer than 64 characters<br>';
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

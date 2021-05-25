<?PHP

/**
 * Validate librarian's login and password
 */

function valLibrLogin($email, $password): bool
{
    $valid = TRUE;

    if (!(valEmail($email) &&
        valPassword($password))) {
        $valid = FALSE;
    }
    return $valid;
}

function valEmail($email): bool
{
    $valid = TRUE;

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMsg[] = 'Please provide a valid email address.<br>';
            $valid = FALSE;
        }
    } else {
        $errorMsg[] = 'Please enter email address.<br>';
        $valid = FALSE;
    }
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }
    return $valid;
}

function valPassword($password): bool
{
    $valid = TRUE;

    if (!empty($password)) {
        if (!ctype_alnum($password)) {
            $errorMsg[] = 'Password must consist of alpha-numeric characters.<br>';
            $valid = FALSE;
        }
    } else {
        $errorMsg[] = 'Please enter a password.<br>';
        $valid = FALSE;
    }
    if (isset($errorMsg)) {
        foreach ($errorMsg as $error) {
            echo $error;
        }
    }
    return $valid;
}

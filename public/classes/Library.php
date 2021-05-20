<?php

/**
 * Library class contains some common methods that are used in child classes
 */

class Library
{
    /* Function validates form input in the author's field */
    public function checkName(string $name): bool
    {

        /* Check if the name field is not empty */
        if (!empty($name)) {

            /* String length check */
            if ((mb_strlen($name) > 64)) {
                return FALSE;
            }

            /* Check that the input contains alpha characters and special characters (dot, hyphen, apostrophe) */
            if (!preg_match('/^[a-zA-Z ._-]+$/', $name)) {
                return FALSE;
            }

            /* Check if the input starts with capital letter */
            if ($name != ucwords($name, " \t\r\n\f\v'")) {
                return FALSE;
            }
        } else {
            return FALSE;
        }

        /* If everything is ok, return true. */
        return TRUE;
    }

    public function checkID($id): bool
    {
        /* Check that the 'id' element exists. ? */
        if (!isset($id)) {
            return FALSE;
        }
        /* Integer type check with filter_var(). */
        if (filter_var($id, FILTER_VALIDATE_INT) === FALSE) {
            return FALSE;
        }

        /* check that $id is between 1 and 100 000. */
        if (($id < 1) || ($id > 100000)) {
            return FALSE;
        }
        return TRUE;
    }
}

<?php

/*
 * 	Author Class
 * 	
*/

class Author
{
    /* Class properties (variables) */

    /* The ID of the author (or NULL if there is no author) */
    private $id;

    /* The name of the author (or NULL if there is no author name) */
    private $name;

    /* The surname of the author (or NULL if there is no author surname) */
    private $surname;


    /* Public class methods (functions) */

    /* Constructor */
    public function __construct()
    {
        /* Initialize the $id, $name and $surname variables to NULL */
        $this->id = NULL;
        $this->name = NULL;
        $this->surname = NULL;
        $this->errors = [];
    }

    /* Destructor */
    public function __destruct()
    {
    }

    /* "Getter" function for the $id variable */
    public function getId(): ?int
    {
        return $this->id;
    }

    /* "Getter" function for the $name variable */
    public function getName(): ?string
    {
        return $this->name;
    }

    /* "Getter" function for the $surname variable */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /* Add a new author to the system */
    public function createAuthor(string $name, string $surname)
    {
        /* Global $pdo object */
        global $pdo;

        /* Trim the strings to remove extra spaces */
        $name = trim($name);
        $surname = trim($surname);

        /* Author validation */

        /* Check if the author name is valid. If not, throw an exception */
        if (!$this->isNameValid($name)) {
            // throw new Exception('Invalid author name');
            return $this->errors;
        }

        /* Check if the surname is valid. If not, throw an exception */
        if (!$this->isSurnameValid($surname)) {
            throw new Exception('Invalid author surname');
        }

        /* Check if the author having the same name already exists. If yes, throw an exception*/
        if (!is_null($this->getIdFromAuthor($name, $surname))) {
            throw new Exception('Author already exists');
        }

        /* Add the new author */

        /* Insert query template */
        $query = 'INSERT INTO library_mirage.authors (author_name, author_surname)
                  VALUES (:name, :surname)';

        /* Values array for PDO */
        $values = [':name' => $name, ':surname' => $surname];

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        /* Display success message */
        // echo '<p style="color:green;">' . $name . ' ' . $surname . ' successfully added!</p>';

    }

    /* Delete the author (selected by her/his ID) */
    public function deleteAuthor(int $id)
    {
        /* Global $pdo object */
        global $pdo;

        /* Query template */
        $query = 'DELETE FROM library_mirage.authors
                  WHERE (author_id = :id)';

        /* Values array for PDO */
        $values = array(':id' => $id);

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }
    }

    /* Update the author's (selected by its ID) name and surname. */
    public function updateAuthor(int $id, string $name, string $surname)
    {
        /* Global $pdo object */
        global $pdo;

        /* Trim the strings to remove extra spaces */
        $name = trim($name);
        $surname = trim($surname);

        /* Check if the author name is valid. */
        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid author name');
        }

        /* Check if the author name is valid. */
        if (!$this->isSurnameValid($surname)) {
            throw new Exception('Invalid author surname');
        }

        /* Check if the author having the same name already exists (except for this one). */
        $idFromAuthor = $this->getIdFromAuthor($name, $surname);

        if (!is_null($idFromAuthor) && ($idFromAuthor != $id)) {
            throw new Exception('Author name and surname already used');
        }

        /* Update the author */

        /* Edit query template */
        $query = 'UPDATE library_mirage.authors 
                  SET author_name = :name,
                  author_surname = :surname
                  WHERE author_id = :id';

        /* Values array for PDO */
        $values = array(
            ':name' => $name,
            ':surname' => $surname,
            ':id' => $id
        );

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        /* Display success message */
        echo '<p style="color:green;">' . $name . ' ' . $surname . ' successfully updated!</p>';

        /* Clear form input after success message */
        $_POST = [];
    }

    /* A sanitization check for the author name */
    public function isNameValid(string $name): bool
    {

        /* Check if the name field is not empty */
        if (isset($name)) {

            /* String length check */
            if ((mb_strlen($name) > 64)) {
                $this->errors[] = 'Input is too long';
                return FALSE;
            }

            /* Check that the input contains alpha characters and special characters (dot, hyphen, apostrophe) */
            if (!preg_match('/^[a-zA-Z ._-]+$/', $name)) {
                $this->errors[] = 'Input has to contain only alpha characters<br>';
                return FALSE;
            }

            /* Check if the input starts with capital letter */
            if ($name != ucwords($name, " \t\r\n\f\v'")) {
                $this->errors[] = 'Input must start with a capital letter<br>';
                return FALSE;
            }
        } else {
            $this->errors[] = 'This field cannot be empty';
            return FALSE;
        }

        /* If everything is ok, return true. */
        return TRUE;
    }

    /* A sanitization check for the author surname */
    public function isSurnameValid(string $surname): bool
    {
        /* To check the surname input, "isNameValid()" function is used
           to avoid code repetition */
        if ($this->isNameValid($surname) === TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* Function returns the author's id having $name as name and $surname as surname,
       or NULL if it's not found */
    public function getIdFromAuthor(string $name, string $surname): ?int
    {
        /* Global $pdo object */
        global $pdo;

        /* Since this method is public, we check $name again here */
        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid author name');
        }

        /* Since this method is public, we check $surname again here */
        if (!$this->isSurnameValid($surname)) {
            throw new Exception('Invalid author surname');
        }

        /* Initialize the return value. If no id is found, return NULL */
        $id = NULL;

        /* Search the ID on the database */
        $query = 'SELECT author_id FROM library_mirage.authors
                  WHERE author_name = :name AND author_surname = :surname';
        $values = [':name' => $name, ':surname' => $surname];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        /* If there is a result: get it's ID */
        if (is_array($row)) {
            $id = intval($row['author_id'], 10);
        }

        return $id;
    }
}

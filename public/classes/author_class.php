<?php

class Author
{
    private $id;
    private $name;
    private $surname;

    public function __construct()
    {
        $this->id = NULL;
        $this->name = NULL;
        $this->surname = NULL;
    }

    public function __destruct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /* Add a new author to the library */
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
            throw new Exception('Invalid author name');
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
        $values = [':id' => $id];

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }
    }

    /* Update the author's name and surname. */
    public function updateAuthor(int $id, string $name, string $surname)
    {
        /* Global $pdo object */
        global $pdo;

        /* Trim the strings to remove extra spaces */
        $name = trim($name);
        $surname = trim($surname);

        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid author name');
        }

        if (!$this->isSurnameValid($surname)) {
            throw new Exception('Invalid author surname');
        }

        /* Check if the author having the same name already exists. */
        $idFromAuthor = $this->getIdFromAuthor($name, $surname);

        if (!is_null($idFromAuthor) && ($idFromAuthor != $id)) {
            throw new Exception('Author name and surname already used');
        }

        /* Update the author's info */
        $query = 'UPDATE library_mirage.authors 
                  SET author_name = :name,
                  author_surname = :surname
                  WHERE author_id = :id';

        /* Values array for PDO */
        $values = [
            ':name' => $name,
            ':surname' => $surname,
            ':id' => $id
        ];

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* A sanitization check for the author name */
    public function isNameValid(string $name): bool
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

    /* A sanitization check for the author surname */
    public function isSurnameValid(string $surname): bool
    {
        /* "isNameValid()" function is used
           to avoid code repetition */
        if (!$this->isNameValid($surname)) {
            return FALSE;
        }
        return TRUE;
    }

    /* Function returns the author's id having $name as name and $surname as surname,
       or NULL if it's not found */
    public function getIdFromAuthor(string $name, string $surname): ?int
    {
        /* Global $pdo object */
        global $pdo;

        /* Check $name again here */
        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid author name');
        }

        /* Check $surname again here */
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
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        /* If there is a result: get the author's ID */
        if (is_array($row)) {
            $id = intval($row['author_id'], 10);
        }

        return $id;
    }

    /* Display the list of authors */
    public function getAuthorById(int $id): ?array
    {
        /* Global $pdo object */
        global $pdo;

        if (!$this->isValidID($id)) {
            throw new Exception('No records found');
            exit();
        }

        /* Search the ID on the database */
        $query = "SELECT * FROM authors WHERE author_id=:author_id";

        $values = [':author_id' => $id];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }

        $result = $res->fetch(PDO::FETCH_ASSOC);

        if (is_array($result)) {

            return $result;
        } else {
            return NULL;
        }
    }

    /* A sanitisation check for input ID */
    public function isValidId(int $id): bool
    {

        /* Global $pdo object */
        global $pdo;

        /* Check that the 'id' element exists. ? */
        if (empty($id)) {
            //TODO delete later
            echo 'Triggered 276<br>';
            return FALSE;
        }

        /* Integer type check with filter_var(). */
        if (filter_var($id, FILTER_VALIDATE_INT) === FALSE) {
            //TODO delete later
            echo 'Triggered 283<br>';
            return FALSE;
        }

        /* check that $id is between 1 and 100 000. */
        if (($id < 1) || ($id > 100000)) {
            //TODO delete later
            echo 'Triggered 290<br>';
            return FALSE;
        }

        /* Search the ID on the database */
        $query = 'SELECT author_id FROM library_mirage.authors
                  WHERE author_id = :author_id';

        $values = [':author_id' => $id];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        /* If there is a result: get the author's ID */
        if (!is_array($row)) {
            // $id = intval($row['author_id'], 10);
            //TODO delete later
            echo 'Triggered 313<br>';
            return FALSE;
        }

        return TRUE;
    }
}

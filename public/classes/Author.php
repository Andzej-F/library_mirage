<?php

class Author
{
    private $name;
    private $surname;

    public function __construct()
    {
        $this->name = NULL;
        $this->surname = NULL;
    }

    public function __destruct()
    {
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

        /* Validation succeeded. Set the class properties (name and surname) */
        $this->name = $name;
        $this->surname = $surname;

        /* Insert query template */
        $query = 'INSERT INTO authors (author_name, author_surname)
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

    /* Display list of authors */
    public function readAuthor(): array
    {
        /* Global $pdo object */
        global $pdo;

        /* Select query template */
        $query = 'SELECT * FROM `authors` WHERE 1';

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute();
            $result = $res->fetchAll();
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        return $result;
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

        // $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;

        $query = 'UPDATE authors 
                  SET author_name = :name,
                  author_surname = :surname
                  WHERE author_id = :id';

        $values = [
            ':name' => $name,
            ':surname' => $surname,
            ':id' => $id
        ];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Delete the author (selected by her/his ID) */
    public function deleteAuthor(int $id)
    {
        global $pdo;

        $query = 'DELETE FROM authors
                  WHERE (author_id = :id)';

        $values = [':id' => $id];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Author form input validation functions */

    public function isNameValid(string $name): bool
    {
        return $this->checkName($name);
    }

    public function isSurnameValid(string $surname): bool
    {
        return $this->checkName($surname);
    }

    /* A sanitization check for the author name and surname */
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

    /* Function returns the author's id or NULL if it's not found */
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
        $query = 'SELECT author_id FROM authors
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
}

<?php

include 'Library.php';

class Author extends Library
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

    /* Display list of authors */
    public function readAuthor(): array
    {
        /* Global $pdo object */
        global $pdo;

        /* Select query template */
        $query = 'SELECT * FROM `library_mirage`.`authors` WHERE 1';

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

        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;

        $query = 'UPDATE library_mirage.authors 
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

        $query = 'DELETE FROM library_mirage.authors
                  WHERE (author_id = :id)';

        $values = [':id' => $id];

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
        return parent::checkName($name);
    }

    /* A sanitization check for the author surname */
    public function isSurnameValid(string $surname): bool
    {
        return parent::checkName($surname);
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
    public function isValidId($id): bool
    {
        return parent::checkId($id);

        /* Global $pdo object */
        global $pdo;

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
            return FALSE;
        }
        return TRUE;
    }
}

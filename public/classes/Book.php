<?php

class Book
{
    private $title;
    private $genre;
    private $year;
    private $pages;
    private $stock;
    private $about;

    public function __construct()
    {
        $this->title = NULL;
        // $this->$genre = NULL;
        // $this->$year = NULL;
        // $this->$pages = NULL;
        // $this->$stock = NULL;
        // $this->$about = NULL;
    }

    public function __destruct()
    {
    }

    public function getTitle(): ?string
    {
        return $this->name;
    }


    /* Add a new book to the library */
    public function createBook(
        $title,
        $author_id,
        $genre,
        $year,
        $pages,
        $stock,
        $about
    ) {
        global $pdo;

        $title = trim($title);
        $genre = trim($genre);
        $year = trim($year);
        $pages = trim($pages);
        $stock = trim($stock);
        $about = trim($about);

        if (!$this->isTitleValid($title)) {
            throw new Exception('Not valid book title');
        }

        /* Check if the book with the same title already exists */
        if (!is_null($this->getIdFromTitle($title))) {
            throw new Exception('Book title already exists');
        }

        if (!$this->isGenreValid($genre)) {
            throw new Exception('Not valid book genre');
        }

        if (!$this->isYearValid($year)) {
            throw new Exception('Not valid book issue year');
        }

        if (!$this->isPagesValid($pages)) {
            throw new Exception('Not valid book pages');
        }

        if (!$this->isStockValid($stock)) {
            throw new Exception('Not valid book stock number');
        }

        if (!$this->isAboutValid($about)) {
            throw new Exception('Not valid book description');
        }

        $query =
            "INSERT INTO `library_mirage`.`books`(
                    `book_title`,
                    `book_author_id`,
                    `book_genre`,
                    `book_year`,
                    `book_pages`,
                    `book_stock`,
                    `book_about`)
                    VALUES (:title,
                    :author_id,
                    :genre,
                    :year,
                    :pages,
                    :stock,
                    :about)";

        $values = [
            ':title' => $title,
            ':author_id' => $author_id,
            ':genre' => $genre,
            ':year' => $year,
            ':pages' => $pages,
            ':stock' => $stock,
            ':about' => $about
        ];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Display library books */
    public function readBook(): array
    {
        global $pdo;

        $query = 'SELECT * FROM `library_mirage`.`books` WHERE 1';

        try {
            $res = $pdo->prepare($query);
            $res->execute();
            $books = $res->fetchAll();
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return $books;
    }

    // /* Update book */
    // public function updateBook(int $id, string $title, int $author_id, string $genre, int $year, int $pages, int $stock, string $about)
    // {
    //     global $pdo;

    //     $title = trim($title);
    //     $genre = trim($genre);
    //     $year = trim($year);
    //     $pages = trim($pages);
    //     $stock = trim($stock);
    //     $about = trim($about);

    //     /* Check if the ID is valid */
    //     if (!$this->isIdValid($id)) {
    //         throw new Exception('Not valid book ID');
    //     }

    //     /* Check if the user name is valid. */
    //     if (!$this->isTitleValid($title)) {
    //         throw new Exception('Not valid user name');
    //     }

    //     /* Check if the ID is valid */
    //     if (!$this->isIdValid($author_id)) {
    //         throw new Exception('Not valid book ID');
    //     }

    //     /* Check if an account having the same name already exists (except for this one). */
    //     $idFromName = $this->getIdFromName($name);

    //     if (!is_null($idFromName) && ($idFromName != $id)) {
    //         throw new Exception('User name already used');
    //     }

    //     /* Finally, edit the account */

    //     /* Edit query template */
    //     $query = 'UPDATE myschema.accounts SET account_name = :name, account_passwd = :passwd, account_enabled = :enabled WHERE account_id = :id';

    //     /* Password hash */
    //     $hash = password_hash(
    //         $passwd,
    //         PASSWORD_DEFAULT
    //     );

    //     /* Int value for the $enabled variable (0 = false, 1 = true) */
    //     $intEnabled = $enabled ? 1 : 0;

    //     /* Values array for PDO */
    //     $values = array(':name' => $name, ':passwd' => $hash, ':enabled' => $intEnabled, ':id' => $id);

    //     /* Execute the query */
    //     try {
    //         $res = $pdo->prepare($query);
    //         $res->execute($values);
    //     } catch (PDOException $e) {
    //         /* If there is a PDO exception, throw a standard exception */
    //         throw new Exception('Database query error');
    //     }
    // }

    // /* Delete an account (selected by its ID) */
    // public function deleteAccount(int $id)
    // {
    //     /* Global $pdo object */
    //     global $pdo;

    //     /* Check if the ID is valid */
    //     if (!$this->isIdValid($id)) {
    //         throw new Exception('Not valid account ID');
    //     }

    //     /* Query template */
    //     $query = 'DELETE FROM myschema.accounts WHERE (account_id = :id)';

    //     /* Values array for PDO */
    //     $values = array(':id' => $id);

    //     /* Execute the query */
    //     try {
    //         $res = $pdo->prepare($query);
    //         $res->execute($values);
    //     } catch (PDOException $e) {
    //         /* If there is a PDO exception, throw a standard exception */
    //         throw new Exception('Database query error');
    //     }

    //     /* Delete the Sessions related to the account */
    //     $query = 'DELETE FROM myschema.account_sessions WHERE (account_id = :id)';

    //     /* Values array for PDO */
    //     $values = array(':id' => $id);

    //     /* Execute the query */
    //     try {
    //         $res = $pdo->prepare($query);
    //         $res->execute($values);
    //     } catch (PDOException $e) {
    //         /* If there is a PDO exception, throw a standard exception */
    //         throw new Exception('Database query error');
    //     }
    // }

    /* Input validation */
    public function isTitleValid($title): bool
    {
        return $this->valText($title, 64);
    }

    public function isGenreValid($genre): bool
    {
        return $this->valText($genre, 100);
    }

    public function isYearValid($year): bool
    {
        return $this->valNumber($year, intval(date('Y')));
    }

    public function isPagesValid($pages): bool
    {
        return $this->valNumber($pages, 2000);
    }

    public function isStockValid($stock): bool
    {
        return $this->valNumber($stock, 100);
    }

    public function isAboutValid($about): bool
    {
        return $this->valText($about, 1000);
    }

    /* Function validates text input for book title, genre and about
       $limit variable defines the maximum amount of allowed characters */
    public function valText($title, $limit): bool
    {
        if (isset($title)) {
            /* Title length check */
            if ((mb_strlen($title) > $limit)) {
                return FALSE;
            }

            /* Check if the title consists of alpha-numeric characters */
            if (!preg_match("/^[A-Za-z0-9]+((\s)?((\'|\-)?([A-Za-z])+))*$/", $title)) {
                return FALSE;
            }
        } else {
            return FALSE;
        }
        return TRUE;
    }

    /* Function validates integer input */
    public function valNumber($number, $limit): bool
    {
        if (isset($number)) {
            /* Check if provided value is of integer type */
            if (filter_var($number, FILTER_VALIDATE_INT) === FALSE) {
                // $errorMsg[] = 'Please enter a valid number line.<br>';
                return FALSE;
            } else {
                /* Check if it is positive */
                if ($number < 0) {
                    // $errorMsg[] = 'Input value cannot be negative.<br>';
                    return FALSE;
                }
                /* Check if the number does not exceed the limit */
                if (($number > $limit)) {
                    // $errorMsg[] = 'Please enter the correct number of pages.<br>';
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
        return TRUE;
    }

    /* Returns the book's id having $name as name, or NULL if it's not found */
    public function getIdFromTitle($title): ?int
    {
        /* Global $pdo object */
        global $pdo;

        /* Since this method is public, we check $name again here */
        if (!$this->isTitleValid($title)) {
            throw new Exception('Not valid title');
        }

        /* Initialize the return value. If no title is found, return NULL */
        $id = NULL;

        /* Search the ID on the database */
        $query = 'SELECT `book_id` FROM `library_mirage`.`books` WHERE (book_title = :title)';
        $values = [':title' => $title];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        /* There is a result: get it's ID */
        if (is_array($row)) {
            $id = intval($row['book_id'], 10);
        }

        return $id;
    }
}

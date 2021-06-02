<?php

class Book
{
    private $title;

    public function __construct()
    {
        $this->title = NULL;
    }

    public function __destruct()
    {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    /* Add a new book to the library */
    public function createBook($title, $author_id, $genre, $year, $pages, $stock, $about)
    {
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

        $this->title = $title;

        $query = "INSERT INTO `books`(
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
    //TODO update fucntion to show pagination
    public function readBook(): array
    {
        global $pdo;

        $query = "SELECT * FROM `books` 
	            INNER JOIN `authors`
                ON `books`.`book_author_id`=`authors`.`author_id`
                ORDER BY `book_title`";

        try {
            $res = $pdo->prepare($query);
            $res->execute();
            $books = $res->fetchAll();
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
        return $books;
    }

    /* Update book */
    public function updateBook($id, $title, $author_id, $genre, $year, $pages, $stock, $about)
    {
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

        $this->title = $title;

        $query = 'UPDATE `books`
                    SET `book_id` = :id,
                    `book_title` = :title,
                    `book_author_id` = :author_id,                  
                    `book_genre` = :genre,
                    `book_year` = :year,
                    `book_pages` = :pages,
                    `book_stock` = :stock,
                    `book_about` = :about
                WHERE `book_id` = :id';

        $values = [
            'id' => $id,
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
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }
    }


    /* Delete the account (selected by its ID) */
    public function deleteBook(int $id)
    {
        /* Global $pdo object */
        global $pdo;

        /* Query template */
        $query = 'DELETE FROM books WHERE (book_id = :id)';

        $values = [':id' => $id];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Book form input validation */
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

    /* Function validates text input for book "title", "genre" and "about"
       $limit defines the maximum number of allowed characters */
    public function valText($title, $limit): bool
    {
        $result = TRUE;

        if (isset($title)) {
            /* Title length check */
            if ((mb_strlen($title) > $limit)) {
                $result = FALSE;
            }

            /* Check if the title consists of alpha-numeric and special characters */
            if (!preg_match('/^[a-zA-z0-9 ,.!().?";\'-]+$/i', $title)) {
                $result = FALSE;
            }
        } else {
            $result = FALSE;
        }
        return $result;
    }

    /* Function validates integer input */
    public function valNumber($number, $limit): bool
    {
        $result = TRUE;

        if (isset($number)) {
            /* Check if provided value is of integer type */
            if (filter_var($number, FILTER_VALIDATE_INT) === FALSE) {
                $result = FALSE;
            } else {
                /* Check if it is positive */
                if ($number < 0) {
                    $result = FALSE;
                }
                /* Check if the number does not exceed the limit */
                if (($number > $limit)) {
                    $result = FALSE;
                }
            }
        } else {
            $result = FALSE;
        }

        return $result;
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
        $query = 'SELECT `book_id` FROM `books` WHERE (book_title = :title)';
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

    /* Display the list of books */
    public function getBookById(int $id): ?array
    {
        /* Global $pdo object */
        global $pdo;

        /* Search the ID on the database */
        $query = "SELECT * FROM `books` 
	            INNER JOIN `authors`
                ON `books`.`book_author_id`=`authors`.`author_id`
                WHERE `book_id`=:book_id";

        $values = [':book_id' => $id];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }

        $result = $res->fetch(PDO::FETCH_ASSOC);

        return (is_array($result) ? $result :  NUll);
    }

    /* Function searches boo by book title or author name/surname */
    public function searchBook($search): ?array
    {
        global $pdo;

        if (!$this->valText($search, 100)) {
            throw new Exception('Not a valid search value');
        }

        $query = "SELECT `book_id`,`book_title`, `author_name`, `author_surname`
                    FROM `books`
                    INNER JOIN `authors` ON `books`.`book_author_id`=`authors`.`author_id`
                    WHERE `book_title`LIKE :search
                    OR `author_name` LIKE :search
                    OR `author_surname` LIKE :search";

        $values = [':search' => $search];

        try {
            $res = $pdo->prepare($query);
            $res->bindValue(':search', '%' . $search . '%');
            $res->execute();
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }

        $results = $res->fetchAll();

        return (is_array($results) ? $results :  NUll);
    }
}

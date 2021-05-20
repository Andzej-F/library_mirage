<?php
class Book
{
    private $id;
    private $title;
    private $genre;
    private $year;
    private $pages;
    private $stock;
    private $about;

    public function __construct()
    {
        $this->id = NULL;
        $this->title = NULL;
        $this->$genre = NULL;
        $this->$year = NULL;
        $this->$pages = NULL;
        $this->$stock = NULL;
        $this->$about = NULL;
    }

    public function __destruct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->name;
    }


    /* Add a new book to the library */
    public function createBook(
        int $id,
        string $title,
        int $author_id,
        string $genre,
        int $year,
        int $pages,
        int $stock,
        string $about
    ) {
        global $pdo;

        $title = trim($title);
        $genre = trim($genre);
        $year = trim($year);
        $pages = trim($pages);
        $stock = trim($stock);
        $about = trim($about);

        if (!$this->isIdValid($id)) {
            throw new Exception('Invalid book ID');
        }

        if (!$this->isTitleValid($title)) {
            throw new Exception('Invalid book title');
        }

        if (!$this->isIdValid($author_id)) {
            throw new Exception('Invalid book ID');
        }

        /* Check if the book with the same title already exists */
        if (!is_null($this->getIdFromTitle($title))) {
            throw new Exception('Book title already exists');
        }

        if (!$this->isGenreValid($genre)) {
            throw new Exception('Invalid book genre');
        }

        if (!$this->isYearValid($year)) {
            throw new Exception('Invalid book issue year');
        }

        if (!$this->isPagesValid($pages)) {
            throw new Exception('Invalid book pages');
        }

        if (!$this->isStockValid($stock)) {
            throw new Exception('Invalid book stock number');
        }

        if (!$this->isAboutValid($about)) {
            throw new Exception('Invalid book description');
        }

        $query = 'INSERT INTO `library_mirage`.`books` (book_title) VALUES (:title)';

        $values = [':title' => $title];

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* List library books */
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

    /* Update book */
    public function updateBook(int $id, string $title, int $author_id, string $genre, int $year, int $pages, int $stock, string $about)
    {
        global $pdo;

        $title = trim($title);
        $genre = trim($genre);
        $year = trim($year);
        $pages = trim($pages);
        $stock = trim($stock);
        $about = trim($about);

        /* Check if the ID is valid */
        if (!$this->isIdValid($id)) {
            throw new Exception('Invalid book ID');
        }

        /* Check if the user name is valid. */
        if (!$this->isTitleValid($title)) {
            throw new Exception('Invalid user name');
        }

        /* Check if the ID is valid */
        if (!$this->isIdValid($author_id)) {
            throw new Exception('Invalid book ID');
        }

        /* Check if an account having the same name already exists (except for this one). */
        $idFromName = $this->getIdFromName($name);

        if (!is_null($idFromName) && ($idFromName != $id)) {
            throw new Exception('User name already used');
        }

        /* Finally, edit the account */

        /* Edit query template */
        $query = 'UPDATE myschema.accounts SET account_name = :name, account_passwd = :passwd, account_enabled = :enabled WHERE account_id = :id';

        /* Password hash */
        $hash = password_hash(
            $passwd,
            PASSWORD_DEFAULT
        );

        /* Int value for the $enabled variable (0 = false, 1 = true) */
        $intEnabled = $enabled ? 1 : 0;

        /* Values array for PDO */
        $values = array(':name' => $name, ':passwd' => $hash, ':enabled' => $intEnabled, ':id' => $id);

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }
    }

    /* Delete an account (selected by its ID) */
    public function deleteAccount(int $id)
    {
        /* Global $pdo object */
        global $pdo;

        /* Check if the ID is valid */
        if (!$this->isIdValid($id)) {
            throw new Exception('Invalid account ID');
        }

        /* Query template */
        $query = 'DELETE FROM myschema.accounts WHERE (account_id = :id)';

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

        /* Delete the Sessions related to the account */
        $query = 'DELETE FROM myschema.account_sessions WHERE (account_id = :id)';

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

    /* Login with username and password */
    public function login(string $name, string $passwd): bool
    {
        /* Global $pdo object */
        global $pdo;

        /* Trim the strings to remove extra spaces */
        $name = trim($name);
        $passwd = trim($passwd);

        /* Check if the user name is valid. If not, return FALSE meaning the authentication failed */
        if (!$this->isNameValid($name)) {
            return FALSE;
        }

        /* Check if the password is valid. If not, return FALSE meaning the authentication failed */
        if (!$this->isPasswdValid($passwd)) {
            return FALSE;
        }

        /* Look for the account in the db. Note: the account must be enabled (account_enabled = 1) */
        $query = 'SELECT * FROM myschema.accounts WHERE (account_name = :name) AND (account_enabled = 1)';

        /* Values array for PDO */
        $values = array(':name' => $name);

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        /* If there is a result, we must check if the password matches using password_verify() */
        if (is_array($row)) {
            if (password_verify($passwd, $row['account_passwd'])) {
                /* Authentication succeeded. Set the class properties (id and name) */
                $this->id = intval($row['account_id'], 10);
                $this->name = $name;
                $this->authenticated = TRUE;

                /* Register the current Sessions on the database */
                $this->registerLoginSession();

                /* Finally, Return TRUE */
                return TRUE;
            }
        }

        /* If we are here, it means the authentication failed: return FALSE */
        return FALSE;
    }

    /* A sanitization check for the account username */
    public function isNameValid(string $name): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;

        /* Example check: the length must be between 8 and 16 chars */
        $len = mb_strlen($name);

        if (($len < 8) || ($len > 16)) {
            $valid = FALSE;
        }

        /* You can add more checks here */

        return $valid;
    }

    /* A sanitization check for the account password */
    public function isPasswdValid(string $passwd): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;

        /* Example check: the length must be between 8 and 16 chars */
        $len = mb_strlen($passwd);

        if (($len < 8) || ($len > 16)) {
            $valid = FALSE;
        }

        /* You can add more checks here */

        return $valid;
    }

    /* A sanitization check for the account ID */
    public function isIdValid(int $id): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;

        /* Example check: the ID must be between 1 and 1000000 */

        if (($id < 1) || ($id > 1000000)) {
            $valid = FALSE;
        }

        /* You can add more checks here */

        return $valid;
    }

    /* Login using Sessions */
    public function sessionLogin(): bool
    {
        /* Global $pdo object */
        global $pdo;

        /* Check that the Session has been started */
        if (session_status() == PHP_SESSION_ACTIVE) {
            /* 
				Query template to look for the current session ID on the account_sessions table.
				The query also make sure the Session is not older than 7 days
			*/
            $query =

                'SELECT * FROM myschema.account_sessions, myschema.accounts WHERE (account_sessions.session_id = :sid) ' .
                'AND (account_sessions.login_time >= (NOW() - INTERVAL 7 DAY)) AND (account_sessions.account_id = accounts.account_id) ' .
                'AND (accounts.account_enabled = 1)';

            /* Values array for PDO */
            $values = array(':sid' => session_id());

            /* Execute the query */
            try {
                $res = $pdo->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                /* If there is a PDO exception, throw a standard exception */
                throw new Exception('Database query error');
            }

            $row = $res->fetch(PDO::FETCH_ASSOC);

            if (is_array($row)) {
                /* Authentication succeeded. Set the class properties (id and name) and return TRUE*/
                $this->id = intval($row['account_id'], 10);
                $this->name = $row['account_name'];
                $this->authenticated = TRUE;

                return TRUE;
            }
        }

        /* If we are here, the authentication failed */
        return FALSE;
    }

    /* Logout the current user */
    public function logout()
    {
        /* Global $pdo object */
        global $pdo;

        /* If there is no logged in user, do nothing */
        if (is_null($this->id)) {
            return;
        }

        /* Reset the account-related properties */
        $this->id = NULL;
        $this->name = NULL;
        $this->authenticated = FALSE;

        /* If there is an open Session, remove it from the account_sessions table */
        if (session_status() == PHP_SESSION_ACTIVE) {
            /* Delete query */
            $query = 'DELETE FROM myschema.account_sessions WHERE (session_id = :sid)';

            /* Values array for PDO */
            $values = array(':sid' => session_id());

            /* Execute the query */
            try {
                $res = $pdo->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                /* If there is a PDO exception, throw a standard exception */
                throw new Exception('Database query error');
            }
        }
    }

    /* Close all account Sessions except for the current one (aka: "logout from other devices") */
    public function closeOtherSessions()
    {
        /* Global $pdo object */
        global $pdo;

        /* If there is no logged in user, do nothing */
        if (is_null($this->id)) {
            return;
        }

        /* Check that a Session has been started */
        if (session_status() == PHP_SESSION_ACTIVE) {
            /* Delete all account Sessions with session_id different from the current one */
            $query = 'DELETE FROM myschema.account_sessions WHERE (session_id != :sid) AND (account_id = :account_id)';

            /* Values array for PDO */
            $values = array(':sid' => session_id(), ':account_id' => $this->id);

            /* Execute the query */
            try {
                $res = $pdo->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                /* If there is a PDO exception, throw a standard exception */
                throw new Exception('Database query error');
            }
        }
    }

    /* Returns the account id having $name as name, or NULL if it's not found */
    public function getIdFromName(string $name): ?int
    {
        /* Global $pdo object */
        global $pdo;

        /* Since this method is public, we check $name again here */
        if (!$this->isNameValid($name)) {
            throw new Exception('Invalid user name');
        }

        /* Initialize the return value. If no account is found, return NULL */
        $id = NULL;

        /* Search the ID on the database */
        $query = 'SELECT account_id FROM myschema.accounts WHERE (account_name = :name)';
        $values = array(':name' => $name);

        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        $row = $res->fetch(PDO::FETCH_ASSOC);

        /* There is a result: get it's ID */
        if (is_array($row)) {
            $id = intval($row['account_id'], 10);
        }

        return $id;
    }


    /* Private class methods */

    /* Saves the current Session ID with the account ID */
    private function registerLoginSession()
    {
        /* Global $pdo object */
        global $pdo;

        /* Check that a Session has been started */
        if (session_status() == PHP_SESSION_ACTIVE) {
            /* 	Use a REPLACE statement to:
				- insert a new row with the session id, if it doesn't exist, or...
				- update the row having the session id, if it does exist.
			*/
            $query = 'REPLACE INTO myschema.account_sessions (session_id, account_id, login_time) VALUES (:sid, :accountId, NOW())';
            $values = array(':sid' => session_id(), ':accountId' => $this->id);

            /* Execute the query */
            try {
                $res = $pdo->prepare($query);
                $res->execute($values);
            } catch (PDOException $e) {
                /* If there is a PDO exception, throw a standard exception */
                throw new Exception('Database query error');
            }
        }
    }
}

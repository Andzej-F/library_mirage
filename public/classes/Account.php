<?php
/*
 * 	The original(complete) Account class file can be downloaded from Alex Web Develop
 *  "PHP Login and Authentication Tutorial":
 * 	
 * 	https://alexwebdevelop.com/user-authentication/

 * 	You are free to use and share this script as you like.
 * 	If you want to share it, please leave this disclaimer inside.
*/

class Account
{
    /* The ID of the logged in account */
    private $id;

    /* The email of the logged in account */
    private $email;

    public function __construct()
    {
        /* Initialize the $id and $email variables to NULL */
        $this->id = NULL;
        $this->email = NULL;
    }

    public function __destruct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /* Add a new account to the library and return its ID */
    public function addAccount(string $email, string $passwd, string $role): int
    {
        /* Global $pdo object */
        global $pdo;

        /* Trim the strings to remove extra spaces */
        $email = trim($email);
        $passwd = trim($passwd);

        /* Check if the user email is valid. If not, throw an exception */
        if (!$this->isEmailValid($email)) {
            throw new Exception('Not valid user email');
        }

        /* Check if the password is valid. If not, throw an exception */
        if (!$this->isPasswdValid($passwd)) {
            throw new Exception('Not valid password');
        }

        /* Check if an account having the same email already exists.
           If it does, throw an exception */
        if (!is_null($this->getIdFromEmail($email))) {
            throw new Exception('User email not available');
        }

        /* Insert query template */
        $query = 'INSERT INTO accounts (acct_email, acct_passwd, acct_role)
                  VALUES (:email, :passwd, :role)';

        /* Password hash */
        $hash = password_hash($passwd, PASSWORD_DEFAULT);

        /* Values array for PDO */
        $values = array(':email' => $email, ':passwd' => $hash, ':role' => $role);

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }

        /* If validation was successful set the class properties*/
        $this->id = $pdo->lastInsertId();
        $this->email = $email;

        /* Enable reader login session, because addAccount method applies only to readers (not librarians)*/
        $_SESSION['reader_login'] = $this->email;

        /* Return the new ID */
        return $pdo->lastInsertId();
    }

    /* Delete an account (selected by its ID) */
    public function deleteAccount(int $id)
    {
        /* Global $pdo object */
        global $pdo;

        /* Check if the ID is valid */
        if (!$this->isIdValid($id)) {
            throw new Exception('Not valid account ID');
        }

        /* Query template */
        $query = 'DELETE FROM accounts WHERE (acct_id = :id)';

        /* Values array for PDO */
        $values = array(':id' => $id);

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            throw new Exception('Database query error');
        }
    }

    /* Edit an account (selected by its ID). Email and password can be changed.*/
    public function editAccount(int $id, string $email, string $passwd)
    {
        /* Global $pdo object */
        global $pdo;

        /* Trim the strings to remove extra spaces */
        $email = trim($email);
        $passwd = trim($passwd);

        /* Check if the ID is valid */
        if (!$this->isIdValid($id)) {
            throw new Exception('Not valid account ID');
        }

        /* Check if the user email is valid. */
        if (!$this->isEmailValid($email)) {
            throw new Exception('Not valid user email');
        }

        /* Check if the password is valid. */
        if (!$this->isPasswdValid($passwd)) {
            throw new Exception('Not valid password');
        }

        /* Check if an account having the same email already exists (except for this one). */
        $idFromEmail = $this->getIdFromEmail($email);

        if (!is_null($idFromEmail) && ($idFromEmail != $id)) {
            throw new Exception('User email already used');
        }

        /* If validation was successful set the class properties*/
        $this->id = $id;
        $this->email = $email;

        /* Edit query template */
        $query = 'UPDATE accounts 
                 SET acct_email = :email, acct_passwd = :passwd
                 WHERE acct_id = :id';

        /* Password hash */
        $hash = password_hash($passwd, PASSWORD_DEFAULT);

        /* Values array for PDO */
        $values = array(
            ':id' => $id,
            ':email' => $email,
            ':passwd' => $hash
        );

        /* Execute the query */
        try {
            $res = $pdo->prepare($query);
            $res->execute($values);
        } catch (PDOException $e) {
            /* If there is a PDO exception, throw a standard exception */
            throw new Exception('Database query error');
        }
    }

    /* Login with useremail and password */
    public function login(string $email, string $passwd)
    {
        /* Global $pdo object */
        global $pdo;

        /* Trim the strings to remove extra spaces */
        $email = trim($email);
        $passwd = trim($passwd);

        /* Check if the user email is valid. */
        if (!$this->isEmailValid($email)) {
            throw new Exception('Not valid user email');
        }

        /* Check if the password is valid. */
        if (!$this->isPasswdValid($passwd)) {
            throw new Exception('Not valid user password');
        }

        /* Look for the account in the database. */
        $query = 'SELECT * FROM accounts 
                  WHERE (acct_email = :email)';

        /* Values array for PDO */
        $values = array(':email' => $email);

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
            if (password_verify($passwd, $row['acct_passwd'])) {
                /* Authentication succeeded. Set the class properties (id and email) */
                $this->id = intval($row['acct_id'], 10);
                $this->email = $email;

                /* Register current sessions  */
                if ($row['acct_role'] === 'librarian') {
                    $_SESSION['libr_login'] = $this->email;
                }

                if ($row['acct_role'] === 'reader') {
                    $_SESSION['reader_login'] = $this->email;
                    $_SESSION['acct_id'] = $this->id;
                }

                /* Finally, Return TRUE */
                return TRUE;
            }

            /* If wrong password provided, throw an exception */
            throw new Exception('Wrong password');
        }

        /* If the authentication failed, throw an exception */
        throw new Exception('User does not exist');
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
        $this->email = NULL;
    }

    /* A sanitization check for the account email */
    public function isEmailValid(string $email): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;

        if (isset($email)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
                $valid = FALSE;
            }
        } else {
            $valid = FALSE;
        }
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

        return $valid;
    }

    /* A sanitization check for the account password */
    public function isPasswdValid(string $passwd): bool
    {
        /* Initialize the return variable */
        $valid = TRUE;

        /* Check the password length. */
        $passLength = mb_strlen($passwd);
        if (isset($passwd)) {
            if ($passLength < 3) {
                $valid = FALSE;
            }

            if ($passLength > 40) {
                $valid = FALSE;
            }

            /* Check that the password contains both letters and numbers. */
            if (ctype_alpha($passwd)) {
                $valid = FALSE;
            }

            if (ctype_digit($passwd)) {
                $valid = FALSE;
            }
        } else {
            $valid = FALSE;
        }
        return $valid;
    }

    /* Returns the account id having $email as email, or NULL if it's not found */
    public function getIdFromEmail(string $email): ?int
    {
        /* Global $pdo object */
        global $pdo;

        /* Since this method is public, we check $email again here */
        if (!$this->isEmailValid($email)) {
            throw new Exception('Not valid user email');
        }

        /* Initialize the return value. If no account is found, return NULL */
        $id = NULL;

        /* Search the ID on the database */
        $query = 'SELECT acct_id FROM accounts 
                  WHERE (acct_email = :email)';

        $values = array(':email' => $email);

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
            $id = intval($row['acct_id'], 10);
        }

        return $id;
    }
}

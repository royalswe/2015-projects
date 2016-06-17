<?php

namespace dal;

use model\SessionStorage;

class User
{
    private $sessionStorage;

    public function __construct()
    {
        $this->sessionStorage = new SessionStorage();
    }
    /**
     * Register a new user
     *
     * @param \model\User $credential
     * @param \model\IListener $listener
     * @return bool
     */
    public function doRegister(\model\User $credential, \model\IListener $listener)
    {
        $username = $credential->getUsername();

        $records = new \Db();
        $records->query('SELECT username,password FROM users WHERE username = :username');
        $records->bind(':username', $username);
        $records->resultset();

        if ($records->rowCount() > 0) {
            $listener->errorListener("Register::UserAlreadyExistException");
        } else {
            $password = password_hash($credential->getPassword(), PASSWORD_BCRYPT);

            $records->query('INSERT INTO users (username, password) VALUES (:username, :password)');
            $records->bind(':username', $username);
            $records->bind(':password', $password);
            $records->execute();

            $this->sessionStorage->set(SessionStorage::$auth, $username);

            return true;
        }

    }

    /**
     * Login user
     *
     * @param \model\User $credential
     * @return bool
     */
    public function doLogin(\model\User $credential)
    {
        $username = $credential->getUsername();
        $password = $credential->getPassword();

        $records = new \Db();

        $records->query('SELECT username, password FROM users WHERE BINARY username = :username');
        $records->bind(':username', $username);
        $results = $records->single();
        if (count($results) > 0 && password_verify($password, $results['password'])) {
            return $this->sessionStorage->set(SessionStorage::$auth, $username);
        } else {
            return false;
        }
    }
}
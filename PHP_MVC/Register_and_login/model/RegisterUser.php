<?php

namespace model;

class RegisterUser
{
    private $username;
    private $password;

    /**
     * @param $username
     * @param $password
     * @throws \NameAndPasswordLengthException
     * @throws \PasswordLengthException
     * @throws \UsernameInvalidCharactersException
     * @throws \UsernameLengthException
     */
    public function __construct($username, $password)
    {
        if (mb_strlen($username) < 3 && mb_strlen($password) < 6)
            throw new \NameAndPasswordLengthException();
        if (mb_strlen($username) < 3)
            throw new \UsernameLengthException();
        if (mb_strlen($password) < 6)
            throw new \PasswordLengthException();
        if (filter_var($username, FILTER_SANITIZE_STRING) !== $username)
            throw new \UsernameInvalidCharactersException();


        $this->username = htmlspecialchars($username);
        $this->password = htmlspecialchars($password);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

}
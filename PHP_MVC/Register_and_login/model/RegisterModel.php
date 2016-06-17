<?php


class RegisterModel
{

    public static $newUsername = 'RegisterModel::newUsername';

    /**
     * Register a new user if username doesn't already exist
     *
     * @param \model\RegisterUser $credential
     * @param \model\IregisterListener $listener
     * @return bool
     */
    public function doRegister(\model\RegisterUser $credential, model\IregisterListener $listener)
    {
        $username = $credential->getUsername();

        $records = new Db();
        $records->query('SELECT username,password FROM users WHERE username = :username');
        $records->bind(':username', $username);
        $records->resultset();

        if ($records->rowCount() > 0) {
            $listener->userExist("RegisterModel::UserAlreadyExistException");
        } else {
            $password = password_hash($credential->getPassword(), PASSWORD_BCRYPT);

            $records->query('INSERT INTO users (username, password) VALUES (:username, :password)');
            $records->bind(':username', $username);
            $records->bind(':password', $password);
            $records->execute();

            $_SESSION[self::$newUsername] = $username;
            return true;
        }

    }
}
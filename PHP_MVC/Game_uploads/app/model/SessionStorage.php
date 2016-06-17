<?php

namespace model;
session_start();

class SessionStorage
{
    public static $auth = 'auth';

    public function set($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public function exist($key)
    {
        return isset($_SESSION[$key]);
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

}
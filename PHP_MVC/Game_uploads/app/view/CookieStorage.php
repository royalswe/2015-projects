<?php

namespace view;

class CookieStorage
{

    public function save($cookieName, $key)
    {
        setcookie($cookieName, $key);
        $_COOKIE[$cookieName] = $key; // hack to update cookie
    }

    public function load($cookieName)
    {
        return isset($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : false;
    }

    public function remove($cookieName)
    {
        unset($_COOKIE[$cookieName]);
        setcookie($cookieName, '', time() - 3600); // remove twice to be extra sure
    }

}
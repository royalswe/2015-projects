<?php

namespace model;


class Login
{
    private $sessionStorage;

    public function __construct()
    {
        $this->sessionStorage = new SessionStorage();
    }

    public function isLoggedIn()
    {
        return $this->sessionStorage->exist(SessionStorage::$auth);
    }

    public function logoutUser()
    {
        return $this->sessionStorage->delete(SessionStorage::$auth);
    }
}
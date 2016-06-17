<?php

namespace view;


use model\SessionStorage;

class NavBar
{
    private $sessionStorage;
    private $cookieStorage;

    public function __construct()
    {
        $this->sessionStorage = new SessionStorage();
        $this->cookieStorage = new CookieStorage();
    }
    public function navigationMenu()
    {
        if($this->isLoggedIn()){
            return
                '<div class="links">
                        <a href="'. parse_ini_file('.env')['site'] .'">Home</a>
                        <a href="addgames">Add Games</a>
                        <a href="login?logout">Logout</a>
                 </div>';
        }
        else{
            return
                '<div class="links">
                        <a href="'. parse_ini_file('.env')['site'] .'">Home</a>
                        <a href="addgames">Add Games</a>
                        <a href="register">Register</a>
                        <a href="login">Login</a>
                 </div>';
        }
    }

    public function isLoggedIn()
    {
        return $this->sessionStorage->exist(SessionStorage::$auth) ||
        $this->cookieStorage->load('view\Login::CookieName');
    }

}
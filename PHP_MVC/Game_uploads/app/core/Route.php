<?php


class Route
{
    private $url;

    /**
     * The route system.
     * checks given url and returns suited controller and method.
     */
    public function __construct()
    {
        if(isset($_GET['url'])){
            // sanitize url for extra security doesn't hurt
            $this->url = filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL);

            switch($this->url) {
                case 'login':
                    $this->url = 'LoginController/doControl';
                    break;
                case 'register':
                    $this->url = 'RegisterController/doControl';
                    break;
                case 'addgames':
                    $this->url = 'AddGameController/index';
                    break;
            }
        }
        else{
            $this->url = 'HomeController/index';
        }

    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->url;
    }

}

<?php


class App
{
    protected $controller = 'Pages';

    protected $method = 'error404';

    protected $params = [];

    public function getController()
    {
        $url = $this->parseUrl();

        /**
         * Check if the given url exist in the controller directory
         * unset url so the remaining url go to the params
         */

        if (file_exists('../app/controller/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        /**
         * include class so we can control it
         */
        require_once '../app/controller/' . $this->controller . '.php';

        /**
         * Check if a second url is given and if the method exist in the given class
         * unset url so the remaining url go to the params
         */
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        } /**
         * set controller to Pages so user can see the 404 error page
         */
        else {
            $this->controller = 'Pages';
            require_once '../app/controller/' . $this->controller . '.php';
        }

        $this->controller = new $this->controller();

        /**
         * give params the url that are left if there are any
         */
        $this->params = $url ?: [];

        return call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        $getURL = new Route;
        $getURL->__toString();

        return $url = explode('/', $getURL);
    }
}
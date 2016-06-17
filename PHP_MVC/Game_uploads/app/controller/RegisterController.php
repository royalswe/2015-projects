<?php

require_once('../app/model/User.php');


class RegisterController extends Controller
{
    private $view;
    private $dal;

    public function __construct()
    {
        $this->dal = $this->dal('dal', 'User');
        $this->view = $this->view('view', 'Register');
    }

    public function doControl()
    {
        if ($this->view->userWantsToRegister()) {

            $credentials = $this->view->getCredentials();
            if ($credentials) {
                if ($this->dal->doRegister($credentials, $this->view) == true)
                    $this->view->redirectToHomePage();
            }
        }

       return $this->view->response();

    }
}
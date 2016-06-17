<?php
require_once('../app/model/User.php');

class LoginController extends Controller
{
    private $dal;
    private $model;
    private $view;

    public function __construct()
    {
        $this->dal = $this->dal('dal', 'User');
        $this->model = $this->model('model', 'Login');
        $this->view = $this->view('view', 'Login', $this->model);
    }

    public function doControl()
    {
        if ($this->model->isLoggedIn() || $this->view->doCookieExist()) {
            if ($this->view->userWantsToLogout()) {
                $this->model->logoutUser();
            }
        } else {
            if ($this->view->userWantsToLogin()) {
                $credential = $this->view->getCredentials();
                if ($credential) {
                    if ($this->dal->doLogin($credential) == true) {
                        $this->view->redirectToHomePage();
                    } else {
                        $this->view->loginSuccess = false;
                    }
                }

            }

        }

        return $this->view->response();

    }


}
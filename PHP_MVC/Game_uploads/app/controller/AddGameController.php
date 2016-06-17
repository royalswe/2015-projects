<?php

require_once('../app/exceptions/FileSizeException.php');

class AddGameController extends Controller
{
    private $view;
    private $dal;
    private $session;

    public function __construct()
    {
        $this->view = $this->view('view', 'AddGame');
        $this->dal = $this->dal('dal', 'Game');
        $this->session = $this->model('model', 'SessionStorage');
    }

    public function index()
    {

        if (!$this->session->exist(\model\SessionStorage::$auth))
            return $this->view->notLoggedIn();

        if ($this->view->submitClicked()) {

                $credentials = $this->view->addingGame();
                if ($credentials) {
                    if($this->dal->add($credentials, $this->view) == true){
                        $this->view->addGameSuccess();
                    }
                }

        }
        else{
            $this->view->getSessionMessage();
        }

        return $this->view->render();

    }
}
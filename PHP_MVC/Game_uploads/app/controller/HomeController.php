<?php


class HomeController extends Controller
{
    private $view;
    private $dal;
    private $model;
    private $navigation;
    private $gameView;

    public function __construct()
    {
        $this->model = $this->model('model', 'GameList');
        $this->dal = $this->dal('dal', 'Game');
        $this->navigation = $this->view('view', 'Navigation');
        $this->view = $this->view('view', 'Home', $this->model, $this->navigation);
    }

    public function index()
    {
        $this->dal->getGames($this->model);

        if ($this->navigation->gameIsSelected()) {
            $selectedGame = $this->view->getSelectedGame();
            $this->gameView = $this->view('view', 'Game');

            return  $this->gameView->showGame($selectedGame);
        }

        return $this->view->render();
    }
}
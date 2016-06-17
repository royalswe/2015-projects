<?php

namespace view;

use model\GameList;

class Home
{
    private $gameList;
    private $navigation;

    public function __construct(GameList $gameList, Navigation $navigation)
    {
        $this->gameList = $gameList;
        $this->navigation = $navigation;
    }
    public function render()
    {
        $gameList = $this->gameList->getGames();

        $render = "<ul>";
        foreach ($gameList as $game) {
            $title = $game->getTitle();
            $img = $game->getImage();
            $urlID = $game->getGameID();
            $url = $this->navigation->getGameURL($urlID);

            $render .= '<li class="gameBox"><a href="'. $url .'/'. str_replace(' ','-',$title) .'">
                <h2 class="gameTitle">'. $title .'</h2>
                <img class="gameImg"
                src="'. dirname($_SERVER['PHP_SELF']) .'/images/'. $img .'"
                title="play '. $title .'"
                alt="play '. $title .'">
            </a></li>';
        }
        $render .= "</ul>";
        return "<h2>List of games</h2> $render";

    }

    public function getSelectedGame() {
        assert($this->navigation->gameIsSelected());
        $unique = $this->navigation->getGameID();

        $game = $this->gameList->getGameByID($unique);

        if ($game != null)
            return $game;

        throw new \Exception("unknown game id");
    }


}
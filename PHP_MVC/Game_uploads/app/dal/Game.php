<?php

namespace dal;

use model\GameList;

class Game
{

    private $db;
    private $gameList;

    public function __construct() {
        $this->db = new \Db();
    }

    /**
     * Add new games to db and game catalog
     *
     * @param \model\Game $credential
     * @param \model\IListener $listener
     * @return bool
     */
    public function add(\model\Game $credential, \model\IListener $listener)
    {
        try {
            $random = rand(0, pow(10, 5)) . '-'; // 5 digit random number to prefix game and img name
            $gameDirectory = "../public/games/"; // path to game directory
            $imgDirectory = "../public/images/"; // path to image directory


            $title = $credential->getTitle();
            $gameFile = $random . $credential->getGameFile()["name"];
            $imgFile = $random . $credential->getImage()["name"];

            $targetFile = $gameDirectory . $gameFile;
            $targetImg = $imgDirectory . $imgFile;

            // Move img and game file to the given directory
            move_uploaded_file($credential->getGameFile()["tmp_name"], $targetFile);
            move_uploaded_file($credential->getImage()["tmp_name"], $targetImg);

            $records = $this->db;

            $records->query('INSERT INTO game (title, game, img) VALUES (:title, :game, :img)');
            $records->bind(':title', $title);
            $records->bind(':game', $gameFile);
            $records->bind(':img', $imgFile);
            $records->execute();

            return true;

        } catch (\Exception $e) {
            $listener->errorListener("AddGameDal::CouldNotAddGameException");
        }

    }

    /**
     * @param GameList $gameList
     * @return GameList
     */
    public function getGames(GameList $gameList) {

        $this->gameList = $gameList;

        $this->db;

        $records = new \Db();
        $records->query('SELECT * FROM game');

        $rows = $records->resultset();

        foreach($rows as $row){
            $game = new \model\Game($row['title'], $row['game'],  $row['img'], $row['id']);
            $this->gameList->add($game);
        }

        return  $this->gameList;
    }
}
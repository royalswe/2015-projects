<?php

namespace model;


class GameList
{

    private $games = array();

    /**
     * Adds the games id as array name
     * @param Game $toBeAdded
     */
    public function add(Game $toBeAdded) {
        $key = $toBeAdded->getGameID();
        $this->games[$key] = $toBeAdded;
    }

    public function getGames() {
        return $this->games;
    }

    public function getGameByID($id) {

        if (isset($this->games[$id])) {
            return $this->games[$id];
        }
        return null;
    }
}
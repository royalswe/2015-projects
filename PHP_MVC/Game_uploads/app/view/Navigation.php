<?php

namespace view;


class Navigation
{

    private static $gameURLID = 'game';

    public function gameIsSelected() {
        if (isset($_GET[self::$gameURLID]))  {
            return true;
        }
        return false;
    }

    public function getGameURL($unique) {
        return "?".self::$gameURLID."=$unique";
    }

    public function getGameID() {
        assert($this->gameIsSelected());
        // Remove game name from url
        $output = dirname($_GET[self::$gameURLID]);
        return $output;
    }
}
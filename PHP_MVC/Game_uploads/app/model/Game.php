<?php

namespace model;

class Game
{
    private $title;
    private $game;
    private $image;
    private $fileExtension;
    private $gameID;

    private $validImgMimeTypes = array(
        'image/gif',
        'image/png',
        'image/jpeg',
        'image/pjpeg'
    );

    private $validGameMimeTypes = array(
        'application/x-shockwave-flash',
        'application/vnd.unity',
        'application/octet-stream'
    );

    private $validFileTypes = array(
        'swf',
        'unity3d'
    );

    private $validImgTypes = array(
        'jpg',
        'jpeg',
        'png',
        'gif'
    );


    /**
     * @param $title
     * @param $game
     * @param null $id
     * @throws \FileExtensionException
     */
    public function __construct($title, $game, $image, $id = null)
    {
        /**
         * If game file comes from add new game it is an array.
         * Then we also want to check if mime type
         */
        if(is_array($game)){
            if (!in_array($game['type'], $this->validGameMimeTypes) || !in_array($image['type'], $this->validImgMimeTypes))
                throw new \FileExtensionException();

            if ($game["size"] > 20000000 || $image["size"] > 4000000) // Game cant be greater than 20mb and img 4mb
                throw new \FileSizeException();
        }

        /**
         * Check if filename has a valid file extension from array
         */
        $thisGame = (is_array($game) ? $game['name'] : $game);
        $thisImage = (is_array($image) ? $image['name'] : $image);

        $fileExt = strtolower(pathinfo($thisGame, PATHINFO_EXTENSION));
        $imgExt = strtolower(pathinfo($thisImage, PATHINFO_EXTENSION));

        if (!in_array($fileExt, $this->validFileTypes) || !in_array($imgExt, $this->validImgTypes))
            throw new \FileExtensionException();


        $this->title = htmlspecialchars($title);
        $this->game = $game;
        $this->image = $image;
        $this->fileExtension = $fileExt;
        $this->gameID = $id;

    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getGameFile()
    {
        return $this->game;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    public function getGameID()
    {
        return $this->gameID;
    }

}
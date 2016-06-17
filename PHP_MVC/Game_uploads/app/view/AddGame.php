<?php

namespace view;

use model\IListener;

class AddGame implements IListener
{

    private static $messageId = 'view\AddGame::Message';
    private static $title = 'view\AddGame::Title';
    private static $gameFile = 'view\AddGame::GameFile';
    private static $image = 'view\AddGame::Image';
    private static $addGame = 'view\AddGame::Game';

    private static $sessionSaveMessage = 'view\AddGame::SessionSaveMessage';

    private $message;

    public function render()
    {
        return '
        <h2>Add Game</h2>
			<form method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Add Game</legend>
					<p id="' . self::$messageId . '">' . $this->message . '</p>

					<label for="' . self::$title . '">Title :</label>
					<input type="text" id="' . self::$title . '" name="' . self::$title . '" value="' . $this->getTitle() . '" />
					<br>
                    <input type="file" id="' . self::$gameFile . '" name="' . self::$gameFile . '"/> (swf/unity)</td>
                    <br>
                    <input type="file" id="' . self::$image . '" name="' . self::$image . '"/> (jpg/png/gif)</td>
                    <br>
					<input type="submit" name="' . self::$addGame . '" value="Submit Game" />
				</fieldset>
			</form>
		';
    }

    public function addingGame()
    {

        try{
            $title = $this->getTitle();
            $gameFile = $this->getFileName();
            $image = $this->getImage();

            if(!empty($this->message))
                throw new \Exception();

            return new \model\Game(
                $title,
                $gameFile,
                $image
            );
        } catch(\FileSizeException $e){
            $this->message .= "File is to large";
        } catch(\FileExtensionException $e){
            $this->message .= "This file type is not excepted";
        } catch(\Exception $e){

        }

    }

    public function getTitle()
    {
        if(isset($_POST[self::$title])){
            if (strlen($_POST[self::$title]) < 3)
                $this->message .= 'Game title has too bee at least 3 characters.<br>';

            if (filter_var($_POST[self::$title], FILTER_SANITIZE_STRING) !== $_POST[self::$title]) {
                $this->message .= 'Game title contains invalid characters.<br>';
                $_POST[self::$title] = strip_tags($_POST[self::$title]);
            }

            return trim($_POST[self::$title]);
        }
    }

    public function getFileName()
    {
        if(!empty($_FILES[self::$gameFile]["name"])){
            return $_FILES[self::$gameFile];
        }
        else{
            $this->message .= 'Game file needs to bee included<br>';
        }
    }

    public function getImage()
    {
        if(!empty($_FILES[self::$image]["name"])){
            return $_FILES[self::$image];
        }
        else{
            $this->message .= 'Image needs to bee included<br>';
        }
    }

    public function submitClicked()
    {
        return isset($_POST[self::$addGame]);
    }

    public function notLoggedIn()
    {
        return '<h2>Please login to add games</h2>';
    }

    public function addGameSuccess()
    {
        $this->redirect('Game successfully added');
    }

    public function getSessionMessage() {
        if (isset($_SESSION[self::$sessionSaveMessage])) {
            $this->message = $_SESSION[self::$sessionSaveMessage];
            unset($_SESSION[self::$sessionSaveMessage]);
        }
        return;
    }

    public function redirect($message)
    {
        $_SESSION[self::$sessionSaveMessage] = $message;
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    public function errorListener($listener)
    {
        $this->message = "Sorry we couldn't add your game";
    }

}
<?php

namespace view;


class Game
{
    private $game;

    public function showGame($selectedGame)
    {

        $title = $selectedGame->getTitle();
        $this->game = $selectedGame->getGameFile();
        $type = $selectedGame->getFileExtension();

        switch($type) {
            case 'swf':
                $output = $this->renderSWF();
                break;
            case 'unity3d':
                $output = $this->renderUnity();
                break;
        }


    return'
        <h1 class="gameHeader">'. $title .'</h1>
        <div id="gameDiv">
            '. $output .'
        </div>
            ';
    }

    public function renderSWF()
    {
        return'
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://www.adobe.com/go/getflashplayer" width="100%" height="100%" align="middle">
                <param name="quality" value="high" />
                <param name="menu" value="true">
                <embed width="100%" height="100%" src="'. dirname($_SERVER['PHP_SELF']) .'/games/'. $this->game .'" width="100%" height="100%" align="middle" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
            </object>
        ';
    }

    public function renderUnity()
    {
        return'
        <object id="UnityObject" classid="clsid:444785F1-DE89-4295-863A-D46C3A781394"
            width="100%" height="100%"
            codebase="http://webplayer.unity3d.com/download_webplayer/UnityWebPlayer.cab#version=2,0,0,0">
            <embed id="UnityEmbed" src="'. dirname($_SERVER['PHP_SELF']) .'/games/'. $this->game .'" width="100%" height="100%"
            type="application/vnd.unity" pluginspage="http://www.unity3d.com/unity-web-player-2.x" />
        </object>
    ';
    }

}
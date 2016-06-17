<?php

class Pages
{
    public function error404()
    {
        return'
        <div class="error404">
            <object codebase="http://www.adobe.com/go/getflashplayer" width="100%" height="100%" align="middle">
                <param name="quality" value="high" />
                <param name="menu" value="true">
                <embed width="100%" height="100%" src="'. dirname($_SERVER['PHP_SELF']) .'/games/pacman.swf" width="100%" height="100%" align="middle" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"></embed>
            </object>
        </div>
        ';
    }
}
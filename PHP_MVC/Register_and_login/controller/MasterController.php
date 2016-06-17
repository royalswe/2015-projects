<?php


class MasterController
{

    /**
     * Choose controller depending on the URL
     */
    public function doControl()
    {
        $getURL = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        if (strpos($getURL, 'register')) {
            $rc = new RegisterController();
            $rc->doControl();
        } else {
            $lc = new LoginController();
            $lc->doControl();
        }

    }
}
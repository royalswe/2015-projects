<?php

//INCLUDE THE FILES NEEDED...
require_once('view/DateTimeView.php');
require_once('view/LayoutView.php');
require_once('view/CookieStorage.php');
require_once('controller/LoginController.php');
require_once('controller/MasterController.php');
require_once('controller/RegisterController.php');

//MAKE SURE ERRORS ARE SHOWN... MIGHT WANT TO TURN THIS OFF ON A PUBLIC SERVER
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$mc = new MasterController();
$mc->doControl();
<?php


require_once('../app/init.php');

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


$app = new App;
$renderOutput = $app->getController();


$layout = new Layout;
$layout->render($renderOutput);
<?php
session_start();
if (isset($_SESSION['lifetime'])){
    if ((time() - $_SESSION['lifetime']) >= 1440 ){
        session_destroy();
    }
}
if(!isset($_SESSION['lifetime'])){
    $_SESSION['lifetime'] = time();
}

define('ROOT', dirname(__FILE__));
require_once (ROOT.'/components/Router.php');
require_once (ROOT.'/components/Db.php');
require_once (ROOT.'/components/InputCleaner.php');
require_once (ROOT.'/components/Encrypter.php');

$router = new Router();
$router->run();



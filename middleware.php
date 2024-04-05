<?php

require_once('config.php');
require_once('helpers/debug.php');


require_once('model/dataBase.php');
require_once 'model/dictionaryModel.php';
require_once 'model/moduleModel.php';
require_once 'model/userModel.php';

$db = new DataBase($dbConfig);
$db->connect();

$GLOBALS['db'] = $db;

//$request = $_SERVER['REQUEST_URI'];
//$viewDir = '/views/';
/*
m_log($request, 'request', 'middleware');

session_start();

if(!isset($_SESSION['loggedInStatus'])){
    $_SESSION['message'] = "Login to continue..."; 
    header('Location: login.php');
    exit();
}
*/


//$user_id = 1;
//m_log($_SESSION, '_SESSION', 'middleware');
?>
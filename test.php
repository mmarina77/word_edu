<?php

require_once('config.php');
require_once('helpers/debug.php');
require_once('helpers/enums.php');

echo "<div>getcwd() = ".getcwd()."</div>";
echo "<div>dirname(__FILE__, 2); = ".dirname(__FILE__)."</div>";
echo "<div>currentPath = ".currentPath()."</div>";
echo "<div>code = ".RESULT_STATUS::DUPLICATE_WORD."</div>";

dump($config);

$logPath = currentPath() . 'logs/' . date('Y-m-d') . '/';
make_dir($logPath);

dump($logPath);
file_put_contents($logPath, 'C:/xampp/htdocs/dic/logs/log.log', FILE_APPEND);

dump($_SERVER);


define ("RESULT_STATUS", json_encode(array ("apple", "cherry", "banana")));    
$fruits = json_decode (FRUITS);    
var_dump($fruits);

?>
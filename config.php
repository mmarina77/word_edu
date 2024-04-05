<?php

define('APPLICATION_PATH', str_replace('\\', "/", dirname(__FILE__)) . '/');
define('APPLICATION_URL', 'http://localhost/dic/');


$config = [];

$dbConfig = [
	'host' => 'localhost',
	'username' => 'root',
	'password' => '',
	'dbname' => 'education'
];


$config = [
	'app_path' => APPLICATION_PATH,
	
	'oxford' => [
		'app_id' => 'd45411f4',
		'app_key' => '6664972cd3f9f91401bef980f80a1cd2',
		'language' => 'en-gb'
	]
];



?>
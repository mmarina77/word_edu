<?php

function currentPath() {
	
	//return str_replace('\\', "/", APPLICATION_PATH) . '/';
	return APPLICATION_PATH;
}

function dump($data) {
	echo '<pre>';
	var_dump($data);
	echo '</pre>';
}

if (!function_exists('make_dir')) {
	function make_dir($path) {
		$p = str_replace('\\', "/", $path);
		if (!file_exists($p) && !is_dir($p)) { //create the folder if it's not already exists
			mkdir($p, 0777, TRUE);
		}
	}
}


function m_log($log_text, $title = '', $filename = '', $folder = '') {

	$logPath = APPLICATION_PATH . 'logs/' . date('Y-m-d') . '/';

	//file_put_contents($logPath, 'C:/xampp/htdocs/dic/logs/log.log', FILE_APPEND);

	$file = !empty($filename) ? $filename : 'dev_log';
	if (!empty($folder)) {
		$logPath .= "$folder/";
	}
	make_dir($logPath);

	$logFile = "$logPath$file.log";
	$time = date('Y-m-d H:i:s');

	if (is_array($log_text) || is_object($log_text)) {
		$text = @print_r($log_text, 1);
	} else {
		$text = $log_text;
	}
	$string = "$time -|- $title -|- $text\r\n";

	if (!$f = @fopen($logFile, "a")) return FALSE;

	if (!fwrite($f, $string)) return FALSE;
	fclose($f);
}

?>
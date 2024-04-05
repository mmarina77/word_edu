<?php
require_once 'middleware.php';


$word = isset($_GET['word']) ? trim($_GET['word']) : null;
$language = isset($_GET['language']) ? $_GET['language'] : "en-gb";

if($word) {
	
	$config['oxford']['language'] = $language;
	$dic = new dictionaryModel($config['oxford']);
	
	//$result = $dic->wordFromOxford($word);
	$result = $dic->getWord($word);

	header("Cache-Control: no-cache, must-revalidate");
	header("Content-Type: application/json");
	$json = json_encode($result);
	echo $json;
}


?>
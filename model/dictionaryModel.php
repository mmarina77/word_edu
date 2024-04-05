<?php

require_once 'model/lib/oxford-dictionary-api.php';

class dictionaryModel {

	private $conf = null;
	private $fields = [];
	function __construct($config = null) {
		$this->conf = $config;
	}

	public function getWord($word) {
		
		$response = [];
		$wordDB = $this->wordFromDB($word);
		if(!$wordDB) {
			// API call
			$oxfordObj = $this->wordFromOxford($word);
			if($oxfordObj['status'] == 200) {
m_log($oxfordObj['data'], 'word from Oxford', 'dictionaryModel');
				$db = $GLOBALS['db'];
				// caching word info to DB
				$result = $db->insertToOxford($oxfordObj['data'], 'en-gb');
				if($result && $result['errorCode'] == 0) {
m_log($result, 'insert result', 'dictionaryModel');	
					$resp = $this->wordById($result['wordId']);
m_log($resp, 'wordById', 'dictionaryModel');	
					$response = [
						'status' => 200,
						'data' => $resp,
						'errorCode' => 0
					];
				} else {
					// insert to DB error
					$response = [
						'status' => 0,
						'data' => $wordDB,
						'errorCode' => 404
					];
m_log($resp, 'insert to DB error', 'dictionaryModel');
				}

			} else {
				// error from Oxford
				$response = [
					'status' => 0,
					//'data' => $wordDB,
					'errorCode' => 404
				];
m_log($oxfordObj, 'error from Oxford', 'dictionaryModel');
			}
		} else {
			$response = [
				'status' => 200,
				'data' => $wordDB,
				'errorCode' => 0
			];
		}
m_log($response, 'response', 'dictionaryModel');	
		return $response;
	}
	
	function insertToDB($data) {
		if($data && sizeof($data) > 0) {
			$fields = ['etymology','audioURL','phonetic','definition','shortDefinition','phrase','type','example','synonyms']; 
			
			$cnt = count($fields);
			$values = '';
			foreach($fields as $value) {
				
				$val = $data[$value];
				if($value == 'synonyms') {
					$val = implode(', ', $val);
				} 
				
				$values .= '"' . $val . '"';
				$cnt--;
				if($cnt > 1 ) {
					$values .= ",";
				}
			}
			
m_log($values, 'values', 'dictionaryModel');
/*
			$arr = [
				'etymology' => $data['etymology'],
				'audioURL' => $data['audioURL'],
				'phonetic' => $data['phonetic'],
				'definition' => $data['definition'],
				'shortDefinition' => $data['shortDefinition'],
				'phrase' => $data['phrase'],
				'type' => $data['type'],
				'example' => $data['example'],
				'synonyms' => count($data['synonyms']) > 0 ? implode(',', $data['synonyms']) : ''
				
			];
*/
		}


	}

	function wordFromOxford($word) {
		
		$conf = $this->conf;
		
		$dictionary = new Dictionary($conf['app_id'], $conf['app_key'], $conf['language'], true);

		/* Create a new dictionary request */
		$result = $dictionary->newRequest($word);
		
		$response = ['status' => 400, 'message' => 'Error'];
		if( isset($dictionary->errors['status'] ) && $dictionary->errors['status'] == 200) {

			$data = [
				'word' => $dictionary->word,
				'totalResultCount' => $dictionary->totalResultCount,
				'resultSet' => $dictionary->resultSet,
				'etymology' => $dictionary->etymology,
				'audioURL' => $dictionary->audioURL,
				'dialect' => $dictionary->dialect,
				'phonetic' => $dictionary->phonetic,
				'definition' => $dictionary->definition,
				'shortDefinition' => $dictionary->shortDefinition,
				'phrase' => $dictionary->phrase,
				'type' => $dictionary->type,
				'example' => $dictionary->example,
				'synonyms' => $dictionary->synonyms // count($dictionary->synonyms) > 0 ? implode(',', $dictionary->synonyms) : ''
				
			];
			$response = [
				'status' => 200,
				'data' => $data,
				'error' => 0
			];
m_log($data, 'data', 'dictionaryModel');	
		}  else {
			$response = ['status' => $dictionary->errors['status'], 'message' => $dictionary->errors['message']];
		}
		
		/*header("Content-Type: application/json");
		$json = json_encode($result);
		echo $json;*/
		//return json_encode($response);
		return $response;
	}
	
	function wordFromDB($word) {
		$db = $GLOBALS['db'];
		$result = $db->fetchRow("SELECT * FROM `oxford_en-gb` WHERE word = '$word'");
m_log($word, 'word from db wordFromDB', 'dictionaryModel');
		return $result;
	}

	function wordById($word_id) {
		$db = $GLOBALS['db'];
		$result = $db->fetchRow("SELECT * FROM `oxford_en-gb` WHERE id = $word_id");
m_log($result, 'word by id', 'dictionaryModel');
		return $result;
	}
}
?>
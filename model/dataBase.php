<?php

class DataBase {
	public $connect;
	public $config;
	public $data;
	private $sql;
	
	private $response;
	

    public function __construct($dbConfig ) {
		$this->config = $dbConfig;
		$this->connect = null;
		
		$this->response = [];
	}

	function connect() {
		if($this->config) {
			$dbConf = $this->config;
			$this->connect = mysqli_connect($dbConf['host'], $dbConf['username'], $dbConf['password'], $dbConf['dbname']);
			if (!$this->connect) {
				die("Connection failed: " . mysqli_connect_error());
			}
		}
        return $this->connect;
	}

	function prepareData($data) {
		
		return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
	}

	function login($table, $email, $password) {
		$email = $this->prepareData($email);
		$password = $this->prepareData($password);
		$this->sql = "select * from " . $table . " where email = '" . $email . "'";
		$result = mysqli_query($this->connect, $this->sql);
		$row = mysqli_fetch_assoc($result);
		if (mysqli_num_rows($result) != 0) {
			$dbemail = $row['email'];
			$dbpassword = $row['password'];
			if ($dbemail == $email && password_verify($password, $dbpassword)) {
				//$login = true;
				return ['id' => $row['id'], 'username' => $row['username'], 'email' => $row['email']];
			} else $login = false;
		} else $login = false;

		return $login;
    }

	function signUp($table, $email, $username, $password) {
		
		$username = $this->prepareData($username);
		//$password = md5($this->prepareData($password));
		$password = $this->prepareData($password);
		$email = $this->prepareData($email);
		$password = password_hash($password, PASSWORD_DEFAULT);

		$sql = "INSERT INTO " . $table . " (username, password, email) VALUES ('" . $username . "','" . $password . "','" . $email . "')";

		if (mysqli_query($this->connect, $sql)) {
			return true;
		} else return false;
	}
	
	function fetchRows( $sql) {
		
		$query = mysqli_query($this->connect, $sql);
		if (!$query) {
			//echo "Could not successfully run query ($sql) from DB: " . mysql_error();
			return null;
		}
		
		$result = [];
		while ($row = mysqli_fetch_assoc($query)) {     
			$result[] = $row;
		}
		return $result;
	}
	
	public function query( $sql) {
		$query = mysqli_query($this->connect, $sql);
		$result = null;
		if (!$query) {
			return null;
		}
		return $result;
	}
	
	function fetchRow( $sql) {
		
		$query = mysqli_query($this->connect, $sql);
		$result = null;
		
		if (!$query) {
			//echo "Could not successfully run query ($sql) from DB: " . mysqli_error();
			return null;
		}
		
		$result = mysqli_fetch_assoc($query);
		return $result;
	}
	
	function insertToOxford($data, $language = 'en-gb') {
		
		$this->response = ['status' => 0, 'errorCode' => 0];
		if($data && sizeof($data) > 0) {
			$fields = ['word','etymology','audioURL','dialect','phonetic','definition','shortDefinition','phrase','type','example','synonyms']; 
			
			$cnt = count($fields);
			$values = '';
			foreach($fields as $key) {
				
				$val = $data[$key] ? $data[$key] : '';
				
				if(!empty($val) && $key == 'synonyms') {
					$val = implode(', ', $val);
				} 
				
				$values .= '"' . $this->prepareData($val) . '"';
				if($cnt > 1) {
					$values .= ',';
				}
				$cnt--;
			}
			$sql = "INSERT INTO `oxford_en-gb` (" . implode(',', $fields) . ") VALUES (" . $values . ")";
			
			$query = mysqli_query($this->connect, $sql);
			$this->response = ['status' => 1, 'errorCode' => 0];
			if(!$query) {
				$error = 'error' . mysqli_error($this->connect);
				$error = strpos($error, 'Duplicate entry');
				$this->response['errorCode'] = 1000;
				if($error > 0 ) {
					$this->response['errorCode'] = 1062;
				}			
				$this->response['status'] = 0;
m_log($this->response['errorCode'], 'errorCode', 'dataBase');
				
			} else {
				$lastId = mysqli_insert_id($this->connect);
				$this->response['wordId'] = $lastId;
				$this->response['status'] = 10;
				$this->response['errorCode'] = 0;
			}
m_log($this->response, 'response', 'dataBase');
		}
		return $this->response;
	}
	
	public function insertModule($data) {
		
		$name = $this->prepareData($data['name']);
		$description = $this->prepareData($data['description']);
		$sql = "INSERT INTO `module` (user_id, name, description) VALUES ({$data['user_id']}, '$name', '$description')";
		
		$query = mysqli_query($this->connect, $sql);
		$result = ['status' => 1, 'error' => 0];
		if(!$query) {
			$error = mysqli_error($this->connect);
			$result = ['status' => 0, 'errorCode' => 1062, 'error' => $error];
		} else {
			
			$last_id = $this->connect->insert_id;
			$result = ['status' => 1, 'error' => 0, 'last_id' => $last_id];
		}
		return $result;
	}
	
	public function insertTicket($data) {
		
		$example = $this->prepareData($data['example']);
		//$description = $this->prepareData($data['description']);
		$sql = "INSERT INTO `ticket` (user_id, word_id, example) VALUES ({$data['user_id']}, {$data['word_id']}, '$example')";
		
		$query = mysqli_query($this->connect, $sql);
		$result = ['status' => 1, 'error' => 0];
		if(!$query) {
			$error = mysqli_error($this->connect);
			$result = ['status' => 0, 'errorCode' => 1062, 'error' => $error];
		} else {
			$last_id = $this->connect->insert_id;
			
			// insert to module_ticket
			$sql = "INSERT INTO `module_ticket` (user_id, ticket_id, module_id) VALUES ({$data['user_id']}, $last_id, {$data['module_id']})";
			$query = mysqli_query($this->connect, $sql);
		
			$result = ['status' => 1, 'error' => 0, 'last_id' => $last_id];
		}
		return $result;
	}
	
	public function ticketsByModuleId($user_id, $module_id) {
		
		$sql = "SELECT 
					ox.word,
					ox.audioURL,
					ox.definition,
					ox.shortDefinition,
					mt.module_id moduleId, 
					t.word_id oxId, 
					t.example, 
					mt.ticket_id ticketId
				FROM module_ticket mt
				LEFT JOIN ticket t ON mt.ticket_id = t.id
				LEFT JOIN `oxford_en-gb` ox ON t.word_id = ox.id
				WHERE mt.user_id = $user_id AND mt.module_id = $module_id";
		$query = mysqli_query($this->connect, $sql);
		$result = ['status' => 1, 'error' => 0];
		if(!$query) {
			$error = mysqli_error($this->connect);
			//$result = ['status' => 0, 'errorCode' => 1050, 'error' => $error];
			$result = null;
		} else {
			$data = [];
			while ($row = mysqli_fetch_assoc($query)) {     
				$data[] = $row;
			}
			$result = $data;
		}
		return $result;
	}
	
	public function ticketStatus($data) {
		
		$sql = null;
		if($data['success'] > 0) {
			$sql = ' success = IFNULL(success, 0) + 1 ';
		} elseif($data['error'] > 0) {
			$sql = ' error = IFNULL(error, 0) + 1 ';
		}
		
		$result = ['status' => 0, 'error' => 10];
		if($sql) {
			$sql = "UPDATE `ticket` SET " . $sql . " WHERE user_id = " .$data['user_id']. " AND id = " . $data['ticket_id']; 
			$query = mysqli_query($this->connect, $sql);
			$result = ['status' => 1, 'error' => 0 ];
		}
		
		return $result;
		
	}
	
	public function removeTicket($user_id, $module_id, $ticket_id) {
		$result = ['status' => 1, 'error' => 0];
		
		$sql = "DELETE FROM ticket WHERE id = $ticket_id AND user_id = $user_id";
		$query = mysqli_query($this->connect, $sql);
		
		$sql = "DELETE FROM module_ticket WHERE ticket_id = $ticket_id AND user_id = $user_id AND module_id = $module_id";
		$query = mysqli_query($this->connect, $sql);
		
		return $result;
	}
}


?>
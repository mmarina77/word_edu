<?php


class userModel {
	
	
	function __construct() {
		
	}
	
	public function userByEmail($email) {
		$db = $GLOBALS['db'];
		$email = $db->prepareData($email);
		$query = $db->fetchRow("SELECT id, username FROM `user` WHERE email = '$email'");
		$result = ['status' => 0, 'errorCode' => 1000];
m_log($query, 'query', 'userModel');
		if($query && sizeof($query) > 0) {
			$result['status'] = 1;
			$result['data'] = $query;
			$result['errorCode'] = 0;
		}
m_log($result, 'result', 'userModel');
		return $result;
	}
	
	public function insertUser($username, $email, $password) {
		$db = $GLOBALS['db'];
		$un = $db->prepareData($username);
		$em = $db->prepareData($email);
		$pas = md5( $db->prepareData($password) );
		$query = $db->query("INSERT INTO `user` (username,email,password) VALUES ('$un','$em','$pas')");
		$result = ['status' => 0, 'errorCode' => 1000];
		if($query && sizeof($query) > 0) {
			$result['status'] = 1;
			$result['errorCode'] = 0;
		}
		return $result;
	}

	public function userLogin($email, $password) {
		$db = $GLOBALS['db'];
		$email = $db->prepareData($email);
		$password = $db->prepareData($password);
		
		$query = $db->fetchRow("SELECT id, username, password FROM `user` WHERE email = '$email'");
		
		$result = ['status' => 0, 'errorCode' => 1000];
		if($query && sizeof($query) > 0) {
			
			if($query['password'] == md5($password)) {
				$result['status'] = 1;
				$result['data'] = $query;
				$result['errorCode'] = 0;				
			}
		}
m_log($result, 'result', 'userModel');
		return $result;
	}

	/*
	public function modulesByUserId($user_id) {
		
		$db = $GLOBALS['db'];
		$result = $db->fetchRow("SELECT * FROM `module` WHERE user_id = $user_id ORDER BY name ASC");
m_log($result, 'modules by id', 'userModel');
		return $result;
	}
	
	public function insertModule($data) {
		
		$db = $GLOBALS['db'];
		
		$result = $db->insertModule($data);
			
		return $result;
	}
	*/
}

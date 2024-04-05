<?php


class moduleModel {
	
	
	function __construct() {
		
	}
	
	public function modulesByUserId($user_id) {
		
		$db = $GLOBALS['db'];
		$query = $db->fetchRows("SELECT * FROM `module` WHERE user_id = $user_id ORDER BY name ASC");
		$result = ['status' => 0, 'errorCode' => 1000];
		if($query && sizeof($query) > 0) {
			$result['status'] = 1;
			$result['data'] = $query;
			$result['errorCode'] = 0;
		}
		return $result;
	}
	
	public function ticketsByModuleId($user_id, $module_id) {
		
		$db = $GLOBALS['db'];
		$query = $db->ticketsByModuleId($user_id, $module_id);
		$result = ['status' => 0, 'errorCode' => 1050];
		if($query && sizeof($query) > 0) {
			$result['status'] = 1;
			$result['data'] = $query;
			$result['errorCode'] = 0;
		}
		return $result;
	}
	
	public function insertModule($data) {
		
		$db = $GLOBALS['db'];
		$result = $db->insertModule($data);
			
		return $result;
	}
	
	public function insertTicket($data) {
		
		$db = $GLOBALS['db'];
		$result = $db->insertTicket($data);
			
		return $result;
	}
	
	public function ticketStatus($data) {
		
		$db = $GLOBALS['db'];
		$result = $db->ticketStatus($data);
			
		return $result;
	}
	
	public function removeTicket($user_id, $module_id, $ticket_id) {
		
		$db = $GLOBALS['db'];
		$result = $db->removeTicket($user_id, $module_id, $ticket_id);
			
		return $result;
	}
	
}

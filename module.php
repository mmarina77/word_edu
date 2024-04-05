<?php

require_once 'middleware.php';
require_once 'authentication.php';

$user_id = $_SESSION['user_id'];

$action = isset($_POST['action']) ? $_POST['action'] : null;

$moduleObj = new moduleModel();
$response = [
	'status' => 200,
	'data' => []
];

/*
m_log($_POST, '_POST', 'module');
m_log($user_id, 'user_id', 'module');
m_log($_SESSION, '_SESSION', 'module');
*/
	switch($action) {
		// modules
		case 'createModule':
			$name = isset($_POST['moduleName']) ? trim($_POST['moduleName']) : null;
			$description = isset($_POST['moduleDescription']) ? trim($_POST['moduleDescription']) : null;
			$data = [
				'user_id' => $user_id,
				'name' => $name,
				'description' => $description
			];
			$response = $moduleObj->insertModule($data);
		break;
		case 'modules':
			$response = $moduleObj->modulesByUserId($user_id);
		break;
		// tickets
		case 'createTicket':
			$word_id = isset($_POST['word_id']) ? $_POST['word_id'] : null;				// oxford word id
			$example = isset($_POST['example']) ? trim($_POST['example']) : null;
			$module_id = isset($_POST['module_id']) ? $_POST['module_id'] : null;

			// insert to custom_dictionary
			$data = [
				'user_id' => $user_id,
				'word_id' => $word_id,
				'module_id' => $module_id,
				'example' => $example
			];
			$response = $moduleObj->insertTicket($data);
		break;		
		case 'ticketsByModule':
			$module_id = isset($_POST['module_id']) ? $_POST['module_id'] : null;
			$response = $moduleObj->ticketsByModuleId($user_id, $module_id);
		break;		
		case 'moduleTickets':
			$module_id = isset($_POST['module_id']) ? $_POST['module_id'] : null;
			$response = $moduleObj->ticketsByModuleId($user_id, $module_id);
		break;		
		case 'ticketStatus':
			$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : null;
			$success = isset($_POST['success']) ? (int)$_POST['success'] : null;
			$error = isset($_POST['error']) ? $_POST['error'] : null;
			$data = [
				'user_id' => $user_id,
				'ticket_id' => $ticket_id,
				'success' => $success,
				'error' => $error
			];
			
			$response = $moduleObj->ticketStatus($data);
		break;
		case 'removeTicket':
			$ticket_id = isset($_POST['ticket_id']) ? $_POST['ticket_id'] : null;
			$module_id = isset($_POST['module_id']) ? $_POST['module_id'] : null;
			$response = $moduleObj->removeTicket($user_id, $module_id, $ticket_id);
		break;
	}


	header("Cache-Control: no-cache, must-revalidate");
	header("Content-Type: application/json");
	$json = json_encode($response);
	echo $json;
?>
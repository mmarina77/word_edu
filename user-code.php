<?php
session_start();

require_once 'middleware.php';

//m_log($_SESSION, '_SESSION', 'user-code');
m_log($_POST, '_POST', 'user-code');


$userObj = new userModel();
if(isset($_POST['registerBtn'])) {
	$username = isset($_POST['username']) ? trim($_POST['username']) : null;
	$email = isset($_POST['email']) ? trim($_POST['email']) : null;
	$password = isset($_POST['password']) ? trim($_POST['password']) : null;
	$confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : null;

    $errors = [];

    if(!$username OR !$email OR !$password OR !$confirm_password){
        array_push($errors, "All fields are required");
    }
    if($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Enter valid email address");
    }

    if($email != ''){
       
		$userCheck = $userObj->userByEmail($email);
        if($userCheck && $userCheck['status'] > 0){
			array_push($errors, "Email already registered");
        } 
    }

    if(count($errors) > 0){
        $_SESSION['errors'] = $errors;
        header('Location: register.php');
        exit();
    }
	$userResult = $userObj->insertUser($username, $email, $password);
	
m_log($userResult, 'userResult', 'user-code');

    if($userResult){
        $_SESSION['message'] = "Registered Successfully";
        header('Location: index.php');
        exit();
    }else{
        $_SESSION['message'] = "Something Went Wrong";
        header('Location: register.php');
        exit();
    }
	
} elseif(isset($_POST['loginBtn'])) {
	
	$email = isset($_POST['email']) ? trim($_POST['email']) : null;
	$password = isset($_POST['password']) ? trim($_POST['password']) : null;	

    $errors = [];

    if($email == '' OR $password == ''){
        array_push($errors, "All fields are mandetory");
    }
	
    if($email != '' && !filter_var($email, FILTER_VALIDATE_EMAIL)){
        array_push($errors, "Email is not valid");
    }
    
    if(count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header('Location: ' . APPLICATION_URL . 'login.php');
        exit();
    }
	
	$userResult = $userObj->userLogin($email, $password);
m_log($userResult, 'userResult', 'user-code');
	if($userResult && isset($userResult['data'])) {
		$user = $userResult['data'];
		$_SESSION['loggedInStatus'] = true;
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['username'] = $user['username'];
		$_SESSION['message'] = "Logged In Successfully!";
m_log($_SESSION, '_SESSION', 'user-code');
m_log(APPLICATION_URL, 'APPLICATION_URL', 'user-code');
		header('Location: ' . APPLICATION_URL);
		exit();
	} else {
		array_push($errors, "Invalid Email or Password!");
		$_SESSION['errors'] = $errors;
		unset($_SESSION['user_id']); 
		unset($_SESSION['username']); 
		unset($_SESSION['loggedInStatus']); 
		header('Location: ' . APPLICATION_URL . 'login.php');
		exit();
	}
	
}

?>
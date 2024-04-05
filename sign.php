<?php
if(isset($_GET['action'])){
	if($_GET['action'] == 'Login') {
		$email = $_GET['email'];
		$password = $_GET['password'];
	}
	
}
?>
<!DOCTYPE html>
<!---Coding By CoderGirl | www.codinglabweb.com--->
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login & Registration Form | CoderGirl</title>
  <!---Custom CSS File--->
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <input type="checkbox" id="check">
    <div class="login form">
      <header>Login</header>
      <form action="">
        <input type="text" placeholder="Enter your email" name="email">
        <input type="password" placeholder="Enter your password" name="password">
        <a href="#">Forgot password?</a>
        <input type="button" class="button" value="Login" name="action">
      </form>
      <div class="signup">
        <span class="signup">Don't have an account?
         <label for="check">Signup</label>
        </span>
      </div>
    </div>
    <div class="registration form">
      <header>Signup</header>
      <form action="">
        <input type="text" placeholder="Enter your username" name="username">
        <input type="text" placeholder="Enter your email" name="email">
        <input type="password" placeholder="Create a password" name="password">
        <input type="password" placeholder="Confirm your password" name="rep_password">
        <input type="button" class="button" value="Signup" name="action">
      </form>
      <div class="signup">
        <span class="signup">Already have an account?
         <label for="check">Login</label>
        </span>
      </div>
    </div>
  </div>
</body>
</html>

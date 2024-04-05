<?php
session_start();
require_once 'middleware.php';

if(isset($_SESSION['loggedInStatus'])){
    header('Location: '. APPLICATION_URL );
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" >
	<style>
		.regBtn {
			background-color:#17a2b8;
			border: solid 1px #17a2b8;
		}
		.regA, label {
			color:#17a2b8;
		}
		.regBtn:hover {
		  background-color: #28b3c9;
		  border: solid 1px #17a2b8;
		}

	</style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="mt-4 card card-body shadow">

                    <h4 class="regA">Register</h4>
                    <hr>
                    <?php
                    if(isset($_SESSION['errors']) && count($_SESSION['errors']) > 0){
                        foreach($_SESSION['errors'] as $error){
                            ?>
                            <div class="alert alert-warning"><?= $error; ?></div>
                            <?php
                        }
                        unset($_SESSION['errors']);
                    }

                    if(isset($_SESSION['message'])){
                        echo '<div class="alert alert-success">'.$_SESSION['message'].'</div>';
                        unset($_SESSION['message']);
                    }
                    ?>
                    <form action="user-code.php" method="POST">
                        <div class="mb-3">
                            <label>User Name</label>
                            <input type="text" name="username" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label>Confirm password</label>
                            <input type="password" name="confirm_password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="registerBtn" class="btn btn-primary w-100 regBtn" style="">Submit</button>
                        </div>
                        <div class="text-center">
                            <a href="login.php" class="regA">Click here to Login</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
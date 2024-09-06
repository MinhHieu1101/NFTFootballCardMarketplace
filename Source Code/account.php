<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "User Account";
		include_once('includes/header.inc');
		if (isset($_SESSION['user'])) {
		//Redirect to user page if user logged in
			header("Location: user.php"); 
        exit();
		}
	?>
</head>
<body>
	<?php include_once('includes/menu.inc'); ?>

    <!-- Account Section -->
    <section class="account">
        <div class="container2" id="container2">
            <!-- Sign Up Form Container -->
            <div class="form-container sign-up-container">
                <form class="form-acc" id="signupForm" action="registration_api.php" method="post">
                    <h1>Sign Up</h1>
                    <input type="text" placeholder="Username" id="userName" name="userName"/>
                    <input type="email" placeholder="Email" id="email" name="email"/>
                    <input type="password" placeholder="Password" id="userPassword" name="userPassword"/>
					<input class="button" type="submit" value="Sign Up">
                </form>
            </div>
            <!-- Sign In Form Container -->
            <div class="form-container sign-in-container">
                <form class="form-acc" id="signinForm" action="authentication_api.php" method="post">
                    <h1>Sign In</h1>
                    <input type="text" placeholder="Username" id="userName2" name="userName2" />
                    <input type="password" placeholder="Password" id="userPassword2" name="userPassword2" />
                    <a href="resetpassword.php">Forgot your password?</a>
					<input class="button" type="submit" value="Sign In">
                </form>
            </div>
            <!-- Panel Container for Sign In/Sign Up Switch -->
            <div class="panel-container">
                <div class="panel">
                    <!-- Left Panel - Sign In -->
                    <div class="panel-frame panel-left">
                        <h1>Welcome Back^^</h1>
                        <p>Login with your account</p>
                        <a class="button ghost" id="sign-in">Sign In</a>
                    </div>
                    <!-- Right Panel - Sign Up -->
                    <div class="panel-frame panel-right">
                        <h1>Hello There^^</h1>
                        <p>Create an account with us!</p>
                        <a class="button ghost" id="sign-up">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<div id="response"></div>
    
	<?php include_once('includes/footer.inc'); ?>
    
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
	<script type="text/javascript" src="assets/scripts/account.js"></script>
	<script type="text/javascript" src="assets/scripts/signup.js"></script>
	<script type="text/javascript" src="assets/scripts/signin.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>

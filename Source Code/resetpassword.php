<!DOCTYPE html>
<html lang="en">
<head>
	<?php $page_title = "Reset Account Password"; ?>
	<?php include_once('includes/header.inc'); ?>
</head>
<body>
	<?php include_once('includes/menu.inc'); ?>

    <!-- Reset Account Section -->
    <section class="account">
        <div class="container2" id="container2">
            <div class="form-container sign-in-container">
                <form class="form-acc" id="resetpassForm" action="resetpassword_api.php" method="post">
                    <h1>Reset Your Password</h1>
                    <input type="text" placeholder="Username" id="userName3" name="userName3"/>
					<input type="email" placeholder="Email" id="email3" name="email3"/>
                    <input type="password" placeholder="New Password" id="userPassword3" name="userPassword3"/>
					<input class="button" type="submit" value="Reset">
                </form>
            </div>

            <div class="panel-container">
                <div class="panel">
                    <div class="panel-frame panel-right">
                        <h1>Good day to you!</h1>
                        <p>Make sure to verify carefully your new password :></p>
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
	<script type="text/javascript" src="assets/scripts/reset.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "Create NFT";
		include_once('includes/header.inc');
		if (!isset($_SESSION['user'])) {
		//Redirect to account page if user not logged in
			header("Location: account.php"); 
			exit();
		} else if ($_SESSION['user']['username'] !== "admin") {
			//Redirect to user page if user is not an admin
			echo '<script>alert("You do not have access to this page!");</script>';
			header("Location: user.php");
			exit();
		}
	?>
</head>
<body>
	<?php include_once('includes/menu.inc'); ?>

    <section class="account">
        <div class="container2" id="container2">
            <!-- Upload NFT Form Container -->
            <div class="form-container sign-in-container">
                <form class="form-acc" id="createForm" action="insert_nft.php" method="post">
                    <h1>Create NFT</h1>
                    <input type="text" placeholder="Thumbnail URL" id="image_url" name="image_url"/>
                    <input type="text" placeholder="Player Name" id="player_name" name="player_name"/>
                    <input type="text" placeholder="Club" id="club" name="club"/>
					<input type="text" placeholder="Position" id="position" name="position"/>
					<input type="text" placeholder="Age" id="age" name="age"/>
					<input type="text" placeholder="Country" id="country" name="country"/>
					<input type="number" step=".01" placeholder="NFT Price" id="price" name="price"/>
					<input class="button" type="submit" value="Submit">
                </form>
            </div>
            <div class="panel-container">
                <div class="panel">
                    <div class="panel-frame panel-right">
                        <h1>NFT Football Card Creation</h1>
                        <p>Only for admin^^</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<div id="response"></div>
    
	<?php include_once('includes/footer.inc'); ?>
    
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
	<script type="text/javascript" src="assets/scripts/nft.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>

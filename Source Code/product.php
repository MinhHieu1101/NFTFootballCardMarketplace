<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "SwinBalls: Autobots balls out!"; 
		include_once('includes/header.inc');
		require('blockchain/contract.php');
		//Check if a product ID is set or not
		$product_id = isset($_GET['card_id']) ? $_GET['card_id'] : '';
		$user_info = $_SESSION['user'];
		$u_id = $user_info['user_id'];
		$u_balance = $user_info['balance'];
		include_once('databaseconnect.php');
		//Card variables
		$card_image = $card_name = $card_club = $card_position = $card_age = $card_country = $card_price = "";
		
		if ($product_id != '') {
				$query = "SELECT * FROM cards WHERE card_id = ?";
				$cardDetails = $conn->prepare($query);
				//Bind the card id to the SQL statement
				$cardDetails->bind_param("s", $product_id);
				$cardDetails->execute();
				$result = $cardDetails->get_result();

				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();

					// Assign card details to variables
					$card_id = $row['card_id'];
					$card_image = $row['image_url'];
					$card_name = $row['player_name'];
					$card_club = $row['club'];
					$card_position = $row['position'];
					$card_age = $row['age'];
					$card_country = $row['country'];
					$card_price = $row['price'];
				} else {
					$message = "This card is nowhere to be found.";
				}

				$cardDetails->close();
			} else {
				$message = "This card ID is not valid.";
			}
			$conn->close();
	?>
</head>
<body>
	<?php include_once('includes/menu.inc'); ?> 

    <!-- Main Content Section -->
    <main class="product">
        <!-- Left Section with Product Image -->
        <section class="left_section">
			<div id="effect" style="background-image: url('./assets/images/<?php echo htmlspecialchars($card_image); ?>');">
			</div>		
        </section>

        <!-- Right Section with Product Information -->
        <section class="right_section">
            <div class="card_info">
                <!-- Product Name -->
                <p class="header title_effect"><strong><?php echo htmlspecialchars($card_name); ?></strong></p>
            </div>

            <br><br>

            <!-- Buy Now Section -->
            <div class="buy_now">
                <div>
                    <h3><?php echo htmlspecialchars($card_price); ?> SwinCoin</h3>
                    <p>Instant Buy</p>
                </div>
                <input type="hidden" id="userId" value="<?php echo $u_id; ?>">
				<input type="hidden" id="cardId" value="<?php echo $card_id; ?>">
				<input type="hidden" id="price" value="<?php echo $card_price; ?>">
				<input type="hidden" id="imageURL" value="<?php echo $card_image; ?>">
			<?php 
				if ($u_balance < $card_price) {
					echo "<div class='alert alert-danger'><p>You don't have enough coin to buy this card!!!</p></div>";
				} else {
					echo "<button class='buy_now_btn' id='buyNowBtn'>Buy Now</button>";
				}
			?>

            </div>
			<br>
			<div id="response"></div>

            <br>

            <!-- Card Details Section -->
            <h2 class="title_effect">Card Details</h2>
            <div class="card_details">
                <div class="c-details">
                    <div class="left_details">
                        <!-- Information fields -->
                        <h4>Club:</h4>
                        <h4>Position:</h4>
                        <h4>Age:</h4>
                        <h4>Country:</h4>
                    </div>
                    <div class="right_details">
                        <!-- Corresponding Details -->
                        <p><?php echo htmlspecialchars($card_club); ?></p>
                        <p><?php echo htmlspecialchars($card_position); ?></p>
                        <p><?php echo htmlspecialchars($card_age); ?></p>
                        <p><?php echo htmlspecialchars($card_country); ?></p>
                    </div>
                </div>
            </div>
			
			<?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
            <?php endif; ?>
            
			<br><br>


			<!-- Club Performance Section -->
		<?php	
			$clubArray = explode(' ', $card_club);
			$apiClubName = implode('-', $clubArray);

			//The API endpoint with the club name
			$apiURl = "http://52.91.84.93:6060/matches/" . urlencode($apiClubName);

			//Make the API call
			$response = file_get_contents($apiURl);
			//Decode the JSON response to an array
			$matches = json_decode($response, true);

			// Check if the array is not empty
			if (!empty($matches)) {
				echo "<h2 class='title_effect'>Club Performance</h2>";
				echo "<div class='last_matches'>";
				//Display each match
				foreach($matches as $match) {
					echo "<div class='match_box'>";
					echo "<img src='assets/images/match.png' alt='Match Image'>";
					echo "<div class='match_info'>";
					echo "<p>" . htmlspecialchars($match, ENT_QUOTES, 'UTF-8') . "</p>";
					echo "</div>";
					echo "</div>";
				}
				echo "</div>";
			}
		?>
		
			<br><br>
			
            <!-- Token Details Section -->
            <h2 class="title_effect">Token Details</h2>
            <div class="token_details">
                <h4>Token ID</h4>
                <p>...</p>
				<p>This information will only be seen after you purchase the card.</p>
            </div>
        </section>
    </main>
    
	<?php include_once('includes/footer.inc'); ?>
    
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
	<script type="text/javascript" src="assets/scripts/product.js"></script>
</body>
</html>

<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php 
		$page_title = "Football Cards Trading Market";
		include_once('includes/header.inc');
		
		if (!isset($_SESSION['user'])) {
			//Redirect to account page if user not logged in
			header("Location: account.php"); 
			exit();
		}
		
		require 'databaseconnect.php';
		
		//Football cards data
		$cards = [];
		$query = "SELECT * FROM cards WHERE card_id NOT IN (SELECT card_id FROM transactions)";
		$result = $conn->query($query);

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$cards[] = $row;
			}
		}

		//Football club names for filters
		$clubNames = [];
		$clubQuery = "SELECT DISTINCT club FROM cards WHERE card_id NOT IN (SELECT card_id FROM transactions)";
		$clubResult = $conn->query($clubQuery);

		if ($clubResult->num_rows > 0) {
			while ($clubRow = $clubResult->fetch_assoc()) {
				$clubNames[] = $clubRow['club'];
			}
		}
		
		//Search results
		$searchResults = [];
		$showModal = false;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['search'])) {
			$searchTerm = $conn->real_escape_string($_POST['search']);
			$searchQuery = $conn->prepare("SELECT * FROM cards WHERE player_name LIKE ? AND card_id NOT IN (SELECT card_id FROM transactions)");
			$nameSearchTerm = "%" . $searchTerm . "%";
			$searchQuery->bind_param('s', $nameSearchTerm);
			$searchQuery->execute();
			$result2 = $searchQuery->get_result();

			if ($result2->num_rows > 0) {
				$searchResults = $result2->fetch_all(MYSQLI_ASSOC);
			}
			$searchQuery->close();
			//Show the results
			$showModal = true;
		}
		$conn->close();

	?>
</head>
<body>
	<?php include_once('includes/menu.inc'); ?>
    
    <!-- Main Content Section -->
    <main>
        <section>
            <!-- Title Section -->
            <h1 class="title title_effect">FEATURED CARDS</h1>
			
			<!-- Filters Section -->
			<div class="filters">
				<!-- Filter Buttons -->
				<div id="myButtonsContainer">
				  <button class="btn active" onclick="filterSelection('all')"> Show all</button>
				  <?php foreach ($clubNames as $clubName): ?>
					<button class="btn" onclick="filterSelection('<?php echo $clubName; ?>')"><?php echo $clubName; ?></button>
				  <?php endforeach; ?>
				</div>
				
				<div>
				    <form class="search" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input class="search" type="search" name="search" placeholder="Search..." />
                    </form>
				</div>
			</div>
			
            <!-- Card Container Section -->
            <div class="card-container">
				<!-- Individual Card Listings -->
				<?php foreach ($cards as $card): ?>
					<div class="filterDiv <?php echo $card['club']; ?>">
						<div class="card-listing">
                            <a href="product.php?card_id=<?php echo $card['card_id']; ?>"><img class="card-img" src="assets/images/<?php echo $card['image_url']; ?>" alt="<?php echo $card['player_name']; ?>"></a>
                            
                            <div class="card-data">
                                <h3 class="card-name"><?php echo $card['player_name']; ?></h3>
                                <span class="card-price"><?php echo $card['price']; ?> SwinCoin</span>
                            </div>
                        </div>
					</div>
				<?php endforeach; ?>
			</div>
			
			<!-- Modal Box to show results -->
			<div id="searchModal" class="modal" style="<?php echo $showModal ? 'display:block;' : ''; ?>">
				<!-- Modal Content -->
				<div class="modal-content">
					<span class="close-modal" onclick="closeModal()">&times;</span>
					<h2 class="title_effect">Search Results</h2>
					<?php
					if ($searchResults) {
						foreach ($searchResults as $card2): ?>
								<div class="card-listing">
									<a href="product.php?card_id=<?php echo $card2['card_id']; ?>"><img class="card-img" src="assets/images/<?php echo $card2['image_url']; ?>" alt="<?php echo $card2['player_name']; ?>"></a>
									<div class="card-data">
										<h3 class="card-name"><?php echo $card2['player_name']; ?></h3>
										<span class="card-price"><?php echo $card2['price']; ?> SwinCoin</span>
									</div>
								</div>
						<?php endforeach;
					} else {
						//If there is no result
						if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['search'])) {
							echo "<p>No results found for '" . htmlspecialchars($_POST['search']) . "'</p>";
						}
					}
					?>
				</div>
			</div>
        </section>
    </main>
    
	<?php include_once('includes/footer.inc'); ?>
    
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
	<script type="text/javascript" src="assets/scripts/filters.js"></script>
</body>
</html>
<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		$page_title = "Transactions History";
		include_once('includes/header.inc');
		
		if (!isset($_SESSION['user'])) {
		//Redirect to account page if user not logged in
        header("Location: account.php");
        exit();
		}
		$user_info = $_SESSION['user'];
		$userID = $user_info['user_id'];
		
		require 'databaseconnect.php';
		
		//Fetch transactions from the database
		$user_id = $conn->real_escape_string($userID);
		$query = "SELECT token_id, card_id, user_id, purchase_date, price, card_image FROM transactions WHERE user_id = ?";
		$transactionQuery = $conn->prepare($query);
		$transactionQuery->bind_param("i", $user_id);
		$transactionQuery->execute();
		$result = $transactionQuery->get_result();

		//Put data into an array
		$transactions = [];
		while ($row = $result->fetch_assoc()) {
			$transactions[] = $row;
		}

		//Close connections
		$transactionQuery->close();
		$conn->close();
		?>
</head>
<body>
	<?php include_once('includes/menu.inc'); ?>

    <!-- Main Content Section -->
    <section class="content">
        <!-- User Information Section -->
        <div class="info">
            <div class="cover-image">
                <img src="assets/images/cover-image.jpg" alt="Cover Image">
            </div>

            <div class="profile">
                <!-- Profile Image and Information -->
                <div class="profile-image">
                    <img src="assets/images/profile-image.jpg" alt="Profile Image">
                </div>
                <div class="profile-info">
                    <h2>A Random User</h2>
                    <p>ID: 123456</p>
                </div>
            </div>

            <hr class="line">

            <!-- Profile Menu Links -->
            <div class="profile-menu">
                <a href="user.php" class="menu-item">Personal Details</a>
                <a href="transaction.php" class="menu-item">Transactions</a>
                <a href="account.php" class="menu-item">Log Out</a>
				<a href="resetpassword.php" class="menu-item">Reset Password</a>
            </div>
        </div>

        <!-- Transaction History Table Section -->
		<div class="transaction-title">
			<h2 class="title_effect">TRANSACTION HISTORY</h2>
		</div>
		
        <div class="res-table">
            <table class="transaction-table">
                <thead>
                    <!-- Table Header Row -->
                    <tr>
                        <th>Token ID</th>
						<th>Card ID</th>
						<th>User ID</th>
                        <th>Purchase Date</th>
						<th>Price</th>
						<th>Card Thumbnail</th>
                    </tr>
                </thead>
				<tbody>
					<?php if (!empty($transactions)): ?>
						<?php foreach ($transactions as $transaction): ?>
							<tr>
								<td><?php echo htmlspecialchars($transaction['token_id']); ?></td>
								<td><?php echo htmlspecialchars($transaction['card_id']); ?></td>
								<td><?php echo htmlspecialchars($transaction['user_id']); ?></td>
								<td><?php echo htmlspecialchars($transaction['purchase_date']); ?></td>
								<td><?php echo htmlspecialchars($transaction['price']); ?> SwinCoin</td>
								<td><img class="card_thumbnail filter" src="assets/images/<?php echo $transaction['card_image']; ?>" alt="<?php echo $transaction['card_image']; ?>"></td>
							</tr>
						<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="5">You have not made any transaction.</td>
						</tr>
					<?php endif; ?>
				</tbody>
            </table>
        </div>
    </section>

	<?php include_once('includes/footer.inc'); ?>
    
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
</body>
</html>

<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php $page_title = "User Profile";
	include_once('includes/header.inc');
	
    if (!isset($_SESSION['user'])) {
		//Redirect to account page if user not logged in
        header("Location: account.php"); 
        exit();
    }
    $user_info = $_SESSION['user'];
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
                    <h2><?php echo htmlspecialchars($user_info['username']); ?></h2>
                    <p><?php echo 'ID: ' . htmlspecialchars($user_info['user_id']); ?></p>
                </div>
            </div>

            <hr class="line">

            <!-- Profile Menu Links -->
            <div class="profile-menu">
                <a href="user.php" class="menu-item">Personal Details</a>
                <a href="transaction.php" class="menu-item">Transactions</a>
                <a href="logout.php" class="menu-item">Log Out</a>
				<a href="resetpassword.php" class="menu-item">Reset Password</a>
            </div>
        </div>

        <!-- User Details Section -->
        <div class="user-details">
            <h2 class="title_effect">USER PROFILE</h2>
            <!-- User Card Details -->
            <div class="card">
                <table>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars($user_info['username']); ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars($user_info['email']); ?></td>
                        </tr>
                        <tr>
                            <td>Date Joined</td>
                            <td>:</td>
                            <td><?php echo htmlspecialchars($user_info['date_joined']); ?></td>
                        </tr>
                        <tr>
                            <td>Balance</td>
                            <td>:</td>
                            <td id="userBalance"><?php echo htmlspecialchars($user_info['balance']) . ' SwinCoin'; ?></td>
                        </tr>
                    </tbody>
                </table>
				
				<button id="addbalance" class="balance" data-userid="<?php echo htmlspecialchars($user_info['user_id']); ?>">
					<img class="balance-icon" src="assets/images/coins.png" alt="Add to Balance" />
					<p>Buy 0.5 SwinCoin</p>
				</button>
            </div>
        </div>
    </section>

	<?php include_once('includes/footer.inc'); ?>
    
    <!-- JavaScript Script Link -->
    <script type="text/javascript" src="assets/scripts/script.js"></script>
	<script type="text/javascript" src="assets/scripts/balance.js"></script>
</body>
</html>

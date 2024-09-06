<?php
session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

require 'databaseconnect.php';

//Fetch POST data
$token_id      = $_POST['token_id'];
$card_id       = $_POST['card_id'];
$user_id       = $_POST['user_id'];
$purchase_date = $_POST['purchase_date'];
$price         = $_POST['price'];
$card_image	   = $_POST['card_image'];

//Insert SQL statement
$insertTransaction = $conn->prepare("INSERT INTO transactions (token_id, card_id, user_id, purchase_date, price, card_image) VALUES (?, ?, ?, ?, ?, ?)");
$insertTransaction->bind_param("isisds", $token_id, $card_id, $user_id, $purchase_date, $price, $card_image);

//Update the user's balance after making a transaction
$updateBalance = $conn->prepare("UPDATE users SET balance = balance - ? WHERE user_id = ?");
$updateBalance->bind_param("di", $price, $user_id);

//Execute the insert statement and the update statement
if ($insertTransaction->execute() && $updateBalance->execute()) {
	  //Commit the transaction only if both insert and update operations succeed
	$conn->commit();
	$updateBalance->close();
	$balanceQuery = "SELECT balance FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $balanceQuery);
    if ($result) {
		$row = mysqli_fetch_assoc($result);
        $response['newBalance'] = $row['balance'];
        $_SESSION['user']['balance'] = $row['balance'];
    }
	http_response_code(200);
	echo json_encode([
		"status" => 'success',
		"message" => "Your transaction has been saved successfully. You can check it on your User Page!"
	]);
} else {
	$conn->rollback();
	http_response_code(400);
	echo json_encode([
		"status" => 'error',
		"message" => "We cannot process your transaction at the moment. Please try again later!"
	]);
}
//Close connections
$insertTransaction->close();
$conn->close();
?>

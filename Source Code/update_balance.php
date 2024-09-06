<?php
session_start();
include('databaseconnect.php');

$response = ['success' => false, 'newBalance' => 0];

if (isset($_POST['user_id']) && isset($_SESSION['user'])) {
    $user_id = $_POST['user_id'];
    $balanceIncrement = 0.5;

    //Prevent SQL injection
    $user_id = mysqli_real_escape_string($conn, $user_id);

    //Query to update the balance of an user
    $query = "UPDATE users SET balance = balance + $balanceIncrement WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $query)) {
        //Fetch the new balance
        $balanceQuery = "SELECT balance FROM users WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $balanceQuery);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $response['newBalance'] = $row['balance'];
            $response['success'] = true;

            // Update the session balance with new value
            $_SESSION['user']['balance'] = $row['balance'];
        }
    }
}

mysqli_close($conn);
echo json_encode($response);
?>
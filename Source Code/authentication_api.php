<?php
session_start();
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

require 'databaseconnect.php';

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['userName2']) && !empty($_POST['userPassword2'])) {
        $userName = sanitize($_POST['userName2']);
        $userPassword = sanitize($_POST['userPassword2']);
        
		$userPasswordHash = md5($userPassword);
		
		$check_userQuery = "SELECT * FROM users WHERE username = ? LIMIT 1;";
        $check_user = $conn->prepare($check_userQuery);
        $check_user->bind_param('s', $userName);
        $check_user->execute();
        $result = $check_user->get_result();
		
		if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            if ($userPasswordHash === $userData['password']) {
				//Storing the user info in the session
				unset($userData['password']);
				$_SESSION['user'] = $userData;
				
				http_response_code(200);
				echo json_encode([
					"status" => 'success',
					"message" => "User Verified. Please wait for 3 seconds!"
				]);
            } else {
				http_response_code(401);
				echo json_encode([
					"status" => 'error',
					"message" => "Incorrect username or password."
				]);
            }
		} else {
				http_response_code(401);
				echo json_encode([
					"status" => 'error',
					"message" => "Incorrect username or password."
				]);
        }
			
		$conn->close();
    } else {
		http_response_code(400);
        echo json_encode([
            "status" => 'error',
            "message" => "Missing required username, or password."
        ]);
    }
} else {
	http_response_code(405);
    echo json_encode([
        "status" => 'error',
        "message" => "HTTP request method not valid. Only POST is allowed."
    ]);
}
?>
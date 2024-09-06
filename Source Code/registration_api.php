<?php
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
	if (!empty($_POST['email']) && !empty($_POST['userName']) && !empty($_POST['userPassword']) ) {
		$userName = sanitize($_POST['userName']);
		$userPassword = sanitize($_POST['userPassword']);
		$hashedPassword = md5($userPassword);
		$email = filter_var(($_POST['email']), FILTER_SANITIZE_EMAIL);

        try {
            //Check for duplicate email
            $checkEmailQuery = "SELECT email FROM users WHERE email = ?";
            $checkEmail = $conn->prepare($checkEmailQuery);
            $checkEmail->bind_param('s', $email);
            $checkEmail->execute();
			$checkEmailResult = $checkEmail->get_result();
            
            if ($checkEmailResult->num_rows > 0) {
				http_response_code(409);
                echo json_encode([
                    "status" => 'error',
                    "message" => "Email already exists."
                ]);
                exit;
            }
            
            //Insert a new user to the database
            $registrationQuery = "INSERT INTO users (user_id, username, password, email, date_joined, balance) VALUES (NULL, ?, ?, ?, NOW(), 0.0);";
            $registration = $conn->prepare($registrationQuery);
			$registration->bind_param('sss', $userName, $hashedPassword, $email);
            $result = $registration->execute();

            if ($result) {
				http_response_code(200);
                echo json_encode([
                    "status" => 'success',
                    "message" => "User successfully registered. Please log in with your new account!"
                ]);
            } else {
				http_response_code(400);
                echo json_encode([
                    "status" => 'error',
                    "message" => "Registration cannot be processed. Please try again later!"
                ]);
            }
        } catch (Exception $event) {
			http_response_code(500); 
            echo json_encode([
                "status" => 'error',
                "message" => "An error occurred: " . $event->getMessage()
            ]);
        }
    } else {
		http_response_code(400);
        echo json_encode([
            "status" => 'error',
            "message" => "Missing required username, password, or email."
        ]);
    }
} else {
	http_response_code(405);
    echo json_encode([
        "status" => 'error',
        "message" => "HTTP request method not valid. Only POST is allowed."
    ]);
}
$conn->close();
?>
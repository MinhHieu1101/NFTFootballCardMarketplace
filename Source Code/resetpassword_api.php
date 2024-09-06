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
	if (!empty($_POST['email3']) && !empty($_POST['userName3']) && !empty($_POST['userPassword3']) ) {  
        $userName = sanitize($_POST['userName3']);
		$email = filter_var(($_POST['email3']), FILTER_SANITIZE_EMAIL);
        $newPassword = md5(sanitize($_POST['userPassword3'])); 
        
		mysqli_begin_transaction($conn);
        try {
            $check_user = $conn->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
            $check_user->bind_param("ss", $userName, $email);
            $check_user->execute();
			$result = $check_user->get_result();
            
            if ($result->num_rows === 1) {
                $updatePass = $conn->prepare("UPDATE users SET password = ? WHERE username = ? AND email = ?");
                $updatePass->bind_param("sss", $newPassword, $userName, $email);
                $updatePass->execute();
				
				mysqli_commit($conn);
                
				http_response_code(200);
                echo json_encode([
                    "status" => 'success',
                    "message" => "Password has been reset successfully. Please log in with your new password!"
                ]);
            } else {
                    http_response_code(404);
                    echo json_encode([
						"status" => 'error',
						"message" => "This user does not exist."
					]);
			}
        } catch (Exception $event) {
			mysqli_rollback($conn);
			
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

if (isset($conn) && $conn) {
    $conn->close();
}
?>

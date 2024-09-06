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

if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST))) {
			$image_url = sanitize($_POST['image_url']);
			$player_name = sanitize($_POST['player_name']);
			$club = sanitize($_POST['club']);
			$position = sanitize($_POST['position']);
			$age = sanitize($_POST['age']);
			$country = sanitize($_POST['country']);
			$price = sanitize($_POST['price']);

			//Concatenate strings to encode
			$combination = $player_name . $club;
			//Base64 encode to generate card_id
			$card_id = base64_encode($combination);

            //Check for duplicate NFT
            $checkCardIDQuery = "SELECT card_id FROM cards WHERE card_id = ?";
            $checkCardID = $conn->prepare($checkCardIDQuery);
            $checkCardID->bind_param('s', $email);
            $checkCardID->execute();
			$checkCardIDResult = $checkCardID->get_result();
            
            if ($checkCardIDResult->num_rows > 0) {
				http_response_code(409);
                echo json_encode([
                    "status" => 'error',
                    "message" => "A similar NFT has already been created."
                ]);
                exit;
            }
            
            //Insert a new NFT to the database
            $creationQuery = "INSERT INTO cards (card_id, image_url, player_name, club, position, age, country, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?);";
            $creation = $conn->prepare($creationQuery);
			$creation->bind_param('sssssisd', $card_id, $image_url, $player_name, $club, $position, $age, $country, $price);
            $result = $creation->execute();

            if ($result) {
				http_response_code(200);
                echo json_encode([
                    "status" => 'success',
                    "message" => "The latest NFT has been created in the database with the ID: " . $card_id
                ]);
            } else {
				http_response_code(400);
                echo json_encode([
                    "status" => 'error',
                    "message" => "Creation cannot be processed. Please try again later!"
                ]);
            }
    } else {
		http_response_code(400);
        echo json_encode([
            "status" => 'error',
            "message" => "Missing required fields or HTTP request method not POST"
        ]);
    }
$conn->close();
?>
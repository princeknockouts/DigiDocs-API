<?php
	include "dbcon.php";

	header("Content-Type: application/json");
	date_default_timezone_set("Asia/Calcutta");

	$data = json_decode(file_get_contents("php://input"));

	function generateRandomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	function checkToken($token, $connection) {
		while (true) {
			$query2 = "SELECT COUNT(id) FROM user_details WHERE user_token='$token'";
			$result2 = $connection-> query($query2);
			$row2 = $result2-> fetch_row();
			if($row2[0] > 0) {
				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$randomString = '';
				for ($i = 0; $i < $charactersLength; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
				checkToken($randomString, $connection);
			} else {
				return $token;
			}
		}
	}

	$username = "";
	$password = "";

	if (isset($data-> username) && isset($data-> password)) {
		$username = $data-> username;
		$password = $data-> password;
	}

	$succ = array (
		"success" => true,
		"user_id" => "",
		"user_token" => "",
		"user_name" => "",
		"contact" => "",
		"email" => "",
		"message" => "User Logged in successfully!!",
		"http code"=> 200
	);

	$err = array(
		"success" => false,
		"http code"=> 512,
		"message" => "",
	);

	$query = "SELECT * FROM user_details WHERE email_id='$username' AND is_delete=0";
	$result = $con-> query($query);

	if ($result-> num_rows > 0) {
		$token = generateRandomString(16);
		$final_token = checkToken($token, $con);
		while($row = $result-> fetch_array()) {
			$query3 = "UPDATE user_details SET user_token='$final_token' WHERE id=$row[0]";
			if ($con-> query($query3)) {
				if(strcmp($row[6], $password)==0) {
					$succ['user_name'] = $row[2]." ".$row[3];
					$succ['user_id'] = $row[0];
					$succ['user_token'] = $final_token;
					$succ['contact'] = $row[4];
					$succ['email'] = $row[5];
					echo json_encode($succ);
				} else {
					$err['message'] = "Incorrect Login credentials, Please try again!!";
					echo json_encode($err);
				}
			} else {
				$err['message'] = "Some error Occured, Please try again after some time!!";
				echo json_encode($err);
			}
		}
	} else {
		$err['message'] = "Incorrect Login credentials, Please try again!!";
		echo json_encode($err);
	}

?>
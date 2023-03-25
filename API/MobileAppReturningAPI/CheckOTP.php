<?php
	include "dbcon.php";

	header("Content-Type: application/json");
	date_default_timezone_set("Asia/Kolkata");

	$succ = array (
		"success" => true,
		"message" => "Correct OTP, please change password",
		"http code"=> 200
	);

	$err = array(
		"success" => false,
		"message" => "Incorrect OTP, please try again!!",
		"http code"=> 500
	);

	$data = json_decode(file_get_contents("php://input"));
	$otp = $data-> otp;
	$password = $data-> password;
	$user_id = $data-> user_id;

	$current_time = date("Y-m-d H:i:s");
	$ten_min_time = date("Y-m-d H:i:s", strtotime("-10 minutes"));

	$final_current_time = str_replace(": ", ":", $current_time);
	$final_min_time = str_replace(": ", ":", $ten_min_time);

	$query = "SELECT * FROM otp WHERE user_id='$user_id'";
	$result = $con-> query($query);
	if($row = $result-> fetch_row()) {
		if ($row[2] == $otp) {
			$query2 = "UPDATE user_details SET password='$password' WHERE id=$user_id";
			if ($con-> query($query2)) {
				$query3 = "DELETE FROM otp WHERE user_id='$user_id'";
				$con-> query($query3);
				echo json_encode($succ);
			} else {
				$query3 = "DELETE FROM otp WHERE user_id='$user_id'";
				$con-> query($query3);
				$err["message"] = "Some Error Occured, please try again after some time";
				echo json_encode($err);
			}
		} else {
			return json_encode($err);
		}
	}
?>
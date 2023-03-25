<?php
	include "dbcon.php";

	header("Content-type: application/json");
	date_default_timezone_set("Asia/Kolkata");

	$data = json_decode(file_get_contents("php://input"));
	$email_id = $data-> email;

	function checkOTP($otp, $con) {
		while (true) {
			$query2 = "SELECT COUNT(id) FROM otp WHERE otp_val=$otp";
			$result2 = $con-> query($query2);
			$row2 = $result2-> fetch_row();
			if($row2[0] > 0) {
				$otp = random_int(100000, 999999);
				checkOTP($otp);
			} else {
				return $otp;
			}
		}
	}

	$otp = random_int(100000, 999999);

	$succ = array (
		"success" => true,
		"user_id" => "",
		"message" => "Otp sent to your email id successfully!!",
		"http code"=> 200
	);
	$err = array(
		"success" => false,
		"message" => "Invalid email id, please check email id and try again!!",
		"http code"=> 500
	);

	$query = "SELECT COUNT(id), id FROM user_details WHERE email_id='$email_id' AND is_delete=0";
	$result = $con-> query($query);
	$row = $result-> fetch_array();
	if($row[0] > 0) {
		$headers = "From: demod1234567890@gmail.com";
		$final_otp = checkOTP($otp, $con);
		$query3 = "INSERT INTO otp (user_id, otp_val) VALUES ($row[1], $final_otp)";
		if($con-> query($query3)) {
			mail($email_id, "OTP for changing password in COPD app", "Your OTP is $final_otp", $headers);
			$succ['user_id'] = $row[1];
			echo json_encode($succ);
		} else {
			$err['http code'] = 503;
			$err['message'] = "Some error occured, please try again after some time!!";
			echo json_encode($err);
		}
	} else {
		echo json_encode($err);
	}
?>
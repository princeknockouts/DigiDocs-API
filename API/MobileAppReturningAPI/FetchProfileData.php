<?php
    include "dbcon.php";


    header("Content-Type: application/json");
	date_default_timezone_set("Asia/Calcutta");

	// $profile_data_array = array();
	

	$succ = array (
		"success" => true,
        "profile_data" => [],
		"message" => "data uploaded succ",
		"http code"=> 200
	);

	$err = array(
		"success" => false,
		"message" => "",
		"http code"=> 500
	);

    $data = json_decode(file_get_contents("php://input"));
	$user_id = $data-> user_id;

    $query = "SELECT * FROM `student` WHERE student_id = $user_id";

    $result = $con-> query($query);
	while($row = $result-> fetch_array()) {
		$profile_data_array = array(
            "student_id"=> $row[0],
			"first_name"=> $row[1],
			"middle_name"=> $row[2],
			"last_name"=> $row[3],
			"dob"=> $row[4],
			"Gender"=> $row[5],
			"ecard"=> $row[6],
			"email"=> $row[7],
			"contact"=> $row[8],
			"address"=> $row[9],
		);
	}
	$succ['profile_data'] = $profile_data_array;
  
    if(1){
        echo json_encode($succ);
    } else {
        echo json_encode($err);
    }



?>
<?php

    include "dbcon.php";

    header("Content-Type: application/json");
    date_default_timezone_set("Asia/Calcutta");

    $dumb_array = array();

    $succ = array (
		"success" => true,
        "org_name" => "",
		"message" => "data uploaded succ",
        "org_mapping" => [],
		"http code"=> 200
	);

	$err = array(
		"success" => false,
		"message" => "",
		"http code"=> 500
	);

    $data = json_decode(file_get_contents("php://input"));
	$user_id = $data-> user_id;

    $query = "SELECT org_name FROM organization_details WHERE id = 1";
    $result = $con-> query($query);
    $row = $result-> fetch_array();
    $succ['org_name'] = $row[0];

    $query1 = "SELECT * FROM `student_organization_mapping` WHERE student_id = $user_id";

    $result1 = $con-> query($query1);
	while($row1 = $result1-> fetch_array()) {
		$mapping_data = array(
            "id"=> $row1[0],
			"student_id"=> $row1[1],
			"organization_id"=> $row1[2],
			"degree"=> $row1[3],
			"completion_year"=> $row1[4],
			"number_of_documents"=> $row1[5],
			"starting_year"=> $row1[6],
			"active_status"=> $row1[7],
		);
        array_push($dumb_array, $mapping_data);
	}
    $succ['org_mapping'] = $dumb_array;
    if(1){
        echo json_encode($succ);
    } else {
        echo json_encode($err);
    }

?>
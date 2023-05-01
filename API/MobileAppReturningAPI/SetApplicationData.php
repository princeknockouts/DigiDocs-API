<?php

    include "dbcon.php";

    header("Content-Type: application/json");
	date_default_timezone_set("Asia/Calcutta");

    $data = json_decode(file_get_contents("php://input"));

    $succ = array (
		"success" => true,
		"profile_data_array" => [],
		"message" => "Patients list fetched successfully!!",
		"http code"=> 200
	);

	$err = array(
		"success" => false,
		"message" => "",
		"http code"=> 500
	);

    $data = json_decode(file_get_contents("php://input"));
	$user_id = $data-> user_id;
    $type = $data-> type;
    $organization = $data-> organization;
    $purpose = $data-> purpose;


   
    $query = "INSERT INTO `document_application` ( `student_id`, `organization_id`, `type_of_document`, `purpose`, `accepted`) VALUES ($user_id, 1, '$type', '$purpose', '0')";

    if(1){
        echo json_encode($succ);
    } else {
        echo json_encode($err);
    }

?>
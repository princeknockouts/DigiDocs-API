<?php

    include "dbcon.php";

    header("Content-Type: application/json");
    date_default_timezone_set("Asia/Calcutta");

    $dumb_array = array();

    $succ = array (
        "success" => true,
        "message" => "data uploaded succ",
        "document_details" => [],
        "http code"=> 200
    );

    $err = array(
        "success" => false,
        "message" => "",
        "http code"=> 500
    );

    $data = json_decode(file_get_contents("php://input"));
    $user_id = $data-> user_id;

    $query = "SELECT * FROM document_details WHERE student_id = 1 AND organization_id = 1";

    $result = $con-> query($query);

    while($row = $result-> fetch_array()) {
		$mapping_data = array(
            "document_id"=> $row[0],
			"student_id"=> $row[1],
			"organization_id"=> $row[2],
			"document_name"=> $row[3],
			"type_of_document"=> $row[4],
			"issued_at"=> $row[5],
			"path"=> $row[6],
		);
        array_push($dumb_array, $mapping_data);
	}
    $succ['document_details'] = $dumb_array;

    if(1){
        echo json_encode($succ);
    } else {
        echo json_encode($err);
    }

?>
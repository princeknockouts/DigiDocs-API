<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    include("../../MobileAppReturningAPI/dbcon.php");

    $student_list = Array();


    $organization_id = $_REQUEST['organization_id'];
    $query = "SELECT * FROM student WHERE student_id IN (SELECT student_id FROM student_organization_mapping WHERE organization_id=$organization_id)";
    $result = $con-> query($query);
    while($row = $result-> fetch_array()) {
        $student_details = Array();
        $student_details["student_id"] = $row[0];
        $student_name = $row[1]." ".$row[2]." ".$row[3];
        $student_details['student_name'] = $student_name;
        array_push($student_list, $student_details);
    }

    echo json_encode($student_list);
?>
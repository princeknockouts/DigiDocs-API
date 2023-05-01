<?php

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    include("../../MobileAppReturningAPI/dbcon.php");

    // Get the file data from the request
    $file_data = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    // $organization = $_REQUEST['organization_id'];
    $student_id = $_REQUEST['student_id'];
    // $type = $_REQUEST['type'];

    $target_dir = '../Student_data/'.$student_id.'/1/';
    $query = "INSERT INTO document_details(student_id, organization_id, document_name, path) VALUES (1, 1, '$file_name', '$target_dir')";
    if ($con-> query($query)) {
        $target_file = $target_dir . basename($file_name);
        move_uploaded_file($file_data, $target_file);

        echo "<script>
            alert('Done!!');
            window.location.href='http://localhost:3000/Organization/AddDocuments';
            </script>";
        die();
    } else {
        echo "<script>
            alert('Done!!');
            window.location.href='http://localhost:3000/Organization/AddDocuments';
            </script>";
        die();
    }
?>
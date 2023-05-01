<?php
	$con = new mysqli(
		"localhost",
		"root",
		"",
		"digidocs"
	);

	if($con-> connect_errno) {
		echo "Faild to connect to mysqli because".$con-> connect_error;
	}
?>
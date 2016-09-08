<?php
	require('dbconnect.php');
	$sql = 'SELECT * FROM logs WHERE 1';

	$display = mysqli_query($db, $sql) or die(mysqli_error($db));
	

	$json_data = array();

	while ($table = mysqli_fetch_assoc($display)) {
		
		$data = array('id' => $table["log_id"], 'lat' => $table["lat"], 'lng' => $table["lng"], 'title' => $table["title"]);

       	$json_data[] = $data;

	}

	echo json_encode($json_data);
	
?>
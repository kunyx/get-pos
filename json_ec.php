<?php
 	header("Access-Control-Allow-Origin: *");
	$data = array(
		array('id' => '1','name' => 'Cynthia'),
		array('id' => '2','name' => 'Keith'),
		array('id' => '3','name' => 'Robert'),
		array('id' => '4','name' => 'Theresa'),
		array('id' => '5','name' => 'Margaret')
	);
 
	echo json_encode($data);
?>

<?php
//namespace controller;

//use model\DbLayer;

session_start();

$_SESSION['prevPage'] = $_SESSION['prevPage'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if($requestMethod == "post") {
	try {
		$jsonString = file_get_contents("php://input");
		$json = json_decode($jsonString, true);
		
		//$username = trim($json['username']);
		//$password = trim($json['password']);
		
		$status = 0;
		//query for a user with that name
		//$dbLayer = new DbLayer();
		//$status = $$dbLayer->authenticateCustomer($username, $password);
		if($status == 0) {
			echo "failed";
		} else if($status == 1) {
			echo "failed";
		} else if($status == 2) {
			echo "success";
		} else {
			echo "error";
		}
	} catch (Exception $e) {
		echo "error";
	}
} else {
	echo "error."
}
?>

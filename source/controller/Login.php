<?php
//namespace controller;

use model\DbLayer;

include_once "../model/DbLayer.php";

session_start();

$_SESSION['prevPage'] = $_SESSION['prevPage'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if($requestMethod == "post") {
	try {
		$jsonString = file_get_contents("php://input");
		$json = json_decode($jsonString, true);
		
		$username = trim($json['username']);
		$password = trim($json['password']);

		//echo "username: $username, password: $password";
		
		//query for a user with that name
		$dbLayer = new DbLayer();
		$status = $dbLayer->authenticateCustomer($username, $password);
		echo strval($status);
	} catch (Exception $e) {
		echo "error";
	}
} else {
	echo "error."
}
?>

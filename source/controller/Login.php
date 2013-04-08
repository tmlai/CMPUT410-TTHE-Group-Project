<?php
//namespace controller;

use model\DbLayer;

include_once "../model/DbLayer.php";

session_start();

$_SESSION['prevPage'] = $_SESSION['prevPage'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if($requestMethod == "post") {
	$jsonString = file_get_contents("php://input");
	$json = json_decode($jsonString, true);
	
	$username = trim($json['username']);
	$password = trim($json['password']);
	
	//query for a user with that name
	$dbLayer = new DbLayer();
	$status = $dbLayer->authenticateCustomer($username, $password);
  
  // Check if user is admin (1 if admin, 0 not)
  if($dbLayer->authenticateAdmin($username, $password))
    $_SEESION['admin'] = 1;
  else
    $_SEESION['admin'] = 0;
  
	if($status == 2) {
		$_SESSION['user'] = $username;
	}
	//return status code
	echo strval($status);
}
?>

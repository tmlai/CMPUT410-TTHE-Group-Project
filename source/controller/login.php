<?php
namespace controller;

use model\DbLayer;

session_start();

$_SESSION['prevPage'] = $_SESSION['prevPage'];
$username = $_POST['username'];
$password = $_POST['password'];

try {
	//query for a user with that name
	$dbLayer = new DbLayer();
	$status = $$dbLayer->authenticateCustomer($username, $password);
	if($status == 0) {
		echo "failed";
	}
} catch (Exception $e) {

}
?>
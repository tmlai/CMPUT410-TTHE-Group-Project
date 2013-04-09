<?php
use model\DbLayer;

include_once '../model/DbLayer.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "GET"){
	$auth = $_GET["auth"];
	$transactionId = $_GET["tx"];
	
	if (!isset($transactionId) || trim($transactionId) === ""){
		$message = "Unexpected error happended. 
				Please contact our technical support team for help.";
		echo $message;
	}
	else if (!isset($auth) || $auth === ""){
		$message = "Your payment is not completed. 
				You are not charged with anything. 
				Please try again. We're sorry for any inconvenience.";
		echo $message;
	}
	else {
		$dbLayer = new DbLayer();
		$dbLayer->comleteTransaction($transactionId);
		
	}
	
	
	
}
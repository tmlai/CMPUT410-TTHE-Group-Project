<?php
namespace controller;

use model\DbLayer;

include_once '../model/DbLayer.php';

try {
	$dbLayer = new DbLayer();
    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	switch($requestMethod) {
		case 'post':
			//$id = file_get_contents("php://input");
			//echo $_SERVER['REQUEST_URI'];
			$quantity = $_POST['amount'];
			$storeId = 1;
			$cid = "c000014"; //hardcoded at the moment should retrieve it somehow
			$orderInfo = $dbLayer->receiveOrderFromStore($storeId, $cid, $quantity);
			echo $orderInfo;
			//NOTE: returns empty atm...
		case 'get':
			break;
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
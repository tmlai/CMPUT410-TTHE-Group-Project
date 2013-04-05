<?php
namespace controller;

use model\DbLayer;

include_once '../model/DbLayer.php';

try {
	$dbLayer = new DbLayer();
    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	switch($requestMethod) {
		case 'post':
			$oid = "some order id";
			$info = $dbLayer->checkDeliveryDate($oid);
			echo $oid;
			//no data for testing yet
		case 'get':
			break;
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
<?php
namespace controller;

use model\DbLayer;

include_once '../model/DbLayer.php';

try {
	$dbLayer = new DbLayer();
    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	switch($requestMethod) {
		case 'post':
			$oid = file_get_contents("php://input");
			$info = $dbLayer->checkDeliveryDate($oid);
			echo $info;
			//no data for testing yet
		case 'get':
			break;
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
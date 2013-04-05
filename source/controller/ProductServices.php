<?php
namespace controller;

use model\DbLayer;

include_once '../model/DbLayer.php';

try {
	$dbLayer = new DbLayer();
    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	switch($requestMethod) {
		case 'get':
			//if id is passed (GET /products/:id)
			//else (GET /products)
			if(!empty($_GET)) {
				$id = $_GET['id'];
				$product = $dbLayer->getOneProduct($id);
				echo $product;
			} else {
				$prodArray = $dbLayer->getProductsInStock();
				echo \json_encode($prodArray);
			}
			break;
		case 'post':
			//$id = file_get_contents("php://input");
			//echo $_SERVER['REQUEST_URI'];
			$quantity = file_get_contents("php://input");
			$storeId = 1;
			$cid = "c000014"; //hardcoded at the moment should retrieve it somehow
			$orderInfo = $dbLayer->receiveOrderFromStore($storeId, $cid, $quantity);
			echo $orderInfo;
			//NOTE: returns empty atm...
			
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
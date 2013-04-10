<?php
namespace controller;
use model\DbLayer;

include_once '../model/DbLayer.php';

try {
	$dbLayer = new DbLayer();
	$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	switch ($requestMethod) {
	case 'get':
	//if id is passed (GET /products/:id)
	//else (GET /products)
		if (!empty($_GET)) {
			// id param for one product
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
		$reUri = $_SERVER['REQUEST_URI'];

		$first_token = strtok($reUri, '/');
		$second_token = strtok('/');

		$quantity = file_get_contents("php://input");
		$storeId = 1;
		$cid = $second_token;
		$orderInfo = $dbLayer->receiveOrderFromStore($storeId, $cid, $quantity['amount']);
		echo $orderInfo;
	//NOTE: returns empty atm...

	}
} catch (Exception $e) {
	echo 'Caught exception: ', $e->getMessage(), "\n";
}
?>
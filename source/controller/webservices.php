<?php
namespace controller;

use model\OrderProduct;

use model\CustomerOrder;

use model\Store;

use model\Customer;

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
				echo \json_encode($product);
			} else {
				$prodArray = $dbLayer->getProductsInStock();
				echo \json_encode($prodArray);
			}
		case 'post':
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
<?php
namespace controller;

use model\DbLayer;

include_once '../model/DbLayer.php';

function getIP() {
	$ip;
	if (getenv("HTTP_CLIENT_IP"))
	$ip = getenv("HTTP_CLIENT_IP");
	else if(getenv("HTTP_X_FORWARDED_FOR"))
	$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if(getenv("REMOTE_ADDR"))
	$ip = getenv("REMOTE_ADDR");
	else
	$ip = "UNKNOWN";
	return $ip;

} 


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
			echo $_SERVER['REQUEST_URI'];
			
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
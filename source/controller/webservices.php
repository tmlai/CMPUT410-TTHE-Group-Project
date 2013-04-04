<?php
namespace controller;
include_once '../model/DbLayer.php';

try {
    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	switch($requestMethod) {
		case 'get':
			//if id is passed (GET /products/:id)
			//else (GET /products)
			if(!empty($_GET)) {
				$id = $_GET['id'];
			} else {
				$prodArray = getProductsInStock();
				echo \json_encode($prodArray);
			}
		case 'post':
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
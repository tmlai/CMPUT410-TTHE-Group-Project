<?php
namespace model;
include_once '../model/DbLayer.php';

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
switch($request_method) {
	case 'get':
		//if id is passed (GET /products/:id)
		//else (GET /products)
		if(!empty($_GET)) {
			$id = $_GET['id'];
		} else {
			// $prodArray = getProductsInStock();
			// echo json_encode($prodArray);
		}
	case 'post':
}

$prodArray = getProductsInStock();
echo json_encode($prodArray);
var_dump($prodArray);
?>
<?php
namespace controller;
include_once '../model/DbLayer.php';

$request_method = strtolower($_SERVER['REQUEST_METHOD']);
echo $request_method;
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
?>
<html>
<body>
<?
// $prodArray = getProductsInStock();
// echo json_encode($prodArray);
// var_dump($prodArray);
?>
</body>
</html>
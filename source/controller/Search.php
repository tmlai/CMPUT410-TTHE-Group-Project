<?php
session_start();
use model\DbLayer;
use model\Product;
include_once '../model/DbLayer.php';
include_once '../model/Product.php';

$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if($requestMethod == "get") {
	$partial = $_GET['searchField'];
	$dbLayer = new DbLayer();
	$list = $dbLayer->searchProductByName($partial);
	$allReturned = array();
	for($i=0; $i<count($list);$i++) {
		$singleProduct = new Object();
		$singleProduct = $list[$i];
		var_dump($singleProduct);
		echo "<br>";
		// $singleProduct['cid'] = $product['cid'];
		// $singleProduct['name'] = $product['name']; 
		// $singleProduct['price'] = $product['price']; 
		// $singleProduct['weight'] = $product['weight'];
		// $singleProduct['description'] = $product['description'];
		$allReturned[$i] = $singleProduct;
	}
	//echo json_encode($list);
	// var_dump($allReturned);
	// echo json_encode($allReturned);
}
?>
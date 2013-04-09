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
		$singleProduct = $list[$i];
		$cid = $singleProduct->getCid();
		$price = $singleProduct->getPrice();
		$weight = $singleProduct->getWeight();
		$name = $singleProduct->getName();
		$description = $singleProduct->getDescription();
		$image = $singleProduct->getImage();
		
		//create a new object
		$singleObj = (object) array(
			'cid'=>$cid, 'price'=>$price,
			'weight'=>$weight, 'name'=>$description,
			'image'=>$image);
		$allReturned[$i] = $singleObj;
	}

	echo json_encode($allReturned);
}
?>
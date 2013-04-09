<?php
session_start();
use model\DbLayer;
use model\Product;
include_once '../model/DbLayer.php';
include_once '../model/Product.php';

$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
$jsonSearch = file_get_contents("php://input");
$search = json_decode($jsonSearch, true);
if($requestMethod == "post") {
	$dbLayer = new DbLayer();
	$name = trim($search['name']);
	$code = trim($search['code']);
	$category = trim($search['category']);
	$priceFrom = trim($search['priceFrom']);
	$priceTo = trim($search['priceTo']);
	$minQty = trim($search['minQty']);
	$maxQty = trim($search['maxQty']);
	$minWeight = trim($search['minWeight']);
	$maxWeight = trim($search['maxWeight']);

	//if empty set as null
	if($name == "") {
		$name = null;
	}
	if($code == "") {
		$code = null;
	}
	if($category == "") {
		$category = null;
	}
	if($priceFrom == "") {
		$priceFrom = null;
	}
	if($priceTo == "") {
		$priceTo = null;
	}
	if($minQty == "") {
		$minQty = null;
	}
	if($maxQty == "") {
		$maxQty = null;
	}
	if($minWeight == "") {
		$minWeight = null;
	}
	if($maxWeight == "") {
		$maxWeight = null;
	}
	//build arrays for ranges
	$priceRange[DbLayer::LOWER_BOUND] = $priceFrom;
	$priceRange[DbLayer::UPPER_BOUND] = $priceTo;
	$availRange[DbLayer::LOWER_BOUND] = $minQty;
	$availRange[DbLayer::UPPER_BOUND] = $maxQty;
	$weightRange[DbLayer::LOWER_BOUND] = $minWeight;
	$weightRange[DbLayer::UPPER_BOUND] = $maxWeight;

	$list = $dbLayer->searchProductByConstraints(
		$name, $code, $category, $priceRange, $availRange, $weightRange );
	//var_dump($list);
	$allReturned = array();
	for($i=0; $i<count($list); $i++) {
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
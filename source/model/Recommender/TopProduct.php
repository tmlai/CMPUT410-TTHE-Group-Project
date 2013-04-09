<?php
use model\DbLayer;
use model\Product;
include_once ('../DbLayer.php');
include_once ('../Product.php');

// function checkStock($productId){
// 	$stock = DbLayer::getStock($productId);
// 	if ($stock == 0){
// 		//call webservice to check
// 	}
// 	return $stock;
// }

$requestMethod = $_SERVER['REQUEST_METHOD'];

$format = 'Y-m-d H:i:s';
$days = 30;
$to = new \DateTime();
$from = new \DateTime();
$from->sub(new \DateInterval("P{$days}D"));

$to = $to->format($format);
$from = $from->format($format);

$category = null;
$numberOfProduct = 10;

if ($requestMethod == "POST"){
	$tempDate = $_POST["date"];
	if (!isset($tempDate) || trim($tempDate) === "")
		$crrDate = date();
	
	$tempDays = $_POST["days"];
	if (!isset($tempDays) || trim($tempDays) === "")
		if ( is_numeric($tempDays))
			$days = $tempDays;
		
	$tempCategory = $_POST["category"];
	if (!isset($tempCategory) || trim($tempCategory) === "")
		$category = $tempCategory;
	
	$tempNumberOfProduct = $_POST["numProduct"];
	if (!isset($tempNumberOfProduct) || trim($tempNumberOfProduct) === "")
		if (is_numeric($tempNumberOfProduct))
			$numberOfProduct = $tempNumberOfProduct;
}
elseif ($requestMethod == "GET"){
	
	$tempDate = $_GET["date"];
	if (!isset($tempDate) || trim($tempDate) === "")
		$crrDate = date();
	
	$tempDays = $_GET["days"];
	if (!isset($tempDays) || trim($tempDays) === "")
		if ( is_numeric($tempDays))
			$days = $tempDays;
		
	$tempCategory = $_GET["category"];
	if (!isset($tempCategory) || trim($tempCategory) === "")
		$category = $tempCategory;
	
	$tempNumberOfProduct = $_GET["numProduct"];
	if (!isset($tempNumberOfProduct) || trim($tempNumberOfProduct) === "")
		if (is_numeric($tempNumberOfProduct))
			$numberOfProduct = $tempNumberOfProduct;
}
else{
	header("HTTP/1.0 400 BAD REQUEST");
	exit();
}

$dbLayer = new DbLayer();
$topProductList = $dbLayer->getTopNSellings($numberOfProduct, $from, $to, $category);

// $topProductList = $dbLayer->getTopNSellings(5,null,null);
$topProductJSONList = array();
foreach ($topProductList as &$topProduct){
	/* @var $topProduct Product */
	$topProductJSONList[] = $topProduct->toAssociativeArray();
	//return a list of json data
}
echo json_encode($topProductJSONList);	
?>
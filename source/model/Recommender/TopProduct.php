<?php
namespace model;

include_once ('../DbLayer.php');

function checkStock($productId){
	$stock = DbLayer::getStock($productId);
	if ($stock == 0){
		//call webservice to check
	}
	return $stock;
}

$requestMethod = $_SERVER['REQUEST_METHOD'];

$crrDate = date();
$days = 30;
$category = "";
$numberOfProduct = "1";

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

// $topProductList = DbLayer::getTopNSellings($numberOfProduct,$crrDate-$days,$crrDate);
$topProductList = DbLayer::getTopNSellings(5,null,null);
$topProductJSONList = array();
foreach ($topProductList as $topProduct){
	//todo: modify to just pass id, name, price
	//do we want to recommend products out of stock?
	$simpleTopProduct = array (
			"cid" => $topProduct.getCid(),
			"name" => $topProduct.getName(),
			"price" => $topProduct.getPrice(),
			"image" => $topProduct.getImage(),
			"description" => $topProduct.getDescription()
	);
	$topProductJSON = json_encode($simpleTopProduct);
	$topProductJSONList[] =$topProductJSON;
	//return a list of json data
}
return json_encode($topProductJSONList);	
?>
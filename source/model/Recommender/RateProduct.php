<?php
namespace model;

include_once ('DbLayer.php');
include_once ('UserRatingProduct');

$requestMethod = $_SERVER['REQUEST_METHOD'];

$userName = $_SESSION["user"]; // from session


if ($requestMethod == "POST"){
	
	if (!isset($userName) || $userName === ""){
		$message = array(
				"status" => "Failed",
				"message" => "You have to login"
		);
	}
	else {
		$productId = $_POST["productId"];
		$rating = $_POST["rating"];
		
		$result = DbLayer.php::rateProduct(new UserRatingProduct($userName,$productId,$rating));
		$message = array();
		if ($result){
			$message = array(
				"status" => "Ok",
				"message" => "Your rating is updated." 	
			);
		}
		else{
			$message = array(
			"status" => "Failed",
			"message" => "Your rating could not be updated. Please try again."
			);
		}
	}
	return json_encode($message);
}
elseif ($requestMethod == "GET"){
	$cat = $_GET["category"];
	$n = $_GET["n"];
	if (!isset($cat) || trim($cat) === ""){
		$cat = null;
	}
	if (!isset($cat) || trim($cat) === ""){
		$n = 5;
	}
	$productList = recommendRelatedProducts($n, $cat);
	$productJSONList = array();
	foreach ($productList as $product){
		$simpleProduct = array (
			"cid" => $product.getCid(),
			"name" => $product.getName(),
			"price" => $product.getPrice(),
			"image" => $product.getImage(),
			"description" => $product.getDescription()
		);
		$simpleProductJSON = json_encode($simpleProduct	);
		$productJSONList[] =$simpleProductJSON;
	}
	return json_encode($productJSONList);
}

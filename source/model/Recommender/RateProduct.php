<?php 
use model\DbLayer;

include_once ('../DbLayer.php');
include_once ('../UserRatingProduct.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "POST"){
	$userName = $_SESSION["user"]; // from session	
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
	echo json_encode($message);
}
elseif ($requestMethod == "GET"){
	$cat = $_GET["category"];
// 	echo "Cat".$cat."<br/>";
	$n = $_GET["n"];
// 	echo "n ".$n."<br/>";
	if (!isset($cat) || trim($cat) === ""){
		$cat = null;
	}
	if (!isset($n) || trim($n) === ""){
		$n = 5;
	}

	$dbLayer = new DbLayer();
	$productList = $dbLayer->recommendRelatedProducts($n, $cat);
	

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
// 	echo "json array".$productJsonList."<br/>";
	echo json_encode($productJSONList);
}

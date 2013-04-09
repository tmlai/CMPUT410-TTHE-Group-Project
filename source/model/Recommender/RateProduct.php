<?php
echo "before include";
include_once ('../DbLayer.php');
include_once ('../UserRatingProduct');

echo "b4 get request method";
$requestMethod = $_SERVER['REQUEST_METHOD'];

echo "before get user from session";
$userName = $_SESSION["user"]; // from session
echo "after get user from session".$userName;

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
	echo json_encode($message);
}
elseif ($requestMethod == "GET"){
	$cat = $_GET["category"];
	echo "Cat".$cat."<br/>";
	$n = $_GET["n"];
	echo "n".$n."<br/>";
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
		echo "before encoding<br/>";
		$simpleProductJSON = json_encode($simpleProduct	);
		echo "after encoding<br/>";
		$productJSONList[] =$simpleProductJSON;
	}
	echo "json array".$productJsonList."<br/>";
	echo json_encode($productJSONList);
}

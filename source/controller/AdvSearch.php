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
	// $name = trim()
	// $code = document.getElementById('searchCodeField').value.trim;
	// $category = document.getElementById('searchCategoryField').value.trim;
	// $priceFrom = document.getElementById('priceFromField').value.trim;
	// $priceTo = document.getElementById('priceToField').value.trim;
	// $minQty = document.getElementById('minQtyField').value.trim;
	// $maxQty = document.getElementById('maxQtyField').value.trim;
	// $minWeight = document.getElementById('minWeightField').value.trim;
	// $maxWeight = document.getElementById('maxWeightField').value.trim;
	var_dump($jsonSearch);
	
	
	
	
	
	
	// $dbLayer = new DbLayer();
	// $list = $dbLayer->searchProductByName($partial);
	// $allReturned = array();
	// for($i=0; $i<count($list);$i++) {
		// $singleProduct = $list[$i];
		// $cid = $singleProduct->getCid();
		// $price = $singleProduct->getPrice();
		// $weight = $singleProduct->getWeight();
		// $name = $singleProduct->getName();
		// $description = $singleProduct->getDescription();
		// $image = $singleProduct->getImage();
		
		// //create a new object
		// $singleObj = (object) array(
			// 'cid'=>$cid, 'price'=>$price,
			// 'weight'=>$weight, 'name'=>$description,
			// 'image'=>$image);
		// $allReturned[$i] = $singleObj;
	// }

	// echo json_encode($allReturned);
}
?>
<?php
session_start();
use model\DbLayer;
use model\CustomerOrder;
use model\OrderProduct;
use model\Store;

include_once ('DbLayer.php');
include_once ('CustomerOrder.php');
include_once ('OrderProduct.php');
include_once ('Store.php');


$priceTolerance = 1.10;

function processOneProduct($productId,$ourPrice,$toOrder,$markets){
	$toOrderInfo = array();
	$choosenStore = null;
	$minPrice = -1.0;
	foreach ($markets as $store){
		$checkingStore = new Store(0, "", $store["name"], $store["url"]);
		$url = $checkingStore->getUrl()."/products/".$productId;
		$productsInfo = file_get_contents($url);
		$productsInfoJson = json_decode($productsInfo, true);
		$stocksInfo[$url] = $productsInfoJson["quantity"];
		$eStoreQuantity = intval($productsInfoJson["quantity"]);
		$eStorePrice = intval($productsInfoJson["price"]);
		if ($eStoreQuantity >= $toOrder 
			&& $eStorePrice <= $ourPrice* $GLOBALS["priceTolerance"]){
			if ($minPrice == -1.0 || $minPrice > $eStorePrice){
				$minPrice = $eStorePrice;
				$choosenStore = $checkingStore;
			}
		}
	}
	
	if ($minPrice == -1.0){
		echo "step 0";
		return False;	
	}
	// sort by stock price from lowest to highest
	asort($toOrderInfo);
	
	//get or create a store with the given url
	$choosenStore = getCreateStoreId($choosenStore);
	if ($choosenStore == False){
		echo "step 1";
		return False;
	}
	
	
	//Ordering from the chosen store
	$orderUrl = $choosenStore->getUrl()."/products/".$productId."/order";
	$data = array('amount' => $toOrder);
	$options = array(
			'http' => array(
					'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
					'method'  => 'POST',
					'content' => http_build_query($data),
			),
	);
	$context  = stream_context_create($options);
	$orderResult = file_get_contents($orderUrl, false, $context);
	if (!isset($orderResult) || $orderResult === ""){
		echo "step 2";
		return False;
	}
	else{
		$orderResultJson = json_decode($orderResult, true);
		return new OrderProduct(0, $productId, $choosenStore->getStoreId(), $toOrder, $orderResultJson["order_id"],
				$orderResultJson["delivery_date"], $toOrder * $ourPrice);
	}
	

}

function getCreateStoreId($store){
	$dbLayer = new DbLayer();
	$storeDb = $dbLayer->searchStore($store->getUrl());
	
	if ($storeDb == null){
		if ($dbLayer->addStore($store)){
			$storeDb = $dbLayer->searchStore($store->getUrl());
			return $storeDb;
		}
		else{
			//cannot add new store, cancel processing
			return False;
		}
	}
	else{
		return $storeDb;
	}
}

$url = "http://cs410-ta.cs.ualberta.ca/registration/markets";
$dbLayer = new DbLayer();
$requestMethod = $_SERVER['REQUEST_METHOD'];
$markets = "";

if ($requestMethod == "GET"){
	$message = "False";
	$marketInfo = file_get_contents($url);
	
	if (!isset($marketInfo) || trim($marketInfo) === ""){
		$message = "False";
	}
	else{
		$productId = $_GET["cid"];
		$quantity = intval($_GET["quantity"]);
		$ourPrice = $dbLayer->getPrice($productId);
// 		echo "<br />Asking for id ".$productId." quantity ".$quantity."<br />";
		try {
			$marketsJson = json_decode($marketInfo, true);
			$markets = $marketsJson["markets"];
// 			$totalAvailable = 0;
			foreach ($markets as $store){
				$url = $store["url"]."/products/".$productId;
				$productsInfo = file_get_contents($url);
				$productsInfoJson = json_decode($productsInfo, true);

// 				echo "<br />PQuantity ".$productsInfoJson["quantity"]."<br/> ";
// 				$totalAvailable += intval($productsInfoJson["quantity"]);
// 				echo "<br />Total available ".$totalAvailable."<br/> ";
				$eStoreQuantity = intval($productsInfoJson["quantity"]);
				$eStorePrice = (float)$productsInfoJson["price"];
				if ( $eStoreQuantity >= $quantity
					&& $eStorePrice <= $ourPrice * $priceTolerance){
					$message = "True";
					break;
				}
			}	
		} catch (Exception $e) {
			$message = $e;
		}
	}
	
	echo $message;
}



if ($requestMethod == "POST"){
	$message = array("status" => "False",
			"message" => "by default",
			"deliveryDate" => ""
	);
	
	$userName = $_SESSION["user"];
// 	echo "user name:[".$userName."]<br/>";
	//TODO:
// 	$userName = "hcngo";
	$products = $_POST["orderLists"];
	
	$productsJson = json_decode($products, true);
	//TODO:
// 	echo "<br/>username ".$userName."<br/>";
// 	echo "<br/>orders ".$products."<br/>\n";
	
	$customerOrder = new CustomerOrder(0, '', '', $userName, 0, '');
	$orderProductsArray = array();
	$failed = False;
	$success = False;
	foreach($productsJson as $productJson){
		$productId = $productJson["cid"];
		$quantity = $productJson["quantity"];
		$crrStock = $dbLayer->getStock($productId);
		echo "crrStock ".$crrStock."<br/>";
		$ourPrice = $dbLayer->getPrice($productId);
		if ($crrStock >= $quantity){
			$orderProductsArray[] = new OrderProduct(0, $productId, 1, $quantity, 0,
					 "", $quantity * $ourPrice);
			$success = True;
			$message["message"] .= "Get from our stock\n<br/>";
		}
		else {
			if ($crrStock > 0){
				$orderProductsArray[] = new OrderProduct(0, $productId, 1, $crrStock, "",
					"", $quantity * $ourPrice);
			}
			$toOrder = $quantity - $crrStock;
			
			$marketInfo = file_get_contents($url);
			if (!isset($marketInfo) || trim($marketInfo) === ""){
				//Have not enough product, cannot call the api, cancel processing
				$failed = True;
				$message["message"] =  "Have not enough product in store for product ".$productId;
				break;
			}
			else{
				$marketsJson = json_decode($marketInfo, true);
				$markets = $marketsJson["markets"];
				$result = processOneProduct($productId,$ourPrice,$toOrder,$markets);
				if ($result != False){
					$orderProductsArray[] = $result;
					$success = True;
				}
				else {
					//Cannot order from another store, cancel processing
					$failed = True;
					$message["message"] = "Could get products from our peer for product ".$productId;
					break;
				}
			}
		}		
	}
	//finished process all order
	//If we succeeded at least once and never failed
	if ($success == True && $failed == False){
		$message["status"] = "True";
		echo "array size ".count($orderProductsArray)." <br/>";
		$dbLayer->addOrder($customerOrder,$orderProductsArray);
		//todo
		$message["deliveryDate"] == "2013-04-08";
	}
	
	echo json_encode($message);
// 

	
	

// 	echo $message;
// 	exit();
}
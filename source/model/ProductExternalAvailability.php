<?php
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
	$orderedStore = "";
	foreach ($markets as $store){
		$orderedStore = new Store(0, date(), $store["name"], $store["url"]);
		$url = $orderedStore.getUrl()."/products/".$productId;
		$productsInfo = file_get_contents($url);
		$productsInfoJson = json_decode($productsInfo, true);
		$stocksInfo[$url] = $productsInfoJson["quantity"];
		$eStoreQuantity = intval($productsInfoJson["quantity"]);
		$eStorePrice = intval($productsInfoJson["price"]);
		if ($eStoreQuantity >= $quantity 
			&& $eStorePrice <= $ourPrice* $GLOBALS["priceTolerance"]){
			$toOrderInfo[$orderedStore] = $eStorePrice;
		}
	}

	// sort by stock price from lowest to highest
	asort($toOrderInfo);
	
	//Ordering
	$deliverDate = "";
	foreach ($toOrderInfo as $key => $val){
		$orderUrl = $key."/products/".$productId."/order";
		$data = array('amount' => $quantity);
		$options = array(
				'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data),
				),
		);
		$context  = stream_context_create($options);
		$returnJson = file_get_contents($key, false, $context);
		if (!isset($deliverDate) || $deliverDate === ""){
			return False;
		}
		else{
			//Key is the url of the store
			return array($orderedStore => $returnJsonString);
		}
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
	$message = array("status" => "True",
			$message["deliveryDate"] == "date time here"
	);
	
	$userName = $_SESSION["user"];
	$products = $_POST["orderLists"];
	$productsJson = json_decode($productsJson, true);

	$customerOrder = new CustomerOrder(0, "", '', $userName, 0, '');
	$orderProductsArray = array();
	foreach($productsJson as $productJson){
		$productId = $productJson["cid"];
		$quantity = $productJson["quantity"];
		$crrStock = $dbLayer->getStock($productId);
		$ourPrice = $dbLayer->getPrice($productId);
		if ($crrStock >= $quantity){
			$orderProductsArray[] = new OrderProduct(0, $productId, 1, $quantity, "",
					 "", $quantity * $ourPrice);
			$message["status"] = "True order from our own store";
		}
		else {
			$orderProductsArray[] = new OrderProduct(0, $productId, 1, $crrStock, "",
					"", $quantity * $ourPrice);
			$toOrder = $quantity - $crrStock;
			
			$marketInfo = file_get_contents($url);
			if (!isset($marketInfo) || trim($marketInfo) === ""){
				//Have not enough product, cannot call the api, cancel processing
				$message["status"] = "False have not enough product, cannot call the api";
			}
			else{
				$marketsJson = json_decode($marketInfo, true);
				$markets = $marketsJson["markets"];
				$result = processOneProduct($productId,$ourPrice,$toOrder,$markets);
				if ($result != False){
					foreach($result as $store => $orderJsonString){
						$storeId = $dbLayer->searchStore($store.getUrl());
						$orderJson = json_decode($orderJsonString, true);
						if ($storeId == null){
							if ($dbLayer->addStore($store)){
								$storeId = $dbLayer->searchStore($store.getUrl());
							}
							else{
								//cannot add new store, cancel processing
								$message["status"] = "False cannot add new store";
							}
						}
						$orderProductsArray[] = new OrderProduct(0, $productId, $storeId, $toOrder, $orderJson["order_id"],
								$orderJson["delivery_date"], $toOrder * $ourPrice);
					}
				}
				else {
					//Cannot order from another store, cancel processing
					$message["status"] = "False cannot order from another store";
				}
			}
		}		
	}
	//finished process all order
	if ($message["status"] == "True"){
		$dbLayer->addOrder($customerOrder,$orderProductsArray);
		//todo
		$message["deliveryDate"] == "apr mon 8 2013";
	}
	
	echo json_encode($message);
// 

	
	

// 	echo $message;
// 	exit();
}
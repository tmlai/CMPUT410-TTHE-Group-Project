<?php
include_once ('DbLayer');

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
		$ourPrice = DbLayer::getPrice($productId);
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
	$message = array("status" => "True");
	
	$userName = $_SESSION["user"];
	$products = $_POST["orderLists"];
	$productsJson = json_decode($productsJson, true);
	$message = "False";
	$customerOrder = new CustomerOrder(0, "", '', $userName, 0, '');
	$orderProductsArray = array();
	foreach($productsJson as $productJson){
		$productId = $productJson["cid"];
		$quantity = $productJson["quantity"];
		$crrStock = DbLayer::getStock($productId);
		$ourPrice = DbLayer::getPrice($productId);
		if ($crrStock >= $quantity){
			$orderProductsArray[] = new OrderProduct(0, $productId, 1, $quantity, "",
					 "", $quantity * $ourPrice);
		}
		else {
			$orderProductsArray[] = new OrderProduct(0, $productId, 1, $crrStock, "",
					"", $quantity * $ourPrice);
			$toOrder = $quantity - $crrStock;
			
			$marketInfo = file_get_contents($url);
			if (!isset($marketInfo) || trim($marketInfo) === ""){
				//Have not enough product, cannot call the api, cancel processing
				$message["status"] = "False";
			}
			else{
				$marketsJson = json_decode($marketInfo, true);
				$markets = $marketsJson["markets"];
				$result = processOneProduct($productId,$ourPrice,$toOrder,$markets);
				if ($result != False){
					foreach($result as $store => $orderJsonString){
						$storeId = DbLayer::searchStore($store.getUrl());
						$orderJson = json_decode($orderJsonString, true);
						if ($storeId == null){
							if (DbLayer::addStore($store)){
								$storeId = DbLayer::searchStore($store.getUrl());
							}
							else{
								//cannot add new store, cancel processing
								$message["status"] = "False";
							}
						}
						$orderProductsArray[] = new OrderProduct(0, $productId, $storeId, $toOrder, $orderJson["order_id"],
								$orderJson["delivery_date"], $toOrder * $ourPrice);
					}
				}
				else {
					//Cannot order from another store, cancel processing
					$message["status"] = "False";
				}
			}
		}		
	}
	//finished process all order
	if ($message["status"] == "True"){
		DbLayer::addOrder($customerOrder,$orderProductsArray);
		//todo
		$message["deliveryDate"] == date();
	}
	
	echo json_encode($message);
// 

	
	

// 	echo $message;
// 	exit();
}
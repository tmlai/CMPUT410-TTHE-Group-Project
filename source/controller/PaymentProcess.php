<?php
session_start();
use model\DbLayer;
use model\TransactionLayer;
use model\CustomerOrder;
use model\OrderProduct;
use model\Store;

include_once ('DbLayer.php');
include_once ('CustomerOrder.php');
include_once ('OrderProduct.php');
include_once ('Store.php');
include_once ('TransactionLayer');


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
		return False;
	}
	// sort by stock price from lowest to highest
	asort($toOrderInfo);

	//get or create a store with the given url
	$choosenStore = getCreateStoreId($choosenStore);
	if ($choosenStore == False){
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

$groupNumber = 4;
$retUrl = "http://cs410.cs.ualberta.ca:41041/source/controller/CompleteTransaction.php";
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == "POST"){
	$message = array("status" => "False",
			"message" => "by default",
			"deliveryDate" => ""
	);
	
// 	echo "hahaha";
	$dbLayer = new DbLayer();
	
	$userName = $_SESSION["user"];
	$products = $_POST["orderLists"];
	$productsJson = json_decode($products, true);

	$customerOrder = new CustomerOrder(0, '', '', $userName, 0, '');
	$orderProductsArray = array();
	$failed = False;
	$success = False;
	$totalAmount = 0;
	foreach($productsJson as $productJson){
		$productId = $productJson["cid"];
		$quantity = $productJson["quantity"];
		$crrStock = $dbLayer->getStock($productId);
// 		echo "crrStock ".$crrStock."<br/>";
		$ourPrice = $dbLayer->getPrice($productId);
		if ($crrStock >= $quantity){
			$orderProduct = new OrderProduct(0, $productId, 1, $quantity, 0,
					"", $quantity * $ourPrice);
			$orderProductsArray[] = $orderProduct;
			$totalAmount += $orderProduct->getAmount();
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
					$totalAmount += $result->getAmount();
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
		$transLayer = new TransactionLayer();
		$transactionId = $transLayer->addTransaction($customerOrder,$orderProductsArray);
		if ($transactionId == 0){
			$message["message"] = "Transaction could not be stored into database";
		}
		else{
			$message["status"] = "True";
			$payBuddyUrl = "http://cs410.cs.ualberta.ca:42001/paybuddy/payment.cgi?";
			$params = "grp=".$groupNumber;
			$params.= "&amt=".$totalAmount;
			$params.= "&tx=".$transactionId;
			$params.= "&ret=".$retUrl;
			$params.= "target=_blank";
			header("Location:".$payBuddyUrl.$params);
		}
	}
	echo json_encode($message);
}
?>
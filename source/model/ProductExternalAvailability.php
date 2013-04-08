<?php

function getJsonFromUrl($url){
	if (isset($url) && trim($url) !== ''){
		$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	
		$result = curl_exec ($curl);
		curl_close ($curl);
	
		return $result;
	}
	else{
		return "";
	}
}


$url = "http://cs410.cs.ualberta.ca:42001/registration/markets";
$message = "False";

$marketInfo = getJsonFromUrl($url);

if (!isset($marketInfo) || trim($marketInfo) === ""){
	$message = "Cannot access market data";
}
else{
	echo "Market info:<br/>".$marketInfo."<br/>";
	$productId = $_GET["cid"];
	$quantity = $_GET["quantity"];
	try {
		$marketsJson = json_decode($marketInfo);
		$markets = $marketsJson["markets"];
		foreach ($markets as $store){
			$url = $store["url"];
			$instockProducts = getJsonFromUrl($url."/products");
			$instockProductsJson = json_decode($instockProducts);
			$instockProductIds = $instockProductsJson["products"];
			foreach ($instockProductIds as $instockProductId){
				if ($instockProductId == $productId){
					if ($quantity == 1 || $quantity == "1"){
						$message = "True";
					}
					else{
						$url.="/products/".$instockProductId;
						$productsInfo = getJsonFromUrl($url."/products");
						$productsInfoJson = json_decode($productsInfo);
						if ($productsInfoJson["qunatity"] >= $quantity)
							$message = "True";
					}
				}	
			}
		}
	} catch (Exception $e) {
		$message = $e;
	}
}

echo $message;
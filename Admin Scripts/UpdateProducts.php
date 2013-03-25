<?php
include_once "../source/model/DbLayer.php";
# http://www.w3schools.com/php/php_file_upload.asp

#allowed file types (our file extension support)
$allowedExts = array("json");

#extension of the uploaded file
$extension = end(explode(".", $_FILES["file"]["name"]));



if ($_FILES["file"]["error"] > 0) {
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
	}
else {
	echo "Upload: " . $_FILES["file"]["name"] . "<br>";
	echo "Type: " . $_FILES["file"]["type"] . "<br>";
	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
	echo "Stored in: " . $_FILES["file"]["tmp_name"];
	var_dump($_FILES["file"]);
	echo "<br>";
	#parse the json file
	$productList = decodeData($_FILES["file"]["tmp_name"]);
	for($i = 0; $i < count($productList); $i++){
		$product = convertIntoProduct($productList[$i]);
		$dbLayer = new \model\DbLayer();
		$result = $dbLayer->addProduct($product);
		if($result){
			echo "add product ".($i + 1)."successfully. <br>";
		}else{
			echo "cannot add product ".($i + 1)."<br>";
		}
	}
  }
  
  function convertIntoProduct($productArray){
  	$product = new \model\Product($productArray['cid'], $productArray['name'],
  			 $productArray['desc'], $productArray['image'], 
  			$productArray['price'], '', '', 20);
  	return $product;
  }
  
function decodeData($fileName) {
	$productList = Array();

	$file = fopen($fileName, "r") or exit("Unable to open file!");
	//Output a line of the file until the end is reached
	while (!feof($file)) {
		$jsonProduct = utf8_encode(fgets($file));
		if (trim($jsonProduct) != '') {
			$product = json_decode($jsonProduct, TRUE);
			array_push($productList, $product);
		}
	}
	fclose($file);
	return $productList;
}
?> 
<?php
include_once "../source/model/DbLayer.php";
# http://www.w3schools.com/php/php_file_upload.asp

#allowed file types (our file extension support)
$allowedExts = array("json");

#extension of the uploaded file
$extension = end(explode(".", $_FILES["file"]["name"]));

$map = array('c000001' => 6, 'c000002' => 5, 'c000003' => 5, 'c000004' => 4,
		'c000005' => 4, 'c000006' => 1, 'c000007' => 1, 'c000008' => 1,
		'c000009' => 7, 'c000010' => 7, 'c000011' => 4, 'c000012' => 4,
		'c000013' => 8, 'c000014' => 8, 'c000015' => 7, 'c000016' => 4,
		'c000017' => 1, 'c000018' => 5, 'c000019' => 5, 'c000020' => 16, 'd000001' => 17, 'd000002' => 17);

if ($_FILES["file"]["error"] > 0) {
	echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
	echo "Upload: " . $_FILES["file"]["name"] . "<br>";
	echo "Type: " . $_FILES["file"]["type"] . "<br>";
	echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
	echo "Stored in: " . $_FILES["file"]["tmp_name"];
	var_dump($_FILES["file"]);
	echo "<br>";
	#parse the json file
	$productList = decodeData($_FILES["file"]["tmp_name"]);
	for ($i = 0; $i < count($productList); $i++) {
		$product = convertIntoProduct($productList[$i]);
		$dbLayer = new \model\DbLayer();
		$result = $dbLayer->addProduct($product);
		if ($result) {
			echo "add product " . ($i + 1) . "successfully. <br>";
			$result = $dbLayer
					->matchProductCategory($product->getCid(),
							$map[$product->getCid()]);
			if ($result) {
				echo "match the product with category successfully.<br>";
			} else {
				echo "cannot match the product with category!<br>";
			}
		} else {
			echo "cannot add product " . ($i + 1) . "<br>";
		}
	}
}

function convertIntoProduct($productArray) {
	$product = new \model\Product($productArray['cid'], $productArray['name'],
			$productArray['desc'], $productArray['image'],
			$productArray['price'], $productArray['weight'], $productArray['dimensions'], 1000);
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
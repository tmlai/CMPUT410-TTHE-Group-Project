<?php
session_start();

$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

// get the product name given the product id
use model\DbLayer;

$list = new Array();

if($requestMethod == "get") {
	$search = $_GET['searchField'];
	$dbLayer = new DbLayer();
	$list = $dbLayer->searchProduct($search);
	// var_dump($search);
	echo "into if statement";
}
//echo \json_encode($list);

?>
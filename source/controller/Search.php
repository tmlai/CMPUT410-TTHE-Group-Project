<?php
session_start();

$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

include_once '../model/DbLayer.php';
use model\DbLayer;
$list = "";

if($requestMethod == "get") {
	$search = $_GET['searchField'];
	$dbLayer = new DbLayer();
	$list = $dbLayer->searchProduct($search);
	// var_dump($search);
	echo "into if statement";
}
//echo \json_encode($list);

?>
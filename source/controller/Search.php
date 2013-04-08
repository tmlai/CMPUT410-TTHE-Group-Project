<?php
session_start();
use model\DbLayer;
include_once '../model/DbLayer.php';


$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if($requestMethod == "get") {
	$search = $_GET['searchField'];
	// $dbLayer = new DbLayer();
	// $list = $dbLayer->searchProduct($search);
	// // var_dump($search);
	echo $search;
}
echo "out of if";
?>
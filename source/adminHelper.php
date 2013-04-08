<?php
namespace controller;
use controller\AdminHelper;

use model\DbLayer;
use model\Customer;
use model\Product;
use model\Store;
use model\Olap;
use model\Category;
include_once './model/DbLayer.php';
include_once './model/Customer.php';
include_once './model/Product.php';
include_once './model/Store.php';
include_once './model/Olap.php';
include_once './model/Category.php';
class AdminHelper {
	public static function getListCustomers() {
		$dbLayer = new DbLayer();
		$list = $dbLayer->getListCustomers();

		$output .= "<option value=''>...</option>";
		$output .= "<option value='NULL'>NULL</option>";
		foreach ($list as &$row) {
			/* @var $row Customer */
			$oneOpt = "<option value='{$row->getUsername()}'> {$row->getUsername()} </option>";
			$output .= $oneOpt;
		}
		echo $output;
	}
	
	public static function getListProducts(){
		$dbLayer = new DbLayer();
		$list = $dbLayer->getProducts();
		$output .= "<option value=''>...</option>";
		$output .= "<option value='NULL'>NULL</option>";
		foreach($list as &$prod){
			/* @var $prod Product */
			$oneOpt = "<option value='{$prod->getCid()}'>{$prod->getCid()}</option>";
			$output .= $oneOpt;
		}
		echo $output;
	}
	
	public static function getListExternalStores(){
		$dbLayer = new DbLayer();
		$list = $dbLayer->getListExternalStores();
		$output .= "<option value=''>...</option>";
		$output .= "<option value='NULL'>NULL</option>";
		foreach($list as &$store){
			/* @var $store Store */
			$oneOpt = "<option value='{$store->getStoreId()}'>{$store->getStoreId()}</option>";
			$output .= $oneOpt;
		}
		echo $output;
	}
	
	public static function getListCategories(){
		$dbLayer = new DbLayer();
		$list = $dbLayer->getCategoriesList();
		$output = "<option value='any'>any</option>";
		foreach($list as &$cate){
			/* @var $prod Category */
			$oneOpt = "<option value='{$cate->getCateId()}'>{$cate->getCateId()}</option>";
			$output .= $oneOpt;
		}
		echo $output;
	}
	
	public static function getListGenOlaps(Olap $olapObj){
		echo "<table border=1><caption>GENERAL OLAP</caption>";
		echo "<tr><th>Customer</th>
		<th>Product ID</th>
		<th>Store ID</th>
		<th>From</th>
		<th>To</th>
		<th>Aggregated Count</th>
		<th>Amounts</th></tr>";
		$dbLayer = new DbLayer();
		$list = $dbLayer->getGenOlapReport($olapObj);
		$output = "";
		foreach($list as &$olap){
			/* @var $olap Olap */
			$username = $olap->getUsername();
			$cid = $olap->getCid();
			$storeId = $olap->getStoreId();
			$from = $olap->getFrom();
			$to = $olap->getTo();
			$aggregatedCount = $olap->getAggregatedCount();
			$amounts = $olap->getAmounts();
				
			$username = "<td>".$username."</td>";
			$cid = "<td>".$cid."</td>";
			$storeId = "<td>".$storeId."</td>";
			$from = "<td>".$from."</td>";
			$to = "<td>".$to."</td>";
			$aggregatedCount = "<td>".$aggregatedCount."</td>";
			$amounts = "<td>".$amounts."</td>";
				
			$oneRow = "<tr>.$username.$cid.$storeId.$from.$to.$aggregatedCount.$amounts.</tr>";
			$output .= $oneRow;
		}
		echo $output;
		echo "</table>";
	}
	
	public static function getListDetailedOlaps(Olap $olapObj){
		echo "<table border=1><caption>Detailed OLAP</caption>";
		echo "<tr><th>Customer</th>
		<th>Product ID</th>
		<th>Store ID</th>
		<th>From</th>
		<th>To</th>
		<th>Aggregated Count</th>
		<th>Amounts</th></tr>";
		$dbLayer = new DbLayer();
		$list = $dbLayer->getOlapReport($olapObj);
		$output = "";
		foreach($list as &$olap){
			/* @var $olap Olap */
			$username = $olap->getUsername();
			$cid = $olap->getCid();
			$storeId = $olap->getStoreId();
			$from = $olap->getFrom();
			$to = $olap->getTo();
			$aggregatedCount = $olap->getAggregatedCount();
			$amounts = $olap->getAmounts();
			
			$username = "<td>".$username."</td>";
			$cid = "<td>".$cid."</td>";
			$storeId = "<td>".$storeId."</td>";
			$from = "<td>".$from."</td>";
			$to = "<td>".$to."</td>";
			$aggregatedCount = "<td>".$aggregatedCount."</td>";
			$amounts = "<td>".$amounts."</td>";
			
			$oneRow = "<tr>.$username.$cid.$storeId.$from.$to.$aggregatedCount.$amounts.</tr>";
			$output .= $oneRow;
		}
		echo $output;
		echo "</table>";
	}
	
	public static function getListOlaps(Olap $olapObj){
		self::getListDetailedOlaps($olapObj);
		self::getListGenOlaps($olapObj);
	}
	
	public static function getTopNProducts($n,$from,$to,$cateId = null){
		echo "<table border=1><caption>Top {$n} Selling Products </caption>";
		echo "<tr><th>cid</th>
		<th>name</th>
		<th>description</th>
		<th>image</th>
		<th>price</th>
		<th>weight</th>
		<th>dimensions</th>
		<th>stock</th>
		<th>total Sold</th></tr>";
		
		$output = "";
		
		$dbLayer = new DbLayer();
		$list = $dbLayer->getTopNSellings($n, $from, $to, $cateId);
		foreach($list as &$prod){
			$cid = "<td>{$prod->getCid()}</td>";
			$name = "<td>{$prod->getName()}</td>";
			$description = "<td>{$prod->getDescription()}</td>";
			$image = "<td>{$prod->getImage()}</td>";
			$price = "<td>{$prod->getPrice()}</td>";
			$weight = "<td>{$prod->getWeight()}</td>";
			$dimensions = "<td>{$prod->getDimensions()}</td>";
			$stock = "<td>{$prod->getStock()}</td>";
			$totalSold = "<td>{$prod->getTotalSold()}</td>";
			
			$oneRow = "<tr>".$cid.$name.$description.$image.$price.$weight.$dimensions.$stock.$totalSold."</tr>";
			
			$output .= $oneRow;
		}
		echo $output;
		echo "</table>";
	}
}
?>
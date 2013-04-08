<?php
namespace controller;
use model\DbLayer;
use model\Customer;
use model\Product;
use model\Store;
include_once './model/DbLayer.php';
include_once './model/Customer.php';
include_once './model/Product.php';
include_once './model/Store.php';
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
}
?>
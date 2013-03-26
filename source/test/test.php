<?php 
namespace test;
use model\Customer;

use model\DbLayer;

include_once "../model/DbLayer.php";
class TestDb{
	/*
	 * PASS
	 */
	public static function testAddProduct(){
		$dbLayer = new \model\DbLayer();
		
		$cid = '1';
		$name = 'product1';
		$description = 'this is product 1';
		$image = 'image url of product';
		$price = '99';
		$weight = '10';
		$dimensions = '10-10-10';
		$stock = 20;
		
		$prod = new \model\Product($cid, $name, $description, $image, $price,
				 $weight, $dimensions, $stock);
		
		$result = $dbLayer->addProduct($prod);
		
		if($result){
			echo "true";
		}else{
			echo "false";
		}
	}

	/*
	 * PASS
	 */
	public static function testAddCustomer(){
		$dbLayer = new DbLayer();
		$cus = new Customer('tully', 'tully', '', 'Calgary', '', 'tully@ualberta.ca');
		$result = $dbLayer->addCustomer($cus);
		if($result){
			echo "true";
		}else{
			echo "false";
		}
	}

	/*
	 * PASS
	 */
	public static function testAuthenticateCustomer(){
		
		$dbLayer = new DbLayer();
		$username = 'teo';
		$pw = 'teo';
		$result = $dbLayer->authenticateCustomer($username, $pw);
		echo strval($result);
		
		$username = 'hcngo';
		$pw = 'teo';
		$result = $dbLayer->authenticateCustomer($username, $pw);
		echo strval($result);
	
		$username = 'trilai';
		$pw = 'trilai';
		$result = $dbLayer->authenticateCustomer($username, $pw);
		echo strval($result);
	}
	/*
	 * PASS
	 */
	public static function testUpdateStock($productId, $itemsDrawn){
		$dbLayer = new DbLayer();
		echo(strval($dbLayer->updateStock($productId, $itemsDrawn)));
	}
	/*
	 * PASS
	 */
	public static function testMapProductCategory(){
		$dbLayer = new DbLayer();
		echo ($dbLayer->matchProductCategory('c000001', 6));
	}
	/*
	 * PASS
	 */
	public static function testGetCategories(){
		$dbLayer = new DbLayer();
		$list = $dbLayer->getCategoriesList();
		var_dump($list);
	}
	
	/*
	 * PASS
	 */
	public static function testGetProducts($cateId){
		$dbLayer = new DbLayer();
		$list = $dbLayer->getProducts($cateId);
		var_dump($list);
	}

	public static function testSearchProduct($partial){
		$dbLayer = new DbLayer();
		$list = $dbLayer->searchProduct($partial);
		var_dump($list);
	}
}
// \test\TestDb::testAddProduct();
// \test\TestDb::testAddCustomer();
// \test\TestDb::testAuthenticateCustomer();
// \test\TestDb::testUpdateStock('c000001', 5);
// \test\TestDb::testMapProductCategory();
// \test\TestDb::testGetCategories();
// \test\TestDb::testGetProducts(1);
\test\TestDb::testSearchProduct('washer');
?>
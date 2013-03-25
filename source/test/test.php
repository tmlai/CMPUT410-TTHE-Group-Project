<?php 
namespace test;
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
		
// 		assert($result,"can't add this new product");
		
		if($result){
			echo "true";
		}else{
			echo "false";
		}
	}
}
// \test\TestDb::testAddProduct();
?>
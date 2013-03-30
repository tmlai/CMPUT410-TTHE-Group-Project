<?php
namespace test;
use model\OrderProduct;

use model\CustomerOrder;

use model\Store;

use model\Customer;

use model\DbLayer;

include_once "../model/DbLayer.php";
class TestDb {
	/*
	 * PASS
	 */
	public static function testAddProduct() {
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

		if ($result) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/*
	 * PASS
	 */
	public static function testAddCustomer() {
		$dbLayer = new DbLayer();
		$cus = new Customer('tully', 'tully', '', 'Calgary', '',
				'tully@ualberta.ca');
		$result = $dbLayer->addCustomer($cus);
		if ($result) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/*
	 * PASS
	 */
	public static function testAuthenticateCustomer() {

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
	public static function testUpdateStock($productId, $itemsDrawn) {
		$dbLayer = new DbLayer();
		echo (strval($dbLayer->updateStock($productId, $itemsDrawn)));
	}

	/*
	 * PASS
	 */
	public static function testGetStock() {
		$productId = 'c000001';
		$dbLayer = new DbLayer();
		echo $dbLayer->getStock($productId);
		echo "second Product : <br>";
		$productId = 'c00';
		echo $dbLayer->getStock($productId);
	}

	/*
	 * PASS
	 */
	public static function testMapProductCategory() {
		$dbLayer = new DbLayer();
		echo ($dbLayer->matchProductCategory('c000001', 6));
	}
	/*
	 * PASS
	 */
	public static function testGetCategories() {
		$dbLayer = new DbLayer();
		$list = $dbLayer->getCategoriesList();
		var_dump($list);
	}

	/*
	 * PASS
	 */
	public static function testGetProducts($cateId) {
		$dbLayer = new DbLayer();
		$list = $dbLayer->getProducts($cateId);
		var_dump($list);
	}

	/*
	 * PASS
	 */
	public static function testSearchProductByName($partial) {
		$dbLayer = new DbLayer();
		$list = $dbLayer->searchProduct($partial);
		var_dump($list);
	}

	/*
	 * PASS
	 */
	public static function testAddStore() {
		$store = new Store(0, "This is store #3", "store_3",
				"http://cs410.cs.ualberta.ca:41031");
		$dbLayer = new DbLayer();
		$result = $dbLayer->addStore($store);
		if ($result) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/*
	 * PASS
	 */
	public static function testSearchStore() {
		$url = "http://cs410.cs.ualberta.ca:41041";
		$dbLayer = new DbLayer();
		$store = $dbLayer->searchStore($url);
		var_dump($store);

		$url = "http://cs410.cs.ualberta.ca:41051";
		$store = $dbLayer->searchStore($url);
		var_dump($store);
	}

	/*
	 * PASS
	 */
	public static function testGetProductsInStock() {
		$dbLayer = new DbLayer();
		$list = $dbLayer->getProductsInStock();
		echo json_encode($list);
	}

	/*
	 * PASS
	 */
	public static function testGetOneProduct() {
		$dbLayer = new DbLayer();
		$cid = 'c000001';
		echo $dbLayer->getOneProduct($cid);
		echo "second non-exist product <br>";
		$cid = 'c000000';
		echo $dbLayer->getOneProduct($cid);
	}

	/*
	 * PASS
	 */
	public static function testReceiveOrderFromStore() {
		$storeId = 2;
		$cid = 'c000001';

		$dbLayer = new DbLayer();

		$quantity = round(($dbLayer->getStock($cid)) / 2);

		$res1 = $dbLayer->receiveOrderFromStore($storeId, $cid, $quantity);
		echo $res1;
		echo "result from second receiving .... <br>";

		// non-exist product id.
		$cid = 'c00';
		$quantity = 1;
		$res2 = $dbLayer->receiveOrderFromStore($storeId, $cid, $quantity);
		echo $res2;
		echo "result from third receiving ... <br>";
		// order more than stock
		$cid = 'c000002';
		$storeId = 4;
		$quantity = $dbLayer->getStock($cid) + 1;
		$res3 = $dbLayer->receiveOrderFromStore($storeId, $cid, $quantity);
		echo $res3;
	}

	/*
	 * PASS
	 */
	public static function testCheckDeliveryDate() {
		$dbLayer = new DbLayer();

		$orderId = 1;
		echo $dbLayer->checkDeliveryDate($orderId);

		$orderId = 5;
		echo $dbLayer->checkDeliveryDate($orderId);
	}

	/*
	 * PASS
	 */
	public static function testAddOrder() {
		$customerOrder = new CustomerOrder(0, "first order", '', 'hcngo', 0, '');
		$orderProductsArray = array();

		$date = new \DateTime();

		for ($i = 6; $i < 10; $i++) {
			$date->add(new \DateInterval('P1D'));
			$deliveryDate = $date->format('Y-m-d');
			$orderProduct = new OrderProduct(0, 'c00000' . $i, 3, 5, $i,
					$deliveryDate, 0);
			$orderProductsArray[] = $orderProduct;
		}
		$dbLayer = new DbLayer();
		$value = $dbLayer->addOrder($customerOrder, $orderProductsArray);
		if ($value) {
			echo "true";
		} else {
			echo "false";
		}
	}

	/*
	 * PASS
	 */
	public static function testSearchProductByCode() {
		$code = 'c000001';
		$dbLayer = new DbLayer();
		var_dump($dbLayer->searchProductByCode($code));

		$code = 'c000025';
		var_dump($dbLayer->searchProductByCode($code));
	}

	/*
	 * PASS
	 */
	public static function testSearchProductByCategory() {
		$category = 'washer';
		$dbLayer = new DbLayer();
		var_dump($dbLayer->searchProductByCategory($category));

		echo "second search ...<br>";
		$category = 'lap';
		var_dump($dbLayer->searchProductByCategory($category));

		echo "third search ...<br>";
		$category = 'appliance';
		var_dump($dbLayer->searchProductByCategory($category));
	}

	/*
	 * PASS
	 */
	public static function testSearchProductByConstraints() {
		$dbLayer = new DbLayer();

		$cateId = 1;
		$priceRange = array();

		// 		$priceRange[DbLayer::LOWER_BOUND] = 700;
		// 		$priceRange[DbLayer::UPPER_BOUND] = 1000;

		$availRange = array();
		// 		$availRange[DbLayer::LOWER_BOUND] = 20;
		// 		$availRange[DbLayer::UPPER_BOUND] = 25;

		$weightRange = array();
		// 		$weightRange[DbLayer::LOWER_BOUND] = 15;
		// 		$weightRange[DbLayer::UPPER_BOUND] = 20;

		$list = $dbLayer
				->searchProductByConstraints($cateId, $priceRange, $availRange,
						$weightRange);
		var_dump($list);
	}

	/*
	 * PASS
	 */
	public static function testGetCustomersOrders(){
		$username = 'hcngo';
		$outstanding = true;
		$dbLayer = new DbLayer();
		
		$list = $dbLayer->getCustomersOrders($username, $outstanding);
		var_dump($list);
	}
	
	/*
	 * PASS
	 */
	public static function testGetListProductsInOrder(){
		$orderId = 6;
		$dbLayer = new DbLayer();
		$list = $dbLayer->getListProductsInOrder($orderId);
		
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
// \test\TestDb::testSearchProductByName('beam');
// \test\TestDb::testAddStore();
// \test\TestDb::testSearchStore();
// \test\TestDb::testGetProductsInStock();
// \test\TestDb::testGetOneProduct();
// \test\TestDb::testGetStock();
// \test\TestDb::testReceiveOrderFromStore();
// \test\TestDb::testCheckDeliveryDate();
// \test\TestDb::testAddOrder();
// \test\TestDb::testSearchProductByCode();
// \test\TestDb::testSearchProductByCategory();
// \test\TestDb::testSearchProductByConstraints();
// \test\TestDb::testGetCustomersOrders();
// \test\TestDb::testGetListProductsInOrder();
?>
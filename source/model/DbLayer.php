<?php
namespace model;
include_once "DbInterface.php";
class DbLayer implements DbInterface {

	const HOST_NAME = 'localhost';
	const DB_NAME = 'cmput410';
	const USER_NAME = 'root';
	const PASSWORD = 'admin04';

	private static function getPdo() {
		$dsn = 'mysql:host=' . self::HOST_NAME . ';dbname=' . self::DB_NAME;
		try{
		$dbh = new PDO($dsn, self::USER_NAME, self::PASSWORD,
				array(PDO::ATTR_PERSISTENT => true));
		return $dbh;
		}catch(Exception $exception){
			die("Uable to connect: ".$exception->getMessage());
		}
	}
	// Customer + admin section
	/*
	 * Add the customer to the database
	 * Parameters: $customer: the customer object to be added
	 * Return type: true if successfully, false if fails
	 */
	public function addCustomer(Customer $customer) {

	}

	/*
	 *
	 */
	public function deleteCustomer(Customer $customer) {

	}

	public function updateCustomer(Customer $customer) {

	}

	// Products section
	public function addProduct(Product $prod) {
		
		$pdo = self::getPdo();
		
// 		/* Begin a transaction, turning off autocommit */
// 		$pdo->beginTransaction();
		
		$preState = "INSERT INTO Products values(:cid, :name, :description, 
		:image, :price, :weight, :dimensions, :stock)";
		
		$stmt = $pdo->prepare($preState);
		
		$array = array(':cid' => $prod->getCid(), ':name' => $prod->getName(),
				':desciption' => $prod->getDescription(), ':image' => $prod->getImage(),
				':price' => $prod->getPrice(), ':weight' => $prod->getWeight(), 
				':dimensions' => $prod->getDimensions(), ':stock' => $prod->getStock());
		
		$result = $stmt->execute($array);
		
		$status = ($result == true && $stmt->rowCount() > 0);
		
// 		if($status == true){
// 			$pdo->commit();
// 		}else{
// 			$pdo->rollback();
// 		}
		
		$pdo = null;
		
		return $status;
		
	}
	//
	// public function updateProduct(Product $prod);
	//
	// public function deleteProduct(Product $prod);

	public function updateStock($productId, $itemsDrawn) {

	}
	/*
	 * Return a list of categories
	 * Return type: array of category objects
	 */
	public function getCategoriesList() {

	}

	/*
	 * Return a list of products belonging to some category
	 * Parameters: $categoryId 	the id of the category
	 * Return type: array of product objects
	 */
	public function getProducts($categoryId) {

	}

	/*
	 * Given the search name for the product, return the product object
	 * Parameters: $initialName	the name for the product to be searched
	 * Return type:	the product object returned or null if can't find any
	 * matching product
	 */
	public function searchProduct($initialName) {

	}

	// -------------------------------------------------------------------------

	public function addStore(Store $store) {

	}

	/*
	 * Get the store Object given the url of the store.
	 */
	public function searchStore($url) {

	}

	/*
	 * order products from other stores
	 * Parameters:	$productId:	the product to be ordered from other stores
	 * 				$quantity:	number of products ordered
	 * 				$url:		url of the store
	 * Return type:	true if the order is placed successfully, false otherwise.
	 */
	public function orderOthersStore($productId, $quantity, $url) {

	}

	/*
	 * Check if some store(including our store) has enough stock to accomodate the
	 * requested number
	 * of products
	 * Parameters:	$productId:	the product to be ordered from other stores
	 * 				$quantity:	number of products requested
	 * 				$url:		url of the store. url = '' if the store is ours.
	 * Return type:	true if the there is enough stock. False otherwise.
	 */
	public function checkIfCanOrder($productId, $quantity, $url) {

	}

	/*
	 * Add just one product ordered to the database.
	 * Parameters:	$pdo:			the pdo connection
	 * 				$oneItemArray:	the array containing info for the item ordered
	 * 				Specifically, must be in this form:
	 * 				["orderId" => orderId, "cid" => cid, "storeId" => storeId, "quantity" =>
	 * quantity];
	 * Return type:	true if insert successfully, false otherwise.
	 * NOTE: 		pass the pdo connection so that this database action can be rollbacked
	 * 				since this action is a small step in a transaction.
	 */
	public function orderOneProduct($pdo, $oneItemArray) {

	}

	// order section
	/*
	 * Add a list of products ordered to the database.
	 * Parameters:	$itemsArray:	the array containing the list of associative
	 * 				arrays, each corresponding to a product ordered
	 * 				Specifically, each sub array must be in this form
	 * 				["orderId" => orderId, "cid" => cid, "storeId" => storeId, "quantity" =>
	 * quantity];
	 * Return type:	the list of positions of products that CANNOT be added!
	 *
	 */
	public function addOrder($itemsArray) {

	}

}

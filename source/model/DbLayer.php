<?php
namespace model;
include_once "DbInterface.php";
class DbLayer implements DbInterface {

	const HOST_NAME = 'localhost';
	const DB_NAME = 'cmput410';
	const USER_NAME = 'root';
	const PASSWORD = 'admin04';

	public static function getPdo() {
		$dsn = 'mysql:dbname=' . self::DB_NAME . ';host=' . self::HOST_NAME
				. ';charset=utf8';
		try {
			$dbh = new \PDO($dsn, self::USER_NAME, self::PASSWORD);
			return $dbh;
		} catch (Exception $exception) {
			die("Uable to connect: " . $exception->getMessage());
		}
	}
	// Customer + admin section
	/*
	 * Add the customer to the database
	 * Parameters: $customer: the customer object to be added
	 * Return type: true if successfully, false if fails
	 */
	public function addCustomer(Customer $customer) {
		$pdo = self::getPdo();

		$preState = "INSERT INTO Customers values(?,?,?,?,?,?)";

		$stmt = $pdo->prepare($preState);

		$array = array($customer->getUsername(), $customer->getPassword(),
				$customer->getAddress(), $customer->getCity(),
				$customer->getPostalCode(), $customer->getEmail());

		$result = $stmt->execute($array);

		$status = ($result == true && $stmt->rowCount() > 0);

		$pdo = null;

		return $status;

	}

	/*
	 *
	 */
	public function deleteCustomer(Customer $customer) {

	}

	public function updateCustomer(Customer $customer) {

	}

	public function authenticateCustomer($username, $password) {
		$status = -1;

		$pdo = self::getPdo();

		$preState = "SELECT password FROM Customers WHERE username=?";

		$stmt = $pdo->prepare($preState);

		$stmt->bindParam(1, $username);

		$stmt->execute();

		// 		while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
		// 			if($row['password'] == $password){
		// 				$exist = true;
		// 				break;
		// 			}
		// 		}

		$list = $stmt->fetchAll();
		if (count($list) == 0) {
			// no user with the indicated username exists
			$status = 0;
		} else {
			for ($i = 0; $i < count($list); $i++) {
				if (strcmp($list[$i][0], $password) == 0) {
					$status = 2;
					break;
				}
			}
			if ($status == -1) {
				$status = 1;
			}
		}
		$pdo = null;

		return $status;
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
				':description' => $prod->getDescription(),
				':image' => $prod->getImage(), ':price' => $prod->getPrice(),
				':weight' => $prod->getWeight(),
				':dimensions' => $prod->getDimensions(),
				':stock' => $prod->getStock());

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

	public function matchProductCategory($cid, $cateId) {
		$pdo = self::getPdo();

		$preState = "INSERT INTO ProductsMapCategories values(?,?)";

		$stmt = $pdo->prepare($preState);

		$array = array($cid, $cateId);

		$result = $stmt->execute($array);

		$value = ($result == true && $stmt->rowCount() > 0);

		$pdo = null;

		return $value;
	}

	public function updateStock($productId, $itemsDrawn) {
		$pdo = self::getPdo();

		$preState = "UPDATE Products SET stock = stock - {$itemsDrawn} WHERE cid = ?";

		$stmt = $pdo->prepare($preState);

		$stmt->bindParam(1, $productId);

		$result = $stmt->execute();

		$value = ($result == true && $stmt->rowCount() > 0);

		$pdo = null;

		return $value;
	}
	/*
	 * Return a list of categories
	 * Return type: array of category objects
	 */
	public function getCategoriesList() {

		$pdo = self::getPdo();

		$preState = "SELECT * from Categories";

		$stmt = $pdo->prepare($preState);

		$stmt->execute();

		$list = array();

		$tempList = $stmt->fetchAll();

		for ($i = 0; $i < count($tempList); $i++) {
			$cate = $tempList[$i];
			$obj = new Category($cate[0], $cate[1], $cate[2]);
			$list[] = $obj;
		}

		$pdo = null;

// 		function compare($c1, $c2){
// 			return strcasecmp($c1->getName(), $c2->getName());
// 		}
		
// 		$sort = usort($list, compare);
// 		if ($sort) {
// 			echo "true";
// 		} else {
// 			echo "false";
// 		}

		return $list;
	}

	/*
	 * Return a list of products belonging to some category
	 * Parameters: $categoryId 	the id of the category
	 * Return type: array of product objects
	 */
	public function getProducts($categoryId) {
		$pdo = self::getPdo();
		
		$preState = "SELECT * FROM Products p, ProductsMapCategories pc 
		WHERE p.cid = pc.cid AND pc.cateId = {$categoryId}";
		
		$stmt = $pdo->prepare($preState);
		
		$stmt->execute();
		
		$tempProds = $stmt->fetchAll();
		
		$pdo = null;
		
		$prodArray = array();
		
		foreach ($tempProds as &$row){
			$prod = new Product($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
			$prodArray[] = $prod;
		}
		
		return $prodArray;
	}

	/*
	 * Given the search name for the product, return the list of product objects
	 * Parameters: $partial	the name for the product to be searched
	 * Return type:	the list of product objects returned
	 */
	public function searchProduct($partial) {
		$partial = strtolower($partial);
		
		$first = substr($partial, 0,1);
		$capFirst = strtoupper($first);
		$rest = substr($partial,1);
		
		$pdo = self::getPdo();
		
		$preState = "SELECT * from Products WHERE name RLIKE '*[{$first}{$capFirst}]{$rest}' ";
		echo $preState;
		
		$stmt = $pdo->prepare($preState);
		
		$stmt->execute();
		
		$temp = $stmt->fetchAll();
		
		$pdo = null;
		
		$list = array();
		
		foreach($temp as &$row){
			$prod = new Product($row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6], $row[7]);
			$list[] = $prod;
		}
		
		return $list;
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
?>
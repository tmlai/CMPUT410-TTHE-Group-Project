<?php
namespace model;
use model\Product;

include_once "DbInterface.php";
class DbLayer implements DbInterface {

	const HOST_NAME = 'localhost';
	const DB_NAME = 'cmput410';
	const USER_NAME = 'root';
	const PASSWORD = 'admin04';

	const LOWER_BOUND = 'lowerBound';
	const UPPER_BOUND = 'upperBound';

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
	 * Return a list of customer objects
	 */
	public function getListCustomers() {
		$pdo = self::getPdo();
		$statement = "SELECT * FROM Customers";
		$stmt = $pdo->prepare($statement);
		$stmt->execute();

		$list = array();
		$temp = $stmt->fetchAll();
		foreach ($temp as &$row) {
			$cus = new Customer($row[0], $row[1], $row[2], $row[3], $row[4],
					$row[5]);
			$list[] = $cus;
		}
		$pdo = null;
		return $list;
	}

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
	 * Add the user to the admin table in the database (temporary?)
	 * Parameters: $customer: the customer object to be added
	 *             $password: the admin password
	 * Return type: true if successfully, false if fails
	 */
		public function addAdmin($username, $password) {
		$pdo = self::getPdo();

		$preState = "INSERT INTO Admins values(?,?)";

		$stmt = $pdo->prepare($preState);

		$array = array($username, $password);

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

	public function updateStock(&$pdo, $productId, $itemsDrawn) {

		$preState = "UPDATE Products SET stock = stock - {$itemsDrawn} 
		WHERE cid = ? AND stock >= {$itemsDrawn}";

		$stmt = $pdo->prepare($preState);

		$stmt->bindParam(1, $productId);

		$result = $stmt->execute();

		$value = ($result == true && $stmt->rowCount() > 0);

		return $value;
	}

	/*
	 * Allow user to rate the product
	 */
	public function rateProduct(UserRatingProduct $urp) {
		$pdo = self::getPdo();
		$statement = "SELECT * FROM UsersRatingProducts WHERE username = ? AND cid = ? ";
		$array = array($urp->getUsername(), $urp->getCid());
		$stmt = $pdo->prepare($statement);
		$stmt->execute($array);

		$temp = $stmt->fetchAll();
		if (count($temp) == 0) {
			// No rating exists
			$statement = "INSERT INTO UsersRatingProducts values(?,?,?)";
			$array = array($urp->getUsername(), $urp->getCid(),
					$urp->getRating());
			$stmt = $pdo->prepare($statement);
			$val = $stmt->execute($array);
			$val = ($val == true && $stmt->rowCount() > 0);
			$pdo = null;
			return $val;
		} else {
			// Overwrite rating
			$statement = "UPDATE UsersRatingProducts SET rating = ? WHERE username = ? AND cid = ?";
			$array = array($urp->getRating(), $urp->getUsername(),
					$urp->getCid());
			$stmt = $pdo->prepare($statement);
			$val = $stmt->execute($array);
			$val = ($val == true && $stmt->rowCount() > 0);
			$pdo = null;
			return $val;
		}

	}

	/*
	 * Get the stock of some product.
	 */
	public function getStock($productId) {
		$pdo = self::getPdo();
		$statement = "SELECT stock FROM Products WHERE cid = ?";
		$stmt = $pdo->prepare($statement);
		$stmt->bindParam(1, $productId);

		$stmt->execute();

		$temp = $stmt->fetchAll();
		$stock = 0;
		foreach ($temp as &$row) {
			$stock = $row[0];
		}
		$pdo = null;
		return $stock;
	}

	/*
	 * Get the price of the product given its product ID.
	 */
	public function getPrice($productId) {
		$pdo = self::getPdo();
		$statement = "SELECT price FROM Products WHERE cid = ?";
		$stmt = $pdo->prepare($statement);
		$stmt->bindParam(1, $productId);

		$stmt->execute();

		$temp = $stmt->fetchAll();
		$price = 0;
		foreach ($temp as &$row) {
			$price = $row[0];
		}
		$pdo = null;
		return $price;

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
	public function getProducts($categoryId = null) {
		$pdo = self::getPdo();

		if (isset($categoryId)) {
			$preState = "SELECT * FROM Products p, ProductsMapCategories pc 
		WHERE p.cid = pc.cid AND pc.cateId = {$categoryId}";
		} else {
			$preState = "SELECT * FROM Products";
		}

		$stmt = $pdo->prepare($preState);

		$stmt->execute();

		$tempProds = $stmt->fetchAll();

		$pdo = null;

		$prodArray = array();

		foreach ($tempProds as &$row) {
			$prod = new Product($row[0], $row[1], $row[2], $row[3], $row[4],
					$row[5], $row[6], $row[7]);
			$prodArray[] = $prod;
		}

		return $prodArray;
	}

	// -------------------------------------------------------------------------
	
	/*
	 * Get the list of external stores which we do business with
	*/
	public function getListExternalStores(){
		$pdo = self::getPdo();
		$statement = "SELECT * FROM Stores WHERE storeId <> 1";
		$stmt = $pdo->prepare($statement);
		$stmt->execute();
		
		$list = array();
		$temp = $stmt->fetchAll();
		foreach($temp as &$row){
			$store = new Store($row[0], $row[1], $row[2], $row[3]);
			$list[] = $store;
		}
		$pdo = null;
		return $list;
	}

	public function addStore(Store $store) {
		$pdo = self::getPdo();
		$statement = "INSERT INTO Stores(description,name,url) values(?,?,?)";
		$stmt = $pdo->prepare($statement);
		$array = array($store->getDescription(), $store->getName(),
				$store->getUrl());
		$result = $stmt->execute($array);
		$value = ($result == true && $stmt->rowCount() > 0);
		$pdo = null;
		return $value;
	}

	/*
	 * Get the store Object given the url of the store.
	 * Return the store object in case of matching. Null otherwise.
	 */
	public function searchStore($url) {
		$pdo = self::getPdo();
		$statement = "SELECT * FROM Stores WHERE url='{$url}'";

		$stmt = $pdo->prepare($statement);
		$stmt->execute();

		$temp = $stmt->fetchAll();
		$store = null;
		foreach ($temp as &$row) {
			$store = new Store($row[0], $row[1], $row[2], $row[3]);
		}
		$pdo = null;
		return $store;
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
	 * Add just one product ordered to the database.
	 * Parameters:	$pdo:			the pdo connection
	 * 				$orderProduct	OrderProduct object to be inserted.
	 * Return type:	true if insert successfully, false otherwise.
	 * NOTE: 		pass the pdo connection so that this database action can be rollbacked
	 * 				since this action is a small step in a transaction.
	 */
	public function orderOneProduct(\PDO $pdo, OrderProduct $orderProduct) {
		$statement = "INSERT INTO OrdersProducts values(?,?,?,?,?,?,?)";
		$stmt = $pdo->prepare($statement);

		$array = array($orderProduct->getOrderId(), $orderProduct->getCid(),
				$orderProduct->getStoreId(), $orderProduct->getQuantity(),
				$orderProduct->getAuxiliaryOrderId(),
				$orderProduct->getDeliveryDate(), $orderProduct->getAmount());
		$value = $stmt->execute($array);
		return $value;
	}

	// order section
	/*
	 * Add a list of products ordered to the database.
	 * Parameters:	$customerOrder	CustomerOrder object representing a new tuple
	 * 								to be inserted into CustomersOrders table.
	 * 				$orderProductsArray	array of OrderProduct objects to be inserted
	 * 								into OrdersProducts table.
	 * Return type:	true if successfully adding all tuples into tables. False
	 * otherwise.
	 */
	public function addOrder(CustomerOrder $customerOrder,
			array $orderProductsArray) {
		$pdo = self::getPdo();
		$pdo->beginTransaction();

		$statement = "INSERT INTO CustomersOrders(description,orderDate,username,payment,deliveryDate)
		 values(?,?,?,?,?)";
		$stmt = $pdo->prepare($statement);

		$date = new \DateTime();
		$orderDate = $date->format('Y-m-d H:i:s');

		$date->add(new \DateInterval('P2D'));
		$deliveryDate = $date->format('Y-m-d');

		$array = array($customerOrder->getDescription(), $orderDate,
				$customerOrder->getUsername(), $customerOrder->getPayment(),
				$deliveryDate);

		$value = $stmt->execute($array);
		$value = ($value == true && $stmt->rowCount() > 0);
		if ($value == false) {
			$pdo->rollBack();
			// TODO
			echo "CustomersOrders insert";
			$pdo = null;
			return false;
		}

		$orderId = $pdo->lastInsertId();

		/* @var $row OrderProduct */
		$latestDate = $date;
		$format = 'Y-m-d';
		foreach ($orderProductsArray as &$row) {
			$row->setOrderId($orderId);

			$deliveryDate = $row->getDeliveryDate();
			$auxiliaryOrderId = $row->getAuxiliaryOrderId();

			if ($deliveryDate != '' && $auxiliaryOrderId != 0) {
				$dateTemp = \DateTime::createFromFormat($format,
						$row->getDeliveryDate());
				if ($latestDate < $dateTemp) {
					$latestDate = $dateTemp;
				}
			}
		}

		// 		Insert each tuple into OrderProducts table.
		$dbLayer = new DbLayer();
		foreach ($orderProductsArray as &$op) {
			$value = $dbLayer->orderOneProduct($pdo, $op);
			if ($value == false) {
				$pdo->rollBack();
				// TODO
				echo "OrderProduct insert";
				$pdo = null;
				return false;
			}
		}

		// 		Decrease the stock of each product
		/* @var $sc OrderProduct */
		foreach ($orderProductsArray as &$sc) {
			// Assume our store has store id of 1.
			if ($sc->getStoreId() == 1) {
				$value = $dbLayer
						->updateStock($pdo, $sc->getCid(), $sc->getQuantity());

				if ($value == false) {
					$pdo->rollBack();
					// TODO
					echo "Update Stock";
					$pdo = null;
					return false;
				}
			}
		}

		// 		Update the deliveryDate to be the latest delivery date from another
		// 		store if the delivery date has been changed.
		if ($latestDate != $date) {
			$statement = "UPDATE CustomersOrders SET deliveryDate = ? WHERE orderId = ?";
			$stmt = $pdo->prepare($statement);
			$array = array($latestDate->format('Y-m-d'), $orderId);
			$value = $stmt->execute($array);
			$value = ($value == true && $stmt->rowCount() > 0);
			if ($value == false) {
				$pdo->rollBack();
				// TODO
				echo "Update CustomersOrders";
				$pdo = null;
				return false;
			}
		}

		$pdo->commit();
		$pdo = null;
		return true;
	}

	// 	------------------------------------------------------------------------

	// 	WEB SERVICES SECTION
	/*
	 * Get the list of product IDs of products still in stock
	 * Return the associative array: array['products'] of which element is
	 * another associative array in the following form: array['id']=id
	 */
	public function getProductsInStock() {
		$pdo = self::getPdo();
		$statement = "SELECT cid FROM Products WHERE stock > 0";
		$stmt = $pdo->prepare($statement);
		$stmt->execute();

		$temp = $stmt->fetchAll();
		$pdo = null;
		$list = array();
		foreach ($temp as &$row) {
			$item = array();
			$item['id'] = $row[0];
			$list[] = $item;
		}
		$retArray = array();
		$retArray['products'] = $list;
		return $retArray;
	}

	/*
	 * Get the whole description about some product given its product ID.
	 * Return the product as JSON(including category) in case of matching. Null otherwise.
	 */
	public function getOneProduct($cid) {
		$pdo = self::getPdo();
		$statement = "SELECT * FROM Products WHERE cid = ?";

		$stmt = $pdo->prepare($statement);
		$stmt->bindParam(1, $cid);

		$stmt->execute();

		$temp = $stmt->fetchAll();

		$statement = "SELECT name, pc.cateId 
		FROM Categories c, ProductsMapCategories pc 
		WHERE c.cateId = pc.cateId AND pc.cid = ?";

		$stmt = $pdo->prepare($statement);
		$stmt->bindParam(1, $cid);
		$stmt->execute();
		$cateList = $stmt->fetchAll();

		$statement = "SELECT rating FROM ProductsRating WHERE cid = ?";
		$stmt = $pdo->prepare($statement);
		$stmt->bindParam(1, $cid);
		$stmt->execute();
		$ratingList = $stmt->fetchAll();

		$prodJson = array();
		if (count($temp) > 0 && count($cateList) > 0) {
			$prodJson['id'] = $temp[0][0];
			$prodJson['name'] = $temp[0][1];
			$prodJson['desc'] = $temp[0][2];
			$prodJson['img'] = $temp[0][3];
			$prodJson['price'] = $temp[0][4];
			$prodJson['weight'] = $temp[0][5] . "kg";
			$prodJson['dim'] = $temp[0][6];
			$prodJson['quantity'] = $temp[0][7];
			$prodJson['category'] = $cateList[0][0];
			$prodJson['cateId'] = $cateList[0][1];
			$prodJson['rating'] = $ratingList[0][0];
		}
		$pdo = null;
		return json_encode($prodJson);
	}

	/*
	 * Take the order from another store. Based on the current protocol,
	 * Each order can involve with one product only.
	 * Parameters:	$storeId	the store id of the store making order
	 * 				$cid		the product id of the product requested.
	 * 				$quantity	the quantity demanded.
	 * Return type:	JSON string in the following form:
	 * 				{"order_id":"order id", "delivery_date":"some date"}
	 * ASSUMPTION:	if the quantity demanded is more than the stock, reject the
	 * 				order and return an empty JSON string.
	 * 				if $quantity <= 0, reject the order.
	 */
	public function receiveOrderFromStore($storeId, $cid, $quantity) {
		$result = array();
		if ($quantity <= 0) {
			return json_encode($result);
		}

		$dbLayer = new DbLayer();
		$stock = $dbLayer->getStock($cid);
		if ($quantity > $stock) {
			return json_encode($result);
		}
		$pdo = self::getPdo();
		$pdo->beginTransaction();

		$date = new \DateTime();
		$orderDate = $date->format('Y-m-d H:i:s');

		$date->add(new \DateInterval('P2D'));
		$deliveryDate = $date->format('Y-m-d');

		$statement = "INSERT INTO StoresOrders(description,orderDate,storeId,payment,deliveryDate)
		values(?,?,?,?,?)";
		$stmt = $pdo->prepare($statement);

		$array = array("", $orderDate, $storeId, 0, $deliveryDate);
		$value = $stmt->execute($array);
		$value = ($value == true && $stmt->rowCount() > 0);
		if ($value == false) {
			$pdo->rollBack();
			$pdo = null;
			return json_encode($result);
		}

		$orderId = $pdo->lastInsertId();
		$statement = "INSERT INTO StoresOrdersProducts values(?,?,?,?)";
		$stmt = $pdo->prepare($statement);

		$array = array($orderId, $cid, $quantity,
				$dbLayer->getPrice($cid) * $quantity);
		$value = $stmt->execute($array);
		$value = ($value == true && $stmt->rowCount() > 0);
		if ($value == false) {
			$pdo->rollBack();
			$pdo = null;
			return json_encode($result);
		}

		$value = $dbLayer->updateStock($pdo, $cid, $quantity);
		if ($value == false) {
			$pdo->rollBack();
			$pdo = null;
			return json_encode($result);
		}

		// The transaction is executed successfully!
		$pdo->commit();
		$pdo = null;
		$result['order_id'] = $orderId;
		$result['delivery_date'] = $deliveryDate;
		return json_encode($result);
	}

	/*
	 * Given the order id, check the delivery date to see if there is a delay
	 * in delivery.
	 * RETURN: JSON in the following format: {"delivery_date":"some date"}.
	 * If $orderId is invalid, return an empty JSON.
	 */
	public function checkDeliveryDate($orderId) {
		$pdo = self::getPdo();
		$statement = "SELECT deliveryDate FROM StoresOrders WHERE orderId = ? ";
		$stmt = $pdo->prepare($statement);
		$stmt->bindParam(1, $orderId);

		$stmt->execute();
		$temp = $stmt->fetchAll();
		$result = array();
		foreach ($temp as &$row) {
			$result['delivery_date'] = $row[0];
		}
		$pdo = null;
		return json_encode($result);
	}

	/*
	 * Given the search name for the product, return the list of product objects
	 * Parameters: $partial	the name for the product to be searched
	 * Return type:	the list of product objects returned
	 * @param string $partial
	 * @return array 
	 */
	public function searchProductByName($partial) {
		$partial = strtolower($partial);

		$first = substr($partial, 0, 1);
		$capFirst = strtoupper($first);
		$rest = substr($partial, 1);

		$pdo = self::getPdo();

		$preState = "SELECT * from Products WHERE name REGEXP '[{$first}{$capFirst}]{$rest}' ";

		$stmt = $pdo->prepare($preState);

		$stmt->execute();

		$temp = $stmt->fetchAll();

		$pdo = null;

		$list = array();

		foreach ($temp as &$row) {
			$prod = new Product($row[0], $row[1], $row[2], $row[3], $row[4],
					$row[5], $row[6], $row[7]);
			$list[] = $prod;
		}

		return $list;
	}

	/*
	 * @param string $code
	 * @return array
	 * Given the $code, product id, of the product, return
	 * a list of products having this code. For compatibility with other
	 * search methods, an array is returned. In fact, this array should contain
	 * at most one product only.
	 */
	public function searchProductByCode($code) {
		$pdo = self::getPdo();
		$statement = "SELECT * FROM Products WHERE cid = ?";
		$stmt = $pdo->prepare($statement);

		$array = array($code);
		$stmt->execute($array);

		$temp = $stmt->fetchAll();
		$list = array();
		foreach ($temp as &$row) {
			$product = new Product($row[0], $row[1], $row[2], $row[3], $row[4],
					$row[5], $row[6], $row[7]);
			$list[] = $product;
		}
		$pdo = null;
		return $list;
	}

	/*
	 * @param string $category
	 * @return array
	 * Given the $category, name of category, of the product, return
	 * list of category IDs.
	 */
	public function searchProductByCategory($category) {
		$category = strtolower($category);

		$first = substr($category, 0, 1);
		$capFirst = strtoupper($first);
		$rest = substr($category, 1);

		$pdo = self::getPdo();

		$preState = "SELECT cateId FROM Categories WHERE name REGEXP '[{$first}{$capFirst}]{$rest}' ";

		$stmt = $pdo->prepare($preState);

		$stmt->execute();

		$temp = $stmt->fetchAll();
		$list = array();
		foreach ($temp as &$row) {
			$list[] = $row[0];
		}
		$pdo = null;
		return $list;
	}

	/*
	 * @param	$cateId			category Id
	 * @param	$priceRange		the price range {lowerBound, upperBound}.
	 * 							null to indicate no constraint on lower/upper.
	 * @param	$availRange		the availability range {lowerBound, upperBound}
	 * @param	$weightRange	the weight Range {lowerBound, upperBound}
	 */
	public function searchProductByConstraints($cateId, $priceRange,
			$availRange, $weightRange) {
		$pdo = self::getPdo();

		$statement = "SELECT * FROM Products p, ProductsMapCategories pmc WHERE p.cid = pmc.cid AND pmc.cateId = ? ";

		$lowerBound = $priceRange[self::LOWER_BOUND];
		if (isset($lowerBound)) {
			$statement .= " AND p.price >= {$lowerBound}";
		}

		$upperBound = $priceRange[self::UPPER_BOUND];
		if (isset($upperBound)) {
			$statement .= " AND p.price <= {$upperBound} ";
		}

		$lowerBound = $availRange[self::LOWER_BOUND];
		if (isset($lowerBound)) {
			$statement .= " AND p.stock >= {$lowerBound} ";
		}

		$upperBound = $availRange[self::UPPER_BOUND];
		if (isset($upperBound)) {
			$statement .= " AND p.stock <= {$upperBound} ";
		}

		$lowerBound = $weightRange[self::LOWER_BOUND];
		if (isset($lowerBound)) {
			$statement .= " AND p.weight >= {$lowerBound} ";
		}

		$upperBound = $weightRange[self::UPPER_BOUND];
		if (isset($upperBound)) {
			$statement .= " AND p.weight <= {$upperBound} ";
		}

		$stmt = $pdo->prepare($statement);
		$array = array($cateId);

		$stmt->execute($array);
		$temp = $stmt->fetchAll();
		$list = array();

		foreach ($temp as &$row) {
			$product = new Product($row[0], $row[1], $row[2], $row[3], $row[4],
					$row[5], $row[6], $row[7]);
			$list[] = $product;
		}

		$pdo = null;
		return $list;
	}

	// 	-----------------------------------------------------------------------
	// 	Outstanding orders section
	/*
	 * Given the username of the user return a list of CustomerOrder objects
	 * corresponding to orders. If $outStanding is indicated(true), only outstanding
	 * orders - ones of which deliveryDate has not passed yet - are returned.
	 */
	public function getCustomersOrders($username, $outstanding) {
		$pdo = self::getPdo();
		if ($outstanding) {
			$date = new \DateTime();
			$date = $date->format('Y-m-d');

			$statement = "SELECT * FROM OutstandingOrders WHERE username = ? AND deliveryDate >= ?";
			$stmt = $pdo->prepare($statement);

			$array = array($username, $date);
			$stmt->execute($array);

		} else {
			$statement = "SELECT * FROM OutstandingOrders WHERE username = ?";
			$stmt = $pdo->prepare($statement);

			$array = array($username);
			$stmt->execute($array);
		}
		$temp = $stmt->fetchAll();
		$list = array();
		foreach ($temp as &$row) {
			$cusOrd = new CustomerOrder($row[0], $row[1], $row[2], $row[3],
					$row[4], $row[5]);
			$cusOrd->setOrderCost($row[6]);
			$list[] = $cusOrd;
		}

		$pdo = null;
		return $list;
	}

	/*
	 * Given the order ID, retrieve the list of Products belonging to this
	 * order.
	 */
	public function getListProductsInOrder($orderId) {
		$pdo = self::getPdo();
		$statement = "SELECT * FROM OrdersProducts WHERE orderId = ?";

		$stmt = $pdo->prepare($statement);
		$array = array($orderId);

		$stmt->execute($array);
		$temp = $stmt->fetchAll();

		$list = array();
		foreach ($temp as &$row) {
			$orPro = new OrderProduct($row[0], $row[1], $row[2], $row[3],
					$row[4], $row[5], $row[6]);
			$list[] = $orPro;
		}
		$pdo = null;
		return $list;
	}

	/*
	 * Given the $olapObj which amounts to search query, return a list of
	 * Olap objects satisfying the constraints.
	 * More specifically,
	 * $username of $olapObj = '' -> each username,
	 * $username of $olapObj = null -> aggregate on all usernames,
	 * $username of $olapObj = specific username -> specific username.
	 *
	 * $storeId of $olapObj = 0 -> each store,
	 * $storeId of $olapObj = null -> aggregate on all stores,
	 * $storeId of $olapObj = specific store id -> specific store.
	 *
	 * $cid of $olapObj = '' -> each product,
	 * $cid of $olapObj = null -> aggregate on all products,
	 * $cid of $olapObj = specific cid -> specific cid.
	 *
	 * $from and $to of $olapObj = '' -> each orderDate,
	 * $from = null and $to = null -> aggregate on all products,
	 * $from = specific and $to = specific -> a range.
	 */
	public function getOlapReport(Olap $olapObj) {
		$pdo = self::getPdo();

		$statement = "SELECT * FROM OlapReport WHERE ";

		$username = $olapObj->getUsername();
		if (isset($username) == false) {
			$statement .= " username is NULL ";

		} elseif ($username == '') {
			$statement .= " username is not NULL ";
		} else {
			$statement .= " username = '{$username}' ";
		}

		$cid = $olapObj->getCid();
		if (isset($cid) == false) {
			$statement .= " AND cid is NULL ";
		} elseif ($cid == '') {
			$statement .= " AND cid is not NULL ";
		} else {
			$statement .= " AND cid = '{$cid}' ";
		}

		$storeId = $olapObj->getStoreId();
		if (isset($storeId) == false) {
			$statement .= " AND storeId is NULL ";
		} elseif ($storeId == 0 || $storeId == '') {
			$statement .= " AND storeId is not NULL ";
		} else {
			$statement .= " AND storeId = {$storeId} ";
		}

		$from = $olapObj->getFrom();
		$to = $olapObj->getTo();
		if (isset($from) == false && isset($to) == false) {
			$statement .= " AND orderDate is NULL ";
		} elseif ($from == '' && $to == '') {
		} else {
			$statement .= " AND orderDate >= '{$from}' ";
			$statement .= " AND orderDate <= '{$to}' ";
		}

		$stmt = $pdo->prepare($statement);
		$stmt->execute();

		$temp = $stmt->fetchAll();
		$list = array();
		foreach ($temp as &$row) {
			$olap = new Olap($row[0], $row[1], $row[2], $row[3], $row[3],
					$row[4], $row[5]);
			$list[] = $olap;
		}

		$pdo = null;
		return $list;
	}
	
	public function getGenOlapReport(Olap $olapObj) {
		$pdo = self::getPdo();
	
		$statement = "SELECT username, cid, storeId, SUM(aggregatedCount) as aggregatedCount, 
		SUM(amounts) as amounts
		 FROM OlapReport WHERE ";
	
		$username = $olapObj->getUsername();
		if (isset($username) == false) {
			$statement .= " username is NULL ";
	
		} elseif ($username == '') {
			$statement .= " username is not NULL ";
		} else {
			$statement .= " username = '{$username}' ";
		}
	
		$cid = $olapObj->getCid();
		if (isset($cid) == false) {
			$statement .= " AND cid is NULL ";
		} elseif ($cid == '') {
			$statement .= " AND cid is not NULL ";
		} else {
			$statement .= " AND cid = '{$cid}' ";
		}
	
		$storeId = $olapObj->getStoreId();
		if (isset($storeId) == false) {
			$statement .= " AND storeId is NULL ";
		} elseif ($storeId == 0 || $storeId == '') {
			$statement .= " AND storeId is not NULL ";
		} else {
			$statement .= " AND storeId = {$storeId} ";
		}
	
		$from = $olapObj->getFrom();
		$to = $olapObj->getTo();
		if (isset($from) == false && isset($to) == false) {
			$statement .= " AND orderDate is NULL ";
		} elseif ($from == '' && $to == '') {
		} else {
			$statement .= " AND orderDate >= '{$from}' ";
			$statement .= " AND orderDate <= '{$to}' ";
		}
		
		$statement .= " GROUP BY username, cid, storeId ";
	
		$stmt = $pdo->prepare($statement);
		$stmt->execute();
	
		$temp = $stmt->fetchAll();
		$list = array();
		foreach ($temp as &$row) {
			$olap = new Olap($row[0], $row[1], $row[2], $from, $to,
					$row[3], $row[4]);
			$list[] = $olap;
		}
	
		$pdo = null;
		return $list;
	}
	
	

	/*
	 * Get the top n sellings products within a period.
	 * $from or $to can be null to indicate no constraint.
	 * $cateId is the category Id products belong to. Default is null
	 */
	public function getTopNSellings($n, $from, $to, $cateId = null) {
		$pdo = self::getPdo();

		if (isset($from) && isset($to)) {
			$inject = " co.orderDate >= '{$from}' AND co.orderDate <= '{$to}' ";
		} elseif (isset($from) && isset($to) == false) {
			$inject = " co.orderDate >= '{$from}' ";
		} elseif (isset($from) == false && isset($to)) {
			$inject = " co.orderDate <= '{$to}' ";
		} elseif (isset($from) == false && isset($to) == false) {
			$inject = " 1 ";
		}

		if (is_null($cateId)) {
			$cateIndicated = "";
		} else {
			$cateIndicated = " AND op.cid in (SELECT cid FROM ProductsMapCategories WHERE cateId = {$cateId})";
		}

		$statement = "SELECT * FROM Products p,
		(SELECT op.cid as cid, SUM(op.quantity) as total FROM OrdersProducts op, CustomersOrders co WHERE co.orderId = op.orderId AND "
				. $inject . $cateIndicated
				. "
		 GROUP BY op.cid ORDER BY total DESC LIMIT 0,{$n}) top WHERE top.cid = p.cid ";
		$stmt = $pdo->prepare($statement);

		$stmt->execute();
		$temp = $stmt->fetchAll();
		$list = array();
		foreach ($temp as &$row) {
			$product = new Product($row[0], $row[1], $row[2], $row[3], $row[4],
					$row[5], $row[6], $row[7]);
			$product->setTotalSold($row[9]);
			$list[] = $product;
		}
		$pdo = null;
		return $list;

	}

	/*
	 * Get the top n highest rated products
	 * $cateId is the category Id products belong to. Default is null, which
	 * means category is not taken into account;
	 */
	public function getTopNRatedProducts($n, $cateId = null) {
		$pdo = self::getPdo();

		if (is_null($cateId)) {
			$cateIndicated = " 1 ";
		} else {
			$cateIndicated = " p.cid in (SELECT cid FROM ProductsMapCategories WHERE cateId = {$cateId})";
		}

		$statement = "SELECT * FROM Products p, ProductsRating proRat
		 WHERE p.cid = proRat.cid AND " . $cateIndicated
				. " ORDER BY proRat.rating DESC
		 LIMIT 0,{$n} ";
		$stmt = $pdo->prepare($statement);

		$stmt->execute();
		$temp = $stmt->fetchAll();
		$list = array();
		foreach ($temp as &$row) {
			$product = new Product($row[0], $row[1], $row[2], $row[3], $row[4],
					$row[5], $row[6], $row[7]);
			$list[] = $product;
		}
		$pdo = null;
		return $list;

	}

	private static function cmp(Product $p1, Product $p2) {
		return $p1->getRating() - $p2->getRating();
	}

	/*
	 * Mix top products by sellings and ratings to product a list of
	 * recommendations for users.
	 * The algorithm to rank top products by rating and sellings is sort them
	 * by their score. The higher the score is, the lower its position in the
	 * recommendations list. "score" of a product is defined as the sum of
	 * their positions in the rating and selling lists. If one product exists in
	 * one list but not in the other, then the position in the other list is
	 * the size of that list which is the lowest position.
	 *
	 * Given the algorithm, the list produced has at most 2 * $n products.
	 */
	public function recommendRelatedProducts($n, $cateId = null) {
		$format = 'Y-m-d H:i:s';

		$from = new \DateTime();
		$from->sub(new \DateInterval('P30D'));
		$to = new \DateTime();

		$from = $from->format($format);
		$to = $to->format($format);

		$sellingList = $this->getTopNSellings($n, $from, $to, $cateId);
		$ratingList = $this->getTopNRatedProducts($n, $cateId);

		function lookup(Product &$prod, array &$list) {
			$size = count($list);
			for ($i = 0; $i < $size; $i++) {
				if ($prod->getCid() == $list[$i]->getCid()) {
					break;
				}
			}
			return $i;
		}

		$newList = array();
		$seSize = count($sellingList);
		$raSize = count($ratingList);
		for ($i = 0; $i < $seSize; $i++) {
			// look if product is in the final list already
			if (lookup($sellingList[$i], $newList) == count($newList)) {
				$ratingScore = lookup($sellingList[$i], $ratingList);
				$sellingList[$i]->setRating($ratingScore + $i);
				$newList[] = $sellingList[$i];
			}
		}

		for ($j = 0; $j < $raSize; $j++) {
			// look if product is in the final list already
			if (lookup($ratingList[$j], $newList) == count($newList)) {
				$sellingScore = lookup($ratingList[$j], $sellingList);
				$ratingList[$j]->setRating($sellingScore + $j);
				$newList[] = $ratingList[$j];
			}
		}

		var_dump($newList);
// 		echo "<br><br> ... <br><br>";

		// Sore the final list based on final score
		usort($newList, 'self::cmp');
		return $newList;

	}

	/*
	 * Given the order ID, and amount of money paying, $howmuch
	 * Update the CustomersOrders table
	 */
	public function setPayment($orderId, $howMuch) {
		$pdo = self::getPdo();
		$statement = "UPDATE CustomersOrders SET payment = ? WHERE orderId = ?";
		$stmt = $pdo->prepare($statement);
		$array = array($howMuch, $orderId);

		$value = $stmt->execute($array);
		$value = ($value == true && $stmt->rowCount() > 0);

		$pdo = null;
		return $value;

	}

}
?>
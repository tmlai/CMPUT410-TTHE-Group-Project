<?php
namespace model;
include_once "Customer.php";
include_once "Product.php";
include_once "Store.php";
include_once "Category.php";
include_once "CustomerOrder.php";
include_once "OrderProduct.php";
include_once "Olap.php";
include_once "UserRatingProduct.php";

interface DbInterface {

	// Customer + admin section
	
	/*
	 * Return a list of customer objects
	 */
	public function getListCustomers();
	
	
	/*
	 * Add the customer to the database
	 * Parameters: $customer: the customer object to be added
	 * Return type: true if successfully, false if fails
	 */
	public function addCustomer(Customer $customer);

	/*
	 *
	 */
	public function deleteCustomer(Customer $customer);

	public function updateCustomer(Customer $customer);

	/*
	 * Given the username and password, authenticate the identity of
	 * the customer.
	 * Return	0	:	username is not recognized.
	 * 			1	:	username is recognized but password doesn't match
	 * 			2	:	username and password match
	 */
	public function authenticateCustomer($username, $password);

	/*
	 * Add the admin to the database
	 * Parameters: $admin: the admin object to be added
	 * Return type: true if successfully, false if fails
	 */
	// public function addAdmin(Admin $admin);
	//
	// public function deleteAdmin(Admin $admin);
	//
	//
	// public function updateAdmin(Admin $admin);

	// ------------------------------------------------------------------------

	// Categories section
	// public function addCategory(Category $cate);
	//
	// public function updateCategory(Category $cate);
	//
	// public function deleteCategory(Category $cate);
	//

	// ------------------------------------------------------------------------

	// Products section
	public function addProduct(Product $prod);
	//
	// public function updateProduct(Product $prod);
	//
	// public function deleteProduct(Product $prod);

	public function matchProductCategory($cid, $cateId);

	/*
	 * Update the stock of some product. 
	 * NOTE: $pdo is the connection object. This is passed into the 
	 * method so that the update stock operation can be rollbacked.
	 */
	public function updateStock(&$pdo, $productId, $itemsDrawn);
	
	/*
	 * Allow user to rate the product
	 */
	public function rateProduct(UserRatingProduct $urp);

	/*
	 * Get the stock of some product.
	 */
	public function getStock($productId);

	/*
	 * Get the price of the product given its product ID.
	 */
	public function getPrice($productId);
	
	
	/*
	 * Return a list of categories
	 * Return type: array of category objects
	 */
	public function getCategoriesList();

	/*
	 * Return a list of products belonging to some category
	 * Parameters: $categoryId 	the id of the category
	 * Return type: array of product objects
	 */
	public function getProducts($categoryId = null);

	// -------------------------------------------------------------------------

	public function addStore(Store $store);

	/*
	 * Get the store Object given the url of the store.
	 * Return the store object in case of matching. Null otherwise.
	 */
	public function searchStore($url);
	
	/*
	 * Get the list of external stores which we do business with
	 */
	public function getListExternalStores();

	/*
	 * order products from other stores
	 * Parameters:	$productId:	the product to be ordered from other stores
	 * 				$quantity:	number of products ordered
	 * 				$url:		url of the store
	 * Return type:	true if the order is placed successfully, false otherwise.
	 */
	public function orderOthersStore($productId, $quantity, $url);

	/*
	 * Add just one product ordered to the database.
	 * Parameters:	$pdo:			the pdo connection
	 * 				$orderProduct	OrderProduct object to be inserted.
	 * Return type:	true if insert successfully, false otherwise.
	 * NOTE: 		pass the pdo connection so that this database action can be rollbacked
	 * 				since this action is a small step in a transaction.
	 */
	public function orderOneProduct(\PDO $pdo, OrderProduct $orderProduct);

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
			array $orderProductsArray);
	// 	------------------------------------------------------------------------

	// 	WEB SERVICES SECTION
	/*
	 * Get the list of product IDs of products still in stock
	 * Return the associative array: array['products'] of which element is
	 * another associative array in the following form: array['id']=id
	 */
	public function getProductsInStock();

	/*
	 * Get the whole description about some product given its product ID.
	 * Return the product object in case of matching. Null otherwise.
	 */
	public function getOneProduct($cid);

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
	 */
	public function receiveOrderFromStore($storeId, $cid, $quantity);

	/*
	 * Given the order id, check the delivery date to see if there is a delay
	 * in delivery.
	 * RETURN: JSON in the following format: {"delivery_date":"some date"}.
	 * If $orderId is invalid, return an empty JSON.
	 */
	public function checkDeliveryDate($orderId);

	// 	------------------------------------------------------------------------
	// 	SEARCH SECTION 
	/*
	 * Given the search name for the product, return the list of product objects
	 * Parameters: $partial	the name for the product to be searched
	 * Return type:	the list of product objects returned.
	 */

	/*
	 * @param string $partial
	 * @return array 
	 */
	public function searchProductByName($partial);

	/*
	 * @param string $code
	 * @return array
	 * Given the $code, product id, of the product, return 
	 * a list of products having this code. For compatibility with other
	 * search methods, an array is returned. In fact, this array should contain 
	 * at most one product only.
	 */
	public function searchProductByCode($code);

	/*
	 * @param string $category
	 * @return array
	 * Given the $category, name of category, of the product, return
	 * category id.
	 */
	public function searchProductByCategory($category);

	/*
	 * @param	$cateId			category Id
	 * @param	$priceRange		the price range {lowerBound, upperBound}. 
	 * 							null to indicate no constraint on lower/upper.
	 * @param	$availRange		the availability range {lowerBound, upperBound}
	 * @param	$weightRange	the weight Range {lowerBound, upperBound}
	 */
	public function searchProductByConstraints($cateId, $priceRange,
			$availRange, $weightRange);

	// 	-----------------------------------------------------------------------
	// 	Outstanding orders section
	/*
	 * Given the username of the user return a list of CustomerOrder objects
	 * corresponding to orders. If $outStanding is indicated(true), only outstanding
	 * orders - ones of which deliveryDate has not passed yet - are returned.
	 */
	public function getCustomersOrders($username, $outStanding);
	
	/*
	 * Given the order ID, retrieve the list of Products belonging to this 
	 * order.
	 */
	public function getListProductsInOrder($orderId);
	
	/*
	 * Given the $olapObj which amounts to search query, return a list of
	 * Olap objects satisfying the constraints.
	 * More specifically, 
	 * $username of $olapObj = 0 -> each username,
	 * $username of $olapObj = null -> aggregate on all usernames,
	 * $username of $olapObj = specific username -> specific username.
	 * 
	 * $storeId of $olapObj = 0 -> each store,
	 * $storeId of $olapObj = null -> aggregate on all stores,
	 * $storeId of $olapObj = specific store id -> specific store.
	 * 
	 * $cid of $olapObj = 0 -> each product,
	 * $cid of $olapObj = null -> aggregate on all products,
	 * $cid of $olapObj = specific cid -> specific cid.
	 * 
	 * $from and $to of $olapObj = 0 -> each orderDate,
	 * $from = null and $to = null -> aggregate on all products,
	 * $from = specific and $to = specific -> a range.
	 */
	public function getOlapReport(Olap $olapObj);
	
	public function getGenOlapReport(Olap $olapObj);
	
	/*
	 * Get the top n sellings products within a period.
	 * $from or $to can be null to indicate no constraint.
	 * $cateId is the category Id products belong to. Default is null
	 */
	public function getTopNSellings($n, $from, $to, $cateId = null);
	
	/*
	 * Get the top n highest rated products 
	 * $cateId is the category Id products belong to. Default is null, which
	 * means category is not taken into account;
	 */
	public function getTopNRatedProducts($n, $cateId = null);
	
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
	 * We take into account the sellings within 30 days only.
	 * 
	 * Given the algorithm, the list produced has at most 2 * $n products.
	 */
	public function recommendRelatedProducts($n, $cateId = null);
	
	/*
	 * Given the order ID, and amount of money paying, $howmuch
	 * Update the CustomersOrders table
	 */
	public function setPayment($orderId, $howMuch);
}
?>
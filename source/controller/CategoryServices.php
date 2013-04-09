<?php
use model\DbLayer;
use model\Category;
use model\Product;
include_once '../model/DbLayer.php';
include_once '../model/Category.php';
include_once '../model/Product.php';
$dbLayer = new DbLayer();
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if ($requestMethod == 'get') {
	// catList param for category list
	if (isset($_GET['catList'])) {
		$categories = $dbLayer->getCategoriesList();
		$allReturned = array();
		foreach ($categories as &$singleCategory) {
			/* @var $singleCategory Category */
			$id = $singleCategory->getCateId();
			$name = $singleCategory->getName();
			$description = $singleCategory->getDescription();

			//create a new object
			$singleObj = array('cateId' => $id, 'name' => $name,
					'description' => $description);
			$allReturned[] = $singleObj;
		}
		echo json_encode($allReturned);
	} elseif (isset($_GET['catProds'])) {
		$id = $_GET['catProds'];
		$list = $dbLayer->getProducts($id);
		$allReturned = array();
		foreach ($list as &$prod) {
			/* @var $prod Product */
			$allReturned[] = $prod->toAssociativeArray();
		}
		echo json_encode($allReturned);
	}
}
?>
<?php
use model\DbLayer;
use model\Category;
include_once '../model/DbLayer.php';
include_once '../model/Category.php';
$dbLayer = new DbLayer();
$requestMethod = strtolower($_SERVER['REQUEST_METHOD']);

if ($requestMethod == 'get') {
	if (count($_GET) > 0) {
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
		}
	} elseif (isset($_GET['catProds'])) {
		$id = $_GET['catProds'];
		$list = $dbLayer->getProducts($id);
		$allReturned = array();
		for ($i = 0; $i < count($list); $i++) {
			$singleProduct = $list[$i];
			$cid = $singleProduct->getCid();
			$price = $singleProduct->getPrice();
			$weight = $singleProduct->getWeight();
			$name = $singleProduct->getName();
			$description = $singleProduct->getDescription();
			$image = $singleProduct->getImage();

			//create a new object
			$singleObj = array('cid' => $cid, 'price' => $price,
					'weight' => $weight, 'name' => $description,
					'image' => $image);
			$allReturned[] = $singleObj;
		}
		echo json_encode($allReturned);
	}
}
?>
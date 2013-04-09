<?php
namespace controller;

use model\DbLayer;

include_once '../model/DbLayer.php';

try {
	$dbLayer = new DbLayer();
    $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	if($requestMethod = 'get') {
			if(!empty($_GET)) {
        // catList param for category list
        if(isset($_GET['catList'])) {
          $categories = $dbLayer->getCategoryList();
          $allReturned = array();
          for($i = 0; $i < count($categories); $i++){
            $singleCategory = $categories[i];
            $id = $singleCategory->getCateId();
            $name = $singleCategory->getName();
            $description = $singleCategory->getDescription();
            
            //create a new object
            $singleObj = array(
              'cateId'=>$id,
              'name'=>$name,
              'description'=>$description);
            $allReturned[] = $singleObj;
          }
          echo \json_encode($allReturned);
        } elseif(isset($_GET['catProds'])) {
          $id = $_GET['catProds'];
          $list = $dbLayer->getProducts($id);
          $allReturned = array();
          for($i=0; $i<count($list);$i++) {
            $singleProduct = $list[$i];
            $cid = $singleProduct->getCid();
            $price = $singleProduct->getPrice();
            $weight = $singleProduct->getWeight();
            $name = $singleProduct->getName();
            $description = $singleProduct->getDescription();
            $image = $singleProduct->getImage();
            
            //create a new object
            $singleObj = array(
              'cid'=>$cid, 'price'=>$price,
              'weight'=>$weight, 'name'=>$description,
              'image'=>$image);
            $allReturned[] = $singleObj;
          }
          echo \json_encode($allReturned);
        }
			}
	}
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
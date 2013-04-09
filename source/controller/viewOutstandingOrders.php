<?php 
session_start();
use model\DbLayer;
use model\CustomerOrder;
use model\OrderProduct;
include_once '../model/DbLayer.php';
include_once '../model/CustomerOrder.php';
include_once '../model/OrderProduct.php';
$username = $_SESSION['user'];
// if($username == ''){
// 	$username = $_GET['user'];
// }
$dbLayer = new DbLayer();

$dbLayer->updateOrdersBeforeViewing($username);

$list = $dbLayer->getCustomersOrders($username, true);
$ordersList = array();
foreach($list as &$co){
	/* @var $co CustomerOrder */
	$oneOrder = array();
	$productsList = array();
	
	$deliveryDate = $co->getDeliveryDate();
	$oneOrder["delivery_date"] = $deliveryDate; 
	
	$orderId = $co->getOrderId();
	$oneOrder["orderId"] = $orderId;
	
	$temp = $dbLayer->getListProductsInOrder($orderId);
	foreach($temp as &$op){
		/* @var $op OrderProduct */
		$eachTuple = array();
		$eachTuple['pid'] = $op->getCid();
		$eachTuple['quantity'] = $op->getQuantity();
		$eachTuple['amount'] = $op->getAmount();
		$productList[] = $eachTuple;
	}
	$oneOrder["order"] = $productList;
	$ordersList[] = $oneOrder;
}
echo json_encode($ordersList);
?>
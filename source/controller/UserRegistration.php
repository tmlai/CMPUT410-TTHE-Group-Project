<?php 
namespace controller;
use model\DbLayer;
include_once '../model/DbLayer.php';

// try {
	// $dbLayer = new DbLayer();
    // $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
	// switch($requestMethod) {
		// case 'get':
			// echo "Wrong Request Method. Please use 'POST'.";
			// break;
		// case 'post':
			// $userJsonString = file_get_contents("php://input");
			
			// var_dump($userJsonString);
			
	// }
// } catch (Exception $e) {
    // echo 'Caught exception: ',  $e->getMessage(), "\n";
// }
?>
<html>
	<header>
		<title> UserRegistration.php </title>
	</header>
	
	<body>
		<?php 
		//grab associative array from post
		$username = $_POST['userField'];
		$password = $_POST['passField'];
		$address = $_POST['addrField'];
		$city = $_POST['cityField'];
		$postalCode = $_POST['postalField'];
		$email = $_POST['emailField'];
		$adminChecked = $_POST['adminCheck'];
		
		// var_dump($_POST);
		// echo "<br><hr><br>";
		// echo $adminChecked;
		
		//create a customer object
		$customer = new Customer();
		$customer->setUsername($username);
		$customer->setPassword($password);
		$customer->setAddress($address);
		$customer->setCity($city);
		$customer->setPostalCode($postalCode);
		$customer->setEmail($email);
		
		//debug $customer, is it setting?
		var_dump($customer);
		
		// //does the user want admin access?
		// if($_POST['adminCheck'] == "on") {
			// $adminCode = $_POST['adminCode'];
			// $realCode = "admin04";
			// //does the user entered the right password?
			// if($adminCode == $realCode) {
				// //add user to both Customer and Admin
			// } else {
				// echo "Failed to register as administrator.";
			// }
		// } else if($_POST['adminCheck'] == "off") {
			// //add user to Customer table
			// // $dbLayer = new DbLayer();
			// // $dbLayer->addCustomer($customer);
		// }
		
		?>
	</body>
</html>
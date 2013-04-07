<?php 
//namespace controller;
use model\DbLayer;
use model\Customer;

include_once '../model/DbLayer.php';
include_once '../model/Customer.php';

?>
<html>
	<header>
		<title> UserRegistration.php </title>
	</header>
	
	<body>
		<?php 
		//debug statements
		var_dump($_POST);
		echo "<br><hr><br>";
		
		
		//grab associative array from post
		$username = $_POST['userField'];
		$password = $_POST['passField'];
		$address = $_POST['addrField'];
		$city = $_POST['cityField'];
		$postalCode = $_POST['postalField'];
		$email = $_POST['emailField'];
		$adminChecked = $_POST['adminCheck'];
		
		//debugging statements
		var_dump($adminChecked);
		echo "<br><hr><br>";
		// echo $adminChecked;
		
		//create a customer object
		$customer = new Customer($username, $password, $address,
			$city, $postalCode, $email);
		
		//debug $customer, is it setting?
		var_dump($customer);
		echo "<br><hr><br>";
		echo $customer->getUsername();
		
		//does the user want admin access?
		if($_POST['adminCheck'] == "on") {
			$adminCode = $_POST['adminCode'];
			$realCode = "admin04";
			//does the user entered the right password?
			if($adminCode == $realCode) {
				echo "Passcode match!!";
				//add user to both Customer and Admin
			} else {
				echo "Failed to register as administrator.";
			}
		} else if($_POST['adminCheck'] == "" || $_POST['adminCheck'] == null) {
			//add user to Customer table
			echo "Add user to Customer table";
			// $dbLayer = new DbLayer();
			// $dbLayer->addCustomer($customer);
		}
		
		?>
	</body>
</html>
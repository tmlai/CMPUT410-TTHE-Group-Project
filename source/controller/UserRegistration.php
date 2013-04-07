<?php 
//namespace controller;
use model\DbLayer;
use model\Customer;

include_once '../model/DbLayer.php';
include_once '../model/Customer.php';

session_start();
?>
<html>
	<head>
		<title> UserRegistration </title>
    <!-- Goto previous page -->
		<META HTTP-EQUIV="refresh" CONTENT="2;URL=<?php echo $_SESSION['prevPage']?>">
	</head>
	<body>
		<?php 
		//grab associative array from post
		$username = $_POST['userField'];
		$password = $_POST['passField'];
		$address = $_POST['addrField'];
		$city = $_POST['cityField'];
		$postalCode = $_POST['postalField'];
		$email = $_POST['emailField'];

		//try to get the admin check box value (was it checked)
		try {
			$adminChecked = $_POST['adminCheck'];
		} catch (Exception $e) {
			$adminChecked = null;
		}

		//create a customer object
		$customer = new Customer($username, $password, $address,
			$city, $postalCode, $email);

		//does the user want admin access?
		if($_POST['adminCheck'] == "on") {
			$adminCode = $_POST['adminCode'];
			$realCode = "admin04";
			//does the user entered the right password?
			if($adminCode == $realCode) {
				//add user to both Customer and Admin
				$dbLayer = new DbLayer();
				$status = $dbLayer->addCustomer($customer);
				if($status == true) {
					$status = $dbLayer->addAdmin($username, $password);
					if($status = true) {
						echo "Admin Registration Success.";
					} else {
						echo "Admin Registration Failed.";
					}
				} else {
					echo "Failed to Register.";
				}
			} else {
				echo "Failed to register as administrator.";
			}
		} else if($_POST['adminCheck'] == "" || $_POST['adminCheck'] == null) {
			//add user to Customer table
			$dbLayer = new DbLayer();
			$status = $dbLayer->addCustomer($customer);
			if($status == false) {
				echo "Failed to register.";
			} else {
				echo "Successfully Registered.";
			}
		}
		?>
	</body>
</html>
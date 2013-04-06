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
		$adminCode = $_POST['adminCode'];
		var_dump($regInfo);
		echo "<br><hr><br>";
		
		?>
	</body>
</html>
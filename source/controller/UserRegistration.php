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
		//$input = file_get_contents("php://input");
		//var_dump($input);
		echo $_POST['userField'];
		echo "<br><hr><br>";
		echo "echo input: ".$input;
		?>
	</body>
</html>
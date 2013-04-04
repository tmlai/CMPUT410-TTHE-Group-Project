<html>
	<header>
		<title> testWeb.php </title>
		<script>
			function testGetAll() {
				var xmlhttp=new XMLHttpRequest();
				//send ajax request
				xmlhttp.open('GET', 'http://cs410.cs.ualberta.ca:41041/CMPUT410-TTHE-Group-Project/source/controller/webservices.php', 'true');
				xmlhttp.send();
			}
		</script>
	</header>
	<body>
		<input type="button" onClick="testGetAll()" value="Get All">
	</body>
</html>
<html>
	<header>
		<title> testWeb.php </title>
		<script>
			//gets all the id numbers in stock
			function testGetAll() {
				var xmlhttp=new XMLHttpRequest();
				//send ajax request
				xmlhttp.open('GET', '/CMPUT410-TTHE-Group-Project/source/controller/webservices.php', 'true');
				xmlhttp.send();
			}
			
			//gets info with the given id number_format
			function testGetOne() {
				var id = document.getElementById("idNum").value;
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.open('GET', '/CMPUT410-TTHE-Group-Project/source/controller/webservices.php?id='+id, 'true');
				xmlhttp.send();
			}
		</script>
	</header>
	<body>
		<input type="button" onClick="testGetAll()" value="Get All ID's"> <br>
		<input type="button" onClick="testGetOne()" value="Get One">
		Id: <input type="text" id="idNum">
	</body>
</html>
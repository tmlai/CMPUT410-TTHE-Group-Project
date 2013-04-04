<html>
	<header>
		<title> testWeb.php </title>
		<script>
			//gets all the id numbers in stock
			function testGetAll() {
				var xmlhttp=new XMLHttpRequest();
				//send ajax request
				xmlhttp.open('GET', '/CMPUT410-TTHE-Group-Project/source/controller/ProductServices.php', 'true');
				xmlhttp.send();
			}
			
			//gets info with the given id number_format
			function testGetOne() {
				var id = document.getElementById("idNum").value;
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.open('GET', '/CMPUT410-TTHE-Group-Project/source/controller/ProductServices.php?id='+id, 'true');
				xmlhttp.send();
			}
			
			//another store doing a post to us to buy one
			function testSellOne() {
				var id = document.getElementById("idNum2").value;
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.open('POST', '/CMPUT410-TTHE-Group-Project/source/controller/ProductServices.php, 'true');
				xmlhttp.send(id);
			}
		</script>
	</header>
	<body>
		<input type="button" onClick="testGetAll()" value="Get All ID's"> <br>
		<input type="button" onClick="testGetOne()" value="Get One">
		Id: <input type="text" id="idNum"><br>
		<input type="button" onClick="testSellOne()" value="Someone Buying From Us">
		Id2: <input type="text" id="idNum2"><br>
	</body>
</html>
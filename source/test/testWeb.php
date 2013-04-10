<html>
	<header>
		<title> testWeb.php </title>
		<script>
			//gets all the id numbers in stock
			function testGetAll() {
				var xmlhttp=new XMLHttpRequest();
				//send ajax request
				xmlhttp.open('GET', '/source/controller/ProductServices.php', 'true');
				xmlhttp.send();
			}
			
			//gets info with the given id number_format
			function testGetOne() {
				var id = document.getElementById("idNum").value;
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.open('GET', '/source/controller/ProductServices.php?id='+id, 'true');
				xmlhttp.send();
			}
			
			//another store doing a post to us to buy one
			function testSellOne() {
				//var id = document.getElementById("idNum2").value;
				
				function functionToCall() {
		if (xmlhttp.readyState == 4) {
			alert(xmlhttp.responseText);
			document.write(xmlhttp.responseText);
			var XmlResult = xmlhttp.responseXML;
		}
	}
				var amt = document.getElementById("amt").value;
				var id = document.getElementById("idNum2").value;
				var params = "amount=" + amt;
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.open('POST', '/products/'+id+'/order', false);
				xmlhttp.onreadystatechange = functionToCall;
				xmlhttp.send(params);
			}
			
			function testGetDeliveryDate() {
				var oid = document.getElementById("oid").value;
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.open('GET', '/source/controller/OrderServices.php?oid='+oid, 'true');
				xmlhttp.send();
			}
		</script>
	</header>
	<body>
		<input type="button" onClick="testGetAll()" value="Get All ID's"> <br>
		<input type="button" onClick="testGetOne()" value="Get One">
		Id: <input type="text" id="idNum"><br>
		<input type="button" onClick="testSellOne()" value="Someone Buying From Us">
		Id2: <input type="text" id="idNum2">Amount: <input type="text" id="amt"><br>
		<input type="button" onClick="testGetDeliveryDate()" value="Check Order">
		Order Id: <input type="text" id="oid">
	</body>
</html>
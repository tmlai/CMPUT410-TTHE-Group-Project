<?php
	session_start();
	$_SESSION["user"] = "hcngo";
?>
<html>
	<header>
		<title> testWeb.php </title>
		<script>
			//gets all the id numbers in stock

			var url ="../model/ProductExternalAvailability.php";
			//gets info with the given id number_format
			function testGetOne() {
				function functionToCall() {
					if (xmlhttp.readyState == 4) {
						alert(xmlhttp.responseText);
						document.write(xmlhttp.responseText);
						var XmlResult = xmlhttp.responseXML;
					}
				}
				
				var id = document.getElementById("id").value;
				var q = document.getElementById("idQ").value;
				var xmlhttp=new XMLHttpRequest();
				xmlhttp.onreadystatechange = functionToCall;
				xmlhttp.open('GET', url+'?cid='+id+"&quantity="+q, 'true');
				
				xmlhttp.send();
			}

			function OrderProduct(id,q){
				this.cid = id;
				this.quantity = q;
			}
			
			//another store doing a post to us to buy one
			function testBuyOne() {
				//var id = document.getElementById("idNum2").value;
				
				function functionToCall() {
					if (xmlhttp.readyState == 4) {
						alert(xmlhttp.responseText);
						document.write(xmlhttp.responseText);
						var XmlResult = xmlhttp.responseXML;
					}
				}
				var id = document.getElementById("id").value;
				var q = document.getElementById("idQ").value;
				var xmlhttp=new XMLHttpRequest();
				var orderLists = Array(1);
				var an_order = new OrderProduct(id,q);
				orderLists[0] = an_order;
				alert(JSON.stringify(orderLists));
				var params = "orderLists="+ JSON.stringify(orderLists);
					
				xmlhttp.open('POST', url, false);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = functionToCall;
				xmlhttp.send(params);
			}
			

		</script>
	</header>
	<body>
		<input type="button" onClick="testGetOne()" value="Get Request">
		Id: <input type="text" id="id"><br>
		<input type="button" onClick="testBuyOne()" value="Buy something">
		Quantity: <input type="text" id="idQ"><br>
	</body>
</html>
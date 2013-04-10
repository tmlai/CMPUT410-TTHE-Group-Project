<?php
	session_start();
	$_SESSION["user"] = "hcngo";
?>
<html>
	<header>
		<script>
			//gets all the id numbers in stock

			var url ="../controller/PaymentProcess.php";
			//gets info with the given id number_format


			function OrderProduct(id,q){
				this.cid = id;
				this.quantity = q;
			}
			
			//another store doing a post to us to buy one
			function testBuyOne() {
				//var id = document.getElementById("idNum2").value;
				
				function functionToCall() {
					if (xmlhttp.readyState == 4) {
						//alert(xmlhttp.responseText);
						res = document.getElementById("res");
						res.innerHTML = xmlhttp.responseText;
						var json = JSON.parse(xmlhttp.responseText);
						alert(json);
						alert(json["status"]);
						if (json["status"] == "True"){
							window.location.replace(json["message"]);
						}
						else {
							alert(json["message"]);
						}
					}
				}
				
				var id = document.getElementById("id").value;
				var q = document.getElementById("idQ").value;
				var xmlhttp=new XMLHttpRequest();
				var orderLists = Array(2);
				var an_order = new OrderProduct(id,q);
				var another_order = new OrderProduct("c000002",q);
				orderLists[0] = an_order;
				orderLists[1] = another_order;
				//alert(JSON.stringify(orderLists));
				var params = "orderLists="+ JSON.stringify(orderLists);
					
				xmlhttp.open('POST', url, false);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
				xmlhttp.onreadystatechange = functionToCall;
				xmlhttp.send(params);
			}
			

		</script>
	</header>
	<body>
		Id: <input type="text" id="id"><br>
		Quantity: <input type="text" id="idQ"><br>
		<input type="button" onClick="testBuyOne()" value="Buy something">
		
		<div id="res"></div>
	</body>
</html>
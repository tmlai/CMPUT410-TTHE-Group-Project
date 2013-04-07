// Add a product to the user's cart
function addProdToCart(pid) {
  alert("checking stock...");
  var xmlhttp = new XMLHttpRequest();
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
  
  // Return if product is in stock
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var jsonArray = JSON.parse(xmlhttp.responseText);
      if(jsonArray.stock == 0) {
        //checkExternalAvail(pid);
        alert("No Stock Available");
      } else {
        var qty = readCookie('cart_' + pid);
        var cartJson = JSON.parse(readCookie('cart'));
        // Check if cart cookie exists
        if(cartJson != null){
          var cartPIDs = cartJson.pids;
          // Add new pid to cart if necessary
          if(cartPIDs.indexOf(pid) < 0) {
            cartPIDs.push(pid);
            cartJson.pids = cartPIDs;
            createCookie('cart', JSON.stringify(cartJson), 0);
          }
        } else {
          // Create cart cookie storing product ids.
          var cartCookie = '{"pid":"' + new Array(pid) + '"}';
          cartCookie = JSON.stringify(cartCookie);
          createCookie('cart', cartCookie, 0);
        }
        if(num == null) num = 0;
        createCookie('cart_' + pid, num + 1, 0);
      }
    }
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, 'true');
  xmlhttp.send();
}
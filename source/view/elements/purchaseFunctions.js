/*
 * Build and write the html for the Cart Products.
 * @param products array
 */ 
function buildInvoice() {
  //var div = document.getElementById("resultsDiv");
  var jsonCart = JSON.parse(readCookie('cart'));
  var emptyCount = 0;
  var price = 0;
  // reset div for products
  document.getElementById("productsBody").innerHTML = " ";
  // If no cart exists
  if(jsonCart == null) {
    document.getElementById("resultsDiv").innerHTML = "<h4>Order is empty.</h4>";
    return false;
  }
  for(var i = 0; i < jsonCart.length; i++) {
    var xmlhttp = new XMLHttpRequest();
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    }	else {
      // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    // Return if product is in stock
    xmlhttp.onreadystatechange=function() {
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        var product = JSON.parse(xmlhttp.responseText);
        document.getElementById("productsBody").innerHTML += (
          "<tr>\n<td>\n"
          // Quantity for purchase
          + jsonCart[i].quantity + "</td>\n"
          // Thumbnail of product
          + "<td> <img src='/img/products/" + product['id'] + ".jpg\'" 
          + "\" alt=\"\" width=\"50\" height=\"50\">\n"
          + "</td>\n"
          // Price of product
          + "<td>$" + product['price'] + "</td>\n"
          // Weight of product
          + "<td>" + product['weight'] + "</td>\n"
          // Name of product
          + "<td>" + product['name'] + "</td>\n"
          // Code of product
          + "<td>" + product['id'] + "</td>\n"
          // Description of product
          + "<td>" + product['desc'].substring(0, 35) + "...</td>\n"
          + "</tr>\n"
        );     
        price += (jsonCart[i].quantity * product['price']);
     }
   
    };
    xmlhttp.open('GET', '../controller/ProductServices.php?id=' + jsonCart[i]['pid'], false);
    xmlhttp.send();
  }
  document.getElementById("loadingSpinner").style.visibility = "hidden";
  document.getElementById("loadingSpinner").innerHTML = "<br>";
  document.getElementById("priceCalc").innerHTML = "Total Price of Cart = $" 
    +  parseFloat(price).toFixed(2);
  if(emptyCount == jsonCart.length)
    document.getElementById("resultsDiv").innerHTML = "<h4>Cart is empty.</h4>";
}

function submitOrder(user) {
  if(user == null || user == "") {
    var pBool = confirm("You must sign in or register to purchase your cart.\n"
      + "Would you like to register now?");
    if(pBool) {
      var dir = location.href;
      dir = dir.substr(0, dir.lastIndexOf("/") + 1);
      dir = dir + "register.php";
      window.location.href = dir;
    }
  } else {
    var jsonCart = JSON.parse(readCookie('cart'));
    if(jsonCart == null) {
      alert("You must have at least one product in order to make a purchase.");
      var dir = location.href;
      dir = dir.substr(0, dir.lastIndexOf("/") + 1);
      dir = dir + "index.php";
      window.location.href = dir;
      return false;
    }
    makePurchase(jsonCart);
  }
}

/*
 * Send the purchase order in json format:
 * orderLists=[{"cid":"#","quantity":"#"},{"cid":"#","quantity":"#"}...]
 */
function makePurchase(cart) {
  var purchase = new Array();
  for(var i = 0; i < cart.length; i++) {
    var arr = {};
    arr['cid'] = cart[i]['pid'];
    arr['quantity'] = cart[i]['quantity'];
    purchase.push(arr);
  }
  sendPurchase('orderLists=' + JSON.stringify(purchase));
}

function sendPurchase(jsonInv) {
  // AJAX call for external stores
  var xmlhttp = new XMLHttpRequest();
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}	else {
    // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
  
  // Return if product is in stock
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var response = JSON.parse(xmlhttp.responseText);
      if(response['status'] == "True") {
        //return response['deliveryDate'];
        // Delete cart cookie on purchase
        eraseCookie('cart');
        // Redirect user
        window.location.replace(response["message"]);
      } else {
        alert(response["message"]);
        var dir = location.href;
        dir = dir.substr(0, dir.lastIndexOf("/") + 1);
        dir = dir + "cart.php";
        window.location.href = dir;
      }
      return "false";
    }
  };
  
  xmlhttp.open('POST', '../controller/PaymentProcess.php', true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send(jsonInv);
  
  // Change document to inform customer
  document.getElementById('resultsDiv').innerHTML = ' <br> ';
  document.getElementById('buttonsDiv').innerHTML = ' <br> ';
  document.getElementById("loadingSpinner").innerHTML = 
    '<img src="./elements/img/spinner.gif" alt="">'
    + '...Your order is being processed, thank you for your patience...';
  document.getElementById("loadingSpinner").style.visibility = "visible";
}
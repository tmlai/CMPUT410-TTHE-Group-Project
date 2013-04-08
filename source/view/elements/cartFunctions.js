/*
 * Add a product to the user's cart.
 */
function addProdToCart(pid) {
  alert("debug: add prod to cart");
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
      updateCartProductQty(pid, xmlhttp.responseText);
      var cartBool = confirm("Product has been added to cart. Would you like to"
        + " go to view the cart?");
      if(cartBool) {
        var dir = location.href;
        dir = dir.substr(0, dir.lastIndexOf("/") + 1);
        dir = dir + "cart.php";
        window.location.href = dir;
      } 
    }
  };
  
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
};

/*
 * Add quantity of a product.
 * Note: JSON format of cart: [{"pid":"value","quantity":"#"},...]
 * Default qty is 1. When greater than 1, the quantity is the total not
 * to increment quantity.
 * @return  true/false on availability of quantity of a product.
 */
function updateCartProductQty(pid, jsonArray, qty = 1) {
  alert("debug: updating cart");
  var jsonArray = JSON.parse(jsonArray);
  var cartJson = JSON.parse(readCookie('cart'));
  // For quantity used from other stores.
  var qtyExternal = 0;
  
  // Check if cart cookie exists
  if(cartJson != null){
      if(jsonArray.quantity < qty) {
        
        // Check external stores for remaining quantity
        qtyExternal = checkExternalAvail(pid, qty - jsonArray.quantity);
        var qtyAvail = qtyExternal + jsonArray.quantity;
        if(qytAvail < qty) {
          var qtyBool = confirm("Only " + qtyAvail + " of this product(" + pid 
            + ") is available, " + (qty - qtyAvail) + " are on backorder, "
            + "would you like to purchase the " + qtyAvail + " available at this"
            + " time?");
          if(qtyBool) {
            qty = qtyAvail;
          } else {
            alert("Sorry we did not have the quantity you requested, please take"
              + " a look at our Top Ranked Related Products for other options.");
            return false;
          }
        }
      }
      alert("Debug: 0");
      // Add pid entry with quantity to cart.
      var index = getCartIndex(pid);
      alert("DEBUG: cart index = " + index);
      if(index == -1) index = cartJson.length;
      cartJson[index] = getJsonCartElement(pid, qty);
  } else {
    alert("Debug: 1");
    // Create cart and store this product id.
    cartJson = new Array(getJsonCartElement(pid, qty));
  }
  // Update the cart
  cartJson = JSON.stringify(cartJson);
  createCookie('cart', cartJson, 0);
  alert("Debug: 2");
  alert("json: " + JSON.parse(readCookie('cart')) + "\nnonjson: " + readCookie('cart'));
  return true;
}

/*
 * Return index of json object in cart json array.
 * @param   pid //productId
 * @return  >= 0 value of index, -1 if not found
 */
function getCartIndex(pid) {
  var cartJson = JSON.parse(readCookie('cart'));
  for(var i = 0; i < cartJson.length; i++) {
    var element = cartJson[i];
    alert("DEBUG: "+ element.pid + " = " + pid);
    if(element.pid == pid)
      return i;
  }
  return -1;
}

/*
 * Get JSON element of a cart product entry.
 * @return  {"pid":"value","quantity":"#"}
 */
function getJsonCartElement(pid, qty) {
  var arr = {};
  arr['pid'] = pid;
  arr['quantity'] = qty;
  //arr = JSON.stringify(arr);
  return(arr);

}

/* 
 * Search external stores for pid of a given quantity.
 * default qty is 1.
 * Return bool of condition of quantity available.
 */
function getExternalAvail(pid, qty = 1) {
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
    var response = xmlhttp.responseText;
    
      if(xmlhttp.responseText == "true") {
        return true;
      }
      return false;
    }
  };
  
  xmlhttp.open('GET', '../model/ProductExternalAvailability.php?cid=' + pid + '&quantity='
    + qty, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

function sendPurchase(user) {
  alert("Debug: open order page, then on that page see order and confirm purchase...");
}

function updateCart() {
  var jsonCart = JSON.parse(readCookie('cart'));
  for(var i = 0; i < jsonCart.length; i++) {
    var value = jsonCartdocument.getElementById("qtyField" + jsonCart[i].pid).value;
    // Delete item from cart
    if(value == 0) {
      jsonCart[i] = "";
    } else {
      jsonCart[i].quantity = value;
    }
  }
  // Update the cart cookie
  cartJson = JSON.stringify(cartJson);
  createCookie('cart', cartJson, 0);
  // Update the cart viewed on cart.php
  buildCartProducts();
}

/*
 * Build and write the html for the Cart Products.
 * @param products array
 */ 
function buildCartProducts() {
  var div = document.getElementById("resultsDiv");
  var jsonCart = JSON.parse(readCookie('cart'));
  //var product;
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
        //console.log(JSON.parse(getOneProduct(jsonCart[i]['pid'])));
        //console.log(getOneProduct(jsonCart[i]['pid']));
        var product = JSON.parse(xmlhttp.responseText);
        document.write(
          "<tr>\n<td>\n"
          // Quantity text field for product
          + "<input type=\"text\" name=\"qtyField" + product.id + 
          + "\" id=\"qtyField" + product.id + "\" value=\"" 
          + product.quantity +">"
          // Rank/index of product
          + "<td>" + (i + 1) + "</td>\n"
          + "<td>\n"
          // Thumbnail of product
          + " <img src='/img/products/" + product['id'] + ".jpg\'" 
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
     
     }
    };
    xmlhttp.open('GET', '../controller/ProductServices.php?id=' + jsonCart[i]['pid'], false);
    xmlhttp.send();
    
  }
}
/*
 * Add a product to the user's cart.
 */
function addProdToCart(pid) {
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
      var cartCheck = updateCartProductQty(pid, xmlhttp.responseText);
      if(cartCheck != false) {
        var cartBool = confirm("Product is in your cart. Would you like to"
          + " to view the cart?");
        if(cartBool) {
          var dir = location.href;
          dir = dir.substr(0, dir.lastIndexOf("/") + 1);
          dir = dir + "cart.php";
          window.location.href = dir;
        } 
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
  var jsonArray = JSON.parse(jsonArray);
  var cartJson = JSON.parse(readCookie('cart'));
  
  // Check if cart cookie exists
  if(cartJson != null){
      if(jsonArray.quantity < qty) {
        if(getExternalAvail(pid, qty - jsonArray.quantity) == false) {
          alert("Sorry we did not have the quantity you requested, please take"
            + " a look at our Top Ranked Related Products for other options.");
          return false;
        }
      }
      // Add pid entry with quantity to cart.
      var index = getCartIndex(pid);
      if(index == -1) index = cartJson.length;
      cartJson[index] = getJsonCartElement(pid, qty);
  } else {
    // Create cart and store this product id.
    cartJson = new Array(getJsonCartElement(pid, qty));
  }
  // Update the cart
  cartJson = JSON.stringify(cartJson);
  createCookie('cart', cartJson, 0);
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
      response = response.trim();
      if(response != "False") {
        return true;
      } else {
        return false;
      }
    }
  };
  
  xmlhttp.open('GET', '../model/ProductExternalAvailability.php?cid=' + pid + '&quantity='
    + qty, false);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

function updateCart() {
  var jsonCart = JSON.parse(readCookie('cart'));
  for(var i = 0; i < jsonCart.length; i++) {
    var id = "qtyField" + jsonCart[i].pid;
    var val = document.getElementById(id).value;
    // Delete item from cart
    if(val == 0) {
      jsonCart.splice(i, 1);
    } else {
      jsonCart[i].quantity = val;
    }
  }
  // Update the cart cookie
  jsonCart = JSON.stringify(jsonCart);
  createCookie('cart', jsonCart, 0);
  // Update the cart viewed on cart.php
  buildCartProducts();
}

/*
 * Build and write the html for the Cart Products.
 * @param products array
 */ 
function buildCartProducts() {
  var jsonCart = JSON.parse(readCookie('cart'));
  var emptyCount = 0;
  var price = 0;
  // reset div for products
  document.getElementById("productsBody").innerHTML = " ";
  // If no cart exists
  if(jsonCart == null) {
    document.getElementById("resultsDiv").innerHTML = "<h4>Cart is empty.</h4>";
    document.getElementById("loadingSpinner").style.visibility = "hidden";
    document.getElementById("loadingSpinner").innerHTML = "<br>";
    setButtonsVisiblity("hidden", new Array("updateButton", "submitButton"));
    return false;
  }
  
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
        try{
          if(xmlhttp.responseText == "") {
           throw "err"; 
          }
          var product = JSON.parse(xmlhttp.responseText);
          document.getElementById("productsBody").innerHTML += (
            "<tr>\n<td>\n"
            // Quantity text field for product
            + "<input type=\"text\" name=\"qtyField" + product.id
            + "\" id=\"qtyField" + product.id + "\" value=\"" 
            + jsonCart[i].quantity + "\" class=\"input-mini\"></td>"
            + "<td " + getProdLink(product['id']) + ">\n"
            // Thumbnail of product
            + " <img src='/img/products/" + product['id'] + ".jpg\'" 
            + "\" alt=\"\" width=\"50\" height=\"50\">\n"
            + "</td>\n"
            // Price of product
            + "<td " + getProdLink(product['id']) + ">$" 
            + product['price'] + "</td>\n"
            // Weight of product
            + "<td " + getProdLink(product['id']) + ">" 
            + product['weight'] + "</td>\n"
            // Name of product
            + "<td " + getProdLink(product['id']) + ">" + product['name'] + "</td>\n"
            // Code of product
            + "<td " + getProdLink(product['id']) + ">" + product['id'] + "</td>\n"
            // Description of product
            + "<td " + getProdLink(product['id']) + ">" + product['desc'].substring(0, 35) + "...</td>\n"
            + "<td>\n"
            + " <button " + getProdLink(product['id']) + "style=\"position:relative; right:0px;\"\n"
            + "   class=\"btn pull-right\">\n"
            + "       View Product\n"
            + "   </button>\n"
            + " </td>\n"
            + "</tr>\n"
          );     
          // Update the price value
          price += (jsonCart[i].quantity * product['price']);
        } catch(err) {
          document.getElementById("productsBody").innerHTML += 
            '<tr><td>No Information available.</td></tr>';
        }
     }
   
    };
    xmlhttp.open('GET', '../controller/ProductServices.php?id=' + jsonCart[i]['pid'], false);
    xmlhttp.send();
  }
  // Hide the spinner
  document.getElementById("loadingSpinner").style.visibility = "hidden";
  document.getElementById("loadingSpinner").innerHTML = "<br>";
  // Make buttons visible
  setButtonsVisiblity("visible", new Array("updateButton", "submitButton"));
  // Update price
  document.getElementById("priceCalc").innerHTML = "Total Price of Cart = $" 
    + parseFloat(price).toFixed(2);
  if(emptyCount == jsonCart.length) {
    // Hide the buttons
    setButtonsVisiblity("hidden", new Array("updateButton", "submitButton"));
    // Write to user that the cart is empty
    document.getElementById("resultsDiv").innerHTML = "<h4>Cart is empty.</h4>";
    // Hide the spinner
    document.getElementById("loadingSpinner").style.visibility = "hidden";
    document.getElementById("loadingSpinner").innerHTML = "<br>";
  }
}

/*
 * Set an array of buttons to the visibility style of val.
 */
function setButtonsVisiblity(val, buttons) {
  for(var i = 0; i < buttons.length; i++) {
    document.getElementById(buttons[i]).style.visibility = val;
  }
}

/*
 * Return string of javascript link to a product
 */
function getProdLink(pid) {
  return "onclick=\"location.href='./product.php?id=" + pid + "'\"";
}

/*
 * Check if user signed in, if so go to confirm purchase order page.
 */
function submitCart(user) {
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
    updateCart();
    var jsonCart = JSON.parse(readCookie('cart'));
    if(jsonCart == null) {
      alert("You must have at least one product in order to make a purchase.");
      return false;
    }
    var dir = location.href;
    dir = dir.substr(0, dir.lastIndexOf("/") + 1);
    dir = dir + "confirmorder.php";
    window.location.href = dir;
  }
}
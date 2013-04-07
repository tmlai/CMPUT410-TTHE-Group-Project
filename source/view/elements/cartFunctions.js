/*
 * Add a product to the user's cart.
 */
function addProdToCart(pid) {
  alert("updating product to cart...");
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
    }
  };
  
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
};

/*
 * Add quantity of a product.
 * Note: JSON format of cart: {"pid":["quantity", "from external store quantity"]}
 * Default qty is 1. When greater than 1, the quantity is the total not
 * to increment quantity.
 * @return  true/false on availability of quantity of a product.
 */
function updateCartProductQty(pid, jsonArray, qty = 1) {
  alert("debug: checking stock");
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
      // Add pid entry with quantity to cart.
        cartJson[0][pid] = new Array(qty, qtyExternal);
      // if(jsonArray.quantity >= qtyNew) {
        // update the quantity.
        // cartJson[0][pid] = new Array(qty, qtyExternal);
        // jsonArray.quantity -= qtyNew;
      // } else {
        // Check other stores for remaining quantity.
        // var qtyRem = qty - jsonArray.quantity;
        // checkExternalAvail(pid, qtyRem);
      // }
  } else {
    // Create cart and store this product id.
    cartJson = '{"' + pid + '":"' + new Array(qty, qtyExternal) + '"}';
  }
  // Update the cart
  cartJson = JSON.stringify(cartJson);
  createCookie('cart', cartJson, 0);
  return true;
}

/* 
 * Search external stores for pid of a given quantity.
 * default qty is 1.
 * Return quantity of availability.
 */
function getExternalAvail(pid, qty = 1) {
  // DEBUG: to be implemented
  alert("debug: Checking other stores...");
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
      //DEBUG: TODO when dblayer has necessary function
    }
  };
  
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
  
  return 1;
}
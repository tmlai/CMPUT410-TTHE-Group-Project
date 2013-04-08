/*
 * Make the AJAX calls for a products availability and recommended related 
 * products.
 */
function loadProductAJAX(pid, category) {
  checkInStock(pid);
  getRelatedProducts(category);
}

/*
 * Check if product is available (quantity > 0).
 * @return  true/false if available
 */
function checkInStock(pid) {
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
      var jsonArray = JSON.parse(xmlhttp.responseText);
      var orderBtn = document.getElementById("orderBtn");
      orderBtn.style.visibility= "visible";
      if((jsonArray.quantity + getExternalAvail(pid)) <= 0) {
        orderBtn.className = "btn btn-danger";
        orderBtn.innerHTML ="Out of Stock";
      }
      document.getElementById("stockDiv").innerHTML = "";
    }
  };
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

/*
 * Adds five of the Top Ranked Related Products of a category to product.php
 */
 function getRelatedProducts(category) {
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
      jsonArray = JSON.parse(xmlhttp.responseText);
      //var jsonArray = xmlhttp.responseText;
      // DEBUG: need to be json to use buildRelatedProducts
      //buildRelatedProducts(jsonArray);
      // DEBUG: temporary, see two lines above
      document.getElementById("resultsDiv").innerHTML = "DEBUG: code returned: <br>\n" + jsonArray;
    }
  };
  xmlhttp.open('GET', '../model/Recommender/TopProduct.php?category=' + category 
    + category, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

/*
 * Build and write the html for the Top Ranked Related Products.
 * @param products array
 */ 
function buildRelatedProducts(products) {
  var div = document.getElementById("resultsDiv");
  for(i = 0; i < products.length; i++) {
    div.write(
      "<tr onclick=\"location.href='./product.php?id='" + products[i]['id']
      + "\">\n"
      // Rank/index of product
      + "<td>" + (i + 1) + "</td>\n"
      + "<td>\n"
      // Thumbnail of product
      + " <img src='/img/products/" + products[i]['id'] + ".jpg\'" 
      + "\" alt=\"\" width=\"50\" height=\"50\">\n"
      + "</td>\n"
      // Price of product
      + "<td>$" + products[i]['price'] + "</td>\n"
      // Weight of product
      + "<td>" + products[i]['weight'] + "</td>\n"
      // Name of product
      + "<td>" + products[i]['name'] + "</td>\n"
      // Code of product
      + "<td>" + products[i]['id'] + "</td>\n"
      // Description of product
      + "<td>" + products[i]['desc'].substring(0, 35) + "...</td>\n"
      + "<td>\n"
      + " <button id=\"p1\" style=\"position:relative; right:0px;\"\n"
      + "   class=\"btn pull-right\">\n"
      + "       View Product\n"
      + "   </button>\n"
      + " </td>\n"
      + "</tr>\n"
    );
  }
}

function rateProduct(pid, value) {
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
      jsonArray = JSON.parse(xmlhttp.responseText);
      if(jsonArray.status == "ok") {
        alert("Thank you for rating our products, we value your support!");
        document.location.reload(true);
      } else {
        alert("Server session timed out, please sign in again to rate a product.");
      }
     }
  };
  xmlhttp.open('POST', '../model/Recommender/RateProduct.php?productID=' + pid 
    + '&rating=' + value, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}
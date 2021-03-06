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
      try{
        var jsonArray = JSON.parse(xmlhttp.responseText);
        var orderBtn = document.getElementById("orderBtn");
        if(getExternalAvail(pid) == false) {
          orderBtn.className = "btn btn-danger";
          orderBtn.innerHTML ="Out of Stock";
        }
        document.getElementById("stockDiv").innerHTML = "";
        orderBtn.style.visibility= "visible";
      } catch (err) {
        orderBtn.className = "btn btn-danger";
        orderBtn.innerHTML ="Out of Stock";
      }
    }
  };
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
  orderBtn.style.visibility= "hidden";
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
      var jsonArray = JSON.parse(xmlhttp.responseText);
      // var jsonArray = xmlhttp.responseText;
      buildRelatedProducts(jsonArray);
    }
  };
  xmlhttp.open('GET', '../model/Recommender/RateProduct.php?category='
    + category, true);
  //xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}

/*
 * Build and write the html for the Top Ranked Related Products.
 * @param products array
 */ 
function buildRelatedProducts(products) {
  for(var i = 0; i < products.length; i++) {
    document.getElementById("resultsDiv").innerHTML += (
      "<tr onclick=\"location.href='./product.php?id=" + products[i]['cid']
      + "'\">\n"
      // Rank/index of product
      + "<td>" + (i + 1) + "</td>\n"
      + "<td>\n"
      // Thumbnail of product
      + " <img src='/img/products/" + products[i]['cid'] + ".jpg\'" 
      + "\" alt=\"\" width=\"50\" height=\"50\">\n"
      + "</td>\n"
      // Price of product
      + "<td>$" + products[i]['price'] + "</td>\n"
      // Weight of product
      + "<td>" + products[i]['weight'] + "</td>\n"
      // Name of product
      + "<td>" + products[i]['name'] + "</td>\n"
      // Code of product
      + "<td>" + products[i]['cid'] + "</td>\n"
      // Description of product
      + "<td>" + products[i]['description'].substring(0, 35) + "...</td>\n"
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

function rateProduct(pid, user, value) {
  if(user == null || user == "") {
    alert("You must be signed in to rate a product.");
  } else {
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
        if(jsonArray.status == "Ok") {
          alert("Thank you for rating our products, we value your support!");
          document.location.reload(true);
        } else {
          alert("Server session timed out, please sign in again to rate a product.");
        }
       }
    };
    var params = 'productId=' + pid  + '&rating=' + value;
    xmlhttp.open('POST', '../model/Recommender/RateProduct.php', true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(params);
  }
}

/*
 * AJAX call for one product info
 */
 function getOneProduct(pid) {
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
      //var jsonObj = JSON.parse(xmlhttp.responseText);
      //alert("cart DEBUG: getting one product: " + jsonObj[1]);
      //console.log(jsonObj);
      //var jsonArray = xmlhttp.responseText;
      return(xmlhttp.responseText);
    }
  };
  xmlhttp.open('GET', '../controller/ProductServices.php?id=' + pid, false);
  xmlhttp.send();
}

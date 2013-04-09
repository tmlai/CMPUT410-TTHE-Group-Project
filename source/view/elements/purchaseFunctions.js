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
  
   
  //document.getElementById("resultsDiv").innerHTML = getTableHTML();
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
        document.getElementById("productsBody").innerHTML += (
          "<tr>\n<td>\n"
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
        price += (jsonCart[i].quantity * product['price']);
     }
   
    };
    xmlhttp.open('GET', '../controller/ProductServices.php?id=' + jsonCart[i]['pid'], false);
    xmlhttp.send();
  }
  //document.getElementById("resultsDiv").innerHTML += getTableHTML("tail");
  document.getElementById("priceCalc").innerHTML = "Total Price of Cart = $" 
    + price;
  if(emptyCount == jsonCart.length)
    document.getElementById("resultsDiv").innerHTML = "<h4>Cart is empty.</h4>";
}

function submitOrder() {
  var jsonCart = JSON.parse(readCookie('cart'));
  if(jsonCart == null) {
    alert("You must have at least one product in order to make a purchase.");
    return false;
  }
  var dir = location.href;
  dir = dir.substr(0, dir.lastIndexOf("/") + 1);
  dir = dir + "index.php";
  window.location.href = dir;
}

function makePurchase() {
  var jsonCart = JSON.parse(readCookie('cart'));
  if(jsonCart == null) {
    alert("You must ha");
    return false;
  }
}
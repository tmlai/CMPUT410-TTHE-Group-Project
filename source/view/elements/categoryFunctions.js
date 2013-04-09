/*
 * Get the list of categories for navbar.
 */
function getMenuCategories() {
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
      buildCategoryDropList(jsonArray);
    }
  };
  xmlhttp.open('GET', '/source/controller/CategoryServices.php?catList', true);
  xmlhttp.send();
}

function getCarouselProds() {
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
      buildCarouselItems(jsonArray);
    }
  };
  xmlhttp.open('GET', '../model/Recommender/TopProduct.php?numProduct=3', true);
  xmlhttp.send();
}

function buildCategoryDropList(cats) {
  for(var i = 0; i < cats.length; i++) {
    document.getElementById("navCatList").innerHTML += (
      '<li><a href="category.php?' + cats[i]['cateId'] + '">' 
      + cats[i]['name'] + '</a></li>'
    );
  }
}

function buildCarouselItems(prods) {
  for(var i = 0; i < prods.length; i++) {
    var product = prods[i];
    if(i == 0) {
      document.getElementById("carouselItemDiv").innerHTML = '<div class="item active">';
    } else {
      document.getElementById("carouselItemDiv").innerHTML += '<div class="item">';
    }
    document.getElementById("carouselItemDiv").innerHTML += (
      '<a href="./product.php?id=' + product['cid'] + '">\n'
      + '<img src=".../img/products/' + product['cid'] + '.jpg" alt="">\n'
      + '<div class="container">\n'
      + '  <div class="carousel-caption">\n'
      + '    <h1>Welcome</h1>\n'
      + '    <p class="lead">Browse through our many products.</p>\n'
      + '    <p>' + product['description'] + '</p>\n'
      + '    <a class="btn btn-large btn-primary" href="#">See Product Details</a>\n'
      + '  </div>\n'
      + '</div>\n'
      + '</a>\n'
      + '</div>\n'
    );
  }
}


/*
 * Get category products of a specific category id.
 */
 function getCategoryProducts(cateId) {
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
  xmlhttp.open('GET', '/source/controller/CategoryServices.php?catProds='
    + cateId, true);
  xmlhttp.send();
}

/*
 * Build and write the html for the Top Ranked Related Products.
 * @param products array
 */ 
function buildCategoryProductList(products) {
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

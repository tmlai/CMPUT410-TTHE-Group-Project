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

/*
 * Get the list of categories for navbar.
 */
function getCategoriesContainer() {
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
      buildCategoryContainer(jsonArray);
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
  xmlhttp.open('GET', '../model/Recommender/TopProduct.php?numProduct=5', true);
  xmlhttp.send();
}

function buildCategoryDropList(cats) {
  for(var i = 0; i < cats.length; i++) {
    document.getElementById("navCatList").innerHTML += (
      '<li><a href="category.php?cateId=' + cats[i]['cateId'] + '">' 
      + cats[i]['name'] + '</a></li>'
    );
  }
}

function buildCategoryContainer(cats) {
  var htmlCats = "";
  for(var i = 0; i < cats.length; i++) {
    var rowBool = ((i % 3) == 0);
    // end and create new row
    if(rowBool && (i > 0) && (i < cats.length)) {
      htmlCats += ('</div>\n<div class="row-fluid">');
    } else if(i == 0) {
      // create new row to start
      htmlCats = ('<div class="row-fluid">');
    }
    htmlCats += (
      '<div class="span4">'
      + '      <h2>' + cats[i]['name'] + '</h2>\n'
      + '      <p>' + cats[i]['description'] + '</p>\n'
      + '      <p><a class="btn" href="category.php?cateId=' + cats[i]['cateId']
      + '">View details &raquo;</a></p>\n'
      + '</div>\n'
    );
  }
  // end last row
  htmlCats += '</div>';
  document.getElementById("categoryContainerDiv").innerHTML = htmlCats;
  
}

function buildCarouselItems(prods) {
  var catHTML = '<div id="myCarousel" class="carousel slide" data-interval="2000">\n';
  catHTML +=  '<div class="carousel-inner" id="carouselItemDiv" data-interval="2000">\n';
  for(var i = 0; i < prods.length; i++) {
    var product = prods[i];
    if(i == 0) {
      catHTML += '<div class="item active">\n';
    } else {
      catHTML += '<div class="item">\n';
    }
    catHTML += (
      '<a href="./product.php?id=' + product['cid'] + '">\n'
      + '<img src="/img/products/' + product['cid'] + '.jpg" alt="">\n'
      + '<div class="container">\n'
      + '  <div class="carousel-caption">\n'
      + '    <h1>Welcome to Our Store</h1>\n'
      + '    <p class="lead">Browse through our many products.</p>\n'
      + '    <p>' + product['description'] + '</p>\n'
      + '    <a class="btn btn-large btn-primary" href="./product.php?id='
      + product['cid'] + '">See Product Details</a>\n'
      + '  </div>\n'
      + '</div>\n'
      + '</a>\n'
      + '</div>\n'
    );
  }
  catHTML += '</div>\n'
    + '<a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>\n'
    + '<a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>\n'
    + '<div class="carousel-bkg">\n'
    + '<img class="bkg" src="/source/view/bootstrap/img/tthe_carousel.jpg" alt="">\n'
    + '</div></div>\n'
  document.getElementById("carouselElement").innerHTML = catHTML;
  document.getElementById("carouselElement").focus();
}


/*
 * Get category products of a specific category id.
 */
 function getCategoryProducts(cateId) {
  if(cateId == null || cateId == "") {
    document.getElementById("resultsDiv").innerHTML = 
      "<h4>No products in this category.</h4>";
    return false;
  }
  writeCateInfo(cateId);
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
      buildCatProducts(jsonArray);
    }
  };
  xmlhttp.open('GET', '/source/controller/CategoryServices.php?catProds='
    + cateId, true);
  xmlhttp.send();
}


/*
 * Place the name and description of a category in the category.php page.
 */
function writeCateInfo(cateId) {
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
      var cateInfo = JSON.parse(xmlhttp.responseText);
      document.getElementById("catHero").innerHTML = '<h1>' + cateInfo['name'] 
        + '</h1>\n' + '<p>' + cateInfo['description'] + '</p>';
    }
  };
  xmlhttp.open('GET', '/source/controller/CategoryServices.php?cateId='
    + cateId, true);
  xmlhttp.send();
  
}

function getProdLink(pid) {
  return "onclick=\"location.href='./product.php?id=" + pid + "'\"";
}


/*
 * Build and write the html for the Category Products.
 * @param products array
 */ 
function buildCatProducts(jsonArray) {
  for(var i = 0; i < jsonArray.length; i++) {
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
            "<tr " + getProdLink(product['id']) + ">\n<td>\n"
            // Thumbnail of product
            + " <img src='/img/products/" + product['id'] + ".jpg\'" 
            + "\" alt=\"\" width=\"50\" height=\"50\">\n"
            + "</td>\n"
            // Price of product
            + "<td>$" 
            + product['price'] + "</td>\n"
            // Weight of product
            + "<td>" 
            + product['weight'] + "</td>\n"
            // Name of product
            + "<td>" + product['name'] + "</td>\n"
            // Code of product
            + "<td>" + product['id'] + "</td>\n"
            // Description of product
            + "<td>" 
            + product['desc'].substring(0, 35) + "...</td>\n"
            + "<td>\n"
            + " <button style=\"position:relative; right:0px;\"\n"
            + "   class=\"btn pull-right\">\n"
            + "       View Product\n"
            + "   </button>\n"
            + " </td>\n"
            + "</tr>\n"
          );     
        } catch(err) {
          document.getElementById("productsBody").innerHTML += 
            '<tr><td>No Information available.</td></tr>';
        }
     }
   
    };
    xmlhttp.open('GET', '../controller/ProductServices.php?id=' + jsonArray[i]['cid'], false);
    xmlhttp.send();
  }
  if(jsonArray.length == 0) {
    document.getElementById("resultsDiv").innerHTML = 
      "<h4>No products in this category. Please browse our other categories.</h4>";
  }
  document.getElementById("loadingSpinner").style.visibility = "hidden";
  document.getElementById("loadingSpinner").innerHTML = "<br>";
}

<?php 
namespace view;
session_start();
$_SESSION['productID'] = $_GET['id'];
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
// get the product name given the product id
use model\DbLayer;

include_once '../model/DbLayer.php';
$id = $_SESSION['productID'];
$dbLayer = new DbLayer();
$product = $product = $dbLayer->getOneProduct($id);
$product = json_decode($product, true);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
    <link href="elements/rateit/src/rateit.css" rel="stylesheet">
    <script type="text/javascript" language="JavaScript" 
      src="./elements/cartFunctions.js"></script>
    <script type="text/javascript" language="JavaScript" >
      
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
    document.getElementById("stockDiv").innerHTML = "readyState = " + xmlhttp.readyState;
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      alert("call came back!");
      //var jsonArray = JSON.parse(xmlhttp.responseText);
      document.getElementById("stockDiv").innerHTML = xmlhttp.responseText;
      var orderBtn = document.getElementsByName("orderBtn");
      orderBtn.style.visibility="visible";
      if((jsonArray.quantity + getExternalAvail(pid)) == 0) {
        //document.getElementById("stockDiv").innerHTML = "(In Stock)";
      //} else {
        document.getElementById("stockDiv").innerHTML = "(Out of Stock)";
        orderBtn.className="btn btn-danger";
        orderBtn.innerHTML="Out of Stock";
      } else {
        document.getElementById("stockDiv").innerHTML = "";
      }
    }
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, 'true');
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send();
}
    </script>
  </head>
  <body onLoad="checkInStock(<?php echo "'" . $_SESSION['productID'] . "'";?>);">
    <?php
      // Navigation Bar
      if($_SESSION['user'] != "") {
        // user dropdown
        require("./elements/navbar_user.php");
      } else {
        // sign in dropdown
        require("./elements/navbar_signin.php");
      }
    ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span9">
                <h1 id="productName">
                  <?php 
                    echo $product['name']
                  ?>
                </h1>
                <div id="prodInfoDiv">
                  <?php
                    echo $product['desc'];
                  ?>
                </div>
                <hr>
          <div class="row-fluid">
            <div id="ratedProdDiv" class="span9" 
                style="position:absolute; buttom:0;">
              <h3>Top Ranked Related Products:</h3>
              <table class="table table-hover">
                <thead>
                    <tr>
                        <th><!-- placeholder --></th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Availability</th>
                        <th>Weight</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                  <div id="resultsDiv">
                    <tr onclick="location.href='./product.php?id=1'">
                        <td>
                          <img src="" alt="" width="50" height="50">
                        </td>
                        <td>$1</td>
                        <td>1</td>
                        <td>1</td>
                        <td>1 kg</td>
                        <td>1name</td>
                        <td>c1</td>
                        <td>This is a description...</td>
                        <td>
                            <button id="p1" style="position:relative; right:0px;"
                            class="btn pull-right">
                                View Product
                            </button>
                        </td>
                    </tr>
                    <tr onclick="location.href='./product.php?id=2'">
                        <td>
                          <img src="" alt="" width="50" height="50">
                        </td>
                        <td>$2</td>
                        <td>2</td>
                        <td>2</td>
                        <td>2 kg</td>
                        <td>2name</td>
                        <td>c2</td>
                        <td>This is a description...</td>
                        <td>
                            <button id="p2" style="position:relative; right:0px;"
                            class="btn pull-right">
                                View Product
                            </button>
                        </td>
                    </tr>
                    <tr onclick="location.href='./product.php?id=3'">
                        <td>
                          <img src="" alt="" width="50" height="50">
                        </td>
                        <td>$3</td>
                        <td>3</td>
                        <td>3</td>
                        <td>3 kg</td>
                        <td>3name</td>
                        <td>c3</td>
                        <td>This is a description...</td>
                        <td>
                            <button id="p3" style="position:relative; right:0px;"
                            class="btn pull-right">
                                View Product
                            </button>
                        </td>
                    </tr>
                    <tr onclick="location.href='./product.php?id=4'">
                        <td>
                          <img src="" alt="" width="50" height="50">
                        </td>
                        <td>$4</td>
                        <td>4</td>
                        <td>4</td>
                        <td>4 kg</td>
                        <td>4name</td>
                        <td>c4</td>
                        <td>This is a description...</td>
                        <td>
                            <button id="p4" style="position:relative; right:0px;"
                            class="btn pull-right">
                                View Product
                            </button>
                        </td>
                    </tr>
                  </div>
                </tbody>
                </table>
              </div>
              </div>
            </div>
            <div class="span3">
                <ul class="thumbnails">
                  <li class="span10">
                    <div class="thumbnail">
					<?php
					  echo "<a href='/img/products/$id.jpg'><img src='/img/products/$id.jpg' alt='$id is missing'></a>";
					?>
                      <nobr>
                        <h4>Price: </h4>
                        <h3>$<?php echo $product['price']?></h3>
                      </nobr>
                      <h4>Rating: </h4>
                      <input type="range" step="0.25" id="backing4"
                        value="<?php 
                            // Get the current rating for default value.
                            if($product['rating'] == null) echo 0;
                            else echo $product['rating'];
                          ?>">
                      <div class="rateit" data-rateit-ispreset="true" 
                        data-rateit-backingfld="#backing4"
                        data-rateit-resetable="false"
                        data-rateit-min="0" data-rateit-max="5">
                      </div>
                      <div id="specDiv" class="well">
                        <p><strong>Weight:</strong> <?php echo $product['weight'];?></p>
                        <p><strong>Code:</strong> 
                          <?php echo $id?>
                        </p>
                      </div>
                      <button name="orderBtn" type="submit" class="btn btn-success" 
                          onclick="addProdToCart(<?php 
                            echo "'" . $_SESSION['productID'] . "'";
                          ?>);" style="visibility:hidden">
                        Order Product</button>
                        <div id="stockDiv">
                          <img src="./elements/img/spinner_small.gif" alt="" 
                            width="50" height="50">
                            <p class="muted">Checking Availability..</p>
                        </div>
                    </div>                    
                  </li>
                </ul>
            </div>
        </div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="elements/rateit/src/jquery.rateit.js"></script>
    <script src="elements/rateit/src/jquery.rateit.min.js"></script>
  </body>
</html>
<?php 
namespace view;
session_start();
$_SESSION['productID'] = $_GET['id'];
// get the product name given the product id
use model\DbLayer;

include_once '../model/DbLayer.php';
$id = $_GET['id'];
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
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
    <script type="text/javascript" language="JavaScript">
    // <!--
    // function getProductInfo() {
      // // Add entry to Catalog.
      // var xmlhttp = new XMLHttpRequest();
      // if (window.XMLHttpRequest)
      // {// code for IE7+, Firefox, Chrome, Opera, Safari
        // xmlhttp=new XMLHttpRequest();
      // }
      // else
      // {// code for IE6, IE5
        // xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      // }
      
      // // Load/Reload catalog after adding entry
      // xmlhttp.onreadystatechange=function() {
        // if (xmlhttp.readyState==4 && xmlhttp.status==200) {
          // var jsonObj = JSON.parse(xmlhttp.responseText);
          // // Reset catalogBool for reloading catalog
          // document.getElementById("prodInfoDiv").innerHTML=jsonObj;
          
        // }
      // }
      
      // xmlhttp.open("GET","/api/items.php?id=" + 
        // <?php echo $_SESSION['productID']; ?>, 
        // true);
      // //xmlhttp.setRequestHeader("Content-type", "/api/items");
      // //xmlhttp.setRequestHeader("Content-length", entry.length);
      // xmlhttp.send(entry);
    // }
  // -->
  </script>
  </head>
  <!-- <body onLoad="getProductInfo();">   -->
  <body>
    <?php
        // Navigation Bar
        require($DOCUMENT_ROOT . "./elements/navbar.php");
    ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span10">
                <h1 id="productName">Product Name</h1>
                <div id="prodInfoDiv">
                  <p id="productDescription">Product information</p>
				  <?php
					echo $product['desc'];
				  ?>
                </div>
            </div>
            <div class="span2">
                <ul class="thumbnails">
                  <li class="span10">
                    <div class="thumbnail">
					<?php
					  echo "<img src='/img/products/$id.jpg' alt='$id is missing'>";
					?>
                      <!--<img data-src="holder.js/300x200" alt="">-->
                      <!--<p class="muted">an image will go here...</p><br>-->
                      <h4>Availability</h4>
                      <p>Stores: </p>
                      <h4>Rating: </h4>
                      <div id="specDiv" class="well">
                        <p><strong>Weight:</strong> <?php echo $product['weight'];?></p>
                        <p><strong>Code:</strong> 
                          <?php echo $id?>
                        </p>
                      </div>
                      <button type="submit" class="btn btn-success">
                        Order Product</button>
                    </div>                    
                  </li>
                </ul>
                <!--
                <div class="well">
                    <p>Sidebar</p>
                </div>-->
            </div>
        </div>
    </div> <!-- /container -->
    <hr>
    <div class="container">
        <h3>Related Products:</h3>
        <div class="row-fluid">
            <div class="span4">
              <h4>Heading</h4>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h4>Heading</h4>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
            <div class="span4">
              <h4>Heading</h4>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn" href="#">View details &raquo;</a></p>
            </div><!--/span-->
        </div><!--/row-->
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
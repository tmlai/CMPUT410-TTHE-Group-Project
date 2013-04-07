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
    <script type="text/javascript" language="JavaScript" 
      src="./elements/productFunctions.js"></script>
  </head>
  <body onLoad="loadProductAJAX(<?php 
      echo "'" . $_SESSION['productID'] . "', ";
      echo "'" . $product['category'] . "'";
    ?>);">
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
                <!-- two break lines for extra spacing -->
                <br><br>
                <hr>
                </div>
                <div class="row-fluid">
                  <div id="ratedProdDiv" class="span9" 
                      style="position:absolute; buttom:0;">
                    <h3>Top Ranked Related Products:</h3>
                    <table class="table table-hover">
                      <thead>
                          <tr>
                              <th><!-- placeholder for rank --></th>
                              <th><!-- placeholder for thumbnail --></th>
                              <th>Price</th>
                              <th>Weight</th>
                              <th>Name</th>
                              <th>Code</th>
                              <th>Description</th>
                          </tr>
                      </thead>
                      <tbody>
                        <div id="resultsDiv">
                          
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
                      <h4>Price: </h4>
                      <h3>$<?php echo $product['price']?></h3>
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
                      <button id="orderBtn" type="submit" class="btn btn-success" 
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
        </div>
      </div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="elements/rateit/src/jquery.rateit.js"></script>
    <script src="elements/rateit/src/jquery.rateit.min.js"></script>
  </body>
</html>
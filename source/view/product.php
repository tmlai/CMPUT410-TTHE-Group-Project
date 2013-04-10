<?php 
//namespace view;
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
$img = trim($product['img']);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Product</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
    <link href="elements/rateit/src/rateit.css" rel="stylesheet">
    <script type="text/javascript" language="JavaScript" 
      src="./elements/cartFunctions.js"></script>
    <script type="text/javascript" language="JavaScript" 
      src="./elements/productFunctions.js"></script>
    <script src="elements/jquery-1.9.1.min.js"></script>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="elements/rateit/src/jquery.rateit.js"></script>
    <script src="elements/rateit/src/jquery.rateit.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>
  <body onLoad="loadProductAJAX(<?php 
      echo "'" . $_SESSION['productID'] . "', ";
      echo "'" . $product['cateId'] . "'";
    ?>); getMenuCategories();">
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
        <div class="span12">
            <div class="span9">
                <h1 id="productName">
                  <?php 
                    echo $product['name']
                  ?>
                </h1>
                <!--<div id="prodInfoDiv">-->
                  <?php
                    echo $product['desc'];
                  ?>
                <hr>
                <div class="row-fluid">
                  <div class="span12">
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
                      <tbody id="resultsDiv">
                      </tbody>
                      </table>
                  
                  </div>
                  </div>
                  </div>
            <div class="rowfluid">
              <div class="span3">
                <ul class="thumbnails">
                  <li class="span10">
                    <div class="thumbnail">
					<?php
					  echo "<a href='/img/products/$img'><img src='/img/products/$img' alt='$img is missing'></a>";
					?>
                      <h4>Price: </h4>
                      <h3>$<?php echo $product['price']?></h3>
                      <h4>Rating: </h4>
                      <input type="range" step="0.25" id="backing4"
                        value="<?php 
                            // Get the current rating for default value.
                            if($product['rating'] == null) echo 0;
                            else echo $product['rating'];
                          ?>" onclick="rateProduct('<?php echo $product['id']?>');">
                      <div class="rateit" id="rateit5"data-rateit-ispreset="true" 
                        data-rateit-backingfld="#backing4"
                        data-rateit-resetable="false"
                        data-rateit-min="0" data-rateit-max="5">
                      </div>
                      <script type="text/javascript">
                      <!--
                        // learned from: http://www.radioactivethinking.com/rateit/example/example.htm
                        $("#rateit5").bind('rated', function (event, value) { 
                          rateProduct(
                            <?php echo "'" . $product['id'] . "', '" 
                              . $_SESSION['user'] . "'"
                              
                            ?>, value);
                        });
                      -->
                      </script>
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
                          <img src="./elements/img/spinner_small.gif" alt="">
                            <p class="muted">Checking Availability..</p>
                        </div>
                    </div>                    
                  </li>
                </ul>
                </div>
              <!--</div>-->
            <!--</div>-->
          </div>
        </div>
      </div>
    </div> <!-- /container -->    
  </body>
</html>
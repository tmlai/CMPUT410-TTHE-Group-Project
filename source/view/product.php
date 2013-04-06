<?php 
namespace view;
session_start();
$_SESSION['productID'] = $_GET['id'];
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
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
    <link href="elements/rateit/src/rateit.css" rel="stylesheet">
  </head>
  <body>
    <?php
      // Navigation Bar
      if($_SESSION['user'] != "") {
        // user dropdown
        require($DOCUMENT_ROOT . "./elements/navbar_user.php");
      } else {
        // sign in dropdown
        require($DOCUMENT_ROOT . "./elements/navbar_signin.php");
      }
    ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span10">
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
            </div>
            <div class="span2">
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
                        value="
                          <?php 
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
    <script src="elements/rateit/src/jquery.rateit.js"></script>
    <script src="elements/rateit/src/jquery.rateit.min.js"></script>
  </body>
</html>
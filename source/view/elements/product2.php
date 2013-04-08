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
        <div class="span8">
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
            <div id="ratedProdDiv" class="span8">
              <h3>Top Ranked Related Products:</h3>

              <div class="rowfluid">
                <div class="span4">
                  <ul class="thumbnails">
                    <li class="span10">
                      <div class="thumbnail">
                
                      </div>                    
                    </li>
                  </ul>
                <!--
                <div class="well">
                    <p>Sidebar</p>
                </div>-->
                </div>
              </div>
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
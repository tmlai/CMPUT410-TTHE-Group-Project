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
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
    <link href="elements/rateit/src/rateit.css" rel="stylesheet">
    <script type="text/javascript" language="JavaScript" 
      src="./elements/cartFunctions.js"></script>
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
            <div id="ratedProdDiv" class="span8" 
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
                    <!-- product code javascript function will return the product code
                    for the query of the database for creating product.php-->
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
            <div class="span4">
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
                      <button type="submit" class="btn btn-success" 
                          onclick="addProdToCart(<?php 
                            echo '\"' . $_SESSION['productID'] . '\"';
                          ?>);">
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
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="elements/rateit/src/jquery.rateit.js"></script>
    <script src="elements/rateit/src/jquery.rateit.min.js"></script>
  </body>
</html>
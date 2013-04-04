<?php 
session_start();
$_SESSION['productID'] = $_GET['id'];
// get the product name given the product id

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
  </head>
  <body>   
    <?php
        // Navigation Bar
        require($DOCUMENT_ROOT . "./elements/navbar.php");
    ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span10">
                <h1>Product Name</h1>
                <p>Product information</p>
            </div>
            <div class="span2">
                <ul class="thumbnails">
                  <li class="span10">
                    <div class="thumbnail">
                      <!--<img data-src="holder.js/300x200" alt="">-->
                      <p class="muted">an image will go here...</p><br>
                      <h4>Availability</h4>
                      <p>Stores: </p>
                      <h4>Rating: </h4>
                      <div id="specDiv" class="well">
                        <p><strong>Weight:</strong> 1kg</p>
                        <p><strong>Code:</strong> 
                          <?php echo $_SESSION['productID']?>
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
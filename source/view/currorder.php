<?php 
//namespace view;
session_start();
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Search Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        // Default Style links
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
  </head>
  <!--<body onLoad="buildOrderProducts()">  --> 
  <body onLoad="buildOrderProducts()">   
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
    <div class="container">
        <h3>Your Current Cart</h3>
        <div class="container" style="width:100%; height:300px; position:relative; 
        bottom:0px; overflow:auto;">
            <table class="table table-hover">
            <thead>
                <tr>
                  <th>Order Quantity</th>
                  <th><!-- placeholder --></th>
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
            <table bornder="0">
              <tr>
                <td align="left">
                  <button class="btn btn-info">Go Back to Cart</button>
                </td>
                <td align="right">
                  <button class="btn btn-success" onclick="sendPurchase()">
                  Checkout
                  </button>
                </td>
              </tr>
        </div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
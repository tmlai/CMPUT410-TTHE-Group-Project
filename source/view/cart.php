<?php 
//namespace view;
session_start();
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - View Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
    <script type="text/javascript" language="JavaScript" 
      src="./elements/productFunctions.js"></script>
    <script type="text/javascript" language="JavaScript" 
      src="./elements/cartFunctions.js"></script>
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
  </head>
  <body onLoad="buildCartProducts(); getMenuCategories();">
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
    <div class="container">
      <h3>Your Current Cart</h3>
      <!--<div class="container">-->
        <div id="resultsDiv">
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
            <tbody id="productsBody">
            </tbody>
          </table>
        </div>
        <hr>
        <div id="loadingSpinner" align="center" style="visibility:visible">
          <img src="./elements/img/spinner.gif" alt="...Loading...">
          <p class="muted">...Retrieving Cart Information...</p>
        </div>
        <div align="center">
        <table border="0" width="100%">
          <col align="left">
          <col align="center">
          <col align="right">
          <tr>
            <td>
              <button id="updateButton" class="btn btn-primary" type="submit" 
                onclick="updateCart();" style="visibility:visible">
                Update Cart
              </button>
            </td>
            <td id="priceCalc"></td>
            <td>
              <button class="btn btn-success" onclick="submitCart(<?php 
                echo "'" . $_SESSION['user'] . "'";
              ?>)" id="submitButton" style="visibility:visible">
              Checkout
              </button>
            </td>
          </tr>
        </table>
      </div>        
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
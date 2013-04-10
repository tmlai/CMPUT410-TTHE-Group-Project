<?php 
//namespace view;
session_start();
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Confirm Order</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" language="JavaScript" 
      src="./elements/productFunctions.js"></script>
    <script type="text/javascript" language="JavaScript" 
      src="./elements/purchaseFunctions.js"></script>
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
  </head>
  <body onLoad="buildInvoice(); getMenuCategories();">
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
            <table class="table"> 
            <thead>
                <tr>
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
        <div align="center" id="buttonsDiv">
        <table border="0" width="100%">
          <col align="left">
          <col align="center">
          <col align="right">
          <tr>
            <td align="left">
              <button class="btn btn-info" onclick="location.href='./cart.php'">
                Go Back to Cart</button>
            </td>
            <td id="priceCalc"></td>
            <td>
              <button class="btn btn-success" onclick="submitOrder(<?php 
                echo "'" . $_SESSION['user'] . "'";
              ?>)">
              Confirm Purchase
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
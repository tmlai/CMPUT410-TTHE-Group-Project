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
    <script type="text/javascript" language="JavaScript" 
      src="./elements/productFunctions.js"></script>
    <script type="text/javascript" language="JavaScript" 
      src="./elements/purchaseFunctions.js"></script>
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
  </head>
  <body onLoad="buildInvoice()">
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
      <form name="cartForm" onSubmit="updateCart();">
        <div id="resultsDiv">
          <form name="cartForm" onSubmit="updateCart();">
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
        <div align="center">
        <table border="0" width="100%">
          <col align="left">
          <col align="center">
          <col align="right">
          <tr>
            <td align="left">
              <button class="btn btn-info" onclick="location.href='./cart.php">
                Go Back to Cart</button>
            </td>
            <td id="priceCalc"></td>
            <td>
              <button class="btn btn-success" onclick="submitOrder()">
              Confirm Purchase
              </button>
            </td>
          </tr>
        </table>
        </div>
      </form>
        
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
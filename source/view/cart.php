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
    <script type="text/javascript" language="JavaScript" 
      src="./elements/productFunctions.js"></script>
    <script type="text/javascript" language="JavaScript" 
      src="./elements/cartFunctions.js"></script>
  </head>
  <body>   
  <!--<body onLoad="buildCartProducts()">--> 
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
        <div class="container">
            <form name="cartForm" onSubmit="updateCart();">
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
                <tr><img src="./elements/img/spinner.gif" alt="Loading..."></tr>
              </div>
            </tbody>
            </div>
            </table>
            <table border="0">
              <tr>
                <td align="left">
                  <button class="btn btn-primary" type="submit">Update Cart</button>
                </td>
                <td align="right">
                  <button class="btn btn-success" onclick="currorder.php">
                  Checkout
                  </button>
                </td>
              </tr>
            </form>
        
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
<?php 
namespace view;
session_start(); 
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Orders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
    <script type="text/javascript" language="JavaScript" 
      src="./elements/orderFunctions.js"></script>
  </head>
  <body onLoad="getMenuCategories(); getOutstandingOrders();">   
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
    <div class="container" id="ordersContainer">
      <div id="loadingSpinner" align="center" style="visibility:visible">
        <img src="./elements/img/spinner.gif" alt="...Loading...">
        <p class="muted">...Retrieving Orders...</p>
      </div>
    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
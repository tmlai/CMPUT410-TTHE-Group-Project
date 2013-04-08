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
      src="/elements/productFunctions.js"></script>
    <script type="text/javascript" language="JavaScript" 
      src="/elements/cartFunctions.js"></script>
    <?php
        // Default Style links
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
  </head>
  <body onLoad="buildCartProducts()">
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
      <!--<div class="container">-->
      <form name="cartForm" onSubmit="updateCart();">
        <div id="resultsDiv">
          <div align="center">
            <img src="./elements/img/spinner.gif" alt="Loading...">
          </div>
        </div>
        <div align="center">
        <table border="0" width="100%">
          <col align="left">
          <col align="right">
          <tr>
            <td>
              <button class="btn btn-primary" type="submit">Update Cart</button>
            </td>
            <td>
              <button class="btn btn-success" onclick="currorder.php">
              Checkout
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
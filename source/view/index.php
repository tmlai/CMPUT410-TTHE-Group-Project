<?php 
namespace view;
session_start(); 
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
    <link href="bootstrap/css/carousel.css" rel="stylesheet">
  </head>
  <body onLoad="getMenuCategories(); getCarouselProds();">   
    <?php
      // Navigation Bar
      if($_SESSION['user'] != "") {
        // user dropdown
        require("./elements/navbar_user.php");
      } else {
        // sign in dropdown
        require("./elements/navbar_signin.php");
      }
      // Carousel element
      require("./elements/carousel.php");
    ?>
    <div class="container" ide="categoryContainerDiv">
      <div id="loadingSpinner" align="center" style="visibility:visible">
            <img src="./elements/img/spinner.gif" alt="...Loading...">
      </div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
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
    <script src="elements/jquery-1.9.1.min.js"></script>
    <!-- Load the CloudCarousel JavaScript file -->
    <!--from: http://www.professorcloud.com/mainsite/carousel-integration.htm-->
    <script src="elements/cloud-carousel/cloud-carousel.1.0.5.js"></script>
    <script>
      $(document).ready(function(){
                     
        // This initialises carousels on the container elements specified, in this case, carousel1.
        $("#carousel1").CloudCarousel(		
          {
            /*reflHeight: 56,
            reflGap:2,
            xPos: 128,
            yPos: 32,
            buttonLeft: $("#left-but"),
            buttonRight: $("#right-but"),
            altBox: $("#alt-text"),
            titleBox: $("#title-text"),
            autoRotate: 'left',
            autoRotateDelay: 1200,
            speed:0.2*/
            xPos: 128,
            yPos: 32,
            buttonLeft: $("#left-but"),
            buttonRight: $("#right-but"),
            altBox: $("#alt-text"),
            titleBox: $("#title-text")
          }
        );
      });
</script>
  </head>
  <body onLoad="getMenuCategories(); getCategoriesContainer();" >   
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
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
          <!-- This is the container for the carousel. -->
          <div id = "carousel1" style="width:600px; height:395px;background:#000;overflow:scroll;">            
              <div id="title-text"></div>
              <div id="alt-text"></div>
              <!-- All images with class of "cloudcarousel" will be turned into carousel items -->
              <!-- You can place links around these images -->
              <img class = "cloudcarousel" src="/img/products/c000020.jpg" height="100" width="100" alt="Flag 1 Description" title="Flag 1 Title" />
              <img class = "cloudcarousel" src="/img/products/c000019.jpg" height="100" width="100" alt="Flag 2 Description" title="Flag 2 Title" />
              <img class = "cloudcarousel" src="/img/products/c000018.jpg" height="100" width="100" alt="Flag 3 Description" title="Flag 3 Title" />
              <img class = "cloudcarousel" src="/img/products/c000017.jpg" height="100" width="100" alt="Flag 4 Description" title="Flag 4 Title" />  
          
            <button id="left-but" class="carouselLeft" style="position:absolute;top:20px;right:64px;"></button>
            <button id="right-but" class="carouselRight" style="position:absolute;top:20px;right:20px;"></button>      
          </div>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12" id="categoryContainerDiv">
          <div id="loadingSpinner" align="center" style="visibility:visible">
              <img src="./elements/img/spinner.gif" alt="...Loading...">
          </div>
        </div>
      </div>
    </div>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
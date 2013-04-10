<?php 
namespace view;
session_start(); 
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];
$cateId = $_GET['cateId'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
    <?php
      // Default Style links
      require("./elements/head_includes.php");
    ?>
  </head>
  <body onLoad="getMenuCategories(); getCategoryProducts('<?php echo $cateId;?>');">   
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
        <div class="hero-unit" id="catHero">
            <h1>Category Name</h1>
            <p>This is a category description.</p>
        </div>
        <div class="container" id="resultsDiv">
          <table class="table table-hover">
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
          <p class="muted">...Retrieving Category Products...</p>
        </div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
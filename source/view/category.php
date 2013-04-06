
<?php 
namespace view;
session_start();
$_SESSION['search'] = $_GET['searchField'];
$_SESSION['prevPage'] = $_SERVER['PATH_INFO'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Category</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
  </head>
  <body>   
    <?php
        // Navigation Bar
        require($DOCUMENT_ROOT . "./elements/navbar.php");
    ?>
    <div class="container">
        <div class="hero-unit">
            <h1>Category Name</h1>
            <p>This is a category description.</p>
        </div>
        <div class="container" style="width:100%; height:300px; position:relative; 
        bottom:0px; overflow:auto;">
                        <table class="table table-hover">
            <thead>
                <tr>
                    <th><!-- placeholder --></th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Availability</th>
                    <th>Weight</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
              <div id="resultsDiv">
                <!-- product code javascript function will return the product code
                for the query of the database for creating product.php-->
                <tr onclick="location.href='./product.php?id=1'">
                    <td>
                      <img src="" alt="" width="50" height="50">
                    </td>
                    <td>$1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1 kg</td>
                    <td>1name</td>
                    <td>c1</td>
                    <td>This is a description...</td>
                    <td>
                        <button id="p1" style="position:relative; right:0px;"
                        class="btn pull-right">
                            View Product
                        </button>
                    </td>
                </tr>
                <tr onclick="location.href='./product.php?id=2'">
                    <td>
                      <img src="" alt="" width="50" height="50">
                    </td>
                    <td>$2</td>
                    <td>2</td>
                    <td>2</td>
                    <td>2 kg</td>
                    <td>2name</td>
                    <td>c2</td>
                    <td>This is a description...</td>
                    <td>
                        <button id="p2" style="position:relative; right:0px;"
                        class="btn pull-right">
                            View Product
                        </button>
                    </td>
                </tr>
                <tr onclick="location.href='./product.php?id=3'">
                    <td>
                      <img src="" alt="" width="50" height="50">
                    </td>
                    <td>$3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3 kg</td>
                    <td>3name</td>
                    <td>c3</td>
                    <td>This is a description...</td>
                    <td>
                        <button id="p3" style="position:relative; right:0px;"
                        class="btn pull-right">
                            View Product
                        </button>
                    </td>
                </tr>
                <tr onclick="location.href='./product.php?id=4'">
                    <td>
                      <img src="" alt="" width="50" height="50">
                    </td>
                    <td>$4</td>
                    <td>4</td>
                    <td>4</td>
                    <td>4 kg</td>
                    <td>4name</td>
                    <td>c4</td>
                    <td>This is a description...</td>
                    <td>
                        <button id="p4" style="position:relative; right:0px;"
                        class="btn pull-right">
                            View Product
                        </button>
                    </td>
                </tr>
              </div>
            </tbody>
            </table>
            <hr>
        </div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
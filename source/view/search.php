<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Search Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        // Default Style links
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
    <link href="bootstrap/css/carousel.css" rel="stylesheet">
  </head>
  <body>   
    <?php
        // Navigation Bar
        require($DOCUMENT_ROOT . "./elements/navbar.php");
    ?>
    <div class="container">
        <h3>Search results for 
        <?php echo $_SESSION['search']; ?>
        </h3>
        <div class="container" style="width:100%; height:300px; position:relative; 
        bottom:0px; overflow:auto;">
            <table class="table table-hover">
            <thead>
                <tr>
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
                <tr onclick="location.href='#'">
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
                <tr onclick="location.href='#'">
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
                <tr onclick="location.href='#'">
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
                <tr onclick="location.href='#'">
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
            </tbody>
            </table>
        </div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
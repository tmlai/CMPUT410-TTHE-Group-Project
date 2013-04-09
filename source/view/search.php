<?php 
//namespace view;
session_start();
$_SESSION['search'] = $_GET['searchField'];
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];

$search = trim($_GET['searchField']);

$advanced = $_GET['advanced'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Search Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
	<script type="text/javascript" language="Javascript"
		src="elements/search.js"></script>
  </head>
  <body onLoad="setToggle()"> 
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
        <h3>
        <?php 
          if($search != "") {
            echo "Search Results for " . $search; 
          } else if($advanced == null) {
			echo "Advanced Search";
		  } else if ($search == ""){
            echo "A blank search is given, please enter a search.";
          }
        ?>
        </h3>
        <label class="clabel" id="dropbutton" data-toggle="collapse" 
          data-target="#advSearch" onclick="dropIconToggle();">
          <div id="dropDiv"></div>
        </label>
        <div id="advSearch" class="collapse">
			<div class="input-append">
                <div id="store_div" class="control-group">
                    <label class="control-label" for="searchNameField">Name
                    </label>
                    <div class="controls">
                        <input type="text" id="searchNameField" 
                        placeholder="Search Name">
                    </div>
					<label class="control-label" for="searchCodeField">Code
                    </label>
                    <div class="controls">
                        <input type="text" id="searchCodeField" 
                        placeholder="Search Code">
                    </div>
					<label class="control-label" for="searchCategoryField">Category
                    </label>
                    <div class="controls">
                        <input type="text" id="searchCategoryField" 
                        placeholder="Search Catagory">
                    </div>
					<label class="control-label" for="priceFromField">Price From
                    </label>
                    <div class="controls">
                        <input type="text" id="priceFromField" 
                        placeholder="Price From">
                    </div>
					<label class="control-label" for="priceToField">Price To
                    </label>
                    <div class="controls">
                        <input type="text" id="priceToField" 
                        placeholder="Price To">
                    </div>
					<label class="control-label" for="minQtyField">Minimum Quantity
                    </label>
                    <div class="controls">
                        <input type="text" id="minQtyField" 
                        placeholder="Minimum Quantity">
                    </div>
					<label class="control-label" for="maxQtyField">Maximum Quantity
                    </label>
                    <div class="controls">
                        <input type="text" id="maxQtyField" 
                        placeholder="Maximum Quantity">
                    </div>
					<label class="control-label" for="minWeightField">Minimum Weight
                    </label>
                    <div class="controls">
                        <input type="text" id="minWeightField" 
                        placeholder="Minimum Weight">
                    </div>
					<label class="control-label" for="maxWeightField">Maximum Weight
                    </label>
                    <div class="controls">
                        <input type="text" id="maxWeightField" 
                        placeholder="Maximum Weight">
                    </div>
					<input type="button" class="btn" value="Advanced Search" onClick="advSearch()">
                </div>
                <!-- and more fields for admin...-->
			</div>
        </div>
        <div class="container" id="tableTitles">
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
            <tbody id="resultsTable">
            </tbody>
            </table>
        </div>
		<hr>
        <div id="loadingSpinner" align="center" style="visibility:visible">
          <img src="./elements/img/spinner.gif" alt="...Loading...">
        </div>
    </div> <!-- /container -->
	<script type="text/javascript">
		window.onload=initialLoading('<?php echo $search;?>');
	</script>
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
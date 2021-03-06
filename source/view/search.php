<?php 
//namespace view;
session_start();
$_SESSION['search'] = $_GET['searchField'];
$_SESSION['prevPage'] = $_SERVER['REQUEST_URI'];

$search = trim($_GET['searchField']);

$advanced = $_GET['advanced'];
if ($advanced == null) {
	$advanced = "false";
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TTHE Enterprise - Search Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
    <?php
        // Default Style links
        require("./elements/head_includes.php");
    ?>
	
  </head>
  <body onLoad="setToggle('<?php echo $advanced;?>'); 
	initialLoading('<?php echo $search;?>'); getMenuCategories(); getMenuCategories();"> 
    <?php
      // Navigation Bar
      if($_SESSION['user'] != "") {
        // user dropdown
        require("/elements/navbar_user.php");
      } else {
        // sign in dropdown
        require("/elements/navbar_signin.php");
      }

    ?>
    <div class="container">
        <h3>
        <?php 
          if($search != "") {
            echo "Search Results for " . $search; 
          } else if($advanced == "true") {
			echo "Advanced Search";
		  } else if ($search == ""){
            echo "A blank search is given, please enter a search.";
          }
        ?>
        </h3>
		<!-- Advanced and chevron -->
        <label class="clabel" id="dropbutton" data-toggle="collapse" 
          data-target="#advSearch" onclick="dropIconToggle();">
          <div id="dropDiv"></div>
        </label>
        <div id="advSearch" class="collapse">
		<!-- Advanced Search Form -->
			<form class="form-horizontal" onSubmit="" action="" method="post">
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
					<br>
					<div class="controls">
						<input type="button" class="btn" 
						 onClick="advSearch()" value="Advanced Search">
					</div>
				</div>
			</form>
	
        </div>
        <div class="container" id="tableTitles">
            <table class="table table-hover">
            <thead id="tableHead">
            </thead>
            <tbody id="resultsTable">
            </tbody>
            </table>
        </div>
		<hr>
    <div id="loadingSpinner" align="center" style="visibility:visible">
		  <img src="./elements/img/spinner.gif" alt="...Loading...">
      <p class="muted">...Searching...</p>
		</div>
    </div> <!-- /container -->
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" language="Javascript"
		src="elements/search.js"></script>
  </body>
</html>
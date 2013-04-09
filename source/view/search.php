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
        require($DOCUMENT_ROOT . "./elements/head_includes.php");
    ?>
    <script type="text/javascript" language="JavaScript">
    <!--
    <?php 
          if($search != "")
            echo "dropBool = false;\n";
          else
            echo "dropBool = true;\n";
    ?>
	function initialLoading() {
		//setToggle();
		//send ajax call to get a list of products
		var xmlhttp = new XMLHttpRequest();
		var productList = new Array();
		var stringList = "";
		if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}	else {
		// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open('GET', 
			'/source/controller/Search.php?searchField=<?php echo $search;?>',
			true);
		xmlhttp.send();
		//need to populate
		xmlhttp.onreadystatechange=function() {
			if (xmlhttp.readyState==4 && xmlhttp.status==200) {
				var list = xmlhttp.responseText;
				var listArray = JSON.parse(list);
				document.getElementById("loadingSpinner").style.visibility = "hidden";
				document.getElementById("loadingSpinner").innerHTML = "<br>";
				//build the table code
				var table = "";
				for(var i = 0; i<listArray.length; i++) {
					table += 
					"<tr onclick=\"location.href='/source/product.php?id="+listArray[i].cid+"'\">" +
						"<td>" +
						  "<img src=\"\" alt=\"\" width=\"50\" height=\"50\">" +
						"</td>" +
						"<td>" + listArray[i].price + "</td>" +
						"<td>" + listArray[i].weight+ " kg</td>" +
						"<td>" + listArray[i].name + "</td>" +
						"<td>" + listArray[i].cid + "</td>" +
						"<td>" + listArray[i].description + "</td>" +
						"<td>" +
							"<button style=\"position:relative; right:0px;\"" +
							"class=\"btn pull-right\">" +
								"View Product" +
							"</button>" +
						"</td>" +
					"</tr>";
				}
				if(listArray.length==0) {
					document.getElementById("tableTitles").innerHTML = "<h4>No products found.</h4>"
				}
				document.getElementById('resultsTable').innerHTML=table;

			}
		}
	}
    function setToggle() {
      if(dropBool) {
        document.getElementById("advSearch").className="collapse in";
      }
      dropIconToggle();
    }
    function dropIconToggle() {
      if(dropBool) {
        dropBool = false;
        document.getElementById("dropDiv").innerHTML=
          'Advanced Search  <i class="icon-chevron-up" data-toggle="collapse"'
            + ' data-target="#advSearch"></i>';
      } else {
        dropBool = true;
        document.getElementById("dropDiv").innerHTML=
          'Advanced Search  <i class="icon-chevron-down" data-toggle="collapse"'
            + ' data-target="#advSearch"></i>';
      }
    }
	
	function advSearch() {
		var name = document.getElementById('searchNameField').value;
		var code = document.getElementById('searchCodeField').value;
		var category = document.getElementById('searchCategoryField').value;
		var priceFrom = document.getElementById('priceFromField').value;
		var priceTo = document.getElementById('priceToField').value;
		var minQty = document.getElementById('minQtyField').value;
		var maxQty = document.getElementById('maxQtyField').value;
		var minWeight = document.getElementById('minWeightField').value;
		var maxWeight = document.getElementById('maxWeightField').value;
		var pass = true;
		
		//check range values
		if(priceFrom != "" && isNaN(priceFrom)) {
			pass = false;
		} else if(priceTo != "" && isNaN(priceTo)) {
			pass = false;
		} else if(minQty != "" && isNaN(minQty)) {
			pass = false;
		} else if(maxQty != "" && isNaN(maxQty)) {
			pass = false;
		} else if(minWeight != "" && isNaN(minWeight)) {
			pass = false;
		} else if(maxWeight != "" && isNaN(maxWeight)) {
			pass = false;
		} 
		
		if(pass == true) {
			//make ajax call
			var search = new Object();
			search.name = name;
			search.code = code;
			search.category = category;
			search.priceFrom = priceFrom;
			search.priceTo = priceTo;
			search.minQty = minQty;
			search.maxQty = maxQty;
			search.minWeight = minWeight;
			search.maxWeight = maxWeight;
			
			//make json
			var jsonSearch = JSON.stringify(search);
			
			//console.log(search);
			var xmlhttp = new XMLHttpRequest();
			if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}	else {
			// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.open('POST', 
				'/source/controller/AdvSearch.php',
				true);
			xmlhttp.send(jsonSearch);
			}
			
			xmlhttp.onreadystatechange=function() {
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					var list = xmlhttp.responseText;
					var listArray = JSON.parse(list);
					document.getElementById("loadingSpinner").style.visibility = "hidden";
					document.getElementById("loadingSpinner").innerHTML = "<br>";
					//build the table code
					var table = "";
					for(var i = 0; i<listArray.length; i++) {
						table += 
						"<tr onclick=\"location.href='/source/product.php?id="+listArray[i].cid+"'\">" +
							"<td>" +
							  "<img src=\"\" alt=\"\" width=\"50\" height=\"50\">" +
							"</td>" +
							"<td>" + listArray[i].price + "</td>" +
							"<td>" + listArray[i].weight+ " kg</td>" +
							"<td>" + listArray[i].name + "</td>" +
							"<td>" + listArray[i].cid + "</td>" +
							"<td>" + listArray[i].description + "</td>" +
							"<td>" +
								"<button style=\"position:relative; right:0px;\"" +
								"class=\"btn pull-right\">" +
									"View Product" +
								"</button>" +
							"</td>" +
						"</tr>";
					}
					if(listArray.length==0) {
						document.getElementById("tableTitles").innerHTML = "<h4>No products found.</h4>"
					}
					document.getElementById('resultsTable').innerHTML=table;
				}
			}
	}
    -->
    </script>
  </head>
  <body onLoad="setToggle();">   
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
    <script src="http://code.jquery.com/jquery.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
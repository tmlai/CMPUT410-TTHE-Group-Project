var dropBool = true;

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
	  'Advanced Search  <i class="icon-chevron-down" data-toggle="collapse"'
		+ ' data-target="#advSearch"></i>';
  } else {
	dropBool = true;
	document.getElementById("dropDiv").innerHTML=
	  'Advanced Search  <i class="icon-chevron-up" data-toggle="collapse"'
		+ ' data-target="#advSearch"></i>';
  }
}

function initialLoading(searchString) {
	// if(searchString != "")
        // dropBool = false;
    // else
        // dropBool = true;
	
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
		'/source/controller/Search.php?searchField=' + searchString,
		false);
	xmlhttp.send();
	//need to populate
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			var list = xmlhttp.responseText;
			var listArray = JSON.parse(list);
			document.getElementById("loadingSpinner").style.visibility = "hidden";
			document.getElementById("loadingSpinner").innerHTML = "<br>";
			// console.log(listArray);
			//build the table code
			var table = "";
			for(var i = 0; i<listArray.length; i++) {
				table += 
				"<tr onclick=\"location.href='/source/view/product.php?id="+listArray[i].cid+"'\">" +
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
					"<tr onclick=\"location.href='/source/view/product.php?id="+listArray[i].cid+"'\">" +
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
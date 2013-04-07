/*
 * Check if product is available (quantity > 0).
 * @return  true/false if available
 */
function checkInStock(pid) {
  var xmlhttp = new XMLHttpRequest();
	if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}	else {
    // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
  
  // Return if product is in stock
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      var jsonArray = JSON.parse(xmlhttp.responseText);
      //if((jsonArray.quantity + getExternalAvail(pid)) == 0) {
        //document.getElementById("stockDiv").innerHTML = "(In Stock)";
      //} else {
        //document.getElementById("stockDiv").innerHTML = "(Out of Stock)";
        var orderBtn = document.getElementsByName("orderBtn");
        orderBtn.className="btn btn-danger";
        orderBtn.innerHTML="Out of Stock";
      //}
    }
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.open('GET', '/source/controller/ProductServices.php?id=' + pid, 'true');
  xmlhttp.send();
  */
}
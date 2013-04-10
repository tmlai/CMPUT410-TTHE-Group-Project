/*
 * AJAX call for outstanding orders.
 */
 function getOutstandingOrders() {
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
      var orders = JSON.parse(xmlhttp.responseText);
      if(orders.length == 0) {
        document.getElementById('ordersContainer').innerHTML = 
          '<h3>You currently have no orders to be viewed.</h3>';
      } else {
        buildOrders(orders);
      }
    }
  };
  xmlhttp.open('GET', '../controller/viewOutstandingOrders.php', true);
  xmlhttp.send();
}

function buildOrders(orders) {
  var oHtml = '<h3>Your Orders:</h3>'
    + '<div class="accordion" id="outstandingAccordion">\n';
  for(var i = 0; i < orders.length; i++) {
    var order = orders[i];
    oHtml += '<div class="accordion-group">\n'
      + '    <div class="accordion-heading">\n'
      + '      <a class="accordion-toggle" data-toggle="collapse" '
      + 'data-parent="#outstandingAccordion" href="#collapse' + order['orderId'] + '">\n'
      + 'Order ID: ' + order['orderId'] + '    -    Date: ' + order['delivery_date']
      + '    -    Total Cost: $' + order['price_total']
      + '</a>\n</div>\n'
      + '    <div id="collapse' + order['orderId'] + '" class="accordion-body collapse">\n'
      + '      <div class="accordion-inner">\n'
      + '<table class="table">\n'
      +  '<thead>\n'
      +  '  <tr>\n'
      +  '    <th>Prodoct ID</th>\n'
      +  '    <th>Quantity</th>\n'
      +  '    <th>Product(s) Cost</th>\n'
      +  '  </tr>\n'
      +  '</thead>\n'
      +  '<tbody>\n';
      for(var j = 0; j < order['order'].length; j++) {
        var prod = order['order'][j];
        oHtml += 
        +    '<tr>\n'
        +      '<td>' + prod['pid'] + '</td>'
        +      '<td>' + prod['quantity'] + '</td>'
        +      '<td>$' + prod['amount'] + '</td>'
        +    '</tr>\n';
      }
      oHtml += 
        +  '</tbody>\n'
        +  '</table>\n'
        +  '</div>\n'
        + '</div>\n'
        + '</div>\n';   
  }
  oHtml += '</div>';
  oHtml = str.replace("NaN","");
  document.getElementById('ordersContainer').innerHTML = oHtml;

}
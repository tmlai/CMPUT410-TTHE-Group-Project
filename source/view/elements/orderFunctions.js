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
      if(order.length == 0) {
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
  oHtml = '<div class="accordion" id="outstandingAccordion">\n';
  for(var i = 0; i < order.length; i++) {
    var order = order[i];
    oHtml += '<div class="accordion-group">\n'
      + '    <div class="accordion-heading">\n'
      + '      <a class="accordion-toggle" data-toggle="collapse" '
      + 'data-parent="#outstandingAccordion" href="#collapse' + order['orderId'] + '">\n'
      + 'Order ID: ' + order['orderId'] + '\tDate: ' + order['delivery_date']
      //+ '\tTotal Cost: ' + order['price_total']
      + '</a>\n</div>\n'
      + '    <div id="collapse' + order['orderId'] + '" class="accordion-body collapse in">\n'
      + '      <div class="accordion-inner">\n';
      
      for(var j = 0; j < order['order'].length; j++) {
        var prod = order['order'][j];
        oHTML += 
        '<table class="table">\n'
          '<thead>\n'
          '  <tr>\n'
          '    <th>Prodoct ID</th>\n'
          '    <th>Quantity</th>\n'
          '    <th>Product(s) Cost</th>\n'
          '  </tr>\n'
          '</thead>\n'
          '<tbody>\n'
            '<tr>\n'
              '<td>' + prod['pid'] + '</td>'
              '<td>' + prod['quantity'] + '</td>'
              '<td>' + prod['amount'] + '</td>'
            '</tr>\n'
          '</tbody>\n'
        '</table>\n';
      }
      oHtml +='</div>\n'
        + '    </div>\n'
        + '  </div>\n';   
  }
  oHtml += '</div>';
  document.getElementById('ordersContainer').innerHTML = oHtml;

}
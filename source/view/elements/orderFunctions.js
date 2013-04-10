/*
 * AJAX call for outstanding orders.
 */
 function getOutstandingOrders(pid) {
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
      buildOrders(orders);
    }
  };
  xmlhttp.open('GET', '../controller/viewOutstandingOrder.php', true);
  xmlhttp.send();
}

function buildOrders(orders) {
  for(var i = 0; i < order.length; i++) {
    var order = order[i];
    var oHtml = '<div class="accordion-group">\n'
      + '    <div class="accordion-heading">\n'
      + '      <a class="accordion-toggle" data-toggle="collapse" '
      + 'data-parent="#outstandingAccordion" href="#collapse' + order['orderId'] + '">\n'
      + 'Order ID: ' + order['orderId'] + '\tDate: ' + order['delivery_date']
      + '</a>\n</div>\n'
      + '    <div id="collapse' + order['orderId'] + '" class="accordion-body collapse in">\n'
      + '      <div class="accordion-inner">\n';
      
      for(var j = 0; j < order['order'].length, j++) {
        <table class="table">
          <thead>
            <tr>
              <th>Prodoct ID</th>
              <th>Quantity</th>
              <th>Cost Amount</th>
            </tr>
          </thead>
          <tbody>
          </>
        </table>
      }
      oHtml +='</div>\n'
        + '    </div>\n'
        + '  </div>\n';
      +
  }

}


[{"orderId":"...",
				  "order":[{"pid":"product id", "quantity":"30", "amount":"..."}, 
						{"pid":"product id", "quantity":"30", "amount":"..."}, 
						{"pid":"product id", "quantity":"30", "amount":"..."}],
				  "delivery_date":"somedate"}, 
				  {}, 
				  {} ]
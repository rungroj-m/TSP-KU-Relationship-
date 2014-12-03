<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Transaction</h3>
	</div>
	<div class="panel-body">
		<div class="row" style="padding: 10px">
			<div class="col-md-6">
				<div class="btn-group btn-group-sm" style="width: 100%">
					<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
						<qq>Status</qq> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" id="types-dropdown" role="menu" style="width: 100%">
					    <li><a>All</a></li>
					</ul>
				</div>   
			</div>
			<div class="col-md-6">
				<button type="button" class="btn btn-success" id="button-get" style="width: 100%">GET</button>
			</div>
		</div>
		
		<table class="table table-striped table-bordered">
			<tbody id="orders-table">
				<tr>
					<td>ID</td>
					<td>Date</td>
					<td>Customer</td>
					<td>Total</td>
					<td>Promotion</td>
					<td>Status</td>
				</tr>
			</tbody>
		</table>
		
		<nav align="right">
			<ul class="pagination">
				<li class="disabled"><a href="#"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
			   	<li><a href="#">1</a></li>
			    <li><a href="#">2</a></li>
			    <li><a href="#">3</a></li>
			    <li><a href="#">4</a></li>
			    <li><a href="#">5</a></li>
			    <li><a href="#"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
			</ul>
		</nav>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_all_transaction': '',
			}
		}).done(function(json_str) {
			var json_obj = JSON.parse(json_str);
			for (var i = 0; i < json_obj.length; i++) {

				var cartId =json_obj[i].cart.cartId;
 				var obj = json_obj[i];
 				(function(obj) {
 	 				$.ajax({
	 					url: 'forjscallphp.php',
	 					type: 'POST',
	 					data: {
	 						'get_ordertrackingid_by_cartid': cartId,
	 					},
	 					success: function(oid) {
		 					if (oid > 0) {
		 						$.ajax({
		 							url: 'http://localhost:11111/orders/current/' + oid,
		 							type: "GET"
		 						}).done(function(status) {
		 							var st = JSON.parse(status);
			 						$("#orders-table").append("\
			 								<tr>\
			 									<td><a href=\"?page=transaction-detail&cartId=" + cartId + "\">" + obj.id + "</a></td>\
			 									<td>" + obj.payment.timeDate.date + "</td>\
			 									<td>" + obj.cart.customer.firstName + " " + obj.cart.customer.lastName + "</td>\
			 									<td>" + obj.payment.amount + "</td>\
			 									<td>" + 000 + "</td>\
			 									<td><a onClick=\"post('?page=update-transaction', {oid: " + oid + ", status: '" + st.orders.order.status.type + "'});\">" + oid + " " + st.orders.order.status.type + "</a></td>\
			 								</tr>");
			 					});
		 					}
		 					else {
		 						$("#orders-table").append("\
		 								<tr>\
		 									<td><a href=\"?page=transaction-detail&cartId=" + cartId + "\">" + obj.id + "</a></td>\
		 									<td>" + obj.payment.timeDate.date + "</td>\
		 									<td>" + obj.cart.customer.firstName + " " + obj.cart.customer.lastName + "</td>\
		 									<td>" + obj.payment.amount + "</td>\
		 									<td>" + 000 + "</td>\
		 									<td>Unknown</td>\
		 								</tr>");
		 					}
	 	 				}
	 				});
 				})(obj);
				
				
			} // for
		});

		$.ajax({
			url: 'http://localhost:11111/orders/enum'
		}).done(function(types_json) {
			var types = JSON.parse(types_json);
			for (var i = 0; i < types.length; i++) {
				$('#types-dropdown').append('<li><a>' + types[i] + '</a></li>');
			}
			$("#types-dropdown li").click(function() {
				$("#dropdown qq").text($(this).text());
			});
		});

	});


	$("#button-get").click(function() {
		alert($("#dropdown qq").text());
		
	});

	function post(path, params) {
	    var method = "POST";
	    
	    var form = document.createElement("form");
	    form.setAttribute("method", method);
	    form.setAttribute("action", path);

	    for(var key in params) {
	        if(params.hasOwnProperty(key)) {
	            var hiddenField = document.createElement("input");
	            hiddenField.setAttribute("type", "hidden");
	            hiddenField.setAttribute("name", key);
	            hiddenField.setAttribute("value", params[key]);

	            form.appendChild(hiddenField);
	         }
	    }

	    document.body.appendChild(form);
	    form.submit();
	}
</script>

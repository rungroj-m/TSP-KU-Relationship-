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
					<td>Products</td>
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
				console.log("cart id : "+cartId);
				(function(obj) {
					$.ajax({
						url: 'forjscallphp.php',
						type: 'POST',
						data: {
							'get_product_in_transaction': cartId
						},
						success: function(json_str2) {
							console.log("------"+json_str2 );
// 							var products_json_obj = json_str2;
// 							console.log(products_json_obj);
							
							$("#orders-table").append("\
									<tr>\
										<td>" + obj.id + "</td>\
										<td>" + 000 + "Products</td>\
										<td>" + obj.payment.timeDate.date + "</td>\
										<td>" + obj.cart.customer.firstName + " " + obj.cart.customer.lastName + "</td>\
										<td>" + obj.payment.amount + "</td>\
										<td>Status</td>\
									</tr>");
						}
					});
				})(obj);
				
				
			} // for
		});

	});
</script>


<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Tracking</h3>
	</div>
	<div class="panel-body">
	
	
					<div class="input-group">
						<span class="input-group-addon">Tracking ID</span>
						<input type="text" class="form-control" id="id">
					</div>
					<br>
					<button class="btn btn-lg btn-success btn-block" id="button-get">GET</button>
					<br>
					<table class="table table-striped table-bordered">
						<tbody id="orders-table">
							<tr>
								<td>Status</td>
								<td>Date</td>
								<td>Description</td>
								<td>Update By</td>
							</tr>
						</tbody>
					</table>
	
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
// 		$.ajax({
// 			url: 'http://localhost:11111/orders/308',
// 			type: "POST",
// 			data: "{\"order\": { \"status\":	{ \"updatedby\": \"server\",  \"type\": \"ORDER_READY\"\ }\ }}"
// 		}).done(function(response) {
// 		    alert(response);
// 		});

		

	});

	$("#button-get").click(function() {
		$("#orders-table").empty();
		$("#orders-table").append("\
			<tr>\
				<td>Status</td>\
				<td>Date</td>\
				<td>Description</td>\
				<td>Update By</td>\
			</tr>");
		
		$.ajax({
		url: 'http://localhost:11111/orders/' + $("#id").val(),
				type: "GET"
			}).done(function(status) {
				console.log(status);
				var st = JSON.parse(status);
				console.log(st);
				
				if (st.orders.order.status.length > 1) {
					for (var i = 0; i < st.orders.order.status.length; i++) {
						$("#orders-table").append("\
								<tr>\
									<td>" + st.orders.order.status[i].type + "</td>\
									<td>" + st.orders.order.status[i].date + "</td>\
									<td>" + st.orders.order.status[i].description + "</td>\
									<td>" + st.orders.order.status[i].updatedby + "</td>\
								</tr>");
					}
				}
				else {
					$("#orders-table").append("\
							<tr>\
								<td>" + st.orders.order.status.type + "</td>\
								<td>" + st.orders.order.status.date + "</td>\
								<td>" + st.orders.order.status.description + "</td>\
								<td>" + st.orders.order.status.updatedby + "</td>\
							</tr>");
				}
			});
	});

	


</script>

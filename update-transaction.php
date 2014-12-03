
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Update Order Status</h3>
	</div>
	<div class="panel-body">
	
	
					<div class="input-group">
						<span class="input-group-addon">Tracking ID</span>
						<input type="text" class="form-control" id="id">
					</div>
					<br>
					<button class="btn btn-lg btn-success btn-block" id="button-get">GET</button>
					<br>
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
					<br>
					<br>
					<br>
					<div class="row">
						<div class="col-md-6">
							<div class="btn-group btn-group-sm" style="width: 100%">
								<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
									<qq>Status</qq> <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" id="types-dropdown" role="menu" style="width: 100%">
								</ul>
							</div>   
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" id="description" placeholder="Addition description ex. EMS code">
						</div>
					</div>
					
					<br>
					<button class="btn btn-lg btn-success btn-block" id="button-update">Update</button>
	
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

// 		$.ajax({
// 			url: 'http://localhost:11111/orders/' + $("#id").val(),
// 			type: "GET"
// 		}).done(function(status) {
// 			console.log(status);
// 			var st = JSON.parse(status);
// 			console.log(st);
// 			$("#orders-table").append("\
// 					<tr>\
// 						<td>" + st.orders.order.status.type + "</td>\
// 						<td>" + st.orders.order.status.date + "</td>\
// 						<td>" + st.orders.order.status.description + "</td>\
// 						<td>" + st.orders.order.status.updatedby + "</td>\
// 					</tr>");
// 		});

		


	});

	$("#button-update").click(function() {
// 		alert($("#dropdown qq").text());
		var json_str = "{\"order\": { \"status\":	{ \"updatedby\": \"server\",  \"type\": \"" + $("#dropdown qq").text() + "\",  \"description\": \"" + $("#description").val() + "\" } }}";
		console.log(JSON.parse(json_str))
		console.log(json_str);
		$.ajax({
			url: 'http://localhost:11111/orders/' + $("#id").val(),
			type: "POST",
			data: json_str
		}).done(function(response) {
		    alert("OK");
		});
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

			$.ajax({
				url: 'http://localhost:11111/orders/next/' + $("#id").val()
			}).done(function(types_json) {
			
						$("#dropdown qq").text(types_json);
						
			});
	});

	


</script>

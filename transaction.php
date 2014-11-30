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
		$.ajax({
			url: 'http://localhost:11111/orders',
			data: {
				//"statue": $("#dropdown qq").text()
			}
		}).done(function(json) {
			var json_obj = JSON.parse(xml2json(json, ""));
			ordersToTable(json_obj)
		});
	});

	function ordersToTable(json_obj) {
		$("#orders-table").empty();
		$("#orders-table").append("\
				<tr>\
					<td>ID</td>\
					<td>Products</td>\
					<td>Date</td>\
					<td>Customer</td>\
					<td>Total</td>\
					<td>Status</td>\
				</tr>");

		var orders = json_obj.orders;
		console.log(orders);
// 		for (var i = 0; i < orders.length; i++) {
// 			$("#orders-table").append("\
// 					<tr>\
// 						<td>" + (i+1) + "</td>\
// 						<td>" +  + "Products</td>\
// 						<td>Date</td>\
// 						<td>Customer</td>\
// 						<td>Total</td>\
// 						<td>Status</td>\
// 					</tr>");
// 		}
	}
</script>

<div class="row" id="redzone" style="display: none">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a id="date">By Time Range</a></li>
					<li><a id="customer">By Customer</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="col-md-9" id="content">
		<div class="panel panel-default" id="div-date">
			<div class="panel-heading">
				<h3 class="panel-title">Report by Time Range</h3>
			</div>
			<div class="panel-body">
				<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-calendar"></span></span>
					<input type="text" class="form-control" id="date-show" placeholder="Date range" disabled="">
				</div>
				<br>
				<div id="calendari_lateral1"></div>
				<br>
				<br>
				<br>
				<div class="jumbotron" id="sum">Select Date Range.</div>
			
				<table class="table table-striped table-bordered">
					<tbody id="orders-table-date">
						<tr>
							<td>ID</td>
							<td>Date</td>
							<td>Customer</td>
							<td>Total</td>
							<td>Promotion</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
			
		<div class="panel panel-default" id="div-customer" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Report by Customer</h3>
			</div>
			<div class="panel-body">
				<div class="btn-group btn-group-sm" style="width: 100%">
					<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
						<qq>Status</qq> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" id="users-dropdown" role="menu" style="width: 100%">
					</ul>
				</div>  
				<br>
				<br>
				<br>
				<div class="jumbotron" id="sum2">Select Customer.</div>
			
				<table class="table table-striped table-bordered">
					<tbody id="orders-table-customer">
						<tr>
							<td>ID</td>
							<td>Date</td>
							<td>Customer</td>
							<td>Total</td>
							<td>Promotion</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">

	$(document).ready(function() {
		if ($.cookie("adminlevel") == 2) {
			$("#redzone").show();
		}
		else
			document.location.href = "?page=notfound"
	});

	$(document).ready(function() {
		
	    var monthNames = ["January", "February", "March", "April", "May", "June", "Jult", "August", "September", "October", "November", "December"];
	
	    var dayNames = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
	    $('#calendari_lateral1').bic_calendar({
	        enableSelect: true,
	        multiSelect: true,
	        dayNames: dayNames,
	        monthNames: monthNames,
	        showDays: true,
	        reqAjax: true,
	        auto: false
	    });

	    document.addEventListener('bicCalendarSelect', function(e) {
	        var a = e.detail.dateFirst.getDate() + "/" + (e.detail.dateFirst.getMonth()+1) + "/" + (e.detail.dateFirst.getYear()+1900);
	        var b = e.detail.dateLast.getDate() + "/" + (e.detail.dateLast.getMonth()+1) + "/" + (e.detail.dateLast.getYear()+1900);
	        
	        start = e.detail.dateFirst;
			end = e.detail.dateLast;
			
			$("#date-show").val(a + ' - ' + b);

			getTransactionByTimeRange(a, b);
	    });
	});

	$("#menu li").click(function() {
		var clicked = $(this).children("a").attr("id");
		$("#content").children("div").each(function() {
			if (!($(this).attr("id").toLowerCase() == "div-" + clicked)) {
				$(this).fadeOut();
			}
			else {
				$(this).fadeIn();
			}
		});

		var that = this;
		$("#menu li").each(function() {
			if (!(this == that)) {
				$(this).removeClass("active");
			}
			else {
				$(this).addClass("active");
			}
		});
	});


	// Get transactions
	$(document).ready(function() {

		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			async: false,
			data: {
				'get_all_customer': ''
			}
		}).done(function(json_str) {
			
			var c = JSON.parse(json_str);
			
			$("#users-dropdown").empty();
			$("#dropdown qq").text("");

			for (var i = 0; i < c.length; i++) {
				console.log("<li><a>" + c[i].id + ": " + c[i].firstName + " " + c[i].lastName + "</a></li>");
				$("#users-dropdown").append("<li><a>" + c[i].id + ": " + c[i].firstName + " " + c[i].lastName + "</a></li>");
			}
			
		    $("#users-dropdown li").click(function() {
		    	$("#dropdown qq").text($(this).text());
		    	getTransactionByCustomer();
		    });
		});


		getTransactionByTimeRange();
	});

	function getTransactionByTimeRange(start, end) {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_transaction_by_daterange": "",
				"start": start.split("/")[2] + "/" + start.split("/")[1] + "/" + start.split("/")[0] + " 00:00:00",
				"end": end.split("/")[2] + "/" + end.split("/")[1] + "/" + end.split("/")[0] + " 00:00:00",
			}
		}).done(function(trans) {
			console.log(trans);
			var ts = JSON.parse(trans);
// 			console.log(ts);

			$("#orders-table-date").empty();
			$("#orders-table-date").append("\
					<tr>\
						<th>ID</th>\
						<th>Date</th>\
						<th>Customer</th>\
						<th>Total</th>\
						<th>Promotion</th>\
					</tr>");

			var sum = 0;
			var dis = 0;
			for (var i = 0; i < ts.length; i++) {
				console.log(ts[i]);
				var row = "\
						<tr>\
							<td>" + ts[i].cart.cartId + "</td>\
							<td>" + ts[i].payment.timeDate.date + "</td>\
							<td>" + ts[i].cart.customer.firstName + " " + ts[i].cart.customer.lastName + "</td>\
							<td>" + ts[i].payment.amount + "</td>";
				(function(date, amount) {
					$.ajax({
						url: 'forjscallphp.php',
						type: "POST",
						async: false,
						data : {
							"get_promotion_by_datetime": "",
							"start": date,
							"end": date
						}
					}).done(function(tran) {
						try {
			 				console.log(".......V");
							var val = JSON.parse(tran)[0].value;

			 				console.log(val);
			 				console.log(".......^");
							var pro = JSON.parse(tran)[0];
							row += "<td>" + ((100.0-val)/100*amount).toFixed(2) + " </td>"

							dis += Number(((100.0-val)/100*amount).toFixed(2));
						} catch (err) {
							row += "<td></td>";
						}
						
					});
				})(ts[i].payment.timeDate.date, ts[i].payment.amount);

				$("#orders-table-date").append(row);
				sum += Number(ts[i].payment.amount);
			}

			$("#sum").html("<h2>Shopping: " + ts.length + "</h2><h4>Total: </h4>" + sum + "<h4>Discount: </h4>" + dis.toFixed(2) + "<h3>Net value: " + (sum-dis).toFixed(2) + "</h3> <h3>Vat 7%: " + ((sum-dis)*7.0/100).toFixed(2) + "</h3><h2>Total profit: " + ((sum-dis)*(100-7.0)/100).toFixed(2) + "</h2>");
		});
	}

	function getTransactionByCustomer() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_transaction_by_customerid": $("#dropdown qq").text().split(":")[0]
			}
		}).done(function(trans) {
			var ts = JSON.parse(trans);
// 			console.log("vvv")
// 			console.log(ts);

			$("#orders-table-customer").empty();
			$("#orders-table-customer").append("\
					<tr>\
						<th>ID</th>\
						<th>Date</th>\
						<th>Customer</th>\
						<th>Total</th>\
					</tr>");

			var sum = 0;
			var dis = 0;
			for (var i = 0; i < ts.length; i++) {
				console.log(ts[i]);
				var row = "\
						<tr>\
							<td>" + ts[i].cart.cartId + "</td>\
							<td>" + ts[i].payment.timeDate.date + "</td>\
							<td>" + ts[i].cart.customer.firstName + " " + ts[i].cart.customer.lastName + "</td>\
							<td>" + ts[i].payment.amount + "</td>";
				
				$("#orders-table-customer").append(row);
				sum += Number(ts[i].payment.amount);
				dis += 000000;
			}

			$("#sum2").html("<h2>Shopping: " + ts.length + "</h2><h4>Total: </h4>" + sum + "<h3>Net value: " + (sum-dis) + "</h3> <h3>Vat 7%: " + ((sum-dis)*7.0/100).toFixed(2) + "</h3><h2>Total profit: " + ((sum-dis)*(100-7.0)/100).toFixed(2) + "</h2>");
		});
	}
	
</script>

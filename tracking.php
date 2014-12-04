
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
					<br>
					<br>
					<br>
					<div id="update-div" style="display: none">
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
						<button class="btn btn-lg btn-primary btn-block" id="button-update" disable>Update</button>
					</div>
	
	</div>
</div>


<script type="text/javascript">

	$("#button-get").click(function() {
		if ($.cookie("adminlevel") != undefined)
			$("#update-div").show();
		
		$("#orders-table").empty();
		$("#orders-table").append("\
			<tr>\
				<td>Status</td>\
				<td>Date</td>\
				<td>Description</td>\
				<td>Update By</td>\
			</tr>");
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_order_status_by_cartid": $("#id").val()
			}
		}).done(function(status) {
			
			var st = JSON.parse(status);
			console.log(st);
			
			for (var i = 0; i < st.length; i++) {
				$("#orders-table").append("\
						<tr>\
							<td>" + st[i].StatusType + "</td>\
							<td>" + st[i].Date + "</td>\
							<td>" + st[i].Description + "</td>\
							<td>" + st[i].UpdatedBy + "</td>\
						</tr>");
			}

			$.ajax({
				url: 'forjscallphp.php',
				type: "POST",
				data: {
					"get_enum_values": ""
				}
			}).done(function(response) {
			    var types = JSON.parse(response);
				console.log(types)
			    $.ajax({
					url: 'forjscallphp.php',
					type: "POST",
					data: {
						"get_lastest_order_status_by_cartid": $("#id").val()
					}
				}).done(function(response) {
					var current = JSON.parse(response)[0].StatusType;
					$("#types-dropdown").empty();
					$("#dropdown qq").text("");
					var found = false;
					var first = true;
				    for (var i = 0; i < types.length; i++) {
					    console.log(types[i].substring(1, types[i].length-1) + " " +  current + " " + (types[i].substring(1, types[i].length-1) == current))
					   
					    if (found) {
							$("#types-dropdown").append("<li><a>" + types[i].substring(1, types[i].length-1) + "</a></li>");
							if (first) {
								$("#dropdown qq").text(types[i].substring(1, types[i].length-1));
								first = false;
							}
					    }
					    
					    if (!found && types[i].substring(1, types[i].length-1) == current) {
						    found = true;
					    }
				    }
				    
				    $("#types-dropdown li").click(function() {
				    	$("#dropdown qq").text($(this).text());
				    });
				});
			});
		});
	});

	$("#button-update").click(function() {$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"update_order_status_by_cartid": $("#id").val(),
				"status": $("#dropdown qq").text(),
				"description": $("#description").val(),
				"by": $.cookie("firstname") + " " + $.cookie("lastname")
			}
		}).done(function(response) {
		    alert(response);
		});
	});

	


</script>

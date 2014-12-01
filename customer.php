<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a id="user">Customer List</a></li>
					<li><a id="block">Block List</a></li>
					<li><a id="admin">Admin List</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	
	<div class="col-md-9" id="content">
		<div class="panel panel-default" id="div-user">
			<div class="panel-heading">
				<h3 class="panel-title">User List</h3>
			</div>
			<div class="panel-body">
			<table class="table table-striped table-bordered">
				<tbody id="user-table">
					<tr>
						<td>ID</td>
						<td>Name</td>
						<td>Email</td>
						<td>Status</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-block" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Blocked List</h3>
			</div>
			<div class="panel-body">
			body
			</div>
		</div>
		
		<div class="panel panel-default" id="div-admin" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Admin List</h3>
			</div>
			<div class="panel-body">
			<table class="table table-striped table-bordered">
				<tbody id="admin-table">
					<tr>
						<td>ID</td>
						<td>Name</td>
						<td>Email</td>
						<td>Level</td>
					</tr>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
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

	$(document).ready(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_customer_list': '',
			}
		}).done(function(json_str) {
			var customers = JSON.parse(json_str);
			console.log(customers);

			for (var i = 0; i < customers.length; i++) {
				$("#user-table").append("\
						<tr>\
							<td>" + customers[i].id + "</td>\
							<td>" + customers[i].firstName + " " + customers[i].lastName + "</td>\
							<td>" + customers[i].username + "</td>\
							<td>Status</td>\
						</tr>");
			}

		});

		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_admin_list': '',
			}
		}).done(function(json_str) {
			console.log(json_str);
			var admins = JSON.parse(json_str);
			console.log(admins);

			for (var i = 0; i < admins.length; i++) {
				$("#admin-table").append("\
						<tr>\
							<td>" + admins[i].id + "</td>\
							<td>" + admins[i].firstName + " " + admins[i].lastName + "</td>\
							<td>" + admins[i].username + "</td>\
							<td>" + admins[i].level + "</td>\
						</tr>");
			}

		});
	});

</script>
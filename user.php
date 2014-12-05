<div class="row" id="redzone" style="display: none">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a id="user">Customer List</a></li>
					<li><a id="block">Blocked List</a></li>
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
							<td></td>
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
				<table class="table table-striped table-bordered">
					<tbody id="blocked-table">
						<tr>
							<td>ID</td>
							<td>Name</td>
							<td>Email</td>
							<td></td>
						</tr>
					</tbody>
				</table>
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
	$(document).ready(function() {
		if ($.cookie("adminlevel") != undefined) {
			$("#redzone").show();
		}
		else
			document.location.href = "?page=notfound"
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
	
	var customer_page = 1;
	var block_page = 1;
	var admin_page = 1;
	
	$(document).ready(function() {
		showCustomer();
		showBlocked();
		showAdmin();
	});

	function showCustomer() {
		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_all_customer': '',
				"page": customer_page
			}
		}).done(function(json_str) {
			var customers = JSON.parse(json_str);
			$("#user-table").empty();
			$("#user-table").append("\
					<tr>\
						<td>ID</td>\
						<td>Name</td>\
						<td>Email</td>\
						<td>Status</td>\
						<td></td>\
					</tr>");

			for (var i = 0; i < customers.length; i++) {
				$("#user-table").append("\
					<tr id=\"" + customers[i].id + "\">\
						<td><a href=\"?page=customer-detail&id=" + customers[i].id + "\">" + customers[i].id + "</a></td>\
						<td>" + customers[i].firstName + " " + customers[i].lastName + "</td>\
						<td>" + customers[i].username + "</td>\
						<td>" + (customers[i].isBlocked == 1 ? "Blocked" : "Unblocked") + "</td>\
						<td>" + (customers[i].isBlocked == 0 ? "<a onClick=\"block(" + customers[i].id + ");\">block</a>" : "<a onClick=\"unblock(" + customers[i].id + ");\">unblock</a>") + "</td>\
					</tr>");
			}

		});
	}

	function showBlocked() {
		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_all_blocked_customer': '',
				"page": customer_page
			}
		}).done(function(json_str) {
			var customers = JSON.parse(json_str);
			$("#blocked-table").empty();
			$("#blocked-table").append("\
					<tr>\
						<td>ID</td>\
						<td>Name</td>\
						<td>Email</td>\
						<td></td>\
					</tr>");

			for (var i = 0; i < customers.length; i++) {
				$("#blocked-table").append("\
					<tr>\
						<td>" + customers[i].id + "</td>\
						<td>" + customers[i].firstName + " " + customers[i].lastName + "</td>\
						<td>" + customers[i].username + "</td>\
						<td><a onClick=\"unblock(" + customers[i].id + ");\">unblock</a></td>\
					</tr>");
			}

		});
	}

	function showAdmin() {
		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_all_admin': '',
				"page": admin_page
			}
		}).done(function(json_str) {
			var admins = JSON.parse(json_str);
			$("#admin-table").empty();
			$("#admin-table").append("\
					<tr>\
						<td>ID</td>\
						<td>Name</td>\
						<td>Email</td>\
						<td>Level</td>\
					</tr>");
			
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
	}

	function block(id) {
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"block": id
			}
		}).done(function(response) {
			document.location.href = "?page=user#" + id
			location.reload();
		});
	}

	function unblock(id) {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"unblock": id
			}
		}).done(function(response) {
			document.location.href = "?page=user#" + id
			location.reload();
		});
	}

</script>
<style>
input {
	margin: 5px
}
</style>

<div class="row" id="redzone" style="display: none">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a id="edit">Edit Customer Profile</a></li>
					<li><a id="transaction">See Customer Transaction</a></li>
					<li><a id="wishlist">See Customer Wishlist</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="col-md-9" id="content">
		<div class="panel panel-default" id="div-edit">
			<div class="panel-heading">
				<h3 class="panel-title">Profile</h3>
			</div>
			<div class="panel-body">
			
					<h2 class="form-signin-heading">Login Information</h2>
					<br>
					
					<div class="row">
						<div class="col-md-6">
							<input type="text" class="form-control" id="customer-id" placeholder="Customer ID" value="<?php if (isset($_GET["id"])) echo $_GET["id"]; ?>">
						</div>
						<div class="col-md-6">
							<button class="btn btn-lg btn-success btn-block" id="get-profile-button">GET</button>
						</div>
					</div>
					<br>
					<br>
					<br>
					<div id="edit-div" style="display: none">
						<input type="email" class="form-control" id="customer-email" placeholder="Email address" required="">
						
						<div class="row">
							<div class="col-md-6">
								<input type="text" class="form-control" id="customer-firstname" placeholder="First Name" required="">
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" id="customer-lastname" placeholder="Last Name" required="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<input type="text" class="form-control" id="customer-address" placeholder="Address" required="">
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" id="customer-address2" placeholder="Address 2">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<input type="text" class="form-control" id="customer-district" placeholder="District" required="">
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control" id="customer-province" placeholder="Province" required="">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<input type="text" class="form-control" id="customer-country" placeholder="Country" required="">
							</div>
							<div class="col-md-4">
								<input type="text" class="form-control" id="customer-zip" placeholder="ZIP" required="">
							</div>
							
							<div class="col-md-4">
								<input type="text" class="form-control" id="customer-phone" placeholder="Phone">
							</div>
						</div>
						<br>
						<div class="checkbox">
						    <label>
						    	<input type="checkbox" id="change-password-checkbox">Change password
						    </label>
						</div>
						<div class="row">
							<div class="col-md-6">
								<input type="password" class="form-control" id="customer-password" placeholder="Password">
							</div>
							<div class="col-md-6">
								<input type="password" class="form-control" id="customer-password-confirm" placeholder="Password again">
							</div>
						</div>
						<br>
						<button class="btn btn-lg btn-primary btn-block" id="save-profile-button">Save</button>
					</div>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-transaction" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Transaction</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<tbody id="transaction-list">
						<tr>
							<th>ID</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Total</th>
							<th>Promotion</th>
							<th>Status</th>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-wishlist" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Transaction</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<tbody id="transaction-list">
						<tr>
							<th>ID</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Total</th>
							<th>Promotion</th>
							<th>Status</th>
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

	$(document).ready(function() {
		<?php
			if (isset($_GET["id"]))
				echo "get();";
		?>
		$("#customer-password").prop('disabled', true);
		$("#customer-password-confirm").prop('disabled', true);
		
		
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

	$("#change-password-checkbox").click(function() {
		console.log($('#change-password-checkbox').is(':checked'));
			$("#customer-password").prop('disabled', !$('#change-password-checkbox').is(':checked'));
			$("#customer-password-confirm").prop('disabled', !$('#change-password-checkbox').is(':checked'));
			
			$("#customer-password").prop('required', $('#change-password-checkbox').is(':checked'));
			$("#customer-password-confirm").prop('required', $('#change-password-checkbox').is(':checked'));
	});

	$("#save-profile-button").click(function() {
		var email = $("#customer-email").val();
		var password = $("#customer-password").val();
		var firstname = $("#customer-firstname").val();
		var lastname = $("#customer-lastname").val();
		var address = $("#customer-address").val();
		var address2 = $("#customer-address2").val();
		var district = $("#customer-district").val();
		var province = $("#customer-province").val();
		var country = $("#customer-country").val();
		var zip = $("#customer-zip").val();
		var phone = $("#customer-phone").val();
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"save_customer_detail": $("#customer-id").val(),
				"email": email,
				"password": $('#change-password-checkbox').is(':checked') ? password : "",
				"firstname": firstname,
				"lastname": lastname,
				"address": address,
				"address2": address2,
				"district": district,
				"province": province,
				"country": country,
				"zip": zip,
				"phone": phone
			}
		}).done(function(response) {
			location.reload();
		});
	});

	$("#get-profile-button").click(function() {
		get();
	});

	function get() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_customer_detail": $("#customer-id").val()
			}
		}).done(function(customer_json) {
			// if found
			var customer_obj = JSON.parse(customer_json);
			if (customer_obj.username != "") {
				$("#customer-email").val(customer_obj.username);
				$("#customer-firstname").val(customer_obj.firstname);
				$("#customer-lastname").val(customer_obj.lastname);
				$("#customer-address").val(customer_obj.address);
				$("#customer-address2").val(customer_obj.address2);
				$("#customer-district").val(customer_obj.district);
				$("#customer-province").val(customer_obj.province);
				$("#customer-country").val(customer_obj.country);
				$("#customer-zip").val(customer_obj.zip);
				$("#customer-phone").val(customer_obj.phone);
				
				$("#edit-div").show();
			}
			else {
				alert("Please check the customer id exists.");
				$("#edit-div").hide();
			}
		});

	}

	

</script>
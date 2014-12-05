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
					<li class="active"><a id="edit">Edit Profile</a></li>
					<li><a id="transaction">See Transaction</a></li>
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
			
					<h2 class="form-signin-heading">Profile Information</h2>
					<br>
					
					
					<input type="email" class="form-control" id="signup-email" placeholder="Email address" disabled>
					
					<div class="row">
						<div class="col-md-6">
							<input type="text" class="form-control" id="signup-firstname" placeholder="First Name" required="">
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" id="signup-lastname" placeholder="Last Name" required="">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<input type="text" class="form-control" id="signup-address" placeholder="Address" required="">
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" id="signup-address2" placeholder="Address 2">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<input type="text" class="form-control" id="signup-district" placeholder="District" required="">
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" id="signup-province" placeholder="Province" required="">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<input type="text" class="form-control" id="signup-country" placeholder="Country" required="">
						</div>
						<div class="col-md-4">
							<input type="text" class="form-control" id="signup-zip" placeholder="ZIP" required="">
						</div>
						
						<div class="col-md-4">
							<input type="text" class="form-control" id="signup-phone" placeholder="Phone">
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
								<input type="password" class="form-control" id="signup-password" placeholder="Password">
							</div>
							<div class="col-md-6">
								<input type="password" class="form-control" id="signup-password-confirm" placeholder="Password again">
							</div>
						</div>
						<br>
						<button class="btn btn-lg btn-primary btn-block" id="save-profile-button">Save</button>
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
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {
		if ($.cookie("customerid") != undefined) {
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

	$(document).ready(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_customer_detail": $.cookie("customerid")
			}
		}).done(function(customer_json) {
			var customer_obj = JSON.parse(customer_json);
			
			$("#signup-email").val(customer_obj.username);
			$("#signup-firstname").val(customer_obj.firstname);
			$("#signup-lastname").val(customer_obj.lastname);
			$("#signup-address").val(customer_obj.address);
			$("#signup-address2").val(customer_obj.address2);
			$("#signup-district").val(customer_obj.district);
			$("#signup-province").val(customer_obj.province);
			$("#signup-country").val(customer_obj.country);
			$("#signup-zip").val(customer_obj.zip);
			$("#signup-phone").val(customer_obj.phone);


			$("#signup-password").prop('disabled', true);
			$("#signup-password-confirm").prop('disabled', true);
		});
	});

	$("#save-profile-button").click(function() {
		var email = $("#signup-email").val();
		var password = $("#signup-password").val();
		var firstname = $("#signup-firstname").val();
		var lastname = $("#signup-lastname").val();
		var address = $("#signup-address").val();
		var address2 = $("#signup-address2").val();
		var district = $("#signup-district").val();
		var province = $("#signup-province").val();
		var country = $("#signup-country").val();
		var zip = $("#signup-zip").val();
		var phone = $("#signup-phone").val();
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"save_customer_detail": $.cookie("customerid"),
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

	$("#change-password-checkbox").click(function() {
		console.log($('#change-password-checkbox').is(':checked'));
			$("#signup-password").prop('disabled', !$('#change-password-checkbox').is(':checked'));
			$("#signup-password-confirm").prop('disabled', !$('#change-password-checkbox').is(':checked'));
			
			$("#signup-password").prop('required', $('#change-password-checkbox').is(':checked'));
			$("#signup-password-confirm").prop('required', $('#change-password-checkbox').is(':checked'));
	});

</script>
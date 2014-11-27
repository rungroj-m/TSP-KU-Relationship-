<div class="row">
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
				<form class="form-signin" id="signup-form" role="form">
					<h2 class="form-signin-heading">Login Information</h2>
					<br>
					<input type="email" class="form-control" id="signup-email" placeholder="Email address" required="" autofocus="">
					<input type="password" class="form-control" id="signup-password" placeholder="Password" required="">
					<input type="password" class="form-control" id="signup-password-confirm" placeholder="Password again" required="">
					<br>
					<input type="text" class="form-control" id="signup-firstname" placeholder="First Name" required="">
					<input type="text" class="form-control" id="signup-lastname" placeholder="Last Name" required="">
					
					<br>
					<button class="btn btn-lg btn-success btn-block" type="submit">Save</button>
				</form>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-transaction" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Transaction</h3>
			</div>
			<div class="panel-body">
				<table class="table">
					<tbody id="transaction-list">
						<tr>
							<th>ID</th>
							<th>Transaction</th>
							<th>Date</th>
							<th>Total</th>
							<th>Status</th>
							<th></th>
						</tr>
						<!-- //////////////////demo//////////// -->
						<tr>
							<th>1234</th>
							<th>[tshirt x 2, balls x2]</th>
							<th>12:23:34 12/12/2014</th>
							<th>128</th>
							<th>Pending</th>
							<th></th>
						</tr>
						<tr>
							<th>1255</th>
							<th>[tshirt x 2, balls x2, red bal...</th>
							<th>00:10:11 15/12/2014</th>
							<th>999</th>
							<th>Sent <a href="#">TH991111</a></th>
							<th></th>
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

</script>
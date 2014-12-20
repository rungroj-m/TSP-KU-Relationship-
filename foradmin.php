
	<!-- Sign up form -->
<div class="container" align="center" id="container-form">
	<div class="jumbotron" style="box-shadow: 4px 4px 6px #cccccc; width: 50%; id="container-signup">
		<form class="form-signin" id="signup-form" role="form">
			<h2 class="form-signin-heading">For admin register</h2>
			<br>
			<input type="email" class="form-control" id="signup-email" placeholder="Email address" required="" autofocus="">
			<input type="password" class="form-control" id="signup-password" placeholder="Password" required="">
			<input type="password" class="form-control" id="signup-password-confirm" placeholder="Password again" required="">
			<br>
			<input type="text" class="form-control" id="signup-firstname" placeholder="First Name" required="">
			<input type="text" class="form-control" id="signup-lastname" placeholder="Last Name" required="">
			<br>
			<button class="btn btn-lg btn-info btn-block" type="submit">Sign up</button>
		</form>
		
		<label>
			You already have an account. <a id="login">Login</a>
		</label>
		<br>
		<label>
			Forgot password? <a id="recovery">Recovery</a>
		</label>
	</div>
</div>


<script type="text/javascript">
	$("a").click(function() {
		var clicked = $(this).attr("id");
		$("#container-form").children("div").each(function() {
			if (!($(this).attr("id").toLowerCase() == "container-" + clicked)) {
				$(this).fadeOut();
			}
			else {
				$(this).fadeIn();
			}
		});
	});

	$("#signup-form").submit(function () {
		var email = $("#signup-email").val();
		var password = $("#signup-password").val();
		var firstname = $("#signup-firstname").val();
		var lastname = $("#signup-lastname").val();
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: { "sign_up_admin": "",
				"email": email,
				"password": password,
				"firstname": firstname,
				"lastname": lastname
			}
		}).done(function(response) {
			var registered = JSON.parse(response);
			
			if (registered.username == email) {
				console.log("Response Pass, from sign up");
				signin(registered);
			}
			else {
				console.log("Response Fail, from sign up");
			}
		});

		return false;
	});

	function signin(customer) {
		$.cookie("customerid", customer.id, { expires: 15 });

		$.cookie("email", customer.username, { expires: 15 });
		$.cookie("firstname", customer.firstname, { expires: 15 });
		$.cookie("lastname", customer.lastname, { expires: 15 });

		if (customer.adminlevel != undefined)
			$.cookie("adminlevel", customer.adminlevel, { expires: 15 });

		<?php
				if (isset($_POST["back_to_location"]))
					echo "postAndRedirect();";
				else
					echo "window.location = window.location.pathname;";
		?>
		
	};
	
</script>
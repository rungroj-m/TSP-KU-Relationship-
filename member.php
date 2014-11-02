<!-- Sign in form -->
<div class="container" align="center" id="container-form">
	<div class="jumbotron" style="box-shadow: 4px 4px 6px #cccccc; width: 50%" id="container-login">
		<form class="form-signin" id="signin-form" role="form">
			<h2 class="form-signin-heading">Please sign in</h2>
			<br>
			<input type="email" class="form-control" id="signin-email" placeholder="Email Address" required="" autofocus="">
			<input type="password" class="form-control" id="signin-password" placeholder="Password" required="">
			<label class="checkbox">
				<input type="checkbox" value="remember-me">Remember me
			</label>
			<br>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		</form>
		
		<label>
			Forget password? <a id="recovery">Recovery</a>
		</label>
		<br>
		<label>
			Don't have an account? <a id="signup">Sign up now</a>
		</label>
	</div>

	<!-- Sign up form -->
	<div class="jumbotron" style="box-shadow: 4px 4px 6px #cccccc; width: 50%; display: none" id="container-signup">
		<form class="form-signin" id="signup-form" role="form">
			<h2 class="form-signin-heading">Login Information</h2>
			<br>
			<input type="email" class="form-control" id="signup-email" placeholder="Email address" required="" autofocus="">
			<input type="password" class="form-control" id="signup-password" placeholder="Password" required="">
			<input type="password" class="form-control" id="signup-password-confirm" placeholder="Password again" required="">
			<br>
			<input type="text" class="form-control" id="signup-firstname" placeholder="First Name" required="">
			<input type="text" class="form-control" id="signup-lastname" placeholder="Last Name" required="">
			<label class="checkbox">
				<input type="checkbox" value="agree">Agree
			</label>
			
			<br>
			<button class="btn btn-lg btn-info btn-block" type="submit">Sign up</button>
		</form>
		
		<label>
			You already have an account. <a id="login">Login</a>
		</label>
		<br>
		<label>
			Forget password? <a id="recovery">Recovery</a>
		</label>
	</div>

	<!-- Recovery password form -->
	<div class="jumbotron" style="box-shadow: 4px 4px 6px #cccccc; width: 50%; display: none" id="container-recovery">
		<form class="form-signin" id="recovery-form" role="form">
			<h2 class="form-signin-heading">Please input your email</h2>
			<br>
			<input type="email" class="form-control" id="recovery-email" placeholder="Email address" required="" autofocus="">
			<br>
			<button class="btn btn-lg btn-warning btn-block" type="submit">Recovery</button>
		</form>
		<label>
			Don't have an account? <a id="signup">Sign up now</a>
		</label>
		<br>
		<label>
			You already have an account. <a id="login">Login</a>
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

	$("#signin-form").submit(function () {
		var email = $("#signin-email").val();
		var password = $("#signin-password").val();
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: { "sign-in": "",
				"email": email,
				"password": password
			}
		}).done(function(response) {
			alert(response);
			signin($.parseJSON(response));
		});
		return false;
	});

	$("#signup-form").submit(function () {
		var email = $("#signup-email").val();
		var password = $("#signup-password").val();
		var firstname = $("#signup-firstname").val();
		var lastname = $("#signup-lastname").val();
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: { "sign_up": "",
				"email": email,
				"password": password,
				"firstname": firstname,
				"lastname": lastname
			}
		}).done(function(response) {
			alert(response);
			signin($.parseJSON(response));
		});

		return false;
	});

	function signin(response) {
		console.log();
		$.cookie("email", response.username, { expires: 15 });
		$.cookie("firstname", response.firstname, { expires: 15 });
		$.cookie("lastname", response.lastname, { expires: 15 });
		window.location = window.location.pathname;
	};

	$("#recovery-form").submit(function () {
		
		 return false;
	});


</script>
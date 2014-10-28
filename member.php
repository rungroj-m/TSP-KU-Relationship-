<!-- Login form -->
<div class="container" align="center" id="container-form">
	<div class="jumbotron" style="width: 50%" id="container-login">
		<form class="form-signin" role="form">
			<h2 class="form-signin-heading">Please sign in</h2>
			<br>
			<input type="username" class="form-control" placeholder="Username" required="" autofocus="">
			<input type="password" class="form-control" placeholder="Password" required="">
			<label class="checkbox">
				<input type="checkbox" value="remember-me">Remember me
			</label>
			<br>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
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
	<div class="jumbotron" style="width: 50%; display: none" id="container-signup">
		<form class="form-signin" role="form">
			<h2 class="form-signin-heading">Login Information</h2>
			<br>
			<input type="text" class="form-control" id="username" placeholder="Username" required="">
			<input type="email" class="form-control" id="email" placeholder="Email address" required="" autofocus="">
			<input type="password" class="form-control" id="password" placeholder="Password" required="">
			<input type="password" class="form-control" id="password-confirm" placeholder="Password again" required="">
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
	<div class="jumbotron" style="width: 50%; display: none" id="container-recovery">
		<form class="form-signin" role="form">
			<h2 class="form-signin-heading">Please input your email</h2>
			<br>
			<input type="email" class="form-control" id="email" placeholder="Email address" required="" autofocus="">
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
		var clicked = $(this).attr('id');
		$("#container-form").children("div").each(function() {
			if (!($(this).attr("id").toLowerCase() == "container-" + clicked)) {
				$(this).fadeOut();
			}
			else {
				$(this).fadeIn();
			}
		});
	});


</script>
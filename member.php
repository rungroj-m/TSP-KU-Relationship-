<div id="redzone" style="display: none">
	<div class="container" align="center" id="container-form">
		<!-- Sign in form -->
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
				Forgot password? <a id="recovery">Recovery</a>
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
				Forgot password? <a id="recovery">Recovery</a>
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
</div>

<?php 
	if (isset($_GET["function"])) {
		echo "
		<script type=\"text/javascript\">
			$(document).ready(function() {
				$(\"#container-form\").children(\"div\").each(function() {
					if (!($(this).attr(\"id\").toLowerCase() == \"container-\" + \"{$_GET["function"]}\")) {
						$(this).fadeOut();
					}
					else {
						$(this).fadeIn();
					}
				});
			});
		</script>
		";
	}

?>

<script type="text/javascript">
	$(document).ready(function() {
		if ($.cookie("customerid") == undefined) {
			$("#redzone").show();
		}
		else
			document.location.href = "?page=notfound"
	});
	
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
			console.log(response);
			var registered = $.parseJSON(response);
			
			if (registered.username == email) {
				console.log("Response Pass, from sign in");
				signin(registered);
			}
			else {
				console.log("Response Fail, from sign in");
			}
			
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
			var registered = $.parseJSON(response);
			
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

	$("#recovery-form").submit(function () {
		alert("Available soon");
		return false;
	});

	function postAndRedirect() {
	    var postFormStr = "<form method='POST' action='" + window.location.pathname <?php if (isset($_POST["back_to_location"])) echo "+ \"{$_POST["back_to_location"]}\""; ?> + "'>";
	    postFormStr += "<input type='hidden' name='pid' value='<?php if (isset($_POST["back_to_location"])) echo $_POST["pid"]; ?>'></input>";
	    postFormStr += "<input type='hidden' name='pn' value='<?php if (isset($_POST["back_to_location"])) echo $_POST["pn"]; ?>'></input>";
	    postFormStr += "<input type='hidden' name='p' value='<?php if (isset($_POST["back_to_location"])) echo $_POST["p"]; ?>'></input>";
	    postFormStr += "<input type='hidden' name='q' value='<?php if (isset($_POST["back_to_location"])) echo $_POST["q"]; ?>'></input>";
	    //postFormStr += "<input type='hidden' name='mq' value='<?php if (isset($_POST["back_to_location"])) echo $_POST["mq"]; ?>'></input>";
	    postFormStr += "</form>";

	    var formElement = $(postFormStr);

	    $('body').append(formElement);
	    $(formElement).submit();
	}


</script>
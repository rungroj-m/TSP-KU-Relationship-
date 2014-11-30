<html>
<head>
	<link rel="shortcut icon" type="image/png" href="image/logo.png"/>
	<title>Xtreme Sport Shop</title>
	
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<script src="js/jquery.js"></script>
	<script src="js/jquery.cookie.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script src="js/summernote.js"></script>
	<script src="bootstrap/js/bootstrap.js"></script>
	<link href="css/kurel.css" rel="stylesheet">
	<script src="js/bic_calendar.js"></script>
	<link href="css/bic_calendar.css" rel="stylesheet">
	
	<script src="js/xml2json.js"></script>
	<script src="js/json2xml.js"></script>
</head>

<style>
body {
	background-color: rgba(252, 252, 252, 0.5);
}
*{
	font-family: Lato;
}
</style>

<body>

    <!-- static for each page -->
			<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			  	<div class="container-fluid">
			  		<a class="navbar-brand" style="padding: 10;" href="#" onclick="window.location = window.location.pathname" ><img alt="Brand" id="logo" style="width: 32px; height: 32px"></a>
				    <div class="navbar-header">
					      <a class="navbar-brand" href="#" onclick="window.location = window.location.pathname" >Xtreme Sport Shop</a>
				 	</div>
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      				<ul class="nav navbar-nav">
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "shopping") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=shopping">Shopping</a></li>
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "inventory") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=inventory">Inventory</a></li>
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "news") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=news">News</a></li>
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "promotion") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=promotion">Promotion</a></li>
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "customer") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=customer">Customer</a></li>
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "member") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=member">Member</a></li>
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "profile") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=profile">Profile</a></li>
		      					<?php if (isset($_GET['page']) && $_GET['page'] == "transaction") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=transaction">Transaction</a></li>
					        </ul>
					        <ul class="nav navbar-nav navbar-right" id="username">
					        </ul>
					    </div>
				</div>
			</nav>
			<br>
			<br>
			<br>

	<!-- for content -->
	<div class="container">
	<?php
	
		if (isset($_GET['page']))
			include_once $_GET['page'] .".php";
		else {
			include_once "main.php";
		}
		
		
		
		require_once('inc/ProductDao.php');
	?>
		
		
	</div>

	<div class="footer">
      <div class="container" align="center" style="margin-top: 30px; margin-bottom: 20px">
        <p class="text-muted">Made by KU Relationship &copy; 2014</p>
      </div>
    </div>
    
    <script type="text/javascript">
		if ($.cookie("customerid") != undefined) {
			
			$("#username").html("<li><a>Hi, " + $.cookie("firstname") + " " + $.cookie("lastname") + "</a></li>" +
					"<li><a href=\"#\" id=\"logout\">Logout</a></li>");
			
			$('.navbar-nav li:contains("Member")').remove();
// ADMIN MODE
// 			if ($.cookie("email") != "admin@kurel.com") {
// 				$('.navbar-nav li:contains("Inventory")').remove();
// 				$('.navbar-nav li:contains("News")').remove();
// 				$('.navbar-nav li:contains("Promotion")').remove();
// 				$('.navbar-nav li:contains("User")').remove();
// 			}
		}
		else {
			$('.navbar-nav li:contains("Profile")').remove();
		}

		$("#logout").click(function() {
			$.removeCookie("customerid");
			$.removeCookie("email");
			$.removeCookie("firstname");
			$.removeCookie("lastname");
			window.location = window.location.pathname;
		});

		function index() {
			window.location.pathname;
		}

		$(document).ready(function() {
			$("#logo").attr("src", window.location.pathname.replace("index.php", "") + "/image/logo.png");
		});

    </script>
</body>


</html>





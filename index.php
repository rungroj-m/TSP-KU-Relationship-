
<html>
<head>
	<link href="bootstrap/css/bootstrap.css" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap-dropdown.js"></script>
	<script>
	   $(function(){
	      $(".dropdown-toggle").dropdown('toggle');
	      }); 
	</script>
</head>

<style>
body {
	background-color: rgba(2, 2, 0, 0.5);
}
.tftextinput{
	margin: 0;
	padding: 5px 15px;
	font-family: Arial, Helvetica, sans-serif;
	font-size:17px;
	border:1px solid #0076a3; border-right:1px solid #0076a3;
	border-top-left-radius: 5px 5px;
	border-bottom-left-radius: 5px 5px;
	border-top-right-radius: 5px 5px;
	border-bottom-right-radius: 5px 5px;
}
*{
	font-family: Lato;
}
</style>

<body>

    <!-- static for each page -->
			<nav class="navbar navbar-inverse" role="navigation">
			  	<div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
					      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						        <span class="sr-only">Toggle navigation</span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
					      </button>
					      <a class="navbar-brand" href="?page=index">Ku Realtionship</a>
				 	</div>
					    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      				<ul class="nav navbar-nav">
					        <?php if (isset($_GET['page']) && $_GET['page'] == "shopping") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=shopping">Shopping</a></li>
					        <?php if (isset($_GET['page']) && $_GET['page'] == "inventory") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=inventory">Inventory</a></li>
					        <?php if (isset($_GET['page']) && $_GET['page'] == "login") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=login">Login</a></li>
					        <?php if (isset($_GET['page']) && $_GET['page'] == "signups") echo "<li class=\"active\">"; else echo "<li>"; ?><a href="?page=signups">SignUp</a></li>
					    </div>
				</div>
			</nav>
			<div align = "center">
			 <img src="logo.png" alt="logo" style="width:304px;height:228px">
    		</div>

	<div style="margin: 10px; padding : 5px">
		<div class="row">
			<div class="col-xs-6 col-sm-4" align = "right" >
  				<div class="btn-group btn-group-sm" >
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" align = right>
				    Category <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" style="background-color: black" role="menu">
				    <li><a value="volvo" href="#" style = "color : white">Shirt</a></li>
				    <li><a value="saab" href="#" style = "color : white">Equipment</a></li>
				    <li><a value="mercedes" href="#" style = "color : white">Balls</a></li>
				    <li><a value="audi" href="#" style = "color : white">Forbidden stuffs</a></li>
				  </ul>
				</div>      
			</div> 


  				<div class="col-xs-6 col-sm-4">
  					<div class="input-group input-group-sm">
					     <input type="text" class="form-control">
					     <span class="input-group-btn">
					     	<button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"/></button>
					     </span>
					</div>
				</div>	    
		</div>
		<!--
			<form name="input" action="search" method="get" >
			 <select class = "tftextinput">
				<option value="volvo">Shirt</option>
				<option value="saab">Equipment</option>
				<option value="mercedes">Balls</option>
				<option value="audi">Forbidden stuffs</option>
			</select> 
			<input type="text" class = "tftextinput" name="user" size = "40" placeholder="Search for an item">
				<input type="image" src="http://i.imgur.com/YQMZRzI.png" alt="Submit Form" >
			</form> 
		-->
	</div>
	<!-- for content -->
	<div id="content" style="background-color: gray; margin: 10px">
	<?php
	
		if (isset($_GET['page']))
		include_once $_GET['page'] .".php";
		
	
		
	?>
		
		
	</div>

</body>

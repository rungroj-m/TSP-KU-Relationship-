
<html>
<head>
</head>

<style>
body {
	background-image: url(http://i.imgur.com/KjfSAxM.png)
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

h1{
background-color: pink;
margin: 10px; 
padding : 5px; 
border: 1px solid black;
}

h2{
margin: 10px;
padding : 5px
}

</style>

<body>

	<h1>
    <!-- static for each page -->

        <Center><font size = "25">KU-RELATIONSHIP</font></Center><br>
		<div align="right" >
			<a href="?page=shopping"><img src="http://i.imgur.com/KePc1Ps.png"/></a>
			<a href="?page=inventory"><img src="http://i.imgur.com/FRzI8aj.png"/></a>
			<a href="?page=login"><img src="http://i.imgur.com/ivQ59CY.png"/></a>
			<a href="?page=signup"><img src="http://i.imgur.com/c9GPkX7.png"/></a>
		</div>

	</h1>
    
	<h2>
	
		<div align="center">
			
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
		</div>

	</h2>
    
	<!-- for content -->
	<div id="content" style="background-color: gray; margin: 10px">
	<?php
	
		if (isset($_GET['page']))
		include_once $_GET['page'] .".php";
		include_once "inc/ProductDao.php";
		include_once "inc/Product.php";
		include_once "inc/Category.php";
		include_once "inc/Brand.php";
		include_once "inc/ProductDescription.php";
		$d = Product::GetEnabledProductByProductDescriptionId ( 1 );
		print_r( $d );
		
	?>
		
		
	</div>

</body>
</head>

<html>
<head>
</head>

<style>

body {
	background-image: url(http://i.imgur.com/KjfSAxM.png)
}

</style>

<body>

    <!-- static for each page -->
    <div style="background-color: pink; margin: 10px; padding : 5px;  border: 1px solid black;">
        <Center><font size = "25">KU-RELATIONSHIP</font></Center><br>
		<div align="right" >
			<a href="?page=shopping"><img src="http://i.imgur.com/KePc1Ps.png"/></a>
			<a href="?page=inventory"><img src="http://i.imgur.com/FRzI8aj.png"/></a>
			<a href="?page=login"><img src="http://i.imgur.com/ivQ59CY.png"/></a>
			<a href="?page=signup"><img src="http://i.imgur.com/c9GPkX7.png"/></a>
		</div>
    </div>
    
	<div style="margin: 10px">
	
			<div align="center">
			
			<a href="?page=login"><img src="http://i.imgur.com/E1EINEg.png" /></a>
			<a> <- Category here [searchbar here] -> button pic </a>
			<a href="?page=search"><img src="http://i.imgur.com/E1EINEg.png" /></a></div>
			
			

	</div>
    
	<!-- for content -->
	<div id="content" style="background-color: gray; margin: 10px">
	<?php
	
		if (isset($_GET['page']))
		include_once $_GET['page'] .".php";
		
	
		
	?>
		
		
	</div>

</body>
</head>
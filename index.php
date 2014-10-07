
<html>
<head>
</head>

<style>
body{
background-image: url(http://i.imgur.com/KjfSAxM.png)
}
</style>

<body>

    <!-- static for each page -->
    <div style="background-color: pink; margin: 10px">
        <Center><font size = "25">SHOPPING</font></Center><br>
			<div align="right">

			<a href="?page=shopping"><img src="http://i.imgur.com/KePc1Ps.png" />  </a>
			<a href="?page=inventory"><img src="http://i.imgur.com/FRzI8aj.png" />  </a> </div>

			</div>
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
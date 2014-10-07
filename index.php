
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
        <Center><font size = "25">KU-RELATIONSHIP</font></Center><br>
			<div align="right">

			<a href="?page=login"><img src="http://i.imgur.com/ivQ59CY.png" /></a>
			<a href="?page=signup"><img src="http://i.imgur.com/c9GPkX7.png" /></a> </div>

			</div>
    </div>
    
	 <div style="background-color: pink; margin: 10px">
        <Center><font size = "5">SEARCH</font></Center><br>
			<div align="center">
			
			<a href="?page=login"><img src="http://i.imgur.com/E1EINEg.png" /></a>
			<a> <- Category here [searchbar here] -> button pic </a>
			<a href="?page=login"><img src="http://i.imgur.com/E1EINEg.png" /></a></div>
			
			

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
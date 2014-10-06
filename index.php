
<html>
<head>
</head>
<body>

    <!-- static for each page -->
    <div style="background-color: pink; margin: 10px">
        header<br>
        <a href="?page=shopping">Shopping:front</a>
        <a href="?page=inventory">Inventory:back</a>
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
<form action = "inventory.php" method = "GET">
<input name="searchbox" type="text" placeholder="input please"><br>
<input name="search" type="submit" value="search"><br>
<a href="add.php">Add</a><br><br>

<!-- productbox template
<div style="width: 200px; height: 250px; background-color: green; padding-top: 10px; margin: 20px" align="center">
	<div id="pic" style="width: 180px; height: 180px; background-color: red">
	pic
	</div>
	
	<div id="name">
	productName
	</div>
	
	<div id="price">
	10$
	</div>
	
	<button type="button">SELECT</button>
</div>
-->


<?php
	echo 'kuy';
	require_once ('inc/Product.php');
	echo 'kuy';
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	
	
	function createProductBox($product) {
		echo "
		<div style=\"width: 200px; height: 250px; background-color: green; padding-top: 10px; margin: 20px\" align=\"center\">
		<div id=\"pic\" style=\"width: 180px; height: 180px; background-color: red\">
		pic
		</div>
		
		<div id=\"name\">
		$product->productDescription->productName
		</div>
		
		<div id=\"price\">
		$product->price
		</div>
		
		<button type=\"button\">SELECT</button>
		</div>
				
		";
	}
	echo 'asdjdsfjnfdajknl';
	
	//Category::CreateCategory( )
	$c = Category::CreateCategory("catName");
	print_r ( $c );
	/*
	
	$b = Brand::CreateBrand("brandName");
	
	$pd = ProductDescription::CreateProductDescription($c, $b, "$description", "$modelCode", "$productName");
	$p = Product::CreateProduct($pd, 100);
	print_r($p);*/

?>

</form>
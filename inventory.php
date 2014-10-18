<form>
<input name="searchbox" type="search" placeholder="input please"><br>
</form>

<a href="JavaScript:newPopup('add.php');">Add</a><br><br>

<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,menubar=no,location=no,directories=no,status=yes')
}
</script>

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

<div id="productBoxContainer" style="background-color: aqua;">

<?php

	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	$productdescs = ProductDescription::GetProductDescriptionsByCategoryId(3);	
	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		createProductBox($product);
	}
	
	
	function createProductBox($product) {
		echo "
		<div id = \"inventory\" style=\"width: 200px; height: 250px; background-color: green; padding-top: 10px; margin: 20px; display: inline-block\" align=\"center\">
		<div id=\"pic\" style=\"width: 180px; height: 180px; background-color: red\">
		pic
		</div>
		
		<div id=\"name\">
		{$product->productDescription->productName}
		</div>
		
		<div id=\"price\">
		$product->price
		</div>

		
		<button type=\"button\" onclick=\"newPopup('add.php?edit=" . $product->id . "');\">EDIT</button>
		</div>
				
		";
	}
	
	/*$c = Category::CreateCategory("catName");
	print_r ( $c );
	
	
	$b = Brand::CreateBrand("brandName");
	
	$pd = ProductDescription::CreateProductDescription($c, $b, "description", "modelCode", "productName");
	$p = Product::CreateProduct($pd, 100);
	print_r($p); */

?>
</div>


</form>
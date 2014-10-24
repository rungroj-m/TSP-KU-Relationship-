<?php
if (isset($_POST["get_product_by_category_for_shopping"])) {
	
	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	$productdescs = ProductDescription::GetProductDescriptionsByCategoryId($_POST["get_product_by_category_for_shopping"]);
	
	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		createProductBoxForShopping($product);
	}
	
}

if (isset($_POST["get_product_by_category_for_inventory"])) {

	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');

	$productdescs = ProductDescription::GetProductDescriptionsByCategoryId($_POST["get_product_by_category_for_inventory"]);

	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		createProductBoxForInventory($product);
	}

}

function createProductBoxForShopping($product) {
	$productId = $product->id;
	$productName = $product->productDescription->productName;
	$price = $product->price;
	
	
	echo "
	<div style=\"width: 200px; height: 250px; border-radius: 6px; background-color: #eee; padding-top: 10px; margin: 20px; display: inline-block\" align=\"center\">
	
	<!-- May change link of pic to product desc page -->
   	<img style=\"width: 180px; height: 180px; background-color: white; border-radius: 3px;\" src=\"http://cdn2.hubspot.net/hub/100473/file-1257668303-png/images/Apple.png\" alt=\"$productName\" href=\"#\">
  
	<div id=\"name\">$productName</div>

	<div id=\"price\">&#3647;$price</div>

	<button type=\"button\" class=\"btn btn-success\" onclick=\"addToCart($productId, '$productName', $price);\">ADD</button>
	</div>

	";
}

function createProductBoxForInventory($product) {
	$productId = $product->id;
	$productName = $product->productDescription->productName;
	$price = $product->price;


	echo "
	<div style=\"width: 200px; height: 250px; border-radius: 6px; background-color: #eee; padding-top: 10px; margin: 20px; display: inline-block\" align=\"center\">

	<!-- May change link of pic to product desc page -->
	<img style=\"width: 180px; height: 180px; background-color: white; border-radius: 3px;\" src=\"http://cdn2.hubspot.net/hub/100473/file-1257668303-png/images/Apple.png\" alt=\"$productName\" href=\"#\">

	<div id=\"name\">$productName</div>

	<div id=\"price\">&#3647;$price</div>

	<button type=\"button\" class=\"btn btn-info\" onclick=\"editProduct('$productId', $price);\">EDIT</button>
	</div>

	";
}

if (isset($_POST["submit"])) {
	if ($_POST["submit"] == "add") {
		
		include_once ('inc/Product.php');
		include_once ('inc/ProductDescription.php');
		include_once ('inc/Category.php');
		include_once ('inc/Brand.php');
		
		$brand = Brand::CreateBrand($_POST['brand']);
		$category = Category::CreateCategory($_POST['category']);
		$productDesc = ProductDescription::CreateProductDescription($category, $brand, $_POST['desc'], $_POST['code'], explode(',', $_POST['tag']), $_POST['name']);
		Product::CreateProduct($productDesc, $_POST['price']);
		echo ("Product Added");
	}
	
}



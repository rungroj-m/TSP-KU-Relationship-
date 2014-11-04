<?php

if (isset($_POST["get_product_by_category_for_shopping"])) {
	
	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	$productdescs;
	if ($_POST["get_product_by_category_for_shopping"] == "")
		$productdescs = Product::GetAllProduct();
	else
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

	$productdescs;
	if ($_POST["get_product_by_category_for_inventory"] == "")
		$productdescs = Product::GetAllProduct();
	else
		$productdescs = ProductDescription::GetProductDescriptionsByCategoryId($_POST["get_product_by_category_for_inventory"]);
	

	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		createProductBoxForInventory($product);
	}

}

if (isset($_POST["search_product_for_shopping"])) {
	
	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	$cat = $_POST["category"];
	$str = $_POST["search_product_for_shopping"];
	if($str == ""){
		if($cat == "Category" || $cat == "All") {
			echo(1);
			$productdescs = Product::GetAllProduct();
		}
		else{
			echo(2);
				$productdescs = ProductDescription::SearchByTags( array($cat) );
			}
	}
	else{
		$str = explode(",", $str);
		if(!($cat == "Category" || $cat == "All")) {
			echo(3);	
			array_push($str, $cat);
			echo($str);
			$productdescs = ProductDescription::SearchByTags( $str );
		}
		else {
			echo(4);
			$productdescs = ProductDescription::SearchByTags( $str );
		}
	}
	

	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		createProductBoxForInventory($product);
	}
}

if (isset($_POST["search_product_for_inventory"])) {

	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');

	$cat = $_POST["category"];
	$str = $_POST["search_product_for_inventory"];
	if($str == ""){
		if($cat == "Category" || $cat == "All") {
			echo(1);
			$productdescs = Product::GetAllProduct();
		}
		else{
			echo(2);
			$productdescs = ProductDescription::SearchByTags( array($cat) );
		}
	}
	else{
		$str = explode(",", $str);
		if(!($cat == "Category" || $cat == "All")) {
			echo(3);
			array_push($str, $cat);
			echo($str);
			$productdescs = ProductDescription::SearchByTags( $str );
		}
		else {
			echo(4);
			$productdescs = ProductDescription::SearchByTags( $str );
		}
	}


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
	<div class=\"thumbnail\" style=\"box-shadow: 2px 2px 5px #cccccc; width: 200px; height: 250px; border-radius: 6px; background-color: #eee; padding-top: 10px; margin: 20px; display: inline-block\" align=\"center\">
	
	   	<a href=\"?page=detail&id=$productId\">
	   		<!-- May change link of pic to product desc page -->
	   		<img style=\"width: 180px; height: 180px; background-color: white; border-radius: 3px;\" src=\"{$product->productDescription->images[0]}\">
	  
			<div id=\"name\">$productName</div>
		</a>
	
		<div id=\"price\">&#3647;$price</div>
	
		<button type=\"button\" class=\"btn btn-success\" onclick=\"addToCart($productId, '$productName', $price, 1);\">ADD</button>
	</div>

	";
	
}

function createProductBoxForInventory($product) {
	$productId = $product->id;
	$productName = $product->productDescription->productName;
	$price = $product->price;
	
	
	echo "
	<div class=\"thumbnail\" style=\"box-shadow: 2px 2px 5px #cccccc; width: 200px; height: 250px; border-radius: 6px; background-color: #eee; padding-top: 10px; margin: 20px; display: inline-block\" align=\"center\">

		<!-- May change link of pic to product desc page -->
		<img style=\"width: 180px; height: 180px; background-color: white; border-radius: 3px;\" src=\"{$product->productDescription->images[0]}\">
	
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
		ProductDescription::AddImages($productDesc->id, array( $_POST['image'] ));
		Product::CreateProduct($productDesc, $_POST['price']);
		echo ("Product Added");
	}
	
}

if (isset($_POST["get_product_detail_by_id"])) {

	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');

	$product = Product::GetProduct($_POST["get_product_detail_by_id"]);
	$productdescs = $product->productDescription;
	$desc = str_replace('"', '\"', $productdescs->description);
	echo "
	{
		\"id\" : {$_POST["get_product_detail_by_id"]},
		\"name\" : \"{$productdescs->productName}\",
		\"code\" : \"{$productdescs->modelCode}\",
		\"price\" : {$product->price},
		\"description\" : \"{$desc}\",
		\"image\" : \"{$product->productDescription->images[0]}\",
		\"category\" : \"{$productdescs->category->value}\",
		\"tag\" : \"{$productdescs->additiontag}\",
		\"quantity\" : 0,
		\"brand\" : \"{$productdescs->brand->value}\"
	}";

}

if (isset($_POST["sign_up"])) {
	require_once ('inc/CustomerDao.php');
	require_once ('inc/Customer.php');
	
	$result = Customer::CreateCustomer($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"]);
	echo "
	{
		\"id\" : {$result->id},
		\"username\" : \"{$result->username}\",
		\"firstname\" : \"{$result->firstName}\",
		\"lastname\" : \"{$result->lastName}\"
	}";
}

if (isset($_POST["sign-in"])) {
	require_once ('inc/CustomerDao.php');
	require_once ('inc/Customer.php');
	
	$result = Customer::Authenticate($_POST["email"], $_POST["password"]);
	echo "
	{
		\"id\" : {$result->id},
		\"username\" : \"{$result->username}\",
		\"firstname\" : \"{$result->firstName}\",
		\"lastname\" : \"{$result->lastName}\"
	}";
}






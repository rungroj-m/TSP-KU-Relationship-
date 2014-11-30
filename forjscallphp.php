<?php
// // search should use search product for
// if (isset($_POST["get_product_by_category_for_shopping"])) {
	
// 	require_once ('inc/Product.php');
// 	require_once ('inc/ProductDescription.php');
// 	require_once ('inc/Category.php');
// 	require_once ('inc/Brand.php');
	
// 	$product;
// 	if ($_POST["get_product_by_category_for_shopping"] == ""){
// 		$product = Product::GetAllProduct();
// 	}
// // 	else{
		
// // 		$productdesc = ProductDescription::GetProductDescriptionsByCategoryId($_POST["get_product_by_category_for_shopping"]);
// // 		foreach($productdesc as $pdesc){
// // 			array_push($product,Product::GetEnabledProductByProductDescriptionId($pdesc->$pid));
// // 		}
// //	}
// 	foreach ($product as $p) {
// // 		echo("test");
// // 		print_r($p);
// //		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
// 		createProductBoxForShopping($p);
// 	}
	
// 	if (count($product) == 0)
// 		echo "No result.";
// }

// if (isset($_POST["get_product_by_category_for_inventory"])) {

// 	require_once ('inc/Product.php');
// 	require_once ('inc/ProductDescription.php');
// 	require_once ('inc/Category.php');
// 	require_once ('inc/Brand.php');

// 	$product;
// 	if ($_POST["get_product_by_category_for_inventory"] == "")
// 		$product = Product::GetAllProduct();
// // 	else
// // 		$productdescs = ProductDescription::GetProductDescriptionsByCategoryId($_POST["get_product_by_category_for_inventory"]);
	

// 	foreach ($product as $p) {
// 		createProductBoxForInventory($p);
// 	}

// 	if (count($product) == 0)
// 		echo "No result.";
// }

if (isset($_POST["search_product_for_shopping"])) {
	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	require_once ('inc/WishList.php');
	require_once ('inc/Customer.php');
	require_once ('inc/CustomerDao.php');
	
	$cat = $_POST["category"];
	$str = $_POST["search_product_for_shopping"];
	$customerId = $_POST["customer_id"];
	$productdescs = array();
	if ($str == "") {
		if ($cat == "Category" || $cat == "All") {
			$product = Product::GetAllProduct();
			foreach ($product as $p){
				array_push($productdescs, $p->productDescription);
			}
		}
		else {
			$productdescs = ProductDescription::SearchByTags(array($cat));
		}
	}
	else {
		$str = array_map( 'trim', explode(",", $str) );
		
		if (!($cat == "Category" || $cat == "All")) {
			array_push($str, $cat);
			$productdescs = ProductDescription::SearchByTags($str);
		}
		else {
			$productdescs = ProductDescription::SearchByTags($str);
		}
	}
	
	$wishList = WishList::GetWishListFromCustomer(Customer::GetCustomer($customerId));
// 	print_r($wishList);
// 	$productandquan = $wishList->GetProducts();
// 	print_r($productandquan);
	
	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		
		
		$isWish = $wishList->isWish($product);
		
		createProductBoxForShopping($product, $isWish);
	}

	
	
	if (count($productdescs) == 0)
		echo "No result.";
}

if (isset($_POST["search_product_for_inventory"])) {

	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');

	$cat = $_POST["category"];
	$str = $_POST["search_product_for_inventory"];
	$productdescs = array();
	if ($str == "") {
		if ($cat == "Category" || $cat == "All") {
			$product = Product::GetAllProduct();
			foreach ($product as $p) {
				array_push($productdescs, $p->productDescription);
			}		
		}
		else{
			$productdescs = ProductDescription::SearchByTags(array($cat));
		}
	}
	else {
		$str = explode(",", $str);
		array_map( 'trim', $tags_str );
		if (!($cat == "Category" || $cat == "All")) {
			array_push($str, $cat);
			$productdescs = ProductDescription::SearchByTags($str);
		}
		else {
			$productdescs = ProductDescription::SearchByTags($str);
		}
	}

	foreach ($productdescs as $p) {
		$product = Product::GetEnabledProductByProductDescriptionId($p->id);
		createProductBoxForInventory($product);
	}
	
	if (count($productdescs) == 0)
		echo "No result.";
}

function createProductBoxForShopping($product, $isWish) {
	if (!($product -> id))
		return "";
	require_once ('inc/Inventory.php');
	include_once ('inc/InventoryDao.php');
	
	$productId = $product->id;
	$productName = $product->productDescription->productName;
	$price = $product->price;
	$imageLen = count($product->productDescription->images);
	$maxQuan = Inventory::getQuntity($productId);
	
	$buttonStatus = $maxQuan > 0 ? "" : "disabled";
	
	if ($isWish)
	echo "
			
	<div class=\"thumbnail productbox\">
	
	   	<a href=\"?page=detail&id=$productId\">
	   		<!-- May change link of pic to product desc page -->
	   		<img src=\"{$product->productDescription->images[$imageLen-1]}\">
	   		<span style=\"position: relative; top: -20px; left: 80px;\" class=\"glyphicon glyphicon-heart\"></span>
			<div class=\"name\" id=\"name\">$productName</div>
		</a>
	
		<div id=\"price\">&#3647;$price</div>
	
		<button type=\"button\" class=\"btn btn-success\" onclick=\"addToCart($productId, '$productName', $price, 1/*, $maxQuan*/);\" $buttonStatus>ADD</button>
	</div>

	";

	else
	echo "
		
	<div class=\"thumbnail productbox\">
	
	<a href=\"?page=detail&id=$productId\">
		<!-- May change link of pic to product desc page -->
		<img src=\"{$product->productDescription->images[$imageLen-1]}\">
		<div class=\"name\" id=\"name\">$productName</div>
	</a>

		<div id=\"price\">&#3647;$price</div>

		<button type=\"button\" class=\"btn btn-success\" onclick=\"addToCart($productId, '$productName', $price, 1/*, $maxQuan*/);\" $buttonStatus>ADD</button>
	</div>
	
	";
	
}

function createProductBoxForInventory($product) {
	if (!($product -> id))
		return "";
	$productId = $product->id;
	$productName = $product->productDescription->productName;
	$price = $product->price;
	
	$images = $product->productDescription->images;
	$imageLen = count($product->productDescription->images);
	
	$coverImage;
	if ( $images == null || count ( $images ) < 1 ) {
		$coverImage = 'image/logo.png';
	} else {
		$coverImage = $product->productDescription->images[$imageLen-1];
	}
	echo "
	<div class=\"thumbnail productbox\">

		<!-- May change link of pic to product desc page -->
		<img src=\"{$coverImage}\">
	
		<div class=\"name\" id=\"name\">$productName</div>
	
		<div id=\"price\">&#3647;$price</div>
	
		<button type=\"button\" class=\"btn btn-info\" onclick=\"editProduct('$productId');\">EDIT</button>
		<button type=\"button\" class=\"btn btn-Danger\" onclick=\"removeProduct('$productId');\">REMOVE</button>
	</div>

	";
}

if (isset($_POST["submit"])) {
	if ($_POST["submit"] == "add") {
		include_once ('inc/Product.php');
		include_once ('inc/ProductDescription.php');
		include_once ('inc/Category.php');
		include_once ('inc/Brand.php');
		include_once ('inc/Inventory.php');
		include_once ('inc/InventoryDao.php');
		$brand = Brand::CreateBrand($_POST['brand']);
		$category = Category::CreateCategory($_POST['category']);
		$productDesc = ProductDescription::CreateProductDescription( $category, $brand, $_POST['desc'], $_POST['code'], array_map( 'trim', explode(',', $_POST['tag']) ), $_POST['name'] ,$_POST['weight']);
		$productDesc->addImages( array( $_POST['image'] ) );
		$product = Product::CreateProduct($productDesc, $_POST['price']);
		Inventory::addProduct($product, $_POST['quan'] );
	}
	if ($_POST["submit"] == "edit") {
		include_once ('inc/ProductDescription.php');
		include_once ('inc/Product.php');
		include_once ('inc/Category.php');
		include_once ('inc/Brand.php');
		include_once ('inc/Inventory.php');
		include_once ('inc/InventoryDao.php');
		
		$id = $_POST["id"];
		$product = Product::GetProduct($id);
		$productdescs = $product->productDescription;
		$product = Product::ReplaceActiveProduct($productdescs, $_POST["price"]);
		Inventory::addProduct($product, $_POST["quan"]);
		$productdescs -> productName = $_POST["name"];
		$productdescs -> modelCode = $_POST["code"];
		$productdescs -> description = $_POST["desc"];
		$productdescs -> addImages(array($_POST["image"]));
		$productdescs -> category = Category::CreateCategory($_POST["category"]);
		$productdescs -> additionTags = array_map( 'trim', explode(',', $_POST['tag']) );
		$productdescs -> brand = Brand::CreateBrand($_POST["brand"]);
		$productdescs -> weight = $_POST['weight'];
		$productdescs -> updateData();
		
		//print_r($productdescs);
		//echo ("Product Edited");
	}
	
}

if (isset($_POST["get_product_detail_by_id"])) {

	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	require_once ('inc/Inventory.php');
	include_once ('inc/InventoryDao.php');
	
	$product = Product::GetProduct($_POST["get_product_detail_by_id"]);
	$productdescs = $product->productDescription;
	$quan = Inventory::getQuntity($product->id);
	$desc = str_replace('"', '\"', $productdescs->description);
	
// 	print_r($product);
// 	print_r($productdescs);
// 	print_r($quan);
// 	echo($desc);
	
	$tags_str = implode("\", \"", $productdescs->additionTags);
	$imageLen = count($product->productDescription->images);
	
	echo "
	{
		\"id\" : {$_POST["get_product_detail_by_id"]},
		\"name\" : \"{$productdescs->productName}\",
		\"code\" : \"{$productdescs->modelCode}\",
		\"price\" : {$product->price},
		\"description\" : \"{$desc}\",
		\"image\" : \"{$product->productDescription->images[$imageLen-1]}\",
		\"category\" : \"{$productdescs->category->value}\",
		\"tag\" : [\"$tags_str\"],
		\"weight\" : $productdescs->weight,
		\"quantity\" : $quan,
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
	
// 	var_dump($_POST);
	
	$result = Customer::Authenticate($_POST["email"], $_POST["password"]);
	echo "
	{
		\"id\" : {$result->id},
		\"username\" : \"{$result->username}\",
		\"firstname\" : \"{$result->firstName}\",
		\"lastname\" : \"{$result->lastName}\"
	}";
}

if (isset($_POST["remove"])) {
	require_once('inc/Product.php');
	require_once('inc/ProductDao.php');
	
	Product::GetProduct($_POST["remove"])->disable();
}

if (isset($_POST["get_promotion"])) {
	echo '[{"date":"27\/2\/","title":"Getting Contacts Barcelona - test1","link":"http:\/\/gettingcontacts.com\/events\/view\/barcelona","color":"red"},{"date":"25\/5\/","title":"test2","link":"http:\/\/gettingcontacts.com\/events\/view\/barcelona","color":"pink"},{"date":"20\/6\/","title":"test2","link":"http:\/\/gettingcontacts.com\/events\/view\/barcelona","color":"green"},{"date":"7\/10\/","title":"test3","link":"http:\/\/gettingcontacts.com\/events\/view\/barcelona","color":"blue","class":"miclasse ","content":"contingut popover';
}

if (isset($_POST["get_all_product_in_cart"])) {
	require_once ('inc/CustomerDao.php');
	require_once ('inc/Customer.php');
	require_once ('inc/Cart.php');
	require_once ('inc/InventoryDao.php');
	require_once ('inc/Product.php');
	require_once ('inc/ProductDao.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	$customer = Customer::GetCustomer($_POST["get_all_product_in_cart"]);
	$products = $customer->getCart()->GetProducts();
	
	echo json_encode($products);
}

if (isset($_POST["add_to_cart"])) {
	require_once ('inc/CustomerDao.php');
	require_once ('inc/Customer.php');
	require_once ('inc/Cart.php');
	require_once ('inc/InventoryDao.php');
	require_once ('inc/Product.php');
	require_once ('inc/ProductDao.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');

	$customer = Customer::GetCustomer($_POST["add_to_cart"]);
	$cart = $customer->getCart();
	
	$product = Product::GetProduct($_POST["product_id"]);
	$amount = $_POST["quantity"];
	
	if ($amount > 0) {
		$cart->AddProduct($product, $amount);
	}
	else if ($amount < 0) {
		$cart->RemoveProduct($product, -1 * $amount);
	}
}

if (isset($_POST["clear-cart"])) {
	require_once ('inc/CustomerDao.php');
	require_once ('inc/Customer.php');
	require_once ('inc/Cart.php');
	require_once ('inc/InventoryDao.php');
	require_once ('inc/Product.php');
	require_once ('inc/ProductDao.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');

	$customer = Customer::GetCustomer($_POST["clear-cart"]);
	$cart = $customer->getCart();
	$cart->ClearProducts();
}

if (isset($_POST["confirm-payment"])) {
	include_once 'inc/CreditCard.php';
	include_once 'inc/Customer.php';
	include_once 'inc/CustomerDao.php';
	include_once 'inc/Cart.php';
	include_once 'inc/Sale.php';
	require_once ('inc/InventoryDao.php');
	require_once ('inc/Product.php');
	require_once ('inc/ProductDao.php');
	require_once ('inc/Promotion.php');
	require_once ('inc/PaymentDao.php');
	require_once ('inc/Payment.php');
	
	$card = CreditCard::CreateCreditCard($_POST["name"], $_POST["number"], $_POST["cvv"], $_POST["expYear"], $_POST["expMonth"]);
	$customer = Customer::GetCustomer($_POST['customerid']);
	$cart = $customer->getCart();
	$cart->setFee($_POST["fee"]);
	$sale = $cart->purchase($card);
	if($cart !== null){
		echo("ok");
	}else{
		echo("verify fail or not enough money please change to other credit card");
	}
}

if (isset($_POST["get_wishlist_product"])) {
	require_once ('inc/WishList.php');
	require_once ('inc/Customer.php');
	require_once ('inc/CustomerDao.php');
	require_once ('inc/InventoryDao.php');
	require_once ('inc/Product.php');
	require_once ('inc/ProductDao.php');
	
	$customerId = $_POST["get_wishlist_product"];
	
	$wishlist = Customer::GetCustomer($customerId)->getWishList();
	$products = $wishlist -> GetProducts();
	
	foreach ($products as $p) {
		createProductBoxForWishList($p["Product"], $p["Quantity"]);
	}
	
	if (count($products) == 0)
		echo "No result.";
}

if (isset($_POST["add_to_wishlist"])) {
	require_once ('inc/WishList.php');
	require_once ('inc/Customer.php');
	require_once ('inc/CustomerDao.php');
	require_once ('inc/InventoryDao.php');
	require_once ('inc/Product.php');
	require_once ('inc/ProductDao.php');
	
	$customerId = $_POST["add_to_wishlist"];
	$productId = $_POST["product_id"];
	$wishlist = Customer::GetCustomer($customerId) -> getWishList();
	$wishlist -> addProduct(Product::GetProduct($productId), 1);
}

function createProductBoxForWishList($product, $wishQuan) {
	if (!($product -> id))
		return "";
	require_once ('inc/Inventory.php');
	include_once ('inc/InventoryDao.php');

	$productId = $product->id;
	$productName = $product->productDescription->productName;
	$price = $product->price;
	$imageLen = count($product->productDescription->images);
	$maxQuan = Inventory::getQuntity($productId);

	$buttonStatus = $maxQuan > 0 ? "" : "disabled";

	
	echo "
		
	<div class=\"thumbnail productbox\">

	<a href=\"?page=detail&id=$productId\">
	<!-- May change link of pic to product desc page -->
	<img src=\"{$product->productDescription->images[$imageLen-1]}\">
	 
	<div class=\"name\" id=\"name\">$wishQuan $productName</div>
	</a>

	<div id=\"price\">&#3647;$price</div>

	<button type=\"button\" class=\"btn btn-success\" onclick=\"addToCart($productId, '$productName', $price, 1/*, $maxQuan*/);\" $buttonStatus>ADD</button>
	<button type=\"button\" class=\"btn btn-Danger\" onclick=\"removeWishProduct('$productId');\">REMOVE</button>
	</div>

	";

}

if (isset($_POST["remove_wish"])) {
	$customerId = isset($_POST["remove_wish"]);
	$productId = isset($_POST["product_id"]);
	$wishlist = WishLists::GetWishListFromCustomer(Customer::GetCustomer($customerId));
	$wishlist -> RemoveProduct(Product::GetProduct($productId),1);
	////
}

if (isset($_POST["sign_up_admin"])) {
	require_once ('inc/CustomerDao.php');
	require_once ('inc/Admin.php');
	$result = Admin::CreateAdmin($_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password"],1);
	echo "
	{
	\"id\" : {$result->id},
	\"username\" : \"{$result->username}\",
	\"firstname\" : \"{$result->firstName}\",
	\"lastname\" : \"{$result->lastName}\"
	}";
}


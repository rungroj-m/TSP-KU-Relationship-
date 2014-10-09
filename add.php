<html>
<body>
<?php
require_once ('inc/Product.php');
require_once ('inc/ProductDao.php');
	if (isset($_GET['edit'])) {
		$result = Product::GetProduct($_GET['edit']);
	}
	
	
?>

Add Product 
<form action = "add.php" method = "POST">
<?php if (isset($_GET['edit'])) echo "<input type=\"hidden\" name=\"id\" value=\"{$result->id}\">" ?>
name:	<input name="name" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->productName}"; ?>"><br>
-code:	<input name="code" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->modelCode}"; ?>"><br>
-price: <input name="price" type="number" value="<?php if (isset($_GET['edit'])) echo "{$result->price}"; ?>"><br>
-description:	<input name="desc" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->description}"; ?>"><br>
<!-- category,brand need get and tag / quantity doesn't have attribute. -->
-category   <input name="category" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->category->value}"; ?>"><br>
-tag:	<input name="tag" type="text" value="<?php if (isset($_GET['edit'])) echo "something like tag"; ?>"><br>
-quantity:	<input name="quan" type="text" value="<?php if (isset($_GET['edit'])) echo "something like quantity"; ?>"><br>
-brand:	<input name="brand" type="text" value="<?php if (isset($_GET['edit'])) echo "{$result->productDescription->brand->value}"; ?>"><br>
<input name ="submit" type="submit" value="<?php echo (isset($_GET['edit']) ? "Save" : "Add"); ?>">
<!-- Cannot clear in edit mode -->
<input name ="reset" type="reset" value="Clear">
<?php if (isset($_GET['edit'])) echo "<input type=\"submit\" name=\"action\" value=\"Delete\" />"; ?>
</form>
    


<?php 


// 	require_once ('inc/Product.php');
	require_once ('inc/ProductDescription.php');
	require_once ('inc/Category.php');
	require_once ('inc/Brand.php');
	
	if (isset($_POST['submit'])) {
		$brand = Brand::CreateBrand($_POST['brand']);
		$category = Category::CreateCategory($_POST['category']);
		$productDesc = ProductDescription::CreateProductDescription($category, $brand, $_POST['desc'], $_POST['code'], explode(',', $_POST['tag']), $_POST['name']);
		Product::CreateProduct($productDesc, $_POST['price']);
		
		echo ("Product Added");
	}
	
	if (isset($_POST['action']))
			echo "kuy benz delete gu la";
		//NEED fucking delete method u dick
?>

</body>
</head>
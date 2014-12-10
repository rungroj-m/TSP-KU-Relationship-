<?php
	if (!isset($_GET["id"])) {
		echo "
			<script type=\"text/javascript\">
				window.location = window.location.pathname;	
			</script>		
		";
	}
	
	require_once ('inc/Inventory.php');
	include_once ('inc/InventoryDao.php');
	$maxQuan = Inventory::getQuntity($_GET["id"]);
	
	echo "
			<script type=\"text/javascript\">
				var maxQuan = $maxQuan;
			</script>
	";

?>
<div id="redzone" style="display: none">
	<br>
	
	<div class="row">
		<div class="col-md-2">
			<div class="btn-group btn-group-sm" style="width: 100%">
				<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
					<qq>Category</qq> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" id="category-dropdown" role="menu" style="width: 100%">
					<li><a>Clothes</a></li>
				    <li><a>Equipments</a></li>
				    <li><a>Balls</a></li>
				    <li><a>Others</a></li>
				    <li><a>All</a></li>
				</ul>
			</div>      
		</div> 
	
		<div class="col-md-10">
			<div class="input-group input-group-sm">
				<input type="text" class="form-control" id="search-box">
				<span class="input-group-btn">
					<button id="search-button" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"/></button>
				</span>
			</div>
		</div>	    
	</div>
	
	<br>
	
	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Product Information</h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<div class="thumbnail">
								<img id="image" style="width: 100%; background-color: white; border-radius: 3px;" src="">
							</div>
						</div>
						<div class="col-md-6">
							<h3>Name: <span id="name"></span></h3>
							<h4>Brand: <span id="brand"></span></h4>
							<h6>Model Code: <span id="code"></span></h6>
							<br>
							<h5>Category: <span id="category"></span></h5>
							<h5>Weight: <span id=weight></span> grams</h5>
							<br>
							<h5>Stock: <span id="quantity"></span></h5>
							<h5>Price: <span id="price"></span></h5>
							
							<div class="row">
								<div class="col-md-6" id="wish-button-div">
									<div class="input-group">
										<input type="number" class="form-control" id="wish" value="0" min="1" max="10">
										<span class="input-group-btn">
											<button type="button" class="btn btn-primary" id="wish_button" style="width: 100%" onclick="addToWish(<?php echo $_GET["id"]; ?>);">
												<span class="glyphicon glyphicon-heart"></span>Add to Wish
											</button>
										</span>
									</div>
								</div>
								
								<div class="col-md-6" id="add-button-div">
									<div class="input-group">
										<input type="number" class="form-control" id="quan" value="1" min="0">
										<span class="input-group-btn">
											<button type="button" class="btn btn-success" id="add-button" onclick="addToCart(<?php echo $_GET["id"]; ?>, 0);">ADD</button>
										</span>
									</div>
								</div>
							
							
							</div>
							
						</div>
					</div>
					<br>
					<h5>Tag: <span id="tag">Warning</span></h5>
					<br>
					<p id="description"></p>
					<br>
					<br>
					<div class="jumbotron">
						Comment & Like & Share
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-3">
			<div class="panel panel-default" id="signin-div">
				<div class="panel-heading">
					<h3 class="panel-title">Signin</h3>
				</div>
				<div class="panel-body">
					<form class="form-signin" id="signin-form" role="form">
						<input type="email" class="form-control" id="signin-email" placeholder="Email Address" required="" autofocus="">
						<input type="password" class="form-control" id="signin-password" placeholder="Password" required="">
						<!-- <label class="checkbox">
							<input type="checkbox" value="remember-me">Remember me
						</label> -->
						<br>
						<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
					</form>
					
					<label>
						Forgot password? <a href="?page=member&function=recovery">Recovery</a>
					</label>
					<br>
					<label>
						Don't have an account? <a href="?page=member&function=signup">Sign up now</a>
					</label>
				</div>
			</div>
		
			<div class="panel panel-default" id="cart-div">
				<div class="panel-heading">
					<h3 class="panel-title">Cart</h3>
				</div>
				<div class="panel-body">
					<table class="table">
						<tbody id="cart">
							<tr>
								<th>Product</th>
								<th>Q.</th>
								<th>U.P.</th>
								<th></th>
							</tr>
						</tbody>
					</table>
					
					<table class="table">
						<tr>
							<th>Total</th>
							<th id="total">&#3647;0</th>
						</tr>
					</table>
					
					<table class="table">
						<tr>
							<th><button type="button" class="btn btn-success" id="button-checkout" style="width: 100%">Check Out</button></th>
							<th><button type="button" class="btn btn-danger" id="button-clear-cart" style="width: 100%">Clear</button></th>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Confirm Clar Cart -->
	<div class="modal fade" id="clear-cart-confirm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Clear Cart</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure to clear cart item(s)?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" id="button-confirm-clear-cart">Clear</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Alert signin -->
	<div class="modal fade" id="alert-signin">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Login</h4>
				</div>
				<div class="modal-body">
					<p>Sign in to ADD product?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
					<button type="button" class="btn btn-primary" id="signin-button" onclick="postAndRedirectToSignin();">Yes</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {
		if ($.cookie("adminlevel") == undefined) {
			$("#redzone").show();
		}
		else
			document.location.href = "?page=notfound"
	});

	var product;
	function aj() {
	$.ajax({
		url: 'forjscallphp.php',
		type: "POST",
		data: { "get_product_detail_by_id": <?php echo $_GET["id"]; ?> }
	}).done(function(response) {
		product = $.parseJSON(response);
// 		alert(response);
	    $("#name").html(product.name);
	    $("#code").html(product.code);
	    $("#price").html(product.price);
	    $("#description").html(product.description);
	    $("#image").attr("src", product.image);
	    $("#category").html(product.category);

	    var tags_str = "";
	    for (var i in product.tag) {
	    	tags_str += "&nbsp;<span class=\"label label-warning\">" + product.tag[i] + "</span>&nbsp;";
	    }
	    
	    $("#tag").html(tags_str);
	    $("#weight").html(product.weight);
	    $("#quantity").html(product.quantity);
	    $("#brand").html(product.brand);

	    <?php 
    		if (isset($_POST["pid"]))
    			echo "addToCart({$_POST["q"]});";
	    ?>
	});
	}

	var pid, pn, p, q//, mq;
	function addToCart(productId, quantity) {
		if ($("#quan").val() == 0)
			return;
		if (quantity == 0)
			quantity = Number($("#quan").val());
			
		var productName = product.name;
		var price = product.price;

		if ($.cookie("email") == undefined) {
			$("#alert-signin").modal({
				show: true
			});
			pid = productId; pn = productName; p = price; q = quantity;/* mq = <?php //echo Inventory::getQuntity($_GET["id"]); ?>*/;
		}
		else {
			$.ajax({
				url: 'forjscallphp.php',
				type: "POST",
				data: {
					"add_to_cart": $.cookie("customerid"),
					"product_id": productId,
					"quantity": quantity
				}
			}).done(function(response) {
// 				showAllProductsInCart();
				location.reload();
			});
		}
	}

	$("#category-dropdown li").click(function() {
		$("#dropdown qq").text($(this).text());
	});

	$("#search-box").keypress(function(event) {
		// 13 means ENTER
		if (event.which == 13) {
			postAndRedirectToShopping();
		}
	});
	
	$("#search-button").click(function() {
		postAndRedirectToShopping();
	});

	$("#button-clear-cart").click(function() {
	    $("#clear-cart-confirm").modal({
		    show: true
		});
		$("#button-confirm-clear-cart").focus();
	});

	$("#button-confirm-clear-cart").click(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"clear-cart": $.cookie("customerid")
			}
		}).done(function(products_json) {
			$("#cart").empty();
			$("#cart").append("\
				<tr>\
					<th>Product</th>\
					<th>Q.</th>\
					<th>U.P.</th>\
				</tr>\
			");
	
			$("#total").text("\u0E3F0");
			
			$("#clear-cart-confirm").modal('hide');
		});
	});

	$(document).ready(function() {
		showAllProductsInCart();
		<?php 
				if (!isset($_POST["pid"]))
					echo "aj();";
		?>

		if ($.cookie("customerid") == undefined) {
			$("#wish-button-div").remove();
			$("#add-button-div").removeClass("col-md-6");
			$("#add-button-div").addClass("col-md-12");

			$("#cart-div").remove();
		}
		else {
			$("#signin-div").remove();
		}

		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"is_wish": $.cookie("customerid"),
				"productId": <?php echo $_GET["id"]; ?>
			}
		}).done(function(wishNum) {
			if (wishNum != 0) {
				$("#wish_button").attr('disabled','disabled');
				$("#wish").attr('value', Number(wishNum));
			}
			
		});
	});

	function showAllProductsInCart() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_all_product_in_cart": $.cookie("customerid")
			}
		}).done(function(products_json) {
			$("#cart").empty();
			$("#cart").append("\
				<tr>\
					<th>Product</th>\
					<th>Q.</th>\
					<th>U.P.</th>\
					<th></th>\
				</tr>\
			");

			var array = JSON.parse(products_json);
			var total = 0;
			for (var i = 0; i < array.length; i++) {

				var productName = array[i].Product.productDescription.productName;
				var quantity = array[i].Quantity;
				var unitprice = array[i].Product.price;

				var pid = array[i].Product.id;
				
				$("#cart").append(
						"<tr>" +
							"<th>" + productName + "</th>" +
							"<th>" + quantity + "</th>" +
							"<th>" + unitprice + "</th>" +
							"<th>" +
								"<span class=\"label alert-danger\" onclick=\"addToCart(" + pid + ", -1);\">-</span>" +
								"<span class=\"label alert-success\" onclick=\"addToCart(" + pid + ", 1);\">+</span>" +
							"</th>" +
						"</tr>"
				);
				total += quantity * unitprice;
			}
			$("#total").text("\u0E3F" + total);
		});
	}
	
	function postAndRedirectToShopping() {
	    var postFormStr = "<form method='POST' action='" + window.location.pathname + "?page=shopping'>";
	    postFormStr += "<input type='hidden' name='search_redirect' value='value'></input>";
	    postFormStr += "<input type='hidden' name='str' value='" + $("#search-box").val() + "'></input>";
	    postFormStr += "<input type='hidden' name='cat' value='" + $("#dropdown qq").text() + "'></input>";
	    postFormStr += "</form>";

	    var formElement = $(postFormStr);

	    $('body').append(formElement);
	    $(formElement).submit();
	}
	
	$("input[type=number]").on("mousewheel", function(e) {
	    $(this).blur(); 
	});

	function addToWish(productId) {
		alert($.cookie("customerid"));
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"add_to_wishlist": $.cookie("customerid"),
				"product_id": productId,
				"quantity": $("#wish").val() > 10 ? 10 : $("#wish").val()
			}
		}).done(function(response) {
			location.reload();
			alert(productId + " added to wish ");
		});
	}

	function postAndRedirectToSignin() {
	    var postFormStr = "<form method='POST' action='" + window.location.pathname + "?page=member'>";
	    postFormStr += "<input type='hidden' name='back_to_location' value=\"?page=detail&id=" + pid + "\"></input>";
	    postFormStr += "<input type='hidden' name='pid' value='" + pid + "'></input>";
	    postFormStr += "<input type='hidden' name='pn' value='" + pn + "'></input>";
	    postFormStr += "<input type='hidden' name='p' value='" + p + "'></input>";
	    postFormStr += "<input type='hidden' name='q' value='" + q + "'></input>";
	    postFormStr += "<input type='hidden' name='mq' value='" + mq + "'></input>";
	    postFormStr += "</form>";

	    var formElement = $(postFormStr);

	    $('body').append(formElement);
	    $(formElement).submit();
	}

	function postAndRedirect() {
	    var postFormStr = "<form method='POST' action='" + window.location.pathname + "?page=member'>";
	    postFormStr += "<input type='hidden' name='back_to_location' value='?page=shopping'></input>";
	    postFormStr += "<input type='hidden' name='pid' value='" + pid + "'></input>";
	    postFormStr += "<input type='hidden' name='pn' value='" + pn + "'></input>";
	    postFormStr += "<input type='hidden' name='p' value='" + p + "'></input>";
	    postFormStr += "<input type='hidden' name='q' value='" + q + "'></input>";
	    postFormStr += "<input type='hidden' name='mq' value='" + mq + "'></input>";
	    postFormStr += "</form>";

	    var formElement = $(postFormStr);

	    $('body').append(formElement);
	    $(formElement).submit();
	}

	$("#button-checkout").click(function() {
		window.location.href = "?page=payment";
	});

	$("#signin-form").submit(function () {
		var email = $("#signin-email").val();
		var password = $("#signin-password").val();
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: { "sign-in": "",
				"email": email,
				"password": password
			}
		}).done(function(response) {
			console.log(response);
			var registered = $.parseJSON(response);
			
			if (registered.username == email) {
				console.log("Response Pass, from sign in");
				signin(registered);
			}
			else {
				console.log("Response Fail, from sign in");
			}
			
		});
		
		return false;
	});

	function signin(customer) {
		$.cookie("customerid", customer.id, { expires: 15 });

		$.cookie("email", customer.username, { expires: 15 });
		$.cookie("firstname", customer.firstname, { expires: 15 });
		$.cookie("lastname", customer.lastname, { expires: 15 });

		if (customer.adminlevel != undefined)
			$.cookie("adminlevel", customer.adminlevel, { expires: 15 });

		location.reload();
		
	};
</script>
						
<?php
	if ($maxQuan == 0) {
		echo "
			<script type=\"text/javascript\">
				$(document).ready(function() {
					$(\"#add-button\").attr(\"disabled\", \"disabled\");
				});
			</script>
		";
	}
?>

<?php 
	if (isset($_POST["pid"]))
		echo "
			<script type=\"text/javascript\">
				$(document).ready(function() {
					aj();
				});
			</script>
	";

?>




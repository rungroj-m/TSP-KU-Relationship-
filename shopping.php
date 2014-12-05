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
					<h3 class="panel-title">Shopping</h3>
				</div>
				
				<div class="panel-body">
					<div id="productBoxContainer">
					</div>
				</div>
				
				<nav align="right">
					<ul class="pagination">
					</ul>
				</nav>
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
							<td><button type="button" class="btn btn-success" id="button-checkout" style="width: 100%">Check Out</button></td>
							<td><button type="button" class="btn btn-danger" id="button-clear-cart" style="width: 100%">Clear</button></td>
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
					<button type="button" class="btn btn-primary" id="signin-button" onclick="postAndRedirect();">Yes</button>
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
			document.location.href = "?page=inventory"
	});

	$(document).ready(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			async: false,
			data: {
				"get_num_page": "",
				"s": <?php echo isset($_GET["s"]) ? "\"{$_GET["s"]}\"" : "\"\"" ?>,
				"c": <?php echo isset($_GET["c"]) ? "\"{$_GET["c"]}\"" : "\"All\"" ?>
			}
		}).done(function(num) {
			$("#productBoxContainer").append(num + " Result(s).<br> ");
			
			var p = GET_P();
			var max =  Math.ceil(num/30);
			
			if (p == 1)
				$(".pagination").append('<li class="disabled"><a><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>');
			else
				$(".pagination").append('<li><a onclick="p(1);"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>');
				
			for (var i = 1; i <= max; i++) {
				if (i == p)
					$(".pagination").append('<li class="active"><a onclick="p(' + i + ');">' + i + '</a></li>');
				else 
					$(".pagination").append('<li><a onclick="p(' + i + ');">' + i + '</a></li>');
			}

			if (p == max)
				$(".pagination").append('<li class="disabled"><a><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>');
			else
				$(".pagination").append('<li><a onclick="p(' + max + ');"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>');
		});
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"search_product_for_shopping": <?php echo isset($_GET["s"]) ? "\"{$_GET["s"]}\"" : "\"\"" ?>,
				"category": <?php echo isset($_GET["c"]) ? "\"{$_GET["c"]}\"" : "\"All\"" ?>,
				"customer_id": $.cookie("customerid") == undefined ? 0 : $.cookie("customerid"),
				"page": <?php echo isset($_GET["p"]) ? ($_GET["p"]-1)*30 + 1 : 1 ?>
						
			}
		}).done(function(response) {
		    $("#productBoxContainer").append(response);
		});

		<?php
			if (isset($_GET["c"])) {
				echo "$(\"#dropdown qq\").text(\"{$_GET["c"]}\");";
			}
			
			if (isset($_GET["s"])) {
				echo "$(\"#search-box\").val(\"{$_GET["s"]}\");";
			}
			
		?>
	});
	
	var pid, pn, p, q/*, mq*/;
	function addToCart(productId, productName, price, quantity/*, maxQuan*/) {
		if ($.cookie("customerid") == undefined) {
			$("#alert-signin").modal({
				show: true
			});
			pid = productId; pn = productName; p = price; q = quantity;// mq = maxQuan;
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
				showAllProductsInCart();
			});
		}
	}

	$("#category-dropdown li").click(function() {
		$("#dropdown qq").text($(this).text());
		search($("#dropdown qq").text(), $("#search-box").val(), <?php echo isset($_GET["p"]) ? $_GET["p"] : "\"-\""; ?>);
	});

	$("#search-box").keypress(function(event) {
		// 13 means ENTER
		if (event.which == 13) {
			search($("#dropdown qq").text(), $("#search-box").val(), <?php echo isset($_GET["p"]) ? $_GET["p"] : "\"-\""; ?>);
		}
	});
	
	$("#search-button").click(function() {
		search($("#dropdown qq").text(), $("#search-box").val(), <?php echo isset($_GET["p"]) ? $_GET["p"] : "\"-\""; ?>);
	});

	function p(p) {
// 		alert(p);
		search("-", "-", p);
	}

	function search(category, search, p) {
		document.location.href = "?page=shopping" + (category == "-" ? "&c=" + $("#dropdown qq").text() : "&c=" + category) + (search == "-" ? "&s=" + $("#search-box").val() : "&s=" + search) + (p == "-" ? "" : "&p=" + p);                                
	}

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
		if ($.cookie("customerid") == undefined) {
			$("#wish-button-div").remove();
			$("#add-button-div").removeClass("col-md-6");
			$("#add-button-div").addClass("col-md-12");

			$("#cart-div").remove();
		}
		else {

			showAllProductsInCart();
				
			$("#signin-div").remove();
		}
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
								"<span class=\"label alert-danger\" onclick=\"addToCart(" + pid + ", '" + productName + "', " + unitprice + ", -1);\">-</span>" +
								"<span class=\"label alert-success\" onclick=\"addToCart(" + pid + ", '" + productName + "', " + unitprice + ", 1);\">+</span>" +
							"</th>" +
						"</tr>"
				);
				total += quantity * unitprice;
			}
			$("#total").text("\u0E3F" + total);
		});
	}
	
	function postAndRedirect() {
	    var postFormStr = "<form method='POST' action='" + window.location.pathname + "?page=member'>";
	    postFormStr += "<input type='hidden' name='back_to_location' value='?page=shopping'></input>";
	    postFormStr += "<input type='hidden' name='pid' value='" + pid + "'></input>";
	    postFormStr += "<input type='hidden' name='pn' value='" + pn + "'></input>";
	    postFormStr += "<input type='hidden' name='p' value='" + p + "'></input>";
	    postFormStr += "<input type='hidden' name='q' value='" + q + "'></input>";
	    //postFormStr += "<input type='hidden' name='mq' value='" + mq + "'></input>";
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

	function GET_P(){
	    if (window.location.href.split("&p=")[1] == undefined)
		    return 1;
	    else
		    return window.location.href.split("&p=")[1];
	}
</script>

<?php 
	if (isset($_POST["search_redirect"])) {
		echo "
			<script type=\"text/javascript\">
				function search_redirect() {
					$.ajax({
						url: 'forjscallphp.php',
						type: 'POST',
						data: {
							'search_product_for_shopping': '{$_POST['str']}',
							'category': '{$_POST['cat']}'
						}
					}).done(function(response) {
					//alert(response);
					    $('#productBoxContainer').html(response);
					});
				}
				
				search_redirect();
			</script>
		";
	}


?>

<?php 
	if (isset($_POST["pid"]))
		echo "
			<script type=\"text/javascript\">
				$(document).ready(function() {
					addToCart({$_POST["pid"]}, \"{$_POST["pn"]}\", {$_POST["p"]}, {$_POST["q"]});//, {$_POST["mq"]});
				});
			</script>
	";

?>



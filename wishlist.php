
<br>

<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Wist List</h3>
			</div>
			<div class="panel-body">
				<div id="productBoxContainer">
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-3">
		<div class="panel panel-default">
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

<!-- Confirm Remove Wish Product -->
<div class="modal fade" id="remove-wish-product-confirm">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Remove Wished Product</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure to remove wished product?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="button-confirm-remove-wish-product" val="" >Remove</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
// 	$.ajax({
// 		url: 'forjscallphp.php',
// 		type: "POST",
// 		data: {
// 			"search_product_for_shopping": "",
// 			"category": "All"
// 		}
// 	}).done(function(response) {
// 	    $("#productBoxContainer").html(response);
// 	});
	
// 	var pid, pn, p, q/*, mq*/;
// 	function addToCart(productId, productName, price, quantity/*, maxQuan*/) {
// 		if ($.cookie("customerid") == undefined) {
// 			$("#alert-signin").modal({
// 				show: true
// 			});
// 			pid = productId; pn = productName; p = price; q = quantity;// mq = maxQuan;
// 		}
// 		else {
// 			$.ajax({
// 				url: 'forjscallphp.php',
// 				type: "POST",
// 				data: {
// 					"add_to_cart": $.cookie("customerid"),
// 					"product_id": productId,
// 					"quantity": quantity
// 				}
// 			}).done(function(response) {
// 				showAllProductsInCart();
// 			});
// 		}
// 	}

// 	$("#category-dropdown li").click(function() {
// 		$("#dropdown qq").text($(this).text());
// 		search();
// 	});

// 	$("#search-box").keypress(function(event) {
// 		// 13 means ENTER
// 		if (event.which == 13) {
// 			search();
// 		}
// 	});
	
// 	$("#search-button").click(function() {
// 		search();
// 	});

// 	function search() {
// 		$.ajax({
// 			url: 'forjscallphp.php',
// 			type: "POST",
// 			data: {
// 				"search_product_for_shopping": $("#search-box").val(),
// 				"category": $("#dropdown qq").text()
// 			}
// 		}).done(function(response) {
// 		    $("#productBoxContainer").html(response);
// 		});
// 	}

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
		showWishList();
	});

	function showWishList() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_wishlist_product": $.cookie("customerid")
			}
		}).done(function(response) {
			$("#productBoxContainer").html(response);
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

	function removeWishProduct(productId) {
		$("#remove-wish-product-confirm").modal({
		    show: true
		});
		$("#button-confirm-remove-wish-product").attr("val", productId);
	}

	$("#button-confirm-remove-wish-product").click(function() {
		var productId = $("#button-confirm-remove-wish-product").attr("val");
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"remove_wish": $.cookie("customerid"),
				"product_id": productId
			}
		}).done(function(response) {
			alert(productId + " removed " +response);
		});
		$("#remove-wish-product-confirm").modal('hide');
	});
		
	
</script>

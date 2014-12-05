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
		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Menu</h3>
				</div>
				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked" id="menu">
						<li><a id="menu-add">Add Product</a></li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Inventory</h3>
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
	</div>
	
	<!-- Add Product popup -->
	<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" style="width: 950px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Product</h4>
				</div>
				<div class="modal-body">
					<iframe id="frame" src="" frameborder="0" style="width: 100%; height: 500px"></iframe>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Confirm Remove Product -->
	<div class="modal fade" id="remove-product-confirm">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Remove Product</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure to remove product?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-danger" id="button-confirm-remove-product" val="" >Remove</button>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		if ($.cookie("adminlevel") != undefined) {
			$("#redzone").show();
		}
		else
			document.location.href = "?page=notfound"
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
				"search_product_for_inventory": "",
				"category": "All",
				"page": <?php echo isset($_GET["p"]) ? ($_GET["p"]-1)*30 + 1 : 1?>
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
		document.location.href = "?page=inventory" + (category == "-" ? "&c=" + $("#dropdown qq").text() : "&c=" + category) + (search == "-" ? "&s=" + $("#search-box").val() : "&s=" + search) + (p == "-" ? "" : "&p=" + p);                                
	}

	function search(category, search, p) {
		document.location.href = "?page=inventory" + (category == "-" ? "&c=" + $("#dropdown qq").text() : "&c=" + category) + (search == "-" ? "&s=" + $("#search-box").val() : "&s=" + search) + (p == "-" ? "" : "&p=" + p);                                
	}

	$("#menu-add").click(function() {
		$("#popup").on("shown.bs.modal", function () {
	        $("#frame").attr("src", "add.php");
		});
		
	    $("#popup").modal({
		    show: true
		});
	});

	window.closeModal = function(){
	    $("#popup").modal('hide');
	};

	function editProduct(productId) {
		$("#popup").on("shown.bs.modal", function () {
	        $("#frame").attr("src", "add.php?id=" + productId);
		});
		
	    $("#popup").modal({
		    show: true
		});
	}
	
	function removeProduct(productId) {
		$("#remove-product-confirm").modal({
		    show: true
		});
		$("#button-confirm-remove-product").attr("val", productId);
	}

	$("#button-confirm-remove-product").click(function() {
		var productId = $("#button-confirm-remove-product").attr("val");
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"remove": productId
			}
		}).done(function(response) {
			alert(productId + " removed " +response);
		});
		$("#remove-product-confirm").modal('hide');
	});

	function GET_P(){
	    if (window.location.href.split("&p=")[1] == undefined)
		    return 1;
	    else
		    return window.location.href.split("&p=")[1];
	}
</script>






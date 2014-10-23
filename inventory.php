<br>

<div class="row">
	<div class="col-md-2">
		<div class="btn-group btn-group-sm" style="width: 100%">
			<button type="button" id="dropdown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="width: 100%">
				Category <span class="caret"></span>
			</button>
			<ul class="dropdown-menu" id="category-dropdown"style="background-color: black" role="menu">
				<li><a style = "color: white">Shirt</a></li>
			    <li><a style = "color: white">Equipment</a></li>
			    <li><a style = "color: white">Balls</a></li>
			    <li><a style = "color: white">Forbidden stuffs</a></li>
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
		</div>
	</div>
</div>


<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Product</h4>
			</div>
			<div class="modal-body">
				<iframe id="frame" src="" frameborder="0" style="width: 550px; height: 525px"></iframe>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		</div>
</div>




<script type="text/javascript">
	$.ajax({
		url: 'forjscallphp.php',
		type: "POST",
		data: { "get_product_by_category": "3" }
	}).done(function(response) {
	    $("#productBoxContainer").html(response);
	});
	
	$("#category-dropdown li").click(function() {
		alert($(this).text());
	});

	$("#search-button").click(function() {
		alert($("#search-box").val());
	});

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

	
</script>






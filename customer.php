<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a>Customer List</a></li>
					<li><a>Block List</a></li>
					<li><a>Admin List</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	
	<div class="col-md-9" id="content">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">User List</h3>
			</div>
			<div class="panel-body">
			body
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$("#add").click(function() {
		$("#add-div").fadeIn();
		$(this).parent().addClass("active");
	});

</script>
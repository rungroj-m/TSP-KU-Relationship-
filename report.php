<div class="row" id="redzone" style="display: none">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a id="date">By Date</a></li>
					<li><a id="month">By Month</a></li>
					<li><a id="year">By Year</a></li>
					<li><a id="product">By Product</a></li>
					<li><a id="customer">By Customer</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	<div class="col-md-9" id="content">
		<div class="panel panel-default" id="div-date">
			<div class="panel-heading">
				<h3 class="panel-title">Report by Date</h3>
			</div>
			<div class="panel-body">
			
			
				<div class="content-date"></div>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-month" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Report by Month</h3>
			</div>
			<div class="panel-body">
				<div class="content-month"></div>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-year" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Report by Year</h3>
			</div>
			<div class="panel-body">
				<div class="content-year"></div>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-product" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Report by Product</h3>
			</div>
			<div class="panel-body">
				<div class="content-product"></div>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-customer" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Report by Customer</h3>
			</div>
			<div class="panel-body">
				<div class="content-customer"></div>
			</div>
		</div>
	</div>
	
</div>

<script type="text/javascript">

	$(document).ready(function() {
		if ($.cookie("adminlevel") == 2) {
			$("#redzone").show();
		}
		else
			document.location.href = "?page=notfound"
	});

	$("#menu li").click(function() {
		var clicked = $(this).children("a").attr("id");
		$("#content").children("div").each(function() {
			if (!($(this).attr("id").toLowerCase() == "div-" + clicked)) {
				$(this).fadeOut();
			}
			else {
				$(this).fadeIn();
			}
		});

		var that = this;
		$("#menu li").each(function() {
			if (!(this == that)) {
				$(this).removeClass("active");
			}
			else {
				$(this).addClass("active");
			}
		});
	});


	// Get transactions
	$(document).ready(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			data: {
				"get_transaction_by_daterange": "",
				"start":"2013-12-17 19:19:22",
				"end": "2014-12-17 19:19:22"
			}
		}).done(function(trans) {
			var tdate = JSON.parse(trans);
			console.log(tdate);
		});
	});
	
</script>

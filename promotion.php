<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a id="calendar">Add Promotion</a></li>
					<li><a id="detail">See all promotions</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	
	<div class="col-md-9" id="content">
		<div class="panel panel-default" id="div-calendar">
			<div class="panel-heading">
				<h3 class="panel-title">Calendar</h3>
			</div>
			<div class="panel-body">
				<div id="calendari_lateral1"></div>
			</div>
			<br>
			<div id="div-new">
				<div class="row" style="margin: 20px">
					<div class="col-md-8">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-calendar"></span></span>
							<input type="text" class="form-control" id="date-show" placeholder="Date range" disabled>
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
							<input type="number" class="form-control" id="discount-value" placeholder="Discount" required="">
							<span class="input-group-addon">%</span>
						</div>
					</div>
				</div>
				<div class="row" style="margin: 20px">
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
							<input type="text" class="form-control" id="title-value" placeholder="Title">
						</div>
					</div>
					<div class="col-md-8">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
							<input type="text" class="form-control" id="description-value" placeholder="Description">
						</div>
					</div>
					<div class="col-md-12" style="padding: 20px">
						<button type="button" class="btn btn-success" id="button-add" style="width: 100%">Add</button>
					</div>
				</div>
			</div>
		</div>
		
		<div class="panel panel-default" id="div-detail" style="display: none">
			<div class="panel-heading">
				<h3 class="panel-title">Promotion Details</h3>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-bordered">
					<tbody id="detail-table">
						<tr>
							<td>ID</td>
							<td>Title</td>
							<td>Value</td>
							<td>Description</td>
							<td>Start Date</td>
							<td>End Date</td>
							<td>Add By</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">


	$(document).ready(function() {
		if ($.cookie("adminlevel") == undefined) {
			$("#div-new").remove();
		}
	});

	$(document).ready(function() {
	
	    var monthNames = ["January", "February", "March", "April", "May", "June", "Jult", "August", "September", "October", "November", "December"];
	
	    var dayNames = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
	    $('#calendari_lateral1').bic_calendar({
	        enableSelect: true,
	        multiSelect: true,
	        dayNames: dayNames,
	        monthNames: monthNames,
	        showDays: true,
	        reqAjax: true
	    });

	    document.addEventListener('bicCalendarSelect', function(e) {
	        var a = e.detail.dateFirst.getDate() + "/" + (e.detail.dateFirst.getMonth()+1) + "/" + (e.detail.dateFirst.getYear()+1900);
	        var b = e.detail.dateLast.getDate() + "/" + (e.detail.dateLast.getMonth()+1) + "/" + (e.detail.dateLast.getYear()+1900);
	        
	        start = e.detail.dateFirst;
			end = e.detail.dateLast;
			
			$("#date-show").val(a + ' - ' + b);
	    });
	});

	var start = 0;
	var end = 0;
	
	$(document).ready(function() {
		if ($.cookie("adminlevel") != undefined)
			$("#calendar").text("Add Promotion");
		else
			$("#calendar").text("Calendar");
		
		$.ajax({
			url: 'forjscallphp.php',
			type: "POST",
			async: false,
			data: {
				"get_all_promotion": ""
			}
		}).done(function(response) {
			var details = JSON.parse(response);
			
			$("#detail-table").empty();
			$("#detail-table").append("\
			<tr>\
				<td>ID</td>\
				<td>Title</td>\
				<td>Value</td>\
				<td>Description</td>\
				<td>Start Date</td>\
				<td>End Date</td>\
				<td>Add By</td>\
			</tr>");

			for (var i = 0; i < details.length; i++) {
				$("#detail-table").append("\
						<tr>\
							<td>" + details[i].id + "</td>\
							<td>" + details[i].title + "</td>\
							<td>" + details[i].value + "%</td>\
							<td>" + details[i].description + "</td>\
							<td>" + details[i].startDate.date.split(" ")[0] + "</td>\
							<td>" + details[i].endDate.date.split(" ")[0] + "</td>\
							<td>" + details[i].admin.firstName + " " + details[i].admin.lastName + "</td>\
						</tr>");
			}
		});
	    
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
	
	$("#button-add").click(function() {
		var ok = true;
		
		if (start == 0 || end == 0) {
			alert("Please select the date.");
			return;
		}

		if ($("#discount-value").val() == "") {
			alert("Please set discount value.");
			return;
        }

		for (var i = new Date(start.getYear()+1900, start.getMonth(), start.getDate()); i <= end; i.setDate(i.getDate() + 1)) {
			if (!ok)
				break;
			$.ajax({
				url: 'forjscallphp.php',
				type: "POST",
				async: false,
				data: {
					"check_overlap": (i.getYear()+1900) + "-" + ((i.getMonth()+1) < 10 ? "0" + (i.getMonth()+1) : (i.getMonth()+1)) + "-" + (i.getDate() < 10 ? "0" + i.getDate() : i.getDate()) + " 00:00:00"
				}
			}).done(function(overlap) {
				console.log((i.getYear()+1900) + "-" + ((i.getMonth()+1) < 10 ? "0" + (i.getMonth()+1) : (i.getMonth()+1)) + "-" + (i.getDate() < 10 ? "0" + i.getDate() : i.getDate()) + " 00:00:00" + " "  + overlap)
				if (overlap != 0) {
					alert("Overlap on " + i);
					ok = false;
				}
			});
		}

		if (ok) {
			$.ajax({
				url: 'forjscallphp.php',
				type: "POST",
				async: false,
				data: {
					"create_promotion": "",
					"adminid": $.cookie("customerid"),
					"start": (start.getYear()+1900) + "-" + ((start.getMonth()+1) < 10 ? "0" + (start.getMonth()+1) : (start.getMonth()+1)) + "-" + (start.getDate() < 10 ? "0" + start.getDate() : start.getDate()) + " 00:00:00",
					"end": (end.getYear()+1900) + "-" + ((end.getMonth()+1) < 10 ? "0" + (end.getMonth()+1) : (end.getMonth()+1)) + "-" + (end.getDate() < 10 ? "0" + end.getDate() : end.getDate()) + " 00:00:00",
					"value": $("#discount-value").val(),
					"title": $("#title-value").val(),
					"description": $("#description-value").val()
				}
			}).done(function(response) {
				location.reload();
			});
		}
	});
</script>
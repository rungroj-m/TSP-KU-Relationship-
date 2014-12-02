<div class="row">
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Menu</h3>
			</div>
			<div class="panel-body">
				<ul class="nav nav-pills nav-stacked" id="menu">
					<li class="active"><a id="add">Add Promotion</a></li>
					<li><a id="add">See all promotions</a></li>
				</ul>
			</div>
		</div>
	</div>
	
	
	<div class="col-md-9" id="content">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Promotions</h3>
			</div>
			<div class="panel-body">
				<div id="calendari_lateral1"></div>
			</div>
			<br>
			<div class="row" style="padding: 20px">
				<div class="col-md-9">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon glyphicon-calendar"></span></span>
						<input type="text" class="form-control" id="date-show" placeholder="Date range" disabled>
					</div>
				</div>
				<div class="col-md-3">
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-tag"></span></span>
						<input type="text" class="form-control" id="date-show" placeholder="% Discount">
					</div>
				</div>
				<div class="col-md-12" style="padding: 20px">
					<button type="button" class="btn btn-success" id="button-add" style="width: 100%">Add</button>
				</div>
			</div>
			
		</div>
	</div>
</div>


<script type="text/javascript">
$(document).ready(function() {

    var monthNames = ["January", "February", "March", "April", "May", "June", "Jult", "August", "September", "October", "November", "December"];

    var dayNames = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];

    var events = [
//         {
//             date: "28/10/2013",
//             title: 'SPORT & WELLNESS',
//             link: '',
//             color: '',
// //             content: '<img src="http://gettingcontacts.com/upload/jornadas/sport-wellness_portada.png" ><br>06-11-2013 - 09:00 <br> Tecnocampus Mataró Auditori',
//             class: '',
//         }
    ];

    $('#calendari_lateral1').bic_calendar({
        //list of events in array
        //events: events,
        //enable select
        enableSelect: true,
        //enable multi-select
        multiSelect: true,
        //set day names
        dayNames: dayNames,
        //set month names
        monthNames: monthNames,
        //show dayNames
        showDays: true,
        //set ajax call
        reqAjax: {
//             url: 'forjscallphp.php',
//             type: 'POST',
//             data: {
//     			"get_promotion": ""
//     		}
		    url: 'http://bic.cat/bic_calendar/index.php',
		    type: 'get',
        }
    });
});

</script>
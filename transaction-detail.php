

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Transaction Detail</h3>
	</div>
	<div class="panel-body" id="reciept-body">
		
		<table class="table table-striped table-bordered">
			<tbody id="orders-table">
				<tr>
					<td>#</td>
					<td>Product</td>
					<td>Quantity</td>
					<td>Unit Price</td>
					<td>Total</td>
				</tr>
			</tbody>
		</table>
		
		
		<div class="row" style="padding: 10px">
			<div class="col-md-6">
				<button type="button" class="btn btn-success" id="button-reciept" style="width: 100%">Reciept</button>
			</div>
		</div>
		
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		$.ajax({
			url: 'forjscallphp.php',
			type: 'POST',
			data: {
				'get_product_in_transaction': <?php echo $_GET["cartId"];?>
			},
			success: function(json_str2) {
				var products = JSON.parse(json_str2);
				var totalQuan = 0;
				var total = 0;
				for (var i = 0; i < products.length; i++) {
					$("#orders-table").append("\
							<tr>\
								<td>" + (i+1) + "</td>\
								<td>" + products[i].Product.productDescription.productName + "</td>\
								<td>" + products[i].Quantity + "</td>\
								<td>" + products[i].Product.price + "</td>\
								<td>" + (products[i].Quantity * products[i].Product.price) + "</td>\
							</tr>");
					totalQuan += Number(products[i].Quantity);
					total += (products[i].Quantity * products[i].Product.price);
				}
				$("#orders-table").append("\
						<tr>\
							<td></td>\
							<td>Total</td>\
							<td>" + totalQuan + "</td>\
							<td></td>\
							<td>" + total + "</td>\
						</tr>");
			}
		});

		$("#button-reciept").click(function() {
			var doc = new jsPDF();

			// We'll make our own renderer to skip this editor
			var specialElementHandlers = {
				'#editor': function(element, renderer){
					return true;
				}
			};

			var table = tableToJson($('#orders-table').get(0))
	        var doc = new jsPDF('p','pt', 'a4', true);
	        doc.cellInitialize();
	        $.each(table, function (i, row){
	            console.debug(row);
	            $.each(row, function (j, cell){
	                doc.cell(10, 50,120, 50, cell, i);  // 2nd parameter=top margin,1st=left margin 3rd=row cell width 4th=Row height
	            })
	        })


	        doc.save('sample-file.pdf');
		});
		
		function tableToJson(table) {
		    var data = [];

		    // first row needs to be headers
		    var headers = [];
		    for (var i=0; i<table.rows[0].cells.length; i++) {
		        headers[i] = table.rows[0].cells[i].innerHTML.toLowerCase().replace(/ /gi,'');
		    }


		    // go through cells
		    for (var i=0; i<table.rows.length; i++) {

		        var tableRow = table.rows[i];
		        var rowData = {};

		        for (var j=0; j<tableRow.cells.length; j++) {

		            rowData[ headers[j] ] = tableRow.cells[j].innerHTML;

		        }

		        data.push(rowData);
		    }       

		    return data;
		}
		
	});

</script>

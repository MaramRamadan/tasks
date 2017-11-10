<!DOCTYPE html>
<html>
<head>
	<title>Hotel details</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<style>
		.container,.hotelDetails{
			padding: 2%;
			margin: 2% auto;
		}
		table, th, td {
   			border: 1px solid black;
		}
		.loader img{
			width: 51px;
		}
		.loader{
			display: none;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row no-gutters">
			<div class="filter col-6 col-md-4">
				<label>Hotel Name <input name="name" class="search form-control"/></label>
				<label>City<input name="city" class="search form-control"/></label>
				<div class="row">
  					<div class="col-md-4">
						<label>Price From:<input name="from_price" class="form-control"/></label>
					</div>
					<div class="col-md-4">
						<label>To <input name="to_price" class="form-control search"/></label>
					</div>
				</div>
				<div class="row">
  					<div class="col-md-4">
						<label>Date From:<input name="from_date" class="form-control"/></label>
					</div>
					<div class="col-md-4">
						<label>To<input name="to_date" class="col-4 form-control search"/></label>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-8">
				<div class="sort_form">
					<labal>Sort By : </labal>
					<select name="hotelSort">
						<option value="--">--</option>
						<option value="price">price</option>
						<option value="name">name</option>
					</select>
				</div>
				<div class="loader">
					<img src="img/loader.gif" alt="">
				</div>
				<div class="hotelDetails">
					
				</div>
			</div>
		</div>
	</div>
</body>
<script>
function DrawData(response){
	html ="<table class='table table-hover'>";
				html+="<tr><th>name</th><th>price</th><th>city</th><th>availability</th></tr>";
				$.each(response.returnData, function(k, v) {
					html+= "<tr>"
					$.each(v , function(key,value){
						if (typeof value !== 'object') {
							text = value;	
						}else{
							availabilityInfo ="";
							$.each(value , function(availabilityKey,availabilityData){
								availabilityInfo+=availabilityData.from +" =>"+availabilityData.to+"  ,";
							});
							text = availabilityInfo;
						}
						html+= "<td>"+text+"</td>";
						
						
					});
					html+="</tr>"
			});
			html+="</table>";
			$(".hotelDetails").html(html);
}
$('select').on('change', function (e) {
	$(".hotelDetails").html('');
	$(".loader").css("display","block");
	console.log($(this).val());
	var optionSelected = $(this).val();
	$.ajax({
		url: "control.php",
		type: "GET",
		data: {action: 'sort' , optionSelected : optionSelected},
		dataType:'JSON', 
		success: function(response){
			DrawData(response);
			$(".loader").css("display","none");
		}
	}); 
});	

$('.search').on('keydown', function (e) {

	if (e.which == 13) {
		$(".hotelDetails").html('');
		$(".loader").css("display","block");
 		searchKey = $(this).attr('name');
 		if(searchKey == 'name' || searchKey === 'city'){
 			searchValue  = $("input[name='"+searchKey+"']").val();
 		}else if(searchKey === 'to_price'){
 			to_price = $("input[name='to_price']").val();
 			from_price = $("input[name='from_price']").val();
 			searchValue = from_price+"_"+to_price;
 			console.log(searchValue);
 		}else if(searchKey === 'to_date'){
 			to_date = $("input[name='to_date']").val();
 			from_date = $("input[name='from_date']").val();
 			searchValue = from_date +"_"+to_date;
 		}
		
		$.ajax({
			url: "control.php",
			type: "GET",
			data: {action: 'search' , 
					searchKey : searchKey ,
					searchValue : searchValue
				},
			dataType:'JSON', 
			success: function(response){
				DrawData(response);
				$(".loader").css("display","none");
			}
		}); 
	}
});
</script>
</html>
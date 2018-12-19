<?php
$customerid = $_GET['id'];
if ($customerid == '') { header('Location: table.html'); }
?>
<html>
	<head>
		<title>NORTHWIND : UPDATE CUSTOMER</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>&nbsp;</p>
					<p><a class="btn btn-sm btn-primary" href="table.html">&laquo; back</a></p>
					<h2>Editing : <span id="customerid-title"></span></h2>
					<p>&nbsp;</p>
					
					<p id="do-success" class="alert alert-success d-none">Data updated!</p>
					<p id="do-failed" class="alert alert-danger d-none"></p>
					
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<h4>Customer Profile</h4>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<form id="customer-form">
								  <div class="form-group row">
									<label for="username" class="col-4 col-form-label">Customer ID</label> 
									<div class="col-8">
									  <input id="CustomerID" name="CustomerID" placeholder="" class="form-control here" readonly type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="name" class="col-4 col-form-label">Company Name</label> 
									<div class="col-8">
									  <input id="CompanyName" name="CompanyName" placeholder="Company Name" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="lastname" class="col-4 col-form-label">Contact Name</label> 
									<div class="col-8">
									  <input id="ContactName" name="ContactName" placeholder="Contact Name" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="lastname" class="col-4 col-form-label">Contact Title</label> 
									<div class="col-8">
									  <input id="ContactTitle" name="ContactTitle" placeholder="Contact Title" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="text" class="col-4 col-form-label">Address</label> 
									<div class="col-8">
									  <input id="Address" name="Address" placeholder="Address" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="email" class="col-4 col-form-label">City</label> 
									<div class="col-8">
									  <input id="City" name="City" placeholder="City" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="Region" class="col-4 col-form-label">Region</label> 
									<div class="col-8">
									  <input id="Region" name="Region" placeholder="Region" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="PostalCode" class="col-4 col-form-label">Postal Code</label> 
									<div class="col-8">
									  <input id="PostalCode" name="PostalCode" placeholder="Postal Code" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="Country" class="col-4 col-form-label">Country</label> 
									<div class="col-8">
									  <input id="Country" name="Country" placeholder="Country" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="Phone" class="col-4 col-form-label">Phone</label> 
									<div class="col-8">
									  <input id="Phone" name="Phone" placeholder="Phone" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<label for="Fax" class="col-4 col-form-label">Fax</label> 
									<div class="col-8">
									  <input id="Fax" name="Fax" placeholder="Fax" class="form-control here" type="text">
									</div>
								  </div>
								  <div class="form-group row">
									<div class="offset-4 col-8">
									  <button name="submit" type="submit" class="btn btn-primary">Update Customer</button>
									</div>
								  </div>
								</form>
							</div>
						</div>
						
					</div>
				</div>

				<p>&nbsp;</p>
					
					
				</div>
			</div>
		</div>
		<script src="js/jquery.js"></script>
		<script>
		var customerid = '<?php echo $customerid;?>';
		var ajax_option = {
			url : 'http://api.mylocal.test/northwind/customer/'+customerid,
			method : 'GET'
		}
		
		$(document).ready(function(){
			
			// RUN ON PAGE LOAD, GET DATA FROM API AND UPDATE PAGE ACCORDINGLY
			$.ajax(ajax_option).done(function( data, textStatus, jqXHR ) {
				
				console.log(data);
				$('#customerid-title').html(data.customerid);
				$('#CustomerID').val( data.customerid );
				$('#CompanyName').val( data.companyname );
				$('#ContactName').val( data.contactname );
				$('#ContactTitle').val( data.contacttitle );
				$('#Address').val( data.address );
				$('#City').val( data.city );
				$('#Region').val( data.region );
				$('#PostalCode').val( data.postalcode );
				$('#Country').val( data.country );
				$('#Phone').val( data.phone );
				$('#Fax').val( data.fax );
				
			}).fail(function( data, textStatus, jqXHR ) {
				window.location.href = '/table.html';
				
			});
			
			
			// EVENT ON FORM SUBMIT -- TO SEND DATA FOR DB UPDATE VIA API
			$( "form#customer-form" ).on( "submit", function( event ) {
				event.preventDefault();
				
				var json_data = {
					'customerid' : $('#CustomerID').val(),
					'companyname' : $('#CompanyName').val(),
					'contactname' : $('#ContactName').val(),
					'contacttitle' : $('#ContactTitle').val(),
					'address' : $('#Address').val(),
					'city' : $('#City').val(),
					'region' : $('#Region').val(),
					'postalcode' : $('#PostalCode').val(),
					'country' : $('#Country').val(),
					'phone' : $('#Phone').val(),
					'fax' : $('#Fax').val()
				};
				
				//$.when( 
				
				$.ajax({
					url : 'http://api.mylocal.test/northwind/customer/'+customerid,
					method : 'PUT',
					data : JSON.stringify(json_data),
					headers : {
						"Content-Type": 'application/json',
						'Authorization' : 'Bearer '+localStorage.getItem('token')
					}
				}).done(function(data){
					$('#do-success').removeClass('d-none');
					$('#do-failed').addClass('d-none');
				}).fail(function( jqXHR, textStatus, errorThrown ) {
					$('#do-success').addClass('d-none');
					$('#do-failed').removeClass('d-none');
					$('#do-failed').html( textStatus );
					
				});
				
			});			
		});
		
		
		</script>
	</body>
<html>
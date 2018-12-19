<?php 
	session_start();

	include('inc/API_Client.php');
	$api = new API_Client('http://api.mylocal.test/northwind/');
	
	$order_id = $_GET['order_id'];
	
	$order = $api->go('order/details/'.$order_id);
		
	if (isset($order['success']) && ($order['success'] === false)) {
		include('order_not_found.php');
	} else {
		$customer = $api->go('customer/'.$order['CustomerID']);
?>
<script>
var token = '<?php echo $_SESSION['token'];?>';
</script>

<html>
<head>
	<title>INVOICE</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<!------ Include the above in your HEAD tag ---------->

	<style>
.invoice-title h2, .invoice-title h3 {
    display: inline-block;
}

.table > tbody > tr > .no-line {
    border-top: none;
}

.table > thead > tr > .no-line {
    border-bottom: none;
}

.table > tbody > tr > .thick-line {
    border-top: 2px solid;
}	
	</style>
	
</head>
<body>

<div class="container">
<!--	<div class="row">
		<div class="col-md-6">
<pre>
<?php print_r($order); ?>
</pre>
		
		</div>
		<div class="col-md-6">
<pre>
<?php print_r($customer); ?>
</pre>
		
		</div>
	</div>
	-->
    <div class="row">
        <div class="col-xs-12">
        	<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order Id # <?php echo $order['OrderID']?></h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
    				        <?php echo $customer['companyname']?><br>
    				        <?php echo $customer['contactname']?>
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
    					<?php echo $customer['address']?><br>
    					<?php echo $customer['city']?><br>
    					<?php echo $customer['region']?> <?php echo $customer['postalcode']?><br>
    					<?php echo $customer['country']?>
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					<br>
    				
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
						<?php 
							echo date('F jS, Y', strtotime($order['OrderDate']));
						?>
    					<!-- March 7th, 2018 --><br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Items</strong></td>
        							<td class="text-center"><strong>Unit Price</strong></td>
        							<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-center"><strong>Discount</strong></td>
        							<td class="text-right"><strong>Price</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
								<?php foreach($order['Details'] as $order_item) { ?>
    							<tr>
    								<td><?php echo $order_item['ProductName']?></td>
    								<td class="text-center"><?php echo number_format($order_item['UnitPrice'],2,'.',',')?></td>
    								<td class="text-center"><?php echo $order_item['Quantity']?></td>
    								<td class="text-center"><?php echo number_format($order_item['Discount'] * 100,2,'.',',')?>%</td>
    								<td class="text-right"><?php echo number_format($order_item['Total'],2,'.',',')?></td>
    							</tr>
								<?php } ?>
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right"><?php echo number_format($order['SubTotal'],2,'.',',');?></td>
    							</tr>
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Shipping</strong></td>
    								<td class="thick-line text-right"><?php echo number_format($order['Freight'],2,'.',',');?></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Total Discount</strong></td>
    								<td class="no-line text-left"><?php echo number_format($order['Discount'],2,'.',',');?></td>
    								<td class="no-line text-center"><strong>Grand Total</strong></td>
    								<td class="no-line text-right"><?php echo number_format($order['GrandTotal'],2,'.',',');?></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
</body>
</html>
<?php } ?>
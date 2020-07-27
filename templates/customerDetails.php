<?php include ('menuItems/customerMenu.html');?>
<br>

<h3 style="text-align: center">Customer Details</h3>
<p><label>Account Id:</label> {{getCustomer.CustomerID}}</p>
<p><label>Company Name:</label> {{getCustomer.CompanyName}}</p> 
<p><label>Contact Name:</label> {{getCustomer.ContactName}}</p>
<p><label>Country:</label> {{getCustomer.Country}}</p>
<p><label>Postal Code:</label> {{getCustomer.PostalCode}}</p>

<p><label>Contact:</label></p>
<p><label style="padding-left: 50px">Fax:</label> {{getCustomer.Fax}}</p>
<p><label style="padding-left: 50px">Tel:</label> {{getCustomer.Phone}}</p>

<p><button type="button" class="btn btn-primary">New Sales Order</button>
		
	</p>

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" target="_self" aria-selected="true">Order History</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" target="_self" aria-selected="false">Product History</a>
  </li>
</ul>

<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="sales-tab">
  	<table class="table">
	<tr>
		<th>Order ID</th>
		<th>Order Date</th>
		<th>Shipped Date</th>
		<th>Shipped Via</th>
	</tr>
	<tr ng-repeat="x in getOrderDetails">
		<td>{{x.OrderID}}</td>
		<td>{{x.OrderDate | date: 'dd/MM/yyyy'}}</td>
		<td>{{x.ShippedDate | date: 'dd-MM-YYYY'}}</td>
		<td>{{x.ShippedVia}}</td>
	</tr>
</table>
  </div>
  <div class="tab-pane fade show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
  	<table class="table">
	<tr>
		<th>Shipped Date</th>
		<th>Product Name</th>
		<th>Unit Price</th>
		<th>Quantity</th>
		<th>Discount</th>
		<th>Freight</th>
		<th>Amount</th>
		
		
	</tr>
	<tr ng-repeat="x in getProductHistory">
		<td>{{x.ShippedDate | date: 'dd-mm-YYYY'}}</td>
		<td>{{x.ProductName}}</td>
		<td>{{x.UnitPrice}}</td>
		<td>{{x.Quantity}}</td>
		<td>{{x.Discount}}</td>
		<td>{{x.Freight}}</td>
		<td>{{x.Pounds | currency: '£'}}</td>
		
	</tr>
</table>

  </div>
  
</div>




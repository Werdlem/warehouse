<?php include ('menuItems/customerMenu.html');?>

<br>

<p>Filter Company: <input type="" ng-model="search.CompanyName"></p>
<p><button type="button" class="btn btn-primary">New Customer</button></p>

<table class="table">
	<tr>
		<th>Customer ID</th>
		<th>Company Name</th>
		<th>Contact</th>
		<th>Phone</th>
	</tr>
	<tr ng-repeat="x in getCustomerList | filter: search:strict">
		<td><a href="/customerDetails?id={{x.CustomerID}}">{{x.CustomerID}}</td>
		<td>{{x.CompanyName}}</td>
		<td>{{x.ContactName}}</td>
		<td>{{x.Phone}}</td></a>
		
	</tr>
</table>


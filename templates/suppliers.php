<?php include ('menuItems/suppliersMenu.html'); ?>

<br>	
<p>Filter Company: <input type="" ng-model="search.CompanyName"></p>


<p><button type="button" class="btn btn-primary">New Supplier</button></p>

<table class="table">
	<tr>
		<th>Supplier Ref</th>
		<th>Company Name</th>
		<th>Contact</th>
		<th>Phone</th>
	</tr>
	<tr ng-repeat="x in s.getSupplierList | filter: search:strict">
		<td><a href="/supplierDetails?id={{x.SupplierID}}">{{x.ACCOUNT_REF}}</td>
		<td>{{x.NAME}}</td>
		<td>{{x.ContactName}}</td>
		<td>{{x.Phone}}</td></a>
		
	</tr>
</table>
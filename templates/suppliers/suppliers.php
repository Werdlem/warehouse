<?php include ('../menuItems/suppliersMenu.html'); ?>

<br>	
<p>Filter Company: <input type="" ng-model="search.NAME"></p>


<p><button type="button" class="btn btn-primary">New Supplier</button></p>

<table class="table">
	<tr>
		<th>Supplier Ref</th>
		<th>Company Name</th>
		<th>Contact</th>
		<th>Phone</th>
	</tr>
	<tr ng-repeat="x in s.getSupplierList | filter:search">
		<td><a href="/supplierDetails?id={{x.ACCOUNT_REF}}">{{x.ACCOUNT_REF}}</td>
		<td>{{x.NAME}}</td>
		<td>{{x.CONTACT_NAME}}</td>
		<td>{{x.PHONE}}</td></a>
		
	</tr>
</table>
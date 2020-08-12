  
  	<table class="table">
	<tr>
		<th>Date</th>
		<th>Quantity</th>
		<th>Details</th>
		<th>PO</th>
		<th>Notes</th>
		<th>Initials</th>
	
		
	</tr>
	
	<tr ng-repeat="x in getSkuOrderRequests">
		<div class="overflow-auto">
		<td>{{x.Date}}</td>
		<td>{{x.Qty}}</td>
		<td>{{x.Deliver}}</td>
		<td>{{x.Po}}</td>
		<td>{{x.Notes}}</td>
		<td>{{x.Initials}}</td>
		</div>
	</tr>

</table>

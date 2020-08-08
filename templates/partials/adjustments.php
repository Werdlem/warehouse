  
  	<table class="table">
	<tr>
		<th>Ajust in</th>
		<th>Adjust Out</th>
		<th>Reason</th>
		<th>Initials</th>
		<th>Date</th>
		<th></th>
		
	</tr>
	
	<tr ng-repeat="x in getSkuAdjustments">
		<div class="overflow-auto">
		<td>{{x.AdjustIN}}</td>
		<td>{{x.AdjustOut}}</td>
		<td>{{x.Reason}}</td>
		<td>{{x.Initials}}</td>
		<td>{{x.Date}}</td>
		<td><button class="btn btn-outline-danger btn-sm" ng-click="delete(x.id)">Delete</button></td>
		</div>
	</tr>

</table>
  </div>
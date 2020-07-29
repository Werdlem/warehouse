  
  	<table class="table">
	<tr>
		<th>Ajust in</th>
		<th>Adjust Out</th>
		<th>Reason</th>
		<th>Initials</th>
		<th>Date</th>
		
	</tr>
	
	<tr ng-repeat="x in getSkuAdjustments">
		<div class="overflow-auto">
		<td>{{x.AdjustIN}}</td>
		<td>{{x.AdjustOut}}</td>
		<td>{{x.Reason}}</td>
		<td>{{x.Initials}}</td>
		<td>{{x.Date}}</td>
		</div>
	</tr>

</table>
  </div>
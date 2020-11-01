<h1>Open Ncr's</h1>

<table class="table" style="width: 50%">
	<tr>	
	<th>Order No</th>
	<th>Date Opened</th>
	</tr>
	<tr ng-repeat="x in ncr.getNcrs">
		<td ng-model="x.sku"><a href="/ncrDetails?orderId={{x.po}}">{{x.po}}</td>
		<td ng-model="x.desc1">{{x.date_opened}}</td>	
	</tr>
	</table>

	</div>

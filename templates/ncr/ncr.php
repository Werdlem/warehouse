
<?php include ('../menuItems/customerMenu.html');?>
	<h3 style="text-align: center">Raise NCR</h3>

<h4>Order Search: <input type="" ng-model="findOrder" ng-change="searchOrder()"></h4>
<p>"NB:for Postpack orders, please use the prefix 'p' followed by the order number and 'd' followed by the order number for damasco"</p>
<style type="text/css">
	.table{width: 100%; text-align: left;}
	textarea{width: 350px}
	img{display:none;}	
</style>
<p>Customer: <span>{{n.getOrder[0].customer}}</span></p>
<p>Order Number: <span>{{n.getOrder[0].order_id}}</span></p>
<p>Order Date: <span>{{n.getOrder[0].order_date}}</span></p>
<div ng-show="findOrder">
Entire Order: <input type="checkbox" id="a" ng-model="entireOrder">
<table class="table" ng-hide="entireOrder">
	<tr>
	<th></th>	
	<th>SKU</th>
	<th>Description</th>
	<th>Qty</th>
	<th>Despatched</th>
	<th>Quantity</th>
    </tr>
	<tr ng-repeat="x in n.getOrder">
		<th><input type="checkbox" id="a" ng-model="x.nc" ng-change=""></th>
		<td ng-model="x.sku">{{x.sku}}</td>
		<td ng-model="x.desc1">{{x.desc1}}</td>
		<td ng-model="x.qty">{{x.qty}}</td>
		<td ng-model="x.qty">{{x.despatch}}</td>

			<td width="500px" style="position: right;">
				<div ng-show="x.nc">
					<input type="number" ng-model="qty">
				</div>					
</td>
   		
	</tr>
</div>
	</table>
	<p>Reason: <select ng-model="reason" ng-options="x.reason for x in options" ng-show="entireOrder||x.nc" ></select></p>
	<p ng-show="reason.reason=='DX'||reason.reason=='DPD'||reason.reason=='Yodel'">Issue: <input type="test" ng-show="reason.reason=='DX'||reason.reason=='DPD'||reason.reason=='Yodel'"></p>
	<p ng-show="entireOrder"> Description of Non conformance: <input type="text area"></p>
	<p><input type="textarea" ng-show="x.Damaged" name="">
	Initials: <input type="text" ng-model="initial" style="width: 40px" maxlength="2">&nbsp
	<input type="button" name="" ng-click="saved()" class="btn btn-info btn-sm" ng-disabled="initial ==null" ng-model="completed" value="Raise NCR" ></button>



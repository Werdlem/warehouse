
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
	<p ng-hide="selectProducts">Entire Order: <input type="checkbox" ng-model="entireOrder" ng-click="raiseNCR()"></p>
	<p ng-hide="entireOrder" >Select Line: <input type="checkbox"ng-model="selectProducts" ng-click="raiseNCR()"></p>
<div ng-show="findOrder">
	
<table class="table" ng-show="selectProducts">
	<tr>
	<th></th>	
	<th>SKU</th>
	<th>Description</th>
	<th>Qty</th>
	<th>Despatched</th>
	<th>Quantity</th>
    </tr>

	<tr ng-repeat="x in n.getOrder">
		<th><input type="checkbox" name="a"  ng-model="x.nc" ng-change=""></th>
		<td ng-model="x.sku">{{x.sku}}</td>
		<td ng-model="x.desc1">{{x.desc1}}</td>
		<td ng-model="x.qty">{{x.qty}}</td>
		<td ng-model="x.qty">{{x.despatch}}</td>

			<td width="500px" style="position: right;">
				<div ng-show="x.nc">
					<select ng-model="reason" ng-options="x.reason for x in options" > 
		</select> 
		<img src="/Css/images/tick.png" style="width: 5%; {{ncr.saved}}" ng-style="myStyle">
	
			<textarea ng-model="description"  placeholder="Please give short description of non-conformance" ></textarea>
			<img src="/Css/images/tick.png" style="width: 5%;" ng-style="myStyle">
			<p ng-hide="replacement"><input type="checkbox" ng-model="refund" name="corrective" > refund</p>
			<p ng-hide="refund"><input type="checkbox" ng-model="replacement" name="corrective" > replacement</p>
			<p><input type="" ng-model="details" ng-show="replacement"></p>
		</div>
   		
	</tr>
</div>
	</table>
	<p ng-show="entireOrder">Reason: <select ng-model="reason" ng-options="x.reason for x in options"  ></select></p>

	<p ng-show="reason.reason=='DX'||reason.reason=='DPD'||reason.reason=='Yodel'">Issue: <input type="test" ng-show="reason.reason=='DX'||reason.reason=='DPD'||reason.reason=='Yodel'"></p>
	<p ng-show="entireOrder"> Description of Non conformance: <input type="text area"></p>
	<p><input type="textarea" ng-show="x.Damaged" name="">
	Initials: <input type="text" ng-model="initial" style="width: 40px" maxlength="2">&nbsp
	<input type="button" name="" ng-click="saved()" class="btn btn-info btn-sm" ng-disabled="initial ==null" ng-model="completed" value="Raise NCR" ></button>



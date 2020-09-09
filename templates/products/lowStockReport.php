 <?php include '../menuItems/productsMenu.html'; ?>

 <table class="table">
 	<tr>
 		<th>Sku</th>
 		<th>Qty</th>
 		<th>Reorder Level</th>
 	</tr>
 	<tr ng-repeat="x in getLowStock">
 		<td><a href="/productDetails?SkuID={{x.SkuID}}&Sku={{x.Sku}}">{{x.Sku}}</td>
 		<td>{{x.StockQty}}</td>
 		<td>{{x.ReorderLevel}}</td>
 		
 	</tr>
 </table>
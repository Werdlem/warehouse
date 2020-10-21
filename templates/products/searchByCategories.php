<div  style="padding: 10px; border: 1px solid rgba(0,0,255,0.2); background-color: rgba(0,0,255,0.1); border-radius: 5px" >
 
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProductModal">Add Product</button>
    <button type="button" class="btn btn-primary btn-sm" ng-disabled="!selectedProduct" data-toggle="modal" data-target="#aliasModal">Add Alias</button>
    <button type="button" class="btn btn-success btn-sm" ng-disabled="!selectedProduct || selectedProduct.Discontinued==1" data-toggle="modal" data-target="#skuOrderRequestModal">New PO</button>
    <button type="button" class="btn btn-warning btn-sm" ng-disabled="!selectedProduct" data-toggle="modal" data-target="#soModal">Adjustment</button>
 
</div>
<div id="container" style="box-shadow: 4px 11px 13px 10px #d4d4d4; border-radius: 5px; padding: 15px; margin-top: 5px">
<br>
	<p>Select Category: <select ng-model="selectedCategory" ng-options="x.CategoryName for x in getCategories" ng-change="selectProduct()"></select></p>
	<div ng-show="selectedCategory">
<h3>Category List</h3>
<table class="table">
	<tr>
		<th>Sku</th>
		<th>Stock Qty</th>
		<th>Live Stock</th>
		<th>Reorder Level</th>
	</tr>
	<tr ng-repeat="x in getProducts">
		<td><a href="/productDetails?SkuID={{x.SkuID}}&Sku={{x.Sku}}">{{x.Sku}}</a></td>
		<td>{{x.StockQty}}</td>
		<td>{{x.LiveStockQty}}</td>
		<td>{{x.ReorderLevel}}</td>
	</tr>
</table>
</div>
</div>

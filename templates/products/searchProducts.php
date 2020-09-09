
 <?php include '../menuItems/productsMenu.html'; ?>


<div id="container" style="box-shadow: 4px 11px 13px 10px #d4d4d4; border-radius: 5px; padding: 15px; margin-top: 5px">
<br>
<form style="margin-top: 0em">
	Search Product: <input type="text" class="form-control" style="width: 25%; display: inline;" ng-model="selectedProduct"> <button class="btn btn-primary mb-2" ng-click="searchProduct()">Search</button>
</form>
<div ng-show="pr.getProducts">
<h1>Product Details</h1>

	<p>Product Name: <a href="/productDetails?SkuID={{pr.getProducts[0].SkuID}}&Sku={{pr.getProducts[0].Sku}}">{{pr.getProducts[0].Sku}}</a></p>
	<p>Sku Alias: <span ng-repeat="x in pr.getProducts"><strong>{{x.Alias}}</strong></span> <br/></p>
	<p>Qty in Stock: {{pr.getProducts[0].StockQty}}</p>
	<p>Location: <span ng-repeat="x in pr.getProducts"><strong> {{x.Location}} </strong><button type="button" ng-show="x.Location" class="btn btn-danger btn-sm" disabled>Delete </button></span></p>
	<p>Product Description: {{pr.getProducts[0].description}}</p>
	<p>Notes: {{pr.getProducts[0].Notes}}</p>
</div>




 <?php include '../menuItems/productsMenu.html'; ?>


<div id="container" style="box-shadow: 4px 11px 13px 10px #d4d4d4; border-radius: 5px; padding: 15px; margin-top: 5px">
<br>
	<p>Search Product: <input type="text" ng-model="selectedProduct"><button ng-click="searchProduct()">search</button></p>
<div ng-show="pr.getProducts">
<h1>Product Details</h1>

	<p>Product Name: <input type="text" ng-model="pr.getProducts[0].Sku" ng-change="editProduct(pr.getProducts[0])"style="border:0"></p>
	<p>Product Description: <input type="text" ng-model="pr.getProducts[0].description"ng-change="editProduct(pr.getProducts[0])"style="border:0"></p>
  
	<p>Sku Alias: {{pr.getProducts.Alias}} <button type="button" class="btn btn-danger btn-sm" ng-show="pr.getProducts.Alias">Del</button> </span> <br/>
	</p>
	<p>Location: <span ng-repeat="x in pr.getProducts">{{x.Location + ' '}}</span></p>
	<p>Notes: <input type="text" ng-model="pr.getProducts[0].Notes" ng-change="editProduct(pr.getProducts)"style="border:0"></p>

	<p>Discontinued:  <input type="checkBox" ng-checked="pr.getProducts[0].Discontinued==1" ng-model="pr.getProducts.Discontinued" ng-change="editProduct(pr.getProducts[0])"></p>
</div>
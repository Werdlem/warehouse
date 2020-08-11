<?php include ('../menuItems/productsMenu.html');?>
<div ng-controller="products as pr" style="padding: 10px">

	<style type="text/css">
		#addProductForm{width: 40%;}
		.form-control{ }
		
	</style>

<h3>Add Product</h3>
<div id="addProductForm">
<form ng-submit="pr.addProduct(newP)">
<p>Select Category:  <select class="form-control" ng-model="pr.newP.selectCategory" ng-options="x.CategoryName for x in getCategories"></select></p>
<p>Product Name:  <input class="form-control" type="text" ng-model="pr.newP.ProductName"></p>
<p>Quantity Per Unit:  <input class="form-control" type="text" ng-model="pr.newP.QuantityPerUnit"></p>
<p>Cost Price: <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">£
          </div>
        </div> 
        <input class="form-control" type="" ng-model="pr.newP.CostPrice"></p>
    </div>
<p>Unit Price:  <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">£
          </div>
        </div>
        <input class="form-control"  ng-model="pr.newP.UnitPrice"></p>
    </div>
<p>Units in Stock:  <input class="form-control" type="" ng-model="pr.newP.UnitsInStock"></p>
<p>Units On Order:  <input class="form-control" type="" ng-model="pr.newP.UnitsOnOrder"></p>
<p>Reorder Level:  <input class="form-control" type="" ng-model="pr.newP.ReorderLevel"></p>

<button class="btn btn-primary" type="Submit" id="submit" value="Submit" >Submit</button>
</form>
</div>
<?php include ('../menuItems/productsMenu.html');?>
<br>
<button class="btn btn-primary btn-sm" data-target="#addCategoryModal" data-toggle="modal">Add A Category</button>
<button class="btn btn-primary btn-sm" ng-click="addCategoryModal()">Add Category</button>
<br><br>
<p>Select Category: <select ng-model="selectedCategory" ng-options="x.CategoryName for x in getCategories" ng-change="selectProduct()"></select></p>
<table class="table" style="width: 50%">
	<tr>
		<th>SKU</th>
		<th>Stock Quantity</th>
	</tr>
	<tr ng-repeat="x in getProducts">
		<td>{{x.Sku}}</td>
		<td>{{x.StockQty}}</td>
	</tr>
</table>

		<!-- Add category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModal" aria-hidden="true">
  <?php include('../partials/add.php')?>
</div>

	
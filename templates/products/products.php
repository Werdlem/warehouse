<div  style="padding: 10px; border: 1px solid rgba(0,0,255,0.2); background-color: rgba(0,0,255,0.1); border-radius: 5px" >
 
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addProductModal">Add Product</button>
    <button type="button" class="btn btn-primary btn-sm" ng-disabled="!selectedProduct" data-toggle="modal" data-target="#aliasModal">Add Alias</button>
    <button type="button" class="btn btn-success btn-sm" ng-disabled="!selectedProduct || selectedProduct.Discontinued==1" data-toggle="modal" data-target="#skuOrderRequestModal">New PO</button>
    <button type="button" class="btn btn-warning btn-sm" ng-disabled="!selectedProduct" data-toggle="modal" data-target="#soModal">Adjustment</button>
 
</div>
<div id="container" style="box-shadow: 4px 11px 13px 10px #d4d4d4; border-radius: 5px; padding: 15px; margin-top: 5px">
<br>
	<p>Select Category: <select ng-model="selectedCategory" ng-options="x.CategoryName for x in getCategories" ng-change="selectProduct()"></select></p>
	<p ng-show="selectedCategory">Select Product: <select ng-model="selectedProduct" ng-options="y.Sku for y in getProducts" ng-change="getProductHistory()"></select></p>
	<div ng-show="selectedProduct">
<h1>Product Details</h1>

	<p>Product Name: <input type="text" ng-model="selectedProduct.Sku" ng-change="editProduct(selectedProduct)"style="border:0"></p>
	<p>Product Description: <input type="text" ng-model="selectedProduct.description"ng-change="editProduct(selectedProduct)"style="border:0"></p>
  <p>Select Category: <select ng-model="editCategory" ng-options="x.CategoryName for x in getCategories" ng-change="editProduct(selectedProduct)"></select></p>
	<!--<p>Sku Alias's: <select ng-model="selectedSkuAliasList" ng-options="x.Alias for x in getSkuAlias"> </select></p>-->
	<p>Sku Alias: <span ng-repeat="x in getSkuAlias" style="padding-left: 1em" >{{x.Alias}} <button type="button" class="btn btn-danger btn-sm">Del</button> </span> <br/>
	</p>
	<p>Location: {{selectedProduct.Location_ID}}</p>
	<p>Quantity Per Unit: <input type="text" ng-model="selectedProduct.QuantityPerUnit" ng-change="editProduct(selectedProduct)"style="border:0"> </p>
	<p>Unit Price: <input type="text" ng-model="selectedProduct.UnitPrice" ng-change="editProduct(selectedProduct)"style="border:0"></p>
	<p>Units In Stock: {{getSkuQty[0].qty}}</p>
	<p>Reorder Level: <input type="text" ng-model="selectedProduct.ReorderLevel" ng-change="editProduct(selectedProduct)"style="border:0"></p>
  <p>Notes: <input type="text" ng-model="selectedProduct.Notes" ng-change="editProduct(selectedProduct)"style="border:0"></p>

	<p>Discontinued:  <input type="checkBox" ng-checked="selectedProduct.Discontinued==1" ng-model="selectedProduct.Discontinued" ng-change="editProduct(selectedProduct)"></p>

	
<!-- Modals -->

  <!--Sku Order Request Modal-->
  <div class="modal fade" id="skuOrderRequestModal" tabindex="-1" role="dialog" aria-hidden="true">
  <?php include('../partials/skuOrderRequestModal.php'); ?>
</div>
  <!--Alias Modal-->
	<div class="modal fade" id="aliasModal" tabindex="-1" role="dialog" aria-hidden="true">
  <?php include('../partials/aliasModal.php'); ?>
</div>
	<!--Adjustment Modal-->
<div class="modal fade" id="soModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include('../partials/productAdjustModal.php') ?>
</div>
<!--Adjustment Modal-->
<div class="modal fade" id="addProductModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <?php include('../partials/productAdjustModal.php') ?>
</div>
<!--Add Product-->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-hidden="true">
  <?php include('../partials/addProductModal.php'); ?>
</div>
</div>

<!-- end modals-->

<div ng-show="selectedProduct">
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="sales-tab" data-toggle="tab" href="#sales" role="tab" aria-controls="sales" target="_self" aria-selected="true" ng-click="getProductHistory()">Goods Out</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="orders" target="_self" aria-selected="false" ng-click="getProductHistory()">Goods In</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="adjustments-tab" data-toggle="tab" href="#adjustments" role="tab" aria-controls="adjustments" target="_self" aria-selected="false" ng-click="StockUpdate()">Adjustments</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="orderReq-tab" data-toggle="tab" href="#orderReq" role="tab" aria-controls="orderReq" target="_self" aria-selected="false" ng-click="StockUpdate()">Sku OrderRequests</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="sales" role="tabpanel" aria-labelledby="sales-tab">
  	<table class="table">
	<tr>
		<th>Order ID</th>
		<th>Order Date</th>
		<th>Shipped Date</th>
		<th>Qty</th>
		
	</tr>
	
	<tr ng-repeat="x in getHistory">
		<div class="overflow-auto">
		<td>{{x.OrderID}}</td>
		<td>{{x.DueDate | date: 'dd/MM/yyyy'}}</td>
		<td>{{x.despatch | date: 'dd-MM-YYYY'}}</td>
		<td>{{x.QtyDelivered}}</td>
		</div>
	</tr>

</table>
  </div>
  <div class="tab-pane fade show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
  	<table class="table">
	<tr>
		<th>Order ID</th>
		<th>Supplier</th>
		<th>GRN</th>
		<th>Delivery Date</th>
		<th>Qty</th>
		
	</tr>
	<tr ng-repeat="x in getOrderHistory">
		<td>{{x.OrderID}}</td>
		<td>{{x.Supplier}}</td>
		<td>{{x.Grn}}</td>
		<td>{{x.DeliveryDate}}</td>
		<td>{{x.QtyReceived}}</td>
		
	</tr>
	</table>
  </div>  
  <div class="tab-pane fade show" id="adjustments" role="tabpanel" aria-labelledby="adjustments-tab">
  <?php include ('../partials/adjustments.php'); ?>  
</div>
 <div class="tab-pane fade show" id="orderReq" role="tabpanel" aria-labelledby="orderReq-tab">
  <?php include ('../partials/skuOrderRequests.php'); ?>
</div>
</div>
</div>
</div>

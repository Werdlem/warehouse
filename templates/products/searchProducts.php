

 <?php include '../menuItems/productsMenu.html'; ?>
    
</div>
<div id="container" style="box-shadow: 4px 11px 13px 10px #d4d4d4; border-radius: 5px; padding: 15px; margin-top: 5px">
<br>
	<p>Search Product: <input type="text" ng-model="searchProducts"><button ng-click="searchProduct()">search</button></p>
	<div>
<h1>Search Results</h1>

<table class="table table-striped">
<thead>
	<tr>
		<th>A</th>
		<th>B</th>
		<th style="width: 5%">C</th>
	</tr>
</thead>
<tbody>
	<tr ng-repeat="x in getProducts">
		<td>Sku</td>
		<td>{{x.Sku}}</td>
		<td ng-repeat="y in getProductLocation">{{y.Location}}</td>
	</tr>
</tbody>
</table>

	<p>Product Name: <input type="text" ng-model="selectedProduct.Sku" ng-change="editProduct(selectedProduct)"style="border:0"></p>
	<p>Product Description: <input type="text" ng-model="selectedProduct.description"ng-change="editProduct(selectedProduct)"style="border:0"></p>
  <p>Select Category: <select ng-model="editCategory" ng-options="x.CategoryName for x in getCategories" ng-change="editProduct(selectedProduct)"></select></p>
	<!--<p>Sku Alias's: <select ng-model="selectedSkuAliasList" ng-options="x.Alias for x in getSkuAlias"> </select></p>-->
	<p>Sku Alias: <span ng-repeat="x in getSkuAlias" style="padding-left: 1em" >{{x.Alias}} <button type="button" class="btn btn-danger btn-sm">Del</button> </span> <br/>
	</p>
	<p>Location: <span ng-repeat="x in getLocations" style="padding-left: 1em">{{x.Location}}</span></p>
	<p>Quantity Per Unit: <input type="text" ng-model="selectedProduct.QuantityPerUnit" ng-change="editProduct(selectedProduct)"style="border:0"> </p>
	<p>Unit Price: <input type="text" ng-model="selectedProduct.UnitPrice" ng-change="editProduct(selectedProduct)"style="border:0"></p>
	<p>Units In Stock: {{getSkuQty[0].qty}}</p>
	<p>Reorder Level: <input type="text" ng-model="selectedProduct.ReorderLevel" ng-change="editProduct(selectedProduct)"style="border:0"></p>
  <p>Notes: <input type="text" ng-model="selectedProduct.Notes" ng-change="editProduct(selectedProduct)"style="border:0"></p>

	<p>Discontinued:  <input type="checkBox" ng-checked="selectedProduct.Discontinued==1" ng-model="selectedProduct.Discontinued" ng-change="editProduct(selectedProduct)"></p>

  {{selectedProduct.Discontinued}}

	
<!-- Modals -->

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

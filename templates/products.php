<?php include ('./menuItems/productsMenu.html');?>

<div  style="padding: 10px">
	<p>Select Category: <select ng-model="selectedCategory" ng-options="x.CategoryName for x in getCategories" ng-change="selectProduct()"></select></p>
	<p ng-show="selectedCategory">Select Product: <select ng-model="selectedProduct" ng-options="y.Sku for y in getProducts" ng-change="getProductHistory()"></select></p>
	<div ng-show="selectedProduct">
<h1>Product Details</h1>

	<p>Product Name: <input type="text" ng-model="selectedProduct.Sku" ng-click="editProduct()" style="border:0"></p>
	<p>Product Description: {{selectedProduct.description}}</p>
	<p>Sku Alias's: <select ng-model="selectedSkuAliasList" ng-options="x.Alias for x in getSkuAlias"></select></p>
	<p>Location: {{selectedProduct.Location_ID}}</p>
	<p>Quantity Per Unit: {{selectedProduct.QuantityPerUnit}}</p>
	<p>Unit Price: {{selectedProduct.UnitPrice}}</p>
	<p>Units In Stock: {{getSkuQty[0].qty}}</p>
	<p>Buffer: {{selectedProduct.buffer_qty}}</p>
	<p><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#aliasModal">Add Alias</button>
		<button type="button" class="btn btn-success btn-sm" disabled go-click="/purchaseOrder">New PO</button>
		<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#soModal">Adjustment</button>
	</p>

	<div class="modal fade" id="aliasModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Alias</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><label>Alias:</label> <input type="text" ng-model="pr.a.alias"></p>
        <p><label>Initials:</label> <input type="text" ng-model="pr.a.initials" maxlength="2" size="1"></p>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-success" ng-show="pr.a.initials" ng-model="pr.a" ng-click="addAlias()">Add</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
	<!--Adjustment Modal-->
	<!-- Modal -->
<div class="modal fade" id="soModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Adjustment</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="getProductHistory()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><label>Sku: {{selectedProduct.Sku}}</label></p>
        <p><label>Qty:</label> <input type="number" ng-model="pr.Adj.Qty"></p>
        <p><label>Reason:</label> <input type="text" ng-model="pr.Adj.reason" size="30"></p>
        <p><label>Initials:</label> <input type="text" ng-model="pr.Adj.initials" maxlength="2" size="1"></p>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-success" ng-show="pr.Adj.initials" ng-model="pr.Adj.AdjIn" ng-click="AdjIn()">Adjust In</button>
        <button type="button" class="btn btn-danger" ng-show="pr.Adj.initials" ng-model="pr.Adj.AdjOut" ng-click="AdjOut()">Adjust Out</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="getProductHistory()">Close</button>
      </div>
    </div>
  </div>
</div>
	<!-- End Modal-->

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
  <?php include ('./partials/adjustments.php'); ?>
  
</div>

</div>
</div>

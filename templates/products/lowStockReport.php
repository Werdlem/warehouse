 <?php include '../menuItems/productsMenu.html'; ?>
 <br/>

 <p>Filter Category: <select ng-model="selectCatagory" ng-options=" x.CategoryName for x in getCategories"></select></p>
 
 <table class="table">
 	<tr>
 		<th>Sku</th>
 		<th>Qty</th>
 		<th>Reorder Level</th>
 	</tr>
 	<tr ng-repeat="x in getLowStock">
 		<td><a href="/productDetails?SkuID={{x.SkuID}}&Sku={{x.Sku}}">{{x.Sku}}</a></td>
 		<td>{{x.StockQty}}</td>
 		<td>{{x.ReorderLevel}}</td>
 		<td> <button type="button" class="btn btn-success btn-sm" ng-disabled="pr.getProduct[0].Discontinued==1" data-toggle="modal" data-target="#skuOrderRequestModall">New PO</button></td>
 <td><div class="modal fade" id="skuOrderRequestModall" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sku Order Request</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><label>Sku: {{x.Sku}}</label></p>
          <input type="test" hidden ng-model="x.Sku">
          <input type="test" hidden ng-model="x.SkuID">
  
          <p>Order Qty: <input type="number" ng-model="order.qty"></p>
          <p>Direct Delivery: <input type="checkbox" ng-model="order.delivery"></p>
            <input type="text" ng-model="order.po" ng-show="order.delivery" placeholder="Sales Order Number">
            <p>Notes: </p><p><textarea type="text" ng-model="order.notes" rows="4" cols="50"></p>
            </textarea> </p>
            <p><input type="text" ng-model="order.Initials" size="2"></p>     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" ng-click="skuOrderRequest(order,x)" ng-show="order.Initials">Send</button>
        </div>
  </div>
  </div>
  </div>
  </div>
</td>
 		
 	</tr>
 </table>

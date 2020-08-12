<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sku Order Request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><label>Sku: {{selectedProduct.Sku}}</label></p>
        <input type="test" hidden ng-model="selectedProduct.Sku">
        <input type="test" hidden ng-model="selectedProduct.SkuID">

        <p>Order Qty: <input type="number" ng-model="order.qty"></p>
        <p>Direct Delivery: <input type="checkbox" ng-model="order.delivery">
          <input type="text" ng-model="order.po" ng-show="order.delivery" placeholder="Sales Order Number">
          <p>Notes: </p><p><textarea type="text" ng-model="order.notes" rows="4" cols="50"></p>
          </textarea> 
          <p><input type="text" ng-model="order.Initials" size="2"></p>     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" ng-click="skuOrderRequest(order)" ng-show="order.Initials">Send</button>
      </div>
      </div>
    </div>
  </div>
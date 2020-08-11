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
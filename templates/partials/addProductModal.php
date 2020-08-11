	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
 <form ng-submit="pr.addProduct(newP)">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="getProductHistory()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
 <div class="modal-body">
<p>Select Category:  <select class="form-control" ng-model="pr.newP.selectCategory" ng-options="x.CategoryName for x in getCategories"></select></p>
<p>Quantity Per Unit:  <input class="form-control" type="text" ng-model="pr.newP.QuantityPerUnit"></p>
<p>Cost Price: <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">£
          </div>
        </div> 
        <input class="form-control" type="" ng-model="pr.newP.CostPrice">
      </div>
  </p>
<p>Unit Price:  
  <div class="input-group mb-2">
        <div class="input-group-prepend">
          <div class="input-group-text">£
          </div>
        </div>
        <input class="form-control"  ng-model="pr.newP.UnitPrice">
      </div>
  </p>
<p>Units in Stock:  <input class="form-control" type="" ng-model="pr.newP.UnitsInStock"></p>
<p>Units On Order:  <input class="form-control" type="" ng-model="pr.newP.UnitsOnOrder"></p>
<p>Reorder Level:  <input class="form-control" type="" ng-model="pr.newP.ReorderLevel"></p>

<button class="btn btn-primary" type="Submit" id="submit" value="Submit" >Submit</button>
</div>
</form>
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
</div>
</div>
</div>

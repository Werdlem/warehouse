	<div class="modal-dialog" ng-controller="addProduct as pro">
    <div class="modal-content">
      <div class="modal-header">

<div class="modal-body">
 <h3>Add Product</h3>
<form ng-submit="pro.addproduct(newP)">
<p>Select Category:  <select class="form-control" ng-model="pro.newP.selectCategory" ng-options="x.CategoryName for x in getCategories"></select></p>
<p>prooduct Name:  <input class="form-control" type="text" ng-model="pro.newP.prooductName"></p>
<p>Description: <input class="form-control" type="text" ng-model="pro.newP.Description"></p></p>
<p>Quantity Per Unit: <input class="form-control" type="number" ng-model="pro.newP.QuantityPerUnit"></p>
<p>Cost proice: <div class="input-group mb-2">
        <div class="input-group-proepend">
          <div class="input-group-text">£
          </div>
        </div> 
        <input class="form-control" type="" ng-model="pro.newP.Costproice">
    </div>
  </p>
<p>Unit proice:  <div class="input-group mb-2">
        <div class="input-group-proepend">
          <div class="input-group-text">£
          </div>
        </div>
        <input class="form-control"  ng-model="pro.newP.Unitproice">
    </div>
  </p>
<p>Units in Stock:  <input class="form-control" type="" ng-model="pro.newP.UnitsInStock"></p>
<p>Units On Order:  <input class="form-control" type="" ng-model="pro.newP.UnitsOnOrder"></p>
<p>Reorder Level:  <input class="form-control" type="" ng-model="pro.newP.ReorderLevel"></p>

<button class="btn btn-primary" type="Submit" id="submit" value="Submit" >Submit</button>
</form>

</div>
</div>
</div>
</div>

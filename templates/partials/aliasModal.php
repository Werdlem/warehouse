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
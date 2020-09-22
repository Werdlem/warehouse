<style type="text/css">
  td:hover{cursor: context-menu;}
</style>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Location</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <p><label>Location:</label> <input type="text" ng-model="newLocation"></p>
        </div>
        
      <div class="modal-footer">        
         <button type="button" class="btn btn-secondary" data-dismiss="modal" ng-click="addNewLocation()">Add</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
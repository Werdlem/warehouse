<style type="text/css">
  td:hover{cursor: context-menu;}
</style>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Location</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <p><label>Location:</label> <input type="text" ng-model="location" ng-change="getLocation()"></p>
        </div>
        <table class="table">
          <tr ng-repeat="x in getLocations | filter:location">
            <td id="hover" ng-click="addLocation(x.location_id)">{{x.Location}}</td>
          </tr>
        </table>
      <div class="modal-footer">        
        
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
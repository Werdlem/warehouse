
 <?php include '../menuItems/productsMenu.html'; ?>
 <style type="text/css">p {margin-bottom: 0.5rem;}</style>


<div id="container" style="border: 1px solid rgba(0,0,255,0.2); background-color: rgba(0,0,255,0.1); border-radius: 5px; padding: 15px; margin-top: 5px">

<form style="margin-top: 0em">
	Search Tools: <input type="text" class="form-control" style="width: 25%; display: inline;" ng-model="searchTool"> <button class="btn btn-primary mb-2" ng-click="searchTools()">Search</button>
</form>
</div>
<div ng-show="pro.getTools" style="">
	<div id="container" style="box-shadow: 4px 11px 13px 10px #d4d4d4; border-radius: 5px; padding: 15px; margin-top: 20px">
<h3 style="text-align: center;text-decoration: underline;">Search Results</h3 >
 <div ng-repeat="x in pro.getTools" style="border-bottom: 2px dashed #6c757d">


	<p>ToolRef: <a href="/toolCalculator?toolID={{x.id}}&tool={{x.tool_ref}}">{{x.tool_ref}}</a></p>
	<p>Location: <strong>{{x.location}}</strong></p>
	
</div>

</div>





<div product-details>

 <?php include('../menuItems/productsMenu.html')?>


<div id="container" style="box-shadow: 4px 11px 13px 10px #d4d4d4; border-radius: 5px; padding: 15px; margin-top: 5px">
<h1>Waste Calculator</h1>
<p>ToolRef: {{cal.getTool.tool_ref}}</p>
<p>Dims: {{cal.getTool.length}} x {{cal.getTool.width}} x {{cal.getTool.height}}</p>
<p>KTOK: {{cal.getTool.ktok_width}} x {{cal.getTool.ktok_length}}</p>
<p>Sqm: {{((cal.getTool.ktok_length * cal.getTool.ktok_width)/cal.getTool.config)/1000000}}sqm</p>
<p>Qty: <input type="number" ng-model="qty" ></p>
<p>Total SQM: {{calcToolSqm()}}</p>


<p>Select Sheetboard: <select ng-model="selectedSheetboard" ng-options="sht.Ref for sht in cal.getSheetboard | filter:filterRangeDeckle| filter:filterRangeChop"></select> </p>
<p>£ per K-Sqm: <input type="number" ng-model="cost"></p>
<p>Size: {{selectedSheetboard.Deckle}} x {{selectedSheetboard.Chop}}</p>
<p>Sqm: {{calcSheetSqm()}}</p>
<p>Waste: {{calcWaste()| number: 4}}</p>
<p>Waste Cost: {{calcCost() |currency: '£'}}</p>
<div style="width: 50%;border-radius: 5px;  box-shadow: 10px 10px 20px #d4d4d4; padding: 30px;margin: auto">
<h1 style="text-align: center">Non Conformance Report</h1>
<h2>Customer Details</h2>
	<p><span>Customer: {{ncr.getCustomerNcr[0].customer_name | uppercase}}</span></p>
	<p><span>Purchase Order: {{ncr.getCustomerNcr[0].po}}</span></p>
	<p><span>NCR Date: {{ncr.getCustomerNcr[0].date_opened}}</span></p>
	<p><span>NCR Raised By: {{ncr.getCustomerNcr[0].raised_by}}</span></p>

<h2>Description of Non Conformance</h2>
<div ng-repeat="x in ncr.getCustomerNcr">
	<p><strong>Sku: </strong>{{x.sku}} - {{x.desc1}} - <strong>{{x.problem | uppercase}}</strong></p>
	<p><strong>Comments: </strong>{{x.p_desc}}</p>
</div>

<h2>Immediate Correction Taken/Required</h2>
<div ng-repeat="x in ncr.getCustomerNcr">
	<p><strong>Action Taken: </strong>{{x.sku}} - {{x.correction}}</p>
	</div>


<h2>Investigation</h2>
<div ng-repeat="x in ncr.getInvestigation">
	<p>{{x.investigation}}</p>

</div>
<br/>
	<textarea style="width: 500px; height: 100px" ng-model="investigation" ng-hide="ncr.getInvestigation[0].date_closed"></textarea>

	<p><input type="button" class="btn btn-info btn-sm" ng-model="Submit" value="Close Investigation" ng-click="investigationComment(investigation)" ng-hide="ncr.getInvestigation[0].date_closed"></p>

	

<h2>Planned Preventative Actions</h2>
<div ng-repeat="x in ncr.getReview">
	<p ng-show="x.review !=null">{{x.review}}</p>
</div>
<div ng-hide="ncr.getReview[0].date_reviewed">
<textarea style="width: 500px; height: 90px" ng-model="review" ></textarea>

<p><input type="button" class="btn btn-info btn-sm" ng-model="Submit" value="Close Review" ng-click="investigationReview(review)"></div></p>
<h3>Close Off</h3>
<p><strong>Name: </strong><input type="text" ng-model="name"><br/> 
	<button class="btn btn-info btn-sm" ng-click="close(name)" ng-show="name">Close NCR</button></p>
</div>





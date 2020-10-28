<p>Account Re: {{s.getSupplierDetails.ACCOUNT_REF}}</p>
<p>Supplier Name: {{s.getSupplierDetails.CONTACT_NAME}}</p>
<p>Address: {{s.getSupplierDetails.ADDRESS_1}},{{s.getSupplierDetails.ADDRESS_2}},{{s.getSupplierDetails.ADDRESS_3}}, {{s.getSupplierDetails.ADDRESS_4}}, {{s.getSupplierDetails.ADDRESS_5}}</p>

<p>Lead Time: <input type="number" ng-model="lead" ng-value="s.getSupplierDetails.lead"></p>
<button ng-click="updateLead()">update</button>
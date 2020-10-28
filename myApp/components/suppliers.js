myApp.controller('suppliers', function($scope,$http, $location){
		this.search = $location.search();
		id = this.search.id;

		$http({
			method: 'POST',
			url: './jsonData/suppliersAction.php',
			data: {action: 'getSupplierList'}
		}).then((response)=>{
			this.getSupplierList = response.data;
		})

		$http({
			method: 'POST',
			url:'./jsonData/suppliersAction.php',
			data:{action: 'getSupplierDetails',
			ref: id}
		}).then((response)=>{
			this.getSupplierDetails = response.data;

	});
this.getSupplierDetails={};
		$scope.updateLead=()=>{
			$http({
			method: 'POST',
			url:'./jsonData/suppliersAction.php',
			data:{action: 'updateLead',
			details: this.getSupplierDetails,
			lead: $scope.lead}
		});
		}
})

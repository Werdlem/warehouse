
	myApp.controller('customers', function($scope, $http,$location){

				$http({
			method: 'GET',
			url: './jsonData/getCustomerList.json.php'
		}).then(function(response){
			$scope.getCustomerList = response.data;
		});

		this.search = $location.search();
		id = this.search.id;
		$http({
			method: 'POST',
			url: './jsonData/getCustomerDetails.json.php',
			data: {id:id}
		}).then(function(response){
			$scope.getCustomer = response.data;
		})
		$http({
			method: 'POST',
			url: './jsonData/getCustOrdDetails.json.php',
			data: {id:id}
		}).then(function(response){
			$scope.getOrderDetails = response.data;
		})

		$http({
			method: 'POST',
			url: './jsonData/getCustomerProductHistory.json.php',
			data: {id:id}
		}).then(function(response){
			$scope.getProductHistory = response.data;
		})
	})
myApp.controller('categories', function($scope,$http, $location){

	
	$http({
		method: 'GET',
		url: './jsonData/getCategories.json.php'
	}).then(function(response){
		$scope.getCategories = response.data;
	});
		$scope.selectProduct =()=>{
		$http({
			method: 'POST',
			url: './jsonData/getProductsByCategory.json.php',
			data: {cId: $scope.selectedCategory.CategoryId}
		}).then(function(response){
			$scope.getProducts = response.data;			
	})

}
	})
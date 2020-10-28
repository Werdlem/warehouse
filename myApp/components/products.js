myApp.controller('products', function($scope, $http, $location, $route){

	this.newP={};
	this.addProduct = ()=>{
		$http({
			method: 'POST',
			url: './jsonData/productsAction.php',
			data: {newP:this.newP,
				action: 'addProduct'}				
		});
	}

	$http({
		method: 'GET',
		url: './jsonData/getCategories.json.php'
	}).then(function(response){
		$scope.getCategories = response.data;
	});

		$scope.searchProduct=(pr)=>{
			$http({
				method:'POST',
				url: '/jsonData/productsAction.php',
				data: {action: 'searchProduct',
				Sku: $scope.selectedProduct}
			}).then((response)=>{

				if (response.data == 'null'){
		alert('Product not found. Please try again.');
	}else{
				this.getProducts = response.data;		
			}
		});
				

		}
		$scope.searchTools=()=>{
			$http({
				method:'POST',
				url: '/jsonData/calculatorAction.php',
				data: {action: 'searchTools',
				ToolRef: $scope.searchTool}
			}).then((response)=>{
				this.getTools = response.data;		
			});
		}

	$scope.getProductHistory =(SkuID, Sku)=>{
		$http({
			method: 'POST',
			url: './jsonData/productsAction.php',
			data: {action: 'skuOrderReq',
			pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getSkuOrderRequests = response.data;
		})
		$http({
			method: 'POST',
			url: './jsonData/getSkuAlias.json.php',
			data: {pID: $scope.selectedProduct.SkuID}			
		}).then((response)=>{
			$scope.getSkuAlias = response.data;
		})		
		$http({
			method: 'POST',
			url: './jsonData/getSkuQty.json.php',
			data: {pID: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getSkuQty = response.data;
		});
		
		$http({
			method: 'POST',
			url: './jsonData/getProductHistory.json.php',
			data: {pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getHistory = response.data;
		});
		$http({
			method: 'POST',
			url: './jsonData/getProductOrderHistory.json.php',
			data: {pId: $scope.selectedProduct.Sku}
		}).then(function(response){
			$scope.getOrderHistory = response.data;
		});
		$http({
			method: 'POST',
			url: './jsonData/getAdjustments.json.php',
			data: {pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getSkuAdjustments = response.data;
		})
		
	}
	
})
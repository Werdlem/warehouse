myApp.controller('productDetails', function($scope, $http, $location, $route) {
		
	this.SkuID = $location.search();
	this.Sku = $location.search();
	SkuID = this.SkuID;
	Sku = this.Sku;
	$scope.delLocation =(x)=>{
		$http({
			method: 'POST',
			url:'./jsonData/productsAction.php',
			data:{action: 'delLocation',
			id: x.location_id}
		}).then((response)=>{
			location.reload();
		});

	}
	$http({
		method:'POST',
		url: './jsonData/productsGet.php',
		data: {action: 'getProductViaUrl',
		SkuID: SkuID}
	}).then((response)=>{
		this.getProduct = response.data;
	});
	$http({ //GET PRODUCT LOCATIONS
		method:'POST',
		url: './jsonData/productsGet.php',
		data: {action: 'getProductLocationsViaUrl',
		SkuID: SkuID}
	}).then((response)=>{
		this.getLocations = response.data;
	});


	$http({
			method: 'POST',
			url: './jsonData/productsGet.php',
			data: {action: 'skuOrderReq',
			pId: SkuID}
		}).then(function(response){
			$scope.getSkuOrderRequests = response.data;
		})
		$http({
			method: 'POST',
			url: './jsonData/productsGet.php',
			data: {action: 'getHistory',
			pId: SkuID}
		}).then(function(response){
			$scope.getHistory = response.data;
		});
		$http({
			method: 'POST',
			url: './jsonData/productsGet.php',
			data: {action: 'getSkuPoHistory',
			pId: Sku}
		}).then(function(response){
			$scope.getOrderHistory = response.data;
		});
		$http({
			method: 'POST',
			url: './jsonData/productsGet.php',
			data: {action: 'getProductAdjustment',
			pId: SkuID}
		}).then(function(response){
			$scope.getSkuAdjustments = response.data;
		})

		$scope.delete =(id)=>{
		$http({
			method:'POST',
			url:'/jsonData/productsAction.php',
			data: {action: 'deleteAdj',
			id: id}
		}).then((response)=>{
				window.location.replace("/productDetails?SkuID="+$scope.pr.getProduct[0].SkuID+"&Sku="+$scope.pr.getProduct[0].Sku);
		})
	}


	this.order = {};
	$scope.skuOrderRequest=(order)=>{
		$http({
			method:'POST',
			url:'/jsonData/productsAction.php',
			data: {action: 'orderReq',
			details: order,
			Sku: Sku,
			SkuID: SkuID,
			Op: order
		}
	}).then((response)=>{
		if (response.data == 'Failure'){
		alert('The order was not sent, please try again or contact the office with your order');
	}
	else if (response.data == 'Success')
	{
		alert('Your order has been sent!');
		location.reload();
	}

	})
}
	$scope.editProduct =()=>{
		$http({
			method:'POST',
			url:'/jsonData/productsAction.php',
			data: {action: 'editProduct',
			details: $scope.pr.getProduct[0],
			LowStock: $scope.LowStock,
			category: $scope.editCategory,
			SkuID
		}
	})
}
	$scope.getSkuAlias=()=>{
		$http({
			method: 'POST',
			url: './jsonData/getSkuAlias.json.php',
			data: $scope.selectedProduct.SkuId			
		}).then((response)=>{
			$scope.getSkuAlias = response.data;
		})
	}

	$scope.getLocation =()=>{
		$http({
		method: 'POST',
		url: '/jsonData/productsGet.php',
		data: {action: 'getLocations',
				location: $scope.location}
	}).then((response)=>{
		$scope.getLocations = response.data;
	})
}
	this.a={};
	this.x={};
	$scope.addLocation=(location_id)=>{
		$http({
			method: 'POST',
			url: './jsonData/productsAction.php',
			data: {action: 'updateLocation',
			SkuID: SkuID,
			locationID: location_id}			
		}).then((response)=>{
			location.reload();
	})
	}

	$scope.addNewLocation=()=>{
		$http({
			method: 'POST',
			url: './jsonData/productsAction.php',
			data: {action: 'addLocation',
			location: $scope.newLocation}			
		})//.then((response)=>{
		//location.reload();
	}
	//)}
	$scope.addAlias=()=>{
		$http({
			method: 'POST',
			url: './jsonData/addAlias.json.php',
			data: {Alias:this.a,
			SkuID: SkuID,}			
		}).then((response)=>{
			//location.reload();
			//window.location.replace("/productDetails?SkuID="+$scope.pr.getProduct[0].SkuID+"&Sku="+$scope.pr.getProduct[0].Sku);
	})
	}
	$scope.delAlias=(AliasID)=>{
		$http({
			method: 'POST',
			url: './jsonData/productsAction.php',
			data: {action: 'delAlias',
			AliasID}			
		}).then((response)=>{
			window.location.replace("/productDetails?SkuID="+$scope.pr.getProduct[0].SkuID+"&Sku="+$scope.pr.getProduct[0].Sku);
	})
	}


this.Adj={};
	$scope.AdjIn = ()=>{		
		$http({		
		method: 'POST',
		url: './jsonData/productsAction.php',
		data: {details:this.Adj, 
		SkuID: $scope.pr.getProduct[0].SkuID,
		action: 'AdjustIn'}
	}).then((response)=>{
		window.location.replace("/productDetails?SkuID="+$scope.pr.getProduct[0].SkuID+"&Sku="+$scope.pr.getProduct[0].Sku);
	})
		
};
$scope.AdjOut = ()=>{		
		$http({		
		method: 'POST',
		url: './jsonData/productsAction.php',
		data: {details:this.Adj, 
		SkuID: $scope.pr.getProduct[0].SkuID,
		action: 'out'}
	}).then(function(response){
		 window.location.replace("/productDetails?SkuID="+$scope.pr.getProduct[0].SkuID+"&Sku="+$scope.pr.getProduct[0].Sku);
	})
};


	$http({
		method: 'GET',
		url: './jsonData/getSuppliers.json.php'
	}).then(function(response){
		$scope.getSuppliers = response.data;
	});

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
	$scope.StockUpdate =()=>{
		$http({
			method: 'POST',
			url:'./jsonData/UpdateStock.json.php'
		})
}

	})
var myApp = angular.module('myApp', ["ngRoute"])
	.config(function($routeProvider,$locationProvider, $provide){
		$routeProvider.when("/",{
			templateUrl : "/templates/home.php"
		})
		//-----------CUSTOMERS----------------//
		.when("/page2",{templateUrl : "/templates/page2.php"})
		.when("/customers",{controller : 'customers as cu',templateUrl :"/templates/customers.php"})
		.when("/customerDetails",{controller: 'customers as cu',templateUrl : "/templates/customerDetails.php"})
		//suppliers
		.when("/suppliers",{controller: 'suppliers as s',templateUrl :"/templates/suppliers.php"})
		.when("/supplierDetails",{controller: 'suppliers as s',	templateUrl: '/templates/supplierDetails'})
		//categories
		.when("/categories",{controller:'categories as cat', templateUrl:'/templates/categories/categoryHome.php'})
		//products
		.when("/products",{controller: 'products as pr',templateUrl : "/templates/products/searchProducts.php"})
		.when("/addProduct",{templateUrl : "/templates/products/addProduct.php", controller: 'products as pr'})
		.when("/addAlias",{templateUrl : "/templates/products/addProduct.php", controller: 'products as pr'})
		.when("/salesOrder",{controller: "salesOrder as so",templateUrl : "/templates/products/salesOrder.php"})
		.when("/purchaseOrder",{controller: "purchaseOrder as po",templateUrl : "/templates/products/purchaseOrder.php"});
		 $locationProvider
  .html5Mode(true)
  .hashPrefix('!');
	});

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

	myApp.controller('suppliers', function($scope,$http, $location){
		this.search = $location.search();
		id = this.search.id;

		$http({
			method: 'POST',
			url: './jsonData/getSupplierDetails.json.php',
			data: {id:id}
		}).then((response)=>{
			this.getSupplierDetails = response.data;
		})

		$http({
			method: 'GET',
			url: './jsonData/getSupplierList.json.php'
		}).then((response)=>{
			this.getSupplier = response.data;
		})

	});

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

myApp.controller('products', function($scope, $http, $location, $route){

		$scope.searchProduct=()=>{
			$http({
				method:'POST',
				url: '/jsonData/productsAction.php',
				data: {action: 'searchProduct',
				Sku: $scope.searchProducts}
			}).then((response)=>{
				$scope.getProducts = response.data;
			})
		}

	this.order = {};
	$scope.skuOrderRequest=(order)=>{
		$http({
			method:'POST',
			url:'/jsonData/productsAction.php',
			data: {action: 'orderReq',
			details: order,
			Sku: $scope.selectedProduct.Sku,
			SkuID: $scope.selectedProduct.SkuID,
		}
	})
}
	$scope.editProduct =()=>{
		$http({
			method:'POST',
			url:'/jsonData/productsAction.php',
			data: {action: 'editProduct',
			details: $scope.selectedProduct,
			category: $scope.editCategory
		}
	})
}

	$scope.delete =(id)=>{
		$http({
			method:'POST',
			url:'/jsonData/productsAction.php',
			data: {action: 'deleteAdj',
			id: id}
		}).then((response)=>{
				$http({
			method: 'POST',
			url: './jsonData/getAdjustments.json.php',
			data: {pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getSkuAdjustments = response.data;
		})
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

	this.a={};
	$scope.addAlias=()=>{
		$http({
			method: 'POST',
			url: './jsonData/addAlias.json.php',
			data: {Alias:this.a,
			SkuID: $scope.selectedProduct.SkuID,}			
		});
	}

this.Adj={};
	$scope.AdjIn = ()=>{		
		$http({		
		method: 'POST',
		url: './jsonData/productsAction.php',
		data: {details:this.Adj, 
		SkuID: $scope.selectedProduct.SkuID,
		action: 'in'}
	})
		$http({
			method: 'POST',
			url:'./jsonData/UpdateStock.json.php'
		}).then((response)=>{
		$http({
			method: 'POST',
			url: './jsonData/getSkuQty.json.php',
			data: {pID: $scope.selectedProduct.SkuID}
		}).then((response)=>{
			$scope.getSkuQty = response.data;
		});
	})
		
};
$scope.AdjOut = ()=>{		
		$http({		
		method: 'POST',
		url: './jsonData/productsAction.php',
		data: {details:this.Adj, 
		SkuID: $scope.selectedProduct.SkuID,
		action: 'out'}
	})
		$http({
			method: 'POST',
			url:'./jsonData/UpdateStock.json.php'
		}).then(function(response){
		$http({
			method: 'POST',
			url: './jsonData/getSkuQty.json.php',
			data: {pID: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getSkuQty = response.data;
		});
	})
};

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

	
	$scope.getProductHistory2 =()=>{
		
		$http({
			method: 'POST',
			url: './jsonData/getProductOrderHistory.json.php',
			data: {pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getOrderHistory = response.data;
		})
	}
	$scope.getProductHistory =(SkuID, Sku)=>{
		$http({
			method: 'POST',
			url: './jsonData/productsAction.php',
			data: {action: 'getLocation',
			pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getLocations = response.data;
		})
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
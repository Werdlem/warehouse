var myApp = angular.module('myApp', ["ngRoute"])
	.config(function($routeProvider,$locationProvider, $provide){
		$routeProvider.when("/",{
			templateUrl : "/templates/home.php"
		})
		//-----------CUSTOMERS----------------//
		.when("/page2",{templateUrl : "/templates/page2.php"})
		.when("/customers",{controller : 'customers as cu',templateUrl :"/templates/customers.php"})
		.when("/customerDetails",{controller: 'customers as cu',templateUrl : "/templates/customerDetails.php"})
		.when("/suppliers",{controller: 'suppliers as s',templateUrl :"/templates/suppliers.php"})
		.when("/supplierDetails",{controller: 'suppliers as s',	templateUrl: '/templates/supplierDetails'})
		.when("/products",{templateUrl : "/templates/products.php"})
		.when("/addProduct",{templateUrl : "/templates/addProduct.php", controller: 'products as pr'})
		.when("/addAlias",{templateUrl : "/templates/addProduct.php", controller: 'products as pr'})
		.when("/salesOrder",{controller: "salesOrder as so",templateUrl : "/templates/salesOrder.php"})
		.when("/purchaseOrder",{controller: "purchaseOrder as po",templateUrl : "/templates/purchaseOrder.php"});
		 $locationProvider
  .html5Mode(true)
  .hashPrefix('!');
	});

	myApp.directive( 'goClick', function ( $location ) {
  return function ( scope, element, attrs ) {
    var path;

    attrs.$observe( 'goClick', function (val) {
      path = val;
    });

    element.bind( 'click', function () {
      scope.$apply( function () {
        $location.path( path );
      });
    });
  };
});

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

myApp.controller('products', function($scope, $http, $location){

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
		url: './jsonData/skuAdjust.json.php',
		data: {details:this.Adj, 
		SkuID: $scope.selectedProduct.SkuID,
		adj: 'in'}
	}).then((response)=>{
			$scope.getProductHistory();
			 $('#soModal').modal('exit');
		});
};
$scope.AdjOut = ()=>{		
		$http({		
		method: 'POST',
		url: './jsonData/skuAdjust.json.php',
		data: {details:this.Adj, 
		SkuID: $scope.selectedProduct.SkuID,
		adj: 'out'}
	}).then((response)=>{
			$scope.getProductHistory();
			 $('#soModal').modal('exit');
		});
};

	this.newP={};
	this.addProduct = ()=>{
		$http({
			method: 'POST',
			url: './jsonData/addProduct.json.php',
			data: this.newP				
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

	$scope.getProductHistory2 =()=>{
		$http({
			method: 'POST',
			url: './jsonData/getProductOrderHistory.json.php',
			data: {pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getOrderHistory = response.data;
		})
	}
	$scope.getProductHistory =()=>{
		$http({
			method: 'POST',
			url: './jsonData/getSkuQty.json.php',
			data: {pID: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getSkuQty = response.data;
		})
		$http({
			method: 'POST',
			url: './jsonData/getProductHistory.json.php',
			data: {pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getHistory = response.data;
		})
		$http({
			method: 'POST',
			url: './jsonData/getProductOrderHistory.json.php',
			data: {pId: $scope.selectedProduct.Sku}
		}).then(function(response){
			$scope.getOrderHistory = response.data;
		})
		$http({
			method: 'POST',
			url: './jsonData/getAdjustments.json.php',
			data: {pId: $scope.selectedProduct.SkuID}
		}).then(function(response){
			$scope.getSkuAdjustments = response.data;
		})
		
	}
	
})
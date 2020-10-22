var myApp = angular.module('myApp',['ngRoute'])
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
		.when("/lowStockReport",{controller:'lowStock as ls',templateUrl:"/templates/products/lowStockReport.php"})
		.when("/searchProduct",{controller:'products as pro',templateUrl: "/templates/products/searchProducts.php"})
		.when("/searchByCategory",{controller: 'categories as ca',templateUrl : "/templates/products/searchByCategories.php"})
		.when("/productDetails",{controller: 'productDetails as pr',templateUrl : "/templates/products/productDetails.php"})
		.when("/addProduct",{templateUrl : "/templates/products/addProduct.php", controller: 'products as pr'})
		.when("/addAlias",{templateUrl : "/templates/products/addProduct.php", controller: 'products as pr'})
		.when("/salesOrder",{controller: "salesOrder as so",templateUrl : "/templates/products/salesOrder.php"})
		.when("/purchaseOrder",{controller: "purchaseOrder as po",templateUrl : "/templates/products/purchaseOrder.php"});
		 $locationProvider
  .html5Mode(true)
  .hashPrefix('!');
	});

	/**
 * Filters out all duplicate items from an array by checking the specified key
 * @param [key] {string} the name of the attribute of each object to compare for uniqueness
 if the key is empty, the entire object will be compared
 if the key === false then no filtering will be performed
 * @return {array}
 */
myApp.filter('unique', function () {

  return function (items, filterOn) {

    if (filterOn === false) {
      return items;
    }

    if ((filterOn || angular.isUndefined(filterOn)) && angular.isArray(items)) {
      var hashCheck = {}, newItems = [];

      var extractValueToCompare = function (item) {
        if (angular.isObject(item) && angular.isString(filterOn)) {
          return item[filterOn];
        } else {
          return item;
        }
      };

      angular.forEach(items, function (item) {
        var valueToCheck, isDuplicate = false;

        for (var i = 0; i < newItems.length; i++) {
          if (angular.equals(extractValueToCompare(newItems[i]), extractValueToCompare(item))) {
            isDuplicate = true;
            break;
          }
        }
        if (!isDuplicate) {
          newItems.push(item);
        }

      });
      items = newItems;
    }
    return items;
  };
});


myApp.controller('addProduct', function($scope,$http){

this.newP={};
	this.addProduct = ()=>{
		$http({
			method: 'POST',
			url: './jsonData/productsAction.php',
			data: {newP:this.newP,
				action: 'addProduct'}				
		});
	}
})

myApp.controller('lowStock', function($scope,$http, $location){

	
	$http({
		method: 'GET',
		url: './jsonData/getCategories.json.php'
	}).then(function(response){
		$scope.getCategories = response.data;
	})
	$http({
		method: 'POST',
		url: './jsonData/productsGet.php',
		data: {action: 'getLowStock'}
	}).then(function(response){
		$scope.getLowStock = response.data;
	})


	this.order = {};
	this.x = {};
	$scope.skuOrderRequest=(order,x)=>{
		$http({
			method:'POST',
			url:'/jsonData/productsAction.php',
			data: {action: 'orderReq',
			details: order,
			Sku: x,
			SkuID: x,
		}
	}).then((response)=>{
		if (response.data == 'Failure'){
		alert('The order was not sent, please try again or contact the office with your order');
	}
	else if (response.data == 'Success')
	{
		alert('Your order has been sent!');
	}

	})
}
})

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
		}
	}).then((response)=>{
		if (response.data == 'Failure'){
		alert('The order was not sent, please try again or contact the office with your order');
	}
	else if (response.data == 'Success')
	{
		//alert('Your order has been sent!');
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
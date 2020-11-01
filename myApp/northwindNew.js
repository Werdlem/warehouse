var myApp = angular.module('myApp',['ngRoute'])
	.config(function($routeProvider,$locationProvider, $provide){
		$routeProvider.when("/",{
			templateUrl : "/templates/home.php"
		})
		//-----------CUSTOMERS----------------//
		.when("/page2",{templateUrl : "/templates/page2.php"})
		.when("/customers",{controller : 'customers as cu',templateUrl :"/templates/customers.php"})
		.when("/customerDetails",{controller: 'customers as cu',templateUrl : "/templates/customerDetails.php"})
      .when("/ncr",{controller: 'NonConformance as n',templateUrl : "/templates/ncr/ncr.php"})
		//suppliers
		.when("/suppliers",{controller: 'suppliers as s',templateUrl :"/templates/suppliers/suppliers.php"})
		.when("/supplierDetails",{controller: 'suppliers as s',	templateUrl: '/templates/suppliers/supplierDetails.php'})
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
		.when("/purchaseOrder",{controller: "purchaseOrder as po",templateUrl : "/templates/products/purchaseOrder.php"})
		//Calculators
		.when("/tooling",{controller: "products as pro",templateUrl : "/templates/calculator/tooling.php"})
		.when("/toolCalculator",{controller: "calculator as cal",templateUrl : "/templates/calculator/toolCalculator.php"});
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


//myApp.controller('addProduct', function($scope,$http){



	

	
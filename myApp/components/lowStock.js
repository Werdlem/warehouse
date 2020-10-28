

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
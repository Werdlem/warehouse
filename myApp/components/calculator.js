

myApp.controller('calculator', function($scope, $http, $location, $route){

	this.toolID = $location.search();
	this.tool = $location.search();
	toolID = this.toolID;
	tool = this.tool;

		$http({
		method:'POST',
		url: './jsonData/calculatorAction.php',
		data: {action: 'getToolViaUrl',
		toolID: toolID}
	}).then((response)=>{
		this.getTool = response.data;
	});

	$http({
		method: 'POST',
		url:'./jsonData/calculatorAction.php',
		data: {action: 'getSheetboard'}
	}).then((response)=>{
		this.getSheetboard = response.data;
	})

	 $scope.calcToolSqm = ()=>{
      var res = ((($scope.cal.getTool.ktok_length * $scope.cal.getTool.ktok_width)*$scope.qty)/$scope.cal.getTool.config)/1000000;
       if (isNaN(res)){
        return null;
       }
       return res;
     };
     $scope.calcSheetSqm = function(){
      var res = ((($scope.selectedSheetboard.Deckle * $scope.selectedSheetboard.Chop)*$scope.qty)/$scope.cal.getTool.config)/1000000;
       if (isNaN(res)){
        return null;
       }
       return res;
     };

     $scope.runsPerSheet = ()=>{
     	var res = ($scope.calcToolSqm() * $scope.runs);
     	return res;
     }

      $scope.calcWaste = function(){
      var res = ($scope.calcSheetSqm()-$scope.runsPerSheet());
       if (isNaN(res)){
        return null;
       }
       return res;
     };
     $scope.calcCost =()=>{
     	var cost = (($scope.cost / 1000)*$scope.calcWaste());
     	if(isNaN(cost)){
     		return null;
     	}
     	return cost
     }; 

     //filter for board that will fit the tool based on the dimensions
    $scope.ktokWidth=()=>{
    	var x = $scope.cal.getTool.ktok_width*1;
    	return x
    }
    $scope.ktokLength=()=>{
    	var x = $scope.cal.getTool.ktok_length*1;
    	return x
    }

$scope.filterRangeDeckle = function(sht){
	return (sht.Deckle > $scope.ktokWidth());

 }
 $scope.filterRangeChop = function(sht){
	return (sht.Chop > $scope.ktokLength());

 }

 $scope.runs = 1;
});
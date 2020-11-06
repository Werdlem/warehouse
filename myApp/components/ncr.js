myApp.controller('NonConformance', function($scope,$http,$location, $route){

  $scope.close =(name, ncr)=>{
  $http({
    method: 'POST',
    url: '/jsonData/ncrClose.json.php',
    data: {name:name,
    id:$scope.ncr.getCustomerNcr[0].po,}
    }).then((response)=>{
       window.location.assign("openNcr");
    });
  };
this.search = $location.search();
 id = this.search.orderId; 


  $scope.investigationComment = (investigation,ncr)=>{
    $http({
      method:'POST',
      url:'./jsonData/investigation.json.php',
      data: {text: investigation, 
        id:$scope.ncr.getCustomerNcr[0].po,
        field: 'investigation',
        date:'i_date'
       }
    }).then((response)=>{
       $route.reload();
    });
  }
  $scope.investigationReview = (review,ncr)=>{
    $http({
      method:'POST',
      url:'./jsonData/ncrReview.json.php',
      data: {text: review, 
        id:$scope.ncr.getCustomerNcr[0].po,
        field: 'review',
        date:'i_date',       
       }
    }).then((response)=>{
       $route.reload();
    });
  }
  $scope.prevent = (preventative,ncr)=>{    
    $http({
      method:'POST',
      url:'./jsonData/investigation.json.php',
      data: {text: preventative, 
        id:$scope.ncr.getCustomerNcr[0].po,
        field: 'preventative',
        date: 'p_date'}
    })
  }

  $http({   
    method: 'POST',
    url:'./jsonData/getInvestigation.json.php',
    data: {order_id:id}
  }).then((response)=>{
    this.getInvestigation = response.data;
    });

   $http({   
    method: 'POST',
    url:'./jsonData/getReview.json.php',
    data: {order_id:id}
  }).then((response)=>{
    this.getReview = response.data;
    });

 $http({   
    method: 'POST',
    url:'./jsonData/getCustomerNcr.json.php',
    data: {order_id:id}
  }).then((response)=>{
    this.getCustomerNcr = response.data;
    });

  $http({
    method:'POST',
    url: './jsonData/getOpenNcrs.json.php',
    data:{status: 'CLOSED'}
  }).then((response)=>{
      this.getClosedNcrs = response.data;
    });

  $http({
    method:'POST',
    url: './jsonData/getOpenNcrs.json.php',
    data:{status: 'OPEN'}
  }).then((response)=>{
      this.getNcrs = response.data;
    });
  $scope.options=[{
    id: 1,
    reason: 'Not Received'
  },
  {
    id:2,
    reason:'Damaged'
  },
  {
    id:3,
    reason:'Incorrect Qty'

  },
  {
  id:4,
    reason:'Incorrect Product'

  },
  {
    id:5,
    reason: 'Faulty Product'
  },
  {
    id:6,
    reason: 'Late Delivery'
  },
  {
    id:7,
    reason: 'DX'
  },
  {
    id:8,
    reason: 'DPD'
  },
  {
    id:9,
    reason: 'Yodel'
  },
  {
    id:10,
    reason: 'Courier Charge'
  }];

  $scope.nc = function(x){
     $scope.myStyle = {
    "display":"none"
  }
}
this.x={};
  $scope.raiseNCR=()=>{
    $http({
      method: 'POST',
      url: './jsonData/ncrAction.php',
      data: {action: 'openNcr',
      details: $scope.n.getOrder[0]
      }
    }).then((response)=>{
      this.getResponse = response.data;
    });
  };

  $scope.searchOrder =()=>{
   //$scope.findOrder = 'P236001';
  $http({
    method:'POST',
    url:'./jsonData/ncrAction.php',
    data: {action: 'searchOrder',
    order:$scope.findOrder}
    }).then((response)=>{
      this.getOrder = response.data;
    });
  }
$scope.saved = ()=>{
 alert("Ncr Saved");
 window.location.reload();
}

  $scope.updateLine =(reason,description,x,corrective,initials)=>{

  $http({
    method:'POST',
    url:'./jsonData/updateNcrStep2.json.php',
    data: {reason:reason.reason,
      description:description,
      id: x.item_id,
      corrective: corrective,
      initials:initials}
  })
};
})
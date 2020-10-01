<!DOCTYPE HTML>
  <head>
    <!-- Required meta tags -->
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
     <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<link  rel="stylesheet" href="./css/northwindCss.css">



<title>Postpack</title> v20.12
 <base href="/">
</head>
<div ng-app="myApp">

<body>
	<div id="index" class="container-fluid">
	<H1> <a href="/" style="">Postpack</a></H1>
	<!-- VERTICAL MAIN MENU----->
  <div id="content">
	<div id="vertical-menu" >
	<ul class="nav flex-column">
  <li class="nav-item"><strong>Customers</strong>
    <a class="nav-link active" href="/customers">Search</a>
  </li>
  <li class="nav-item"><strong>Suppliers</strong>
    <a class="nav-link" href="/suppliers">Search</a>
  </li>
  <li class="nav-item"> <strong>Products</strong>
    <a class="nav-link" href="/searchProduct">Search By Sku</a>
    <a class="nav-link" href="/searchByCategory">Search By Category</a>
    <a class="nav-link" href="/lowStockReport">Low Stock Report</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" tabindex="-1" aria-disabled="true"></a>
  </li>
</ul>
</div>
<div class="contentView">
  <div ng-view >
    
  </div> 
</div>

</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular-route.js"></script>
</body>

<script type="text/javascript" src = "./myApp/northwind.js"></script>	
</div>
</html>
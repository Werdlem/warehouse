<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));

$ProductName = $data->ProductName;
$SupplierID = $data->selectSupplier->SupplierID;
$CategoryID = $data->selectCategory->CategoryID;
$QuantityPerUnit = $data->QuantityPerUnit;
$CostPrice = $data->CostPrice;
$UnitPrice =$data->UnitPrice;
$UnitsInStock =$data->UnitsInStock;
$UnitsOnOrder = $data->UnitsOnOrder;
$ReorderLevel = $data->ReorderLevel;
$Discontinued = $data->Discontinued;

$fetch = $dal->addProduct($ProductName,$SupplierID, $CategoryID, $QuantityPerUnit,$CostPrice,$UnitPrice,$UnitsInStock,$UnitsOnOrder,$ReorderLevel,$Discontinued);
echo json_encode($fetch);
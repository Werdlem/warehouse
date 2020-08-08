<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;

switch ($action) {

	case 'deleteAdj': // delete adjustment
		$id = $data->id;
		//echo $id;
	$delete = $dal->deleteAllocation($id);
		break;

	case 'in': // adjust stock in
		$field = 'AdjustIn';
		$skuID = $data->SkuID;
		$qty = $data->details->Qty;
		$initials = $data->details->initials;
		$reason = $data->details->reason;
	//echo $field;
	$fetch = $dal->adjIn($skuID, $qty, $initials,$reason);
		break;

	case 'out': // adjust stock out
		$skuID = $data->SkuID;
		$qty = $data->details->Qty;
		$initials = $data->details->initials;
		$reason = $data->details->reason;
	$field = 'AdjustOut';
	//echo $field;
	$fetch = $dal->adjOut($skuID, $qty, $initials,$reason);
		break;

	case 'addProduct': //add product to DB
		$ProductName = $data->newP->ProductName;
		$CategoryId = $data->newP->selectCategory->CategoryId;
		$QuantityPerUnit = $data->newP->QuantityPerUnit;
		$CostPrice = $data->newP->CostPrice;
		$UnitPrice =$data->newP->UnitPrice;
		$UnitsInStock =$data->newP->UnitsInStock;
		$UnitsOnOrder = $data->newP->UnitsOnOrder;
		$ReorderLevel = $data->newP->ReorderLevel;

$fetch = $dal->addProduct($ProductName, $CategoryId, $QuantityPerUnit,$CostPrice,$UnitPrice,$UnitsInStock,$UnitsOnOrder,$ReorderLevel);
echo json_encode($fetch);
		break;
}
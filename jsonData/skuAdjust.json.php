<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));
$skuID = $data->SkuID;
$qty = $data->details->Qty;
$initials = $data->details->initials;
$reason = $data->details->reason;
if ($data->adj == 'in'){
	$field = 'AdjustIn';
	$fetch = $dal->adjIn($skuID, $qty, $initials,$reason);
}
elseif ($data->adj == 'out'){
	$field = 'AdjustOut';
	$fetch = $dal->adjOut($skuID, $qty, $initials,$reason);
}
//$fetch = $dal->adjIn($skuID, $qty, $initials,$reason);
//$update = $dal->SkuStockUpdate();
echo json_encode($fetch);
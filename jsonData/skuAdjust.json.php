<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));
$skuID = $data->SkuID;
$qty = $data->details->Qty;
$initials = $data->details->initials;
$reason = $data->details->reason;

$fetch = $dal->adjIn($skuID, $qty, $initials,$reason);
echo json_encode($fetch);
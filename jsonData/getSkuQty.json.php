<?php

require_once ('../DB/specConn.php');
$data = json_decode(file_get_contents("php://input"));
$id = $data->pID;
$dal = new products();
#$fetch = $dal->getAdjustments($id);
$qty = $dal->getStockQuantity($id);
#echo json_encode($fetch);
echo json_encode($qty);
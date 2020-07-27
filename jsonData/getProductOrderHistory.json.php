<?php

require_once ('../DB/specConn.php');
$data = json_decode(file_get_contents("php://input"));
$pId = $data->pId;
$dal = new products();
$fetch = $dal->getProductOrderHistory($pId);
echo json_encode($fetch);
<?php

require_once ('../DB/specConn.php');
$data = json_decode(file_get_contents("php://input"));
$cId = $data->cId;
$dal = new products();
$fetch = $dal->getProductsByCategory($cId);
echo json_encode($fetch);
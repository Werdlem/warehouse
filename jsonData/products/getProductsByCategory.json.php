<?php

require_once ('../DB/specConn.php');
$value = json_decode(file_get_contents("php://input"));
$cID = $data->cId;
$dal = new northwind();
$fetch = $dal->getProductsByCategory();
echo json_encode($fetch);
<?php

require_once ('../DB/customerConn.php');
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$dal = new customers();
$fetch = $dal->getCustOrdDetails($id);
echo json_encode($fetch);
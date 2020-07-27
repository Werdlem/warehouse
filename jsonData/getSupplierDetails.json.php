<?php

require_once ('../DB/supplierConn.php');
$dal = new suppliers();
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$fetch = $dal->getSupplierDetails($id);
echo json_encode($fetch);
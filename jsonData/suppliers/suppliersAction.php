<?php

require_once ('../DB/supplierConn.php');
$dal = new suppliers();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;


switch ($action) {

	case 'getSupplierList':
	$fetch = $dal->getSupplierList();
	echo json_encode($fetch);
	break;

}
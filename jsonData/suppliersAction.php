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

	case 'getSupplierDetails':
	if(isset($data->ref)){
		$id= $data->ref;
		$fetch = $dal->getSupplierDetails($id);
		echo json_encode($fetch);
		break;
	}
	case 'updateLead':
	$ref = $data->details->ACCOUNT_REF;
	$lead = $data->lead;
	$add = $dal->addSupplierLead($ref,$lead);
	break;

}
<?php

require_once ('../DB/ncrConn.php');
$dal = new ncr();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;


switch ($action) {

	case 'openNcr':
	$OrderID = $data->details->OrderID;
	$customer = $data->details->customer;
	$Despatch = $data->details->despatch;
	$add = $dal->openNcr($OrderID,$customer,$Despatch);
	echo json_encode($add);
	break;


	case 'searchOrder':
	$order = $data->order;
	$fetch = $dal->searchOrder($order);
	echo json_encode($fetch);
	break;

}
<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;

switch ($action) {
	case 'deleteAdj':
		echo 'delete adj';
		break;
	case 'in':
		echo 'in';
		break;
	case 'out':
		echo 'out';
		break;
	case 'addProduct':
		echo 'Add Product';
		break;
}
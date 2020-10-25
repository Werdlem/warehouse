<?php

require_once ('../DB/calculator.php');
$dal = new calculator();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;


switch ($action) {

	case 'searchTools':
	$ref = $data->ToolRef;
	$dal = new calculator();
	$search = $dal->searchTools($ref);
	echo json_encode($search);
	break;

	case 'getToolViaUrl':
	$toolID = $data->toolID->toolID;
	$tool =  $data->toolID->tool;
	
		$fetch = $dal->getToolViaUrl($toolID);
		echo json_encode($fetch);
		break;

	case 'getSheetboard':
	$fetch = $dal->getSheetboard();
	echo json_encode($fetch);
	break;

}
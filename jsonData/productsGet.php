<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;

switch ($action) {
	case 'updateLocation':
	$locationID = $data->locationID;
	$SkuID = $data->SkuID->SkuID;
	$addLocation = $dal->updateLocation($locationID,$SkuID);
	break;

	case 'getLocations':
	$location = $data->location;
	$fetch = $dal->getLocations($location);
	echo json_encode($fetch);
	break; 

	case 'getLowStock':
	$fetch = $dal->getLowStock();
	echo json_encode($fetch);
	break;

	case 'getProductViaUrl':
	$SkuID = $data->SkuID->SkuID;
	$Sku =  $data->SkuID->Sku;
	$update = $dal->updateSku($SkuID, $Sku);
	//echo json_encode($update);

	$skuID = $data->SkuID->SkuID;

	
		$fetch = $dal->getProduct($skuID);
		echo json_encode($fetch);
		break;

case 'getHistory':
	$id = $data->pId->SkuID;
$fetch = $dal->getProductHistory($id);
echo json_encode($fetch);
	break;

case 'skuOrderReq':
		$id = $data->pId->SkuID;
		$dal = new products();
		$fetch = $dal->getSkuOrderReq($id);

		echo json_encode($fetch);

		break;
case 'getSkuPoHistory':

		$pId = $data->pId->Sku;

$fetch = $dal->getProductOrderHistory($pId);
echo json_encode($fetch);
	break;

	case 'getProductAdjustment';

	$id = $data->pId->SkuID;
$dal = new products();
$fetch = $dal->getAdjustments($id);
echo json_encode($fetch);
	break;

	
}
<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;


switch ($action) {

	case 'addLocation':
	$location = strtoupper($data->location);
	$dal = new products();
	$addLocation = $dal->addLocation($location);
	break;

	case 'updateLocation':
	$locationID = $data->locationID;
	$SkuID = $data->SkuID->SkuID;
	$dal = new products();
	$addLocation = $dal->updateLocation($SkuID,$locationID);
	break;

	case 'delLocation': //delete product sku from locatation
	$id = $data->id;
	$del = $dal->delLocation($id);
	break;

	case 'delAlias': //delete Alias
$AliasID = $data->AliasID;
echo $AliasID;
$dal = new products();
$fetch = $dal->delAlias($AliasID);
break;

	case 'deleteAdj': // delete adjustment
		$id = $data->id;
		//echo $id;
	$delete = $dal->deleteAllocation($id);
		break;

	case 'AdjustIn': // adjust stock in
		$field = 'AdjustIn';
		$skuID = $data->SkuID;
		$qty = $data->details->Qty;
		$initials = strtoupper($data->details->initials);
		$reason = strtoupper($data->details->reason);
	//echo $field;
	$fetch = $dal->adjIn($skuID, $qty, $initials,$reason);
	$update = $dal->updateAllSku();
	$liveStock = $dal->getLiveStockFigures();
		break;

	case 'out': // adjust stock out
		$skuID = $data->SkuID;
		$qty = $data->details->Qty;
		$initials = strtoupper($data->details->initials);
		$reason = strtoupper($data->details->reason);
	$field = 'AdjustOut';
	//echo $field;
	$fetch = $dal->adjOut($skuID, $qty, $initials,$reason);
	$update = $dal->updateAllSku();
	$liveStock = $dal->getLiveStockFigures();
		break;

	case 'addProduct': //add product to DB
		$ProductName = strtoupper($data->newP->ProductName);
		$CategoryId = $data->newP->selectCategory->CategoryId;
		$QuantityPerUnit = $data->newP->QuantityPerUnit;
		$CostPrice = $data->newP->CostPrice;
		$UnitPrice =$data->newP->UnitPrice;
		$UnitsInStock =$data->newP->UnitsInStock;
		$Description = strtoupper($data->newP->Description);
		$ReorderLevel = $data->newP->ReorderLevel;

$fetch = $dal->addProduct($ProductName, $CategoryId, $QuantityPerUnit,$CostPrice,$UnitPrice,$UnitsInStock,$Description,$ReorderLevel);
echo $Description;
echo json_encode($fetch);
		break;

	#edit selected product
	case 'editProduct':
		$Sku = strtoupper($data->details->Sku);
		$Desc = strtoupper($data->details->Description);
		$Qpu = $data->details->QuantityPerUnit;
		$UnitPrice = $data->details->UnitPrice;
		$ReorderLevel = $data->details->ReorderLevel;
		$Notes = strtoupper($data->details->Notes);
		$description = strtoupper($data->details->Description);

		if(isset($data->category->CategoryId)){
			$CategoryId = $data->category->CategoryId;
		}
		else{
			$CategoryId = $data->details->CategoryId;
		}

		$SkuID = $data->SkuID->SkuID;

		if ($data->details->Discontinued ==''){
			$Discontinued = 0;
		}

		else{
			$Discontinued = $data->details->Discontinued;
		}
		if ($data->LowStock ==''){
			$lowStock = 0;
		}

		else{
			$lowStock = $data->LowStock;
		}
		
		$fetch = $dal->updateProduct($Sku, $Desc,$Qpu,$UnitPrice, $ReorderLevel,$Notes, $Discontinued, $CategoryId, $lowStock, $SkuID);
		break;


case 'orderReq':
	$SkuID = $data->Sku->SkuID;
	$Sku = strtoupper($data->Sku->Sku);
	$qty = $data->details->qty;
	$initials = $data->details->Initials;

	if(isset($data->details->delivery)){
		$delivery = 'YES';
		$po = $data->details->po;

	
	}
	else {
		$delivery = 'NO';
		$po = 'NA';
		
	}
	if(isset($data->details->notes)){
		$notes = strtoupper($data->details->notes);
		
	}
	else {
		$notes = 'NA';
	}
		#send email to office

	 	require_once "../DB/settings.php";
 		require_once '../lib/swift_required.php';

 		//Create the transport

			$transport = (new Swift_SmtpTransport(SMTP_HOST, SMTP_PORT,'tls'))
			->setUsername(Username)
			->setPassword(Password);
			//$transport = Swift_MailTransport::newInstance('smtp.gmail.com', 465);
			$mailer = new Swift_Mailer($transport);			
			$message = (new Swift_Message('PLEASE ORDER'))
			->setSubject('Product Order: ' .$Sku)
			->setFrom($EMAIL_ORDERS_FROM)
			->setCc($EMAIL_ORDERS_PU)
			->setTo($EMAIL_ORDERS_TO)
			
			//Order Body//
			
			->setBody('<html>'.
                'Please order '. $qty . '(qty) of <a href="http://warehouse.web/productDetails?SkuID='.$SkuID.'&Sku='.$Sku.'">'.$Sku.'</a><br /><br />
                Direct Delivery: '.$delivery.'<br/>
                PO: '.$po.'<br/>
                Additional Notes: '.$notes.'<br/>'.
                'Initials: '.strtoupper($initials).'<br>'.
                '</body>' .
                '</html>',
                'text/html'
            );
			
		
			$result = $mailer->send($message);
			if ($result > 0)
			{
				$initials = strtoupper($data->details->Initials);
	$execute = $dal->orderReq($SkuID, $Sku, $qty, $delivery, $po, $notes, $initials);
	//$execute = $dal->updateProductDate($SkuID);
	$execute = $dal->updateSkuOrderDate($SkuID);
	$result = 'Success';
	echo $result;
			
            }
            else{
            	

            	$result = 'Failure';

            	echo $result;
				
				}

	break;

	case 'skuOrderReq':
		$id = $data->pId;
		$dal = new products();
		$fetch = $dal->getSkuOrderReq($id);

		echo json_encode($fetch);

		break;

	case 'autoSelect':$Sku  =$data->Sku;
	$fetch = $dal->autoSelect($Sku);
	echo json_encode($fetch);
		$SkuID = $data->Sku;

		break;

	case 'searchProduct';
	//$updateStock = $dal->updateAllSku();
	//$liveStock = $dal->getLiveStockFigures();
	$Sku  =$data->Sku;
	$fetch = $dal->searchProduct($Sku);
	print (json_encode($fetch));
}
<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;


switch ($action) {

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
		break;

	case 'out': // adjust stock out
		$skuID = $data->SkuID;
		$qty = $data->details->Qty;
		$initials = strtoupper($data->details->initials);
		$reason = strtoupper($data->details->reason);
	$field = 'AdjustOut';
	//echo $field;
	$fetch = $dal->adjOut($skuID, $qty, $initials,$reason);
		break;

	case 'addProduct': //add product to DB
		$ProductName = $data->newP->ProductName;
		$CategoryId = $data->newP->selectCategory->CategoryId;
		$QuantityPerUnit = $data->newP->QuantityPerUnit;
		$CostPrice = $data->newP->CostPrice;
		$UnitPrice =$data->newP->UnitPrice;
		$UnitsInStock =$data->newP->UnitsInStock;
		$UnitsOnOrder = $data->newP->UnitsOnOrder;
		$ReorderLevel = $data->newP->ReorderLevel;

$fetch = $dal->addProduct($ProductName, $CategoryId, $QuantityPerUnit,$CostPrice,$UnitPrice,$UnitsInStock,$UnitsOnOrder,$ReorderLevel);
echo json_encode($fetch);
		break;

	#edit selected product
	case 'editProduct':
		$Sku = $data->details->Sku;
		$Desc = $data->details->description;
		$Qpu = $data->details->QuantityPerUnit;
		$UnitPrice = $data->details->UnitPrice;
		$ReorderLevel = $data->details->ReorderLevel;
		$Notes = $data->details->Notes;

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
		
		$fetch = $dal->updateProduct($Sku, $Desc,$Qpu,$UnitPrice, $ReorderLevel,$Notes, $Discontinued, $CategoryId, $SkuID);
		break;


case 'orderReq':
	$SkuID = $data->Sku->SkuID;
	$Sku = strtoupper($data->Sku->Sku);
	$qty = $data->details->qty;
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
			$transport = Swift_MailTransport::newInstance(SMTP_HOST, SMTP_PORT);
			//$transport = Swift_MailTransport::newInstance('smtp.gmail.com', 465);
			$mailer = Swift_Mailer::newInstance($transport);			
			$message = Swift_Message::newInstance('Please Order')
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
	$Sku  =$data->Sku;
	$fetch = $dal->searchProduct($Sku);
	print (json_encode($fetch));

}
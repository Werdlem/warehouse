<?php

require_once ('../DB/specConn.php');
$dal = new products();
$data = json_decode(file_get_contents("php://input"));

$action = $data->action;

switch ($action) {

	case 'deleteAdj': // delete adjustment
		$id = $data->id;
		//echo $id;
	$delete = $dal->deleteAllocation($id);
		break;

	case 'in': // adjust stock in
		$field = 'AdjustIn';
		$skuID = $data->SkuID;
		$qty = $data->details->Qty;
		$initials = $data->details->initials;
		$reason = $data->details->reason;
	//echo $field;
	$fetch = $dal->adjIn($skuID, $qty, $initials,$reason);
		break;

	case 'out': // adjust stock out
		$skuID = $data->SkuID;
		$qty = $data->details->Qty;
		$initials = $data->details->initials;
		$reason = $data->details->reason;
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
		$SkuID = $data->details->SkuID;
		$Discontinued = $data->details->Discontinued;

		echo $CategoryId;
	
		
		$fetch = $dal->updateProduct($Sku, $Desc,$Qpu,$UnitPrice, $ReorderLevel,$Notes, $Discontinued, $CategoryId, $SkuID);
		break;


case 'orderReq':
	$SkuID = $data->SkuID;
	$Sku = strtoupper($data->Sku);
	$qty = $data->details->qty;
	if(isset($data->details->delivery)){
		$delivery = 'DIRECT';
		$po = $data->details->po;
	}
	else {
		$delivery = 'NA';
		$po = 'NA';
	}
	if(isset($data->details->notes)){
		$notes = strtoupper($data->details->notes);
		
	}
	else {
		$notes = 'NA';
	}
	$initials = strtoupper($data->details->Initials);
	$execute = $dal->orderReq($SkuID, $Sku, $qty, $delivery, $po, $notes, $initials);
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
                'Please order '. $qty . '(qty) of '.$Sku.'</a><br /><br />
                Direct Delivery: '.$delivery.'<br/>
                PO: '.$po.'<br/>
                Additional Notes: '.$notes.'<br/>'.
                '</body>' .
                '</html>',
                'text/html'
            );
			
			//$numSent = $mailer->send($message);
			//printf("Send %d messages\n", $numSent);
			
			$result = $mailer->send($message);
			if ($result > 0)
			{
				echo "<div class='panel panel-success'>
<div class='panel-heading' style='text-align:center;'><h3>Order Success!</h3></div>
<div class='panel-body'>
				Your order of ".$product .'-'.$priority." has been successfully sent, have a nice day :-D"
				?>
				
				<button onclick='goBack()'>Go Back</button>

				<script>
						function goBack() {
   						 window.history.back();
				}
						</script>
				</div></div>
			<?php
            }
            else{
				
				echo "<div class='panel panel-danger'>
						<div class='panel-heading' style='text-align:center;'><h3>Order Failure</h3></div>
						<div class='panel-body'>
						<p>Your order of <strong style='red'><a href='?action=activity&sku=". $Sku ."&sku_id=".$SkuID."'> ".$Sku." </a></strong> was not sent, please call the office with your order.</p>
				</div>
				</div>";
				
				}

	break;

	case 'skuOrderReq':
		$id = $data->pId;
		$dal = new products();
		$fetch = $dal->getSkuOrderReq($id);

		echo json_encode($fetch);

		break;

		case 'getLocation':
		$SkuID = $data->pId;

		$fetch = $dal->getLocations($SkuID);
		echo json_encode($fetch);
		break;

	case 'searchProduct';
	$Sku  =$data->Sku;
	$fetch = $dal->searchProduct($Sku);
	echo json_encode($fetch);

}
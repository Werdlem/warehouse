<?php

require_once ('../DB/specConn.php');
$data = json_decode(file_get_contents("php://input"));

		$id = $data->pId;
		$dal = new products();
		$fetch = $dal->getSkuOrderReq($id);

		echo json_encode($fetch);
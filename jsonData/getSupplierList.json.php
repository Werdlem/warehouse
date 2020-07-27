<?php

require_once ('../DB/supplierConn.php');
$dal = new suppliers();
$fetch = $dal->getSupplierList();
echo json_encode($fetch);
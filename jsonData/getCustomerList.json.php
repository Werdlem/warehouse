<?php

require_once ('../DB/customerConn.php');
$dal = new customers();
$fetch = $dal->getCustomerList();
echo json_encode($fetch);
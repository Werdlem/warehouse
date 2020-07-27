<?php

require_once ('../DB/specConn.php');
$dal = new northwind();
$fetch = $dal->getCategories();
echo json_encode($fetch);
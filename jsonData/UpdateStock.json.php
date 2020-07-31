<?php

require_once ('../DB/specConn.php');
$dal = new products();
$fetch = $dal->StockUpdate();


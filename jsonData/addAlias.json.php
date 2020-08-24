<?php

require_once ('../DB/specConn.php');
$data = json_decode(file_get_contents("php://input"));
$SkuID = $data->SkuID->SkuID;
$alias = $data->Alias->alias;
$initials = $data->Alias->initials;
$dal = new products();
$fetch = $dal->addAlias($SkuID,$alias, $initials);

echo json_encode($fetch);

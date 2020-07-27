<?php
require_once('settings.php');


class customers{

  public function getProductHistory($id){
   $pdo = Database::DB();
   $stmt = $pdo->prepare('select OrderDate as ShippedDate,ProductName,UnitPrice, Quantity, Discount,ExtendedPrice as Pounds, Freight
FROM
invoices
WHERE customerID = :id
ORDER BY OrderDate desc
');
   $stmt->bindValue(':id', $id);
   $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getCustOrdDetails($id){
   $pdo = Database::DB();
   $stmt = $pdo->prepare(' select OrderID, OrderDate, ShippedDate, s.CompanyName AS ShippedVia
FROM
orders o
LEFT JOIN shippers s
ON
o.ShipVia=s.ShipperID
WHERE CustomerID = :id');
   $stmt->bindValue(':id', $id);
   $stmt->execute();
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getCustomerDetails($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select 
      *
      from 
      customers
      where 
      CustomerID = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return$stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getCustomerList(){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select 
      CustomerID, CompanyName, ContactName, Phone
      from 
      customers');
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  
}
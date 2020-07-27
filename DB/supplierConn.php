<?php
require_once('settings.php');

class suppliers{

  public function getSupplierDetails($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select 
      *
      from 
      suppliers
      where 
      supplierID = :id');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    return$stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getSupplierList(){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select 
      SupplierID, CompanyName, ContactName, Phone
      from 
      Suppliers');
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  
}
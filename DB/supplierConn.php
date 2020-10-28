<?php
require_once('settings.php');

class suppliers{
   public function getSupplierList(){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select *
      from
      _suppliers
      ');   
    $stmt->execute();
    if($stmt->rowCount()>0)
   {
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
 }
 public function getSupplierDetails($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select *
      from _suppliers s 
      left join
      supplier_lead_times sl on 
      s.ACCOUNT_REF = sl.supplierRef
      where 
      s.ACCOUNT_REF = :stmt');
    $stmt->bindValue(':stmt', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function addSupplierLead($ref,$lead){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert
      into supplier_lead_times
      (supplierRef, lead)
      values (:ref, :lead) 
      on duplicate key update
      lead=:lead');
    $stmt->bindValue('ref', $ref);
    $stmt->bindValue(':lead', $lead);
    $stmt->execute();
}
}
<?php
require_once('settings.php');

class products{

  #GET STOCK QTY
public function getStockQuantity($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('
      sELECT SUM(qty_delivered) AS total
      FROM
      products p
      JOIN alias a oN p.SkuID=a.SkuID
      JOIN goods_out go ON p.Sku=go.sku OR a.Alias=go.sku OR a.Alias=go.desc1sku
      WHERE 
      p.SkuID = :pId
      ');
    $stmt->bindValue(':pId', $id);
    $stmt->execute();
    if($stmt->rowCount()>0){
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
    echo 'No Data!';
  }
}

  public function getAdjustments($id){
    
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select * 
      FROM adjustments
      where
      SkuID  = :pId');
    $stmt->bindValue(':pId', $id);
    $stmt->execute();
    if($stmt->rowCount()>0){
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
    echo 'No Data!';
  }
   
  }

  public function adjIn($skuID, $qty, $initials,$reason){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      adjustments
      (skuID,AdjustIn,Initials,Reason)
      values
      (?,?,?,?)
      ');
    $stmt->bindValue(1, $skuID);
    $stmt->bindValue(2, $qty);
    $stmt->bindValue(3, $initials);
    $stmt->bindValue(4, $reason);
    $stmt->execute();
    }

  public function addProduct($ProductName,$SupplierID, $categoryID, $QuantityPerUnit,$CostPrice,$UnitPrice,$UnitsInStock,$UnitsOnOrder,$ReorderLevel,$Discontinued){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      products
      (ProductName,SupplierID,categoryID,QuantityPerUnit,CostPrice,UnitPrice,UnitsInStock, UnitsOnOrder, ReorderLevel,Discontinued)
      values
      (?,?,?,?,?,?,?,?,?,?)
      ');
    $stmt->bindValue(1, $ProductName);
    $stmt->bindValue(2, $SupplierID);
    $stmt->bindValue(3, $categoryID);
    $stmt->bindValue(4, $QuantityPerUnit);
    $stmt->bindValue(5, $CostPrice);
    $stmt->bindValue(6, $UnitPrice);
    $stmt->bindValue(7,$UnitsOnOrder);
    $stmt->bindValue(8, $UnitsOnOrder);
    $stmt->bindValue(9, $ReorderLevel);
    $stmt->bindValue(10, $Discontinued);
    $stmt->execute();
    }

  public function getProductOrderHistory($pId){
    
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select * 
      FROM goods_in gi
      JOIN
      products p ON
      gi.Sku=p.sku
      
      where
      gi.Sku  = :pId');
    $stmt->bindValue(':pId', $pId);
    $stmt->execute();
    if($stmt->rowCount()>0){
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
    echo 'No Data!';
  }
   
  }

  public function getSuppliers(){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select CompanyName as SupplierName, SupplierID
      from 
      suppliers');
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  public function getCategories(){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select *
      from 
      product_categories');
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getProductsByCategory($cId){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select *,
      (sELECT SUM(qty_delivered) AS total
      FROM
      products pr
      JOIN alias a oN pr.SkuID=a.SkuID
      JOIN goods_out go ON pr.Sku=go.sku OR a.Alias=go.sku OR a.Alias=go.desc1sku
      WHERE 
      pr.SkuID = p.SkuID) as total
      from 
      products p     
      where p.CategoryId = :cId');
    $stmt->bindValue(':cId', $cId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getProductHistory($pId){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('SELECT go.orderID, p.skuID,p.sku, alias, go.DueDate, go.qty_delivered, go.DispatchDate
FROM
products p
 JOIN
alias a ON
p.SkuID = a.SkuID
JOIN
goods_out go ON
a.alias=go.Desc1Sku
OR
p.Sku=go.sku
OR
a.Alias=go.sku
where 
p.SkuID = :pId
ORDER BY 
go.DueDate desc
');
    $stmt->bindValue(':pId', $pId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }


}
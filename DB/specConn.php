<?php
require_once('settings.php');

class products{
  #edit product

  #UPDATE `stock`.`products` SET `alias_1`='A' WHERE  `SkuID`=7

  #delete allocation
  public function deleteAllocation($id){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('delete 
      from adjustments
      where
      id = :id
      ');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
  }
  #UPDATESTOCK

  public function StockUpdate(){
      $pdo = Database::DB();
      $stmt = $pdo->prepare('call UpdateStock()
      ');
      $stmt->execute();     
    
    }

  #fetch SkU alias's
     public function getSkuAlias($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select * 
      from
      alias
      where
      SkuID = :stmt
      ');
    $stmt->bindValue(':stmt', $id);
     $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
      
  }

  #add product alias
   public function addAlias($skuID,$alias, $initials){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      alias
      (SkuID,Alias,Initials)
      values
      (?,?,?)
      ');
   
    $stmt->bindValue(1, $skuID);   
    $stmt->bindValue(2, $alias);
    $stmt->bindValue(3, $initials);
   
    $stmt->execute();
    }

  #Products stock quantity update

  public function SkuStockUpdate(){
      $pdo = Database::DB();
      $stmt = $pdo->prepare('call UpdateStock()
      ');
      $stmt->execute();     
    
    }

  #GET STOCK QTY
public function getStockQuantity($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('
      SELECT StockQty as qty
      from products p
      where 
      p.SkuID = :pID
      ');
    $stmt->bindValue(':pID', $id);
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
      SkuID  = :pId
      order BY
      date desc');
    $stmt->bindValue(':pId', $id);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
      
  }

  public function adjIn($skuID, $qty, $initials,$reason){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      adjustments
      (SkuID,AdjustIn,Initials,Reason)
      values
      (?,?,?,?)
      ');
   
    $stmt->bindValue(1, $skuID);   
    $stmt->bindValue(2, $qty);
    $stmt->bindValue(3, $initials);
    $stmt->bindValue(4, $reason);
    $stmt->execute();
    }
    public function adjOut($skuID, $qty, $initials,$reason){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      adjustments
      (SkuID,AdjustOut,Initials,Reason)
      values
      (?,?,?,?)
      ');
   
    $stmt->bindValue(1, $skuID);   
    $stmt->bindValue(2, $qty);
    $stmt->bindValue(3, $initials);
    $stmt->bindValue(4, $reason);
    $stmt->execute();
    }

  public function addProduct($ProductName, $categoryId, $QuantityPerUnit,$CostPrice,$UnitPrice,$UnitsInStock,$ReorderLevel){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      products
      (Sku,categoryId,QuantityPerUnit,CostPrice,UnitPrice,StockQty, ReorderLevel)
      values
      (?,?,?,?,?,?,?)
      ');
    $stmt->bindValue(1, $ProductName);
    //$stmt->bindValue(2, $SupplierID);
    $stmt->bindValue(2, $categoryId);
    $stmt->bindValue(3, $QuantityPerUnit);
    $stmt->bindValue(4, $CostPrice);
    $stmt->bindValue(5, $UnitPrice);
    $stmt->bindValue(6,$UnitsInStock);
    //$stmt->bindValue(7, $UnitsOnOrder);
    $stmt->bindValue(7, $ReorderLevel);
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
      gi.Sku  = :pId
      order by DeliveryDate desc');
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
    $stmt = $pdo->prepare('select *
      from 
      products p
      where p.CategoryId = :cId');
    $stmt->bindValue(':cId', $cId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getProductHistory($pId){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('SELECT go.orderID, p.skuID,p.sku, alias, go.DueDate, go.QtyDelivered, go.DispatchDate, go.despatch
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
p.SkuID = :pId and QtyDelivered > "0"
ORDER BY 
go.DueDate desc
');
    $stmt->bindValue(':pId', $pId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }


}
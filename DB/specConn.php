<?php
require_once('settings.php');

class products{
  #product search
  public function searchProduct($Sku){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select * 
      from
      products
      where
      Sku like :sku
      ');
    $stmt->bindValue(':sku', $Sku.'%');
     $stmt->execute();
   if($stmt->rowCount()>0){
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
    echo 'No Data';
  }
      
  }

  #get Product Locations
  public function getLocations($SkuID){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select * 
      from
      location l
      join products p
      on
      l.SkuID = p.SkuID
      where
      l.SkuID = :stmt
      ');
    $stmt->bindValue(':stmt', $SkuID);
     $stmt->execute();
   if($stmt->rowCount()>0){
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
    echo 'No Data';
  }
      
  }

  #select sku order request history

  public function getSkuOrderReq($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select * 
      from
      sku_order_request
      where
      SkuID = :stmt
      ');
    $stmt->bindValue(':stmt', $id);
     $stmt->execute();
   if($stmt->rowCount()>0){
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
    echo 'No Data!';
  }
      
  }
  #sku order history
  public function orderReq($SkuID, $Sku, $qty, $deliver, $po, $notes, $initials){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
     sku_order_request
      (SkuID, Sku, Qty, Deliver, Po, Notes, Initials)
      values
      (?,?,?,?,?,?,?)
      ');
   
    $stmt->bindValue(1, $SkuID);   
    $stmt->bindValue(2, $Sku);
    $stmt->bindValue(3, $qty);
    $stmt->bindValue(4, $deliver);
    $stmt->bindValue(5, $po);
    $stmt->bindValue(6, $notes); 
    $stmt->bindValue(7,$initials); 
    $stmt->execute();
    }

  #edit product
  public function updateProduct($Sku, $Desc,$Qpu,$UnitPrice, $ReorderLevel,$Notes, $Discontinued, $CategoryId, $SkuID){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('update products
      set Sku = :sku, Description = :desc, QuantityPerUnit = :Qpu, UnitPrice = :UnitPrice, ReorderLevel = :ReorderLevel, Notes = :notes, Discontinued = :disc, CategoryId = :CategoryId
      where
      SkuID = :SkuID
      ');
    $stmt->bindValue(':sku', $Sku);
    $stmt->bindValue(':desc', $Desc);
    $stmt->bindValue(':Qpu',$Qpu);
    $stmt->bindValue(':UnitPrice', $UnitPrice);
    $stmt->bindValue(':ReorderLevel', $ReorderLevel);
    $stmt->bindValue(':notes',$Notes);
    $stmt->bindValue(':disc', $Discontinued);
    $stmt->bindValue(':CategoryId', $CategoryId);
    $stmt->bindValue('SkuID', $SkuID);
    $stmt->execute();
  }

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
    $stmt = $pdo->prepare('sELECT go.orderID, p.skuID,p.sku, a.alias, go.sku, go.desc1sku, go.DueDate, go.QtyDelivered, go.DispatchDate, go.despatch
FROM
products p 
left join
alias a on
p.SkuID=a.SkuID
JOIN
goods_out go on
p.Sku = go.sku
or 
p.Sku = go.desc1sku
or
a.Alias = go.sku
or
a.Alias = go.desc1sku
where
p.SkuID = :pId and QtyDelivered > 0
ORDER BY 
go.DueDate desc
');
    $stmt->bindValue(':pId', $pId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }


}
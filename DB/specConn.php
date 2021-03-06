<?php
require_once('settings.php');

class products{
   public function addLocation($location){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
     locations
      (location)
      values
      (?)');
   
    $stmt->bindValue(1, $location);   
    $stmt->execute();
    }



  public function getProductLocations($SkuID){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select *
    from locations l 
    join
    products p on
    l.SkuID = p.SkuID   
    where
    l.SkuID = :SkuID 
      ');
    $stmt->bindValue(':SkuID', $SkuID);
   $stmt->execute();
   if($stmt->rowCount()>0)
   {
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
}
  #del skuID from location
  public function delLocation($id){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('update
      locations
      set SkuID = NULL
    where
    location_id = :id    
      ');
    $stmt->bindValue(':id', $id);
    //$stmt->bindValue(':locationID', $locationID);
   $stmt->execute();
   
}
  #add product to locaiton
  public function updateLocation($SkuID,$locationID){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('update locations
    set SkuID = :SkuID
    where location_id = :locationID    
      ');
    $stmt->bindValue(':SkuID', $SkuID);
    $stmt->bindValue(':locationID', $locationID);
   $stmt->execute();
   
}

  #get Low Sstock report ignoring JWM (9), 0201 + board(23&31), bubble (41),  loadpoint(48)

public function getLiveStockFigures(){
      $pdo = Database::DB();
      $stmt = $pdo->prepare('call Live_StockQty_2()');
      $stmt->execute();     
    
    }
 public function getLowStock(){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select p.SkuID,p.Sku, p.StockQty, p.ReorderLevel,p.last_order_date, gi.DeliveryDate as delDate, p.CategoryId as cId, pc.CategoryName as Category, p.liveStockQty as liveStock
      from products p
      left join _gi_delivery_date gi on
      p.Sku = gi.Sku
      left join product_categories pc on
      p.CategoryId = pc.CategoryId
      where p.LiveStockQty < ReorderLevel
            and
          gi.DeliveryDate > p.last_order_date 
          and
          p.Discontinued = 0
          and p.CategoryId not in (0, 29,31,9,41,53)
          and p.LowStock = 0
        
    group by SkuID
      order by StockQty desc      
      ');
   $stmt->execute();
   if($stmt->rowCount()>0)
   {
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
}

  #update the Sku on Demand

public function updateAllSku(){
      $pdo = Database::DB();
      $stmt = $pdo->prepare('call StockUpdateCurrent()');
      $stmt->execute();     
    
    }

   public function updateSku($SkuID, $Sku){
$pdo = Database::DB();
 $stmt=$pdo->prepare('DROP TABLE IF EXISTS `:Sku`');
 $stmt->bindValue(':Sku', $Sku);
 $stmt->execute();
  
  # create temp table
  $stmt = $pdo->prepare('CREATE TABLE `:Sku` (
    SkuID INT UNSIGNED,
    TotalReceived INT NOT NULL DEFAULT 0,
    TotalDelivered INT NOT NULL DEFAULT 0,
    TotalDeliveredSku INT NOT NULL DEFAULT 0,
    TotalAdjusted INT NOT NULL DEFAULT 0,
    StockQty MEDIUMINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`SkuID`)
  ) ENGINE=InnoDB');
  $stmt->bindValue(':Sku', $Sku);
  $stmt->execute();

    $stmt = $pdo->prepare('INSERT INTO `:Sku` (SkuID)
  values(:SkuID)    
      ');
    $stmt->bindValue(':Sku', $Sku);
    $stmt->bindValue(':SkuID', $SkuID);
     $stmt->execute();

    $stmt = $pdo->prepare('UPDATE `:Sku` su
    JOIN (
        select p.SkuID, p.StockQty as StockQty
        from products p
        where p.SkuID = :SkuID    
      )pud on pud.SkuID = su.SkuID
      SET su.StockQty = pud.StockQty') ;
    $stmt->bindValue(':SkuID', $SkuID);
    $stmt->bindValue(':Sku', $Sku);
     $stmt->execute();

      $stmt = $pdo->prepare('UPDATE `:Sku` su
  JOIN (
    SELECT
      p.SkuID,
      gi.TotalReceived as TotalReceived
    FROM goods_in gi
    JOIN products p ON p.Sku = gi.Sku   
    WHERE  gi.DeliveryDate > p.LastUpdated
    and gi.Sku = :Sku
  ) pgi ON pgi.SkuID = su.SkuID
  SET su.TotalReceived = pgi.TotalReceived');
   $stmt->bindValue('Sku', $Sku);
  $stmt->bindValue(':Sku', $Sku);
  $stmt->execute();

    # calc del ~1sec to run using only product alias table
 $stmt = $pdo->prepare('UPDATE `:Sku` su
  JOIN (
    SELECT
      p.SkuID,      
      coalesce(SUM(go.QtyDelivered),0) as QtyDelivered
    FROM products p
    left join alias a on p.SkuID=a.SkuID
    JOIN goods_out go 
    ON 
    a.Alias = go.sku or
    a.Alias = go.desc1sku       
     where  go.DispatchDate > p.LastUpdated and
     p.SkuID = :SkuID
  ) pgo ON pgo.SkuId = su.SkuId
  SET su.TotalDelivered = pgo.QtyDelivered');
 $stmt->bindValue(':Sku', $Sku);
 $stmt->bindValue(':SkuID', $SkuID);
 $stmt->execute();

  #calc delivered using only the products table. avoids possible duplicates when joing tables
  $stmt = $pdo->prepare('UPDATE `:Sku` su
  JOIN (
      SELECT
        p.SkuID,      
        coalesce(SUM(go.QtyDelivered),0) as QtyDelivered
    FROM products p
    
    JOIN goods_out go 
    ON p.Sku = go.sku or
    p.Sku = go.desc1sku 
            
  where   go.DispatchDate > p.LastUpdated  and p.SkuID = :SkuID
  ) pgo ON pgo.SkuId = su.SkuId
  SET su.TotalDeliveredSku = pgo.QtyDelivered');
     $stmt->bindValue(':Sku', $Sku);
  $stmt->bindValue(':SkuID', $SkuID);
  $stmt->execute();


  # calc allocation ~1sec to run
$stmt = $pdo->prepare('UPDATE `:Sku` su
JOIN (
SELECT
p.SkuID,
coalesce(sum(adj.AdjustIN),0) - coalesce(sum(adj.AdjustOut),0) as TotalAdjusted
FROM Adjustments adj
JOIN products p ON p.SkuId = adj.SkuID
where  adj.Date > p.LastUpdated and p.SkuID = :SkuID
) psat ON psat.SkuId = su.SkuID
SET su.TotalAdjusted = psat.TotalAdjusted');
 $stmt->bindValue(':Sku', $Sku);
$stmt->bindValue(':SkuID', $SkuID);
$stmt->execute();

  # calc stock qty
 $stmt=$pdo->prepare('UPDATE `:Sku`
  SET StockQty = TotalReceived - TotalDelivered - TotalDeliveredSku + TotalAdjusted+StockQty');
  $stmt->bindValue(':Sku', $Sku);
 $stmt->execute();

#update the products DB
 $stmt=$pdo->prepare('UPDATE products p
  JOIN `:Sku` t ON p.SkuId = t.SkuID
  SET p.StockQty = t.StockQty');
  $stmt->bindValue(':Sku', $Sku);
 $stmt->execute();

$stmt=$pdo->prepare('drop table `:Sku`');
$stmt->bindValue(':Sku', $Sku);
$stmt->execute();
}

#delete alias
  public function delAlias($AliasID){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('delete
      from alias
      where
      AliasID = :aliasID      
      ');
    $stmt->bindValue(':aliasID', $AliasID);
     $stmt->execute();
}
  #auto select product search
  public function getProduct($SkuID){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select *, P.SkuID
      from
    products p
  
      left JOIN locations l on
      p.SkuID = l.SkuID
      left join alias a on
      p.SkuID = a.SkuID
      left join product_categories pg on
      pg.CategoryId = p.CategoryId
      where
      p.SkuID = :stmt
      
      ');
    $stmt->bindValue(':stmt', $SkuID.'%');
     $stmt->execute();
   if($stmt->rowCount()>0)
   {
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
}
  #product search
  public function searchProduct($Sku){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select *,p.SkuID,group_concat(l.location) as location, group_concat(a.Alias) as Alias
      from
    products p
    left join alias a on
    p.SkuID = a.SkuID  
      left JOIN locations l on
      p.SkuID = l.SkuID
      where
      p.Sku like :stmt
      or
      a.Alias like :stmt 
      group by p.sku     
      ');
    $stmt->bindValue(':stmt', '%'.$Sku.'%');
     $stmt->execute();
   if($stmt->rowCount()==null){

   echo '';
    
  }
  else{
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
      
  }

  #get Product Locations
  public function getLocations($location){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('Select * 
      from
    locations l
    where Location like :stmt
    limit 5

      ');
     $stmt->bindValue(':stmt', $location.'%');
     $stmt->execute();
   if($stmt->rowCount()>0){
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  else{
   return 'No Data';
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
     public function updateSkuOrderDate($SkuID){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('update
     products 
      set last_order_date = now()
      where SkuID = :SkuID
      ');
   
    $stmt->bindValue(':SkuID', $SkuID);   
    $stmt->execute();
    }

  #edit product
  public function updateProduct($Sku, $Desc,$Qpu,$UnitPrice, $ReorderLevel,$Notes, $Discontinued, $CategoryId,$lowStock, $SkuID){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('update products
      set Sku = :sku, Description = :desc, QuantityPerUnit = :Qpu, UnitPrice = :UnitPrice, ReorderLevel = :ReorderLevel, Notes = :notes, Discontinued = :disc, CategoryId = :CategoryId, LowStock = :lowStock
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
    $stmt->bindValue(':lowStock',$lowStock);
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
      $stmt = $pdo->prepare('call StockUpdateCurrent()
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
     # $stmt = $pdo->prepare('call UpdateStock()
      #');
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

  public function addProduct($ProductName, $categoryId, $QuantityPerUnit,$CostPrice,$UnitPrice,$UnitsInStock,$Description,$ReorderLevel){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      products
      (Sku,categoryId,QuantityPerUnit,CostPrice,UnitPrice,StockQty,Description,ReorderLevel)
      values
      (?,?,?,?,?,?,?,?)
      ');
    $stmt->bindValue(1, $ProductName);
    $stmt->bindValue(2, $categoryId);
    $stmt->bindValue(3, $QuantityPerUnit);
    $stmt->bindValue(4, $CostPrice);
    $stmt->bindValue(5, $UnitPrice);
    $stmt->bindValue(6,$UnitsInStock);
    $stmt->bindValue(7, $Description);
    $stmt->bindValue(8, $ReorderLevel);
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
      product_categories
      order by CategoryName asc');
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
a.Alias = go.sku
or
a.Alias = go.desc1sku
or
p.sku=go.sku
or
p.sku = go.desc1sku
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
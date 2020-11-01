<?php
require_once('settings.php');

  class ncr{
  public function getReview($orderId){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('select nr.review, nr.reviewed_by, nr.date_reviewed
      from
      ncr_review nr
      left join
      ncr n on 
      nr.po = n.po
      where
      nr.po = :orderId
      group by nr.po');
    $stmt->bindValue(':orderId', $orderId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getInvestigation($orderId){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('select nr.investigation, nr.initials, nr.date_closed
      from
      ncr_review nr
      left join
      ncr n on 
      nr.po = n.po
      where
      nr.po = :orderId
      group by nr.po');
    $stmt->bindValue(':orderId', $orderId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function closeNcr($name, $newDate, $po){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('update 
      ncr
      set 
      closed_by = :name, date_closed =:newDate, status = :status
      where
      po = :po');
    $stmt->bindValue(':po', $po);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':newDate', $newDate);
    $stmt->bindValue(':status', 'CLOSED');
    $stmt->execute();
  }

   public function closeInvestigation($po,$text, $newDate){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('insert into 
      ncr_review
      (po, investigation, date_closed)
      values
      (?,?,?)
      ');
    $stmt->bindValue(1, $po);
    $stmt->bindValue(2, $text);
    $stmt->bindValue(3, $newDate);
    $stmt->execute();

   }
  

  public function review($text, $newDate,$po){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('update 
      ncr_review
      set
      review = :text, date_reviewed =:newDate
      where
      po = :po');
    $stmt->bindValue(':text', $text);
    $stmt->bindValue(':newDate', $newDate);
    $stmt->bindValue(':po', $po);
    $stmt->execute();
  }

  public function getCustomerNcr($orderId){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('select *
      from
      ncr
      where
      po = :orderId');
    $stmt->bindValue(':orderId', $orderId);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getNcrs($status){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('select
      po, date_opened, date_closed
      from
      ncr
       where 
    status = :status     
      group by po
      ');
    $stmt->bindValue(':status', $status);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function ncrDescription($reason, $description,$newDate,$correction,$initials,$id){
    try{
    $pdo = Database::DB();
    $stmt = $pdo->prepare('update 
      ncr
      set problem =?, p_desc = ?, date_opened = ?, correction =?, raised_by = ?, status = "OPEN" 
      where
      id = ?');
    $stmt->bindValue(1,$reason);
    $stmt->bindValue(2,$description);
    $stmt->bindValue(3,$newDate);
    $stmt->bindValue(4, $correction);
     $stmt->bindValue(5, $initials);
    $stmt->bindValue(6, $id);
    $stmt->execute();
    }    
    catch (PDOException $e)
    {
      die("1062 Duplicate Entry");
    }
        echo $id;
  }

  public function deleteNcr($id){
    $pdo = Database::DB();
    $stmt=$pdo->prepare('delete
      from
      ncr
      where
      id = :id');
    $stmt->bindValue(':id',$id);
    $stmt->execute();
  }

  public function openNcr($po,$sku,$desc1,$qty,$id, $customerName){
    $pdo = Database::DB();
    $stmt=$pdo->prepare('insert into
      ncr
      (po,sku,desc1,qty,id,customer_name)
      values 
      (?,?,?,?,?,?)
      ');
    $stmt->bindValue(1, $po);
    $stmt->bindValue(2, $sku);
    $stmt->bindValue(3, $desc1);
    $stmt->bindValue(4, $qty);
    $stmt->bindValue(5, $id);
    $stmt->bindValue(6, $customerName);
    $stmt->execute();
  }

  public function searchOrder($order){
    $pdo = Database::DB();
    $stmt = $pdo->prepare('select *
      from goods_out
      where
      OrderID = :order');
    $stmt->bindValue(':order', $order);
    $stmt->execute();
    return$stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  }
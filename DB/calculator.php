<?php
require_once('settings.php');

class calculator{
   public function searchTools($ref){
  $pdo = Database::DB();
    $stmt = $pdo->prepare('select *
      from
      _tooling
      where tool_Ref like :stmt
      or tool_alias like :stmt');
   
    $stmt->bindValue(':stmt', '%'.$ref.'%');   
    $stmt->execute();
    if($stmt->rowCount()>0)
   {
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
    }

    public function getToolViaUrl($toolID){
      $pdo = Database::DB();
      $stmt = $pdo->prepare('select *
        from _tooling
        where
        id = :toolId;
        ');
      $stmt->bindValue('toolId', $toolID);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSheetboard(){
      $pdo = Database::DB();
      $stmt = $pdo->prepare('select *
        from sheetboard
        ');
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  }


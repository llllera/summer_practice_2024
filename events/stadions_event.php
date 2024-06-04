<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../data.php');
    if (isset($_POST['change'] )) {
        $id = $_POST['id'];
    try {
        $stmt = $db->prepare("SELECT name FROM stadions where id = ?");
        $stmt->execute([$id]);
        $name = $sth->fetch();
        $stmt = $db->prepare("UPDATE performances SET place = :place where place = :id");
        $stmt -> execute(['place'=>$_POST['name'],'id' => $name]);
        $stmt = $db->prepare("UPDATE stadions SET name = :name where id = :id");
        $stmt -> execute(['name'=>$_POST['name'],'id' => $id]);
        }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
}
    else if (isset($_POST['delete'] )) {
        try {
            $id = $_POST['id'];
            $stmt = $db->prepare("SELECT name FROM stadions where id = ?");
            $stmt->execute([$id]);
            $name = $sth->fetch();
            $stmt = $db->prepare("SELECT id FROM performances where place = ?");
            $stmt->execute([$name]);
            $row = $stmt->fetchAll();
            for($i = 0; $i < count($row); $i++){
                $stmt = $db->prepare("DELETE FROM performances_member where id_performances = ?");
                $stmt->execute([$row[$i]]);
              };
            $stmt = $db->prepare("DELETE FROM stadions where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("DELETE FROM performances where place = ?");
            $stmt->execute([$name]);
            
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }

       
    }
    
    header('Location: ../index.php');
}
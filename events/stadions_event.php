<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../data.php');
    if (isset($_POST['change'] )) {
        $id = $_POST['id'];
    try {
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
            $stmt = $db->prepare("DELETE FROM stadions where id = ?");
            $stmt->execute([$id]);
            
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }

       
    }
    
    header('Location: ../index.php');
}
<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('../data.php');
    if (isset($_POST['change'] )) {
        session_start();
        $_SESSION['id'] = $_POST['id'];
        header('Location: form_sport_event.php');
    }
    else if (isset($_POST['delete'] )) {
        try {
            $id = $_POST['id'];
            $stmt = $db->prepare("DELETE FROM sportsmen where id = ?");
            $stmt->execute([$id]);
            $stmt = $db->prepare("SELECT id_performance FROM performances_members where id_member = ?");
            $stmt->execute([$id]);
            $row = $stmt->fetchAll();
            for($i = 0; $i < count($row); $i++){
                $stmt = $db->prepare("DELETE FROM performances where id = ?");
                $stmt->execute([$row[$i]]);
              };
            $stmt = $db->prepare("DELETE FROM performances_members where id_member = ?");
            $stmt->execute([$id]);
            
        }
        catch(PDOException $e){
            print('Error : ' . $e->getMessage());
            exit();
        }

        header('Location: ../index.php');
    }
    
    
}
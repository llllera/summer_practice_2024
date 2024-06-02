<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Спортсмен</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f2f2f2;
      
    }
    .container {
      width: 500px;
      margin: auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .form-group {
      margin: 20px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input[type="text"],
    .form-group input[type="tel"], 
    select {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .form-group input[type="submit"] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: none;
      background-color: #4CAF50;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }
  </style>
</head>
<body>
<div class="container">
        <div class="block">
            <form action="form_sport_event.php" method="POST">
            <?php
                if (!empty($messages)) {
                print('<div class="form-group" >');
                // Выводим все сообщения.
                foreach ($messages as $message) {
                    print($message);
                }
                print('</div>');
                }
                ?>
                <div class="form-group">
                    <label for="client_name">ФИО:</label>
                    <input type="text" id="client_name" name="name" value="<?php print $values['name']; ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="client_phone">Телефон:</label>
                    <input type="tel" id="client_phone" name="phone" value="<?php print $values['phone']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="client_email">Вид спорта:</label>
                    
                    <select name="sport[]">
                    <?php
                    $types=selectAll('types_of_sports');
                    foreach($types as $t){
                        if($t['name']==$values['sport']){
                            echo '<option value="'.$t['name'].'" selected>' . $t['name'] . '</option>';
                        }
                       else { echo '<option value="'.$t['name'].'" >' . $t['name'] . '</option>';}
                    }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="добавить" >
                </div>
                
                <div class="form-group">
                    <a href = "">Вернуться</a>
                </div>
            </form>
        </div>
    </div>
    <?php
function selectAll($tables){
  include('data.php');
  $sth = $db->prepare("SELECT * FROM $tables");
    $sth->execute();
    return $users = $sth->fetchAll();
}
?>
</body>
</html>
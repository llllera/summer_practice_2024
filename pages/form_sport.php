<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style_form.css">
    <title>Спортсмен</title>
</head>
<body>
<div class="container">
        <div class="block">
            <form action="./events/form_sport_event.php" method="POST">
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
                    <a href = "./index.php">Вернуться</a>
                </div>
            </form>
        </div>
    </div>
    <?php
function selectAll($tables){
  include('./data.php');
  $sth = $db->prepare("SELECT * FROM $tables");
    $sth->execute();
    return $users = $sth->fetchAll();
}
?>
</body>
</html>
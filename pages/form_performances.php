<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style_form.css">
    <title>Мероприятие</title>
</head>
<body>
<div class="container">
        <div class="block">
            <form action="form_perfomances_event.php" method="POST">
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
                    <label for="client_name">ФИО участника(ов):</label>
                    <select name="name[]" multiple="multiple">
                    <?php
                    $types=selectAll('sportsmen');
                    foreach($types as $t){
                        if(strpos($values['name'],$t['id'] )!== false){                                    ///скорее всего не будет работать
                            echo '<option value="'.$t['id'].'" selected>' . $t['name'] . '</option>';
                        }
                       else { echo '<option value="'.$t['id'].'" >' . $t['name'] . '</option>';}
                    }
                    ?>
                    </select>
                </div>
                

                <div class="form-group">
                    <label for="client_date">Дата:</label>
                    <select class="information" name="year" <?php if ($errors['year']) {print 'class="error"';} ?>>
                        <?php
                            for ($i = 2024; $i <= 2050; $i++) {
                                printf('<option %s value="%d">%d год</option>', $values['year'] == $i ? "selected" : '', $i, $i);
                            }
                        ?>
                    </select><br>
                  
                    <select class="information" name="month" <?php if ($errors['month']) {print 'class="error"';} ?>>
                        <?php
                            for ($i = 1; $i <= 12; $i++) {
                                printf('<option %s value="%d">%d месяц</option>', $values['month'] == $i ? "selected" : '', $i, $i);
                            }
                        ?>
                    </select><br>
                
                    <select class="information" name="day" <?php if ($errors['day']) {print 'class="error"';} ?>>
                        <?php
                            for ($i = 1; $i <= 31; $i++) {
                                printf('<option %s value="%d">%d день</option>', $values['day'] == $i ? "selected" : '', $i, $i);
                            }
                        ?>
                    </select><br>

                            </div>


                <div class="form-group">
                    <label for="client_email">Стадион:</label>
                    
                    <select name="stad[]">
                    <?php
                    $types=selectAll('stadions');
                    foreach($types as $t){
                        if($t['name']==$values['stad']){
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
  include('data.php');
  $sth = $db->prepare("SELECT * FROM $tables");
    $sth->execute();
    return $users = $sth->fetchAll();
}
?>
</body>
</html>
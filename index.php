<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style_index.css">
    <title>Спортивные заведения</title>
</head>
<body>
    <?php 
    if(session_start()){
        session_destroy();}
    ?>
    <div class="container">
        <div class = "content">
            <button onclick="showBlock(1)">Список спортменов</button>

            <table  id="block1" class="table">
                <thead>
                    <tr>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Вид спорта</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $people=selectAll('sportsmen');
                    foreach ($people as $pp) : ?>
                    <tr class="item_row">
                        <td><?php echo $pp['name']; ?></td>
                        <td><?php echo $pp['phone']; ?></td>
                        <td><?php echo $pp['sport']; ?></td>
                        <form action="sport_event.php" method="post">
                            <td class="edit">
                                <button class="but" type="submit" name="change">Редактировать</button>
                            </td>
                            <td class="edit">
                                <button class="but" name="delete" type="submit">Удалить</button>
                                <input name="id" value="<?php echo $pp['id']; ?>" type="hidden" />
                            </td>
                        </form> 
                    </tr>
                    <?php endforeach; ?>
                    <tr class="add">
                        <td colspan="5"><button class="but" name="change" id="add" type="submit">Добавить</button></td>
                    </tr>
                </tbody>
       
            </table>
        </div>
        <div class = "content">
            <button onclick="showBlock(2)">Виды спорта</button>
            <table  id="block2" class ="table">
                <tbody>
                <?php $people=selectAll('types_of_sports');
                foreach ($people as $pp) : ?>
                <tr class="item_row">
                    <td><?php echo $pp['name']; ?></td>
                        <form action="" method="post">
                            <td class="edit">
                                <button  class="but" name="change" type="submit">Редактировать</button>
                            </td>
                            <td class="edit">
                                <button class="but" name="delete" type="submit">Удалить</button>
                                <input name="id" value="<?php echo $pp['id']; ?>" type="hidden" />
                            </td>
                        </form>
                    
                </tr>
                <?php endforeach; ?>
                </tbody>
                
                
            </table>
        </div>
        <div class = "content">
            <button onclick="showBlock(3)">Список стадионов</button>

            <table  id="block3" class ="table">
                <tbody>
                <?php $people=selectAll('stadions');
                foreach ($people as $pp) : ?>
                <tr class="item_row">
                    <td><?php echo $pp['name']; ?></td>
                        <form action="" method="post">
                        <td class="edit"><button class="but" name="change" type="submit">Редактировать</button></td>
                        <td class="edit"><button class="but" name="delete" type="submit">Удалить</button>
                            <input name="id" value="<?php echo $pp['id']; ?>" type="hidden" /></td>
                        </form>
                    
                </tr>
                <?php endforeach; ?>
                </tbody>
            
            </table>
        </div>
        <div class = "content">
        <button onclick="showBlock(4)">Журнал учета выступлений</button>

        <table  id="block4" class ="table">
        <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Дата</th>
                    <th>Стадион</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                include('data.php');
                $sth = $db->prepare("SELECT performances.id, performances.date, performances.place, GROUP_CONCAT(sportsmen.name SEPARATOR ', ') AS names
                                    FROM performances
                                    JOIN performances_members ON performances.id = performances_members.id_performance join sportsmen on performances_members.id_member = sportsmen.id
                                    GROUP BY performances.id;");
                $sth->execute();
                $people = $sth->fetchAll();
            foreach ($people as $pp) : ?>
            <tr class="item_row">
                <td><?php echo $pp['names']; ?></td>
                <td><?php echo $pp['date']; ?></td>
                <td><?php echo $pp['place']; ?></td>
               
                    <form action="" method="post">
                    <td class="edit"><button class="but" name="change" type="submit">Редактировать</button></td>
                    <td class="edit"><button class="but" name="delete" type="submit">Удалить</button>
                        <input name="id" value="<?php echo $pp['id']; ?>" type="hidden" /></td>
                    </form>
                
            </tr>
            <?php endforeach; ?>
            <tr class="add">
                            <td colspan="5"><button class="but" name="change" id="add" type="submit">Редактировать</button></td>
                        </tr>
        </tbody>
            
        </table>
        </div>

        </div>

<script>
        function showBlock(blockNumber) {
      var block = document.getElementById("block" + blockNumber);
      if (block.style.display === "none") {
        block.style.display = "inline-table";
      } else {
        block.style.display = "none";
      }
    }
</script>
<?php
function selectAll($tables){
  include('data.php');
  $sth = $db->prepare("SELECT * FROM $tables");
    $sth->execute();
    return $users = $sth->fetchAll();
}

?>
</body>
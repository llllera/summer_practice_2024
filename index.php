<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Спортивные заведения</title>
    <style>
        table{
            display: none;
        }
        </style>
</head>
<body>
    <button onclick="showBlock(1)">Список спортменов</button>

    <table  id="block1" class="content" id="films">
   
        <thead>
            <tr>
                <th>ФИО</th>
                <th>Телефон</th>
                <th>Вид спорта</th>
                <th class="nullCell"></th>
                <th class="nullCell"></th>
            </tr>
        </thead>
        <tbody>
        <?php $people=selectAll('sportsmen');
        foreach ($people as $pp) : ?>
        <tr class="item_row">
            <td><?php echo $pp['name']; ?></td>
            <td><?php echo $pp['phone']; ?></td>
            <td>
                <form action="" method="post">
                    <button class="btn edit-btn" name="change" type="submit">Редактировать</button>
                    <button class="btn delete-btn" name="delete" type="submit">Удалить</button>
                    <input name="id" value="<?php echo $pp['id']; ?>" type="hidden" />
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
       
    </table>
    <button onclick="showBlock(2)">Список спортменов</button>

    <table  id="block2" class="content" id="films">
        <thead>
            <tr>
                <th>Название</th>
                <th>Ингредиенты</th>
                <th>Действия</th>
            </tr>
        </thead>
        
    </table>
    <button onclick="showBlock(3)">Список спортменов</button>

    <table  id="block3" class="content" id="films">
        <thead>
            <tr>
                <th>Название</th>
                <th>Ингредиенты</th>
                <th>Действия</th>
            </tr>
        </thead>
        
    </table>
    <button onclick="showBlock(4)">Список спортменов</button>

    <table  id="block4" class="content" id="films">
        <thead>
            <tr>
                <th>Название</th>
                <th>Ингредиенты</th>
                <th>Действия</th>
            </tr>
        </thead>
        
    </table>



<script>
        /**let coll = document.getElemByClassName('collapsible');
        for(let i=0; i < coll.lenght; i++){
            coll[i].addEventListener('click', function(){
                this.classList.toggle('active');
                let content = this.nextElementSibling;
                if(content.style.maxHeight){
                    content.style.maxHeight = null;
                }else{
                    content.style.maxHeight= content.scrollHeight + 'px'
                }
            })
        }
        **/
        function showBlock(blockNumber) {
      var block = document.getElementById("block" + blockNumber);
      if (block.style.display === "none") {
        block.style.display = "block";
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
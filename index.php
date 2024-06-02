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
</body>
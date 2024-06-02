<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Спортивные заведения</title>
    <style>
        .content{
            max-height:0;
        }
        </style>
</head>
<body>
<button class="collapsible">Список спортменов</button>
<div class="content">
    <table class="film-table" id="films">
        <thead>
            <tr>
                <th>Название</th>
                <th>Ингредиенты</th>
                <th>Действия</th>
            </tr>
        </thead>
        
    </table>
</div>


<script>
        let coll = document.getElemByClassName('collapsible');
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
</script>
</body>
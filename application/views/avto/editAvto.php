<div class="grid">
    <div class="gridItemBig">
        <div class="centerForm">
            <h1 class="zagH1">Редактировать авто</h1>
            <form action="/profile/myavto/edit" method="post">
                <input class="input1" type="hidden" name="id" value="<?php echo $avto['id'];?>">
                <p class="label">Бренд:</p>
                <input class="input1" type="text" name="brand" value="<?php echo $avto['brand'];?>">
                <p class="label">Модель:</p>
                <input class="input1" type="text" name="model" value="<?php echo $avto['model'];?>">
                <p class="label">Тип:</p>
                <input class="input1" type="text" name="type" value="<?php echo $avto['type'];?>">
                <p class="label">Описание:</p>
                <textarea class="input1" name="opis" cols="30" rows="10"><?php echo $avto['opis'];?></textarea>
                <input class="input1" type="submit" value="Отправить" name="sub">
            </form>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <a href="/profile/myavto/delete/<?php echo $avto['id'];?>"><div class="actBut">Удалить авто</div></a>
        </div>
    </div>
</div>

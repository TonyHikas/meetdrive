<div class="grid">
    <div class="gridItemBig">
        <div class="centerForm">
            <h1 class="zagH1">Редактировать мероприятие</h1>
                <form action="/profile/myevent/edit" method="post">
                    <input class="input1" type="hidden" name="id" value="<?php echo $event['id'];?>">
                    <p class="label">Название:</p>
                    <input class="input1" type="text" name="nazv" value="<?php echo $event['nazv'];?>">
                    <p class="label">Дата старта:</p>
                    <input class="input1" type="text" name="start_date" value="<?php echo $event['start_date'];?>">
                    <p class="label">Категория:</p>
                    <input class="input1" type="text" name="category" value="<?php echo $event['category'];?>">
                    <p class="label">Тип транспорта:</p>
                    <input class="input1" type="text" name="transport_type" value="<?php echo $event['transport_type'];?>">
                    <p class="label">Город:</p>
                    <input class="input1" type="text" name="city" value="<?php echo $event['city'];?>">
                    <p class="label">Адрес:</p>
                    <input class="input1" type="text" name="adress" value="<?php echo $event['adress'];?>">
                    <p class="label">Тип мероприятия:</p>
                    <input class="input1" type="text" name="event_type" value="<?php echo $event['event_type'];?>">
                    <p class="label">Цена:</p>
                    <input class="input1" type="text" name="price" value="<?php echo $event['price'];?>">

                    <p class="label">Описание:</p>
                    <textarea class="input1" name="opis" cols="30" rows="10"><?php echo $event['opis'];?></textarea>
                    <input class="input1" type="submit" value="Отправить" name="sub">
                </form>
                <br>
                <br>
                <br>
                <a href="/profile/myevent/delete/<?php echo $event['id'];?>"><div class="actBut">Удалить мероприятие</div></a>
        </div>
    </div>
</div>
<?php
echo '<p>Название: <h1>'.$event['nazv'].' - '.$event['company'].'</h1></p>';
echo '<p>Описание: '.$event['opis'].'</p>';
echo '<p>Дата начала: '.$event['start_date'].'</p>';
echo '<p>Время начала: '.$event['start_time'].'</p>';
echo '<p>Категория: '.$event['category'].'</p>';
echo '<p>Тип транспорта: '.$event['transport_type'].'</p>';
echo '<p>Город: '.$event['city'].'</p>';
echo '<p>Адрес: '.$event['adress'].'</p>';
echo '<p>Тип мероприятия: '.$event['event_type'].'</p>';
echo '<p>Цена: '.$event['price'].'</p>';


?>
    <hr>
<?php if ($ispodt and !$is_creator): ?>
    <?php if ($isUch==false): ?>
        <h3>Учавствовать</h3>
        <form action="/event/<?php echo $alias;?>/enter" method="post">
            <select name="avto_id">
                <?php foreach ($avtos as $avto): ?>
                <option value="<?php echo $avto['id'];?>"><?php echo $avto['brand']." ".$avto['model'];?></option>
                <?php endforeach; ?>
            </select>
            <?php if ($event['type']==3): ?>
                <input type="text" name="code" placeholder="Пригласительный код">
            <?php endif; ?>
            <input type="submit" value="Отправить" name="sub">
        </form>
    <?php endif; ?>
    <?php if ($isUch!=false): ?>
    <?php if ($isUch['podt']==1){echo 'Участие подтверждено';}else{echo 'Участие ожидает подтверждения организатора';} ?>
        <h3>Поменять вато</h3>
        <?php if ($event['type']==1): ?>
            Внимание! При смене авто подтверждение на ваше участие пропадёт и будет отпавленна новая заявка на подтверждение
        <?php endif; ?>
        <form action="/event/<?php echo $alias;?>/edit" method="post">
            <select name="avto_id">
                <?php foreach ($avtos as $avto): ?>
                    <option <?php if ($avto['id']==$isUch['avto_id']){echo 'selected';} ?> value="<?php echo $avto['id'];?>"><?php echo $avto['brand']." ".$avto['model'];?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Поменять вато" name="sub">
        </form>
        <h3>Отменить участие</h3>
        <form action="/event/<?php echo $alias;?>/exit" method="post">
            <input type="hidden" value="123" name="123">
            <input type="submit" value="Отменить" name="sub">
        </form>
    <?php endif; ?>
<?php endif; ?>
<?php if($is_creator): ?>
Я создатель <br>
Подтверждённые <br>
<?php foreach ($uchastniki_podt as $uch_podt){
    echo $uch_podt['user_id'].'<br>';
    } ?>
    Не подтверждённые
    <?php foreach ($uchastniki_nepodt as $uch_nepodt){
        echo $uch_nepodt['user_id'].'<br>';
    } ?>
<?php endif; ?>
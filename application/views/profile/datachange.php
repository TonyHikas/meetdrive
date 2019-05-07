<div class="grid">
    <div class="gridItemBig">
        <div class="centerForm">
            <h1 class="zagH1">Смена пароля</h1>
            <form action="/profile/datachange" method="post">
                <p class="label">Имя</p>
                <input class="input1" type="text" name="name" value="<?=$name; ?>">
                <p class="label">Город</p>
                <input class="input1" type="text" name="city" value="<?=$city; ?>">
                <p class="label">Телефон</p>
                <input class="input1" type="text" name="tel" value="<?=$tel; ?>">
                <input class="input1" type="submit" value="Сменить" name="sub">
            </form>
        </div>
    </div>
</div>
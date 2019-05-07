<div class="grid">
    <div class="gridItemBig">
        <div class="centerForm">
            <h1 class="zagH1">Создать организацию</h1>
                <p style="text-align: center;">У одного аккаунта может быть только одна организация</p>
                <form action="/profile/myevent/create" method="post">
                    <p class="label">Название:</p>
                    <input class="input1" type="text" name="company" value="">
                    <p class="label">Ссылка на оффициальную страницу организации(соц. сети/сайт)(не обязательно):</p>
                    <input class="input1" type="text" name="link" value="">
                    <p class="label">Описание:</p>
                    <textarea class="input1" name="opis" cols="30" rows="10"></textarea>
                    <input class="input1" type="submit" value="Отправить" name="sub">
                </form>
        </div>
    </div>
</div>
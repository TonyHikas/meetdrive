<div class="grid">
    <div class="gridItemBig">
        <div class="centerForm">
            <h1 class="zagH1">Добавить мероприятие</h1>
                <form action="/profile/myevent/add" method="post">
                    <p class="label">Название:</p>
                    <input class="input1" type="text" name="nazv" value="">
                    <p class="label">Дата старта:</p>
                    <input class="input1" type="text" name="start_date" value="">
                    <p class="label">Категория:</p>
                    <input class="input1" type="text" name="category" value="">
                    <p class="label">Тип транспорта:</p>
                    <input class="input1" type="text" name="transport_type" value="">
                    <p class="label">Город:</p>
                    <input class="input1" type="text" name="city" value="">
                    <p class="label">Адрес:</p>
                    <input class="input1" type="text" name="adress" value="">
                    <p class="label">Тип мероприятия:</p>
                    <input class="input1" type="text" name="event_type" value="">
                    <p class="label">Цена:</p>
                    <input class="input1" type="text" name="price" value="">

                    <p class="label">Описание:</p>
                    <textarea class="input1" name="opis" cols="30" rows="10"></textarea>
                    <input class="input1" type="submit" value="Отправить" name="sub">
                </form>
        </div>
    </div>
</div>
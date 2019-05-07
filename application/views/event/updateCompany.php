<div class="grid">
    <div class="gridItemBig">
        <div class="centerForm">
            <h1 class="zagH1">Редактировать организацию</h1>
                <form action="/profile/myevent/update" method="post">
                    <p class="label">Название:</p>
                    <input class="input1" type="text" name="company" value="<?php echo $user['company'];?>">
                    <p class="label">Ссылка на оффициальную страницу организации(соц. сети/сайт)(не обязательно):</p>
                    <input class="input1" type="text" name="link" value="<?php echo $user['company_link'];?>">
                    <p class="label">Описание:</p>
                    <textarea class="input1" name="opis" cols="30" rows="10"><?php echo $user['company_opis'];?></textarea>

                    <input class="input1" type="submit" value="Отправить" name="sub">
                </form>
        </div>
    </div>
</div>
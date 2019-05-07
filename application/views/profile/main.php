<div class="grid">
    <div class="gridItem">
        <h1 class="zagH1"><?= $user['name']; ?></h1>
        <p><b>Email:</b><br><?= $user['email'] ?></p>
        <?php
        if ($user['pod_email']!=1){
            echo '<a href="/profile/podt"><h3>Подтвердите свой аккаунт</h3></a>';
        }
        ?>
        <p><b>Телефон:</b><br><?= $user['tel'] ?></p>
        <p><b>Город:</b><br><?= $user['city'] ?></p>
    </div>
    <div class="gridItem">
        <h2 class="zagH2">Редактировать аккаунт</h2>
        <a href="/profile/emailchange"><div class="actBut">Поменять email</div></a>
        <a href="/profile/passchange"><div class="actBut">Поменять пароль</div></a>
        <a href="/profile/datachange"><div class="actBut">Редактировать данные</div></a>
        <a href="/profile/logout"><div class="actBut">Выйти</div></a>
    </div>
    <div class="gridItem">
        <h2 class="zagH2">Мой транспорт</h2>
        <a href="/profile/myavto"><div class="actBut">Мои авто</div></a>
    </div>
    <div class="gridItem">
        <h2 class="zagH2">Мои участия</h2>
        <a href="/profile/active"><div class="actBut">Активные</div></a>
        <a href="/profile/archive"><div class="actBut">Архив</div></a>
    </div>
    <div class="gridItem">
        <h2 class="zagH2">Моя компания</h2>
        <?php if ($user['company']!=''){ ?>
            <a href="/profile/myevent/update"><div class="actBut">Редактировать организацию</div></a>
            <p><b>Название:</b><br><?=$user['company'] ?></p>
            <p><b>Ссылка:</b><br><?=$user['company_link'] ?></p>
            <p><b>Описание:</b><br><?=$user['company_opis'] ?></p>
        <?php }else echo '<a href="/profile/myevent/create"><div class="actBut">Создать</div></a>'; ?>
    </div>
    <?php if ($user['company']!=''): ?>
        <div class="gridItem">
            <h2 class="zagH2">Мои мероприятия</h2>
            <a href="/profile/myevent"><div class="actBut">Мои мероприятия</div></a>
            <a href="/profile/archivemyevent"><div class="actBut">Мои прошлые мероприятия</div></a>
        </div>
    <?php endif; ?>


</div>

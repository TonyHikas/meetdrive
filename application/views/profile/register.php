<div class="grid">
    <div class="gridItemBig">
        <div class="centerForm">
            <h1 class="zagH1">Регистрация</h1>
                <form action="/profile/register" method="post">
                    <p class="label">Имя:</p>
                    <input class="input1" type="text" name="name">
                    <p class="label">Email:</p>
                    <input class="input1" type="text" name="login">
                    <p class="label">Телефон(не обязательно):</p>
                    <input class="input1" type="text" name="tel">
                    <p class="label">Пароль:</p>
                    <input class="input1" type="password" name="password">
                    <p class="label">Повторите пароль:</p>
                    <input class="input1" type="password" name="password2">
                    <input class="input1" type="submit" value="Зарегистироваться" name="sub">
                </form>
            <br>
            <a href="/profile/login"><div class="actBut">Или войти</div></a>
        </div>
    </div>
</div>
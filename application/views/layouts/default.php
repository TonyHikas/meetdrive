<!DOCTYPE html>
<html lang="ru">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/styles/style.css">
    <script src="/public/scripts/jquery.js"></script>
    <link rel="stylesheet" href="/public/styles/jQuery.Brazzers-Carousel.min.css">
    <script src="/public/scripts/form.js"></script>
    <title><?php echo $title; ?> - meetDrive.ru</title>
</head>
<body>
<!-- Адаптивное меню -->
<nav class="clearfix">
    <div id="header">
        <a href="/"><div id="logoText">meetDrive.ru</div></a><!-- Логотип в полноценной версии -->
    </div>
    <ul class="clearfix">
        <li><a href="/">ГЛАВНАЯ</a></li>
        <li><a href="/all">СХОДКИ</a></li>
        <li><a href="#">НОВОСТИ</a></li>
        <li><a href="#">О НАС</a></li>
        <li><a href="#">ПОМОЩЬ</a></li>
        <li><a href="/profile">ПРОФИЛЬ</a></li>
    </ul>
    <a href="#" id="pull"><div id="mobLogo">meetDrive.ru</div><!-- Логотип в мобильной версии --><div id="mobMenuTitle">Меню</div></a>
</nav>
<!-- Скрипт для разворачивания меню -->
<script>
    $(function() {
        var pull 		= $('#pull');
        menu 		= $('nav ul');
        menuHeight	= menu.height();

        $(pull).on('click', function(e) {
            e.preventDefault();
            menu.slideToggle();
        });
        $(mobLogo).on('click', function(e) {
            window.open("/");
        });
    });
    $(window).resize(function(){
        var w = $(window).width();
        if(w > 320 && menu.is(':hidden')) {
            menu.removeAttr('style');
        }
    });

</script>
<div class="center mainblock">
    <div class="content">
<?php echo $content; ?>
    </div>
<div class="widget">

</div>
</div>

<footer>
    meetDrive.ru 2019г. - Все права защищены
</footer>
</body>
</html>
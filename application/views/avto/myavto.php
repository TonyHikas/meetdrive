<p>Мои авто!</p>

<a href="/profile/myavto/add">Добавить авто</a>
<hr>


<?php echo 'Текущая: '.$page.' Максимальная: '.$max_page.' Всего: '.$count;?>
<?php if ($count==0){echo 'Не найдены записи'; $avtos = [];} ?>
<?php  foreach ($avtos as $avto): ?>
    <a href="/profile/myavto/edit/<?php echo $avto['id'];?>">
        <div class="shodItem">
            <div class="shodImg braz">
                <img class="shodGalImg" src="/public/users_img/car.jpg" alt="">
                <img class="shodGalImg" src="/public/users_img/car2.jpg" alt="">
                <img class="shodGalImg" src="/public/users_img/car.jpg" alt=""><!-- Если нет картинки то ничего не вставлять(только главную) -->
                <img class="shodGalImg" src="/public/users_img/car2.jpg" alt="">
                <img class="shodGalImg" src="/public/users_img/car.jpg" alt="">
                <img class="shodGalImg" src="/public/users_img/car2.jpg" alt="">
            </div>
            <div class="mobShadImgs">
                <div class="mobShadOneImg" style="background-image: url('/public/users_img/car.jpg');"></div>
                <div class="mobShadOneImg" style="background-image: url('/public/users_img/car2.jpg');"></div>
                <div class="mobShadOneImg" style="background-image: url('/public/users_img/car.jpg');"></div>
                <div class="mobShadOneImg" style="background-image: url('/public/users_img/car2.jpg');"></div>
                <div class="mobShadOneImg" style="background-image: url('/public/users_img/car.jpg');"></div>
                <div class="mobShadOneImg" style="background-image: url('/public/users_img/car2.jpg');"></div><!-- Если нет картинки то  вставлять дубликаты первой -->
            </div>
            <div class="shodData">
                <div class="shodTitle"><div class="menuItemShod"><?php echo $avto['brand'].' - '.$avto['model'];?></div></div>
                <div class="shodFFF">
                    <div class="shodPrams">
                        <div class="shodOneParam"><?php echo $avto['type'];?></div>
                        <div class="shodOneParam"><?php echo $avto['opis'];?></div>

                    </div>
                </div>
            </div>
        </div>
    </a>
<?php endforeach; ?>
<!-- Конеу Вывод блоков со сходками -->
<div class="pagin">
    <div class="pagnum">
        <?php $adrr = '/profile/archive/'; if ($max_page ==0){$max_page=1;}?>
        <?php if (($page!=1)): ?>
            <a href="<?=$adrr;?>1"><div class="pagitem">1</div></a>
        <?php endif; ?>

        <?php if (($page-4)>1): ?>
            <a><div class="pagitem">...</div></a>
        <?php endif; ?>

        <?php if (($page-3)>1): ?>
            <a href="<?php echo $adrr.($page-3);?>"><div class="pagitem"><?=($page-3) ?></div></a>
        <?php endif; ?>

        <?php if (($page-2)>1): ?>
            <a href="<?php echo $adrr.($page-2);?>"><div class="pagitem"><?=($page-2) ?></div></a>
        <?php endif; ?>

        <?php if (($page-1)>1): ?>
            <a href="<?php echo $adrr.($page-1);?>"><div class="pagitem"><?=($page-1) ?></div></a>
        <?php endif; ?>

        <a><div class="pagitem"><?=($page) ?></div></a><!-- Текущая -->


        <?php if (($page+1)<$max_page): ?>
            <a href="<?php echo $adrr.($page+1);?>"><div class="pagitem"><?=($page+1) ?></div></a>
        <?php endif; ?>

        <?php if (($page+2)<$max_page): ?>
            <a href="<?php echo $adrr.($page+2);?>"><div class="pagitem"><?=($page+2) ?></div></a>
        <?php endif; ?>

        <?php if (($page+3)<$max_page): ?>
            <a href="<?php echo $adrr.($page+3);?>"><div class="pagitem"><?=($page+3) ?></div></a>
        <?php endif; ?>
        <?php if (($page+4)<$max_page): ?>
            <a><div class="pagitem">...</div></a>
        <?php endif; ?>
        <?php if (($max_page!=$page)): ?>
            <a href="<?php echo $adrr.($max_page);?>"><div class="pagitem"><?=$max_page; ?></div></a>
        <?php endif; ?>

    </div>
    <div class="pagstrel">
        <?php if ($page!=1): ?>
            <a href="<?php echo $adrr.($page-1);?>"><div class="pagstr">&#8592; Предыдущая</div></a>
        <?php endif; ?>
        <?php if ($page != $max_page): ?>
            <a href="<?php echo $adrr.($page+1);?>"><div class="pagstr">Следующая &#8594;</div></a>
        <?php endif; ?>
    </div>
</div>

<script src="/public/scripts/jQuery.Brazzers-Carousel.min.js"></script>


<script>

    $(document).ready(function() {
        $(".shodImg").brazzersCarousel();
    });


</script>




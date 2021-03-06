
<!-- <div class="sort">
    <form action="" class="sortSel">
        <select class="select selSort" >
            <option value="">Сортировать по</option>
            <option value="">1</option>
            <option value="">2</option>
            <option value="">3</option>
            <option value="">4</option>
        </select>
        <select class="select selSort" >
            <option value="">Параметры выдачи</option>
            <option value="">1</option>
            <option value="">2</option>
            <option value="">3</option>
            <option value="">4</option>
        </select>
    </form>
</div> -->
<!-- Вывод блоков со сходками -->
<?php echo 'Текущая: '.$page.' Максимальная: '.$max_page.' Всего: '.$count;?>
<?php if ($count==0){echo 'Не найдены записи'; $events = [];} ?>
<?php  foreach ($events as $event): ?>
    <a href="/event/<?php echo $event['alias'];?>">
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
                <div class="shodTitle"><div class="menuItemShod"><span class="shodBegLine"><?php echo $event['nazv'].' - '.$event['company'];?></span></div></div>
                <div class="shodFFF">
                    <div class="shodPrams">
                        <div class="shodOneParam"><?php echo $event['category'];?></div>
                        <div class="shodOneParam"><?php echo $event['transport_type'];?></div>
                        <div class="shodOneParam"><?php echo $event['city'];?></div>
                    </div>
                    <div class="shodPrams">
                        <div class="shodOneParam"><?php echo $event['event_type'];?></div>
                        <div class="shodOneParam"><?php echo $event['start_time'];?></div>
                        <div class="shodOneParam"><?php echo $event['start_date'];?></div>
                    </div>
                </div>
            </div>
            <div class="shodPriceAndPodt">
                <div class="shodPodt"> <?php if ($event['company_confirm']==1){echo '<img class="podtImg" src="/public/images/checkbox.png"alt="">';} ?> </div>
                <div class="shodPrice"><?php if ($event['price']==0){echo 'Бесплатно';}else{echo $event['price'].' Р.';} ?></div>
            </div>
        </div>
    </a>
<?php endforeach; ?>
<!-- Конеу Вывод блоков со сходками -->
<div class="pagin">
    <div class="pagnum">
        <?php $adrr = '/profile/active/'; if ($max_page ==0){$max_page=1;} ?>
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



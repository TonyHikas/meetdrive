<header>
    <div style="margin-right: auto;"><a href="/admin/params">Назад</a></div>
</header>
<div class="contentAdm">
    <div class="lItem">
        <h3>Редактировать параметр</h3>
    </div>
    <p>id:<?php echo ' '.$oneParam[0]['id'];?></p>
    <p>name:<?php echo ' '.$oneParam[0]['name'];?></p>
    <p>comment:<?php echo ' '.$oneParam[0]['comment'];?></p>
    <form action="/admin/editParams" method="post">
        <input type="hidden" name="id" value="<?php echo $oneParam[0]['id'];?>">
        <textarea name="value" cols="30" rows="10"><?php echo $oneParam[0]['value'];?></textarea>

        <input type="submit" name="sub">
    </form>


</div>
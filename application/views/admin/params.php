<header>
    <div style="margin-right: auto;"><a href="/admin">На главную</a></div>
</header>
<div class="contentAdm">
    <div class="lItem">
        <h3>Редактирование параметров</h3>
    </div>
    <table class="paramTable">
        <tr>
            <td>id</td>
            <td>name</td>
            <td>value</td>
            <td>comment</td>
            <td>Редактировать</td>
        </tr>
        <?php foreach ($params as $param): ?>
            <tr>
                <td><?= $param['id'] ?></td>
                <td><?= $param['name'] ?></td>
                <td><?= htmlspecialchars($param['value'],ENT_QUOTES); ?></td>
                <td><?= $param['comment'] ?></td>
                <td><a href="editParams/<?= $param['id'] ?>">Редактировать</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>
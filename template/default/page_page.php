<td class="content">
    <? if($page) :?>
        <h1>
            <?=$page['title']?>
        </h1>

        <p><?=$page['text']?></p>
    <? else: ?>
        <p>Данных с такими параметрами не существует</p>
    <? endif; ?>

</td>
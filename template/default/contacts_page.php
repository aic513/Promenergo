<td class="content">
    <? if($contacts) :?>
        <h1>
            <?=$contacts['title']?>
        </h1>

        <p><?=$contacts['text']?></p>
    <? else: ?>
        <p>Данных с такими параметрами не существует</p>
    <? endif; ?>

</td>
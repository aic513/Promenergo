<td class="content">
    <? if ($text) : ?>
        <h1>
            <?= $text['title']; ?>
        </h1>
        <?= $text['text']; ?>
    <? else : ?>
        <p>Данных с такими параметрами нет</p>
    <? endif; ?>

</td>
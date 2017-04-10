<td class="news">
    <h1>
        Новости
    </h1>
    <? if ($news): ?>
        <? foreach ($news as $item): ?>
            <div>
                <span>
                    <?= date("d.m.Y", $item['date']); ?>
                </span>
                <h2>
                    <a href="<?= SITE_URL; ?>news/id/<?= $item['news_id'] ?>"><strong><?= $item['title']; ?></strong></a>
                </h2>
                <p>
                    <?= $item['anons']; ?>
                </p>
            </div>
        <? endforeach; ?>
    <? else: ?>
        <p>Новостей нет</p>
    <? endif; ?>
    <a class="arhiv-news" href="<?= SITE_URL; ?>archive">Архив новостей</a>
</td>
<td class="content">
    <? if ($news_text) : ?>
        <h1>
            <?= $news_text['title']; ?>
        </h1>
        <span class="news-date">
			<?= date("d.m.Y", $news_text['date']); ?>
		</span>
        <p><?= $news_text['text']; ?></p>
    <? else : ?>
        <p>Новостей с такими параметрами нет</p>
    <? endif; ?>
    <p><a href="<?= SITE_URL; ?>archive">Перейти к списку новостей</a></p>
</td>
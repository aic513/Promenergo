<div class="footer-main">
    <div class="footer">
        <div class="ftrMenu">
            <div class="phone">
                +375 (17) <span>220-73-64</span><br/>
                +375 (17) <span>328-15-01</span>
            </div>
            <p><a href="<?= SITE_URL; ?>">Главная</a> |
                <? if ($pages) : ?>
                    <? foreach ($pages as $page) : ?>
                        <a href="<?= SITE_URL; ?>page/id/<?= $page['page_id'] ?>"><?= $page['title'] ?></a> |
                    <? endforeach; ?>
                <? endif; ?>
                <a href="<?= SITE_URL; ?>archive">Новости</a> | <a href="<?= SITE_URL; ?>catalog">Каталог товаров</a>
        </div>
        <div class="copy">
            © 2008-2009. ООО “ПромСтройЭнерго”<br/>
            Все права защищены.<br/>
            E-mail:<a href="mailto: info@pse.by">info@pse.by</a>
        </div>
    </div>
</div>
</div>
</div>
</div>
</body>
</html>
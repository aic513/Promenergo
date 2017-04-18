<td class="nav">
	<div class="links">
		<a href="<?=SITE_URL?>"><img src="<?=VIEW?>images/home.gif" alt="главная" title="на главную"/></a>
		<a href="<?=SITE_URL?>contacts/"><img src="<?=VIEW?>images/kontakts.gif" alt="контакты"
		                                      title="перейти к контактам"/></a>
		<a href="<?=SITE_URL?>map"><img src="<?=VIEW?>images/amp.gif" alt="карта сайта" title="к карте сайта"/></a>
	</div>
	<ul class="navigation">
		<li>&mdash;&nbsp; <a href="<?=SITE_URL;?>archive">Новости</a></li>
		<? if ($pages) : ?>
			<? foreach ($pages as $item) : ?>
				<li>&mdash;&nbsp; <a href="<?=SITE_URL;?>page/id/<?=$item['page_id']?>"><?=$item['title']?></a></li>
			<? endforeach; ?>
		<? endif; ?>
		<li>&mdash;&nbsp; <a href="<?=SITE_URL;?>catalog">Каталог товаров</a></li>
	</ul>
	</ul>
	<div id="katalog">
		<div id="select">
			<a id="header_catalog_type" href="#" class="selec_activ"> по назначению </a>&nbsp;&nbsp; |&nbsp;&nbsp;
			<a id="header_catalog_brand" href="#" class="selec"> по брендам </a>
		</div>
		
		<? if ($types) : ?>
			<div id="list_type">
				<? foreach ($types as $item_t) : ?>
					<a href="<?=SITE_URL;?>catalog/type/<?=$item_t['type_id']?>"><?=$item_t['type_name']?></a><br/>
				<? endforeach; ?>
			</div>
		<? endif; ?>

		<? if ($brands) : ?>
			<div id="list_brands">
				<? foreach ($brands as $key => $item_b) : ?>
					<? if ($item_b['next_lvl']) : ?>
						<p><a href="#"><?=$item_b[0];?></a></p>
						<div>
							<a href="<?=SITE_URL;?>catalog/parent/<?=$key;?>">Все типы</a><br/>
							<? foreach ($item_b['next_lvl'] as $k => $v) : ?>
								<a href="<?=SITE_URL;?>catalog/brand/<?=$k?>"><?=$v;?></a><br/>
							<? endforeach; ?>

						</div>
					<? else : ?>
						<a href="<?=SITE_URL;?>catalog/brand/<?=$key;?>"><?=$item_b['0']?></a><br/>
					<? endif; ?>
				<? endforeach; ?>
			</div>
		<? endif; ?>

	</div>
	<div class="pricelist">
		<a href="<?=SITE_URL;?>pricelist"><strong>Скачать прайс-лист</strong></a><br/>
		(367 кб, MS Excel)
	</div>

</td>
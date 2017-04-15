<td class="content">
	
	<h1>
		Карта сайта
	</h1>
	
	<? if ($pages && $catalog) : ?>
		<ul>
			<li>
				<a href="<?=SITE_URL;?>">Главная</a>
			</li>
			<li>
				<a href="<?=SITE_URL;?>archive">Новости</a>
			</li>
			
			<? foreach ($pages as $item) : ?>
				<li>
					<a href="<?=SITE_URL;?>page/id/<?=$item['page_id']?>"><?=$item['title']?></a>
				</li>
			<? endforeach; ?>
			<li>
				<a href="<?=SITE_URL;?>catalog">Каталог товаров</a>
			</li>
			<ul>
				
				<? foreach ($catalog as $key => $val) : ?>
					<? if ($val['next_lvl']) : ?>
						<li>
							<a href="<?=SITE_URL;?>catalog/parent/<?=$key;?>"><?=$val[0]?></a>
							<ul>
								<? foreach ($val['next_lvl'] as $k => $v) : ?>
									<li>
										<a href="<?=SITE_URL;?>catalog/brand/<?=$k?>"><?=$v;?></a>
									</li>
								<? endforeach; ?>
							</ul>
						</li>
					<? else : ?>
						<li>
							<a href="<?=SITE_URL;?>catalog/brand/<?=$key?>"><?=$val[0];?></a>
						</li>
					<? endif; ?>
				<? endforeach; ?>
			</ul>
		
		</ul>
	
	
	<? else : ?>
		<p>Данных по карте сайта нет</p>
	<? endif; ?>

</td>
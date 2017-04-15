<td class="content">

	<h1>
		Результаты поиска
	</h1>
	<div class="kat_map">
		<a href="<?=SITE_URL;?>">Главная</a> / <span>Результаты поиска </span>
	</div>
	<? if ($search) : ?>
	<?
	$i = 1;  //счетчик итераций цикла foreach
	?>
	<? foreach ($search as $key => $item) : ?>
	<div class="product-cat-main">
		<? if ($i == 3) : ?>   <?//если вывели третий товар - меняем ему класс?>
		<div class="product-cat-third">
			<? $i = 0; ?>
			<? else : ?>
			<div class="product-cat">
				<? endif; ?>

				<a href="<?=SITE_URL?>tovar/id/<?=$item['tovar_id'];?>">
					<img src="<?=SITE_URL.UPLOAD_DIR.$item['img'];?>" alt="<?=$item['title']?>"/>
				</a>
				<a href="<?=SITE_URL?>tovar/id/<?=$item['tovar_id'];?>">
					<?=$item['title']?>
				</a>
			</div>
			<div class="bord-bot"></div>
		</div>
		<? $i++; ?>
		<? endforeach; ?>
		<div class="clr"></div>
		<? if ($navigation) : ?>
			<br/>
			<ul class="pager">
				<? if ($navigation['first']) : ?>
					<li class="first">
						<a href="<?=SITE_URL;?>search/page/1/str/<?=$str;?>">Первая</a>
					</li>
				<? endif; ?>

				<? if ($navigation['last_page']) : ?>
					<li>
						<a href="<?=SITE_URL;?>search/page/<?=$navigation['last_page']?>/str/<?=$str?>">&lt;</a>
					</li>
				<? endif; ?>

				<? if ($navigation['previous']) : ?>
					<? foreach ($navigation['previous'] as $val) : ?>
						<li>
							<a href="<?=SITE_URL;?>search/page/<?=$val;?>/str/<?=$str?>"><?=$val;?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>

				<? if ($navigation['current']) : ?>
					<li>
						<span><?=$navigation['current'];?></span>
					</li>
				<? endif; ?>

				<? if ($navigation['next']) : ?>
					<? foreach ($navigation['next'] as $v) : ?>
						<li>
							<a href="<?=SITE_URL;?>search/page/<?=$v;?>/str/<?=$str?>"><?=$v;?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>
				<? if ($navigation['next_pages']) : ?>
					<li>
						<a href="<?=SITE_URL;?>search/page/<?=$navigation['next_pages']?>/str/<?=$str?>">
							&gt;</a>
					</li>
				<? endif; ?>

				<? if ($navigation['end']) : ?>
					<li class="last">
						<a href="<?=SITE_URL;?>search/page/<?=$navigation['end']?>/str/<?=$str?>">Последняя</a>
					</li>
				<? endif; ?>

			</ul>
		<? endif; ?>

		<? else : ?>
			<p>Данных для вывода нет</p>
		<? endif; ?>
</td>
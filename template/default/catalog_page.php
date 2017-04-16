<td class="content">

	<h1>
		Каталог продукции
	</h1>

	<? if ($krohi) : ?>
		<div class="kat_map">
			<? if (count($krohi) > 1) : ?>
				<a href="<?=SITE_URL?>">Главная</a> /
				<a href="<?=SITE_URL?>catalog/parent/<?=$krohi[0]['brand_id'];?>"><?=$krohi[0]['brand_name'];?></a> /
				<span><?=$krohi[1]['brand_name'];?></span>

			<? elseif (count($krohi) == 1 && array_key_exists('type_name', $krohi[0])) : ?>
				<a href="<?=SITE_URL?>">Главная</a> /
				<span><?=$krohi[0]['type_name'];?></span>

			<? elseif (count($krohi) == 1 && array_key_exists('brand_name', $krohi[0])) : ?>
				<a href="<?=SITE_URL?>">Главная</a> /
				<span><?=$krohi[0]['brand_name'];?></span>
			<? endif; ?>
		</div>
	<? endif; ?>

	<? if ($catalog) : ?>
	<?
	$i = 1;
	?>
	<? foreach ($catalog as $key => $item) : ?>
	<div class="product-cat-main">
		<? if ($i == 3) : ?>
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
						<a href="<?=SITE_URL;?>catalog/page/1<?=$previous?>">Первая</a>
					</li>
				<? endif; ?>

				<? if ($navigation['last_page']) : ?>
					<li>
						<a href="<?=SITE_URL;?>catalog/page/<?=$navigation['last_page']?><?=$previous?>">&lt;</a>
					</li>
				<? endif; ?>

				<? if ($navigation['previous']) : ?>
					<? foreach ($navigation['previous'] as $val) : ?>
						<li>
							<a href="<?=SITE_URL;?>catalog/page/<?=$val;?><?=$previous?>"><?=$val;?></a>
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
							<a href="<?=SITE_URL;?>catalog/page/<?=$v;?><?=$previous?>"><?=$v;?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>
				<? if ($navigation['next_pages']) : ?>
					<li>
						<a href="<?=SITE_URL;?>catalog/page/<?=$navigation['next_pages']?><?=$previous?>">&gt;</a>
					</li>
				<? endif; ?>

				<? if ($navigation['end']) : ?>
					<li class="last">
						<a href="<?=SITE_URL;?>catalog/page/<?=$navigation['end']?><?=$previous?>">Последняя</a>
					</li>
				<? endif; ?>

			</ul>
		<? endif; ?>

		<? else : ?>
			<p>Данных для вывода нет</p>
		<? endif; ?>

</td>
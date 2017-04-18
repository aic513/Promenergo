<td class="content">
	<? if ($tovar) : ?>
		<h1>
			<?=$tovar['title']?>
		</h1>

		<div class="kat_map">

			<? if (count($krohi) == 1) : ?>
				<a href="<?=SITE_URL?>">Главная</a> /
				<span><?=$krohi[0]['tovar_name'];?></span>

			<? endif; ?>
		</div>

		<p>
			<img src="<?=SITE_URL.UPLOAD_DIR.$tovar['img'];?>"/>
		</p>
		<p><?=$tovar['text']?></p>
	<? else: ?>
		<p>Данных с такими параметрами не существует</p>
	<? endif; ?>

</td>
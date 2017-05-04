<td class="content">

	<? if ($option == 'view') : ?>
		<h1>
			Редактирование типов товаров
		</h1>
		<p><?=$mes;?></p>
		<? if ($data_type) : ?>
			<table class="edit_types" cellspacing="4px" border="1px" width="100%">
				<tbody>
				<? foreach ($data_type as $item) : ?>
					<tr>
						<td>
							<?=$item['type_name'];?>
						</td>
						<td>
							<a href="<?=SITE_URL;?>edittypes/option/edit/id/<?=$item['type_id']?>">
								Изменить
							</a>
						</td>
						<td>
							<a href="<?=SITE_URL;?>edittypes/option/delete/id/<?=$item['type_id']?>">
								Удалить
							</a>
						</td>
					</tr>
				<? endforeach; ?>
				</tbody>
			</table>
		<? else : ?>
			<p>Типов товаров нет</p>
		<? endif; ?>

	<? elseif ($option == 'edit' && $type) : ?>
		<h1>
			Редактирование типа товара - <?=$type['type_name'];?>
		</h1>
		<p><?=$mes;?></p>
		<form action="<?=SITE_URL;?>edittypes/option/edit" method="POST">
			<input type="hidden" name="id" value="<?=$type['type_id']?>">
			<p><span>Название типа товара: &nbsp;</span>
				<input class="txt-zag" type="text" name="type_name" value="<?=$type['type_name'];?>"></p>

			<? for ($i = 0; $i < 5; $i++) : ?>
				<? if ($i == 0) : ?>
					<input <? if ($type['in_header'] == $i) echo "checked"; ?> type="radio" value="<?=$i;?>"
					                                                           name="in_header">Тип товара не отображается в шапке сайта
					<br/>
				<? else : ?>
					<input <? if ($type['in_header'] == $i) echo "checked"; ?> type="radio" value="<?=$i;?>"
					                                                           name="in_header">Ячейка №<?=$i?><br/>
				<? endif; ?>

			<? endfor; ?>
			<br/>
			<input type="image" src="<?=VIEW;?>admin/images/update_btn.jpg" name="submit_edit_types">
		</form>

	<? endif; ?>

</td>

<td class="rightbar-adm">
	<h1>
		Категории
	</h1>
	<? if ($brands) : ?>
		<ul>
			<? foreach ($brands as $key => $item) : ?>
				<? if ($item['next_lvl']) : ?>
					<li>
						<a href="<?=SITE_URL;?>editcatalog/parent/<?=$key;?>">
							<?=$item[0];?>
						</a>
						<ul>
							<? foreach ($item['next_lvl'] as $k => $val) : ?>
								<li>
									<a href="<?=SITE_URL;?>editcatalog/brand/<?=$k?>">
										<?=$val;?>
									</a>
								</li>
							<? endforeach; ?>
						</ul>
					</li>
				<? else : ?>
					<li>
						<a href="<?=SITE_URL;?>editcatalog/brand/<?=$key;?>">
							<?=$item[0];?>
						</a>
					</li>
				<? endif; ?>
			<? endforeach; ?>
			<li><a href="<?=SITE_URL;?>editcatalog/brand/0">Без категории</a></li>
		</ul>
	<? else : ?>
		<p>Категорий нет</p>
	<? endif; ?>
	<br/>
	<p><a href="<?=SITE_URL;?>editcategory"><strong>Новая категория</strong></a></p>
	<p><a href="<?=SITE_URL;?>edittypes"><strong>Редактирование типов</strong></a></p>
</td>
<td class="content">

	<? if ($option == 'add') : ?>
		<h1>
			Добавление категории
		</h1>
		<p><?=$mes;?></p>
		<form action="<?=SITE_URL;?>editcategory/option/add" method="POST">
			<p><span>Название категории:</span>
				<input class="txt_zag" type="text" name="title">
			</p>

			<p><span>Родительская категория:</span>
				<select name="parent">
					<option value="0">Родительская</option>
					<? if ($parents_cat) : ?>
						<? foreach ($parents_cat as $item) : ?>
							<option value="<?=$item['brand_id']?>"><?=$item['brand_name']?></option>
						<? endforeach; ?>
					<? endif; ?>
				</select>
			</p>
			<input type="image" src="<?=VIEW;?>admin/images/save_btn.jpg" name="submit_add_cat">
		</form>

	<? elseif ($option == 'edit' && $category) : ?>
		<h1>
			Редактирование категории - <?=$category['brand_name']?>
		</h1>
		<p><?=$mes;?></p>
		<form action="<?=SITE_URL;?>editcategory/option/edit" method="POST">
			<p><span>Название категории:</span>
				<input class="txt_zag" type="text" name="title" value="<?=$category['brand_name'];?>">
			</p>
			<input type="hidden" name="id" value="<?=$category['brand_id']?>">

			<p><span>Родительская категория:</span>
				<select name="parent">
					<option value="0">Родительская</option>
					<? if ($parents_cat) : ?>
						<? foreach ($parents_cat as $item) : ?>
							<? if ($item['brand_id'] == $category['parent_id']): ?>
								<option selected value="<?=$item['brand_id']?>"><?=$item['brand_name']?></option>
							<? else : ?>
								<option value="<?=$item['brand_id']?>"><?=$item['brand_name']?></option>
							<? endif; ?>

						<? endforeach; ?>
					<? endif; ?>
				</select>
			</p>
			<input type="image" src="<?=VIEW;?>admin/images/update_btn.jpg" name="submit_edit_cat">
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
	<p><a href=""><strong>Редактирование типов</strong></a></p>
</td>
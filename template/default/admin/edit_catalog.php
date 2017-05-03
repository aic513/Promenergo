<td class="content">
	<? if ($option == 'view') : ?>
		<h1>
			Редактирование каталога
		</h1>
		<p><?=$mes;?></p>
		<? if ($category) : ?>
			<div class="button-catalog-adm">
				<a href="<?=SITE_URL;?>editcatalog/option/add/id/<?=$category;?>"><img
							src="<?=VIEW;?>admin/images/add_produkt.jpg"
							alt="Добавить продукт в категорию"/></a>
				<a href="<?=SITE_URL;?>editcategory/option/edit/id/<?=$category;?>"><img
							src="<?=VIEW;?>admin/images/change_cat.jpg" alt="Изменить категорию"/></a>
				<a href="<?=SITE_URL;?>editcategory/option/delete/id/<?=$category;?>"><img
							src="<?=VIEW;?>admin/images/del_cat.jpg" alt="Удалить категорию"/></a>
			</div>
		<? endif; ?>
		<? if ($goods) : ?>
			<? foreach ($goods as $item) : ?>
				<div class="adm-product-cat-main">
					<div class="adm-product-cat">
						<p><?=$item['title']?></p>
						<img src="<?=SITE_URL.UPLOAD_DIR.$item['img'];?>" alt="<?=$item['title']?>"/>
						<p>
							<a href="<?=SITE_URL;?>editcatalog/option/edit/tovar/<?=$item['tovar_id']?>">
								Изменить
							</a> |
							<a href="<?=SITE_URL;?>editcatalog/option/delete/tovar/<?=$item['tovar_id']?><?=$previous;?>">
								Удалить
							</a>
						</p>
					</div>
					<div class="adm-bord-bot"></div>
				</div>
			<? endforeach; ?>
			<div style="clear:both"></div>

			<? if ($navigation) : ?>
				<ul class="pager">
					<? if ($navigation['first']) : ?>
						<li class="first">
							<a href="<?=SITE_URL;?>editcatalog/page/1<?=$previous;?>">Первая</a>
						</li>
					<? endif; ?>

					<? if ($navigation['last_page']) : ?>
						<li>
							<a href="<?=SITE_URL;?>editcatalog/page/<?=$navigation['last_page']?><?=$previous;?>">
								&lt;</a>
						</li>
					<? endif; ?>

					<? if ($navigation['previous']) : ?>
						<? foreach ($navigation['previous'] as $val) : ?>
							<li>
								<a href="<?=SITE_URL;?>editcatalog/page/<?=$val;?><?=$previous;?>"><?=$val;?></a>
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
								<a href="<?=SITE_URL;?>editcatalog/page/<?=$v;?><?=$previous;?>"><?=$v;?></a>
							</li>
						<? endforeach; ?>
					<? endif; ?>
					<? if ($navigation['next_pages']) : ?>
						<li>
							<a href="<?=SITE_URL;?>editcatalog/page/<?=$navigation['next_pages']?><?=$previous;?>">
								&gt;</a>
						</li>
					<? endif; ?>

					<? if ($navigation['end']) : ?>
						<li class="last">
							<a href="<?=SITE_URL;?>editcatalog/page/<?=$navigation['end']?><?=$previous;?>">Последняя</a>
						</li>
					<? endif; ?>
				</ul>
			<? endif; ?>


		<? elseif ($category && !$goods) : ?>
			<p>Товаров нет</p>
		<? else : ?>
			<p>Выберите категорию товара</p>
		<? endif; ?>

	<? elseif ($option == 'add') : ?>
		<h1>
			Добавление нового товара
		</h1>
		<p><?=$mes;?></p>

		<!--FORM ADD-->
		<form enctype="multipart/form-data" action="<?=SITE_URL;?>editcatalog/option/add/id/<?=$category?>"
		      method="POST">
			<p><span>Название: &nbsp;
			</span><input class="txt-zag" type="text" name="title"></p>
			<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
			<p><span>картинка анонса:
			</span><input class="txt-zag" type="file" value="" name="img">
			<p><span>Краткое описание:</span></p>
			<textarea name="anons" cols="60" rows="15"></textarea><br/><br/>

			<p><span>Полное описание:</span></p>
			<textarea name="text" cols="60" rows="15"></textarea><br/><br/>

			<p><span>Ключевые слова: &nbsp;
						</span><input class="txt-zag" type="text" name="keywords"></p>
			<p><span>Описание: &nbsp;
						</span><input class="txt-zag" type="text" name="discription"></p>
			<p><span>Выберите тип товара:</span></p>
			<select name="type">
				<? if ($type_cat) : ?>
				<? foreach ($type_cat as $item) : ?>
					<option value="<?=$item['type_id']?>"><?=$item['type_name']?></option>
				<? endforeach; ?>
			</select>
			<? else : ?>
				<p>типов пока нет</p>
			<? endif; ?>

			<p><span>Или создайте новый: &nbsp;</span>
				<input class="txt-zag" type="text" name="new_type"></p>
			<p>Публиковать товар:<br/>
				<input type="radio" name="publish" value="1" checked>Да
				<input type="radio" name="publish" value="0">Нет</p>

			<p><span>Цена: &nbsp;
			</span><input class="txt-zag" type="text" name="price"></p>

			<input type="image" src="<?=VIEW;?>admin/images/save_btn.jpg" name="submit_add_cat">

		</form>
		<!--FORM EDIT-->
	<? elseif ($option == 'edit') : ?>
		<h1>
			Изменение товара - <?=$tovar['title'];?>
		</h1>
		<p><?=$mes;?></p>

		<!--FORM ADD-->
		<form enctype="multipart/form-data" action="<?=SITE_URL;?>editcatalog/option/edit" method="POST">
			<p><span>Название: &nbsp;
			</span><input class="txt-zag" type="text" name="title" value="<?=$tovar['title'];?>"></p>
			<input type="hidden" name="id" value="<?=$tovar['tovar_id']?>">
			<input type="hidden" name="MAX_FILE_SIZE" value="2097152">
			<p><span>картинка анонса:
			</span><input class="txt-zag" type="file" value="" name="img">
			<p><span>Краткое описание:</span></p>
			<textarea name="anons" cols="60" rows="15"><?=$tovar['anons']?></textarea><br/><br/>

			<p><span>Полное описание:</span></p>
			<textarea name="text" cols="60" rows="15"><?=$tovar['text']?></textarea><br/><br/>

			<p><span>Ключевые слова: &nbsp;
						</span><input class="txt-zag" type="text" name="keywords" value="<?=$tovar['keywords']?>"></p>
			<p><span>Описание: &nbsp;
						</span><input class="txt-zag" type="text" value="<?=$tovar['discription']?>" name="discription">
			</p>
			<p><span>Выберите тип товара:</span></p>
			<select name="type">
				<? if ($type_cat) : ?>
				<? foreach ($type_cat as $item) : ?>
					<? if ($item['type_id'] == $tovar['type_id']) : ?>
						<option selected value="<?=$item['type_id']?>"><?=$item['type_name']?></option>
					<? else : ?>
						<option value="<?=$item['type_id']?>"><?=$item['type_name']?></option>
					<? endif; ?>

				<? endforeach; ?>
			</select>
			<? else : ?>
				<p>типов пока нет</p>
			<? endif; ?>

			<p><span>Или создайте новый: &nbsp;</span>
				<input class="txt-zag" type="text" name="new_type"></p>

			<p><span>Выберите категорию:</span></p>
			<? if ($brands) : ?>
				<select name="category">
					<? if ($tovar['brand_id'] == 0) : ?>
						<option selected value="0">Без категории</option>
					<? endif; ?>

					<? foreach ($brands as $key => $item) : ?>
						<? if ($key == $tovar['brand_id']) : ?>
							<option selected value="<?=$key;?>"><?=$item[0];?></option>
						<? else : ?>
							<option value="<?=$key;?>"><?=$item[0];?></option>
						<? endif; ?>

						<? if ($item['next_lvl']) : ?>
							<? foreach ($item['next_lvl'] as $k => $val) : ?>
								<? if ($k == $tovar['brand_id']) : ?>
									<option selected value="<?=$k;?>">--<?=$val;?></option>
								<? else : ?>
									<option value="<?=$k;?>">--<?=$val;?></option>
								<? endif; ?>
							<? endforeach; ?>
						<? endif ?>

					<? endforeach; ?>
				</select>
			<? else : ?>
				<p>Категорий нет</p>
			<? endif; ?>
			<p>Публиковать товар:<br/>
				<? if ($tovar['publish'] === '1') : ?>
				<input type="radio" name="publish" value="1" checked>Да
				<input type="radio" name="publish" value="0">Нет</p>
		<? else : ?>
			<input type="radio" name="publish" value="1">Да
			<input type="radio" name="publish" value="0" checked>Нет</p>
		<? endif; ?>


			<p><span>Цена: &nbsp;
			</span><input class="txt-zag" type="text" value="<?=$tovar['price']?>" name="price"></p>

			<input type="image" src="<?=VIEW;?>admin/images/update_btn.jpg" name="submit_add_cat">

		</form>
		<!--FORM ADD-->
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
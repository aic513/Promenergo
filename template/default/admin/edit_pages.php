<td class="content">
	<? if ($option == 'add') : ?>
		<h1>
			Добавление страницы
		</h1>
		<? if ($mes) : ?>
			<p><?=$mes;?></p>
		<? endif; ?>
		<form method="POST" action="<?=SITE_URL;?>admin">
			<p><span>Заголовок страницы: &nbsp;
						</span><input class="txt-zag" type="text" name="title"></p>
			<p><span>Текст страницы:</span></p>
			<textarea rows="15" cols="60" name="text" id="text"></textarea>
			<br/><br/>
			<p><span>Ключевые слова: &nbsp;
						</span><input class="txt-zag" type="text" name="keywords" value=""></p>
			<p><span>Описание: &nbsp;
						</span><input class="txt-zag" type="text" name="discription" value=""></p>
			<p><span>Позиция страницы: &nbsp;
						</span><input class="txt-num" type="text" name="position"></p>
			<input type="image" src="<?=VIEW;?>admin/images/save_btn.jpg" name="add">

		</form>
	<? elseif ($option == 'edit') : ?>
		<? if ($page_text) : ?>
			<h1>
				Редактирование страницы - <?=$page_text['title']?>
			</h1>
			<? if ($mes) : ?>
				<p><?=$mes;?></p>
			<? endif; ?>
			<form method="POST" action="<?=SITE_URL;?>admin">
				<input type="hidden" name="id" value="<?=$page_text['page_id']?>">
				<p><span>Заголовок страницы: &nbsp;
						</span><input class="txt-zag" type="text" name="title" value="<?=$page_text['title'];?>"></p>
				<p><span>Текст страницы:</span></p>
						<textarea rows="15" cols="60" name="text" id="text">
							<?=$page_text['text'];?>
						</textarea>
				<br/><br/>
				<p><span>Ключевые слова: &nbsp;
						</span><input class="txt-zag" type="text" name="keywords" value="<?=$page_text['keywords'];?>">
				</p>
				<p><span>Описание: &nbsp;
						</span><input class="txt-zag" type="text" name="discription"
				                      value="<?=$page_text['discription'];?>"></p>
				<p><span>Позиция страницы: &nbsp;
						</span><input class="txt-num" type="text" name="position" value="<?=$page_text['position'];?>">
				</p>
				<input type="image" src="<?=VIEW;?>admin/images/update_btn.jpg" name="edit">

				<a href="<?=SITE_URL;?>admin/id/<?=$page_text['page_id'];?>/option/delete">
					<img src="<?=VIEW;?>admin/images/delete_btn.jpg" alt="Удалить страницу">
				</a>
			</form>
		<? else : ?>
			<p>Такой страницы нет</p>
		<? endif; ?>
	<? endif; ?>
</td>
<td class="rightbar-adm">
	<h1>
		Список страниц
	</h1>
	<div>
		<? if ($pages) : ?>
			<? foreach ($pages as $item) : ?>
				<p>
					<a href="<?=SITE_URL;?>admin/id/<?=$item['page_id'];?>"><?=$item['title']?></a>
				</p>
			<? endforeach; ?>
		<? else : ?>
			<p>Страниц нет</p>
		<? endif; ?>
		<br/>
		<p><a href="/visitka/admin"><img src="<?=VIEW;?>admin/images/add_btn.jpg" alt="добавить страницу"/></a>
		</p>

		<? if ($pages) : ?>
			<p>Главная страница:</p>
			<form method="POST" action="<?=SITE_URL;?>admin">
				<select name="home_page">
					<? foreach ($pages as $item) : ?>
						<? if ($item['page_id'] == $home) : ?>
							<option selected value="<?=$item['page_id'];?>">
								<?=$item['title']?>
							</option>
						<? else : ?>
							<option value="<?=$item['page_id'];?>">
								<?=$item['title']?>
							</option>
						<? endif; ?>
					<? endforeach; ?>
				</select>
				<br>
				<input type="image" src="<?=VIEW;?>admin/images/update_btn.jpg" name="home">
			</form>
		<? endif; ?>

		<br>
		<? if ($pages) : ?>
			<p>Страница контактов:</p>
			<form method="POST" action="<?=SITE_URL;?>admin">
				<select name="contacts">
					<? foreach ($pages as $item) : ?>
						<? if ($item['page_id'] == $contacts) : ?>
							<option selected value="<?=$item['page_id'];?>">
								<?=$item['title']?>
							</option>
						<? else : ?>
							<option value="<?=$item['page_id'];?>">
								<?=$item['title']?>
							</option>
						<? endif; ?>
					<? endforeach; ?>
				</select>
				<br>
				<input type="image" src="<?=VIEW;?>admin/images/update_btn.jpg" name="contacts_submit">
			</form>
		<? endif; ?>
	</div>
</td>
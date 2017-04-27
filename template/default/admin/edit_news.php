<td class="content">
	<? if ($option == 'add') : ?>
		<h1>
			Добавление новостей
		</h1>
		<? if ($mes) : ?>
			<p><?=$mes;?></p>
		<? endif; ?>
		<form method="POST" action="<?=SITE_URL;?>editnew">
			<p><span>Заголовок новости: &nbsp;
						</span><input class="txt-zag" type="text" name="title" value="<?=$data['title']?>"></p>
			<p><span>Текст новости:</span></p>
			<textarea rows="15" cols="60" name="text" id="text"><?=$data['text']?></textarea>
			<br/>Анонс новости:</span></p>
			<textarea rows="15" cols="60" name="anons" id="anons"><?=$data['anons']?></textarea>
			<br/><br/>
			<p><span>Ключевые слова: &nbsp;
						</span><input class="txt-zag" type="text" name="keywords" value="<?=$data['keywords']?>"></p>
			<p><span>Описание: &nbsp;
						</span><input class="txt-zag" type="text" name="discription" value="<?=$data['discription']?>">
			</p>
			<input type="image" src="<?=VIEW;?>admin/images/save_btn.jpg" name="add_news">

		</form>
	<? elseif ($option == 'edit') : ?>
		<? if ($news_text) : ?>
			<h1>
				Редактирование новости - <?=$news_text['title'];?>
			</h1>
			<? if ($mes) : ?>
				<p><?=$mes;?></p>
			<? endif; ?>
			<form method="POST" action="<?=SITE_URL;?>editnew">
				<input type="hidden" name="id" value="<?=$news_text['news_id'];?>">
				<p><span>Заголовок новости: &nbsp;
						</span><input value="<?=$news_text['title'];?>" class="txt-zag" type="text" name="title"></p>
				<p><span>Текст новости:</span></p>
				<textarea rows="15" cols="60" name="text" id="text"><?=$news_text['text'];?></textarea>
				<br/>Анонс новости:</span></p>
				<textarea rows="15" cols="60" name="anons" id="anons"><?=$news_text['anons'];?></textarea>
				<br/><br/>
				<p><span>Ключевые слова: &nbsp;
						</span><input class="txt-zag" type="text" name="keywords" value="<?=$news_text['keywords'];?>">
				</p>
				<p><span>Описание: &nbsp;
						</span><input class="txt-zag" type="text" name="discription"
				                      value="<?=$news_text['discription'];?>"></p>
				<input type="image" src="<?=VIEW;?>admin/images/update_btn.jpg" name="edit_news">

			</form>
			<br/>
			<a href="<?=SITE_URL;?>editnew/id/<?=$news_text['news_id'];?>/option/delete">
				<img src="<?=VIEW;?>admin/images/delete_btn.jpg" alt="Удалить страницу">
			</a>
		<? else : ?>
			<p>Такой новости нет</p>
		<? endif; ?>
	<? endif; ?>
</td>
<td class="rightbar-adm">
	<h1>
		Список новостей
	</h1>
	<div>
		<? if ($news) : ?>
			<? foreach ($news as $item) : ?>
				<p>
					<a href="<?=SITE_URL;?>editnew/id/<?=$item['news_id'];?>"><?=$item['title']?></a>
				</p>
			<? endforeach; ?>
		<? else : ?>
			<p>Страниц нет</p>
		<? endif; ?>
		<br/>

		<? if ($navigation) : ?>
			<ul class="pager" style="width:130px !important; margin-left: 5px !important">
				<? if ($navigation['last_page']) : ?>
					<li>
						<a href="<?=SITE_URL;?>editnew/page/<?=$navigation['last_page']?>">&lt;</a>
					</li>
				<? endif; ?>
				<? if ($navigation['current']) : ?>
					<li>
						<span><?=$navigation['current'];?></span>
					</li>
				<? endif; ?>

				<? if ($navigation['next_pages']) : ?>
					<li>
						<a href="<?=SITE_URL;?>editnew/page/<?=$navigation['next_pages']?>">&gt;</a>
					</li>
				<? endif; ?>
			</ul>
		<? endif; ?>
		<p><a href="<?=SITE_URL;?>editnew"><img src="<?=VIEW;?>admin/images/add_btn.jpg"
		                                         alt="добавить новость"/></a></p>

	</div>
</td>
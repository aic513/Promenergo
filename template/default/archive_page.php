<td class="content">

	<h1>
		Новости
	</h1>
	<? if ($archive) : ?>
		<? foreach ($archive as $item) : ?>
			<div class="news-cat">
								<span>
									<?= date("d.m.Y", $item[ 'date' ]); ?>
								</span>
				<h2>
					<a href="<?= SITE_URL; ?>news/id/<?= $item[ 'news_id' ]; ?>">
						<?= $item[ 'title' ]; ?>
					</a>
				</h2>

				<p>
					<?= $item[ 'anons' ]; ?>
				</p>
				<p class="more">
					<a href="<?= SITE_URL; ?>news/id/<?= $item[ 'news_id' ]; ?>">
						Читать подробнее
					</a>
				</p>
			</div>
		<? endforeach; ?>

		<? if ($navigation) : ?>
			<ul class="pager">
				<? if ($navigation[ 'first' ]) : ?>
					<li class="first">
						<a href="<?= SITE_URL; ?>archive/page/1">Первая</a>
					</li>
				<? endif; ?>

				<? if ($navigation[ 'last_page' ]) : ?>
					<li>
						<a href="<?= SITE_URL; ?>archive/page/<?= $navigation[ 'last_page' ] ?>">&lt;</a>
					</li>
				<? endif; ?>

				<? if ($navigation[ 'previous' ]) : ?>
					<? foreach ($navigation[ 'previous' ] as $val) : ?>
						<li>
							<a href="<?= SITE_URL; ?>archive/page/<?= $val; ?>"><?= $val; ?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>

				<? if ($navigation[ 'current' ]) : ?>
					<li>
						<span><?= $navigation[ 'current' ]; ?></span>
					</li>
				<? endif; ?>

				<? if ($navigation[ 'next' ]) : ?>
					<? foreach ($navigation[ 'next' ] as $v) : ?>
						<li>
							<a href="<?= SITE_URL; ?>archive/page/<?= $v; ?>"><?= $v; ?></a>
						</li>
					<? endforeach; ?>
				<? endif; ?>
				<? if ($navigation[ 'next_pages' ]) : ?>
					<li>
						<a href="<?= SITE_URL; ?>archive/page/<?= $navigation[ 'next_pages' ] ?>">&gt;</a>
					</li>
				<? endif; ?>

				<? if ($navigation[ 'end' ]) : ?>
					<li class="last">
						<a href="<?= SITE_URL; ?>archive/page/<?= $navigation[ 'end' ] ?>">Последняя</a>
					</li>
				<? endif; ?>

			</ul>
		<? endif; ?>
	<? else : ?>
		<p>Новостей нет</p>
	<? endif; ?>

</td>
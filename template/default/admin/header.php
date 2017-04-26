<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<? if ($styles) : ?>
		<? foreach ($styles as $style) : ?>
			<link rel="stylesheet" type="text/css" href="<?=$style;?>"/>
		<? endforeach; ?>
	<? endif; ?>

	<? if ($scripts) : ?>
		<? foreach ($scripts as $script) : ?>
			<script type="text/javascript" src="<?=$script?>"></script>
		<? endforeach; ?>
	<? endif; ?>

	<title><?=$title;?></title>
</head>

<body>
<div class="karkas-main">
	<div class="karkas">
		<div class="main">
			<div class="header">
				<a href="<?=SITE_URL;?>"><img src="<?=VIEW.'admin/';?>images/logo.png" class="logo"
				                              alt="Промстрой энерго"/></a>
			</div>
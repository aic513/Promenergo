<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="<?= $discription; ?>"/>
    <meta name="keywords" content="<?= $keywords; ?>"/>
    <? if ($styles) : ?>
        <? foreach ($styles as $style) : ?>
            <link rel="stylesheet" type="text/css" href="<?= $style; ?>"/>
        <? endforeach; ?>
    <? endif; ?>

    <? if ($scripts) : ?>
        <? foreach ($scripts as $script) : ?>
            <script type="text/javascript" src="<?= $script ?>"></script>
        <? endforeach; ?>
    <? endif; ?>

    <title><?= $title; ?></title>
</head>

<body>
<div class="karkas-main">
    <div class="karkas">
        <div class="main">
            <div class="header">
                <a href="/"><img src="<?= VIEW; ?>images/logo.png" class="logo"
                                               alt="Промстрой энерго"/></a>
                <ul class="menu">
                    <li><a href="<?= VIEW; ?>catalog/type/<?= $header_menu[0]['type_id'] ?>" class="step1"><span
                                class="menu_links_text"><?= $header_menu[0]['type_name'] ?></span></a></li>
                    <li><a href="<?= VIEW; ?>catalog/type/<?= $header_menu[1]['type_id'] ?>" class="step2"><span
                                class="menu_links_text1"><?= $header_menu[1]['type_name'] ?></span></a></li>
                    <li><a href="<?= VIEW; ?>catalog/type/<?= $header_menu[2]['type_id'] ?>" class="step3"><span
                                class="menu_links_text2"><?= $header_menu[2]['type_name'] ?></span></a></li>
                    <li><a href="<?= VIEW; ?>catalog/type/<?= $header_menu[3]['type_id'] ?>" class="step4"><span
                                class="menu_links_text3"><?= $header_menu[3]['type_name'] ?></span></a></li>
                </ul>
                <div class="search">
                    <p>поиск по сайту:</p>
                    <form action="<?= VIEW; ?>search" method="POST">
                        <img src="<?= VIEW; ?>images/loopa.gif" alt=""/>
                        <input class="inpt" type="text" name="txt1"/>
                        <input type="image" src="<?= VIEW; ?>images/search.gif" name="go"/>
                    </form>
                </div>
            </div>
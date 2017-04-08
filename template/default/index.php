<?php
/*
 * Файл,который собирает в себе все куски шаблона
 */
?>
<?= $header; ?>
<table class="content-main" cellpadding="0" cellspacing="0">
    <tr>
        <?= $left_bar; ?>
        <?= $content; ?>
        <?= $right_bar; ?>
    </tr>
</table>
<?= $footer; ?>


<?php
/*
 * Файл,который собирает в себе все куски шаблона
 */
include 'header.php';
?>
<table class="content-main" cellpadding="0" cellspacing="0">
    <tr>
    <?php   //3 блока в контентной части
    include 'left_bar.php';
    include 'content.php';
    include 'right_bar.php';
    ?>
    </tr>
</table>
<?php
include 'footer.php';
?>

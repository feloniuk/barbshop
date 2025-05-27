<?php
$text = reFilter(Request::getParam('cookie_content'));
$bgColor = Request::getParam('cookie_bg_color');
$textColor = Request::getParam('cookie_text_color');
$btnColor = Request::getParam('cookie_button_color');

?>
<div class="cookies-popup cookies">
    <div class="cookies-popup__bg"></div>
    <div class="cookies-popup__block" style="color:<?= $textColor ?>; background-color: <?= $bgColor ?>; ">
        <span class="cookies-popup__close"></span>

        <?= $text ?>

        <button class="cookies-popup__btn cookies-btn" style="background-color: <?= $btnColor ?>">I agree</button>

    </div>
</div>

<?php
/**
 * POPUP
 */

class Popup
{
    /**
     * @param $title
     * @param string $classHelper
     * class list: old-popup-styles, pos-t, pos-r, pos-b, pos-l, full-height, slide-t, slide-r, slide-b, slide-l
     */
    public static function head($title, $classHelper = 'old-popup-styles overflow-x-hidden') {
        echo '<div id="popup-close-bg" class="popup__close-bg" onclick="closePopup();"></div>
                <div id="popup-block" class="popup__block ' . $classHelper . '" data-scroll-lock-scrollable>
                <span class="popup__btn-close" onclick="closePopup();" title="Close">
                    <span class="cross-clip"></span>
                </span>
                <div class="popup__container">
                    <h3 class="popup__title">' . $title . '</h3>
                    <div id="popup-content" class="popup__content">';
    }

    public static function foot() {
        echo '</div>
        </div>
    </div>';
    }

    public static function closeListener() {
        echo '<script>
                closePopupListener();
                
                // $(\'.popup__block\').addClass(\'scrollbarHide\').scrollbar();
            </script>';
    }
}

/* End of file */

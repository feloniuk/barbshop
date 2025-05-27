<?php
/**
 * POPUP
 */

class Popup_view
{
    /**
     * @param string $classHelper
     * class list: old-popup-styles, pos-t, pos-r, pos-b, pos-l, full-height, slide-t, slide-r, slide-b, slide-l
     */
    public static function head($classHelper = 'overflow-x-hidden') {
        echo '<div id="popup-close-bg" class="popup__close-bg" onclick="closePopup()"></div>
              <div id="popup-block" class="popup__block ' . $classHelper . '">';
    }

    public static function foot() {
        echo '</div>';
    }

    public static function closeListener() {
        echo '<script>
                closePopupListener();
            </script>';
    }
}

/* End of file */

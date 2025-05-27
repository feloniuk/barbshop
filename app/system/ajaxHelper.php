<?php
/**
 * Ajax Helper
 *
 * Call before Layout if isAjax()
*/

if (Request::isAjax()) {
    // Change url
    Request::addResponse('url', false, url(_URI_));

    // Change title
    if (Request::getTitle())
        Request::addResponse('title', false, Request::getTitle());

    Request::endAjax();
}

/* End of file */
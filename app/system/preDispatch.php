<?php
/**
 * PRE DISPATCH
 */

// UserInc
incFile('modules/page/system/inc/User.inc.php');
UserInc::cookieAuth();

// Email/include JS code
Request::getSettings([
    'include_code_top', 'include_code_bottom',
    'admin_mail', 'noreply_mail', 'noreply_name',
    'title_prefix', 'favicon', 'cms_logo',
    'recaptcha_key', 'site_key',
    'facebook', 'linkedin', 'twitter', 'instagram', 'youtube',
    'og_image', 'og_job', 'og_blog',
    'test_mode', 'test_mode_email', 'tracker', 'tracker_api',
    'cookie_content', 'cookie_enable', 'cookie_bg_color', 'cookie_text_color', 'cookie_button_color',
]);

// Recaptcha
Request::setParam('recaptcha_status', false);
if (Request::getParam('recaptcha_key') && Request::getParam('site_key'))
    Request::setParam('recaptcha_status', 'yes');

// Admin logo
Request::setParam('admin_logo', _SITEDIR_ . 'data/setting/' . Request::getParam('cms_logo'));
if (!Request::getParam('cms_logo'))
    Request::setParam('admin_logo', _SITEDIR_ . 'assets/img/logo.png');

// Get META for page
Model::import('panel/content_pages');
$metaTitle = Content_pagesModel::getBlock(CONTROLLER, ACTION, 'meta_title');
if ($metaTitle) Request::setTitle($metaTitle->content, false);

$metaKeywords = Content_pagesModel::getBlock(CONTROLLER, ACTION, 'meta_keywords');
if ($metaKeywords) Request::setKeywords($metaKeywords->content, false);

$metaDesc = Content_pagesModel::getBlock(CONTROLLER, ACTION, 'meta_desc');
if ($metaDesc) Request::setDescription($metaDesc->content, false);


// Popup
incFile('modules/page/system/inc/Popup.inc.php');
incFile('modules/page/system/inc/Popup_view.inc.php');

/* End of file */
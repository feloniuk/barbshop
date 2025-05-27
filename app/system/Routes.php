<?php
/**
* ROUTES
*/

// Example:
//Route::set('login', 'profile@login')
//    ->name('profile')
//    ->where('id', '[0-9]+')
//    ->where('name', '[A-Za-z]+')
//    ->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
//Do not remove
Route::set('app/data/cvs/{slug}', 'page@file_download')->name('file_download');
Route::set('es.png', 'page@email_status')->name('e_image');
Route::set('sitemap.xml$', 'page@sitemap')->name('sitemap');
Route::set('appointments', 'page@appointments')->name('appointments');

Route::set('shops/{slug}', 'page@shops')->name('shops');
Route::set('barber/{slug}', 'page@barber')->name('barber');
Route::set('zapis', 'page@zapis')->name('zapis');
Route::set('skaner', 'page@skaner')->name('skaner');

/* End of file */

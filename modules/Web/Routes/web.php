<?php

$domain = env('APP_DOMAIN');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('web.')->domain($domain)->group(function() {

	Route::get('/symlink', function () {
        // Artisan::call('storage:link');
        symlink('/home/staispa/pmb.staispa.ac.id/storage/app/public', '/home/staispa/public_html/apps_pmb/storage');
    });

});
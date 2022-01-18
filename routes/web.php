<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

use App\Http\Controllers\LandingPage\{
    LandingPageController
};

use App\Http\Controllers\Auth\{RedirectAuthenticatedUsersController};

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

Route::get('/', function () {
    return redirect('/redirectAuthenticatedUsers');
});

Route::get('/redirectAuthenticatedUsers', [RedirectAuthenticatedUsersController::class, 'home']);

Route::get('/home', [LandingPageController::class, 'index'])
    ->name('landing_page.index')
    ->middleware('cacheable:10');
Route::get('/berita', [LandingPageController::class, 'berita'])->name(
    'landing_page.berita'
);
Route::get('/kontak', [LandingPageController::class, 'kontak'])->name(
    'landing_page.kontak'
);

Route::post('/mata_kuliah_list', [
    MainController::class,
    'mata_kuliah_list',
])->name('mata_kuliah_list');
Route::post('/semester_list', [MainController::class, 'semester_list'])->name(
    'semester_list'
);

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth'])
    ->name('dashboard');
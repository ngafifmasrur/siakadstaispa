<?php

namespace App\Providers;

use App\Models\m_global_konfigurasi;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.app', function ($view) {
            $view->with('semester', m_global_konfigurasi::first()->semester_aktif->nama_semester);
            $view->with('tahun_ajaran', m_global_konfigurasi::first()->semester_aktif->nama_semester);

            // $view->with('tahun_ajaran', m_tahun_ajaran::where('a_periode_aktif', '1')->value('nama_tahun_ajaran'));
            $view->with('semester', '2021/2022');
            $view->with('tahun_ajaran', '2021/2022');
        });
    }
}

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
            $view->with('semester', m_global_konfigurasi::first()->nama_semester_aktif);
            $view->with('tahun_ajaran', m_global_konfigurasi::first()->nama_tahun_ajaran);
        });

        view()->composer('*', function ($view) {
            $view->with('semester_id', m_global_konfigurasi::first()->id_semester_aktif);
        });
    }
}

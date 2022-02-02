<?php

namespace App\Providers;

use App\Models\m_semester;
use App\Models\m_tahun_ajaran;
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
            $view->with('semester', m_semester::where('a_periode_aktif', 1)->value('nama_semester'));
            $view->with('tahun_ajaran', m_tahun_ajaran::where('a_periode_aktif', 1)->value('nama_tahun_ajaran'));
        });
    }
}

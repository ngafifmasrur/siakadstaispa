<?php

namespace Modules\Admission\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class AdmissionServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Admission', 'Database/Migrations'));

        View::share('models', [
            'Admission' => new \Modules\Admission\Models\Admission,
            'AdmissionRegistrant' => new \Modules\Admission\Models\AdmissionRegistrant,
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Admission', 'Config/config.php') => config_path('admission.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Admission', 'Config/config.php'), 'admission'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/admission');

        $sourcePath = module_path('Admission', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/admission';
        }, \Config::get('view.paths')), [$sourcePath]), 'admission');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/admission');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'admission');
        } else {
            $this->loadTranslationsFrom(module_path('Admission', 'Resources/lang'), 'admission');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Admission', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}

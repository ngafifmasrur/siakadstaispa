<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Admission\Models\FooterInformation;

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
        view()->composer('*', function ($view) {

            /**
             * Global variable yang bisa diakses di seluruh view blade
             *
             */

            // Get active information
            $activeInformation = $this->getActiveFooterInformation('informasi');

            // Get active email
            $activeEmail = $this->getActiveFooterInformation('email');

            // Get active phone number
            $activePhoneNumber = $this->getActiveFooterInformation('nomor telepon');

            // Get active website
            $activeWebsite = $this->getActiveFooterInformation('website');
            /** @var \Illuminate\Contracts\View\View $view */
            $view->with(compact('activeInformation', 'activeEmail', 'activePhoneNumber', 'activeWebsite'));
        });

        setlocale(LC_TIME, 'id_ID');
    }

    /**
     * Get active footer information based on type and status
     *
     * @param string $type
     * @return mixed
     */
    function getActiveFooterInformation($type)
    {
        return FooterInformation::where([
            'status' => true,
            'type'   => $type
        ])->first();
    }
}

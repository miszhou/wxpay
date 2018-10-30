<?php
namespace WxPay;

use Illuminate\Support\ServiceProvider;

class WxPayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $source = realpath(__DIR__.'/../config/WxPayConfig.php');
        $this->publishes([$source => base_path('config/wxpayConfig.php')]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('WxPay\WxApi', 'WxPay\WxApi');
    }
}

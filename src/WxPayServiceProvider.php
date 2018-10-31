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
        // 默认资源文件配置
        $source = realpath(__DIR__.'/../config/WxPayConfig.php');
        // demo
        $demo = realpath(__DIR__.'/../demo/Demo.php');
        $democallback = realpath(__DIR__.'/../demo/PayNotifyCallBack.php');
        $this->publishes([
            $source => base_path('config/wxpayConfig.php'),
            $demo => base_path('demo/Demo.php'),
            $democallback => base_path('demo/PayNotifyCallBack.php')
        ]);
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

<?php

namespace Zning\EaseMobSdk;

use Illuminate\Support\ServiceProvider;

class EaseMobProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->registerEaseMob();


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //

        //数据库文件
        $this->loadMigrationsFrom(__DIR__. '/migrations');

        //配置文件
        $configPath = __DIR__ . '/config/easemob.php';
        $this->mergeConfigFrom($configPath, 'easemob');

        $this->app->singleton('easemob', function ($app) {

            $easemob = $this->app->make(EaseMobManager::class);

            $easemob->setConfig($app['config']['easemob']);

            return $easemob;

        });


    }


    /**
     * 注册 配置文件 和 数据库文件
     */

    public function registerEaseMob() {

        $configPath = __DIR__ . '/config/easemob.php';
        if (function_exists('config_path')) {
            $publishPath = config_path('easemob.php');
        } else {
            $publishPath = base_path('config/easemob.php');
        }
        $this->publishes([$configPath => $publishPath], 'config');
    }
}

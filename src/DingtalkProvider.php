<?php

namespace cjango\Dingtalk;

use Illuminate\Support\ServiceProvider;

class DingtalkProvider extends ServiceProvider
{

    public function boot()
    {
        // 发布配置
        $source = realpath(__DIR__ . '/config.php');
        $this->publishes([
            $source => config_path('wechat.php'),
        ]);
    }

    public function register()
    {

    }
}

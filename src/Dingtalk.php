<?php

namespace cjango\Dingtalk;

use Illuminate\Support\Facades\Facade;

class Dingtalk extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'dingtalk';
    }

    public static function __callStatic($name, $args)
    {
        return app('dingtalk')->$name;
    }
}

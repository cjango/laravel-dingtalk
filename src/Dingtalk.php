<?php

namespace cjango\Dingtalk;

use Illuminate\Support\Facades\Facade;

class Dingtalk extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'dingtalk';
    }

}

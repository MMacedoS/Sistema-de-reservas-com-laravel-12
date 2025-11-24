<?php

namespace App\Traits;

trait SingletonTrait
{
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = app(static::class);
        }
        return self::$instance;
    }
}

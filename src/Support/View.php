<?php

namespace PassThisTest\Support;

class View
{
    public static $dirname = 'views';

    public static $engine;

    public static function render($file, $context = array())
    {
        echo static::$engine->render($file, $context);
    }

    public static function compile($file, $context = array())
    {
        return static::$engine->render($file, $context);
    }

}
<?php

namespace Core;

class BaseRedirect
{
    public static function redirect($url)
    {
        header('Location: '.$url);
        exit;
    }
}

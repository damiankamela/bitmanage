<?php

namespace BitManage;

class Config
{
    /**
     * @param $name
     * @return null|string
     */
    public static function get($name)
    {
        return $_ENV[$name] ?? null;
    }
}
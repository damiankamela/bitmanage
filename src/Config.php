<?php

namespace BitManage;

class Config
{
    /**
     * @param $name
     * @return null|string
     */
    public static function get($name): ?string
    {
        return $_ENV[$name] ?? null;
    }
}
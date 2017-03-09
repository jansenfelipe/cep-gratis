<?php

namespace JansenFelipe\CepGratis\Tests;

class Util
{
    /**
     * Get the path to the base of tests source.
     *
     * @param string $path
     *
     * @return string
     */
    public static function base_path($path = '')
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

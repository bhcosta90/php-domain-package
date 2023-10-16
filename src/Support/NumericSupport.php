<?php

declare(strict_types=1);

namespace BRCas\CA\Support;

class NumericSupport
{
    public static function truncate($value, $decimal = 2): float|int
    {
        return intval($value * ($p = pow(10, $decimal))) / $p;
    }
}

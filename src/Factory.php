<?php

namespace Shiren\TAM;

use Exception;

/**
 * @method static g(string $spell): int 根据拼音获得天干的索引
 * @method static z(string $spell): int 根据拼音获得地支的索引
 */
class Factory
{
    const GM = ['jia' => 0, 'yi' => 1, 'bing' => 2, 'ding' => 3, 'wu' => 4, 'ji' => 5, 'geng' => 6, 'xin' => 7, 'ren' => 8, 'gui' => 9];
    const ZM = ['zi'=> 0, 'chou' => 1, 'yin'=> 2, 'mao' => 3, 'chen' => 4, 'si' => 5, 'wu' => 6, 'wei' => 7, 'shen' => 8, 'you'=> 9, 'xu' => 10, 'hai' => 11];

    /**
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        if ($name == 'g') {
            return self::GM[$arguments];
        } elseif ($name == 'z') {
            return self::ZM[$arguments];
        }
        throw new Exception('method is not exist in ' . static::class);
    }
}
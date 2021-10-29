<?php

namespace Shiren\TAM;

class Factory
{
    const GM    = ['jia' => 0, 'yi'   => 1, 'bing'  => 2, 'ding' => 3, 'wu'   => 4, 'ji' => 5, 'geng' => 6, 'xin' => 7, 'ren'  => 8, 'gui' => 9];
    const ZM    = ['zi'  => 0, 'chou' => 1, 'yin'   => 2, 'mao'  => 3, 'chen' => 4, 'si' => 5, 'wu'   => 6, 'wei' => 7, 'shen' => 8, 'you' => 9, 'xu' => 10, 'hai' => 11];
    const Type  = ['yin' => 0, 'bi'   => 1, 'shang' => 2, 'cai'  => 3, 'sha'  => 4];

    /**
     * 根据拼音获得天干的索引
     * @param string $spell
     * @return int
     */
    public static function g(string $spell): int
    {
        return self::GM[$spell];
    }

    /**
     * 根据拼音获得地支的索引
     * @param string $spell
     * @return int
     */
    public static function z(string $spell): int
    {
        return self::ZM[$spell];
    }

    /**
     * 根据拼音获得五神(印比伤才杀)的索引
     * @param string $spell
     * @return int
     */
    public static function type(string $spell): int
    {
        return self::Type[$spell];
    }

    /**
     * 中文天干转天干索引
     * @param string $chinese
     * @return int
     */
    public static function chinese2g(string $chinese): int
    {
        return static::search($chinese, Definition::Gan);
    }

    /**
     * 中文地支转地支索引
     * @param string $chinese
     * @return int
     */
    public static function chinese2z(string $chinese): int
    {
        return static::search($chinese, Definition::Zhi);
    }

    private static function search(string $chinese, array $map): int
    {
        $index = array_search($chinese, $map);
        return $index !== false ? $index : -1;
    }
}

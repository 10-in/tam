<?php

namespace Shiren\TAM;

class Str
{
    /**
     * 把阴阳索引转为字符串
     * @param int ...$arg
     * @return string
     */
    public static function o(int ...$arg): string
    {
        return self::stringify($arg, Definition::Opposite);
    }

    /**
     * 把五行索引转为字符串
     * @param int ...$arg
     * @return string
     */
    public static function e(int ...$arg): string
    {
        return self::stringify($arg, Definition::Element);
    }

    /**
     * 把天干索引转为字符串
     * @param int ...$arg
     * @return string
     */
    public static function g(int ...$arg): string
    {
        return self::stringify($arg, Definition::Gan);
    }

    /**
     * 把地支索引转为字符串
     * @param int ...$arg
     * @return string
     */
    public static function z(int ...$arg): string
    {
        return self::stringify($arg, Definition::Zhi);
    }

    /**
     * 把五神索引转为字符串
     * @param int ...$arg
     * @return string
     */
    public static function spirits(int ...$arg): string
    {
        return self::stringify($arg, Definition::Spirits5);
    }

    /**
     * @param array $ps 参数列表
     * @param array $map 替换map
     * @param string $delimiter 间隔符号
     * @return string
     */
    protected static function stringify(array $ps, array $map, string $delimiter = ''): string
    {
        $str = '';
        foreach ($ps as $a) {
            $str .= $map[$a] . $delimiter;
        }
        return rtrim($str, $delimiter);
    }
}
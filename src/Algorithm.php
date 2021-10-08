<?php

namespace Shiren\TAM;

/**
 * 通过算法关联关系
 */
class Algorithm
{
    /**
     * 根据天干索引转化为对应的阴阳索引
     * @param int $gi 天干索引
     * @return int
     */
    public static function gz2o(int $gi): int
    {
        return ($gi + 1) % 2;
    }

    /**
     * 根据天干索引转化为对应的五行索引
     * @param int $gi 天干索引
     * @return int
     */
    public static function g2e(int $gi): int
    {
        return (($gi - $gi % 2) / 2 + 1) % 5;
    }

    /**
     * 根据地支索引转化为对应的五行索引
     * @param int $zi 地支索引
     * @return int
     */
    public static function z2e(int $zi): int
    {
        return ($zi % 3) == 1 ? 3 : call_user_func(function ($y) {
            $t = (int)(($y + 1) / 3) % 4;
            return $t + (int)($t / 3);
        }, $zi);
    }

    /**
     * 根据两五行元素获取对应的五神关系索引
     * @param int $ie 日干五行
     * @param int $oe 其他五行
     * @return int
     */
    public static function spirit(int $ie, int $oe): int
    {
        return ((6 - $ie) % 5 + $oe) % 5;
    }

    /**
     * 格局是否是属于命强的局
     * @param int $spirit
     * @return bool
     */
    public static function strong(int $spirit): bool
    {
        return $spirit < 2;
    }

    /**
     * 五行相生
     * @param int $parent 五行元素主动生
     * @param int $child 五行元素被生
     * @return bool
     */
    public static function born(int $parent, int $child): bool
    {
        return ($parent + 1) % 5 == $child;
    }

    /**
     * 五行相克
     * @param int $active 五行元素主动方
     * @param int $passive 五行元素被动方
     * @return bool
     */
    public static function restrain(int $active, int $passive): bool
    {
        return ($active + 2) % 5 == $passive;
    }

    /**
     * 天干相合
     * @param int $a 合
     * @param int $b 被合
     * @return bool
     */
    public static function gh(int $a, int $b): bool
    {
        return $b - $a == 5;
    }

    /**
     * 天干相合
     * @param int $a 合
     * @param int $b 被合
     * @return bool
     */
    public static function gc(int $a, int $b): bool
    {
        return $b - $a == 6;
    }
    
    /**
     * 地支相合
     * @param int $a 合
     * @param int $b 被合
     * @return bool
     */
    public static function zh(int $a, int $b): bool
    {
        return (($a + $b) % 12 == 1) && ($b > $a);
    }

    /**
     * 地支相冲
     * @param int $a 冲
     * @param int $b 被冲
     * @return bool
     */
    public static function zc(int $a, int $b): bool
    {
        return ($b  - $a) == 6;
    }

    /**
     * 三合(增强中间)
     * @param int $a
     * @param int $b
     * @param int $c
     * @param bool $ips is position sensitive 位置敏感
     * @return bool
     */
    public static function is3He(int $a, int $b, int $c, bool $ips=false): bool
    {
        if ($ips) {
            return in_array("$a.$b.$c", ['2.6.10', '5.9.1', '8.0.4', '11.3.7']);
        } else {
            $r = [$a, $b, $c];
            sort($r, SORT_NUMERIC);
            return ($r[0] + 4) == $r[1] && ($r[0] + 8) == $r[2];
        }
    }

    /**
     * 三会(增强前两个)
     * @param int $a
     * @param int $b
     * @param int $c
     * @param bool $ips is position sensitive 位置敏感
     * @return bool
     */
    public static function is3Hui(int $a, int $b, int $c, bool $ips=false): bool
    {
        if ($ips) {
            return in_array("$a.$b.$c", ['2.3.4', '5.6.7', '8.9.10', '11.0.1']);
        } else {
            $r = [$a, $b, $c];
            sort($r, SORT_NUMERIC);
            if (in_array($r[0], [2, 5, 8])) {
                return ($r[0] + 1) == $r[1] && ($r[0] + 2) == $r[2];
            } elseif ($r[0] == 0) {
                return $r[1] == 1 && $r[2] == 11;
            }
            return false;
        }
    }

    /**
     * 下一个天干索引
     * @param int $i
     * @return int
     */
    public static function nextG(int $i): int
    {
        return self::next($i, 10);
    }

    /**
     * 上一个天干索引
     * @param int $i
     * @return int
     */
    public static function prevG(int $i): int
    {
        return self::prev($i, 10);
    }

    /**
     * 下一个地支
     * @param int $i
     * @return int
     */
    public static function nextZ(int $i): int
    {
        return self::next($i, 12);
    }

    /**
     * 上一个地支
     * @param int $i
     * @return int
     */
    public static function prevZ(int $i): int
    {
        return self::prev($i, 12);
    }

    /**
     * 年上起月法
     * @param int $yearGan 年干
     * @return int 月干(月支都从寅开始)
     */
    public static function year2month(int $yearGan): int
    {
        return (($yearGan % 5 + 1) * 2) % 10;
    }

    /**
     * 日上起时法
     * @param int $dayGan 日干
     * @return int 时干(时支都从子开始)
     */
    public static function day2hour(int $dayGan): int
    {
        return ($dayGan % 5) * 2;
    }

    /**
     * 环形偏移下一个
     * @param int $current 当前
     * @param int $size 环形内数值个数
     * @return int
     */
    protected static function next(int $current, int $size): int
    {
        return ($current + 1) % $size;
    }

    /**
     * 环形偏移上一个
     * @param int $current 当前
     * @param int $size 环形内数值个数
     * @return int
     */
    protected static function prev(int $current, int $size): int
    {
        return ($current + $size - 1) % $size;
    }
}
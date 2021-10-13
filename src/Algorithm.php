<?php

namespace Shiren\TAM;

/**
 * 通过数学规律快速计算关联关系
 */
class Algorithm
{
    /**
     * 根据天干索引转化为对应的阴阳索引
     * @example 如天干戊的索引为4，代入函数得到1->阳，则戊为阳干
     * @param int $gi 天干索引
     * @return int
     */
    public static function gz2o(int $gi): int
    {
        return ($gi + 1) % 2;
    }

    /**
     * 根据天干索引转化为对应的五行索引
     * @example 如天干壬为8，代入函数得0->水，则壬对应五行的水
     * @param int $gi 天干索引
     * @return int
     */
    public static function g2e(int $gi): int
    {
        return (($gi - $gi % 2) / 2 + 1) % 5;
    }

    /**
     * 根据地支索引转化为对应的五行索引
     * @example 如地支未为7，代入函数得3->土，则未对应五行的土
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
     * @example 如"我"日干为壬->水->0，"他"支为巳->火->2, 代入公式得3->才局
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
     * @example 五神中印(0)比(1)为命强，伤(2)才(3)杀(4)为命弱
     * @param int $spirit
     * @return bool
     */
    public static function strong(int $spirit): bool
    {
        return $spirit < 2;
    }

    /**
     * 五行相生
     * @example 水0->木1->火2->土3->金4->水5->···, 代入任意两个五行元素，可以判断前者是否生后者
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
     * @example 水0->火2->金4->木1->土3->水0->···，代入任意两个原属，可以判断这前者是否克后者
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
     * @example 天干合是阴阳相吸，阴干配阳干，同时索引间隔4个。代入甲0和己5，可以得出两者为合的关系
     * @param int $a 合
     * @param int $b 被合
     * @return bool
     */
    public static function gh(int $a, int $b): bool
    {
        return $b - $a == 5;
    }

    /**
     * 天干相冲
     * @example 天干冲为两个阴干或者阳干相斥，同时索引间隔5个。代入乙1和辛7，可以得出两者为冲的关系
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
     * @example 地支合是阴阳相吸，阴支配阳支，按环形排列，则以0，1和6，7分别为分界中线，两两相合，如代入卯3->戌10可以得出两者为合的关系
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
     * @example 地支冲为两个阴支或者阳支相斥，按环形排列，则以中心为对称点，两两相冲。如代入子0，午6，得出两者为冲的关系
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
     * @example 三合仅地支有，按环形排列地支，则每隔三个选出一个，能选出三个地支组成三合
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
     * @example 三会仅地支有，按环形排列地支，从2开始，每连续三个为一个三会
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
     * 干支暗合(天地鸳鸯媾合)
     * @example 干支合，本身是天干合的变体。地支的主气天干和天干具有合的关系，如地支子的主气为癸，而天干戊癸合，则地支子和天干戊媾合简称戊子合
     * @param int $g
     * @param int $z
     * @return bool
     */
    public static function gzh(int $g, int $z): bool
    {
        $g1 = Definition::ZwG[$z][0];
        return abs($g - $g1) == 5;
    }

    /**
     * 干支暗冲(天地鸳鸯媾冲)
     * @example 干支冲，本身是天干冲的变体。地支的主气天干和天干具有冲的关系，如地支子的主气为癸，而天干丁癸冲，则地支子和天干丁媾冲简称丁子冲
     * @param int $g
     * @param int $z
     * @return bool
     */
    public static function gzc(int $g, int $z): bool
    {
        $g1 = Definition::ZwG[$z][0];
        return abs($g - $g1) == 6;
    }

    /**
     * 地支暗媾合
     * @example 天干合的变体，两个地支的主气天干相合。如巳的主气丙和酉的主气辛相合，则巳酉媾(暗)合
     * @param int $z1
     * @param int $z2
     * @return bool
     */
    public static function zac(int $z1, int $z2): bool
    {
        $g1 = Definition::ZwG[$z1][0];
        $g2 = Definition::ZwG[$z2][0];
        return abs($g1 - $g2) == 5;
    }

    /**
     * 下一个天干索引
     * @example 环形排列天干，获取当前天干的下一个天干索引
     * @param int $i
     * @return int
     */
    public static function nextG(int $i): int
    {
        return self::next($i, 10);
    }

    /**
     * 上一个天干索引
     * @example 环形排列天干，获取当前天干的上一个天干索引
     * @param int $i
     * @return int
     */
    public static function prevG(int $i): int
    {
        return self::prev($i, 10);
    }

    /**
     * 下一个地支
     * @example 环形排列地支，获取当前地支的下一个地支索引
     * @param int $i
     * @return int
     */
    public static function nextZ(int $i): int
    {
        return self::next($i, 12);
    }

    /**
     * 上一个地支
     * @example 环形排列地支，获取当前地支的上一个地支索引
     * @param int $i 当前地支的索引，如 丑->1
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
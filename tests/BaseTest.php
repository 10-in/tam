<?php

use PHPUnit\Framework\TestCase;
use Shiren\TAM\Algorithm;

/**
 * 基础测试(正向测试)
 */
class BaseTest extends TestCase
{
    /**
     * 测试干支转换为对应的阴阳
     */
    public function testGanAndZhi2Opposite()
    {
        $rs = [1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0];
        for ($i = 0; $i < 12; $i++) {
            $res = Algorithm::gz2o($i);
            $this->assertEquals($res, $rs[$i]);
        }
    }

    /**
     * 测试干转为五行
     */
    public function testGan2Element()
    {
        $rs = [1, 1, 2, 2, 3, 3, 4, 4, 0, 0];
        for ($i = 0; $i < 10; $i++) {
            $res = Algorithm::g2e($i);
            $this->assertEquals($res, $rs[$i]);
        }
    }

    /**
     * 测试支转为五行
     */
    public function testZhi2Element()
    {
        $rs = [0, 3, 1, 1, 3, 2, 2, 3, 4, 4, 3, 0];
        for ($i = 0; $i < 12; $i++) {
            $res = Algorithm::z2e($i);
            $this->assertEquals($res, $rs[$i]);
        }
    }

    /**
     * 五行关系
     */
    public function testElementRelation()
    {
        $rs = [
            [1, 2, 3, 4, 0],
            [0, 1, 2, 3, 4],
            [4, 0, 1, 2, 3],
            [3, 4, 0, 1, 2],
            [2, 3, 4, 0, 1],
        ];
        for ($i = 0; $i < 5; $i++) {
            for ($o = 0; $o < 5; $o++) {
                $this->assertEquals(Algorithm::spirit($i, $o), $rs[$i][$o]);
            }
        }
    }

    /**
     * 测试命强命弱判断是否正确
     */
    public function testTypeIsStrong()
    {
        $rs = [true, true, false, false, false];
        for ($i = 0; $i < 5; $i++) {
            $this->assertEquals(Algorithm::strong($i), $rs[$i]);
        }
    }

    /**
     * 判断五行相生
     */
    public function testElementBron()
    {
        $r = [1, 2, 3, 4, 0];
        for ($i = 0; $i < 5; $i++) {
            $this->assertTrue(Algorithm::born($i, $r[$i]));
        }
    }


    /**
     * 判断五行相克
     */
    public function testElementRestrain()
    {
        $r = [2, 3, 4, 0, 1];
        for ($i = 0; $i < 5; $i++) {
            $this->assertTrue(Algorithm::restrain($i, $r[$i]));
        }
    }

    /**
     * 判断天干和
     */
    public function testGanHe()
    {
        foreach ([[0, 5], [1, 6], [2, 7], [3, 8], [4, 9]] as $item) {
            $this->assertTrue(Algorithm::gh($item[0], $item[1]));
        }
    }

    /**
     * 判断天干冲
     */
    public function testGanChong()
    {
        foreach ([[0, 6], [1, 7], [2, 8], [3, 9]] as $item) {
            $this->assertTrue(Algorithm::gh($item[0], $item[1]));
        }
    }
}
<?php

use PHPUnit\Framework\TestCase;
use Shiren\TAM\Algorithm;

/**
 * 算法测试(主要是正向测试)
 */
class AlgorithmTest extends TestCase
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
            $this->assertTrue(Algorithm::gc($item[0], $item[1]));
        }
    }

    /**
     * 判断地支合
     */
    public function testZhiHe()
    {
        foreach ([[0, 1], [2, 11], [3, 10], [4, 9], [5, 8], [6, 7]] as $couple) {
            $this->assertTrue(Algorithm::zh($couple[0], $couple[1]));
        }
    }

    /**
     * 判断地支冲
     */
    public function testZhiCHong()
    {
        foreach ([[0, 6], [1, 7], [2, 8], [3, 9], [4, 10], [5, 11]] as $couple) {
            $this->assertTrue(Algorithm::zc($couple[0], $couple[1]));
        }
    }

    /**
     * 判断干的偏移
     */
    public function testGanOffset()
    {
        for ($i = 0; $i < 9; $i++) {
            $this->assertEquals($i + 1, Algorithm::nextG($i));
        }
        $this->assertEquals(0, Algorithm::nextG(9));

        for ($i = 9; $i > 0; $i--) {
            $this->assertEquals($i - 1, Algorithm::prevG($i));
        }
        $this->assertEquals(9, Algorithm::prevG(0));
    }

    /**
     * 判断支的偏移
     */
    public function testZhiOffset()
    {
        for ($i = 0; $i < 11; $i++) {
            $this->assertEquals($i + 1, Algorithm::nextZ($i));
        }
        $this->assertEquals(0, Algorithm::nextZ(11));

        for ($i = 10; $i > 0; $i--) {
            $this->assertEquals($i - 1, Algorithm::prevZ($i));
        }
        $this->assertEquals(11, Algorithm::prevZ(0));
    }

    /**
     * 测试是3合
     */
    public function testIs3He()
    {
        $rs = [
            [0, 4, 8],
            [1, 5, 9],
            [2, 6, 10],
            [3, 7, 11]
        ];
        foreach ($rs as $r) {
            $this->assertTrue(Algorithm::is3He($r[0], $r[1], $r[2]));
        }
    }

    /**
     * 测试是三会
     */
    public function testIs3Hui()
    {
        $rs = [
            [11, 0, 1],
            [2, 3, 4],
            [5, 6, 7],
            [8, 9, 10],
        ];
        foreach ($rs as $r) {
            $this->assertTrue(Algorithm::is3Hui($r[0], $r[1], $r[2]));
        }
    }

    public function testYear2Month()
    {
        $map = "2468024680";
        $s = '';
        for ($i = 0;$i < 10; $i++) {
            $s .= Algorithm::year2month($i);
        }
        $this->assertEquals($map, $s);
    }

    public function testDay2Hour()
    {
        $map = "0246802468";
        $s = '';
        for ($i = 0;$i < 10; $i++) {
            $s .= Algorithm::day2hour($i);
        }
        $this->assertEquals($map, $s);
    }
}
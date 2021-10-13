<?php

use PHPUnit\Framework\TestCase;
use Shiren\TAM\Algorithm;

/**
 * 错误测试
 */
class FalseTest extends TestCase
{
    /**
     * 判断干支阴阳
     */
    public function testGanAndZhi2Opposite()
    {
        $rs = [0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 1];
        for ($i = 0; $i < 12; $i++) {
            $res = Algorithm::gz2o($i);
            $this->assertFalse($res == $rs[$i]);
        }
    }
}
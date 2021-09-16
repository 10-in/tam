<?php

require __DIR__ . '/../vendor/autoload.php';

echo \Shiren\TAM\Algorithm::g2e(0); // 0[甲] -> 1[木]
echo \Shiren\TAM\Algorithm::gz2o(10); // 10[戌] -> 1[阳]

echo \Shiren\TAM\Str::z(1, 2, 3);
echo \Shiren\TAM\Str::spirits(1, 2);
<?php
require __DIR__ . '/../vendor/autoload.php';


for($a = 0; $a < 12; $a++) {
    for($b = $a + 1; $b<12;$b++) {
        for($c=$b+1; $c<12;$c++) {
            if ($a == $b || $a == $c || $b == $c) continue;
           if (\Shiren\TAM\Algorithm::is3He($a, $b, $c)) {
               echo "$a $b $c \n";
           }
        }
    }
}

for($a = 0; $a < 12; $a++) {
    for($b = $a + 1; $b<12;$b++) {
        for($c=$b+1; $c<12;$c++) {
            if ($a == $b || $a == $c || $b == $c) continue;
            if (\Shiren\TAM\Algorithm::is3Hui($a, $b, $c)) {
                echo "$a $b $c \n";
            }
        }
    }
}
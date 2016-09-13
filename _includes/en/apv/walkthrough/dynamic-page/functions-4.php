<?php

function calcPower($in, $exp = 2) {
    $out = 1;
    for($i = 1; $i <= $exp; $i++) {
        $out *= $in;
    }
    return $out;
}

echo calcPower(5);      //outputs 25
echo calcPower(5, 3);   //outputs 125

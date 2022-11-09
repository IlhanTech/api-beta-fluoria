<?php

function key_gen() {
    $comb = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $final = $comb;
    $comb = str_shuffle($final);
    $pass = array();
    $combLen = strlen($comb) - 1;
    for ($i = 0; $i < 40; $i++) {
        $n = rand(0, $combLen);
        $pass[] = $comb[$n];
    }
    $key = implode($pass);
    return ($key);
}


?>

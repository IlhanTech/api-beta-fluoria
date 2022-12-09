<?php

function base_info() {
    $host = 'localhost';
    $usr = 'root';
    $pass = NULL;
    $base = 'fluoria-beta';

    $bdd = [$host, $usr, $pass, $base];
    return $bdd;
}

function pdo_tab() {
    $arr = base_info();
    $host = $arr[0];
    $dbname = $arr[3];
    $string = "mysql:host=" . $host . ";dbname=" . $dbname."; charset=utf8";
    $tab = [$string, $arr[1], $arr[2]];
    return $tab;
}

?>

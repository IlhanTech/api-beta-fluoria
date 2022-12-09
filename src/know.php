<?php

include "base.php";

function know_access() {
    $player = $key = NULL;
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);
    if (isset($_GET["player"]))
        $player = $_GET["player"];
    if ($player == NULL && $key == NULL) {
        echo 'FALSE';
        return NULL;
    }
    $sql = "SELECT `player` FROM `players` WHERE `player` = :player";
    $query = $db->prepare($sql);
    $query->bindParam(':player', $player);
    $query->execute();
    $result = $query->fetch();
    if ($result === false) {
        echo 'FALSE';
        return FALSE;
    }
    echo 'TRUE';
    return TRUE;
}

know_access();
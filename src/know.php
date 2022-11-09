<?php

include "base.php";

function know_access() {
    $bdd = base_info();
    $player = $_GET["player"];
    $host = $bdd[0];
    $username = $bdd[1];
    $password = $bdd[2];
    $dbname =$bdd[3];
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname .'; charset=utf8' , $username , $password);
    $reponse = $db->query('SELECT * FROM `players`');

    if ($player == NULL && $key == NULL) {
        return NULL;
    }
    while ($donnees = $reponse->fetch()) {
        if (strcmp($donnees['player'], $player) == 0) {
            echo 'TRUE';
            return (TRUE);
        } else  {
            echo 'FALSE';
            return (FALSE);
        }
    }
}
know_access();
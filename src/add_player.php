<?php

include_once "base.php";

function know_access_2($player, $key) {
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);
    $reponse = $db->prepare('SELECT * FROM `players` WHERE `player` = ? AND `key` = ?');
    $reponse->execute([$player, $key]);

    if ($player == NULL || $key == NULL) {
        return NULL;
    }
    while ($donnees = $reponse->fetch()) {
        if (strcmp($donnees['player'], $player) == 0 && strcmp($donnees['key'], $key) == 0) {
            return (0);
        }
    }
    return (42);
}

function key_in_db_player($key) {
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);

    $sql = "SELECT `key` FROM `players` WHERE `key` = :key";
    $query = $db->prepare($sql);
    $query->bindParam(':key', $key);
    $query->execute();

    $result = $query->fetch();
    if ($result === false) {
        return (42);
    }
    return (0);
}

function player_in_db_player($player) {
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);

    $sql = "SELECT `player` FROM `players` WHERE `player` = :player";
    $query = $db->prepare($sql);
    $query->bindParam(':player', $player);
    $query->execute();

    $result = $query->fetch();
    if ($result === false) {
        return (42);
    }
    return (0);
}

function key_in_db_key($key) {
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);

    $sql = "SELECT `key` FROM `keys` WHERE `key` = :key";
    $query = $db->prepare($sql);
    $query->bindParam(':key', $key);
    $query->execute();

    $result = $query->fetch();
    if ($result === false) {
        return (42);
    }
    return (0);
}

function add_player() {
    $key = $player =  NULL;
    $date = date("m.d.y");
    if (isset($_GET["player"]))
        $player = $_GET["player"];
    if (isset($_GET["key"]))
        $key = $_GET["key"];
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);
    $reponse = $db->query('SELECT * FROM `players`');
    $type = "only";

    if (key_in_db_key($key) == 1) {
        echo 'FALSE';
        echo '<p class="error-msg">La clef utilisée est invalide !</p>';
        return FALSE;
    }
    if (key_in_db_player($key) == 0) {
        echo 'FALSE';
        echo '<p class="error-msg">Clef déjà utilisée par un autre joueur !</p>';
        return FALSE;
    }
    if (player_in_db_player($player) == 0) {
        echo 'FALSE';
        echo '<p class="error-msg">Ce joueur a déjà été ajouté à la beta !</p>';
        return FALSE;
    }
    if (know_access_2($player, $key) == TRUE) {
        echo 'FALSE';
        echo '<p class="error-msg">Ce joueur a déjà été ajouté à la beta !</p>';
        return FALSE;
    }
    $sql = "INSERT INTO `players` (`player`, `key`, `date`) VALUES (:player, :key, :date)";
    $query = $db->prepare($sql);
    $query->bindParam(':player', $player);
    $query->bindParam(':key', $key);
    $query->bindParam(':date', $date);
    $query->execute();

    $reponse = $db->query('SELECT * FROM `keys`');
    while ($donnees = $reponse->fetch()) {
        if (strcmp($donnees['key'], $key) == 0 && strcmp($donnees['type'], $type) == 0) {
            $id = $donnees['id'];
            $sql = "DELETE FROM `keys` WHERE id=:id";
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
        }
    }
    echo 'TRUE';
    return TRUE;
}

add_player();
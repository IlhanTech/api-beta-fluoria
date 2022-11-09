<?php

include "base.php";

function know_access_2($player, $key) {
    $bdd = base_info();
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
        if (strcmp($donnees['player'], $player) == 0 && strcmp($donnees['key'], $key) == 0) {
            return (TRUE);
        } else  {
            return (FALSE);
        }
    }
}

function key_in_db_player($key) {
    $bdd = base_info();
    $host = $bdd[0];
    $username = $bdd[1];
    $password = $bdd[2];
    $dbname = $bdd[3];
    $conn = mysqli_connect($bdd[0], $bdd[1], $bdd[2], $bdd[3]);
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname .'; charset=utf8' , $username , $password);
    $i = 0;

    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    foreach ($db->query("SELECT `key` FROM `players`") as $keys) {
        if ($db->query("SELECT `key` FROM `players`") == NULL)
            return (42);
        $array[$i] = $keys[0];
        if (strcmp($array[$i], $key) == 0) {
            return (0);
        }
        $i++;
    }
    mysqli_close($conn);
    return (1);
}

function player_in_db_player($player) {
    $bdd = base_info();
    $host = $bdd[0];
    $username = $bdd[1];
    $password = $bdd[2];
    $dbname = $bdd[3];
    $conn = mysqli_connect($bdd[0], $bdd[1], $bdd[2], $bdd[3]);
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname .'; charset=utf8' , $username , $password);
    $i = 0;

    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    foreach ($db->query("SELECT `player` FROM `players`") as $players) {
        if ($db->query("SELECT `player` FROM `players`") == NULL)
            return (42);
        $array[$i] = $players[0];
        if (strcmp($array[$i], $player) == 0) {
            return (0);
        }
        $i++;
    }
    mysqli_close($conn);
    return (1);
}

function key_in_db_key($key) {
    $bdd = base_info();
    $host = $bdd[0];
    $username = $bdd[1];
    $password = $bdd[2];
    $dbname = $bdd[3];
    $conn = mysqli_connect($bdd[0], $bdd[1], $bdd[2], $bdd[3]);
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname .'; charset=utf8' , $username , $password);
    $i = 0;

    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    foreach ($db->query("SELECT `key` FROM `keys`") as $keys) {
        if ($db->query("SELECT `key` FROM `keys`") == NULL)
            return (42);
        $array[$i] = $keys[0];
        if (strcmp($array[$i], $key) == 0) {
            return (0);
        }
        $i++;
    }
    mysqli_close($conn);
    return (1);
}


function add_player() {
    $bdd = base_info();
    $date = date("m.d.y");
    $player = $_GET["player"];
    $key = $_GET["key"];
    $host = $bdd[0];
    $username = $bdd[1];
    $password = $bdd[2];
    $dbname =$bdd[3];
    $db = new PDO('mysql:host=' . $host . ';dbname=' . $dbname .'; charset=utf8' , $username , $password);
    $reponse = $db->query('SELECT * FROM `players`');
    $type = "only";

    if (key_in_db_key($key) == 1) {
        echo 'FALSE';
        echo '<p class="error-msg">La clef utilisée est invalide !</p>';
        return (FALSE);
    }
    if (key_in_db_player($key) == 0) {
        echo 'FALSE';
        echo '<p class="error-msg">Clef déjà utilisée par un autre joueur !</p>';
        return FALSE;
    }
    if (player_in_db_player($player) == 0) {
        echo 'FALSE';
        echo '<p class="error-msg">Ce joueur a déjà été ajouté à la beta !</p>';
        return (FALSE);
    }
    if (know_access_2($player, $key) == TRUE) {
        echo 'FALSE';
        echo '<p class="error-msg">Ce joueur a déjà été ajouté à la beta !</p>';
        return (FALSE);
    }
    $sql = "INSERT INTO `players` (`player`, `key`, `date`) VALUES ('$player', '$key', '$date')";
    $db->query($sql);

    $reponse = $db->query('SELECT * FROM `keys`');
    while ($donnees = $reponse->fetch()) {
        if (strcmp($donnees['key'], $key) == 0 && strcmp($donnees['type'], $type) == 0) {
            $id = $donnees['id'];
            $sql = "DELETE FROM `keys` WHERE id=$id";
            $db->query($sql);
        }
    }
    echo 'TRUE';
    return (TRUE);
}

add_player();
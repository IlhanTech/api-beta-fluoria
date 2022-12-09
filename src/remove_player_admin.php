<?php
include "base.php";
include "../index.php";

function player_in_db_player_remove($player) {
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

function detect_shit_remove($player) {
    $incorrect = "!#$%&'()*+,-./:;<=>?@[\]^_`{|}~€£";

    if ($player == '')
        return (42);
    for ($i = 0; $i < strlen($player); $i++) {
        for ($y = 0; $y < strlen($incorrect); $y++) {
            if ($player[$i] == $incorrect[$y]) {
                return (42);
            }
        }
    }
}

function remove_player_admin() {
    $date = date("m.d.y");
    $player = $_POST['input_field_remove'];
    $player = str_replace(' ', '', $player);
    if (detect_shit_remove($player) == 42) {
        echo '<p class="error">Veuillez rentrer un pseudo correct !</p>';
        return (42);
    }
    if (player_in_db_player_remove($player) != 0) {
        echo "<p class=". "error" .">Erreur ce joueur n'est pas inscris à la béta !</p>";
        return (42);
    }
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);
    $reponse = $db->query('SELECT * FROM `players`');
    while ($donnees = $reponse->fetch()) {
        if (strcmp($donnees['player'], $player) == 0) {
            $id = $donnees['id'];
            $sql = "DELETE FROM `players` WHERE id=:id";
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id);
            $query->execute();
        }
    }
    echo "<p class=". "success" .">Le joueur $player a bien été retiré de la beta !</p>";
}

echo '<link rel="stylesheet" href="../css/style.css">';
remove_player_admin();
header("Refresh: 2;url=/api/");

?>
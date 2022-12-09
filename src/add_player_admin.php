<?php

include "../index.php";
include "base.php";

function key_gen_add() {
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

function style_form_mail_add() {
    ?>
    <style>
    h2 {
        font-size: 22px;
    }
    form input {
        width: 500px;
        height: 40px;
    }
    .wp-core-ui .button-primary {
        background: #032f67 !important;
        border-color: #032f67 !important;
    }
    .wp-core-ui:hover .button-primary:hover {
        background: #022450 !important;
        border-color: #022450 !important;
    }
    </style>
    <?php
}

function player_in_db_player_add($player) {
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

function detect_shit_add($player) {
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

function add_player_admin() {
    $date = date("m.d.y");
    $player = $_POST['input_field_add'];
    $player = str_replace(' ', '', $player);
    if (detect_shit_add($player) == 42) {
        echo '<p class="error">Veuillez rentrer un pseudo correct !</p>';
        return (42);
    }
    if (player_in_db_player_add($player) == 0) {
        echo '<p class="error">Erreur ce joueur à déjà ajouté à la béta !</p>';
        return (42);
    }
    $key = key_gen_add();
    $arr = pdo_tab();
    $db = new PDO($arr[0], $arr[1], $arr[2]);

    $sql = "INSERT INTO `players` (`player`, `key`, `date`) VALUES (:player, :key, :date)";
    $query = $db->prepare($sql);
    $query->bindParam(':player', $player);
    $query->bindParam(':key', $key);
    $query->bindParam(':date', $date);
    $query->execute();
    echo "<p class=". "success" .">Le joueur $player a bien été ajouté à la beta !</p>";
}

echo '<link rel="stylesheet" href="../css/style.css">';
add_player_admin();
header("Refresh: 2;url=/api/");

?>

<?php

include "key.php";

function base_info_gen() {
    $host = 'localhost';
    $usr = 'root';
    $pass = NULL;
    $base = 'fluoria-beta';

    $bdd = [$host, $usr, $pass, $base];
    return $bdd;
}

function pdo_tab_gen() {
    $arr = base_info_gen();
    $host = $arr[0];
    $dbname = $arr[3];
    $string = "mysql:host=" . $host . ";dbname=" . $dbname."; charset=utf8";
    $tab = [$string, $arr[1], $arr[2]];
    return $tab;
}

function copy_key($key) {
    echo '<textarea rows="1" cols="40" readonly style="resize: none"id="cpy">'. $key .'</textarea>';
    echo '<button onclick="window.copyText()">Copy</button>';
    echo '<script>
        function copyText() {
            var textarea = document.getElementById("cpy");
            textarea.select();
            document.execCommand("copy");
        }
    </script>';
}

function module_generate_key() {
    $etat = 2;
    $first = "unique";
    $bdd = base_info_gen();
    $date = date("m.d.y");
    $key = NULL;

    $conn = mysqli_connect($bdd[0], $bdd[1], $bdd[2], $bdd[3]);

    if (!$conn) {
        die("Échec de la connexion : " . mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        foreach ($_POST['selector'] as $value) {
            $first = $value;
        }
    }
    ?>
    <form action="#" method="post">
        <select name="selector[]">
            <option value="unique" <?php if($first == "unique") {?> selected="selected" <?php } ?>>Unique</option>
            <option value="permanente" <?php if($first == "permanente") {?> selected="selected" <?php } ?>>Permanente</option>
        </select>
        <input type="submit" name="submit" value="Générer" class="gen"/>
    </form>
    <?php
        if (isset($_POST['submit'])) {
            foreach ($_POST['selector'] as $value) {
                switch ($value) {
                    case "permanente": $etat= 1; break;
                    default: $etat = 2; break;
                }
            }
            if ($etat == 1) {
                $key = key_gen();
                $type = "permanent";
                $sql = "INSERT INTO `keys` (`key`, `type`, `date`) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $key, $type, $date);
                if ($stmt->execute()) {
                } else {
                    echo "Erreur : " . $sql . "<br>" . $conn->error;
                }
            }
            if ($etat == 2) {
                $key = key_gen();
                $type = "only";
                $sql = "INSERT INTO `keys` (`key`, `type`, `date`) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sss', $key, $type, $date);
                if ($stmt->execute()) {
                } else {
                    echo "Erreur : " . $sql . "<br>" . $conn->error;
                }

            }
        }
    mysqli_close($conn);
    return ($key);
}

?>



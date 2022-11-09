<?php

include "key.php";
include "base.php";

function module_generate_key() {
    echo '<div class="module-key-generate">';
    $etat = 2;
    $first = "unique";
    $bdd = base_info();
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
        <h5>Sélectionnez un état</h5>
        <select name="selector[]">
            <option value="unique" <?php if($first == "unique") {?> selected="selected" <?php } ?>>Unique</option>
            <option value="permanente" <?php if($first == "permanente") {?> selected="selected" <?php } ?>>Permanente</option>
        </select>
        <input type="submit" name="submit" value="Générer" />
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

                $sql = "INSERT INTO `keys` (`key`, `type`, `date`) VALUES ('$key', '$type', '$date')";

                if (mysqli_query($conn, $sql)) {
                } else {
                    echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
                }
            }
            if ($etat == 2) {
                $key = key_gen();
                $type = "only";

                $sql = "INSERT INTO `keys` (`key`, `type`, `date`) VALUES ('$key', '$type', '$date')";

                if (mysqli_query($conn, $sql)) {
                } else {
                    echo "Erreur : " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    echo '<div class="key">';
    echo "<p>$key</p>";
    echo "</div>";
    echo "</div>";
    mysqli_close($conn);
}

?>

<?php

include "base.php";

$bdd = base_info();
$conn = mysqli_connect($bdd[0], $bdd[1], $bdd[2], $bdd[3]);

if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

$create_table_1 = "CREATE TABLE IF NOT EXISTS `keys` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `key` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
    `date` date DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;";

$create_table_2 = "CREATE TABLE IF NOT EXISTS `players` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `player` varchar(255) NOT NULL,
    `key` varchar(255) NOT NULL,
    `date` date DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;";

if (mysqli_query($conn, $create_table_1)) {
    echo "La table keys a bien été créée. <br>";
} else {
    echo "Erreur : " . $create_table_1 . "<br>" . mysqli_error($conn);
}

if (mysqli_query($conn, $create_table_2)) {
    echo "La table players a bien été créée. <br>";
} else {
    echo "Erreur : " . $create_table_2 . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);

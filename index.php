<!DOCTYPE html>
<html>
    <head>
        <title>Panel admin beta Fluoria</title>
        <link rel="stylesheet" href="css/style.css">
        <?php
            include "src/generate.php";
        ?>
    </head>
    <body>
        <div class="div-logo">
        <a href="http://fluoria.fr">
            <img alt="logo fluoria" class="logo" src="http://fluoria.fr/storage/img/bigologo.png" width="75%" alt="Fluoria"/>
        </a>
        </div>
        <div class="div-father">
            <h2 class="info">Entrez le pseudonyme du joueur : </h2>
            <div class="div-form1">
                <form action="src/add_player_admin.php" method="POST">
                    <input type="text" name="input_field_add" placeholder="Pseudonyme" class="pseudo">
                    <button type="submit" class="buttongreen">Ajouter</button>
                </form>
            </div>

            <div class="div-form2">
                <form action="src/remove_player_admin.php" method="POST">
                    <input type="text" name="input_field_remove" placeholder="Pseudonyme" class="pseudo">
                    <button type="submit" class="buttongreen">Retirer</button>
                </form>
            </div>
            <div class="module-key-generate">
                <h2 class="info-client">Générer une clef : </h2>
                <?php
                    $key = module_generate_key();
                    copy_key($key);
                ?>
            </div>
        </div>
    </body>
</html>
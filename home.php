<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Tank Wars</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="./home.css">
    <link rel="icon" href="./uploads/img_site/iconeSite.png" type="image/x-icon">
    <script defer src="./script.js"></script>
</head>

<body>

    <section class="combat-container">
        <h1>Tank Wars</h1>
        <?php if (isset($_SESSION['logimg'])) {
                echo "<p class='error'>{$_SESSION['logimg']}</p>";
                unset($_SESSION['logimg']); // Supprime le message après affichage
            } ?>
        <button class="btn-open-popup" onclick="togglePopup()"></button>
        <form action="index.php?action=battle" method="POST" class="battle-container">
            <div class="autrelabel">
                <label for="tankjouer">Votre Tank</label>
                <div class="ennemi"><img id="tankjoueur-img" src="" alt="Tank joueur" class="tank-img" style="visibility:hidden;"></div>

                <div id="tankjoueur-stats" class="tank-stats" style="visibility:hidden;">
                    <p>Attaque: <span id="tankjoueur-atk"></span></p>
                    <p>Santé: <span id="tankjoueur-pv"></span></p>
                </div>

                <select name="tankjoueur" id="tankjouer" class="selecthome"
                    onchange="updateImageAndStats('tankjouer', 'tankjoueur-img', 'tankjoueur-stats', 'tankjoueur-atk', 'tankjoueur-pv')">
                    <option value="" disabled selected>Choisissez Votre Tank</option>
                    <?php
                    // on récupère les informations des tanks afin de pouvoir afficher les statistiques et l'image du tanks au dessus du select
                    foreach ($personnages as $value) {
                        echo '<option value="' . $value->getId() . '" data-image="' . $value->getImage() . '" data-atk="' . $value->getAtk() . '" data-pv="' . $value->getPv() . '">' . $value->getNom() . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="vs">
                <h2>VS</h2>
                <button type="submit">Battle !</button>
            </div>
            <div class="autrelabel">
                <label for="tankbot">Tank rival</label>
                <img id="tankbot-img" src="" alt="Tank rival" class="tank-img" style="visibility:hidden;">
                <div id="tankbot-stats" class="tank-stats" style="visibility:hidden;">
                    <p>Attaque: <span id="tankbot-atk"></span></p>
                    <p>Santé: <span id="tankbot-pv"></span></p>
                </div>

                <select name="tankbot" id="tankbot" class="selecthome"
                    onchange="updateImageAndStats('tankbot', 'tankbot-img', 'tankbot-stats', 'tankbot-atk', 'tankbot-pv')">
                    <option value="" disabled selected>Choisissez Votre Tank rival</option>
                    <?php
                    foreach ($personnages as $value) {
                        echo '<option value="' . $value->getId() . '" data-image="' . $value->getImage() . '" data-atk="' . $value->getAtk() . '" data-pv="' . $value->getPv() . '">' . $value->getNom() . '</option>';
                    }
                    ?>
                </select>
            </div>
        </form>
    </section>

    <div class="popup-overlay" id="popupOverlay" onclick="togglePopup()"></div>

    <!-- Formulaire popup -->
    <div class="form-popup" id="myForm">
        <button class="close-popup" onclick="togglePopup()">X</button>
        <form action='index.php?action=addperso' method='POST' enctype="multipart/form-data">
            <h2>Ajouter un Tank</h2>
            <?php echo "<p>Il y'a actuellement " . $persocount . " Tank </p>"; ?>

            <label for='nom'>Nom :</label>
            <input type='text' name='nom' id='nom' required>

            <label for='atk'>Attaque :</label>
            <input type='number' name='atk' id='atk' required max="100" min="1" >

            <label for='pv'>Santé :</label>
            <input type='number' name='pv' id='pv' required max="100" min="1">

            <label for="photo">image du Tank :</label>
            <input type="file" name="photo" id="photo" required>

            <input type="submit" name="submit" value="Ajouter">
        </form>
    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat - Tank Wars</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="icon" href="./uploads/img_site/iconeSite.png" type="image/x-icon">
</head>

<body>
    <?php

    $gameover = false;
    $message = '';
    
    if ($tankjoueur->getPv() <= 0) {
        $gameover = true;
        $message = 'Vous avez perdu !';

        // Reinitialisation des points de vie des tanks
        $tankjoueur = $monManager->getPersonnageById($_SESSION['tankjoueur']);
        $tankjoueur->reinitPv();
        $monManager->updatePersonnage($tankjoueur);
        $tankbot = $monManager->getPersonnageById($_SESSION['tankbot']);
        $tankbot->reinitPv();
        $monManager->updatePersonnage($tankbot);

    } elseif ($tankbot->getPv() <= 0) {
        $gameover = true;
        $message = 'Vous avez gagné !';

        // Reinitialisation des points de vie des tanks
        $tankjoueur = $monManager->getPersonnageById($_SESSION['tankjoueur']);
        $tankjoueur->reinitPv();
        $monManager->updatePersonnage($tankjoueur);
        $tankbot = $monManager->getPersonnageById($_SESSION['tankbot']);
        $tankbot->reinitPv();
        $monManager->updatePersonnage($tankbot);
    }
    ?>
    <section class="combat-container">
        <h1>Tank Wars</h1>
        <?php
        if (isset($logdujoueur)) {
            echo "<p class='LogDialogue'> $logdujoueur </p>";
        }
        ?>
        <?php
        if (isset($logdubot)) {
            echo "<p class='LogDialogue Bot'> $logdubot </p>";
        }
        ?>
        </span>
        <div class="battle-container">
            <div>
                <?php echo "<h3>" . $tankjoueur->getNom() . "</h3>" ?>
                <?php if (isset($joueuratk)) {
                    echo "<img class='degatsbot' src='./uploads/img_site/degats.png' alt=''>";
                } ?>
                <?php if (isset($joueursoin)) {
                    echo "<img class='joueursoin' src='./uploads/img_site/soin.png' alt=''>";
                } ?>
                <?php echo "<img src='" . $tankjoueur->getImage() . "' alt='Tank joueur' class='tank-img ennemi'>"; ?>
                <div class="barre-de-vie">
                    <?php echo "<div class='barre' style='width: " . $tankjoueur->getPv() . "%;'></div>" ?>
                </div>
            </div>
            <div class="vs">
                <h2>VS</h2>
                <div class="form-container">
                    <form method="post" action="index.php?action=attaquer">
                        <button type="submit" name="action" value="attaquer">attaquer</button>
                    </form>
                    <form method="post" action="index.php?action=regen">
                        <button type="submit" name="action" value="regen">regen</button>
                    </form>
                    <form method="post" action="index.php?action=fuir">
                        <button type="submit" name="action" value="fuir">fuir</button>
                    </form>
                </div>
            </div>
            <div>
                <?php echo "<h3>" . $tankbot->getNom() . "</h3>" ?>
                <?php if (isset($botatk)) {
                    echo "<img class='degatsjoueur' src='./uploads/img_site/degats.png' alt=''>";
                } ?>
                <?php if (isset($botsoin)) {
                    echo "<img class='botsoin' src='./uploads/img_site/soin.png' alt=''>";
                } ?>
                <?php echo "<img src='" . $tankbot->getImage() . "' alt='Tank rival' class='tank-img'>"; ?>
                <div class="barre-de-vie">
                    <?php echo "<div class='barre' style='width: " . $tankbot->getPv() . "%;'></div>" ?>
                </div>
            </div>
        </div>
        <?php
        echo "<div class='win' id='winMessage'>
        <h1> $message </h1>
        </div>";
        ?>
    </section>

    <script>
        if (<?php echo $gameover ?>) {
            document.getElementById('winMessage').style.display = 'flex';
            setTimeout(function () {
                window.location.href = 'index.php?action=home';
            }, 3000);
        }
    </script>

</body>

</html>
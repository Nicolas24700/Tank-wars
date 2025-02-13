<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice - Tank Wars</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="icon" href="./uploads/img_site/iconeSite.png" type="image/x-icon">
    
</head>

<body>
    <?php
    $donnees = $monManager->getALLPersonnages();
    ?>
    <section class="section-backoffice">
        <h2>Back Office - Liste des Personnages</h2>
        <a href="index.php?action=home" class="imglien" aria-label="Lien vers la page d'accueil"></a>
        <?php if (isset($_SESSION['logadmin'])) {
            echo "<p class='erroradmin'>{$_SESSION['logadmin']}</p>";
            unset($_SESSION['logadmin']); // Supprime le message après affichage
        } ?>
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>nom</th>
                    <th>attaque</th>
                    <th>santé</th>
                    <th>image</th>
                    <th>lien image</th>
                    <th>Modifier</th>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // affichage des tanks
                foreach ($donnees as $donneess) {
                    echo '<tr>';
                    echo '<form action="index.php?action=modifperso" method="post">';
                    echo '<input type="hidden" name="action" value="modifperso">';
                    echo '<input type="hidden" name="id" value="' . $donneess->getId() . '">';
                    echo '<td><input type="text" name="id" disabled value="' . $donneess->getId() . '"></td>';
                    echo '<td><input type="text" name="nom" value="' . $donneess->getNom() . '"></td>';
                    echo '<td><input type="number" name="atk" value="' . $donneess->getAtk() . '"></td>';
                    echo '<td><input type="number" name="pv" value="' . $donneess->getpv() . '"></td>';
                    echo '<td><img class="flipped-image" src="' . $donneess->getImage() . '" alt="image" width="100px"></td>';
                    echo '<td><input type="text" name="lien_image" value="' . $donneess->getImage() . '"></td>';
                    echo '<td><input type="submit" value="Modifier"></td>';
                    echo '</form>';
                    echo '<form action="index.php?action=deleteperso" method="post">';
                    echo '<input type="hidden" name="action" value="deleteperso">';
                    echo '<input type="hidden" name="id" value="' . $donneess->getId() . '">';
                    echo '<input type="hidden" name="nom" value="' . $donneess->getNom() . '">';
                    echo '<td><input type="submit" value="Supprimer"></td>';
                    echo '</form>';
                    echo '</tr>';
                }
                ?>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
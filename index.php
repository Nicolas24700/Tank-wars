<?php
require_once './boostrap.php';

session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'home':
        $personnages = $monManager->getALLPersonnages();
        $persocount = Personnage::afficheCompteur();
        include './home.php';
        break;
    case 'addperso':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $atk = $_POST['atk'];
            $pv = $_POST['pv'];
            $uploadedFile = $monManager->uploadImage($_FILES["photo"], $nom);
            //si l'image a bien été uploadée on crée le personnage et on l'ajoute à la base de données
            if ($uploadedFile) {
                $perso = new Personnage([
                    'nom' => $nom,
                    'atk' => $atk,
                    'pv' => $pv,
                    'image' => $uploadedFile
                ]);
                $monManager->addPersonnage($perso);
                //message de confirmation de création
                $_SESSION['logimg'] = "Le Tank [ $nom ] a été créée avec succès.";
            }
        }
        $personnages = $monManager->getALLPersonnages();
        $persocount = Personnage::afficheCompteur();
        include './home.php';
        break;
    case 'battle':
        $personnages = $monManager->getALLPersonnages();
        $persocount = Personnage::afficheCompteur();
        // créer une session pour stocker les id des tanks choisis pour le battle
        if (isset($_POST['tankjoueur']) && isset($_POST['tankbot'])) {
            $_SESSION['tankjoueur'] = $_POST['tankjoueur'];
            $_SESSION['tankbot'] = $_POST['tankbot'];
            if ($_SESSION['tankjoueur'] == $_SESSION['tankbot']) {
                $_SESSION['logimg'] = "Vous ne pouvez pas choisir le même tank pour les deux joueurs.";
                include './home.php';
            }
        }
        // si aucun tank est choisi , on redirige vers la page d'accueil
        if (!isset($_SESSION['tankjoueur']) || !isset($_SESSION['tankbot'])) {
            header('Location: ./index.php?action=home');
        }
        // récupérer les tanks choisis
        $tankjoueur = $monManager->getPersonnageById($_SESSION['tankjoueur']);
        $tankbot = $monManager->getPersonnageById($_SESSION['tankbot']);
        include './battle.php';
        break;
    case 'attaquer':
        // Permet d'attaquer
        $tankjoueur = $monManager->getPersonnageById($_SESSION['tankjoueur']);
        $tankbot = $monManager->getPersonnageById($_SESSION['tankbot']);
        $logdujoueur = $tankjoueur->attaque($tankbot);
        // variable pour afficher le png de l'attaque
        $joueuratk = true;
        $monManager->updatePersonnage($tankjoueur);
        $monManager->updatePersonnage($tankbot);

        // Permet de faire jouer l'ordi avec un nombre aléatoire
        $actionOrdi = rand(1, 2);
        if ($actionOrdi == 1) {
            $logdubot = $tankbot->attaque($tankjoueur);
            // variable pour afficher le png de l'attaque
            $botatk = true;
            $monManager->updatePersonnage($tankbot);
            $monManager->updatePersonnage($tankjoueur);
        } else {
            $logdubot = $tankbot->regen();
            // variable pour afficher le png de soin
            $botsoin = true;
            $monManager->updatePersonnage($tankbot);
        }
        include './battle.php';
        break;
    case 'regen':
        // Permet de regenerer les points de vie
        $tankjoueur = $monManager->getPersonnageById($_SESSION['tankjoueur']);
        $tankbot = $monManager->getPersonnageById($_SESSION['tankbot']);
        $logdujoueur = $tankjoueur->regen();
        // variable pour afficher le png de l'attaque
        $joueursoin = true;
        $monManager->updatePersonnage($tankjoueur);

        // Permet de faire jouer l'ordi avant l'affichage du dialogue
        $actionOrdi = rand(1, 2);
        if ($actionOrdi == 1) {
            $logdubot = $tankbot->attaque($tankjoueur);
            // variable pour afficher le png de l'attaque
            $botatk = true;
            $monManager->updatePersonnage($tankbot);
            $monManager->updatePersonnage($tankjoueur);
        } else {
            $logdubot = $tankbot->regen();
            // variable pour afficher le png de soin
            $botsoin = true;
            $monManager->updatePersonnage($tankbot);
        }
        include './battle.php';
        break;
    case 'fuir':
        //si on fuit on réinitialise les points de vie des tanks
        $tankjoueur = $monManager->getPersonnageById($_SESSION['tankjoueur']);
        $tankjoueur->reinitPv();
        $monManager->updatePersonnage($tankjoueur);
        $tankbot = $monManager->getPersonnageById($_SESSION['tankbot']);
        $tankbot->reinitPv();
        $monManager->updatePersonnage($tankbot);

        // Suppression des variables de session
        $_SESSION = array();
        unset($_SESSION['tankjoueur']);
        unset($_SESSION['tankbot']);
        session_destroy();

        // Redirection vers la page d'accueil
        header('Location: index.php?action=home');
        break;

    case 'backoffice':
        include './backoffice.php';
        break;
    case 'deleteperso':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $monManager->deletePersonnage($monManager->getPersonnageById($id));
            $_SESSION['logadmin'] = "Le Tank [$nom] avec l'id [$id] a été supprimé avec succès.";
        }
        include './backoffice.php';
        break;
    case 'modifperso':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nom = $_POST['nom'];
            $id = $_POST['id'];
            $atk = $_POST['atk'];
            $pv = $_POST['pv'];
            $modif = $monManager->getPersonnageById($id);
            $modif->setNom($nom);
            $modif->setPv($pv);
            $modif->setAtk($atk);
            $monManager->updatePersonnage($modif);
            $_SESSION['logadmin'] = "Le Tank [$nom] avec l'id [$id] a été modifiée avec succès.";
        }
        include './backoffice.php';
        break;
    default:
        include './home.php';
        break;

}

?>
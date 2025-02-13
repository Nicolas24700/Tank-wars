<?php
class PersonnageManager
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function setDb(PDO $db)
    {
        $this->db = $db;
    }

    public function getALLPersonnages()
    {
        $requete = 'SELECT * FROM personnages ORDER BY id';
        $stmt = $this->db->query($requete);

        while ($perso = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $personnages[] = new Personnage($perso);
        }
        return $personnages;
    }
    public function addPersonnage(Personnage $perso)
    {
        $query = $this->db->prepare('INSERT INTO personnages(nom, pv, atk, image) VALUES (:nom, :pv, :atk, :image)');
        $query->bindValue(':nom', $perso->getNom());
        $query->bindValue(':pv', $perso->getPv());
        $query->bindValue(':atk', $perso->getAtk());
        $query->bindValue(':image', $perso->getImage());
        $query->execute();
    }

    public function updatePersonnage(Personnage $perso){
        $query = $this->db->prepare('UPDATE personnages SET nom = :nom, pv = :pv, atk = :atk WHERE id = :id');
        $query->bindValue(':nom', $perso->getNom());
        $query->bindValue(':pv', $perso->getPv());
        $query->bindValue(':atk', $perso->getAtk());
        $query->bindValue(':id', $perso->getId());
        $query->execute();
    }
    public function getPersonnageById($id) {
        $query = $this -> db -> prepare('SELECT * FROM personnages WHERE id = :id');
        $query -> bindValue(':id', $id);
        $query -> execute();
        $donnees = $query -> fetch(PDO::FETCH_ASSOC);

        return new Personnage($donnees);
    }
    public function deletePersonnage(Personnage $perso)
    {
    
        $queryimage = $this->db->prepare("SELECT image FROM personnages WHERE id = :id");
        $queryimage->bindValue(':id', $perso->getId()); 
        $queryimage->execute();
    
        $result = $queryimage->fetch(PDO::FETCH_ASSOC);
        $profilePic = $result['image'];
    
        if ($profilePic && file_exists($profilePic)) {
                unlink($profilePic);
        }
    
        $query = $this->db->prepare('DELETE FROM personnages WHERE id = :id');
        $query->bindValue(':id', $perso->getId()); 
        $query->execute();
    }
    
    public function uploadImage($file, $newName)
    {
        $target_dir = "uploads/";
        $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $target_file = $target_dir . $newName . "_tank." . $imageFileType;
        $uploadOk = 1;

        if ($file["error"] !== UPLOAD_ERR_OK) {
            $_SESSION['logimg'] = "Erreur lors du téléchargement du fichier.";
            return false;
        }
        // verifie si l'image est une image réelle ou une fausse image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['logimg'] = "Le fichier n'est pas une image.";
            $uploadOk = 0;
        }

        // verifie si l'image existe déjà
        if (file_exists($target_file)) {
            $_SESSION['logimg'] = "Désolé, le fichier existe déjà.";
            $uploadOk = 0;
        }

        // vérifie si la taille de l'image est trop grande
        if ($file["size"] > 100000) {
            $_SESSION['logimg'] = "Désolé, votre fichier est trop volumineux.";
            $uploadOk = 0;
        }

        // limite les types de fichiers autorisés
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['logimg'] = "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }
        // si tout est ok, on upload le fichier
        if ($uploadOk && move_uploaded_file($file["tmp_name"], $target_file)) {
            return $target_file;
        } else {
            $target_file = null;
        }
    }
}
?>
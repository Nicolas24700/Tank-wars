<?php

class Personnage
{
    private $id;
    private $nom;
    private $pv;
    private $atk;

    private $image;
    public const MAXpv = 100;
    private static $compteur = 0;

    // GETTERS =======================================

    public static function afficheCompteur()
    {
        return self::$compteur;
    }

    public function getpv()
    {
        return $this->pv;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAtk()
    {
        return $this->atk;
    }
    public function getNom()
    {
        return $this->nom;
    }
    public function getImage(){
        return $this->image;
    }

    // SETTERS ==================================================

    public function setpv($pv)
    {
        $this->pv = $pv;
        if ($pv < 0) {
            $this->pv = 0;
        }
        if ($pv > self::MAXpv) {
            $this->pv = self::MAXpv;
        }
    }
    public function setAtk($atk)
    {
        $this->atk = $atk;
        if ($atk < 0){
            $this->atk = 5;
        } 
    }
    public function setId($id)
    {
        return $this->id = $id;
    }
    public function setNom($nom)
    {
        return $this->nom = $nom;
    }
    public function setImage($image){
        return $this->image = $image;
    }
    // ==========================================
    public function __construct($donnees)
    {
        $this->hydrate($donnees);
        self::$compteur++;
    }   

    public function reinitPv()
    {
        $this->pv = self::MAXpv;
    }
    public function regen(){
        // on regen un nombre aléatoire de pv entre 5 et 20
        $rdn = rand(5, 20);
        if ($this->pv >= self::MAXpv){
            $this->pv = self::MAXpv;
            return " $this->nom a déjà toute sa santé !";
        } else {
            $this->pv += $rdn;
            return " $this->nom s'est regen de " . $rdn ." !";
        }
    }
    public function attaque(Personnage $cible)
    {
        $cible->pv -= $this->atk;
        return $this->nom . " inflige " . $this->atk . " de dégats à " . $cible->nom . " !";
    }

    private function hydrate($donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
?>
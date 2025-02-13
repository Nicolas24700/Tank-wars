<?php
$db = new PDO('mysql:host=localhost;dbname=poo_sgbd', 'root', '');

function chargerClasse($classe)
{
    require 'class/' . $classe . '.php';
}

spl_autoload_register('chargerClasse');
$monManager = new PersonnageManager($db);

?>
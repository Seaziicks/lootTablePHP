<?php

// Sous WAMP (Windows)

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=u418341279_lootTable;charset=utf8mb4', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}

catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}
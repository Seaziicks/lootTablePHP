<?php

// Sous WAMP (Windows)

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=u418341279_lootTable;charset=utf8', 'root', '');
}

catch(Exception $e)
{
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}
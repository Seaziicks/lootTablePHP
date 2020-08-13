<?php
/// Librairies éventuelles (pour la connexion à la BDD, etc.)
include('../db.php');

/// Paramétrage de l'entête HTTP (pour la réponse au Client)
header("Content-Type:application/json");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];
switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (!empty($_GET['idPersonnage']) && (empty($_GET['details']) || !filter_var($_GET['details'],FILTER_VALIDATE_BOOLEAN))) {
            $statistiqueQuery = $bdd->query('SELECT *
					from monte 
                    where idPersonnage='.$_GET['idPersonnage']);

            // Prepare le tableau de statistique, en mettant toutes les valeurs à 0.
            for($i = 1 ; $i <= $bdd->query('SELECT count(*) from statistique')->fetch()[0] ; $i++ ) {
                $statistiques[$i] = 0;
            }
            while($statistiqueFetched = $statistiqueQuery->fetch(PDO::FETCH_ASSOC)) {
                $statistiques[$statistiqueFetched['idStatistique']] += $statistiqueFetched['valeur'];
            }

            $matchingData = $statistiques;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Vous désirez consulter votre compte en statistique ?", $matchingData);
        } elseif (!empty($_GET['idPersonnage']) && !empty($_GET['details']) &&filter_var($_GET['details'],FILTER_VALIDATE_BOOLEAN)) {
            $statistiqueQuery = $bdd->query('SELECT *
					from monte 
                    where idPersonnage='.$_GET['idPersonnage']);
            $statistiques = [];
            while($statistiqueFetched = $statistiqueQuery->fetch(PDO::FETCH_ASSOC)) {
                if(empty($statistiques[$statistiqueFetched['niveau']]))
                    for($i = 1 ; $i < 8 ; $i++)
                        $statistiques[$statistiqueFetched['niveau']][$i] = 0;
                $statistiques[$statistiqueFetched['niveau']][$statistiqueFetched['idStatistique']] = intval($statistiqueFetched['valeur']);
            }

            $matchingData = $statistiques;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Oh je vois que monsieur est un connaisseur ! Voici toutes les transactions sur vos statistiques.", $matchingData);
        }

        break;

    case "POST":
        if (!(empty($_POST['idPersonnage']) || empty($_POST['idStatistique']) ||empty($_POST['niveau']))) {
            try {
                $sql = "INSERT INTO monte (idPersonnage, idStatistique, niveau, valeur)
                VALUES (" . $_POST['idPersonnage'] . ", " . $_POST['idStatistique'] . ",
                 " . $_POST['niveau'] . ", " . $_POST['valeur'] . ")";


                $bdd->exec($sql);
                $result = $bdd->query("SELECT *
					FROM monte 
                    WHERE idPersonnage = " . $_POST['idPersonnage'] . " AND idStatistique = " . $_POST['idStatistique'] . "
                    AND niveau = " . $_POST['niveau']);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "monte added", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "monte add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        deliver_responseRest(400, "monte add error, missing idPersonnag or idStatistique or niveau", $sql . "<br>" . $e->getMessage());
        break;

    case "PUT":
        if (!(empty($_PUT['idPersonnage']) || empty($_PUT['idStatistique']) ||empty($_PUT['niveau']))) {
            try {
                $sql = "UPDATE monte 
                SET valeur = '" . $_PUT['valeur'] . "', 
                WHERE idPersonnage = " . $_PUT['idPersonnage'] . " AND idStatistique = " . $_PUT['idStatistique'] . "
                AND niveau = " . $_PUT['niveau'];


                $bdd->exec($sql);
                $result = $bdd->query("SELECT *
					FROM monte 
                    WHERE idPersonnage = " . $_PUT['idPersonnage'] . " AND idStatistique = " . $_PUT['idStatistique'] . "
                    AND niveau = " . $_PUT['niveau']);
                $result->closeCursor();
                $bdd = null;
                http_response_code(200);
                deliver_responseRest(200, "monte modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "monte modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        deliver_responseRest(400, "monte modification error, missing idPersonnag or idStatistique or niveau", $sql . "<br>" . $e->getMessage());
        break;
}
/// Envoi de la réponse au Client
function deliver_responseRest($status, $status_message, $data)
{
    /// Paramétrage de l'entête HTTP, suite
    // header("HTTP/1.1 $status $status_message");
/// Paramétrage de la réponse retournée
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
/// Mapping de la réponse au format JSON
    $json_response = json_encode($response);
    echo $json_response;
}

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
        if (!empty($_GET['idPersonnage'])) {
            $personnageQuery = $bdd->query('SELECT *
					from personnage 
                    where idPersonnage ='.$_GET['idPersonnage']);

            $personnage =  $personnageQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $personnage;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Bien le bonjour, voyageur. Je vous envoie un de mes meilleurs soldats !", $matchingData);
        }
        break;

    case "POST":
        if (!(empty($_POST['idPersonnage']))) {
            try {
                $sql = "UPDATE personnage 
                SET nom = '" . $_POST['nom'] . "', 
                niveau = '" . $_POST['niveau'] . "', 
                WHERE idPersonnage = " . $_POST['idPersonnage'];


                $bdd->exec($sql);
                $result = $bdd->query('SELECT *
					from personnage
                    where idPersonnage='.$_GET['idPersonnage']);
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "personnage modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "personnage modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        deliver_responseRest(400, "personnage modification error, missing idPersonnage", $sql . "<br>" . $e->getMessage());
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

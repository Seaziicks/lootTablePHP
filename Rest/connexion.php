<?php
/// Librairies éventuelles (pour la connexion à la BDD, etc.)
include('../db.php');

/// Paramétrage de l'entête HTTP (pour la réponse au Client)
header("Content-Type:application/json");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];
switch ($http_method) {
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['Connexion'])) {
            $user = json_decode($_GET['Connexion']);
            $sql = 'SELECT *
                    FROM user
                    WHERE username = :username
                    AND password = :password';

            $user->Username = strtolower($user->Username);
            $userQuery = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $userQuery->bindParam(':username', $user->Username, PDO::PARAM_STR);
            $userQuery->bindParam(':password', $user->Password, PDO::PARAM_STR);
            $userQuery->execute();
            $userFetched = $userQuery->fetch(PDO::FETCH_ASSOC);

            if (!$userFetched) {
                http_response_code(403);
                /// Envoi de la réponse au Client
                deliver_responseRest(403, "Désolé, connais pas !", '');
            } elseif ($userFetched) {
                $personnage = null;
                if($userFetched['idPersonnage']) {
                    $personnageQuery = $bdd->query('SELECT *
                                                    FROM personnage
                                                    WHERE idPersonnage = ' . $userFetched['idPersonnage']);
                    $personnage = $personnageQuery->fetch(PDO::FETCH_ASSOC);
                }
                $matchingData = [$userFetched, $personnage];
                http_response_code(200);
                /// Envoi de la réponse au Client
                deliver_responseRest(200, "Ah, mais je vous reconnais, vous êtes un habitué !", $matchingData);
            }
        }
        break;

    case "POST":
        break;
    case "PUT":
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




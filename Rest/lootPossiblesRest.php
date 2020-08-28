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
        $lootsQuery = $bdd->query('SELECT idLoot, libelle
                                             FROM loot
                                             ');
        $loot = [];
        while($lootsFetched=$lootsQuery->fetch(PDO::FETCH_ASSOC)){
            $lootsFetched['idLoot'] = $lootsFetched['idLoot'] == null ? null : intval($lootsFetched['idLoot']);
            array_push($loot, ['idLoot' => $lootsFetched['idLoot'], 'libelle' => $lootsFetched['libelle']]);
        }
        $matchingData = $loot;
        http_response_code(200);
        /// Envoi de la réponse au Client
        deliver_responseRest(200, "Voici le catalogue de ce que vous pourrez trouver chez nous.", $matchingData);
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

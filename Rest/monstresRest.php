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
        if (isset($_GET['withFamille']) && filter_var($_GET['withFamille'], FILTER_VALIDATE_BOOLEAN)) {
            $famillesQuery = $bdd->query('SELECT DISTINCT fm.* 
                                                    FROM famillemonstre as fm, monstre as m 
                                                    WHERE fm.idFamilleMonstre IN (Select DISTINCT idFamilleMonstre FROM monstre) 
                                                    ORDER BY fm.libelle');
            $familles = [];
            // Pour chaque famille, on crée un tableau avec le nom de la famille.
            while ($famillesFetched = $famillesQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($familles, ['Famille' => $famillesFetched['libelle'], 'Membres' => []]);
            }
            // On ajoute un array vide pour tous les monstres non repertoriés dans une famille
            array_push($familles, ['Famille' => '', 'Membres' => []]);

            $monstresQuery = $bdd->query('SELECT idMonstre, monstre.libelle, monstre.idFamilleMonstre, famillemonstre.libelle as famille
                                                    FROM monstre
                                                    LEFT JOIN famillemonstre -- Here!
                                                        ON famillemonstre.idFamilleMonstre = monstre.idFamilleMonstre');

            // Pour chaque monstre, si il a une famille, on l'ajoute dans le tableau de sa famille, sinon dans le tableau des non repertoriés
            while ($monstreFetched = $monstresQuery->fetch(PDO::FETCH_ASSOC)) {
                if (!empty($monstreFetched['famille'])) {
                    // On choisit les données à envoyer.
                    $newMembre = ['idMonstre' => intval($monstreFetched['idMonstre']), 'libelle' => $monstreFetched['libelle'], 'idFamilleMonstre' => intval($monstreFetched['idFamilleMonstre'])];
                    array_push($familles[array_search($monstreFetched['famille'], array_column($familles, 'Famille'))]['Membres'], $newMembre);
                } else {
                    array_push($familles[count($familles) - 1]['Membres'], ['idMonstre' => intval($monstreFetched['idMonstre']), 'libelle' => $monstreFetched['libelle']]);
                }
            }
            $matchingData = $familles;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Il est beau mon tableau, mieux qu'un Vincent van Gogh !", $matchingData);
        } else {
            $monstresQuery = $bdd->query('SELECT idMonstre, monstre.libelle, monstre.idFamilleMonstre, famillemonstre.libelle as famille
                                                    FROM monstre
                                                    LEFT JOIN famillemonstre -- Here!
                                                        ON famillemonstre.idFamilleMonstre = monstre.idFamilleMonstre');

            // Pour chaque monstre, si il a une famille, on l'ajoute dans le tableau de sa famille, sinon dans le tableau des non repertoriés
            $monstres = [];
            while ($monstreFetched = $monstresQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($monstres, $monstreFetched);
            }
            $matchingData = $monstres;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Il est beau mon tableau, mieux qu'un Vincent van Gogh !", $matchingData);
        }
        break;

    case "POST":
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




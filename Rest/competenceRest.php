<?php
declare(strict_types=1);
spl_autoload_register('chargerClasse');
session_start();
header("Content-Type:application/json");

/**
 * @param $classname
 */
function chargerClasse($classname)
{
    if (is_file('Poo/' . $classname . '.php'))
        require 'Poo/' . $classname . '.php';
    elseif (is_file('Poo/Manager/' . $classname . '.php'))
        require 'Poo/Manager/' . $classname . '.php';
    elseif (is_file('Poo/Classes/' . $classname . '.php'))
        require 'Poo/Classes/' . $classname . '.php';
}
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
        if (isset($_GET['idPersonnage'])) {
            $sql = 'SELECT *
                FROM competence
                WHERE idPersonnage = :idPersonnage
                ORDER BY idCompetenceParente';

            $competencesQuery = $bdd->prepare($sql);
            $competencesQuery->bindParam(':idPersonnage',$_GET['idPersonnage'], PDO::PARAM_INT);
            $competencesQuery->execute();

            $competencesPersonnage = [];
            while ($competenceFetched = $competencesQuery->fetch(PDO::FETCH_ASSOC)) {
                $competenceFetched['idCompetence'] = intval($competenceFetched['idCompetence']);
                $competenceFetched['idPersonnage'] = intval($competenceFetched['idPersonnage']);
                $competenceFetched['idCompetenceParente'] = $competenceFetched['idCompetenceParente'] ? intval($competenceFetched['idCompetenceParente']) : null;
                $competenceFetched['optionnelle'] = boolval($competenceFetched['optionnelle']);
                array_push($competencesPersonnage, $competenceFetched);
            }

            for ($i = 0 ; $i < count($competencesPersonnage); $i++) {
                $competencesPersonnage[$i]['children'] = [];
            }


            $preparedData = [];
            for ($i = 0 ; $i < count($competencesPersonnage); $i++) {
                if (empty($competencesPersonnage[$i]['idCompetenceParente'])) {
                    array_push($preparedData, $competencesPersonnage[$i]);
                }
            }

            for ($i = 0 ; $i < count($competencesPersonnage); $i++) {
                if (!empty($competencesPersonnage[$i]['idCompetenceParente'])) {
                    for ($j = 0 ; $j < count($preparedData); $j++) {
                        insertData($preparedData[$j], $competencesPersonnage[$i]);
                    }
                }
            }

            $matchingData = $preparedData;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "C'est tout ce qu'il sait faire, et saura faire. C'est décevant ....", $matchingData);

        }
        break;

    case "POST":
        echo "POST";
        break;
    case "PUT":
        echo "PUT";
        break;
    case "DELETE":
        echo "DELETE";
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

function insertData(&$parent, &$competence) {

    if ($parent['idCompetence'] === $competence['idCompetenceParente']) {
        array_push($parent['children'], $competence);
    } else {
        for ($i = 0 ; $i < count($parent['children']) ; $i++) {
            insertData($parent['children'][$i], $competence);
        }
    }
}

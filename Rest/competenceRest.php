<?php
declare(strict_types=1);
spl_autoload_register('chargerClasse');
session_start();

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
header("Content-Type:application/json; charset=UTF-8");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];

switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['idPersonnage'])) {

            $CompetenceManager = new CompetenceManager($bdd);
            $preparedData = $CompetenceManager->getCompetencesForPersonnage($_GET['idPersonnage']);

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
        if (!UserManager::hasRightToAccess(AccessRights::GAME_MASTER)) {
            http_response_code(403);
            deliver_responseRest(403, "Accès non authorisé, vous n'avez pas les droits.", '');
        } else {
            if (isset($_GET['Competence'])) {
                $CompetenceManager = new CompetenceManager($bdd);
                $CompetenceManager->updateCompetence($_GET['Competence']);
                $fetchedResult = $CompetenceManager->getCompetence(json_decode($_GET['Competence'])->idCompetence);

                http_response_code(201);
                deliver_responseRest(201, "competence modified", $fetchedResult);

            } elseif (isset($_GET['CompetenceContenu'])) {
                // print_r($_GET['CompetenceContenu']);
                $competenceContenu = json_decode($_GET['CompetenceContenu'])->CompetenceContenu;
                // print_r($competenceContenu);

                $CompetenceContenuManager = new CompetenceContenuManager($bdd);
                $CompetenceContenuManager->updateCompetenceContenu($competenceContenu);
                $fetchedResult = $CompetenceContenuManager->getCompetenceContenu($competenceContenu->idCompetenceContenu);

                http_response_code(201);
                deliver_responseRest(201, "competence contenu modified", $fetchedResult);
            }
        }
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

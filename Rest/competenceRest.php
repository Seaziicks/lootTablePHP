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
            $sql = 'SELECT *
                FROM competence
                WHERE idPersonnage = :idPersonnage
                ORDER BY idCompetenceParente';

            $competencesQuery = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $competencesQuery->bindParam(':idPersonnage',$_GET['idPersonnage'], PDO::PARAM_INT);
            $competencesQuery->execute();

            $competencesPersonnage = [];
            while ($competenceFetched = $competencesQuery->fetch(PDO::FETCH_ASSOC)) {
                $competenceFetched['idCompetence'] = intval($competenceFetched['idCompetence']);
                $competenceFetched['idPersonnage'] = intval($competenceFetched['idPersonnage']);
                $competenceFetched['idCompetenceParente'] = $competenceFetched['idCompetenceParente'] ? intval($competenceFetched['idCompetenceParente']) : null;
                $competenceFetched['niveau'] = intval($competenceFetched['niveau']);
                $competenceFetched['optionnelle'] = boolval($competenceFetched['optionnelle']);
                $competenceFetched['etat'] = $competenceFetched['niveau'] > 0 ? 'selected' : 'locked';
                $competenceFetched['contenu'] = getCompetenceContenu($bdd, $competenceFetched['idCompetence']);
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
                        insertChildren($preparedData[$j], $competencesPersonnage[$i]);
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
        if (!UserManager::hasRightToAccess(AccessRights::GAME_MASTER)) {
            http_response_code(403);
            deliver_responseRest(403, "Accès non authorisé, vous n'avez pas les droits.", '');
        } else {
            if (isset($_GET['Competence'])) {
                $competence = json_decode($_GET['Competence'])->Competence;
                $sql = "UPDATE competence 
                SET idPersonnage = :idPersonnage, idCompetenceParente = :idCompetenceParente, titre = :titre, niveau = :niveau,
                icone = :icone, etat = :etat, optionnelle = :optionnelle
                WHERE idCompetence = :idCompetence;";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idCompetence', $competence->idCompetence, PDO::PARAM_INT);
                $commit->bindParam(':idPersonnage', $competence->idPersonnage, PDO::PARAM_INT);
                $commit->bindParam(':idCompetenceParente', $competence->idCompetenceParente, PDO::PARAM_INT);
                $commit->bindParam(':titre', $competence->titre, PDO::PARAM_STR);
                $commit->bindParam(':niveau', $competence->niveau, PDO::PARAM_INT);
                $commit->bindParam(':icone', $competence->icone, PDO::PARAM_STR);
                $commit->bindParam(':etat', $competence->etat, PDO::PARAM_STR);
                $commit->bindParam(':optionnelle', $competence->optionnelle, PDO::PARAM_BOOL);
                $commit->execute();

                // $commit->debugDumpParams();

                foreach ($competence->contenu as $contenu) {
                    updateCompetenceContenu($bdd, $contenu);
                }

                $fetchedResult = getCompetence($bdd, $competence->idCompetence);
                $bdd = null;

            } elseif (isset($_GET['CompetenceContenu'])) {
                print_r($_GET['CompetenceContenu']);
                $competenceContenu = json_decode($_GET['CompetenceContenu'])->CompetenceContenu;
                print_r($competenceContenu);

                updateCompetenceContenu($bdd, $competenceContenu);

                $sql = 'SELECT *
                FROM competencecontenu
                WHERE idCompetenceContenu = :idCompetenceContenu';

                $competenceContenuQuery = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $competenceContenuQuery->bindParam(':idCompetenceContenu', $competenceContenu->idCompetenceContenu, PDO::PARAM_INT);
                $competenceContenuQuery->execute();

                $competenceContenuFetched = $competenceContenuQuery->fetch(PDO::FETCH_ASSOC);
                $competenceContenuFetched['idCompetenceContenu'] = intval($competenceContenuFetched['idCompetenceContenu']);
                $competenceContenuFetched['idCompetence'] = intval($competenceContenuFetched['idCompetence']);
                $competenceContenuFetched['niveauCompetenceRequis'] = $competenceContenuFetched['niveauCompetenceRequis'] ? intval($competenceContenuFetched['idCompetenceParente']) : null;

                $fetchedResult = $competenceContenuFetched;
                $bdd = null;
            }
            http_response_code(201);
            deliver_responseRest(201, "competence modified", $fetchedResult);
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

function getCompetenceContenu(PDO $bdd, int $idCompetence) {
    $sql = 'SELECT * 
            FROM competencecontenu 
            WHERE idCompetence = :idCompetence
            ORDER BY niveauCompetenceRequis';

    $contenuQuery = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $contenuQuery->bindParam('idCompetence', $idCompetence, PDO::PARAM_INT);
    $contenuQuery->execute();

    $contenus = [];
    while ($contenuFetched = $contenuQuery->fetch(PDO::FETCH_ASSOC)) {
        $contenuFetched['idCompetenceContenu'] = intval($contenuFetched['idCompetenceContenu']);
        $contenuFetched['idCompetence'] = intval($contenuFetched['idCompetence']);
        $contenuFetched['niveauCompetenceRequis'] = $contenuFetched['niveauCompetenceRequis'] ? intval($contenuFetched['niveauCompetenceRequis']) : null;
        array_push($contenus, $contenuFetched);
    }

    return $contenus;
}

function insertChildren(&$parent, &$competence) {

    if ($parent['idCompetence'] === $competence['idCompetenceParente']) {
        array_push($parent['children'], $competence);
    } else {
        for ($i = 0 ; $i < count($parent['children']) ; $i++) {
            insertChildren($parent['children'][$i], $competence);
        }
    }
}

function updateCompetenceContenu(PDO $bdd, $competenceContenu) {
    $sql = "UPDATE competencecontenu 
                SET idCompetence = :idCompetence, niveauCompetenceRequis = :niveauCompetenceRequis, contenu = :contenu
                WHERE idCompetenceContenu = :idCompetenceContenu;";

    $test = 'Projette un jet de lave qui inflige 1D4 de dégâts + bonusIntelligence.';
    // print_r($competenceContenu->contenu);
    $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $commit->bindParam(':idCompetence', $competenceContenu->idCompetence, PDO::PARAM_INT);
    $commit->bindParam(':niveauCompetenceRequis', $competenceContenu->niveauCompetenceRequis, PDO::PARAM_INT);
    $commit->bindParam(':contenu', $competenceContenu->contenu, PDO::PARAM_STR);
    $commit->bindParam(':idCompetenceContenu', $competenceContenu->idCompetenceContenu, PDO::PARAM_INT);
    $commit->execute();

    // $commit->debugDumpParams();
}

function getCompetence(PDO $bdd, $idCompetence) {
    $sql = 'SELECT *
                FROM competence
                WHERE idCompetence = :idCompetence';

    $competencesQuery = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $competencesQuery->bindParam(':idCompetence',$idCompetence, PDO::PARAM_INT);
    $competencesQuery->execute();

    $competenceFetched = $competencesQuery->fetch(PDO::FETCH_ASSOC);
    $competenceFetched['idCompetence'] = intval($competenceFetched['idCompetence']);
    $competenceFetched['idPersonnage'] = intval($competenceFetched['idPersonnage']);
    $competenceFetched['idCompetenceParente'] = $competenceFetched['idCompetenceParente'] ? intval($competenceFetched['idCompetenceParente']) : null;
    $competenceFetched['niveau'] = intval($competenceFetched['niveau']);
    $competenceFetched['optionnelle'] = boolval($competenceFetched['optionnelle']);
    $competenceFetched['etat'] = $competenceFetched['niveau'] > 0 ? 'selected' : 'locked';
    $competenceFetched['contenu'] = getCompetenceContenu($bdd, $competenceFetched['idCompetence']);


    $competenceFetched['children'] = [];

    return $competenceFetched;
}

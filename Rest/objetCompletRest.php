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

$ObjetManager = new ObjetManager($bdd);

switch ($http_method) {
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['idObjet']) && isset($_GET['nameOnly']) && filter_var($_GET['nameOnly'], FILTER_VALIDATE_BOOLEAN)) {
            /// Récupération des critères de recherche envoyés par le Client
            $objetsQuery = $bdd->query('SELECT idObjet, idPersonnage, nom, fauxNom, afficherNom
                                                FROM objet
                                                WHERE idObjet = ' . $_GET['idObjet'] . '');

            $objet = $objetFetched=$objetsQuery->fetch(PDO::FETCH_ASSOC);
            $objet['idObjet'] = intval($objet['idObjet']);
            $objet['idPersonnage'] = intval($objet['idPersonnage']);
            $objet['afficherNom'] = boolval($objet['afficherNom']);

            $matchingData = $objet;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voici le nom que vous avez commandé.", $matchingData);
        } elseif (isset($_GET['idObjet'])) {
            $objet = $ObjetManager->getObjetAsNonJSonBis($_GET['idObjet']);

            $matchingData = $objet;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Je vous le fais à un prix d'ami !", $matchingData);
        } elseif (isset($_GET['idPersonnage']) && isset($_GET['idsOnly']) && filter_var($_GET['idsOnly'], FILTER_VALIDATE_BOOLEAN)) {
            /// Récupération des critères de recherche envoyés par le Client
            $objetsQuery = $bdd->query('SELECT idObjet
                                                FROM objet
                                                WHERE idPersonnage = ' . $_GET['idPersonnage'] . '');
            $ids = [];
            while($objetFetched=$objetsQuery->fetch(PDO::FETCH_ASSOC)){
                array_push($ids, intval($objetFetched['idObjet']));
            }
            $matchingData = $ids;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voici les identifiants de tous nos produits concernant cette référence.", $matchingData);

        } elseif (isset($_GET['idPersonnage']) && isset($_GET['namesOnly']) && filter_var($_GET['namesOnly'], FILTER_VALIDATE_BOOLEAN)) {
            /// Récupération des critères de recherche envoyés par le Client
            $objetsQuery = $bdd->query('SELECT idObjet, idPersonnage, nom, fauxNom, afficherNom
                                                FROM objet
                                                WHERE idPersonnage = ' . $_GET['idPersonnage'] . '');
            $names = [];
            while($objetFetched=$objetsQuery->fetch(PDO::FETCH_ASSOC)){
                array_push($names, ["idObjet" => intval($objetFetched['idObjet']), "idPersonnage" => intval($objetFetched['idPersonnage']),
                    "nom" => $objetFetched['nom'], "fauxNom" => $objetFetched['fauxNom'],
                    "afficherNom" => boolval($objetFetched['afficherNom'])]);
            }
            $matchingData = $names;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voici les identifiants de tous nos produits concernant cette référence.", $matchingData);

        } elseif (isset($_GET['idPersonnage'])) {

            /// Récupération des critères de recherche envoyés par le Client
            $objetsQuery = $bdd->query('SELECT idObjet
                                                FROM objet
                                                WHERE idPersonnage = ' . $_GET['idPersonnage'] . '');
            $objets = [];
            while($objetFetched=$objetsQuery->fetch(PDO::FETCH_ASSOC)){
                array_push($objets, $ObjetManager->getObjetAsNonJSon(intval($objetFetched['idObjet'])));
            }
            $matchingData = $objets;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voici le catalogue de ce que vous pourrez trouver chez nous pour cette référence.", $matchingData);

        }
        break;

    case "POST":
        if (!UserManager::hasRightToAccess(AccessRights::GAME_MASTER)) {
            http_response_code(403);
            deliver_responseRest(403, "Accès non authorisé, vous n'avez pas les droits.", '');
        } else {
            try {
                $objet = $ObjetManager->addCompleteObjet($_GET['Objet']);
                http_response_code(201);
                deliver_responseRest(201, "objet added", $objet);
            } catch (PDOException $e) {
                deliver_responseRest(400, "objet add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        break;
    case "PUT":
        if (!UserManager::hasRightToAccess(AccessRights::GAME_MASTER)) {
            http_response_code(403);
            deliver_responseRest(403, "Accès non authorisé, vous n'avez pas les droits.", '');
        } else {
            try {
                $objet = $ObjetManager->updateObjet($_GET['Objet']);
                http_response_code(201);
                deliver_responseRest(201, "objet modified", $objet);
            } catch (PDOException $e) {
                deliver_responseRest(400, "objet modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        break;
    case "DELETE":
        if (!UserManager::hasRightToAccess(AccessRights::GAME_MASTER)) {
            http_response_code(403);
            deliver_responseRest(403, "Accès non authorisé, vous n'avez pas les droits.", '');
        } else {
            try {
                $objet = json_decode($_GET['Objet'])->Objet;
                // print_r($objet);
                $rowCount = $ObjetManager->deleteObjet($objet->idObjet);

                if (!$rowCount) {
                    deliver_responseRest(400, "objet deletion fail", '');
                } else {
                    http_response_code(202);
                    deliver_responseRest(202, "objet deleted", '');
                }
            } catch (PDOException $e) {
                deliver_responseRest(400, "objet deletion error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
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




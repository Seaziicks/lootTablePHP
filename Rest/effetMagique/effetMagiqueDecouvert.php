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
    if (is_file('../Poo/' . $classname . '.php'))
        require '../Poo/' . $classname . '.php';
    elseif (is_file('../Poo/Manager/' . $classname . '.php'))
        require '../Poo/Manager/' . $classname . '.php';
    elseif (is_file('../Poo/Classes/' . $classname . '.php'))
        require '../Poo/Classes/' . $classname . '.php';
}
/// Librairies éventuelles (pour la connexion à la BDD, etc.)
include('../../db.php');

/// Paramétrage de l'entête HTTP (pour la réponse au Client)
header("Content-Type:application/json");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];
$EffetMagiqueDecouvertManager = new EffetMagiqueDecouvertManager($bdd);
switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (!empty($_GET['idObjet']) && !empty($_GET['idPersonnage']) && !empty($_GET['allDecouverts']) && filter_var($_GET['allDecouverts'], FILTER_VALIDATE_BOOLEAN)) {
            $matchingData = $EffetMagiqueDecouvertManager->getAllEffetMagiqueDecouvert(intval($_GET['idObjet']));
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "C'est ce que vous avez réussi à découvrir, jusqu'à présent.", $matchingData);
        } elseif (!empty($_GET['idObjet']) && !empty($_GET['idPersonnage'])) {
            $matchingData = $EffetMagiqueDecouvertManager->getEffetMagiqueDecouvert(intval($_GET['idObjet']), intval($_GET['idPersonnage']));
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Cela représente toutes les connaissances acsquises sur cet objet, jusqu'à présent.", $matchingData);
        }
        break;

    case "POST":
        try {
            $effetMagiqueDecouvert = json_decode($_GET['EffetMagiqueDecouvert'])->EffetMagiqueDecouvert;
            $effetAdded = $EffetMagiqueDecouvertManager->addEffetMagiqueDecouvert(json_encode($effetMagiqueDecouvert));

            http_response_code(201);
            deliver_responseRest(201, "Vous pensez en savoir plus sur cet objet maintenant, mais est-ce vrai ?", $effetAdded);
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueDecouvert add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        try {
            $effetMagiqueDecouvert = json_decode($_GET['EffetMagiqueDecouvert'])->EffetMagiqueDecouvert;
            $effetMagiqueDecouvertUpdated = $EffetMagiqueDecouvertManager->updateEffetMagiqueDecouvert(json_encode($effetMagiqueDecouvert));


            http_response_code(202);
            deliver_responseRest(202, "Ah ! Vous vous révisez ? Vous étiez pourtant si proche ... Tant pis !", $effetMagiqueDecouvertUpdated);
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueDecouvert modification error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case 'DELETE':
        try {
            $effetMagiqueDecouvert = json_decode($_GET['EffetMagiqueDecouvert'])->EffetMagiqueDecouvert;
            $rowCount = $EffetMagiqueDecouvertManager->deleteEffetMagiqueDecouvert($effetMagiqueDecouvert);

            if( ! $rowCount ) {
                deliver_responseRest(400, "effetMagiqueDecouvert deletion fail", '');
            } else {
                http_response_code(202);
                deliver_responseRest(202, "De toute façon, vous n'y comprenez rien ...", '');
            }
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueDecouvert deletion error in SQL", $sql . "<br>" . $e->getMessage());
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

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

$EffetMagiqueUlManager = new EffetMagiqueUlManager($bdd);

switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['idEffetMagiqueUl'])) {
            $effetMagiqueUl = $EffetMagiqueUlManager->getEffetMagiqueUl($_GET['idEffetMagiqueUl']);

            $matchingData = $effetMagiqueUl;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "effetMagiqueUl", $matchingData);
        } elseif (isset($_GET['idEffetMagique'])) {
            /// Récupération des critères de recherche envoyés par le Client
            $effetsMagiquesUl = $EffetMagiqueUlManager->getAllEffetMagiqueUlAsNotJSonBis($_GET['idEffetMagique']);
            $matchingData = $effetsMagiquesUl;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Multiple effetMagiqueUl", $matchingData);
        }
        break;

    case "POST":
        if(isset($_GET['EffetMagiqueUl'])) {
            try {
                $effetMagiqueUl = json_decode($_GET['EffetMagiqueUl'])->EffetMagiqueUl;
                $effetMagiqueUl->idEffetMagique = $_GET['idEffetMagique'];
                $effetMagiqueUlAdded = $EffetMagiqueUlManager->addEffetMagiqueUl(json_encode($effetMagiqueUl), $effetMagiqueUl->idEffetMagique);

                http_response_code(201);
                deliver_responseRest(201, "effetMagiqueUl added", $effetMagiqueUlAdded);
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagiqueUl add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        break;
    case "PUT":
        try {
            $effetMagiqueUl = json_decode($_GET['EffetMagiqueUl'])->EffetMagiqueUl;
            $effetMagiqueUlUpdated = $EffetMagiqueUlManager->updateEffetMagiqueUl(json_encode($effetMagiqueUl));


            http_response_code(202);
            deliver_responseRest(202, "effetMagiqueUl modified", $effetMagiqueUlUpdated);
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueUl modification error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case 'DELETE':
        try {
            $effetMagiqueUl = json_decode($_GET['EffetMagiqueUl'])->EffetMagiqueUl;
            $rowCount = $EffetMagiqueUlManager->deleteEffetMagiqueUl($effetMagiqueUl->idEffetMagiqueUl);

            if( ! $rowCount ) {
                deliver_responseRest(400, "effetMagiqueUl deletion fail", '');
            } else {
                http_response_code(202);
                deliver_responseRest(202, "effetMagiqueUl deleted", '');
            }
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueUl deletion error in SQL", $sql . "<br>" . $e->getMessage());
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

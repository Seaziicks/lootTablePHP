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

$EffetMagiqueTableTitleContentManager = new EffetMagiqueTableTitleContentManager($bdd);

switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['idEffetMagiqueTableTitleContent'])) {
            $effetMagiqueTableTitleContent = $EffetMagiqueTableTitleContentManager->getEffetMagiqueTableTitleContent($_GET['idEffetMagiqueTableTitleContent']);

            $matchingData = $effetMagiqueTableTitleContent;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "effetMagiqueTableTitleContent", $matchingData);
        }
        break;

    case "POST":
        if(isset($_GET['EffetMagiqueTableTitleContent'])) {
            try {
                $effetMagiqueTableTitleContent = json_decode($_GET['EffetMagiqueTableTitleContent'])->EffetMagiqueTableTitleContent;
                $effetMagiqueTableTitleContent->idEffetMagiqueTableTitle = $_GET['idEffetMagiqueTableTitle'];
                $effetMagiqueTableTitleContentAdded = $EffetMagiqueTableTitleContentManager->addEffetMagiqueTableTitleContent(json_encode($effetMagiqueTableTitleContent), $effetMagiqueTableTitleContent->idEffetMagiqueTableTitle);

                http_response_code(201);
                deliver_responseRest(201, "effetMagiqueTableTitleContent added", $effetMagiqueTableTitleContentAdded);
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagiqueTableTitleContent add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        break;
    case "PUT":
        try {
            $effetMagiqueTableTitleContent = json_decode($_GET['EffetMagiqueTableTitleContent'])->EffetMagiqueTableTitleContent;
            $effetMagiqueTableTitleContentUpdated = $EffetMagiqueTableTitleContentManager->updateEffetMagiqueTableTitleContent(json_encode($effetMagiqueTableTitleContent));


            http_response_code(202);
            deliver_responseRest(202, "effetMagiqueTableTitle modified", $effetMagiqueTableTitleContentUpdated);
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueTableTitle modification error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case 'DELETE':
        try {
            $effetMagiqueTableTitleContent = json_decode($_GET['EffetMagiqueTableTitleContent'])->EffetMagiqueTableTitleContent;
            $rowCount = $EffetMagiqueTableTitleContentManager->deleteEffetMagiqueTableTitleContent($effetMagiqueTableTitleContent->idEffetMagiqueTableTitleContent);

            if( ! $rowCount ) {
                deliver_responseRest(400, "effetMagiqueTableTitleContent deletion fail", '');
            } else {
                http_response_code(202);
                deliver_responseRest(202, "effetMagiqueTableTitleContent deleted", '');
            }
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueTableTitleContent deletion error in SQL", $sql . "<br>" . $e->getMessage());
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
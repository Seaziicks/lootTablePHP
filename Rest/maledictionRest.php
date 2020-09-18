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

$MaledictionManager = new MaledictionManager($bdd);

switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (!empty($_GET['idMalediction'])) {
            $maledictionQuery = $bdd->query('SELECT *
					FROM malediction 
                    where idMalediction='.$_GET['idMalediction']);

            $malediction =  $maledictionQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $malediction;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Je vous maudis !", $matchingData);
        }
        break;

    case "POST":
        try {
            $malediction = json_decode($_GET['Malediction']);
            $sql = "INSERT INTO `malediction` (`nom`,`description`) 
                                        VALUES (:nom, :description)";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':nom',$malediction->nom, PDO::PARAM_STR);
            $commit->bindParam(':description',$malediction->description, PDO::PARAM_STR);
            $commit->execute();
            $result = $bdd->query('SELECT *
					FROM malediction 
                    where idMalediction=' . $bdd->lastInsertId() . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "malediction added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "malediction add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!(empty($_GET['idMalediction']))) {
            try {
                $malediction = $MaledictionManager->updateMalediction($_GET['Malediction']);
                http_response_code(201);
                deliver_responseRest(201, "malediction modified", $malediction);
            } catch (PDOException $e) {
                deliver_responseRest(400, "malediction modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } else
            deliver_responseRest(400, "malediction modification error, missing idMalediction", '');
        break;
    case "DELETE":
        try {
            $malediction = json_decode($_GET['Malediction'])->Malediction;
            $rowCount = $MaledictionManager->deleteMalediction($malediction->idMalediction);

            if( ! $rowCount ) {
                deliver_responseRest(400, "malediction deletion fail", '');
            } else {
                http_response_code(202);
                deliver_responseRest(202, "malediction deleted", '');
            }
        } catch (PDOException $e) {
            deliver_responseRest(400, "malediction deletion error in SQL", $sql . "<br>" . $e->getMessage());
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

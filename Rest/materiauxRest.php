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
        if (isset($_GET['idMateriaux'])) {
            $materiauQuery = $bdd->query('SELECT *
                                                    FROM materiaux
                                                    WHERE idMateriaux = ' . $_GET['idMateriaux']);

            $materiauFetched = $materiauQuery->fetch(PDO::FETCH_ASSOC);
            $materiauData = $materiauFetched;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Vous aurez de quoi faire, avec pareil merveille !", $matchingData);
        } else {
            $materiauxQuery = $bdd->query('SELECT *
                                                    FROM materiaux');

            $materiaux = [];
            while ($materiauFetched = $materiauxQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($materiaux, $materiauFetched);
            }
            $matchingData = $materiaux;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voilà tout ce que vous pouvez avoir sous la main !", $matchingData);
        }
        break;

    case "POST":
        try {
            $materiau = json_decode($_GET['Materiau']);
            $sql = "INSERT INTO `materiaux` (`nom`,`effet`) VALUES (:nom, :effet)";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':nom',$materiau->nom, PDO::PARAM_STR);
            $commit->bindParam(':effet',$materiau->effet, PDO::PARAM_STR);
            $commit->execute();
            $result = $bdd->query('SELECT *
					from materiaux 
                    where idMateriaux=' . $bdd->lastInsertId() . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "materiau added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "materiau add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!empty($_GET['idMateriaux'])) {
            try {
                $materiau = json_decode($_GET['Materiau']);
                $sql = "UPDATE materiaux 
                SET nom = :nom, effet = :effet
                WHERE idMateriaux = :idMateriaux;";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idMateriaux',$materiau->idMateriaux, PDO::PARAM_INT);
                $commit->bindParam(':nom',$materiau->nom, PDO::PARAM_STR);
                $commit->bindParam(':effet',$materiau->effet, PDO::PARAM_STR);
                $commit->execute();

                $result = $bdd->query('SELECT *
					from materiaux
                    where idMateriaux=' . $materiau->idMateriaux . '
                    ');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "materiau modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "materiau modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
            break;
        }
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




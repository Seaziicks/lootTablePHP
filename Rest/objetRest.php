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
        if (isset($_GET['idObjet'])) {
            $objetQuery = $bdd->query('SELECT *
                                                    FROM objet
                                                    WHERE idObjet = ' . $_GET['idObjet']);

            $objetFetched = $objetQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $objetFetched;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Je vous le fais à un prix d'ami !", $matchingData);
        } else {
            $objetsQuery = $bdd->query('SELECT *
                                                    FROM objet');

            $objets = [];
            while ($objetFetched = $objetsQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($objets, $objetFetched);
            }
            $matchingData = $objets;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voilà tout ce que j'ai en stock.", $matchingData);
        }
        break;

    case "POST":
        try {
            $objet = $ObjetManager->addObjet($_GET['Objet']);

            http_response_code(201);
            deliver_responseRest(201, "objet added", $objet);
        } catch (PDOException $e) {
            deliver_responseRest(400, "objet add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!empty($_GET['idObjet']) && !empty($_GET['idMalediction'])) {
            $sql = "UPDATE objet 
                SET idMalediction = :idMalediction
                WHERE idObjet = :idObjet;";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idObjet',$_GET['idObjet'], PDO::PARAM_INT);
            $commit->bindParam(':idMalediction',$_GET['idMalediction'], PDO::PARAM_INT);
            $commit->execute();

            $result = $bdd->query('SELECT *
					FROM objet
                    where idObjet=' . $_GET['idObjet'] . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;
            http_response_code(201);
            deliver_responseRest(201, "objet malediction modified", $fetchedResult);
        } elseif (!empty($_GET['idObjet']) && !empty($_GET['idMateriaux'])) {
            $sql = "UPDATE objet 
                SET idMateriaux = :idMateriaux
                WHERE idObjet = :idObjet;";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idObjet',$_GET['idObjet'], PDO::PARAM_INT);
            $commit->bindParam(':idMalediction',$_GET['idMalediction'], PDO::PARAM_INT);
            $commit->execute();

            $result = $bdd->query('SELECT *
					FROM objet
                    where idObjet=' . $_GET['idObjet'] . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;
            http_response_code(201);
            deliver_responseRest(201, "objet materiau modified", $fetchedResult);
        }
        elseif (!empty($_GET['idObjet'])) {
            try {
                $objet = $ObjetManager->updateObjet($_GET['Objet']);
                http_response_code(201);
                deliver_responseRest(201, "$objet modified", $objet);
            } catch (PDOException $e) {
                deliver_responseRest(400, "$objet modification error in SQL", $sql . "<br>" . $e->getMessage());
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




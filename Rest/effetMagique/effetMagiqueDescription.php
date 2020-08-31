<?php
/// Librairies éventuelles (pour la connexion à la BDD, etc.)
include('../../db.php');

/// Paramétrage de l'entête HTTP (pour la réponse au Client)
header("Content-Type:application/json");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];
switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (!empty($_GET['idEffetMagiqueDescription'])) {
            $effetMagiqueDescriptionQuery = $bdd->query('SELECT *
					from effetMagiqueDescription 
                    where idEffetMagiqueDescription='.$_GET['idEffetMagiqueDescription']);

            $effetMagiqueDescription =  $effetMagiqueDescriptionQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $effetMagiqueDescription;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Rarf ...", $matchingData);
        }
        break;

    case "POST":
        try {
            $effetMagiqueDescriptionsInfos = json_decode($_GET['EffetMagiqueDescriptions']);
            $effetMagiqueDescriptions = json_decode($_GET['EffetMagiqueDescriptions'])->Descriptions;

            $idDescriptions = '';
            foreach ($effetMagiqueDescriptions as $description) {
                $sql = "INSERT INTO `effetMagiqueDescription` (`idEffetMagique`,`contenu`) 
                                        VALUES (:idEffetMagique, :contenu)";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idEffetMagique', $effetMagiqueDescriptionsInfos->idEffetMagique, PDO::PARAM_INT);
                $commit->bindParam(':contenu', $description, PDO::PARAM_STR);
                $commit->execute();
                $idDescriptions .= $bdd->lastInsertId();
                if ($description != $effetMagiqueDescriptions[count($effetMagiqueDescriptions) - 1]) {
                    $idDescriptions .= ", ";
                }
            }
            $result = $bdd->query('SELECT *
					from effetMagiqueDescription 
                    where idEffetMagiqueDescription in (' . $idDescriptions . ')
                    ');
            $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "multiple effetMagiqueDescription added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "multiple effetMagiqueDescription add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!(empty($_POST['idEffetMagiqueDescription']))) {
            try {
                $effetMagiqueDescription = json_decode($_GET['EffetMagiqueDescriptionManager']);
                $sql = "UPDATE effetMagiqueDescription 
                SET contenu = '" . $effetMagiqueDescription->contenu . "'
                WHERE idEffetMagiqueDescription = " . $effetMagiqueDescription->idEffetMagiqueDescription;


                $bdd->exec($sql);
                $result = $bdd->query('SELECT *
					from effetMagiqueDescription 
                    where idEffetMagiqueDescription='.$effetMagiqueDescription->idEffetMagiqueDescription);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "effetMagiqueDescription modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagiqueDescription modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        deliver_responseRest(400, "effetMagiqueDescription modification error, missing idEffetMagiqueDescription", $sql . "<br>" . $e->getMessage());
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

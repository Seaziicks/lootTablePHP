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
        if (!empty($_GET['idEffetMagiqueInfos'])) {
            $effetMagiqueInfosQuery = $bdd->query('SELECT *
					from effetMagiqueInfos 
                    where idEffetMagiqueInfos='.$_GET['idEffetMagiqueInfos']);

            $effetMagiqueInfos =  $effetMagiqueInfosQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $effetMagiqueInfos;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Rarf ...", $matchingData);
        }
        break;

    case "POST":
        try {
            $effetMagiqueInfosInfos = json_decode($_GET['EffetMagiqueInfos']);
            $effetMagiqueInfos = json_decode($_GET['EffetMagiqueInfos'])->Infos;

            $idInfos = '';
            foreach ($effetMagiqueInfos as $info) {
                $sql = "INSERT INTO `effetMagiqueInfos` (`idEffetMagique`,`contenu`) 
                                        VALUES (:idEffetMagique, :contenu)";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idEffetMagique', $effetMagiqueInfosInfos->idEffetMagique, PDO::PARAM_INT);
                $commit->bindParam(':contenu', $info, PDO::PARAM_STR);
                $commit->execute();
                $idInfos .= $bdd->lastInsertId();
                if ($info != $effetMagiqueInfos[count($effetMagiqueInfos) - 1]) {
                    $idInfos .= ", ";
                }
            }
            print_r($idInfos);
            $result = $bdd->query('SELECT *
					from effetMagiqueInfos 
                    where idEffetMagiqueInfos in (' . $idInfos . ')
                    ');
            $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "effetMagiqueInfos added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueInfos add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!(empty($_POST['idEffetMagiqueInfos']))) {
            try {
                $effetMagiqueInfos = json_decode($_GET['EffetMagiqueInfos']);
                $sql = "UPDATE effetMagiqueInfos 
                SET contenu = '" . $effetMagiqueInfos->contenu . "'
                WHERE idEffetMagiqueInfos = " . $effetMagiqueInfos->idEffetMagiqueInfos;


                $bdd->exec($sql);
                $result = $bdd->query('SELECT *
					from effetMagiqueInfos 
                    where idEffetMagiqueInfos='.$effetMagiqueInfos->idEffetMagiqueInfos);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "effetMagiqueInfos modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagiqueInfos modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        deliver_responseRest(400, "effetMagiqueInfos modification error, missing idEffetMagiqueInfos", $sql . "<br>" . $e->getMessage());
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

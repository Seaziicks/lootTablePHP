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
        if (!empty($_GET['idEffetMagiqueUl'])) {
            $effetMagiqueUlsQuery = $bdd->query('SELECT *
					from effetmagiqueul 
                    where idEffetMagique='.$_GET['idEffetMagique']);

            $allUl = [];
            while ($effetMagiqueUl = $effetMagiqueUlsQuery->fetch(PDO::FETCH_ASSOC)) {
                $effetMagiqueUl['position'] = $effetMagiqueUl['position'] == null ? null : intval($effetMagiqueUl['position']);
                $ul['position'] = $effetMagiqueUl['position'];

                /* Récupération des lignes de la table */
                $effetMagiqueUlContentsQuery = $bdd->query('SELECT *
					from effetmagiqueulcontent
                    where idEffetMagiqueUl='.$effetMagiqueUl['idEffetMagiqueUl']);

                $li= [];
                while ($effetMagiqueUlContent = $effetMagiqueUlContentsQuery->fetch(PDO::FETCH_ASSOC)) {
                        array_push($li, $effetMagiqueUlTrContent['contenu']);
                }
                $ul['li'] = $li;

                array_push($allUl, $ul);
            }

            $matchingData = $allUl;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Vous savez ce que fait Ul ? Il tire des choses vers le haut avec effort. Eh bien oui, Ul hisse !", $matchingData);
        }
        break;

    case "POST":
        try {
            print_r(json_decode($_GET['EffetMagiqueUlManager'])->Ul);
            $effetMagiqueUl = json_decode($_GET['EffetMagiqueUlManager'])->Ul;
            $sql = "INSERT INTO `effetmagiqueul` (`idEffetMagique`,`position`) 
                    VALUES (:idEffetMagique, :position)";
            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idEffetMagique',$_GET['idEffetMagique'], PDO::PARAM_INT);
            $commit->bindParam(':position',$effetMagiqueUl->position, PDO::PARAM_INT);
            $commit->execute();
            $ulIndex = $bdd->lastInsertId();

            foreach($effetMagiqueUl->li as $li) {
                    $sql = "INSERT INTO `effetMagiqueUlContent` (`idEffetMagiqueUl`,`contenu`) 
                                        VALUES (:idEffetMagiqueUl, :contenu)";

                    $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $commit->bindParam(':idEffetMagiqueUl',$ulIndex, PDO::PARAM_INT);
                    $commit->bindParam(':contenu',$li, PDO::PARAM_STR);
                    $commit->execute();
            }

        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueTable add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
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

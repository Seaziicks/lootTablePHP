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
        if (!empty($_GET['idEffetMagique'])) {
            $effetMagiqueQuery = $bdd->query('SELECT *
					from effetmagique 
                    where idEffetMagique='.$_GET['idEffetMagique']);

            $effetMagique =  $effetMagiqueQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $effetMagique;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Un effet magique pour la une, un !", $matchingData);
        }
        break;

    case "POST":
        try {
            $effetMagique = json_decode($_GET['EffetMagique']);
            $sql = "INSERT INTO `effetmagique` (`idObjet`,`nom`) 
                                        VALUES (:idObjet, :nom)";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idObjet',$effetMagique->idObjet, PDO::PARAM_INT);
            $commit->bindParam(':nom',$effetMagique->nom, PDO::PARAM_STR);
            $commit->execute();
            $result = $bdd->query('SELECT *
					from effetmagique 
                    where idEffetMagique=' . $bdd->lastInsertId() . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "effetMagique added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagique add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!(empty($_GET['idEffetMagique']))) {
            try {
                $effetMagique = json_decode($_GET['EffetMagique']);
                $sql = "UPDATE effetmagique 
                SET idObjet = '" . $effetMagique->idObjet . "', 
                nom = '" . $effetMagique->nom . "', 
                WHERE idEffetMagique = " . $effetMagique->idEffetMagique;


                $bdd->exec($sql);
                $result = $bdd->query('SELECT *
					from effetmagique 
                    where idEffetMagique='.$effetMagique->idEffetMagique);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "effetMagique modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagique modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        deliver_responseRest(400, "effetMagique modification error, missing idEffetMagique", $sql . "<br>" . $e->getMessage());
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

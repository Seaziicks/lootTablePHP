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
        if (isset($_GET['idMonstre'])) {
            $monstreQuery = $bdd->query('SELECT *
                                                    FROM monstre
                                                    WHERE idMonstre = ' . $_GET['idMonstre']);

            $monstreFetched = $monstreQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $monstreFetched;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Vous recherchez des renseignement par rapport à cet individu ? Faîtes attention, il est peu fréquentable ...", $matchingData);
        } else {
            $monstresQuery = $bdd->query('SELECT *
                                                    FROM monstre');

            $monstres = [];
            while ($monstreFetched = $monstresQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($monstres, $monstreFetched);
            }
            $matchingData = $monstres;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "C'est pour un jeu des " . count($monstres) . " monstres ?", $matchingData);
        }
        break;

    case "POST":
        try {
            $monstre = json_decode($_GET['Monstre']);
            $sql = "INSERT INTO `monstre` (`idFamilleMonstre`,`libelle`) VALUES (".$monstre->idFamilleMonstre.", :libelle)";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':libelle',$monstre->libelle, PDO::PARAM_STR);
            $commit->execute();
            $result = $bdd->query('SELECT *
					FROM monstre 
                    where idMonstre=' . $bdd->lastInsertId() . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "monstre added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "monstre add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (isset($_GET['idMonstre'])) {
            try {
                $monstre = json_decode($_GET['Monstre']);
                $sql = "UPDATE monstre 
                SET idFamilleMonstre = :idFamilleMonstre,
                libelle = :libelle 
                WHERE idMonstre = :idMonstre;";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idMonstre',$monstre->idMonstre, PDO::PARAM_INT);
                $commit->bindParam(':idFamilleMonstre',$monstre->idFamilleMonstre, PDO::PARAM_INT);
                $commit->bindParam(':libelle',$monstre->libelle, PDO::PARAM_STR);
                $commit->execute();

                $result = $bdd->query('SELECT *
					FROM monstre
                    where idMonstre=' . $monstre->idMonstre . '
                    ');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "monstre modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "monstre modification error in SQL", $sql . "<br>" . $e->getMessage());
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




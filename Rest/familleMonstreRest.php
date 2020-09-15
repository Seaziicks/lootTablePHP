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
        if (isset($_GET['idFamille'])) {
            $familleQuery = $bdd->query('SELECT *
                                                    FROM famillemonstre
                                                    WHERE idFamilleMonstre = ' . $_GET['idFamille']);

            // Pour chaque monstre, si il a une famille, on l'ajoute dans le tableau de sa famille, sinon dans le tableau des non repertoriés
            $familleFetched = $familleQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $familleFetched;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Vous appartenez à cette famille ? Je vois un petit aire de ressemblance ...", $matchingData);
        } else {
            $famillesQuery = $bdd->query('SELECT *
                                                    FROM famillemonstre');

            // Pour chaque monstre, si il a une famille, on l'ajoute dans le tableau de sa famille, sinon dans le tableau des non repertoriés
            $familles = [];
            while ($familleFetched = $famillesQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($familles, $familleFetched);
            }
            $matchingData = $familles;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "C'est pour un jeu des " . count($familles) . " familles ?", $matchingData);
        }
        break;

    case "POST":
        try {
            $famille = json_decode($_GET['Famille']);
            $sql = "INSERT INTO `famillemonstre` (`libelle`) VALUES ('" . $famille->libelle . "')";

            $bdd->exec($sql);
            $result = $bdd->query('SELECT *
					from famillemonstre 
                    where idFamilleMonstre=' . $bdd->lastInsertId() . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "familleMonstre added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "familleMonstre add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!empty($_GET['idFamilleMonstre'])) {
            try {
                $famille = json_decode($_GET['Famille']);
                $sql = "UPDATE famillemonstre 
                SET libelle = :libelle 
                WHERE idFamilleMonstre = :idFamilleMonstre;";

                $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idFamilleMonstre',$famille->idFamilleMonstre, PDO::PARAM_INT);
                $commit->bindParam(':libelle',$famille->libelle, PDO::PARAM_STR);
                $commit->execute();

                $result = $bdd->query('SELECT *
					from famillemonstre
                    where idFamilleMonstre=' . $famille->idFamilleMonstre . '
                    ');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "familleMonstre modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "familleMonstre modification error in SQL", $sql . "<br>" . $e->getMessage());
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




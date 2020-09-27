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

switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['niveau'])) {
            $sql = 'SELECT *
                FROM progressionpersonnage
                WHERE niveau = :niveau';

            $progressionPersonnageNiveauQuery = $bdd->prepare($sql);
            $progressionPersonnageNiveauQuery->bindParam(':niveau',$_GET['niveau'], PDO::PARAM_INT);
            $progressionPersonnageNiveauQuery->execute();

            $progressionPersonnageNiveauFetched = $progressionPersonnageNiveauQuery->fetch(PDO::FETCH_ASSOC);
            $progressionPersonnageNiveauFetched['idProgressionPersonnage'] = $progressionPersonnageNiveauFetched['idProgressionPersonnage'] ? intval($progressionPersonnageNiveauFetched['idProgressionPersonnage']) : null;
            $progressionPersonnageNiveauFetched['niveau'] = intval($progressionPersonnageNiveauFetched['niveau']);
            $progressionPersonnageNiveauFetched['statistiques'] = boolval($progressionPersonnageNiveauFetched['statistiques']);
            $progressionPersonnageNiveauFetched['nombreStatistiques'] = intval($progressionPersonnageNiveauFetched['nombreStatistiques']);
            $progressionPersonnageNiveauFetched['pointCompetence'] = boolval($progressionPersonnageNiveauFetched['pointCompetence']);
            $progressionPersonnageNiveauFetched['nombrePointsCompetences'] = intval($progressionPersonnageNiveauFetched['nombrePointsCompetences']);

            $matchingData = $progressionPersonnageNiveauFetched;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voilà comment vous êtes sensé vous développer. C'est pas fameux.", $matchingData);

        } else {
            $progressionPersonnageQuery = $bdd->query('SELECT *
                FROM progressionpersonnage
                ORDER BY niveau DESC');

            $progressionPersonnage = [];
            while ($progressionPersonnageFetched = $progressionPersonnageQuery->fetch(PDO::FETCH_ASSOC)) {
                $progressionPersonnageFetched['idProgressionPersonnage'] = $progressionPersonnageFetched['idProgressionPersonnage'] ? intval($progressionPersonnageFetched['idProgressionPersonnage']) : null;
                $progressionPersonnageFetched['niveau'] = intval($progressionPersonnageFetched['niveau']);
                $progressionPersonnageFetched['statistiques'] = boolval($progressionPersonnageFetched['statistiques']);
                $progressionPersonnageFetched['nombreStatistiques'] = intval($progressionPersonnageFetched['nombreStatistiques']);
                $progressionPersonnageFetched['pointCompetence'] = boolval($progressionPersonnageFetched['pointCompetence']);
                $progressionPersonnageFetched['nombrePointsCompetences'] = intval($progressionPersonnageFetched['nombrePointsCompetences']);
                array_push($progressionPersonnage, $progressionPersonnageFetched);
            }
            $matchingData = $progressionPersonnage;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Vous avez devant vous le reste de votre vie.", $matchingData);
        }
        break;

    case "POST":
        $progression = json_decode($_GET['ProgressionPersonnage'])->ProgressionPersonnage;

        $sql = 'SELECT *
                FROM progressionpersonnage
                WHERE niveau = :niveau';

        $progressionPersonnageNiveauExistQuery = $bdd->prepare($sql);
        $progressionPersonnageNiveauExistQuery->bindParam(':niveau',$progression->niveau, PDO::PARAM_INT);
        $progressionPersonnageNiveauExistQuery->execute();

        if ($progressionPersonnageNiveauExistQuery->fetch()) {
            http_response_code(409);
            /// Envoi de la réponse au Client
            deliver_responseRest(409, "Cette progression est déjà définie.", '');
        } else {
            try {
                $sql = "INSERT INTO `progressionpersonnage` (`niveau`,`statistiques`,`nombreStatistiques`,`pointCompetence`,`nombrePointsCompetences`) 
                                        VALUES (:niveau, :statistiques, :nombreStatistiques, :pointCompetence, :nombrePointsCompetences)";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':niveau', $progression->niveau, PDO::PARAM_INT);
                $commit->bindParam(':statistiques', $progression->statistiques, PDO::PARAM_BOOL);
                $commit->bindParam(':nombreStatistiques', $progression->nombreStatistiques, PDO::PARAM_INT);
                $commit->bindParam(':pointCompetence', $progression->pointCompetence, PDO::PARAM_BOOL);
                $commit->bindParam(':nombrePointsCompetences', $progression->nombrePointsCompetences, PDO::PARAM_INT);
                $commit->execute();

                // $commit->debugDumpParams();

                $result = $bdd->query('SELECT *
					FROM progressionpersonnage 
                    where idProgressionPersonnage=' . $bdd->lastInsertId() . '
                    ');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;

                http_response_code(201);
                deliver_responseRest(201, "progression added", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "progression add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        break;
    case "PUT":
        if (isset($_GET['idProgressionPersonnage'])) {
            try {
                $progression = json_decode($_GET['ProgressionPersonnage'])->ProgressionPersonnage;
                $sql = "UPDATE progressionpersonnage 
                SET statistiques = :statistiques,
                nombreStatistiques = :nombreStatistiques,
                pointCompetence = :pointCompetence,
                nombrePointsCompetences = :nombrePointsCompetences
                WHERE niveau = :niveau";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                // $commit->bindParam(':idProgressionPersonnage',$progression->idProgressionPersonnage, PDO::PARAM_INT);
                $commit->bindParam(':niveau',$progression->niveau, PDO::PARAM_INT);
                $commit->bindParam(':statistiques',$progression->statistiques, PDO::PARAM_BOOL);
                $commit->bindParam(':nombreStatistiques',$progression->nombreStatistiques, PDO::PARAM_INT);
                $commit->bindParam(':pointCompetence',$progression->pointCompetence, PDO::PARAM_BOOL);
                $commit->bindParam(':nombrePointsCompetences',$progression->nombrePointsCompetences, PDO::PARAM_INT);
                $commit->execute();

                $result = $bdd->query('SELECT *
					FROM progressionpersonnage
                    where idProgressionPersonnage='.$progression->idProgressionPersonnage);
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "progression modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "progression modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } else
            deliver_responseRest(400, "progression modification error, missing idProgressionPersonnage", '');
        break;
    case "DELETE":
        try {
            $progression = json_decode($_GET['ProgressionPersonnage'])->ProgressionPersonnage;
            $commit = $bdd->prepare('DELETE FROM progressionpersonnage WHERE niveau = :niveau');
            $commit->bindParam(':niveau',$progression->niveau, PDO::PARAM_INT);
            $commit->execute();
            $rowCount = $commit->rowCount();

            if( ! $rowCount ) {
                deliver_responseRest(400, "progression deletion fail", '');
            } else {
                http_response_code(202);
                deliver_responseRest(202, "progression deleted", '');
            }
        } catch (PDOException $e) {
            deliver_responseRest(400, "progression deletion error in SQL", $sql . "<br>" . $e->getMessage());
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

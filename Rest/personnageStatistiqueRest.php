<?php
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
        if (isset($_GET['idPersonnage']) && (empty($_GET['details']) || !filter_var($_GET['details'],FILTER_VALIDATE_BOOLEAN))) {
            /**
             * Permet de récupérer les statistiques agglomérées pour un personnage.
             */
            $statistiqueQuery = $bdd->query('SELECT s.libelle, m.niveau, m.valeur
            FROM monte as m, statistique as s
            WHERE idPersonnage='.$_GET['idPersonnage'].'
            AND m.idStatistique = s.idStatistique
            ORDER BY m.idStatistique');
            $statistiquesNameQuery = $bdd->query('SELECT * FROM statistique');
            $statistiquesNames = $statistiquesNameQuery->fetchAll(PDO::FETCH_ASSOC);
            // $statistiquesTest[array_search($statistiqueFetched['idStatistique'], array_column($statistiquesTest, 'idStatistique'))]
            $statistiques = [];
            // Prepare le tableau de statistique, en mettant toutes les valeurs à 0.
            foreach($statistiquesNames as $statistiqueName) {
                $statistiques[$statistiqueName['libelle']] = 0;
            }
            while($statistiqueFetched = $statistiqueQuery->fetch(PDO::FETCH_ASSOC)) {
                $statistiques[$statistiqueFetched['libelle']] += $statistiqueFetched['valeur'];
            }
            /**
             * Ancienne manière de faire, quand je faisais une requête SQL non raffinnée. Complexe, mais complètement con.

            $statistiqueQuery = $bdd->query('SELECT *
            FROM monte
            where idPersonnage='.$_GET['idPersonnage']);

            while($statistiqueFetched = $statistiqueQuery->fetch(PDO::FETCH_ASSOC)) {
                $currentStatistiqueName = $statistiquesNames[array_search($statistiqueFetched['idStatistique'], array_column($statistiquesNames, 'idStatistique'))]['libelle'];
                $statistiques[$currentStatistiqueName] += $statistiqueFetched['valeur'];
            }
            */

            $matchingData = $statistiques;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Vous désirez consulter votre compte en statistique ?", $matchingData);
        } elseif (isset($_GET['idPersonnage']) && isset($_GET['details']) && filter_var($_GET['details'],FILTER_VALIDATE_BOOLEAN)) {
            /**
             * Permet de récupérer les statistiques niveau par niveau, pour voir les points investis à chaque niveau.
             */
            $statistiquesNameQuery = $bdd->query('SELECT * FROM statistique');
            $statistiquesNames = $statistiquesNameQuery->fetchAll(PDO::FETCH_ASSOC);

            $statistiqueQuery = $bdd->query('SELECT s.libelle, m.niveau, m.valeur
					FROM monte as m, statistique as s
                    WHERE idPersonnage = '.$_GET['idPersonnage'].'
                    AND m.idStatistique = s.idStatistique
                    ORDER BY niveau DESC, m.idStatistique');

            $statistiques = [];
            $statistique = [];
            $niveauCourant = null;

            while($statistiqueFetched = $statistiqueQuery->fetch(PDO::FETCH_ASSOC)) {
                if (intval($statistiqueFetched['niveau']) !== $niveauCourant) {
                    if ($statistique)
                        array_push($statistiques, $statistique);
                    $statistique = [];
                    $niveauCourant = intval($statistiqueFetched['niveau']);
                    $statistique['niveau'] = $niveauCourant;
                    foreach ($statistiquesNames as $statistiqueName) {
                        $statistique[$statistiqueName['libelle']] = 0;
                    }
                }
                // $currentStatistiqueName = $statistiquesNames[array_search($statistiqueFetched['idStatistique'], array_column($statistiquesNames, 'idStatistique'))]['libelle'];
                $statistique[$statistiqueFetched['libelle']] = intval($statistiqueFetched['valeur']);
            }
            if (!array_search($statistique, $statistiques))
                array_push($statistiques, $statistique);

/*
            for ($i = 0 ; $i < count($statistiques); $i++) {
                $statistiques[$i]['vitalite'] += $statistiques[$i]['vitaliteNaturelle'] + $statistiques[$i]['deVitalite'];
                $statistiques[$i]['mana'] += $statistiques[$i]['manaNaturel'] + $statistiques[$i]['deMana'];
                unset($statistiques[$i]['vitaliteNaturelle']);
                unset($statistiques[$i]['deVitalite']);
                unset($statistiques[$i]['manaNaturel']);
                unset($statistiques[$i]['deMana']);
            }
*/

            $matchingData = $statistiques;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Oh je vois que monsieur est un connaisseur ! Voici toutes les transactions sur vos statistiques.", $matchingData);
        }

        break;

    case "POST":
        if (!UserManager::hasRightToAccess(AccessRights::SAME_USER)) {
            http_response_code(403);
            deliver_responseRest(403, "Accès non authorisé, vous n'avez pas les droits.", '');
        } else {
            if (!(empty($_GET['idPersonnage']) || empty($_GET['idStatistique']) || empty($_GET['niveau']))) {
                /**
                 * Ajout d'une ligne de statistique, lors de la montée de niveau
                 */
                try {
                    $sql = "INSERT INTO monte (idPersonnage, idStatistique, niveau, valeur)
                VALUES (" . $_GET['idPersonnage'] . ", " . $_GET['idStatistique'] . ",
                 " . $_GET['niveau'] . ", " . $_GET['valeur'] . ")";


                    $bdd->exec($sql);
                    $result = $bdd->query("SELECT *
					FROM monte 
                    WHERE idPersonnage = " . $_GET['idPersonnage'] . " AND idStatistique = " . $_GET['idStatistique'] . "
                    AND niveau = " . $_GET['niveau']);
                    $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                    $result->closeCursor();
                    $bdd = null;
                    http_response_code(201);
                    deliver_responseRest(201, "monte added", $fetchedResult);
                } catch (PDOException $e) {
                    deliver_responseRest(400, "monte add error in SQL", $sql . "<br>" . $e->getMessage());
                }
            }
            deliver_responseRest(400, "monte add error, missing idPersonnag or idStatistique or niveau", $sql . "<br>" . $e->getMessage());
        }
        break;

    case "PUT":
        if (!UserManager::hasRightToAccess(AccessRights::GAME_MASTER)) {
            http_response_code(403);
            deliver_responseRest(403, "Accès non authorisé, vous n'avez pas les droits.", '');
        } else {
            if (!(empty($_GET['idPersonnage']) || empty($_GET['idStatistique']) || empty($_GET['niveau']))) {
                /**
                 * Modification d'une ligne de statistique.
                 */
                try {
                    $sql = "UPDATE monte 
                SET valeur = :valeur 
                WHERE idPersonnage = :idPersonnage 
                AND idStatistique = :idStatistique 
                AND niveau = :niveau";

                    $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $commit->bindParam(':idPersonnage', $_GET['idPersonnage'], PDO::PARAM_INT);
                    $commit->bindParam(':idStatistique', $_GET['idStatistique'], PDO::PARAM_INT);
                    $commit->bindParam(':niveau', $_GET['niveau'], PDO::PARAM_INT);
                    $commit->bindParam(':valeur', $_GET['valeur'], PDO::PARAM_INT);
                    $commit->execute();

                    $result = $bdd->query("SELECT *
					FROM monte 
                    WHERE idPersonnage = " . $_GET['idPersonnage'] . " AND idStatistique = " . $_GET['idStatistique'] . "
                    AND niveau = " . $_GET['niveau']);
                    $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                    $result->closeCursor();
                    $bdd = null;
                    http_response_code(200);
                    deliver_responseRest(200, "monte modified", $fetchedResult);
                } catch (PDOException $e) {
                    deliver_responseRest(400, "monte modification error in SQL", $sql . "<br>" . $e->getMessage());
                }
            }
            deliver_responseRest(400, "monte modification error, missing idPersonnag or idStatistique or niveau", $sql . "<br>" . $e->getMessage());
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

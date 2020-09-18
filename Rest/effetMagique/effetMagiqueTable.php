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
    if (is_file('../Poo/' . $classname . '.php'))
        require '../Poo/' . $classname . '.php';
    elseif (is_file('../Poo/Manager/' . $classname . '.php'))
        require '../Poo/Manager/' . $classname . '.php';
    elseif (is_file('../Poo/Classes/' . $classname . '.php'))
        require '../Poo/Classes/' . $classname . '.php';
}
/// Librairies éventuelles (pour la connexion à la BDD, etc.)
include('../../db.php');

/// Paramétrage de l'entête HTTP (pour la réponse au Client)
header("Content-Type:application/json");

/// Identification du type de méthode HTTP envoyée par le client
$http_method = $_SERVER['REQUEST_METHOD'];
$EffetMagiqueTableManager = new EffetMagiqueTableManager($bdd);
switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (!empty($_GET['idEffetMagiqueTable'])) {
            $effetMagiqueTablesQuery = $bdd->query('SELECT *
					FROM effetmagiquetable 
                    where idEffetMagique='.$_GET['idEffetMagique']);

            $allTables = [];
            while ($effetMagiqueTable = $effetMagiqueTablesQuery->fetch(PDO::FETCH_ASSOC)) {
                $effetMagiqueTable['position'] = $effetMagiqueTable['position'] == null ? null : intval($effetMagiqueTable['position']);
                $table['position'] = $effetMagiqueTable['position'];

                /* Récupération des titres de la table */
                $effetMagiqueTableTitlesQuery = $bdd->query('SELECT *
					FROM effetmagiquetabletitle 
                    where idEffetMagiqueTable='.$effetMagiqueTable['idEffetMagiqueTable']);

                $titles= [];
                while ($effetMagiqueTableTitle = $effetMagiqueTableTitlesQuery->fetch(PDO::FETCH_ASSOC)) {

                    $effetMagiqueTableTitleContensQuery = $bdd->query('SELECT *
					FROM effetmagiquetabletitlecontent 
                    where idEffetMagiqueTableTitle='.$effetMagiqueTableTitle['idEffetMagiqueTableTitle']);

                    $title= [];
                    while ($effetMagiqueTableTitleContent = $effetMagiqueTableTitleContensQuery->fetch(PDO::FETCH_ASSOC)) {
                        array_push($title, $effetMagiqueTableTitleContent['contenu']);
                    }
                    array_push($titles, $title);
                }
                $table['title'] = $titles;

                /* Récupération des lignes de la table */
                $effetMagiqueTableTrsQuery = $bdd->query('SELECT *
					FROM effetmagiquetabletr
                    where idEffetMagiqueTable='.$effetMagiqueTable['idEffetMagiqueTable']);

                $trs= [];
                while ($effetMagiqueTableTr = $effetMagiqueTableTrsQuery->fetch(PDO::FETCH_ASSOC)) {

                    $effetMagiqueTableTrContensQuery = $bdd->query('SELECT *
					FROM effetmagiquetabletrcontent 
                    where idEffetMagiqueTableTr='.$effetMagiqueTableTr['idEffetMagiqueTableTr']);

                    $tr= [];
                    while ($effetMagiqueTableTrContent = $effetMagiqueTableTrContensQuery->fetch(PDO::FETCH_ASSOC)) {
                        array_push($tr, $effetMagiqueTableTrContent['contenu']);
                    }
                    array_push($trs, $tr);
                }
                $table['tr'] = $trs;

                array_push($allTables, $table);
            }

            $matchingData = $allTables;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Rarf ...", $matchingData);
        }
        break;

    case "POST":
        try {

            $effetMagiqueTable = json_decode($_GET['EffetMagiqueTable'])->Table;
            $sql = "INSERT INTO `effetmagiquetable` (`idEffetMagique`,`position`) 
                    VALUES (:idEffetMagique, :position)";
            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

            $commit->bindParam(':idEffetMagique',$_GET['idEffetMagique'], PDO::PARAM_INT);
            $commit->bindParam(':position',$effetMagiqueTable->position, PDO::PARAM_INT);
            $commit->execute();
            $tableIndex = $bdd->lastInsertId();
            foreach($effetMagiqueTable->title as $title) {
                $sql = "INSERT INTO `effetmagiquetabletitle` (`idEffetMagiqueTable`) 
                                        VALUES (:idEffetMagiqueTable)";
                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idEffetMagiqueTable', $tableIndex, PDO::PARAM_INT);
                $commit->execute();
                $tableTitleIndex = $bdd->lastInsertId();
                foreach ($title as $contenu) {
                    $sql = "INSERT INTO `effetmagiquetabletitlecontent` (`idEffetMagiqueTableTitle`,`contenu`) 
                                        VALUES (:idEffetMagiqueTableTitle, :contenu)";

                    $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $commit->bindParam(':idEffetMagiqueTableTitle',$tableTitleIndex, PDO::PARAM_INT);
                    $commit->bindParam(':contenu',$contenu, PDO::PARAM_STR);
                    $commit->execute();
                }

            }

            foreach($effetMagiqueTable->tr as $tr) {
                $sql = "INSERT INTO `effetmagiquetabletr` (`idEffetMagiqueTable`) 
                                        VALUES (:idEffetMagiqueTable)";
                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idEffetMagiqueTable', $tableIndex, PDO::PARAM_INT);
                $commit->execute();
                $tableTrIndex = $bdd->lastInsertId();
                foreach ($tr as $contenu) {
                    $sql = "INSERT INTO `effetmagiquetabletrcontent` (`idEffetMagiqueTableTr`,`contenu`) 
                                        VALUES (:idEffetMagiqueTableTr, :contenu)";

                    $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                    $commit->bindParam(':idEffetMagiqueTableTr',$tableTrIndex, PDO::PARAM_INT);
                    $commit->bindParam(':contenu',$contenu, PDO::PARAM_STR);
                    $commit->execute();
                }
            }

        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueTable add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        try {
            $effetMagiqueTable = json_decode($_GET['EffetMagiqueTable'])->EffetMagiqueTable;
            $effetMagiqueTableUpdated = $EffetMagiqueTableManager->updateEffetMagiqueTable(json_encode($effetMagiqueTable));


            http_response_code(202);
            deliver_responseRest(202, "effetMagiqueTable modified", $effetMagiqueTableUpdated);
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueTable modification error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case 'DELETE':
        try {
            $effetMagiqueTable = json_decode($_GET['EffetMagiqueTable'])->EffetMagiqueTable;
            $rowCount = $EffetMagiqueTableManager->deleteEffetMagiqueTable($effetMagiqueTable->idEffetMagiqueTable);

            if( ! $rowCount ) {
                deliver_responseRest(400, "effetMagiqueTable deletion fail", '');
            } else {
                http_response_code(202);
                deliver_responseRest(202, "effetMagiqueTable deleted", '');
            }
        } catch (PDOException $e) {
            deliver_responseRest(400, "effetMagiqueTable deletion error in SQL", $sql . "<br>" . $e->getMessage());
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

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

$EffetMagiqueManager = new EffetMagiqueManager($bdd);

switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['idEffetMagique'])) {
            $objet = $EffetMagiqueManager->getCompleteEffetMagiqueAsNotJson($_GET['idEffetMagique']);

            $matchingData = $objet;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Je vous fais de l'effet ? Vous trouvez ça magique ?", $matchingData);
        } elseif (isset($_GET['idObjet'])) {
            /// Récupération des critères de recherche envoyés par le Client
            $effetsMagiques = $EffetMagiqueManager->getAllEffetMagiqueForObjet($_GET['idObjet']);
            $matchingData = $effetsMagiques;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voici le catalogue de ce que vous pourrez trouver chez nous.", $matchingData);
        }
        break;

    case "POST":
        if(isset($_GET['EffetMagique'])) {
            try {
                $effetMagique = json_decode($_GET['EffetMagique'])->EffetMagique;
                $effetMagique->idObjet = $_GET['idObjet'];
                $effetMagiqueAdded = $EffetMagiqueManager->addEffetMagique(json_encode($effetMagique));
                $EffetMagiqueManager->addDescription(json_decode($_GET['EffetMagique'])->EffetMagique->description, $effetMagiqueAdded->_idEffetMagique);
                $EffetMagiqueManager->addInfos(json_decode($_GET['EffetMagique'])->EffetMagique->infos->data, $effetMagiqueAdded->_idEffetMagique);

                http_response_code(201);
                deliver_responseRest(201, "effetMagique added", $effetMagiqueAdded);
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagique add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } elseif (isset($_GET['EffetMagiqueTable']) && isset($_GET['idEffetMagique'])) {
            try {
                if (json_decode($_GET['EffetMagiqueTable'])->EffetMagiqueTable) {
                    $EffetMagiqueTableManager = new EffetMagiqueTableManager($bdd);
                    $tables = json_decode($_GET['EffetMagiqueTable'])->EffetMagiqueTable;
                    foreach ($tables as $tableToAdd) {
                        $table = new stdClass();
                        $table->Table = $tableToAdd;
                        $EffetMagiqueTableManager->addEffetMagiqueTable(json_encode($table), intval($_GET['idEffetMagique']));
                    }
                    // $EffetMagiqueManager->addTable(json_decode($_GET['EffetMagiqueTable']), $_GET['idEffetMagique']);
                    $effetsMagiquesTable = $EffetMagiqueTableManager->getAllEffetMagiqueTableAsNotJSon(intval($_GET['idEffetMagique']));

                    http_response_code(201);
                    deliver_responseRest(201, "effetMagiqueTable added", $effetsMagiquesTable);
                }
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagiqueTable add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } elseif (isset($_GET['EffetMagiqueUl']) && isset($_GET['idEffetMagique'])) {
            try {
                if (json_decode($_GET['EffetMagiqueUl'])->EffetMagiqueUl) {

                    $EffetMagiqueUlManager = new EffetMagiqueUlManager($bdd);

                    $uls = json_decode($_GET['EffetMagiqueUl'])->EffetMagiqueUl;
                    foreach ($uls as $ulToAdd) {
                        $ul = new stdClass();
                        $ul->Ul = $ulToAdd;
                        $EffetMagiqueUlManager->addCompleteEffetMagiqueUl(json_encode($ul), intval($_GET['idEffetMagique']));
                    }
                    // $EffetMagiqueManager->addUl(json_decode($_GET['EffetMagiqueUl']), $_GET['idEffetMagique']);

                    $effetsMagiquesUl = $EffetMagiqueUlManager->getAllEffetMagiqueUlAsNotJSon(intval($_GET['idEffetMagique']));

                    http_response_code(201);
                    deliver_responseRest(201, "effetMagiqueUl added", $effetsMagiquesUl);
                }
            } catch (PDOException $e) {
                deliver_responseRest(400, "effetMagiqueUl add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        }
        break;
    case "PUT":
        if (!(empty($_GET['idEffetMagique']))) {
            try {
                $effetMagique = json_decode($_GET['EffetMagique']);
                $sql = "UPDATE effetmagique 
                SET idObjet = '" . $effetMagique->idObjet . "', 
                title = '" . $effetMagique->title . "', 
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

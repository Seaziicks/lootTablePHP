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
        if (!empty($_GET['idMonstre'])) {
            try {

                $lootsQuery = $bdd->query('SELECT d.roll, d.idLoot, l.libelle, d.niveauMonstre, d.multiplier, d.diceNumber, d.dicePower, l.poids
					FROM dropchancebis AS d, loot AS l
                    WHERE idMonstre = ' . $_GET['idMonstre'] . '
                    AND l.idLoot = d.idLoot
                    ORDER BY roll');
                $loot = [];
                while ($lootsFetched = $lootsQuery->fetch(PDO::FETCH_ASSOC)) {
                    $lootsFetched['roll'] =$lootsFetched['roll'] == null ? null : intval($lootsFetched['roll']);
                    $lootsFetched['idLoot'] = $lootsFetched['idLoot'] == null ? null : intval($lootsFetched['idLoot']);
                    $lootsFetched['niveauMonstre'] = $lootsFetched['niveauMonstre'] == null ? null : intval($lootsFetched['niveauMonstre']);
                    $lootsFetched['multiplier'] = $lootsFetched['multiplier'] == null ? null : intval($lootsFetched['multiplier']);
                    $lootsFetched['diceNumber'] = $lootsFetched['diceNumber'] == null ? null : intval($lootsFetched['diceNumber']);
                    $lootsFetched['dicePower'] = $lootsFetched['dicePower'] == null ? null : intval($lootsFetched['dicePower']);
                    $lootsFetched['poids'] = $lootsFetched['poids'] == null ? null : intval($lootsFetched['poids']);
                    array_push($loot, $lootsFetched);
                }

                $matchingData = $loot;
                http_response_code(200);
                /// Envoi de la réponse au Client
                deliver_responseRest(200, "Veillez à vérifier que les chances de drop soient consécutives et disjointes.", $matchingData);
            } catch (PDOException $e) {
                deliver_responseRest(400, "dropChance get error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } else
            deliver_responseRest(400, "dropChance get error, missing idMonstre", '');
        break;

    case "POST":
        if (!(empty($_GET['idMonstre']) || empty($_GET['idLoot']))) {
            try {

                $params = json_decode($_GET['Loot']);
                $loot = $params->Loot[0];
                $sql = "INSERT INTO `dropchancebis` (`idMonstre`, `roll`, `idLoot`, `niveauMonstre`, `multiplier`, `diceNumber`, `dicePower`) 
                        VALUES (" . $params->idMonstre . ", " . $loot->roll . ", " . $loot->idLoot . ", NULL, " . $loot->multiplier . ", " . $loot->diceNumber . ", " . $loot->dicePower . ")";

                $bdd->exec($sql);
                $result = $bdd->query('SELECT d.roll, l.libelle, d.niveauMonstre, d.multiplier, d.diceNumber, d.dicePower, l.poids
					from dropchancebis as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    order by roll');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "dropChance added", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "dropChance add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } elseif (!(empty($_GET['idMonstre']) || empty($_GET['multipleInput'])) && filter_var($_GET['multipleInput'], FILTER_VALIDATE_BOOLEAN)) {

            $params = json_decode($_GET['Loot']);
            $sql = "INSERT INTO `dropchancebis` (`idMonstre`, `roll`, `idLoot`, `niveauMonstre`, `multiplier`, `diceNumber`, `dicePower`) VALUES ";
            $loots = $params->Loot;
            $rolls = '';
            foreach ($loots as $loot) {
                $sql .= "(" . $params->idMonstre . ", " . $loot->roll . ", " . $loot->idLoot . ", NULL, " . $loot->multiplier . ", " . $loot->diceNumber . ", " . $loot->dicePower . ")";
                $rolls .= $loot->roll;
                if ($loot != $loots[count($loots) - 1]) {
                    $sql .= ", ";
                    $rolls .= ", ";
                }
            }
            $sql .= ";";
            // print_r($sql);

            $bdd->exec($sql);
            $result = $bdd->query('SELECT d.roll, l.libelle, d.niveauMonstre, d.multiplier, d.diceNumber, d.dicePower, l.poids
					from dropchancebis as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    AND d.roll in (' . $rolls . ')
                    AND d.idLoot = l.idLoot
                    order by roll');
            $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "dropChance added", $fetchedResult);

        } else
            deliver_responseRest(400, "dropChance add error, missing idMonstre or idLoot, or missing idMonstre && multipleInput == true", '');
        break;
    case "PUT":
        if (!(empty($_GET['idMonstre']) || empty($_GET['idLoot']))) {
            try {

                $params = json_decode($_GET['Loot']);
                $loot = $params->Loot;
                $sql = "UPDATE dropchancebis 
                SET idLoot = " . $loot->idLoot . ",
                niveauMonstre = NULL, multiplier = " . $loot->multiplier . ",
                diceNumber = " . $loot->diceNumber . ", dicePower = " . $loot->dicePower . "
                WHERE idMonstre = " . $params->idMonstre . "
                AND roll = " . $loot->roll . ";";


                $bdd->exec($sql);
                $result = $bdd->query('SELECT d.roll, l.libelle, d.niveauMonstre, d.multiplier, d.diceNumber, d.dicePower, l.poids
					from dropchancebis as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    AND d.roll = ' . $loot->roll . '
                    AND d.idLoot = l.idLoot
                    order by roll');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "dropChance modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "dropChance modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } elseif (!(empty($_GET['idMonstre']) || empty($_GET['multipleInput'])) && filter_var($_GET['multipleInput'], FILTER_VALIDATE_BOOLEAN)) {
            try {
                $params = json_decode($_GET['Loot']);
                $loots = $params->Loot;

                $rolls = '';
                foreach ($loots as $loot) {
                    $loot->idLoot = $loot->idLoot ? $loot->idLoot : 'NULL';
                    $sql = "UPDATE dropchancebis 
                            SET idLoot = " . $loot->idLoot . ",
                            niveauMonstre = NULL, multiplier = " . $loot->multiplier . ",
                            diceNumber = " . $loot->diceNumber . ", dicePower = " . $loot->dicePower . "
                            WHERE idMonstre = " . $params->idMonstre . "
                            AND roll = " . $loot->roll . ";";

                    $rolls .= $loot->roll;
                    if ($loot != $loots[count($loots) - 1]) {
                        $rolls .= ", ";
                    }
                }

                $bdd->exec($sql);
                $result = $bdd->query('SELECT d.roll, l.libelle, d.niveauMonstre, d.multiplier, d.diceNumber, d.dicePower, l.poids
					from dropchancebis as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    AND d.roll in (' . $rolls . ')
                    AND d.idLoot = l.idLoot
                    order by roll');
                $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;

                http_response_code(201);
                deliver_responseRest(201, "dropChance modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "dropChance modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } else
            deliver_responseRest(400, "dropChance modification error, missing idMonstre or idLoot", '');
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

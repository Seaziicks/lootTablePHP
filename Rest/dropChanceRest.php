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

                $lootsQuery = $bdd->query('SELECT d.idLoot, l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					FROM dropchance AS d, loot AS l
                    WHERE idMonstre = ' . $_GET['idMonstre'] . '
                    AND l.idLoot = d.idLoot
                    ORDER BY minRoll');
                $loot = [];
                while ($lootsFetched = $lootsQuery->fetch(PDO::FETCH_ASSOC)) {
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
                $sql = "INSERT INTO `dropchance` (`idMonstre`, `idLoot`, `minRoll`, `maxRoll`, `niveauMonstre`, `multiplier`, `dicePower`) 
                        VALUES (" . $params->idMonstre . ", " . $loot->idLoot . ", " . $loot->minRoll . ", " . $loot->maxRoll . ", NULL, " . $loot->multiplier . ", " . $loot->dicePower . ")";

                $bdd->exec($sql);
                $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					FROM dropchance as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    order by minRoll');
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
            $sql = "INSERT INTO `dropchance` (`idMonstre`, `idLoot`, `minRoll`, `maxRoll`, `niveauMonstre`, `multiplier`, `dicePower`) VALUES ";
            $loots = $params->Loot;
            $idLoots = '';
            foreach ($loots as $loot) {
                $sql .= "(" . $params->idMonstre . ", " . $loot->idLoot . ", " . $loot->minRoll . ", " . $loot->maxRoll . ", NULL, " . $loot->multiplier . ", " . $loot->dicePower . ")";
                $idLoots .= $loot->idLoot;
                if ($loot != $loots[count($loots) - 1]) {
                    $sql .= ", ";
                    $idLoots .= ", ";
                }
            }
            $sql .= ";";

            $bdd->exec($sql);
            $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					FROM dropchance as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    AND d.idLoot in (' . $idLoots . ')
                    AND d.idLoot = l.idLoot
                    order by minRoll');
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
                $sql = "UPDATE dropchance 
                SET minRoll = :minRoll, maxRoll = :maxRoll,
                niveauMonstre = NULL, multiplier = :multiplier,
                dicePower =:dicePower 
                WHERE idMonstre = :idMonstre 
                AND idLoot = :idLoot;";

                $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idMonstre', $params->idMonstre, PDO::PARAM_INT);
                $commit->bindParam(':idLoot', $loot->idLoot, PDO::PARAM_INT);
                $commit->bindParam(':minRoll', $loot->minRoll, PDO::PARAM_INT);
                $commit->bindParam(':maxRoll', $loot->maxRoll, PDO::PARAM_INT);
                $commit->bindParam(':multiplier', $loot->multiplier, PDO::PARAM_INT);
                $commit->bindParam(':dicePower', $loot->dicePower, PDO::PARAM_INT);
                $commit->execute();

                $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					FROM dropchance as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    AND d.idLoot =' . $loot->idLoot . '
                    AND d.idLoot = l.idLoot
                    ');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "dropChance modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "dropChance modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } elseif (!(empty($_GET['idMonstre']) || empty($_GET['multipleInput'])) && filter_var($_GET['multipleInput'], FILTER_VALIDATE_BOOLEAN)) {

            $params = json_decode($_GET['Loot']);
            $loots = $params->Loot;
            $idLoots = '';
            foreach ($loots as $loot) {
                $sql = "UPDATE dropchance 
                SET minRoll = :minRoll, maxRoll = :maxRoll,
                niveauMonstre = NULL, multiplier = :multiplier,
                dicePower = :dicePower 
                WHERE idMonstre = :idMonstre 
                AND idLoot = :idLoot;";

                $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idMonstre', $params->idMonstre, PDO::PARAM_INT);
                $commit->bindParam(':idLoot', $loot->idLoot, PDO::PARAM_INT);
                $commit->bindParam(':minRoll', $loot->minRoll, PDO::PARAM_INT);
                $commit->bindParam(':maxRoll', $loot->maxRoll, PDO::PARAM_INT);
                $commit->bindParam(':multiplier', $loot->multiplier, PDO::PARAM_INT);
                $commit->bindParam(':dicePower', $loot->dicePower, PDO::PARAM_INT);
                $commit->execute();

                $idLoots .= $loot->idLoot;
                if ($loot != $loots[count($loots) - 1]) {
                    $idLoots .= ", ";
                }
            }

            $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					FROM dropchance as d, loot as l
                    where idMonstre=' . $params->idMonstre . '
                    AND d.idLoot in (' . $idLoots . ')
                    AND d.idLoot = l.idLoot
                    order by minRoll');
            $fetchedResult = $result->fetchAll(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "dropChance modified", $fetchedResult);

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

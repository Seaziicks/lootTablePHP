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
        if (!empty($_GET['idMonstre'])) {
            try {
            $lootsQuery = $bdd->query('SELECT d.idLoot, l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					FROM dropchance AS d, loot AS l
                    WHERE idMonstre = '. $_GET['idMonstre'] .'
                    AND l.idLoot = d.idLoot
                    ORDER BY minRoll');



            $loot = [];
            while($lootsFetched=$lootsQuery->fetch(PDO::FETCH_ASSOC)){
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
                $sql = "UPDATE dropchance 
                SET minRoll = " . $_GET['minRoll'] . ", maxRoll = " . $_GET['maxRoll'] . ",
                niveauMonstre = " . $_GET['niveauMonstre'] . ", multiplier = " . $_GET['multiplier'] . ",
                dicePower = " . $_GET['dicePower'] . "
                WHERE idMonstre = " . $_GET['idMonstre'] . "
                AND idLoot = " . $_GET['idLoot'];


                $bdd->exec($sql);
                $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					from dropchance as d, loot as l
                    where idMonstre='.$_GET['idMonstre'].'
                    order by minRoll');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "dropChance added", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "dropChance add error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } elseif (!(empty($_GET['idMonstre']) || empty($_GET['multipleInput'])) && filter_var($_GET['multipleInput'],FILTER_VALIDATE_BOOLEAN)) {
            $params = json_decode($_GET['Loot']);

            $sql = "INSERT INTO `dropchance` (`idMonstre`, `idLoot`, `minRoll`, `maxRoll`, `niveauMonstre`, `multiplier`, `dicePower`) VALUES ";

            $loots = $params->Loot;

            $idLoots = '';
            foreach($loots as $loot) {
                $sql .= "(" . $params->idMonstre .", " . $loot->idLoot .", " . $loot->minRoll .", " . $loot->maxRoll .", NULL, " . $loot->multiplier .", " . $loot->dicePower . ")";
                $idLoots .= $loot->idLoot;
                if($loot != $loots[count($loots) -1 ]) {
                    $sql .= ", ";
                    $idLoots .= ", ";
                }
            }
            $sql .= ";";

            $bdd->exec($sql);
            $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					from dropchance as d, loot as l
                    where idMonstre='.$params->idMonstre.'
                    AND d.idLoot in ('.$idLoots.')
                    AND d.idLoot = l.idLoot
                    order by minRoll');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
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
                $sql = "UPDATE dropchance 
                SET minRoll = " . $_GET['minRoll'] . ", maxRoll = " . $_GET['maxRoll'] . ",
                niveauMonstre = " . $_GET['niveauMonstre'] . ", multiplier = " . $_GET['multiplier'] . ",
                dicePower = " . $_GET['dicePower'] . "
                WHERE idMonstre = " . $_GET['idMonstre'] . "
                AND idLoot = " . $_GET['idLoot'];


                $bdd->exec($sql);
                $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					from dropchance as d, loot as l
                    where idMonstre='.$_GET['idMonstre'].'
                    order by minRoll');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "dropChance modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "dropChance modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } elseif (!(empty($_GET['idMonstre']) || empty($_GET['multipleInput'])) && filter_var($_GET['multipleInput'],FILTER_VALIDATE_BOOLEAN)) {
            $params = json_decode($_GET['Loot']);



            $loots = $params->Loot;

            $idLoots = '';
            foreach($loots as $loot) {
                $sql = "UPDATE dropchance 
                SET minRoll = " . $loot->minRoll . ", maxRoll = " . $loot->maxRoll . ",
                niveauMonstre = NULL, multiplier = " . $loot->multiplier . ",
                dicePower = " . $loot->dicePower . "
                WHERE idMonstre = " . $params->idMonstre . "
                AND idLoot = " . $loot->idLoot . ";";
                $sql .= "(" . $params->idMonstre .", " . $loot->idLoot .", " . $loot->minRoll .", " . $loot->maxRoll .", NULL, " . $loot->multiplier .", " . $loot->dicePower . ")";

                $idLoots .= $loot->idLoot;
                if($loot != $loots[count($loots) -1 ]) {
                    $idLoots .= ", ";
                }
            }

            $bdd->exec($sql);
            $result = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					from dropchance as d, loot as l
                    where idMonstre='.$params->idMonstre.'
                    AND d.idLoot in ('.$idLoots.')
                    AND d.idLoot = l.idLoot
                    order by minRoll');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "dropChance added", $fetchedResult);

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

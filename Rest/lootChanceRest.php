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
            $lootsQuery = $bdd->query('SELECT l.libelle, d.minRoll, d.maxRoll, d.niveauMonstre, d.multiplier, d.dicePower, l.poids
					from dropchance as d, loot as l
                    where idMonstre='.$_GET['idMonstre'].'
                    order by minRoll');



            $loot = [];
            while($lootsFetched=$lootsQuery->fetch(PDO::FETCH_ASSOC)){
                array_push($loot, $lootsFetched);
            }
            $matchingData = $loot;
        }
        http_response_code(200);
        /// Envoi de la réponse au Client
        deliver_responseRest(200, "Veillez à vérifier que les chances de drop soient consécutives et disjointes.", $matchingData);
        break;

    case "POST":
        if (!(empty($_POST['idMonstre']) || empty($_POST['idLoot']))) {
            try {
                $sql = "UPDATE dropchance 
                SET minRoll = " . $_POST['minRoll'] . ", maxRoll = " . $_POST['maxRoll'] . ",
                niveauMonstre = " . $_POST['niveauMonstre'] . ", multiplier = " . $_POST['multiplier'] . ",
                dicePower = " . $_POST['dicePower'] . "
                WHERE idMonstre = " . $_POST['idMonstre'] . "
                AND idLoot = " . $_POST['idLoot'];


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
        }
        deliver_responseRest(400, "dropChance modification error, missing idMonstre or idLoot", $sql . "<br>" . $e->getMessage());
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

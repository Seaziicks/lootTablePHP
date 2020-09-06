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
        if (isset($_GET['idObjet'])) {
            $objetQuery = $bdd->query('SELECT *
                                                    FROM objet
                                                    WHERE idObjet = ' . $_GET['idObjet']);

            $objetFetched = $objetQuery->fetch(PDO::FETCH_ASSOC);
            $matchingData = $objetFetched;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Je vous le fais à un prix d'ami !", $matchingData);
        } else {
            $objetsQuery = $bdd->query('SELECT *
                                                    FROM objet');

            $objets = [];
            while ($objetFetched = $objetsQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($objets, $objetFetched);
            }
            $matchingData = $objets;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voilà tout ce que j'ai en stock.", $matchingData);
        }
        break;

    case "POST":
        try {
            $objet = json_decode($_GET['Objet']);
            $sql = "INSERT INTO `objet` (`nom`, fauxNom,`bonus`,`type`,`prix`,`prixNonHumanoide`,`devise`,`idMalediction`,`categorie`,`idMateriaux`,
                                        `taille`,`degats`,`critique`,`facteurPortee`,`armure`,`bonusDexteriteMax`,`malusArmureTests`,`risqueEchecSorts`,
                                        `afficherNom`, `afficherEffetMagique`, `afficherMalediction`, `afficherMateriau`, `afficherInfos`) 
                                        VALUES (:nom, fauxNom, :bonus, :type, :prix, :prixNonHumanoide, :devise, :idMalediction, :categorie, :idMateriaux,
                                                :taille, :degats, :critique, :facteurPortee, :armure, :bonusDexteriteMax, :malusArmureTests, :risqueEchecSorts,
                                                :afficherNom, :afficherEffetMagique, :afficherMalediction, :afficherMateriau, :afficherInfos)";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':nom',$objet->nom, PDO::PARAM_STR);
            $commit->bindParam(':fauxNom',$objet->fauxNom, PDO::PARAM_STR);
            $commit->bindParam(':bonus',$objet->bonus, PDO::PARAM_INT);
            $commit->bindParam(':type',$objet->type, PDO::PARAM_STR);
            $commit->bindParam(':prix',$objet->prix, PDO::PARAM_INT);
            $commit->bindParam(':prixNonHumanoide',$objet->prixNonHumanoide, PDO::PARAM_INT);
            $commit->bindParam(':devise',$objet->devise, PDO::PARAM_INT);
            $commit->bindParam(':idMalediction',$objet->idMalediction, PDO::PARAM_INT);
            $commit->bindParam(':categorie',$objet->categorie, PDO::PARAM_STR);
            $commit->bindParam(':idMateriaux',$objet->idMateriaux, PDO::PARAM_INT);
            $commit->bindParam(':taille',$objet->taille, PDO::PARAM_STR);
            $commit->bindParam(':degats',$objet->degats, PDO::PARAM_INT);
            $commit->bindParam(':critique',$objet->critique, PDO::PARAM_STR);
            $commit->bindParam(':facteurPortee',$objet->facteurPortee, PDO::PARAM_STR);
            $commit->bindParam(':armure',$objet->armure, PDO::PARAM_INT);
            $commit->bindParam(':bonusDexteriteMax',$objet->bonusDexteriteMax, PDO::PARAM_INT);
            $commit->bindParam(':malusArmureTests',$objet->malusArmureTests, PDO::PARAM_INT);
            $commit->bindParam(':risqueEchecSorts',$objet->risqueEchecSorts, PDO::PARAM_STR);
            $commit->bindParam(':afficherNom',$objet->afficherNom, PDO::PARAM_BOOL);
            $commit->bindParam(':afficherEffetMagique',$objet->afficherEffetMagique, PDO::PARAM_BOOL);
            $commit->bindParam(':afficherMalediction',$objet->afficherMalediction, PDO::PARAM_BOOL);
            $commit->bindParam(':afficherMateriau',$objet->afficherMateriau, PDO::PARAM_BOOL);
            $commit->bindParam(':afficherInfos',$objet->afficherInfos, PDO::PARAM_BOOL);
            $commit->execute();
            $result = $bdd->query('SELECT *
					from objet 
                    where idObjet=' . $bdd->lastInsertId() . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;

            http_response_code(201);
            deliver_responseRest(201, "objet added", $fetchedResult);
        } catch (PDOException $e) {
            deliver_responseRest(400, "objet add error in SQL", $sql . "<br>" . $e->getMessage());
        }
        break;
    case "PUT":
        if (!empty($_GET['idObjet']) && !empty($_GET['idMalediction'])) {
            $sql = "UPDATE objet 
                SET idMalediction = :idMalediction
                WHERE idObjet = :idObjet;";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idMalediction',$_GET['idMalediction'], PDO::PARAM_INT);
            $commit->execute();

            $result = $bdd->query('SELECT *
					from objet
                    where idObjet=' . $_GET['idObjet'] . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;
            http_response_code(201);
            deliver_responseRest(201, "objet malediction modified", $fetchedResult);
        } elseif (!empty($_GET['idObjet']) && !empty($_GET['idMateriaux'])) {
            $sql = "UPDATE objet 
                SET idMateriaux = :idMateriaux
                WHERE idObjet = :idObjet;";

            $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $commit->bindParam(':idMateriaux',$_GET['idMateriaux'], PDO::PARAM_INT);
            $commit->execute();

            $result = $bdd->query('SELECT *
					from objet
                    where idObjet=' . $_GET['idObjet'] . '
                    ');
            $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
            $result->closeCursor();
            $bdd = null;
            http_response_code(201);
            deliver_responseRest(201, "objet materiau modified", $fetchedResult);
        }
        elseif (!empty($_GET['idObjet'])) {
            try {
                $objet = json_decode($_GET['Objet']);
                $sql = "UPDATE objet 
                SET nom = :nom, fauxNom = :fauxNom, bonus = :bonus, type = :type, prix = :prix,
                prixNonHumanoide = :prixNonHumanoide, devise = :devise, idMalediction = :idMalediction, categorie = :categorie,
                idMateriaux = :idMateriaux, taille = :taille, degats = :degats, critique = :critique, facteurPortee = :facteurPortee,
                armure = :armure, bonusDexteriteMax = :bonusDexteriteMax, malusArmureTests = :malusArmureTests, risqueEchecSorts = :risqueEchecSorts,
                afficherNom = :afficherNom, afficherEffetMagique = :afficherEffetMagique, afficherMalediction = :afficherMalediction,
                afficherMateriau = :afficherMateriau, afficherInfos = :afficherInfos
                WHERE idObjet = :idObjet;";

                $commit = $bdd->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idObjet',$objet->idObjet, PDO::PARAM_INT);
                $commit->bindParam(':nom',$objet->nom, PDO::PARAM_STR);
                $commit->bindParam(':fauxNom',$objet->fauxNom, PDO::PARAM_STR);
                $commit->bindParam(':bonus',$objet->bonus, PDO::PARAM_INT);
                $commit->bindParam(':type',$objet->type, PDO::PARAM_STR);
                $commit->bindParam(':effetMagique',$objet->effetMagique, PDO::PARAM_INT);
                $commit->bindParam(':prix',$objet->prix, PDO::PARAM_INT);
                $commit->bindParam(':prixNonHumanoide',$objet->prixNonHumanoide, PDO::PARAM_INT);
                $commit->bindParam(':devise',$objet->devise, PDO::PARAM_INT);
                $commit->bindParam(':idMalediction',$objet->idMalediction, PDO::PARAM_INT);
                $commit->bindParam(':categorie',$objet->categorie, PDO::PARAM_STR);
                $commit->bindParam(':idMateriaux',$objet->idMateriaux, PDO::PARAM_INT);
                $commit->bindParam(':taille',$objet->taille, PDO::PARAM_STR);
                $commit->bindParam(':degats',$objet->degats, PDO::PARAM_INT);
                $commit->bindParam(':critique',$objet->critique, PDO::PARAM_STR);
                $commit->bindParam(':facteurPortee',$objet->facteurPortee, PDO::PARAM_STR);
                $commit->bindParam(':armure',$objet->armure, PDO::PARAM_INT);
                $commit->bindParam(':bonusDexteriteMax',$objet->bonusDexteriteMax, PDO::PARAM_INT);
                $commit->bindParam(':malusArmureTests',$objet->malusArmureTests, PDO::PARAM_INT);
                $commit->bindParam(':risqueEchecSorts',$objet->risqueEchecSorts, PDO::PARAM_STR);
                $commit->execute();

                $result = $bdd->query('SELECT *
					from objet
                    where idObjet=' . $objet->idObjet . '
                    ');
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "$objet modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "$objet modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
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




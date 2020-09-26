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

$PersonnageManager = new PersonnageManager($bdd);

switch ($http_method){
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (!empty($_GET['idPersonnage']) && !empty($_GET['withStatistique']) && filter_var($_GET['withStatistique'],FILTER_VALIDATE_BOOLEAN)) {

            $personnage = $PersonnageManager->getPersonnageAvecStatistiques(1);

            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Regardez moi ce monstre, ces muscles, cette intelligence, cette puissance !", $personnage);

        } elseif (!empty($_GET['idPersonnage'])) {

            $personnage = $PersonnageManager->getPersonnage($_GET['idPersonnage']);

            $matchingData = $personnage;
            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Bien le bonjour, voyageur. Je vous envoie un de mes meilleurs soldats !", $matchingData);

        } elseif (!empty($_GET['withStatistique']) && filter_var($_GET['withStatistique'],FILTER_VALIDATE_BOOLEAN)) {

            $personnages = $PersonnageManager->getAllPersonnageAvecStatistiques();

            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Et voilà la fine équipe, avec tous leurs attributs !", $personnages);
        } elseif (!empty($_GET['withStatistique']) && !filter_var($_GET['withStatistique'],FILTER_VALIDATE_BOOLEAN)) {

            $personnages = $PersonnageManager->getAllPersonnage();

            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Et voilà la fine équipe !", $personnages);
        }
        break;

    case "POST":
        if (!(empty($_GET['idPersonnage']))) {
            try {
                $sql = "UPDATE personnage 
                SET nom = :nom, 
                niveau = :niveau
                WHERE idPersonnage = :idPersonnage";

                $commit = $this->_db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $commit->bindParam(':idPersonnage', intval($_GET['idPersonnage']), PDO::PARAM_INT);
                $commit->bindParam(':nom', $_GET['nom'], PDO::PARAM_STR);
                $commit->bindParam(':niveau', intval($_GET['niveau']), PDO::PARAM_INT);
                $commit->execute();

                $result = $bdd->query('SELECT *
					FROM personnage
                    where idPersonnage='.$_GET['idPersonnage']);
                $fetchedResult = $result->fetch(PDO::FETCH_ASSOC);
                $result->closeCursor();
                $bdd = null;
                http_response_code(201);
                deliver_responseRest(201, "personnage modified", $fetchedResult);
            } catch (PDOException $e) {
                deliver_responseRest(400, "personnage modification error in SQL", $sql . "<br>" . $e->getMessage());
            }
        } else {
            deliver_responseRest(400, "personnage modification error, missing idPersonnage", '');
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

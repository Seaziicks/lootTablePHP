<?php
declare(strict_types=1);

use Firebase\JWT\JWT;

spl_autoload_register('chargerClasse');
session_start();
header("Content-Type:application/json");

require_once('secret_jwt_token.php');

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

$UserManager = new UserManager($bdd);

switch ($http_method) {
    /// Cas de la méthode GET
    case "GET" :
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['Connexion'])) {
            $user = json_decode($_GET['Connexion']);

            $user = $UserManager->getUser($_GET['Connexion']);

            if (!$user) {
                http_response_code(403);
                /// Envoi de la réponse au Client
                deliver_responseRest(403, "Désolé, connais pas !", '');
            } elseif ($user) {

                $issuedAt   = new DateTimeImmutable();
                $expire     = $issuedAt->modify('+2 hours')->getTimestamp();      // Add 60 seconds
                // $expire     = $issuedAt->modify('+2 seconds')->getTimestamp();      // Add 60 seconds
                $serverName = "localhost";
                $idUser   = $user->_idUser;                                           // Retrieved from filtered POST data
                $username   = "$user->_username";                                           // Retrieved from filtered POST data
                $isGameMaster   = $user->_isGameMaster;                                           // Retrieved from filtered POST data
                $isAdmin   = $user->_isAdmin;                                           // Retrieved from filtered POST data

                //print_r($user);

                $data = [
                    'iat'  => $issuedAt->getTimestamp(),         // Issued at: time when the token was generated
                    'iss'  => $serverName,                       // Issuer
                    'nbf'  => $issuedAt->getTimestamp(),         // Not before
                    'exp'  => $expire,                           // Expire
                    'idUser' => $idUser,
                    'username' => $username,                     // User name
                    'isGameMaster' => $isGameMaster,
                    'isAdmin' => $isAdmin
                ];

                //print_r($data);

                // echo JWT::encode($data, getJwtSecret(), getJwtAlgorithm());
                $matchingData = JWT::encode(
                    $data,
                    getJwtSecret(),
                    getJwtAlgorithm()
                );

                http_response_code(200);
                /// Envoi de la réponse au Client
                deliver_responseRest(200, "Qui a demandé un token bien chaud, qui ?!", $matchingData);
            }
        } elseif(isset($_GET['leftPersonnage']) && filter_var($_GET['leftPersonnage'], FILTER_VALIDATE_BOOLEAN)) {
            $sql = 'SELECT * 
                    FROM personnage 
                    WHERE idPersonnage NOT IN (
                        SELECT idPersonnage 
                        FROM user WHERE idPersonnage IS NOT NULL)';
            $allLeftPersonnageQuery = $bdd->query($sql);

            $allPersonnage = [];

            while($allLeftPersonnageFetched = $allLeftPersonnageQuery->fetch(PDO::FETCH_ASSOC)) {
                array_push($allPersonnage, $allLeftPersonnageFetched);
            }

            $matchingData = $allPersonnage;

            http_response_code(200);
            /// Envoi de la réponse au Client
            deliver_responseRest(200, "Voilà un catalogue de nos meilleurs specimens encore disponibles.", $matchingData);
        } elseif(isset($_GET['User']) && isset($_GET['checkAvailable']) && filter_var($_GET['checkAvailable'], FILTER_VALIDATE_BOOLEAN)) {
            $userData = json_encode(json_decode($_GET['User'])->User);
            $userExist = $UserManager->userExist($userData);
            if ($userExist) {
                http_response_code(409);
                /// Envoi de la réponse au Client
                deliver_responseRest(409, "Vous êtes déjà inscrit dans notre club privé.", '');
            } else {
                http_response_code(200);
                /// Envoi de la réponse au Client
                deliver_responseRest(200, "Votre nom ne me dis rien ... Voulez-vous nous rejoindre ?", '');
            }
        } elseif(isset($_GET['nomPersonnage']) && isset($_GET['checkAvailable']) && filter_var($_GET['checkAvailable'], FILTER_VALIDATE_BOOLEAN)) {
            $PersonnageManager = new PersonnageManager($bdd);

            $personnageExist = $PersonnageManager->personnageExist($_GET['nomPersonnage']);
            if ($personnageExist) {
                http_response_code(409);
                /// Envoi de la réponse au Client
                deliver_responseRest(409, "Cet avatar est déjà ... Hum ... Utilisé.", '');
            } else {
                http_response_code(200);
                /// Envoi de la réponse au Client
                deliver_responseRest(200, "Oh, ce serait un nouveau costume ?", '');
            }
        }
        break;

    case "POST":
        /// Récupération des critères de recherche envoyés par le Client
        if (isset($_GET['Creation'])) {
            $userData = json_encode(json_decode($_GET['Creation'])->User);
            $userExist = $UserManager->userExist($userData);
            if ($userExist) {
                http_response_code(409);
                /// Envoi de la réponse au Client
                deliver_responseRest(409, "Vous êtes déjà inscrit dans notre club privé.", $matchingData);
            } else {
                $user = json_decode($_GET['Creation']);
                $user = $UserManager->addUserWithPersonnage($_GET['Creation']);

                $matchingData = $user;

                http_response_code(200);
                /// Envoi de la réponse au Client
                deliver_responseRest(200, "Alors comme ça vous voulez faire parti du Fight Club ?", $matchingData);
            }
        }
        break;
    case "PUT":
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



